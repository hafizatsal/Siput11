<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;

use App\Http\Controllers\auditor\ProfileController;
use App\Http\Controllers\auditor\PasswordController;
use App\Http\Controllers\auditor\PlotUkurController;
use App\Http\Controllers\auditor\KlasterController;
use App\Http\Controllers\auditor\DataPlotController;
use App\Http\Controllers\auditor\DataIndikatorController;
use App\Http\Controllers\auditor\SkoringController;
use App\Http\Controllers\auditor\SkoringControllerNew;
use App\Http\Controllers\auditor\SkoringExportController;
use App\Http\Controllers\auditor\VerifikasiController;
use App\Http\Controllers\auditor\LbdsController;
use App\Http\Controllers\auditor\KerusakanController;
use App\Http\Controllers\auditor\IndikatorController;
use App\Http\Controllers\auditor\PengukuranController;
use App\Http\Controllers\auditor\KtkController;
use App\Http\Controllers\auditor\HomeController;
use App\Http\Controllers\auditor\PlotController;
use App\Http\Controllers\auditor\TajukController;
use App\Http\Controllers\auditor\ImportFaunaController;
use App\Http\Controllers\auditor\ImportPohonController;
use App\Http\Controllers\auditor\DataHutanController;
use App\Http\Controllers\auditor\DownloadController;

