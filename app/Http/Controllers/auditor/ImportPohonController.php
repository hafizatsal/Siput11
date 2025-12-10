<?php

namespace App\Http\Controllers\auditor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Exceptions\CustomException;

class ImportPohonController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function importExcel(Request $req)
    {
        $req->validate([
            'import_id_pengukuran_phn'=>'required|integer',
            'id_klaster_import_phn'=>'required|integer',
            'import_pengukuran_ke_phn'=>'required|integer',
            'import_id_plot_phn'=>'required|integer',
            'file'=>'required|file|mimes:xls,xlsx,csv|max:10240',
        ]);

        $id_pengukuran  = $req->import_id_pengukuran_phn;
        $id_klaster_plot = $req->id_klaster_import_phn;
        $pengukuran_ke   = $req->import_pengukuran_ke_phn;
        $id_plot_pengukuran = $req->import_id_plot_phn;

        $plot = DB::table('tbl_plot')->where('id_plot',$id_plot_pengukuran)->first();

        $no_plot = match($plot->nama_plot){
            "PLOT 1"=>1,"PLOT 2"=>2,"PLOT 3"=>3,"PLOT 4"=>4,default=>0
        };

        if(!$req->hasFile('file'))
            return back()->with('delete','File belum dipilih!');

        // 🔥 CARA BACA FILE EXCEL BARU
        $dataSheets = Excel::toCollection(null, $req->file('file'));

        foreach($dataSheets as $sheet){

            if($sheet->getTitle() != "Jenis dan Lokasi Pohon") continue;

            $jenis_master = DB::table('table_master_jenis_tanaman')->get();
            $data_insert = [];

            foreach($sheet as $row){

                if(!is_numeric($row[1]) || $row[0] != $no_plot) continue;

                $jenis = $jenis_master->firstWhere('nama_latin',$row[3]);

                if(!$jenis){
                    return back()->with('delete',"Data pohon $row[3] belum tersedia. Tambahkan dulu!");
                }

                $data_insert[] = [
                    'id_klaster_plot'=>$id_klaster_plot,
                    'id_plot'=>$id_plot_pengukuran,
                    'id_master_jenis_tanaman'=>$jenis->id_jenis_tanaman,
                    'pengukuran_ke'=>$pengukuran_ke,
                    'status'=>1,
                    'isInserted'=>1
                ];
            }

            if(count($data_insert)){
                DB::table('data_tanaman_plot')->insert($data_insert);
                return back()->with('insert','Data pohon berhasil diimport ✔');
            }
        }

        return back()->with('delete','Format Excel salah, gunakan template resmi.');
    }
}
