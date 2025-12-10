<?php

namespace App\Http\Controllers\auditor;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Validator;
use App\Exceptions\CustomException;
use Illuminate\Database\QueryException;
class ProfileController extends Controller
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
      $role = DB::table('roles')
      ->join('users','users.id_role','=','roles.id')
      ->leftjoin('foto_user','foto_user.id_user','=','users.id')
      ->where('users.id','=',Auth::user()->id)
      ->first();

      $lihat_foto = DB::table('foto_user')->where('id_user',Auth::User()->id)->get();
      $cek_foto_user = count($lihat_foto);
        return view('auditor.profile',compact('role','cek_foto_user'));
    }

    public function edit(Request $req)
    {
      $req->validate([
          'id_pengguna'=>'required|integer',
          'nama'=>'required|regex:/^[a-zA-Z ]{3,50}$/',
          'file'=>'required|file|mimes:jpg,jpeg,png|max:10240',
        ]);

      $id = $req->input('id_pengguna');
      $nama= $req->input('nama');

      $cek_foto = DB::table('foto_user')->where('id_user','=',Auth::User()->id)->get();
      if(count($cek_foto)==0){
        if($req->hasFile('file')){
          $req->validate([
            'file' => 'file|max:2048',
        ]);
          $filesize = $req->file->getClientSize();
          $fileextension = $req->file->getClientOriginalExtension();
          $filename = time() . '.' . $fileextension;
          if($fileextension== 'jpg' || $fileextension== 'jpeg' || $fileextension== 'png'){
            $req->file->move('upload/profile',$filename);
            $data_foto = array(
              'id_user' => Auth::User()->id,
              'filename' => $filename,
              'size' => $filesize,
            );
            DB::table('foto_user')->insert($data_foto);
          }
          else{
            session()->flash('delete', 'Format file yang mendukung jpg,jpeg, dan png.');
            return back();
          }

        }
      }
      else{
        if($req->hasFile('file')){
          $req->validate([
            'file' => 'file|max:2048',
        ]);
          $filesize = $req->file->getClientSize();
          $fileextension = $req->file->getClientOriginalExtension();
          $filename = time() . '.' . $fileextension;

          if($fileextension== 'jpg' || $fileextension== 'jpeg' || $fileextension== 'png'){
            $file_path = public_path().'/upload/profile/'.$cek_foto[0]->filename;
            unlink($file_path);
            $req->file->move('upload/profile',$filename);
            $data_foto = array(
              'filename' => $filename,
              'size' => $filesize,
            );
            DB::table('foto_user')->where('id_user',Auth::User()->id)->update($data_foto);
          }
          else{
            session()->flash('delete', 'Format file yang mendukung jpg,jpeg, dan png.');
            return back();
          }


        }
      }

        $pengguna = array(
          'nama' => $nama,
        );

        try{
          DB::table('users')->where('id', $id)->update($pengguna);
          session()->flash('edit', 'Data pengguna berhasil diubah.');
        }
        catch(\Illuminate\Database\QueryException $e){
          throw new CustomException($e->getMessage());
        }
        $req->all();
        return back();
    }

}
