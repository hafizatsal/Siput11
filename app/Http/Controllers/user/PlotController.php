<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Exceptions\CustomException;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Validator;
use App\Rules\ValidJumlah;

class PlotController extends Controller
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

    public function lihatPlot($id){

      $id=decrypt($id);
      $id_klaster_plot= DB::table('tbl_plot')->select('id_klaster_plot')
      ->where('id_plot','=',$id)->first();

      $data_pohon=DB::table('data_tanaman_plot')
      ->join(
        'table_master_jenis_tanaman',
        'table_master_jenis_tanaman.id_jenis_tanaman','=','data_tanaman_plot.id_master_jenis_tanaman'
        )
      ->where('id_plot','=',$id)
      ->get();

        $data_fauna=DB::table('data_fauna')
        ->join(
          'tabel_master_fauna',
          'tabel_master_fauna.id_jenis_fauna','=','data_fauna.id_master_fauna'
          )
        ->where('id_plot_fauna','=',$id)
        ->get();

        $jumlah_pohon=DB::table('data_tanaman_plot')
        ->select(DB::raw("table_master_jenis_tanaman.nama_tanaman,table_master_jenis_tanaman.nama_latin,COUNT(*) as jumlah"))
        ->join(
        'table_master_jenis_tanaman',
        'table_master_jenis_tanaman.id_jenis_tanaman','=','data_tanaman_plot.id_master_jenis_tanaman'
        )
        ->where('id_plot','=',$id)
        ->groupBy(DB::raw('table_master_jenis_tanaman.nama_tanaman,table_master_jenis_tanaman.nama_latin'))
        ->get();

        $jumlah_fauna=DB::table('data_fauna')
        ->join(
        'tabel_master_fauna',
        'tabel_master_fauna.id_jenis_fauna','=','data_fauna.id_master_fauna'
        )
        ->where('id_plot_fauna','=',$id)
        ->get();


        $data_plot=DB::table('tbl_plot')
          ->leftjoin('tbl_klaster_plot','tbl_klaster_plot.id_klaster_plot','=','tbl_plot.id_klaster_plot')
          ->leftjoin('pola_tanam','pola_tanam.id_pola_tanam','=','tbl_klaster_plot.pola_tanam')
          ->leftjoin('lokasi','lokasi.id_klaster_plot','=','tbl_klaster_plot.id_klaster_plot')
          ->leftjoin('desa','desa.id','=','lokasi.id_desa')
          ->leftjoin('kecamatan','kecamatan.id','=','lokasi.id_kecamatan')
          ->leftjoin('kabupaten','kabupaten.id','=','lokasi.id_kabupaten')
          ->leftjoin('provinsi','provinsi.id_provinsi','=','lokasi.id_provinsi')
          ->where('tbl_plot.id_plot','=',$id)
          ->orderBy('tbl_plot.id_plot', 'ASC')
          ->first();

          $pengukuran=DB::table('pengukuran_master')->select('pengukuran_master.*', DB::raw("DATE_FORMAT(pengukuran_master.tahun_pengukuran, '%d-%m-%Y') as tahun"))->where('id_plot','=',$id)->get();

          $master_pohon = DB::table('table_master_jenis_tanaman')->get();
          $master_fauna = DB::table('tabel_master_fauna')->get();


          // $jumlah_pohon_klaster=DB::table('data_tanaman_plot')
          // ->select(DB::raw("table_master_jenis_tanaman.nama_tanaman, COUNT(*) as jumlah"))
          // ->join(
          // 'table_master_jenis_tanaman',
          // 'table_master_jenis_tanaman.id_jenis_tanaman','=','data_tanaman_plot.id_master_jenis_tanaman'
          // )
          // ->join(
          //   'tbl_klaster_plot',
          //   'tbl_klaster_plot.id_klaster_plot','=','data_tanaman_plot.id_klaster_plot'
          //   )
          // ->where('data_tanaman_plot.id_klaster_plot','=',$id_klaster_plot->id_klaster_plot)
          // ->groupBy(DB::raw('table_master_jenis_tanaman.nama_tanaman'))
          // ->get();
          $id_klasters=$id_klaster_plot->id_klaster_plot;
        return view('user.detail_plot',[
          'data'=>$data_pohon,
          'data_fauna'=>$data_fauna,
          'plot'=>$data_plot,
          'jumlah_pohon'=>$jumlah_pohon,
          'jumlah_fauna'=>$jumlah_fauna,
          'pengukuran' => $pengukuran,
          'master_pohon' => $master_pohon,
          'master_fauna' => $master_fauna,
          'id_klaster'=> $id_klasters,
          // 'jumlah_pohon_klaster'=>$jumlah_pohon_klaster,
        ]);

    }

      public function tambahPengukuranPlot($id){
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
        $pengukuran_ke=$data_pengukuran->pengukuran_ke;

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
        ->where('id_pengukuran','=',$id)
        ->where('data_tanaman_plot.pengukuran_ke','=',$pengukuran_ke)
        ->get();

        $jumlah_pohon_kerusakan=DB::table('data_tanaman_plot')
        ->select(DB::raw("table_master_jenis_tanaman.nama_tanaman,kerusakan_pohon.tli, COUNT(*) as jumlah"))
        ->join(
        'table_master_jenis_tanaman',
        'table_master_jenis_tanaman.id_jenis_tanaman','=','data_tanaman_plot.id_master_jenis_tanaman'
        )
        ->join(
          'tbl_klaster_plot',
          'tbl_klaster_plot.id_klaster_plot','=','data_tanaman_plot.id_klaster_plot'
          )
          ->join(
            'kerusakan_pohon',
            'kerusakan_pohon.id_pengukuran','=','data_tanaman_plot.id_tanaman_plot'
            )
        ->where('data_tanaman_plot.id_plot','=',$id_plot)
        ->groupBy(DB::raw('table_master_jenis_tanaman.nama_tanaman,kerusakan_pohon.tli'))
        ->get();

        $master_pohon = DB::table('table_master_jenis_tanaman')->get();
        $master_fauna = DB::table('tabel_master_fauna')->get();

        $data_fauna=DB::table('data_fauna')
        ->join(
          'tabel_master_fauna',
          'tabel_master_fauna.id_jenis_fauna','=','data_fauna.id_master_fauna'
          )
        ->where('id_plot_fauna','=',$id_plot)
        ->where('data_fauna.pengukuran_ke','=',$pengukuran_ke)
        ->get();

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

        $jumlah_fauna=DB::table('data_fauna')
        ->join(
        'tabel_master_fauna',
        'tabel_master_fauna.id_jenis_fauna','=','data_fauna.id_master_fauna'
        )
        ->where('id_plot_fauna','=',$id_plot)
        ->where('data_fauna.pengukuran_ke','=',$pengukuran_ke)
        ->get();


        return view('user.tambah_data_pengukuran_plot',[
          'data_pengukuran'=>$data_pengukuran,
          'data_pohon'=>$data_pohon,
          'data_fauna'=>$data_fauna,
          'jumlah_pohon'=>$jumlah_pohon,
          'jumlah_fauna'=>$jumlah_fauna,
          'kode_lokasi'=>$kode_kerusakan_lokasi,
          'kerusakan'=>$jumlah_pohon_kerusakan,
          'id_plot' => $id_plot,
          'id_klaster' => $id_klaster_plot,
          'pengukuran_ke' => $pengukuran_ke,
          'master_pohon' => $master_pohon,
          'master_fauna' => $master_fauna,
        ]);
      }

      public function tambah(Request $req)
      {
        $pengukuran_ke = $req->input('pengukuran_ke');
        $tanggal_pengukuran = $req->input('tanggal_pengukuran');
        $nama_pengukur = $req->input('nama_pengukur');
        $id_plot = $req->input('id_plot');

        $req->validate([
            'pengukuran_ke'=>'required|integer',
            'tanggal_pengukuran'=>'required',
            'nama_pengukur'=>'required',
            'id_plot'=>'required|integer',
          ]);

        $data_pengukuran = array(
          'pengukuran_ke' => $pengukuran_ke,
          'tahun_pengukuran' => $tanggal_pengukuran,
          'nama_pengukur' => $nama_pengukur,
          'id_plot' => $id_plot,
        );
        try{
          DB::table('pengukuran_master')->insert($data_pengukuran);
          session()->flash('insert', 'Data pengukuran berhasil ditambah.');
        }
        catch(\Illuminate\Database\QueryException $e){
          throw new CustomException($e->getMessage());
        }

        return back();
      }

      public function tambah2(Request $req)
      {
        $pengukuran_ke = $req->input('pengukuran_ke2');
        $tanggal_pengukuran = $req->input('tanggal_pengukuran');
        $nama_pengukur = $req->input('nama_pengukur');
        $id_plot = $req->input('id_plot');

        $req->validate([
            'pengukuran_ke2'=>'required|integer',
            'tanggal_pengukuran'=>'required',
            'nama_pengukur'=>'required',
            'id_plot'=>'required|integer',
          ]);

        $data_pengukuran = array(
          'pengukuran_ke' => $pengukuran_ke,
          'tahun_pengukuran' => $tanggal_pengukuran,
          'nama_pengukur' => $nama_pengukur,
          'id_plot' => $id_plot,
        );
        try{
          DB::table('pengukuran_master')->insert($data_pengukuran);
          session()->flash('insert', 'Data pengukuran berhasil ditambah.');
        }
        catch(\Illuminate\Database\QueryException $e){
          throw new CustomException($e->getMessage());
        }

        return back();
      }

      public function hapus_pengukuran(Request $req)
      {
          try{
              DB::table('pengukuran_master')->where('id_pengukuran',$req->input('hapus_id'))->delete();
              session()->flash('insert', 'Data pengukuran berhasil dihapus.');
          }
          catch(\Illuminate\Database\QueryException $e){
            throw new CustomException($e->getMessage());
          }


          // DB::table('pengukuran_master')->where('id_pengukuran',$req->input('hapus_id1'))->delete();
          // DB::table('pengukuran_master')->where('id_pengukuran',$req->input('hapus_id2'))->delete();
          // DB::table('pengukuran_master')->where('id_pengukuran',$req->input('hapus_id3'))->delete();
          return back();
      }

      public function edit_pengukuran(Request $req)
      {
        $id = $req->input('edit_id_plot');
        $tahun_pengukuran = $req->input('edit_tanggal_pengukuran');
        $nama_pengukur = $req->input('edit_nama_pengukur');

        $req->validate([
            'edit_id_plot'=>'required',
            'edit_tanggal_pengukuran'=>'required',
            'edit_nama_pengukur'=>'required',
          ]);

        $data_pengukuran = array(
          'tahun_pengukuran' => $tahun_pengukuran,
          'nama_pengukur' => $nama_pengukur,
        );
        try{
          DB::table('pengukuran_master')->where('id_pengukuran', $id)->update($data_pengukuran);
          session()->flash('insert', 'Data pengukuran berhasil diubah.');
        }
        catch(\Illuminate\Database\QueryException $e){
          throw new CustomException($e->getMessage());
        }

        return back();
      }

      public function tambah_pohon(Request $req)
      {

      $req->validate([
          'nama_pohon'=>'required',
          'id_klasters_plot'=>'required',
          'id_plot_pohon'=>'required',
          'jumlah'=>'required|integer|min:1|max:100',
          'pengukurans_ke'=>'required',
        ]);
         $id_tanaman = $req->input('nama_pohon');
         $id_klasters_plot = $req->input('id_klasters_plot');
         $id_plot = $req->input('id_plot_pohon');
         $jumlah = $req->input('jumlah');
         $pengukuran_ke = $req->input('pengukurans_ke');
         $data_pohon = array(
           'id_master_jenis_tanaman' => $id_tanaman,
           'id_plot' => $id_plot,
           'id_klaster_plot' =>$id_klasters_plot,
           'pengukuran_ke' => $pengukuran_ke,
         );

         try{
           for ($i=0; $i < $jumlah ; $i++) {
           DB::table('data_tanaman_plot')->insert($data_pohon);
            }
           session()->flash('insert', 'Data pohon berhasil ditambah.');
         }
         catch(\Illuminate\Database\QueryException $e){
           throw new CustomException($e->getMessage());
         }

        return back();
      }

