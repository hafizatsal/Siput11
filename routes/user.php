<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;

/* ================== CONTROLLERS INTI USER ================== */
use App\Http\Controllers\user\HomeController;
use App\Http\Controllers\user\ProfileController;
use App\Http\Controllers\user\PlotUkurController;
use App\Http\Controllers\user\DataIndikatorController;
use App\Http\Controllers\user\KtkController;
use App\Http\Controllers\user\KlasterController;
use App\Http\Controllers\user\SkoringController;

/* ===== Wajib Ada (dipakai SIPUT lama) ===== */
use App\Http\Controllers\user\PlotController;
use App\Http\Controllers\user\ImportPohonController;
use App\Http\Controllers\user\ImportFaunaController;
use App\Http\Controllers\user\KerusakanController;
use App\Http\Controllers\user\TajukController;
use App\Http\Controllers\user\LbdsController;
use App\Http\Controllers\user\SkoringExportController;
use App\Http\Controllers\user\PasswordController;
use App\Http\Controllers\user\PengukuranController;
use App\Http\Controllers\user\DataPlotController;
use App\Http\Controllers\user\DownloadController;
use App\Http\Controllers\user\IndikatorController;
use App\Http\Controllers\user\DataHutanController;
use App\Http\Controllers\user\SkoringControllerNew;

