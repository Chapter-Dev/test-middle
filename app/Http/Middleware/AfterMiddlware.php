<?php

namespace App\Http\Middleware;

use Closure;

class AfterMiddlware{

    public function handle($request, Closure $next)
    {
        $response = $next($request);

        $response->header('X-CSRF-TOKEN', $request->session()->token());

        return $response;
    }
}