// tambah data Fauna
public function tambah_fauna(Request $req)
{
  $req->validate([
      'nama_fauna'=>'required',
      'id_klasters_plot_fauna'=>'required',
      'id_plot_fauna'=>'required',
      'peng_ke'=>'required|integer',
      'jumlah_fauna'=>'required|integer|min:1|max:10000',
    ]);
   $id_fauna = $req->input('nama_fauna');
   $id_klasters_plot_fauna = $req->input('id_klasters_plot_fauna');
   $id_plot_fauna = $req->input('id_plot_fauna');
   $jumlah_fauna = $req->input('jumlah_fauna');
   $pengukuran_ke = $req->input('peng_ke');
   $data_fauna = array(
     'id_master_fauna' => $id_fauna,
     'id_plot_fauna' => $id_plot_fauna,
     'id_klaster_plot_fauna' =>$id_klasters_plot_fauna,
     'jumlah'=>$jumlah_fauna,
     'pengukuran_ke'=>$pengukuran_ke,
   );
   // cek apakah data sudah ada
   $validasi_data_fauna=DB::table('data_fauna')
   ->where('id_klaster_plot_fauna','=',$id_klasters_plot_fauna)
   ->where('id_master_fauna','=',$id_fauna)
   ->where('id_plot_fauna','=',$id_plot_fauna)
   ->where('pengukuran_ke','=',$pengukuran_ke)
   ->get();
   // jika data fauna sudah ada
   if(count($validasi_data_fauna)>0){
     $jmlah_fauna=DB::table('data_fauna')
     ->where('id_klaster_plot_fauna','=',$id_klasters_plot_fauna)
     ->where('id_master_fauna','=',$id_fauna)
     ->where('id_plot_fauna','=',$id_plot_fauna)
     ->where('pengukuran_ke','=',$pengukuran_ke)
     ->first();
     $jmlh= $jmlah_fauna->jumlah;

     $data_faunaup = array(
       'id_master_fauna' => $id_fauna,
       'id_plot_fauna' => $id_plot_fauna,
       'id_klaster_plot_fauna' =>$id_klasters_plot_fauna,
       'jumlah'=>$jmlh+$jumlah_fauna,
       'pengukuran_ke'=>$pengukuran_ke,
     );
     try{
       DB::table('data_fauna')
       ->where('id_klaster_plot_fauna','=',$id_klasters_plot_fauna)
       ->where('id_master_fauna','=',$id_fauna)
       ->where('id_plot_fauna','=',$id_plot_fauna)
       ->where('pengukuran_ke','=',$pengukuran_ke)
       ->update($data_faunaup);
       session()->flash('insert', 'Data fauna berhasil diubah.');
     }
     catch(\Illuminate\Database\QueryException $e){
       throw new CustomException($e->getMessage());
     }

   }
   // jika data belum ada
   else{
     try{
       DB::table('data_fauna')->insert($data_fauna);
       session()->flash('insert', 'Data fauna berhasil ditambah.');
     }
     catch(\Illuminate\Database\QueryException $e){
       throw new CustomException($e->getMessage());
     }

   }
  return back();
}

