<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class User
{
    private function isAjax(Request $request): bool
{
    return $request->ajax()
        || $request->wantsJson()
        || $request->expectsJson()
        || $request->header('X-Requested-With') === 'XMLHttpRequest';
}

public function handle(Request $request, Closure $next): Response
{
    $maintenance = DB::table('setting')->first();
    if ($maintenance && $maintenance->status == 0) {

        if ($this->isAjax($request)) {
            return response()->json(['message' => 'Maintenance'], 503);
        }

        return response()->view('error.msg', [
            'title'  => 'Maintenance',
            'header' => 'Maintenance',
            'msg'    => 'Sistem sedang dalam maintenance.'
        ], 503);
    }

    if (!Auth::check()) {

        if ($this->isAjax($request)) {
            return response()->json(['message' => 'Unauthenticated'], 401);
        }

        return redirect()->route('login');
    }

    if (Auth::user()->id_role != 2) {

        if ($this->isAjax($request)) {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        abort(403, 'Akses ditolak');
    }

    return $next($request);
}
}
