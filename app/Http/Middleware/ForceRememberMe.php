<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class ForceRememberMe
{
    public function handle($request, Closure $next)
    {
        // Jika user belum login, tapi cookie remember ada → login via remember
        if (!Auth::check()) {
            foreach ($request->cookies as $name => $value) {
                if (str_starts_with($name, 'remember_web_')) {
                    Auth::viaRemember();
                    break;
                }
            }
        }

        return $next($request);
    }
}
