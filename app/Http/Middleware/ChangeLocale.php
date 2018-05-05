<?php

namespace App\Http\Middleware;

use Closure;

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
        $acceptedLanguages = $request->server('HTTP_ACCEPT_LANGUAGE');
        $preferredLanguage = explode(',', $acceptedLanguages)[0];
        app()->setlocale($preferredLanguage);
        return $next($request);
    }
}
