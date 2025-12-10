<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
class DownloadController extends Controller
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

    public function template_ts()
    {
      $pathToFile =  public_path(). "/upload/berkas/Tally Sheet Pengukuran Kesehatan Hutan.xls";
        return response()->download($pathToFile);
    }

    public function template_ts_w()
    {
      $pathToFile =  public_path(). "/upload/berkas/Lampiran Tally Sheet Pengukuran Kesehatan Hutan.doc";
        return response()->download($pathToFile);
    }

    public function panduan_siput()
    {
      $pathToFile =  public_path(). "/upload/berkas/Panduan Penggunaan SIPUT.pdf";
        return response()->download($pathToFile);
    }

    public function panduan_import()
    {
      $pathToFile =  public_path(). "/upload/berkas/Panduan Import SIPUT.pdf";
        return response()->download($pathToFile);
    }
}
