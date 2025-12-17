<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;

class RememberMeFix
{
    public function handle($request, Closure $next)
    {
        // Jika session kosong (karena browser ditutup)
        if (!Auth::check()) {

            // Cari cookie remember Laravel
            foreach ($request->cookies as $name => $value) {

                if (str_starts_with($name, 'remember_web_')) {
                    // Paksa Laravel login via cookie remember
                    Auth::viaRemember();
                    break;
                }
            }
        }

        return $next($request);
    }
}
