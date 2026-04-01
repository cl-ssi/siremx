<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        if (! $request->expectsJson()) {
            return route('basepath');
        }

        // Para peticiones AJAX/API, no redirigir, dejar que el middleware
        // lance AuthenticationException que se convierte en 401 JSON
        return null;        
    }

    protected function unauthenticated($request, array $guards)
    {
        if ($request->expectsJson()) {
            abort(response()->json(['code' => 401, 'message' => 'Unauthenticated'], 401));
        }
        
        parent::unauthenticated($request, $guards);
    }    
}
