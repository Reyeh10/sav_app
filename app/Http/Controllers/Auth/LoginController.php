<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    /*
    |--------------------------------------------------------------------------
    | LOGIN FORM SMART HR
    |--------------------------------------------------------------------------
    */

    public function showLoginForm()
    {
        return view('auth.smarthr.login');
    }

    /*
    |--------------------------------------------------------------------------
    | REDIRECTION APRES LOGIN PAR ROLE
    |--------------------------------------------------------------------------
    */

    protected function redirectTo()
    {
        $role = trim(auth()->user()->role);

        return match ($role) {
            'admin'      => '/vehicles',
            'mecanicien' => '/vehicles',
            'logistique' => '/vehicles',
            'vendeur'    => '/sales/create',
            default      => '/login',
        };
    }

    /*
    |--------------------------------------------------------------------------
    | LOGOUT PROPRE LARAVEL (IMPORTANT)
    |--------------------------------------------------------------------------
    */

    public function logout(Request $request)
    {
        Auth::logout();

        // Invalide session
        $request->session()->invalidate();

        // Regénère token CSRF
        $request->session()->regenerateToken();

        // Redirect login
        return redirect()->route('login');
    }

    /*
    |--------------------------------------------------------------------------
    | CONSTRUCTEUR
    |--------------------------------------------------------------------------
    */

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }
}
