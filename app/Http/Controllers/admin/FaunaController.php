<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Http\Controllers\Controller;
use App\Exceptions\CustomException;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;

class FaunaController extends Controller
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
      $data=DB::table('tabel_master_fauna')
      ->orderBy('nama_fauna')->get();
      return view('admin.fauna',[
        'data'=>$data,
      ]);
  }

  public function insert(Request $req)
  {
    // fungsi ini digunakan untuk menambahkan data fauna
    $nama_fauna = $req->input('nama_fauna');
    $nama_latin = $req->input('nama_latin_fauna');
    // menyimpan data fauna ke dalam array
    $data_fauna = array(
      'nama_fauna' => $nama_fauna,
      'nama_latin_fauna' => $nama_latin,
    );
    // memasukkkan data ke table data fauna
    try{
      DB::table('tabel_master_fauna')->insert($data_fauna);
      session()->flash('insert', 'Data Fauna berhasil ditambah.');
    }
    catch(\Illuminate\Database\QueryException $e){
      throw new CustomException($e->getMessage());
    }
    return back(); // kembali ke halaman data fauna
  }

  public function update(Request $req)
  {
    $id_fauna = $req->input('id_fauna2');
    $nama_fauna = $req->input('nama_fauna2');
    $nama_latin = $req->input('nama_latin_fauna2');

    // menyimpan data fauna
    $data_fauna = array(
      'nama_fauna' => $nama_fauna,
      'nama_latin_fauna' => $nama_latin,
    );
    // mengubah data fauna
    try{
      DB::table('tabel_master_fauna')->where('id_jenis_fauna', $id_fauna)->update($data_fauna);
      session()->flash('insert', 'Data Fauna berhasil diubah.');
    }
    catch(\Illuminate\Database\QueryException $e){
      throw new CustomException($e->getMessage());
    }
    return back(); // kembali ke halaman data fauna
  }

  // fungsi untuk menghapus data pohon
  public function delete(Request $req)
  {
    // menghapus data berdasarkan id_jenis_fauna
    try{
      DB::table('tabel_master_fauna')->where('id_jenis_fauna',$req->input('hapus_id_fauna'))->delete();
      session()->flash('insert', 'Data Fauna berhasil dihapus.');
    }
    catch(\Illuminate\Database\QueryException $e){
      throw new CustomException($e->getMessage());
    }
    return back(); // fungsi untuk mengarahkan ke halaman data fauna
    // setelah menghapus data
  }

  // fungsi untuk mengembalikan nilai array fauna
  public function fauna(Request $req)
  {
    $id_fauna = $req->id;
    $fauna= DB::table('tabel_master_fauna')
    ->where('id_jenis_fauna', '=', $id_fauna)
    ->get();
    return response()->json($fauna);
  }
}
