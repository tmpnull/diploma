<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Collection;

class ChangeLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $defaultLocale = app()->getLocale();
        $acceptedLanguages = $request->server('HTTP_ACCEPT_LANGUAGE');
        if ($acceptedLanguages) {
            $preferredLanguage = new Collection(explode(',', explode(';', $acceptedLanguages)[0]));
            $preferredLanguage = $preferredLanguage->filter(function ($language) {
                return str_contains($language, 'en') || str_contains($language, 'ru');
            });
            app()->setLocale($preferredLanguage->isNotEmpty() ? $preferredLanguage->first() : $defaultLocale);
        }
        return $next($request);
    }
}