Route::middleware(['auth', 'auditor'])
    ->prefix('auditor')
    ->group(function () {
        /* ================= HOME ================= */
        Route::get('/home', function () {
            $pengumuman = DB::table('pengumuman')->get();
            return view('auditor.home', compact('pengumuman'));
        })->name('auditor.home');

        Route::get('/json-koordinat', [HomeController::class, 'titik'])->name('auditor.koordinat_home');

        /* ================= PROFILE ================= */
        Route::get('/profile', [ProfileController::class, 'index'])->name('auditor.profile');
        Route::post('/profile/edit', [ProfileController::class, 'edit'])->name('auditor.profile_edit');
        Route::get('/ubahPassword', [PasswordController::class, 'index'])->name('auditor.ubah_password');
        Route::post('/passwordUbah', [PasswordController::class, 'changePassword'])->name('auditor.password_ubah');

        /* ================= PLOT UKUR / KLASTER ================= */
        Route::get('/plot_ukur/klaster', [PlotUkurController::class, 'index'])->name('auditor.data_klaster');
        Route::get('/plot_ukur/klaster/lihat', [PlotUkurController::class, 'lihat'])->name('auditor.data_klaster.lihat');
        Route::post('/plot_ukur/klaster/edit', [PlotUkurController::class, 'edit'])->name('auditor.data_klaster.edit');
        Route::post('/plot_ukur/klaster/delete', [PlotUkurController::class, 'delete'])->name('auditor.data_klaster.delete');
        Route::post('/plot_ukur/klaster/insert', [PlotUkurController::class, 'insert'])->name('auditor.data_klaster.insert');

        /* JSON */
        Route::post('/json-data_kategori', [PlotUkurController::class, 'data_kategori'])->name('auditor.json_data_kategori');
        Route::post('/json-data_tahun', [PlotUkurController::class, 'data_tahun'])->name('auditor.json_data_tahun');
        Route::post('/json-data_tahun2', [PlotUkurController::class, 'data_tahun2'])->name('auditor.json_data_tahun2');
        Route::post('/json-data_klaster_plot2', [PlotUkurController::class, 'data_klaster_plot2'])->name('auditor.json_data_klaster_plot2');
        Route::post('/json-data_klaster_plot3', [PlotUkurController::class, 'data_klaster_plot3'])->name('auditor.json_data_klaster_plot3');
        Route::get('/plot_ukur/klaster/{id}', [PlotUkurController::class, 'klaster_plot'])->name('auditor.klaster_plot');

        /* KLASTER CONTROLLER */
        Route::post('/plot_ukur/klaster/data_klaster/insert', [KlasterController::class, 'insert_klaster_plot'])->name('auditor.insert_klaster');
        Route::get('/plot_ukur/klaster/data_klaster/edit', [KlasterController::class, 'update_klaster_plot'])->name('auditor.klaster.data_klaster.edit');
        Route::get('/plot_ukur/klaster/data_klaster/hapus', [KlasterController::class, 'hapus_klaster_plot'])->name('auditor.klaster.data_klaster.hapus');
        Route::get('/plot_ukur/klaster/detail/{id}', [KlasterController::class, 'detail_klaster_plot'])->name('auditor.klaster.data_klaster.detail');
        Route::get('/plot_ukur/detail_klaster', [KlasterController::class, 'detail_klaster_plots'])->name('auditor.klaster.data_klaster.details');
        Route::get('/plot_ukur/editPlot', [KlasterController::class, 'editPlot'])->name('auditor.klaster.data_klaster.editPlot');
        Route::post('/json-data-pengukuran2', [DataPlotController::class, 'data_pengukuran2'])->name('auditor.data_pengukuran2');
        Route::get('/plot_ukur/lihat_plot/{id}', [KlasterController::class, 'detailPlot'])->name('auditor.plot.lihat_plot');
        Route::get('/plot_ukur/nilai_tertimbang/{id}', [KlasterController::class, 'tertimbang'])->name('auditor.nilai_tertimbang');
        Route::get('/nilai_tertimbang/edit', [KlasterController::class, 'edit_tertimbang'])->name('auditor.edit_tertimbang');

        /* ================= DATA PLOT ================= */
        Route::get('/plot_ukur/klaster_plot', [PlotUkurController::class, 'indexDataKlaster'])->name('auditor.data_klaster_plot');
        Route::get('/plot_ukur/plot', [PlotUkurController::class, 'indexDataPlot'])->name('auditor.data_plot');
        Route::post('/json-data-plot-klaster3', [DataPlotController::class, 'data_plot_klaster3'])->name('auditor.data_plot_klaster3');
        Route::get('/plot_ukur/detail_plot', [KlasterController::class, 'detail_plots'])->name('auditor.plot.details');

        /* ================= INSERT PENGUKURAN ================= */
        Route::post('/plot_ukur/pengukuran/insert', [PlotController::class, 'tambah'])->name('auditor.pengukuran.insert');
        Route::post('/plot_ukur/pengukuran/insert2', [PlotController::class, 'tambah2'])->name('auditor.pengukuran.insert2');
        Route::get('/plot_ukur/pengukuran/hapus', [PlotController::class, 'hapus_pengukuran'])->name('auditor.pengukuran.hapus');
        Route::get('/plot_ukur/pengukuran/edit', [PlotController::class, 'edit_pengukuran'])->name('auditor.pengukuran.edit');

        /* ================= DATA PENGUKURAN ================= */
        Route::get('/data_pengukuran/prod', [DataIndikatorController::class, 'indexDataPengukuranp'])->name('auditor.data_pengukuranp');
        Route::get('/data_pengukuran/vit', [DataIndikatorController::class, 'indexDataPengukuranv'])->name('auditor.data_pengukuranv');
        Route::get('/data_pengukuran/bio', [DataIndikatorController::class, 'indexDataPengukuranb'])->name('auditor.data_pengukuranb');
        Route::get('/data_pengukuran/ktk', [DataIndikatorController::class, 'indexDataPengukurank'])->name('auditor.data_pengukurank');
        Route::get('/data_pengukuran/prod_lbds', [DataIndikatorController::class, 'lbds2'])->name('auditor.plbds');
        Route::get('/data_pengukuran/prod_lbds/{id}', [DataIndikatorController::class, 'lbds'])->name('auditor.lbds');
        Route::get('/data_pengukuran/vital', [DataIndikatorController::class, 'vit'])->name('auditor.pvit');
        Route::get('/data_pengukuran/biodiv', [DataIndikatorController::class, 'bio'])->name('auditor.pbio');
        Route::get('/data_pengukuran/ktapak', [DataIndikatorController::class, 'ktk'])->name('auditor.pktk');
        Route::get('/data_pengukuran/vit_kerusakan/{id}', [DataIndikatorController::class, 'kerusakan'])->name('auditor.kerusakan');
        Route::get('/data_pengukuran/vit_tajuk/{id}', [DataIndikatorController::class, 'tajuk'])->name('auditor.tajuk');
        Route::get('/data_pengukuran/indikator/{id}', [DataIndikatorController::class, 'dataIndikator'])->name('auditor.data_indikator');
        Route::get('/data_pengukuran/biodiversitas/{id}', [DataIndikatorController::class, 'paramBiodiversitas'])->name('auditor.pengukuran_biodiversitas');
        Route::get('/data_pengukuran/bio_pohon/{id}', [DataIndikatorController::class, 'biodivPohon'])->name('auditor.bio_pohon');
        Route::get('/data_pengukuran/bio_fauna/{id}', [DataIndikatorController::class, 'biodivFauna'])->name('auditor.bio_fauna');

        Route::get('/data_pengukuran', [PengukuranController::class, 'home'])->name('auditor.data_pengukuranplot');
        Route::get('/data_pengukuran/lihat', [PengukuranController::class, 'lihatpengukuran'])->name('auditor.lihatpengukuran');
        Route::get('/data_pengukuran/lihat/{id}', [PengukuranController::class, 'lihatpengukurans'])->name('auditor.lihatpengukurans');

        /* ===================== PENGUKURAN PLOT ===================== */
        Route::get('/data_pengukuran/pengukuran/plot/{id}', [PlotController::class, 'tambahPengukuranPlot'])->name('auditor.tambah_pengukuran_plot');
        Route::get('/indikator/{id}', [PlotController::class, 'lihatPlot'])->name('auditor.indikator');
        Route::post('/tambah_pengukuran_plot/pertumbuhan', [PlotController::class, 'tambahPertumbuhan'])->name('auditor.tambah_pertumbuhan');

        Route::get('/hapus_pertumbuhan', [IndikatorController::class, 'delete'])->name('auditor.hapus_pertumbuhan');
        Route::get('/hapus_all_pertumbuhan', [IndikatorController::class, 'delete_all'])->name('auditor.hapus_all_pertumbuhan');

        Route::post('/tambah_pengukuran_plot/foto_pertumbuhan', [PlotController::class, 'tambahFotoPertumbuhan'])->name('auditor.tambah_foto_pertumbuhan');
        Route::get('/hapus_foto_pertumbuhan', [PlotController::class, 'delete'])->name('auditor.hapus_foto_pertumbuhan');
        Route::post('/edit_pengukuran_plot/foto_pertumbuhan', [PlotController::class, 'editFotoPertumbuhan'])->name('auditor.edit_foto_pertumbuhan');
        Route::post('/json-foto_lbds', [PlotController::class, 'foto_lbds'])->name('auditor.json_foto_lbds');

        // indikator produktivitas
        Route::get('/data_pengukuran/produktivitas/{id}', [DataIndikatorController::class, 'paramProduktivitas'])->name('auditor.pengukuran_produktivitas');
        Route::get('/data_pengukuran/prod_lbds/{id}', [DataIndikatorController::class, 'lbds'])->name('auditor.lbds');
        Route::get('/data_pengukuran/pertumbuhan/{id}', [IndikatorController::class, 'pertumbuhan'])->name('auditor.pertumbuhan');

        Route::post('/import_lbds', [LbdsController::class, 'importExcel'])->name('auditor.import_lbds');

        // indikator vitalitas
        Route::get('/data_pengukuran/vitalitas/{id}', [DataIndikatorController::class, 'paramVitalitas'])->name('auditor.pengukuran_vitalitas');
        Route::get('/data_pengukuran/vit_kerusakan/{id}', [DataIndikatorController::class, 'kerusakan'])->name('auditor.kerusakan');
        Route::get('/data_pengukuran/vit_tajuk/{id}', [DataIndikatorController::class, 'tajuk'])->name('auditor.tajuk');

        Route::post('/import_kerusakan', [KerusakanController::class, 'importExcel'])->name('auditor.import_kerusakan');

        // pengukuran biodiversitas
        Route::get('/data_pengukuran/biodiversitas/{id}', [DataIndikatorController::class, 'paramBiodiversitas'])->name('auditor.pengukuran_biodiversitas');
        Route::get('/data_pengukuran/bio_pohon/{id}', [DataIndikatorController::class, 'biodivPohon'])->name('auditor.bio_pohon');
        Route::get('/data_pengukuran/bio_fauna/{id}', [DataIndikatorController::class, 'biodivFauna'])->name('auditor.bio_fauna');

        // indikator kualitas tapak
        Route::get('/data_pengukuran/ktk/{id}', [DataIndikatorController::class, 'paramKtk'])->name('auditor.pengukuran_ktk');
        Route::get('/data_pengukuran/ktk_kimia/{id}', [DataIndikatorController::class, 'kimia'])->name('auditor.kimia');

        Route::post('/tambah_ktk_kimia', [KlasterController::class, 'tambahKimia'])->name('auditor.tambah_kimia');
        Route::post('/edit_ktk_kimia', [KlasterController::class, 'editKimia'])->name('auditor.edit_kimia');
        Route::get('/ktk/hapus', [KlasterController::class, 'hapus_kimia'])->name('auditor.hapus_ktk_kimia');

        Route::get('/data_pengukuran/ktk_fisika/{id}', [DataIndikatorController::class, 'fisika'])->name('auditor.fisika');

        Route::post('/tambah_ktk_fisik', [KlasterController::class, 'tambahFisik'])->name('auditor.tambah_fisik');
        Route::post('/edit_ktk_fisik', [KlasterController::class, 'editFisik'])->name('auditor.edit_fisik');
        Route::get('/ktk/hapus_fisik', [KlasterController::class, 'hapus_fisika'])->name('auditor.hapus_ktk_fisik');

        // foto KTK
        Route::post('/tambah_pengukuran_plot/foto_ktk', [KtkController::class, 'tambahFotoKtk'])->name('auditor.tambah_foto_ktk');

        Route::get('/hapus_foto_ktk', [KtkController::class, 'deleteFotoKtk'])->name('auditor.hapus_foto_ktk');

        Route::post('/edit_pengukuran_plot/foto_ktk', [KtkController::class, 'editFotoKtk'])->name('auditor.edit_foto_ktk');

        Route::post('/json-foto_ktk', [KtkController::class, 'foto_ktk'])->name('auditor.json_foto_ktk');

        /* ===================== KERUSAKAN ===================== */
        Route::post('/tambah_pengukuran_plot/kerusakan', [PlotController::class, 'tambahKerusakan'])->name('auditor.tambah_kerusakan');
        Route::get('/hapus_kerusakan', [DataIndikatorController::class, 'delete_kerusakan'])->name('auditor.hapus_kerusakan');
        Route::get('/hapus_all_kerusakan', [DataIndikatorController::class, 'delete_kerusakan_all'])->name('auditor.hapus_all_kerusakan');

        Route::post('/tambah_pengukuran_plot/foto_kerusakan', [KerusakanController::class, 'tambahFotoKerusakan'])->name('auditor.tambah_foto_kerusakan');
        Route::get('/hapus_foto_kerusakan', [KerusakanController::class, 'deleteFotoKerusakan'])->name('auditor.hapus_foto_kerusakan');
        Route::post('/edit_pengukuran_plot/foto_kerusakan', [KerusakanController::class, 'editFotoKerusakan'])->name('auditor.edit_foto_kerusakan');
        Route::post('/json-foto_kerusakan', [KerusakanController::class, 'foto_kerusakan'])->name('auditor.json_foto_kerusakan');

         /* ===================== TAJUK ===================== */
        Route::post('/tambah_pengukuran_plot/tajuk', [PlotController::class, 'tambahTajuk'])->name('auditor.tambah_tajuk');
        Route::get('/hapus_tajuk', [DataIndikatorController::class, 'delete_tFajuk'])->name('auditor.hapus_tajuk');
        Route::get('/hapus_all_tajuk', [DataIndikatorController::class, 'delete_tajuk_all'])->name('auditor.hapus_all_tajuk');

        Route::post('/tambah_pengukuran_plot/foto_tajuk', [TajukController::class, 'tambahFotoTajuk'])->name('auditor.tambah_foto_tajuk');
        Route::get('/hapus_foto_tajuk', [TajukController::class, 'deleteFotoTajuk'])->name('auditor.hapus_foto_tajuk');
        Route::post('/edit_pengukuran_plot/foto_tajuk', [TajukController::class, 'editFotoTajuk'])->name('auditor.edit_foto_tajuk');
        Route::post('/json-foto_tajuk', [TajukController::class, 'foto_tajuk'])->name('auditor.json_foto_tajuk');

        Route::get('/json-tajuk', [PlotController::class, 'tajuk'])->name('auditor.json_tajuk');
        Route::get('/json_kerusakan', [PlotController::class, 'kerusakan2'])->name('auditor.json_kerusakan');
        Route::post('/import_tajuk', [TajukController::class, 'importExcel'])->name('auditor.import_tajuk');


        /* ===================== FAUNA ===================== */
        Route::post('/tambah_fauna', [PlotController::class, 'tambah_fauna'])->name('auditor.tambah_fauna');
        Route::post('/edit_fauna', [PlotController::class, 'edit_fauna'])->name('auditor.edit_fauna_plot');
        Route::get('/data_fauna/hapus', [PlotController::class, 'hapus_fauna'])->name('auditor.hapus_fauna');
        Route::get('/hapus_all_fauna', [PlotController::class, 'delete_all_fauna'])->name('auditor.hapus_all_fauna');
        Route::get('/data_pohon/status', [PlotController::class, 'status_pohon'])->name('auditor.status_pohon');
        Route::post('/import_fauna', [ImportFaunaController::class, 'importExcel'])->name('auditor.import_fauna');

        /* ==================== POHON ==================== */
        Route::post('/tambah_pohon', [PlotController::class, 'tambah_pohon'])->name('auditor.tambah_pohon');
        Route::post('/edit_pohon', [PlotController::class, 'edit_pohon'])->name('auditor.edit_pohon_plot');
        Route::get('/data_pohon/hapus', [PlotController::class, 'hapus_pohon'])->name('auditor.hapus_pohon');
        Route::get('/hapus_all_pohon', [PlotController::class, 'delete_all_pohon'])->name('auditor.hapus_all_pohon');
        Route::post('/import_pohon', [ImportPohonController::class, 'importExcel'])->name('auditor.import_pohon');

        /* ================= SKORING ================= */
        Route::get('/penilaian/klaster', [SkoringController::class, 'home'])->name('auditor.penilaian.klaster');
        Route::post('/penilaian/kesehatan', [SkoringControllerNew::class, 'index'])->name('auditor.penilaian.kesehatan');
        Route::post('/penilaian/kesehatan/detail', [SkoringController::class, 'detail'])->name('auditor.penilaian.kesehatan.detail');
        Route::post('/penilaian/kesehatan/detail_plot', [SkoringController::class, 'detail_plot'])->name('auditor.penilaian.kesehatan.detail_plot');
        Route::post('/penilaian/klaster/export', [SkoringExportController::class, 'exportNilaiAkhir'])->name('auditor.penilaian.klaster.export');

        Route::get('/kabupaten_skor', [SkoringController::class, 'kabupaten_skor'])->name('auditor.kabupaten_skor');
        Route::get('/kecamatan_skor', [SkoringController::class, 'kecamatan_skor'])->name('auditor.kecamatan_skor');
        Route::get('/skor_pengukuran_ke', [SkoringController::class, 'pengukuran_ke'])->name('auditor.skor_pengukuran_ke');

        Route::get('/plot_ukur/nilai_tertimbang/{id}', [KlasterController::class, 'tertimbang'])->name('auditor.isi_nilai_tertimbang');
        Route::get('/nilai_tertimbang/hapus', [KlasterController::class, 'hapus_prod'])->name('auditor.hapus_tertimbang_prod');
        Route::get('/nilai_tertimbang/edit', [KlasterController::class, 'edit_tertimbang'])->name('auditor.edit_tertimbang');
        Route::post('/nilai_tertimbang/insert', [KlasterController::class, 'indikator_insert'])->name('auditor.indikator/insert');

        Route::post('/json-fungsi2', [PengukuranController::class, 'fungsi2'])->name('auditor.json_fungsi2');
        Route::post('/json-kabupaten2', [PengukuranController::class, 'kabupaten2'])->name('auditor.json_kabupaten2');
        Route::post('/json-kecamatan2', [PengukuranController::class, 'kecamatan2'])->name('auditor.json_kecamatan2');
        Route::post('/json-desa2', [PengukuranController::class, 'desa2'])->name('auditor.json_desa2');
        Route::post('/json-data_pertumbuhan2', [PlotController::class, 'dataPertumbuhan2'])->name('auditor.json_data_pertumbuhan2');
        Route::post('/json-data_kerusakan2', [PlotController::class, 'dataKerusakan2'])->name('auditor.json_data_kerusakan2');
        Route::post('/json-data_kondisi_tajuk2', [PlotController::class, 'dataKondisiTajuk2'])->name('auditor.json_data_kondisi_tajuk2');
        Route::post('/json-sifat_fisik', [DataIndikatorController::class, 'jsonFisik'])->name('auditor.json_sifat_fisik');
        Route::post('/json-data-klaster2', [DataHutanController::class, 'data2'])->name('auditor.json-data-klaster2');

        /* ================= VERIFIKASI ================= */
        Route::get('/verifikasi', [VerifikasiController::class, 'lihat'])->name('auditor.verifikasi');
        Route::post('/verifikasi/verif', [VerifikasiController::class, 'verif'])->name('auditor.verifikasi.verif');
        Route::post('/verifikasi/unverif', [VerifikasiController::class, 'unverif'])->name('auditor.verifikasi.unverif');

        /* ========================= DOWNLOAD ========================= */
        Route::get('/download_panduan_siput', [DownloadController::class, 'panduan_siput'])->name('auditor.download_panduan_siput');
        Route::get('/download_panduan_import', [DownloadController::class, 'panduan_import'])->name('auditor.download_panduan_import');
        Route::get('/download_template_tally_sheet_word', [DownloadController::class, 'template_ts_w'])->name('auditor.download_template_tally_sheet_word');
        Route::get('/download_template_tally_sheet_excel', [DownloadController::class, 'template_ts'])->name('auditor.download_template_tally_sheet_excel');
    });
