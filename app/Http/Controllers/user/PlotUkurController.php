<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
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
      ->where('input_by','=',Auth::user()->id)
      ->orderBy('nama_data_klaster')->get();

      $data_kategori = DB::table('kategori_klaster')->get();

      return view('user.PlotUkur.data_klaster',compact('data_klaster','data_kategori')
      );
    }

    public function indexDataKlaster()
    {
      // mengembalikan nilai data klaster
      $data_klaster = DB::table('tbl_data_klaster')
      ->where('input_by','=',Auth::user()->id)
      ->orderBy('nama_data_klaster')->get();

      $data_kategori = DB::table('kategori_klaster')->get();

      return view('user.PlotUkur.data_klaster_plot',compact('data_klaster','data_kategori')
      );
    }

    public function indexDataPlot()
    {
      // mengembalikan nilai data klaster
      $data_klaster = DB::table('tbl_data_klaster')
      ->where('input_by','=',Auth::user()->id)
      ->orderBy('nama_data_klaster')->get();

      return view('user.PlotUkur.data_plot',compact('data_klaster')
      );
    }

    // memasukkan data kedalam tbl_data_klaster
    public function insert(Request $req)
    {
      $req->validate([
          'pengukuranke1'=>'required|integer',
          'tahun_pengukuran_modal'=>'required|date',
          'nama_pengukur'=>'required|regex:/^[a-zA-Z,\' ]{2,50}$/',
          'kategori_modal' => 'unique:kategori_klaster,kategori,NULL,pengukuran_ke',
        ]);

      $input_by = Auth::user()->id; //berdasarkan id masing-masing user
      $pengukuran_ke = $req->input('pengukuranke1');
      $tahun_pengukuran = $req->input('tahun_pengukuran_modal');
      $nama_pengukur = $req->input('nama_pengukur');
      $kategori = $req->input('kategori_modal');
      $id_data_klaster2 = $req->input('tahun_pengukuran_pertama');
      $kategori2 = $req->input('pengukur_pertama');
      if($pengukuran_ke==1){
        $req->validate([
        'kategori_modal'=>'required|regex:/^[a-zA-Z() ]{2,50}$/',
        ]);
        try{
          $data_klaster = array(
            'pengukuran_ke'=> $pengukuran_ke,
            'tahun_pengukuran'=> $tahun_pengukuran,
            'nama_pengukur'=> $nama_pengukur,
            'kategori'=> $kategori,
            "input_by"=> Auth::User()->id,
          );

          DB::table('kategori_klaster')->insert($data_klaster);

          $id_data_klaster = DB::table('kategori_klaster')
          ->select(DB::raw('MAX(id_data_klaster) AS id_data_klaster'))
          ->where('input_by','=',Auth::user()->id)
          ->first();

          $data_tertimbang = array(
            "id_data_klaster" => $id_data_klaster->id_data_klaster,
          );

          DB::table('nilai_tertimbang_copy')->insert($data_tertimbang);
          session()->flash('insert', 'Data berhasil ditambah.');
        }
        catch(\Illuminate\Database\QueryException $e){
          throw new CustomException($e->getMessage());
        }
      }
      else if($pengukuran_ke==2){
        $req->validate([
            'pengukur_pertama'=>'required',
            'tahun_pengukuran_pertama'=>'required|unique:kategori_klaster,id_data_klaster2,NULL,pengukuran_ke',
          ]);
        try{
          $data_klaster = array(
            'id_data_klaster2' => $id_data_klaster2,
            'pengukuran_ke'=> $pengukuran_ke,
            'tahun_pengukuran'=> $tahun_pengukuran,
            'nama_pengukur'=> $nama_pengukur,
            'kategori'=> $kategori2,
            "input_by"=> Auth::User()->id,
          );

          DB::table('kategori_klaster')->insert($data_klaster);

          $id_data_klaster = DB::table('kategori_klaster')
          ->where('id_data_klaster2','=',$id_data_klaster2)
          ->where('pengukuran_ke','=',2)
          ->first();

          $data_tertimbang = array(
            "id_data_klaster" => $id_data_klaster->id_data_klaster,
          );

          DB::table('nilai_tertimbang_copy')->insert($data_tertimbang);
          session()->flash('insert', 'Data berhasil ditambah.');
        }
        catch(\Illuminate\Database\QueryException $e){
          throw new CustomException($e->getMessage());
        }

        $data_semua_klaster = DB::table('tbl_klaster_plot')
        ->join('kategori_klaster','kategori_klaster.id_data_klaster','=','tbl_klaster_plot.id_data_klaster')
        ->where('tbl_klaster_plot.id_data_klaster','=',$id_data_klaster2)->get();
        $z=0;
        foreach ($data_semua_klaster as $data_semua_klaster) {
          $id_klaster2[$z] = $data_semua_klaster->id_klaster_plot;
          $z++;
        }

        for($i=0;$i<$z;$i++){
          $data_semua_plot = DB::table('tbl_plot')
          ->join('tbl_klaster_plot','tbl_klaster_plot.id_klaster_plot','=','tbl_plot.id_klaster_plot')
          ->where('tbl_plot.id_klaster_plot','=',$id_klaster2[$i])
          ->get();

          $id_plot[$i][0] = $data_semua_plot[0]->id_plot;
          $id_plot[$i][1] = $data_semua_plot[1]->id_plot;
          $id_plot[$i][2] = $data_semua_plot[2]->id_plot;
          $id_plot[$i][3] = $data_semua_plot[3]->id_plot;

          $pengukuran_master = array(
            'pengukuran_ke' => $pengukuran_ke,
            'id_data_klaster' => $id_data_klaster->id_data_klaster,
            'id_plot' => $id_plot[$i][0],
            'tahun_pengukuran' => $tahun_pengukuran,
            'nama_pengukur' => $nama_pengukur,
          );

          $pengukuran_master2 = array(
            'pengukuran_ke' => $pengukuran_ke,
            'id_data_klaster' => $id_data_klaster->id_data_klaster,
            'id_plot' => $id_plot[$i][1],
            'tahun_pengukuran' => $tahun_pengukuran,
            'nama_pengukur' => $nama_pengukur,
          );

          $pengukuran_master3 = array(
            'pengukuran_ke' => $pengukuran_ke,
            'id_data_klaster' => $id_data_klaster->id_data_klaster,
            'id_plot' => $id_plot[$i][2],
            'tahun_pengukuran' => $tahun_pengukuran,
            'nama_pengukur' => $nama_pengukur,
          );

          $pengukuran_master4 = array(
            'pengukuran_ke' => $pengukuran_ke,
            'id_data_klaster' => $id_data_klaster->id_data_klaster,
            'id_plot' => $id_plot[$i][3],
            'tahun_pengukuran' => $tahun_pengukuran,
            'nama_pengukur' => $nama_pengukur,
          );

          try{
            DB::beginTransaction();
            DB::table('pengukuran_master')->insert($pengukuran_master);
            DB::table('pengukuran_master')->insert($pengukuran_master2);
            DB::table('pengukuran_master')->insert($pengukuran_master3);
            DB::table('pengukuran_master')->insert($pengukuran_master4);
            DB::commit();
            session()->flash('insert', 'Data berhasil ditambah.');
          }
          catch(\Illuminate\Database\QueryException $e){
            throw new CustomException($e->getMessage());
          }
        }



      }

      else{
        $req->validate([
            'pengukur_pertama'=>'required',
            'tahun_pengukuran_pertama'=>'required|unique:kategori_klaster,id_data_klaster2,NULL,pengukuran_ke',
          ]);
        try{
          $data_klaster = array(
            'id_data_klaster2' => $id_data_klaster2,
            'pengukuran_ke'=> $pengukuran_ke,
            'tahun_pengukuran'=> $tahun_pengukuran,
            'nama_pengukur'=> $nama_pengukur,
            'kategori'=> $kategori2,
            "input_by"=> Auth::User()->id,
          );

          DB::table('kategori_klaster')->insert($data_klaster);

          $id_data_klaster = DB::table('kategori_klaster')
          ->where('id_data_klaster2','=',$id_data_klaster2)
          ->where('pengukuran_ke','=',3)
          ->first();

          $data_tertimbang = array(
            "id_data_klaster" => $id_data_klaster->id_data_klaster,
          );

          DB::table('nilai_tertimbang_copy')->insert($data_tertimbang);
          session()->flash('insert', 'Data berhasil ditambah.');
        }
        catch(\Illuminate\Database\QueryException $e){
          throw new CustomException($e->getMessage());
        }

        $data_semua_klaster = DB::table('tbl_klaster_plot')
        ->join('kategori_klaster','kategori_klaster.id_data_klaster','=','tbl_klaster_plot.id_data_klaster')
        ->where('tbl_klaster_plot.id_data_klaster','=',$id_data_klaster2)->get();
        $z=0;
        foreach ($data_semua_klaster as $data_semua_klaster) {
          $id_klaster2[$z] = $data_semua_klaster->id_klaster_plot;
          $z++;
        }

        for($i=0;$i<$z;$i++){
          $data_semua_plot = DB::table('tbl_plot')
          ->join('tbl_klaster_plot','tbl_klaster_plot.id_klaster_plot','=','tbl_plot.id_klaster_plot')
          ->where('tbl_plot.id_klaster_plot','=',$id_klaster2[$i])
          ->get();

          $id_plot[$i][0] = $data_semua_plot[0]->id_plot;
          $id_plot[$i][1] = $data_semua_plot[1]->id_plot;
          $id_plot[$i][2] = $data_semua_plot[2]->id_plot;
          $id_plot[$i][3] = $data_semua_plot[3]->id_plot;

          $pengukuran_master = array(
            'pengukuran_ke' => $pengukuran_ke,
            'id_plot' => $id_plot[$i][0],
            'tahun_pengukuran' => $tahun_pengukuran,
            'nama_pengukur' => $nama_pengukur,
          );

          $pengukuran_master2 = array(
            'pengukuran_ke' => $pengukuran_ke,
            'id_plot' => $id_plot[$i][1],
            'tahun_pengukuran' => $tahun_pengukuran,
            'nama_pengukur' => $nama_pengukur,
          );

          $pengukuran_master3 = array(
            'pengukuran_ke' => $pengukuran_ke,
            'id_plot' => $id_plot[$i][2],
            'tahun_pengukuran' => $tahun_pengukuran,
            'nama_pengukur' => $nama_pengukur,
          );

          $pengukuran_master4 = array(
            'pengukuran_ke' => $pengukuran_ke,
            'id_plot' => $id_plot[$i][3],
            'tahun_pengukuran' => $tahun_pengukuran,
            'nama_pengukur' => $nama_pengukur,
          );

          try{
            DB::table('pengukuran_master')->insert($pengukuran_master);
            DB::table('pengukuran_master')->insert($pengukuran_master2);
            DB::table('pengukuran_master')->insert($pengukuran_master3);
            DB::table('pengukuran_master')->insert($pengukuran_master4);
            session()->flash('insert', 'Data berhasil ditambah.');
          }
          catch(\Illuminate\Database\QueryException $e){
            throw new CustomException($e->getMessage());
          }
        }



      }


      return back();
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
                      ->where('input_by','=',Auth::user()->id)
                      ->orderBy('kategori')->get();

      $data_kategori = DB::table('kategori_klaster')->get();

      return view('user.PlotUkur.daftar_data_klaster',compact('data_klaster','data_kategori'));
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
      return view('user.PlotUkur.klaster_plot',compact('data_klaster_plot','data_nama_klaster','provinsi','kepemilikan','jenis','pola','jenis_pengelola','data_pengukuran','fungsi','ijin'));
    }

    public function edit(Request $req){
      $req->validate([
          'id_data_klaster' => 'required|integer',
          'edit_pengukuranke1'=>'required|integer',
          'edit_tahun_pengukuran_modal'=>'required|date',
          'edit_nama_pengukur'=>'required|regex:/^[a-zA-Z,\' ]{2,50}$/',
          'edit_kategori_modal'=>'required|regex:/^[a-zA-Z() ]{2,50}$/',
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
      return redirect('user/plot_ukur/klaster');
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
      ->where('input_by','=',Auth::user()->id)
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
        ->where('input_by','=',Auth::user()->id)
        ->orderBy('kategori')
        ->get();
      }
      else if($pengukuran_ke=="99"){
        $data_kategori = DB::table('kategori_klaster')
        ->where('pengukuran_ke','=',1)
        ->orderBy('kategori')
        ->get();
      }
      else{
        $data_kategori = DB::table('kategori_klaster')
        ->where('pengukuran_ke','=',1)
        // ->where('input_by','=',Auth::user()->id)
        ->orderBy('kategori')
        ->get();
      }

      return response()->json($data_kategori);
    }

}
