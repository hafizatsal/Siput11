<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Validator;
use App\Exceptions\CustomException;
use Illuminate\Database\QueryException;

class PengumumanController extends Controller
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
     $isi_pengumuman="";
     $isi_link="";
     $pengumuman = DB::table('pengumuman')->get();
     $hitung_pengumuman= count($pengumuman);
     if($hitung_pengumuman!=0){
       $isi_pengumuman=$pengumuman[0]->isi_pengumuman;
       $isi_link=$pengumuman[1]->isi_pengumuman;
     }
    return view('admin.pengumuman',compact('isi_pengumuman','isi_link'));
   }

   public function insert(Request $req)
   {
     // fungsi ini digunakan untuk menambahkan pengumuman
     $isi_pengumuman = $req->input('isi_pengumuman');
     $updated_by = $req->input('input_by');
     // menyimpan pengumuman ke dalam array
     $pengumuman = array(
       'isi_pengumuman' => $isi_pengumuman,
       'updated_by' => $updated_by,
     );
     // memasukkkan data ke table pengumuman
     try{
       DB::table('pengumuman')->where('id_pengumuman','=',1)->update($pengumuman);
       session()->flash('insert', 'Pengumuman berhasil diubah.');
     }
     catch(\Illuminate\Database\QueryException $e){
       throw new CustomException($e->getMessage());
     }
     return back(); // kembali ke halaman pengumuman
   }

   public function insert2(Request $req)
   {
     // fungsi ini digunakan untuk menambahkan pengumuman
     $isi_pengumuman = $req->input('download_link');
     $updated_by = $req->input('input_by2');
     // menyimpan pengumuman ke dalam array
     $pengumuman = array(
       'isi_pengumuman' => $isi_pengumuman,
       'updated_by' => $updated_by,
     );
     // memasukkkan data ke table pengumuman
     try{
       DB::table('pengumuman')->where('id_pengumuman','=',2)->update($pengumuman);
       session()->flash('insert', 'Pengumuman tambahan berhasil diubah.');
     }
     catch(\Illuminate\Database\QueryException $e){
       throw new CustomException($e->getMessage());
     }
     return back(); // kembali ke halaman pengumuman
   }


 }
