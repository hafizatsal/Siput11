<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Http\Controllers\Controller;
use App\Exceptions\CustomException;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;

class IndikatorTanahController extends Controller
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
      $data=DB::table('tbl_sifat_kimia_tanah')
      ->orderBy('sifat_kimia','asc')->get();
      return view('admin.sifat_tanah',[
        'data'=>$data,
      ]);
  }

  public function insert(Request $req)
  {
    // fungsi ini digunakan untuk menambahkan data tanah
    // id dibuat otomatis autoincrement
    $sifat_tanah = $req->input('nama_indikator_tanah');
    // menyimpan data tanah ke dalam array
    $data_tanah = array(
      'sifat_kimia' => $sifat_tanah,
    );
    // memasukkkan data ke table data tanah
    try{
      DB::table('tbl_sifat_kimia_tanah')->insert($data_tanah);
      session()->flash('insert', 'Data Sifat Tanah berhasil ditambah.');
    }
    catch(\Illuminate\Database\QueryException $e){
      throw new CustomException($e->getMessage());
    }
    return back(); // kembali ke halaman data tanah
  }

  public function update(Request $req)
  {
    $id_tanah = $req->input('id_tanah2');
    $sifat_tanah = $req->input('nama_indikator_tanah2');

    // menyimpan data tanah
    $data_tanah = array(
      'sifat_kimia' => $sifat_tanah,
    );
    // mengubah data tanah
    try{
      DB::table('tbl_sifat_kimia_tanah')->where('id_parameter_kimia', $id_tanah)->update($data_tanah);
      session()->flash('insert', 'Data Sifat Tanah berhasil diubah.');
    }
    catch(\Illuminate\Database\QueryException $e){
      throw new CustomException($e->getMessage());
    }
    return back(); // kembali ke halaman data tanah
  }

  // fungsi untuk menghapus data tanah
  public function delete(Request $req)
  {
    // menghapus data berdasarkan id_indikator
    try{
      DB::table('tbl_sifat_kimia_tanah')->where('id_parameter_kimia',$req->input('hapus_id_tanah'))->delete();
      session()->flash('insert', 'Data Sifat Tanah berhasil dihapus.');
    }
    catch(\Illuminate\Database\QueryException $e){
      throw new CustomException($e->getMessage());
    }
    return back(); // fungsi untuk mengarahkan ke halaman data tanah
    // setelah menghapus data
  }

  // fungsi untuk mengembalikan nilai array data tanah
  public function tanah2(Request $req)
  {
    $id_tanah = $req->id;
    $tanah= DB::table('tbl_sifat_kimia_tanah')
    ->where('id_parameter_kimia', '=', $id_tanah)
    ->get();
    return response()->json($tanah);
  }

}
