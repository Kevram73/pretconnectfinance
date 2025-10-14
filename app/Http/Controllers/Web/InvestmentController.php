<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Investment;
use App\Models\Plan;
use App\Models\Transaction;
use App\Models\Wallet;
use App\Services\CommissionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class InvestmentController extends Controller
{
    protected $commissionService;

    public function __construct(CommissionService $commissionService)
    {
        $this->commissionService = $commissionService;
    }

    public function create()
    {
        $plans = Plan::where('is_active', true)->get();
        $user = Auth::user();
        $wallet = $user->wallet;
        
        return view('investments.create', compact('plans', 'wallet'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'plan_id' => 'required|exists:plans,id',
            'amount' => 'required|numeric|min:100|max:100000',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $user = Auth::user();
        $wallet = $user->wallet;
        $plan = Plan::findOrFail($request->plan_id);

        // Vérifier que le montant est dans la plage du plan
        if ($request->amount < $plan->min_amount || $request->amount > $plan->max_amount) {
            return redirect()->back()
                ->with('error', 'Le montant doit être entre $' . $plan->min_amount . ' et $' . $plan->max_amount . ' pour ce plan.')
                ->withInput();
        }

        // Vérifier que l'utilisateur a suffisamment de fonds
        if ($wallet->balance < $request->amount) {
            return redirect()->back()
                ->with('error', 'Solde insuffisant pour effectuer cet investissement.')
                ->withInput();
        }

        DB::beginTransaction();
        try {
            // Calculer les dates
            $startDate = now();
            $endDate = $startDate->copy()->addDays($plan->duration_days);

            // Créer l'investissement
            $investment = Investment::create([
                'user_id' => $user->id,
                'plan_id' => $plan->id,
                'amount' => $request->amount,
                'daily_profit' => $plan->calculateDailyProfit($request->amount),
                'total_profit' => 0.00,
                'daily_percentage' => $plan->daily_percentage,
                'duration_days' => $plan->duration_days,
                'days_elapsed' => 0,
                'start_date' => $startDate,
                'end_date' => $endDate,
                'status' => 'ACTIVE',
            ]);

            // Débiter le portefeuille
            $wallet->subtractBalance($request->amount);
            $wallet->addInvestment($request->amount);

            // Créer la transaction d'investissement
            Transaction::create([
                'user_id' => $user->id,
                'type' => 'INVESTMENT',
                'amount' => $request->amount,
                'status' => 'COMPLETED',
                'description' => 'Investissement dans ' . $plan->name,
                'reference' => 'INV-' . $investment->id,
            ]);

            // Traiter les commissions de parrainage
            $this->commissionService->processReferralCommission($user, $request->amount);

            DB::commit();

            return redirect()->route('investments')
                ->with('success', 'Votre investissement a été créé avec succès !');

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()
                ->with('error', 'Une erreur est survenue lors de la création de l\'investissement.')
                ->withInput();
        }
    }

    public function show(Investment $investment)
    {
        // Vérifier que l'utilisateur peut voir cet investissement
        if ($investment->user_id !== Auth::id() && !Auth::user()->isAdmin()) {
            abort(403);
        }

        return view('investments.show', compact('investment'));
    }
}