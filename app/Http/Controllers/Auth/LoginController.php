<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class LoginController extends Controller
{
    public function showLoginForm()
{
    if (Auth::check()) {
        return redirect('/home');
    }

    return view('auth.login');
}

    // wajib agar Laravel login dengan username
    public function username()
    {
        return 'username';
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        $credentials = [
            'username' => $request->username,
            'password' => $request->password
        ];

        // remember_token ON
        if (Auth::attempt($credentials, true)) {

            // WAJIB regenerate session
            $request->session()->regenerate();

            // UPDATE last_login di tabel users
            DB::table('users')->where('id', Auth::id())->update([
                'last_login' => now()
            ]);

            // CATAT ke tabel login
            DB::table('login')->insert([
                'id_user' => Auth::id(),
                'time_login' => now()
            ]);

            // redirect berdasarkan role
            return match (Auth::user()->id_role) {
                1 => redirect('/admin/home'),
                2 => redirect('/user/home'),
                3 => redirect('/auditor/home'),
                default => redirect('/login')->withErrors(['role' => 'Role tidak dikenali'])
            };
        }

        return back()->withErrors(['login' => 'Username atau Password salah']);
    }

    public function logout()
    {
        $user = Auth::user();

        if ($user) {
            // UPDATE logout_time di tabel users
            DB::table('users')->where('id', $user->id)->update([
                'logout_time' => now()
            ]);

            // update tabel login
            $id_login = DB::table('login')
                ->select('id_login')
                ->where('id_user', $user->id)
                ->orderBy('id_login', 'desc')
                ->first();

            if ($id_login) {
                DB::table('login')->where('id_login', $id_login->id_login)
                    ->update(['time_logout' => now()]);
            }
        }

        Auth::guard('web')->logout();

        request()->session()->invalidate();
        request()->session()->regenerateToken();
        return redirect('/login');
    }
}
