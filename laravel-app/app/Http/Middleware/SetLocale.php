<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class SetLocale
{
    public function handle(Request $request, Closure $next)
    {
        $locale = (string) $request->session()->get('locale', 'en');
        if (in_array($locale, ['en', 'fr', 'es', 'de'], true)) {
            App::setLocale($locale);
        }

        return $next($request);
    }
}