// tambah parameter lbds
      public function tambahPertumbuhan(Request $req)
      {
        $req->validate([
            'id_pengukuran'=>'required',
            'id_tanaman3'=>'required',
            'pengukuran_jarak'=>'numeric|min:0',
            'azimuth'=>'numeric|min:0',
            'pengukuran_keliling'=>'numeric|min:0',
            'pengukuran_tinggi'=>'numeric|min:0',
          ]);
         $id_pengukuran = $req->input('id_pengukuran');
         $id_tanaman = $req->input('id_tanaman3');
         $jarak = $req->input('pengukuran_jarak');
         $azimuth = $req->input('azimuth');
         $keliling = $req->input('pengukuran_keliling');
         $diameter = $keliling/3.14;
         $tinggi = $req->input('pengukuran_tinggi');

         $lbds = (($diameter/100*$diameter/100))*3.14*0.25;
         $v = (($diameter/100*$diameter/100))*3.14*0.25*$tinggi*0.7;

         $data_lbds = array(
           'id_pengukuran' => $id_pengukuran,
           'id_tanaman' => $id_tanaman,
           'azimuth' => $azimuth,
           'jarak' => $jarak,
           'keliling' => $keliling,
           'jarijari' => $diameter,
           'tinggi' => $tinggi,
           'Hasil_LBDS' => $lbds,
           'v' => $v,
         );

         $validasi_pertumbuhan=DB::table('lbds')
         ->where('id_pengukuran','=',$id_pengukuran)
         ->where('id_tanaman','=',$id_tanaman)
         ->get();

         if(count($validasi_pertumbuhan)>0){
           try{
             DB::table('lbds')->where('id_pengukuran','=',$id_pengukuran)
             ->where('id_tanaman','=',$id_tanaman)->update($data_lbds);
             session()->flash('insert', 'Data pertumbuhan berhasil diubah.');
           }
           catch(\Illuminate\Database\QueryException $e){
             throw new CustomException($e->getMessage());
           }

         }
         else {
           try{
             DB::table('lbds')->insert($data_lbds);
            session()->flash('insert', 'Data pertumbuhan berhasil ditambah.');
           }
           catch(\Illuminate\Database\QueryException $e){
             throw new CustomException($e->getMessage());
           }
         }
        return back();
      }

      // foto lbds
      public function tambahFotoPertumbuhan(Request $req){
        $req->validate([
            'judul_foto'=>'required',
            'file_foto'=>'required|file|mimes:jpg,jpeg,png|max:1024',
          ]);

          $id_pengukuran = $req->input('id_pengukuran');
          $judul_foto = $req->input('judul_foto');
          $keterangan= $req->input('keterangan_foto');

          if($req->hasFile('file_foto')){
            $req->validate([
              'file_foto' => 'file|max:1024',
          ]);
            $filesize = $req->file_foto->getClientSize();
            $fileextension = $req->file_foto->getClientOriginalExtension();
            $filename = time() . '.' . $fileextension;
            if($fileextension== 'jpg' || $fileextension== 'jpeg' || $fileextension== 'png'){
              $req->file_foto->move('upload/pengukuran/lbds',$filename);
              $data_foto_lbds = array(
                'id_pengukuran' => $id_pengukuran,
                'title' => $judul_foto,
                'filename' => $filename,
                'size' => $filesize,
                'keterangan' => $keterangan,
              );
              try{
                DB::table('foto_lbds')->insert($data_foto_lbds);
                session()->flash('insert', 'Data foto berhasil ditambah.');
              }
              catch(\Illuminate\Database\QueryException $e){
                throw new CustomException($e->getMessage());
              }
              $req->all();
              return back();
            }
            else{
              session()->flash('edit', 'Format file yang mendukung jpg,jpeg, dan png.');
              return back();
            }

          }
          else{
            session()->flash('delete', 'Gagal menjalankan aksi.');
            return back();
          }

      }

      public function editFotoPertumbuhan(Request $req){
        $req->validate([
            'edit_judul_foto'=>'required',
            'edit_file_foto'=>'bail|file|mimes:jpg,jpeg,png|max:1024',
          ]);

          $judul_foto = $req->input('edit_judul_foto');
          $keterangan= $req->input('edit_keterangan_foto');
          $id_foto = $req->input('id_foto');

          $cek_foto = DB::table('foto_lbds')->where('id_foto_lbds','=',$id_foto)->first();

          if($req->hasFile('edit_file_foto')){
            $req->validate([
              'edit_file_foto' => 'file|max:1024',
          ]);
            $filesize = $req->edit_file_foto->getClientSize();
            $fileextension = $req->edit_file_foto->getClientOriginalExtension();
            $filename = time() . '.' . $fileextension;
            if($fileextension== 'jpg' || $fileextension== 'jpeg' || $fileextension== 'png'){
              $file_path = public_path().'/upload/pengukuran/lbds/'.$cek_foto->filename;
              unlink($file_path);
              $req->edit_file_foto->move('upload/pengukuran/lbds',$filename);
              $data_foto_lbds = array(
                'title' => $judul_foto,
                'filename' => $filename,
                'size' => $filesize,
                'keterangan' => $keterangan,
              );
              try{
                DB::table('foto_lbds')->where('id_foto_lbds','=',$id_foto)->update($data_foto_lbds);
                session()->flash('insert', 'Data foto berhasil diubah.');
              }
              catch(\Illuminate\Database\QueryException $e){
                throw new CustomException($e->getMessage());
              }
              $req->all();
              return back();
            }
            else{
              session()->flash('edit', 'Format file yang mendukung jpg,jpeg, dan png.');
              return back();
            }

          }
          else{
              $data_foto_lbds = array(
                'title' => $judul_foto,
                'keterangan' => $keterangan,
              );
              try{
                DB::table('foto_lbds')->where('id_foto_lbds','=',$id_foto)->update($data_foto_lbds);
                session()->flash('insert', 'Data foto berhasil diubah.');
              }
              catch(\Illuminate\Database\QueryException $e){
                throw new CustomException($e->getMessage());
              }
              return back();
            }


      }

      public function foto_lbds(Request $req){
        $id_foto_lbds= $req->id;
        $foto_lbds= DB::table('foto_lbds')
        ->where('id_foto_lbds','=',$id_foto_lbds)->get();

        return response()->json($foto_lbds);
      }

      //delete foto
      public function delete(Request $req){
        try{
          $id = $req->hapus_id_foto;
          DB::table('foto_lbds')->where('id_foto_lbds', $id)->delete();
          session()->flash('insert', 'Foto berhasil dihapus.');

        }
        catch(\Illuminate\Database\QueryException $e){
          throw new CustomException($e->getMessage());
        }
        return back();
      }

