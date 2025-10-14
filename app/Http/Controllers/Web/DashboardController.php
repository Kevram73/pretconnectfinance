<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Commission;
use App\Models\Investment;
use App\Models\MultiLevelCommission;
use App\Models\TeamReward;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $wallet = $user->wallet;
        
        // Statistiques du portefeuille
        $stats = [
            'balance' => $wallet->balance,
            'total_deposited' => $wallet->total_deposited,
            'total_withdrawn' => $wallet->total_withdrawn,
            'total_invested' => $wallet->total_invested,
            'total_profits' => $wallet->total_profits,
            'total_commissions' => $wallet->total_commissions,
        ];

        // Investissements actifs
        $activeInvestments = Investment::where('user_id', $user->id)
            ->where('status', 'ACTIVE')
            ->with('plan')
            ->get();

        // Transactions récentes
        $recentTransactions = Transaction::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        // Commissions récentes
        $recentCommissions = Commission::where('referrer_id', $user->id)
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        return view('dashboard.index', compact('stats', 'activeInvestments', 'recentTransactions', 'recentCommissions'));
    }

    public function transactions()
    {
        $user = Auth::user();
        $transactions = Transaction::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('dashboard.transactions', compact('transactions'));
    }

    public function investments()
    {
        $user = Auth::user();
        $investments = Investment::where('user_id', $user->id)
            ->with('plan')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('dashboard.investments', compact('investments'));
    }

    public function commissions()
    {
        $user = Auth::user();
        $commissions = Commission::where('referrer_id', $user->id)
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        $multiLevelCommissions = MultiLevelCommission::where('referrer_id', $user->id)
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('dashboard.commissions', compact('commissions', 'multiLevelCommissions'));
    }

    public function teamRewards()
    {
        $user = Auth::user();
        $teamRewards = TeamReward::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('dashboard.team-rewards', compact('teamRewards'));
    }

    public function referrals()
    {
        $user = Auth::user();
        
        // Statistiques de parrainage
        $referralStats = [
            'total_referrals' => $user->referrals()->count(),
            'active_referrals' => $user->referrals()->where('is_active', true)->count(),
            'total_commission_earned' => Commission::where('referrer_id', $user->id)->sum('amount'),
        ];

        // Liste des filleuls
        $referrals = $user->referrals()
            ->with('wallet')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        // Commissions par niveau
        $commissionByLevel = MultiLevelCommission::where('referrer_id', $user->id)
            ->selectRaw('level, SUM(amount) as total_amount, COUNT(*) as count')
            ->groupBy('level')
            ->get();

        return view('dashboard.referrals', compact('referralStats', 'referrals', 'commissionByLevel'));
    }

    public function profile()
    {
        $user = Auth::user();
        return view('dashboard.profile', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,' . $user->id,
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $user->update([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'username' => $request->username,
            'email' => $request->email,
        ]);

        return redirect()->back()->with('success', 'Profil mis à jour avec succès !');
    }

    public function changePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'current_password' => 'required',
            'password' => 'required|string|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator);
        }

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return redirect()->back()
                ->with('error', 'Le mot de passe actuel est incorrect.');
        }

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return redirect()->back()->with('success', 'Mot de passe modifié avec succès !');
    }
}