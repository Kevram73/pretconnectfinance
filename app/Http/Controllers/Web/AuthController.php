<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            
            if (!$user->is_active) {
                Auth::logout();
                return redirect()->back()
                    ->with('error', 'Votre compte a été désactivé. Contactez l\'administrateur.');
            }

            $request->session()->regenerate();
            
            if ($user->isAdmin()) {
                return redirect()->route('admin.dashboard');
            }
            
            return redirect()->intended(route('dashboard'));
        }

        return redirect()->back()
            ->with('error', 'Les identifiants fournis ne correspondent pas à nos enregistrements.')
            ->withInput();
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'referral_code' => 'nullable|string|exists:users,referral_code',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Vérifier le code de parrainage
        $referrer = null;
        if ($request->referral_code) {
            $referrer = User::where('referral_code', $request->referral_code)->first();
            if (!$referrer) {
                return redirect()->back()
                    ->with('error', 'Code de parrainage invalide.')
                    ->withInput();
            }
        }

        // Créer l'utilisateur
        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'referral_code' => User::generateReferralCode(),
            'referred_by' => $referrer ? $referrer->id : null,
            'role' => 'USER',
            'is_active' => true,
        ]);

        // Créer le portefeuille
        Wallet::create([
            'user_id' => $user->id,
            'balance' => 0.00,
            'total_deposited' => 0.00,
            'total_withdrawn' => 0.00,
            'total_invested' => 0.00,
            'total_profits' => 0.00,
            'total_commissions' => 0.00,
        ]);

        // Connecter l'utilisateur
        Auth::login($user);

        return redirect()->route('dashboard')
            ->with('success', 'Compte créé avec succès ! Bienvenue sur PrêtConnect.');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect()->route('login');
    }
}