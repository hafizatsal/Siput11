<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Validator;
use App\Exceptions\CustomException;
use Illuminate\Database\QueryException;

class BerkasController extends Controller
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
     return view('admin.berkas');
   }
   public function edit(Request $req)
   {
     $id = $req->input('input_by');
     $req->validate([
         'input_by'=>'required|integer',
       ]);

       if(!$req->hasFile('file_panduan') || !$req->hasFile('file_tally')){
         session()->flash('edit', 'Tidak ada berkas yang dimasukkan.');
       }
       $cek_berkas = DB::table('berkas')->where('id_berkas','=',1)->get();
       if($req->hasFile('file_panduan')){

         $req->validate([
           'file_panduan' => 'file|max:10024',
         ]);


         $filesize = $req->file_panduan->getClientSize();
         $fileextension = $req->file_panduan->getClientOriginalExtension();
         $filename = "Panduan Penggunaan SIPUT.pdf";

         if(count($cek_berkas)!=0){
           if($fileextension == 'pdf'){
             $file_path = public_path().'/upload/berkas/Panduan Penggunaan SIPUT.pdf';
             unlink($file_path);
             $req->file_panduan->move('upload/berkas',$filename);
             $data_berkas = array(
               'nama_berkas' => $filename,
               'size' => $filesize,
               'uploaded_by' => $id,
             );
             try{
             DB::table('berkas')->where('id_berkas',1)->update($data_berkas);
             session()->flash('insert', 'Berkas berhasil diubah.');
            }
             catch(\Illuminate\Database\QueryException $e){
               throw new CustomException($e->getMessage());
            }
            }
           else{
             session()->flash('delete', 'Format file yang mendukung .pdf.');
             return back();
           }
          }
       else{
         if($fileextension == 'pdf'){
           $req->file->move('upload/berkas',$filename);
           $data_berkas = array(
             'id_berkas' => 1,
             'nama_berkas' => $filename,
             'size' => $filesize,
             'uploaded_by' => $id,
           );
           try{
           DB::table('berkas')->insert($data_berkas);
           session()->flash('insert', 'Berkas berhasil ditambah.');
         }
         catch(\Illuminate\Database\QueryException $e){
           throw new CustomException($e->getMessage());
         }
         }
         else{
           session()->flash('delete', 'Format file yang mendukung .pdf.');
           return back();
         }
       }

        }
     $cek_berkas_tally = DB::table('berkas')->where('id_berkas','=',2)->get();
     if($req->hasFile('file_tally')){

       $req->validate([
         'file_tally' => 'file|max:10024',
     ]);


       $filesize = $req->file_tally->getClientSize();
       $fileextension = $req->file_tally->getClientOriginalExtension();
       $filename = "Tally Sheet Pengukuran Kesehatan Hutan.xls";

       if(count($cek_berkas_tally)!=0){
       if($fileextension == 'xls'){
         $file_path = public_path().'/upload/berkas/Tally Sheet Pengukuran Kesehatan Hutan.xls';
         unlink($file_path);
         $req->file_tally->move('upload/berkas',$filename);
         $data_berkas = array(
           'nama_berkas' => $filename,
           'size' => $filesize,
           'uploaded_by' => $id,
         );
         try{
         DB::table('berkas')->where('id_berkas',2)->update($data_berkas);
         session()->flash('insert', 'Berkas berhasil diubah.');
       }
       catch(\Illuminate\Database\QueryException $e){
         throw new CustomException($e->getMessage());
       }
     }
       else{
         session()->flash('delete', 'Format file yang mendukung .xls.');
         return back();
       }
     }
     else{
       if($fileextension == 'xls'){
         // $file_path = public_path().'/upload/berkas/Panduan Penggunaan SIPUT.pdf';
         // unlink($file_path);
         $req->file->move('upload/berkas',$filename);
         $data_berkas = array(
           'id_berkas' => 2,
           'nama_berkas' => $filename,
           'size' => $filesize,
           'uploaded_by' => $id,
         );
         try{
         DB::table('berkas')->insert($data_berkas);
         session()->flash('insert', 'Berkas berhasil ditambah.');
       }
       catch(\Illuminate\Database\QueryException $e){
         throw new CustomException($e->getMessage());
       }
       }
       else{
         session()->flash('delete', 'Format file yang mendukung .xls.');
         return back();
       }
     }

   }

       $req->all();
       return back();
   }

 }
