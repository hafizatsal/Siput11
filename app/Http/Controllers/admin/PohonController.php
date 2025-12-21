<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Http\Controllers\Controller;
use App\Exceptions\CustomException;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
class PohonController extends Controller
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
      $data=DB::table('table_master_jenis_tanaman')
      ->orderBy('nama_tanaman')->get();
      return view('admin.pohon',[
        'data'=>$data,
      ]);
  }

  public function insert(Request $req)
  {
    // fungsi ini digunakan untuk menambahkan data pohon
    // id dibuat otomatis autoincrement
    $req->validate([
      'nama_pohon' => 'required|string|max:255',
      'nama_latin_pohon' => 'required|string|max:255',
    ]);

    $nama_pohon = trim($req->input('nama_pohon'));
    $nama_latin = trim($req->input('nama_latin_pohon'));
    // menyimpan data pohon ke dalam array
    $data_pohon = array(
      'nama_tanaman' => $nama_pohon,
      'nama_latin' => $nama_latin,
    );
    // memasukkkan data ke table data pohon
    try{
      DB::table('table_master_jenis_tanaman')->insert($data_pohon);
      session()->flash('insert', 'Data Pohon berhasil ditambah.');
    }
    catch(\Illuminate\Database\QueryException $e){
      throw new CustomException($e->getMessage());
    }
    return back(); // kembali ke halaman data pohon
  }

  public function update(Request $req)
  {
    $req->validate([
      'id_pohon2' => 'required|integer',
      'nama_pohon2' => 'required|string|max:255',
      'nama_latin_pohon2' => 'required|string|max:255',
    ]);

    $id_pohon = $req->input('id_pohon2');
    $nama_pohon = trim($req->input('nama_pohon2'));
    $nama_latin = trim($req->input('nama_latin_pohon2'));

    // menyimpan data pohon
    $data_pohon = array(
      'id_jenis_tanaman' => $id_pohon,
      'nama_tanaman' => $nama_pohon,
      'nama_latin' => $nama_latin,
    );
    // mengubah data pohon
    try{
      DB::table('table_master_jenis_tanaman')->where('id_jenis_tanaman', $id_pohon)->update($data_pohon);
      session()->flash('insert', 'Data Pohon berhasil diubah.');
    }
    catch(\Illuminate\Database\QueryException $e){
      throw new CustomException($e->getMessage());
    }
    return back(); // kembali ke halaman data pohon
  }

  // fungsi untuk menghapus data pohon
  public function delete(Request $req)
  {
    // menghapus data berdasarkan id_jenis_tanaman
    try{
      DB::table('table_master_jenis_tanaman')->where('id_jenis_tanaman',$req->input('hapus_id_pohon'))->delete();
      session()->flash('insert', 'Data Pohon berhasil dihapus.');
    }
    catch(\Illuminate\Database\QueryException $e){
      throw new CustomException($e->getMessage());
    }
    return back();
    // setelah menghapus data
  }

  // fungsi untuk mengembalikan nilai array hak milik
  public function pohon2(Request $req)
  {
    $id_pohon = $req->id;
    $pohon= DB::table('table_master_jenis_tanaman')
    ->where('id_jenis_tanaman', '=', $id_pohon)
    ->get();
    return response()->json($pohon);
  }


}
