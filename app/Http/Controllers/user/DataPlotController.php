<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class DataPlotController extends Controller
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

    private function assertOwnsKlasterPlot($id_klaster_plot)
    {
      $owns = DB::table('tbl_klaster_plot')
        ->leftJoin('kategori_klaster', function ($join) {
          $join->on('kategori_klaster.id_data_klaster', '=', 'tbl_klaster_plot.id_data_klaster')
            ->orOn('kategori_klaster.id_data_klaster2', '=', 'tbl_klaster_plot.id_data_klaster');
        })
        ->where('tbl_klaster_plot.id_klaster_plot', $id_klaster_plot)
        ->where('kategori_klaster.input_by', Auth::id())
        ->exists();
      if (!$owns) {
        abort(403, 'Unauthorized');
      }
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
    public function index()
    {
        return view('user.home');
    }

    public function data_plot_klaster3(Request $req)
    {
      $id = $req->id;
      $this->assertOwnsKlasterPlot($id);
      $data_plot = DB::table('tbl_plot')
      ->where('id_klaster_plot','=',$id)
      ->get();

      return response()->json($data_plot);
    }

    public function data_pengukuran2(Request $req)
    {
      $id = $req->id;
      $this->assertOwnsPlot($id);
      $data_pengukuran = DB::table('pengukuran_master')
      ->where('id_plot','=',$id)
      ->get();

      return response()->json($data_pengukuran);
    }

}
