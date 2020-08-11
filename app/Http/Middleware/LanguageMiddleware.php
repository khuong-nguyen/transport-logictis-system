<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Arr;

class LanguageMiddleware
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
        if ($request->method() === 'GET') {
            $segment = $request->segment(1);

            if (!in_array($segment, config('app.locales'))) {
                $segments = $request->segments();
                $fallback = session('locale') ?: config('app.fallback_locale');
                $segments = Arr::prepend($segments, $fallback);
                return redirect()->to(implode('/', $segments));
            }

            session(['locale' => $segment]);
            app()->setLocale($segment);
            $request->route()->forgetParameter('locale');
        }
        return $next($request);
    }
}