// tambah parameter kerusakan pohon
      public function tambahKerusakan(Request $req)
      {
        $req->validate([
            'id_pengukuran_r'=>'required|integer',
            'id_tanaman'=>'required|integer',
            'DgL1'=>'required|integer|min:0|max:9',
            'DgT1'=>'required|integer',
            'SrVT1'=>'required|integer|min:0|max:9',
            'DgL2'=>'required|integer|min:0|max:9',
            'DgT2'=>'required|integer',
            'SrVT2'=>'required|integer|min:0|max:9',
            'DgL3'=>'required|integer|min:0|max:9',
            'DgT3'=>'required|integer',
            'SrVT3'=>'required|integer|min:0|max:9',
          ]);
         $id_pengukuran = $req->input('id_pengukuran_r');
         $id_tanaman = $req->input('id_tanaman');
         // kode kerusakan
         $kdDgL1 = $req->input('DgL1');
         $kdDgT1 = $req->input('DgT1');
         $kdSrVT1 = $req->input('SrVT1');
         $kdDgL2 = $req->input('DgL2');
         $kdDgT2 = $req->input('DgT2');
         $kdSrVT2 = $req->input('SrVT2');
         $kdDgL3 = $req->input('DgL3');
         $kdDgT3 = $req->input('DgT3');
         $kdSrVT3 = $req->input('SrVT3');

         $kode_lokasi = DB::table('kode_kerusakan_lokasi')->get();

         $kode_tipe = DB::table('kode_kerusakan_type')->get();

         $kode_keparahan = DB::table('kode_kerusakan_keparahan')->get();

         foreach ($kode_lokasi as $value) {
           if($kdDgL1==$value->kode){
             $nDgL1=$value->nilai;
           }
           if($kdDgL2==$value->kode){
             $nDgL2=$value->nilai;
           }
           if($kdDgL3==$value->kode){
             $nDgL3=$value->nilai;
           }
         }

         foreach ($kode_tipe as $value) {
           if($kdDgT1==$value->kode){
             $nDgT1=$value->nilai;
           }
           if($kdDgT2==$value->kode){
             $nDgT2=$value->nilai;
           }
           if($kdDgT3==$value->kode){
             $nDgT3=$value->nilai;
           }
         }

         foreach ($kode_keparahan as $value) {
           if($kdSrVT1==$value->keparahan){
             $nSrVT1=$value->nilai;
           }
           if($kdSrVT2==$value->keparahan){
             $nSrVT2=$value->nilai;
           }
           if($kdSrVT3==$value->keparahan){
             $nSrVT3=$value->nilai;
           }
         }

         if(!isset($nDgL1)){
           session()->flash('edit', 'Kode kerusakan lokasi 1='.$kdDgL1.' salah. Hubungi administrator untuk menambahkan kode yang valid.');
           return back();
         }
         if(!isset($nDgT1)){
           session()->flash('edit', 'Kode kerusakan tipe 1='.$kdDgT1.' salah. Hubungi administrator untuk menambahkan kode yang valid.');
           return back();
         }
         if(!isset($nSrVT1)){
           session()->flash('edit', 'Kode kerusakan keparahan 1='.$kdSrVT1.' salah. Hubungi administrator untuk menambahkan kode yang valid.');
           return back();
         }
         if(!isset($nDgL2)){
           session()->flash('edit', 'Kode kerusakan lokasi 2='.$kdDgL2.' salah. Hubungi administrator untuk menambahkan kode yang valid.');
           return back();
         }
         if(!isset($nDgT2)){
           session()->flash('edit', 'Kode kerusakan tipe 2='.$kdDgT2.' salah. Hubungi administrator untuk menambahkan kode yang valid.');
           return back();
         }
         if(!isset($nSrVT2)){
           session()->flash('edit', 'Kode kerusakan keparahan 2='.$kdSrVT2.' salah. Hubungi administrator untuk menambahkan kode yang valid.');
           return back();
         }
         if(!isset($nDgL3)){
           session()->flash('edit', 'Kode kerusakan lokasi 3='.$kdDgL3.' salah. Hubungi administrator untuk menambahkan kode yang valid.');
           return back();
         }
         if(!isset($nDgT3)){
           session()->flash('edit', 'Kode kerusakan tipe 3='.$kdDgT3.' salah. Hubungi administrator untuk menambahkan kode yang valid.');
           return back();
         }
         if(!isset($nSrVT3)){
           session()->flash('edit', 'Kode kerusakan keparahan 3='.$kdSrVT3.' salah. Hubungi administrator untuk menambahkan kode yang valid.');
           return back();
         }

         $tli = $nDgL1*$nDgT1*$nSrVT1 +
                $nDgL2*$nDgT2*$nSrVT2 +
                $nDgL3*$nDgT3*$nSrVT3;


         // nilai kerusakan
         // $nDgL1 = $req->input('hDgL1');
         // $nDgT1 = $req->input('hDgT1');
         // $nSrVT1 = $req->input('hSrVT1');
         // $nDgL2 = $req->input('hDgL2');
         // $nDgT2 = $req->input('hDgT2');
         // $nSrVT2 = $req->input('hSrVT2');
         // $nDgL3 = $req->input('hDgL3');
         // $nDgT3 = $req->input('hDgT3');
         // $nSrVT3 = $req->input('hSrVT3');
         //
         // $tli = $req->input('hasil_tli');

         $data_kerusakan = array(
           'id_pengukuran' => $id_pengukuran,
           'id_tanaman' => $id_tanaman,
           'kdDgL1' => $kdDgL1,
           'kdDgT1' => $kdDgT1,
           'kdSrVT1' => $kdSrVT1,
           'kdDgL2' => $kdDgL2,
           'kdDgT2' => $kdDgT2,
           'kdSrVT2' => $kdSrVT2,
           'kdDgL3' => $kdDgL3,
           'kdDgT3' => $kdDgT3,
           'kdSrVT3' => $kdSrVT3,

           'nDgL1' => $nDgL1,
           'nDgT1' => $nDgT1,
           'nSrVT1' => $nSrVT1,
           'nDgL2' => $nDgL2,
           'nDgT2' => $nDgT2,
           'nSrVT2' => $nSrVT2,
           'nDgL3' => $nDgL3,
           'nDgT3' => $nDgT3,
           'nSrVT3' => $nSrVT3,
           'tli' => $tli,
         );

         $validasi_kerusakan = DB::table('kerusakan_pohon')
         ->where('id_pengukuran','=',$id_pengukuran)
         ->where('id_tanaman','=',$id_tanaman)
         ->get();


           if(count($validasi_kerusakan)>0){
             try{
             DB::table('kerusakan_pohon')->where('id_pengukuran','=',$id_pengukuran)
             ->where('id_tanaman','=',$id_tanaman)->update($data_kerusakan);
            session()->flash('insert', 'Data kerusakan berhasil diubah.');
           }
           catch(\Illuminate\Database\QueryException $e){
             throw new CustomException($e->getMessage());
           }
         }
           else{
             try{
             DB::table('kerusakan_pohon')->insert($data_kerusakan);
             session()->flash('insert', 'Data kerusakan berhasil ditambah.');
           }
           catch(\Illuminate\Database\QueryException $e){
             throw new CustomException($e->getMessage());
           }
         }

        return back();
      }

      // tambah parameter kerusakan pohon
      public function tambahTajuk(Request $req)
      {
        $req->validate([
            'id_pengukuran_t'=>'required|integer',
            'id_tanaman2'=>'required|integer',
            'lcr'=>'required|numeric|min:0|max:100',
            'cden'=>'required|numeric|min:0|max:100',
            'cdb'=>'required|numeric|min:0|max:100',
            'cdw'=>'required|numeric|min:0|max:100',
            'cd90'=>'required|numeric|min:0|max:100',
          ]);
        $id_pengukuran = $req->input('id_pengukuran_t');
        $id_tanaman = $req->input('id_tanaman2');

        $lcr = $req->input('lcr');
        $cden = $req->input('cden');
        $ft= 100-$cden;
        $cdb= $req->input('cdb');
        $cdw= $req->input('cdw');
        $cd90= $req->input('cd90');
        $cd= ($cdw+$cd90)/2;

        // variabel untuk menampung jumlah nilai 3, 2, dan 1
        $jumlah_nilai=[0,0,0,0,0];
        //
        $satu=0;
        $dua=0;
        $tiga=0;

        $kode_lcr = DB::table('kode_kondisi_tajuk')
        ->where('id_kondisi_tajuk','=',1)->first();
        $kode_cden = DB::table('kode_kondisi_tajuk')
        ->where('id_kondisi_tajuk','=',2)->first();
        $kode_ft = DB::table('kode_kondisi_tajuk')
        ->where('id_kondisi_tajuk','=',3)->first();
        $kode_cdb = DB::table('kode_kondisi_tajuk')
        ->where('id_kondisi_tajuk','=',4)->first();
        $kode_cd = DB::table('kode_kondisi_tajuk')
        ->where('id_kondisi_tajuk','=',5)->first();
        //perhitungan lcr
          if($lcr>=$kode_lcr->batas_atas){
            $hasil_lcr=3;
            $jumlah_nilai[0] = 3;
          }
          else if($lcr<$kode_lcr->batas_bawah){
            $hasil_lcr=1;
            $jumlah_nilai[0] = 1;
          }
          else{
            $hasil_lcr=2;
            $jumlah_nilai[0] = 2;
          }

          //perhitungan cden
          if($cden>=$kode_cden->batas_atas){
            $hasil_cden=3;
            $jumlah_nilai[1] = 3;
          }
          else if($cden<$kode_cden->batas_bawah){
            $hasil_cden=1;
            $jumlah_nilai[1] = 1;
          }
          else{
            $hasil_cden=2;
            $jumlah_nilai[1] = 2;
          }

          //perhitungan ft
          if($ft>=$kode_ft->batas_atas){
            $hasil_ft=1;
            $jumlah_nilai[2] = 1;
          }
          else if($ft<$kode_ft->batas_bawah){
            $hasil_ft=3;
            $jumlah_nilai[2] = 3;
          }
          else{
            $hasil_ft=2;
            $jumlah_nilai[2] = 2;
          }

          //perhitungan cdb
          if($cdb>=$kode_cdb->batas_atas){
            $hasil_cdb=1;
            $jumlah_nilai[3] = 1;
          }
          else if($cdb<$kode_cdb->batas_bawah){
            $hasil_cdb=3;
            $jumlah_nilai[3] = 3;
          }
          else{
            $hasil_cdb=2;
            $jumlah_nilai[3] = 2;
          }

          //perhitungan cd
          if($cd>=$kode_cd->batas_atas){
            $hasil_cd=3;
            $jumlah_nilai[4] = 3;
          }
          else if($cd<$kode_cd->batas_bawah){
            $hasil_cd=1;
            $jumlah_nilai[4] = 1;
          }
          else{
            $hasil_cd=2;
            $jumlah_nilai[4] = 2;
          }

          //perhitugan vcri
          for($i=0;$i<5;$i++){
            if($jumlah_nilai[$i] == 3){
             $tiga+=1;
           }
           else if($jumlah_nilai[$i] == 2){
            $dua+=1;
          }
          else if($jumlah_nilai[$i] == 1){
           $satu+=1;
         }
          }

          // nilai vcri
          if($tiga==5 || ($dua==1 && $satu==0 && $tiga==4)){
            $hasil_vcr=4;
            $hasil_kesimpulan="Tinggi";
          }
          else if($satu>0 && $satu!=5){
            $hasil_vcr=2;
            $hasil_kesimpulan="Rendah";
          }
          else if($satu==5){
            $hasil_vcr=1;
            $hasil_kesimpulan="Sangat Rendah";
          }
          else {
            $hasil_vcr=3;
            $hasil_kesimpulan="Sedang";
          }

        $data_tajuk = array(
          'id_pengukuran' => $id_pengukuran,
          'id_tanaman' => $id_tanaman,
          'lcr' => $lcr,
          'cden' => $cden,
          'ft' => $ft,
          'cdb' => $cdb,
          'cdw' => $cdw,
          'cd90' => $cd90,
          'cd' => $cd,

          'nlcr' => $hasil_lcr,
          'ncden' => $hasil_cden,
          'nft' => $hasil_ft,
          'ncdb' => $hasil_cdb,
          'ncd' => $hasil_cd,

          'vcri' => $hasil_vcr,
          'kesimpulan' => $hasil_kesimpulan,
        );

        $validasi_tajuk=DB::table('kondisi_tajuk')
        ->where('id_pengukuran','=',$id_pengukuran)
        ->where('id_tanaman','=',$id_tanaman)
        ->get();

        if(count($validasi_tajuk)>0){
          try{
            DB::table('kondisi_tajuk')->where('id_pengukuran','=',$id_pengukuran)
            ->where('id_tanaman','=',$id_tanaman)->update($data_tajuk);
            session()->flash('insert', 'Data kondisi tajuk berhasil diubah.');
          }
          catch(\Illuminate\Database\QueryException $e){
            throw new CustomException($e->getMessage());
          }

        }
        else{
          try{
            DB::table('kondisi_tajuk')->insert($data_tajuk);
            session()->flash('insert', 'Data kondisi tajuk berhasil ditambah.');
          }
          catch(\Illuminate\Database\QueryException $e){
            throw new CustomException($e->getMessage());
          }

        }

       return back();
           }

       public function dataPertumbuhan2(Request $req)
       {
         $id_pengukuran = $req->id;
         $id_tanaman = $req->id2;
         $hasil_lbds = DB::table('lbds')
         ->where('id_pengukuran','=',$id_pengukuran)
         ->where('id_tanaman','=',$id_tanaman)
         ->get();
         return response()->json($hasil_lbds);
       }

       public function dataKerusakan2(Request $req)
       {
         $id_pengukuran = $req->id;
         $id_tanaman = $req->id2;
         $hasil_kerusakan = DB::table('kerusakan_pohon')
         ->where('id_pengukuran','=',$id_pengukuran)
         ->where('id_tanaman','=',$id_tanaman)
         ->get();
         return response()->json($hasil_kerusakan);
       }

       public function kerusakan2(Request $request)
{
    $id_pengukuran = $request->input('id_pengukuran');

    $data_kerusakan = DB::table('pengukuran_master')
        ->join('data_tanaman_plot','data_tanaman_plot.id_plot','=','pengukuran_master.id_plot')
        ->join('table_master_jenis_tanaman','table_master_jenis_tanaman.id_jenis_tanaman','=','data_tanaman_plot.id_master_jenis_tanaman')
        ->leftJoin('kerusakan_pohon','data_tanaman_plot.id_tanaman_plot','=','kerusakan_pohon.id_tanaman')
        ->where('pengukuran_master.id_pengukuran', $id_pengukuran)
        ->get();

    return view('user.coba', [
        'data_kerusakan' => $data_kerusakan,
        'jumlah_data'    => $data_kerusakan->count(),
    ]);
}

       public function dataKondisiTajuk2(Request $req)
       {
         $id_pengukuran = $req->id;
         $id_tanaman = $req->id2;
         $hasil_tajuk = DB::table('kondisi_tajuk')
         ->where('id_pengukuran','=',$id_pengukuran)
         ->where('id_tanaman','=',$id_tanaman)
         ->get();
         return response()->json($hasil_tajuk);
       }

      public function tajuk(Request $request)
{
    $nilai_tajuk = DB::table('kode_kondisi_tajuk')
        ->where('id_parameter_tajuk', $request->id_tajuk)
        ->get();

    return response()->json($nilai_tajuk);
}


      public function edit_pohon(Request $req)
      {
        $req->validate([
            'edit_id_pohon'=>'required',
            'edit_nama_pohon'=>'required',
          ]);

        $id = $req->input('edit_id_pohon');
        $id_master_pohon = $req->input('edit_nama_pohon');
        $data_pohon = array(
          'id_master_jenis_tanaman' => $id_master_pohon,
        );
        try{
          DB::table('data_tanaman_plot')->where('id_tanaman_plot', $id)->update($data_pohon);
          session()->flash('insert', 'Data pohon berhasil diubah.');
        }
        catch(\Illuminate\Database\QueryException $e){
          throw new CustomException($e->getMessage());
        }


        return back();
      }

      public function edit_fauna(Request $req)
      {
        $req->validate([
            'edit_id_fauna'=>'required',
            'edit_nama_fauna'=>'required',
            'edit_jumlah_fauna'=>'required|integer|min:1|max:10000',
          ]);
        $id = $req->input('edit_id_fauna');
        $id_master_fauna = $req->input('edit_nama_fauna');
        $jumlah_fauna = $req->input('edit_jumlah_fauna');
        $data_fauna = array(
          'id_master_fauna' => $id_master_fauna,
          'jumlah'=>$jumlah_fauna,
        );

          // jika fauna yang diedit angkanya ditulis 0
          if($jumlah_fauna==0){
              // delete data fauna
              try{
                DB::table('data_fauna')->where('id_fauna', $id)->delete();
                session()->flash('insert', 'Data fauna berhasil dihapus.');
              }
              catch(\Illuminate\Database\QueryException $e){
                throw new CustomException($e->getMessage());
              }

          }
          // jika pohon yang di edit lebih dari sama dengan 1
          else {
            try{
              // update data fauna
              DB::table('data_fauna')->where('id_fauna', $id)->update($data_fauna);
              session()->flash('insert', 'Data fauna berhasil diubah.');
            }
            catch(\Illuminate\Database\QueryException $e){
              throw new CustomException($e->getMessage());
            }

        }

        return back();
      }

      public function hapus_pohon(Request $req)
      {
        $id_tanaman = $req->input('id_jenis_tanaman2');
        $id_klasters_plot = $req->input('id_klasters_plot2');

        try{
             DB::table('data_tanaman_plot')->where('id_tanaman_plot',$req->input('hapus_id'))->delete();
             session()->flash('insert', 'Data pohon berhasil dihapus.');
        }
        catch(\Illuminate\Database\QueryException $e){
          throw new CustomException($e->getMessage());
        }

          return back();
      }

      public function delete_all_pohon(Request $req){
        try{
          $id = $req->hapus_id_all;
          $pengukuran_ke = $req->pengukuran_ke;
          DB::table('data_tanaman_plot')
          ->where('id_plot', $id)
          ->where('pengukuran_ke', $pengukuran_ke)
          ->delete();
          session()->flash('insert', 'Semua data berhasil dihapus.');

        }
        catch(\Illuminate\Database\QueryException $e){
          throw new CustomException($e->getMessage());
        }
        return back();
      }

      public function status_pohon(Request $req)
      {
        $id = $req->input('status_id');
        $status = $req->input('status');
        $data_status = array(
            'status' => $status,
        );
        try{
            DB::table('data_tanaman_plot')->where('id_tanaman_plot', $id)->update($data_status);
            session()->flash('insert', 'Status pohon berhasil diubah.');
        }
        catch(\Illuminate\Database\QueryException $e){
          throw new CustomException($e->getMessage());
        }


        return back();
      }

      public function hapus_fauna(Request $req)
      {
        $id_fauna = $req->input('id_jenis_fauna2');
        $id_klasters_plot = $req->input('id_klasters_plot_fauna2');
        $pengukuran_ke = $req->input('peng_ke3');

        try{
          DB::table('data_fauna')->where('id_fauna',$req->input('hapus_id2'))->delete();
          session()->flash('insert', 'Data fauna berhasil dihapus.');
        }
        catch(\Illuminate\Database\QueryException $e){
          throw new CustomException($e->getMessage());
        }

          return back();
      }

      public function delete_all_fauna(Request $req){
        try{
          $id = $req->hapus_id_all;
          $pengukuran_ke = $req->pengukuran_ke;
          DB::table('data_fauna')
          ->where('id_plot_fauna', $id)
          ->where('pengukuran_ke', $pengukuran_ke)
          ->delete();
          session()->flash('insert', 'Semua data berhasil dihapus.');

        }
        catch(\Illuminate\Database\QueryException $e){
          throw new CustomException($e->getMessage());
        }
        return back();
      }

      // public function kerusakan_lokasi(Request $req)
      // {
      //   $id_kerusakan_lokasi = Input::get('kode');
      //   $kode_kerusakan_lokasi= DB::table('kode_kerusakan_lokasi')
      //   ->where('kode', '=', $id_kerusakan_lokasi)->get();
      //   return response()->json($kode_kerusakan_lokasi);
      // }

      // public function kerusakan_tipe(Request $req)
      // {
      //   $id_kerusakan_tipe = Input::get('kode');
      //   $kode_kerusakan_tipe= DB::table('kode_kerusakan_type')
      //   ->where('kode', '=', $id_kerusakan_tipe)->get();
      //   return response()->json($kode_kerusakan_tipe);
      // }

      // public function kerusakan_keparahan(Request $req)
      // {
      //   $tingkat_keparahan = Input::get('tingkat');
      //   $kode_kerusakan_keparahan= DB::table('kode_kerusakan_keparahan')
      //   ->where('keparahan', '=', $tingkat_keparahan)->get();
      //   return response()->json($kode_kerusakan_keparahan);
      // }


  }
