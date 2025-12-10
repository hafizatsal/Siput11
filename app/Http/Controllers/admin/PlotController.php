<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PlotController extends Controller
{
  public function index()
  {
      return view('admin.plot');
  }
}
