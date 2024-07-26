<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class apiAuth
{
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);
        $response->headers->set('Access-Control-Allow-Methods','*');
        $response->headers->set('Access-Control-Allow-Headers','*');
        return $response;
    }

}
