<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        // 🔥 gunakan guard web secara explisit (WAJIB)
        $credentials = [
            'username' => $request->username,
            'password' => $request->password
        ];

        if (Auth::guard('web')->attempt($credentials, true)) {

            // 🔥 pastikan session benar terbuat
            Auth::guard('web')->login(Auth::guard('web')->user());

            // catat login
            DB::table('login')->insert([
                'id_user' => Auth::guard('web')->id(),
                'time_login' => DB::raw('NOW()')
            ]);

            // redirect sesuai role
            return match (Auth::guard('web')->user()->id_role) {
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
        $user = Auth::guard('web')->user();

        if ($user) {
            $id_login = DB::table('login')
                ->select('id_login')
                ->where('id_user', $user->id)
                ->orderBy('id_login', 'desc')
                ->first();

            if ($id_login) {
                DB::table('login')->where('id_login', $id_login->id_login)
                    ->update(['time_logout' => DB::raw('NOW()')]);
            }
        }

        Auth::guard('web')->logout();
        return redirect('/login');
    }
}

