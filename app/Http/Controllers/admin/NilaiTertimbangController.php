<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class NilaiTertimbangController extends Controller
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
      $data=DB::table('tbl_master_tertimbang')->get();
      return view('admin.nilai_tertimbang',[
        'data'=>$data,
      ]);
  }

  public function insert(Request $req)
  {
    // fungsi ini digunakan untuk menambahkan data tertimbang
    // id dibuat otomatis autoincrement
    $nama_tertimbang = $req->input('nama_nilai_tertimbang');
    // menyimpan data tertimbang ke dalam array
    $data_tertimbang = array(
      'nama' => $nama_tertimbang,
    );
    // memasukkan data ke table data tertimbang
    DB::table('tbl_master_tertimbang')->insert($data_tertimbang);
    return back(); // kembali ke halaman data tertimbang
  }

  public function update(Request $req)
  {
    $id_tertimbang = $req->input('id_tertimbang2');
    $nama_tertimbang = $req->input('nama_nilai_tertimbang2');

    // menyimpan data tertimbang
    $data_tertimbang = array(
      'id_master_tertimbang' => $id_tertimbang,
      'nama' => $nama_tertimbang,
    );
    // mengubah data tertimbang
    DB::table('tbl_master_tertimbang')->where('id_master_tertimbang', $id_tertimbang)->update($data_tertimbang);
    return back(); // kembali ke halaman data tertimbang
  }

  // fungsi untuk menghapus data tertimbang
  public function delete(Request $req)
  {
    // menghapus data berdasarkan id_master_tertimbang
    DB::table('tbl_master_tertimbang')->where('id_master_tertimbang',$req->input('hapus_id_tertimbang'))->delete();
    return redirect(route('nilai_tertimbang')); // fungsi untuk mengarahkan ke halaman data tertimbang
    // setelah menghapus data
  }

  // fungsi untuk mengembalikan nilai array data tertimbang
  public function tertimbang(Request $req)
{
    $id_tertimbang = $req->input('id_tertimbang');

    $tertimbang = DB::table('tbl_master_tertimbang')
        ->where('id_master_tertimbang', $id_tertimbang)
        ->get();

    return response()->json($tertimbang);
}

}
