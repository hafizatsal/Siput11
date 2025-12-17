<?php

namespace App\Http\Middleware;

use Closure;

class StatefulSession
{
    public function handle($request, Closure $next)
    {
        // Memastikan request dianggap stateful (bukan "guest" setiap buka browser)
        config(['session.expire_on_close' => false]);
        config(['session.same_site' => 'lax']);

        return $next($request);
    }
}
