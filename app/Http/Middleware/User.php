<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class User
{
    public function handle(Request $request, Closure $next): Response
{
    $maintenance = DB::table('setting')->first();
    if ($maintenance && $maintenance->status == 0) {
        return response()->view('error.msg', [
            'title'  => 'Maintenance',
            'header' => 'Maintenance',
            'msg'    => 'Sistem sedang dalam maintenance.'
        ], 503);
    }

    if (!Auth::check()) {
        return redirect()->route('login');
    }

    if (Auth::user()->id_role != 2) {
        abort(403, 'Akses ditolak');
    }

    return $next($request);
}
}
