<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Http\Controllers\Controller;
use App\Exceptions\CustomException;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;

class InstansiController extends Controller
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
      $data=DB::table('instansi')
      ->orderBy('nama_instansi')->get();
      return view('admin.instansi',[
        'data'=>$data,
      ]);
  }

  public function insert(Request $req)
  {
    // fungsi ini digunakan untuk menambahkan data instansi
    // id dibuat otomatis autoincrement
    $nama_instansi = $req->input('nama_instansi');
    // menyimpan data instansi ke dalam array
    $data_instansi = array(
      'nama_instansi' => $nama_instansi,
    );
    // memasukkkan data ke table data instansi
    try{
      DB::table('instansi')->insert($data_instansi);
      session()->flash('insert', 'Data Instansi berhasil ditambah.');
    }
    catch(\Illuminate\Database\QueryException $e){
      throw new CustomException($e->getMessage());
    }
    return back(); // kembali ke halaman data instansi
  }

  public function update(Request $req)
  {
    $id_instansi = $req->input('id_instansi2');
    $nama_instansi = $req->input('nama_instansi2');

    // menyimpan data instansi
    $data_instansi = array(
      'nama_instansi' => $nama_instansi,
    );
    // mengubah data instansi
    try{
      DB::table('instansi')->where('id', $id_instansi)->update($data_instansi);
      session()->flash('insert', 'Data Instansi berhasil diubah.');
    }
    catch(\Illuminate\Database\QueryException $e){
      throw new CustomException($e->getMessage());
    }
    return back(); // kembali ke halaman data instansi
  }

  // fungsi untuk menghapus data instansi
  public function delete(Request $req)
  {
    // menghapus data berdasarkan id
    try{
      DB::table('instansi')->where('id',$req->input('hapus_id_instansi'))->delete();
      session()->flash('insert', 'Data Instansi berhasil dihapus.');
    }
    catch(\Illuminate\Database\QueryException $e){
      throw new CustomException($e->getMessage());
    }
    return back(); // fungsi untuk mengarahkan ke halaman data instansi
    // setelah menghapus data
  }

  // fungsi untuk mengembalikan nilai array data instansi
  public function instansi(Request $req)
  {
    $id_instansi = $req->id;
    $instansi= DB::table('instansi')
    ->where('id', '=', $id_instansi)
    ->get();
    return response()->json($instansi);
  }


}
