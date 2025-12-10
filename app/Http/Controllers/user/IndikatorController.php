<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Exceptions\CustomException;

class IndikatorController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('user.home');
    }

    public function plot($id)
    {
        $id = decrypt($id);

        $data = DB::table('data_tanaman_plot')
            ->join('table_master_jenis_tanaman',
                'table_master_jenis_tanaman.id_jenis_tanaman','=','data_tanaman_plot.id_master_jenis_tanaman'
            )->get();

        $data_plot = DB::table('tbl_plot')
            ->leftJoin('tbl_klaster_plot','tbl_klaster_plot.id_klaster_plot','=','tbl_plot.id_klaster_plot')
            ->leftJoin('pola_tanam','pola_tanam.id_pola_tanam','=','tbl_klaster_plot.pola_tanam')
            ->leftJoin('pengukuran_master','pengukuran_master.id_plot','=','tbl_plot.id_plot')
            ->leftJoin('lokasi','lokasi.id_klaster_plot','=','tbl_klaster_plot.id_klaster_plot')
            ->leftJoin('desa','desa.id','=','lokasi.id_desa')
            ->leftJoin('kecamatan','kecamatan.id','=','lokasi.id_kecamatan')
            ->leftJoin('kabupaten','kabupaten.id','=','lokasi.id_kabupaten')
            ->leftJoin('provinsi','provinsi.id_provinsi','=','lokasi.id_provinsi')
            ->where('tbl_plot.id_plot',$id)
            ->orderBy('tbl_plot.id_plot','ASC')
            ->first();

        return view('user.detail_plot',[
            'data'=>$data,
            'plot'=>$data_plot,
        ]);
    }

    public function pertumbuhan($id)
    {
        $id = decrypt($id);

        $data_pengukuran = DB::table('pengukuran_master')
            ->join('tbl_plot','tbl_plot.id_plot','=','pengukuran_master.id_plot')
            ->where('pengukuran_master.id_pengukuran',$id)
            ->first();

        $pengukuran_ke = $data_pengukuran->pengukuran_ke;
        $id_plot = $data_pengukuran->id_plot;

        $id_klaster_plot = DB::table('tbl_plot')->where('id_plot',$id_plot)->value('id_klaster_plot');

        $data_pohon = DB::table('pengukuran_master')
            ->join('data_tanaman_plot','data_tanaman_plot.id_plot','=','pengukuran_master.id_plot')
            ->join('table_master_jenis_tanaman','table_master_jenis_tanaman.id_jenis_tanaman','=','data_tanaman_plot.id_master_jenis_tanaman')
            ->leftJoin('lbds','data_tanaman_plot.id_tanaman_plot','=','lbds.id_tanaman')
            ->where('pengukuran_master.id_pengukuran',$id)
            ->where('data_tanaman_plot.pengukuran_ke',$pengukuran_ke)
            ->get();

        $data_pertumbuhan = DB::table('lbds')
            ->where('id_pengukuran',$id)
            ->get();

        return view('user.data_pertumbuhan', compact(
            'id','data_pengukuran','data_pohon','data_pertumbuhan','id_plot','id_klaster_plot'
        ));
    }

    public function delete(Request $req)
    {
        try{
            DB::table('lbds')->where('id',$req->hapus_id)->delete();
            session()->flash('delete','Data berhasil dihapus.');
        } catch(\Illuminate\Database\QueryException $e){
            throw new CustomException($e->getMessage());
        }
        return back();
    }

    public function delete_all(Request $req)
    {
        try{
            DB::table('lbds')->where('id_pengukuran',$req->hapus_id_all)->delete();
            session()->flash('delete','Semua data berhasil dihapus.');
        } catch(\Illuminate\Database\QueryException $e){
            throw new CustomException($e->getMessage());
        }
        return back();
    }
}
