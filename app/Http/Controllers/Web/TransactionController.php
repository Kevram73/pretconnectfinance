<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class TransactionController extends Controller
{
    public function createDeposit()
    {
        $user = Auth::user();
        $wallet = $user->wallet;
        
        return view('transactions.deposit', compact('wallet'));
    }

    public function storeDeposit(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'amount' => 'required|numeric|min:100|max:100000',
            'payment_method' => 'required|string|in:USDT_BEP20,USDC_BEP20,USDT_TRC20',
            'deposit_type' => 'required|string|in:AUTOMATIC,MANUAL',
            'transaction_hash' => 'required|string|max:255',
            'screenshot' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $user = Auth::user();
        $wallet = $user->wallet;

        // Gérer l'upload de la capture d'écran
        $screenshotPath = null;
        if ($request->hasFile('screenshot')) {
            $screenshotPath = $request->file('screenshot')->store('screenshots', 'public');
        }

        // Créer la transaction de dépôt
        $transaction = Transaction::create([
            'user_id' => $user->id,
            'type' => 'DEPOSIT',
            'deposit_type' => $request->deposit_type,
            'amount' => $request->amount,
            'status' => 'PENDING',
            'description' => 'Dépôt ' . strtolower($request->deposit_type) . ' via ' . $request->payment_method,
            'payment_method' => $request->payment_method,
            'transaction_hash' => $request->transaction_hash,
            'screenshot_path' => $screenshotPath,
        ]);

        return redirect()->route('transactions')
            ->with('success', 'Votre demande de dépôt a été soumise avec succès. Elle sera validée par l\'administrateur.');
    }

    public function createWithdrawal()
    {
        $user = Auth::user();
        $wallet = $user->wallet;
        
        return view('transactions.withdrawal', compact('wallet'));
    }

    public function storeWithdrawal(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'amount' => 'required|numeric|min:3|max:100000',
            'wallet_address' => 'required|string|max:255',
            'payment_method' => 'required|string|in:USDT_BEP20',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $user = Auth::user();
        $wallet = $user->wallet;

        // Vérifier que l'utilisateur a suffisamment de fonds
        if ($wallet->balance < $request->amount) {
            return redirect()->back()
                ->with('error', 'Solde insuffisant pour effectuer ce retrait.')
                ->withInput();
        }

        // Créer la transaction de retrait
        $transaction = Transaction::create([
            'user_id' => $user->id,
            'type' => 'WITHDRAWAL',
            'amount' => $request->amount,
            'status' => 'PENDING',
            'description' => 'Retrait vers ' . $request->payment_method,
            'payment_method' => $request->payment_method,
            'payment_hash' => $request->wallet_address,
        ]);

        return redirect()->route('transactions')
            ->with('success', 'Votre demande de retrait a été soumise avec succès. Elle sera traitée par l\'administrateur.');
    }

    public function show(Transaction $transaction)
    {
        // Vérifier que l'utilisateur peut voir cette transaction
        if ($transaction->user_id !== Auth::id() && !Auth::user()->isAdmin()) {
            abort(403);
        }

        return view('transactions.show', compact('transaction'));
    }
}