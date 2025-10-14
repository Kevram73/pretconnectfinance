<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Investment;
use App\Models\Plan;
use App\Models\Commission;
use App\Models\TeamReward;
use App\Models\Wallet;
use App\Services\InvestmentService;
use App\Services\CommissionService;
use App\Services\TeamRewardService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
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
     * Show admin dashboard.
     */
    public function dashboard()
    {
        $stats = [
            'total_users' => User::count(),
            'active_users' => User::where('is_active', true)->count(),
            'total_deposits' => Transaction::deposits()->completed()->sum('amount'),
            'total_withdrawals' => Transaction::withdrawals()->completed()->sum('amount'),
            'total_investments' => Investment::sum('amount'),
            'active_investments' => Investment::active()->sum('amount'),
            'pending_deposits' => Transaction::deposits()->pending()->sum('amount'),
            'pending_withdrawals' => Transaction::withdrawals()->pending()->sum('amount'),
            'total_commissions' => Commission::completed()->sum('amount'),
            'pending_commissions' => Commission::pending()->sum('amount'),
        ];

        $investmentStats = $this->investmentService->getAdminInvestmentStats();
        $commissionStats = $this->commissionService->getAdminCommissionStats();
        $teamRewardStats = $this->teamRewardService->getAdminTeamRewardStats();

        return view('admin.dashboard', compact('stats', 'investmentStats', 'commissionStats', 'teamRewardStats'));
    }

    /**
     * Show all users.
     */
    public function users(Request $request)
    {
        $perPage = 15;
        $search = $request->get('search');
        $role = $request->get('role');

        $query = User::with('wallet');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('username', 'like', "%{$search}%");
            });
        }

        if ($role) {
            $query->where('role', $role);
        }

        $users = $query->paginate($perPage);

        return view('admin.users', compact('users', 'search', 'role'));
    }

    /**
     * Show user details.
     */
    public function user(User $user)
    {
        $user->load(['wallet', 'referrer', 'referrals', 'transactions', 'investments']);

        return view('admin.user', compact('user'));
    }

    /**
     * Update user.
     */
    public function updateUser(Request $request, User $user)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'sometimes|required|string|max:255',
            'last_name' => 'sometimes|required|string|max:255',
            'username' => 'sometimes|required|string|max:255|unique:users,username,' . $user->id,
            'email' => 'sometimes|required|string|email|max:255|unique:users,email,' . $user->id,
            'role' => 'sometimes|required|in:USER,ADMIN',
            'is_active' => 'sometimes|required|boolean',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $user->update($request->only(['first_name', 'last_name', 'username', 'email', 'role', 'is_active']));

        return redirect()->back()
            ->with('success', 'Utilisateur mis à jour avec succès.');
    }

    /**
     * Show all transactions.
     */
    public function transactions(Request $request)
    {
        $perPage = 15;
        $type = $request->get('type');
        $status = $request->get('status');
        $search = $request->get('search');

        $query = Transaction::with('user');

        if ($type) {
            $query->where('type', $type);
        }

        if ($status) {
            $query->where('status', $status);
        }

        if ($search) {
            $query->whereHas('user', function ($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $transactions = $query->latest()->paginate($perPage);

        return view('admin.transactions', compact('transactions', 'type', 'status', 'search'));
    }

    /**
     * Update transaction status.
     */
    public function updateTransaction(Request $request, Transaction $transaction)
    {
        $validator = Validator::make($request->all(), [
            'status' => 'required|in:PENDING,COMPLETED,CANCELLED',
            'description' => 'nullable|string|max:500',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator);
        }

        DB::beginTransaction();

        try {
            $oldStatus = $transaction->status;
            $transaction->update([
                'status' => $request->status,
                'description' => $request->description ?? $transaction->description,
            ]);

            // Handle wallet updates based on transaction type and status
            if ($request->status === 'COMPLETED' && $oldStatus !== 'COMPLETED') {
                $this->handleTransactionCompletion($transaction);
            } elseif ($request->status === 'CANCELLED' && $oldStatus === 'PENDING') {
                $this->handleTransactionCancellation($transaction);
            }

            DB::commit();

            return redirect()->back()
                ->with('success', 'Transaction mise à jour avec succès.');

        } catch (\Exception $e) {
            DB::rollBack();
            
            return redirect()->back()
                ->withErrors(['error' => 'Erreur lors de la mise à jour de la transaction.']);
        }
    }

    /**
     * Handle transaction completion.
     */
    private function handleTransactionCompletion(Transaction $transaction): void
    {
        $user = $transaction->user;
        $wallet = $user->wallet;

        if (!$wallet) {
            $wallet = $user->wallet()->create([
                'balance' => 0.00,
                'total_deposited' => 0.00,
                'total_withdrawn' => 0.00,
                'total_invested' => 0.00,
                'total_profits' => 0.00,
                'total_commissions' => 0.00,
            ]);
        }

        switch ($transaction->type) {
            case 'DEPOSIT':
                $wallet->addBalance($transaction->amount);
                $wallet->addDeposit($transaction->amount);
                break;
            case 'WITHDRAWAL':
                $wallet->addWithdrawal($transaction->amount);
                break;
        }
    }

    /**
     * Handle transaction cancellation.
     */
    private function handleTransactionCancellation(Transaction $transaction): void
    {
        $user = $transaction->user;
        $wallet = $user->wallet;

        if ($wallet && $transaction->type === 'WITHDRAWAL') {
            // Return the amount to the wallet
            $wallet->addBalance($transaction->amount);
        }
    }

    /**
     * Show all investments.
     */
    public function investments(Request $request)
    {
        $perPage = 15;
        $status = $request->get('status');
        $search = $request->get('search');

        $query = Investment::with(['user', 'plan']);

        if ($status) {
            $query->where('status', $status);
        }

        if ($search) {
            $query->whereHas('user', function ($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $investments = $query->latest()->paginate($perPage);

        return view('admin.investments', compact('investments', 'status', 'search'));
    }

    /**
     * Show all plans.
     */
    public function plans()
    {
        $plans = Plan::all();

        return view('admin.plans', compact('plans'));
    }

    /**
     * Show plan details (AJAX).
     */
    public function showPlan(Plan $plan)
    {
        return response()->json(['plan' => $plan]);
    }

    /**
     * Delete plan.
     */
    public function deletePlan(Plan $plan)
    {
        $plan->delete();

        return redirect()->back()
            ->with('success', 'Plan supprimé avec succès.');
    }

    /**
     * Show transaction details (AJAX).
     */
    public function showTransaction(Transaction $transaction)
    {
        $transaction->load('user');
        return response()->json(['transaction' => $transaction, 'user' => $transaction->user]);
    }

    /**
     * Show investment details (AJAX).
     */
    public function showInvestment(Investment $investment)
    {
        $investment->load(['user', 'plan']);
        return response()->json(['investment' => $investment, 'user' => $investment->user, 'plan' => $investment->plan]);
    }

    /**
     * Show commission details (AJAX).
     */
    public function showCommission(Commission $commission)
    {
        $commission->load(['user', 'referrer']);
        return response()->json(['commission' => $commission, 'user' => $commission->user, 'referrer' => $commission->referrer]);
    }

    /**
     * Show user details (AJAX).
     */
    public function showUser(User $user)
    {
        return response()->json(['user' => $user]);
    }

    /**
     * Create or update plan.
     */
    public function storePlan(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'min_amount' => 'required|numeric|min:0',
            'max_amount' => 'required|numeric|min:0',
            'daily_percentage' => 'required|numeric|min:0|max:100',
            'duration_days' => 'required|integer|min:1',
            'total_percentage' => 'required|numeric|min:0|max:1000',
            'is_active' => 'boolean',
            'is_rapid' => 'boolean',
            'rapid_days' => 'nullable|integer|min:1',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $plan = Plan::create($request->all());

        return redirect()->back()
            ->with('success', 'Plan créé avec succès.');
    }

    /**
     * Update plan.
     */
    public function updatePlan(Request $request, Plan $plan)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'min_amount' => 'sometimes|required|numeric|min:0',
            'max_amount' => 'sometimes|required|numeric|min:0',
            'daily_percentage' => 'sometimes|required|numeric|min:0|max:100',
            'duration_days' => 'sometimes|required|integer|min:1',
            'total_percentage' => 'sometimes|required|numeric|min:0|max:1000',
            'is_active' => 'sometimes|boolean',
            'is_rapid' => 'sometimes|boolean',
            'rapid_days' => 'nullable|integer|min:1',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $plan->update($request->all());

        return redirect()->back()
            ->with('success', 'Plan mis à jour avec succès.');
    }

    /**
     * Show all commissions.
     */
    public function commissions(Request $request)
    {
        $perPage = 15;
        $status = $request->get('status');
        $type = $request->get('type');

        $query = Commission::with(['user', 'referrer']);

        if ($status) {
            $query->where('status', $status);
        }

        if ($type) {
            $query->where('type', $type);
        }

        $commissions = $query->latest()->paginate($perPage);

        return view('admin.commissions', compact('commissions', 'status', 'type'));
    }

    /**
     * Update commission status.
     */
    public function updateCommission(Request $request, Commission $commission)
    {
        $validator = Validator::make($request->all(), [
            'status' => 'required|in:PENDING,COMPLETED,CANCELLED',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator);
        }

        DB::beginTransaction();

        try {
            $commission->update(['status' => $request->status]);

            if ($request->status === 'COMPLETED') {
                $referrer = $commission->referrer;
                $wallet = $referrer->wallet;

                if ($wallet) {
                    $wallet->addBalance($commission->amount);
                    $wallet->addCommission($commission->amount);
                }
            }

            DB::commit();

            return redirect()->back()
                ->with('success', 'Commission mise à jour avec succès.');

        } catch (\Exception $e) {
            DB::rollBack();
            
            return redirect()->back()
                ->withErrors(['error' => 'Erreur lors de la mise à jour de la commission.']);
        }
    }
}
