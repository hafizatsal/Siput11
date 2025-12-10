<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Exceptions\CustomException;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;

class KtkController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }


    /* =========================
       TAMBAH FOTO KTK
    ========================= */
    public function tambahFotoKtk(Request $req)
    {
        $req->validate([
            'judul_foto' => 'required',
            'file_foto'  => 'required|file|mimes:jpg,jpeg,png|max:1024',
        ]);

        $kode_plot  = $req->kode_plot;
        $judul_foto = $req->judul_foto;
        $keterangan = $req->keterangan_foto;

        if ($req->hasFile('file_foto')) {

            $file      = $req->file('file_foto');
            $ext       = $file->getClientOriginalExtension();
            $filename  = time().".".$ext;

            $file->move(public_path('upload/pengukuran/ktk'), $filename);

            try{
                DB::table('foto_ktk')->insert([
                    'kode_plot'  => $kode_plot,
                    'title'      => $judul_foto,
                    'filename'   => $filename,
                    'size'       => $file->getSize(),
                    'keterangan' => $keterangan,
                ]);

                return back()->with('insert',"Foto berhasil ditambahkan ✔");
            }
            catch(QueryException $e){
                throw new CustomException($e->getMessage());
            }

        }

        return back()->with('delete',"Gagal mengupload file ❌");
    }


    /* =========================
       HAPUS FOTO
    ========================= */
    public function deleteFotoKtk(Request $req)
    {
        try{
            $foto = DB::table('foto_ktk')->where('id_foto_ktk',$req->hapus_id_foto)->first();

            if($foto){
                $path = public_path('upload/pengukuran/ktk/'.$foto->filename);
                if(file_exists($path)) unlink($path);

                DB::table('foto_ktk')->where('id_foto_ktk',$req->hapus_id_foto)->delete();
                return back()->with('delete',"Foto berhasil dihapus 🗑");
            }
            return back()->with('delete',"Foto tidak ditemukan");
        }
        catch(QueryException $e){
            throw new CustomException($e->getMessage());
        }
    }


    /* =========================
       EDIT FOTO
    ========================= */
    public function editFotoKtk(Request $req)
    {
        $req->validate([
            'edit_judul_foto' => 'required',
            'edit_file_foto'  => 'nullable|file|mimes:jpg,jpeg,png|max:1024',
        ]);

        $foto = DB::table('foto_ktk')->where('id_foto_ktk',$req->id_foto)->first();
        if(!$foto) return back()->with('delete',"Data foto tidak ditemukan");

        $update = [
            'title'      => $req->edit_judul_foto,
            'keterangan' => $req->edit_keterangan_foto,
        ];

        // Jika ada gambar baru → replace
        if($req->hasFile('edit_file_foto')){

            $file      = $req->file('edit_file_foto');
            $ext       = $file->getClientOriginalExtension();
            $filename  = time().".".$ext;

            $path_old  = public_path('upload/pengukuran/ktk/'.$foto->filename);

            if(file_exists($path_old)) unlink($path_old);

            $file->move(public_path('upload/pengukuran/ktk'),$filename);

            $update['filename']=$filename;
            $update['size']=$file->getSize();
        }

        try{
            DB::table('foto_ktk')->where('id_foto_ktk',$req->id_foto)->update($update);
            return back()->with('insert',"Foto berhasil diperbarui ✨");
        }
        catch(QueryException $e){
            throw new CustomException($e->getMessage());
        }
    }


    /* =========================
       AJAX Ambil Data Gambar
    ========================= */
    public function foto_ktk(Request $req)
    {
        return response()->json(
            DB::table('foto_ktk')->where('id_foto_ktk',$req->id)->first()
        );
    }

}
