<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Http\Controllers\Controller;
use App\Exceptions\CustomException;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;

class IndikatorController extends Controller
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
      $data=DB::table('kode_kondisi_tajuk')
      ->orderBy('nama_parameter','asc')->get();
      return view('admin.nilai_tajuk',[
        'data'=>$data,
      ]);
  }

  public function update(Request $req)
  {
    $id_tajuk = $req->input('id_tajuk');
    $batas_atas = $req->input('batas_atas');
    $batas_bawah = $req->input('batas_bawah');

    // menyimpan data tanah
    $data_tajuk = array(
      'batas_atas' => $batas_atas,
      'batas_bawah' => $batas_bawah,
    );
    // mengubah data tanah
    try{
      DB::table('kode_kondisi_tajuk')->where('id_kondisi_tajuk', $id_tajuk)->update($data_tajuk);
      session()->flash('insert', 'Data Batas Tajuk berhasil diubah.');
    }
    catch(\Illuminate\Database\QueryException $e){
      throw new CustomException($e->getMessage());
    }
    return back(); // kembali ke halaman data tanah
  }


  // fungsi untuk mengembalikan nilai array data tajuk
  public function tajuk(Request $req)
  {
    $id_tajuk = $req->id;
    $tajuk= DB::table('kode_kondisi_tajuk')
    ->where('id_kondisi_tajuk', '=', $id_tajuk)
    ->get();
    return response()->json($tajuk);
  }

  public function index_lokasi()
  {
      $data=DB::table('kode_kerusakan_lokasi')
      ->orderBy('kode','asc')->get();
      return view('admin.nilai_kerusakan_lokasi',[
        'data'=>$data,
      ]);
  }

  public function insert_lokasi(Request $req)
  {
    // fungsi ini digunakan untuk menambahkan data kode kerusakan lokasi

    $kode = $req->input('kode_lokasi');
    $lokasi = $req->input('lokasi');
    $nilai = $req->input('nilai');
    // menyimpan data kode kerusakan lokasi ke dalam array
    $data_kode_lokasi = array(
      'kode' => $kode,
      'lokasi' => $lokasi,
      'nilai'=> $nilai,
    );
    // memasukkkan data ke table data kode kerusakan lokasi
    try{
      DB::table('kode_kerusakan_lokasi')->insert($data_kode_lokasi);
      session()->flash('insert', 'Data Lokasi Kerusakan berhasil ditambah.');
    }
    catch(\Illuminate\Database\QueryException $e){
      throw new CustomException($e->getMessage());
    }
    return back(); // kembali ke halaman data kerusakan lokasi
  }

  public function delete(Request $req)
  {
    // menghapus data berdasarkan kode
    try{
      DB::table('kode_kerusakan_lokasi')->where('kode',$req->input('hapus_id_lokasi'))->delete();
      session()->flash('insert', 'Data Kerusakan Lokasi berhasil dihapus.');
    }
    catch(\Illuminate\Database\QueryException $e){
      throw new CustomException($e->getMessage());
    }
    return back(); // fungsi untuk mengarahkan ke halaman lokasi kerusakan
    // setelah menghapus data
  }

  public function update_lokasi(Request $req)
  {
    $kode = $req->input('kode_lokasi_edit');
    $lokasi = $req->input('lokasi_edit');
    $nilai = $req->input('nilai_edit');

    // menyimpan data kerusakan lokasi
    $data_lokasi = array(
      'lokasi' => $lokasi,
      'nilai' => $nilai,
    );
    // mengubah data kerusakan lokasi
    try{
      DB::table('kode_kerusakan_lokasi')->where('kode', $kode)->update($data_lokasi);
      session()->flash('insert', 'Data Kerusakan Lokasi berhasil diubah.');
    }
    catch(\Illuminate\Database\QueryException $e){
      throw new CustomException($e->getMessage());
    }
    return back(); // kembali ke halaman data kerusakan lokasi
  }

  // fungsi untuk mengembalikan nilai array data kerusakan lokasi
  public function lokasi_kerusakan(Request $req)
  {
    $kode = $req->id;
    $kode_lokasi= DB::table('kode_kerusakan_lokasi')
    ->where('kode', '=', $kode)
    ->get();
    return response()->json($kode_lokasi);
  }

  public function index_tipe()
  {
      $data=DB::table('kode_kerusakan_type')
      ->orderBy('kode','asc')->get();
      return view('admin.nilai_kerusakan_tipe',[
        'data'=>$data,
      ]);
  }

  public function insert_tipe(Request $req)
  {
    // fungsi ini digunakan untuk menambahkan data kode kerusakan tipe

    $kode = $req->input('kode_tipe');
    $tipe = $req->input('tipe');
    $nilai = $req->input('nilai');
    // menyimpan data kode kerusakan tipe ke dalam array
    $data_kode_tipe = array(
      'kode' => $kode,
      'type' => $tipe,
      'nilai'=> $nilai,
    );
    // memasukkkan data ke table data kode kerusakan tipe
    try{
      DB::table('kode_kerusakan_type')->insert($data_kode_tipe);
      session()->flash('insert', 'Data Tipe Kerusakan berhasil ditambah.');
    }
    catch(\Illuminate\Database\QueryException $e){
      throw new CustomException($e->getMessage());
    }
    return back(); // kembali ke halaman data kerusakan tipe
  }

  public function delete_tipe(Request $req)
  {
    // menghapus data berdasarkan kode
    try{
      DB::table('kode_kerusakan_type')->where('kode',$req->input('hapus_id_tipe'))->delete();
      session()->flash('insert', 'Data Kerusakan Tipe berhasil dihapus.');
    }
    catch(\Illuminate\Database\QueryException $e){
      throw new CustomException($e->getMessage());
    }
    return back(); // fungsi untuk mengarahkan ke halaman tipe kerusakan
    // setelah menghapus data
  }

  public function update_tipe(Request $req)
  {
    $kode = $req->input('kode_tipe_edit');
    $tipe = $req->input('tipe_edit');
    $nilai = $req->input('nilai_edit');

    // menyimpan data kerusakan tipe
    $data_tipe = array(
      'type' => $tipe,
      'nilai' => $nilai,
    );
    // mengubah data kerusakan tipe
    try{
      DB::table('kode_kerusakan_type')->where('kode', $kode)->update($data_tipe);
      session()->flash('insert', 'Data Kerusakan Tipe berhasil diubah.');
    }
    catch(\Illuminate\Database\QueryException $e){
      throw new CustomException($e->getMessage());
    }
    return back(); // kembali ke halaman data kerusakan tipe
  }

  // fungsi untuk mengembalikan nilai array data kerusakan tipe
  public function tipe_kerusakan(Request $req)
  {
    $kode = $req->id;
    $kode_tipe= DB::table('kode_kerusakan_type')
    ->where('kode', '=', $kode)
    ->get();
    return response()->json($kode_tipe);
  }

  public function index_keparahan()
  {
      $data=DB::table('kode_kerusakan_keparahan')
      ->orderBy('keparahan','asc')->get();
      return view('admin.nilai_kerusakan_keparahan',[
        'data'=>$data,
      ]);
  }

  public function insert_keparahan(Request $req)
  {
    // fungsi ini digunakan untuk menambahkan data kode kerusakan keparahan

    $keparahan = $req->input('keparahan');
    $nilai = $req->input('nilai');
    // menyimpan data kode kerusakan keparahan ke dalam array
    $data_kode_keparahan = array(
      'keparahan' => $keparahan,
      'nilai'=> $nilai,
    );
    // memasukkkan data ke table data kode kerusakan keparahan
    try{
      DB::table('kode_kerusakan_keparahan')->insert($data_kode_keparahan);
      session()->flash('insert', 'Data Keparahan Kerusakan berhasil ditambah.');
    }
    catch(\Illuminate\Database\QueryException $e){
      throw new CustomException($e->getMessage());
    }
    return back(); // kembali ke halaman data kerusakan keparahan
  }

  public function delete_keparahan(Request $req)
  {
    // menghapus data berdasarkan kode
    try{
      DB::table('kode_kerusakan_keparahan')->where('keparahan',$req->input('hapus_id_keparahan'))->delete();
      session()->flash('insert', 'Data Kerusakan Keparahan berhasil dihapus.');
    }
    catch(\Illuminate\Database\QueryException $e){
      throw new CustomException($e->getMessage());
    }
    return back(); // fungsi untuk mengarahkan ke halaman keparahan kerusakan
    // setelah menghapus data
  }

  public function update_keparahan(Request $req)
  {
    $kode = $req->input('kode_keparahan_edit');
    $keparahan = $req->input('keparahan_edit');
    $nilai = $req->input('nilai_edit');

    // menyimpan data kerusakan keparahan
    $data_keparahan = array(
      'nilai' => $nilai,
    );
    // mengubah data kerusakan keparahan
    try{
      DB::table('kode_kerusakan_keparahan')->where('keparahan', $keparahan)->update($data_keparahan);
      session()->flash('insert', 'Data Kerusakan Keparahan berhasil diubah.');
    }
    catch(\Illuminate\Database\QueryException $e){
      throw new CustomException($e->getMessage());
    }
    return back(); // kembali ke halaman data kerusakan keparahan
  }

  // fungsi untuk mengembalikan nilai array data kerusakan keparahan
  public function keparahan_kerusakan(Request $req)
  {
    $keparahan = $req->id;
    $kode_keparahan= DB::table('kode_kerusakan_keparahan')
    ->where('keparahan', '=', $keparahan)
    ->get();
    return response()->json($kode_keparahan);
  }

}
