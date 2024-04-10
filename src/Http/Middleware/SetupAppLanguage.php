<?php

namespace Kenepa\TranslationManager\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class SetupAppLanguage
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $acceptableLocales = array_column(config('translation-manager.available_locales'), 'code');
        $userLocales = $request->getLanguages();
        $locale = Str::before($request->getPreferredLanguage($userLocales),'_');

        if (!in_array($locale, $acceptableLocales)) {
            $locale = $acceptableLocales[0];
        }

        app()->setLocale( $locale);

        return $next($request);
    }
}
