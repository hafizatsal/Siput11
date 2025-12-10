<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    //
    public function index()
    {
      $data=DB::table('tbl_klaster_plot')->get();

      return view('admin.data_pengukuran',[
        'data'=>$data,
      ]);
    }
}
