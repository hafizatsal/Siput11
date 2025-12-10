<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Exceptions\CustomException;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Validator;

class PasswordController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
      return view('auth.ubahpassword');
    }
    public function changePassword(Request $request)
    { if (!(Hash::check($request->get('current-password'), Auth::user()->password))) {
       // The passwords matches
       return redirect()->back()->with("error","Password lama Anda salah. Mohon coba kembali.");
     }

      if(strcmp($request->get('current-password'), $request->get('new-password')) == 0){
        //Current password and new password are same
        return redirect()->back()->with("error","Password baru tidak boleh sama dengan password lama. Mohon pilih password lain.");
      }

      $validatedData = $request->validate([
        'current-password' => 'required',
        'password' => 'required|string|min:6|confirmed',
      ]);
       //Change Password
      $user = Auth::user();
      $user->password = bcrypt($request->get('password'));
      $user->save();
      return redirect()->back()->with("success","Password berhasil diubah!");
    }
}
