<?php

namespace App\Http\Middleware;

use Closure;

class Cors
{
    public function handle($request, Closure $next)
    {
        if ($request->getMethod() === 'OPTIONS') {
            return response('', 204)
                ->header('Access-Control-Allow-Origin', 'https://siremx.saludtarapaca.gob.cl')
                ->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS')
                ->header('Access-Control-Allow-Headers', 'Content-Type, X-CSRF-TOKEN, X-Requested-With, Accept, Authorization')
                ->header('Access-Control-Allow-Credentials', 'true');
        }

        $response = $next($request);
        
        return $response
            ->header('Access-Control-Allow-Origin', 'https://siremx.saludtarapaca.gob.cl')
            ->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS')
            ->header('Access-Control-Allow-Headers', 'Content-Type, X-CSRF-TOKEN, X-Requested-With, Accept, Authorization')
            ->header('Access-Control-Allow-Credentials', 'true');
    }
}