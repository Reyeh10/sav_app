<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    use RegistersUsers;

    public function showRegistrationForm()
    {
        return view('auth.smarthr.register');
    }

    /**
     * ✅ Après inscription → rediriger vers login
     */
    protected function registered($request, $user)
    {
        auth()->logout();
        return redirect()->route('login')
            ->with('success', "Compte créé ✅ Connectez-vous maintenant.");
    }

    /**
     * ✅ Validation
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users'],
            'password' => ['required', 'min:6', 'confirmed'],
        ]);
    }

    /**
     * ✅ Création User en DB
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),

            // ✅ rôle par défaut
            'role' => 'vendeur',
        ]);
    }
}
