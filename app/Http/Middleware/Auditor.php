<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class Auditor
{
    public function handle(Request $request, Closure $next): Response
    {
        // Maintenance
        $maintenance = DB::table('setting')->first();
        if ($maintenance && $maintenance->status == 0) {
            return response()->view('error.msg', [
                'title'  => 'Maintenance',
                'header' => 'Maintenance',
                'msg'    => 'Sistem sedang dalam maintenance.'
            ], 503);
        }

        // Tidak login
        if (!Auth::check()) {
            return redirect('/login');
        }

        // Jika bukan AUDITOR (3)
        if (Auth::user()->id_role != 3) {
            return redirect('/home');
        }

        return $next($request);
    }
}
