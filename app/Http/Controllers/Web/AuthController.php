<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    /**
     * Show login form.
     */
    public function showLogin()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }
        
        return view('auth.login');
    }

    /**
     * Handle login.
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput($request->except('password'));
        }

        if (Auth::attempt($request->only('email', 'password'), $request->boolean('remember'))) {
            $request->session()->regenerate();
            
            return redirect()->intended(route('dashboard'));
        }

        return redirect()->back()
            ->withErrors(['email' => 'Les identifiants fournis ne correspondent pas à nos enregistrements.'])
            ->withInput($request->except('password'));
    }

    /**
     * Show registration form.
     */
    public function showRegister()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }
        
        return view('auth.register');
    }

    /**
     * Handle registration.
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'referral_code' => 'nullable|string|exists:users,referral_code',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput($request->except('password', 'password_confirmation'));
        }

        $referrer = null;
        if ($request->referral_code) {
            $referrer = User::where('referral_code', $request->referral_code)->first();
        }

        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'referral_code' => User::generateReferralCode(),
            'referred_by' => $referrer?->id,
        ]);

        // Create wallet for the user
        $user->wallet()->create([
            'balance' => 0.00,
            'total_deposited' => 0.00,
            'total_withdrawn' => 0.00,
            'total_invested' => 0.00,
            'total_profits' => 0.00,
            'total_commissions' => 0.00,
        ]);

        Auth::login($user);

        return redirect()->route('dashboard')
            ->with('success', 'Compte créé avec succès !');
    }

    /**
     * Handle logout.
     */
    public function logout(Request $request)
    {
        Auth::logout();
        
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect()->route('login')
            ->with('success', 'Vous avez été déconnecté avec succès.');
    }
}
