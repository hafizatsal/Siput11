<?php

namespace App\Http\Controllers\auditor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Exceptions\CustomException;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;

class KerusakanController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Import Excel kerusakan pohon.
     */
    public function importExcel(Request $req)
    {
        // Validasi input
        $req->validate([
            'import_id_pengukuran'   => 'required|integer',
            'id_klaster_import'      => 'required|integer',
            'import_pengukuran_ke'   => 'required|integer',
            'import_id_plot'         => 'required|integer',
            'file'                   => 'required|file|mimes:xls,xlsx,csv|max:10240',
        ]);

        $id_pengukuran      = $req->input('import_id_pengukuran');
        $id_klaster_plot    = $req->input('id_klaster_import');
        $pengukuran_ke      = $req->input('import_pengukuran_ke');
        $id_plot_pengukuran = $req->input('import_id_plot');

        // Ambil informasi plot
        $id_plot = DB::table('tbl_plot')
            ->where('id_plot', '=', $id_plot_pengukuran)
            ->first();

        if (!$id_plot) {
            session()->flash('delete', 'Plot tidak ditemukan.');
            return back();
        }

        // Mapping nama_plot -> nomor plot
        if ($id_plot->nama_plot === 'PLOT 1') {
            $no_plot = 1;
        } elseif ($id_plot->nama_plot === 'PLOT 2') {
            $no_plot = 2;
        } elseif ($id_plot->nama_plot === 'PLOT 3') {
            $no_plot = 3;
        } elseif ($id_plot->nama_plot === 'PLOT 4') {
            $no_plot = 4;
        } else {
            session()->flash('delete', 'Nama plot tidak dikenali.');
            return back();
        }

        if (!$req->hasFile('file')) {
            session()->flash('delete', 'File tidak ditemukan.');
            return back();
        }

        $file = $req->file('file');

        // BACA EXCEL (Maatwebsite Excel v3)
        // Hasil: Collection (per sheet) -> Collection (per row)
        $sheets = Excel::toCollection(null, $file);

        if ($sheets->isEmpty()) {
            session()->flash('delete', 'File excel kosong atau tidak terbaca.');
            return back();
        }

        // Asumsi: sheet pertama adalah "Kondisi Kerusakan Pohon"
        $sheet = $sheets->first();

        if (!$sheet || $sheet->count() === 0) {
            session()->flash('delete', 'Sheet excel kosong.');
            return back();
        }

        $data_excel = [];

        // Hitung jumlah baris kerusakan di excel untuk plot ini
        foreach ($sheet as $row) {
            // $row bisa berupa array atau Collection
            $rowArray = is_array($row) ? array_values($row) : array_values($row->toArray());

            if (!isset($rowArray[1])) {
                continue;
            }

            if (is_numeric($rowArray[1]) && isset($rowArray[0]) && $rowArray[0] == $no_plot) {
                $data_excel[] = $rowArray[0];
            }
        }

        $jumlah_data_kerusakan_xls = count($data_excel); // jumlah data kerusakan di excel

        // Data kerusakan di database
        $data_tanaman_kerusakan = DB::table('kerusakan_pohon')
            ->where('id_pengukuran', '=', $id_pengukuran)
            ->get();

        // Data pohon untuk plot + pengukuran ke
        $data_pohon = DB::table('data_tanaman_plot')
            ->where('id_plot', '=', $id_plot_pengukuran)
            ->where('pengukuran_ke', '=', $pengukuran_ke)
            ->get();

        $jumlah_pohon              = $data_pohon->count();
        $jumlah_data_kerusakan_db  = $data_tanaman_kerusakan->count();

        // Kode-kode kerusakan
        $kode_lokasi     = DB::table('kode_kerusakan_lokasi')->get()->pluck('nilai', 'kode');        // kode => nilai
        $kode_tipe       = DB::table('kode_kerusakan_type')->get()->pluck('nilai', 'kode');          // kode => nilai
        $kode_keparahan  = DB::table('kode_kerusakan_keparahan')->get()->pluck('nilai', 'keparahan'); // keparahan => nilai

        if ($jumlah_data_kerusakan_db != 0) {
            session()->flash('delete', 'Data kondisi kerusakan sudah ada, tidak dapat diimport lagi.');
            return back();
        }

        if ($jumlah_pohon != $jumlah_data_kerusakan_xls) {
            session()->flash(
                'delete',
                'Jumlah data kondisi kerusakan di file tidak sesuai dengan jumlah pohon ('
                . $jumlah_data_kerusakan_xls . ' vs ' . $jumlah_pohon . ').'
            );
            return back();
        }

        $kerusakan  = [];
        $indexPohon = 0; // index untuk array $data_pohon

        // Proses isi sheet (Kondisi Kerusakan Pohon)
        foreach ($sheet as $row) {
            $rowArray = is_array($row) ? array_values($row) : array_values($row->toArray());

            // Pastikan kolom cukup
            if (!isset($rowArray[1]) || !is_numeric($rowArray[1])) {
                continue;
            }

            if (!isset($rowArray[0]) || $rowArray[0] != $no_plot) {
                continue;
            }

            // Pastikan ada data pohon yang cukup
            if (!isset($data_pohon[$indexPohon])) {
                continue;
            }

            // Ambil kode dari excel (jaga-jaga index out of range)
            $kdDgL1 = $rowArray[2]  ?? null;
            $kdDgT1 = $rowArray[3]  ?? null;
            $kdSrVT1 = $rowArray[4] ?? null;
            $kdDgL2 = $rowArray[5]  ?? null;
            $kdDgT2 = $rowArray[6]  ?? null;
            $kdSrVT2 = $rowArray[7] ?? null;
            $kdDgL3 = $rowArray[8]  ?? null;
            $kdDgT3 = $rowArray[9]  ?? null;
            $kdSrVT3 = $rowArray[10] ?? null;

            // Ambil nilai dari tabel kode_* (default 0 jika tidak ada)
            $nDgL1  = $kdDgL1  ? ($kode_lokasi[$kdDgL1]     ?? 0) : 0;
            $nDgL2  = $kdDgL2  ? ($kode_lokasi[$kdDgL2]     ?? 0) : 0;
            $nDgL3  = $kdDgL3  ? ($kode_lokasi[$kdDgL3]     ?? 0) : 0;

            $nDgT1  = $kdDgT1  ? ($kode_tipe[$kdDgT1]       ?? 0) : 0;
            $nDgT2  = $kdDgT2  ? ($kode_tipe[$kdDgT2]       ?? 0) : 0;
            $nDgT3  = $kdDgT3  ? ($kode_tipe[$kdDgT3]       ?? 0) : 0;

            $nSrVT1 = $kdSrVT1 ? ($kode_keparahan[$kdSrVT1] ?? 0) : 0;
            $nSrVT2 = $kdSrVT2 ? ($kode_keparahan[$kdSrVT2] ?? 0) : 0;
            $nSrVT3 = $kdSrVT3 ? ($kode_keparahan[$kdSrVT3] ?? 0) : 0;

            // Hitung TLI
            $tli = $nDgL1 * $nDgT1 * $nSrVT1
                 + $nDgL2 * $nDgT2 * $nSrVT2
                 + $nDgL3 * $nDgT3 * $nSrVT3;

            $kerusakan[] = [
                'id_pengukuran' => $id_pengukuran,
                'id_tanaman'    => $data_pohon[$indexPohon++]->id_tanaman_plot,
                'kdDgL1'        => $kdDgL1,
                'kdDgT1'        => $kdDgT1,
                'kdSrVT1'       => $kdSrVT1,
                'kdDgL2'        => $kdDgL2,
                'kdDgT2'        => $kdDgT2,
                'kdSrVT2'       => $kdSrVT2,
                'kdDgL3'        => $kdDgL3,
                'kdDgT3'        => $kdDgT3,
                'kdSrVT3'       => $kdSrVT3,
                'nDgL1'         => $nDgL1,
                'nDgT1'         => $nDgT1,
                'nSrVT1'        => $nSrVT1,
                'nDgL2'         => $nDgL2,
                'nDgT2'         => $nDgT2,
                'nSrVT2'        => $nSrVT2,
                'nDgL3'         => $nDgL3,
                'nDgT3'         => $nDgT3,
                'nSrVT3'        => $nSrVT3,
                'tli'           => $tli,
                'isInserted'    => 1,
            ];
        }

        if (!empty($kerusakan)) {
            try {
                DB::table('kerusakan_pohon')->insert($kerusakan);
                session()->flash('insert', 'Data kerusakan pohon berhasil ditambah.');
            } catch (QueryException $e) {
                throw new CustomException($e->getMessage());
            }
        } else {
            session()->flash('delete', 'Tidak ada data kerusakan yang dapat diimport.');
        }

        return back();
    }

    /**
     * Tambah foto kerusakan.
     */
    public function tambahFotoKerusakan(Request $req)
    {
        $req->validate([
            'judul_foto' => 'required',
            'file_foto'  => 'required|file|mimes:jpg,jpeg,png|max:1024',
        ]);

        $id_pengukuran = $req->input('id_pengukuran');
        $judul_foto    = $req->input('judul_foto');
        $keterangan    = $req->input('keterangan_foto');

        if ($req->hasFile('file_foto')) {
            $file         = $req->file('file_foto');
            $filesize     = $file->getSize();
            $fileextension= $file->getClientOriginalExtension();
            $filename     = time() . '.' . $fileextension;

            if (!in_array(strtolower($fileextension), ['jpg', 'jpeg', 'png'])) {
                session()->flash('delete', 'Format file yang didukung hanya jpg, jpeg, dan png.');
                return back();
            }

            $file->move(public_path('upload/pengukuran/kerusakan'), $filename);

            $data_foto_kerusakan = [
                'id_pengukuran' => $id_pengukuran,
                'title'         => $judul_foto,
                'filename'      => $filename,
                'size'          => $filesize,
                'keterangan'    => $keterangan,
            ];

            try {
                DB::table('foto_kerusakan')->insert($data_foto_kerusakan);
                session()->flash('insert', 'Data foto berhasil ditambah.');
            } catch (QueryException $e) {
                throw new CustomException($e->getMessage());
            }

            return back();
        }

        session()->flash('delete', 'Gagal menjalankan aksi.');
        return back();
    }

    /**
     * Hapus foto kerusakan.
     */
    public function deleteFotoKerusakan(Request $req)
    {
        try {
            $id   = $req->hapus_id_foto;
            $foto = DB::table('foto_kerusakan')->where('id_foto_kerusakan', $id)->first();

            if ($foto) {
                $file_path = public_path('upload/pengukuran/kerusakan/' . $foto->filename);
                if (file_exists($file_path)) {
                    @unlink($file_path);
                }
            }

            DB::table('foto_kerusakan')->where('id_foto_kerusakan', $id)->delete();
            session()->flash('delete', 'Foto berhasil dihapus.');
        } catch (QueryException $e) {
            throw new CustomException($e->getMessage());
        }

        return back();
    }

    /**
     * Edit foto kerusakan.
     */
    public function editFotoKerusakan(Request $req)
    {
        $req->validate([
            'edit_judul_foto' => 'required',
            'edit_file_foto'  => 'nullable|file|mimes:jpg,jpeg,png|max:1024',
        ]);

        $judul_foto = $req->input('edit_judul_foto');
        $keterangan = $req->input('edit_keterangan_foto');
        $id_foto    = $req->input('id_foto');

        $cek_foto = DB::table('foto_kerusakan')->where('id_foto_kerusakan', '=', $id_foto)->first();

        if (!$cek_foto) {
            session()->flash('delete', 'Foto tidak ditemukan.');
            return back();
        }

        if ($req->hasFile('edit_file_foto')) {
            $file          = $req->file('edit_file_foto');
            $filesize      = $file->getSize();
            $fileextension = $file->getClientOriginalExtension();
            $filename      = time() . '.' . $fileextension;

            if (!in_array(strtolower($fileextension), ['jpg', 'jpeg', 'png'])) {
                session()->flash('delete', 'Format file yang didukung hanya jpg, jpeg, dan png.');
                return back();
            }

            // Hapus file lama
            $file_path = public_path('upload/pengukuran/kerusakan/' . $cek_foto->filename);
            if (file_exists($file_path)) {
                @unlink($file_path);
            }

            // Simpan file baru
            $file->move(public_path('upload/pengukuran/kerusakan'), $filename);

            $data_foto_kerusakan = [
                'title'      => $judul_foto,
                'filename'   => $filename,
                'size'       => $filesize,
                'keterangan' => $keterangan,
            ];

            try {
                DB::table('foto_kerusakan')
                    ->where('id_foto_kerusakan', '=', $id_foto)
                    ->update($data_foto_kerusakan);

                session()->flash('insert', 'Data foto berhasil diubah.');
            } catch (QueryException $e) {
                throw new CustomException($e->getMessage());
            }

            return back();
        }

        // Jika tidak ganti file, hanya update judul + keterangan
        $data_foto_kerusakan = [
            'title'      => $judul_foto,
            'keterangan' => $keterangan,
        ];

        try {
            DB::table('foto_kerusakan')
                ->where('id_foto_kerusakan', '=', $id_foto)
                ->update($data_foto_kerusakan);

            session()->flash('edit', 'Data foto berhasil diubah.');
        } catch (QueryException $e) {
            throw new CustomException($e->getMessage());
        }

        return back();
    }

    /**
     * Ambil detail foto kerusakan (JSON).
     */
    public function foto_kerusakan(Request $req)
    {
        $id_foto_kerusakan = $req->id;

        $foto_kerusakan = DB::table('foto_kerusakan')
            ->where('id_foto_kerusakan', '=', $id_foto_kerusakan)
            ->get();

        return response()->json($foto_kerusakan);
    }
}
