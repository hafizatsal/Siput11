<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Http\Controllers\Controller;
use App\Exceptions\CustomException;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;

class hmjfController extends Controller
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
      $data=DB::table('tbl_hak_milik')->get();
      $data_jenis=DB::table('jenis_hutan')->get();
      $data_fungsi=DB::table('fungsi_hutan')->get();
      return view('admin.hmjf',[
        'data'=>$data,
        'data_jenis'=>$data_jenis,
        'data_fungsi'=>$data_fungsi,
      ]);
  }

  public function insert(Request $req)
  {
    // fungsi ini digunakan untuk menambahkan data hak milik
    // id dibuat otomatis autoincrement
    $nama_hak_milik = $req->input('nama_hak_milik');
    // menyimpan data hak milik ke dalam array
    $hak_milik = array(
      'hak_milik' => $nama_hak_milik,
    );
    // memasukkkan data ke table hak milik
    try{
      DB::table('tbl_hak_milik')->insert($hak_milik);
      session()->flash('insert', 'Data Hak Milik berhasil ditambah.');
    }
    catch(\Illuminate\Database\QueryException $e){
      throw new CustomException($e->getMessage());
    }
    return back(); // kembali ke halaman data hak milik
  }

  public function update(Request $req)
  {
    $id_hak = $req->input('id_hak_milik2');
    $nama_hak = $req->input('nama_hak_milik2');

    // menyimpan data hak_milik
    $data_milik = array(
      'id_hak_milik' => $id_hak,
      'hak_milik' => $nama_hak,
    );
    // mengubah data hak milik
    try{
      DB::table('tbl_hak_milik')->where('id_hak_milik', $id_hak)->update($data_milik);
      session()->flash('insert', 'Data Hak Milik berhasil diubah.');
    }
    catch(\Illuminate\Database\QueryException $e){
      throw new CustomException($e->getMessage());
    }
    return back(); // kembali ke halaman data hak milik
  }

  // fungsi untuk menghapus data hak milik
  public function delete(Request $req)
  {
    // menghapus data berdasarkan id_hak_milik
    try{
      DB::table('tbl_hak_milik')->where('id_hak_milik',$req->input('hapus_id_hak'))->delete();
      session()->flash('insert', 'Data Hak Milik berhasil dihapus.');
    }
    catch(\Illuminate\Database\QueryException $e){
      throw new CustomException($e->getMessage());
    }
    return back(); // kembali ke halaman data hak milik
    // setelah menghapus data
  }

  // fungsi untuk mengembalikan nilai array hak milik
  public function hak2(Request $req)
  {
    $id_hak = $req->id;
    $hak= DB::table('tbl_hak_milik')
    ->where('id_hak_milik', '=', $id_hak)
    ->get();
    return response()->json($hak);
  }
}
