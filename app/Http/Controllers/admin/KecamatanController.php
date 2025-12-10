<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Exceptions\CustomException;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;

class KecamatanController extends Controller
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
      $data=DB::table('kabupaten')
      ->join(
        'kecamatan',
        'kecamatan.id_kabupaten' , '=', 'kabupaten.id')
        ->where('kabupaten.id', '=', $id)
        ->get();
        $data2=DB::table('kabupaten')
          ->where('kabupaten.id', '=', $id)
          ->first();
      return view('admin.kecamatan',[
        'data'=>$data,
        'data2'=>$data2,
        'id_kabupaten' => $id,
      ]);
  }

  public function insert(Request $req)
  {
    // fungsi ini digunakan untuk menambahkan data kecamatan
    // id dibuat otomatis autoincrement
    $nama_kecamatan = $req->input('nama_kecamatan');
    $id_kabupaten = $req->input('id_kabupaten');
    // menyimpan data kecamatan ke dalam array
    $data_kecamatan = array(
      'id_kabupaten' => $id_kabupaten,
      'nama_kecamatan' => $nama_kecamatan,
    );
    // memasukkkan data ke table data kecamatan
    try{
      DB::table('kecamatan')->insert($data_kecamatan);
      session()->flash('insert', 'Data Kecamatan berhasil diubah.');
    }
    catch(\Illuminate\Database\QueryException $e){
      throw new CustomException($e->getMessage());
    }
    return back(); // kembali ke halaman data kecamatan
  }

  public function update(Request $req)
  {
    $id_kecamatan = $req->input('edit_id_kec');
    $nama_kecamatan = $req->input('nama_kecamatan2');

    // menyimpan data kecamatan
    $data_kecamatan = array(
      'nama_kecamatan' => $nama_kecamatan,
    );
    // mengubah data kecamatan
    try{
    DB::table('kecamatan')->where('id', $id_kecamatan)->update($data_kecamatan);
    session()->flash('insert', 'Data Kecamatan berhasil diubah.');
    }
    catch(\Illuminate\Database\QueryException $e){
      throw new CustomException($e->getMessage());
    }
    return back(); // kembali ke halaman data kecamatan
  }

  // fungsi untuk menghapus data lokasi
  public function delete(Request $req)
  {
    // menghapus data berdasarkan id
    try{
      DB::table('kecamatan')->where('id',$req->input('hapus_id_kecamatan'))->delete();
      session()->flash('insert', 'Data Kecamatan berhasil diubah.');
    }
    catch(\Illuminate\Database\QueryException $e){
      throw new CustomException($e->getMessage());
    }
    return back(); // fungsi untuk mengarahkan ke halaman data lokasi
    // setelah menghapus data
  }

  // fungsi untuk mengembalikan nilai array data kabupaten
  public function kecamatan(Request $req)
  {
    $id_kecamatan = $req->id;
    $kecamatan= DB::table('kecamatan')
    ->where('id', '=', $id_kecamatan)
    ->get();
    return response()->json($kecamatan);
  }
}
