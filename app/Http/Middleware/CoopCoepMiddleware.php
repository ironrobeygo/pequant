<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CoopCoepMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);
        $response->header('Cross-Origin-Embedder-Policy', 'require-corp');
        $response->header('Cross-Origin-Opener-Policy', 'same-origin');

        return $response;
    }
}
