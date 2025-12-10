<?php

namespace App\Http\Controllers\auditor;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
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

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('auditor.home');
    }

    public function data_plot_klaster3(Request $req)
    {
      $id = $req->id;
      $data_plot = DB::table('tbl_plot')
      ->where('id_klaster_plot','=',$id)
      ->get();

      return response()->json($data_plot);
    }

    public function data_pengukuran2(Request $req)
    {
      $id = $req->id;
      $data_pengukuran = DB::table('pengukuran_master')
      ->where('id_plot','=',$id)
      ->get();

      return response()->json($data_pengukuran);
    }

}
