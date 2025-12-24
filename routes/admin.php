<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;

use App\Http\Controllers\admin\ProfileController;
use App\Http\Controllers\admin\UserController;
use App\Http\Controllers\admin\LokasiController;
use App\Http\Controllers\admin\PohonController;
use App\Http\Controllers\admin\FaunaController;
use App\Http\Controllers\admin\KabupatenController;
use App\Http\Controllers\admin\KecamatanController;
use App\Http\Controllers\admin\DesaController;
use App\Http\Controllers\admin\FungsiController;
use App\Http\Controllers\admin\InstansiController;
use App\Http\Controllers\admin\PlotController;
use App\Http\Controllers\admin\IndikatorTanahController;
use App\Http\Controllers\admin\IndikatorController;
use App\Http\Controllers\admin\hmjfController;
use App\Http\Controllers\admin\PengumumanController;
use App\Http\Controllers\admin\BerkasController;
use App\Http\Controllers\admin\PasswordController;
use App\Http\Controllers\admin\NilaiTertimbangController;

Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->group(function () {
        /* ====================== HOME ====================== */
        Route::get('/home', function () {
            $users['users'] = \App\Models\User::all();
            $riwayat = DB::table('login')->select('login.time_login', 'login.time_logout', 'username')->join('users', 'users.id', '=', 'login.id_user')->orderBy('login.time_login', 'DESC')->limit(100)->get();

            $jumlah_user = DB::table('users')->count();
            $jumlah_sifat = DB::table('tbl_sifat_kimia_tanah')->count();
            $jumlah_pohon = DB::table('table_master_jenis_tanaman')->count();
            $jumlah_fauna = DB::table('tabel_master_fauna')->count();

            return view('admin.home', $users, compact('riwayat', 'jumlah_user', 'jumlah_sifat', 'jumlah_pohon', 'jumlah_fauna'));
        })->name('admin.home');

        /* ========== PROFILE ========== */
        Route::get('/profile', [ProfileController::class, 'index'])->name('admin.profile2');
        Route::post('/profile/edit', [ProfileController::class, 'edit'])->name('admin.profile_edit2');

        Route::get('/ubahPassword', [PasswordController::class, 'index'])->name('admin.ubah_password_admin');
        Route::post('/passwordUbah', [PasswordController::class, 'changePassword'])->name('admin.password_ubah_admin');

        /* ========== USER MANAGEMENT ========== */
        Route::get('/user', [UserController::class, 'index'])->name('admin.user');
        Route::post('/user/insert', [UserController::class, 'insert'])->name('admin.user.insert');
        Route::post('/user/hapus', [UserController::class, 'hapus'])->name('admin.hapus_user');
        Route::post('/user/banned', [UserController::class, 'ban'])->name('admin.ban_user');

        /* ========== LOKASI ========== */
        Route::get('/lokasi', [LokasiController::class, 'index'])->name('admin.lokasi');
        Route::get('/lokasi/kabupaten/{id}', [KabupatenController::class, 'index'])->name('admin.kabupaten');
        Route::get('/lokasi/kabupaten/kecamatan/{id}', [KecamatanController::class, 'index'])->name('admin.kecamatan');
        Route::get('/lokasi/kabupaten/kecamatan/desa/{id}', [DesaController::class, 'index'])->name('admin.desa');

        /* ========== HMJF ========== */
        Route::get('/hmjf', [hmjfController::class, 'index'])->name('admin.hmjf');
        Route::post('/hmjf/insert', [hmjfController::class, 'insert'])->name('admin.hmjf.insert');
        Route::post('/hmjf/edit', [hmjfController::class, 'update'])->name('admin.edit_hak');
        Route::post('/hapus_hak', [hmjfController::class, 'delete'])->name('admin.hapus_hak');
        Route::post('/json-hak2', [hmjfController::class, 'hak2'])->name('admin.json_hak');

        /* ========== FUNGSI ========== */
        Route::post('/fungsi/insert', [FungsiController::class, 'insert'])->name('admin.fungsi.insert');
        Route::post('/fungsi/edit', [FungsiController::class, 'update'])->name('admin.edit_fungsi');
        Route::post('/json-fungsi', [FungsiController::class, 'fungsi'])->name('admin.json_fungsi');
        Route::post('/hapus_fungsi', [FungsiController::class, 'delete'])->name('admin.hapus_fungsi');

        /* ========== DATA POHON ========== */
        Route::get('/pohon', [PohonController::class, 'index'])->name('admin.pohon');
        Route::post('/pohon/insert', [PohonController::class, 'insert'])->name('admin.pohon.insert');
        Route::post('/pohon/edit', [PohonController::class, 'update'])->name('admin.edit_pohon');
        Route::post('/hapus_pohon', [PohonController::class, 'delete'])->name('admin.hapus_pohon');
        Route::post('/json-pohon2', [PohonController::class, 'pohon2'])->name('admin.json_pohon');

        /* ========== FAUNA ========== */
        Route::post('/json-fauna', [FaunaController::class, 'fauna'])->name('admin.json_fauna');
        Route::post('/fauna/insert', [FaunaController::class, 'insert'])->name('admin.fauna.insert');
        Route::post('/fauna/edit', [FaunaController::class, 'update'])->name('admin.edit_fauna');
        Route::post('/hapus_fauna', [FaunaController::class, 'delete'])->name('admin.hapus_fauna');
        Route::get('/fauna', [FaunaController::class, 'index'])->name('admin.fauna');

        /* ========== SIFAT TANAH ========== */
        Route::get('/sifat_tanah', [IndikatorTanahController::class, 'index'])->name('admin.sifat_tanah');
        Route::post('/tanah/insert', [IndikatorTanahController::class, 'insert'])->name('admin.tanah.insert');
        Route::post('/tanah/edit', [IndikatorTanahController::class, 'update'])->name('admin.edit_tanah');
        Route::post('/hapus_tanah', [IndikatorTanahController::class, 'delete'])->name('admin.hapus_tanah');
        Route::post('/json-tanah2', [IndikatorTanahController::class, 'tanah2'])->name('admin.json_tanah');

        /* ========== TAJUK ========== */
        Route::get('/nilai_tajuk', [IndikatorController::class, 'index'])->name('admin.nilai_tajuk');
        Route::post('/json-tajuk2', [IndikatorController::class, 'tajuk'])->name('admin.json_tajuk');
        Route::post('/tajuk/edit', [IndikatorController::class, 'update'])->name('admin.edit_tajuk');

        /* ========== KERUSAKAN LOKASI ========== */
        Route::get('/nilai_kerusakan_lokasi', [IndikatorController::class, 'index_lokasi'])->name('admin.nilai_kerusakan_lokasi');
        Route::post('/nilai_kerusakan_lokasi/insert', [IndikatorController::class, 'insert_lokasi'])->name('admin.nilai_kerusakan_lokasi.insert');
        Route::post('/hapus_lokasi_kerusakan', [IndikatorController::class, 'delete'])->name('admin.hapus_lokasi_kerusakan');
        Route::post('/lokasi_kerusakan/edit', [IndikatorController::class, 'update_lokasi'])->name('admin.edit_lokasi_kerusakan');
        Route::post('/json-lokasi_kerusakan', [IndikatorController::class, 'lokasi_kerusakan'])->name('admin.json_lokasi_kerusakan');

        /* ========== KERUSAKAN TIPE ========== */
        Route::get('/nilai_kerusakan_tipe', [IndikatorController::class, 'index_tipe'])->name('admin.nilai_kerusakan_tipe');
        Route::post('/nilai_kerusakan_tipe/insert', [IndikatorController::class, 'insert_tipe'])->name('admin.nilai_kerusakan_tipe.insert');
        Route::post('/hapus_tipe_kerusakan', [IndikatorController::class, 'delete_tipe'])->name('admin.hapus_tipe_kerusakan');
        Route::post('/tipe_kerusakan/edit', [IndikatorController::class, 'update_tipe'])->name('admin.edit_tipe_kerusakan');
        Route::post('/json-tipe_kerusakan', [IndikatorController::class, 'tipe_kerusakan'])->name('admin.json_tipe_kerusakan');

        /* ========== KERUSAKAN KEPARAHAN ========== */
        Route::get('/nilai_kerusakan_keparahan', [IndikatorController::class, 'index_keparahan'])->name('admin.nilai_kerusakan_keparahan');
        Route::post('/nilai_kerusakan_keparahan/insert', [IndikatorController::class, 'insert_keparahan'])->name('admin.nilai_kerusakan_keparahan.insert');
        Route::post('/hapus_keparahan_kerusakan', [IndikatorController::class, 'delete_keparahan'])->name('admin.hapus_keparahan_kerusakan');
        Route::post('/keparahan_kerusakan/edit', [IndikatorController::class, 'update_keparahan'])->name('admin.edit_keparahan_kerusakan');
        Route::post('/json-keparahan_kerusakan', [IndikatorController::class, 'keparahan_kerusakan'])->name('admin.json_keparahan_kerusakan');

        /* ========== PENGUMUMAN ========== */
        Route::get('/pengumuman', [PengumumanController::class, 'index'])->name('admin.pengumuman');
        Route::post('/pengumuman/insert', [PengumumanController::class, 'insert'])->name('admin.pengumuman.insert');
        Route::post('/pengumuman_tambah/insert', [PengumumanController::class, 'insert2'])->name('admin.pengumuman_tambah.insert');

        /* ========== BERKAS ========== */
        Route::get('/berkas', [BerkasController::class, 'index'])->name('admin.berkas');
        Route::post('/berkas/edit', [BerkasController::class, 'edit'])->name('admin.berkas_edit');

        /* ===================== PLOT ===================== */
        Route::get('/plot', [PlotController::class, 'index'])->name('admin.plot');

        /* ===================== INSTANSI ===================== */
        Route::get('/instansi', [InstansiController::class, 'index'])->name('admin.instansi');
        Route::post('/instansi/insert', [InstansiController::class, 'insert'])->name('admin.instansi.insert');
        Route::post('/instansi/edit', [InstansiController::class, 'update'])->name('admin.edit_instansi');
        Route::post('/json-instansi', [InstansiController::class, 'instansi'])->name('admin.json_instansi');
        Route::post('/hapus_instansi', [InstansiController::class, 'delete'])->name('admin.hapus_instansi');

        /* ===================== LOKASI ===================== */
        Route::post('/json-lokasi', [LokasiController::class, 'lokasi'])->name('admin.json_lokasi');
        Route::post('/lokasi/insert', [LokasiController::class, 'insert'])->name('admin.lokasi.insert');
        Route::post('/lokasi/edit', [LokasiController::class, 'update'])->name('admin.edit_lokasi');
        Route::post('/hapus_lokasi', [LokasiController::class, 'delete'])->name('admin.hapus_lokasi');

        /* ===================== KABUPATEN ===================== */
        Route::post('/kabupaten/insert', [KabupatenController::class, 'insert'])->name('admin.kabupaten.insert');
        Route::post('/json-kabupaten', [KabupatenController::class, 'kabupaten'])->name('admin.json_kabupaten');
        Route::post('/kabupaten/edit', [KabupatenController::class, 'update'])->name('admin.edit_kabupaten');
        Route::post('/hapus_kabupaten', [KabupatenController::class, 'delete'])->name('admin.hapus_kabupaten');

        /* ===================== KECAMATAN ===================== */
        Route::post('/kecamatan/insert', [KecamatanController::class, 'insert'])->name('admin.kecamatan.insert');
        Route::post('/json-kecamatan', [KecamatanController::class, 'kecamatan'])->name('admin.json_kecamatan');
        Route::post('/kecamatan/edit', [KecamatanController::class, 'update'])->name('admin.edit_kecamatan');
        Route::post('/hapus_kecamatan', [KecamatanController::class, 'delete'])->name('admin.hapus_kecamatan');

        /* ===================== DESA ===================== */
        Route::post('/desa/insert', [DesaController::class, 'insert'])->name('admin.desa.insert');
        Route::post('/json-desa', [DesaController::class, 'desa'])->name('admin.json_desa');
        Route::post('/desa/edit', [DesaController::class, 'update'])->name('admin.edit_desa');
        Route::post('/hapus_desa', [DesaController::class, 'delete'])->name('admin.hapus_desa');

        /* ===================== NILAI TERTIMBANG (opsional kalau dipakai) ===================== */

        Route::get('/nilai_tertimbang', [NilaiTertimbangController::class, 'index'])->name('admin.nilai_tertimbang');
        Route::post('/tertimbang/insert', [NilaiTertimbangController::class, 'insert'])->name('admin.tertimbang.insert');
        Route::post('/tertimbang/edit', [NilaiTertimbangController::class, 'update'])->name('admin.edit_tertimbang');
        Route::post('/hapus_tertimbang', [NilaiTertimbangController::class, 'delete'])->name('admin.hapus_tertimbang');
        Route::get('/json-tertimbang', [NilaiTertimbangController::class, 'tertimbang'])->name('admin.json_tertimbang');;

        // Route::get('/data_pengukuran_admin', [App\Http\Controllers\admin\AdminController::class,'index'])
        //     ->name('data_pengukuran_admin');

        // Route::post('/data_pengukuran/insert', [App\Http\Controllers\admin\PengukuranController::class,'insert'])
        //     ->name('data_pengukuran_insert');

        // Route::get('/data_pengukuran/hapus', [App\Http\Controllers\admin\PengukuranController::class,'hapus'])
        //     ->name('hapus_data_pengukuran');

        // Route::get('/skoring_kesehatan_hutan', [App\Http\Controllers\admin\SkoringController::class,'index'])
        //     ->name('skoring_kesehatan_hutan');
    });
