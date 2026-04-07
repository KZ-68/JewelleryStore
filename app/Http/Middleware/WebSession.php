<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class WebSession
{
    public function handle(Request $request, Closure $next)
    {
        auth()->setDefaultDriver('web');
        return $next($request);
    }
}