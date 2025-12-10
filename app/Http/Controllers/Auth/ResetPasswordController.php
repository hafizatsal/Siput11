<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;

class ResetPasswordController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest');
    }

    /** 🟢 FORM REQUEST RESET PASSWORD (INPUT EMAIL) */
    public function showForm()
    {
        return view('auth.passwords.email');
    }

    /** 🟢 KIRIM LINK RESET PASSWORD (POST) */
    public function process(Request $request)
    {
        $request->validate(['email'=>'required|email']);

        $status = Password::sendResetLink($request->only('email'));

        return $status === Password::RESET_LINK_SENT
            ? back()->with('success','Link reset password berhasil dikirim ke email kamu!')
            : back()->withErrors(['email'=>'Email tidak ditemukan atau gagal mengirim reset link.']);
    }

    /** 🟢 FORM SET PASSWORD BARU SAAT KLIK EMAIL */
    public function resetPage($token)
    {
        return view('auth.passwords.reset', compact('token'));
    }

    /** 🟢 SUBMIT PASSWORD BARU + AUTO REDIRECT LOGIN */
    public function resetSubmit(Request $request)
    {
        $request->validate([
            'email'=>'required|email',
            'password'=>'required|min:6|confirmed',
            'token'=>'required'
        ]);

        $status = Password::reset(
            $request->only('email','password','password_confirmation','token'),
            function($user,$password){
                $user->password = Hash::make($password);
                $user->save();
            }
        );

        return $status === Password::PASSWORD_RESET
            ? redirect('/login')->with('success','Password berhasil diganti! Silahkan login.')
            : back()->withErrors(['email'=>'Token sudah kadaluarsa atau tidak valid.']);
    }
}
