<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;

class RememberMeMiddleware
{
    public function handle($request, Closure $next)
    {
        // Jika user belum login tetapi punya cookie remember_me
        if (!Auth::check()) {
            $rememberCookieName = 'remember_web_' . sha1(config('app.key'));

            if ($request->hasCookie($rememberCookieName)) {
                // Memaksa Laravel membaca cookie remember_me dan login ulang user
                Auth::viaRemember();
            }
        }

        return $next($request);
    }
}
