<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ForcePasswordChange
{
    public function handle($request, Closure $next)
{
    if (auth()->check()) {

        $user = auth()->user();

        if(auth()->check() && auth()->user()->must_change_password){
            if(!$request->is('force-password')){
                return redirect('/force-password');
            }
        }

    }

    return $next($request);
}

}
