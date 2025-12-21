<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Exceptions\CustomException;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use App\Provinsi;
use App\Kabupaten;
use App\Kecamatan;
use App\Desa;
use App\Kepemilikan;
use App\JenisPengelola;
use App\Jenis;
use App\Fungsi;
use App\Pola;
use Illuminate\Support\Facades\Auth;


class PengukuranController extends Controller
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

    private function assertOwnsPlot($id_plot)
    {
      $owns = DB::table('tbl_plot')
        ->join('tbl_klaster_plot', 'tbl_klaster_plot.id_klaster_plot', '=', 'tbl_plot.id_klaster_plot')
        ->leftJoin('kategori_klaster', function ($join) {
          $join->on('kategori_klaster.id_data_klaster', '=', 'tbl_klaster_plot.id_data_klaster')
            ->orOn('kategori_klaster.id_data_klaster2', '=', 'tbl_klaster_plot.id_data_klaster');
        })
        ->where('tbl_plot.id_plot', $id_plot)
        ->where('kategori_klaster.input_by', Auth::id())
        ->exists();
      if (!$owns) {
        abort(403, 'Unauthorized');
      }
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $req)
    {
      $id_prov=$req->provinsi_home;
      $id_kab=$req->kabupaten_home;
      $id_kec=$req->kecamatan_home;
      $id_kepemilikan=$req->kepemilikan_home;
      $tipe_hutan=$req->tipe_hutan_home;
      $fungsi_hutan=$req->fungsi_hutan_home;

        // mengambil isi tabel klaster plot, hak milik jenis fungsi hutan, serta lokasi
        $data_klaster = DB::table('tbl_klaster_plot')
                    ->join(
                        'hak_milik_jenis_fungsi_hutan',
                        'hak_milik_jenis_fungsi_hutan.id_klaster_plot','=','tbl_klaster_plot.id_klaster_plot'
                    )
                    ->join(
                      'tbl_hak_milik',
                      'tbl_hak_milik.id_hak_milik','=','hak_milik_jenis_fungsi_hutan.id_hak_milik')
                    ->join(
                      'fungsi_hutan',
                      'fungsi_hutan.id_fungsi_hutan','=','hak_milik_jenis_fungsi_hutan.id_fungsi_hutan')
                    ->join(
                      'jenis_hutan',
                      'jenis_hutan.id_jenis_hutan','=','hak_milik_jenis_fungsi_hutan.id_jenis_hutan')
                    ->join(
                      'lokasi',
                      'lokasi.id_klaster_plot','=','tbl_klaster_plot.id_klaster_plot')
                    // ->join(
                    //   'desa',
                    //   'desa.id','=','lokasi.id_desa')
                    ->join(
                      'kecamatan',
                      'kecamatan.id','=','lokasi.id_kecamatan')
                    ->join(
                      'kabupaten',
                      'kabupaten.id','=','lokasi.id_kabupaten')
                     ->join(
                      'provinsi',
                      'provinsi.id_provinsi','=','lokasi.id_provinsi')
                     ->where([['lokasi.id_provinsi','like',$id_prov],['lokasi.id_kabupaten','like',$id_kab],['lokasi.id_kecamatan','like',$id_kec],['tbl_hak_milik.id_hak_milik','like',$id_kepemilikan],['fungsi_hutan.id_fungsi_hutan','like',$tipe_hutan],['input_by','=',Auth::User()->id]])
                    ->get();

        // variabel ini digunakan untuk mengembalikan nilai yang dipakai pada modal box
        // pada data pengukuran
        //-------------------------------------------
        $provinsi = Provinsi::all();
        $kepemilikan = Kepemilikan::all();
        $jenis = Jenis::all();
        $pola = Pola::all();
        $jenis_pengelola = JenisPengelola::all();
        //-------------------------------------------
        return view('user.data_pengukuran',compact('provinsi','kepemilikan','jenis','pola','jenis_pengelola'),[
          'data'=>$data_klaster,
        ]);
    }

    public function home(){
      $data_klaster = DB::table('tbl_data_klaster')
      ->where('input_by','=',Auth::user()->id)
      ->orderBy('nama_data_klaster')->get();

      return view('user.data_pengukuran.data_pengukuran_plot',compact('data_klaster'));
    }

    public function lihatpengukuran(Request $req){
      $id=$req->input('nama_plot');
      $this->assertOwnsPlot($id);
      $id_klaster=DB::table('tbl_plot')->select('id_klaster_plot')
      ->where('id_plot','=',$id)
      ->first();
      $id_klaster_plot=$id_klaster->id_klaster_plot;

      $id_semua_plot = DB::table('tbl_klaster_plot')
      ->join('tbl_plot','tbl_plot.id_klaster_plot','=','tbl_klaster_plot.id_klaster_plot')
      ->where('tbl_klaster_plot.id_klaster_plot','=',$id_klaster_plot)
      ->get();
      for($i=0;$i<count($id_semua_plot);$i++){
        $id_plots[$i]=$id_semua_plot[$i]->id_plot;
        $nama_plots[$i]=$id_semua_plot[$i]->nama_plot;
      }

      $data_pengukuran=DB::table('pengukuran_master')
      ->join('tbl_plot','tbl_plot.id_plot','=','pengukuran_master.id_plot')
      ->where('pengukuran_master.id_plot','=',$id)
      ->get();

      $data_id=DB::table('pengukuran_master')
      ->join('tbl_plot','tbl_plot.id_plot','=','pengukuran_master.id_plot')
      ->where('pengukuran_master.id_plot','=',$id)
      ->first();

      $nama_plot=DB::table('tbl_plot')
      ->join('tbl_klaster_plot','tbl_klaster_plot.id_klaster_plot','=','tbl_plot.id_klaster_plot')
      ->join('pola_tanam','pola_tanam.id_pola_tanam','=','tbl_klaster_plot.pola_tanam')
      ->where('id_plot','=',$id)
      ->first();

      $data_id_plot =DB::table('tbl_klaster_plot')
      ->select('id_plot')
      ->join('tbl_plot','tbl_plot.id_klaster_plot','=','tbl_klaster_plot.id_klaster_plot')
      ->where('tbl_plot.id_klaster_plot','=',$id_klaster_plot)
      ->get();

      for($i=0;$i<4;$i++){
        $id_plot[$i] = $data_id_plot[$i]->id_plot;
      }

      $jumlah_pengukuran = count($data_pengukuran);
      if($jumlah_pengukuran!=0)
      {
        for($k=0;$k<$jumlah_pengukuran;$k++){
          $pengukuran_ke = $data_pengukuran[$k]->pengukuran_ke;
          $id_pengukuran = $data_pengukuran[$k]->id_pengukuran;

          $data_tanaman_plot[] = DB::table('data_tanaman_plot')
          ->where('id_klaster_plot','=',$id_klaster_plot)
          ->where('id_plot','=',$id)
          ->where('pengukuran_ke','=',$pengukuran_ke)
          ->get();

          $cek_kerusakan[] = DB::table('kerusakan_pohon')
          ->where('id_pengukuran','=',$id_pengukuran)
          ->get();

          $cek_pertumbuhan[] = DB::table('lbds')
          ->where('id_pengukuran','=',$id_pengukuran)
          ->get();

          $cek_tajuk[] = DB::table('kondisi_tajuk')
          ->where('id_pengukuran','=',$id_pengukuran)
          ->get();
        }
        // dd($cek_kerusakan);
        for($k=0;$k<$jumlah_pengukuran;$k++){
          $jumlah_pohon_plot=count($data_tanaman_plot[$k]);
          $jumlah_kerusakan_pohon=count($cek_kerusakan[$k]);
          $jumlah_pertumbuhan_pohon=count($cek_pertumbuhan[$k]);
          $jumlah_tajuk_pohon=count($cek_tajuk[$k]);

          if($jumlah_pohon_plot==$jumlah_kerusakan_pohon){
              $kerusakan_lengkap[] = 1;
          }
          else{
              $kerusakan_lengkap[] = 0;
          }

          if($jumlah_pohon_plot==$jumlah_pertumbuhan_pohon){
              $pertumbuhan_lengkap[] = 1;
          }
          else{
              $pertumbuhan_lengkap[] = 0;
          }

          if($jumlah_pohon_plot==$jumlah_tajuk_pohon){
              $tajuk_lengkap[] = 1;
          }
          else{
              $tajuk_lengkap[] = 0;
          }

          if($jumlah_pohon_plot==$jumlah_kerusakan_pohon &&
             $jumlah_pohon_plot==$jumlah_pertumbuhan_pohon &&
             $jumlah_pohon_plot==$jumlah_tajuk_pohon){
              $status_lengkap[] = 1;
          }
          else{
              $status_lengkap[] = 0;
          }

        }
      }
      else{
        $status_lengkap[] = 0;
      }

      $koordinat_bujur_p=$nama_plot->koordinat_BT;
      if($koordinat_bujur_p==""){
        $koordinat_bujur_p = "000 00 00.00";
      }
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

      $koordinat_lintang_p=$nama_plot->koordinat_LS;
      if($koordinat_lintang_p==""){
        $koordinat_lintang_p = "00 00 00.00";
      }
      $l_splitName_p = explode(' ', $koordinat_lintang_p, 2);
      $l_splitName2_p= explode(' ', $l_splitName_p[1], 2);
      $l_splitName3_p= explode(' ', $l_splitName2_p[1], 2);
      if($l_splitName_p[0]>=0){
        $ket_lintang_p='LS';
      }
      else{
        $ket_lintang_p='LU';
        $l_splitName_p[0]=$l_splitName_p[0]*-1;
      }
      $koor_ls_ful_p=$l_splitName_p[0].' ᴼ '.$l_splitName2_p[0].' ’ '.$l_splitName3_p[0].' ”';$data_pengukuran=DB::table('pengukuran_master')
      ->join('tbl_plot','tbl_plot.id_plot','=','pengukuran_master.id_plot')
      ->where('pengukuran_master.id_plot','=',$id)
      ->get();

      $data_id=DB::table('pengukuran_master')
      ->join('tbl_plot','tbl_plot.id_plot','=','pengukuran_master.id_plot')
      ->where('pengukuran_master.id_plot','=',$id)
      ->first();

      return view('user.data_pengukuran.detail_data_pengukuran',[
        'koor_bt_ful_p'=>$koor_bt_ful_p,
        'koor_ls_ful_p'=>$koor_ls_ful_p,
        'ket_bujur_p'=>$ket_bujur_p,
        'ket_lintang_p'=>$ket_lintang_p,
        'jumlah_pengukuran'=>$jumlah_pengukuran,
        'data_pengukuran'=>$data_pengukuran,
        'data_id' =>$data_id,
        'nama_plot' =>$nama_plot,
        'id_plot' => $id,
        'id_plots' => $id_plots,
        'nama_plots' => $nama_plots,
        'data_id_plot' => $id_plot,
        'id_klaster' => $id_klaster_plot,
        'cek_status' => $status_lengkap,
      ]);
    }

    public function lihatpengukurans($id){
      $id=decrypt($id);
      $this->assertOwnsPlot($id);
      $id_klaster=DB::table('tbl_plot')->select('id_klaster_plot')
      ->where('id_plot','=',$id)
      ->first();
      $id_klaster_plot=$id_klaster->id_klaster_plot;

      $id_semua_plot = DB::table('tbl_klaster_plot')
      ->join('tbl_plot','tbl_plot.id_klaster_plot','=','tbl_klaster_plot.id_klaster_plot')
      ->where('tbl_klaster_plot.id_klaster_plot','=',$id_klaster_plot)
      ->get();
      for($i=0;$i<count($id_semua_plot);$i++){
        $id_plots[$i]=$id_semua_plot[$i]->id_plot;
        $nama_plots[$i]=$id_semua_plot[$i]->nama_plot;
      }

      $data_pengukuran=DB::table('pengukuran_master')
      ->join('tbl_plot','tbl_plot.id_plot','=','pengukuran_master.id_plot')
      ->where('pengukuran_master.id_plot','=',$id)
      ->get();

      $data_id=DB::table('pengukuran_master')
      ->join('tbl_plot','tbl_plot.id_plot','=','pengukuran_master.id_plot')
      ->where('pengukuran_master.id_plot','=',$id)
      ->first();

      $nama_plot=DB::table('tbl_plot')
      ->join('tbl_klaster_plot','tbl_klaster_plot.id_klaster_plot','=','tbl_plot.id_klaster_plot')
      ->join('pola_tanam','pola_tanam.id_pola_tanam','=','tbl_klaster_plot.pola_tanam')
      ->where('id_plot','=',$id)
      ->first();

      $data_id_plot =DB::table('tbl_klaster_plot')
      ->select('id_plot')
      ->join('tbl_plot','tbl_plot.id_klaster_plot','=','tbl_klaster_plot.id_klaster_plot')
      ->where('tbl_plot.id_klaster_plot','=',$id_klaster_plot)
      ->get();

      for($i=0;$i<4;$i++){
        $id_plot[$i] = $data_id_plot[$i]->id_plot;
      }

      $jumlah_pengukuran = count($data_pengukuran);
      if($jumlah_pengukuran!=0)
      {
        for($k=0;$k<$jumlah_pengukuran;$k++){
          $pengukuran_ke = $data_pengukuran[$k]->pengukuran_ke;
          $id_pengukuran = $data_pengukuran[$k]->id_pengukuran;

          $data_tanaman_plot[] = DB::table('data_tanaman_plot')
          ->where('id_klaster_plot','=',$id_klaster_plot)
          ->where('id_plot','=',$id)
          ->where('pengukuran_ke','=',$pengukuran_ke)
          ->get();

          $cek_kerusakan[] = DB::table('kerusakan_pohon')
          ->where('id_pengukuran','=',$id_pengukuran)
          ->get();

          $cek_pertumbuhan[] = DB::table('lbds')
          ->where('id_pengukuran','=',$id_pengukuran)
          ->get();

          $cek_tajuk[] = DB::table('kondisi_tajuk')
          ->where('id_pengukuran','=',$id_pengukuran)
          ->get();
        }
        // dd($cek_kerusakan);
        for($k=0;$k<$jumlah_pengukuran;$k++){
          $jumlah_pohon_plot=count($data_tanaman_plot[$k]);
          $jumlah_kerusakan_pohon=count($cek_kerusakan[$k]);
          $jumlah_pertumbuhan_pohon=count($cek_pertumbuhan[$k]);
          $jumlah_tajuk_pohon=count($cek_tajuk[$k]);

          if($jumlah_pohon_plot==$jumlah_kerusakan_pohon){
              $kerusakan_lengkap[] = 1;
          }
          else{
              $kerusakan_lengkap[] = 0;
          }

          if($jumlah_pohon_plot==$jumlah_pertumbuhan_pohon){
              $pertumbuhan_lengkap[] = 1;
          }
          else{
              $pertumbuhan_lengkap[] = 0;
          }

          if($jumlah_pohon_plot==$jumlah_tajuk_pohon){
              $tajuk_lengkap[] = 1;
          }
          else{
              $tajuk_lengkap[] = 0;
          }

          if($jumlah_pohon_plot==$jumlah_kerusakan_pohon &&
             $jumlah_pohon_plot==$jumlah_pertumbuhan_pohon &&
             $jumlah_pohon_plot==$jumlah_tajuk_pohon){
              $status_lengkap[] = 1;
          }
          else{
              $status_lengkap[] = 0;
          }

        }
      }
      else{
        $status_lengkap[] = 0;
      }

      $koordinat_bujur_p=$nama_plot->koordinat_BT;
      if($koordinat_bujur_p==""){
        $koordinat_bujur_p = "000 00 00.00";
      }
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

      $koordinat_lintang_p=$nama_plot->koordinat_LS;
      if($koordinat_lintang_p==""){
        $koordinat_lintang_p = "00 00 00.00";
      }
      $l_splitName_p = explode(' ', $koordinat_lintang_p, 2);
      $l_splitName2_p= explode(' ', $l_splitName_p[1], 2);
      $l_splitName3_p= explode(' ', $l_splitName2_p[1], 2);
      if($l_splitName_p[0]>=0){
        $ket_lintang_p='LS';
      }
      else{
        $ket_lintang_p='LU';
        $l_splitName_p[0]=$l_splitName_p[0]*-1;
      }
      $koor_ls_ful_p=$l_splitName_p[0].' ᴼ '.$l_splitName2_p[0].' ’ '.$l_splitName3_p[0].' ”';$data_pengukuran=DB::table('pengukuran_master')
      ->join('tbl_plot','tbl_plot.id_plot','=','pengukuran_master.id_plot')
      ->where('pengukuran_master.id_plot','=',$id)
      ->get();

      $data_id=DB::table('pengukuran_master')
      ->join('tbl_plot','tbl_plot.id_plot','=','pengukuran_master.id_plot')
      ->where('pengukuran_master.id_plot','=',$id)
      ->first();

      return view('user.data_pengukuran.detail_data_pengukuran',[
        'koor_bt_ful_p'=>$koor_bt_ful_p,
        'koor_ls_ful_p'=>$koor_ls_ful_p,
        'ket_bujur_p'=>$ket_bujur_p,
        'ket_lintang_p'=>$ket_lintang_p,
        'jumlah_pengukuran'=>$jumlah_pengukuran,
        'data_pengukuran'=>$data_pengukuran,
        'data_id' =>$data_id,
        'nama_plot' =>$nama_plot,
        'id_plot' => $id,
        'id_plots' => $id_plots,
        'nama_plots' => $nama_plots,
        'data_id_plot' => $id_plot,
        'id_klaster' => $id_klaster_plot,
        'cek_status' => $status_lengkap,
      ]);
    }

    public function fungsi2(Request $req)
    {
      $id_jenis_hutan = $req->id; // mengambil nilai id_jenis dari link yang diset
      // lihat jquery di modal-tambah3, dan modal-edit pada user.include.data_pengukuran

      // mengambil nilai hubungan_fungsi_jenis_hutan pada database berdasarkan nilai id_jenis
      $fungsi_hutan = DB::table('hubungan_fungsi_jenis_hutan')
      // kolom yang di ambil adalah id, id_fungsi, id_jenis, dan fungsi
                  ->select(
                      'id',
                      'id_fungsi',
                      'id_jenis',
                      'fungsi')
      // tabel berelasi dengan table fungsi hutan berdasarkan id_fungsi
                  ->join(
                      'fungsi_hutan',
                      'fungsi_hutan.id_fungsi_hutan','=','hubungan_fungsi_jenis_hutan.id_fungsi')
                  ->where('id_jenis', '=', $id_jenis_hutan)
                  ->orderBy('fungsi')
                  ->get();
                  return response()->json($fungsi_hutan); // mengembalikan nilai hubungan_fungsi_jenis_hutan
                  // berupa json, yang dapat dipanggil pada data_pengukuran.
                  // lihat jquery di modal-tambah3, dan modal-edit pada user.include.data_pengukuran
    }

    // fungsi untuk mengembalikan nilai array kabupaten berdarkan provinsi yang dipilih
    public function kabupaten2(Request $req)
    {
      $id_provinsi = $req->id;
      $kabupaten= Kabupaten::where('id_provinsi', '=', $id_provinsi)
                                    ->orderBy('nama_kabupaten')->get();
      return response()->json($kabupaten);
    }

    // fungsi untuk mengembalikan nilai array kecamatan berdarkan kabupaten yang dipilih
    public function kecamatan2(Request $req)
    {
      $id_kabupaten = $req->id;
      $kecamatan= Kecamatan::where('id_kabupaten', '=', $id_kabupaten)
                                    ->orderBy('nama_kecamatan')->get();
      return response()->json($kecamatan);
    }

    // fungsi untuk mengembalikan nilai array desa berdarkan kecamatan yang dipilih
    public function desa2(Request $req)
    {
      $id_kecamatan = $req->id;
      $desa= Desa::where('id_kecamatan', '=', $id_kecamatan)
                          ->orderBy('nama_desa')->get();
      return response()->json($desa);
    }
}
