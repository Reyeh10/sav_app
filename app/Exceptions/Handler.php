<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Illuminate\Session\TokenMismatchException;
use Symfony\Component\HttpKernel\Exception\HttpException;

class Handler extends ExceptionHandler
{
    /**
     * Inputs never flashed
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register exception handling callbacks
     */
    public function register(): void
    {

        /*
        |--------------------------------------------------------------------------
        | Handle CSRF / Session Expired (419)
        |--------------------------------------------------------------------------
        */

        $this->renderable(function (TokenMismatchException $e, $request) {

            // ✅ API / AJAX calls
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Session expired. Please login again.',
                    'session_expired' => true
                ], 419);
            }

            // ✅ WEB Requests
            return redirect()
                ->route('login')
                ->with('session_expired', true)
                ->with('error', 'Session expirée. Veuillez vous reconnecter.');
        });


        /*
        |--------------------------------------------------------------------------
        | Handle Generic 419 HTTP Exception
        |--------------------------------------------------------------------------
        */

        $this->renderable(function (HttpException $e, $request) {

            if ($e->getStatusCode() === 419) {

                if ($request->expectsJson()) {
                    return response()->json([
                        'message' => 'Session expired. Please login again.',
                        'session_expired' => true
                    ], 419);
                }

                return redirect()
                    ->route('login')
                    ->with('session_expired', true);
            }

        });


        /*
        |--------------------------------------------------------------------------
        | Default Reportable
        |--------------------------------------------------------------------------
        */

        $this->reportable(function (Throwable $e) {
            // Tu peux log ici si besoin
        });

    }
}
