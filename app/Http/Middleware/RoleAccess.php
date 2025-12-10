<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RoleAccess
{
    public function handle($request, Closure $next, string $role)
    {
        $user = Auth::user();

        if (!$user) return redirect('/login');

        // Role Rules
        if ($role == 'admin' && $user->id_role != 1) return redirect('/user/home');
        if ($role == 'user' && $user->id_role != 2) return redirect('/admin/home');
        if ($role == 'auditor' && $user->id_role != 3) return redirect('/user/home');

        return $next($request);
    }
}
