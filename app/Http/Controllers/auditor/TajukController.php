<?php

namespace App\Http\Controllers\auditor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Exceptions\CustomException;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
class TajukController extends Controller
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
    public function importExcel(Request $req)
    {
      $req->validate([
          'import_id_pengukuran'=>'required|integer',
          'id_klaster_import'=>'required|integer',
          'import_pengukuran_ke'=>'required|integer',
          'import_id_plot'=>'required|integer',
          'file'=>'required|file|mimes:xls,xlsx,csv|max:10240',
        ]);

      $id_pengukuran= $req->input('import_id_pengukuran');
      $id_klaster_plot = $req->input('id_klaster_import');
      $pengukuran_ke = $req->input('import_pengukuran_ke');
      $id_plot_pengukuran = $req->input('import_id_plot');

      $owns_plot = DB::table('tbl_plot')
        ->join('tbl_klaster_plot', 'tbl_klaster_plot.id_klaster_plot', '=', 'tbl_plot.id_klaster_plot')
        ->leftJoin('kategori_klaster', function ($join) {
          $join->on('kategori_klaster.id_data_klaster', '=', 'tbl_klaster_plot.id_data_klaster')
            ->orOn('kategori_klaster.id_data_klaster2', '=', 'tbl_klaster_plot.id_data_klaster');
        })
        ->where('tbl_plot.id_plot', $id_plot_pengukuran)
        ->where(function ($query) {
          $query->where('kategori_klaster.input_by', Auth::id())
            ->orWhere('kategori_klaster.verif', 1);
        })
        ->exists();
      if (!$owns_plot) {
        abort(403, 'Unauthorized');
      }
      $id_plot = DB::table('tbl_plot')->where('id_plot','=',$id_plot_pengukuran)->first();

      if($id_plot->nama_plot=="PLOT 1"){
        $no_plot = 1;
      }
      else if($id_plot->nama_plot=="PLOT 2"){
        $no_plot = 2;
      }
      else if($id_plot->nama_plot=="PLOT 3"){
        $no_plot = 3;
      }
      else if($id_plot->nama_plot=="PLOT 4"){
        $no_plot = 4;
      }

      if($req->hasFile('file')){

    $data = Excel::toCollection(new class implements \Maatwebsite\Excel\Concerns\ToCollection {
        public function collection(\Illuminate\Support\Collection $rows)
        {
            return $rows;
        }
    }, $req->file('file'));

    $data = $data[0]; // ambil sheet pertama

    // Tambahkan agar row bisa diakses seperti Excel::load()
    foreach ($data as $sheetIndex => $value) {
        $data[$sheetIndex] = (object) $value->toArray();
    }


      if(!empty($data) && $data->count()){
				foreach ($data as $key => $value) {
					$sheetTitle = $value->getTitle();
					$i=1;

          if($sheetTitle === 'Kondisi Tajuk') {
                foreach($value as $row) {
    								if(is_numeric($row[1])){
                      if($row[0]==$no_plot){
                        $data_excel [] = $row[0]; // untuk menampung jumlah data di excel
                      }
    								}
                  }

                $jumlah_data_tajuk_xls = count($data_excel); // jumlah data kondisi tajuk di excel

                $data_tanaman_tajuk = DB::table('kondisi_tajuk')
                ->where('id_pengukuran','=',$id_pengukuran)->get();

                $data_pohon = DB::table('data_tanaman_plot')
                ->where('id_plot','=',$id_plot_pengukuran)
                ->where('pengukuran_ke','=',$pengukuran_ke)->get();

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

                $jumlah_pohon = count($data_pohon);

                $jumlah_data_tajuk_db = count($data_tanaman_tajuk); // jumlah data kondisi tajuk di database
                if($jumlah_data_tajuk_db==0){
                  if($jumlah_pohon==$jumlah_data_tajuk_xls){

                      $nmr_pohon = 0; // untuk index id_pohon
                    foreach($value as $row) {
        								if(is_numeric($row[1])){
                          if($row[0]==$no_plot){
                            // variabel untuk menampung jumlah nilai 3, 2, dan 1
                            $jumlah_nilai=[0,0,0,0,0];
                            //
                            $satu=0;
                            $dua=0;
                            $tiga=0;

                            //perhitungan lcr
                              if($row[2]>=$kode_lcr->batas_atas){
                                $hasil_lcr=3;
                                $jumlah_nilai[0] = 3;
                              }
                              else if($row[2]<$kode_lcr->batas_bawah){
                                $hasil_lcr=1;
                                $jumlah_nilai[0] = 1;
                              }
                              else{
                                $hasil_lcr=2;
                                $jumlah_nilai[0] = 2;
                              }

                              //perhitungan cden
                              if($row[3]>=$kode_cden->batas_atas){
                                $hasil_cden=3;
                                $jumlah_nilai[1] = 3;
                              }
                              else if($row[3]<$kode_cden->batas_bawah){
                                $hasil_cden=1;
                                $jumlah_nilai[1] = 1;
                              }
                              else{
                                $hasil_cden=2;
                                $jumlah_nilai[1] = 2;
                              }

                              //perhitungan ft
                              if($row[4]>=$kode_ft->batas_atas){
                                $hasil_ft=1;
                                $jumlah_nilai[2] = 1;
                              }
                              else if($row[4]<$kode_ft->batas_bawah){
                                $hasil_ft=3;
                                $jumlah_nilai[2] = 3;
                              }
                              else{
                                $hasil_ft=2;
                                $jumlah_nilai[2] = 2;
                              }

                              //perhitungan cdb
                              if($row[5]>=$kode_cdb->batas_atas){
                                $hasil_cdb=1;
                                $jumlah_nilai[3] = 1;
                              }
                              else if($row[5]<$kode_cdb->batas_bawah){
                                $hasil_cdb=3;
                                $jumlah_nilai[3] = 3;
                              }
                              else{
                                $hasil_cdb=2;
                                $jumlah_nilai[3] = 2;
                              }

                              //perhitungan cd
                              if($row[8]>=$kode_cd->batas_atas){
                                $hasil_cd=3;
                                $jumlah_nilai[4] = 3;
                              }
                              else if($row[8]<$kode_cd->batas_bawah){
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


          									$kon_taj[]= ['id_pengukuran' => $id_pengukuran, 'id_tanaman' => $data_pohon[$nmr_pohon++]->id_tanaman_plot, 'lcr' => $row[2],
          																'cden' => $row[3], 'ft' => $row[4], 'cdb' =>$row[5], 'cdw' => $row[6],
          																'cd90' => $row[7], 'cd' => $row[8],'nlcr' => $hasil_lcr,'ncden' => $hasil_cden,
          																'nft' => $hasil_ft, 'ncdb' =>$hasil_cdb, 'ncd' =>$hasil_cd, 'vcri' =>$hasil_vcr,
          																'kesimpulan' => $hasil_kesimpulan, 'isInserted' => 1];

                          } //endif no_plot
        								} //endif numeric
                      } //endforeach
                    } //endif jumlah pohon = jumlah data tajuk excel
                    else{
                      session()->flash('delete', 'Jumlah data kondisi tajuk yang ingin diimport tidak sesuai dengan data pohon!');
                      return back();
                    }
                  } //endif jumlah data kondisi tajuk database
                  else{
                    session()->flash('delete', 'Data kondisi tajuk tidak dapat diimport');
                    return back();
                  }
    						if(!empty($kon_taj)){
                  try{
    							DB::table('kondisi_tajuk')->insert($kon_taj);
                  session()->flash('insert', 'Data kondisi tajuk berhasil ditambah.');
                  }
                  catch(\Illuminate\Database\QueryException $e){
                    throw new CustomException($e->getMessage());
                  }
    						} //endif empty
    					} //end sheet title
              else{
                session()->flash('delete', 'Format file yang Anda gunakan salah, silahkan unduh template file import pada halaman utama.');
              }
            } //endforeach
          } //endif !empty file
        } //endif hasFile
return back();
    } //endfunction

    public function tambahFotoTajuk(Request $req){
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
            $req->file_foto->move('upload/pengukuran/tajuk',$filename);
            $data_foto_kerusakan = array(
              'id_pengukuran' => $id_pengukuran,
              'title' => $judul_foto,
              'filename' => $filename,
              'size' => $filesize,
              'keterangan' => $keterangan,
            );
            try{
              DB::table('foto_tajuk')->insert($data_foto_kerusakan);
              session()->flash('insert', 'Data foto berhasil ditambah.');
            }
            catch(\Illuminate\Database\QueryException $e){
              throw new CustomException($e->getMessage());
            }
            $req->all();
            return back();
          }
          else{
            session()->flash('delete', 'Format file yang mendukung jpg,jpeg, dan png.');
            return back();
          }

        }
        else{
          session()->flash('delete', 'Gagal menjalankan aksi.');
          return back();
        }

    }

    public function deleteFotoTajuk(Request $req){
      try{
        $id = $req->hapus_id_foto;
        DB::table('foto_tajuk')->where('id_foto_tajuk', $id)->delete();
        session()->flash('delete', 'Foto berhasil dihapus.');

      }
      catch(\Illuminate\Database\QueryException $e){
        throw new CustomException($e->getMessage());
      }
      return back();
    }

    public function editFotoTajuk(Request $req){
      $req->validate([
          'edit_judul_foto'=>'required',
          'edit_file_foto'=>'bail|file|mimes:jpg,jpeg,png|max:1024',
        ]);

        $judul_foto = $req->input('edit_judul_foto');
        $keterangan= $req->input('edit_keterangan_foto');
        $id_foto = $req->input('id_foto');

        $cek_foto = DB::table('foto_tajuk')->where('id_foto_tajuk','=',$id_foto)->first();

        if($req->hasFile('edit_file_foto')){
          $req->validate([
            'edit_file_foto' => 'file|max:1024',
        ]);
          $filesize = $req->edit_file_foto->getClientSize();
          $fileextension = $req->edit_file_foto->getClientOriginalExtension();
          $filename = time() . '.' . $fileextension;
          if($fileextension== 'jpg' || $fileextension== 'jpeg' || $fileextension== 'png'){
            $file_path = public_path().'/upload/pengukuran/tajuk/'.$cek_foto->filename;
            unlink($file_path);
            $req->edit_file_foto->move('upload/pengukuran/tajuk',$filename);
            $data_foto_tajuk = array(
              'title' => $judul_foto,
              'filename' => $filename,
              'size' => $filesize,
              'keterangan' => $keterangan,
            );
            try{
              DB::table('foto_tajuk')->where('id_foto_tajuk','=',$id_foto)->update($data_foto_tajuk);
              session()->flash('insert', 'Data foto berhasil diubah.');
            }
            catch(\Illuminate\Database\QueryException $e){
              throw new CustomException($e->getMessage());
            }
            $req->all();
            return back();
          }
          else{
            session()->flash('delete', 'Format file yang mendukung jpg,jpeg, dan png.');
            return back();
          }

        }
        else{
            $data_foto_tajuk = array(
              'title' => $judul_foto,
              'keterangan' => $keterangan,
            );
            try{
              DB::table('foto_tajuk')->where('id_foto_tajuk','=',$id_foto)->update($data_foto_tajuk);
              session()->flash('edit', 'Data foto berhasil diubah.');
            }
            catch(\Illuminate\Database\QueryException $e){
              throw new CustomException($e->getMessage());
            }
            return back();
          }


    }

    public function foto_tajuk(Request $req){
      $id_foto_tajuk= $req->id;
      $foto_tajuk= DB::table('foto_tajuk')
      ->where('id_foto_tajuk','=',$id_foto_tajuk)->get();

      return response()->json($foto_tajuk);
    }

}

