<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Exceptions\CustomException;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;

class DesaController extends Controller
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
  public function index($id)
  {
      $id=decrypt($id);

      $data=DB::table('kecamatan')
      ->join(
        'desa',
        'desa.id_kecamatan' , '=', 'kecamatan.id')
        ->where('kecamatan.id', '=', $id)
        ->get();
        $data3=DB::table('kecamatan')
          ->where('kecamatan.id', '=', $id)
          ->first();

          $data2=DB::table('kabupaten')
            ->where('kabupaten.id', '=', $data3->id_kabupaten)
            ->first();
      return view('admin.desa',[
        'data'=>$data,
        'data2'=>$data2,
        'data3'=>$data3,
        'id_kecamatan' => $id,
      ]);
  }

  public function insert(Request $req)
  {
    // fungsi ini digunakan untuk menambahkan data desa
    // id dibuat otomatis autoincrement
    $nama_desa = $req->input('nama_desa');
    $id_kecamatan = $req->input('id_kecamatan');
    // menyimpan data desa ke dalam array
    $data_desa = array(
      'id_kecamatan' => $id_kecamatan,
      'nama_desa' => $nama_desa,
    );
    // memasukkkan data ke table data desa
    try{
    DB::table('desa')->insert($data_desa);
    session()->flash('insert', 'Data Desa berhasil diubah.');
    }
    catch(\Illuminate\Database\QueryException $e){
      throw new CustomException($e->getMessage());
    }
    return back(); // kembali ke halaman data desa
  }

  public function update(Request $req)
  {
    $id_desa = $req->input('edit_id_desa');
    $nama_desa = $req->input('nama_desa2');

    // menyimpan data desa
    $data_desa = array(
      'nama_desa' => $nama_desa,
    );
    // mengubah data desa
    try{
      DB::table('desa')->where('id', $id_desa)->update($data_desa);
      session()->flash('insert', 'Data Desa berhasil diubah.');
    }
    catch(\Illuminate\Database\QueryException $e){
      throw new CustomException($e->getMessage());
    }
    return back(); // kembali ke halaman data desa
  }

  // fungsi untuk menghapus data lokasi
  public function delete(Request $req)
  {
    // menghapus data berdasarkan id
    try{
      DB::table('desa')->where('id',$req->input('hapus_id_desa'))->delete();
      session()->flash('insert', 'Data Desa berhasil diubah.');
    }
    catch(\Illuminate\Database\QueryException $e){
      throw new CustomException($e->getMessage());
    }
    return back(); // fungsi untuk mengarahkan ke halaman data desa
    // setelah menghapus data
  }

  // fungsi untuk mengembalikan nilai array data kabupaten
  public function desa(Request $req)
  {
    $id_desa = $req->id;
    $desa= DB::table('desa')
    ->where('id', '=', $id_desa)
    ->get();
    return response()->json($desa);
  }
}
