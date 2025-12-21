<?php

namespace App\Http\Controllers\auditor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exceptions\CustomException;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class LbdsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function importExcel(Request $req)
    {
        // ==== VALIDASI INPUT ====
        $req->validate([
            'import_id_pengukuran'=>'required|integer',
            'id_klaster_import'=>'required|integer',
            'import_pengukuran_ke'=>'required|integer',
            'import_id_plot'=>'required|integer',
            'file'=>'required|file|mimes:xls,xlsx,csv|max:10240',
        ]);

        $id_pengukuran      = $req->input('import_id_pengukuran');
        $id_klaster_plot    = $req->input('id_klaster_import');
        $pengukuran_ke      = $req->input('import_pengukuran_ke');
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

        // cek info plot
        $id_plot = DB::table('tbl_plot')->where('id_plot',$id_plot_pengukuran)->first();
        if(!$id_plot){
            session()->flash('delete', "Plot tidak ditemukan di database.");
            return back();
        }

        $no_plot = match($id_plot->nama_plot){
            "PLOT 1" => 1,
            "PLOT 2" => 2,
            "PLOT 3" => 3,
            "PLOT 4" => 4,
            default  => null
        };

        if($no_plot === null){
            session()->flash('delete',"Nama plot tidak dikenali (harus PLOT 1-4)");
            return back();
        }

        // ==== CEK FILE ====
if (!$req->hasFile('file')) {
    session()->flash('delete', 'Tidak ada file yang dipilih.');
    return back();
}

// ==== BACA FILE EXCEL ====
try {
    $path = $req->file('file')->getRealPath();

    // ⚠️ Jika masih pakai Excel::load (versi lama), sementara biarkan dulu:
    $data = Excel::load($path, function($reader) {
        $reader->noHeading = true;
    })->get();

} catch (\Exception $e) {
    session()->flash('delete', 'Gagal membaca file Excel. Pastikan format benar.');
    return back();
}

        // ==== PROSES SETIAP SHEET ====
        foreach($data as $sheet){
            $sheetTitle = $sheet->getTitle();

            if($sheetTitle !== 'Kondisi Pertumbuhan'){
                session()->flash('delete',
                    "Sheet tidak sesuai! Nama sheet harus **Kondisi Pertumbuhan**, ditemukan: ".$sheetTitle
                );
                return back();
            }

            $data_excel = [];
            foreach($sheet as $row){
                if(is_numeric($row[1]) && $row[0] == $no_plot){
                    $data_excel[] = $row[0];
                }
            }

            $jumlah_data_xls = count($data_excel);

            $data_existing = DB::table('lbds')->where('id_pengukuran',$id_pengukuran)->count();
            $data_pohon    = DB::table('data_tanaman_plot')
                                ->where('id_plot',$id_plot_pengukuran)
                                ->where('pengukuran_ke',$pengukuran_ke)
                                ->get();
            $jumlah_pohon = count($data_pohon);

            // ==== VALIDASI =====
            if($data_existing > 0){
                session()->flash('delete','Data LBDS sudah ada sebelumnya — import ditolak untuk menghindari duplikasi.');
                return back();
            }

            if($jumlah_pohon != $jumlah_data_xls){
                session()->flash('delete',
                    "DATA TIDAK SESUAI!".
                    "<br>Jumlah pohon database : <b>$jumlah_pohon</b>".
                    "<br>Jumlah pada Excel   : <b>$jumlah_data_xls</b>".
                    "<br>Perbaiki Excel sesuai jumlah pohon pada plot tersebut."
                );
                return back();
            }

            // ==== Siap Insert ====
            $kon_pertumbuhan = [];
            $i=0;

            foreach($sheet as $row){
                if(is_numeric($row[1]) && $row[0] == $no_plot){

                    $kon_pertumbuhan[] = [
                        'id_pengukuran' => $id_pengukuran,
                        'id_tanaman'    => $data_pohon[$i++]->id_tanaman_plot,
                        'azimuth'       => $row[2],
                        'jarak'         => $row[3],
                        'keliling'      => $row[4],
                        'jarijari'      => $row[5],
                        'tinggi'        => $row[6],
                        'Hasil_LBDS'    => (($row[5]/100)*($row[5]/100))*3.14*0.25,
                        'v'             => (($row[5]/100)*($row[5]/100))*3.14*0.25*$row[6]*0.7,
                        'isInserted'    => 1
                    ];
                }
            }

            try{
                DB::table('lbds')->insert($kon_pertumbuhan);
                session()->flash('insert', "Data pertumbuhan berhasil diimport dan tersimpan.");
            }catch(QueryException $e){
                throw new CustomException($e->getMessage());
            }
        }

        return back();
    }
}

