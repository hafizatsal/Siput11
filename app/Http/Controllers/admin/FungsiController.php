<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Http\Controllers\Controller;
use App\Exceptions\CustomException;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;

class FungsiController extends Controller
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
    // fungsi ini digunakan untuk menambahkan data fungsi
    // id dibuat otomatis autoincrement
    $nama_fungsi = $req->input('nama_fungsi_hutan');
    // menyimpan data fungsi ke dalam array
    $fungsi = array(
      'fungsi' => $nama_fungsi,
    );
    // memasukkkan data ke table fungsi
    try{
      DB::table('fungsi_hutan')->insert($fungsi);
      session()->flash('insert', 'Data Fungsi Hutan berhasil ditambah.');
    }
    catch(\Illuminate\Database\QueryException $e){
      throw new CustomException($e->getMessage());
    }
    return back(); // kembali ke halaman data fungsi
  }

  public function update(Request $req)
  {
    $id_fungsi = $req->input('id_fungsi_hutan2');
    $fungsi = $req->input('nama_fungsi_hutan2');

    // menyimpan data fungsi
    $data_fungsi = array(
      'id_fungsi_hutan' => $id_fungsi,
      'fungsi' => $fungsi,
    );
    // mengubah data fungsi
    try{
      DB::table('fungsi_hutan')->where('id_fungsi_hutan', $id_fungsi)->update($data_fungsi);
      session()->flash('insert', 'Data Fungsi Hutan berhasil diubah.');
    }
    catch(\Illuminate\Database\QueryException $e){
      throw new CustomException($e->getMessage());
    }
    return back(); // kembali ke halaman data hak milik
  }

  // fungsi untuk menghapus data hak milik
  public function delete(Request $req)
  {
    // menghapus data berdasarkan id fungsi
    try{
    DB::table('fungsi_hutan')->where('id_fungsi_hutan',$req->input('hapus_id_fungsi'))->delete();
    session()->flash('insert', 'Data Fungsi Hutan berhasil dihapus.');
    }
    catch(\Illuminate\Database\QueryException $e){
      throw new CustomException($e->getMessage());
    }
    return back(); // fungsi untuk mengarahkan ke halaman data fungsi
    // setelah menghapus data
  }

  // fungsi untuk mengembalikan nilai array hak milik
  public function fungsi(Request $req)
  {
    $id_fungsi = $req->id;
    $fungsi= DB::table('fungsi_hutan')
    ->where('id_fungsi_hutan', '=', $id_fungsi)
    ->get();
    return response()->json($fungsi);
  }
}
