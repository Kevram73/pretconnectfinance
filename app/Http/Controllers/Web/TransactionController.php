<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class TransactionController extends Controller
{
    /**
     * Show deposit form.
     */
    public function createDeposit()
    {
        return view('transactions.deposit');
    }

    /**
     * Store deposit request.
     */
    public function storeDeposit(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'amount' => 'required|numeric|min:10',
            'payment_method' => 'required|string|in:CRYPTO,BANK_TRANSFER',
            'description' => 'nullable|string|max:500',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $user = Auth::user();

        $transaction = Transaction::create([
            'user_id' => $user->id,
            'type' => 'DEPOSIT',
            'amount' => $request->amount,
            'status' => 'PENDING',
            'description' => $request->description ?? 'Demande de dépôt',
            'payment_method' => $request->payment_method,
            'reference' => 'DEP_' . time() . '_' . $user->id,
        ]);

        return redirect()->route('transactions.show', $transaction)
            ->with('success', 'Demande de dépôt créée avec succès !');
    }

    /**
     * Show withdrawal form.
     */
    public function createWithdrawal()
    {
        $user = Auth::user();
        $user->load('wallet');

        return view('transactions.withdrawal', compact('user'));
    }

    /**
     * Store withdrawal request.
     */
    public function storeWithdrawal(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'amount' => 'required|numeric|min:50',
            'payment_method' => 'required|string|in:CRYPTO,BANK_TRANSFER',
            'description' => 'nullable|string|max:500',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $user = Auth::user();
        $wallet = $user->wallet;

        if (!$wallet || $wallet->balance < $request->amount) {
            return redirect()->back()
                ->withErrors(['amount' => 'Solde insuffisant.'])
                ->withInput();
        }

        $transaction = Transaction::create([
            'user_id' => $user->id,
            'type' => 'WITHDRAWAL',
            'amount' => $request->amount,
            'status' => 'PENDING',
            'description' => $request->description ?? 'Demande de retrait',
            'payment_method' => $request->payment_method,
            'reference' => 'WTH_' . time() . '_' . $user->id,
        ]);

        // Hold the amount in the wallet
        $wallet->subtractBalance($request->amount);

        return redirect()->route('transactions.show', $transaction)
            ->with('success', 'Demande de retrait créée avec succès !');
    }

    /**
     * Show transaction details.
     */
    public function show(Transaction $transaction)
    {
        $user = Auth::user();

        if ($transaction->user_id !== $user->id) {
            abort(403, 'Accès non autorisé.');
        }

        return view('transactions.show', compact('transaction'));
    }

    /**
     * Show all transactions.
     */
    public function index(Request $request)
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

        return view('transactions.index', compact('transactions', 'type', 'status'));
    }
}
