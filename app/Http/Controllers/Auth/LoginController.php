<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /*
    ============================
    LOGIN FORM
    ============================
    */
    public function showLoginForm()
    {
        return view('auth.smarthr.login');
    }

    /*
    ============================
    LOGIN LOGIC
    ============================
    */
    public function login(Request $request)
    {
        // ✅ Validation champs
        $request->validate([
            'email' => ['required','email'],
            'password' => ['required']
        ]);

        // ✅ Tentative login
        if (Auth::attempt($request->only('email','password'))) {

            // ✅ Sécurité session
            $request->session()->regenerate();

            $user = Auth::user();

            // ✅ Force changement password UNIQUEMENT si flag = 1
            if ((int)$user->must_change_password === 1) {
                return redirect()->route('force.password.form');
            }

            // ✅ Redirection normale
            return redirect()->intended($this->redirectTo());
        }

        // ❌ LOGIN FAILED
        return back()
            ->withErrors([
                'login_error' => 'Veuillez entrer un mot de passe correct'
            ])
            ->withInput($request->only('email'));
    }

    /*
    ============================
    REDIRECT BY ROLE
    ============================
    */
    protected function redirectTo()
    {
        if (!auth()->check()) return '/login';

        return match(auth()->user()->role) {
            'admin' => '/dashboard/admindashboard',
            'vendeur' => '/dashboard/vendor',
            'logistique' => '/vehicles',
            'mecanicien' => '/vehicles',
            default => '/dashboard'
        };
    }

    /*
    ============================
    LOGOUT
    ============================
    */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
}
