<?php

namespace App\Http\Controllers\Auth;

use App\Models\User; // pastikan model benar (Laravel 11 default pakai App\Models\User)
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;

class RegisterController extends Controller
{
    // 🔹 Tampilkan halaman register
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    // 🔹 Proses register user
    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        $user = $this->create($request->all());

        event(new Registered($user));

        $this->sendEmail($user);

        // Simpan log
        DB::table('log')->insert([
            "controller" => "RegisterController",
            "function"   => "register",
            "activity"   => "User {$user->username} berhasil dibuat",
            "line"       => 78
        ]);

        return redirect('/login')->with('message','Registrasi Berhasil. Silahkan Login.');
    }

    // 🔹 Validasi input
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'nama'     => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users',
            'instansi' => 'required|string|min:3',
            'email'    => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);
    }

    // 🔹 Insert ke database users
    protected function create(array $data)
    {
        return User::create([
            'nama'        => $data['nama'],
            'username'    => $data['username'],
            'email'       => $data['email'],
            'instansi'    => $data['instansi'],
            'password'    => Hash::make($data['password']),
            'blocked_date'=> '1990-01-01'
        ]);
    }

    // 🔹 Kirim email verifikasi / notifikasi
    protected function sendEmail($user)
    {
        try {
            Mail::send('user.email', ['nama' => $user->nama], function($message) use ($user){
                $message->subject('Registrasi Berhasil');
                $message->from('siputunila@gmail.com', 'SIPUT System');
                $message->to($user->email);
            });
        } catch (\Exception $e) {
            return; // tidak block proses jika email gagal
        }
    }
}
