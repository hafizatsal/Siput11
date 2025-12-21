<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Exceptions\CustomException;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use App\Services\WilayahSyncService;
use App\Jobs\WilayahSyncJob;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class LokasiController extends Controller
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
      $data=DB::table('provinsi')
      ->orderBy('nama_provinsi')->get();
      return view('admin.lokasi',[
        'data'=>$data,
      ]);
  }

  public function insert(Request $req)
  {
    // fungsi ini digunakan untuk menambahkan data provinsi
    // id dibuat otomatis autoincrement
    $nama_provinsi = $req->input('nama_lokasi');
    // menyimpan data provinsi ke dalam array
    $data_provinsi = array(
      'nama_provinsi' => $nama_provinsi,
    );
    // memasukkkan data ke table data provinsi
    try{
      DB::table('provinsi')->insert($data_provinsi);
      session()->flash('insert', 'Data Provinsi berhasil ditambah.');
  }
  catch(\Illuminate\Database\QueryException $e){
    throw new CustomException($e->getMessage());
  }
    return back(); // kembali ke halaman data provinsi
  }

  public function update(Request $req)
  {
    $id_provinsi = $req->input('id_lokasi2');
    $nama_provinsi = $req->input('nama_lokasi2');

    // menyimpan data provinsi
    $data_provinsi = array(
      'nama_provinsi' => $nama_provinsi,
    );
    // mengubah data provinsi
    try{
      DB::table('provinsi')->where('id_provinsi', $id_provinsi)->update($data_provinsi);
      session()->flash('insert', 'Data Provinsi berhasil diubah.');
  }
  catch(\Illuminate\Database\QueryException $e){
    throw new CustomException($e->getMessage());
  }
    return back(); // kembali ke halaman data provinsi
  }

  // fungsi untuk menghapus data lokasi
  public function delete(Request $req)
  {
    // menghapus data berdasarkan id
    try{
    DB::table('provinsi')->where('id_provinsi',$req->input('hapus_id_lokasi'))->delete();
    session()->flash('insert', 'Data Provinsi berhasil dihapus.');
    }
    catch(\Illuminate\Database\QueryException $e){
      throw new CustomException($e->getMessage());
    }

    return back(); // fungsi untuk mengarahkan ke halaman data lokasi
    // setelah menghapus data
  }

  // fungsi untuk mengembalikan nilai array data lokasi
  public function lokasi(Request $req)
  {
    $id_provinsi = $req->id;
    $provinsi= DB::table('provinsi')
    ->where('id_provinsi', '=', $id_provinsi)
    ->get();
    return response()->json($provinsi);
  }

  public function sync(Request $req, WilayahSyncService $service)
  {
    $provinsiApiId = $req->input('provinsi_api_id');
    $depth = $req->input('sync_depth', config('wilayah.sync_depth'));

    $statusKey = 'wilayah_sync_status_admin_' . Auth::id();
    $cancelKey = 'wilayah_sync_cancel_admin_' . Auth::id();
    $historyKey = 'wilayah_sync_history_admin_' . Auth::id();
    Cache::forget($cancelKey);
    Cache::put($statusKey, [
      'status' => 'queued',
      'message' => 'Sync masuk antrian.',
      'queued_at' => now()->toDateTimeString(),
    ], 86400);

    WilayahSyncJob::dispatch($provinsiApiId, $depth, $statusKey, $cancelKey, $historyKey);
    session()->flash('insert', 'Sync diproses di background. Jangan menutup halaman sampai selesai.');

    return back();
  }

  public function syncStatus()
  {
    $statusKey = 'wilayah_sync_status_admin_' . Auth::id();
    $historyKey = 'wilayah_sync_history_admin_' . Auth::id();
    $status = Cache::get($statusKey, ['status' => 'idle']);
    $status['history'] = Cache::get($historyKey, []);
    return response()->json($status);
  }

  public function syncCancel(Request $req)
  {
    $statusKey = 'wilayah_sync_status_admin_' . Auth::id();
    $cancelKey = 'wilayah_sync_cancel_admin_' . Auth::id();

    Cache::put($cancelKey, true, 86400);
    Cache::put($statusKey, [
      'status' => 'cancelling',
      'message' => 'Membatalkan sync...',
      'updated_at' => now()->toDateTimeString(),
    ], 86400);

    if ($req->expectsJson()) {
      return response()->json(['status' => 'cancelling']);
    }

    return redirect()->route('admin.lokasi')->with('insert', 'Permintaan pembatalan dikirim. Tunggu sampai proses berhenti.');
  }
}
