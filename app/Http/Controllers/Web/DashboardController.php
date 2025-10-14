<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use App\Models\Transaction;
use App\Models\Investment;
use App\Services\InvestmentService;
use App\Services\CommissionService;
use App\Services\TeamRewardService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    protected $investmentService;
    protected $commissionService;
    protected $teamRewardService;

    public function __construct(
        InvestmentService $investmentService,
        CommissionService $commissionService,
        TeamRewardService $teamRewardService
    ) {
        $this->investmentService = $investmentService;
        $this->commissionService = $commissionService;
        $this->teamRewardService = $teamRewardService;
    }

    /**
     * Show user dashboard.
     */
    public function index()
    {
        $user = Auth::user();
        $user->load('wallet');

        // Get user statistics
        $investmentStats = $this->investmentService->getUserInvestmentStats($user);
        $commissionStats = $this->commissionService->getUserCommissionStats($user);
        $teamRewardStats = $this->teamRewardService->getUserTeamRewardStats($user);

        // Get recent transactions
        $recentTransactions = $user->transactions()
            ->latest()
            ->limit(10)
            ->get();

        // Get active investments
        $activeInvestments = $user->investments()
            ->active()
            ->with('plan')
            ->get();

        // Get available plans
        $availablePlans = Plan::active()->get();

        return view('dashboard.index', compact(
            'user',
            'investmentStats',
            'commissionStats',
            'teamRewardStats',
            'recentTransactions',
            'activeInvestments',
            'availablePlans'
        ));
    }

    /**
     * Show transactions page.
     */
    public function transactions(Request $request)
    {
        $user = Auth::user();
        $perPage = 15;
        $type = $request->get('type');
        $status = $request->get('status');

        $query = $user->transactions()->latest();

        if ($type) {
            $query->where('type', $type);
        }

        if ($status) {
            $query->where('status', $status);
        }

        $transactions = $query->paginate($perPage);

        return view('dashboard.transactions', compact('transactions', 'type', 'status'));
    }

    /**
     * Show investments page.
     */
    public function investments(Request $request)
    {
        $user = Auth::user();
        $perPage = 15;
        $status = $request->get('status');

        $query = $user->investments()->with('plan')->latest();

        if ($status) {
            $query->where('status', $status);
        }

        $investments = $query->paginate($perPage);

        return view('dashboard.investments', compact('investments', 'status'));
    }

    /**
     * Show commissions page.
     */
    public function commissions()
    {
        $user = Auth::user();
        
        $referralCommissions = $user->commissions()
            ->with('user')
            ->latest()
            ->get();

        $multiLevelCommissions = $user->multiLevelCommissions()
            ->with('user')
            ->latest()
            ->get();

        $commissionStats = $this->commissionService->getUserCommissionStats($user);

        return view('dashboard.commissions', compact(
            'referralCommissions',
            'multiLevelCommissions',
            'commissionStats'
        ));
    }

    /**
     * Show team rewards page.
     */
    public function teamRewards()
    {
        $user = Auth::user();
        
        $teamRewards = $user->teamRewards()
            ->orderBy('level')
            ->get();

        $teamRewardStats = $this->teamRewardService->getUserTeamRewardStats($user);

        return view('dashboard.team-rewards', compact('teamRewards', 'teamRewardStats'));
    }

    /**
     * Show referrals page.
     */
    public function referrals()
    {
        $user = Auth::user();
        
        $referrals = $user->referrals()
            ->with('wallet')
            ->latest()
            ->get();

        return view('dashboard.referrals', compact('referrals'));
    }

    /**
     * Show profile page.
     */
    public function profile()
    {
        $user = Auth::user();
        $user->load('wallet');

        return view('dashboard.profile', compact('user'));
    }

    /**
     * Update profile.
     */
    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $validator = Validator::make($request->all(), [
            'first_name' => 'sometimes|required|string|max:255',
            'last_name' => 'sometimes|required|string|max:255',
            'username' => 'sometimes|required|string|max:255|unique:users,username,' . $user->id,
            'email' => 'sometimes|required|string|email|max:255|unique:users,email,' . $user->id,
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $user->update($request->only(['first_name', 'last_name', 'username', 'email']));

        return redirect()->back()
            ->with('success', 'Profil mis à jour avec succès.');
    }

    /**
     * Change password.
     */
    public function changePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'current_password' => 'required|string',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator);
        }

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return redirect()->back()
                ->withErrors(['current_password' => 'Le mot de passe actuel est incorrect.']);
        }

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return redirect()->back()
            ->with('success', 'Mot de passe modifié avec succès.');
    }
}
