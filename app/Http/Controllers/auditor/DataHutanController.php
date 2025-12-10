<?php

namespace App\Http\Controllers\auditor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
class DataHutanController extends Controller
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
        return view('auditor.home');
    }

    public function data2(Request $req)
    {
      $id_klaster = $req->id;
      $data_klaster = DB::table('tbl_klaster_plot')
                   ->join(
                      'hak_milik_jenis_fungsi_hutan',
                      'hak_milik_jenis_fungsi_hutan.id_klaster_plot','=','tbl_klaster_plot.id_klaster_plot')

                  ->join(
                    'tbl_hak_milik',
                    'tbl_hak_milik.id_hak_milik','=','hak_milik_jenis_fungsi_hutan.id_hak_milik')
                  ->join(
                    'fungsi_hutan',
                    'fungsi_hutan.id_fungsi_hutan','=','hak_milik_jenis_fungsi_hutan.id_fungsi_hutan')
                  ->join(
                    'lokasi',
                    'lokasi.id_klaster_plot','=','tbl_klaster_plot.id_klaster_plot')
                  ->join(
                    'desa',
                    'desa.id','=','lokasi.id_desa')
                  ->join(
                    'kecamatan',
                    'kecamatan.id','=','lokasi.id_kecamatan')
                  ->join(
                    'kabupaten',
                    'kabupaten.id','=','lokasi.id_kabupaten')
                   ->join(
                    'provinsi',
                    'provinsi.id_provinsi','=','lokasi.id_provinsi'
                  )->where('hak_milik_jenis_fungsi_hutan.id_klaster_plot', '=', $id_klaster)
                  ->get();
                  return response()->json($data_klaster);
    }
}
