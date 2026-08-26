<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Enregistrer les services de l’application.
     */
    public function register(): void
    {
        //
    }

    /**
     * Initialiser les services de l’application.
     */
    public function boot(): void
    {
        /*
        |--------------------------------------------------------------------------
        | Pagination Bootstrap 5
        |--------------------------------------------------------------------------
        |
        | Le thème de l’application utilise Bootstrap. Sans cette instruction,
        | Laravel génère une pagination Tailwind dont les flèches SVG peuvent
        | apparaître en très grande taille.
        |
        */

        Paginator::useBootstrapFive();
    }
}
