<?php

namespace App\Http\Controllers\auditor;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Http\Controllers\Controller;
use App\Exceptions\CustomException;
use Illuminate\Database\QueryException;
use App\Provinsi;
use App\Kabupaten;
use App\Kecamatan;
use App\Desa;
use App\Kepemilikan;
use App\JenisPengelola;
use App\Jenis;
use App\Fungsi;
use App\Pola;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;


class VerifikasiController extends Controller
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


    public function lihat(Request $req)
    {
      $id_data_klaster =$req->tahun_pengukuran;
      $kategori =$req->kategori;
      $pengukuran_ke =$req->pengukuranke;
      $data_klaster = DB::table('kategori_klaster')
                      ->select('users.username','kategori_klaster.id_data_klaster','kategori_klaster.id_data_klaster2','kategori_klaster.pengukuran_ke','kategori_klaster.tahun_pengukuran','kategori_klaster.nama_pengukur','kategori_klaster.kategori','kategori_klaster.verif')
                      ->leftjoin('users','kategori_klaster.input_by','=','users.id')
                      ->orderBy('kategori_klaster.kategori')->get();

      $data_kategori = DB::table('kategori_klaster')->get();

      return view('auditor.verifikasi.data_verif',compact('data_klaster','data_kategori'));
    }

    public function verif(Request $req){
      try{
        $id_data_klaster = $req->verif_id_data_klaster;

        $data_klaster = array(
          'verif' => 1,
        );

        DB::table('kategori_klaster')->where('id_data_klaster', $id_data_klaster)->update($data_klaster);
        session()->flash('insert', 'Data berhasil diverifikasi.');
      }

      catch(\Illuminate\Database\QueryException $e){
        throw new CustomException($e->getMessage());
      }
      return back();
    }

    public function unverif(Request $req){
      try{
        $id_data_klaster = $req->unverif_id_data_klaster;

        $data_klaster = array(
          'verif' => 0,
        );

        DB::table('kategori_klaster')->where('id_data_klaster', $id_data_klaster)->update($data_klaster);
        session()->flash('insert', 'Data berhasil diunverifikasi.');
      }

      catch(\Illuminate\Database\QueryException $e){
        throw new CustomException($e->getMessage());
      }
      return back();
    }
}
