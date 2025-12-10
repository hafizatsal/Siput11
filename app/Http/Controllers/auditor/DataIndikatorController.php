<?php

namespace App\Http\Controllers\auditor;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use App\Exceptions\CustomException;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class DataIndikatorController extends Controller
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
     * @description fungsi index mengembalikan home auditor
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('auditor.home');
    }

    public function indexDataPengukuranp()
    {
      // mengembalikan nilai data klaster
      $data_klaster = DB::table('tbl_data_klaster')
      ->where('input_by','=',Auth::user()->id)
      ->orderBy('nama_data_klaster')->get();

      return view('auditor.data_pengukuran.data_pengukuran_prod',compact('data_klaster')
      );
    }

    public function indexDataPengukuranv()
    {
      // mengembalikan nilai data klaster
      $data_klaster = DB::table('tbl_data_klaster')
      ->where('input_by','=',Auth::user()->id)
      ->orderBy('nama_data_klaster')->get();

      return view('auditor.data_pengukuran.data_pengukuran_vit',compact('data_klaster')
      );
    }

    public function indexDataPengukuranb()
    {
      // mengembalikan nilai data klaster
      $data_klaster = DB::table('tbl_data_klaster')
      ->where('input_by','=',Auth::user()->id)
      ->orderBy('nama_data_klaster')->get();

      return view('auditor.data_pengukuran.data_pengukuran_bio',compact('data_klaster')
      );
    }

    public function indexDataPengukurank()
    {
      // mengembalikan nilai data klaster
      $data_klaster = DB::table('tbl_data_klaster')
      ->where('input_by','=',Auth::user()->id)
      ->orderBy('nama_data_klaster')->get();

      return view('auditor.data_pengukuran.data_pengukuran_ktk',compact('data_klaster')
      );
    }

    public function dataIndikator($id)
    {
      $id=decrypt($id);
      $data_pengukuran=DB::table('pengukuran_master')
      ->join('tbl_plot','tbl_plot.id_plot','=','pengukuran_master.id_plot')
      ->where('pengukuran_master.id_pengukuran','=',$id)
      ->first();

      $id_plot = $data_pengukuran->id_plot;
      $id_klaster=DB::table('tbl_plot')->select('id_klaster_plot')
      ->where('id_plot','=',$id_plot)
      ->first();
      $id_klaster_plot=$id_klaster->id_klaster_plot;

      return view('auditor.data_pengukuran.daftar_indikator',compact('id','id_plot','id_klaster_plot'));
    }

    public function paramBiodiversitas($id)
    {
      $id=decrypt($id);
      $data_pengukuran=DB::table('pengukuran_master')
      ->join('tbl_plot','tbl_plot.id_plot','=','pengukuran_master.id_plot')
      ->where('pengukuran_master.id_pengukuran','=',$id)
      ->first();

      $id_plot = $data_pengukuran->id_plot;
      $id_klaster=DB::table('tbl_plot')->select('id_klaster_plot')
      ->where('id_plot','=',$id_plot)
      ->first();
      $id_klaster_plot=$id_klaster->id_klaster_plot;

      return view('auditor.data_pengukuran.parameter_biodiversitas',compact('id','id_plot','id_klaster_plot'));
    }

    public function paramProduktivitas($id)
    {
      $id=decrypt($id);
      $data_pengukuran=DB::table('pengukuran_master')
      ->join('tbl_plot','tbl_plot.id_plot','=','pengukuran_master.id_plot')
      ->where('pengukuran_master.id_pengukuran','=',$id)
      ->first();

      $id_plot = $data_pengukuran->id_plot;
      $id_klaster=DB::table('tbl_plot')->select('id_klaster_plot')
      ->where('id_plot','=',$id_plot)
      ->first();
      $id_klaster_plot=$id_klaster->id_klaster_plot;

      return view('auditor.data_pengukuran.parameter_produktivitas',compact('id','id_plot','id_klaster_plot'));
    }

    public function paramVitalitas($id)
    {
      $id=decrypt($id);
      $data_pengukuran=DB::table('pengukuran_master')
      ->join('tbl_plot','tbl_plot.id_plot','=','pengukuran_master.id_plot')
      ->where('pengukuran_master.id_pengukuran','=',$id)
      ->first();

      $id_plot = $data_pengukuran->id_plot;
      $id_klaster=DB::table('tbl_plot')->select('id_klaster_plot')
      ->where('id_plot','=',$id_plot)
      ->first();
      $id_klaster_plot=$id_klaster->id_klaster_plot;

      return view('auditor.data_pengukuran.parameter_vitalitas',compact('id','id_plot','id_klaster_plot'));
    }

    public function paramKtk($id)
    {
      $id=decrypt($id);
      $data_pengukuran=DB::table('pengukuran_master')
      ->join('tbl_plot','tbl_plot.id_plot','=','pengukuran_master.id_plot')
      ->where('pengukuran_master.id_pengukuran','=',$id)
      ->first();

      $id_plot = $data_pengukuran->id_plot;
      $id_klaster=DB::table('tbl_plot')->select('id_klaster_plot')
      ->where('id_plot','=',$id_plot)
      ->first();
      $id_klaster_plot=$id_klaster->id_klaster_plot;

      return view('auditor.data_pengukuran.parameter_ktk',compact('id','id_plot','id_klaster_plot'));
    }

    public function biodivPohon($id)
    {
      $id=decrypt($id);
        $data_pengukuran=DB::table('pengukuran_master')
        ->leftjoin('tbl_plot','tbl_plot.id_plot','=','pengukuran_master.id_plot')
        ->leftjoin('tbl_klaster_plot','tbl_klaster_plot.id_klaster_plot','tbl_plot.id_klaster_plot')
        ->leftjoin('pola_tanam','pola_tanam.id_pola_tanam','=','tbl_klaster_plot.pola_tanam')
        ->where('pengukuran_master.id_pengukuran','=',$id)
        ->first();

        $id_plot = $data_pengukuran->id_plot;
        $id_klaster=DB::table('tbl_plot')->select('id_klaster_plot')
        ->where('id_plot','=',$id_plot)
        ->first();
        $id_klaster_plot=$id_klaster->id_klaster_plot;
        $pengukuran_ke=$data_pengukuran->pengukuran_ke;

        $id_semua_plot = DB::table('tbl_klaster_plot')
        ->join('tbl_plot','tbl_plot.id_klaster_plot','=','tbl_klaster_plot.id_klaster_plot')
        ->join('pengukuran_master','pengukuran_master.id_plot','=','tbl_plot.id_plot')
        ->where('pengukuran_master.pengukuran_ke','=',$pengukuran_ke)
        ->where('tbl_klaster_plot.id_klaster_plot','=',$id_klaster_plot)
        ->get();
        for($i=0;$i<count($id_semua_plot);$i++){
          $id_plots[$i]=$id_semua_plot[$i]->id_pengukuran;
          $nama_plots[$i]=$id_semua_plot[$i]->nama_plot;
        }

        $data_pohon=DB::table('pengukuran_master')
        ->join('data_tanaman_plot',
               'data_tanaman_plot.id_plot','=','pengukuran_master.id_plot'
               )
        ->join(
          'table_master_jenis_tanaman',
          'table_master_jenis_tanaman.id_jenis_tanaman','=','data_tanaman_plot.id_master_jenis_tanaman'
          )
        ->where('id_pengukuran','=',$id)
        ->where('data_tanaman_plot.pengukuran_ke','=',$pengukuran_ke)
        ->get();

        $master_pohon = DB::table('table_master_jenis_tanaman')->orderBy('nama_tanaman','asc')->get();

        $jumlah_pohon=DB::table('data_tanaman_plot')
        ->select(DB::raw("table_master_jenis_tanaman.nama_tanaman,table_master_jenis_tanaman.nama_latin,COUNT(*) as jumlah"))
        ->join(
        'table_master_jenis_tanaman',
        'table_master_jenis_tanaman.id_jenis_tanaman','=','data_tanaman_plot.id_master_jenis_tanaman'
        )
        ->where('id_plot','=',$id_plot)
        ->where('data_tanaman_plot.pengukuran_ke','=',$pengukuran_ke)
        ->where('data_tanaman_plot.status','=','1')
        ->groupBy(DB::raw('table_master_jenis_tanaman.nama_tanaman,table_master_jenis_tanaman.nama_latin'))
        ->get();

        $koordinat_bujur_p=$data_pengukuran->koordinat_BT;
      $splitName_p = explode(' ', $koordinat_bujur_p, 2);
      $splitName2_p= explode(' ', $splitName_p[1], 2);
      $splitName3_p= explode(' ', $splitName2_p[1], 2);
      if($splitName_p[0]>=0){
        $ket_bujur_p='BT';
      }
      else{
        $ket_bujur_p='BB';
        $splitName_p[0]=$splitName_p[0]*-1;
      }
      $koor_bt_ful_p=$splitName_p[0].' ᴼ '.$splitName2_p[0].' ’ '.$splitName3_p[0].' ”';

      $koordinat_lintang_p=$data_pengukuran->koordinat_LS;
      $l_splitName_p = explode(' ', $koordinat_lintang_p, 2);
      $l_splitName2_p= explode(' ', $l_splitName_p[1], 2);
      $l_splitName3_p= explode(' ', $l_splitName2_p[1], 2);
      if($l_splitName_p[0]>=0){
        $ket_lintang_p='LU';
      }
      else{
        $ket_lintang_p='LS';
        $l_splitName_p[0]=$l_splitName_p[0]*-1;
      }
      $koor_ls_ful_p=$l_splitName_p[0].' ᴼ '.$l_splitName2_p[0].' ’ '.$l_splitName3_p[0].' ”';

        return view('auditor.biodiversitas.biodiv_pohon',[
          'id'=>$id,
          'data_pengukuran'=>$data_pengukuran,
          'data_pohon'=>$data_pohon,
          'jumlah_pohon'=>$jumlah_pohon,
          'id_plot' => $id_plot,
          'id_klaster' => $id_klaster_plot,
          'pengukuran_ke' => $pengukuran_ke,
          'master_pohon' => $master_pohon,
          'koor_bt_ful_p'=>$koor_bt_ful_p,
          'koor_ls_ful_p'=>$koor_ls_ful_p,
          'ket_bujur_p'=>$ket_bujur_p,
          'ket_lintang_p'=>$ket_lintang_p,
          'id_pengukuran' => $id_plots,
          'nama_plots' => $nama_plots,
        ]);
    }

    public function biodivFauna($id)
    {
      $id=decrypt($id);
      $data_pengukuran=DB::table('pengukuran_master')
      ->leftjoin('tbl_plot','tbl_plot.id_plot','=','pengukuran_master.id_plot')
      ->leftjoin('tbl_klaster_plot','tbl_klaster_plot.id_klaster_plot','tbl_plot.id_klaster_plot')
      ->leftjoin('pola_tanam','pola_tanam.id_pola_tanam','=','tbl_klaster_plot.pola_tanam')
      ->where('pengukuran_master.id_pengukuran','=',$id)
      ->first();

      $id_plot = $data_pengukuran->id_plot;
      $id_klaster=DB::table('tbl_plot')->select('id_klaster_plot')
      ->where('id_plot','=',$id_plot)
      ->first();
      $id_klaster_plot=$id_klaster->id_klaster_plot;
      $pengukuran_ke=$data_pengukuran->pengukuran_ke;

      $id_semua_plot = DB::table('tbl_klaster_plot')
        ->join('tbl_plot','tbl_plot.id_klaster_plot','=','tbl_klaster_plot.id_klaster_plot')
        ->join('pengukuran_master','pengukuran_master.id_plot','=','tbl_plot.id_plot')
        ->where('pengukuran_master.pengukuran_ke','=',$pengukuran_ke)
        ->where('tbl_klaster_plot.id_klaster_plot','=',$id_klaster_plot)
        ->get();
        for($i=0;$i<count($id_semua_plot);$i++){
          $id_plots[$i]=$id_semua_plot[$i]->id_pengukuran;
          $nama_plots[$i]=$id_semua_plot[$i]->nama_plot;
        }

      $kode_kerusakan_lokasi=DB::table('kode_kerusakan_lokasi')
      ->get();

      $master_fauna = DB::table('tabel_master_fauna')->orderBy('nama_fauna')->get();

      $data_fauna=DB::table('data_fauna')
      ->join(
        'tabel_master_fauna',
        'tabel_master_fauna.id_jenis_fauna','=','data_fauna.id_master_fauna'
        )
      ->where('id_plot_fauna','=',$id_plot)
      ->where('data_fauna.pengukuran_ke','=',$pengukuran_ke)
      ->get();

      $jumlah_fauna=DB::table('data_fauna')
      ->join(
      'tabel_master_fauna',
      'tabel_master_fauna.id_jenis_fauna','=','data_fauna.id_master_fauna'
      )
      ->where('id_plot_fauna','=',$id_plot)
      ->where('data_fauna.pengukuran_ke','=',$pengukuran_ke)
      ->get();

      $koordinat_bujur_p=$data_pengukuran->koordinat_BT;
      $splitName_p = explode(' ', $koordinat_bujur_p, 2);
      $splitName2_p= explode(' ', $splitName_p[1], 2);
      $splitName3_p= explode(' ', $splitName2_p[1], 2);
      if($splitName_p[0]>=0){
        $ket_bujur_p='BT';
      }
      else{
        $ket_bujur_p='BB';
        $splitName_p[0]=$splitName_p[0]*-1;
      }
      $koor_bt_ful_p=$splitName_p[0].' ᴼ '.$splitName2_p[0].' ’ '.$splitName3_p[0].' ”';

      $koordinat_lintang_p=$data_pengukuran->koordinat_LS;
      $l_splitName_p = explode(' ', $koordinat_lintang_p, 2);
      $l_splitName2_p= explode(' ', $l_splitName_p[1], 2);
      $l_splitName3_p= explode(' ', $l_splitName2_p[1], 2);
      if($l_splitName_p[0]>=0){
        $ket_lintang_p='LU';
      }
      else{
        $ket_lintang_p='LS';
        $l_splitName_p[0]=$l_splitName_p[0]*-1;
      }
      $koor_ls_ful_p=$l_splitName_p[0].' ᴼ '.$l_splitName2_p[0].' ’ '.$l_splitName3_p[0].' ”';


      return view('auditor.biodiversitas.biodiv_fauna',[
        'id' => $id,
        'data_pengukuran'=>$data_pengukuran,
        'data_fauna'=>$data_fauna,
        'jumlah_fauna'=>$jumlah_fauna,
        'id_plot' => $id_plot,
        'id_klaster' => $id_klaster_plot,
        'pengukuran_ke' => $pengukuran_ke,
        'master_fauna' => $master_fauna,
        'koor_bt_ful_p'=>$koor_bt_ful_p,
        'koor_ls_ful_p'=>$koor_ls_ful_p,
        'ket_bujur_p'=>$ket_bujur_p,
        'ket_lintang_p'=>$ket_lintang_p,
        'id_pengukuran' => $id_plots,
        'nama_plots' => $nama_plots,
      ]);
    }

    public function bio(Request $req)
    {
      $id=$req->input('pengukuranke');
      $id_plot_p =  $req->input('nama_plot');
      $param=$req->nama_parameter;
      if($param==1){
        $data_pengukuran=DB::table('pengukuran_master')
        ->leftjoin('tbl_plot','tbl_plot.id_plot','=','pengukuran_master.id_plot')
        ->leftjoin('tbl_klaster_plot','tbl_klaster_plot.id_klaster_plot','tbl_plot.id_klaster_plot')
        ->leftjoin('pola_tanam','pola_tanam.id_pola_tanam','=','tbl_klaster_plot.pola_tanam')
        ->where('pengukuran_master.id_plot','=',$id_plot_p)
        ->where('pengukuran_master.pengukuran_ke','=',$id)
        ->first();

        $id_plot = $data_pengukuran->id_plot;
        $id_klaster=DB::table('tbl_plot')->select('id_klaster_plot')
        ->where('id_plot','=',$id_plot)
        ->first();
        $id_klaster_plot=$id_klaster->id_klaster_plot;
        $pengukuran_ke=$data_pengukuran->pengukuran_ke;
        $id_pengukuran = $data_pengukuran->id_pengukuran;

        $id_semua_plot = DB::table('tbl_klaster_plot')
        ->join('tbl_plot','tbl_plot.id_klaster_plot','=','tbl_klaster_plot.id_klaster_plot')
        ->join('pengukuran_master','pengukuran_master.id_plot','=','tbl_plot.id_plot')
        ->where('pengukuran_master.pengukuran_ke','=',$pengukuran_ke)
        ->where('tbl_klaster_plot.id_klaster_plot','=',$id_klaster_plot)
        ->get();
        for($i=0;$i<count($id_semua_plot);$i++){
          $id_plots[$i]=$id_semua_plot[$i]->id_pengukuran;
          $nama_plots[$i]=$id_semua_plot[$i]->nama_plot;
        }

        $data_pohon=DB::table('pengukuran_master')
        ->join('data_tanaman_plot',
               'data_tanaman_plot.id_plot','=','pengukuran_master.id_plot'
               )
        ->join(
          'table_master_jenis_tanaman',
          'table_master_jenis_tanaman.id_jenis_tanaman','=','data_tanaman_plot.id_master_jenis_tanaman'
          )
        ->where('pengukuran_master.id_pengukuran','=',$id_pengukuran)
        ->where('data_tanaman_plot.pengukuran_ke','=',$pengukuran_ke)
        ->get();

        $master_pohon = DB::table('table_master_jenis_tanaman')->orderBy('nama_tanaman','asc')->get();

        $jumlah_pohon=DB::table('data_tanaman_plot')
        ->select(DB::raw("table_master_jenis_tanaman.nama_tanaman,table_master_jenis_tanaman.nama_latin,COUNT(*) as jumlah"))
        ->join(
        'table_master_jenis_tanaman',
        'table_master_jenis_tanaman.id_jenis_tanaman','=','data_tanaman_plot.id_master_jenis_tanaman'
        )
        ->where('id_plot','=',$id_plot)
        ->where('data_tanaman_plot.pengukuran_ke','=',$pengukuran_ke)
        ->where('data_tanaman_plot.status','=','1')
        ->groupBy(DB::raw('table_master_jenis_tanaman.nama_tanaman,table_master_jenis_tanaman.nama_latin'))
        ->get();

        $koordinat_bujur_p=$data_pengukuran->koordinat_BT;
      $splitName_p = explode(' ', $koordinat_bujur_p, 2);
      $splitName2_p= explode(' ', $splitName_p[1], 2);
      $splitName3_p= explode(' ', $splitName2_p[1], 2);
      if($splitName_p[0]>=0){
        $ket_bujur_p='BT';
      }
      else{
        $ket_bujur_p='BB';
        $splitName_p[0]=$splitName_p[0]*-1;
      }
      $koor_bt_ful_p=$splitName_p[0].' ᴼ '.$splitName2_p[0].' ’ '.$splitName3_p[0].' ”';

      $koordinat_lintang_p=$data_pengukuran->koordinat_LS;
      $l_splitName_p = explode(' ', $koordinat_lintang_p, 2);
      $l_splitName2_p= explode(' ', $l_splitName_p[1], 2);
      $l_splitName3_p= explode(' ', $l_splitName2_p[1], 2);
      if($l_splitName_p[0]>=0){
        $ket_lintang_p='LU';
      }
      else{
        $ket_lintang_p='LS';
        $l_splitName_p[0]=$l_splitName_p[0]*-1;
      }
      $koor_ls_ful_p=$l_splitName_p[0].' ᴼ '.$l_splitName2_p[0].' ’ '.$l_splitName3_p[0].' ”';

        return view('auditor.biodiversitas.biodiv_pohon',[
          'id'=>$id_pengukuran,
          'data_pengukuran'=>$data_pengukuran,
          'data_pohon'=>$data_pohon,
          'jumlah_pohon'=>$jumlah_pohon,
          'id_plot' => $id_plot,
          'id_klaster' => $id_klaster_plot,
          'pengukuran_ke' => $pengukuran_ke,
          'master_pohon' => $master_pohon,
          'koor_bt_ful_p'=>$koor_bt_ful_p,
          'koor_ls_ful_p'=>$koor_ls_ful_p,
          'ket_bujur_p'=>$ket_bujur_p,
          'ket_lintang_p'=>$ket_lintang_p,
          'id_pengukuran' => $id_plots,
          'nama_plots' => $nama_plots,
        ]);
      }
      else if($param==2){
        $data_pengukuran=DB::table('pengukuran_master')
        ->leftjoin('tbl_plot','tbl_plot.id_plot','=','pengukuran_master.id_plot')
        ->leftjoin('tbl_klaster_plot','tbl_klaster_plot.id_klaster_plot','tbl_plot.id_klaster_plot')
        ->leftjoin('pola_tanam','pola_tanam.id_pola_tanam','=','tbl_klaster_plot.pola_tanam')
        ->where('pengukuran_master.id_plot','=',$id_plot_p)
        ->where('pengukuran_master.pengukuran_ke','=',$id)
        ->first();

        $id_plot = $data_pengukuran->id_plot;
        $id_klaster=DB::table('tbl_plot')->select('id_klaster_plot')
        ->where('id_plot','=',$id_plot)
        ->first();
        $id_klaster_plot=$id_klaster->id_klaster_plot;
        $pengukuran_ke=$data_pengukuran->pengukuran_ke;
        $id_pengukuran = $data_pengukuran->id_pengukuran;

        $id_semua_plot = DB::table('tbl_klaster_plot')
        ->join('tbl_plot','tbl_plot.id_klaster_plot','=','tbl_klaster_plot.id_klaster_plot')
        ->join('pengukuran_master','pengukuran_master.id_plot','=','tbl_plot.id_plot')
        ->where('pengukuran_master.pengukuran_ke','=',$pengukuran_ke)
        ->where('tbl_klaster_plot.id_klaster_plot','=',$id_klaster_plot)
        ->get();
        for($i=0;$i<count($id_semua_plot);$i++){
          $id_plots[$i]=$id_semua_plot[$i]->id_pengukuran;
          $nama_plots[$i]=$id_semua_plot[$i]->nama_plot;
        }

        $master_fauna = DB::table('tabel_master_fauna')->orderBy('nama_fauna')->get();

        $data_fauna=DB::table('data_fauna')
        ->join(
          'tabel_master_fauna',
          'tabel_master_fauna.id_jenis_fauna','=','data_fauna.id_master_fauna'
          )
          ->join('pengukuran_master',
                 'pengukuran_master.id_plot','=','data_fauna.id_plot_fauna'
                 )
        ->where('pengukuran_master.id_pengukuran','=',$id_pengukuran)
        ->where('data_fauna.pengukuran_ke','=',$pengukuran_ke)
        ->get();

        $jumlah_fauna=DB::table('data_fauna')
        ->join(
        'tabel_master_fauna',
        'tabel_master_fauna.id_jenis_fauna','=','data_fauna.id_master_fauna'
        )
        ->where('id_plot_fauna','=',$id_plot)
        ->where('data_fauna.pengukuran_ke','=',$pengukuran_ke)
        ->get();

        $koordinat_bujur_p=$data_pengukuran->koordinat_BT;
      $splitName_p = explode(' ', $koordinat_bujur_p, 2);
      $splitName2_p= explode(' ', $splitName_p[1], 2);
      $splitName3_p= explode(' ', $splitName2_p[1], 2);
      if($splitName_p[0]>=0){
        $ket_bujur_p='BT';
      }
      else{
        $ket_bujur_p='BB';
        $splitName_p[0]=$splitName_p[0]*-1;
      }
      $koor_bt_ful_p=$splitName_p[0].' ᴼ '.$splitName2_p[0].' ’ '.$splitName3_p[0].' ”';

      $koordinat_lintang_p=$data_pengukuran->koordinat_LS;
      $l_splitName_p = explode(' ', $koordinat_lintang_p, 2);
      $l_splitName2_p= explode(' ', $l_splitName_p[1], 2);
      $l_splitName3_p= explode(' ', $l_splitName2_p[1], 2);
      if($l_splitName_p[0]>=0){
        $ket_lintang_p='LU';
      }
      else{
        $ket_lintang_p='LS';
        $l_splitName_p[0]=$l_splitName_p[0]*-1;
      }
      $koor_ls_ful_p=$l_splitName_p[0].' ᴼ '.$l_splitName2_p[0].' ’ '.$l_splitName3_p[0].' ”';

        return view('auditor.biodiversitas.biodiv_fauna',[
          'id' => $id_pengukuran,
          'data_pengukuran'=>$data_pengukuran,
          'data_fauna'=>$data_fauna,
          'jumlah_fauna'=>$jumlah_fauna,
          'id_plot' => $id_plot,
          'id_klaster' => $id_klaster_plot,
          'pengukuran_ke' => $pengukuran_ke,
          'master_fauna' => $master_fauna,
          'koor_bt_ful_p'=>$koor_bt_ful_p,
          'koor_ls_ful_p'=>$koor_ls_ful_p,
          'ket_bujur_p'=>$ket_bujur_p,
          'ket_lintang_p'=>$ket_lintang_p,
          'id_pengukuran' => $id_plots,
          'nama_plots' => $nama_plots,
        ]);
      }
    }

    public function lbds($id)
    {
      $id=decrypt($id);
        $data_pengukuran=DB::table('pengukuran_master')
        ->leftjoin('tbl_plot','tbl_plot.id_plot','=','pengukuran_master.id_plot')
        ->leftjoin('tbl_klaster_plot','tbl_klaster_plot.id_klaster_plot','tbl_plot.id_klaster_plot')
        ->leftjoin('pola_tanam','pola_tanam.id_pola_tanam','=','tbl_klaster_plot.pola_tanam')
        ->where('pengukuran_master.id_pengukuran','=',$id)
        ->first();

        $id_plot = $data_pengukuran->id_plot;
        $id_klaster=DB::table('tbl_plot')->select('id_klaster_plot')
        ->where('id_plot','=',$id_plot)
        ->first();
        $id_klaster_plot=$id_klaster->id_klaster_plot;
        $pengukuran_ke=$data_pengukuran->pengukuran_ke;
        $id_pengukuran = $data_pengukuran->id_pengukuran;

        $id_semua_plot = DB::table('tbl_klaster_plot')
        ->join('tbl_plot','tbl_plot.id_klaster_plot','=','tbl_klaster_plot.id_klaster_plot')
        ->join('pengukuran_master','pengukuran_master.id_plot','=','tbl_plot.id_plot')
        ->where('pengukuran_master.pengukuran_ke','=',$pengukuran_ke)
        ->where('tbl_klaster_plot.id_klaster_plot','=',$id_klaster_plot)
        ->get();
        for($i=0;$i<count($id_semua_plot);$i++){
          $id_plots[$i]=$id_semua_plot[$i]->id_pengukuran;
          $nama_plots[$i]=$id_semua_plot[$i]->nama_plot;
        }

        $data_pohon=DB::table('pengukuran_master')
        ->join('data_tanaman_plot',
               'data_tanaman_plot.id_plot','=','pengukuran_master.id_plot'
               )
        ->join(
          'table_master_jenis_tanaman',
          'table_master_jenis_tanaman.id_jenis_tanaman','=','data_tanaman_plot.id_master_jenis_tanaman'
          )
        ->leftjoin(
          'lbds',
          'data_tanaman_plot.id_tanaman_plot','=','lbds.id_tanaman'
          )
        ->where('pengukuran_master.id_pengukuran','=',$id)
        ->where('data_tanaman_plot.pengukuran_ke','=',$pengukuran_ke)
        ->get();

        $data_pohon_import=DB::table('lbds')
        ->where('id_pengukuran','=',$id_pengukuran)
        ->get();

        $master_pohon = DB::table('table_master_jenis_tanaman')->orderBy('nama_tanaman','asc')->get();

        $koordinat_bujur_p=$data_pengukuran->koordinat_BT;
        $splitName_p = explode(' ', $koordinat_bujur_p, 2);
        $splitName2_p= explode(' ', $splitName_p[1], 2);
        $splitName3_p= explode(' ', $splitName2_p[1], 2);
        if($splitName_p[0]>=0){
          $ket_bujur_p='BT';
        }
        else{
          $ket_bujur_p='BB';
          $splitName_p[0]=$splitName_p[0]*-1;
        }
        $koor_bt_ful_p=$splitName_p[0].' ᴼ '.$splitName2_p[0].' ’ '.$splitName3_p[0].' ”';

        $koordinat_lintang_p=$data_pengukuran->koordinat_LS;
        $l_splitName_p = explode(' ', $koordinat_lintang_p, 2);
        $l_splitName2_p= explode(' ', $l_splitName_p[1], 2);
        $l_splitName3_p= explode(' ', $l_splitName2_p[1], 2);
        if($l_splitName_p[0]>=0){
          $ket_lintang_p='LU';
        }
        else{
          $ket_lintang_p='LS';
          $l_splitName_p[0]=$l_splitName_p[0]*-1;
        }
        $koor_ls_ful_p=$l_splitName_p[0].' ᴼ '.$l_splitName2_p[0].' ’ '.$l_splitName3_p[0].' ”';

        $data_foto_pengukuran = DB::table('foto_lbds')
        ->select('id_foto_lbds','title','keterangan','filename')
        ->join('lbds','lbds.id_pengukuran','=','foto_lbds.id_pengukuran')
        ->where('lbds.id_pengukuran','=',$data_pengukuran->id_pengukuran)
        ->groupBy('foto_lbds.id_foto_lbds','lbds.id_pengukuran','foto_lbds.title','foto_lbds.keterangan','foto_lbds.filename')
        ->orderBy('foto_lbds.id_foto_lbds','desc')
        ->get();

        return view('auditor.produktivitas.prod_lbds',[
          'id'=>$id,
          'data_pengukuran'=>$data_pengukuran,
          'koor_bt_ful_p'=>$koor_bt_ful_p,
          'koor_ls_ful_p'=>$koor_ls_ful_p,
          'ket_bujur_p'=>$ket_bujur_p,
          'ket_lintang_p'=>$ket_lintang_p,
          'data_pohon'=>$data_pohon,
          'data_pohon_import' => $data_pohon_import,
          'id_plot' => $id_plot,
          'id_klaster' => $id_klaster_plot,
          'pengukuran_ke' => $pengukuran_ke,
          'master_pohon' => $master_pohon,
          'id_pengukuran' => $id_plots,
          'nama_plots' => $nama_plots,

          'data_foto_pengukuran' => $data_foto_pengukuran,
        ]);
    }

    public function lbds2(Request $req)
    {
      $id=$req->input('pengukuranke');
      $id_plot_p =  $req->input('nama_plot');
        $data_pengukuran=DB::table('pengukuran_master')
        ->leftjoin('tbl_plot','tbl_plot.id_plot','=','pengukuran_master.id_plot')
        ->leftjoin('tbl_klaster_plot','tbl_klaster_plot.id_klaster_plot','tbl_plot.id_klaster_plot')
        ->leftjoin('pola_tanam','pola_tanam.id_pola_tanam','=','tbl_klaster_plot.pola_tanam')
        ->where('pengukuran_master.id_plot','=',$id_plot_p)
        ->where('pengukuran_master.pengukuran_ke','=',$id)
        ->first();

        $id_plot = $data_pengukuran->id_plot;
        $id_klaster=DB::table('tbl_plot')->select('id_klaster_plot')
        ->where('id_plot','=',$id_plot)
        ->first();
        $id_klaster_plot=$id_klaster->id_klaster_plot;
        $pengukuran_ke=$data_pengukuran->pengukuran_ke;
        $id_pengukuran = $data_pengukuran->id_pengukuran;

        $id_semua_plot = DB::table('tbl_klaster_plot')
        ->join('tbl_plot','tbl_plot.id_klaster_plot','=','tbl_klaster_plot.id_klaster_plot')
        ->join('pengukuran_master','pengukuran_master.id_plot','=','tbl_plot.id_plot')
        ->where('pengukuran_master.pengukuran_ke','=',$pengukuran_ke)
        ->where('tbl_klaster_plot.id_klaster_plot','=',$id_klaster_plot)
        ->get();
        for($i=0;$i<count($id_semua_plot);$i++){
          $id_plots[$i]=$id_semua_plot[$i]->id_pengukuran;
          $nama_plots[$i]=$id_semua_plot[$i]->nama_plot;
        }

        $data_pohon=DB::table('pengukuran_master')
        ->join('data_tanaman_plot',
               'data_tanaman_plot.id_plot','=','pengukuran_master.id_plot'
               )
        ->join(
          'table_master_jenis_tanaman',
          'table_master_jenis_tanaman.id_jenis_tanaman','=','data_tanaman_plot.id_master_jenis_tanaman'
          )
        ->leftjoin(
          'lbds',
          'data_tanaman_plot.id_tanaman_plot','=','lbds.id_tanaman'
          )
        ->where('pengukuran_master.id_pengukuran','=',$id_pengukuran)
        ->where('data_tanaman_plot.pengukuran_ke','=',$pengukuran_ke)
        ->get();

        $data_pohon_import=DB::table('lbds')
        ->where('id_pengukuran','=',$id_pengukuran)
        ->get();

        $master_pohon = DB::table('table_master_jenis_tanaman')->orderBy('nama_tanaman','asc')->get();

        $koordinat_bujur_p=$data_pengukuran->koordinat_BT;
      $splitName_p = explode(' ', $koordinat_bujur_p, 2);
      $splitName2_p= explode(' ', $splitName_p[1], 2);
      $splitName3_p= explode(' ', $splitName2_p[1], 2);
      if($splitName_p[0]>=0){
        $ket_bujur_p='BT';
      }
      else{
        $ket_bujur_p='BB';
        $splitName_p[0]=$splitName_p[0]*-1;
      }
      $koor_bt_ful_p=$splitName_p[0].' ᴼ '.$splitName2_p[0].' ’ '.$splitName3_p[0].' ”';

      $koordinat_lintang_p=$data_pengukuran->koordinat_LS;
      $l_splitName_p = explode(' ', $koordinat_lintang_p, 2);
      $l_splitName2_p= explode(' ', $l_splitName_p[1], 2);
      $l_splitName3_p= explode(' ', $l_splitName2_p[1], 2);
      if($l_splitName_p[0]>=0){
        $ket_lintang_p='LU';
      }
      else{
        $ket_lintang_p='LS';
        $l_splitName_p[0]=$l_splitName_p[0]*-1;
      }
      $koor_ls_ful_p=$l_splitName_p[0].' ᴼ '.$l_splitName2_p[0].' ’ '.$l_splitName3_p[0].' ”';

      $data_foto_pengukuran = DB::table('foto_lbds')
      ->select('id_foto_lbds','title','keterangan','filename')
      ->join('lbds','lbds.id_pengukuran','=','foto_lbds.id_pengukuran')
      ->where('lbds.id_pengukuran','=',$data_pengukuran->id_pengukuran)
      ->groupBy('foto_lbds.id_foto_lbds','lbds.id_pengukuran','foto_lbds.title','foto_lbds.keterangan','foto_lbds.filename')
      ->orderBy('foto_lbds.id_foto_lbds','desc')
      ->get();

        return view('auditor.produktivitas.prod_lbds',[
          'id'=>$id_pengukuran,
          'data_pengukuran'=>$data_pengukuran,
          'data_pohon'=>$data_pohon,
          'data_pohon_import'=>$data_pohon_import,
          'id_plot' => $id_plot,
          'id_klaster' => $id_klaster_plot,
          'pengukuran_ke' => $pengukuran_ke,
          'master_pohon' => $master_pohon,
          'koor_bt_ful_p'=>$koor_bt_ful_p,
          'koor_ls_ful_p'=>$koor_ls_ful_p,
          'ket_bujur_p'=>$ket_bujur_p,
          'ket_lintang_p'=>$ket_lintang_p,
          'id_plots' => $id_plots,
          'nama_plots' => $nama_plots,
          'id_pengukuran' => $id_plots,
          'nama_plots' => $nama_plots,

          'data_foto_pengukuran' => $data_foto_pengukuran,
        ]);
    }

    public function kerusakan($id)
    {
      $id=decrypt($id);
        $data_pengukuran=DB::table('pengukuran_master')
        ->leftjoin('tbl_plot','tbl_plot.id_plot','=','pengukuran_master.id_plot')
        ->leftjoin('tbl_klaster_plot','tbl_klaster_plot.id_klaster_plot','tbl_plot.id_klaster_plot')
        ->leftjoin('pola_tanam','pola_tanam.id_pola_tanam','=','tbl_klaster_plot.pola_tanam')
        ->where('pengukuran_master.id_pengukuran','=',$id)
        ->first();

        $id_plot = $data_pengukuran->id_plot;
        $id_klaster=DB::table('tbl_plot')->select('id_klaster_plot')
        ->where('id_plot','=',$id_plot)
        ->first();
        $id_klaster_plot=$id_klaster->id_klaster_plot;
        $pengukuran_ke=$data_pengukuran->pengukuran_ke;
        $id_pengukuran = $data_pengukuran->id_pengukuran;

        $id_semua_plot = DB::table('tbl_klaster_plot')
        ->join('tbl_plot','tbl_plot.id_klaster_plot','=','tbl_klaster_plot.id_klaster_plot')
        ->join('pengukuran_master','pengukuran_master.id_plot','=','tbl_plot.id_plot')
        ->where('pengukuran_master.pengukuran_ke','=',$pengukuran_ke)
        ->where('tbl_klaster_plot.id_klaster_plot','=',$id_klaster_plot)
        ->get();
        for($i=0;$i<count($id_semua_plot);$i++){
          $id_plots[$i]=$id_semua_plot[$i]->id_pengukuran;
          $nama_plots[$i]=$id_semua_plot[$i]->nama_plot;
        }

        $kode_kerusakan_lokasi=DB::table('kode_kerusakan_lokasi')
        ->get();

        $data_pohon=DB::table('pengukuran_master')
        ->join('data_tanaman_plot',
               'data_tanaman_plot.id_plot','=','pengukuran_master.id_plot'
               )
        ->join(
          'table_master_jenis_tanaman',
          'table_master_jenis_tanaman.id_jenis_tanaman','=','data_tanaman_plot.id_master_jenis_tanaman'
          )
        ->leftjoin(
          'kerusakan_pohon',
          'data_tanaman_plot.id_tanaman_plot','=','kerusakan_pohon.id_tanaman'
          )
        ->where('pengukuran_master.id_pengukuran','=',$id)
        ->where('data_tanaman_plot.pengukuran_ke','=',$pengukuran_ke)
        ->get();

        $data_pohon_import=DB::table('kerusakan_pohon')
        ->where('id_pengukuran','=',$id_pengukuran)
        ->get();

        $master_pohon = DB::table('table_master_jenis_tanaman')->orderBy('nama_tanaman','asc')->get();

        $koordinat_bujur_p=$data_pengukuran->koordinat_BT;
      $splitName_p = explode(' ', $koordinat_bujur_p, 2);
      $splitName2_p= explode(' ', $splitName_p[1], 2);
      $splitName3_p= explode(' ', $splitName2_p[1], 2);
      if($splitName_p[0]>=0){
        $ket_bujur_p='BT';
      }
      else{
        $ket_bujur_p='BB';
        $splitName_p[0]=$splitName_p[0]*-1;
      }
      $koor_bt_ful_p=$splitName_p[0].' ᴼ '.$splitName2_p[0].' ’ '.$splitName3_p[0].' ”';

      $koordinat_lintang_p=$data_pengukuran->koordinat_LS;
      $l_splitName_p = explode(' ', $koordinat_lintang_p, 2);
      $l_splitName2_p= explode(' ', $l_splitName_p[1], 2);
      $l_splitName3_p= explode(' ', $l_splitName2_p[1], 2);
      if($l_splitName_p[0]>=0){
        $ket_lintang_p='LU';
      }
      else{
        $ket_lintang_p='LS';
        $l_splitName_p[0]=$l_splitName_p[0]*-1;
      }
      $koor_ls_ful_p=$l_splitName_p[0].' ᴼ '.$l_splitName2_p[0].' ’ '.$l_splitName3_p[0].' ”';

      $data_foto_pengukuran = DB::table('foto_kerusakan')
      ->select('id_foto_kerusakan','title','keterangan','filename')
      ->join('kerusakan_pohon','kerusakan_pohon.id_pengukuran','=','foto_kerusakan.id_pengukuran')
      ->where('kerusakan_pohon.id_pengukuran','=',$data_pengukuran->id_pengukuran)
      ->groupBy('foto_kerusakan.id_foto_kerusakan','kerusakan_pohon.id_pengukuran','foto_kerusakan.title','foto_kerusakan.keterangan','foto_kerusakan.filename')
      ->orderBy('foto_kerusakan.id_foto_kerusakan','desc')
      ->get();

        return view('auditor.vitalitas.kerusakan',[
          'id'=>$id,
          'data_pengukuran'=>$data_pengukuran,
          'data_pohon'=>$data_pohon,
          'data_pohon_import'=>$data_pohon_import,
          'kode_lokasi'=>$kode_kerusakan_lokasi,
          'id_plot' => $id_plot,
          'id_klaster' => $id_klaster_plot,
          'pengukuran_ke' => $pengukuran_ke,
          'master_pohon' => $master_pohon,
          'koor_bt_ful_p'=>$koor_bt_ful_p,
          'koor_ls_ful_p'=>$koor_ls_ful_p,
          'ket_bujur_p'=>$ket_bujur_p,
          'ket_lintang_p'=>$ket_lintang_p,
          'id_pengukuran' => $id_plots,
          'nama_plots' => $nama_plots,

          'data_foto_pengukuran' => $data_foto_pengukuran,
        ]);
    }

    public function tajuk($id)
    {
      $id=decrypt($id);
        $data_pengukuran=DB::table('pengukuran_master')
        ->leftjoin('tbl_plot','tbl_plot.id_plot','=','pengukuran_master.id_plot')
        ->leftjoin('tbl_klaster_plot','tbl_klaster_plot.id_klaster_plot','tbl_plot.id_klaster_plot')
        ->leftjoin('pola_tanam','pola_tanam.id_pola_tanam','=','tbl_klaster_plot.pola_tanam')
        ->where('pengukuran_master.id_pengukuran','=',$id)
        ->first();

        $id_plot = $data_pengukuran->id_plot;
        $id_klaster=DB::table('tbl_plot')->select('id_klaster_plot')
        ->where('id_plot','=',$id_plot)
        ->first();
        $id_klaster_plot=$id_klaster->id_klaster_plot;
        $pengukuran_ke=$data_pengukuran->pengukuran_ke;
        $id_pengukuran = $data_pengukuran->id_pengukuran;

        $id_semua_plot = DB::table('tbl_klaster_plot')
        ->join('tbl_plot','tbl_plot.id_klaster_plot','=','tbl_klaster_plot.id_klaster_plot')
        ->join('pengukuran_master','pengukuran_master.id_plot','=','tbl_plot.id_plot')
        ->where('pengukuran_master.pengukuran_ke','=',$pengukuran_ke)
        ->where('tbl_klaster_plot.id_klaster_plot','=',$id_klaster_plot)
        ->get();
        for($i=0;$i<count($id_semua_plot);$i++){
          $id_plots[$i]=$id_semua_plot[$i]->id_pengukuran;
          $nama_plots[$i]=$id_semua_plot[$i]->nama_plot;
        }

        $data_pohon=DB::table('pengukuran_master')
        ->join('data_tanaman_plot',
               'data_tanaman_plot.id_plot','=','pengukuran_master.id_plot'
               )
        ->join(
          'table_master_jenis_tanaman',
          'table_master_jenis_tanaman.id_jenis_tanaman','=','data_tanaman_plot.id_master_jenis_tanaman'
          )
        ->leftjoin(
          'kondisi_tajuk',
          'data_tanaman_plot.id_tanaman_plot','=','kondisi_tajuk.id_tanaman'
          )
        ->where('pengukuran_master.id_pengukuran','=',$id)
        ->where('data_tanaman_plot.pengukuran_ke','=',$pengukuran_ke)
        ->get();

        $data_pohon_import=DB::table('kondisi_tajuk')
        ->where('id_pengukuran','=',$id_pengukuran)
        ->get();

        $master_pohon = DB::table('table_master_jenis_tanaman')->orderBy('nama_tanaman','asc')->get();

        $koordinat_bujur_p=$data_pengukuran->koordinat_BT;
      $splitName_p = explode(' ', $koordinat_bujur_p, 2);
      $splitName2_p= explode(' ', $splitName_p[1], 2);
      $splitName3_p= explode(' ', $splitName2_p[1], 2);
      if($splitName_p[0]>=0){
        $ket_bujur_p='BT';
      }
      else{
        $ket_bujur_p='BB';
        $splitName_p[0]=$splitName_p[0]*-1;
      }
      $koor_bt_ful_p=$splitName_p[0].' ᴼ '.$splitName2_p[0].' ’ '.$splitName3_p[0].' ”';

      $koordinat_lintang_p=$data_pengukuran->koordinat_LS;
      $l_splitName_p = explode(' ', $koordinat_lintang_p, 2);
      $l_splitName2_p= explode(' ', $l_splitName_p[1], 2);
      $l_splitName3_p= explode(' ', $l_splitName2_p[1], 2);
      if($l_splitName_p[0]>=0){
        $ket_lintang_p='LU';
      }
      else{
        $ket_lintang_p='LS';
        $l_splitName_p[0]=$l_splitName_p[0]*-1;
      }
      $koor_ls_ful_p=$l_splitName_p[0].' ᴼ '.$l_splitName2_p[0].' ’ '.$l_splitName3_p[0].' ”';

      $data_foto_pengukuran = DB::table('foto_tajuk')
      ->select('id_foto_tajuk','title','keterangan','filename')
      ->join('kondisi_tajuk','kondisi_tajuk.id_pengukuran','=','foto_tajuk.id_pengukuran')
      ->where('kondisi_tajuk.id_pengukuran','=',$data_pengukuran->id_pengukuran)
      ->groupBy('foto_tajuk.id_foto_tajuk','kondisi_tajuk.id_pengukuran','foto_tajuk.title','foto_tajuk.keterangan','foto_tajuk.filename')
      ->orderBy('foto_tajuk.id_foto_tajuk','desc')
      ->get();

        return view('auditor.vitalitas.kondisi_tajuk',[
          'id'=>$id,
          'data_pengukuran'=>$data_pengukuran,
          'data_pohon'=>$data_pohon,
          'data_pohon_import' => $data_pohon_import,
          'id_plot' => $id_plot,
          'id_klaster' => $id_klaster_plot,
          'pengukuran_ke' => $pengukuran_ke,
          'master_pohon' => $master_pohon,
          'koor_bt_ful_p'=>$koor_bt_ful_p,
          'koor_ls_ful_p'=>$koor_ls_ful_p,
          'ket_bujur_p'=>$ket_bujur_p,
          'ket_lintang_p'=>$ket_lintang_p,
          'id_pengukuran' => $id_plots,
          'nama_plots' => $nama_plots,

          'data_foto_pengukuran' => $data_foto_pengukuran,
        ]);
    }

    public function vit(Request $req)
    {
      $id=$req->input('pengukuranke');
      $id_plot_p =  $req->input('nama_plot');
      $param=$req->nama_parameter;
      if($param==2){
        $data_pengukuran=DB::table('pengukuran_master')
        ->leftjoin('tbl_plot','tbl_plot.id_plot','=','pengukuran_master.id_plot')
        ->leftjoin('tbl_klaster_plot','tbl_klaster_plot.id_klaster_plot','tbl_plot.id_klaster_plot')
        ->leftjoin('pola_tanam','pola_tanam.id_pola_tanam','=','tbl_klaster_plot.pola_tanam')
        ->where('pengukuran_master.id_plot','=',$id_plot_p)
        ->where('pengukuran_master.pengukuran_ke','=',$id)
        ->first();

        $id_plot = $data_pengukuran->id_plot;
        $id_klaster=DB::table('tbl_plot')->select('id_klaster_plot')
        ->where('id_plot','=',$id_plot)
        ->first();
        $id_klaster_plot=$id_klaster->id_klaster_plot;
        $pengukuran_ke=$data_pengukuran->pengukuran_ke;
        $id_pengukuran = $data_pengukuran->id_pengukuran;

        $id_semua_plot = DB::table('tbl_klaster_plot')
        ->join('tbl_plot','tbl_plot.id_klaster_plot','=','tbl_klaster_plot.id_klaster_plot')
        ->join('pengukuran_master','pengukuran_master.id_plot','=','tbl_plot.id_plot')
        ->where('pengukuran_master.pengukuran_ke','=',$pengukuran_ke)
        ->where('tbl_klaster_plot.id_klaster_plot','=',$id_klaster_plot)
        ->get();
        for($i=0;$i<count($id_semua_plot);$i++){
          $id_plots[$i]=$id_semua_plot[$i]->id_pengukuran;
          $nama_plots[$i]=$id_semua_plot[$i]->nama_plot;
        }

        $data_pohon=DB::table('pengukuran_master')
        ->join('data_tanaman_plot',
               'data_tanaman_plot.id_plot','=','pengukuran_master.id_plot'
               )
        ->join(
          'table_master_jenis_tanaman',
          'table_master_jenis_tanaman.id_jenis_tanaman','=','data_tanaman_plot.id_master_jenis_tanaman'
          )
        ->leftjoin(
          'kondisi_tajuk',
          'data_tanaman_plot.id_tanaman_plot','=','kondisi_tajuk.id_tanaman'
          )
        ->where('pengukuran_master.id_pengukuran','=',$id_pengukuran)
        ->where('data_tanaman_plot.pengukuran_ke','=',$pengukuran_ke)
        ->get();

        $data_pohon_import=DB::table('kondisi_tajuk')
        ->where('id_pengukuran','=',$id_pengukuran)
        ->get();

        $master_pohon = DB::table('table_master_jenis_tanaman')->orderBy('nama_tanaman','asc')->get();

        $koordinat_bujur_p=$data_pengukuran->koordinat_BT;
      $splitName_p = explode(' ', $koordinat_bujur_p, 2);
      $splitName2_p= explode(' ', $splitName_p[1], 2);
      $splitName3_p= explode(' ', $splitName2_p[1], 2);
      if($splitName_p[0]>=0){
        $ket_bujur_p='BT';
      }
      else{
        $ket_bujur_p='BB';
        $splitName_p[0]=$splitName_p[0]*-1;
      }
      $koor_bt_ful_p=$splitName_p[0].' ᴼ '.$splitName2_p[0].' ’ '.$splitName3_p[0].' ”';

      $koordinat_lintang_p=$data_pengukuran->koordinat_LS;
      $l_splitName_p = explode(' ', $koordinat_lintang_p, 2);
      $l_splitName2_p= explode(' ', $l_splitName_p[1], 2);
      $l_splitName3_p= explode(' ', $l_splitName2_p[1], 2);
      if($l_splitName_p[0]>=0){
        $ket_lintang_p='LU';
      }
      else{
        $ket_lintang_p='LS';
        $l_splitName_p[0]=$l_splitName_p[0]*-1;
      }
      $koor_ls_ful_p=$l_splitName_p[0].' ᴼ '.$l_splitName2_p[0].' ’ '.$l_splitName3_p[0].' ”';

      $data_foto_pengukuran = DB::table('foto_tajuk')
      ->select('id_foto_tajuk','title','keterangan','filename')
      ->join('kondisi_tajuk','kondisi_tajuk.id_pengukuran','=','foto_tajuk.id_pengukuran')
      ->where('kondisi_tajuk.id_pengukuran','=',$data_pengukuran->id_pengukuran)
      ->groupBy('foto_tajuk.id_foto_tajuk','kondisi_tajuk.id_pengukuran','foto_tajuk.title','foto_tajuk.keterangan','foto_tajuk.filename')
      ->orderBy('foto_tajuk.id_foto_tajuk','desc')
      ->get();

        return view('auditor.vitalitas.kondisi_tajuk',[
          'id'=>$id_pengukuran,
          'data_pengukuran'=>$data_pengukuran,
          'data_pohon'=>$data_pohon,
          'data_pohon_import'=>$data_pohon_import,
          'id_plot' => $id_plot,
          'id_klaster' => $id_klaster_plot,
          'pengukuran_ke' => $pengukuran_ke,
          'master_pohon' => $master_pohon,
          'koor_bt_ful_p'=>$koor_bt_ful_p,
          'koor_ls_ful_p'=>$koor_ls_ful_p,
          'ket_bujur_p'=>$ket_bujur_p,
          'ket_lintang_p'=>$ket_lintang_p,
          'id_pengukuran' => $id_plots,
          'nama_plots' => $nama_plots,

          'data_foto_pengukuran' => $data_foto_pengukuran
        ]);
      }
      else if($param==1){
        $data_pengukuran=DB::table('pengukuran_master')
        ->leftjoin('tbl_plot','tbl_plot.id_plot','=','pengukuran_master.id_plot')
        ->leftjoin('tbl_klaster_plot','tbl_klaster_plot.id_klaster_plot','tbl_plot.id_klaster_plot')
        ->leftjoin('pola_tanam','pola_tanam.id_pola_tanam','=','tbl_klaster_plot.pola_tanam')
        ->where('pengukuran_master.id_plot','=',$id_plot_p)
        ->where('pengukuran_master.pengukuran_ke','=',$id)
        ->first();

        $id_plot = $data_pengukuran->id_plot;
        $id_klaster=DB::table('tbl_plot')->select('id_klaster_plot')
        ->where('id_plot','=',$id_plot)
        ->first();
        $id_klaster_plot=$id_klaster->id_klaster_plot;
        $pengukuran_ke=$data_pengukuran->pengukuran_ke;
        $id_pengukuran = $data_pengukuran->id_pengukuran;

        $id_semua_plot = DB::table('tbl_klaster_plot')
        ->join('tbl_plot','tbl_plot.id_klaster_plot','=','tbl_klaster_plot.id_klaster_plot')
        ->join('pengukuran_master','pengukuran_master.id_plot','=','tbl_plot.id_plot')
        ->where('pengukuran_master.pengukuran_ke','=',$pengukuran_ke)
        ->where('tbl_klaster_plot.id_klaster_plot','=',$id_klaster_plot)
        ->get();
        for($i=0;$i<count($id_semua_plot);$i++){
          $id_plots[$i]=$id_semua_plot[$i]->id_pengukuran;
          $nama_plots[$i]=$id_semua_plot[$i]->nama_plot;
        }

        $kode_kerusakan_lokasi=DB::table('kode_kerusakan_lokasi')
        ->get();

        $data_pohon=DB::table('pengukuran_master')
        ->join('data_tanaman_plot',
               'data_tanaman_plot.id_plot','=','pengukuran_master.id_plot'
               )
        ->join(
          'table_master_jenis_tanaman',
          'table_master_jenis_tanaman.id_jenis_tanaman','=','data_tanaman_plot.id_master_jenis_tanaman'
          )
        ->leftjoin(
          'kerusakan_pohon',
          'data_tanaman_plot.id_tanaman_plot','=','kerusakan_pohon.id_tanaman'
          )
        ->where('pengukuran_master.id_pengukuran','=',$id_pengukuran)
        ->where('data_tanaman_plot.pengukuran_ke','=',$pengukuran_ke)
        ->get();

        $data_pohon_import=DB::table('kerusakan_pohon')
        ->where('id_pengukuran','=',$id_pengukuran)
        ->get();

        $master_pohon = DB::table('table_master_jenis_tanaman')->orderBy('nama_tanaman','asc')->get();

        $koordinat_bujur_p=$data_pengukuran->koordinat_BT;
      $splitName_p = explode(' ', $koordinat_bujur_p, 2);
      $splitName2_p= explode(' ', $splitName_p[1], 2);
      $splitName3_p= explode(' ', $splitName2_p[1], 2);
      if($splitName_p[0]>=0){
        $ket_bujur_p='BT';
      }
      else{
        $ket_bujur_p='BB';
        $splitName_p[0]=$splitName_p[0]*-1;
      }
      $koor_bt_ful_p=$splitName_p[0].' ᴼ '.$splitName2_p[0].' ’ '.$splitName3_p[0].' ”';

      $koordinat_lintang_p=$data_pengukuran->koordinat_LS;
      $l_splitName_p = explode(' ', $koordinat_lintang_p, 2);
      $l_splitName2_p= explode(' ', $l_splitName_p[1], 2);
      $l_splitName3_p= explode(' ', $l_splitName2_p[1], 2);
      if($l_splitName_p[0]>=0){
        $ket_lintang_p='LU';
      }
      else{
        $ket_lintang_p='LS';
        $l_splitName_p[0]=$l_splitName_p[0]*-1;
      }
      $koor_ls_ful_p=$l_splitName_p[0].' ᴼ '.$l_splitName2_p[0].' ’ '.$l_splitName3_p[0].' ”';

      $data_foto_pengukuran = DB::table('foto_kerusakan')
      ->select('id_foto_kerusakan','title','keterangan','filename')
      ->join('kerusakan_pohon','kerusakan_pohon.id_pengukuran','=','foto_kerusakan.id_pengukuran')
      ->where('kerusakan_pohon.id_pengukuran','=',$data_pengukuran->id_pengukuran)
      ->groupBy('foto_kerusakan.id_foto_kerusakan','kerusakan_pohon.id_pengukuran','foto_kerusakan.title','foto_kerusakan.keterangan','foto_kerusakan.filename')
      ->orderBy('foto_kerusakan.id_foto_kerusakan','desc')
      ->get();

        return view('auditor.vitalitas.kerusakan',[
          'id'=>$id_pengukuran,
          'data_pengukuran'=>$data_pengukuran,
          'data_pohon'=>$data_pohon,
          'data_pohon_import'=>$data_pohon_import,
          'kode_lokasi'=>$kode_kerusakan_lokasi,
          'id_plot' => $id_plot,
          'id_klaster' => $id_klaster_plot,
          'pengukuran_ke' => $pengukuran_ke,
          'master_pohon' => $master_pohon,
          'koor_bt_ful_p'=>$koor_bt_ful_p,
          'koor_ls_ful_p'=>$koor_ls_ful_p,
          'ket_bujur_p'=>$ket_bujur_p,
          'ket_lintang_p'=>$ket_lintang_p,
          'id_pengukuran' => $id_plots,
          'nama_plots' => $nama_plots,

          'data_foto_pengukuran' => $data_foto_pengukuran,
        ]);
      }

    }

    public function kimia($id)
    {
      $id=decrypt($id);
        $data_pengukuran=DB::table('pengukuran_master')
        ->leftjoin('tbl_plot','tbl_plot.id_plot','=','pengukuran_master.id_plot')
        ->leftjoin('tbl_klaster_plot','tbl_klaster_plot.id_klaster_plot','tbl_plot.id_klaster_plot')
        ->leftjoin('pola_tanam','pola_tanam.id_pola_tanam','=','tbl_klaster_plot.pola_tanam')
        ->where('pengukuran_master.id_pengukuran','=',$id)
        ->first();
        //
        $id_plot = $data_pengukuran->id_plot;
        $id_klaster=DB::table('tbl_plot')->select('tbl_klaster_plot.id_klaster_plot','tbl_klaster_plot.nama_klaster')
        ->join('tbl_klaster_plot','tbl_klaster_plot.id_klaster_plot','=','tbl_plot.id_klaster_plot')
        ->where('tbl_plot.id_plot','=',$id_plot)
        ->first();
        $id_klaster_plot=$id_klaster->id_klaster_plot;
        $pengukuran_ke=$data_pengukuran->pengukuran_ke;

        $id_semua_plot = DB::table('tbl_klaster_plot')
        ->join('tbl_plot','tbl_plot.id_klaster_plot','=','tbl_klaster_plot.id_klaster_plot')
        ->join('pengukuran_master','pengukuran_master.id_plot','=','tbl_plot.id_plot')
        ->where('pengukuran_master.pengukuran_ke','=',$pengukuran_ke)
        ->where('tbl_klaster_plot.id_klaster_plot','=',$id_klaster_plot)
        ->get();
        for($i=0;$i<count($id_semua_plot);$i++){
          $id_plots[$i]=$id_semua_plot[$i]->id_pengukuran;
          $nama_plots[$i]=$id_semua_plot[$i]->nama_plot;
        }
        //
        $parameter_kimia = DB::table('tbl_sifat_kimia_tanah')->orderBy('sifat_kimia')->get();

        $data_ktk_kimia= DB::table('ktk_kimia')
        ->join('tbl_klaster_plot','tbl_klaster_plot.id_klaster_plot','=','ktk_kimia.kode_klaster')
        ->join('tbl_sifat_kimia_tanah','tbl_sifat_kimia_tanah.id_parameter_kimia','=','ktk_kimia.id_sifat')
        ->where('kode_klaster','=',$id_klaster_plot)
        ->where('pengukuran_ke','=',$pengukuran_ke)
        ->get();

        $koordinat_bujur_p=$data_pengukuran->koordinat_BT;
      $splitName_p = explode(' ', $koordinat_bujur_p, 2);
      $splitName2_p= explode(' ', $splitName_p[1], 2);
      $splitName3_p= explode(' ', $splitName2_p[1], 2);
      if($splitName_p[0]>=0){
        $ket_bujur_p='BT';
      }
      else{
        $ket_bujur_p='BB';
        $splitName_p[0]=$splitName_p[0]*-1;
      }
      $koor_bt_ful_p=$splitName_p[0].' ᴼ '.$splitName2_p[0].' ’ '.$splitName3_p[0].' ”';

      $koordinat_lintang_p=$data_pengukuran->koordinat_LS;
      $l_splitName_p = explode(' ', $koordinat_lintang_p, 2);
      $l_splitName2_p= explode(' ', $l_splitName_p[1], 2);
      $l_splitName3_p= explode(' ', $l_splitName2_p[1], 2);
      if($l_splitName_p[0]>=0){
        $ket_lintang_p='LU';
      }
      else{
        $ket_lintang_p='LS';
        $l_splitName_p[0]=$l_splitName_p[0]*-1;
      }
      $koor_ls_ful_p=$l_splitName_p[0].' ᴼ '.$l_splitName2_p[0].' ’ '.$l_splitName3_p[0].' ”';

        return view('auditor.ktk.kimia',[
          'id'=>$id,
          'data_pengukuran'=>$data_pengukuran,
          'id_plot' => $id_plot,
          'kode_klaster' => $id_klaster,
          'id_klaster' => $id_klaster_plot,
          'pengukuran_ke' => $pengukuran_ke,
          'parameter_kimia'=>$parameter_kimia,
          'data_ktk_kimia' => $data_ktk_kimia,
          'koor_bt_ful_p'=>$koor_bt_ful_p,
          'koor_ls_ful_p'=>$koor_ls_ful_p,
          'ket_bujur_p'=>$ket_bujur_p,
          'ket_lintang_p'=>$ket_lintang_p,
          'id_pengukuran' => $id_plots,
          'nama_plots' => $nama_plots,
        ]);
    }

    public function fisika($id)
    {
      $id=decrypt($id);
        $data_pengukuran=DB::table('pengukuran_master')
        ->leftjoin('tbl_plot','tbl_plot.id_plot','=','pengukuran_master.id_plot')
        ->leftjoin('tbl_klaster_plot','tbl_klaster_plot.id_klaster_plot','tbl_plot.id_klaster_plot')
        ->leftjoin('pola_tanam','pola_tanam.id_pola_tanam','=','tbl_klaster_plot.pola_tanam')
        ->where('pengukuran_master.id_pengukuran','=',$id)
        ->first();
        //
        $id_plot = $data_pengukuran->id_plot;
        $id_klaster=DB::table('tbl_plot')->select('tbl_klaster_plot.id_klaster_plot','tbl_klaster_plot.nama_klaster')
        ->join('tbl_klaster_plot','tbl_klaster_plot.id_klaster_plot','=','tbl_plot.id_klaster_plot')
        ->where('tbl_plot.id_plot','=',$id_plot)
        ->first();
        $id_klaster_plot=$id_klaster->id_klaster_plot;
        $pengukuran_ke=$data_pengukuran->pengukuran_ke;
        $id_pengukuran = $data_pengukuran->id_pengukuran;

        $id_semua_plot = DB::table('tbl_klaster_plot')
        ->join('tbl_plot','tbl_plot.id_klaster_plot','=','tbl_klaster_plot.id_klaster_plot')
        ->join('pengukuran_master','pengukuran_master.id_plot','=','tbl_plot.id_plot')
        ->where('pengukuran_master.pengukuran_ke','=',$pengukuran_ke)
        ->where('tbl_klaster_plot.id_klaster_plot','=',$id_klaster_plot)
        ->get();
        for($i=0;$i<count($id_semua_plot);$i++){
          $id_plots[$i]=$id_semua_plot[$i]->id_pengukuran;
          $nama_plots[$i]=$id_semua_plot[$i]->nama_plot;
        }
        //

        $koordinat_bujur_p=$data_pengukuran->koordinat_BT;
      $splitName_p = explode(' ', $koordinat_bujur_p, 2);
      $splitName2_p= explode(' ', $splitName_p[1], 2);
      $splitName3_p= explode(' ', $splitName2_p[1], 2);
      if($splitName_p[0]>=0){
        $ket_bujur_p='BT';
      }
      else{
        $ket_bujur_p='BB';
        $splitName_p[0]=$splitName_p[0]*-1;
      }
      $koor_bt_ful_p=$splitName_p[0].' ᴼ '.$splitName2_p[0].' ’ '.$splitName3_p[0].' ”';

      $koordinat_lintang_p=$data_pengukuran->koordinat_LS;
      $l_splitName_p = explode(' ', $koordinat_lintang_p, 2);
      $l_splitName2_p= explode(' ', $l_splitName_p[1], 2);
      $l_splitName3_p= explode(' ', $l_splitName2_p[1], 2);
      if($l_splitName_p[0]>=0){
        $ket_lintang_p='LU';
      }
      else{
        $ket_lintang_p='LS';
        $l_splitName_p[0]=$l_splitName_p[0]*-1;
      }
      $koor_ls_ful_p=$l_splitName_p[0].' ᴼ '.$l_splitName2_p[0].' ’ '.$l_splitName3_p[0].' ”';

        $data_fisik=DB::table('pengukuran_master')
        ->join(
          'ktk_fisika',
          'ktk_fisika.kode_plot','=','pengukuran_master.id_plot'
          )
        ->where('pengukuran_master.id_pengukuran','=',$id_pengukuran)
        ->where('ktk_fisika.pengukuran_ke','=',$pengukuran_ke)
        ->get();

        if(count($data_fisik)>0){
          $koordinat_bujur_pt=$data_fisik[0]->bujur_tanah;
        $splitName_p = explode(' ', $koordinat_bujur_pt, 2);
        $splitName2_p= explode(' ', $splitName_p[1], 2);
        $splitName3_p= explode(' ', $splitName2_p[1], 2);
        if($splitName_p[0]>=0){
          $ket_bujur_pt='BT';
        }
        else{
          $ket_bujur_pt='BB';
          $splitName_p[0]=$splitName_p[0]*-1;
        }
        $koor_bt_ful_pt=$splitName_p[0].' ᴼ '.$splitName2_p[0].' ’ '.$splitName3_p[0].' ”';

        $koordinat_lintang_pt=$data_fisik[0]->lintang_tanah;
        $l_splitName_p = explode(' ', $koordinat_lintang_pt, 2);
        $l_splitName2_p= explode(' ', $l_splitName_p[1], 2);
        $l_splitName3_p= explode(' ', $l_splitName2_p[1], 2);
        if($l_splitName_p[0]>=0){
          $ket_lintang_pt='LU';
        }
        else{
          $ket_lintang_pt='LS';
          $l_splitName_p[0]=$l_splitName_p[0]*-1;
        }
        $koor_ls_ful_pt=$l_splitName_p[0].' ᴼ '.$l_splitName2_p[0].' ’ '.$l_splitName3_p[0].' ”';
        }
        else{
          $koor_bt_ful_pt=0;
          $koor_ls_ful_pt=0;
          $ket_lintang_pt="";
          $ket_bujur_pt="";
        }

        $data_foto_pengukuran = DB::table('foto_ktk')
        ->select('id_foto_ktk','title','keterangan','filename')
        ->join('ktk_fisika','ktk_fisika.kode_plot','=','foto_ktk.kode_plot')
        ->where('ktk_fisika.kode_plot','=',$id_plot)
        ->groupBy('foto_ktk.id_foto_ktk','ktk_fisika.kode_plot','foto_ktk.title','foto_ktk.keterangan','foto_ktk.filename')
        ->orderBy('foto_ktk.id_foto_ktk','desc')
        ->get();

        return view('auditor.ktk.fisika',[
          'id'=>$id,
          'data_fisik' => $data_fisik,
          'data_pengukuran'=>$data_pengukuran,
          'id_plot' => $id_plot,
          'kode_klaster' => $id_klaster,
          'id_klaster' => $id_klaster_plot,
          'pengukuran_ke' => $pengukuran_ke,
          'koor_bt_ful_p'=>$koor_bt_ful_p,
          'koor_ls_ful_p'=>$koor_ls_ful_p,
          'ket_bujur_p'=>$ket_bujur_p,
          'ket_lintang_p'=>$ket_lintang_p,
          'koor_bt_ful_pt'=>$koor_bt_ful_pt,
          'koor_ls_ful_pt'=>$koor_ls_ful_pt,
          'ket_bujur_pt'=>$ket_bujur_pt,
          'ket_lintang_pt'=>$ket_lintang_pt,
          'id_pengukuran' => $id_plots,
          'nama_plots' => $nama_plots,

          'data_foto_pengukuran' => $data_foto_pengukuran,
        ]);
    }

    public function ktk(Request $req)
    {
      $id=$req->input('pengukuranke');
      $id_plot_p =  $req->input('nama_plot');
      $param=$req->input('nama_parameter');
      if($param==2){
        $data_pengukuran=DB::table('pengukuran_master')
        ->leftjoin('tbl_plot','tbl_plot.id_plot','=','pengukuran_master.id_plot')
        ->leftjoin('tbl_klaster_plot','tbl_klaster_plot.id_klaster_plot','tbl_plot.id_klaster_plot')
        ->leftjoin('pola_tanam','pola_tanam.id_pola_tanam','=','tbl_klaster_plot.pola_tanam')
        ->where('pengukuran_master.id_plot','=',$id_plot_p)
        ->where('pengukuran_master.pengukuran_ke','=',$id)
        ->first();
        //
        $id_plot = $data_pengukuran->id_plot;
        $id_klaster=DB::table('tbl_plot')->select('tbl_klaster_plot.id_klaster_plot','tbl_klaster_plot.nama_klaster')
        ->join('tbl_klaster_plot','tbl_klaster_plot.id_klaster_plot','=','tbl_plot.id_klaster_plot')
        ->where('tbl_plot.id_plot','=',$id_plot)
        ->first();
        $id_klaster_plot=$id_klaster->id_klaster_plot;
        $pengukuran_ke=$data_pengukuran->pengukuran_ke;
        $id_pengukuran = $data_pengukuran->id_pengukuran;
        //

        $id_semua_plot = DB::table('tbl_klaster_plot')
        ->join('tbl_plot','tbl_plot.id_klaster_plot','=','tbl_klaster_plot.id_klaster_plot')
        ->join('pengukuran_master','pengukuran_master.id_plot','=','tbl_plot.id_plot')
        ->where('pengukuran_master.pengukuran_ke','=',$pengukuran_ke)
        ->where('tbl_klaster_plot.id_klaster_plot','=',$id_klaster_plot)
        ->get();
        for($i=0;$i<count($id_semua_plot);$i++){
          $id_plots[$i]=$id_semua_plot[$i]->id_pengukuran;
          $nama_plots[$i]=$id_semua_plot[$i]->nama_plot;
        }

        $parameter_kimia = DB::table('tbl_sifat_kimia_tanah')->orderBy('sifat_kimia')->get();

        $data_ktk_kimia= DB::table('ktk_kimia')
        ->join('tbl_klaster_plot','tbl_klaster_plot.id_klaster_plot','=','ktk_kimia.kode_klaster')
        ->join('tbl_sifat_kimia_tanah','tbl_sifat_kimia_tanah.id_parameter_kimia','=','ktk_kimia.id_sifat')
        ->where('kode_klaster','=',$id_klaster_plot)
        ->where('pengukuran_ke','=',$pengukuran_ke)
        ->get();

        $koordinat_bujur_p=$data_pengukuran->koordinat_BT;
      $splitName_p = explode(' ', $koordinat_bujur_p, 2);
      $splitName2_p= explode(' ', $splitName_p[1], 2);
      $splitName3_p= explode(' ', $splitName2_p[1], 2);
      if($splitName_p[0]>=0){
        $ket_bujur_p='BT';
      }
      else{
        $ket_bujur_p='BB';
        $splitName_p[0]=$splitName_p[0]*-1;
      }
      $koor_bt_ful_p=$splitName_p[0].' ᴼ '.$splitName2_p[0].' ’ '.$splitName3_p[0].' ”';

      $koordinat_lintang_p=$data_pengukuran->koordinat_LS;
      $l_splitName_p = explode(' ', $koordinat_lintang_p, 2);
      $l_splitName2_p= explode(' ', $l_splitName_p[1], 2);
      $l_splitName3_p= explode(' ', $l_splitName2_p[1], 2);
      if($l_splitName_p[0]>=0){
        $ket_lintang_p='LU';
      }
      else{
        $ket_lintang_p='LS';
        $l_splitName_p[0]=$l_splitName_p[0]*-1;
      }
      $koor_ls_ful_p=$l_splitName_p[0].' ᴼ '.$l_splitName2_p[0].' ’ '.$l_splitName3_p[0].' ”';

        return view('auditor.ktk.kimia',[
          'id'=>$id_pengukuran,
          'data_pengukuran'=>$data_pengukuran,
          'id_plot' => $id_plot,
          'kode_klaster' => $id_klaster,
          'id_klaster' => $id_klaster_plot,
          'pengukuran_ke' => $pengukuran_ke,
          'parameter_kimia'=>$parameter_kimia,
          'data_ktk_kimia' => $data_ktk_kimia,
          'koor_bt_ful_p'=>$koor_bt_ful_p,
          'koor_ls_ful_p'=>$koor_ls_ful_p,
          'ket_bujur_p'=>$ket_bujur_p,
          'ket_lintang_p'=>$ket_lintang_p,
          'id_pengukuran' => $id_plots,
          'nama_plots' => $nama_plots,
        ]);
      }

      else if($param==1){
        $data_pengukuran=DB::table('pengukuran_master')
        ->leftjoin('tbl_plot','tbl_plot.id_plot','=','pengukuran_master.id_plot')
        ->leftjoin('tbl_klaster_plot','tbl_klaster_plot.id_klaster_plot','tbl_plot.id_klaster_plot')
        ->leftjoin('pola_tanam','pola_tanam.id_pola_tanam','=','tbl_klaster_plot.pola_tanam')
        ->where('pengukuran_master.id_plot','=',$id_plot_p)
        ->where('pengukuran_master.pengukuran_ke','=',$id)
        ->first();
        //
        $id_plot = $data_pengukuran->id_plot;
        $id_klaster=DB::table('tbl_plot')->select('tbl_klaster_plot.id_klaster_plot','tbl_klaster_plot.nama_klaster')
        ->join('tbl_klaster_plot','tbl_klaster_plot.id_klaster_plot','=','tbl_plot.id_klaster_plot')
        ->where('tbl_plot.id_plot','=',$id_plot)
        ->first();
        $id_klaster_plot=$id_klaster->id_klaster_plot;
        $pengukuran_ke=$data_pengukuran->pengukuran_ke;
        $id_pengukuran = $data_pengukuran->id_pengukuran;
        //

        $id_semua_plot = DB::table('tbl_klaster_plot')
        ->join('tbl_plot','tbl_plot.id_klaster_plot','=','tbl_klaster_plot.id_klaster_plot')
        ->join('pengukuran_master','pengukuran_master.id_plot','=','tbl_plot.id_plot')
        ->where('pengukuran_master.pengukuran_ke','=',$pengukuran_ke)
        ->where('tbl_klaster_plot.id_klaster_plot','=',$id_klaster_plot)
        ->get();
        for($i=0;$i<count($id_semua_plot);$i++){
          $id_plots[$i]=$id_semua_plot[$i]->id_pengukuran;
          $nama_plots[$i]=$id_semua_plot[$i]->nama_plot;
        }

        $koordinat_bujur_p=$data_pengukuran->koordinat_BT;
      $splitName_p = explode(' ', $koordinat_bujur_p, 2);
      $splitName2_p= explode(' ', $splitName_p[1], 2);
      $splitName3_p= explode(' ', $splitName2_p[1], 2);
      if($splitName_p[0]>=0){
        $ket_bujur_p='BT';
      }
      else{
        $ket_bujur_p='BB';
        $splitName_p[0]=$splitName_p[0]*-1;
      }
      $koor_bt_ful_p=$splitName_p[0].' ᴼ '.$splitName2_p[0].' ’ '.$splitName3_p[0].' ”';

      $koordinat_lintang_p=$data_pengukuran->koordinat_LS;
      $l_splitName_p = explode(' ', $koordinat_lintang_p, 2);
      $l_splitName2_p= explode(' ', $l_splitName_p[1], 2);
      $l_splitName3_p= explode(' ', $l_splitName2_p[1], 2);
      if($l_splitName_p[0]>=0){
        $ket_lintang_p='LU';
      }
      else{
        $ket_lintang_p='LS';
        $l_splitName_p[0]=$l_splitName_p[0]*-1;
      }
      $koor_ls_ful_p=$l_splitName_p[0].' ᴼ '.$l_splitName2_p[0].' ’ '.$l_splitName3_p[0].' ”';

        $data_fisik=DB::table('pengukuran_master')
        ->join(
          'ktk_fisika',
          'ktk_fisika.kode_plot','=','pengukuran_master.id_plot'
          )
          ->where('pengukuran_master.id_pengukuran','=',$id_pengukuran)
          ->where('ktk_fisika.pengukuran_ke','=',$pengukuran_ke)
        ->get();

        if(count($data_fisik)>0){
          $koordinat_bujur_pt=$data_fisik[0]->bujur_tanah;
        $splitName_p = explode(' ', $koordinat_bujur_pt, 2);
        $splitName2_p= explode(' ', $splitName_p[1], 2);
        $splitName3_p= explode(' ', $splitName2_p[1], 2);
        if($splitName_p[0]>=0){
          $ket_bujur_pt='BT';
        }
        else{
          $ket_bujur_pt='BB';
          $splitName_p[0]=$splitName_p[0]*-1;
        }
        $koor_bt_ful_pt=$splitName_p[0].' ᴼ '.$splitName2_p[0].' ’ '.$splitName3_p[0].' ”';

        $koordinat_lintang_pt=$data_fisik[0]->lintang_tanah;
        $l_splitName_p = explode(' ', $koordinat_lintang_pt, 2);
        $l_splitName2_p= explode(' ', $l_splitName_p[1], 2);
        $l_splitName3_p= explode(' ', $l_splitName2_p[1], 2);
        if($l_splitName_p[0]>=0){
          $ket_lintang_pt='LU';
        }
        else{
          $ket_lintang_pt='LS';
          $l_splitName_p[0]=$l_splitName_p[0]*-1;
        }
        $koor_ls_ful_pt=$l_splitName_p[0].' ᴼ '.$l_splitName2_p[0].' ’ '.$l_splitName3_p[0].' ”';
        }
        else{
          $koor_bt_ful_pt=0;
          $koor_ls_ful_pt=0;
          $ket_lintang_pt="";
          $ket_bujur_pt="";
        }

        $data_foto_pengukuran = DB::table('foto_ktk')
        ->select('id_foto_ktk','title','keterangan','filename')
        ->join('ktk_fisika','ktk_fisika.kode_plot','=','foto_ktk.kode_plot')
        ->where('ktk_fisika.kode_plot','=',$id_plot)
        ->groupBy('foto_ktk.id_foto_ktk','ktk_fisika.kode_plot','foto_ktk.title','foto_ktk.keterangan','foto_ktk.filename')
        ->orderBy('foto_ktk.id_foto_ktk','desc')
        ->get();

        return view('auditor.ktk.fisika',[
          'id'=>$id_pengukuran,
          'data_fisik' => $data_fisik,
          'data_pengukuran'=>$data_pengukuran,
          'id_plot' => $id_plot,
          'kode_klaster' => $id_klaster,
          'id_klaster' => $id_klaster_plot,
          'pengukuran_ke' => $pengukuran_ke,
          'koor_bt_ful_p'=>$koor_bt_ful_p,
          'koor_ls_ful_p'=>$koor_ls_ful_p,
          'ket_bujur_p'=>$ket_bujur_p,
          'ket_lintang_p'=>$ket_lintang_p,
          'koor_bt_ful_pt'=>$koor_bt_ful_pt,
          'koor_ls_ful_pt'=>$koor_ls_ful_pt,
          'ket_bujur_pt'=>$ket_bujur_pt,
          'ket_lintang_pt'=>$ket_lintang_pt,
          'id_pengukuran' => $id_plots,
          'nama_plots' => $nama_plots,

          'data_foto_pengukuran' => $data_foto_pengukuran,
        ]);
      }

    }

    public function delete_kerusakan(Request $req){
      try{
        $id = $req->hapus_id;
        DB::table('kerusakan_pohon')->where('id', $id)->delete();
        session()->flash('delete', 'Data berhasil dihapus.');

      }
      catch(\Illuminate\Database\QueryException $e){
        throw new CustomException($e->getMessage());
      }
      return back();
    }

    public function delete_kerusakan_all(Request $req){
      try{
        $id = $req->hapus_id_all;
        DB::table('kerusakan_pohon')->where('id_pengukuran', $id)->delete();
        session()->flash('delete', 'Semua data berhasil dihapus.');

      }
      catch(\Illuminate\Database\QueryException $e){
        throw new CustomException($e->getMessage());
      }
      return back();
    }

    public function delete_tajuk(Request $req){
      try{
        $id = $req->hapus_id;
        DB::table('kondisi_tajuk')->where('id', $id)->delete();
        session()->flash('delete', 'Data berhasil dihapus.');

      }
      catch(\Illuminate\Database\QueryException $e){
        throw new CustomException($e->getMessage());
      }
      return back();
    }

    public function delete_tajuk_all(Request $req){
      try{
        $id = $req->hapus_id_all;
        DB::table('kondisi_tajuk')->where('id_pengukuran', $id)->delete();
        session()->flash('delete', 'Semua data berhasil dihapus.');

      }
      catch(\Illuminate\Database\QueryException $e){
        throw new CustomException($e->getMessage());
      }
      return back();
    }

    public function jsonFisik(Request $req){
      $id_ktk = $req->id;

      $sifat_fisik=DB::table('ktk_fisika')
      ->where('id_ktk','=',$id_ktk)->get();
      return response()->json($sifat_fisik);

    }
}
