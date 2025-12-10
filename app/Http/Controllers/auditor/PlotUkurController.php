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


class PlotUkurController extends Controller
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
      // mengembalikan nilai data klaster
      $data_klaster = DB::table('tbl_data_klaster')
      ->orderBy('nama_data_klaster')->get();

      $data_kategori = DB::table('kategori_klaster')->get();

      return view('auditor.PlotUkur.data_klaster',compact('data_klaster','data_kategori')
      );
    }

    public function indexDataKlaster()
    {
      // mengembalikan nilai data klaster
      $data_klaster = DB::table('tbl_data_klaster')
      ->orderBy('nama_data_klaster')->get();

      $data_kategori = DB::table('kategori_klaster')->get();

      return view('auditor.PlotUkur.data_klaster_plot',compact('data_klaster','data_kategori')
      );
    }

    public function indexDataPlot()
    {
      // mengembalikan nilai data klaster
      $data_klaster = DB::table('tbl_data_klaster')
      ->orderBy('nama_data_klaster')->get();

      return view('auditor.PlotUkur.data_plot',compact('data_klaster')
      );
    }

    public function lihat(Request $req)
    {
      $id_data_klaster =$req->tahun_pengukuran;
      $kategori =$req->kategori;
      $pengukuran_ke =$req->pengukuranke;
      $data_klaster = DB::table('kategori_klaster')
                      ->where([['pengukuran_ke','like',$pengukuran_ke]])
                      ->where([['kategori','like',$kategori]])
                      ->where([['id_data_klaster','like',$id_data_klaster]])
                      ->orderBy('kategori')->get();

      $data_kategori = DB::table('kategori_klaster')->get();

      return view('auditor.PlotUkur.daftar_data_klaster',compact('data_klaster','data_kategori'));
    }

    public function klaster_plot($id)
    {
      $id=decrypt($id);
      $data_klaster_plot = DB::table('tbl_klaster_plot')
      ->leftjoin(
      'hak_milik_jenis_fungsi_hutan',
      'hak_milik_jenis_fungsi_hutan.id_klaster_plot','=','tbl_klaster_plot.id_klaster_plot'
      )
      ->leftjoin(
      'tbl_hak_milik',
      'tbl_hak_milik.id_hak_milik','=','hak_milik_jenis_fungsi_hutan.id_hak_milik')
      ->leftjoin(
      'fungsi_hutan',
      'fungsi_hutan.id_fungsi_hutan','=','hak_milik_jenis_fungsi_hutan.id_fungsi_hutan')
      ->leftjoin(
      'lokasi',
      'lokasi.id_klaster_plot','=','tbl_klaster_plot.id_klaster_plot')
      ->leftjoin(
      'desa',
      'desa.id','=','lokasi.id_desa')
      ->leftjoin(
      'kecamatan',
      'kecamatan.id','=','lokasi.id_kecamatan')
      ->leftjoin(
      'kabupaten',
      'kabupaten.id','=','lokasi.id_kabupaten')
      ->leftjoin(
      'provinsi',
      'provinsi.id_provinsi','=','lokasi.id_provinsi')
      ->where('id_data_klaster','=',$id)
      ->orderBy('nama_klaster')
      ->get();

      $cek_pengukuran = DB::table('kategori_klaster')
      ->where('id_data_klaster2','=',$id)->first();
      $cek_pengukuran2 = DB::table('kategori_klaster')
      ->where('id_data_klaster2','=',$id)->get();

if(count($cek_pengukuran2)!=0){
  if($cek_pengukuran->id_data_klaster2!=""){
    $id_data_klaster2 = $cek_pengukuran->id_data_klaster2;
    $cek_user = DB::table('tbl_klaster_plot')
    ->select('kategori_klaster.input_by')
    ->join('kategori_klaster','kategori_klaster.id_data_klaster','=','tbl_klaster_plot.id_data_klaster')
    ->where('kategori_klaster.id_data_klaster','=',$id_data_klaster2)
    ->first();

    $ijin = $cek_user->input_by;
  }
  else{
    $ijin = Auth::user()->id;
  }
}
else{
  $ijin = Auth::user()->id;
}



      $data_nama_klaster = DB::table('kategori_klaster')
      ->where('id_data_klaster','=',$id)->first();

        // variabel ini digunakan untuk mengembalikan nilai yang dipakai pada modal box
        //-------------------------------------------
        $provinsi = Provinsi::orderBy('nama_provinsi','asc')->get();
        $kepemilikan = Kepemilikan::orderBy('hak_milik','asc')->get();
        $jenis = Jenis::where('id_jenis_hutan','!=',0)
                ->orderBy('nama','asc')->get();
        $pola = Pola::where('id_pola_tanam','!=',0)
                ->orderBy('nama_pola','asc')->get();
        $jenis_pengelola = JenisPengelola::orderBy('jenis_pengelola','asc')->get();
        $data_klaster = DB::table('tbl_data_klaster')->orderBy('nama_data_klaster')->get();
        //-------------------------------------------
        $data_pengukuran = DB::table('kategori_klaster')
        ->where('id_data_klaster','=',$id)->first();

        $fungsi = DB::table('fungsi_hutan')->orderBy('fungsi')->get();
      return view('auditor.PlotUkur.klaster_plot',compact('data_klaster_plot','data_nama_klaster','provinsi','kepemilikan','jenis','pola','jenis_pengelola','data_pengukuran','fungsi','ijin'));
    }

    public function edit(Request $req){
      $req->validate([
          'id_data_klaster' => 'required|integer',
          'edit_pengukuranke1'=>'required|integer',
          'edit_tahun_pengukuran_modal'=>'required|date',
          'edit_nama_pengukur'=>'required|regex:/^[a-zA-Z, ]{2,50}$/',
          'edit_kategori_modal'=>'required|regex:/^[a-zA-Z ]{2,50}$/',
        ]);

      try{
        $id_data_klaster = $req->id_data_klaster;
        $pengukuran_ke = $req->edit_pengukuranke1;
        $nama_pengukur = $req->edit_nama_pengukur;
        $kategori = $req->edit_kategori_modal;
        $edit_tahun_pengukuran_modal = $req->edit_tahun_pengukuran_modal;
        $data_klaster = array(
          'pengukuran_ke' => $pengukuran_ke,
          'tahun_pengukuran' => $edit_tahun_pengukuran_modal,
          'nama_pengukur' => $nama_pengukur,
          'kategori' => $kategori,
        );
        DB::table('kategori_klaster')->where('id_data_klaster', $id_data_klaster)->update($data_klaster);

        session()->flash('insert', 'Data berhasil diubah.');
      }
      catch(\Illuminate\Database\QueryException $e){
        throw new CustomException($e->getMessage());
      }
      return back();
    }

    public function delete(Request $req){
      try{
        $id_data_klaster = $req->hapus_id_data_klaster;
        DB::table('kategori_klaster')->where('id_data_klaster', $id_data_klaster)->delete();
        session()->flash('insert', 'Data berhasil dihapus.');

      }
      catch(\Illuminate\Database\QueryException $e){
        throw new CustomException($e->getMessage());
      }
return back();
    }

    public function data_klaster2(Request $req){
      $id_data_klaster = $req->id;
      $data_klaster = DB::table('tbl_data_klaster')
      ->where('id_data_klaster','=',$id_data_klaster)
      ->get();
      return response()->json($data_klaster);
    }

    public function data_klaster_plot2(Request $req){
      $id_data_klaster = $req->id;
      $data_klaster_plot = DB::table('kategori_klaster')
      ->join('tbl_klaster_plot','tbl_klaster_plot.id_data_klaster','=','kategori_klaster.id_data_klaster')
      ->where('kategori_klaster.id_data_klaster','=',$id_data_klaster)
      ->orderBy('tbl_klaster_plot.nama_klaster')
      ->get();
      return response()->json($data_klaster_plot);
    }

    public function data_klaster_plot3(Request $req){
      $id_data_klaster = $req->id;
      $data_klaster_plot = DB::table('kategori_klaster')
      ->join('tbl_klaster_plot','tbl_klaster_plot.id_data_klaster','=','kategori_klaster.id_data_klaster')
      ->where('kategori_klaster.id_data_klaster','=',$id_data_klaster)
      ->orderBy('tbl_klaster_plot.nama_klaster')
      ->get();
      return response()->json($data_klaster_plot);
    }

    public function data_tahun(Request $req){
      $kategori=$req->id;
      $pengukuran_ke=$req->pengke;
      $data_tahun = DB::table('kategori_klaster')
      ->select('tahun_pengukuran','id_data_klaster','id_data_klaster2')
      ->where('kategori','=',$kategori)
      ->where('pengukuran_ke','=',$pengukuran_ke)
      ->orderBy('tahun_pengukuran')
      ->get();
      return response()->json($data_tahun);
    }

    public function data_tahun2(Request $req){
      $kategori=$req->id;
      $pengukuran_ke=$req->pengke;
      $data_tahun = DB::table('kategori_klaster')
      ->select('tahun_pengukuran','id_data_klaster')
      ->where('kategori','=',$kategori)
      ->where('pengukuran_ke','=',$pengukuran_ke)
      ->orderBy('tahun_pengukuran')
      ->get();
      return response()->json($data_tahun);
    }

    public function data_kategori(Request $req){
      $pengukuran_ke=$req->id;
      if($pengukuran_ke=="1" || $pengukuran_ke=="2" || $pengukuran_ke=="3" ){
        $data_kategori = DB::table('kategori_klaster')
        ->where('pengukuran_ke','=',$pengukuran_ke)
        ->where('verif','=',1)
        ->orderBy('kategori')
        ->get();
      }
      else if($pengukuran_ke=="99"){
        $data_kategori = DB::table('kategori_klaster')
        ->where('pengukuran_ke','=',1)
        ->where('verif','=',1)
        ->orderBy('kategori')
        ->get();
      }
      else{
        $data_kategori = DB::table('kategori_klaster')
        ->where('pengukuran_ke','=',1)
        // ->where('input_by','=',Auth::user()->id)
        ->where('verif','=',1)
        ->orderBy('kategori')
        ->get();
      }

      return response()->json($data_kategori);
    }

}
