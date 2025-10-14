<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use App\Models\Investment;
use App\Services\InvestmentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class InvestmentController extends Controller
{
    protected $investmentService;

    public function __construct(InvestmentService $investmentService)
    {
        $this->investmentService = $investmentService;
    }

    /**
     * Show investment form.
     */
    public function create()
    {
        $plans = Plan::active()->get();
        
        return view('investments.create', compact('plans'));
    }

    /**
     * Store investment.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'plan_id' => 'required|exists:plans,id',
            'amount' => 'required|numeric|min:100',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $user = Auth::user();
        $plan = Plan::findOrFail($request->plan_id);

        // Check if plan is active
        if (!$plan->is_active) {
            return redirect()->back()
                ->withErrors(['plan_id' => 'Ce plan n\'est pas actif.'])
                ->withInput();
        }

        // Check amount limits
        if ($request->amount < $plan->min_amount || $request->amount > $plan->max_amount) {
            return redirect()->back()
                ->withErrors(['amount' => "Le montant doit être entre {$plan->min_amount} et {$plan->max_amount} USD."])
                ->withInput();
        }

        // Check wallet balance
        $wallet = $user->wallet;
        if (!$wallet || $wallet->balance < $request->amount) {
            return redirect()->back()
                ->withErrors(['amount' => 'Solde insuffisant.'])
                ->withInput();
        }

        try {
            $investment = $this->investmentService->createInvestment($user, $plan, $request->amount);

            return redirect()->route('investments.show', $investment)
                ->with('success', 'Investissement créé avec succès !');

        } catch (\Exception $e) {
            return redirect()->back()
                ->withErrors(['error' => 'Erreur lors de la création de l\'investissement.'])
                ->withInput();
        }
    }

    /**
     * Show investment details.
     */
    public function show(Investment $investment)
    {
        $user = Auth::user();

        if ($investment->user_id !== $user->id) {
            abort(403, 'Accès non autorisé.');
        }

        $investment->load('plan');

        return view('investments.show', compact('investment'));
    }

    /**
     * Show all investments.
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $perPage = 15;
        $status = $request->get('status');

        $query = $user->investments()->with('plan')->latest();

        if ($status) {
            $query->where('status', $status);
        }

        $investments = $query->paginate($perPage);

        return view('investments.index', compact('investments', 'status'));
    }
}