Route::middleware(['auth', 'user'])
    ->prefix('user')
    ->group(function () {

        /* =========================== HOME =========================== */
        Route::get('/home', function () {
            $pengumuman = DB::table('pengumuman')->get();
            return view('user.home', compact('pengumuman'));
        })->name('user.home');

        Route::get('/json-koordinat', [HomeController::class, 'titik'])->name('user.koordinat_home');

        /* ========================== PROFILE ========================== */
        Route::post('/profile/edit', [ProfileController::class, 'edit'])->name('user.profile_edit');
        Route::get('/profile', [ProfileController::class, 'index'])->name('user.profile');

        /* ====================== DATA PLOT UKUR ======================= */
        Route::get('/plot_ukur/klaster', [PlotUkurController::class, 'index'])->name('user.data_klaster');
        Route::get('/plot_ukur/klaster/lihat', [PlotUkurController::class, 'lihat'])->name('user.data_klaster.lihat');
        Route::post('/plot_ukur/klaster/insert', [PlotUkurController::class, 'insert'])->name('user.data_klaster.insert');

        Route::get('/plot_ukur/klaster_plot', [PlotUkurController::class, 'indexDataKlaster'])->name('user.data_klaster_plot');
        Route::post('/json-data_klaster_plot2', [PlotUkurController::class, 'data_klaster_plot2'])->name('user.json_data_klaster_plot2');
        Route::post('/json-data_klaster_plot3', [PlotUkurController::class, 'data_klaster_plot3'])->name('user.json_data_klaster_plot3');

        Route::get('/plot_ukur/klaster/{id}', [PlotUkurController::class, 'klaster_plot'])->name('user.klaster_plot');
        Route::post('/plot_ukur/klaster/edit', [PlotUkurController::class, 'edit'])->name('user.data_klaster.edit');
        Route::post('/plot_ukur/klaster/delete', [PlotUkurController::class, 'delete'])->name('user.data_klaster.delete');

        Route::post('/json-data_klaster2', [PlotUkurController::class, 'data_klaster2'])->name('user.json_data_klaster2');
        Route::post('/json-data_tahun', [PlotUkurController::class, 'data_tahun'])->name('user.json_data_tahun');
        Route::post('/json-data_tahun2', [PlotUkurController::class, 'data_tahun2'])->name('user.json_data_tahun2');
        Route::post('/json-data_kategori', [PlotUkurController::class, 'data_kategori'])->name('user.json_data_kategori');

        /* ================= DETAIL KLASTER PLOT ================== */
        Route::get('/plot_ukur/klaster/detail/{id}', [KlasterController::class, 'detail_klaster_plot'])->name('user.detail_klaster');
        Route::get('/plot_ukur/detail_klaster', [KlasterController::class, 'detail_klaster_plots'])->name('user.detail_klaster_all');
        Route::post('/plot_ukur/klaster/data_klaster/insert', [KlasterController::class, 'insert_klaster_plot'])->name('user.insert_klaster');
        Route::get('/plot_ukur/klaster/data_klaster/edit', [KlasterController::class, 'update_klaster_plot'])->name('user.edit_klaster');
        Route::get('/plot_ukur/klaster/data_klaster/hapus', [KlasterController::class, 'hapus_klaster_plot'])->name('user.hapus_klaster');
        Route::get('/plot_ukur/editPlot', [KlasterController::class, 'editPlot'])->name('user.editPlot');

        /* ========================= DATA PLOT ========================= */
        Route::get('/plot_ukur/plot', [PlotUkurController::class, 'indexDataPlot'])->name('user.data_plot');
        Route::post('/json-data-plot-klaster3', [DataPlotController::class, 'data_plot_klaster3'])->name('user.data_plot_klaster3');
        Route::get('/plot_ukur/detail_plot', [KlasterController::class, 'detail_plots'])->name('user.detail_plot');
        Route::get('/plot_ukur/lihat_plot/{id}', [KlasterController::class, 'detailPlot'])->name('user.lihat_plot');
        Route::post('/json-data-pengukuran2', [DataPlotController::class, 'data_pengukuran2'])->name('user.data_pengukuran2');

        /* ================= INSERT & EDIT PENGUKURAN ================= */
        Route::post('/plot_ukur/pengukuran/insert', [PlotController::class, 'tambah'])->name('user.pengukuran.insert');
        Route::post('/plot_ukur/pengukuran/insert2', [PlotController::class, 'tambah2'])->name('user.pengukuran.insert2');
        Route::get('/plot_ukur/pengukuran/hapus', [PlotController::class, 'hapus_pengukuran'])->name('user.pengukuran.hapus');
        Route::get('/plot_ukur/pengukuran/edit', [PlotController::class, 'edit_pengukuran'])->name('user.pengukuran.edit');

        /* ====================== DATA PENGUKURAN ====================== */
        Route::get('/data_pengukuran/indikator/{id}', [DataIndikatorController::class, 'dataIndikator'])->name('user.data_indikator');
        Route::get('/data_pengukuran/biodiversitas/{id}', [DataIndikatorController::class, 'paramBiodiversitas'])->name('user.pengukuran_biodiversitas');
        Route::get('/data_pengukuran/bio_pohon/{id}', [DataIndikatorController::class, 'biodivPohon'])->name('user.bio_pohon');
        Route::get('/data_pengukuran/bio_fauna/{id}', [DataIndikatorController::class, 'biodivFauna'])->name('user.bio_fauna');

        Route::get('/data_pengukuran', [PengukuranController::class, 'home'])->name('user.data_pengukuranplot');
        Route::get('/data_pengukuran/lihat', [PengukuranController::class, 'lihatpengukuran'])->name('user.lihatpengukuran');
        Route::get('/data_pengukuran/lihat/{id}', [PengukuranController::class, 'lihatpengukurans'])->name('user.lihatpengukurans');

        Route::get('/data_pengukuran/prod', [DataIndikatorController::class, 'indexDataPengukuranp'])->name('user.data_pengukuranp');
        Route::get('/data_pengukuran/vit', [DataIndikatorController::class, 'indexDataPengukuranv'])->name('user.data_pengukuranv');
        Route::get('/data_pengukuran/bio', [DataIndikatorController::class, 'indexDataPengukuranb'])->name('user.data_pengukuranb');
        Route::get('/data_pengukuran/ktk', [DataIndikatorController::class, 'indexDataPengukurank'])->name('user.data_pengukurank');
        Route::get('/data_pengukuran/prod_lbds', [DataIndikatorController::class, 'lbds2'])->name('user.plbds');
        Route::get('/data_pengukuran/vital', [DataIndikatorController::class, 'vit'])->name('user.pvit');
        Route::get('/data_pengukuran/biodiv', [DataIndikatorController::class, 'bio'])->name('user.pbio');
        Route::get('/data_pengukuran/ktapak', [DataIndikatorController::class, 'ktk'])->name('user.pktk');


        /* ====================== PRODUKTIVITAS ====================== */
        Route::get('/data_pengukuran/produktivitas/{id}', [DataIndikatorController::class, 'paramProduktivitas'])->name('user.pengukuran_produktivitas');
        Route::get('/data_pengukuran/prod_lbds/{id}', [DataIndikatorController::class, 'lbds'])->name('user.lbds');
        Route::get('/data_pengukuran/pertumbuhan/{id}', [IndikatorController::class, 'pertumbuhan'])->name('user.pertumbuhan');
        Route::post('/import_lbds', [LbdsController::class, 'importExcel'])->name('user.import_lbds');

        /* ====================== VITALITAS ====================== */
        Route::get('/data_pengukuran/vitalitas/{id}', [DataIndikatorController::class, 'paramVitalitas'])->name('user.pengukuran_vitalitas');
        Route::get('/data_pengukuran/vit_kerusakan/{id}', [DataIndikatorController::class, 'kerusakan'])->name('user.kerusakan');
        Route::get('/data_pengukuran/vit_tajuk/{id}', [DataIndikatorController::class, 'tajuk'])->name('user.tajuk');

        Route::post('/import_kerusakan', [KerusakanController::class, 'importExcel'])->name('user.import_kerusakan');

        /* ==================== POHON ==================== */
        Route::post('/tambah_pohon', [PlotController::class, 'tambah_pohon'])->name('user.tambah_pohon');
        Route::post('/edit_pohon', [PlotController::class, 'edit_pohon'])->name('user.edit_pohon_plot');
        Route::get('/data_pohon/hapus', [PlotController::class, 'hapus_pohon'])->name('user.hapus_pohon');
        Route::get('/hapus_all_pohon', [PlotController::class, 'delete_all_pohon'])->name('user.hapus_all_pohon');
        Route::post('/import_pohon', [ImportPohonController::class, 'importExcel'])->name('user.import_pohon');

        /* ==================== KTK ==================== */
        Route::post('/tambah_ktk_kimia', [KlasterController::class, 'tambahKimia'])->name('user.tambah_kimia');
        Route::post('/edit_ktk_kimia', [KlasterController::class, 'editKimia'])->name('user.edit_kimia');
        Route::get('/ktk/hapus', [KlasterController::class, 'hapus_kimia'])->name('user.hapus_ktk_kimia');
        Route::get('/data_pengukuran/ktk/{id}', [DataIndikatorController::class, 'paramKtk'])->name('user.pengukuran_ktk');
        Route::get('/data_pengukuran/ktk_kimia/{id}', [DataIndikatorController::class, 'kimia'])->name('user.kimia');
        Route::get('/data_pengukuran/ktk_fisika/{id}', [DataIndikatorController::class, 'fisika'])->name('user.fisika');

        Route::post('/tambah_ktk_fisik', [KlasterController::class, 'tambahFisik'])->name('user.tambah_fisik');
        Route::post('/edit_ktk_fisik', [KlasterController::class, 'editFisik'])->name('user.edit_fisik');
        Route::get('/ktk/hapus_fisik', [KlasterController::class, 'hapus_fisika'])->name('user.hapus_ktk_fisik');

        /* ===================== FOTO KTK ===================== */
        Route::post('/tambah_pengukuran_plot/foto_ktk', [KtkController::class, 'tambahFotoKtk'])->name('user.tambah_foto_ktk');
        Route::get('/hapus_foto_ktk', [KtkController::class, 'deleteFotoKtk'])->name('user.hapus_foto_ktk');
        Route::post('/edit_pengukuran_plot/foto_ktk', [KtkController::class, 'editFotoKtk'])->name('user.edit_foto_ktk');
        Route::post('/json-foto_ktk', [KtkController::class, 'foto_ktk'])->name('user.json_foto_ktk');

        /* ===================== PENILAIAN ===================== */
        Route::get('/penilaian/klaster', [SkoringController::class, 'home'])->name('user.penilaian_klaster');
        Route::post('/penilaian/kesehatan', [SkoringControllerNew::class, 'index'])->name('user.penilaian_kesehatan');
        Route::post('/penilaian/kesehatan/detail', [SkoringController::class, 'detail'])->name('user.penilaian_kesehatan.detail');
        Route::post('/penilaian/kesehatan/detail_plot', [SkoringController::class, 'detail_plot'])->name('user.penilaian_kesehatan.plot');
        Route::post('/penilaian/klaster/export', [SkoringExportController::class, 'exportNilaiAkhir'])->name('user.penilaian_klaster_export');

        /* ===================== PENGUKURAN PLOT ===================== */
        Route::get('/data_pengukuran/pengukuran/plot/{id}', [PlotController::class, 'tambahPengukuranPlot'])->name('user.tambah_pengukuran_plot');
        Route::get('/indikator/{id}', [PlotController::class, 'lihatPlot'])->name('user.indikator');

        Route::post('/tambah_pengukuran_plot/pertumbuhan', [PlotController::class, 'tambahPertumbuhan'])->name('user.tambah_pertumbuhan');
        Route::get('/hapus_pertumbuhan', [IndikatorController::class, 'delete'])->name('user.hapus_pertumbuhan');
        Route::get('/hapus_all_pertumbuhan', [IndikatorController::class, 'delete_all'])->name('user.hapus_all_pertumbuhan');

        Route::post('/tambah_pengukuran_plot/foto_pertumbuhan', [PlotController::class, 'tambahFotoPertumbuhan'])->name('user.tambah_foto_pertumbuhan');
        Route::get('/hapus_foto_pertumbuhan', [PlotController::class, 'delete'])->name('user.hapus_foto_pertumbuhan');
        Route::post('/edit_pengukuran_plot/foto_pertumbuhan', [PlotController::class, 'editFotoPertumbuhan'])->name('user.edit_foto_pertumbuhan');
        Route::post('/json-foto_lbds', [PlotController::class, 'foto_lbds'])->name('user.json_foto_lbds');

        /* ===================== KERUSAKAN ===================== */
        Route::post('/tambah_pengukuran_plot/kerusakan', [PlotController::class, 'tambahKerusakan'])->name('user.tambah_kerusakan');
        Route::get('/hapus_kerusakan', [DataIndikatorController::class, 'delete_kerusakan'])->name('user.hapus_kerusakan');
        Route::get('/hapus_all_kerusakan', [DataIndikatorController::class, 'delete_kerusakan_all'])->name('user.hapus_all_kerusakan');

        Route::post('/tambah_pengukuran_plot/foto_kerusakan', [KerusakanController::class, 'tambahFotoKerusakan'])->name('user.tambah_foto_kerusakan');
        Route::get('/hapus_foto_kerusakan', [KerusakanController::class, 'deleteFotoKerusakan'])->name('user.hapus_foto_kerusakan');
        Route::post('/edit_pengukuran_plot/foto_kerusakan', [KerusakanController::class, 'editFotoKerusakan'])->name('user.edit_foto_kerusakan');
        Route::post('/json-foto_kerusakan', [KerusakanController::class, 'foto_kerusakan'])->name('user.json_foto_kerusakan');

        /* ===================== TAJUK ===================== */
        Route::post('/tambah_pengukuran_plot/tajuk', [PlotController::class, 'tambahTajuk'])->name('user.tambah_tajuk');
        Route::get('/hapus_tajuk', [DataIndikatorController::class, 'delete_tajuk'])->name('user.hapus_tajuk');
        Route::get('/hapus_all_tajuk', [DataIndikatorController::class, 'delete_tajuk_all'])->name('user.hapus_all_tajuk');

        Route::post('/tambah_pengukuran_plot/foto_tajuk', [TajukController::class, 'tambahFotoTajuk'])->name('user.tambah_foto_tajuk');
        Route::get('/hapus_foto_tajuk', [TajukController::class, 'deleteFotoTajuk'])->name('user.hapus_foto_tajuk');
        Route::post('/edit_pengukuran_plot/foto_tajuk', [TajukController::class, 'editFotoTajuk'])->name('user.edit_foto_tajuk');
        Route::post('/json-foto_tajuk', [TajukController::class, 'foto_tajuk'])->name('user.json_foto_tajuk');

        Route::get('/json-tajuk', [PlotController::class, 'tajuk'])->name('user.json_tajuk');
        Route::get('/json_kerusakan', [PlotController::class, 'kerusakan2'])->name('user.json_kerusakan');
        Route::post('/import_tajuk', [TajukController::class, 'importExcel'])->name('user.import_tajuk');

        /* ===================== FAUNA ===================== */
        Route::post('/tambah_fauna', [PlotController::class, 'tambah_fauna'])->name('user.tambah_fauna');
        Route::post('/edit_fauna', [PlotController::class, 'edit_fauna'])->name('user.edit_fauna_plot');
        Route::get('/data_fauna/hapus', [PlotController::class, 'hapus_fauna'])->name('user.hapus_fauna');
        Route::get('/hapus_all_fauna', [PlotController::class, 'delete_all_fauna'])->name('user.hapus_all_fauna');
        Route::get('/data_pohon/status', [PlotController::class, 'status_pohon'])->name('user.status_pohon');
        Route::post('/import_fauna', [ImportFaunaController::class, 'importExcel'])->name('user.import_fauna');

        /* ===================== SKORING ===================== */
        Route::get('/kabupaten_skor', [SkoringController::class, 'kabupaten_skor'])->name('user.kabupaten_skor');
        Route::get('/kecamatan_skor', [SkoringController::class, 'kecamatan_skor'])->name('user.kecamatan_skor');
        Route::get('/skor_pengukuran_ke', [SkoringController::class, 'pengukuranke'])->name('user.skor_pengukuran_ke');

        Route::get('/plot_ukur/nilai_tertimbang/{id}', [KlasterController::class, 'tertimbang'])->name('user.isi_nilai_tertimbang');
        Route::get('/nilai_tertimbang/hapus', [KlasterController::class, 'hapus_prod'])->name('user.hapus_tertimbang_prod');
        Route::get('/nilai_tertimbang/edit', [KlasterController::class, 'edit_tertimbang'])->name('user.edit_tertimbang');
        Route::post('/nilai_tertimbang/insert', [KlasterController::class, 'indikator_insert'])->name('user.indikator/insert');

        Route::post('/json-fungsi2', [PengukuranController::class, 'fungsi2'])->name('user.json_fungsi2');
        Route::post('/json-kabupaten2', [PengukuranController::class, 'kabupaten2'])->name('user.json_kabupaten2');
        Route::post('/json-kecamatan2', [PengukuranController::class, 'kecamatan2'])->name('user.json_kecamatan2');
        Route::post('/json-desa2', [PengukuranController::class, 'desa2'])->name('user.json_desa2');
        Route::post('/json-data_pertumbuhan2', [PlotController::class, 'dataPertumbuhan2'])->name('user.json_data_pertumbuhan2');
        Route::post('/json-data_kerusakan2', [PlotController::class, 'dataKerusakan2'])->name('user.json_data_kerusakan2');
        Route::post('/json-data_kondisi_tajuk2', [PlotController::class, 'dataKondisiTajuk2'])->name('user.json_data_kondisi_tajuk2');
        Route::post('/json-sifat_fisik', [DataIndikatorController::class, 'jsonFisik'])->name('user.json_sifat_fisik');
        Route::post('/json-data-klaster2', [DataHutanController::class, 'data2'])->name('user.json-data-klaster2');

        /* ========================= PASSWORD ========================= */
        Route::get('/ubahPassword', [PasswordController::class, 'index'])->name('user.ubah_password');
        Route::post('/passwordUbah', [PasswordController::class, 'changePassword'])->name('user.password_ubah');
        Route::get('/resetPassword', [App\Http\Controllers\Auth\ResetPasswordController::class, 'resetForm'])->name('user.reset_password');

        /* ========================= DOWNLOAD ========================= */
        Route::get('/download_panduan_siput', [DownloadController::class, 'panduan_siput'])->name('user.download_panduan_siput');
        Route::get('/download_panduan_import', [DownloadController::class, 'panduan_import'])->name('user.download_panduan_import');
        Route::get('/download_template_tally_sheet_word', [DownloadController::class, 'template_ts_w'])->name('user.download_template_tally_sheet_word');
        Route::get('/download_template_tally_sheet_excel', [DownloadController::class, 'template_ts'])->name('user.download_template_tally_sheet_excel');
    });
