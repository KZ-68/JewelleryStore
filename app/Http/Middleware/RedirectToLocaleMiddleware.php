<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

class RedirectToLocaleMiddleware
{
    public function handle(Request $request, Closure $next) : \Illuminate\Http\Response|\Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
    {
        $segments = $request->segments(); // Les portions de textes entre les slash
        $availableLocales = config('app.available_locales');
        $defaultLocale = Config::get('app.fallback_locale');

        // Protège les routes sensibles contre les redirections
        if ($request->is('up') || $request->is('api/*') || $request->is('storage/*')) {
            return $next($request);
        }

        // Fallback vers la langue par défaut
        if (empty($segments)) {
            return redirect('/' . $defaultLocale);
        }

        // Construction de l'url pour que le second slash devant la langue soit ajouté
        if (!in_array($segments[0], $availableLocales)) {
            return redirect('/' . $defaultLocale . '/' . \ltrim(implode('/', $segments), '/'));
        }

        return $next($request);
    }
}