<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Exceptions\CustomException;
use Illuminate\Database\QueryException;
use GMaps;

class KlasterController extends Controller
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

     public function insert_klaster_plot(Request $req)
     {
       $req->validate([
           'id_tambah_data_klaster'=> 'required|integer',
           'altitude'=>'nullable|numeric|max:1000',
           'kepemilikan'=>'required',
           'jenis'=>'nullable|regex:/^[a-zA-Z ]{2,50}$/',
           'fungsi'=>'required',
           'provinsi'=>'required',
           'kabupaten'=>'required',
           'kecamatan'=>'required',
           'desa'=>'required',
           'nama_titik_ikat'=>'required|regex:/^[a-zA-Z ]{2,50}$/',
           'kode_klaster_plot'=>'required|regex:/^[a-zA-Z][a-zA-Z0-9]{2,9}$/',
           'jarak_titik_ikat'=>'nullable|numeric|min:0|max:1000',
           'luas'=>'nullable|numeric|min:0|max:1000',
           'azimuth'=>'nullable|numeric|min:0|max:1000',
           'tahun_tanam'=>'nullable|regex:/^([1-2][\d]{3}){0,1}(,[1-2][\d]{3}){0,2}$/',
           'usia'=>'nullable|integer|min:1|max:100',
           'jarak_tanam_x'=>'nullable|numeric|min:0|max:1000',
           'jarak_tanam_y'=>'nullable|numeric|min:0|max:1000',
           'jenis_tanaman'=>'nullable|regex:/^[a-zA-Z ]{0,50}$/',
         ]);

       // fungsi ini digunakan untuk menambahkan data pengukuran
       $input_by = Auth::user()->id; //berdasarkan id masing-masing user
       // mengembalikan nilai pada modal-tambah3 pada user.include.data_pengukuran
       //------------------------------------------------------------------------

       $id_data_klaster = $req->input('id_tambah_data_klaster');
       $klaster = $req->input('kode_klaster_plot');
       $altitude = $req->input('altitude');
       $pengelola = $req->input('pengelola');
       $ket_pengelola = $req->input('ket_pengelola');
       $titik_ikat = $req->input('nama_titik_ikat');
       $jarak_titik = $req->input('jarak_titik_ikat');
       $jarakx = $req->input('jarak_tanam_x');
       $jaraky = $req->input('jarak_tanam_y');
       $luas = $req->input('luas');
       $pola = $req->input('pola_tanam');
       $tahun = $req->input('tahun_tanam');
       $usia = $req->input('usia');
       $azimuth = $req->input('azimuth');
       $id_provinsi = $req->input('provinsi');
       $id_kabupaten = $req->input('kabupaten');
       $id_kecamatan = $req->input('kecamatan');
       $id_desa = $req->input('desa');
       $id_hak_milik = $req->input('kepemilikan');
       $id_jenis_hutan = $req->input('jenis');
       $id_fungsi_hutan = $req->input('fungsi');
       $jenis_tanaman = $req->input('jenis_tanaman');
       $koor_bujur = $req->input('koor_bujur');
       $koor_lintang = $req->input('koor_lintang');
       $ket_lintang = $req->input('pilih_lintang2');
       $ket_bujur = $req->input('pilih_bujur2');
       //klaster
       $koor_bujur_klaster = $req->input('koor_bujur_klaster');
       $koor_lintang_klaster = $req->input('koor_lintang_klaster');
       $ket_lintang_klaster = $req->input('pilih_lintang_klaster2');
       $ket_bujur_klaster = $req->input('pilih_bujur_klaster2');
       //------------------------------------------------------------------------

       if($koor_bujur==""){
         $koor_bujur = "000 ᴼ 00 ’ 00.00 ”";
       }
       if($koor_lintang==""){
         $koor_lintang = "00 ᴼ 00 ’ 00.00 ”";
       }

       if($koor_bujur_klaster==""){
         $koor_bujur_klaster = "000 ᴼ 00 ’ 00.00 ”";
       }
       if($koor_lintang_klaster==""){
         $koor_lintang_klaster = "00 ᴼ 00 ’ 00.00 ”";
       }

       $pattern = '/_/i';
       if(preg_match($pattern,$koor_bujur) || preg_match($pattern,$koor_lintang) ){
         session()->flash('delete', 'Koordinat yang dimasukkan salah.');
         return back();
       }

       // klaster
       $pattern_klaster = '/_/i';
       if(preg_match($pattern_klaster,$koor_bujur_klaster) || preg_match($pattern_klaster,$koor_lintang_klaster) ){
         session()->flash('delete', 'Koordinat klaster yang dimasukkan salah.');
         return back();
       }


       //
       // LINTANG
       $ls_splitName = explode(' ᴼ', $koor_lintang, 2);
       $ls_splitName2= explode(' ’', $ls_splitName[1], 2);
       $ls_splitName3= explode(' ”', $ls_splitName2[1], 2);
       if($ket_lintang=='LS'){
         $koor_ls_ful='-'.$ls_splitName[0].$ls_splitName2[0].$ls_splitName3[0];
       }
       else{
         $koor_ls_ful=$ls_splitName[0].$ls_splitName2[0].$ls_splitName3[0];
       }

       //BUJUR
       $splitName = explode(' ᴼ', $koor_bujur, 2);
       $splitName2= explode(' ’', $splitName[1], 2);
       $splitName3= explode(' ”', $splitName2[1], 2);
       if($ket_bujur=='BT'){
         $koor_bt_ful=$splitName[0].$splitName2[0].$splitName3[0];
       }
       else{
         $koor_bt_ful='-'.$splitName[0].$splitName2[0].$splitName3[0];
       }
       //

       // Klaster
       // LINTANG
       $ls_splitName_klaster = explode(' ᴼ', $koor_lintang_klaster, 2);
       $ls_splitName_klaster2= explode(' ’', $ls_splitName_klaster[1], 2);
       $ls_splitName_klaster3= explode(' ”', $ls_splitName_klaster2[1], 2);
       if($ket_lintang_klaster=='LS'){
         $koor_ls_ful_klaster='-'.$ls_splitName_klaster[0].$ls_splitName_klaster2[0].$ls_splitName_klaster3[0];
       }
       else{
         $koor_ls_ful_klaster=$ls_splitName_klaster[0].$ls_splitName_klaster2[0].$ls_splitName_klaster3[0];
       }

       //BUJUR
       $splitName_klaster = explode(' ᴼ', $koor_bujur_klaster, 2);
       $splitName_klaster2= explode(' ’', $splitName_klaster[1], 2);
       $splitName_klaster3= explode(' ”', $splitName_klaster2[1], 2);
       if($ket_bujur_klaster=='BT'){
         $koor_bt_ful_klaster=$splitName_klaster[0].$splitName_klaster2[0].$splitName_klaster3[0];
       }
       else{
         $koor_bt_ful_klaster='-'.$splitName_klaster[0].$splitName_klaster2[0].$splitName_klaster3[0];
       }
       //

       // menyimpan data klaster_plot ke dalam array data
       $data = array(
         "input_by"=> Auth::User()->id,
         'id_data_klaster' => $id_data_klaster,
         'nama_klaster'=> $klaster,
         'altitude' => $altitude,
         'pengelola'=> $pengelola,
         'ket_pengelola' => $ket_pengelola,
         'tipe_hutan' => $id_jenis_hutan,
         'nama_titik_ikat' => $titik_ikat,
         'jarak_ke_titik_ikat' => $jarak_titik,
         'luas' => $luas,
         'azimuth' => $azimuth,
         'usia' => $usia,
         'tahun_tanam' => $tahun,
         'jarak_tanam_x' => $jarakx,
         'jarak_tanam_y' => $jaraky,
         'pola_tanam' => $pola,
         'jenis_tanaman' => $jenis_tanaman,
         'koordinatLS' => $koor_ls_ful,
         'koordinatBT' => $koor_bt_ful,
         // klaster
         'lintang_klaster' => $koor_ls_ful_klaster,
         'bujur_klaster' => $koor_bt_ful_klaster,
       );

       try{
         DB::table('tbl_klaster_plot')->insert($data);
         $klaster = DB::table('tbl_klaster_plot')
                       ->select(DB::raw('MAX(id_klaster_plot) AS id_klaster'))
                       ->where('input_by','=',Auth::user()->id)
                       ->first();
         $id_klaster = $klaster->id_klaster;

         // menyimpan data lokasi ke dalam array data
         $data_lokasi = array(
           'id_klaster_plot' => $id_klaster,
           'id_provinsi' => $id_provinsi,
           'id_kabupaten' => $id_kabupaten,
           'id_kecamatan' => $id_kecamatan,
           'id_desa' => $id_desa,
         );
         // menyimpan data hak_milik ke dalam array data
         $data_milik = array(
           'id_klaster_plot' => $id_klaster,
           'id_hak_milik' => $id_hak_milik,
           'id_fungsi_hutan' => $id_fungsi_hutan,
         );
         // menambah data plot1 ke dalam array data
         $data_plot1 = array(
           'id_klaster_plot' => $id_klaster,
           'nama_plot' => 'PLOT 1',
           'jarak_ke_klaster' => $jarak_titik,
           // 'koordinat_LS' => $koor_ls_ful,
           // 'koordinat_BT' => $koor_bt_ful,
           // 'kode_foto' => $foto,
         );
         // menambah data plot2 ke dalam array data
         $data_plot2 = array(
           'id_klaster_plot' => $id_klaster,
           'nama_plot' => 'PLOT 2',
           'jarak_ke_klaster' => $jarak_titik,
           // 'koordinat_LS' => $ls,
           // 'koordinat_BT' => $bt,
           // 'kode_foto' => $foto,
         );
         // menambah data plot3 ke dalam array data
         $data_plot3 = array(
           'id_klaster_plot' => $id_klaster,
           'nama_plot' => 'PLOT 3',
           'jarak_ke_klaster' => $jarak_titik,
           // 'koordinat_LS' => $ls,
           // 'koordinat_BT' => $bt,
           // 'kode_foto' => $foto,
         );
         // menambah data plot4 ke dalam array data
         $data_plot4 = array(
           'id_klaster_plot' => $id_klaster,
           'nama_plot' => 'PLOT 4',
           'jarak_ke_klaster' => $jarak_titik,
           // 'koordinat_LS' => $ls,
           // 'koordinat_BT' => $bt,
           // 'kode_foto' => $foto,
         );
         // menambah data nilai_tertimbang ke dalam array data
         // $nilai_tertimbang = array(
         //   'id_klaster' => $id_klaster,
         // );


         // menambahkan data pada tbl_klaster_plot, lokasi, hak_milik_jenis_fungsi_hutan,
         // tbl_plot, dan nilai_tertimbang_copy.
         DB::beginTransaction(); //fungsi untuk menampung data terlebih dahulu
         DB::table('lokasi')->insert($data_lokasi);
         DB::table('hak_milik_jenis_fungsi_hutan')->insert($data_milik);
         DB::table('tbl_plot')->insert($data_plot1);
         DB::table('tbl_plot')->insert($data_plot2);
         DB::table('tbl_plot')->insert($data_plot3);
         DB::table('tbl_plot')->insert($data_plot4);
         DB::commit(); // setelah semua tereksekusi baru data disimpan ke dalam Database
         // jika terdapat error, maka semua data tidak akan disimpan ke dalam database
         $tahun_pengukuran = $req->input('tahun_pengukuran');
         $pengukuran_ke = $req->input('pengukuran_ke');
         $nama_pengukur = $req->input('nama_pengukur');
         $id_plot=DB::table('tbl_plot')
         ->where('id_klaster_plot','=',$id_klaster)->get();

         $data_pengukuran1= array(
           'pengukuran_ke' => $pengukuran_ke,
           'id_data_klaster' => $id_data_klaster,
           'id_plot' => $id_plot[0]->id_plot,
           'tahun_pengukuran' => $tahun_pengukuran,
           'nama_pengukur' => $nama_pengukur,
         );
         $data_pengukuran2= array(
           'pengukuran_ke' => $pengukuran_ke,
           'id_data_klaster' => $id_data_klaster,
           'id_plot' => $id_plot[1]->id_plot,
           'tahun_pengukuran' => $tahun_pengukuran,
           'nama_pengukur' => $nama_pengukur,
         );
         $data_pengukuran3= array(
           'pengukuran_ke' => $pengukuran_ke,
           'id_data_klaster' => $id_data_klaster,
           'id_plot' => $id_plot[2]->id_plot,
           'tahun_pengukuran' => $tahun_pengukuran,
           'nama_pengukur' => $nama_pengukur,
         );
         $data_pengukuran4= array(
           'pengukuran_ke' => $pengukuran_ke,
           'id_data_klaster' => $id_data_klaster,
           'id_plot' => $id_plot[3]->id_plot,
           'tahun_pengukuran' => $tahun_pengukuran,
           'nama_pengukur' => $nama_pengukur,
         );

         DB::table('pengukuran_master')->insert($data_pengukuran1);
         DB::table('pengukuran_master')->insert($data_pengukuran2);
         DB::table('pengukuran_master')->insert($data_pengukuran3);
         DB::table('pengukuran_master')->insert($data_pengukuran4);
         session()->flash('insert', 'Data Klaster Plot berhasil ditambah.');
       }
       catch(\Illuminate\Database\QueryException $e){
         throw new CustomException($e->getMessage());
       }
       return back(); //kembali ke halaman data klaster plot
     }

     // fungsi yang digunakan untuk update data pengukuran
     public function update_klaster_plot(Request $req)
     {
       $req->validate([
           'altitude2' => 'nullable|numeric|min:0|max:1000',
           'kepemilikan2'=>'required',
           'jenis2'=>'required|regex:/^[a-zA-Z ]{2,50}$/',
           'fungsi2'=>'required',
           'pengelola2'=>'nullable|regex:/^[a-zA-Z ]{0,50}$/',
           'provinsi2'=>'required',
           'kabupaten2'=>'required',
           'kecamatan2'=>'required',
           'desa2'=>'required',
           'nama_titik_ikat2'=>'required|regex:/^[a-zA-Z ]{2,50}$/',
           'kode_klaster_plot2'=>'required|regex:/^[a-zA-Z][a-zA-Z0-9]{2,9}$/',
           'jarak_titik_ikat2'=>'nullable|numeric|min:0|max:1000',
           'luas2'=>'nullable|numeric|min:0|max:1000',
           'azimuth2'=>'nullable|numeric|min:0|max:1000',
           'tahun_tanam2'=>'nullable|regex:/^([1-2][\d]{3}){0,1}(,[1-2][\d]{3}){0,2}$/',
           'usia2'=>'nullable|integer|min:1|max:100',
           'jenis_tanaman2' => 'nullable|regex:/^[a-zA-Z ]{2,50}$/',
           'jarak_tanam_x2'=>'nullable|numeric|min:0|max:1000',
           'jarak_tanam_y2'=>'nullable|numeric|min:0|max:1000',
         ]);
       $input_by = Auth::user()->id; // mengembalikan nilai id masing-masing user
       // mengembalikan nilai pada modal-edit pada user.include.data_pengukuran
       //------------------------------------------------------------------------
       $id_klaster = $req->input('id_klaster_plot2');
       $klaster = $req->input('kode_klaster_plot2');
       $altitude = $req->input('altitude2');
       $pengelola = $req->input('pengelola2');
       $ket_pengelola = $req->input('ket_pengelola2');
       $titik_ikat = $req->input('nama_titik_ikat2');
       $jarak_titik = $req->input('jarak_titik_ikat2');
       $jarakx = $req->input('jarak_tanam_x2');
       $jaraky = $req->input('jarak_tanam_y2');
       $luas = $req->input('luas2');
       $pola = $req->input('pola_tanam2');
       $tahun = $req->input('tahun_tanam2');
       $usia = $req->input('usia2');
       $azimuth = $req->input('azimuth2');
       $id_provinsi = $req->input('provinsi2');
       $id_kabupaten = $req->input('kabupaten2');
       $id_kecamatan = $req->input('kecamatan2');
       $id_desa = $req->input('desa2');
       $id_hak_milik = $req->input('kepemilikan2');
       $id_jenis_hutan = $req->input('jenis2');
       $id_fungsi_hutan = $req->input('fungsi2');
       $jenis_tanaman = $req->input('jenis_tanaman2');
       $koord_bujur = $req->input('koor_bujur2');
       $koord_lintang = $req->input('koor_lintang2');
       $ket_lintang = $req->input('pilih_lintang');
       $ket_bujur = $req->input('pilih_bujur');
       $koord_bujur_klaster = $req->input('koor_bujur2_klaster');
       $koord_lintang_klaster = $req->input('koor_lintang2_klaster');
       $ket_lintang_klaster = $req->input('pilih_lintang_klaster');
       $ket_bujur_klaster = $req->input('pilih_bujur_klaster');
       //------------------------------------------------------------------------

       if($koord_bujur==""){
         $koord_bujur = "000 ᴼ 00 ’ 00.00 ”";
       }
       if($koord_lintang==""){
         $koord_lintang = "00 ᴼ 00 ’ 00.00 ”";
       }

       if($koord_bujur_klaster==""){
         $koord_bujur_klaster = "000 ᴼ 00 ’ 00.00 ”";
       }
       if($koord_lintang_klaster==""){
         $koord_lintang_klaster = "00 ᴼ 00 ’ 00.00 ”";
       }
       $pattern = '/_/i';
       if(preg_match($pattern,$koord_bujur) || preg_match($pattern,$koord_lintang) ){
         session()->flash('delete', 'Koordinat titik ikat yang dimasukkan salah.');
         return back();
       }

       $pattern_klaster = '/_/i';
       if(preg_match($pattern_klaster,$koord_bujur_klaster) || preg_match($pattern_klaster,$koord_lintang_klaster) ){
         session()->flash('delete', 'Koordinat klaster yang dimasukkan salah.');
         return back();
       }

       //
       $splitName = explode(' ᴼ', $koord_bujur, 2);
       $splitName2= explode(' ’', $splitName[1], 2);
       $splitName3= explode(' ”', $splitName2[1], 2);

       if($ket_bujur=='BT'){
         $koor_bt_ful=$splitName[0].$splitName2[0].$splitName3[0];
       }
       else{
         $koor_bt_ful='-'.$splitName[0].$splitName2[0].$splitName3[0];
       }


       $ls_splitName = explode(' ᴼ', $koord_lintang, 2);
       $ls_splitName2= explode(' ’', $ls_splitName[1], 2);
       $ls_splitName3= explode(' ”', $ls_splitName2[1], 2);

       if($ket_lintang=='LS'){
         $koor_ls_ful='-'.$ls_splitName[0].$ls_splitName2[0].$ls_splitName3[0];
       }
       else{
         $koor_ls_ful=$ls_splitName[0].$ls_splitName2[0].$ls_splitName3[0];
       }

       //

       // koor klaster
       $splitName_klaster = explode(' ᴼ', $koord_bujur_klaster, 2);
       $splitName_klaster2= explode(' ’', $splitName_klaster[1], 2);
       $splitName_klaster3= explode(' ”', $splitName_klaster2[1], 2);

       if($ket_bujur_klaster=='BT'){
         $koor_bt_ful_klaster=$splitName_klaster[0].$splitName_klaster2[0].$splitName_klaster3[0];
       }
       else{
         $koor_bt_ful_klaster='-'.$splitName_klaster[0].$splitName_klaster2[0].$splitName_klaster3[0];
       }


       $ls_splitName_klaster = explode(' ᴼ', $koord_lintang_klaster, 2);
       $ls_splitName_klaster2= explode(' ’', $ls_splitName_klaster[1], 2);
       $ls_splitName_klaster3= explode(' ”', $ls_splitName_klaster2[1], 2);

       if($ket_lintang_klaster=='LS'){
         $koor_ls_ful_klaster='-'.$ls_splitName_klaster[0].$ls_splitName_klaster2[0].$ls_splitName_klaster3[0];
       }
       else{
         $koor_ls_ful_klaster=$ls_splitName_klaster[0].$ls_splitName_klaster2[0].$ls_splitName_klaster3[0];
       }

       //

       // menyimpan data klaster_plot yang diedit pada modal-edit_klaster_plot.blade.php Pada
       // user.include.data_pengukuran
       $data = array(
         'id_klaster_plot' => $id_klaster,
         "input_by"=> Auth::User()->id,
         'nama_klaster'=> $klaster,
         'altitude' => $altitude,
         'pengelola'=> $pengelola,
         'ket_pengelola' => $ket_pengelola,
         'tipe_hutan' => $id_jenis_hutan,
         'nama_titik_ikat' => $titik_ikat,
         'jarak_ke_titik_ikat' => $jarak_titik,
         'luas' => $luas,
         'azimuth' => $azimuth,
         'tahun_tanam' => $tahun,
         'usia' => $usia,
         'jarak_tanam_x' => $jarakx,
         'jarak_tanam_y' => $jaraky,
         'pola_tanam' => $pola,
         'jenis_tanaman' => $jenis_tanaman,
         'koordinatBT' => $koor_bt_ful,
         'koordinatLS' => $koor_ls_ful,
         //koor klaster
         'bujur_klaster' => $koor_bt_ful_klaster,
         'lintang_klaster' => $koor_ls_ful_klaster,
       );

       // menyimpan data lokasi yang diedit pada modal-edit.blade.php Pada
       // user.include.data_pengukuran
       $data_lokasi = array(
         'id_provinsi' => $id_provinsi,
         'id_kabupaten' => $id_kabupaten,
         'id_kecamatan' => $id_kecamatan,
         'id_desa' => $id_desa,
       );
       // menyimpan data hak_milik yang diedit pada modal-edit.blade.php Pada
       // user.include.data_pengukuran
       $data_milik = array(
         'id_hak_milik' => $id_hak_milik,
         'id_fungsi_hutan' => $id_fungsi_hutan,
       );

       $data_plot = array(
         // 'koordinat_BT' => $koor_bt_ful,
         // 'koordinat_LS' => $koor_ls_ful,
       );
       try{
         // mengubah data klaster_plot berdasarkan input dari modal-edit.blade.php Pada
         // user.include.data_pengukuran
         DB::beginTransaction(); // fungsi untuk menampung data terlebih dahulu
         DB::table('tbl_klaster_plot')->where('id_klaster_plot', $id_klaster)->update($data);
         DB::table('lokasi')->where('id_klaster_plot', $id_klaster)->update($data_lokasi);
         DB::table('hak_milik_jenis_fungsi_hutan')->where('id_klaster_plot', $id_klaster)->update($data_milik);
         DB::commit(); // menyimpan data ke dalam database
                       // jika ada yang error, maka semua data tidak akan disimpan ke dalam database
        session()->flash('insert', 'Data Klaster Plot berhasil diubah.');
       }
       catch(\Illuminate\Database\QueryException $e){
         throw new CustomException($e->getMessage());
       }

       return back();
     }

     // fungsi untuk menghapus data klaster_plot
     public function hapus_klaster_plot(Request $req)
     {
       try{
         // menghapus data berdasarkan id_klaster_plot
         // data-data anaknya seperti data plot, data lokasi, data hak_milik_jenis_fungsi_hutan akan
         // otomatis terhapus
         DB::table('tbl_klaster_plot')->where('id_klaster_plot',$req->input('hapus_id'))->delete();
         session()->flash('delete', 'Data Klaster Plot berhasil dihapus.');
       }
       catch(\Illuminate\Database\QueryException $e){
         throw new CustomException($e->getMessage());
       }

       return back(); // fungsi untuk mengarahkan ke halaman sebelumnya
       // setelah menghapus data
     }

    public function detail_klaster_plot($id){

      $id=decrypt($id);

      $id_data_klaster1 = DB::table('kategori_klaster')
      ->leftjoin('tbl_klaster_plot','tbl_klaster_plot.id_data_klaster','=','kategori_klaster.id_data_klaster')
      ->where('tbl_klaster_plot.id_klaster_plot','=',$id)
      ->first();

      $id_data_klaster2 = $id_data_klaster1->id_data_klaster;

      $data=DB::table('tbl_klaster_plot')
      ->where('tbl_klaster_plot.id_klaster_plot','=',$id)
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
       ->leftjoin(
         'pola_tanam',
         'pola_tanam.id_pola_tanam','=','tbl_klaster_plot.pola_tanam'
         )
      ->first();
      $plot = DB::table('tbl_plot')
      ->where('id_klaster_plot','=',$id)
      ->get();

      $koordinat_bujur_p=$data->bujur_klaster;
      if($koordinat_bujur_p==""){
        $koordinat_bujur_p = "000 ᴼ 00 ’ 00.00 ”";
      }
      $splitName_p = explode(' ', $koordinat_bujur_p, 2);
      $splitName2_p= explode(' ', $splitName_p[1], 2);
      $splitName3_p= explode(' ', $splitName2_p[1], 2);
      if($splitName_p[0]>=0){
        $ket_bujur_p='BT';
        $long_derajat=$splitName_p[0];

        $menit_b = $splitName2_p[0]/60;
        $detik_b = $splitName3_p[0]/3600;

        $koordinat_bujur_angka_klaster = $long_derajat + $menit_b + $detik_b;
      }
      else{
        $ket_bujur_p='BB';
        $splitName_p[0]=$splitName_p[0]*-1;

        $long_derajat=$splitName_p[0]*-1;

        $menit_b = $splitName2_p[0]/60;
        $detik_b = $splitName3_p[0]/3600;

        $koordinat_bujur_angka_klaster = $long_derajat - $menit_b - $detik_b;
      }


      $koor_bt_ful_p=$splitName_p[0].' ᴼ '.$splitName2_p[0].' ’ '.$splitName3_p[0].' ”';

      $koordinat_lintang_p=$data->lintang_klaster;
      if($koordinat_lintang_p==""){
        $koordinat_lintang_p = "00 ᴼ 00 ’ 00.00 ”";
      }
      $l_splitName_p = explode(' ', $koordinat_lintang_p, 2);
      $l_splitName2_p= explode(' ', $l_splitName_p[1], 2);
      $l_splitName3_p= explode(' ', $l_splitName2_p[1], 2);
      if($l_splitName_p[0]>=0){
        $ket_lintang_p='LU';
        $lat_derajat=$l_splitName_p[0];

        $menit_l = $l_splitName2_p[0]/60;
        $detik_l = $l_splitName3_p[0]/3600;

        $koordinat_lintang_angka_klaster = $lat_derajat + $menit_l + $detik_l;
      }
      else{
        $ket_lintang_p='LS';
        $l_splitName_p[0]=$l_splitName_p[0]*-1;

        $lat_derajat=$l_splitName_p[0]*-1;

        $menit_l = $l_splitName2_p[0]/60;
        $detik_l = $l_splitName3_p[0]/3600;

        $koordinat_lintang_angka_klaster = $lat_derajat - $menit_l - $detik_l;
      }


      $koor_ls_ful_p=$l_splitName_p[0].' ᴼ '.$l_splitName2_p[0].' ’ '.$l_splitName3_p[0].' ”';

      // koordinat titik ikat
      $koordinat_bujur_p_ikat=$data->koordinatBT;
      if($koordinat_bujur_p_ikat==""){
        $koordinat_bujur_p_ikat = "000 ᴼ 00 ’ 00.00 ”";
      }
      $splitName_p_ikat = explode(' ', $koordinat_bujur_p_ikat, 2);
      $splitName2_p_ikat= explode(' ', $splitName_p_ikat[1], 2);
      $splitName3_p_ikat= explode(' ', $splitName2_p_ikat[1], 2);
      if($splitName_p_ikat[0]>=0){
        $ket_bujur_p_ikat='BT';
        $long_derajat_ikat=$splitName_p_ikat[0];

        $menit_b = $splitName2_p_ikat[0]/60;
        $detik_b = $splitName3_p_ikat[0]/3600;

        $koordinat_bujur_angka_klaster_ikat = $long_derajat_ikat + $menit_b + $detik_b;
      }
      else{
        $ket_bujur_p_ikat='BB';
        $splitName_p_ikat[0]=$splitName_p_ikat[0]*-1;

        $long_derajat_ikat=$splitName_p_ikat[0]*-1;

        $menit_b = $splitName2_p_ikat[0]/60;
        $detik_b = $splitName3_p_ikat[0]/3600;

        $koordinat_bujur_angka_klaster_ikat = $long_derajat_ikat - $menit_b - $detik_b;
      }


      $koor_bt_ful_p_ikat=$splitName_p_ikat[0].' ᴼ '.$splitName2_p_ikat[0].' ’ '.$splitName3_p_ikat[0].' ”';

      $koordinat_lintang_p_ikat=$data->koordinatLS;
      if($koordinat_lintang_p_ikat==""){
        $koordinat_lintang_p_ikat = "00 ᴼ 00 ’ 00.00 ”";
      }
      $l_splitName_p_ikat = explode(' ', $koordinat_lintang_p_ikat, 2);
      $l_splitName2_p_ikat= explode(' ', $l_splitName_p_ikat[1], 2);
      $l_splitName3_p_ikat= explode(' ', $l_splitName2_p_ikat[1], 2);
      if($l_splitName_p_ikat[0]>=0){
        $ket_lintang_p_ikat='LU';
        $lat_derajat_ikat=$l_splitName_p_ikat[0];

        $menit_l = $l_splitName2_p_ikat[0]/60;
        $detik_l = $l_splitName3_p_ikat[0]/3600;

        $koordinat_lintang_angka_klaster_ikat = $lat_derajat_ikat + $menit_l + $detik_l;
      }
      else{
        $ket_lintang_p_ikat='LS';
        $l_splitName_p_ikat[0]=$l_splitName_p_ikat[0]*-1;

        $lat_derajat_ikat=$l_splitName_p_ikat[0]*-1;

        $menit_l = $l_splitName2_p_ikat[0]/60;
        $detik_l = $l_splitName3_p_ikat[0]/3600;

        $koordinat_lintang_angka_klaster_ikat = $lat_derajat_ikat - $menit_l - $detik_l;
      }


      $koor_ls_ful_p_ikat=$l_splitName_p_ikat[0].' ᴼ '.$l_splitName2_p_ikat[0].' ’ '.$l_splitName3_p_ikat[0].' ”';

      for($i=0;$i<4;$i++){
        //
      $koordinat_bujur[$i]=$plot[$i]->koordinat_BT;
      $splitName[$i] = explode(' ', $koordinat_bujur[$i], 2);
      $splitName2[$i]= explode(' ', $splitName[$i][1], 2);
      $splitName3[$i]= explode(' ', $splitName2[$i][1], 2);
      if($splitName[$i][0]>=0){
        $ket_bujur[$i]='BT';

        $long_derajat_p=$splitName[$i][0];

        $menit_b_plot[$i] = $splitName2[$i][0]/60;
        $detik_b_plot[$i] = $splitName3[$i][0]/3600;

        $koor_bujur_plot[$i]= $long_derajat_p + $menit_b_plot[$i] + $detik_b_plot[$i];
      }
      else{
        $ket_bujur[$i]='BB';
        $splitName[$i][0]=$splitName[$i][0]*-1;

        $long_derajat_p=$splitName[$i][0]*-1;

        $menit_b_plot[$i] = $splitName2[$i][0]/60;
        $detik_b_plot[$i] = $splitName3[$i][0]/3600;

        $koor_bujur_plot[$i]= $long_derajat_p - $menit_b_plot[$i] - $detik_b_plot[$i];
      }


      $koor_bt_ful[$i]=$splitName[$i][0].' ᴼ '.$splitName2[$i][0].' ’ '.$splitName3[$i][0].' ”';
    }
            //

        for($i=0;$i<4;$i++){
          //
          $koordinat_lintang[$i]=$plot[$i]->koordinat_LS;
          $l_splitName[$i] = explode(' ', $koordinat_lintang[$i], 2);
          $l_splitName2[$i]= explode(' ', $l_splitName[$i][1], 2);
          $l_splitName3[$i]= explode(' ', $l_splitName2[$i][1], 2);
          if($l_splitName[$i][0]>=0){
            $ket_lintang[$i]='LU';

            $lat_derajat_p=$l_splitName[$i][0];

            $menit_l_plot[$i] = $l_splitName2[$i][0]/60;
            $detik_l_plot[$i] = $l_splitName3[$i][0]/3600;

            $koor_lintang_plot[$i]= $lat_derajat_p + $menit_l_plot[$i] + $detik_l_plot[$i];
          }
          else{
            $ket_lintang[$i]='LS';
            $l_splitName[$i][0]=$l_splitName[$i][0]*-1;

            $lat_derajat_p=$l_splitName[$i][0]*-1;

            $menit_l_plot[$i] = $l_splitName2[$i][0]/60;
            $detik_l_plot[$i] = $l_splitName3[$i][0]/3600;

            $koor_lintang_plot[$i]= $lat_derajat_p - $menit_l_plot[$i] - $detik_l_plot[$i];
          }



          $koor_ls_ful[$i]=$l_splitName[$i][0].' ᴼ '.$l_splitName2[$i][0].' ’ '.$l_splitName3[$i][0].' ”';
        }
          //

          $cek_pengukuran = DB::table('kategori_klaster')
          ->where('id_data_klaster2','=',$id_data_klaster2)->first();
          $cek_pengukuran2 = DB::table('kategori_klaster')
          ->where('id_data_klaster2','=',$id_data_klaster2)->get();

if(count($cek_pengukuran2)!=0){
  if($cek_pengukuran->id_data_klaster2!=""){
    $id_data_klaster2 = $cek_pengukuran->id_data_klaster2;
    $cek_user = DB::table('tbl_klaster_plot')
    ->select('kategori_klaster.input_by')
    ->leftjoin('kategori_klaster','kategori_klaster.id_data_klaster','=','tbl_klaster_plot.id_data_klaster')
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


        return view('user.PlotUkur.detail_klaster',[
          'lintang_masked' => $koordinat_lintang,
          'bujur_masked' => $koordinat_bujur,
          'id_data_klaster2' => $id_data_klaster2,
          'koor_bt_ful_p' => $koor_bt_ful_p,
          'ket_bujur_p'=>$ket_bujur_p,
          'koor_ls_ful_p'=>$koor_ls_ful_p,
          'ket_lintang_p'=>$ket_lintang_p,
          'koor_bt_ful'=>$koor_bt_ful,
          'koor_ls_ful'=>$koor_ls_ful,
          'ket_lintang'=>$ket_lintang,
          'ket_bujur'=>$ket_bujur,

          // koordinat titik ikat
          'koor_bt_ful_p_ikat' => $koor_bt_ful_p_ikat,
          'ket_bujur_p_ikat'=>$ket_bujur_p_ikat,
          'koor_ls_ful_p_ikat'=>$koor_ls_ful_p_ikat,
          'ket_lintang_p_ikat'=>$ket_lintang_p_ikat,

          'data'=>$data,
          'plot'=>$plot,
          'koordinat_bujur_angka_klaster' => $koordinat_bujur_angka_klaster,
          'koordinat_lintang_angka_klaster' => $koordinat_lintang_angka_klaster,
          'koor_lintang_plot' => $koor_lintang_plot,
          'koor_bujur_plot' => $koor_bujur_plot,
          'ijin' => $ijin,
          ]);
    }


    public function detail_klaster_plots(Request $req){

      $id=$req->nama_klaster_plot;

      $id_data_klaster1 = DB::table('kategori_klaster')
      ->leftjoin('tbl_klaster_plot','tbl_klaster_plot.id_data_klaster','=','kategori_klaster.id_data_klaster')
      ->where('tbl_klaster_plot.id_klaster_plot','=',$id)
      ->first();

      $id_data_klaster2 = $id_data_klaster1->id_data_klaster;

      $data=DB::table('tbl_klaster_plot')
      ->where('tbl_klaster_plot.id_klaster_plot','=',$id)
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
        ->leftjoin(
          'pola_tanam',
          'pola_tanam.id_pola_tanam','=','tbl_klaster_plot.pola_tanam'
          )
      ->first();
      $plot = DB::table('tbl_plot')
      ->where('id_klaster_plot','=',$id)
      ->get();

      $koordinat_bujur_p=$data->bujur_klaster;
      if($koordinat_bujur_p==""){
        $koordinat_bujur_p = "000 ᴼ 00 ’ 00.00 ”";
      }
      $splitName_p = explode(' ', $koordinat_bujur_p, 2);
      $splitName2_p= explode(' ', $splitName_p[1], 2);
      $splitName3_p= explode(' ', $splitName2_p[1], 2);
      if($splitName_p[0]>=0){
        $ket_bujur_p='BT';
        $long_derajat=$splitName_p[0];

        $menit_b = $splitName2_p[0]/60;
        $detik_b = $splitName3_p[0]/3600;

        $koordinat_bujur_angka_klaster = $long_derajat + $menit_b + $detik_b;
      }
      else{
        $ket_bujur_p='BB';
        $splitName_p[0]=$splitName_p[0]*-1;

        $long_derajat=$splitName_p[0]*-1;

        $menit_b = $splitName2_p[0]/60;
        $detik_b = $splitName3_p[0]/3600;

        $koordinat_bujur_angka_klaster = $long_derajat - $menit_b - $detik_b;
      }


      $koor_bt_ful_p=$splitName_p[0].' ᴼ '.$splitName2_p[0].' ’ '.$splitName3_p[0].' ”';

      $koordinat_lintang_p=$data->lintang_klaster;
      if($koordinat_lintang_p==""){
        $koordinat_lintang_p = "00 ᴼ 00 ’ 00.00 ”";
      }
      $l_splitName_p = explode(' ', $koordinat_lintang_p, 2);
      $l_splitName2_p= explode(' ', $l_splitName_p[1], 2);
      $l_splitName3_p= explode(' ', $l_splitName2_p[1], 2);
      if($l_splitName_p[0]>=0){
        $ket_lintang_p='LU';
        $lat_derajat=$l_splitName_p[0];

        $menit_l = $l_splitName2_p[0]/60;
        $detik_l = $l_splitName3_p[0]/3600;

        $koordinat_lintang_angka_klaster = $lat_derajat + $menit_l + $detik_l;
      }
      else{
        $ket_lintang_p='LS';
        $l_splitName_p[0]=$l_splitName_p[0]*-1;

        $lat_derajat=$l_splitName_p[0]*-1;

        $menit_l = $l_splitName2_p[0]/60;
        $detik_l = $l_splitName3_p[0]/3600;

        $koordinat_lintang_angka_klaster = $lat_derajat - $menit_l - $detik_l;
      }


      $koor_ls_ful_p=$l_splitName_p[0].' ᴼ '.$l_splitName2_p[0].' ’ '.$l_splitName3_p[0].' ”';

      // koordinat titik ikat
      $koordinat_bujur_p_ikat=$data->koordinatBT;
      if($koordinat_bujur_p_ikat==""){
        $koordinat_bujur_p_ikat = "000 ᴼ 00 ’ 00.00 ”";
      }
      $splitName_p_ikat = explode(' ', $koordinat_bujur_p_ikat, 2);
      $splitName2_p_ikat= explode(' ', $splitName_p_ikat[1], 2);
      $splitName3_p_ikat= explode(' ', $splitName2_p_ikat[1], 2);
      if($splitName_p_ikat[0]>=0){
        $ket_bujur_p_ikat='BT';
        $long_derajat_ikat=$splitName_p_ikat[0];

        $menit_b = $splitName2_p_ikat[0]/60;
        $detik_b = $splitName3_p_ikat[0]/3600;

        $koordinat_bujur_angka_klaster_ikat = $long_derajat_ikat + $menit_b + $detik_b;
      }
      else{
        $ket_bujur_p_ikat='BB';
        $splitName_p_ikat[0]=$splitName_p_ikat[0]*-1;

        $long_derajat_ikat=$splitName_p_ikat[0]*-1;

        $menit_b = $splitName2_p_ikat[0]/60;
        $detik_b = $splitName3_p_ikat[0]/3600;

        $koordinat_bujur_angka_klaster_ikat = $long_derajat_ikat - $menit_b - $detik_b;
      }


      $koor_bt_ful_p_ikat=$splitName_p_ikat[0].' ᴼ '.$splitName2_p_ikat[0].' ’ '.$splitName3_p_ikat[0].' ”';

      $koordinat_lintang_p_ikat=$data->koordinatLS;
      if($koordinat_lintang_p_ikat==""){
        $koordinat_lintang_p_ikat = "00 ᴼ 00 ’ 00.00 ”";
      }
      $l_splitName_p_ikat = explode(' ', $koordinat_lintang_p_ikat, 2);
      $l_splitName2_p_ikat= explode(' ', $l_splitName_p_ikat[1], 2);
      $l_splitName3_p_ikat= explode(' ', $l_splitName2_p_ikat[1], 2);
      if($l_splitName_p_ikat[0]>=0){
        $ket_lintang_p_ikat='LU';
        $lat_derajat_ikat=$l_splitName_p_ikat[0];

        $menit_l = $l_splitName2_p_ikat[0]/60;
        $detik_l = $l_splitName3_p_ikat[0]/3600;

        $koordinat_lintang_angka_klaster_ikat = $lat_derajat_ikat + $menit_l + $detik_l;
      }
      else{
        $ket_lintang_p_ikat='LS';
        $l_splitName_p_ikat[0]=$l_splitName_p_ikat[0]*-1;

        $lat_derajat_ikat=$l_splitName_p_ikat[0]*-1;

        $menit_l = $l_splitName2_p_ikat[0]/60;
        $detik_l = $l_splitName3_p_ikat[0]/3600;

        $koordinat_lintang_angka_klaster_ikat = $lat_derajat_ikat - $menit_l - $detik_l;
      }


      $koor_ls_ful_p_ikat=$l_splitName_p_ikat[0].' ᴼ '.$l_splitName2_p_ikat[0].' ’ '.$l_splitName3_p_ikat[0].' ”';

      for($i=0;$i<4;$i++){
        //
      $koordinat_bujur[$i]=$plot[$i]->koordinat_BT;
      $splitName[$i] = explode(' ', $koordinat_bujur[$i], 2);
      $splitName2[$i]= explode(' ', $splitName[$i][1], 2);
      $splitName3[$i]= explode(' ', $splitName2[$i][1], 2);
      if($splitName[$i][0]>=0){
        $ket_bujur[$i]='BT';

        $long_derajat_p=$splitName[$i][0];

        $menit_b_plot[$i] = $splitName2[$i][0]/60;
        $detik_b_plot[$i] = $splitName3[$i][0]/3600;

        $koor_bujur_plot[$i]= $long_derajat_p + $menit_b_plot[$i] + $detik_b_plot[$i];
      }
      else{
        $ket_bujur[$i]='BB';
        $splitName[$i][0]=$splitName[$i][0]*-1;

        $long_derajat_p=$splitName[$i][0]*-1;

        $menit_b_plot[$i] = $splitName2[$i][0]/60;
        $detik_b_plot[$i] = $splitName3[$i][0]/3600;

        $koor_bujur_plot[$i]= $long_derajat_p - $menit_b_plot[$i] - $detik_b_plot[$i];
      }


      $koor_bt_ful[$i]=$splitName[$i][0].' ᴼ '.$splitName2[$i][0].' ’ '.$splitName3[$i][0].' ”';
    }
            //

        for($i=0;$i<4;$i++){
          //
          $koordinat_lintang[$i]=$plot[$i]->koordinat_LS;
          $l_splitName[$i] = explode(' ', $koordinat_lintang[$i], 2);
          $l_splitName2[$i]= explode(' ', $l_splitName[$i][1], 2);
          $l_splitName3[$i]= explode(' ', $l_splitName2[$i][1], 2);
          if($l_splitName[$i][0]>=0){
            $ket_lintang[$i]='LU';

            $lat_derajat_p=$l_splitName[$i][0];

            $menit_l_plot[$i] = $l_splitName2[$i][0]/60;
            $detik_l_plot[$i] = $l_splitName3[$i][0]/3600;

            $koor_lintang_plot[$i]= $lat_derajat_p + $menit_l_plot[$i] + $detik_l_plot[$i];
          }
          else{
            $ket_lintang[$i]='LS';
            $l_splitName[$i][0]=$l_splitName[$i][0]*-1;

            $lat_derajat_p=$l_splitName[$i][0]*-1;

            $menit_l_plot[$i] = $l_splitName2[$i][0]/60;
            $detik_l_plot[$i] = $l_splitName3[$i][0]/3600;

            $koor_lintang_plot[$i]= $lat_derajat_p - $menit_l_plot[$i] - $detik_l_plot[$i];
          }

          $koor_ls_ful[$i]=$l_splitName[$i][0].' ᴼ '.$l_splitName2[$i][0].' ’ '.$l_splitName3[$i][0].' ”';
        }
          //
          $cek_pengukuran = DB::table('kategori_klaster')
          ->where('id_data_klaster2','=',$id_data_klaster2)->first();
          $cek_pengukuran2 = DB::table('kategori_klaster')
          ->where('id_data_klaster2','=',$id_data_klaster2)->get();

if(count($cek_pengukuran2)!=0){
  if($cek_pengukuran->id_data_klaster2!=""){
    $id_data_klaster2 = $cek_pengukuran->id_data_klaster2;
    $cek_user = DB::table('tbl_klaster_plot')
    ->select('kategori_klaster.input_by')
    ->leftjoin('kategori_klaster','kategori_klaster.id_data_klaster','=','tbl_klaster_plot.id_data_klaster')
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

        return view('user.PlotUkur.detail_klaster',[
          'lintang_masked' => $koordinat_lintang,
          'bujur_masked' => $koordinat_bujur,
          'id_data_klaster2' => $id_data_klaster2,
          'koor_bt_ful_p' => $koor_bt_ful_p,
          'ket_bujur_p'=>$ket_bujur_p,
          'koor_ls_ful_p'=>$koor_ls_ful_p,
          'ket_lintang_p'=>$ket_lintang_p,
          'koor_bt_ful'=>$koor_bt_ful,
          'koor_ls_ful'=>$koor_ls_ful,
          'ket_lintang'=>$ket_lintang,
          'ket_bujur'=>$ket_bujur,

          // koordinat titik ikat
          'koor_bt_ful_p_ikat' => $koor_bt_ful_p_ikat,
          'ket_bujur_p_ikat'=>$ket_bujur_p_ikat,
          'koor_ls_ful_p_ikat'=>$koor_ls_ful_p_ikat,
          'ket_lintang_p_ikat'=>$ket_lintang_p_ikat,

          'data'=>$data,
          'plot'=>$plot,
          'koordinat_bujur_angka_klaster' => $koordinat_bujur_angka_klaster,
          'koordinat_lintang_angka_klaster' => $koordinat_lintang_angka_klaster,
          'koor_lintang_plot' => $koor_lintang_plot,
          'koor_bujur_plot' => $koor_bujur_plot,

          'ijin' => $ijin,
          ]);
    }

    public function editPlot(Request $req)
    {

      $id_plot = $req->input('id_plot') ;
      $nama_plot = $req->input('nama_plot');
      $koorniatBT = $req->input('koordinat');
      $koorniatLS = $req->input('lintang');
      $ket_lintang = $req->input('pilih_lintang');
      $ket_bujur =  $req->input('pilih_bujur');

      if($koorniatBT==""){
        $koorniatBT = "000 ᴼ 00 ’ 00.00 ”";
      }
      if($koorniatLS==""){
        $koorniatLS = "00 ᴼ 00 ’ 00.00 ”";
      }
      $pattern = '/_/i';
      if(preg_match($pattern,$koorniatBT) || preg_match($pattern,$koorniatLS) ){
        session()->flash('delete', 'Koordinat yang dimasukkan salah.');
        return back();
      }

      $splitName = explode(' ᴼ', $koorniatBT, 2);
      $splitName2= explode(' ’', $splitName[1], 2);
      $splitName3= explode(' ”', $splitName2[1], 2);

      if($ket_bujur=='BT'){
        $koor_bt_ful=$splitName[0].$splitName2[0].$splitName3[0];
      }
      else{
        $koor_bt_ful='-'.$splitName[0].$splitName2[0].$splitName3[0];
      }

      $ls_splitName = explode(' ᴼ', $koorniatLS, 2);
      $ls_splitName2= explode(' ’', $ls_splitName[1], 2);
      $ls_splitName3= explode(' ”', $ls_splitName2[1], 2);

      if($ket_lintang=='LU'){
        $koor_ls_ful=$ls_splitName[0].$ls_splitName2[0].$ls_splitName3[0];
      }
      else{
        $koor_ls_ful='-'.$ls_splitName[0].$ls_splitName2[0].$ls_splitName3[0];
      }

      $data_plot = array(
        'nama_plot' => $nama_plot,
        'koordinat_BT' => $koor_bt_ful,
        'koordinat_LS' => $koor_ls_ful,
      );
      try{
      DB::table('tbl_plot')->where('id_plot', $id_plot)->update($data_plot);
      session()->flash('insert', 'Koordinat Plot berhasil diubah.');
      }
      catch(\Illuminate\Database\QueryException $e){
        throw new CustomException($e->getMessage());
      }
      return back();
    }

    public function detailPlot($id){
      $id=decrypt($id);
      $id_klaster=DB::table('tbl_plot')->select('id_klaster_plot')
      ->where('id_plot','=',$id)
      ->first();
      $id_klaster_plot=$id_klaster->id_klaster_plot;

      $id_data_klaster1 = DB::table('kategori_klaster')
      ->leftjoin('tbl_klaster_plot','tbl_klaster_plot.id_data_klaster','=','kategori_klaster.id_data_klaster')
      ->where('tbl_klaster_plot.id_klaster_plot','=',$id_klaster_plot)
      ->first();

      $id_data_klaster2 = $id_data_klaster1->id_data_klaster;

      $data_pohon = DB::table('data_tanaman_plot')
      ->select(DB::raw("table_master_jenis_tanaman.nama_tanaman,table_master_jenis_tanaman.nama_latin,data_tanaman_plot.id_master_jenis_tanaman,COUNT(*) as jumlah"))
      ->leftjoin(
      'table_master_jenis_tanaman',
      'table_master_jenis_tanaman.id_jenis_tanaman','=','data_tanaman_plot.id_master_jenis_tanaman'
      )
      ->where('id_plot','=',$id)
      ->where('data_tanaman_plot.status','=','1')
      ->groupBy(DB::raw('table_master_jenis_tanaman.nama_tanaman,table_master_jenis_tanaman.nama_latin,data_tanaman_plot.id_master_jenis_tanaman'))
      ->orderBy('table_master_jenis_tanaman.nama_tanaman')
      ->get();

      $jumlah_jenis_pohon= count($data_pohon);
      $pohon_peng1[0]=0;
      $pohon_peng2[0]=0;
      $pohon_peng3[0]=0;
      if($jumlah_jenis_pohon>0){
        $jumlah_pohon1=DB::table('data_tanaman_plot')
        ->select(DB::raw("table_master_jenis_tanaman.nama_tanaman,table_master_jenis_tanaman.nama_latin,data_tanaman_plot.id_master_jenis_tanaman,COUNT(*) as jumlah"))
        ->leftjoin(
        'table_master_jenis_tanaman',
        'table_master_jenis_tanaman.id_jenis_tanaman','=','data_tanaman_plot.id_master_jenis_tanaman'
        )
        ->where('id_plot','=',$id)
        ->where('data_tanaman_plot.pengukuran_ke','=',1)
        ->where('data_tanaman_plot.status','=','1')
        ->groupBy(DB::raw('table_master_jenis_tanaman.nama_tanaman,table_master_jenis_tanaman.nama_latin,data_tanaman_plot.id_master_jenis_tanaman'))
        ->orderBy('table_master_jenis_tanaman.nama_tanaman')
        ->get();
        $jumlah_jenis_pohon1 = count($jumlah_pohon1);
        for($i=0;$i<$jumlah_jenis_pohon;$i++){
          $pohon_peng1[$i]=0;
          for($j=0;$j<$jumlah_jenis_pohon1;$j++){
          if($data_pohon[$i]->id_master_jenis_tanaman==$jumlah_pohon1[$j]->id_master_jenis_tanaman){
            $pohon_peng1[$i]=$jumlah_pohon1[$j]->jumlah;
            break;
          }
        }
        }

        $jumlah_pohon2=DB::table('data_tanaman_plot')
        ->select(DB::raw("table_master_jenis_tanaman.nama_tanaman,table_master_jenis_tanaman.nama_latin,data_tanaman_plot.id_master_jenis_tanaman,COUNT(*) as jumlah"))
        ->leftjoin(
        'table_master_jenis_tanaman',
        'table_master_jenis_tanaman.id_jenis_tanaman','=','data_tanaman_plot.id_master_jenis_tanaman'
        )
        ->where('id_plot','=',$id)
        ->where('data_tanaman_plot.pengukuran_ke','=',2)
        ->where('data_tanaman_plot.status','=','1')
        ->groupBy(DB::raw('table_master_jenis_tanaman.nama_tanaman,table_master_jenis_tanaman.nama_latin,data_tanaman_plot.id_master_jenis_tanaman'))
        ->orderBy('table_master_jenis_tanaman.nama_tanaman')
        ->get();
        $jumlah_jenis_pohon2 = count($jumlah_pohon2);
        for($i=0;$i<$jumlah_jenis_pohon;$i++){
          $pohon_peng2[$i]=0;
          for($j=0;$j<$jumlah_jenis_pohon2;$j++){
          if($data_pohon[$i]->id_master_jenis_tanaman==$jumlah_pohon2[$j]->id_master_jenis_tanaman){
            $pohon_peng2[$i]=$jumlah_pohon2[$j]->jumlah;
            break;
          }
        }
        }

        $jumlah_pohon3=DB::table('data_tanaman_plot')
        ->select(DB::raw("table_master_jenis_tanaman.nama_tanaman,table_master_jenis_tanaman.nama_latin,data_tanaman_plot.id_master_jenis_tanaman,COUNT(*) as jumlah"))
        ->leftjoin(
        'table_master_jenis_tanaman',
        'table_master_jenis_tanaman.id_jenis_tanaman','=','data_tanaman_plot.id_master_jenis_tanaman'
        )
        ->where('id_plot','=',$id)
        ->where('data_tanaman_plot.pengukuran_ke','=',3)
        ->where('data_tanaman_plot.status','=','1')
        ->groupBy(DB::raw('table_master_jenis_tanaman.nama_tanaman,table_master_jenis_tanaman.nama_latin,data_tanaman_plot.id_master_jenis_tanaman'))
        ->orderBy('table_master_jenis_tanaman.nama_tanaman')
        ->get();
        $jumlah_jenis_pohon3 = count($jumlah_pohon3);
        for($i=0;$i<$jumlah_jenis_pohon;$i++){
          $pohon_peng3[$i]=0;
          for($j=0;$j<$jumlah_jenis_pohon3;$j++){
          if($data_pohon[$i]->id_master_jenis_tanaman==$jumlah_pohon3[$j]->id_master_jenis_tanaman){
            $pohon_peng3[$i]=$jumlah_pohon3[$j]->jumlah;
            break;
          }
        }
        }
      }

      $data_fauna = DB::table('data_fauna')
      ->select(DB::raw("tabel_master_fauna.nama_fauna,tabel_master_fauna.nama_latin_fauna,data_fauna.id_master_fauna"))
      ->leftjoin(
        'tabel_master_fauna',
        'tabel_master_fauna.id_jenis_fauna','=','data_fauna.id_master_fauna'
        )
      ->where('id_plot_fauna','=',$id)
      ->groupBy(DB::raw('tabel_master_fauna.nama_fauna,tabel_master_fauna.nama_latin_fauna,data_fauna.id_master_fauna'))
      ->orderBy('tabel_master_fauna.nama_fauna','asc')
      ->get();

      $jumlah_jenis_fauna= count($data_fauna);
      $fauna_peng1[0]=0;
      $fauna_peng2[0]=0;
      $fauna_peng3[0]=0;
      if($jumlah_jenis_fauna>0){

        $data_fauna1=DB::table('data_fauna')
        ->leftjoin(
          'tabel_master_fauna',
          'tabel_master_fauna.id_jenis_fauna','=','data_fauna.id_master_fauna'
          )
        ->where('id_plot_fauna','=',$id)
        ->where('data_fauna.pengukuran_ke','=',1)
        ->orderBy('tabel_master_fauna.nama_fauna','asc')
        ->get();
        $jumlah_jenis_fauna1 = count($data_fauna1);
        for($i=0;$i<$jumlah_jenis_fauna;$i++){
          $fauna_peng1[$i]=0;
          for($j=0;$j<$jumlah_jenis_fauna1;$j++){
          if($data_fauna[$i]->id_master_fauna==$data_fauna1[$j]->id_master_fauna){
            $fauna_peng1[$i]=$data_fauna1[$j]->jumlah;
            break;
          }
        }
        }

        $data_fauna2=DB::table('data_fauna')
        ->leftjoin(
          'tabel_master_fauna',
          'tabel_master_fauna.id_jenis_fauna','=','data_fauna.id_master_fauna'
          )
        ->where('id_plot_fauna','=',$id)
        ->where('data_fauna.pengukuran_ke','=',2)
        ->orderBy('tabel_master_fauna.nama_fauna','asc')
        ->get();
        $jumlah_jenis_fauna2 = count($data_fauna2);
        for($i=0;$i<$jumlah_jenis_fauna;$i++){
          $fauna_peng2[$i]=0;
          for($j=0;$j<$jumlah_jenis_fauna2;$j++){
          if($data_fauna[$i]->id_master_fauna==$data_fauna2[$j]->id_master_fauna){
            $fauna_peng2[$i]=$data_fauna2[$j]->jumlah;
            break;
          }
        }
        }

        $data_fauna3=DB::table('data_fauna')
        ->leftjoin(
          'tabel_master_fauna',
          'tabel_master_fauna.id_jenis_fauna','=','data_fauna.id_master_fauna'
          )
        ->where('id_plot_fauna','=',$id)
        ->where('data_fauna.pengukuran_ke','=',3)
        ->orderBy('tabel_master_fauna.nama_fauna','asc')
        ->get();
        $jumlah_jenis_fauna3 = count($data_fauna3);
        for($i=0;$i<$jumlah_jenis_fauna;$i++){
          $fauna_peng3[$i]=0;
          for($j=0;$j<$jumlah_jenis_fauna3;$j++){
          if($data_fauna[$i]->id_master_fauna==$data_fauna3[$j]->id_master_fauna){
            $fauna_peng3[$i]=$data_fauna3[$j]->jumlah;
            break;
          }
        }
        }
      }

      $data_pengukuran=DB::table('pengukuran_master')
      ->leftjoin('tbl_plot','tbl_plot.id_plot','=','pengukuran_master.id_plot')
      ->where('pengukuran_master.id_plot','=',$id)
      ->get();

      $data_id=DB::table('pengukuran_master')
      ->leftjoin('tbl_plot','tbl_plot.id_plot','=','pengukuran_master.id_plot')
      ->where('pengukuran_master.id_plot','=',$id)
      ->first();

      $nama_plot=DB::table('tbl_plot')
      ->leftjoin('tbl_klaster_plot','tbl_klaster_plot.id_klaster_plot','=','tbl_plot.id_klaster_plot')
      ->leftjoin('pola_tanam','pola_tanam.id_pola_tanam','=','tbl_klaster_plot.pola_tanam')
      ->where('id_plot','=',$id)
      ->first();

      $data_id_plot =DB::table('tbl_klaster_plot')
      ->select('id_plot')
      ->leftjoin('tbl_plot','tbl_plot.id_klaster_plot','=','tbl_klaster_plot.id_klaster_plot')
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
      $splitName_p = explode(' ', $koordinat_bujur_p, 2);
      $splitName2_p= explode(' ', $splitName_p[1], 2);
      $splitName3_p= explode(' ', $splitName2_p[1], 2);
      if($splitName_p[0]>=0){
        $ket_bujur_p='BT';

        $long_derajat = $splitName_p[0];
        $menit_b = $splitName2_p[0]/60;
        $detik_b = $splitName3_p[0]/3600;

        $koordinat_bujur_angka_klaster = $long_derajat + $menit_b + $detik_b;
      }
      else{
        $ket_bujur_p='BB';
        $splitName_p[0]=$splitName_p[0]*-1;

        $long_derajat = $splitName_p[0]*-1;
        $menit_b = $splitName2_p[0]/60;
        $detik_b = $splitName3_p[0]/3600;

        $koordinat_bujur_angka_klaster = $long_derajat - $menit_b - $detik_b;
      }



      $koor_bt_ful_p=$splitName_p[0].' ᴼ '.$splitName2_p[0].' ’ '.$splitName3_p[0].' ”';

      $koordinat_lintang_p=$nama_plot->koordinat_LS;
      $l_splitName_p = explode(' ', $koordinat_lintang_p, 2);
      $l_splitName2_p= explode(' ', $l_splitName_p[1], 2);
      $l_splitName3_p= explode(' ', $l_splitName2_p[1], 2);
      if($l_splitName_p[0]>=0){
        $ket_lintang_p='LU';

        $lat_derajat = $l_splitName_p[0];
        $menit_l = $l_splitName2_p[0]/60;
        $detik_l = $l_splitName3_p[0]/3600;

        $koordinat_lintang_angka_klaster = $lat_derajat + $menit_l + $detik_l;
      }
      else{
        $ket_lintang_p='LU';
        $l_splitName_p[0]=$l_splitName_p[0]*-1;

        $lat_derajat = $l_splitName_p[0]*-1;
        $menit_l = $l_splitName2_p[0]/60;
        $detik_l = $l_splitName3_p[0]/3600;

        $koordinat_lintang_angka_klaster = $lat_derajat - $menit_l - $detik_l;
      }


      $koor_ls_ful_p=$l_splitName_p[0].' ᴼ '.$l_splitName2_p[0].' ’ '.$l_splitName3_p[0].' ”';

      return view('user.PlotUkur.detail_data_plot',[
        'id_data_klaster2' => $id_data_klaster2,
        'koor_bt_ful_p'=>$koor_bt_ful_p,
        'koor_ls_ful_p'=>$koor_ls_ful_p,
        'ket_bujur_p'=>$ket_bujur_p,
        'ket_lintang_p'=>$ket_lintang_p,
        'jumlah_pengukuran'=>$jumlah_pengukuran,
        'data_pengukuran'=>$data_pengukuran,
        'data_id' =>$data_id,
        'nama_plot' =>$nama_plot,
        'id_plot' => $id,
        'data_id_plot' => $id_plot,
        'id_klaster' => $id_klaster_plot,
        'cek_status' => $status_lengkap,
        'data_fauna' => $data_fauna,
        'fauna_peng1' => $fauna_peng1,
        'fauna_peng2' => $fauna_peng2,
        'fauna_peng3' => $fauna_peng3,
        'data_pohon' => $data_pohon,
        'pohon_peng1' => $pohon_peng1,
        'pohon_peng2' => $pohon_peng2,
        'pohon_peng3' => $pohon_peng3,
        'koordinat_lintang_angka_klaster' => $koordinat_lintang_angka_klaster,
        'koordinat_bujur_angka_klaster' => $koordinat_bujur_angka_klaster,
      ]);
    }

    public function detail_plots(Request $req){
      $id=$req->input('nama_plot');
      $id_klaster=DB::table('tbl_plot')->select('id_klaster_plot')
      ->where('id_plot','=',$id)
      ->first();
      $id_klaster_plot=$id_klaster->id_klaster_plot;

      $id_data_klaster1 = DB::table('kategori_klaster')
      ->leftjoin('tbl_klaster_plot','tbl_klaster_plot.id_data_klaster','=','kategori_klaster.id_data_klaster')
      ->where('tbl_klaster_plot.id_klaster_plot','=',$id_klaster_plot)
      ->first();

      $id_data_klaster2 = $id_data_klaster1->id_data_klaster;

      $data_pohon = DB::table('data_tanaman_plot')
      ->select(DB::raw("table_master_jenis_tanaman.nama_tanaman,table_master_jenis_tanaman.nama_latin,data_tanaman_plot.id_master_jenis_tanaman,COUNT(*) as jumlah"))
      ->leftjoin(
      'table_master_jenis_tanaman',
      'table_master_jenis_tanaman.id_jenis_tanaman','=','data_tanaman_plot.id_master_jenis_tanaman'
      )
      ->where('id_plot','=',$id)
      ->where('data_tanaman_plot.status','=','1')
      ->groupBy(DB::raw('table_master_jenis_tanaman.nama_tanaman,table_master_jenis_tanaman.nama_latin,data_tanaman_plot.id_master_jenis_tanaman'))
      ->orderBy('table_master_jenis_tanaman.nama_tanaman')
      ->get();

      $jumlah_jenis_pohon= count($data_pohon);
      $pohon_peng1[0]=0;
      $pohon_peng2[0]=0;
      $pohon_peng3[0]=0;
      if($jumlah_jenis_pohon>0){
        $jumlah_pohon1=DB::table('data_tanaman_plot')
        ->select(DB::raw("table_master_jenis_tanaman.nama_tanaman,table_master_jenis_tanaman.nama_latin,data_tanaman_plot.id_master_jenis_tanaman,COUNT(*) as jumlah"))
        ->leftjoin(
        'table_master_jenis_tanaman',
        'table_master_jenis_tanaman.id_jenis_tanaman','=','data_tanaman_plot.id_master_jenis_tanaman'
        )
        ->where('id_plot','=',$id)
        ->where('data_tanaman_plot.pengukuran_ke','=',1)
        ->where('data_tanaman_plot.status','=','1')
        ->groupBy(DB::raw('table_master_jenis_tanaman.nama_tanaman,table_master_jenis_tanaman.nama_latin,data_tanaman_plot.id_master_jenis_tanaman'))
        ->orderBy('table_master_jenis_tanaman.nama_tanaman')
        ->get();
        $jumlah_jenis_pohon1 = count($jumlah_pohon1);
        for($i=0;$i<$jumlah_jenis_pohon;$i++){
          $pohon_peng1[$i]=0;
          for($j=0;$j<$jumlah_jenis_pohon1;$j++){
          if($data_pohon[$i]->id_master_jenis_tanaman==$jumlah_pohon1[$j]->id_master_jenis_tanaman){
            $pohon_peng1[$i]=$jumlah_pohon1[$j]->jumlah;
            break;
          }
        }
        }

        $jumlah_pohon2=DB::table('data_tanaman_plot')
        ->select(DB::raw("table_master_jenis_tanaman.nama_tanaman,table_master_jenis_tanaman.nama_latin,data_tanaman_plot.id_master_jenis_tanaman,COUNT(*) as jumlah"))
        ->leftjoin(
        'table_master_jenis_tanaman',
        'table_master_jenis_tanaman.id_jenis_tanaman','=','data_tanaman_plot.id_master_jenis_tanaman'
        )
        ->where('id_plot','=',$id)
        ->where('data_tanaman_plot.pengukuran_ke','=',2)
        ->where('data_tanaman_plot.status','=','1')
        ->groupBy(DB::raw('table_master_jenis_tanaman.nama_tanaman,table_master_jenis_tanaman.nama_latin,data_tanaman_plot.id_master_jenis_tanaman'))
        ->orderBy('table_master_jenis_tanaman.nama_tanaman')
        ->get();
        $jumlah_jenis_pohon2 = count($jumlah_pohon2);
        for($i=0;$i<$jumlah_jenis_pohon;$i++){
          $pohon_peng2[$i]=0;
          for($j=0;$j<$jumlah_jenis_pohon2;$j++){
          if($data_pohon[$i]->id_master_jenis_tanaman==$jumlah_pohon2[$j]->id_master_jenis_tanaman){
            $pohon_peng2[$i]=$jumlah_pohon2[$j]->jumlah;
            break;
          }
        }
        }

        $jumlah_pohon3=DB::table('data_tanaman_plot')
        ->select(DB::raw("table_master_jenis_tanaman.nama_tanaman,table_master_jenis_tanaman.nama_latin,data_tanaman_plot.id_master_jenis_tanaman,COUNT(*) as jumlah"))
        ->leftjoin(
        'table_master_jenis_tanaman',
        'table_master_jenis_tanaman.id_jenis_tanaman','=','data_tanaman_plot.id_master_jenis_tanaman'
        )
        ->where('id_plot','=',$id)
        ->where('data_tanaman_plot.pengukuran_ke','=',3)
        ->where('data_tanaman_plot.status','=','1')
        ->groupBy(DB::raw('table_master_jenis_tanaman.nama_tanaman,table_master_jenis_tanaman.nama_latin,data_tanaman_plot.id_master_jenis_tanaman'))
        ->orderBy('table_master_jenis_tanaman.nama_tanaman')
        ->get();
        $jumlah_jenis_pohon3 = count($jumlah_pohon3);
        for($i=0;$i<$jumlah_jenis_pohon;$i++){
          $pohon_peng3[$i]=0;
          for($j=0;$j<$jumlah_jenis_pohon3;$j++){
          if($data_pohon[$i]->id_master_jenis_tanaman==$jumlah_pohon3[$j]->id_master_jenis_tanaman){
            $pohon_peng3[$i]=$jumlah_pohon3[$j]->jumlah;
            break;
          }
        }
        }
      }

      $data_fauna = DB::table('data_fauna')
      ->select(DB::raw("tabel_master_fauna.nama_fauna,tabel_master_fauna.nama_latin_fauna,data_fauna.id_master_fauna"))
      ->leftjoin(
        'tabel_master_fauna',
        'tabel_master_fauna.id_jenis_fauna','=','data_fauna.id_master_fauna'
        )
      ->where('id_plot_fauna','=',$id)
      ->groupBy(DB::raw('tabel_master_fauna.nama_fauna,tabel_master_fauna.nama_latin_fauna,data_fauna.id_master_fauna'))
      ->orderBy('tabel_master_fauna.nama_fauna','asc')
      ->get();

      $jumlah_jenis_fauna= count($data_fauna);
      $fauna_peng1[0]=0;
      $fauna_peng2[0]=0;
      $fauna_peng3[0]=0;
      if($jumlah_jenis_fauna>0){

        $data_fauna1=DB::table('data_fauna')
        ->leftjoin(
          'tabel_master_fauna',
          'tabel_master_fauna.id_jenis_fauna','=','data_fauna.id_master_fauna'
          )
        ->where('id_plot_fauna','=',$id)
        ->where('data_fauna.pengukuran_ke','=',1)
        ->orderBy('tabel_master_fauna.nama_fauna','asc')
        ->get();
        $jumlah_jenis_fauna1 = count($data_fauna1);
        for($i=0;$i<$jumlah_jenis_fauna;$i++){
          $fauna_peng1[$i]=0;
          for($j=0;$j<$jumlah_jenis_fauna1;$j++){
          if($data_fauna[$i]->id_master_fauna==$data_fauna1[$j]->id_master_fauna){
            $fauna_peng1[$i]=$data_fauna1[$j]->jumlah;
            break;
          }
        }
        }

        $data_fauna2=DB::table('data_fauna')
        ->leftjoin(
          'tabel_master_fauna',
          'tabel_master_fauna.id_jenis_fauna','=','data_fauna.id_master_fauna'
          )
        ->where('id_plot_fauna','=',$id)
        ->where('data_fauna.pengukuran_ke','=',2)
        ->orderBy('tabel_master_fauna.nama_fauna','asc')
        ->get();
        $jumlah_jenis_fauna2 = count($data_fauna2);
        for($i=0;$i<$jumlah_jenis_fauna;$i++){
          $fauna_peng2[$i]=0;
          for($j=0;$j<$jumlah_jenis_fauna2;$j++){
          if($data_fauna[$i]->id_master_fauna==$data_fauna2[$j]->id_master_fauna){
            $fauna_peng2[$i]=$data_fauna2[$j]->jumlah;
            break;
          }
        }
        }

        $data_fauna3=DB::table('data_fauna')
        ->leftjoin(
          'tabel_master_fauna',
          'tabel_master_fauna.id_jenis_fauna','=','data_fauna.id_master_fauna'
          )
        ->where('id_plot_fauna','=',$id)
        ->where('data_fauna.pengukuran_ke','=',3)
        ->orderBy('tabel_master_fauna.nama_fauna','asc')
        ->get();
        $jumlah_jenis_fauna3 = count($data_fauna3);
        for($i=0;$i<$jumlah_jenis_fauna;$i++){
          $fauna_peng3[$i]=0;
          for($j=0;$j<$jumlah_jenis_fauna3;$j++){
          if($data_fauna[$i]->id_master_fauna==$data_fauna3[$j]->id_master_fauna){
            $fauna_peng3[$i]=$data_fauna3[$j]->jumlah;
            break;
          }
        }
        }
      }

      $data_pengukuran=DB::table('pengukuran_master')
      ->leftjoin('tbl_plot','tbl_plot.id_plot','=','pengukuran_master.id_plot')
      ->where('pengukuran_master.id_plot','=',$id)
      ->get();

      $data_id=DB::table('pengukuran_master')
      ->leftjoin('tbl_plot','tbl_plot.id_plot','=','pengukuran_master.id_plot')
      ->where('pengukuran_master.id_plot','=',$id)
      ->first();

      $nama_plot=DB::table('tbl_plot')
      ->leftjoin('tbl_klaster_plot','tbl_klaster_plot.id_klaster_plot','=','tbl_plot.id_klaster_plot')
      ->leftjoin('pola_tanam','pola_tanam.id_pola_tanam','=','tbl_klaster_plot.pola_tanam')
      ->where('id_plot','=',$id)
      ->first();

      $data_id_plot =DB::table('tbl_klaster_plot')
      ->select('id_plot')
      ->leftjoin('tbl_plot','tbl_plot.id_klaster_plot','=','tbl_klaster_plot.id_klaster_plot')
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
      $splitName_p = explode(' ', $koordinat_bujur_p, 2);
      $splitName2_p= explode(' ', $splitName_p[1], 2);
      $splitName3_p= explode(' ', $splitName2_p[1], 2);
      if($splitName_p[0]>=0){
        $ket_bujur_p='BT';

        $long_derajat = $splitName_p[0];
        $menit_b = $splitName2_p[0]/60;
        $detik_b = $splitName3_p[0]/3600;

        $koordinat_bujur_angka_klaster = $long_derajat + $menit_b + $detik_b;
      }
      else{
        $ket_bujur_p='BB';
        $splitName_p[0]=$splitName_p[0]*-1;

        $long_derajat = $splitName_p[0]*-1;
        $menit_b = $splitName2_p[0]/60;
        $detik_b = $splitName3_p[0]/3600;

        $koordinat_bujur_angka_klaster = $long_derajat - $menit_b - $detik_b;
      }



      $koor_bt_ful_p=$splitName_p[0].' ᴼ '.$splitName2_p[0].' ’ '.$splitName3_p[0].' ”';

      $koordinat_lintang_p=$nama_plot->koordinat_LS;
      $l_splitName_p = explode(' ', $koordinat_lintang_p, 2);
      $l_splitName2_p= explode(' ', $l_splitName_p[1], 2);
      $l_splitName3_p= explode(' ', $l_splitName2_p[1], 2);
      if($l_splitName_p[0]>=0){
        $ket_lintang_p='LU';

        $lat_derajat = $l_splitName_p[0];
        $menit_l = $l_splitName2_p[0]/60;
        $detik_l = $l_splitName3_p[0]/3600;

        $koordinat_lintang_angka_klaster = $lat_derajat + $menit_l + $detik_l;
      }
      else{
        $ket_lintang_p='LU';
        $l_splitName_p[0]=$l_splitName_p[0]*-1;

        $lat_derajat = $l_splitName_p[0]*-1;
        $menit_l = $l_splitName2_p[0]/60;
        $detik_l = $l_splitName3_p[0]/3600;

        $koordinat_lintang_angka_klaster = $lat_derajat - $menit_l - $detik_l;
      }


      $koor_ls_ful_p=$l_splitName_p[0].' ᴼ '.$l_splitName2_p[0].' ’ '.$l_splitName3_p[0].' ”';

      return view('user.PlotUkur.detail_data_plot',[
        'id_data_klaster2' => $id_data_klaster2,
        'koor_bt_ful_p'=>$koor_bt_ful_p,
        'koor_ls_ful_p'=>$koor_ls_ful_p,
        'ket_bujur_p'=>$ket_bujur_p,
        'ket_lintang_p'=>$ket_lintang_p,
        'jumlah_pengukuran'=>$jumlah_pengukuran,
        'data_pengukuran'=>$data_pengukuran,
        'data_id' =>$data_id,
        'nama_plot' =>$nama_plot,
        'id_plot' => $id,
        'data_id_plot' => $id_plot,
        'id_klaster' => $id_klaster_plot,
        'cek_status' => $status_lengkap,
        'data_fauna' => $data_fauna,
        'fauna_peng1' => $fauna_peng1,
        'fauna_peng2' => $fauna_peng2,
        'fauna_peng3' => $fauna_peng3,
        'data_pohon' => $data_pohon,
        'pohon_peng1' => $pohon_peng1,
        'pohon_peng2' => $pohon_peng2,
        'pohon_peng3' => $pohon_peng3,
        'koordinat_lintang_angka_klaster' => $koordinat_lintang_angka_klaster,
        'koordinat_bujur_angka_klaster' => $koordinat_bujur_angka_klaster,
      ]);
    }

    public function tambahKimia(Request $req)
    {
      $req->validate([
          'id_klasters_plot'=>'required',
          'tambah_sifat'=>'required',
          'tambah_cec'=>'required|numeric|min:0|max:100',
          'pengukurans_ke'=>'required|integer',
        ]);
      $kode_klaster = $req->input('id_klasters_plot');
      $id_sifat = $req->input('tambah_sifat');
      $cec = $req->input('tambah_cec');
      $pengukuran_ke = $req->input('pengukurans_ke');

      $data_ktk = array(
        'kode_klaster' => $kode_klaster,
        'id_sifat' => $id_sifat,
        'cec' =>$cec,
        'pengukuran_ke' => $pengukuran_ke,
      );
      try{
        DB::table('ktk_kimia')->insert($data_ktk);
        session()->flash('insert', 'Data kualitas tapak kimia berhasil ditambah.');
      }
      catch(\Illuminate\Database\QueryException $e){
        throw new CustomException($e->getMessage());
      }

      return back();
    }

    public function hapus_kimia(Request $req)
    {
      try{
        DB::table('ktk_kimia')->where('id_ktk',$req->input('hapus_id'))->delete();
        session()->flash('delete', 'Data kualitas tapak berhasil dihapus.');
      }
      catch(\Illuminate\Database\QueryException $e){
        throw new CustomException($e->getMessage());
      }

      return back();
    }

    public function editKimia(Request $req)
    {
      $req->validate([
          'edit_sifat'=>'required',
          'id_ktk2'=>'required',
          'edit_cec'=>'required|numeric|min:0|max:100',
          'pengukurans_ke2'=>'required|integer',
        ]);
      $id_sifat = $req->input('edit_sifat');
      $id_ktk = $req->input('id_ktk2');
      $cec= $req->input('edit_cec');
      $pengukuran_ke = $req->input('pengukurans_ke2');
      $data_kimia = array(
        'id_sifat' => $id_sifat,
        'cec' => $cec,
        'pengukuran_ke' => $pengukuran_ke,
      );
      try{
        DB::table('ktk_kimia')->where('id_ktk',$id_ktk)->update($data_kimia);
        session()->flash('edit', 'Data kualitas tapak berhasil diubah.');
      }
      catch(\Illuminate\Database\QueryException $e){
        throw new CustomException($e->getMessage());
      }

      return back();
    }

    public function tambahFisik(Request $req)
    {
      $req->validate([
          'tambah_titik_plot'=>'required',
          'id_klaster_plot'=>'required|integer',
          'id_plot'=>'required|integer',
          'pengukuran_ke'=>'required|integer',
          'terbuka'=>'required|numeric|min:0|max:100',
          'tertutup'=>'required|numeric|min:0|max:100',
          'tekstur'=>'required|regex:/^[a-zA-Z ]{1,}$/',
          'warna' => 'required|regex:/^[a-zA-Z ]{1,}$/',
          'ketebalan'=>'required|numeric|min:0|max:100',
          'lintang'=>'required',
          'bujur'=>'required',
        ]);

        $koorniatBT = $req->input('bujur');
        $koorniatLS = $req->input('lintang');
        $ket_lintang = $req->input('pilih_lintang');
        $ket_bujur = $req->input('pilih_bujur');

        if($koorniatBT==""){
          $koorniatBT = "000 ᴼ 00 ’ 00.00 ”";
        }
        if($koorniatLS==""){
          $koorniatLS = "00 ᴼ 00 ’ 00.00 ”";
        }
        $pattern = '/_/i';
        if(preg_match($pattern,$koorniatBT) || preg_match($pattern,$koorniatLS) ){
          session()->flash('delete', 'Koordinat yang dimasukkan salah.');
          return back();
        }

        $splitName = explode(' ᴼ', $koorniatBT, 2);
        $splitName2= explode(' ’', $splitName[1], 2);
        $splitName3= explode(' ”', $splitName2[1], 2);
        if($ket_bujur=='BT'){
          $koor_bt_ful=$splitName[0].$splitName2[0].$splitName3[0];
        }
        else{
          $koor_bt_ful='-'.$splitName[0].$splitName2[0].$splitName3[0];
        }


        $ls_splitName = explode(' ᴼ', $koorniatLS, 2);
        $ls_splitName2= explode(' ’', $ls_splitName[1], 2);
        $ls_splitName3= explode(' ”', $ls_splitName2[1], 2);
        if($ket_lintang=='LS'){
          $koor_ls_ful='-'.$ls_splitName[0].$ls_splitName2[0].$ls_splitName3[0];
        }
        else{
          $koor_ls_ful=$ls_splitName[0].$ls_splitName2[0].$ls_splitName3[0];
        }


      $kode_klaster = $req->input('id_klaster_plot');
      $kode_plot = $req->input('id_plot');
      $pengukuran_ke = $req->input('pengukuran_ke');
      $titik_plot = $req->input('tambah_titik_plot');
      $terbuka = $req->input('terbuka');
      $tertutup = 100-$terbuka;
      $tekstur = $req->input('tekstur');
      $warna = $req->input('warna');
      $ketebalan = $req->input('ketebalan');
      $lintang = $koorniatBT;
      $bujur = $koorniatLS;

      $data_ktk = array(
        'kode_klaster' => $kode_klaster,
        'kode_plot' => $kode_plot,
        'pengukuran_ke' => $pengukuran_ke,
        'titik_plot' => $titik_plot,
        'terbuka' => $terbuka,
        'tertutup' => $tertutup,
        'tekstur' => $tekstur,
        'warna_tanah' => $warna,
        'ketebalan' => $ketebalan,
        'lintang_tanah' =>$koor_ls_ful,
        'bujur_tanah' => $koor_bt_ful,
      );
      try{
        DB::table('ktk_fisika')->insert($data_ktk);
        session()->flash('insert', 'Data kualitas tapak fisik berhasil ditambah.');
      }
      catch(\Illuminate\Database\QueryException $e){
        throw new CustomException($e->getMessage());
      }

      return back();
    }

    public function editFisik(Request $req)
    {
      $req->validate([
        'id_ktk' => 'required',
        'tambah_titik_plot2'=>'required',
        'id_klaster_plot2'=>'required|integer',
        'id_plot2'=>'required|integer',
        'pengukuran_ke2'=>'required|integer',
        'terbuka2'=>'required|numeric|min:0|max:100',
        'tertutup2'=>'required|numeric|min:0|max:100',
        'tekstur2'=>'required|regex:/^[a-zA-Z ]{1,}$/',
        'warna2'=>'required|regex:/^[a-zA-Z ]{1,}$/',
        'ketebalan2'=>'required|numeric|min:0|max:100',
        'lintang2'=>'required',
        'bujur2'=>'required',
        ]);
        $koorniatBT = $req->input('bujur2');
        $koorniatLS = $req->input('lintang2');
        $ket_bujur = $req->input('pilih_bujur2');
        $ket_lintang = $req->input('pilih_lintang2');


        if($koorniatBT==""){
          $koorniatBT = "000 ᴼ 00 ’ 00.00 ”";
        }
        if($koorniatLS==""){
          $koorniatLS = "00 ᴼ 00 ’ 00.00 ”";
        }
        $pattern = '/_/i';
        if(preg_match($pattern,$koorniatBT) || preg_match($pattern,$koorniatLS) ){
          session()->flash('delete', 'Koordinat yang dimasukkan salah.');
          return back();
        }

        $splitName = explode(' ᴼ', $koorniatBT, 2);
        $splitName2= explode(' ’', $splitName[1], 2);
        $splitName3= explode(' ”', $splitName2[1], 2);
        if($ket_bujur=='BT'){
          $koor_bt_ful=$splitName[0].$splitName2[0].$splitName3[0];
        }
        else{
          $koor_bt_ful='-'.$splitName[0].$splitName2[0].$splitName3[0];
        }


        $ls_splitName = explode(' ᴼ', $koorniatLS, 2);
        $ls_splitName2= explode(' ’', $ls_splitName[1], 2);
        $ls_splitName3= explode(' ”', $ls_splitName2[1], 2);
        if($ket_lintang=='LS'){
          $koor_ls_ful='-'.$ls_splitName[0].$ls_splitName2[0].$ls_splitName3[0];
        }
        else{
          $koor_ls_ful=$ls_splitName[0].$ls_splitName2[0].$ls_splitName3[0];
        }


      $id_ktk = $req->input('id_ktk');
      $kode_klaster = $req->input('id_klaster_plot2');
      $kode_plot = $req->input('id_plot2');
      $pengukuran_ke = $req->input('pengukuran_ke2');
      $titik_plot = $req->input('tambah_titik_plot2');
      $terbuka = $req->input('terbuka2');
      $tertutup = 100-$terbuka;
      $tekstur = $req->input('tekstur2');
      $warna = $req->input('warna2');
      $ketebalan = $req->input('ketebalan2');
      $lintang = $koorniatBT;
      $bujur = $koorniatLS;

      $data_ktk = array(
        'kode_klaster' => $kode_klaster,
        'kode_plot' => $kode_plot,
        'pengukuran_ke' => $pengukuran_ke,
        'titik_plot' => $titik_plot,
        'terbuka' => $terbuka,
        'tertutup' => $tertutup,
        'tekstur' => $tekstur,
        'warna_tanah' => $warna,
        'ketebalan' => $ketebalan,
        'lintang_tanah' =>$koor_ls_ful,
        'bujur_tanah' => $koor_bt_ful,
      );
      try{
        DB::table('ktk_fisika')->where('id_ktk',$id_ktk)->update($data_ktk);
        session()->flash('edit', 'Data kualitas tapak berhasil diubah.');
      }
      catch(\Illuminate\Database\QueryException $e){
        throw new CustomException($e->getMessage());
      }

      return back();
    }

    public function hapus_fisika(Request $req)
    {
      try{
        DB::table('ktk_fisika')->where('id_ktk',$req->input('hapus_id'))->delete();
        session()->flash('delete', 'Data kualitas tapak berhasil dihapus.');
      }
      catch(\Illuminate\Database\QueryException $e){
        throw new CustomException($e->getMessage());
      }

      return back();
    }


    public function tertimbang($id)
    {
      $id=decrypt($id);
      $nama_data_klaster = DB::table('kategori_klaster')
      ->where('id_data_klaster', '=', $id)->first();

      $data_nilai = DB::table('nilai_tertimbang_copy')
      ->where('id_data_klaster', '=', $id)
      ->first();

      return view('user.PlotUkur.nilaiTertimbang',[
        'nama'=>$nama_data_klaster,
        'data_nilai'=>$data_nilai,

      ]);
    }

    public function hapus_prod(Request $req)
    {
      DB::table('nilai_tertimbang')->where('id',$req->input('hapus_id_nt'))->delete();
      return back();
    }

    public function edit_tertimbang(Request $req)
    {
        $id = $req->input('id_indikator2');
        // $id_master_indikator = $req->input('nama_indikator2');
        $nilai = $req->input('nilai_indikator2');
        $nama_param = $req->input('nama_indikator2');

        if($nama_param=="Produktivitas"){
          $data_indikator = array(
            'nilai_prod' => $nilai,
          );
        }
        else if($nama_param=="Kerusakan Pohon"){
          $data_indikator = array(
            'nilai_kphn' => $nilai,
          );
        }
        else if($nama_param=="Kondisi Tajuk"){
          $data_indikator = array(
            'nilai_ktjk' => $nilai,
          );
        }
        else if($nama_param=="Biodiversitas Pohon"){
          $data_indikator = array(
            'nilai_kjpb' => $nilai,
          );
        }
        else if($nama_param=="Biodiversitas Fauna"){
          $data_indikator = array(
            'nilai_kjfb' => $nilai,
          );
        }
        else if($nama_param=="Kualitas Tapak"){
          $data_indikator = array(
            'nilai_ktpk' => $nilai,
          );
        }

      try{
        DB::table('nilai_tertimbang_copy')->where('id', $id)->update($data_indikator);
      } catch(\Illuminate\Database\QueryException $e){
        throw new CustomException($e->getMessage());
      }
      session()->flash('insert', 'Nilai tertimbang berhasil diubah.');
      return back();
    }
}
