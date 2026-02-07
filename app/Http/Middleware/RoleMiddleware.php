<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Middleware pour autoriser l'accès selon le rôle utilisateur.
     *
     * Exemple :
     * Route::middleware(['role:ADMIN'])->group(...)
     * Route::middleware(['role:ADMIN,LOGISTIQUE'])->group(...)
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        /**
         * ✅ 1. Si utilisateur non connecté → redirection login
         */
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        /**
         * ✅ 2. Récupérer le rôle utilisateur
         */
        $user = auth()->user();
        $userRole = $user->role;

        /**
         * ✅ 3. Si aucun rôle défini → accès refusé
         */
        if (!$userRole) {
            abort(403, "Accès refusé : aucun rôle attribué.");
        }

        /**
         * ✅ 4. Autoriser si rôle utilisateur fait partie des rôles acceptés
         */
        if (!in_array($userRole, $roles)) {

            // Option 1 : abort classique
            abort(403, "Accès refusé. Rôle requis : " . implode(', ', $roles));

            // Option 2 (alternative) : rediriger plutôt que abort
            // return redirect('/dashboard')->with('error', 'Accès interdit.');
        }

        /**
         * ✅ 5. Accès autorisé → continuer la requête
         */
        return $next($request);
    }
}
