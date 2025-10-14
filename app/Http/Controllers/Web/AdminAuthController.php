<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AdminAuthController extends Controller
{
    /**
     * Show admin login form.
     */
    public function showLogin()
    {
        return view('auth.admin-login');
    }

    /**
     * Handle admin login.
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $credentials = $request->only('email', 'password');
        $remember = $request->boolean('remember');

        // Check if user exists and is admin
        $user = \App\Models\User::where('email', $credentials['email'])->first();

        if (!$user || !$user->isAdmin()) {
            throw ValidationException::withMessages([
                'email' => ['Ces identifiants ne correspondent pas à un administrateur.'],
            ]);
        }

        if (!$user->is_active) {
            throw ValidationException::withMessages([
                'email' => ['Ce compte administrateur est désactivé.'],
            ]);
        }

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();

            return redirect()->intended(route('admin.dashboard'));
        }

        throw ValidationException::withMessages([
            'email' => ['Les identifiants fournis sont incorrects.'],
        ]);
    }

    /**
     * Handle admin logout.
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }
}
