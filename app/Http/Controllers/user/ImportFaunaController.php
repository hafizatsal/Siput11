<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Exceptions\CustomException;

class ImportFaunaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function importExcel(Request $req)
    {
        $req->validate([
            'import_id_pengukuran_fhn'=>'required|integer',
            'id_klaster_import_fhn'=>'required|integer',
            'import_pengukuran_ke_fhn'=>'required|integer',
            'import_id_plot_fhn'=>'required|integer',
            'file'=>'required|file|mimes:xls,xlsx,csv|max:10240',
        ]);

        $id_pengukuran  = $req->import_id_pengukuran_fhn;
        $id_klaster_plot = $req->id_klaster_import_fhn;
        $pengukuran_ke   = $req->import_pengukuran_ke_fhn;
        $id_plot_pengukuran = $req->import_id_plot_fhn;

        $id_plot = DB::table('tbl_plot')->where('id_plot',$id_plot_pengukuran)->first();

        $no_plot = match($id_plot->nama_plot){
            "PLOT 1" => 1,
            "PLOT 2" => 2,
            "PLOT 3" => 3,
            "PLOT 4" => 4,
            default => 0
        };

        if($req->hasFile('file')){

            $file = $req->file('file');

            // 🔥 CARA BARU BACA EXCEL
            $dataSheets = Excel::toCollection(null, $file);

            if($dataSheets->count()){

                foreach($dataSheets as $sheet){

                    $sheetTitle = $sheet->getTitle();
                    if($sheetTitle !== "Jenis Fauna") continue;

                    $jenis = DB::table('tabel_master_fauna')->get();
                    $data_fauna = [];

                    foreach($sheet as $row){

                        if(is_numeric($row[0]) && $row[0] == $no_plot){

                            $m = $jenis->firstWhere('nama_latin_fauna',$row[2]);

                            if(!$m){
                                session()->flash('delete','Data fauna belum tersedia, silahkan tambah fauna terlebih dahulu.');
                                return back();
                            }

                            $data_fauna[] = [
                                'id_klaster_plot_fauna'=>$id_klaster_plot,
                                'id_plot_fauna'=>$id_plot_pengukuran,
                                'id_master_fauna'=>$m->id_jenis_fauna,
                                'jumlah'=>$row[3],
                                'pengukuran_ke'=>$pengukuran_ke,
                                'isInserted'=>1
                            ];
                        }
                    }

                    if(count($data_fauna)){
                        DB::table('data_fauna')->insert($data_fauna);
                        session()->flash('insert','Data fauna berhasil diimport ✔');
                    }
                }
            }
        }

        return back();
    }
}
