<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminSession
{
    public function handle(Request $request, Closure $next)
    {
        auth()->setDefaultDriver('admin');
        return $next($request);
    }
}
