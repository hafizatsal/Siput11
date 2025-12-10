<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Exceptions\CustomException;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;

class KabupatenController extends Controller
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
      $data=DB::table('provinsi')
      ->join(
        'kabupaten',
        'kabupaten.id_provinsi' , '=', 'provinsi.id_provinsi')
        ->where('provinsi.id_provinsi', '=', $id)
        ->get();
      return view('admin.kabupaten',[
        'data'=>$data,
        'id_provinsi' => $id,
      ]);
  }

  public function insert(Request $req)
  {
    // fungsi ini digunakan untuk menambahkan data kabuaten
    // id dibuat otomatis autoincrement
    $nama_kabupaten = $req->input('nama_kabupaten');
    $id_provinsi = $req->input('id_provinsi');
    // menyimpan data kabupaten ke dalam array
    $data_kabupaten = array(
      'id_provinsi' => $id_provinsi,
      'nama_kabupaten' => $nama_kabupaten,
    );
    // memasukkkan data ke table data kabupaten
    try{
    DB::table('kabupaten')->insert($data_kabupaten);
    session()->flash('insert', 'Data Kabupaten berhasil ditambah.');
    }
    catch(\Illuminate\Database\QueryException $e){
      throw new CustomException($e->getMessage());
    }
    return back(); // kembali ke halaman data kabupaten
  }

  public function update(Request $req)
  {
    $id_kabupaten = $req->input('edit_id_kab');
    $nama_kabupaten = $req->input('nama_kabupaten2');

    // menyimpan data kabupaten
    $data_kabupaten = array(
      'nama_kabupaten' => $nama_kabupaten,
    );
    // mengubah data kabupaten
    try{
    DB::table('kabupaten')->where('id', $id_kabupaten)->update($data_kabupaten);
    session()->flash('insert', 'Data Kabupaten berhasil diubah.');
    }
    catch(\Illuminate\Database\QueryException $e){
      throw new CustomException($e->getMessage());
    }
    return back(); // kembali ke halaman data kabupaten
  }

  // fungsi untuk menghapus data lokasi
  public function delete(Request $req)
  {
    // menghapus data berdasarkan id
    try{
      DB::table('kabupaten')->where('id',$req->input('hapus_id_kabupaten'))->delete();
      session()->flash('insert', 'Data Kabupaten berhasil dihapus.');
    }
    catch(\Illuminate\Database\QueryException $e){
      throw new CustomException($e->getMessage());
    }
    return back(); // fungsi untuk mengarahkan ke halaman data lokasi
    // setelah menghapus data
  }

  // fungsi untuk mengembalikan nilai array data kabupaten
  public function kabupaten(Request $req)
  {
    $id_kabupaten = $req->id;
    $kabupaten= DB::table('kabupaten')
    ->where('id', '=', $id_kabupaten)
    ->get();
    return response()->json($kabupaten);
  }
}
