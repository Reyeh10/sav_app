<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller
{

/*
================================
LIST USERS (ADMIN ONLY)
================================
*/
public function index()
{
    if (!auth()->check() || auth()->user()->role !== 'admin') {
        abort(403);
    }

    $users = User::latest()->get();

    return view('users.index', compact('users'));
}


/*
================================
CREATE FORM (ADMIN ONLY)
================================
*/
public function create()
{
    if (!auth()->check() || auth()->user()->role !== 'admin') {
        abort(403);
    }

    return view('users.create');
}


/*
================================
STORE USER (TEMP PASSWORD)
================================
*/
public function store(Request $request)
{
    if (!auth()->check() || auth()->user()->role !== 'admin') {
        abort(403);
    }

    $request->validate([
        'name' => ['required','string','max:255'],
        'email' => ['required','email','unique:users,email'],
        //'password' => bcrypt($request->password),
        'temp_password' => [
            'required',
            Password::min(8)
                ->letters()
                ->numbers()
        ],
        'role' => ['required','string']
    ]);

    DB::table('users')->insert([
        'name' => $request->name,
        'email' => $request->email,
        'role' => $request->role,
        'password' => Hash::make($request->temp_password),
        'must_change_password' => 1,
        'created_at' => now(),
        'updated_at' => now()


    ]);

    return redirect()->route('users.index')
        ->with('success','Utilisateur créé avec mot de passe temporaire');
}


/*
================================
EDIT USER (ADMIN ONLY)
================================
*/
public function edit($id)
{
    if (!auth()->check() || auth()->user()->role !== 'admin') {
        abort(403);
    }

    $user = User::findOrFail($id);

    return view('users.edit', compact('user'));
}


/*
================================
UPDATE ROLE
================================
*/
public function update(Request $request, $id)
{
    if (!auth()->check() || auth()->user()->role !== 'admin') {
        abort(403);
    }

    DB::table('users')
        ->where('id', $id)
        ->update([
            'role' => $request->role,
            'updated_at' => now()
        ]);

    return redirect()->route('users.index')
        ->with('success','Utilisateur mis à jour');
}


/*
================================
FORCE PASSWORD FORM
================================
*/
public function forcePasswordForm()
{
    $user = auth()->user();

    if (!$user || (int)$user->must_change_password !== 1) {
        return redirect('/dashboard');
    }

    return view('users.force-password', compact('user'));
}


/*
================================
SAVE NEW PASSWORD (FINAL STEP)
================================
*/
public function saveNewPassword(Request $request)
{
    $user = auth()->user();

    if (!$user || (int)$user->must_change_password !== 1) {
        return redirect('/dashboard');
    }

    $request->validate([
        'password' => [
            'required',
            'confirmed',
            Password::min(8)
                ->letters()
                ->numbers()
        ]
    ]);

    DB::table('users')
        ->where('id', $user->id)
        ->update([
            'password' => Hash::make($request->password),
            'must_change_password' => 0,
            'updated_at' => now()
        ]);

    return redirect('/dashboard')
        ->with('success','Mot de passe mis à jour');
}


    public function destroy(User $user)
    {
        // empêcher de supprimer soi-même
        if (auth()->id() === $user->id) {
            return redirect()->route('users.index')
                ->with('error', 'Vous ne pouvez pas supprimer votre propre compte.');
        }

        $user->delete();

        return redirect()->route('users.index')
            ->with('success', 'Utilisateur supprimé avec succès.');
    }

}
