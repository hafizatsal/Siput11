<?php

namespace App\Http\Controllers\admin;

use App\User;
use App\Exceptions\CustomException;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth'); // wajib login untuk akses
    }

    /** 📄 Tampilkan daftar user */
    public function index()
    {
        $data = DB::table('users')->get();
        $instansi = DB::table('instansi')->get();
        $peran = DB::table('roles')->get();

        return view('admin.user', compact('data','instansi','peran'));
    }

    /** ➕ Tambah user baru */
    public function insert(Request $req)
    {
        $req->validate([
            'nama_user' => 'required|string|max:255',
            'email'     => 'required|email|unique:users',
            'username'  => 'required|string|max:255|unique:users',
            'instansi'  => 'required',
            'peran'     => 'required|integer',
        ]);

        try{
            User::create([
                'nama'      => $req->nama_user,
                'username'  => $req->username,
                'email'     => $req->email,
                'instansi'  => $req->instansi,
                'password'  => Hash::make('123456'), // password default
                'id_role'   => $req->peran,
                'blocked_date' => '1990-01-01',
            ]);

            return back()->with('insert','User berhasil ditambah.');
        }
        catch(QueryException $e){
            throw new CustomException($e->getMessage());
        }
    }

    /** 🗑 Hapus user */
    public function hapus(Request $req)
    {
        try{
            DB::table('users')->where('id',$req->hapus_id)->delete();
            return back()->with('insert','User berhasil dihapus.');
        }
        catch(QueryException $e){
            throw new CustomException($e->getMessage());
        }
    }

    /** 🚫 Ban User */
    public function ban(Request $req)
    {
        $req->validate([
            'id_pengguna'    => 'required|integer',
            'tanggal_banned' => 'required|date',
        ]);

        try{
            DB::table('users')->where('id',$req->id_pengguna)->update([
                'blocked_date' => $req->tanggal_banned
            ]);

            return back()->with('insert','User diblokir sampai '.date('d M Y', strtotime($req->tanggal_banned)));
        }
        catch(QueryException $e){
            throw new CustomException($e->getMessage());
        }
    }
}
