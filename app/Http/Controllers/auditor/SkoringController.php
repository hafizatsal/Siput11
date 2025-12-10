<?php

namespace App\Http\Controllers\auditor;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class SkoringController extends Controller
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
     public function index(Request $req)
     {
       $req->validate([
           'tahun_pengukuran'=>'required|integer',
           'pengukuranke'=>'required',
         ]);

       $id_data_klaster = $req->tahun_pengukuran;
       $lbds_v=[];
       $lbds=[];
       $vcrc=[];
       $tli=[];
       $bio_pohon=[];
       $pengukuran_ke=$req->pengukuranke;
       //anak biodiversitas
       $n_tanaman=[];
       $ni_klaster=[];
       $pi_klaster=[];
       $ln_pi_klaster=[];
       $pi_ln_pi_klaster=[];
       $h=[];
       $s=1;
       $j=[];
       //anak biodiversitas

       // parameter indikator
       $param_vit=$req->param_vit;
       $param_ktk=$req->param_ktk;
       $p_lbds=$req->lbds;
       $p_volume=$req->volume;
       $p_kerusakan=$req->kerusakan;
       $p_ktjk=$req->ktjk;
       $p_kimia=$req->kimia;
       $sifat_kimia=$req->input('sifat-sifat_kimia');
       $p_fisik=$req->fisik;
       $haksenp=$req->haksenp;
       $p_jpliu=$req->jpliup;
       $p_dmg=$req->dmgp;
       $haksenf=$req->haksenf;
       $p_jpliuf=$req->jpliuf;
       $p_dmgf=$req->dmgf;
       // untuk hitung jumlah parameter yang dipilih, kalo lebih dari 1 artinya bagian penilaian keshut ada tanda '=' nya
       $pprod=0;
       $pvolume=0;
       $pkerusakan=0;
       $pktjk=0;
       $pkimia=0;
       $phaksenp=0;
       $pjpliup=0;
       $pdmgp=0;
       $phaksenf=0;
       $pjpliuf=0;
       $pdmgf=0;


       if($p_lbds!=""){
           $pprod=1;
       }
       if($p_volume!=""){
           $pvolume=1;
       }
       if($p_kerusakan!=""){
           $pkerusakan=1;
       }
       if($p_ktjk!=""){
           $pktjk=1;
       }
       if($p_kimia!=""){
           $pkimia=1;
       }
       if($haksenp!=""){
           $phaksenp=1;
       }
       if($p_jpliu!=""){
           $pjpliup=1;
       }
       if($p_dmg!=""){
           $pdmgp=1;
       }
       if($haksenf!=""){
           $phaksenf=1;
       }
       if($p_jpliuf!=""){
           $pjpliuf=1;
       }
       if($p_dmgf!=""){
           $pdmgf=1;
       }
       $jmlh_param=$pprod+$pvolume+$pkerusakan+$pktjk+$pkimia+$phaksenp+$pjpliup+$pdmgp+$phaksenf+$pjpliuf+$pdmgf;

       if($jmlh_param==0){
         $pesan= "Parameter harus dipilih";
         return view('auditor.penilaian_kurang',[
           'pesan' => $pesan,
         ]);
       }

       if($pengukuran_ke==1){
         $id_klaster = DB::table('kategori_klaster')
         ->leftjoin('tbl_klaster_plot','tbl_klaster_plot.id_data_klaster','=','kategori_klaster.id_data_klaster')
         ->leftjoin('lokasi','lokasi.id_klaster_plot','=','tbl_klaster_plot.id_klaster_plot')
         ->leftjoin('desa','desa.id','=','lokasi.id_desa')
         ->leftjoin('kecamatan','kecamatan.id','=','lokasi.id_kecamatan')
         ->leftjoin('kabupaten','kabupaten.id','=','lokasi.id_kabupaten')
         ->leftjoin('provinsi','provinsi.id_provinsi','=','lokasi.id_provinsi')
         ->where([['kategori_klaster.id_data_klaster','like',$id_data_klaster]])
         ->where('kategori_klaster.pengukuran_ke','=',1)
         ->orderBy('tbl_klaster_plot.nama_klaster','asc')
         ->get();
       }
       else if($pengukuran_ke=="%"){
         $id_klaster1 = DB::table('kategori_klaster')
         ->where('id_data_klaster','=',$id_data_klaster)
         ->where('pengukuran_ke','=',1)->get();

         $id_klaster2 = DB::table('kategori_klaster')
         ->where('id_data_klaster2','=',$id_data_klaster)
         ->where('pengukuran_ke','=',2)->get();

         $id_klaster3 = DB::table('kategori_klaster')
         ->where('id_data_klaster2','=',$id_data_klaster)
         ->where('pengukuran_ke','=',3)->get();

         if(count($id_klaster1)>0 && count($id_klaster2)>0 && count($id_klaster3)>0){

           $id_klaster = DB::table('kategori_klaster')
           ->leftjoin('tbl_klaster_plot','tbl_klaster_plot.id_data_klaster','=','kategori_klaster.id_data_klaster')
           ->leftjoin('lokasi','lokasi.id_klaster_plot','=','tbl_klaster_plot.id_klaster_plot')
           ->leftjoin('desa','desa.id','=','lokasi.id_desa')
           ->leftjoin('kecamatan','kecamatan.id','=','lokasi.id_kecamatan')
           ->leftjoin('kabupaten','kabupaten.id','=','lokasi.id_kabupaten')
           ->leftjoin('provinsi','provinsi.id_provinsi','=','lokasi.id_provinsi')
           ->where('kategori_klaster.id_data_klaster','=',$id_data_klaster)
           ->orderBy('tbl_klaster_plot.nama_klaster','asc')
           ->get();

           $id_klaster2 = DB::table('kategori_klaster')
           ->select('kategori_klaster.id_data_klaster','kategori_klaster.id_data_klaster2','kategori_klaster.pengukuran_ke','kategori_klaster.nama_pengukur','kategori_klaster.kategori','kategori_klaster.tahun_pengukuran','tbl_klaster_plot.id_klaster_plot')
           ->leftjoin('tbl_klaster_plot','tbl_klaster_plot.id_data_klaster','=','kategori_klaster.id_data_klaster2')
           ->leftjoin('lokasi','lokasi.id_klaster_plot','=','tbl_klaster_plot.id_klaster_plot')
           ->leftjoin('desa','desa.id','=','lokasi.id_desa')
           ->leftjoin('kecamatan','kecamatan.id','=','lokasi.id_kecamatan')
           ->leftjoin('kabupaten','kabupaten.id','=','lokasi.id_kabupaten')
           ->leftjoin('provinsi','provinsi.id_provinsi','=','lokasi.id_provinsi')
           ->where('kategori_klaster.id_data_klaster2','=',$id_data_klaster)
           ->where('kategori_klaster.pengukuran_ke','=',2)
           ->orderBy('tbl_klaster_plot.nama_klaster','asc')
           ->get();

           $id_klaster3 = DB::table('kategori_klaster')
           ->select('kategori_klaster.id_data_klaster','kategori_klaster.id_data_klaster2','kategori_klaster.pengukuran_ke','kategori_klaster.nama_pengukur','kategori_klaster.kategori','kategori_klaster.tahun_pengukuran','tbl_klaster_plot.id_klaster_plot')
           ->leftjoin('tbl_klaster_plot','tbl_klaster_plot.id_data_klaster','=','kategori_klaster.id_data_klaster2')
           ->leftjoin('lokasi','lokasi.id_klaster_plot','=','tbl_klaster_plot.id_klaster_plot')
           ->leftjoin('desa','desa.id','=','lokasi.id_desa')
           ->leftjoin('kecamatan','kecamatan.id','=','lokasi.id_kecamatan')
           ->leftjoin('kabupaten','kabupaten.id','=','lokasi.id_kabupaten')
           ->leftjoin('provinsi','provinsi.id_provinsi','=','lokasi.id_provinsi')
           ->where('kategori_klaster.id_data_klaster2','=',$id_data_klaster)
           ->where('kategori_klaster.pengukuran_ke','=',3)
           ->orderBy('tbl_klaster_plot.nama_klaster','asc')
           ->get();


           // dd($id_klaster);
           // Untuk perhitungan lebih dari sama dengan 1 klaster
           $jumlah_penilaian = count($id_klaster);
           if ($jumlah_penilaian>=1)
           {

             $m=0;
             $tli_r=[];
             $vcr_r=[];
             $lbds_r=[];
             $volume_r=[];
             $cec_r=[];

             for ($i=0; $i < count($id_klaster); $i++) {
               // untuk mengetahui id klaster saat ini
               $id_cl=$id_klaster[$i]->id_klaster_plot;
                 $id_pengukuran1=[];
                 $plot=[];
                 $tli_f=[];
                 $vcr_f=[];
                 $lbds_f=[];
                 $volume_f=[];
                 $cec_f=[];
                 // untuk menghitung banyaknya plot yang ada pengukuran
                 $plot=DB::table('tbl_plot')
                 ->join('pengukuran_master','pengukuran_master.id_plot','=','tbl_plot.id_plot')
                 ->where('id_klaster_plot',$id_cl)
                 ->where('pengukuran_ke','=',1)
                 ->get();
                 if(count($plot)!=0){
                 for ($j=0; $j < count($plot); $j++) {
                   $id_pengukuran=DB::table('pengukuran_master')->where([['id_plot',$plot[$j]->id_plot],['pengukuran_ke',1]])->get();
                   $id_pengukuran1[$j]=$id_pengukuran[0]->id_pengukuran;

                 }

               }
               else{
                 // id pengukuran gak ada
               }
               $tli_r[$m]=0;
               $vcr_r[$m]=0;
               $lbds_r[$m]=0;
               $volume_r[$m]=0;
               $cec_r[$m]=0;
               // kalo pengukurannya tidak kosong dalam satu klaster

               if(count($id_pengukuran1)!=0){
                 for ($k=0; $k < count($id_pengukuran1); $k++) {
                 $tli=0;
                 $vcr=0;
                 $lbds=0;
                 $volume=0;

                 //indikator kualitas Tapak
                 if($p_kimia!=""){

                   if($sifat_kimia==""){
                     $cec_f[$i]=0;
                   }
                   else{
                     $data_pengukuran_ktk_kimia= DB::table('ktk_kimia')
                     ->where('kode_klaster','=',$id_cl)
                     ->where('pengukuran_ke','=',1)
                     ->where('id_sifat','=',$sifat_kimia)
                     ->first();
                     $data_pengukuran_ktk_kimia= DB::table('ktk_kimia')
                     ->where('kode_klaster','=',$id_cl)
                     ->where('pengukuran_ke','=',1)
                     ->where('id_sifat','=',$sifat_kimia)
                     ->get();
                     if(count($data_pengukuran_ktk_kimia)!=0){
                         $cec_f[$i]=$data_pengukuran_ktk_kimia[0]->cec;
                     }
                     else{
                       $cec_f[$i]=0;
                     }
                   }

                 }
                 else{
                   $cec_f[$i]=0;
                 }

                 // indikator vitalitas
                 // untuk data pengukuran kerusakan
                 if($p_kerusakan!=""){
                   $data_pengukuran=DB::table('pengukuran_master')
                     ->join('kerusakan_pohon','kerusakan_pohon.id_pengukuran','=','pengukuran_master.id_pengukuran')
                     ->select('tli')
                     ->where('pengukuran_master.id_pengukuran',$id_pengukuran1[$k])->get();

                     // untuk kerusakan
                     if(count($data_pengukuran)!=0){
                       for ($l=0; $l < count ($data_pengukuran); $l++) {
                         // nilai total tli plot
                         $tli+=$data_pengukuran[$l]->tli;
                       }
                       // nilai pli plot
                       $tli_f[$k]=($tli/count($data_pengukuran));
                     }
                     else{
                       $tli_f[$k]=0;
                     }
                 }
                 else{
                   $tli_f[$k]=0;
                 }
                 //

                 // untuk data pengukuran tajuk
                 if($p_ktjk!=""){
                   $data_pengukuran_tajuk=DB::table('pengukuran_master')
                     ->join('kondisi_tajuk','kondisi_tajuk.id_pengukuran','=','pengukuran_master.id_pengukuran')
                     ->select('vcri')
                     ->where('pengukuran_master.id_pengukuran',$id_pengukuran1[$k])->get();
                     // untuk tajuk
                     if(count($data_pengukuran_tajuk)!=0){
                       for ($l=0; $l < count ($data_pengukuran_tajuk); $l++) {
                         // nilai total vcr plot
                         $vcr+=$data_pengukuran_tajuk[$l]->vcri;
                       }
                       // nilai vcr plot
                       $vcr_f[$k]=($vcr/count($data_pengukuran_tajuk));
                     }
                     else{
                       $vcr_f[$k]=0;
                     }
                 }
                 else{
                   $vcr_f[$k]=0;
                 }

                   // indikator produktivitas parameter lbds
                 if($p_lbds!=""){
                 $data_pengukuran_lbds=DB::table('pengukuran_master')
                   ->join('lbds','lbds.id_pengukuran','=','pengukuran_master.id_pengukuran')
                   ->select('Hasil_LBDS','v')
                   ->where('pengukuran_master.id_pengukuran',$id_pengukuran1[$k])->get();
                   // untuk lbds
                   if(count($data_pengukuran_lbds)!=0){
                   for ($l=0; $l < count ($data_pengukuran_lbds); $l++) {
                     // nilai total lbds plot
                     $lbds+=$data_pengukuran_lbds[$l]->Hasil_LBDS;
                   }
                   // nilai lbds plot
                   $lbds_f[$k]=$lbds;
                 }
                 else{
                   $lbds_f[$k]=0;
                 }
                }
                else{
                  $lbds_f[$k]=0;
                }
                   //

                   // indikator produktivitas parameter volume
                   if($p_volume!=""){
                   $data_pengukuran_volume=DB::table('pengukuran_master')
                   ->join('lbds','lbds.id_pengukuran','=','pengukuran_master.id_pengukuran')
                   ->select('Hasil_LBDS','v')
                   ->where('pengukuran_master.id_pengukuran',$id_pengukuran1[$k])->get();
                    // untuk volume
                    if(count($data_pengukuran_volume)!=0){
                    for ($l=0; $l < count ($data_pengukuran_volume); $l++) {
                      // nilai total volume_v plot
                      $volume+=$data_pengukuran_volume[$l]->v;
                    }
                    // nilai volume_v plot
                    $volume_f[$k]=$volume;
                   }
                   else{
                    $volume_f[$k]=0;
                   }
                   }
                   else{
                   $volume_f[$k]=0;
                   }
                   //

                 //nilai total KTPK
                 $cec_r[$m]=$cec_f[$i];
                 // nilai total PLI
                 $tli_r[$m]+=$tli_f[$k];
                 // nilai total VCR
                 $vcr_r[$m]+=$vcr_f[$k];
                 // nilai total LBDS
                 $lbds_r[$m]+=$lbds_f[$k];
                 // nilai total Volume
                 $volume_r[$m]+=$volume_f[$k];
               }

               $tli_r[$m]=$tli_r[$m]/count($id_pengukuran1);
               $vcr_r[$m]=$vcr_r[$m]/count($id_pengukuran1);
               $lbds_r[$m]=$lbds_r[$m]/count($id_pengukuran1);
               $volume_r[$m]=$volume_r[$m]/count($id_pengukuran1);
                 // hanya pembulatan
                 for ($a=0;$a<count($id_pengukuran1);$a++){
                   $tli_f[$a]=round(($tli_f[$a]),3);
                   $vcr_f[$a]=round(($vcr_f[$a]),3);
                   $lbds_f[$a]=round(($lbds_f[$a]),3);
                   $volume_f[$a]=round(($volume_f[$a]),3);
                 }
               }
               else{
                 if($id_cl==""){
                   $pesan= "Data pengukuran tidak tersedia";
                   return view('auditor.penilaian_kurang',[
                     'pesan' => $pesan,
                   ]);
                 }
                 else{
                   $pesan= "Salah satu pengukuran tidak tersedia";
                   return view('auditor.pengukuran_kurang',[
                     'pesan' => $pesan,
                     'id_klaster' => $id_cl,
                   ]);
                 }

               }

                 $m++;

                 // data biodiversitas pohon
                 for($q=0;$q<count($plot);$q++){
                   $j_pliu_klaster[$i]=0;
                 if($haksenp!="" || $p_jpliu!=""){
                   $rata_h_aksen[$i]=0;
                   $data_biodiv_pohon[$i] = DB::table('data_tanaman_plot')
                   ->where('id_plot','=',$plot[$q]->id_plot)
                   ->where('status','=','1')
                   ->where('pengukuran_ke','=',1)
                   ->get();
                   $jumlah_pohon[$i]=count($data_biodiv_pohon[$i]);
                   $jenis_pohon[$i]=DB::table('data_tanaman_plot')
                   ->select(DB::raw("data_tanaman_plot.id_master_jenis_tanaman, COUNT(*) as jumlah"))
                   ->where('data_tanaman_plot.id_plot','=',$plot[$q]->id_plot)
                   ->where('status','=','1')
                   ->where('pengukuran_ke','=',1)
                   ->groupBy(DB::raw('data_tanaman_plot.id_master_jenis_tanaman'))
                   ->get();

                   $h_aksen[$q]=0;
                   if($jumlah_pohon[$i]!=0){
                     for($o=0;$o<count($jenis_pohon[$i]);$o++){
                       $n[$o]=$jenis_pohon[$i][$o]->jumlah;
                       $ni[$o]=$n[$o]/$jumlah_pohon[$i];
                       $ln_ni[$o]=log($ni[$o]);
                       $ni_ln_ni[$o]=$ni[$o]*$ln_ni[$o];
                       $h_aksen[$q]-=$ni_ln_ni[$o];
                     }

                     //$h_aksen[$i]=$h_aksen[$i]/count($jenis_pohon[$i]);
                   }
                  }
                  else{
                    $h_aksen[$q]=0;
                  }
                //   if($i==1){
                //   dd($h_aksen);
                // }
                  //

                   // dmg biodiversitas pohon
                   if($p_dmg!=""){
                     $h_aksen_klaster[$i]=0;
                     $rata_h_aksen[$i]=0;
                     $data_biodiv_pohon[$i] = DB::table('data_tanaman_plot')
                     ->where('id_plot','=',$plot[$q]->id_plot)
                     ->where('status','=','1')
                     ->where('pengukuran_ke','=',1)
                     ->get();
                     $jumlah_pohon[$i]=count($data_biodiv_pohon[$i]);
                     $jenis_pohon[$i]=DB::table('data_tanaman_plot')
                     ->select(DB::raw("data_tanaman_plot.id_master_jenis_tanaman, COUNT(*) as jumlah"))
                     ->where('data_tanaman_plot.id_plot','=',$plot[$q]->id_plot)
                     ->where('status','=','1')
                     ->where('pengukuran_ke','=',1)
                     ->groupBy(DB::raw('data_tanaman_plot.id_master_jenis_tanaman'))
                     ->get();

                     $data_biodiv_pohon_klaster[$i] = DB::table('data_tanaman_plot')
                     ->where('id_klaster_plot','=',$id_klaster[$i]->id_klaster_plot)
                     ->where('status','=','1')
                     ->where('pengukuran_ke','=',1)
                     ->get();
                     $jumlah_pohon_klaster[$i]=count($data_biodiv_pohon_klaster[$i]);

                     $jenis_pohon_klaster[$i]=DB::table('data_tanaman_plot')
                     ->select(DB::raw("data_tanaman_plot.id_master_jenis_tanaman, COUNT(*) as jumlah"))
                     ->where('data_tanaman_plot.id_klaster_plot','=',$id_klaster[$i]->id_klaster_plot)
                     ->where('status','=','1')
                     ->where('pengukuran_ke','=',1)
                     ->groupBy(DB::raw('data_tanaman_plot.id_master_jenis_tanaman'))
                     ->get();
                     $jml_jenis_klaster[$i] = count($jenis_pohon_klaster[$i]);

                     $h_aksen[$q]=0;
                     $d_mg[$i]=0;
                     if($jumlah_pohon[$i]!=0){
                       $jml_jenis[$i] = count($jenis_pohon[$i]);
                       for($o=0;$o<count($jenis_pohon[$i]);$o++){
                         $n[$o]=$jenis_pohon[$i][$o]->jumlah;
                         $ni[$o]=$n[$o]/$jumlah_pohon[$i];
                         $ln_ni[$o]=log($ni[$o]);
                         $ni_ln_ni[$o]=$ni[$o]*$ln_ni[$o];
                         $h_aksen[$q]-=$ni_ln_ni[$o];
                         $rata_h_aksen[$i]+=$h_aksen[$q];
                       }

                       if($jumlah_pohon_klaster[$i]>1){
                         $d_mg[$i]=($jml_jenis_klaster[$i]-1)/log($jumlah_pohon_klaster[$i]);
                       }
                     }

                    }
                    else{
                      $d_mg[$i]=0;
                    }
                  }
                     // dd($h_aksen);
                     if($haksenp!=""){
                         $rata_h_aksen[$i]=0;
                         for($v=0;$v<4;$v++){
                         $rata_h_aksen[$i]+=$h_aksen[$v];
                       }
                       $h_aksen_klaster[$i]=$rata_h_aksen[$i]/4;
                     }


                    if($p_jpliu!=""){
                      $rata_h_aksen[$i]=0;
                      for($v=0;$v<4;$v++){
                      $rata_h_aksen[$i]+=$h_aksen[$v];
                    }
                     $h_aksen_klaster[$i]=$rata_h_aksen[$i]/4;

                      $jenis_pohon_klaster[$i]=DB::table('data_tanaman_plot')
                      ->select(DB::raw("data_tanaman_plot.id_master_jenis_tanaman, COUNT(*) as jumlah"))
                      ->where('data_tanaman_plot.id_klaster_plot','=',$id_klaster[$i]->id_klaster_plot)
                      ->where('status','=','1')
                      ->where('pengukuran_ke','=',1)
                      ->groupBy(DB::raw('data_tanaman_plot.id_master_jenis_tanaman'))
                      ->get();
                      $jml_jenis_klaster[$i] = count($jenis_pohon_klaster[$i]);

                      if($jml_jenis_klaster[$i]>1){
                        $j_pliu_klaster[$i]=$h_aksen_klaster[$i]/log($jml_jenis_klaster[$i]);
                      }
                  }
                  else{
                    $j_pliu_klaster[$i]=0;
                  }
                    //

                  // data biodiversitas fauna
                  if($haksenf!=""){
                    $data_biodiv_fauna[$i] = DB::table('data_fauna')
                    ->where('id_klaster_plot_fauna','=',$id_cl)
                    ->where('pengukuran_ke','=',1)
                    ->get();
                    $h_aksenf[$i]=0;
                    if(count($data_biodiv_fauna[$i])!=0){
                      $total_fauna=0;
                      $tot_data_fauna[$i]=count($data_biodiv_fauna[$i]);
                      for($s=0;$s<$tot_data_fauna[$i];$s++){
                        $total_fauna+=$data_biodiv_fauna[$i][$s]->jumlah;
                      }

                      $jumlah_fauna[$i]=$total_fauna;
                      for($t=0;$t<$tot_data_fauna[$i];$t++){
                        $nf[$t]=$data_biodiv_fauna[$i][$t]->jumlah;
                        $nif[$t]=$nf[$t]/$jumlah_fauna[$i];
                        $ln_nif[$t]=log($nif[$t]);
                        $ni_ln_nif[$t]=$nif[$t]*$ln_nif[$t];
                        $h_aksenf[$i]-=$ni_ln_nif[$t];
                      }
                     // $h_aksenf[$i]=$h_aksenf[$i]/$tot_data_fauna[$i];
                    }
                 }
                 else{
                   $h_aksenf[$i]=0;
                 }

                 // data jpliu fauna
                 if($p_jpliuf!=""){
                   $data_biodiv_fauna[$i] = DB::table('data_fauna')
                   ->where('id_klaster_plot_fauna','=',$id_cl)
                   ->where('pengukuran_ke','=',1)
                   ->get();
                   $h_aksenf[$i]=0;
                   $j_pliuf[$i]=0;
                   if(count($data_biodiv_fauna[$i])!=0){
                     $total_fauna=0;
                     $tot_data_fauna[$i]=count($data_biodiv_fauna[$i]);
                     for($s=0;$s<$tot_data_fauna[$i];$s++){
                       $total_fauna+=$data_biodiv_fauna[$i][$s]->jumlah;
                     }

                     $jumlah_fauna[$i]=$total_fauna;
                     for($t=0;$t<$tot_data_fauna[$i];$t++){
                       $nf[$t]=$data_biodiv_fauna[$i][$t]->jumlah;
                       $nif[$t]=$nf[$t]/$jumlah_fauna[$i];
                       $ln_nif[$t]=log($nif[$t]);
                       $ni_ln_nif[$t]=$nif[$t]*$ln_nif[$t];
                       $h_aksenf[$i]-=$ni_ln_nif[$t];

                       if($tot_data_fauna[$i]==0 || $tot_data_fauna[$i]==1 ){
                         $j_pliuf[$i]+=0;
                       }
                       else{
                         $j_pliuf[$i]+=-1*$ni_ln_nif[$t]/log($tot_data_fauna[$i]);
                       }

                     }
                     $j_pliuf[$i]=$j_pliuf[$i]/$tot_data_fauna[$i];
                   //  $h_aksenf[$i]=$h_aksenf[$i]/$tot_data_fauna[$i];
                   }
                }
                else{
                  $j_pliuf[$i]=0;
                }

                // data dmg fauna
                if($p_dmgf!=""){
                  $data_biodiv_fauna[$i] = DB::table('data_fauna')
                  ->where('id_klaster_plot_fauna','=',$id_cl)
                  ->where('pengukuran_ke','=',1)
                  ->get();
                  $h_aksenf[$i]=0;
                  $d_mgf[$i]=0;
                  if(count($data_biodiv_fauna[$i])!=0){
                    $total_fauna=0;
                    $tot_data_fauna[$i]=count($data_biodiv_fauna[$i]);

                    for($s=0;$s<$tot_data_fauna[$i];$s++){
                      $total_fauna+=$data_biodiv_fauna[$i][$s]->jumlah;
                    }

                    $jumlah_fauna[$i]=$total_fauna;
                    if($jumlah_fauna[$i]>1){
                      for($t=0;$t<$tot_data_fauna[$i];$t++){
                        $nf[$t]=$data_biodiv_fauna[$i][$t]->jumlah;
                        $nif[$t]=$nf[$t]/$jumlah_fauna[$i];
                        $ln_nif[$t]=log($nif[$t]);
                        $ni_ln_nif[$t]=$nif[$t]*$ln_nif[$t];
                        $h_aksenf[$i]-=$ni_ln_nif[$t];
                      }
                     // $h_aksenf[$i]=$h_aksenf[$i]/$tot_data_fauna[$i];
                       $d_mgf[$i]=($tot_data_fauna[$i]-1)/log($jumlah_fauna[$i]);
                   }
                  }
               }
               else{
                 $d_mgf[$i]=0;
               }

               }


               // hanya pembulatan
               for ($a=0;$a<count($tli_r);$a++){
                 $cec_r[$a]=round(($cec_r[$a]),3);
                 $lbds_r[$a]=round(($lbds_r[$a]),3);
                 $volume_r[$a]=round(($volume_r[$a]),3);
                 $tli_r[$a]=round(($tli_r[$a]),3);
                 $vcr_r[$a]=round(($vcr_r[$a]),3);
                 // $h_aksen[$a]=round($h_aksen[$a],3);
                 // $j_pliu[$a]=round($j_pliu[$a],3);
                 $d_mg[$a]=round($d_mg[$a],3);
                 $h_aksenf[$a]=round($h_aksenf[$a],3);
                 $j_pliuf[$a]=round($j_pliuf[$a],3);
                 $d_mgf[$a]=round($d_mgf[$a],3);
               }

               // range nilai skor Ktk kimia
               if($p_kimia!=""){
                     $const_cec=(max($cec_r)-min($cec_r))/10;
                     $range_cec_l=[];
                     $range_cec_init=min($cec_r);
                     $range_cec_l[0]=min($cec_r);
                     $range_cec_r=[];
                     for ($i=1;$i<10;$i++){
                       $range_cec_init+=$const_cec;
                       $range_cec_l[$i]=round($range_cec_init,3);
                       $range_cec_r[$i]=round(($range_cec_l[$i]-0.001),3);
                     }
                     $range_cec_r[10]=round(max($cec_r),3);

                     for ($i=0; $i < count($id_klaster); $i++) {
                       $skor_cec[$i]=1;
                       for ($j=0; $j < count($range_cec_l); $j++) {
                         if($cec_r[$i]>=$range_cec_l[$j] && $cec_r[$i]<=$range_cec_r[$j+1]){
                           break;
                         }
                         if($skor_cec[$i]<10){
                         $skor_cec[$i]++;
                       }
                       }
                     }
                   }
                   else{
                     $range_cec_l=0;
                     $range_cec_r=0;
                     for ($i=0;$i<count($id_klaster);$i++){
                         $skor_cec[$i]=0;
                     }
                   }
                 //

               // range nilai skor Produktivitas
                 //lbds
                 if($p_lbds!=""){
                     $const_lbds=(max($lbds_r)-min($lbds_r))/10;
                     $range_lbds_l=[];
                     $range_lbds_init=min($lbds_r);
                     $range_lbds_l[0]=min($lbds_r);
                     $range_lbds_r=[];
                     for ($i=1;$i<10;$i++){
                       $range_lbds_init+=$const_lbds;
                       $range_lbds_l[$i]=round($range_lbds_init,3);
                       $range_lbds_r[$i]=round(($range_lbds_l[$i]-0.001),3);
                     }
                     $range_lbds_r[10]=round(max($lbds_r),3);

                     for ($i=0; $i < count($id_klaster); $i++) {
                       $skor_lbds[$i]=1;
                       for ($j=0; $j < count($range_lbds_l); $j++) {
                         if($lbds_r[$i]>=$range_lbds_l[$j] && $lbds_r[$i]<=$range_lbds_r[$j+1]){
                           break;
                         }
                         if($skor_lbds[$i]<10){
                           $skor_lbds[$i]++;
                         }
                       }
                     }
                   }
                   else{
                     $range_lbds_l=0;
                     $range_lbds_r=0;
                     for ($i=0;$i<count($id_klaster);$i++){
                       $skor_lbds[$i]=0;
                   }
                 }

                 //volume_v
                 if($p_volume!=""){
                     $const_volume=(max($volume_r)-min($volume_r))/10;
                     $range_volume_l=[];
                     $range_volume_init=min($volume_r);
                     $range_volume_l[0]=min($volume_r);
                     $range_volume_r=[];
                     for ($i=1;$i<10;$i++){
                       $range_volume_init+=$const_volume;
                       $range_volume_l[$i]=round($range_volume_init,3);
                       $range_volume_r[$i]=round(($range_volume_l[$i]-0.001),3);
                     }
                     $range_volume_r[10]=round(max($volume_r),3);

                     for ($i=0; $i < count($id_klaster); $i++) {
                       $skor_volume[$i]=1;
                       for ($j=0; $j < count($range_volume_l); $j++) {
                         if($volume_r[$i]>=$range_volume_l[$j] && $volume_r[$i]<=$range_volume_r[$j+1]){
                           break;
                         }
                         if($skor_volume[$i]<10){
                           $skor_volume[$i]++;
                         }

                       }
                     }
                   }
                   else{
                     $range_volume_l=0;
                     $range_volume_r=0;
                     for ($i=0;$i<count($id_klaster);$i++){
                       $skor_volume[$i]=0;
                   }
                 }
                 //

                 // range nilai skor kerusakan
                 if($p_kerusakan!=""){
                       $const_tli=(max($tli_r)-min($tli_r))/10;
                       $range_tli_r=[];
                       $range_tli_init=max($tli_r);
                       $range_tli_r[0]=max($tli_r);
                       $range_tli_l=[];
                       for ($i=1;$i<10;$i++){
                         $range_tli_init-=$const_tli;
                         $range_tli_r[$i]=round($range_tli_init,3);
                         $range_tli_l[$i]=round(($range_tli_r[$i]+0.001),3);
                       }
                       $range_tli_l[10]=round(min($tli_r),3);

                       for ($i=0; $i < count($id_klaster); $i++) {
                         $skor_tli[$i]=0;
                         for ($j=0; $j < count($range_tli_l); $j++) {
                           if($skor_tli[$i]<10){
                           $skor_tli[$i]++;
                           }
                           if($tli_r[$i]>=$range_tli_l[$j+1] && $tli_r[$i]<=$range_tli_r[$j]){
                             break;
                           }
                         }
                       }
                     }
                     else{
                       $range_tli_l=0;
                       $range_tli_r=0;
                       for ($i=0;$i<count($id_klaster);$i++){
                         $skor_tli[$i]=0;
                     }
                     }
                   //
                   // range nilai skor tajuk
                   if($p_ktjk!=""){
                         $const_vcr=(max($vcr_r)-min($vcr_r))/10;
                         $range_vcr_l=[];
                         $range_vcr_init=min($vcr_r);
                         $range_vcr_l[0]=min($vcr_r);
                         $range_vcr_r=[];
                         for ($i=1;$i<10;$i++){
                           $range_vcr_init+=$const_vcr;
                           $range_vcr_l[$i]=round($range_vcr_init,3);
                           $range_vcr_r[$i]=round(($range_vcr_l[$i]-0.001),3);
                         }
                         $range_vcr_r[10]=round(max($vcr_r),3);

                         for ($i=0; $i < count($id_klaster); $i++) {
                           $skor_vcr[$i]=1;
                           for ($j=0; $j < count($range_vcr_l); $j++) {
                             if($vcr_r[$i]>=$range_vcr_l[$j] && $vcr_r[$i]<=$range_vcr_r[$j+1]){
                               break;
                             }
                             if($skor_vcr[$i]<10){
                               $skor_vcr[$i]++;
                             }
                           }
                         }
                       }
                   else{
                     $range_vcr_l=0;
                     $range_vcr_r=0;
                     for ($i=0; $i < count($id_klaster); $i++) {
                       $skor_vcr[$i]=0;
                     }
                   }
                     //

                     // range nilai skor h_aksen
                     $const_h_aksen=0;
                     if($haksenp!=""){
                           $const_h_aksen=(max($h_aksen_klaster)-min($h_aksen_klaster))/10;
                           $range_h_aksen_l=[];
                           $range_h_aksen_init=min($h_aksen_klaster);
                           $range_h_aksen_l[0]=min($h_aksen_klaster);
                           $range_h_aksen_r=[];
                           for ($i=1;$i<10;$i++){
                             $range_h_aksen_init+=$const_h_aksen;
                             $range_h_aksen_l[$i]=round($range_h_aksen_init,3);
                             $range_h_aksen_r[$i]=round(($range_h_aksen_l[$i]-0.001),3);
                           }
                           $range_h_aksen_r[10]=round(max($h_aksen_klaster),3);

                           for ($i=0; $i < count($id_klaster); $i++) {
                             $skor_h_aksen[$i]=1;
                             for ($j=0; $j < count($range_h_aksen_l); $j++) {
                               if($h_aksen_klaster[$i]>=$range_h_aksen_l[$j] && $h_aksen_klaster[$i]<=$range_h_aksen_r[$j+1]){
                                 break;
                               }
                               if($skor_h_aksen[$i]<10){
                               $skor_h_aksen[$i]++;
                             }
                             }
                           }
                         }
                         else{
                           for($t=0;$t<=10;$t++){
                             $range_h_aksen_l[$t]=0;
                             $range_h_aksen_r[$t]=0;
                           }
                           for ($i=0; $i < count($id_klaster); $i++) {
                             $skor_h_aksen[$i]=0;
                           }
                         }
                       //

                       // range nilai skor j_pliup
                       $const_j_pliu=0;
                       if($p_jpliu!=""){
                             $const_j_pliu=(max($j_pliu_klaster)-min($j_pliu_klaster))/10;
                             $range_j_pliu_l=[];
                             $range_j_pliu_init=min($j_pliu_klaster);
                             $range_j_pliu_l[0]=min($j_pliu_klaster);
                             $range_j_pliu_r=[];
                             for ($i=1;$i<10;$i++){
                               $range_j_pliu_init+=$const_j_pliu;
                               $range_j_pliu_l[$i]=round($range_j_pliu_init,3);
                               $range_j_pliu_r[$i]=round(($range_j_pliu_l[$i]-0.001),3);
                             }
                             $range_j_pliu_r[10]=round(max($j_pliu_klaster),3);

                             for ($i=0; $i < count($id_klaster); $i++) {
                               $skor_j_pliu[$i]=1;
                               for ($j=0; $j < count($range_j_pliu_l); $j++) {
                                 if($j_pliu_klaster[$i]>=$range_j_pliu_l[$j] && $j_pliu_klaster[$i]<=$range_j_pliu_r[$j+1]){
                                   break;
                                 }
                                 if($skor_j_pliu[$i]<10){
                                 $skor_j_pliu[$i]++;
                               }
                               }
                             }
                           }
                           else{
                             for($t=0;$t<=10;$t++){
                               $range_j_pliu_l[$t]=0;
                               $range_j_pliu_r[$t]=0;
                             }
                             for ($i=0; $i < count($id_klaster); $i++) {
                               $skor_j_pliu[$i]=0;
                             }
                           }
                         //

                         // range nilai skor d_mg
                         $const_d_mg=0;
                         if($p_dmg!=""){
                               $const_d_mg=(max($d_mg)-min($d_mg))/10;
                               $range_d_mg_l=[];
                               $range_d_mg_init=min($d_mg);
                               $range_d_mg_l[0]=min($d_mg);
                               $range_d_mg_r=[];
                               for ($i=1;$i<10;$i++){
                                 $range_d_mg_init+=$const_d_mg;
                                 $range_d_mg_l[$i]=round($range_d_mg_init,3);
                                 $range_d_mg_r[$i]=round(($range_d_mg_l[$i]-0.001),3);
                               }
                               $range_d_mg_r[10]=round(max($d_mg),3);

                               for ($i=0; $i < count($id_klaster); $i++) {
                                 $skor_d_mg[$i]=1;
                                 for ($j=0; $j < count($range_d_mg_l); $j++) {
                                   if($d_mg[$i]>=$range_d_mg_l[$j] && $d_mg[$i]<=$range_d_mg_r[$j+1]){
                                     break;
                                   }
                                   if($skor_d_mg[$i]<10){
                                   $skor_d_mg[$i]++;
                                 }
                                 }
                               }
                             }
                             else{
                               for($t=0;$t<=10;$t++){
                                 $range_d_mg_l[$t]=0;
                                 $range_d_mg_r[$t]=0;
                               }
                               for ($i=0; $i < count($id_klaster); $i++) {
                                 $skor_d_mg[$i]=0;
                               }
                             }
                           //

                       // range nilai skor h_aksenf
                       if($haksenf!=""){
                             $const_h_aksenf=(max($h_aksenf)-min($h_aksenf))/10;
                             $range_h_aksen_lf=[];
                             $range_h_aksen_initf=min($h_aksenf);
                             $range_h_aksen_lf[0]=min($h_aksenf);
                             $range_h_aksen_rf=[];
                             for ($i=1;$i<10;$i++){
                               $range_h_aksen_initf+=$const_h_aksenf;
                               $range_h_aksen_lf[$i]=round($range_h_aksen_initf,3);
                               $range_h_aksen_rf[$i]=round(($range_h_aksen_lf[$i]-0.001),3);
                             }
                             $range_h_aksen_rf[10]=round(max($h_aksenf),3);

                             for ($i=0; $i < count($id_klaster); $i++) {
                               $skor_h_aksenf[$i]=1;
                               for ($j=0; $j < count($range_h_aksen_lf); $j++) {
                                 if($h_aksenf[$i]>=$range_h_aksen_lf[$j] && $h_aksenf[$i]<=$range_h_aksen_rf[$j+1]){
                                   break;
                                 }
                                 if($skor_h_aksenf[$i]<10){
                                   $skor_h_aksenf[$i]++;
                                 }
                               }
                             }
                           }
                           else{
                             $range_h_aksen_lf=0;
                             $range_h_aksen_rf=0;
                             for ($i=0; $i < count($id_klaster); $i++) {
                               $skor_h_aksenf[$i]=0;
                             }
                           }
                         //

                         // range nilai skor jpliuf
                         if($p_jpliuf!=""){
                               $const_j_pliuf=(max($j_pliuf)-min($j_pliuf))/10;
                               $range_j_pliu_lf=[];
                               $range_j_pliu_initf=min($j_pliuf);
                               $range_j_pliu_lf[0]=min($j_pliuf);
                               $range_j_pliu_rf=[];
                               for ($i=1;$i<10;$i++){
                                 $range_j_pliu_initf+=$const_j_pliuf;
                                 $range_j_pliu_lf[$i]=round($range_j_pliu_initf,3);
                                 $range_j_pliu_rf[$i]=round(($range_j_pliu_lf[$i]-0.001),3);
                               }
                               $range_j_pliu_rf[10]=round(max($j_pliuf),3);

                               for ($i=0; $i < count($id_klaster); $i++) {
                                 $skor_j_pliuf[$i]=1;
                                 for ($j=0; $j < count($range_j_pliu_lf); $j++) {
                                   if($j_pliuf[$i]>=$range_j_pliu_lf[$j] && $j_pliuf[$i]<=$range_j_pliu_rf[$j+1]){
                                     break;
                                   }
                                   if($skor_j_pliuf[$i]<10){
                                     $skor_j_pliuf[$i]++;
                                   }
                                 }
                               }
                             }
                             else{
                               $range_j_pliu_lf=0;
                               $range_j_pliu_rf=0;
                               for ($i=0; $i < count($id_klaster); $i++) {
                                 $skor_j_pliuf[$i]=0;
                               }
                             }
                           //

                           // range nilai skor dmgf
                           if($p_dmgf!=""){
                                 $const_d_mgf=(max($d_mgf)-min($d_mgf))/10;
                                 $range_d_mg_lf=[];
                                 $range_d_mg_initf=min($d_mgf);
                                 $range_d_mg_lf[0]=min($d_mgf);
                                 $range_d_mg_rf=[];
                                 for ($i=1;$i<10;$i++){
                                   $range_d_mg_initf+=$const_d_mgf;
                                   $range_d_mg_lf[$i]=round($range_d_mg_initf,3);
                                   $range_d_mg_rf[$i]=round(($range_d_mg_lf[$i]-0.001),3);
                                 }
                                 $range_d_mg_rf[10]=round(max($d_mgf),3);

                                 for ($i=0; $i < count($id_klaster); $i++) {
                                   $skor_d_mgf[$i]=1;
                                   for ($j=0; $j < count($range_d_mg_lf); $j++) {
                                     if($d_mgf[$i]>=$range_d_mg_lf[$j] && $d_mgf[$i]<=$range_d_mg_rf[$j+1]){
                                       break;
                                     }
                                     if($skor_d_mgf[$i]<10){
                                       $skor_d_mgf[$i]++;
                                     }
                                   }
                                 }
                               }
                               else{
                                 $range_d_mg_lf=0;
                                 $range_d_mg_rf=0;
                                 for ($i=0; $i < count($id_klaster); $i++) {
                                   $skor_d_mgf[$i]=0;
                                 }
                               }
                             //

                       // nilai Tertimbang
                       for ($i=0; $i < count($id_klaster); $i++) {

                           $nt_kr=DB::table('nilai_tertimbang_copy')
                           ->where('id_data_klaster','=',$id_data_klaster)->get();

                           if(count($nt_kr)==0){
                             $nt_ktpk[$i]=0.27;
                             $nt_kerusakan[$i]=0.27;
                             $nt_produktivitas[$i]=0.28;
                             $nt_ktjk[$i]=0.23;
                             $nt_biodiv[$i]=0.077;
                             $nt_biodivf[$i]=0.077;
                           }
                           else{
                             $nt_kr=DB::table('nilai_tertimbang_copy')
                             ->where('id_data_klaster','=',$id_data_klaster)->first();
                             $nt_ktpk[$i]=$nt_kr->nilai_ktpk;
                             $nt_kerusakan[$i]=$nt_kr->nilai_kphn;
                             $nt_produktivitas[$i]=$nt_kr->nilai_prod;
                             $nt_ktjk[$i]=$nt_kr->nilai_ktjk;
                             $nt_biodiv[$i]=$nt_kr->nilai_kjpb;
                             $nt_biodivf[$i]=$nt_kr->nilai_kjfb;
                           }


                     }

                       //  nilai akhir ktk kimia
                       $na_total_cec[0] = 0;
                       for ($i=0; $i < count($id_klaster); $i++) {
                         $na_cec[$i]=$skor_cec[$i]*$nt_ktpk[$i];
                         $na_total_cec[0] += $na_cec[$i];
                       }
                       //  nilai akhir Produktivitas lbds
                       $na_total_lbds[0] = 0;
                       for ($i=0; $i < count($id_klaster); $i++) {
                         $na_lbds[$i]=$skor_lbds[$i]*$nt_produktivitas[$i];
                         $na_total_lbds[0] += $na_lbds[$i];
                       }
                       $na_total_lbds[0] = $na_total_lbds[0]/$i;
                       //  nilai akhir Produktivitas volume
                       $na_total_volume[0] = 0;
                       for ($i=0; $i < count($id_klaster); $i++) {
                         $na_volume[$i]=$skor_volume[$i]*$nt_produktivitas[$i];
                         $na_total_volume[0] += $na_volume[$i];
                       }
                       $na_total_volume[0] = $na_total_volume[0]/$i;
                       //  nilai akhir kerusakan pohon
                       $na_total_kerusakan[0] = 0;
                       for ($i=0; $i < count($id_klaster); $i++) {
                         $na_kerusakan[$i]=$skor_tli[$i]*$nt_kerusakan[$i];
                         $na_total_kerusakan[0] += $na_kerusakan[$i];
                       }
                       $na_total_kerusakan[0] = $na_total_kerusakan[0]/$i;
                       //  nilai akhir kondisi tajuk
                       $na_total_tajuk[0] = 0;
                       for ($i=0; $i < count($id_klaster); $i++) {
                         $na_tajuk[$i]=$skor_vcr[$i]*$nt_ktjk[$i];
                         $na_total_tajuk[0] += $na_tajuk[$i];
                       }
                       $na_total_tajuk[0] = $na_total_tajuk[0]/$i;

                       //  nilai akhir biodiversitas pohon haksen
                       $na_total_biodiv_pohon[0] = 0;
                       for ($i=0; $i < count($id_klaster); $i++) {
                         $na_biodiv_pohon[$i]=$skor_h_aksen[$i]*$nt_biodiv[$i];
                         $na_total_biodiv_pohon[0] += $na_biodiv_pohon[$i];
                       }
                       $na_total_biodiv_pohon[0] = $na_total_biodiv_pohon[0]/$i;

                       //  nilai akhir biodiversitas pohon jpliu
                       $na_total_biodiv_pohon_jpliu[0] = 0;
                       for ($i=0; $i < count($id_klaster); $i++) {
                         $na_biodiv_pohon_jpliu[$i]=$skor_j_pliu[$i]*$nt_biodiv[$i];
                         $na_total_biodiv_pohon_jpliu[0] += $na_biodiv_pohon_jpliu[$i];
                       }
                       //  nilai akhir biodiversitas pohon dmg
                       $na_total_biodiv_pohon_dmg[0] = 0;
                       for ($i=0; $i < count($id_klaster); $i++) {
                         $na_biodiv_pohon_dmg[$i]=$skor_d_mg[$i]*$nt_biodiv[$i];
                         $na_total_biodiv_pohon_dmg[0] += $na_biodiv_pohon_dmg[$i];
                       }
                       $na_total_biodiv_pohon_dmg[0] = $na_total_biodiv_pohon_dmg[0]/$i;

                       //  nilai akhir biodiversitas fauna
                       $na_total_biodiv_fauna[0] = 0;
                       for ($i=0; $i < count($id_klaster); $i++) {
                         $na_biodiv_fauna[$i]=$skor_h_aksenf[$i]*$nt_biodivf[$i];
                         $na_total_biodiv_fauna[0] += $na_biodiv_fauna[$i];
                       }
                       $na_total_biodiv_fauna[0] = $na_total_biodiv_fauna[0]/$i;

                       $na_total_biodiv_fauna_jpliuf[0] = 0;
                       for ($i=0; $i < count($id_klaster); $i++) {
                         $na_biodiv_fauna_jpliuf[$i]=$skor_j_pliuf[$i]*$nt_biodivf[$i];
                         $na_total_biodiv_fauna_jpliuf[0] += $na_biodiv_fauna_jpliuf[$i];
                       }
                       $na_total_biodiv_fauna_jpliuf[0] = $na_total_biodiv_fauna_jpliuf[0]/$i;

                       $na_total_biodiv_fauna_dmgf[0] = 0;
                       for ($i=0; $i < count($id_klaster); $i++) {
                         $na_biodiv_fauna_dmgf[$i]=$skor_d_mgf[$i]*$nt_biodivf[$i];
                         $na_total_biodiv_fauna_dmgf[0] += $na_biodiv_fauna_dmgf[$i];
                       }
                       $na_total_biodiv_fauna_dmgf[0] = $na_total_biodiv_fauna_dmgf[0]/$i;



                       // nilai total indikator
                       $na_seluruh[0] = 0;
                       for ($i=0; $i < count($id_klaster); $i++) {
                         $na_total[$i]=$na_kerusakan[$i]+$na_tajuk[$i]+$na_biodiv_pohon[$i]+$na_biodiv_pohon_jpliu[$i]+$na_biodiv_pohon_dmg[$i]+$na_lbds[$i]+$na_volume[$i]+$na_biodiv_fauna[$i]+$na_biodiv_fauna_jpliuf[$i]+$na_cec[$i];
                         $na_seluruh[0] += $na_total[$i];
                       }
                       $na_seluruh[0] = $na_seluruh[0]/$i;



                         $kedua_m=0;
                         $kedua_tli_r=[];
                         $kedua_vcr_r=[];
                         $kedua_lbds_r=[];
                         $kedua_volume_r=[];
                         $kedua_cec_r=[];

                         for ($kedua_i=0; $kedua_i < count($id_klaster2); $kedua_i++) {
                           // untuk mengetahui id klaster saat ini
                           $kedua_id_cl=$id_klaster2[$kedua_i]->id_klaster_plot;
                             $kedua_id_pengukuran1=[];
                             $kedua_plot=[];
                             $kedua_tli_f=[];
                             $kedua_vcr_f=[];
                             $kedua_lbds_f=[];
                             $kedua_volume_f=[];
                             $kedua_cec_f=[];
                             // untuk menghitung banyaknya plot yang ada pengukuran
                             $kedua_plot=DB::table('tbl_plot')
                             ->join('pengukuran_master','pengukuran_master.id_plot','=','tbl_plot.id_plot')
                             ->where('id_klaster_plot',$kedua_id_cl)
                             ->where('pengukuran_ke','=',2)
                             ->get();
                             if(count($kedua_plot)!=0){
                             for ($kedua_j=0; $kedua_j < count($kedua_plot); $kedua_j++) {
                               $kedua_id_pengukuran=DB::table('pengukuran_master')->where([['id_plot',$kedua_plot[$kedua_j]->id_plot],['pengukuran_ke',2]])->get();
                               $kedua_id_pengukuran1[$kedua_j]=$kedua_id_pengukuran[0]->id_pengukuran;

                             }

                           }
                           else{
                             // id pengukuran gak ada
                           }
                           $kedua_tli_r[$kedua_m]=0;
                           $kedua_vcr_r[$kedua_m]=0;
                           $kedua_lbds_r[$kedua_m]=0;
                           $kedua_volume_r[$kedua_m]=0;
                           $kedua_cec_r[$kedua_m]=0;
                           // kalo pengukurannya tidak kosong dalam satu klaster

                           if(count($kedua_id_pengukuran1)!=0){
                             for ($kedua_k=0; $kedua_k < count($kedua_id_pengukuran1); $kedua_k++) {
                             $kedua_tli=0;
                             $kedua_vcr=0;
                             $kedua_lbds=0;
                             $kedua_volume=0;

                             //indikator kualitas Tapak
                             if($p_kimia!=""){

                               if($kedua_sifat_kimia==""){
                                 $kedua_cec_f[$kedua_i]=0;
                               }
                               else{
                                 $kedua_data_pengukuran_ktk_kimia= DB::table('ktk_kimia')
                                 ->where('kode_klaster','=',$kedua_id_cl)
                                 ->where('pengukuran_ke','=',2)
                                 ->where('id_sifat','=',$kedua_sifat_kimia)
                                 ->first();
                                 $kedua_data_pengukuran_ktk_kimia= DB::table('ktk_kimia')
                                 ->where('kode_klaster','=',$kedua_id_cl)
                                 ->where('pengukuran_ke','=',2)
                                 ->where('id_sifat','=',$kedua_sifat_kimia)
                                 ->get();
                                 if(count($kedua_data_pengukuran_ktk_kimia)!=0){
                                     $kedua_cec_f[$kedua_i]=$kedua_data_pengukuran_ktk_kimia[0]->cec;
                                 }
                                 else{
                                   $kedua_cec_f[$kedua_i]=0;
                                 }
                               }

                             }
                             else{
                               $kedua_cec_f[$kedua_i]=0;
                             }

                             // indikator vitalitas
                             // untuk data pengukuran kerusakan
                             if($p_kerusakan!=""){
                               $kedua_data_pengukuran=DB::table('pengukuran_master')
                                 ->join('kerusakan_pohon','kerusakan_pohon.id_pengukuran','=','pengukuran_master.id_pengukuran')
                                 ->select('tli')
                                 ->where('pengukuran_master.id_pengukuran',$kedua_id_pengukuran1[$kedua_k])->get();

                                 // untuk kerusakan
                                 if(count($kedua_data_pengukuran)!=0){
                                   for ($kedua_l=0; $kedua_l < count ($kedua_data_pengukuran); $kedua_l++) {
                                     // nilai total tli plot
                                     $kedua_tli+=$kedua_data_pengukuran[$kedua_l]->tli;
                                   }
                                   // nilai pli plot
                                   $kedua_tli_f[$kedua_k]=($kedua_tli/count($kedua_data_pengukuran));
                                 }
                                 else{
                                   $kedua_tli_f[$kedua_k]=0;
                                 }
                             }
                             else{
                               $kedua_tli_f[$kedua_k]=0;
                             }
                             //

                             // untuk data pengukuran tajuk
                             if($p_ktjk!=""){
                               $kedua_data_pengukuran_tajuk=DB::table('pengukuran_master')
                                 ->join('kondisi_tajuk','kondisi_tajuk.id_pengukuran','=','pengukuran_master.id_pengukuran')
                                 ->select('vcri')
                                 ->where('pengukuran_master.id_pengukuran',$kedua_id_pengukuran1[$kedua_k])->get();
                                 // untuk tajuk
                                 if(count($kedua_data_pengukuran_tajuk)!=0){
                                   for ($kedua_l=0; $kedua_l < count ($kedua_data_pengukuran_tajuk); $kedua_l++) {
                                     // nilai total vcr plot
                                     $kedua_vcr+=$kedua_data_pengukuran_tajuk[$kedua_l]->vcri;
                                   }
                                   // nilai vcr plot
                                   $kedua_vcr_f[$kedua_k]=($kedua_vcr/count($kedua_data_pengukuran_tajuk));
                                 }
                                 else{
                                   $kedua_vcr_f[$kedua_k]=0;
                                 }
                             }
                             else{
                               $kedua_vcr_f[$kedua_k]=0;
                             }

                               // indikator produktivitas parameter lbds
                             if($p_lbds!=""){
                             $kedua_data_pengukuran_lbds=DB::table('pengukuran_master')
                               ->join('lbds','lbds.id_pengukuran','=','pengukuran_master.id_pengukuran')
                               ->select('Hasil_LBDS','v')
                               ->where('pengukuran_master.id_pengukuran',$kedua_id_pengukuran1[$kedua_k])->get();
                               // untuk lbds
                               if(count($kedua_data_pengukuran_lbds)!=0){
                               for ($kedua_l=0; $kedua_l < count ($kedua_data_pengukuran_lbds); $kedua_l++) {
                                 // nilai total lbds plot
                                 $kedua_lbds+=$kedua_data_pengukuran_lbds[$kedua_l]->Hasil_LBDS;
                               }
                               // nilai lbds plot
                               $kedua_lbds_f[$kedua_k]=$kedua_lbds;
                             }
                             else{
                               $kedua_lbds_f[$kedua_k]=0;
                             }
                            }
                            else{
                              $kedua_lbds_f[$kedua_k]=0;
                            }
                               //

                               // indikator produktivitas parameter volume
                               if($p_volume!=""){
                               $kedua_data_pengukuran_volume=DB::table('pengukuran_master')
                               ->join('lbds','lbds.id_pengukuran','=','pengukuran_master.id_pengukuran')
                               ->select('Hasil_LBDS','v')
                               ->where('pengukuran_master.id_pengukuran',$kedua_id_pengukuran1[$kedua_k])->get();
                                // untuk volume
                                if(count($kedua_data_pengukuran_volume)!=0){
                                for ($kedua_l=0; $kedua_l < count ($kedua_data_pengukuran_volume); $kedua_l++) {
                                  // nilai total volume_v plot
                                  $kedua_volume+=$kedua_data_pengukuran_volume[$kedua_l]->v;
                                }
                                // nilai volume_v plot
                                $kedua_volume_f[$kedua_k]=$kedua_volume;
                               }
                               else{
                                $kedua_volume_f[$kedua_k]=0;
                               }
                               }
                               else{
                               $kedua_volume_f[$kedua_k]=0;
                               }
                               //

                             //nilai total KTPK
                             $kedua_cec_r[$kedua_m]=$kedua_cec_f[$kedua_i];
                             // nilai total PLI
                             $kedua_tli_r[$kedua_m]+=$kedua_tli_f[$kedua_k];
                             // nilai total VCR
                             $kedua_vcr_r[$kedua_m]+=$kedua_vcr_f[$kedua_k];
                             // nilai total LBDS
                             $kedua_lbds_r[$kedua_m]+=$kedua_lbds_f[$kedua_k];
                             // nilai total Volume
                             $kedua_volume_r[$kedua_m]+=$kedua_volume_f[$kedua_k];
                           }

                           $kedua_tli_r[$kedua_m]=$kedua_tli_r[$kedua_m]/count($kedua_id_pengukuran1);
                           $kedua_vcr_r[$kedua_m]=$kedua_vcr_r[$kedua_m]/count($kedua_id_pengukuran1);
                           $kedua_lbds_r[$kedua_m]=$kedua_lbds_r[$kedua_m]/count($kedua_id_pengukuran1);
                           $kedua_volume_r[$kedua_m]=$kedua_volume_r[$kedua_m]/count($kedua_id_pengukuran1);
                             // hanya pembulatan
                             for ($kedua_a=0;$kedua_a<count($kedua_id_pengukuran1);$kedua_a++){
                               $kedua_tli_f[$kedua_a]=round(($kedua_tli_f[$kedua_a]),3);
                               $kedua_vcr_f[$kedua_a]=round(($kedua_vcr_f[$kedua_a]),3);
                               $kedua_lbds_f[$kedua_a]=round(($kedua_lbds_f[$kedua_a]),3);
                               $kedua_volume_f[$kedua_a]=round(($kedua_volume_f[$kedua_a]),3);
                             }
                           }
                           else{
                             if($kedua_id_cl==""){
                               $kedua_pesan= "Data pengukuran tidak tersedia";
                               return view('auditor.penilaian_kurang',[
                                 'pesan' => $kedua_pesan,
                               ]);
                             }
                             else{
                               $kedua_pesan= "Salah satu pengukuran tidak tersedia";
                               return view('auditor.pengukuran_kurang',[
                                 'pesan' => $kedua_pesan,
                                 'id_klaster' => $kedua_id_cl,
                               ]);
                             }

                           }

                             $kedua_m++;

                             // data biodiversitas pohon
                             for($kedua_q=0;$kedua_q<count($kedua_plot);$kedua_q++){
                               $kedua_j_pliu_klaster[$i]=0;
                             if($haksenp!="" || $p_jpliu!=""){
                               $kedua_rata_h_aksen[$kedua_i]=0;
                               $kedua_data_biodiv_pohon[$kedua_i] = DB::table('data_tanaman_plot')
                               ->where('id_plot','=',$kedua_plot[$kedua_q]->id_plot)
                               ->where('status','=','1')
                               ->where('pengukuran_ke','=',2)
                               ->get();
                               $kedua_jumlah_pohon[$kedua_i]=count($kedua_data_biodiv_pohon[$kedua_i]);
                               $kedua_jenis_pohon[$kedua_i]=DB::table('data_tanaman_plot')
                               ->select(DB::raw("data_tanaman_plot.id_master_jenis_tanaman, COUNT(*) as jumlah"))
                               ->where('data_tanaman_plot.id_plot','=',$kedua_plot[$kedua_q]->id_plot)
                               ->where('status','=','1')
                               ->where('pengukuran_ke','=',2)
                               ->groupBy(DB::raw('data_tanaman_plot.id_master_jenis_tanaman'))
                               ->get();

                               $kedua_h_aksen[$kedua_q]=0;
                               if($kedua_jumlah_pohon[$kedua_i]!=0){
                                 for($kedua_o=0;$kedua_o<count($kedua_jenis_pohon[$kedua_i]);$kedua_o++){
                                   $kedua_n[$kedua_o]=$kedua_jenis_pohon[$kedua_i][$kedua_o]->jumlah;
                                   $kedua_ni[$kedua_o]=$kedua_n[$kedua_o]/$kedua_jumlah_pohon[$kedua_i];
                                   $kedua_ln_ni[$kedua_o]=log($kedua_ni[$kedua_o]);
                                   $kedua_ni_ln_ni[$kedua_o]=$kedua_ni[$kedua_o]*$kedua_ln_ni[$kedua_o];
                                   $kedua_h_aksen[$kedua_q]-=$kedua_ni_ln_ni[$kedua_o];
                                 }

                                 //$kedua_h_aksen[$kedua_i]=$kedua_h_aksen[$kedua_i]/count($kedua_jenis_pohon[$kedua_i]);
                               }
                              }
                              else{
                                $kedua_h_aksen[$kedua_q]=0;
                              }
                            //   if($kedua_i==1){
                            //   dd($kedua_h_aksen);
                            // }
                              //

                               // dmg biodiversitas pohon
                               if($p_dmg!=""){
                                 $kedua_h_aksen_klaster[$kedua_i]=0;
                                 $kedua_rata_h_aksen[$kedua_i]=0;
                                 $kedua_data_biodiv_pohon[$kedua_i] = DB::table('data_tanaman_plot')
                                 ->where('id_plot','=',$kedua_plot[$kedua_q]->id_plot)
                                 ->where('status','=','1')
                                 ->where('pengukuran_ke','=',2)
                                 ->get();
                                 $kedua_jumlah_pohon[$kedua_i]=count($kedua_data_biodiv_pohon[$kedua_i]);
                                 $kedua_jenis_pohon[$kedua_i]=DB::table('data_tanaman_plot')
                                 ->select(DB::raw("data_tanaman_plot.id_master_jenis_tanaman, COUNT(*) as jumlah"))
                                 ->where('data_tanaman_plot.id_plot','=',$kedua_plot[$kedua_q]->id_plot)
                                 ->where('status','=','1')
                                 ->where('pengukuran_ke','=',2)
                                 ->groupBy(DB::raw('data_tanaman_plot.id_master_jenis_tanaman'))
                                 ->get();

                                 $kedua_data_biodiv_pohon_klaster[$kedua_i] = DB::table('data_tanaman_plot')
                                 ->where('id_klaster_plot','=',$kedua_id_cl)
                                 ->where('status','=','1')
                                 ->where('pengukuran_ke','=',2)
                                 ->get();
                                 $kedua_jumlah_pohon_klaster[$kedua_i]=count($kedua_data_biodiv_pohon_klaster[$kedua_i]);

                                 $kedua_jenis_pohon_klaster[$kedua_i]=DB::table('data_tanaman_plot')
                                 ->select(DB::raw("data_tanaman_plot.id_master_jenis_tanaman, COUNT(*) as jumlah"))
                                 ->where('data_tanaman_plot.id_klaster_plot','=',$kedua_id_cl)
                                 ->where('status','=','1')
                                 ->where('pengukuran_ke','=',2)
                                 ->groupBy(DB::raw('data_tanaman_plot.id_master_jenis_tanaman'))
                                 ->get();
                                 $kedua_jml_jenis_klaster[$kedua_i] = count($kedua_jenis_pohon_klaster[$kedua_i]);

                                 $kedua_h_aksen[$kedua_q]=0;
                                 $kedua_d_mg[$kedua_i]=0;
                                 if($kedua_jumlah_pohon[$kedua_i]!=0){
                                   $kedua_jml_jenis[$kedua_i] = count($kedua_jenis_pohon[$kedua_i]);
                                   for($kedua_o=0;$kedua_o<count($kedua_jenis_pohon[$kedua_i]);$kedua_o++){
                                     $kedua_n[$kedua_o]=$kedua_jenis_pohon[$kedua_i][$kedua_o]->jumlah;
                                     $kedua_ni[$kedua_o]=$kedua_n[$kedua_o]/$kedua_jumlah_pohon[$kedua_i];
                                     $kedua_ln_ni[$kedua_o]=log($kedua_ni[$kedua_o]);
                                     $kedua_ni_ln_ni[$kedua_o]=$kedua_ni[$kedua_o]*$kedua_ln_ni[$kedua_o];
                                     $kedua_h_aksen[$kedua_q]-=$kedua_ni_ln_ni[$kedua_o];
                                     $kedua_rata_h_aksen[$kedua_i]+=$kedua_h_aksen[$kedua_q];
                                   }

                                   if($kedua_jumlah_pohon_klaster[$kedua_i]>1){
                                     $kedua_d_mg[$kedua_i]=($kedua_jml_jenis_klaster[$kedua_i]-1)/log($kedua_jumlah_pohon_klaster[$kedua_i]);
                                   }
                                 }

                                }
                                else{
                                  $kedua_d_mg[$kedua_i]=0;
                                }
                              }
                                 // dd($kedua_h_aksen);
                                 if($haksenp!=""){
                                     $kedua_rata_h_aksen[$kedua_i]=0;
                                     for($kedua_v=0;$kedua_v<4;$kedua_v++){
                                     $kedua_rata_h_aksen[$kedua_i]+=$kedua_h_aksen[$kedua_v];
                                   }
                                   $kedua_h_aksen_klaster[$kedua_i]=$kedua_rata_h_aksen[$kedua_i]/4;
                                 }


                                if($p_jpliu!=""){
                                  $kedua_rata_h_aksen[$kedua_i]=0;
                                  for($kedua_v=0;$kedua_v<4;$kedua_v++){
                                  $kedua_rata_h_aksen[$kedua_i]+=$kedua_h_aksen[$kedua_v];
                                }
                                 $kedua_h_aksen_klaster[$kedua_i]=$kedua_rata_h_aksen[$kedua_i]/4;

                                  $kedua_jenis_pohon_klaster[$kedua_i]=DB::table('data_tanaman_plot')
                                  ->select(DB::raw("data_tanaman_plot.id_master_jenis_tanaman, COUNT(*) as jumlah"))
                                  ->where('data_tanaman_plot.id_klaster_plot','=',$kedua_id_cl)
                                  ->where('status','=','1')
                                  ->where('pengukuran_ke','=',2)
                                  ->groupBy(DB::raw('data_tanaman_plot.id_master_jenis_tanaman'))
                                  ->get();
                                  $kedua_jml_jenis_klaster[$kedua_i] = count($kedua_jenis_pohon_klaster[$kedua_i]);

                                  if($kedua_jml_jenis_klaster[$kedua_i]>1){
                                    $kedua_j_pliu_klaster[$kedua_i]=$kedua_h_aksen_klaster[$kedua_i]/log($kedua_jml_jenis_klaster[$kedua_i]);
                                  }
                              }
                              else{
                                $kedua_j_pliu_klaster[$i]=0;
                              }
                                //

                              // data biodiversitas fauna
                              if($haksenf!=""){
                                $kedua_data_biodiv_fauna[$kedua_i] = DB::table('data_fauna')
                                ->where('id_klaster_plot_fauna','=',$kedua_id_cl)
                                ->where('pengukuran_ke','=',2)
                                ->get();
                                $kedua_h_aksenf[$kedua_i]=0;
                                if(count($kedua_data_biodiv_fauna[$kedua_i])!=0){
                                  $kedua_total_fauna=0;
                                  $kedua_tot_data_fauna[$kedua_i]=count($kedua_data_biodiv_fauna[$kedua_i]);
                                  for($kedua_s=0;$kedua_s<$kedua_tot_data_fauna[$kedua_i];$kedua_s++){
                                    $kedua_total_fauna+=$kedua_data_biodiv_fauna[$kedua_i][$kedua_s]->jumlah;
                                  }

                                  $kedua_jumlah_fauna[$kedua_i]=$kedua_total_fauna;
                                  for($kedua_t=0;$kedua_t<$kedua_tot_data_fauna[$kedua_i];$kedua_t++){
                                    $kedua_nf[$kedua_t]=$kedua_data_biodiv_fauna[$kedua_i][$kedua_t]->jumlah;
                                    $kedua_nif[$kedua_t]=$kedua_nf[$kedua_t]/$kedua_jumlah_fauna[$kedua_i];
                                    $kedua_ln_nif[$kedua_t]=log($kedua_nif[$kedua_t]);
                                    $kedua_ni_ln_nif[$kedua_t]=$kedua_nif[$kedua_t]*$kedua_ln_nif[$kedua_t];
                                    $kedua_h_aksenf[$kedua_i]-=$kedua_ni_ln_nif[$kedua_t];
                                  }
                                  $kedua_h_aksenf[$kedua_i]=$kedua_h_aksenf[$kedua_i]/$kedua_tot_data_fauna[$kedua_i];
                                }
                             }
                             else{
                               $kedua_h_aksenf[$kedua_i]=0;
                             }

                             // data jpliu fauna
                             if($p_jpliuf!=""){
                               $kedua_data_biodiv_fauna[$kedua_i] = DB::table('data_fauna')
                               ->where('id_klaster_plot_fauna','=',$kedua_id_cl)
                               ->where('pengukuran_ke','=',2)
                               ->get();
                               $kedua_h_aksenf[$kedua_i]=0;
                               $kedua_j_pliuf[$kedua_i]=0;
                               if(count($kedua_data_biodiv_fauna[$kedua_i])!=0){
                                 $kedua_total_fauna=0;
                                 $kedua_tot_data_fauna[$kedua_i]=count($kedua_data_biodiv_fauna[$kedua_i]);
                                 for($kedua_s=0;$kedua_s<$kedua_tot_data_fauna[$kedua_i];$kedua_s++){
                                   $kedua_total_fauna+=$kedua_data_biodiv_fauna[$kedua_i][$kedua_s]->jumlah;
                                 }

                                 $kedua_jumlah_fauna[$kedua_i]=$kedua_total_fauna;
                                 for($kedua_t=0;$kedua_t<$kedua_tot_data_fauna[$kedua_i];$kedua_t++){
                                   $kedua_nf[$kedua_t]=$kedua_data_biodiv_fauna[$kedua_i][$kedua_t]->jumlah;
                                   $kedua_nif[$kedua_t]=$kedua_nf[$kedua_t]/$kedua_jumlah_fauna[$kedua_i];
                                   $kedua_ln_nif[$kedua_t]=log($kedua_nif[$kedua_t]);
                                   $kedua_ni_ln_nif[$kedua_t]=$kedua_nif[$kedua_t]*$kedua_ln_nif[$kedua_t];
                                   $kedua_h_aksenf[$kedua_i]-=$kedua_ni_ln_nif[$kedua_t];

                                   if($kedua_tot_data_fauna[$kedua_i]==0 || $kedua_tot_data_fauna[$kedua_i]==1 ){
                                     $kedua_j_pliuf[$kedua_i]+=0;
                                   }
                                   else{
                                     $kedua_j_pliuf[$kedua_i]+=-1*$kedua_ni_ln_nif[$kedua_t]/log($kedua_tot_data_fauna[$kedua_i]);
                                   }

                                 }
                                 $kedua_j_pliuf[$kedua_i]=$kedua_j_pliuf[$kedua_i]/$kedua_tot_data_fauna[$kedua_i];
                                 $kedua_h_aksenf[$kedua_i]=$kedua_h_aksenf[$kedua_i]/$kedua_tot_data_fauna[$kedua_i];
                               }
                            }
                            else{
                              $kedua_j_pliuf[$kedua_i]=0;
                            }

                            // data dmg fauna
                            if($p_dmgf!=""){
                              $kedua_data_biodiv_fauna[$kedua_i] = DB::table('data_fauna')
                              ->where('id_klaster_plot_fauna','=',$kedua_id_cl)
                              ->where('pengukuran_ke','=',2)
                              ->get();
                              $kedua_h_aksenf[$kedua_i]=0;
                              $kedua_d_mgf[$kedua_i]=0;
                              if(count($kedua_data_biodiv_fauna[$kedua_i])!=0){
                                $kedua_total_fauna=0;
                                $kedua_tot_data_fauna[$kedua_i]=count($kedua_data_biodiv_fauna[$kedua_i]);

                                for($kedua_s=0;$kedua_s<$kedua_tot_data_fauna[$kedua_i];$kedua_s++){
                                  $kedua_total_fauna+=$kedua_data_biodiv_fauna[$kedua_i][$kedua_s]->jumlah;
                                }

                                $kedua_jumlah_fauna[$kedua_i]=$kedua_total_fauna;
                                for($kedua_t=0;$kedua_t<$kedua_tot_data_fauna[$kedua_i];$kedua_t++){
                                  $kedua_nf[$kedua_t]=$kedua_data_biodiv_fauna[$kedua_i][$kedua_t]->jumlah;
                                  $kedua_nif[$kedua_t]=$kedua_nf[$kedua_t]/$kedua_jumlah_fauna[$kedua_i];
                                  $kedua_ln_nif[$kedua_t]=log($kedua_nif[$kedua_t]);
                                  $kedua_ni_ln_nif[$kedua_t]=$kedua_nif[$kedua_t]*$kedua_ln_nif[$kedua_t];
                                  $kedua_h_aksenf[$kedua_i]-=$kedua_ni_ln_nif[$kedua_t];
                                }

                                if($kedua_tot_data_fauna[$kedua_i]>1){
                                  $kedua_h_aksenf[$kedua_i]=$kedua_h_aksenf[$kedua_i]/$kedua_tot_data_fauna[$kedua_i];
                                }
                                if($kedua_jumlah_fauna[$kedua_i]>1){
                                  $kedua_d_mgf[$kedua_i]=($kedua_tot_data_fauna[$kedua_i]-1)/log($kedua_jumlah_fauna[$kedua_i]);
                                }
                              }
                           }
                           else{
                             $kedua_d_mgf[$kedua_i]=0;
                           }

                           }


                           // hanya pembulatan
                           for ($kedua_a=0;$kedua_a<count($kedua_tli_r);$kedua_a++){
                             $kedua_cec_r[$kedua_a]=round(($kedua_cec_r[$kedua_a]),3);
                             $kedua_lbds_r[$kedua_a]=round(($kedua_lbds_r[$kedua_a]),3);
                             $kedua_volume_r[$kedua_a]=round(($kedua_volume_r[$kedua_a]),3);
                             $kedua_tli_r[$kedua_a]=round(($kedua_tli_r[$kedua_a]),3);
                             $kedua_vcr_r[$kedua_a]=round(($kedua_vcr_r[$kedua_a]),3);
                             // $kedua_h_aksen[$kedua_a]=round($kedua_h_aksen[$kedua_a],3);
                             // $kedua_j_pliu[$kedua_a]=round($kedua_j_pliu[$kedua_a],3);
                             $kedua_d_mg[$kedua_a]=round($kedua_d_mg[$kedua_a],3);
                             $kedua_h_aksenf[$kedua_a]=round($kedua_h_aksenf[$kedua_a],3);
                             $kedua_j_pliuf[$kedua_a]=round($kedua_j_pliuf[$kedua_a],3);
                             $kedua_d_mgf[$kedua_a]=round($kedua_d_mgf[$kedua_a],3);
                             // $kedua_h_aksen_klaster[$kedua_a]=round($kedua_h_aksen_klaster[$kedua_a],3);
                             // $kedua_j_pliu_klaster[$kedua_a]=round($kedua_j_pliu_klaster[$kedua_a],3);
                           }

                           // range nilai skor Ktk kimia
                           if($p_kimia!=""){
                                 $kedua_const_cec=(max($kedua_cec_r)-min($kedua_cec_r))/10;
                                 $kedua_range_cec_l=[];
                                 $kedua_range_cec_init=min($kedua_cec_r);
                                 $kedua_range_cec_l[0]=min($kedua_cec_r);
                                 $kedua_range_cec_r=[];
                                 for ($kedua_i=1;$kedua_i<10;$kedua_i++){
                                   $kedua_range_cec_init+=$kedua_const_cec;
                                   $kedua_range_cec_l[$kedua_i]=round($kedua_range_cec_init,3);
                                   $kedua_range_cec_r[$kedua_i]=round(($kedua_range_cec_l[$kedua_i]-0.001),3);
                                 }
                                 $kedua_range_cec_r[10]=round(max($kedua_cec_r),3);

                                 for ($kedua_i=0; $kedua_i < count($id_klaster2); $kedua_i++) {
                                   $kedua_skor_cec[$kedua_i]=1;
                                   for ($kedua_j=0; $kedua_j < count($kedua_range_cec_l); $kedua_j++) {
                                     if($kedua_cec_r[$kedua_i]>=$kedua_range_cec_l[$kedua_j] && $kedua_cec_r[$kedua_i]<=$kedua_range_cec_r[$kedua_j+1]){
                                       break;
                                     }
                                     if($kedua_skor_cec[$kedua_i]<10){
                                     $kedua_skor_cec[$kedua_i]++;
                                   }
                                   }
                                 }
                               }
                               else{
                                 $kedua_range_cec_l=0;
                                 $kedua_range_cec_r=0;
                                 for ($kedua_i=0;$kedua_i<count($id_klaster2);$kedua_i++){
                                     $kedua_skor_cec[$kedua_i]=0;
                                 }
                               }
                             //

                           // range nilai skor Produktivitas
                             //lbds
                             if($p_lbds!=""){
                                 $kedua_const_lbds=(max($kedua_lbds_r)-min($kedua_lbds_r))/10;
                                 $kedua_range_lbds_l=[];
                                 $kedua_range_lbds_init=min($kedua_lbds_r);
                                 $kedua_range_lbds_l[0]=min($kedua_lbds_r);
                                 $kedua_range_lbds_r=[];
                                 for ($kedua_i=1;$kedua_i<10;$kedua_i++){
                                   $kedua_range_lbds_init+=$kedua_const_lbds;
                                   $kedua_range_lbds_l[$kedua_i]=round($kedua_range_lbds_init,3);
                                   $kedua_range_lbds_r[$kedua_i]=round(($kedua_range_lbds_l[$kedua_i]-0.001),3);
                                 }
                                 $kedua_range_lbds_r[10]=round(max($kedua_lbds_r),3);

                                 for ($kedua_i=0; $kedua_i < count($id_klaster2); $kedua_i++) {
                                   $kedua_skor_lbds[$kedua_i]=1;
                                   for ($kedua_j=0; $kedua_j < count($kedua_range_lbds_l); $kedua_j++) {
                                     if($kedua_lbds_r[$kedua_i]>=$kedua_range_lbds_l[$kedua_j] && $kedua_lbds_r[$kedua_i]<=$kedua_range_lbds_r[$kedua_j+1]){
                                       break;
                                     }
                                     if($kedua_skor_lbds[$kedua_i]<10){
                                       $kedua_skor_lbds[$kedua_i]++;
                                     }
                                   }
                                 }
                               }
                               else{
                                 $kedua_range_lbds_l=0;
                                 $kedua_range_lbds_r=0;
                                 for ($kedua_i=0;$kedua_i<count($id_klaster2);$kedua_i++){
                                   $kedua_skor_lbds[$kedua_i]=0;
                               }
                             }

                             //volume_v
                             if($p_volume!=""){
                                 $kedua_const_volume=(max($kedua_volume_r)-min($kedua_volume_r))/10;
                                 $kedua_range_volume_l=[];
                                 $kedua_range_volume_init=min($kedua_volume_r);
                                 $kedua_range_volume_l[0]=min($kedua_volume_r);
                                 $kedua_range_volume_r=[];
                                 for ($kedua_i=1;$kedua_i<10;$kedua_i++){
                                   $kedua_range_volume_init+=$kedua_const_volume;
                                   $kedua_range_volume_l[$kedua_i]=round($kedua_range_volume_init,3);
                                   $kedua_range_volume_r[$kedua_i]=round(($kedua_range_volume_l[$kedua_i]-0.001),3);
                                 }
                                 $kedua_range_volume_r[10]=round(max($kedua_volume_r),3);

                                 for ($kedua_i=0; $kedua_i < count($id_klaster2); $kedua_i++) {
                                   $kedua_skor_volume[$kedua_i]=1;
                                   for ($kedua_j=0; $kedua_j < count($kedua_range_volume_l); $kedua_j++) {
                                     if($kedua_volume_r[$kedua_i]>=$kedua_range_volume_l[$kedua_j] && $kedua_volume_r[$kedua_i]<=$kedua_range_volume_r[$kedua_j+1]){
                                       break;
                                     }
                                     if($kedua_skor_volume[$kedua_i]<10){
                                       $kedua_skor_volume[$kedua_i]++;
                                     }

                                   }
                                 }
                               }
                               else{
                                 $kedua_range_volume_l=0;
                                 $kedua_range_volume_r=0;
                                 for ($kedua_i=0;$kedua_i<count($id_klaster2);$kedua_i++){
                                   $kedua_skor_volume[$kedua_i]=0;
                               }
                             }
                             //

                             // range nilai skor kerusakan
                             if($p_kerusakan!=""){
                                   $kedua_const_tli=(max($kedua_tli_r)-min($kedua_tli_r))/10;
                                   $kedua_range_tli_r=[];
                                   $kedua_range_tli_init=max($kedua_tli_r);
                                   $kedua_range_tli_r[0]=max($kedua_tli_r);
                                   $kedua_range_tli_l=[];
                                   for ($kedua_i=1;$kedua_i<10;$kedua_i++){
                                     $kedua_range_tli_init-=$kedua_const_tli;
                                     $kedua_range_tli_r[$kedua_i]=round($kedua_range_tli_init,3);
                                     $kedua_range_tli_l[$kedua_i]=round(($kedua_range_tli_r[$kedua_i]+0.001),3);
                                   }
                                   $kedua_range_tli_l[10]=round(min($kedua_tli_r),3);

                                   for ($kedua_i=0; $kedua_i < count($id_klaster2); $kedua_i++) {
                                     $kedua_skor_tli[$kedua_i]=0;
                                     for ($kedua_j=0; $kedua_j < count($kedua_range_tli_l); $kedua_j++) {
                                       if($kedua_skor_tli[$kedua_i]<10){
                                       $kedua_skor_tli[$kedua_i]++;
                                       }
                                       if($kedua_tli_r[$kedua_i]>=$kedua_range_tli_l[$kedua_j+1] && $kedua_tli_r[$kedua_i]<=$kedua_range_tli_r[$kedua_j]){
                                         break;
                                       }
                                     }
                                   }
                                 }
                                 else{
                                   $kedua_range_tli_l=0;
                                   $kedua_range_tli_r=0;
                                   for ($kedua_i=0;$kedua_i<count($id_klaster2);$kedua_i++){
                                     $kedua_skor_tli[$kedua_i]=0;
                                 }
                                 }
                               //
                               // range nilai skor tajuk
                               if($p_ktjk!=""){
                                     $kedua_const_vcr=(max($kedua_vcr_r)-min($kedua_vcr_r))/10;
                                     $kedua_range_vcr_l=[];
                                     $kedua_range_vcr_init=min($kedua_vcr_r);
                                     $kedua_range_vcr_l[0]=min($kedua_vcr_r);
                                     $kedua_range_vcr_r=[];
                                     for ($kedua_i=1;$kedua_i<10;$kedua_i++){
                                       $kedua_range_vcr_init+=$kedua_const_vcr;
                                       $kedua_range_vcr_l[$kedua_i]=round($kedua_range_vcr_init,3);
                                       $kedua_range_vcr_r[$kedua_i]=round(($kedua_range_vcr_l[$kedua_i]-0.001),3);
                                     }
                                     $kedua_range_vcr_r[10]=round(max($kedua_vcr_r),3);

                                     for ($kedua_i=0; $kedua_i < count($id_klaster2); $kedua_i++) {
                                       $kedua_skor_vcr[$kedua_i]=1;
                                       for ($kedua_j=0; $kedua_j < count($kedua_range_vcr_l); $kedua_j++) {
                                         if($kedua_vcr_r[$kedua_i]>=$kedua_range_vcr_l[$kedua_j] && $kedua_vcr_r[$kedua_i]<=$kedua_range_vcr_r[$kedua_j+1]){
                                           break;
                                         }
                                         if($kedua_skor_vcr[$kedua_i]<10){
                                           $kedua_skor_vcr[$kedua_i]++;
                                         }
                                       }
                                     }
                                   }
                               else{
                                 $kedua_range_vcr_l=0;
                                 $kedua_range_vcr_r=0;
                                 for ($kedua_i=0; $kedua_i < count($id_klaster2); $kedua_i++) {
                                   $kedua_skor_vcr[$kedua_i]=0;
                                 }
                               }
                                 //

                                 // range nilai skor h_aksen
                                 $kedua_const_h_aksen=0;
                                 if($haksenp!=""){
                                       $kedua_const_h_aksen=(max($kedua_h_aksen_klaster)-min($kedua_h_aksen_klaster))/10;
                                       $kedua_range_h_aksen_l=[];
                                       $kedua_range_h_aksen_init=min($kedua_h_aksen_klaster);
                                       $kedua_range_h_aksen_l[0]=min($kedua_h_aksen_klaster);
                                       $kedua_range_h_aksen_r=[];
                                       for ($kedua_i=1;$kedua_i<10;$kedua_i++){
                                         $kedua_range_h_aksen_init+=$kedua_const_h_aksen;
                                         $kedua_range_h_aksen_l[$kedua_i]=round($kedua_range_h_aksen_init,3);
                                         $kedua_range_h_aksen_r[$kedua_i]=round(($kedua_range_h_aksen_l[$kedua_i]-0.001),3);
                                       }
                                       $kedua_range_h_aksen_r[10]=round(max($kedua_h_aksen_klaster),3);

                                       for ($kedua_i=0; $kedua_i < count($id_klaster2); $kedua_i++) {
                                         $kedua_skor_h_aksen[$kedua_i]=1;
                                         for ($kedua_j=0; $kedua_j < count($kedua_range_h_aksen_l); $kedua_j++) {
                                           if($kedua_h_aksen_klaster[$kedua_i]>=$kedua_range_h_aksen_l[$kedua_j] && $kedua_h_aksen_klaster[$kedua_i]<=$kedua_range_h_aksen_r[$kedua_j+1]){
                                             break;
                                           }
                                           if($kedua_skor_h_aksen[$kedua_i]<10){
                                           $kedua_skor_h_aksen[$kedua_i]++;
                                         }
                                         }
                                       }
                                     }
                                     else{
                                       for($kedua_t=0;$kedua_t<=10;$kedua_t++){
                                         $kedua_range_h_aksen_l[$kedua_t]=0;
                                         $kedua_range_h_aksen_r[$kedua_t]=0;
                                       }
                                       for ($kedua_i=0; $kedua_i < count($id_klaster2); $kedua_i++) {
                                         $kedua_skor_h_aksen[$kedua_i]=0;
                                       }
                                     }
                                   //

                                   // range nilai skor j_pliup
                                   $kedua_const_j_pliu=0;
                                   if($p_jpliu!=""){
                                         $kedua_const_j_pliu=(max($kedua_j_pliu_klaster)-min($kedua_j_pliu_klaster))/10;
                                         $kedua_range_j_pliu_l=[];
                                         $kedua_range_j_pliu_init=min($kedua_j_pliu_klaster);
                                         $kedua_range_j_pliu_l[0]=min($kedua_j_pliu_klaster);
                                         $kedua_range_j_pliu_r=[];
                                         for ($kedua_i=1;$kedua_i<10;$kedua_i++){
                                           $kedua_range_j_pliu_init+=$kedua_const_j_pliu;
                                           $kedua_range_j_pliu_l[$kedua_i]=round($kedua_range_j_pliu_init,3);
                                           $kedua_range_j_pliu_r[$kedua_i]=round(($kedua_range_j_pliu_l[$kedua_i]-0.001),3);
                                         }
                                         $kedua_range_j_pliu_r[10]=round(max($kedua_j_pliu_klaster),3);

                                         for ($kedua_i=0; $kedua_i < count($id_klaster2); $kedua_i++) {
                                           $kedua_skor_j_pliu[$kedua_i]=1;
                                           for ($kedua_j=0; $kedua_j < count($kedua_range_j_pliu_l); $kedua_j++) {
                                             if($kedua_j_pliu_klaster[$kedua_i]>=$kedua_range_j_pliu_l[$kedua_j] && $kedua_j_pliu_klaster[$kedua_i]<=$kedua_range_j_pliu_r[$kedua_j+1]){
                                               break;
                                             }
                                             if($kedua_skor_j_pliu[$kedua_i]<10){
                                             $kedua_skor_j_pliu[$kedua_i]++;
                                           }
                                           }
                                         }
                                       }
                                       else{
                                         for($kedua_t=0;$kedua_t<=10;$kedua_t++){
                                           $kedua_range_j_pliu_l[$kedua_t]=0;
                                           $kedua_range_j_pliu_r[$kedua_t]=0;
                                         }
                                         for ($kedua_i=0; $kedua_i < count($id_klaster2); $kedua_i++) {
                                           $kedua_skor_j_pliu[$kedua_i]=0;
                                         }
                                       }
                                     //

                                     // range nilai skor d_mg
                                     $kedua_const_d_mg=0;
                                     if($p_dmg!=""){
                                           $kedua_const_d_mg=(max($kedua_d_mg)-min($kedua_d_mg))/10;
                                           $kedua_range_d_mg_l=[];
                                           $kedua_range_d_mg_init=min($kedua_d_mg);
                                           $kedua_range_d_mg_l[0]=min($kedua_d_mg);
                                           $kedua_range_d_mg_r=[];
                                           for ($kedua_i=1;$kedua_i<10;$kedua_i++){
                                             $kedua_range_d_mg_init+=$kedua_const_d_mg;
                                             $kedua_range_d_mg_l[$kedua_i]=round($kedua_range_d_mg_init,3);
                                             $kedua_range_d_mg_r[$kedua_i]=round(($kedua_range_d_mg_l[$kedua_i]-0.001),3);
                                           }
                                           $kedua_range_d_mg_r[10]=round(max($kedua_d_mg),3);

                                           for ($kedua_i=0; $kedua_i < count($id_klaster2); $kedua_i++) {
                                             $kedua_skor_d_mg[$kedua_i]=1;
                                             for ($kedua_j=0; $kedua_j < count($kedua_range_d_mg_l); $kedua_j++) {
                                               if($kedua_d_mg[$kedua_i]>=$kedua_range_d_mg_l[$kedua_j] && $kedua_d_mg[$kedua_i]<=$kedua_range_d_mg_r[$kedua_j+1]){
                                                 break;
                                               }
                                               if($kedua_skor_d_mg[$kedua_i]<10){
                                               $kedua_skor_d_mg[$kedua_i]++;
                                             }
                                             }
                                           }
                                         }
                                         else{
                                           for($kedua_t=0;$kedua_t<=10;$kedua_t++){
                                             $kedua_range_d_mg_l[$kedua_t]=0;
                                             $kedua_range_d_mg_r[$kedua_t]=0;
                                           }
                                           for ($kedua_i=0; $kedua_i < count($id_klaster2); $kedua_i++) {
                                             $kedua_skor_d_mg[$kedua_i]=0;
                                           }
                                         }
                                       //

                                   // range nilai skor h_aksenf
                                   if($haksenf!=""){
                                         $kedua_const_h_aksenf=(max($kedua_h_aksenf)-min($kedua_h_aksenf))/10;
                                         $kedua_range_h_aksen_lf=[];
                                         $kedua_range_h_aksen_initf=min($kedua_h_aksenf);
                                         $kedua_range_h_aksen_lf[0]=min($kedua_h_aksenf);
                                         $kedua_range_h_aksen_rf=[];
                                         for ($kedua_i=1;$kedua_i<10;$kedua_i++){
                                           $kedua_range_h_aksen_initf+=$kedua_const_h_aksenf;
                                           $kedua_range_h_aksen_lf[$kedua_i]=round($kedua_range_h_aksen_initf,3);
                                           $kedua_range_h_aksen_rf[$kedua_i]=round(($kedua_range_h_aksen_lf[$kedua_i]-0.001),3);
                                         }
                                         $kedua_range_h_aksen_rf[10]=round(max($kedua_h_aksenf),3);

                                         for ($kedua_i=0; $kedua_i < count($id_klaster2); $kedua_i++) {
                                           $kedua_skor_h_aksenf[$kedua_i]=1;
                                           for ($kedua_j=0; $kedua_j < count($kedua_range_h_aksen_lf); $kedua_j++) {
                                             if($kedua_h_aksenf[$kedua_i]>=$kedua_range_h_aksen_lf[$kedua_j] && $kedua_h_aksenf[$kedua_i]<=$kedua_range_h_aksen_rf[$kedua_j+1]){
                                               break;
                                             }
                                             if($kedua_skor_h_aksenf[$kedua_i]<10){
                                               $kedua_skor_h_aksenf[$kedua_i]++;
                                             }
                                           }
                                         }
                                       }
                                       else{
                                         $kedua_range_h_aksen_lf=0;
                                         $kedua_range_h_aksen_rf=0;
                                         for ($kedua_i=0; $kedua_i < count($id_klaster2); $kedua_i++) {
                                           $kedua_skor_h_aksenf[$kedua_i]=0;
                                         }
                                       }
                                     //

                                     // range nilai skor jpliuf
                                     if($p_jpliuf!=""){
                                           $kedua_const_j_pliuf=(max($kedua_j_pliuf)-min($kedua_j_pliuf))/10;
                                           $kedua_range_j_pliu_lf=[];
                                           $kedua_range_j_pliu_initf=min($kedua_j_pliuf);
                                           $kedua_range_j_pliu_lf[0]=min($kedua_j_pliuf);
                                           $kedua_range_j_pliu_rf=[];
                                           for ($kedua_i=1;$kedua_i<10;$kedua_i++){
                                             $kedua_range_j_pliu_initf+=$kedua_const_j_pliuf;
                                             $kedua_range_j_pliu_lf[$kedua_i]=round($kedua_range_j_pliu_initf,3);
                                             $kedua_range_j_pliu_rf[$kedua_i]=round(($kedua_range_j_pliu_lf[$kedua_i]-0.001),3);
                                           }
                                           $kedua_range_j_pliu_rf[10]=round(max($kedua_j_pliuf),3);

                                           for ($kedua_i=0; $kedua_i < count($id_klaster2); $kedua_i++) {
                                             $kedua_skor_j_pliuf[$kedua_i]=1;
                                             for ($kedua_j=0; $kedua_j < count($kedua_range_j_pliu_lf); $kedua_j++) {
                                               if($kedua_j_pliuf[$kedua_i]>=$kedua_range_j_pliu_lf[$kedua_j] && $kedua_j_pliuf[$kedua_i]<=$kedua_range_j_pliu_rf[$kedua_j+1]){
                                                 break;
                                               }
                                               if($kedua_skor_j_pliuf[$kedua_i]<10){
                                                 $kedua_skor_j_pliuf[$kedua_i]++;
                                               }
                                             }
                                           }
                                         }
                                         else{
                                           $kedua_range_j_pliu_lf=0;
                                           $kedua_range_j_pliu_rf=0;
                                           for ($kedua_i=0; $kedua_i < count($id_klaster2); $kedua_i++) {
                                             $kedua_skor_j_pliuf[$kedua_i]=0;
                                           }
                                         }
                                       //

                                       // range nilai skor dmgf
                                       if($p_dmgf!=""){
                                             $kedua_const_d_mgf=(max($kedua_d_mgf)-min($kedua_d_mgf))/10;
                                             $kedua_range_d_mg_lf=[];
                                             $kedua_range_d_mg_initf=min($kedua_d_mgf);
                                             $kedua_range_d_mg_lf[0]=min($kedua_d_mgf);
                                             $kedua_range_d_mg_rf=[];
                                             for ($kedua_i=1;$kedua_i<10;$kedua_i++){
                                               $kedua_range_d_mg_initf+=$kedua_const_d_mgf;
                                               $kedua_range_d_mg_lf[$kedua_i]=round($kedua_range_d_mg_initf,3);
                                               $kedua_range_d_mg_rf[$kedua_i]=round(($kedua_range_d_mg_lf[$kedua_i]-0.001),3);
                                             }
                                             $kedua_range_d_mg_rf[10]=round(max($kedua_d_mgf),3);

                                             for ($kedua_i=0; $kedua_i < count($id_klaster2); $kedua_i++) {
                                               $kedua_skor_d_mgf[$kedua_i]=1;
                                               for ($kedua_j=0; $kedua_j < count($kedua_range_d_mg_lf); $kedua_j++) {
                                                 if($kedua_d_mgf[$kedua_i]>=$kedua_range_d_mg_lf[$kedua_j] && $kedua_d_mgf[$kedua_i]<=$kedua_range_d_mg_rf[$kedua_j+1]){
                                                   break;
                                                 }
                                                 if($kedua_skor_d_mgf[$kedua_i]<10){
                                                   $kedua_skor_d_mgf[$kedua_i]++;
                                                 }
                                               }
                                             }
                                           }
                                           else{
                                             $kedua_range_d_mg_lf=0;
                                             $kedua_range_d_mg_rf=0;
                                             for ($kedua_i=0; $kedua_i < count($id_klaster2); $kedua_i++) {
                                               $kedua_skor_d_mgf[$kedua_i]=0;
                                             }
                                           }
                                         //

                                   // nilai Tertimbang
                                   for ($kedua_i=0; $kedua_i < count($id_klaster2); $kedua_i++) {

                                       $kedua_nt_kr=DB::table('nilai_tertimbang_copy')
                                       ->where('id_data_klaster','=',$id_klaster2[0]->id_data_klaster)->get();

                                       if(count($kedua_nt_kr)==0){
                                         $kedua_nt_ktpk[$kedua_i]=0.27;
                                         $kedua_nt_kerusakan[$kedua_i]=0.27;
                                         $kedua_nt_produktivitas[$kedua_i]=0.28;
                                         $kedua_nt_ktjk[$kedua_i]=0.23;
                                         $kedua_nt_biodiv[$kedua_i]=0.077;
                                         $kedua_nt_biodivf[$kedua_i]=0.077;
                                       }
                                       else{
                                         $kedua_nt_kr=DB::table('nilai_tertimbang_copy')
                                         ->where('id_data_klaster','=',$id_klaster2[0]->id_data_klaster)->first();
                                         $kedua_nt_ktpk[$kedua_i]=$kedua_nt_kr->nilai_ktpk;
                                         $kedua_nt_kerusakan[$kedua_i]=$kedua_nt_kr->nilai_kphn;
                                         $kedua_nt_produktivitas[$kedua_i]=$kedua_nt_kr->nilai_prod;
                                         $kedua_nt_ktjk[$kedua_i]=$kedua_nt_kr->nilai_ktjk;
                                         $kedua_nt_biodiv[$kedua_i]=$kedua_nt_kr->nilai_kjpb;
                                         $kedua_nt_biodivf[$kedua_i]=$kedua_nt_kr->nilai_kjfb;
                                       }



                                 }

                                   //  nilai akhir ktk kimia
                                   $kedua_na_total_cec[0] = 0;
                                   for ($kedua_i=0; $kedua_i < count($id_klaster2); $kedua_i++) {
                                     $kedua_na_cec[$kedua_i]=$kedua_skor_cec[$kedua_i]*$kedua_nt_ktpk[$kedua_i];
                                     $kedua_na_total_cec[0] += $kedua_na_cec[$kedua_i];
                                   }
                                   //  nilai akhir Produktivitas lbds
                                   $kedua_na_total_lbds[0] = 0;
                                   for ($kedua_i=0; $kedua_i < count($id_klaster2); $kedua_i++) {
                                     $kedua_na_lbds[$kedua_i]=$kedua_skor_lbds[$kedua_i]*$kedua_nt_produktivitas[$kedua_i];
                                     $kedua_na_total_lbds[0] += $kedua_na_lbds[$kedua_i];
                                   }
                                   $kedua_na_total_lbds[0] = $kedua_na_total_lbds[0]/$kedua_i;
                                   //  nilai akhir Produktivitas volume
                                   $kedua_na_total_volume[0] = 0;
                                   for ($kedua_i=0; $kedua_i < count($id_klaster2); $kedua_i++) {
                                     $kedua_na_volume[$kedua_i]=$kedua_skor_volume[$kedua_i]*$kedua_nt_produktivitas[$kedua_i];
                                     $kedua_na_total_volume[0] += $kedua_na_volume[$kedua_i];
                                   }
                                   $kedua_na_total_volume[0] = $kedua_na_total_volume[0]/$kedua_i;
                                   //  nilai akhir kerusakan pohon
                                   $kedua_na_total_kerusakan[0] = 0;
                                   for ($kedua_i=0; $kedua_i < count($id_klaster2); $kedua_i++) {
                                     $kedua_na_kerusakan[$kedua_i]=$kedua_skor_tli[$kedua_i]*$kedua_nt_kerusakan[$kedua_i];
                                     $kedua_na_total_kerusakan[0] += $kedua_na_kerusakan[$kedua_i];
                                   }
                                   $kedua_na_total_kerusakan[0] = $kedua_na_total_kerusakan[0]/$kedua_i;
                                   //  nilai akhir kondisi tajuk
                                   $kedua_na_total_tajuk[0] = 0;
                                   for ($kedua_i=0; $kedua_i < count($id_klaster2); $kedua_i++) {
                                     $kedua_na_tajuk[$kedua_i]=$kedua_skor_vcr[$kedua_i]*$kedua_nt_ktjk[$kedua_i];
                                     $kedua_na_total_tajuk[0] += $kedua_na_tajuk[$kedua_i];
                                   }
                                   $kedua_na_total_tajuk[0] = $kedua_na_total_tajuk[0]/$kedua_i;

                                   //  nilai akhir biodiversitas pohon haksen
                                   $kedua_na_total_biodiv_pohon[0] = 0;
                                   for ($kedua_i=0; $kedua_i < count($id_klaster2); $kedua_i++) {
                                     $kedua_na_biodiv_pohon[$kedua_i]=$kedua_skor_h_aksen[$kedua_i]*$kedua_nt_biodiv[$kedua_i];
                                     $kedua_na_total_biodiv_pohon[0] += $kedua_na_biodiv_pohon[$kedua_i];
                                   }
                                   $kedua_na_total_biodiv_pohon[0] = $kedua_na_total_biodiv_pohon[0]/$kedua_i;

                                   //  nilai akhir biodiversitas pohon jpliu
                                   $kedua_na_total_biodiv_pohon_jpliu[0] = 0;
                                   for ($kedua_i=0; $kedua_i < count($id_klaster2); $kedua_i++) {
                                     $kedua_na_biodiv_pohon_jpliu[$kedua_i]=$kedua_skor_j_pliu[$kedua_i]*$kedua_nt_biodiv[$kedua_i];
                                     $kedua_na_total_biodiv_pohon_jpliu[0] += $kedua_na_biodiv_pohon_jpliu[$kedua_i];
                                   }
                                   //  nilai akhir biodiversitas pohon dmg
                                   $kedua_na_total_biodiv_pohon_dmg[0] = 0;
                                   for ($kedua_i=0; $kedua_i < count($id_klaster2); $kedua_i++) {
                                     $kedua_na_biodiv_pohon_dmg[$kedua_i]=$kedua_skor_d_mg[$kedua_i]*$kedua_nt_biodiv[$kedua_i];
                                     $kedua_na_total_biodiv_pohon_dmg[0] += $kedua_na_biodiv_pohon_dmg[$kedua_i];
                                   }
                                   $kedua_na_total_biodiv_pohon_dmg[0] = $kedua_na_total_biodiv_pohon_dmg[0]/$kedua_i;

                                   //  nilai akhir biodiversitas fauna
                                   $kedua_na_total_biodiv_fauna[0] = 0;
                                   for ($kedua_i=0; $kedua_i < count($id_klaster2); $kedua_i++) {
                                     $kedua_na_biodiv_fauna[$kedua_i]=$kedua_skor_h_aksenf[$kedua_i]*$kedua_nt_biodivf[$kedua_i];
                                     $kedua_na_total_biodiv_fauna[0] += $kedua_na_biodiv_fauna[$kedua_i];
                                   }
                                   $kedua_na_total_biodiv_fauna[0] = $kedua_na_total_biodiv_fauna[0]/$kedua_i;

                                   $kedua_na_total_biodiv_fauna_jpliuf[0] = 0;
                                   for ($kedua_i=0; $kedua_i < count($id_klaster2); $kedua_i++) {
                                     $kedua_na_biodiv_fauna_jpliuf[$kedua_i]=$kedua_skor_j_pliuf[$kedua_i]*$kedua_nt_biodivf[$kedua_i];
                                     $kedua_na_total_biodiv_fauna_jpliuf[0] += $kedua_na_biodiv_fauna_jpliuf[$kedua_i];
                                   }
                                   $kedua_na_total_biodiv_fauna_jpliuf[0] = $kedua_na_total_biodiv_fauna_jpliuf[0]/$kedua_i;

                                   $kedua_na_total_biodiv_fauna_dmgf[0] = 0;
                                   for ($kedua_i=0; $kedua_i < count($id_klaster2); $kedua_i++) {
                                     $kedua_na_biodiv_fauna_dmgf[$kedua_i]=$kedua_skor_d_mgf[$kedua_i]*$kedua_nt_biodivf[$kedua_i];
                                     $kedua_na_total_biodiv_fauna_dmgf[0] += $kedua_na_biodiv_fauna_dmgf[$kedua_i];
                                   }
                                   $kedua_na_total_biodiv_fauna_dmgf[0] = $kedua_na_total_biodiv_fauna_dmgf[0]/$kedua_i;



                                   // nilai total indikator
                                   $kedua_na_seluruh[0] = 0;
                                   for ($kedua_i=0; $kedua_i < count($id_klaster2); $kedua_i++) {
                                     $kedua_na_total[$kedua_i]=$kedua_na_kerusakan[$kedua_i]+$kedua_na_tajuk[$kedua_i]+$kedua_na_biodiv_pohon[$kedua_i]+$kedua_na_biodiv_pohon_jpliu[$kedua_i]+$kedua_na_biodiv_pohon_dmg[$kedua_i]+$kedua_na_lbds[$kedua_i]+$kedua_na_volume[$kedua_i]+$kedua_na_biodiv_fauna[$kedua_i]+$kedua_na_biodiv_fauna_jpliuf[$kedua_i]+$kedua_na_cec[$kedua_i];
                                     $kedua_na_seluruh[0] += $kedua_na_total[$kedua_i];
                                   }
                                   $kedua_na_seluruh[0] = $kedua_na_seluruh[0]/$kedua_i;

                                   $ketiga_m=0;
                         $ketiga_tli_r=[];
                         $ketiga_vcr_r=[];
                         $ketiga_lbds_r=[];
                         $ketiga_volume_r=[];
                         $ketiga_cec_r=[];

                         for ($ketiga_i=0; $ketiga_i < count($id_klaster3); $ketiga_i++) {
                           // untuk mengetahui id klaster saat ini
                           $ketiga_id_cl=$id_klaster3[$ketiga_i]->id_klaster_plot;
                             $ketiga_id_pengukuran1=[];
                             $ketiga_plot=[];
                             $ketiga_tli_f=[];
                             $ketiga_vcr_f=[];
                             $ketiga_lbds_f=[];
                             $ketiga_volume_f=[];
                             $ketiga_cec_f=[];
                             // untuk menghitung banyaknya plot yang ada pengukuran
                             $ketiga_plot=DB::table('tbl_plot')
                             ->join('pengukuran_master','pengukuran_master.id_plot','=','tbl_plot.id_plot')
                             ->where('id_klaster_plot',$ketiga_id_cl)
                             ->where('pengukuran_ke','=',3)
                             ->get();

                             if(count($ketiga_plot)!=0){
                             for ($ketiga_j=0; $ketiga_j < count($ketiga_plot); $ketiga_j++) {
                               $ketiga_id_pengukuran=DB::table('pengukuran_master')->where([['id_plot',$ketiga_plot[$ketiga_j]->id_plot],['pengukuran_ke',3]])->get();
                               $ketiga_id_pengukuran1[$ketiga_j]=$ketiga_id_pengukuran[0]->id_pengukuran;

                             }

                           }
                           else{
                             // id pengukuran gak ada
                           }
                           $ketiga_tli_r[$ketiga_m]=0;
                           $ketiga_vcr_r[$ketiga_m]=0;
                           $ketiga_lbds_r[$ketiga_m]=0;
                           $ketiga_volume_r[$ketiga_m]=0;
                           $ketiga_cec_r[$ketiga_m]=0;
                           // kalo pengukurannya tidak kosong dalam satu klaster

                           if(count($ketiga_id_pengukuran1)!=0){
                             for ($ketiga_k=0; $ketiga_k < count($ketiga_id_pengukuran1); $ketiga_k++) {
                             $ketiga_tli=0;
                             $ketiga_vcr=0;
                             $ketiga_lbds=0;
                             $ketiga_volume=0;

                             //indikator kualitas Tapak
                             if($p_kimia!=""){

                               if($ketiga_sifat_kimia==""){
                                 $ketiga_cec_f[$ketiga_i]=0;
                               }
                               else{
                                 $ketiga_data_pengukuran_ktk_kimia= DB::table('ktk_kimia')
                                 ->where('kode_klaster','=',$ketiga_id_cl)
                                 ->where('pengukuran_ke','=',3)
                                 ->where('id_sifat','=',$ketiga_sifat_kimia)
                                 ->first();
                                 $ketiga_data_pengukuran_ktk_kimia= DB::table('ktk_kimia')
                                 ->where('kode_klaster','=',$ketiga_id_cl)
                                 ->where('pengukuran_ke','=',3)
                                 ->where('id_sifat','=',$ketiga_sifat_kimia)
                                 ->get();
                                 if(count($ketiga_data_pengukuran_ktk_kimia)!=0){
                                     $ketiga_cec_f[$ketiga_i]=$ketiga_data_pengukuran_ktk_kimia[0]->cec;
                                 }
                                 else{
                                   $ketiga_cec_f[$ketiga_i]=0;
                                 }
                               }

                             }
                             else{
                               $ketiga_cec_f[$ketiga_i]=0;
                             }

                             // indikator vitalitas
                             // untuk data pengukuran kerusakan
                             if($p_kerusakan!=""){
                               $ketiga_data_pengukuran=DB::table('pengukuran_master')
                                 ->join('kerusakan_pohon','kerusakan_pohon.id_pengukuran','=','pengukuran_master.id_pengukuran')
                                 ->select('tli')
                                 ->where('pengukuran_master.id_pengukuran',$ketiga_id_pengukuran1[$ketiga_k])->get();

                                 // untuk kerusakan
                                 if(count($ketiga_data_pengukuran)!=0){
                                   for ($ketiga_l=0; $ketiga_l < count ($ketiga_data_pengukuran); $ketiga_l++) {
                                     // nilai total tli plot
                                     $ketiga_tli+=$ketiga_data_pengukuran[$ketiga_l]->tli;
                                   }
                                   // nilai pli plot
                                   $ketiga_tli_f[$ketiga_k]=($ketiga_tli/count($ketiga_data_pengukuran));
                                 }
                                 else{
                                   $ketiga_tli_f[$ketiga_k]=0;
                                 }
                             }
                             else{
                               $ketiga_tli_f[$ketiga_k]=0;
                             }
                             //

                             // untuk data pengukuran tajuk
                             if($p_ktjk!=""){
                               $ketiga_data_pengukuran_tajuk=DB::table('pengukuran_master')
                                 ->join('kondisi_tajuk','kondisi_tajuk.id_pengukuran','=','pengukuran_master.id_pengukuran')
                                 ->select('vcri')
                                 ->where('pengukuran_master.id_pengukuran',$ketiga_id_pengukuran1[$ketiga_k])->get();
                                 // untuk tajuk
                                 if(count($ketiga_data_pengukuran_tajuk)!=0){
                                   for ($ketiga_l=0; $ketiga_l < count ($ketiga_data_pengukuran_tajuk); $ketiga_l++) {
                                     // nilai total vcr plot
                                     $ketiga_vcr+=$ketiga_data_pengukuran_tajuk[$ketiga_l]->vcri;
                                   }
                                   // nilai vcr plot
                                   $ketiga_vcr_f[$ketiga_k]=($ketiga_vcr/count($ketiga_data_pengukuran_tajuk));
                                 }
                                 else{
                                   $ketiga_vcr_f[$ketiga_k]=0;
                                 }
                             }
                             else{
                               $ketiga_vcr_f[$ketiga_k]=0;
                             }

                               // indikator produktivitas parameter lbds
                             if($p_lbds!=""){
                             $ketiga_data_pengukuran_lbds=DB::table('pengukuran_master')
                               ->join('lbds','lbds.id_pengukuran','=','pengukuran_master.id_pengukuran')
                               ->select('Hasil_LBDS','v')
                               ->where('pengukuran_master.id_pengukuran',$ketiga_id_pengukuran1[$ketiga_k])->get();
                               // untuk lbds
                               if(count($ketiga_data_pengukuran_lbds)!=0){
                               for ($ketiga_l=0; $ketiga_l < count ($ketiga_data_pengukuran_lbds); $ketiga_l++) {
                                 // nilai total lbds plot
                                 $ketiga_lbds+=$ketiga_data_pengukuran_lbds[$ketiga_l]->Hasil_LBDS;
                               }
                               // nilai lbds plot
                               $ketiga_lbds_f[$ketiga_k]=$ketiga_lbds;
                             }
                             else{
                               $ketiga_lbds_f[$ketiga_k]=0;
                             }
                            }
                            else{
                              $ketiga_lbds_f[$ketiga_k]=0;
                            }
                               //

                               // indikator produktivitas parameter volume
                               if($p_volume!=""){
                               $ketiga_data_pengukuran_volume=DB::table('pengukuran_master')
                               ->join('lbds','lbds.id_pengukuran','=','pengukuran_master.id_pengukuran')
                               ->select('Hasil_LBDS','v')
                               ->where('pengukuran_master.id_pengukuran',$ketiga_id_pengukuran1[$ketiga_k])->get();
                                // untuk volume
                                if(count($ketiga_data_pengukuran_volume)!=0){
                                for ($ketiga_l=0; $ketiga_l < count ($ketiga_data_pengukuran_volume); $ketiga_l++) {
                                  // nilai total volume_v plot
                                  $ketiga_volume+=$ketiga_data_pengukuran_volume[$ketiga_l]->v;
                                }
                                // nilai volume_v plot
                                $ketiga_volume_f[$ketiga_k]=$ketiga_volume;
                               }
                               else{
                                $ketiga_volume_f[$ketiga_k]=0;
                               }
                               }
                               else{
                               $ketiga_volume_f[$ketiga_k]=0;
                               }
                               //

                             //nilai total KTPK
                             $ketiga_cec_r[$ketiga_m]=$ketiga_cec_f[$ketiga_i];
                             // nilai total PLI
                             $ketiga_tli_r[$ketiga_m]+=$ketiga_tli_f[$ketiga_k];
                             // nilai total VCR
                             $ketiga_vcr_r[$ketiga_m]+=$ketiga_vcr_f[$ketiga_k];
                             // nilai total LBDS
                             $ketiga_lbds_r[$ketiga_m]+=$ketiga_lbds_f[$ketiga_k];
                             // nilai total Volume
                             $ketiga_volume_r[$ketiga_m]+=$ketiga_volume_f[$ketiga_k];
                           }

                           $ketiga_tli_r[$ketiga_m]=$ketiga_tli_r[$ketiga_m]/count($ketiga_id_pengukuran1);
                           $ketiga_vcr_r[$ketiga_m]=$ketiga_vcr_r[$ketiga_m]/count($ketiga_id_pengukuran1);
                           $ketiga_lbds_r[$ketiga_m]=$ketiga_lbds_r[$ketiga_m]/count($ketiga_id_pengukuran1);
                           $ketiga_volume_r[$ketiga_m]=$ketiga_volume_r[$ketiga_m]/count($ketiga_id_pengukuran1);
                             // hanya pembulatan
                             for ($ketiga_a=0;$ketiga_a<count($ketiga_id_pengukuran1);$ketiga_a++){
                               $ketiga_tli_f[$ketiga_a]=round(($ketiga_tli_f[$ketiga_a]),3);
                               $ketiga_vcr_f[$ketiga_a]=round(($ketiga_vcr_f[$ketiga_a]),3);
                               $ketiga_lbds_f[$ketiga_a]=round(($ketiga_lbds_f[$ketiga_a]),3);
                               $ketiga_volume_f[$ketiga_a]=round(($ketiga_volume_f[$ketiga_a]),3);
                             }
                           }
                           else{
                             if($ketiga_id_cl==""){
                               $ketiga_pesan= "Data pengukuran tidak tersedia";
                               return view('auditor.penilaian_kurang',[
                                 'pesan' => $ketiga_pesan,
                               ]);
                             }
                             else{
                               $ketiga_pesan= "Salah satu pengukuran tidak tersedia";
                               return view('auditor.pengukuran_kurang',[
                                 'pesan' => $ketiga_pesan,
                                 'id_klaster' => $ketiga_id_cl,
                               ]);
                             }

                           }

                             $ketiga_m++;

                             // data biodiversitas pohon
                             for($ketiga_q=0;$ketiga_q<count($ketiga_plot);$ketiga_q++){
                               $ketiga_j_pliu_klaster[$i]=0;
                             if($haksenp!="" || $p_jpliu!=""){
                               $ketiga_rata_h_aksen[$ketiga_i]=0;
                               $ketiga_data_biodiv_pohon[$ketiga_i] = DB::table('data_tanaman_plot')
                               ->where('id_plot','=',$ketiga_plot[$ketiga_q]->id_plot)
                               ->where('status','=','1')
                               ->where('pengukuran_ke','=',3)
                               ->get();
                               $ketiga_jumlah_pohon[$ketiga_i]=count($ketiga_data_biodiv_pohon[$ketiga_i]);
                               $ketiga_jenis_pohon[$ketiga_i]=DB::table('data_tanaman_plot')
                               ->select(DB::raw("data_tanaman_plot.id_master_jenis_tanaman, COUNT(*) as jumlah"))
                               ->where('data_tanaman_plot.id_plot','=',$ketiga_plot[$ketiga_q]->id_plot)
                               ->where('status','=','1')
                               ->where('pengukuran_ke','=',3)
                               ->groupBy(DB::raw('data_tanaman_plot.id_master_jenis_tanaman'))
                               ->get();

                               $ketiga_h_aksen[$ketiga_q]=0;
                               if($ketiga_jumlah_pohon[$ketiga_i]!=0){
                                 for($ketiga_o=0;$ketiga_o<count($ketiga_jenis_pohon[$ketiga_i]);$ketiga_o++){
                                   $ketiga_n[$ketiga_o]=$ketiga_jenis_pohon[$ketiga_i][$ketiga_o]->jumlah;
                                   $ketiga_ni[$ketiga_o]=$ketiga_n[$ketiga_o]/$ketiga_jumlah_pohon[$ketiga_i];
                                   $ketiga_ln_ni[$ketiga_o]=log($ketiga_ni[$ketiga_o]);
                                   $ketiga_ni_ln_ni[$ketiga_o]=$ketiga_ni[$ketiga_o]*$ketiga_ln_ni[$ketiga_o];
                                   $ketiga_h_aksen[$ketiga_q]-=$ketiga_ni_ln_ni[$ketiga_o];
                                 }

                                 //$ketiga_h_aksen[$ketiga_i]=$ketiga_h_aksen[$ketiga_i]/count($ketiga_jenis_pohon[$ketiga_i]);
                               }
                              }
                              else{
                                $ketiga_h_aksen[$ketiga_q]=0;
                              }
                            //   if($ketiga_i==1){
                            //   dd($ketiga_h_aksen);
                            // }
                              //

                               // dmg biodiversitas pohon
                               if($p_dmg!=""){
                                 $ketiga_h_aksen_klaster[$ketiga_i]=0;
                                 $ketiga_rata_h_aksen[$ketiga_i]=0;
                                 $ketiga_data_biodiv_pohon[$ketiga_i] = DB::table('data_tanaman_plot')
                                 ->where('id_plot','=',$ketiga_plot[$ketiga_q]->id_plot)
                                 ->where('status','=','1')
                                 ->where('pengukuran_ke','=',3)
                                 ->get();
                                 $ketiga_jumlah_pohon[$ketiga_i]=count($ketiga_data_biodiv_pohon[$ketiga_i]);
                                 $ketiga_jenis_pohon[$ketiga_i]=DB::table('data_tanaman_plot')
                                 ->select(DB::raw("data_tanaman_plot.id_master_jenis_tanaman, COUNT(*) as jumlah"))
                                 ->where('data_tanaman_plot.id_plot','=',$ketiga_plot[$ketiga_q]->id_plot)
                                 ->where('status','=','1')
                                 ->where('pengukuran_ke','=',3)
                                 ->groupBy(DB::raw('data_tanaman_plot.id_master_jenis_tanaman'))
                                 ->get();

                                 $ketiga_data_biodiv_pohon_klaster[$ketiga_i] = DB::table('data_tanaman_plot')
                                 ->where('id_klaster_plot','=',$id_klaster3[$ketiga_i]->id_klaster_plot)
                                 ->where('status','=','1')
                                 ->where('pengukuran_ke','=',3)
                                 ->get();
                                 $ketiga_jumlah_pohon_klaster[$ketiga_i]=count($ketiga_data_biodiv_pohon_klaster[$ketiga_i]);

                                 $ketiga_jenis_pohon_klaster[$ketiga_i]=DB::table('data_tanaman_plot')
                                 ->select(DB::raw("data_tanaman_plot.id_master_jenis_tanaman, COUNT(*) as jumlah"))
                                 ->where('data_tanaman_plot.id_klaster_plot','=',$id_klaster3[$ketiga_i]->id_klaster_plot)
                                 ->where('status','=','1')
                                 ->where('pengukuran_ke','=',3)
                                 ->groupBy(DB::raw('data_tanaman_plot.id_master_jenis_tanaman'))
                                 ->get();
                                 $ketiga_jml_jenis_klaster[$ketiga_i] = count($ketiga_jenis_pohon_klaster[$ketiga_i]);

                                 $ketiga_h_aksen[$ketiga_q]=0;
                                 $ketiga_d_mg[$ketiga_i]=0;
                                 if($ketiga_jumlah_pohon[$ketiga_i]!=0){
                                   $ketiga_jml_jenis[$ketiga_i] = count($ketiga_jenis_pohon[$ketiga_i]);
                                   for($ketiga_o=0;$ketiga_o<count($ketiga_jenis_pohon[$ketiga_i]);$ketiga_o++){
                                     $ketiga_n[$ketiga_o]=$ketiga_jenis_pohon[$ketiga_i][$ketiga_o]->jumlah;
                                     $ketiga_ni[$ketiga_o]=$ketiga_n[$ketiga_o]/$ketiga_jumlah_pohon[$ketiga_i];
                                     $ketiga_ln_ni[$ketiga_o]=log($ketiga_ni[$ketiga_o]);
                                     $ketiga_ni_ln_ni[$ketiga_o]=$ketiga_ni[$ketiga_o]*$ketiga_ln_ni[$ketiga_o];
                                     $ketiga_h_aksen[$ketiga_q]-=$ketiga_ni_ln_ni[$ketiga_o];
                                     $ketiga_rata_h_aksen[$ketiga_i]+=$ketiga_h_aksen[$ketiga_q];
                                   }

                                   if($ketiga_jumlah_pohon_klaster[$ketiga_i]>1){
                                     $ketiga_d_mg[$ketiga_i]=($ketiga_jml_jenis_klaster[$ketiga_i]-1)/log($ketiga_jumlah_pohon_klaster[$ketiga_i]);
                                   }
                                 }

                                }
                                else{
                                  $ketiga_d_mg[$ketiga_i]=0;
                                }
                              }
                                 // dd($ketiga_h_aksen);
                                 if($haksenp!=""){
                                     $ketiga_rata_h_aksen[$ketiga_i]=0;
                                     for($ketiga_v=0;$ketiga_v<4;$ketiga_v++){
                                     $ketiga_rata_h_aksen[$ketiga_i]+=$ketiga_h_aksen[$ketiga_v];
                                   }
                                   $ketiga_h_aksen_klaster[$ketiga_i]=$ketiga_rata_h_aksen[$ketiga_i]/4;
                                 }


                                if($p_jpliu!=""){
                                  $ketiga_rata_h_aksen[$ketiga_i]=0;
                                  for($ketiga_v=0;$ketiga_v<4;$ketiga_v++){
                                  $ketiga_rata_h_aksen[$ketiga_i]+=$ketiga_h_aksen[$ketiga_v];
                                }
                                 $ketiga_h_aksen_klaster[$ketiga_i]=$ketiga_rata_h_aksen[$ketiga_i]/4;

                                  $ketiga_jenis_pohon_klaster[$ketiga_i]=DB::table('data_tanaman_plot')
                                  ->select(DB::raw("data_tanaman_plot.id_master_jenis_tanaman, COUNT(*) as jumlah"))
                                  ->where('data_tanaman_plot.id_klaster_plot','=',$id_klaster3[$ketiga_i]->id_klaster_plot)
                                  ->where('status','=','1')
                                  ->where('pengukuran_ke','=',3)
                                  ->groupBy(DB::raw('data_tanaman_plot.id_master_jenis_tanaman'))
                                  ->get();
                                  $ketiga_jml_jenis_klaster[$ketiga_i] = count($ketiga_jenis_pohon_klaster[$ketiga_i]);

                                  if($ketiga_jml_jenis_klaster[$ketiga_i]>1){
                                    $ketiga_j_pliu_klaster[$ketiga_i]=$ketiga_h_aksen_klaster[$ketiga_i]/log($ketiga_jml_jenis_klaster[$ketiga_i]);
                                  }
                              }
                              else{
                                $ketiga_j_pliu_klaster[$i]=0;
                              }
                                //

                              // data biodiversitas fauna
                              if($haksenf!=""){
                                $ketiga_data_biodiv_fauna[$ketiga_i] = DB::table('data_fauna')
                                ->where('id_klaster_plot_fauna','=',$ketiga_id_cl)
                                ->where('pengukuran_ke','=',3)
                                ->get();
                                $ketiga_h_aksenf[$ketiga_i]=0;
                                if(count($ketiga_data_biodiv_fauna[$ketiga_i])!=0){
                                  $ketiga_total_fauna=0;
                                  $ketiga_tot_data_fauna[$ketiga_i]=count($ketiga_data_biodiv_fauna[$ketiga_i]);
                                  for($ketiga_s=0;$ketiga_s<$ketiga_tot_data_fauna[$ketiga_i];$ketiga_s++){
                                    $ketiga_total_fauna+=$ketiga_data_biodiv_fauna[$ketiga_i][$ketiga_s]->jumlah;
                                  }

                                  $ketiga_jumlah_fauna[$ketiga_i]=$ketiga_total_fauna;
                                  for($ketiga_t=0;$ketiga_t<$ketiga_tot_data_fauna[$ketiga_i];$ketiga_t++){
                                    $ketiga_nf[$ketiga_t]=$ketiga_data_biodiv_fauna[$ketiga_i][$ketiga_t]->jumlah;
                                    $ketiga_nif[$ketiga_t]=$ketiga_nf[$ketiga_t]/$ketiga_jumlah_fauna[$ketiga_i];
                                    $ketiga_ln_nif[$ketiga_t]=log($ketiga_nif[$ketiga_t]);
                                    $ketiga_ni_ln_nif[$ketiga_t]=$ketiga_nif[$ketiga_t]*$ketiga_ln_nif[$ketiga_t];
                                    $ketiga_h_aksenf[$ketiga_i]-=$ketiga_ni_ln_nif[$ketiga_t];
                                  }
                                  $ketiga_h_aksenf[$ketiga_i]=$ketiga_h_aksenf[$ketiga_i]/$ketiga_tot_data_fauna[$ketiga_i];
                                }
                             }
                             else{
                               $ketiga_h_aksenf[$ketiga_i]=0;
                             }

                             // data jpliu fauna
                             if($p_jpliuf!=""){
                               $ketiga_data_biodiv_fauna[$ketiga_i] = DB::table('data_fauna')
                               ->where('id_klaster_plot_fauna','=',$ketiga_id_cl)
                               ->where('pengukuran_ke','=',3)
                               ->get();
                               $ketiga_h_aksenf[$ketiga_i]=0;
                               $ketiga_j_pliuf[$ketiga_i]=0;
                               if(count($ketiga_data_biodiv_fauna[$ketiga_i])!=0){
                                 $ketiga_total_fauna=0;
                                 $ketiga_tot_data_fauna[$ketiga_i]=count($ketiga_data_biodiv_fauna[$ketiga_i]);
                                 for($ketiga_s=0;$ketiga_s<$ketiga_tot_data_fauna[$ketiga_i];$ketiga_s++){
                                   $ketiga_total_fauna+=$ketiga_data_biodiv_fauna[$ketiga_i][$ketiga_s]->jumlah;
                                 }

                                 $ketiga_jumlah_fauna[$ketiga_i]=$ketiga_total_fauna;
                                 for($ketiga_t=0;$ketiga_t<$ketiga_tot_data_fauna[$ketiga_i];$ketiga_t++){
                                   $ketiga_nf[$ketiga_t]=$ketiga_data_biodiv_fauna[$ketiga_i][$ketiga_t]->jumlah;
                                   $ketiga_nif[$ketiga_t]=$ketiga_nf[$ketiga_t]/$ketiga_jumlah_fauna[$ketiga_i];
                                   $ketiga_ln_nif[$ketiga_t]=log($ketiga_nif[$ketiga_t]);
                                   $ketiga_ni_ln_nif[$ketiga_t]=$ketiga_nif[$ketiga_t]*$ketiga_ln_nif[$ketiga_t];
                                   $ketiga_h_aksenf[$ketiga_i]-=$ketiga_ni_ln_nif[$ketiga_t];

                                   if($ketiga_tot_data_fauna[$ketiga_i]==0 || $ketiga_tot_data_fauna[$ketiga_i]==1 ){
                                     $ketiga_j_pliuf[$ketiga_i]+=0;
                                   }
                                   else{
                                     $ketiga_j_pliuf[$ketiga_i]+=-1*$ketiga_ni_ln_nif[$ketiga_t]/log($ketiga_tot_data_fauna[$ketiga_i]);
                                   }

                                 }
                                 $ketiga_j_pliuf[$ketiga_i]=$ketiga_j_pliuf[$ketiga_i]/$ketiga_tot_data_fauna[$ketiga_i];
                                 $ketiga_h_aksenf[$ketiga_i]=$ketiga_h_aksenf[$ketiga_i]/$ketiga_tot_data_fauna[$ketiga_i];
                               }
                            }
                            else{
                              $ketiga_j_pliuf[$ketiga_i]=0;
                            }

                            // data dmg fauna
                            if($p_dmgf!=""){
                              $ketiga_data_biodiv_fauna[$ketiga_i] = DB::table('data_fauna')
                              ->where('id_klaster_plot_fauna','=',$ketiga_id_cl)
                              ->where('pengukuran_ke','=',3)
                              ->get();
                              $ketiga_h_aksenf[$ketiga_i]=0;
                              $ketiga_d_mgf[$ketiga_i]=0;
                              if(count($ketiga_data_biodiv_fauna[$ketiga_i])!=0){
                                $ketiga_total_fauna=0;
                                $ketiga_tot_data_fauna[$ketiga_i]=count($ketiga_data_biodiv_fauna[$ketiga_i]);

                                for($ketiga_s=0;$ketiga_s<$ketiga_tot_data_fauna[$ketiga_i];$ketiga_s++){
                                  $ketiga_total_fauna+=$ketiga_data_biodiv_fauna[$ketiga_i][$ketiga_s]->jumlah;
                                }

                                $ketiga_jumlah_fauna[$ketiga_i]=$ketiga_total_fauna;
                                for($ketiga_t=0;$ketiga_t<$ketiga_tot_data_fauna[$ketiga_i];$ketiga_t++){
                                  $ketiga_nf[$ketiga_t]=$ketiga_data_biodiv_fauna[$ketiga_i][$ketiga_t]->jumlah;
                                  $ketiga_nif[$ketiga_t]=$ketiga_nf[$ketiga_t]/$ketiga_jumlah_fauna[$ketiga_i];
                                  $ketiga_ln_nif[$ketiga_t]=log($ketiga_nif[$ketiga_t]);
                                  $ketiga_ni_ln_nif[$ketiga_t]=$ketiga_nif[$ketiga_t]*$ketiga_ln_nif[$ketiga_t];
                                  $ketiga_h_aksenf[$ketiga_i]-=$ketiga_ni_ln_nif[$ketiga_t];
                                }
                                if($ketiga_tot_data_fauna[$ketiga_i]>1){
                                  $ketiga_h_aksenf[$ketiga_i]=$ketiga_h_aksenf[$ketiga_i]/$ketiga_tot_data_fauna[$ketiga_i];
                                }
                                if($ketiga_jumlah_fauna[$ketiga_i]>1){
                                  $ketiga_d_mgf[$ketiga_i]=($ketiga_tot_data_fauna[$ketiga_i]-1)/log($ketiga_jumlah_fauna[$ketiga_i]);
                                }
                              }
                           }
                           else{
                             $ketiga_d_mgf[$ketiga_i]=0;
                           }

                           }


                           // hanya pembulatan
                           for ($ketiga_a=0;$ketiga_a<count($ketiga_tli_r);$ketiga_a++){
                             $ketiga_cec_r[$ketiga_a]=round(($ketiga_cec_r[$ketiga_a]),3);
                             $ketiga_lbds_r[$ketiga_a]=round(($ketiga_lbds_r[$ketiga_a]),3);
                             $ketiga_volume_r[$ketiga_a]=round(($ketiga_volume_r[$ketiga_a]),3);
                             $ketiga_tli_r[$ketiga_a]=round(($ketiga_tli_r[$ketiga_a]),3);
                             $ketiga_vcr_r[$ketiga_a]=round(($ketiga_vcr_r[$ketiga_a]),3);
                             // $ketiga_h_aksen[$ketiga_a]=round($ketiga_h_aksen[$ketiga_a],3);
                             // $ketiga_j_pliu[$ketiga_a]=round($ketiga_j_pliu[$ketiga_a],3);
                             $ketiga_d_mg[$ketiga_a]=round($ketiga_d_mg[$ketiga_a],3);
                             $ketiga_h_aksenf[$ketiga_a]=round($ketiga_h_aksenf[$ketiga_a],3);
                             $ketiga_j_pliuf[$ketiga_a]=round($ketiga_j_pliuf[$ketiga_a],3);
                             $ketiga_d_mgf[$ketiga_a]=round($ketiga_d_mgf[$ketiga_a],3);
                             // $ketiga_h_aksen_klaster[$ketiga_a]=round($ketiga_h_aksen_klaster[$ketiga_a],3);
                             // $ketiga_j_pliu_klaster[$ketiga_a]=round($ketiga_j_pliu_klaster[$ketiga_a],3);
                           }

                           // range nilai skor Ktk kimia
                           if($p_kimia!=""){
                                 $ketiga_const_cec=(max($ketiga_cec_r)-min($ketiga_cec_r))/10;
                                 $ketiga_range_cec_l=[];
                                 $ketiga_range_cec_init=min($ketiga_cec_r);
                                 $ketiga_range_cec_l[0]=min($ketiga_cec_r);
                                 $ketiga_range_cec_r=[];
                                 for ($ketiga_i=1;$ketiga_i<10;$ketiga_i++){
                                   $ketiga_range_cec_init+=$ketiga_const_cec;
                                   $ketiga_range_cec_l[$ketiga_i]=round($ketiga_range_cec_init,3);
                                   $ketiga_range_cec_r[$ketiga_i]=round(($ketiga_range_cec_l[$ketiga_i]-0.001),3);
                                 }
                                 $ketiga_range_cec_r[10]=round(max($ketiga_cec_r),3);

                                 for ($ketiga_i=0; $ketiga_i < count($id_klaster3); $ketiga_i++) {
                                   $ketiga_skor_cec[$ketiga_i]=1;
                                   for ($ketiga_j=0; $ketiga_j < count($ketiga_range_cec_l); $ketiga_j++) {
                                     if($ketiga_cec_r[$ketiga_i]>=$ketiga_range_cec_l[$ketiga_j] && $ketiga_cec_r[$ketiga_i]<=$ketiga_range_cec_r[$ketiga_j+1]){
                                       break;
                                     }
                                     if($ketiga_skor_cec[$ketiga_i]<10){
                                     $ketiga_skor_cec[$ketiga_i]++;
                                   }
                                   }
                                 }
                               }
                               else{
                                 $ketiga_range_cec_l=0;
                                 $ketiga_range_cec_r=0;
                                 for ($ketiga_i=0;$ketiga_i<count($id_klaster3);$ketiga_i++){
                                     $ketiga_skor_cec[$ketiga_i]=0;
                                 }
                               }
                             //

                           // range nilai skor Produktivitas
                             //lbds
                             if($p_lbds!=""){
                                 $ketiga_const_lbds=(max($ketiga_lbds_r)-min($ketiga_lbds_r))/10;
                                 $ketiga_range_lbds_l=[];
                                 $ketiga_range_lbds_init=min($ketiga_lbds_r);
                                 $ketiga_range_lbds_l[0]=min($ketiga_lbds_r);
                                 $ketiga_range_lbds_r=[];
                                 for ($ketiga_i=1;$ketiga_i<10;$ketiga_i++){
                                   $ketiga_range_lbds_init+=$ketiga_const_lbds;
                                   $ketiga_range_lbds_l[$ketiga_i]=round($ketiga_range_lbds_init,3);
                                   $ketiga_range_lbds_r[$ketiga_i]=round(($ketiga_range_lbds_l[$ketiga_i]-0.001),3);
                                 }
                                 $ketiga_range_lbds_r[10]=round(max($ketiga_lbds_r),3);

                                 for ($ketiga_i=0; $ketiga_i < count($id_klaster3); $ketiga_i++) {
                                   $ketiga_skor_lbds[$ketiga_i]=1;
                                   for ($ketiga_j=0; $ketiga_j < count($ketiga_range_lbds_l); $ketiga_j++) {
                                     if($ketiga_lbds_r[$ketiga_i]>=$ketiga_range_lbds_l[$ketiga_j] && $ketiga_lbds_r[$ketiga_i]<=$ketiga_range_lbds_r[$ketiga_j+1]){
                                       break;
                                     }
                                     if($ketiga_skor_lbds[$ketiga_i]<10){
                                       $ketiga_skor_lbds[$ketiga_i]++;
                                     }
                                   }
                                 }
                               }
                               else{
                                 $ketiga_range_lbds_l=0;
                                 $ketiga_range_lbds_r=0;
                                 for ($ketiga_i=0;$ketiga_i<count($id_klaster3);$ketiga_i++){
                                   $ketiga_skor_lbds[$ketiga_i]=0;
                               }
                             }

                             //volume_v
                             if($p_volume!=""){
                                 $ketiga_const_volume=(max($ketiga_volume_r)-min($ketiga_volume_r))/10;
                                 $ketiga_range_volume_l=[];
                                 $ketiga_range_volume_init=min($ketiga_volume_r);
                                 $ketiga_range_volume_l[0]=min($ketiga_volume_r);
                                 $ketiga_range_volume_r=[];
                                 for ($ketiga_i=1;$ketiga_i<10;$ketiga_i++){
                                   $ketiga_range_volume_init+=$ketiga_const_volume;
                                   $ketiga_range_volume_l[$ketiga_i]=round($ketiga_range_volume_init,3);
                                   $ketiga_range_volume_r[$ketiga_i]=round(($ketiga_range_volume_l[$ketiga_i]-0.001),3);
                                 }
                                 $ketiga_range_volume_r[10]=round(max($ketiga_volume_r),3);

                                 for ($ketiga_i=0; $ketiga_i < count($id_klaster3); $ketiga_i++) {
                                   $ketiga_skor_volume[$ketiga_i]=1;
                                   for ($ketiga_j=0; $ketiga_j < count($ketiga_range_volume_l); $ketiga_j++) {
                                     if($ketiga_volume_r[$ketiga_i]>=$ketiga_range_volume_l[$ketiga_j] && $ketiga_volume_r[$ketiga_i]<=$ketiga_range_volume_r[$ketiga_j+1]){
                                       break;
                                     }
                                     if($ketiga_skor_volume[$ketiga_i]<10){
                                       $ketiga_skor_volume[$ketiga_i]++;
                                     }

                                   }
                                 }
                               }
                               else{
                                 $ketiga_range_volume_l=0;
                                 $ketiga_range_volume_r=0;
                                 for ($ketiga_i=0;$ketiga_i<count($id_klaster3);$ketiga_i++){
                                   $ketiga_skor_volume[$ketiga_i]=0;
                               }
                             }
                             //

                             // range nilai skor kerusakan
                             if($p_kerusakan!=""){
                                   $ketiga_const_tli=(max($ketiga_tli_r)-min($ketiga_tli_r))/10;
                                   $ketiga_range_tli_r=[];
                                   $ketiga_range_tli_init=max($ketiga_tli_r);
                                   $ketiga_range_tli_r[0]=max($ketiga_tli_r);
                                   $ketiga_range_tli_l=[];
                                   for ($ketiga_i=1;$ketiga_i<10;$ketiga_i++){
                                     $ketiga_range_tli_init-=$ketiga_const_tli;
                                     $ketiga_range_tli_r[$ketiga_i]=round($ketiga_range_tli_init,3);
                                     $ketiga_range_tli_l[$ketiga_i]=round(($ketiga_range_tli_r[$ketiga_i]+0.001),3);
                                   }
                                   $ketiga_range_tli_l[10]=round(min($ketiga_tli_r),3);

                                   for ($ketiga_i=0; $ketiga_i < count($id_klaster3); $ketiga_i++) {
                                     $ketiga_skor_tli[$ketiga_i]=0;
                                     for ($ketiga_j=0; $ketiga_j < count($ketiga_range_tli_l); $ketiga_j++) {
                                       if($ketiga_skor_tli[$ketiga_i]<10){
                                       $ketiga_skor_tli[$ketiga_i]++;
                                       }
                                       if($ketiga_tli_r[$ketiga_i]>=$ketiga_range_tli_l[$ketiga_j+1] && $ketiga_tli_r[$ketiga_i]<=$ketiga_range_tli_r[$ketiga_j]){
                                         break;
                                       }
                                     }
                                   }
                                 }
                                 else{
                                   $ketiga_range_tli_l=0;
                                   $ketiga_range_tli_r=0;
                                   for ($ketiga_i=0;$ketiga_i<count($id_klaster3);$ketiga_i++){
                                     $ketiga_skor_tli[$ketiga_i]=0;
                                 }
                                 }
                               //
                               // range nilai skor tajuk
                               if($p_ktjk!=""){
                                     $ketiga_const_vcr=(max($ketiga_vcr_r)-min($ketiga_vcr_r))/10;
                                     $ketiga_range_vcr_l=[];
                                     $ketiga_range_vcr_init=min($ketiga_vcr_r);
                                     $ketiga_range_vcr_l[0]=min($ketiga_vcr_r);
                                     $ketiga_range_vcr_r=[];
                                     for ($ketiga_i=1;$ketiga_i<10;$ketiga_i++){
                                       $ketiga_range_vcr_init+=$ketiga_const_vcr;
                                       $ketiga_range_vcr_l[$ketiga_i]=round($ketiga_range_vcr_init,3);
                                       $ketiga_range_vcr_r[$ketiga_i]=round(($ketiga_range_vcr_l[$ketiga_i]-0.001),3);
                                     }
                                     $ketiga_range_vcr_r[10]=round(max($ketiga_vcr_r),3);

                                     for ($ketiga_i=0; $ketiga_i < count($id_klaster3); $ketiga_i++) {
                                       $ketiga_skor_vcr[$ketiga_i]=1;
                                       for ($ketiga_j=0; $ketiga_j < count($ketiga_range_vcr_l); $ketiga_j++) {
                                         if($ketiga_vcr_r[$ketiga_i]>=$ketiga_range_vcr_l[$ketiga_j] && $ketiga_vcr_r[$ketiga_i]<=$ketiga_range_vcr_r[$ketiga_j+1]){
                                           break;
                                         }
                                         if($ketiga_skor_vcr[$ketiga_i]<10){
                                           $ketiga_skor_vcr[$ketiga_i]++;
                                         }
                                       }
                                     }
                                   }
                               else{
                                 $ketiga_range_vcr_l=0;
                                 $ketiga_range_vcr_r=0;
                                 for ($ketiga_i=0; $ketiga_i < count($id_klaster3); $ketiga_i++) {
                                   $ketiga_skor_vcr[$ketiga_i]=0;
                                 }
                               }
                                 //

                                 // range nilai skor h_aksen
                                 $ketiga_const_h_aksen=0;
                                 if($haksenp!=""){
                                       $ketiga_const_h_aksen=(max($ketiga_h_aksen_klaster)-min($ketiga_h_aksen_klaster))/10;
                                       $ketiga_range_h_aksen_l=[];
                                       $ketiga_range_h_aksen_init=min($ketiga_h_aksen_klaster);
                                       $ketiga_range_h_aksen_l[0]=min($ketiga_h_aksen_klaster);
                                       $ketiga_range_h_aksen_r=[];
                                       for ($ketiga_i=1;$ketiga_i<10;$ketiga_i++){
                                         $ketiga_range_h_aksen_init+=$ketiga_const_h_aksen;
                                         $ketiga_range_h_aksen_l[$ketiga_i]=round($ketiga_range_h_aksen_init,3);
                                         $ketiga_range_h_aksen_r[$ketiga_i]=round(($ketiga_range_h_aksen_l[$ketiga_i]-0.001),3);
                                       }
                                       $ketiga_range_h_aksen_r[10]=round(max($ketiga_h_aksen_klaster),3);

                                       for ($ketiga_i=0; $ketiga_i < count($id_klaster3); $ketiga_i++) {
                                         $ketiga_skor_h_aksen[$ketiga_i]=1;
                                         for ($ketiga_j=0; $ketiga_j < count($ketiga_range_h_aksen_l); $ketiga_j++) {
                                           if($ketiga_h_aksen_klaster[$ketiga_i]>=$ketiga_range_h_aksen_l[$ketiga_j] && $ketiga_h_aksen_klaster[$ketiga_i]<=$ketiga_range_h_aksen_r[$ketiga_j+1]){
                                             break;
                                           }
                                           if($ketiga_skor_h_aksen[$ketiga_i]<10){
                                           $ketiga_skor_h_aksen[$ketiga_i]++;
                                         }
                                         }
                                       }
                                     }
                                     else{
                                       for($ketiga_t=0;$ketiga_t<=10;$ketiga_t++){
                                         $ketiga_range_h_aksen_l[$ketiga_t]=0;
                                         $ketiga_range_h_aksen_r[$ketiga_t]=0;
                                       }
                                       for ($ketiga_i=0; $ketiga_i < count($id_klaster3); $ketiga_i++) {
                                         $ketiga_skor_h_aksen[$ketiga_i]=0;
                                       }
                                     }
                                   //

                                   // range nilai skor j_pliup
                                   $ketiga_const_j_pliu=0;
                                   if($p_jpliu!=""){
                                         $ketiga_const_j_pliu=(max($ketiga_j_pliu_klaster)-min($ketiga_j_pliu_klaster))/10;
                                         $ketiga_range_j_pliu_l=[];
                                         $ketiga_range_j_pliu_init=min($ketiga_j_pliu_klaster);
                                         $ketiga_range_j_pliu_l[0]=min($ketiga_j_pliu_klaster);
                                         $ketiga_range_j_pliu_r=[];
                                         for ($ketiga_i=1;$ketiga_i<10;$ketiga_i++){
                                           $ketiga_range_j_pliu_init+=$ketiga_const_j_pliu;
                                           $ketiga_range_j_pliu_l[$ketiga_i]=round($ketiga_range_j_pliu_init,3);
                                           $ketiga_range_j_pliu_r[$ketiga_i]=round(($ketiga_range_j_pliu_l[$ketiga_i]-0.001),3);
                                         }
                                         $ketiga_range_j_pliu_r[10]=round(max($ketiga_j_pliu_klaster),3);

                                         for ($ketiga_i=0; $ketiga_i < count($id_klaster3); $ketiga_i++) {
                                           $ketiga_skor_j_pliu[$ketiga_i]=1;
                                           for ($ketiga_j=0; $ketiga_j < count($ketiga_range_j_pliu_l); $ketiga_j++) {
                                             if($ketiga_j_pliu_klaster[$ketiga_i]>=$ketiga_range_j_pliu_l[$ketiga_j] && $ketiga_j_pliu_klaster[$ketiga_i]<=$ketiga_range_j_pliu_r[$ketiga_j+1]){
                                               break;
                                             }
                                             if($ketiga_skor_j_pliu[$ketiga_i]<10){
                                             $ketiga_skor_j_pliu[$ketiga_i]++;
                                           }
                                           }
                                         }
                                       }
                                       else{
                                         for($ketiga_t=0;$ketiga_t<=10;$ketiga_t++){
                                           $ketiga_range_j_pliu_l[$ketiga_t]=0;
                                           $ketiga_range_j_pliu_r[$ketiga_t]=0;
                                         }
                                         for ($ketiga_i=0; $ketiga_i < count($id_klaster3); $ketiga_i++) {
                                           $ketiga_skor_j_pliu[$ketiga_i]=0;
                                         }
                                       }
                                     //

                                     // range nilai skor d_mg
                                     $ketiga_const_d_mg=0;
                                     if($p_dmg!=""){
                                           $ketiga_const_d_mg=(max($ketiga_d_mg)-min($ketiga_d_mg))/10;
                                           $ketiga_range_d_mg_l=[];
                                           $ketiga_range_d_mg_init=min($ketiga_d_mg);
                                           $ketiga_range_d_mg_l[0]=min($ketiga_d_mg);
                                           $ketiga_range_d_mg_r=[];
                                           for ($ketiga_i=1;$ketiga_i<10;$ketiga_i++){
                                             $ketiga_range_d_mg_init+=$ketiga_const_d_mg;
                                             $ketiga_range_d_mg_l[$ketiga_i]=round($ketiga_range_d_mg_init,3);
                                             $ketiga_range_d_mg_r[$ketiga_i]=round(($ketiga_range_d_mg_l[$ketiga_i]-0.001),3);
                                           }
                                           $ketiga_range_d_mg_r[10]=round(max($ketiga_d_mg),3);

                                           for ($ketiga_i=0; $ketiga_i < count($id_klaster3); $ketiga_i++) {
                                             $ketiga_skor_d_mg[$ketiga_i]=1;
                                             for ($ketiga_j=0; $ketiga_j < count($ketiga_range_d_mg_l); $ketiga_j++) {
                                               if($ketiga_d_mg[$ketiga_i]>=$ketiga_range_d_mg_l[$ketiga_j] && $ketiga_d_mg[$ketiga_i]<=$ketiga_range_d_mg_r[$ketiga_j+1]){
                                                 break;
                                               }
                                               if($ketiga_skor_d_mg[$ketiga_i]<10){
                                               $ketiga_skor_d_mg[$ketiga_i]++;
                                             }
                                             }
                                           }
                                         }
                                         else{
                                           for($ketiga_t=0;$ketiga_t<=10;$ketiga_t++){
                                             $ketiga_range_d_mg_l[$ketiga_t]=0;
                                             $ketiga_range_d_mg_r[$ketiga_t]=0;
                                           }
                                           for ($ketiga_i=0; $ketiga_i < count($id_klaster3); $ketiga_i++) {
                                             $ketiga_skor_d_mg[$ketiga_i]=0;
                                           }
                                         }
                                       //

                                   // range nilai skor h_aksenf
                                   if($haksenf!=""){
                                         $ketiga_const_h_aksenf=(max($ketiga_h_aksenf)-min($ketiga_h_aksenf))/10;
                                         $ketiga_range_h_aksen_lf=[];
                                         $ketiga_range_h_aksen_initf=min($ketiga_h_aksenf);
                                         $ketiga_range_h_aksen_lf[0]=min($ketiga_h_aksenf);
                                         $ketiga_range_h_aksen_rf=[];
                                         for ($ketiga_i=1;$ketiga_i<10;$ketiga_i++){
                                           $ketiga_range_h_aksen_initf+=$ketiga_const_h_aksenf;
                                           $ketiga_range_h_aksen_lf[$ketiga_i]=round($ketiga_range_h_aksen_initf,3);
                                           $ketiga_range_h_aksen_rf[$ketiga_i]=round(($ketiga_range_h_aksen_lf[$ketiga_i]-0.001),3);
                                         }
                                         $ketiga_range_h_aksen_rf[10]=round(max($ketiga_h_aksenf),3);

                                         for ($ketiga_i=0; $ketiga_i < count($id_klaster3); $ketiga_i++) {
                                           $ketiga_skor_h_aksenf[$ketiga_i]=1;
                                           for ($ketiga_j=0; $ketiga_j < count($ketiga_range_h_aksen_lf); $ketiga_j++) {
                                             if($ketiga_h_aksenf[$ketiga_i]>=$ketiga_range_h_aksen_lf[$ketiga_j] && $ketiga_h_aksenf[$ketiga_i]<=$ketiga_range_h_aksen_rf[$ketiga_j+1]){
                                               break;
                                             }
                                             if($ketiga_skor_h_aksenf[$ketiga_i]<10){
                                               $ketiga_skor_h_aksenf[$ketiga_i]++;
                                             }
                                           }
                                         }
                                       }
                                       else{
                                         $ketiga_range_h_aksen_lf=0;
                                         $ketiga_range_h_aksen_rf=0;
                                         for ($ketiga_i=0; $ketiga_i < count($id_klaster3); $ketiga_i++) {
                                           $ketiga_skor_h_aksenf[$ketiga_i]=0;
                                         }
                                       }
                                     //

                                     // range nilai skor jpliuf
                                     if($p_jpliuf!=""){
                                           $ketiga_const_j_pliuf=(max($ketiga_j_pliuf)-min($ketiga_j_pliuf))/10;
                                           $ketiga_range_j_pliu_lf=[];
                                           $ketiga_range_j_pliu_initf=min($ketiga_j_pliuf);
                                           $ketiga_range_j_pliu_lf[0]=min($ketiga_j_pliuf);
                                           $ketiga_range_j_pliu_rf=[];
                                           for ($ketiga_i=1;$ketiga_i<10;$ketiga_i++){
                                             $ketiga_range_j_pliu_initf+=$ketiga_const_j_pliuf;
                                             $ketiga_range_j_pliu_lf[$ketiga_i]=round($ketiga_range_j_pliu_initf,3);
                                             $ketiga_range_j_pliu_rf[$ketiga_i]=round(($ketiga_range_j_pliu_lf[$ketiga_i]-0.001),3);
                                           }
                                           $ketiga_range_j_pliu_rf[10]=round(max($ketiga_j_pliuf),3);

                                           for ($ketiga_i=0; $ketiga_i < count($id_klaster3); $ketiga_i++) {
                                             $ketiga_skor_j_pliuf[$ketiga_i]=1;
                                             for ($ketiga_j=0; $ketiga_j < count($ketiga_range_j_pliu_lf); $ketiga_j++) {
                                               if($ketiga_j_pliuf[$ketiga_i]>=$ketiga_range_j_pliu_lf[$ketiga_j] && $ketiga_j_pliuf[$ketiga_i]<=$ketiga_range_j_pliu_rf[$ketiga_j+1]){
                                                 break;
                                               }
                                               if($ketiga_skor_j_pliuf[$ketiga_i]<10){
                                                 $ketiga_skor_j_pliuf[$ketiga_i]++;
                                               }
                                             }
                                           }
                                         }
                                         else{
                                           $ketiga_range_j_pliu_lf=0;
                                           $ketiga_range_j_pliu_rf=0;
                                           for ($ketiga_i=0; $ketiga_i < count($id_klaster3); $ketiga_i++) {
                                             $ketiga_skor_j_pliuf[$ketiga_i]=0;
                                           }
                                         }
                                       //

                                       // range nilai skor dmgf
                                       if($p_dmgf!=""){
                                             $ketiga_const_d_mgf=(max($ketiga_d_mgf)-min($ketiga_d_mgf))/10;
                                             $ketiga_range_d_mg_lf=[];
                                             $ketiga_range_d_mg_initf=min($ketiga_d_mgf);
                                             $ketiga_range_d_mg_lf[0]=min($ketiga_d_mgf);
                                             $ketiga_range_d_mg_rf=[];
                                             for ($ketiga_i=1;$ketiga_i<10;$ketiga_i++){
                                               $ketiga_range_d_mg_initf+=$ketiga_const_d_mgf;
                                               $ketiga_range_d_mg_lf[$ketiga_i]=round($ketiga_range_d_mg_initf,3);
                                               $ketiga_range_d_mg_rf[$ketiga_i]=round(($ketiga_range_d_mg_lf[$ketiga_i]-0.001),3);
                                             }
                                             $ketiga_range_d_mg_rf[10]=round(max($ketiga_d_mgf),3);

                                             for ($ketiga_i=0; $ketiga_i < count($id_klaster3); $ketiga_i++) {
                                               $ketiga_skor_d_mgf[$ketiga_i]=1;
                                               for ($ketiga_j=0; $ketiga_j < count($ketiga_range_d_mg_lf); $ketiga_j++) {
                                                 if($ketiga_d_mgf[$ketiga_i]>=$ketiga_range_d_mg_lf[$ketiga_j] && $ketiga_d_mgf[$ketiga_i]<=$ketiga_range_d_mg_rf[$ketiga_j+1]){
                                                   break;
                                                 }
                                                 if($ketiga_skor_d_mgf[$ketiga_i]<10){
                                                   $ketiga_skor_d_mgf[$ketiga_i]++;
                                                 }
                                               }
                                             }
                                           }
                                           else{
                                             $ketiga_range_d_mg_lf=0;
                                             $ketiga_range_d_mg_rf=0;
                                             for ($ketiga_i=0; $ketiga_i < count($id_klaster3); $ketiga_i++) {
                                               $ketiga_skor_d_mgf[$ketiga_i]=0;
                                             }
                                           }
                                         //

                                   // nilai Tertimbang
                                   for ($ketiga_i=0; $ketiga_i < count($id_klaster3); $ketiga_i++) {

                                       $ketiga_nt_kr=DB::table('nilai_tertimbang_copy')
                                       ->where('id_data_klaster','=',$id_klaster3[0]->id_data_klaster)->get();

                                       if(count($ketiga_nt_kr)==0){
                                         $ketiga_nt_ktpk[$ketiga_i]=0.27;
                                         $ketiga_nt_kerusakan[$ketiga_i]=0.27;
                                         $ketiga_nt_produktivitas[$ketiga_i]=0.28;
                                         $ketiga_nt_ktjk[$ketiga_i]=0.23;
                                         $ketiga_nt_biodiv[$ketiga_i]=0.077;
                                         $ketiga_nt_biodivf[$ketiga_i]=0.077;
                                       }
                                       else{
                                         $ketiga_nt_kr=DB::table('nilai_tertimbang_copy')
                                         ->where('id_data_klaster','=',$id_klaster3[0]->id_data_klaster)->first();
                                         $ketiga_nt_ktpk[$ketiga_i]=$ketiga_nt_kr->nilai_ktpk;
                                         $ketiga_nt_kerusakan[$ketiga_i]=$ketiga_nt_kr->nilai_kphn;
                                         $ketiga_nt_produktivitas[$ketiga_i]=$ketiga_nt_kr->nilai_prod;
                                         $ketiga_nt_ktjk[$ketiga_i]=$ketiga_nt_kr->nilai_ktjk;
                                         $ketiga_nt_biodiv[$ketiga_i]=$ketiga_nt_kr->nilai_kjpb;
                                         $ketiga_nt_biodivf[$ketiga_i]=$ketiga_nt_kr->nilai_kjfb;
                                       }

                                 }

                                   //  nilai akhir ktk kimia
                                   $ketiga_na_total_cec[0] = 0;
                                   for ($ketiga_i=0; $ketiga_i < count($id_klaster3); $ketiga_i++) {
                                     $ketiga_na_cec[$ketiga_i]=$ketiga_skor_cec[$ketiga_i]*$ketiga_nt_ktpk[$ketiga_i];
                                     $ketiga_na_total_cec[0] += $ketiga_na_cec[$ketiga_i];
                                   }
                                   //  nilai akhir Produktivitas lbds
                                   $ketiga_na_total_lbds[0] = 0;
                                   for ($ketiga_i=0; $ketiga_i < count($id_klaster3); $ketiga_i++) {
                                     $ketiga_na_lbds[$ketiga_i]=$ketiga_skor_lbds[$ketiga_i]*$ketiga_nt_produktivitas[$ketiga_i];
                                     $ketiga_na_total_lbds[0] += $ketiga_na_lbds[$ketiga_i];
                                   }
                                   $ketiga_na_total_lbds[0] = $ketiga_na_total_lbds[0]/$ketiga_i;
                                   //  nilai akhir Produktivitas volume
                                   $ketiga_na_total_volume[0] = 0;
                                   for ($ketiga_i=0; $ketiga_i < count($id_klaster3); $ketiga_i++) {
                                     $ketiga_na_volume[$ketiga_i]=$ketiga_skor_volume[$ketiga_i]*$ketiga_nt_produktivitas[$ketiga_i];
                                     $ketiga_na_total_volume[0] += $ketiga_na_volume[$ketiga_i];
                                   }
                                   $ketiga_na_total_volume[0] = $ketiga_na_total_volume[0]/$ketiga_i;
                                   //  nilai akhir kerusakan pohon
                                   $ketiga_na_total_kerusakan[0] = 0;
                                   for ($ketiga_i=0; $ketiga_i < count($id_klaster3); $ketiga_i++) {
                                     $ketiga_na_kerusakan[$ketiga_i]=$ketiga_skor_tli[$ketiga_i]*$ketiga_nt_kerusakan[$ketiga_i];
                                     $ketiga_na_total_kerusakan[0] += $ketiga_na_kerusakan[$ketiga_i];
                                   }
                                   $ketiga_na_total_kerusakan[0] = $ketiga_na_total_kerusakan[0]/$ketiga_i;
                                   //  nilai akhir kondisi tajuk
                                   $ketiga_na_total_tajuk[0] = 0;
                                   for ($ketiga_i=0; $ketiga_i < count($id_klaster3); $ketiga_i++) {
                                     $ketiga_na_tajuk[$ketiga_i]=$ketiga_skor_vcr[$ketiga_i]*$ketiga_nt_ktjk[$ketiga_i];
                                     $ketiga_na_total_tajuk[0] += $ketiga_na_tajuk[$ketiga_i];
                                   }
                                   $ketiga_na_total_tajuk[0] = $ketiga_na_total_tajuk[0]/$ketiga_i;

                                   //  nilai akhir biodiversitas pohon haksen
                                   $ketiga_na_total_biodiv_pohon[0] = 0;
                                   for ($ketiga_i=0; $ketiga_i < count($id_klaster3); $ketiga_i++) {
                                     $ketiga_na_biodiv_pohon[$ketiga_i]=$ketiga_skor_h_aksen[$ketiga_i]*$ketiga_nt_biodiv[$ketiga_i];
                                     $ketiga_na_total_biodiv_pohon[0] += $ketiga_na_biodiv_pohon[$ketiga_i];
                                   }
                                   $ketiga_na_total_biodiv_pohon[0] = $ketiga_na_total_biodiv_pohon[0]/$ketiga_i;

                                   //  nilai akhir biodiversitas pohon jpliu
                                   $ketiga_na_total_biodiv_pohon_jpliu[0] = 0;
                                   for ($ketiga_i=0; $ketiga_i < count($id_klaster3); $ketiga_i++) {
                                     $ketiga_na_biodiv_pohon_jpliu[$ketiga_i]=$ketiga_skor_j_pliu[$ketiga_i]*$ketiga_nt_biodiv[$ketiga_i];
                                     $ketiga_na_total_biodiv_pohon_jpliu[0] += $ketiga_na_biodiv_pohon_jpliu[$ketiga_i];
                                   }
                                   //  nilai akhir biodiversitas pohon dmg
                                   $ketiga_na_total_biodiv_pohon_dmg[0] = 0;
                                   for ($ketiga_i=0; $ketiga_i < count($id_klaster3); $ketiga_i++) {
                                     $ketiga_na_biodiv_pohon_dmg[$ketiga_i]=$ketiga_skor_d_mg[$ketiga_i]*$ketiga_nt_biodiv[$ketiga_i];
                                     $ketiga_na_total_biodiv_pohon_dmg[0] += $ketiga_na_biodiv_pohon_dmg[$ketiga_i];
                                   }
                                   $ketiga_na_total_biodiv_pohon_dmg[0] = $ketiga_na_total_biodiv_pohon_dmg[0]/$ketiga_i;

                                   //  nilai akhir biodiversitas fauna
                                   $ketiga_na_total_biodiv_fauna[0] = 0;
                                   for ($ketiga_i=0; $ketiga_i < count($id_klaster3); $ketiga_i++) {
                                     $ketiga_na_biodiv_fauna[$ketiga_i]=$ketiga_skor_h_aksenf[$ketiga_i]*$ketiga_nt_biodivf[$ketiga_i];
                                     $ketiga_na_total_biodiv_fauna[0] += $ketiga_na_biodiv_fauna[$ketiga_i];
                                   }
                                   $ketiga_na_total_biodiv_fauna[0] = $ketiga_na_total_biodiv_fauna[0]/$ketiga_i;

                                   $ketiga_na_total_biodiv_fauna_jpliuf[0] = 0;
                                   for ($ketiga_i=0; $ketiga_i < count($id_klaster3); $ketiga_i++) {
                                     $ketiga_na_biodiv_fauna_jpliuf[$ketiga_i]=$ketiga_skor_j_pliuf[$ketiga_i]*$ketiga_nt_biodivf[$ketiga_i];
                                     $ketiga_na_total_biodiv_fauna_jpliuf[0] += $ketiga_na_biodiv_fauna_jpliuf[$ketiga_i];
                                   }
                                   $ketiga_na_total_biodiv_fauna_jpliuf[0] = $ketiga_na_total_biodiv_fauna_jpliuf[0]/$ketiga_i;

                                   $ketiga_na_total_biodiv_fauna_dmgf[0] = 0;
                                   for ($ketiga_i=0; $ketiga_i < count($id_klaster3); $ketiga_i++) {
                                     $ketiga_na_biodiv_fauna_dmgf[$ketiga_i]=$ketiga_skor_d_mgf[$ketiga_i]*$ketiga_nt_biodivf[$ketiga_i];
                                     $ketiga_na_total_biodiv_fauna_dmgf[0] += $ketiga_na_biodiv_fauna_dmgf[$ketiga_i];
                                   }
                                   $ketiga_na_total_biodiv_fauna_dmgf[0] = $ketiga_na_total_biodiv_fauna_dmgf[0]/$ketiga_i;



                                   // nilai total indikator
                                   $ketiga_na_seluruh[0] = 0;
                                   for ($ketiga_i=0; $ketiga_i < count($id_klaster3); $ketiga_i++) {
                                     $ketiga_na_total[$ketiga_i]=$ketiga_na_kerusakan[$ketiga_i]+$ketiga_na_tajuk[$ketiga_i]+$ketiga_na_biodiv_pohon[$ketiga_i]+$ketiga_na_biodiv_pohon_jpliu[$ketiga_i]+$ketiga_na_biodiv_pohon_dmg[$ketiga_i]+$ketiga_na_lbds[$ketiga_i]+$ketiga_na_volume[$ketiga_i]+$ketiga_na_biodiv_fauna[$ketiga_i]+$ketiga_na_biodiv_fauna_jpliuf[$ketiga_i]+$ketiga_na_cec[$ketiga_i];
                                     $ketiga_na_seluruh[0] += $ketiga_na_total[$ketiga_i];
                                   }
                                   $ketiga_na_seluruh[0] = $ketiga_na_seluruh[0]/$ketiga_i;

 $na_total_lbds[0]=round($na_total_lbds[0],3);
 $na_total_volume[0]=round($na_total_volume[0],3);
 $na_total_kerusakan[0]=round($na_total_kerusakan[0],3);
 $na_total_tajuk[0]=round($na_total_tajuk[0],3);
 $na_total_biodiv_pohon[0]=round($na_total_biodiv_pohon[0],3);
 $na_total_biodiv_pohon_jpliu[0]=round($na_total_biodiv_pohon_jpliu[0],3);
 $na_total_biodiv_pohon_dmg[0]=round($na_total_biodiv_pohon_dmg[0],3);
 $na_total_biodiv_fauna[0]=round($na_total_biodiv_fauna[0],3);
 $na_total_biodiv_fauna_jpliuf[0]=round($na_total_biodiv_fauna_jpliuf[0],3);
 $na_total_biodiv_fauna_dmgf[0]=round($na_total_biodiv_fauna_dmgf[0],3);
 $na_seluruh[0] = round($na_seluruh[0],3);

 $kedua_na_total_lbds[0]=round($kedua_na_total_lbds[0],3);
 $kedua_na_total_volume[0]=round($kedua_na_total_volume[0],3);
 $kedua_na_total_kerusakan[0]=round($kedua_na_total_kerusakan[0],3);
 $kedua_na_total_tajuk[0]=round($kedua_na_total_tajuk[0],3);
 $kedua_na_total_biodiv_pohon[0]=round($kedua_na_total_biodiv_pohon[0],3);
 $kedua_na_total_biodiv_pohon_jpliu[0]=round($kedua_na_total_biodiv_pohon_jpliu[0],3);
 $kedua_na_total_biodiv_pohon_dmg[0]=round($kedua_na_total_biodiv_pohon_dmg[0],3);
 $kedua_na_total_biodiv_fauna[0]=round($kedua_na_total_biodiv_fauna[0],3);
 $kedua_na_total_biodiv_fauna_jpliuf[0]=round($kedua_na_total_biodiv_fauna_jpliuf[0],3);
 $kedua_na_total_biodiv_fauna_dmgf[0]=round($kedua_na_total_biodiv_fauna_dmgf[0],3);
 $kedua_na_seluruh[0] = round($kedua_na_seluruh[0],3);

 $ketiga_na_total_lbds[0]=round($ketiga_na_total_lbds[0],3);
 $ketiga_na_total_volume[0]=round($ketiga_na_total_volume[0],3);
 $ketiga_na_total_kerusakan[0]=round($ketiga_na_total_kerusakan[0],3);
 $ketiga_na_total_tajuk[0]=round($ketiga_na_total_tajuk[0],3);
 $ketiga_na_total_biodiv_pohon[0]=round($ketiga_na_total_biodiv_pohon[0],3);
 $ketiga_na_total_biodiv_pohon_jpliu[0]=round($ketiga_na_total_biodiv_pohon_jpliu[0],3);
 $ketiga_na_total_biodiv_pohon_dmg[0]=round($ketiga_na_total_biodiv_pohon_dmg[0],3);
 $ketiga_na_total_biodiv_fauna[0]=round($ketiga_na_total_biodiv_fauna[0],3);
 $ketiga_na_total_biodiv_fauna_jpliuf[0]=round($ketiga_na_total_biodiv_fauna_jpliuf[0],3);
 $ketiga_na_total_biodiv_fauna_dmgf[0]=round($ketiga_na_total_biodiv_fauna_dmgf[0],3);
 $ketiga_na_seluruh[0] = round($ketiga_na_seluruh[0],3);

 return view('auditor.nilai.skoring_semua_pengukuran',[
                         'jumlah_penilaian' => $jumlah_penilaian,
                         'id_data_klaster' => $id_data_klaster,
                         'param_vit' => $param_vit,
                         'param_ktk' =>$param_ktk,
                         'jmlh_param' =>$jmlh_param,

                         'p_lbds'=>$p_lbds,
                         'p_volume'=>$p_volume,
                         'p_kerusakan'=>$p_kerusakan,
                         'p_ktjk'=>$p_ktjk,
                         'p_kimia'=>$p_kimia,
                         'sifat_kimia'=>$sifat_kimia,
                         'p_fisik'=>$p_fisik,
                         'haksenp' =>$haksenp,
                         'p_jpliu' =>$p_jpliu,
                         'p_dmg' =>$p_dmg,
                         'haksenf' =>$haksenf,
                         'p_jpliuf' =>$p_jpliuf,
                         'p_dmgf' =>$p_dmgf,


                         'pengukuran_ke' => $pengukuran_ke,
                         'id_klaster' => $id_klaster,
                         'id_klaster2' => $id_klaster2,
                         'id_klaster3' => $id_klaster3,
                         // 'nilai_pli' => $tli_f,

                         'na_total_cec' => $na_total_cec,
                         'na_total_lbds' => $na_total_lbds,
                         'na_total_volume' => $na_total_volume,
                         'na_total_kerusakan' => $na_total_kerusakan,
                         'na_total_tajuk' => $na_total_tajuk,
                         'na_total_biodiv_pohon' => $na_total_biodiv_pohon,
                         'na_total_biodiv_pohon_jpliu' => $na_total_biodiv_pohon_jpliu,
                         'na_total_biodiv_pohon_dmg' => $na_total_biodiv_pohon_dmg,
                         'na_total_biodiv_fauna' => $na_total_biodiv_fauna,
                         'na_total_biodiv_fauna_jpliuf' => $na_total_biodiv_fauna_jpliuf,
                         'na_total_biodiv_fauna_dmgf' => $na_total_biodiv_fauna_dmgf,

                         'na_total' => $na_total,
                         'na_seluruh' => $na_seluruh,

                         'na_total_cec2' => $kedua_na_total_cec,
                         'na_total_lbds2' => $kedua_na_total_lbds,
                         'na_total_volume2' => $kedua_na_total_volume,
                         'na_total_kerusakan2' => $kedua_na_total_kerusakan,
                         'na_total_tajuk2' => $kedua_na_total_tajuk,
                         'na_total_biodiv_pohon2' => $kedua_na_total_biodiv_pohon,
                         'na_total_biodiv_pohon_jpliu2' => $kedua_na_total_biodiv_pohon_jpliu,
                         'na_total_biodiv_pohon_dmg2' => $kedua_na_total_biodiv_pohon_dmg,
                         'na_total_biodiv_fauna2' => $kedua_na_total_biodiv_fauna,
                         'na_total_biodiv_fauna_jpliuf2' => $kedua_na_total_biodiv_fauna_jpliuf,
                         'na_total_biodiv_fauna_dmgf2' => $kedua_na_total_biodiv_fauna_dmgf,

                         'na_total2' => $kedua_na_total,
                         'na_seluruh2' => $kedua_na_seluruh,

                         'na_total_cec3' => $ketiga_na_total_cec,
                         'na_total_lbds3' => $ketiga_na_total_lbds,
                         'na_total_volume3' => $ketiga_na_total_volume,
                         'na_total_kerusakan3' => $ketiga_na_total_kerusakan,
                         'na_total_tajuk3' => $ketiga_na_total_tajuk,
                         'na_total_biodiv_pohon3' => $ketiga_na_total_biodiv_pohon,
                         'na_total_biodiv_pohon_jpliu3' => $ketiga_na_total_biodiv_pohon_jpliu,
                         'na_total_biodiv_pohon_dmg3' => $ketiga_na_total_biodiv_pohon_dmg,
                         'na_total_biodiv_fauna3' => $ketiga_na_total_biodiv_fauna,
                         'na_total_biodiv_fauna_jpliuf3' => $ketiga_na_total_biodiv_fauna_jpliuf,
                         'na_total_biodiv_fauna_dmgf3' => $ketiga_na_total_biodiv_fauna_dmgf,

                         'na_total3' => $ketiga_na_total,
                         'na_seluruh3' => $ketiga_na_seluruh,
                       ]);
             }
             else {
               return view('auditor.home',[

                 ]);
             }


         }
         else{
           return view('auditor.penilaian_kurang',[
             'pesan' => "Pengukuran tidak lengkap",
           ]);
         }

         return view('auditor.penilaian_kurang',[
           'pesan' => "tes",
         ]);
       }
       else{
         $id_klaster = DB::table('kategori_klaster')
         ->leftjoin('tbl_klaster_plot','tbl_klaster_plot.id_data_klaster','=','kategori_klaster.id_data_klaster2')
         ->leftjoin('lokasi','lokasi.id_klaster_plot','=','tbl_klaster_plot.id_klaster_plot')
         ->leftjoin('desa','desa.id','=','lokasi.id_desa')
         ->leftjoin('kecamatan','kecamatan.id','=','lokasi.id_kecamatan')
         ->leftjoin('kabupaten','kabupaten.id','=','lokasi.id_kabupaten')
         ->leftjoin('provinsi','provinsi.id_provinsi','=','lokasi.id_provinsi')
         ->where([['kategori_klaster.id_data_klaster2','like',$id_data_klaster]])
         ->where('kategori_klaster.pengukuran_ke','=',$pengukuran_ke)
         ->orderBy('tbl_klaster_plot.nama_klaster','asc')
         ->get();

         $id_data_klaster2 = DB::table('kategori_klaster')->where('id_data_klaster2','=',$id_data_klaster)
         ->where('pengukuran_ke','=',$pengukuran_ke)->first();

       }
       //



       // Untuk perhitungan lebih dari sama dengan 1 klaster
       $jumlah_penilaian = count($id_klaster);
       if ($jumlah_penilaian>=1){

         for($i=0;$i<count($id_klaster);$i++){
           $data_tanaman[$i]=DB::table('data_tanaman_plot')
           ->join('tbl_plot','tbl_plot.id_plot','=','data_tanaman_plot.id_plot')
           ->join('table_master_jenis_tanaman','table_master_jenis_tanaman.id_jenis_tanaman','=','data_tanaman_plot.id_master_jenis_tanaman')
           ->where('data_tanaman_plot.id_klaster_plot',$id_klaster[$i]->id_klaster_plot)
           ->where('data_tanaman_plot.pengukuran_ke','=',$pengukuran_ke)
           ->get();
         }

         $m=0;
         $tli_r=[];
         $vcr_r=[];
         $lbds_r=[];
         $volume_r=[];
         $cec_r=[];
         $h_aksen_klaster[$i]=0;
         for ($i=0; $i < count($id_klaster); $i++) {
           // untuk mengetahui id klaster saat ini
           $id_cl=$id_klaster[$i]->id_klaster_plot;
             $id_pengukuran1=[];
             $plot=[];
             $tli_f=[];
             $vcr_f=[];
             $lbds_f=[];
             $volume_f=[];
             $cec_f=[];
             // untuk menghitung banyaknya plot yang ada pengukuran
             $plot=DB::table('tbl_plot')
             ->join('pengukuran_master','pengukuran_master.id_plot','=','tbl_plot.id_plot')
             ->where('id_klaster_plot',$id_cl)
             ->where('pengukuran_ke','=',$pengukuran_ke)
             ->get();
             if(count($plot)!=0){
             for ($j=0; $j < count($plot); $j++) {
               $id_pengukuran=DB::table('pengukuran_master')->where([['id_plot',$plot[$j]->id_plot],['pengukuran_ke',$pengukuran_ke]])->get();
               $id_pengukuran1[$j]=$id_pengukuran[0]->id_pengukuran;

             }
           }
           else{
             // id pengukuran gak ada
           }
           $tli_r[$m]=0;
           $vcr_r[$m]=0;
           $lbds_r[$m]=0;
           $volume_r[$m]=0;
           $cec_r[$m]=0;
           // kalo pengukurannya tidak kosong dalam satu klaster

           if(count($id_pengukuran1)!=0){
             for ($k=0; $k < count($id_pengukuran1); $k++) {
             $tli=0;
             $vcr=0;
             $lbds=0;
             $volume=0;

             //indikator kualitas Tapak
             if($p_kimia!=""){

               if($sifat_kimia==""){
                 $cec_f[$i]=0;
               }
               else{
                 $data_pengukuran_ktk_kimia= DB::table('ktk_kimia')
                 ->where('kode_klaster','=',$id_cl)
                 ->where('pengukuran_ke','=',$pengukuran_ke)
                 ->where('id_sifat','=',$sifat_kimia)
                 ->first();
                 $data_pengukuran_ktk_kimia= DB::table('ktk_kimia')
                 ->where('kode_klaster','=',$id_cl)
                 ->where('pengukuran_ke','=',$pengukuran_ke)
                 ->where('id_sifat','=',$sifat_kimia)
                 ->get();
                 if(count($data_pengukuran_ktk_kimia)!=0){
                     $cec_f[$i]=$data_pengukuran_ktk_kimia[0]->cec;
                 }
                 else{
                   $cec_f[$i]=0;
                 }
               }

             }
             else{
               $cec_f[$i]=0;
             }

             // indikator vitalitas
             // untuk data pengukuran kerusakan
             if($p_kerusakan!=""){
               $data_pengukuran=DB::table('pengukuran_master')
                 ->join('kerusakan_pohon','kerusakan_pohon.id_pengukuran','=','pengukuran_master.id_pengukuran')
                 ->select('tli')
                 ->where('pengukuran_master.id_pengukuran',$id_pengukuran1[$k])->get();

                 // untuk kerusakan
                 if(count($data_pengukuran)!=0){
                   for ($l=0; $l < count ($data_pengukuran); $l++) {
                     // nilai total tli plot
                     $tli+=$data_pengukuran[$l]->tli;
                   }
                   // nilai pli plot
                   $tli_f[$k]=($tli/count($data_pengukuran));
                 }
                 else{
                   $tli_f[$k]=0;
                 }
             }
             else{
               $tli_f[$k]=0;
             }
             //

             // untuk data pengukuran tajuk
             if($p_ktjk!=""){
               $data_pengukuran_tajuk=DB::table('pengukuran_master')
                 ->join('kondisi_tajuk','kondisi_tajuk.id_pengukuran','=','pengukuran_master.id_pengukuran')
                 ->select('vcri')
                 ->where('pengukuran_master.id_pengukuran',$id_pengukuran1[$k])->get();
                 // untuk tajuk
                 if(count($data_pengukuran_tajuk)!=0){
                   for ($l=0; $l < count ($data_pengukuran_tajuk); $l++) {
                     // nilai total vcr plot
                     $vcr+=$data_pengukuran_tajuk[$l]->vcri;
                   }
                   // nilai vcr plot
                   $vcr_f[$k]=($vcr/count($data_pengukuran_tajuk));
                 }
                 else{
                   $vcr_f[$k]=0;
                 }
             }
             else{
               $vcr_f[$k]=0;
             }

               // indikator produktivitas parameter lbds
             if($p_lbds!=""){
             $data_pengukuran_lbds=DB::table('pengukuran_master')
               ->join('lbds','lbds.id_pengukuran','=','pengukuran_master.id_pengukuran')
               ->select('Hasil_LBDS','v')
               ->where('pengukuran_master.id_pengukuran',$id_pengukuran1[$k])->get();
               // untuk lbds
               if(count($data_pengukuran_lbds)!=0){
               for ($l=0; $l < count ($data_pengukuran_lbds); $l++) {
                 // nilai total lbds plot
                 $lbds+=$data_pengukuran_lbds[$l]->Hasil_LBDS;
               }
               // nilai lbds plot
               $lbds_f[$k]=$lbds;
             }
             else{
               $lbds_f[$k]=0;
             }
            }
            else{
              $lbds_f[$k]=0;
            }
               //

               // indikator produktivitas parameter volume
               if($p_volume!=""){
               $data_pengukuran_volume=DB::table('pengukuran_master')
               ->join('lbds','lbds.id_pengukuran','=','pengukuran_master.id_pengukuran')
               ->select('Hasil_LBDS','v')
               ->where('pengukuran_master.id_pengukuran',$id_pengukuran1[$k])->get();
                // untuk volume
                if(count($data_pengukuran_volume)!=0){
                for ($l=0; $l < count ($data_pengukuran_volume); $l++) {
                  // nilai total volume_v plot
                  $volume+=$data_pengukuran_volume[$l]->v;
                }
                // nilai volume_v plot
                $volume_f[$k]=$volume;
               }
               else{
                $volume_f[$k]=0;
               }
               }
               else{
               $volume_f[$k]=0;
               }
               //

             //nilai total KTPK
             $cec_r[$m]+=$cec_f[$i];
             // nilai total PLI
             $tli_r[$m]+=$tli_f[$k];
             // nilai total VCR
             $vcr_r[$m]+=$vcr_f[$k];
             // nilai total LBDS
             $lbds_r[$m]+=$lbds_f[$k];
             // nilai total Volume
             $volume_r[$m]+=$volume_f[$k];
           }

           $cec_r[$m]=$cec_r[$m]/count($id_pengukuran1);
           $tli_r[$m]=$tli_r[$m]/count($id_pengukuran1);
           $vcr_r[$m]=$vcr_r[$m]/count($id_pengukuran1);
           $lbds_r[$m]=$lbds_r[$m]/count($id_pengukuran1);
           $volume_r[$m]=$volume_r[$m]/count($id_pengukuran1);
             // hanya pembulatan
             for ($a=0;$a<count($id_pengukuran1);$a++){
               $tli_f[$a]=round(($tli_f[$a]),3);
               $vcr_f[$a]=round(($vcr_f[$a]),3);
               $lbds_f[$a]=round(($lbds_f[$a]),3);
               $volume_f[$a]=round(($volume_f[$a]),3);
             }
           }
           else{
             if($id_cl==""){
               $pesan= "Data pengukuran tidak tersedia";
               return view('auditor.penilaian_kurang',[
                 'pesan' => $pesan,
               ]);
             }
             else{
               $pesan= "Salah satu pengukuran tidak tersedia";
               return view('auditor.pengukuran_kurang',[
                 'pesan' => $pesan,
                 'id_klaster' => $id_cl,
               ]);
             }

           }

             $m++;

             // data biodiversitas pohon
             for($q=0;$q<count($plot);$q++){
               $j_pliu_klaster[$i]=0;
             if($haksenp!="" || $p_jpliu!=""){
               $rata_h_aksen[$i]=0;
               $data_biodiv_pohon[$i] = DB::table('data_tanaman_plot')
               ->where('id_plot','=',$plot[$q]->id_plot)
               ->where('status','=','1')
               ->where('pengukuran_ke','=',$pengukuran_ke)
               ->get();
               $jumlah_pohon[$i]=count($data_biodiv_pohon[$i]);
               $jenis_pohon[$i]=DB::table('data_tanaman_plot')
               ->select(DB::raw("data_tanaman_plot.id_master_jenis_tanaman, COUNT(*) as jumlah"))
               ->where('data_tanaman_plot.id_plot','=',$plot[$q]->id_plot)
               ->where('status','=','1')
               ->where('pengukuran_ke','=',$pengukuran_ke)
               ->groupBy(DB::raw('data_tanaman_plot.id_master_jenis_tanaman'))
               ->get();

               $h_aksen[$q]=0;
               if($jumlah_pohon[$i]!=0){
                 for($o=0;$o<count($jenis_pohon[$i]);$o++){
                   $n[$o]=$jenis_pohon[$i][$o]->jumlah;
                   $ni[$o]=$n[$o]/$jumlah_pohon[$i];
                   $ln_ni[$o]=log($ni[$o]);
                   $ni_ln_ni[$o]=$ni[$o]*$ln_ni[$o];
                   $h_aksen[$q]-=$ni_ln_ni[$o];
                 }

                 //$h_aksen[$i]=$h_aksen[$i]/count($jenis_pohon[$i]);
               }
              }
              else{
                $h_aksen[$q]=0;
              }
            //   if($i==1){
            //   dd($h_aksen);
            // }
              //

               // dmg biodiversitas pohon
               if($p_dmg!=""){
                 $h_aksen_klaster[$i]=0;
                 $rata_h_aksen[$i]=0;
                 $data_biodiv_pohon[$i] = DB::table('data_tanaman_plot')
                 ->where('id_plot','=',$plot[$q]->id_plot)
                 ->where('status','=','1')
                 ->where('pengukuran_ke','=',$pengukuran_ke)
                 ->get();
                 $jumlah_pohon[$i]=count($data_biodiv_pohon[$i]);
                 $jenis_pohon[$i]=DB::table('data_tanaman_plot')
                 ->select(DB::raw("data_tanaman_plot.id_master_jenis_tanaman, COUNT(*) as jumlah"))
                 ->where('data_tanaman_plot.id_plot','=',$plot[$q]->id_plot)
                 ->where('status','=','1')
                 ->where('pengukuran_ke','=',$pengukuran_ke)
                 ->groupBy(DB::raw('data_tanaman_plot.id_master_jenis_tanaman'))
                 ->get();

                 $data_biodiv_pohon_klaster[$i] = DB::table('data_tanaman_plot')
                 ->where('id_klaster_plot','=',$id_klaster[$i]->id_klaster_plot)
                 ->where('status','=','1')
                 ->where('pengukuran_ke','=',$pengukuran_ke)
                 ->get();
                 $jumlah_pohon_klaster[$i]=count($data_biodiv_pohon_klaster[$i]);

                 $jenis_pohon_klaster[$i]=DB::table('data_tanaman_plot')
                 ->select(DB::raw("data_tanaman_plot.id_master_jenis_tanaman, COUNT(*) as jumlah"))
                 ->where('data_tanaman_plot.id_klaster_plot','=',$id_klaster[$i]->id_klaster_plot)
                 ->where('status','=','1')
                 ->where('pengukuran_ke','=',$pengukuran_ke)
                 ->groupBy(DB::raw('data_tanaman_plot.id_master_jenis_tanaman'))
                 ->get();
                 $jml_jenis_klaster[$i] = count($jenis_pohon_klaster[$i]);

                 $h_aksen[$q]=0;
                 $d_mg[$i]=0;
                 if($jumlah_pohon[$i]!=0){
                   $jml_jenis[$i] = count($jenis_pohon[$i]);
                   for($o=0;$o<count($jenis_pohon[$i]);$o++){
                     $n[$o]=$jenis_pohon[$i][$o]->jumlah;
                     $ni[$o]=$n[$o]/$jumlah_pohon[$i];
                     $ln_ni[$o]=log($ni[$o]);
                     $ni_ln_ni[$o]=$ni[$o]*$ln_ni[$o];
                     $h_aksen[$q]-=$ni_ln_ni[$o];
                     $rata_h_aksen[$i]+=$h_aksen[$q];
                   }

                   if($jumlah_pohon_klaster[$i]>1){
                     $d_mg[$i]=($jml_jenis_klaster[$i]-1)/log($jumlah_pohon_klaster[$i]);
                   }
                 }

                }
                else{
                  $d_mg[$i]=0;
                }
              }
                 // dd($h_aksen);
                 if($haksenp!=""){
                     $rata_h_aksen[$i]=0;
                     for($v=0;$v<4;$v++){
                     $rata_h_aksen[$i]+=$h_aksen[$v];
                   }
                   $h_aksen_klaster[$i]=$rata_h_aksen[$i]/4;
                   $h_aksen_klaster[$i]=round($h_aksen_klaster[$i],3);
                 }


                if($p_jpliu!=""){
                  $rata_h_aksen[$i]=0;
                  for($v=0;$v<4;$v++){
                  $rata_h_aksen[$i]+=$h_aksen[$v];
                }
                 $h_aksen_klaster[$i]=$rata_h_aksen[$i]/4;
                 $h_aksen_klaster[$i]=round($h_aksen_klaster[$i],3);

                  $jenis_pohon_klaster[$i]=DB::table('data_tanaman_plot')
                  ->select(DB::raw("data_tanaman_plot.id_master_jenis_tanaman, COUNT(*) as jumlah"))
                  ->where('data_tanaman_plot.id_klaster_plot','=',$id_klaster[$i]->id_klaster_plot)
                  ->where('status','=','1')
                  ->where('pengukuran_ke','=',$pengukuran_ke)
                  ->groupBy(DB::raw('data_tanaman_plot.id_master_jenis_tanaman'))
                  ->get();
                  $jml_jenis_klaster[$i] = count($jenis_pohon_klaster[$i]);

                  if($jml_jenis_klaster[$i]>1){
                    $j_pliu_klaster[$i]=$h_aksen_klaster[$i]/log($jml_jenis_klaster[$i]);
                }
                else{
                  $j_pliu_klaster[$i]=0;
                }
              }
              else{
                $j_pliu_klaster[$i]=0;
              }
                //

              // data biodiversitas fauna
              if($haksenf!=""){
                $data_biodiv_fauna[$i] = DB::table('data_fauna')
                ->where('id_klaster_plot_fauna','=',$id_cl)
                ->where('pengukuran_ke','=',$pengukuran_ke)
                ->get();
                $h_aksenf[$i]=0;
                if(count($data_biodiv_fauna[$i])!=0){
                  $total_fauna=0;
                  $tot_data_fauna[$i]=count($data_biodiv_fauna[$i]);
                  for($s=0;$s<$tot_data_fauna[$i];$s++){
                    $total_fauna+=$data_biodiv_fauna[$i][$s]->jumlah;
                  }

                  $jumlah_fauna[$i]=$total_fauna;
                  for($t=0;$t<$tot_data_fauna[$i];$t++){
                    $nf[$t]=$data_biodiv_fauna[$i][$t]->jumlah;
                    $nif[$t]=$nf[$t]/$jumlah_fauna[$i];
                    $ln_nif[$t]=log($nif[$t]);
                    $ni_ln_nif[$t]=$nif[$t]*$ln_nif[$t];
                    $h_aksenf[$i]-=$ni_ln_nif[$t];
                  }
                  $h_aksenf[$i]=$h_aksenf[$i];
                }
             }
             else{
               $h_aksenf[$i]=0;
             }

             // data jpliu fauna
             if($p_jpliuf!=""){
               $data_biodiv_fauna[$i] = DB::table('data_fauna')
               ->where('id_klaster_plot_fauna','=',$id_cl)
               ->where('pengukuran_ke','=',$pengukuran_ke)
               ->get();
               $h_aksenf[$i]=0;
               $j_pliuf[$i]=0;
               if(count($data_biodiv_fauna[$i])!=0){
                 $total_fauna=0;
                 $tot_data_fauna[$i]=count($data_biodiv_fauna[$i]);
                 for($s=0;$s<$tot_data_fauna[$i];$s++){
                   $total_fauna+=$data_biodiv_fauna[$i][$s]->jumlah;
                 }

                 $jumlah_fauna[$i]=$total_fauna;
                 for($t=0;$t<$tot_data_fauna[$i];$t++){
                   $nf[$t]=$data_biodiv_fauna[$i][$t]->jumlah;
                   $nif[$t]=$nf[$t]/$jumlah_fauna[$i];
                   $ln_nif[$t]=log($nif[$t]);
                   $ni_ln_nif[$t]=$nif[$t]*$ln_nif[$t];
                   $h_aksenf[$i]-=$ni_ln_nif[$t];

                   if($tot_data_fauna[$i]==0 || $tot_data_fauna[$i]==1 ){
                     $j_pliuf[$i]+=0;
                   }
                   else{
                     $j_pliuf[$i]+=-1*$ni_ln_nif[$t]/log($tot_data_fauna[$i]);
                   }

                 }
                 $j_pliuf[$i]=$j_pliuf[$i]/$tot_data_fauna[$i];
                 $h_aksenf[$i]=$h_aksenf[$i]/$tot_data_fauna[$i];
               }
            }
            else{
              $j_pliuf[$i]=0;
            }

            // data dmg fauna
            if($p_dmgf!=""){
              $data_biodiv_fauna[$i] = DB::table('data_fauna')
              ->where('id_klaster_plot_fauna','=',$id_cl)
              ->where('pengukuran_ke','=',$pengukuran_ke)
              ->get();
              $h_aksenf[$i]=0;
              $d_mgf[$i]=0;
              if(count($data_biodiv_fauna[$i])!=0){
                $total_fauna=0;
                $tot_data_fauna[$i]=count($data_biodiv_fauna[$i]);

                for($s=0;$s<$tot_data_fauna[$i];$s++){
                  $total_fauna+=$data_biodiv_fauna[$i][$s]->jumlah;
                }

                $jumlah_fauna[$i]=$total_fauna;
                for($t=0;$t<$tot_data_fauna[$i];$t++){
                  $nf[$t]=$data_biodiv_fauna[$i][$t]->jumlah;
                  $nif[$t]=$nf[$t]/$jumlah_fauna[$i];
                  $ln_nif[$t]=log($nif[$t]);
                  $ni_ln_nif[$t]=$nif[$t]*$ln_nif[$t];
                  $h_aksenf[$i]-=$ni_ln_nif[$t];
                }
                if($tot_data_fauna[$i]>1){
                  $h_aksenf[$i]=$h_aksenf[$i]/$tot_data_fauna[$i];
                }
                if($jumlah_fauna[$i]>1){
                  $d_mgf[$i]=($tot_data_fauna[$i]-1)/log($jumlah_fauna[$i]);
                }
              }
           }
           else{
             $d_mgf[$i]=0;
           }

           }

           // hanya pembulatan
           for ($a=0;$a<count($tli_r);$a++){
             $cec_r[$a]=round(($cec_r[$a]),3);
             $lbds_r[$a]=round(($lbds_r[$a]),3);
             $volume_r[$a]=round(($volume_r[$a]),3);
             $tli_r[$a]=round(($tli_r[$a]),3);
             $vcr_r[$a]=round(($vcr_r[$a]),3);
             // $h_aksen[$a]=round($h_aksen[$a],3);
             $d_mg[$a]=round($d_mg[$a],3);
             $h_aksenf[$a]=round($h_aksenf[$a],3);
             $j_pliuf[$a]=round($j_pliuf[$a],3);
             $d_mgf[$a]=round($d_mgf[$a],3);
             // $h_aksen_klaster[$a]=round($h_aksen_klaster[$a],3);
             $j_pliu_klaster[$a]=round($j_pliu_klaster[$a],3);
           }

           // range nilai skor Ktk kimia
           $const_cec=0;
           if($p_kimia!=""){
                 $const_cec=(max($cec_r)-min($cec_r))/10;
                 $range_cec_l=[];
                 $range_cec_init=min($cec_r);
                 $range_cec_l[0]=min($cec_r);
                 $range_cec_r=[];
                 for ($i=1;$i<10;$i++){
                   $range_cec_init+=$const_cec;
                   $range_cec_l[$i]=round($range_cec_init,3);
                   $range_cec_r[$i]=round(($range_cec_l[$i]-0.001),3);
                 }
                 $range_cec_r[10]=round(max($cec_r),3);

                 for ($i=0; $i < count($id_klaster); $i++) {
                   $skor_cec[$i]=1;
                   for ($j=0; $j < count($range_cec_l); $j++) {
                     if($cec_r[$i]>=$range_cec_l[$j] && $cec_r[$i]<=$range_cec_r[$j+1]){
                       break;
                     }
                     if($skor_cec[$i]<10){
                     $skor_cec[$i]++;
                   }
                   }
                 }
               }
               else{
                 for($t=0;$t<=10;$t++){
                   $range_cec_l[$t]=0;
                   $range_cec_r[$t]=0;
                 }
                 for ($i=0;$i<count($id_klaster);$i++){
                     $skor_cec[$i]=0;
                 }
               }
             //

           // range nilai skor Produktivitas
             //lbds
             $const_lbds=0;
             if($p_lbds!=""){
                 $const_lbds=(max($lbds_r)-min($lbds_r))/10;
                 $range_lbds_l=[];
                 $range_lbds_init=min($lbds_r);
                 $range_lbds_l[0]=min($lbds_r);
                 $range_lbds_r=[];
                 for ($i=1;$i<10;$i++){
                   $range_lbds_init+=$const_lbds;
                   $range_lbds_l[$i]=round($range_lbds_init,3);
                   $range_lbds_r[$i]=round(($range_lbds_l[$i]-0.001),3);
                 }
                 $range_lbds_r[10]=round(max($lbds_r),3);

                 for ($i=0; $i < count($id_klaster); $i++) {
                   $skor_lbds[$i]=1;
                   for ($j=0; $j < count($range_lbds_l); $j++) {
                     if($lbds_r[$i]>=$range_lbds_l[$j] && $lbds_r[$i]<=$range_lbds_r[$j+1]){
                       break;
                     }
                     if($skor_lbds[$i]<10){
                       $skor_lbds[$i]++;
                     }
                   }
                 }
               }
               else{
                 for($t=0;$t<=10;$t++){
                   $range_lbds_l[$t]=0;
                   $range_lbds_r[$t]=0;
                 }
                 for ($i=0;$i<count($id_klaster);$i++){
                   $skor_lbds[$i]=0;
               }
             }

             //volume_v
             $const_volume=0;
             if($p_volume!=""){
                 $const_volume=(max($volume_r)-min($volume_r))/10;
                 $range_volume_l=[];
                 $range_volume_init=min($volume_r);
                 $range_volume_l[0]=min($volume_r);
                 $range_volume_r=[];
                 for ($i=1;$i<10;$i++){
                   $range_volume_init+=$const_volume;
                   $range_volume_l[$i]=round($range_volume_init,3);
                   $range_volume_r[$i]=round(($range_volume_l[$i]-0.001),3);
                 }
                 $range_volume_r[10]=round(max($volume_r),3);

                 for ($i=0; $i < count($id_klaster); $i++) {
                   $skor_volume[$i]=1;
                   for ($j=0; $j < count($range_volume_l); $j++) {
                     if($volume_r[$i]>=$range_volume_l[$j] && $volume_r[$i]<=$range_volume_r[$j+1]){
                       break;
                     }
                     if($skor_volume[$i]<10){
                       $skor_volume[$i]++;
                     }

                   }
                 }
               }
               else{
                 for($t=0;$t<=10;$t++){
                   $range_volume_l[$t]=0;
                   $range_volume_r[$t]=0;
                 }
                 for ($i=0;$i<count($id_klaster);$i++){
                   $skor_volume[$i]=0;
               }
             }
             //

             // range nilai skor kerusakan
             $const_tli=0;
             if($p_kerusakan!=""){
                   $const_tli=(max($tli_r)-min($tli_r))/10;
                   $range_tli_r=[];
                   $range_tli_init=max($tli_r);
                   $range_tli_r[0]=max($tli_r);
                   $range_tli_l=[];
                   for ($i=1;$i<10;$i++){
                     $range_tli_init-=$const_tli;
                     $range_tli_r[$i]=round($range_tli_init,3);
                     $range_tli_l[$i]=round(($range_tli_r[$i]+0.001),3);
                   }
                   $range_tli_l[10]=round(min($tli_r),3);

                   for ($i=0; $i < count($id_klaster); $i++) {
                     $skor_tli[$i]=0;
                     for ($j=0; $j < count($range_tli_l); $j++) {
                       if($skor_tli[$i]<10){
                       $skor_tli[$i]++;
                       }
                       if($tli_r[$i]>=$range_tli_l[$j+1] && $tli_r[$i]<=$range_tli_r[$j]){
                         break;
                       }
                     }
                   }
                 }
                 else{
                   for($t=0;$t<=10;$t++){
                     $range_tli_l[$t]=0;
                     $range_tli_r[$t]=0;
                   }
                   for ($i=0;$i<count($id_klaster);$i++){
                     $skor_tli[$i]=0;
                 }
                 }
               //
               // range nilai skor tajuk
               $const_vcr=0;
               if($p_ktjk!=""){
                     $const_vcr=(max($vcr_r)-min($vcr_r))/10;
                     $range_vcr_l=[];
                     $range_vcr_init=min($vcr_r);
                     $range_vcr_l[0]=min($vcr_r);
                     $range_vcr_r=[];
                     for ($i=1;$i<10;$i++){
                       $range_vcr_init+=$const_vcr;
                       $range_vcr_l[$i]=round($range_vcr_init,3);
                       $range_vcr_r[$i]=round(($range_vcr_l[$i]-0.001),3);
                     }
                     $range_vcr_r[10]=round(max($vcr_r),3);

                     for ($i=0; $i < count($id_klaster); $i++) {
                       $skor_vcr[$i]=1;
                       for ($j=0; $j < count($range_vcr_l); $j++) {
                         if($vcr_r[$i]>=$range_vcr_l[$j] && $vcr_r[$i]<=$range_vcr_r[$j+1]){
                           break;
                         }
                         if($skor_vcr[$i]<10){
                           $skor_vcr[$i]++;
                         }
                       }
                     }
                   }
               else{
                 for($t=0;$t<=10;$t++){
                   $range_vcr_l[$t]=0;
                   $range_vcr_r[$t]=0;
                 }
                 for ($i=0; $i < count($id_klaster); $i++) {
                   $skor_vcr[$i]=0;
                 }
               }
                 //

                 // range nilai skor h_aksen
                 $const_h_aksen=0;
                 if($haksenp!=""){
                       $const_h_aksen=(max($h_aksen_klaster)-min($h_aksen_klaster))/10;
                       $range_h_aksen_l=[];
                       $range_h_aksen_init=min($h_aksen_klaster);
                       $range_h_aksen_l[0]=min($h_aksen_klaster);
                       $range_h_aksen_r=[];
                       for ($i=1;$i<10;$i++){
                         $range_h_aksen_init+=$const_h_aksen;
                         $range_h_aksen_l[$i]=round($range_h_aksen_init,3);
                         $range_h_aksen_r[$i]=round(($range_h_aksen_l[$i]-0.001),3);
                       }
                       $range_h_aksen_r[10]=round(max($h_aksen_klaster),3);

                       for ($i=0; $i < count($id_klaster); $i++) {
                         $skor_h_aksen[$i]=1;
                         for ($j=0; $j < count($range_h_aksen_l); $j++) {
                           if($h_aksen_klaster[$i]>=$range_h_aksen_l[$j] && $h_aksen_klaster[$i]<=$range_h_aksen_r[$j+1]){
                             break;
                           }
                           if($skor_h_aksen[$i]<10){
                           $skor_h_aksen[$i]++;
                         }
                         }
                       }
                     }
                     else{
                       for($t=0;$t<=10;$t++){
                         $range_h_aksen_l[$t]=0;
                         $range_h_aksen_r[$t]=0;
                       }
                       for ($i=0; $i < count($id_klaster); $i++) {
                         $skor_h_aksen[$i]=0;
                       }
                     }
                   //

                   // range nilai skor j_pliup
                   $const_j_pliu=0;
                   if($p_jpliu!=""){
                         $const_j_pliu=(max($j_pliu_klaster)-min($j_pliu_klaster))/10;
                         $range_j_pliu_l=[];
                         $range_j_pliu_init=min($j_pliu_klaster);
                         $range_j_pliu_l[0]=min($j_pliu_klaster);
                         $range_j_pliu_r=[];
                         for ($i=1;$i<10;$i++){
                           $range_j_pliu_init+=$const_j_pliu;
                           $range_j_pliu_l[$i]=round($range_j_pliu_init,3);
                           $range_j_pliu_r[$i]=round(($range_j_pliu_l[$i]-0.001),3);
                         }
                         $range_j_pliu_r[10]=round(max($j_pliu_klaster),3);

                         for ($i=0; $i < count($id_klaster); $i++) {
                           $skor_j_pliu[$i]=1;
                           for ($j=0; $j < count($range_j_pliu_l); $j++) {
                             if($j_pliu_klaster[$i]>=$range_j_pliu_l[$j] && $j_pliu_klaster[$i]<=$range_j_pliu_r[$j+1]){
                               break;
                             }
                             if($skor_j_pliu[$i]<10){
                             $skor_j_pliu[$i]++;
                           }
                           }
                         }
                       }
                       else{
                         for($t=0;$t<=10;$t++){
                           $range_j_pliu_l[$t]=0;
                           $range_j_pliu_r[$t]=0;
                         }
                         for ($i=0; $i < count($id_klaster); $i++) {
                           $skor_j_pliu[$i]=0;
                         }
                       }
                     //

                     // range nilai skor d_mg
                     $const_d_mg=0;
                     if($p_dmg!=""){
                           $const_d_mg=(max($d_mg)-min($d_mg))/10;
                           $range_d_mg_l=[];
                           $range_d_mg_init=min($d_mg);
                           $range_d_mg_l[0]=min($d_mg);
                           $range_d_mg_r=[];
                           for ($i=1;$i<10;$i++){
                             $range_d_mg_init+=$const_d_mg;
                             $range_d_mg_l[$i]=round($range_d_mg_init,3);
                             $range_d_mg_r[$i]=round(($range_d_mg_l[$i]-0.001),3);
                           }
                           $range_d_mg_r[10]=round(max($d_mg),3);

                           for ($i=0; $i < count($id_klaster); $i++) {
                             $skor_d_mg[$i]=1;
                             for ($j=0; $j < count($range_d_mg_l); $j++) {
                               if($d_mg[$i]>=$range_d_mg_l[$j] && $d_mg[$i]<=$range_d_mg_r[$j+1]){
                                 break;
                               }
                               if($skor_d_mg[$i]<10){
                               $skor_d_mg[$i]++;
                             }
                             }
                           }
                         }
                         else{
                           for($t=0;$t<=10;$t++){
                             $range_d_mg_l[$t]=0;
                             $range_d_mg_r[$t]=0;
                           }
                           for ($i=0; $i < count($id_klaster); $i++) {
                             $skor_d_mg[$i]=0;
                           }
                         }
                       //

                   // range nilai skor h_aksenf
                   $const_h_aksenf=0;
                   if($haksenf!=""){
                         $const_h_aksenf=(max($h_aksenf)-min($h_aksenf))/10;
                         $range_h_aksen_lf=[];
                         $range_h_aksen_initf=min($h_aksenf);
                         $range_h_aksen_lf[0]=min($h_aksenf);
                         $range_h_aksen_rf=[];
                         for ($i=1;$i<10;$i++){
                           $range_h_aksen_initf+=$const_h_aksenf;
                           $range_h_aksen_lf[$i]=round($range_h_aksen_initf,3);
                           $range_h_aksen_rf[$i]=round(($range_h_aksen_lf[$i]-0.001),3);
                         }
                         $range_h_aksen_rf[10]=round(max($h_aksenf),3);

                         for ($i=0; $i < count($id_klaster); $i++) {
                           $skor_h_aksenf[$i]=1;
                           for ($j=0; $j < count($range_h_aksen_lf); $j++) {
                             if($h_aksenf[$i]>=$range_h_aksen_lf[$j] && $h_aksenf[$i]<=$range_h_aksen_rf[$j+1]){
                               break;
                             }
                             if($skor_h_aksenf[$i]<10){
                               $skor_h_aksenf[$i]++;
                             }
                           }
                         }
                       }
                       else{
                         for($t=0;$t<=10;$t++){
                           $range_h_aksen_lf[$t]=0;
                           $range_h_aksen_rf[$t]=0;
                         }
                         for ($i=0; $i < count($id_klaster); $i++) {
                           $skor_h_aksenf[$i]=0;
                         }
                       }
                     //

                     // range nilai skor jpliuf
                     $const_j_pliuf=0;
                     if($p_jpliuf!=""){
                           $const_j_pliuf=(max($j_pliuf)-min($j_pliuf))/10;
                           $range_j_pliu_lf=[];
                           $range_j_pliu_initf=min($j_pliuf);
                           $range_j_pliu_lf[0]=min($j_pliuf);
                           $range_j_pliu_rf=[];
                           for ($i=1;$i<10;$i++){
                             $range_j_pliu_initf+=$const_j_pliuf;
                             $range_j_pliu_lf[$i]=round($range_j_pliu_initf,3);
                             $range_j_pliu_rf[$i]=round(($range_j_pliu_lf[$i]-0.001),3);
                           }
                           $range_j_pliu_rf[10]=round(max($j_pliuf),3);

                           for ($i=0; $i < count($id_klaster); $i++) {
                             $skor_j_pliuf[$i]=1;
                             for ($j=0; $j < count($range_j_pliu_lf); $j++) {
                               if($j_pliuf[$i]>=$range_j_pliu_lf[$j] && $j_pliuf[$i]<=$range_j_pliu_rf[$j+1]){
                                 break;
                               }
                               if($skor_j_pliuf[$i]<10){
                                 $skor_j_pliuf[$i]++;
                               }
                             }
                           }
                         }
                         else{
                           for($t=0;$t<=10;$t++){
                             $range_j_pliu_lf[$t]=0;
                             $range_j_pliu_rf[$t]=0;
                           }
                           for ($i=0; $i < count($id_klaster); $i++) {
                             $skor_j_pliuf[$i]=0;
                           }
                         }
                       //

                       // range nilai skor dmgf
                       $const_d_mgf=0;
                       if($p_dmgf!=""){
                             $const_d_mgf=(max($d_mgf)-min($d_mgf))/10;
                             $range_d_mg_lf=[];
                             $range_d_mg_initf=min($d_mgf);
                             $range_d_mg_lf[0]=min($d_mgf);
                             $range_d_mg_rf=[];
                             for ($i=1;$i<10;$i++){
                               $range_d_mg_initf+=$const_d_mgf;
                               $range_d_mg_lf[$i]=round($range_d_mg_initf,3);
                               $range_d_mg_rf[$i]=round(($range_d_mg_lf[$i]-0.001),3);
                             }
                             $range_d_mg_rf[10]=round(max($d_mgf),3);

                             for ($i=0; $i < count($id_klaster); $i++) {
                               $skor_d_mgf[$i]=1;
                               for ($j=0; $j < count($range_d_mg_lf); $j++) {
                                 if($d_mgf[$i]>=$range_d_mg_lf[$j] && $d_mgf[$i]<=$range_d_mg_rf[$j+1]){
                                   break;
                                 }
                                 if($skor_d_mgf[$i]<10){
                                   $skor_d_mgf[$i]++;
                                 }
                               }
                             }
                           }
                           else{
                             for($t=0;$t<=10;$t++){
                               $range_d_mg_lf[$t]=0;
                               $range_d_mg_rf[$t]=0;
                             }
                             for ($i=0; $i < count($id_klaster); $i++) {
                               $skor_d_mgf[$i]=0;
                             }
                           }
                         //

                   // nilai Tertimbang
                   for ($i=0; $i < count($id_klaster); $i++) {
                     if($pengukuran_ke==1){
                       $nt_kr=DB::table('nilai_tertimbang_copy')
                       ->where('id_data_klaster','=',$id_data_klaster)->get();

                       if(count($nt_kr)==0){
                         $nt_ktpk[$i]=0.27;
                         $nt_kerusakan[$i]=0.27;
                         $nt_produktivitas[$i]=0.28;
                         $nt_ktjk[$i]=0.23;
                         $nt_biodiv[$i]=0.077;
                         $nt_biodivf[$i]=0.077;
                       }
                       else{
                         $nt_kr=DB::table('nilai_tertimbang_copy')
                         ->where('id_data_klaster','=',$id_data_klaster)->first();
                         $nt_ktpk[$i]=$nt_kr->nilai_ktpk;
                         $nt_kerusakan[$i]=$nt_kr->nilai_kphn;
                         $nt_produktivitas[$i]=$nt_kr->nilai_prod;
                         $nt_ktjk[$i]=$nt_kr->nilai_ktjk;
                         $nt_biodiv[$i]=$nt_kr->nilai_kjpb;
                         $nt_biodivf[$i]=$nt_kr->nilai_kjfb;
                       }
                     }
                     else{
                       $nt_kr=DB::table('nilai_tertimbang_copy')
                       ->where('id_data_klaster','=',$id_data_klaster2->id_data_klaster)->get();

                       if(count($nt_kr)==0){
                         $nt_ktpk[$i]=0.27;
                         $nt_kerusakan[$i]=0.27;
                         $nt_produktivitas[$i]=0.28;
                         $nt_ktjk[$i]=0.23;
                         $nt_biodiv[$i]=0.077;
                         $nt_biodivf[$i]=0.077;
                       }
                       else{
                         $nt_kr=DB::table('nilai_tertimbang_copy')
                         ->where('id_data_klaster','=',$id_data_klaster2->id_data_klaster)->first();
                         $nt_ktpk[$i]=$nt_kr->nilai_ktpk;
                         $nt_kerusakan[$i]=$nt_kr->nilai_kphn;
                         $nt_produktivitas[$i]=$nt_kr->nilai_prod;
                         $nt_ktjk[$i]=$nt_kr->nilai_ktjk;
                         $nt_biodiv[$i]=$nt_kr->nilai_kjpb;
                         $nt_biodivf[$i]=$nt_kr->nilai_kjfb;
                       }
                     }

                 }

                   //  nilai akhir ktk kimia
                   for ($i=0; $i < count($id_klaster); $i++) {
                     $na_cec[$i]=$skor_cec[$i]*$nt_ktpk[$i];
                   }
                   //  nilai akhir Produktivitas lbds
                   for ($i=0; $i < count($id_klaster); $i++) {
                     $na_lbds[$i]=$skor_lbds[$i]*$nt_produktivitas[$i];
                   }
                   //  nilai akhir Produktivitas volume
                   for ($i=0; $i < count($id_klaster); $i++) {
                     $na_volume[$i]=$skor_volume[$i]*$nt_produktivitas[$i];
                   }
                   //  nilai akhir kerusakan pohon
                   for ($i=0; $i < count($id_klaster); $i++) {
                     $na_kerusakan[$i]=$skor_tli[$i]*$nt_kerusakan[$i];
                   }
                   //  nilai akhir kondisi tajuk
                   for ($i=0; $i < count($id_klaster); $i++) {
                     $na_tajuk[$i]=$skor_vcr[$i]*$nt_ktjk[$i];
                   }
                   //  nilai akhir biodiversitas pohon haksen
                   for ($i=0; $i < count($id_klaster); $i++) {
                     $na_biodiv_pohon[$i]=$skor_h_aksen[$i]*$nt_biodiv[$i];
                   }
                   //  nilai akhir biodiversitas pohon jpliu
                   for ($i=0; $i < count($id_klaster); $i++) {
                     $na_biodiv_pohon_jpliu[$i]=$skor_j_pliu[$i]*$nt_biodiv[$i];
                   }
                   //  nilai akhir biodiversitas pohon dmg
                   for ($i=0; $i < count($id_klaster); $i++) {
                     $na_biodiv_pohon_dmg[$i]=$skor_d_mg[$i]*$nt_biodiv[$i];
                   }
                   //  nilai akhir biodiversitas fauna
                   for ($i=0; $i < count($id_klaster); $i++) {
                     $na_biodiv_fauna[$i]=$skor_h_aksenf[$i]*$nt_biodivf[$i];
                   }
                   for ($i=0; $i < count($id_klaster); $i++) {
                     $na_biodiv_fauna_jpliuf[$i]=$skor_j_pliuf[$i]*$nt_biodivf[$i];
                   }
                   for ($i=0; $i < count($id_klaster); $i++) {
                     $na_biodiv_fauna_dmgf[$i]=$skor_d_mgf[$i]*$nt_biodivf[$i];
                   }



                   // nilai total indikator
                   for ($i=0; $i < count($id_klaster); $i++) {
                     $na_total[$i]=$na_kerusakan[$i]+$na_tajuk[$i]+$na_biodiv_pohon[$i]+$na_biodiv_pohon_jpliu[$i]+$na_biodiv_pohon_dmg[$i]+$na_lbds[$i]+$na_volume[$i]+$na_biodiv_fauna[$i]+$na_biodiv_fauna_jpliuf[$i]+$na_cec[$i];
                   }

                   // range skor untuk nilai akhir
                   $const_nks=(max($na_total)-min($na_total))/3;
                   $range_nks_l=[];
                   $range_nks_init=min($na_total);
                   $range_nks_l[0]=min($na_total);
                   $range_nks_r=[];
                   for ($i=1;$i<3;$i++){
                     $range_nks_init+=$const_nks;
                     $range_nks_l[$i]=round($range_nks_init,3);
                     $range_nks_r[$i]=round(($range_nks_l[$i]-0.001),3);
                   }
                   $range_nks_r[3]=round(max($na_total),3);

                   // skor klaster nilai akhir
                   for ($i=0; $i < count($id_klaster); $i++) {
                     $skor_nks[$i]=1;
                     for ($j=0; $j < count($range_nks_l); $j++) {
                       if($na_total[$i]>=$range_nks_l[$j] && $na_total[$i]<=$range_nks_r[$j+1]){
                         break;
                       }
                       if($skor_nks[$i]<3){
                       $skor_nks[$i]++;
                     }
                     }
                   }

                   for ($i=0; $i < count($id_klaster); $i++) {
                   if($skor_nks[$i]==1){$nilai_skor[$i]="Buruk";}
                   else if($skor_nks[$i]==2){$nilai_skor[$i]="Sedang";}
                   else {$nilai_skor[$i]="Baik";}
                 }

                   $kondisi[0]="Buruk";
                   $kondisi[1]="Sedang";
                   $kondisi[2]="Baik";

                   $jumlah=0;
                   $app = app();
                   $range_skor_keshut = app();
                   $kondisi_app = app();

                   foreach($id_klaster as $value){
                     $nilai_akhir_kesehatan_hutan[$jumlah]= $app->make('stdClass');
                     $nilai_akhir_kesehatan_hutan[$jumlah]->Kode_Klaster = $value->nama_klaster;
                     $nilai_akhir_kesehatan_hutan[$jumlah]->Nilai_Akhir = $na_total[$jumlah];

                     $jumlah++;
                   }

                   $nilai_skor_akhir[0] = $range_skor_keshut->make('stdClass');
                   $nilai_skor_akhir[0]->jenis = "Nilai NKH Max";
                   $nilai_skor_akhir[0]->nilai = $range_nks_r[3];

                   $nilai_skor_akhir[1] = $range_skor_keshut->make('stdClass');
                   $nilai_skor_akhir[1]->jenis = "Nilai NKH Min";
                   $nilai_skor_akhir[1]->nilai = $range_nks_l[0];

                   $nilai_skor_akhir[2] = $range_skor_keshut->make('stdClass');
                   $nilai_skor_akhir[2]->jenis = "Interval Skor";
                   $nilai_skor_akhir[2]->nilai = $const_nks;

                   $kondisi_keshut[0] = $kondisi_app->make('stdClass');
                   $kondisi_keshut[0]->jenis = "Baik";
                   $kondisi_keshut[0]->max = $range_nks_r[3];
                   $kondisi_keshut[0]->mins = $range_nks_l[2];

                   $kondisi_keshut[1] = $kondisi_app->make('stdClass');
                   $kondisi_keshut[1]->jenis = "Sedang";
                   $kondisi_keshut[1]->max = $range_nks_r[2];
                   $kondisi_keshut[1]->mins = $range_nks_l[1];

                   $kondisi_keshut[2] = $kondisi_app->make('stdClass');
                   $kondisi_keshut[2]->jenis = "Buruk";
                   $kondisi_keshut[2]->max = $range_nks_r[1];
                   $kondisi_keshut[2]->mins = $range_nks_l[0];

                   return view('auditor.nilai.skoring_kesehatan_hutan',[
                     'kondisi_keshut' => $kondisi_keshut,
                     'nilai_skor_akhir' => $nilai_skor_akhir,
                     'data_nilai_akhir' => $nilai_akhir_kesehatan_hutan,
                     'jumlah_penilaian' => $jumlah_penilaian,
                     'id_data_klaster' => $id_data_klaster,
                     'param_vit' => $param_vit,
                     'param_ktk' =>$param_ktk,
                     'jmlh_param' =>$jmlh_param,

                     'p_lbds'=>$p_lbds,
                     'p_volume'=>$p_volume,
                     'p_kerusakan'=>$p_kerusakan,
                     'p_ktjk'=>$p_ktjk,
                     'p_kimia'=>$p_kimia,
                     'sifat_kimia'=>$sifat_kimia,
                     'p_fisik'=>$p_fisik,
                     'haksenp' =>$haksenp,
                     'p_jpliu' =>$p_jpliu,
                     'p_dmg' =>$p_dmg,
                     'haksenf' =>$haksenf,
                     'p_jpliuf' =>$p_jpliuf,
                     'p_dmgf' =>$p_dmgf,


                     'pengukuran_ke' => $pengukuran_ke,
                     'id_klaster' => $id_klaster,
                     'data_tanamman' => $data_tanaman,
                     // 'nilai_pli' => $tli_f,

                     'nilai_cec' => $cec_r,
                     'range_cec_l' => $range_cec_l,
                     'range_cec_r' => $range_cec_r,
                     'skor_cec' => $skor_cec,
                     'na_cec' => $na_cec,
                     'const_cec' => $const_cec,

                     'nilai_lbds' => $lbds_r,
                     'range_lbds_l' => $range_lbds_l,
                     'range_lbds_r' => $range_lbds_r,
                     'skor_lbds' => $skor_lbds,
                     'na_lbds' => $na_lbds,
                     'const_lbds' => $const_lbds,

                     'nilai_volume' => $volume_r,
                     'range_volume_l' => $range_volume_l,
                     'range_volume_r' => $range_volume_r,
                     'skor_volume' => $skor_volume,
                     'na_volume' => $na_volume,
                     'const_volume' => $const_volume,

                     'nilai_tli' => $tli_r,
                     'range_tli_l' => $range_tli_l,
                     'range_tli_r' => $range_tli_r,
                     'skor_tli' => $skor_tli,
                     'na_kerusakan' => $na_kerusakan,
                     'const_tli' => $const_tli,


                     'nilai_vcr' => $vcr_r,
                     'range_vcr_l' => $range_vcr_l,
                     'range_vcr_r' => $range_vcr_r,
                     'skor_vcr' => $skor_vcr,
                     'na_tajuk' => $na_tajuk,
                     'const_vcr' => $const_vcr,

                     'h_aksen' => $h_aksen,
                     'h_aksen_klaster' => $h_aksen_klaster,
                     'range_h_aksen_l' => $range_h_aksen_l,
                     'range_h_aksen_r' => $range_h_aksen_r,
                     'skor_h_aksen' => $skor_h_aksen,
                     'na_biodiv_pohon' => $na_biodiv_pohon,
                     'const_h_aksen' => $const_h_aksen,

                     'j_pliu_klaster' => $j_pliu_klaster,
                     'range_j_pliu_l' => $range_j_pliu_l,
                     'range_j_pliu_r' => $range_j_pliu_r,
                     'skor_j_pliu' => $skor_j_pliu,
                     'na_biodiv_pohon_jpliu' => $na_biodiv_pohon_jpliu,

                     'd_mg' => $d_mg,
                     'range_d_mg_l' => $range_d_mg_l,
                     'range_d_mg_r' => $range_d_mg_r,
                     'skor_d_mg' => $skor_d_mg,
                     'na_biodiv_pohon_dmg' => $na_biodiv_pohon_dmg,

                     'h_aksenf' => $h_aksenf,
                     'range_h_aksen_lf' => $range_h_aksen_lf,
                     'range_h_aksen_rf' => $range_h_aksen_rf,
                     'skor_h_aksenf' => $skor_h_aksenf,
                     'na_biodiv_fauna' => $na_biodiv_fauna,
                     'const_h_aksenf' => $const_h_aksenf,

                     'j_pliuf' => $j_pliuf,
                     'range_j_pliu_lf' => $range_j_pliu_lf,
                     'range_j_pliu_rf' => $range_j_pliu_rf,
                     'skor_j_pliuf' => $skor_j_pliuf,
                     'na_biodiv_fauna_jpliuf' => $na_biodiv_fauna_jpliuf,

                     'd_mgf' => $d_mgf,
                     'range_d_mg_lf' => $range_d_mg_lf,
                     'range_d_mg_rf' => $range_d_mg_rf,
                     'skor_d_mgf' => $skor_d_mgf,
                     'na_biodiv_fauna_dmgf' => $na_biodiv_fauna_dmgf,

                     'nt_ktpk' => $nt_ktpk,
                     'nt_kerusakan' => $nt_kerusakan,
                     'nt_produktivitas' => $nt_produktivitas,
                     'nt_ktjk' => $nt_ktjk,
                     'nt_biodiv' => $nt_biodiv,
                     'nt_biodivf' => $nt_biodivf,

                     'na_total' => $na_total,
                     'range_nks_l' => $range_nks_l,
                     'range_nks_r' => $range_nks_r,
                     'skor_nks' => $skor_nks,
                     'kondisi' => $kondisi,
                     'nilai_skor' => $nilai_skor,
                   ]);
         }
         else {
           return view('auditor.home',[

             ]);
         }

     }

     public function detail(Request $req){
       $id=$req->input('id_klaster_plot');
       $pengukuran_ke = $req->input('pengukuran_ke');
       $p_lbds=$req->p_lbds;
       $p_volume=$req->p_volume;
       $p_kerusakan=$req->p_kerusakan;
       $p_ktjk=$req->p_ktjk;

       $p_kimia=$req->p_kimia;
       $sifat_kimia=$req->input('sifat-sifat_kimia');
       $p_fisik = $req->p_fisik;
       $haksenp=$req->haksenp;
       $p_jpliu=$req->p_jpliu;
       $p_dmg=$req->p_dmg;
       $haksenf=$req->haksenf;
       $p_jpliuf=$req->p_jpliuf;
       $p_dmgf=$req->p_dmgf;
       // untuk hitung jumlah parameter yang dipilih, kalo lebih dari 1 artinya bagian penilaian keshut ada tanda '=' nya
       $pprod=0;
       $pvolume=0;
       $pkerusakan=0;
       $pktjk=0;

       if($p_lbds!=""){
           $pprod=1;
       }
       if($p_volume!=""){
           $pvolume=1;
       }
       if($p_kerusakan!=""){
           $pkerusakan=1;
       }
       if($p_ktjk!=""){
           $pktjk=1;
       }
       $jmlh_param=$pprod+$pvolume+$pkerusakan+$pktjk;

       $data_fisik = DB::table('ktk_fisika')->where('kode_klaster','=',$id)->where('pengukuran_ke',$pengukuran_ke)->get();

       $tli_f=[];
       $vcr_f=[];
       $lbds_f=[];
       $volume_f=[];
       $cec_f=[];

       // untuk data tbl_plot
       $id_plot = DB::table('tbl_plot')
       ->leftjoin('tbl_klaster_plot','tbl_klaster_plot.id_klaster_plot','=','tbl_plot.id_klaster_plot')
       ->leftjoin('kategori_klaster','kategori_klaster.id_data_klaster','=','tbl_klaster_plot.id_data_klaster')
       ->join('pengukuran_master','pengukuran_master.id_plot','=','tbl_plot.id_plot')
       ->where('tbl_plot.id_klaster_plot','=',$id)
       ->where('pengukuran_master.pengukuran_ke','=',$pengukuran_ke)
       ->orderBy('tbl_plot.nama_plot','asc')
       ->get();

       $jumlah_plot = count($id_plot);
       $kode_klaster_plot = $id_plot[0]->nama_klaster;

       $id_data_klaster = $id_plot[0]->id_data_klaster;

       if($pengukuran_ke!=1){
         $id_data_klaster2 = DB::table('kategori_klaster')
         ->where('id_data_klaster2','=',$id_data_klaster)
         ->where('pengukuran_ke','=',$pengukuran_ke)->first();
       }

       // untuk data tanaman dalam plot
       for($i=0;$i<count($id_plot);$i++){
           $data_tanaman[$i]=DB::table('data_tanaman_plot')
           ->join('tbl_plot','tbl_plot.id_plot','=','data_tanaman_plot.id_plot')
           ->join('table_master_jenis_tanaman','table_master_jenis_tanaman.id_jenis_tanaman','=','data_tanaman_plot.id_master_jenis_tanaman')
           ->where('data_tanaman_plot.id_plot',$id_plot[$i]->id_plot)
           ->where('data_tanaman_plot.pengukuran_ke','=',$pengukuran_ke)
           ->get();
         }

       // untuk memilih plot tanaman
       for ($i=0; $i < count($id_plot); $i++) {

       $plot[$i]=DB::table('tbl_plot')
       ->join('pengukuran_master','pengukuran_master.id_plot','=','tbl_plot.id_plot')
       ->where('tbl_plot.id_plot',$id_plot[$i]->id_plot)
       ->where('pengukuran_ke','=',$pengukuran_ke)
       ->get();

       if(count($plot)!=0){
               for ($j=0; $j < count($plot); $j++) {
                 $id_pengukuran=DB::table('pengukuran_master')->where([['id_plot',$plot[$j][0]->id_plot],['pengukuran_ke',$pengukuran_ke]])->get();
                 $id_pengukuran1[$j]=$id_pengukuran[0]->id_pengukuran;

               }
             }
             else{
              // id pengukuran gak ada
            }

            if(count($id_pengukuran1)!=0){
              for ($k=0; $k < count($id_pengukuran1); $k++) {
                $tli=0;
                $vcr=0;
                $lbds=0;
                $volume=0;

                    // indikator vitalitas
                    // untuk data pengukuran kerusakan
                    if($p_kerusakan!=""){
                      $data_pengukuran=DB::table('pengukuran_master')
                        ->join('kerusakan_pohon','kerusakan_pohon.id_pengukuran','=','pengukuran_master.id_pengukuran')
                        ->select('tli')
                        ->where('pengukuran_master.id_pengukuran',$id_pengukuran1[$k])->get();

                        // untuk kerusakan
                        if(count($data_pengukuran)!=0){
                          for ($l=0; $l < count ($data_pengukuran); $l++) {
                            // nilai total tli plot
                            $tli+=$data_pengukuran[$l]->tli;
                          }
                          // nilai pli plot
                          $tli_f[$k]=($tli/count($data_pengukuran));
                        }
                        else{
                          $tli_f[$k]=0;
                        }
                      }
                      else{
                        $tli_f[$k]=0;
                      }

                    //

                    // untuk data pengukuran tajuk
                    if($p_ktjk!=""){
                      $data_pengukuran_tajuk=DB::table('pengukuran_master')
                        ->join('kondisi_tajuk','kondisi_tajuk.id_pengukuran','=','pengukuran_master.id_pengukuran')
                        ->select('vcri')
                        ->where('pengukuran_master.id_pengukuran',$id_pengukuran1[$k])->get();
                        // untuk tajuk
                        if(count($data_pengukuran_tajuk)!=0){
                          for ($l=0; $l < count ($data_pengukuran_tajuk); $l++) {
                            // nilai total vcr plot
                            $vcr+=$data_pengukuran_tajuk[$l]->vcri;
                          }
                          // nilai vcr plot
                          $vcr_f[$k]=($vcr/count($data_pengukuran_tajuk));
                        }
                        else{
                          $vcr_f[$k]=0;
                        }
                      }
                      else{
                        $vcr_f[$k]=0;
                      }


                      // indikator produktivitas parameter lbds
                      if($p_lbds!=""){
                    $data_pengukuran_lbds=DB::table('pengukuran_master')
                      ->join('lbds','lbds.id_pengukuran','=','pengukuran_master.id_pengukuran')
                      ->select('Hasil_LBDS','v')
                      ->where('pengukuran_master.id_pengukuran',$id_pengukuran1[$k])->get();

                      // untuk lbds
                      if(count($data_pengukuran_lbds)!=0){
                      for ($l=0; $l < count ($data_pengukuran_lbds); $l++) {
                        // nilai total lbds plot
                        $lbds+=$data_pengukuran_lbds[$l]->Hasil_LBDS;
                      }
                      // dd($lbds);
                      // nilai lbds plot
                      $lbds_f[$k]=$lbds;
                    }
                    else{
                      $lbds_f[$k]=0;
                    }
                  }
                  else{
                    $lbds_f[$k]=0;
                  }

                  // indikator produktivitas parameter volume
                  if($p_volume!=""){
                $data_pengukuran_volume=DB::table('pengukuran_master')
                  ->join('lbds','lbds.id_pengukuran','=','pengukuran_master.id_pengukuran')
                  ->select('Hasil_LBDS','v')
                  ->where('pengukuran_master.id_pengukuran',$id_pengukuran1[$k])->get();

                  // untuk volume
                  if(count($data_pengukuran_volume)!=0){
                  for ($l=0; $l < count ($data_pengukuran_volume); $l++) {
                    // nilai total lbds plot
                    $volume+=$data_pengukuran_volume[$l]->v;
                  }
                  // nilai volume plot
                  $volume_f[$k]=$volume;
                }
                else{
                  $volume_f[$k]=0;
                }
              }
              else{
                $volume_f[$k]=0;
              }

                  if($p_kimia!=""){
                  $data_ktk_kimia= DB::table('ktk_kimia')
                  ->select('tbl_klaster_plot.nama_klaster','tbl_sifat_kimia_tanah.sifat_kimia','ktk_kimia.cec')
                  ->join('tbl_klaster_plot','tbl_klaster_plot.id_klaster_plot','=','ktk_kimia.kode_klaster')
                  ->join('tbl_sifat_kimia_tanah','tbl_sifat_kimia_tanah.id_parameter_kimia','=','ktk_kimia.id_sifat')
                  ->where('kode_klaster','=',$id)
                  ->where('id_sifat','=',$sifat_kimia)
                  ->where('pengukuran_ke','=',$pengukuran_ke)
                  ->get();
                }
                else{
                  $data_ktk_kimia=0;
                  $sifat_kimia=0;
                }
                // data biodiversitas pohon
              if($haksenp=="" && $p_jpliu=="" && $p_dmg==""){
                $n=0;
                $ni=0;
                $ln_ni=0;
                $ni_ln_ni=0;
              }

              $jumlah_pohon=DB::table('data_tanaman_plot')
              ->select(DB::raw("table_master_jenis_tanaman.nama_tanaman,table_master_jenis_tanaman.nama_latin,COUNT(*) as jumlah"))
              ->join(
              'table_master_jenis_tanaman',
              'table_master_jenis_tanaman.id_jenis_tanaman','=','data_tanaman_plot.id_master_jenis_tanaman'
              )
              ->where('id_plot','=',$id_plot[$i]->id_plot)
              ->where('data_tanaman_plot.pengukuran_ke','=',$pengukuran_ke)
              ->where('data_tanaman_plot.status','=','1')
              ->groupBy(DB::raw('table_master_jenis_tanaman.nama_tanaman,table_master_jenis_tanaman.nama_latin'))
              ->orderBy('table_master_jenis_tanaman.nama_tanaman')
              ->get();

              if($haksenp!=""){

              if(count($jumlah_pohon)!=0){
                $data_biodiv_pohon = DB::table('data_tanaman_plot')
                ->where('id_plot','=',$id_plot[$i]->id_plot)
                ->where('status','=','1')
                ->where('pengukuran_ke','=',$pengukuran_ke)
                ->get();

                $jmlh_phn = count($data_biodiv_pohon);
                $jenis_pohon=DB::table('data_tanaman_plot')
                ->select(DB::raw("table_master_jenis_tanaman.nama_tanaman,data_tanaman_plot.id_master_jenis_tanaman, COUNT(*) as jumlah"))
                ->join('table_master_jenis_tanaman','table_master_jenis_tanaman.id_jenis_tanaman','=','data_tanaman_plot.id_master_jenis_tanaman')
                ->where('data_tanaman_plot.id_plot','=',$id_plot[$i]->id_plot)
                ->where('status','=','1')
                ->where('pengukuran_ke','=',$pengukuran_ke)
                ->groupBy(DB::raw('table_master_jenis_tanaman.nama_tanaman,data_tanaman_plot.id_master_jenis_tanaman'))
                ->orderBy('table_master_jenis_tanaman.nama_tanaman')
                ->get();

                $h_aksen=0;
                if($jmlh_phn!=0){
                  for($z=0;$z<count($jenis_pohon);$z++){
                    $n[$z]=$jenis_pohon[$z]->jumlah;
                    $ni[$z]=$n[$z]/$jmlh_phn;
                    $ln_ni[$z]=log($ni[$z]);
                    $ni_ln_ni[$z]=-1*$ni[$z]*$ln_ni[$z];
                    $h_aksen+=$ni_ln_ni[$z];
                    $ni[$z]=round($ni[$z],3);
                    $ln_ni[$z]=round($ln_ni[$z],3);
                    $ni_ln_ni[$z]=round($ni_ln_ni[$z],3);
                  }
                  $rata_h_aksen[$i]=$h_aksen;
                  $rata_h_aksen[$i]=round($rata_h_aksen[$i],3);
                  $h_aksen=round($h_aksen,3);
                }
                else{
                  $h_aksen=0;
                  $rata_h_aksen[$i]=0;
                }
              }
             else{
               $pesan = "Data pohon tidak ada";
               $id_klastersss = $id;
               return view('auditor.pengukuran_kurang',[
                  'pesan'=>$pesan,
                  'id_klaster' => $id_klastersss,
               ]);
             }
            }
            else{

              $h_aksen=0;
              $rata_h_aksen[$i]=0;
            }

              // data J' pohon
              if($p_jpliu!=""){


              if(count($jumlah_pohon)!=0){
                $data_biodiv_pohon = DB::table('data_tanaman_plot')
                ->where('id_plot','=',$id_plot[$i]->id_plot)
                ->where('status','=','1')
                ->where('pengukuran_ke','=',$pengukuran_ke)
                ->get();

                $jmlh_phn = count($data_biodiv_pohon);
                $jenis_pohon=DB::table('data_tanaman_plot')
                ->select(DB::raw("table_master_jenis_tanaman.nama_tanaman,data_tanaman_plot.id_master_jenis_tanaman, COUNT(*) as jumlah"))
                ->join('table_master_jenis_tanaman','table_master_jenis_tanaman.id_jenis_tanaman','=','data_tanaman_plot.id_master_jenis_tanaman')
                ->where('data_tanaman_plot.id_plot','=',$id_plot[$i]->id_plot)
                ->where('status','=','1')
                ->where('pengukuran_ke','=',$pengukuran_ke)
                ->groupBy(DB::raw('table_master_jenis_tanaman.nama_tanaman,data_tanaman_plot.id_master_jenis_tanaman'))
                ->orderBy('table_master_jenis_tanaman.nama_tanaman')
                ->get();

                $h_aksen=0;
                $tot_jpliu=0;
                if($jmlh_phn!=0){
                  for($z=0;$z<count($jenis_pohon);$z++){
                    $n[$z]=$jenis_pohon[$z]->jumlah;
                    $ni[$z]=$n[$z]/$jmlh_phn;
                    $ln_ni[$z]=log($ni[$z]);
                    $ni_ln_ni[$z]=-1*$ni[$z]*$ln_ni[$z];
                    $h_aksen+=$ni_ln_ni[$z];
                    $ni[$z]=round($ni[$z],3);
                    $ln_ni[$z]=round($ln_ni[$z],3);
                    $ni_ln_ni[$z]=round($ni_ln_ni[$z],3);
                    if(count($jenis_pohon)==1 || count($jenis_pohon)==0){
                      $j_pliu[$z] = 0;
                    }
                    else{
                      $j_pliu[$z] = $ni_ln_ni[$z]/log(count($jenis_pohon));
                    }
                    $tot_jpliu+=$j_pliu[$z];
                    $j_pliu[$z]=round($j_pliu[$z],3);
                  }
                  $rata_j_pliu[$i]=$tot_jpliu/count($jenis_pohon);
                  $rata_j_pliu[$i]=round($rata_j_pliu[$i],3);
                  $rata_h_aksen[$i]=$h_aksen;
                  $rata_h_aksen[$i]=round($rata_h_aksen[$i],3);
                  $h_aksen=round($h_aksen,3);
                }
                else{
                  $rata_j_pliu=0;
                  $j_pliu=0;
                }
              }
             else{
               $pesan = "Data pohon tidak ada";
               $id_klastersss = $id;
               return view('auditor.pengukuran_kurang',[
                  'pesan'=>$pesan,
                  'id_klaster' => $id_klastersss,
               ]);
             }
            }
            else{
              $rata_j_pliu[$i]=0;
              $j_pliu=0;
            }

            // data DMg pohon
            if($p_dmg!=""){

            if(count($jumlah_pohon)!=0){
              $data_biodiv_pohon = DB::table('data_tanaman_plot')
              ->where('id_plot','=',$id_plot[$i]->id_plot)
              ->where('status','=','1')
              ->where('pengukuran_ke','=',$pengukuran_ke)
              ->get();

              $jmlh_phn = count($data_biodiv_pohon);
              $jenis_pohon=DB::table('data_tanaman_plot')
              ->select(DB::raw("table_master_jenis_tanaman.nama_tanaman,data_tanaman_plot.id_master_jenis_tanaman, COUNT(*) as jumlah"))
              ->join('table_master_jenis_tanaman','table_master_jenis_tanaman.id_jenis_tanaman','=','data_tanaman_plot.id_master_jenis_tanaman')
              ->where('data_tanaman_plot.id_plot','=',$id_plot[$i]->id_plot)
              ->where('status','=','1')
              ->where('pengukuran_ke','=',$pengukuran_ke)
              ->groupBy(DB::raw('table_master_jenis_tanaman.nama_tanaman,data_tanaman_plot.id_master_jenis_tanaman'))
              ->orderBy('table_master_jenis_tanaman.nama_tanaman')
              ->get();

              $h_aksen=0;
              $tot_dmg=0;

              if($jmlh_phn>1){
                for($z=0;$z<count($jenis_pohon);$z++){
                  $n[$z]=$jenis_pohon[$z]->jumlah;
                  $ni[$z]=$n[$z]/$jmlh_phn;
                  $ln_ni[$z]=log($ni[$z]);
                  $ni_ln_ni[$z]=-1*$ni[$z]*$ln_ni[$z];
                  $h_aksen+=$ni_ln_ni[$z];
                  $ni[$z]=round($ni[$z],3);
                  $ln_ni[$z]=round($ln_ni[$z],3);
                  $ni_ln_ni[$z]=round($ni_ln_ni[$z],3);
                  $d_mg[$z] = (count($jenis_pohon)-1)/log($jmlh_phn);
                  $tot_dmg=$d_mg[$z];
                  $d_mg[$z]=round($d_mg[$z],3);
                }
                $rata_dmg[$i]=$tot_dmg;
                $rata_dmg[$i]=round($rata_dmg[$i],3);
                $rata_h_aksen[$i]=$h_aksen;
                $rata_h_aksen[$i]=round($rata_h_aksen[$i],3);
                $h_aksen=round($h_aksen,3);
              }
              else{
                $rata_dmg[$i]=0;
                $d_mg=0;
              }
            }
           else{
             $pesan = "Data pohon tidak ada";
             $id_klastersss = $id;
             return view('auditor.pengukuran_kurang',[
                'pesan'=>$pesan,
                'id_klaster' => $id_klastersss,
             ]);
           }
          }
          else{
            $rata_dmg[$i]=0;
            $d_mg=0;
          }

              // data biodiversitas fauna
              $h_aksenf=0;
              if($haksenf=="" && $p_jpliuf=="" && $p_dmgf==""){
                $nf=0;
                $nif=0;
                $ln_nif=0;
                $ni_ln_nif=0;
              }
              //jenis fauna
              $jumlah_fauna=DB::table('data_fauna')
              ->join(
              'tabel_master_fauna',
              'tabel_master_fauna.id_jenis_fauna','=','data_fauna.id_master_fauna'
              )
              ->where('id_klaster_plot_fauna','=',$id)
              ->where('data_fauna.pengukuran_ke','=',$pengukuran_ke)
              ->get();
              if($haksenf!=""){

                if(count($jumlah_fauna)!=0){
                  $total_fauna=0;
                  $tot_data_fauna[$i]=count($jumlah_fauna);
                  for($s=0;$s<$tot_data_fauna[$i];$s++){
                    $total_fauna+=$jumlah_fauna[$s]->jumlah;
                  }

                  for($t=0;$t<$tot_data_fauna[$i];$t++){
                    $nf[$t]=$jumlah_fauna[$t]->jumlah;
                    $nif[$t]=$nf[$t]/$total_fauna;
                    $ln_nif[$t]=log($nif[$t]);
                    $ni_ln_nif[$t]=-1*$nif[$t]*$ln_nif[$t];
                    $h_aksenf+=$ni_ln_nif[$t];
                    $nif[$t]=round($nif[$t],3);
                    $ln_nif[$t]=round($ln_nif[$t],3);
                    $ni_ln_nif[$t]=round($ni_ln_nif[$t],3);
                  }
                  $rata_h_aksenf=$h_aksenf;
                  $rata_h_aksenf=round($rata_h_aksenf,3);
                  $h_aksenf=round($h_aksenf,3);
                }
                else{
                  $pesan = "Data Fauna tidak ada";
                  $id_klastersss = $id;
                  return view('auditor.pengukuran_kurang',[
                     'pesan'=>$pesan,
                     'id_klaster' => $id_klastersss,
                  ]);
                }
              }
              else{
                $h_aksenf=0;
                $rata_h_aksenf=0;
              }
             //

             // data J' fauna
             $h_aksenf=0;
             $tot_jpliuf=0;
             if($p_jpliuf!=""){


               if(count($jumlah_fauna)!=0){
                 $total_fauna=0;
                 $tot_data_fauna[$i]=count($jumlah_fauna);
                 for($s=0;$s<$tot_data_fauna[$i];$s++){
                   $total_fauna+=$jumlah_fauna[$s]->jumlah;
                 }

                 for($t=0;$t<$tot_data_fauna[$i];$t++){
                   $nf[$t]=$jumlah_fauna[$t]->jumlah;
                   $nif[$t]=$nf[$t]/$total_fauna;
                   $ln_nif[$t]=log($nif[$t]);
                   $ni_ln_nif[$t]=-1*$nif[$t]*$ln_nif[$t];
                   $h_aksenf+=$ni_ln_nif[$t];
                   $nif[$t]=round($nif[$t],3);
                   $ln_nif[$t]=round($ln_nif[$t],3);
                   $ni_ln_nif[$t]=round($ni_ln_nif[$t],3);
                   if($tot_data_fauna[$i]==0 || $tot_data_fauna[$i]==1 ){
                      $j_pliuf[$t] = 0;
                   }
                   else{
                     $j_pliuf[$t] = $ni_ln_nif[$t]/log($tot_data_fauna[$i]);
                   }
                   $tot_jpliuf+=$j_pliuf[$t];
                   $j_pliuf[$t]=round($j_pliuf[$t],3);
                 }
                 $rata_j_pliuf=$tot_jpliuf/$tot_data_fauna[$i];
                 $rata_j_pliuf=round($rata_j_pliuf,3);
                 $rata_h_aksenf=$h_aksenf;
                 $rata_h_aksenf=round($rata_h_aksenf,3);
                 $h_aksenf=round($h_aksenf,3);
               }
               else{
                 $pesan = "Data Fauna tidak ada";
                 $id_klastersss = $id;
                 return view('auditor.pengukuran_kurang',[
                    'pesan'=>$pesan,
                    'id_klaster' => $id_klastersss,
                 ]);
               }
             }
             else{
               $rata_j_pliuf=0;
               $j_pliuf=0;
             }
             //

             // data DMg fauna
             $tot_dmgf=0;
             if($p_dmgf!=""){


               if(count($jumlah_fauna)!=0){
                 $total_fauna=0;
                 $tot_data_fauna[$i]=count($jumlah_fauna);
                 for($s=0;$s<$tot_data_fauna[$i];$s++){
                   $total_fauna+=$jumlah_fauna[$s]->jumlah;
                 }

                 for($t=0;$t<$tot_data_fauna[$i];$t++){
                   $nf[$t]=$jumlah_fauna[$t]->jumlah;
                   $nif[$t]=$nf[$t]/$total_fauna;
                   $ln_nif[$t]=log($nif[$t]);
                   $ni_ln_nif[$t]=-1*$nif[$t]*$ln_nif[$t];
                   $h_aksenf+=$ni_ln_nif[$t];
                   $nif[$t]=round($nif[$t],3);
                   $ln_nif[$t]=round($ln_nif[$t],3);
                   $ni_ln_nif[$t]=round($ni_ln_nif[$t],3);
                   $d_mgf[$t]=0;
                   if($total_fauna>1){
                     $d_mgf[$t] = ($tot_data_fauna[$i]-1)/log($total_fauna);
                   }
                   $tot_dmgf+=$d_mgf[$t];
                   $d_mgf[$t]=round($d_mgf[$t],3);
                 }
                 $rata_dmgf=$tot_dmgf/$tot_data_fauna[$i];
                 $rata_dmgf=round($rata_dmgf,3);
                 $rata_h_aksenf=$h_aksenf;
                 $rata_h_aksenf=round($rata_h_aksenf,3);
                 $h_aksenf=round($h_aksenf,3);
               }
               else{
                 $pesan = "Data Fauna tidak ada";
                 $id_klastersss = $id;
                 return view('auditor.pengukuran_kurang',[
                    'pesan'=>$pesan,
                    'id_klaster' => $id_klastersss,
                 ]);
               }
             }
             else{
               $d_mgf=0;
               $rata_dmgf=0;
             }

            //

              }
            }
            else{
              // error handling
            }

          }
            // hanya pembulatan
             for ($a=0;$a<count($id_pengukuran1);$a++){
               $tli_f[$a]=round(($tli_f[$a]),3);
               $vcr_f[$a]=round(($vcr_f[$a]),3);
               $lbds_f[$a]=round(($lbds_f[$a]),3);
               $volume_f[$a]=round(($volume_f[$a]),3);
             }
             if($p_lbds!=""){
                 $const_lbds=(max($lbds_f)-min($lbds_f))/10;
                 $range_lbds_l=[];
                 $range_lbds_init=min($lbds_f);
                 $range_lbds_l[0]=min($lbds_f);
                 $range_lbds_r=[];
                 for ($i=1;$i<10;$i++){
                   $range_lbds_init+=$const_lbds;
                   $range_lbds_l[$i]=round($range_lbds_init,3);
                   $range_lbds_r[$i]=round(($range_lbds_l[$i]-0.001),3);
                 }
                 $range_lbds_r[10]=round(max($lbds_f),3);

                 for ($i=0; $i < count($id_plot); $i++) {
                   $skor_lbds[$i]=1;
                   for ($j=0; $j < count($range_lbds_l); $j++) {
                     if($lbds_f[$i]>=$range_lbds_l[$j] && $lbds_f[$i]<=$range_lbds_r[$j+1]){
                       break;
                     }
                     if($skor_lbds[$i]<10){
                     $skor_lbds[$i]++;
                   }
                   }
                 }
               }
               else{
                 $range_lbds_l=0;
                 $range_lbds_r=0;
                 for ($i=0;$i<count($id_plot);$i++){
                   $skor_lbds[$i]=0;
               }
             }

             if($p_volume!=""){
                 $const_volume=(max($volume_f)-min($volume_f))/10;
                 $range_volume_l=[];
                 $range_volume_init=min($volume_f);
                 $range_volume_l[0]=min($volume_f);
                 $range_volume_r=[];
                 for ($i=1;$i<10;$i++){
                   $range_volume_init+=$const_volume;
                   $range_volume_l[$i]=round($range_volume_init,3);
                   $range_volume_r[$i]=round(($range_volume_l[$i]-0.001),3);
                 }
                 $range_volume_r[10]=round(max($volume_f),3);

                 for ($i=0; $i < count($id_plot); $i++) {
                   $skor_volume[$i]=1;
                   for ($j=0; $j < count($range_volume_l); $j++) {
                     if($volume_f[$i]>=$range_volume_l[$j] && $volume_f[$i]<=$range_volume_r[$j+1]){
                       break;
                     }
                     if($skor_volume[$i]<10){
                     $skor_volume[$i]++;
                   }
                   }
                 }
               }
               else{
                 $range_volume_l=0;
                 $range_volume_r=0;
                 for ($i=0;$i<count($id_plot);$i++){
                   $skor_volume[$i]=0;
               }
             }

               if($p_kerusakan!=""){
                 $const_tli=(max($tli_f)-min($tli_f))/10;
                   $range_tli_r=[];
                   $range_tli_init=max($tli_f);
                   $range_tli_r[0]=max($tli_f);
                   $range_tli_l=[];
                   for ($i=1;$i<10;$i++){
                     $range_tli_init-=$const_tli;
                     $range_tli_r[$i]=round($range_tli_init,3);
                     $range_tli_l[$i]=round(($range_tli_r[$i]+0.001),3);
                   }
                   $range_tli_l[10]=round(min($tli_f),3);

                   for ($i=0; $i < count($id_plot); $i++) {
                     $skor_tli[$i]=0;
                     for ($j=0; $j < count($range_tli_l); $j++) {
                       $skor_tli[$i]++;
                       if($tli_f[$i]>=$range_tli_l[$j+1] && $tli_f[$i]<=$range_tli_r[$j]){
                         break;
                       }
                     }
                   }
                 }
               else{
                 $range_tli_l=0;
                 $range_tli_r=0;
                 for ($i=0;$i<count($id_plot);$i++){
                   $skor_tli[$i]=0;
               }
             }
               if($p_ktjk!=""){
                   $const_vcr=(max($vcr_f)-min($vcr_f))/10;
                     $range_vcr_l=[];
                     $range_vcr_init=min($vcr_f);
                     $range_vcr_l[0]=min($vcr_f);
                     $range_vcr_r=[];
                     for ($i=1;$i<10;$i++){
                       $range_vcr_init+=$const_vcr;
                       $range_vcr_l[$i]=round($range_vcr_init,3);
                       $range_vcr_r[$i]=round(($range_vcr_l[$i]-0.001),3);
                     }
                     $range_vcr_r[10]=round(max($vcr_f),3);

                     for ($i=0; $i < count($id_plot); $i++) {
                       $skor_vcr[$i]=1;
                       for ($j=0; $j < count($range_vcr_l); $j++) {
                         if($vcr_f[$i]>=$range_vcr_l[$j] && $vcr_f[$i]<=$range_vcr_r[$j+1]){
                           break;
                         }
                         $skor_vcr[$i]++;
                       }
                     }
                   }
             else{
               $range_vcr_l=0;
               $range_vcr_r=0;
               for ($i=0; $i < count($id_plot); $i++) {
                 $skor_vcr[$i]=0;
               }
             }

             //H'
             if($haksenp!=""){
                 $const_h_aksen=(max($rata_h_aksen)-min($rata_h_aksen))/10;
                 $range_h_aksen_l=[];
                 $range_h_aksen_init=min($rata_h_aksen);
                 $range_h_aksen_l[0]=min($rata_h_aksen);
                 $range_h_aksen_r=[];
                 for ($i=1;$i<10;$i++){
                   $range_h_aksen_init+=$const_h_aksen;
                   $range_h_aksen_l[$i]=round($range_h_aksen_init,3);
                   $range_h_aksen_r[$i]=round(($range_h_aksen_l[$i]-0.001),3);
                 }
                 $range_h_aksen_r[10]=round(max($rata_h_aksen),3);

                 for ($i=0; $i < count($id_plot); $i++) {
                   $skor_h_aksen[$i]=1;
                   for ($j=0; $j < count($range_h_aksen_l); $j++) {
                     if($rata_h_aksen[$i]>=$range_h_aksen_l[$j] && $rata_h_aksen[$i]<=$range_h_aksen_r[$j+1]){
                       break;
                     }
                     if($skor_h_aksen[$i]<10){
                     $skor_h_aksen[$i]++;
                   }
                   }
                 }
               }
               else{
                 $range_h_aksen_l=0;
                 $range_h_aksen_r=0;
                 for ($i=0;$i<count($id_plot);$i++){
                   $skor_h_aksen[$i]=0;
               }
             }

             //J'
             if($p_jpliu!=""){
                 $const_j_pliu=(max($rata_j_pliu)-min($rata_j_pliu))/10;
                 $range_j_pliu_l=[];
                 $range_j_pliu_init=min($rata_j_pliu);
                 $range_j_pliu_l[0]=min($rata_j_pliu);
                 $range_j_pliu_r=[];
                 for ($i=1;$i<10;$i++){
                   $range_j_pliu_init+=$const_j_pliu;
                   $range_j_pliu_l[$i]=round($range_j_pliu_init,3);
                   $range_j_pliu_r[$i]=round(($range_j_pliu_l[$i]-0.001),3);
                 }
                 $range_j_pliu_r[10]=round(max($rata_j_pliu),3);

                 for ($i=0; $i < count($id_plot); $i++) {
                   $skor_j_pliu[$i]=1;
                   for ($j=0; $j < count($range_j_pliu_l); $j++) {
                     if($rata_j_pliu[$i]>=$range_j_pliu_l[$j] && $rata_j_pliu[$i]<=$range_j_pliu_r[$j+1]){
                       break;
                     }
                     if($skor_j_pliu[$i]<10){
                     $skor_j_pliu[$i]++;
                   }
                   }
                 }
               }
               else{
                 $range_j_pliu_l=0;
                 $range_j_pliu_r=0;
                 for ($i=0;$i<count($id_plot);$i++){
                   $skor_j_pliu[$i]=0;
               }
             }

             //Dmg
             if($p_dmg!=""){
                 $const_dmg=(max($rata_dmg)-min($rata_dmg))/10;
                 $range_dmg_l=[];
                 $range_dmg_init=min($rata_dmg);
                 $range_dmg_l[0]=min($rata_dmg);
                 $range_dmg_r=[];
                 for ($i=1;$i<10;$i++){
                   $range_dmg_init+=$const_dmg;
                   $range_dmg_l[$i]=round($range_dmg_init,3);
                   $range_dmg_r[$i]=round(($range_dmg_l[$i]-0.001),3);
                 }
                 $range_dmg_r[10]=round(max($rata_dmg),3);

                 for ($i=0; $i < count($id_plot); $i++) {
                   $skor_dmg[$i]=1;
                   for ($j=0; $j < count($range_dmg_l); $j++) {
                     if($rata_dmg[$i]>=$range_dmg_l[$j] && $rata_dmg[$i]<=$range_dmg_r[$j+1]){
                       break;
                     }
                     if($skor_dmg[$i]<10){
                     $skor_dmg[$i]++;
                   }
                   }
                 }
               }
               else{
                 $range_dmg_l=0;
                 $range_dmg_r=0;
                 for ($i=0;$i<count($id_plot);$i++){
                   $skor_dmg[$i]=0;
               }
             }

                 for ($i=0; $i < count($id_plot); $i++) {
                   if($pengukuran_ke==1){
                     $nt_kr=DB::table('nilai_tertimbang_copy')
                     ->where('id_data_klaster','=',$id_data_klaster)->get();

                     if(count($nt_kr)==0){
                       $nt_ktpk[$i]=0;
                       $nt_kerusakan[$i]=0;
                       $nt_produktivitas[$i]=0;
                       $nt_ktjk[$i]=0;
                       $nt_biodiv[$i]=0;
                     }
                     else{
                       $nt_kr=DB::table('nilai_tertimbang_copy')
                       ->where('id_data_klaster','=',$id_data_klaster)->first();
                       $nt_ktpk[$i]=$nt_kr->nilai_ktpk;
                       $nt_kerusakan[$i]=$nt_kr->nilai_kphn;
                       $nt_produktivitas[$i]=$nt_kr->nilai_prod;
                       $nt_ktjk[$i]=$nt_kr->nilai_ktjk;
                       $nt_biodiv[$i]=$nt_kr->nilai_kjpb;
                     }
                   }

                   else{
                     $nt_kr=DB::table('nilai_tertimbang_copy')
                     ->where('id_data_klaster','=',$id_data_klaster2->id_data_klaster)->get();

                     if(count($nt_kr)==0){
                       $nt_ktpk[$i]=0;
                       $nt_kerusakan[$i]=0;
                       $nt_produktivitas[$i]=0;
                       $nt_ktjk[$i]=0;
                       $nt_biodiv[$i]=0;
                     }
                     else{
                       $nt_kr=DB::table('nilai_tertimbang_copy')
                       ->where('id_data_klaster','=',$id_data_klaster2->id_data_klaster)->first();
                       $nt_ktpk[$i]=$nt_kr->nilai_ktpk;
                       $nt_kerusakan[$i]=$nt_kr->nilai_kphn;
                       $nt_produktivitas[$i]=$nt_kr->nilai_prod;
                       $nt_ktjk[$i]=$nt_kr->nilai_ktjk;
                       $nt_biodiv[$i]=$nt_kr->nilai_kjpb;
                     }
                   }

                }

                   //  nilai akhir Produktivitas lbds
                   for ($i=0; $i < count($id_plot); $i++) {
                     $na_lbds[$i]=$skor_lbds[$i]*$nt_produktivitas[$i];
                   }
                   //  nilai akhir Produktivitas volume
                   for ($i=0; $i < count($id_plot); $i++) {
                     $na_volume[$i]=$skor_volume[$i]*$nt_produktivitas[$i];
                   }
                   //  nilai akhir kerusakan pohon
                   for ($i=0; $i < count($id_plot); $i++) {
                     $na_kerusakan[$i]=$skor_tli[$i]*$nt_kerusakan[$i];
                   }
                   //  nilai akhir kondisi tajuk
                   for ($i=0; $i < count($id_plot); $i++) {
                     $na_tajuk[$i]=$skor_vcr[$i]*$nt_ktjk[$i];
                   }

                   //  nilai akhir H'
                   for ($i=0; $i < count($id_plot); $i++) {
                     $na_h_aksen[$i]=$skor_h_aksen[$i]*$nt_biodiv[$i];
                   }

                   //  nilai akhir J'
                   for ($i=0; $i < count($id_plot); $i++) {
                     $na_j_pliu[$i]=$skor_j_pliu[$i]*$nt_biodiv[$i];
                   }

                   //  nilai akhir Dmg'
                   for ($i=0; $i < count($id_plot); $i++) {
                     $na_dmg[$i]=$skor_dmg[$i]*$nt_biodiv[$i];
                   }

                   // nilai total indikator
                   for ($i=0; $i < count($id_plot); $i++) {
                     $na_total[$i]=$na_kerusakan[$i]+$na_tajuk[$i]+$na_lbds[$i]+$na_volume[$i]+$na_h_aksen[$i]+$na_j_pliu[$i]+$na_dmg[$i];
                   }

                   // range skor untuk nilai akhir
                   $const_nks=(max($na_total)-min($na_total))/3;
                   $range_nks_l=[];
                   $range_nks_init=min($na_total);
                   $range_nks_l[0]=min($na_total);
                   $range_nks_r=[];
                   for ($i=1;$i<3;$i++){
                     $range_nks_init+=$const_nks;
                     $range_nks_l[$i]=round($range_nks_init,3);
                     $range_nks_r[$i]=round(($range_nks_l[$i]-0.001),3);
                   }
                   $range_nks_r[3]=round(max($na_total),3);

                   // skor klaster nilai akhir
                   for ($i=0; $i < count($id_plot); $i++) {
                     $skor_nks[$i]=1;
                     for ($j=0; $j < count($range_nks_l); $j++) {
                       if($na_total[$i]>=$range_nks_l[$j] && $na_total[$i]<=$range_nks_r[$j+1]){
                         break;
                       }
                       $skor_nks[$i]++;
                     }
                   }

                   for ($i=0; $i < count($id_plot); $i++) {
                   if($skor_nks[$i]==1){$nilai_skor[$i]="Buruk";}
                   else if($skor_nks[$i]==2){$nilai_skor[$i]="Sedang";}
                   else {$nilai_skor[$i]="Baik";}
                 }

                   $kondisi[0]="Buruk";
                   $kondisi[1]="Sedang";
                   $kondisi[2]="Baik";

       return view('auditor.nilai.detail_skoring_kesehatan_hutan',[
         'id_plot' => $id_plot,
         'kode_klaster_plot'=>$kode_klaster_plot,
         'jumlah_plot' => $jumlah_plot,
         'pengukuran_ke' => $pengukuran_ke,
         'data_ktk_kimia' => $data_ktk_kimia,
         'jumlah_pohon'=>$jumlah_pohon,
         'jumlah_fauna'=>$jumlah_fauna,
         'jmlh_param' =>$jmlh_param,
         'p_lbds'=>$p_lbds,
         'p_volume'=>$p_volume,
         'p_kerusakan'=>$p_kerusakan,
         'p_ktjk'=>$p_ktjk,
         'sifat_kimia'=>$sifat_kimia,
         'p_kimia'=>$p_kimia,
         'p_fisik'=>$p_fisik,
         'haksenp' =>$haksenp,
         'p_jpliu' =>$p_jpliu,
         'p_dmg' =>$p_dmg,
         'haksenf' =>$haksenf,
         'p_jpliuf' =>$p_jpliuf,
         'p_dmgf' =>$p_dmgf,

         'nilai_lbds' => $lbds_f,
         'range_lbds_l' => $range_lbds_l,
         'range_lbds_r' => $range_lbds_r,
         'skor_lbds' => $skor_lbds,
         'na_lbds' => $na_lbds,

         'nilai_volume' => $volume_f,
         'range_volume_l' => $range_volume_l,
         'range_volume_r' => $range_volume_r,
         'skor_volume' => $skor_volume,
         'na_volume' => $na_volume,

         'nilai_tli' => $tli_f,
         'range_tli_l' => $range_tli_l,
         'range_tli_r' => $range_tli_r,
         'skor_tli' => $skor_tli,
         'na_kerusakan' => $na_kerusakan,

         'nilai_vcr' => $vcr_f,
         'range_vcr_l' => $range_vcr_l,
         'range_vcr_r' => $range_vcr_r,
         'skor_vcr' => $skor_vcr,
         'na_tajuk' => $na_tajuk,

         'range_h_aksen_l' => $range_h_aksen_l,
         'range_h_aksen_r' => $range_h_aksen_r,
         'skor_h_aksen' => $skor_h_aksen,
         'na_h_aksen' => $na_h_aksen,

         'range_j_pliu_l' => $range_j_pliu_l,
         'range_j_pliu_r' => $range_j_pliu_r,
         'skor_j_pliu' => $skor_j_pliu,
         'na_j_pliu' => $na_j_pliu,

         'range_dmg_l' => $range_dmg_l,
         'range_dmg_r' => $range_dmg_r,
         'skor_dmg' => $skor_dmg,
         'na_dmg' => $na_dmg,

         'nt_ktpk' => $nt_ktpk,
         'nt_kerusakan' => $nt_kerusakan,
         'nt_produktivitas' => $nt_produktivitas,
         'nt_ktjk' => $nt_ktjk,
         'nt_biodiv' => $nt_biodiv,

         'n' => $n,
         'ni' => $ni,
         'ln_ni' => $ln_ni,
         'ni_ln_ni' => $ni_ln_ni,
         'h_aksen' => $h_aksen,
         'j_pliu' => $j_pliu,
         'd_mg' => $d_mg,
         'rata_h_aksen' => $rata_h_aksen,
         'rata_j_pliu' => $rata_j_pliu,
         'rata_dmg' => $rata_dmg,

         'nf' => $nf,
         'nif' => $nif,
         'ln_nif' => $ln_nif,
         'ni_ln_nif' => $ni_ln_nif,
         'h_aksenf' => $h_aksenf,
         'j_pliuf' => $j_pliuf,
         'd_mgf' => $d_mgf,
         'rata_h_aksenf' => $rata_h_aksenf,
         'rata_j_pliuf' => $rata_j_pliuf,
         'rata_dmgf' => $rata_dmgf,

         'na_total' => $na_total,
         'range_nks_l' => $range_nks_l,
         'range_nks_r' => $range_nks_r,
         'skor_nks' => $skor_nks,
         'kondisi' => $kondisi,
         'nilai_skor' => $nilai_skor,
         'data_fisik' => $data_fisik,

       ]);
     }

     public function detail_plot(Request $req){
       $id_plot = $req->id_plot;
       $id_klaster = DB::table('tbl_plot')
       ->join('tbl_klaster_plot','tbl_klaster_plot.id_klaster_plot','=','tbl_plot.id_klaster_plot')
       ->where('tbl_plot.id_plot','=',$id_plot)->first();
       $id_klaster_plot = $id_klaster->id_klaster_plot;
       $pengukuran_ke = $req->pengukuran_ke;


       $p_lbds=$req->p_lbds;
       $p_volume=$req->p_volume;
       $p_kerusakan=$req->p_kerusakan;
       $p_ktjk=$req->p_ktjk;
       $p_kimia=$req->p_kimia;
       $sifat_kimia=$req->input('sifat-sifat_kimia');
       $p_fisik = $req->p_fisik;
       $haksenp=$req->haksenp;
       $haksenf=$req->haksenf;
       $p_jpliu = $req->p_jpliu;
       $p_dmg = $req->p_dmg;

       $ni[0]=0;
       $ln_ni[0]=0;
       $ni_ln_ni[0]=0;

       $id_pengukuran=DB::table('pengukuran_master')->where([['id_plot',$id_plot],['pengukuran_ke',$pengukuran_ke]])->first();

       $data_pohon=DB::table('pengukuran_master')
       ->join('data_tanaman_plot','data_tanaman_plot.id_plot','=','pengukuran_master.id_plot')
       ->join('table_master_jenis_tanaman','table_master_jenis_tanaman.id_jenis_tanaman','=','data_tanaman_plot.id_master_jenis_tanaman')
       ->leftjoin('lbds','data_tanaman_plot.id_tanaman_plot','=','lbds.id_tanaman')
       ->leftjoin('kerusakan_pohon','data_tanaman_plot.id_tanaman_plot','=','kerusakan_pohon.id_tanaman')
       ->leftjoin('kondisi_tajuk','data_tanaman_plot.id_tanaman_plot','=','kondisi_tajuk.id_tanaman')
       ->where('pengukuran_master.id_pengukuran','=',$id_pengukuran->id_pengukuran)
       ->where('data_tanaman_plot.pengukuran_ke','=',$pengukuran_ke)
       ->select('table_master_jenis_tanaman.nama_tanaman','table_master_jenis_tanaman.nama_latin','lbds.Hasil_LBDS','lbds.v','kerusakan_pohon.tli','kondisi_tajuk.vcri')
       ->get();

       $jumlah_pohon=DB::table('data_tanaman_plot')
       ->select(DB::raw("table_master_jenis_tanaman.nama_tanaman,table_master_jenis_tanaman.nama_latin,COUNT(*) as jumlah"))
       ->join(
       'table_master_jenis_tanaman',
       'table_master_jenis_tanaman.id_jenis_tanaman','=','data_tanaman_plot.id_master_jenis_tanaman'
       )
       ->where('id_plot','=',$id_plot)
       ->where('data_tanaman_plot.pengukuran_ke','=',$pengukuran_ke)
       ->where('data_tanaman_plot.status','=','1')
       ->groupBy(DB::raw('table_master_jenis_tanaman.nama_tanaman,table_master_jenis_tanaman.nama_latin'))
       ->get();

       if(count($jumlah_pohon)>=1){
         $data_biodiv_pohon = DB::table('data_tanaman_plot')
         ->where('id_plot','=',$id_plot)
         ->where('status','=','1')
         ->where('data_tanaman_plot.pengukuran_ke','=',$pengukuran_ke)
         ->get();

         $jmlh_phn = count($data_biodiv_pohon);
         $jenis_pohon=DB::table('data_tanaman_plot')
         ->select(DB::raw("table_master_jenis_tanaman.nama_tanaman,data_tanaman_plot.id_master_jenis_tanaman, COUNT(*) as jumlah"))
         ->join('table_master_jenis_tanaman','table_master_jenis_tanaman.id_jenis_tanaman','=','data_tanaman_plot.id_master_jenis_tanaman')
         ->where('data_tanaman_plot.id_plot','=',$id_plot)
         ->where('status','=','1')
         ->where('pengukuran_ke','=',$pengukuran_ke)
         ->groupBy(DB::raw('table_master_jenis_tanaman.nama_tanaman,data_tanaman_plot.id_master_jenis_tanaman'))
         ->orderBy('table_master_jenis_tanaman.nama_tanaman')
         ->get();

         $h_aksen=0;
         if($jmlh_phn!=0){
           for($z=0;$z<count($jenis_pohon);$z++){
             $n[$z]=$jenis_pohon[$z]->jumlah;
             $ni[$z]=$n[$z]/$jmlh_phn;
             $ln_ni[$z]=log($ni[$z]);
             $ni_ln_ni[$z]=-1*$ni[$z]*$ln_ni[$z];
             $h_aksen+=$ni_ln_ni[$z];
             $ni[$z]=round($ni[$z],3);
             $ln_ni[$z]=round($ln_ni[$z],3);
             $ni_ln_ni[$z]=round($ni_ln_ni[$z],3);
           }
           $rata_h_aksen=$h_aksen;
           $rata_h_aksen=round($rata_h_aksen,3);
           $h_aksen=round($h_aksen,3);
         }
         else{
           $h_aksen=0;
           $rata_h_aksen=0;
         }
       }
       else{
         $h_aksen=0;
         $rata_h_aksen=0;
       }

       // data J' pohon
       if($p_jpliu!=""){


       if(count($jumlah_pohon)!=0){
         $data_biodiv_pohon = DB::table('data_tanaman_plot')
         ->where('id_plot','=',$id_plot)
         ->where('status','=','1')
         ->where('pengukuran_ke','=',$pengukuran_ke)
         ->get();

         $jmlh_phn = count($data_biodiv_pohon);
         $jenis_pohon=DB::table('data_tanaman_plot')
         ->select(DB::raw("table_master_jenis_tanaman.nama_tanaman,data_tanaman_plot.id_master_jenis_tanaman, COUNT(*) as jumlah"))
         ->join('table_master_jenis_tanaman','table_master_jenis_tanaman.id_jenis_tanaman','=','data_tanaman_plot.id_master_jenis_tanaman')
         ->where('data_tanaman_plot.id_plot','=',$id_plot)
         ->where('status','=','1')
         ->where('pengukuran_ke','=',$pengukuran_ke)
         ->groupBy(DB::raw('table_master_jenis_tanaman.nama_tanaman,data_tanaman_plot.id_master_jenis_tanaman'))
         ->orderBy('table_master_jenis_tanaman.nama_tanaman')
         ->get();

         $h_aksen=0;
         $tot_jpliu=0;
         if($jmlh_phn!=0){
           for($z=0;$z<count($jenis_pohon);$z++){
             $n[$z]=$jenis_pohon[$z]->jumlah;
             $ni[$z]=$n[$z]/$jmlh_phn;
             $ln_ni[$z]=log($ni[$z]);
             $ni_ln_ni[$z]=-1*$ni[$z]*$ln_ni[$z];
             $h_aksen+=$ni_ln_ni[$z];
             $ni[$z]=round($ni[$z],3);
             $ln_ni[$z]=round($ln_ni[$z],3);
             $ni_ln_ni[$z]=round($ni_ln_ni[$z],3);
             if(count($jenis_pohon)==1 || count($jenis_pohon)==0){
               $j_pliu[$z] = 0;
             }
             else{
               $j_pliu[$z] = $ni_ln_ni[$z]/log(count($jenis_pohon));
             }
             $tot_jpliu+=$j_pliu[$z];
             $j_pliu[$z]=round($j_pliu[$z],3);
           }
           $rata_j_pliu=$tot_jpliu/count($jenis_pohon);
           $rata_j_pliu=round($rata_j_pliu,3);
           $rata_h_aksen=$h_aksen;
           $rata_h_aksen=round($rata_h_aksen,3);
           $h_aksen=round($h_aksen,3);
         }
         else{
           $rata_j_pliu=0;
           $j_pliu=0;
         }
       }
      else{
        $pesan = "Data pohon tidak ada";
        $id_klastersss = $id;
        return view('auditor.pengukuran_kurang',[
           'pesan'=>$pesan,
           'id_klaster' => $id_klastersss,
        ]);
      }
     }
     else{
       $rata_j_pliu=0;
       $j_pliu=0;
     }

     // data DMg pohon
     if($p_dmg!=""){


     if(count($jumlah_pohon)!=0){
       $data_biodiv_pohon = DB::table('data_tanaman_plot')
       ->where('id_plot','=',$id_plot)
       ->where('status','=','1')
       ->where('pengukuran_ke','=',$pengukuran_ke)
       ->get();

       $jmlh_phn = count($data_biodiv_pohon);
       $jenis_pohon=DB::table('data_tanaman_plot')
       ->select(DB::raw("table_master_jenis_tanaman.nama_tanaman,data_tanaman_plot.id_master_jenis_tanaman, COUNT(*) as jumlah"))
       ->join('table_master_jenis_tanaman','table_master_jenis_tanaman.id_jenis_tanaman','=','data_tanaman_plot.id_master_jenis_tanaman')
       ->where('data_tanaman_plot.id_plot','=',$id_plot)
       ->where('status','=','1')
       ->where('pengukuran_ke','=',$pengukuran_ke)
       ->groupBy(DB::raw('table_master_jenis_tanaman.nama_tanaman,data_tanaman_plot.id_master_jenis_tanaman'))
       ->orderBy('table_master_jenis_tanaman.nama_tanaman')
       ->get();

       $h_aksen=0;
       $tot_dmg=0;
       if($jmlh_phn>1){
         for($z=0;$z<count($jenis_pohon);$z++){
           $n[$z]=$jenis_pohon[$z]->jumlah;
           $ni[$z]=$n[$z]/$jmlh_phn;
           $ln_ni[$z]=log($ni[$z]);
           $ni_ln_ni[$z]=-1*$ni[$z]*$ln_ni[$z];
           $h_aksen+=$ni_ln_ni[$z];
           $ni[$z]=round($ni[$z],3);
           $ln_ni[$z]=round($ln_ni[$z],3);
           $ni_ln_ni[$z]=round($ni_ln_ni[$z],3);
           $d_mg[$z] = (count($jenis_pohon)-1)/log($jmlh_phn);
           $tot_dmg+=$d_mg[$z];
           $d_mg[$z]=round($d_mg[$z],3);
         }
         $rata_dmg=$tot_dmg/count($jenis_pohon);
         $rata_dmg=round($rata_dmg,3);
         $rata_h_aksen=$h_aksen;
         $rata_h_aksen=round($rata_h_aksen,3);
         $h_aksen=round($h_aksen,3);
       }
       else{
         $rata_dmg=0;
         $d_mg=0;
       }
     }
    else{
      $pesan = "Data pohon tidak ada";
      $id_klastersss = $id;
      return view('auditor.pengukuran_kurang',[
         'pesan'=>$pesan,
         'id_klaster' => $id_klastersss,
      ]);
    }
   }
   else{
     $rata_dmg=0;
     $d_mg=0;
   }

       $jumlah_fauna=DB::table('data_fauna')
       ->join(
       'tabel_master_fauna',
       'tabel_master_fauna.id_jenis_fauna','=','data_fauna.id_master_fauna'
       )
       ->where('id_plot_fauna','=',$id_plot)
       ->where('data_fauna.pengukuran_ke','=',$pengukuran_ke)
       ->get();

       $data_ktk_kimia= DB::table('ktk_kimia')
       ->select('tbl_klaster_plot.nama_klaster','tbl_sifat_kimia_tanah.sifat_kimia','ktk_kimia.cec')
       ->join('tbl_klaster_plot','tbl_klaster_plot.id_klaster_plot','=','ktk_kimia.kode_klaster')
       ->join('tbl_sifat_kimia_tanah','tbl_sifat_kimia_tanah.id_parameter_kimia','=','ktk_kimia.id_sifat')
       ->where('kode_klaster','=',$id_klaster_plot)
       ->where('id_sifat','=',$sifat_kimia)
       ->where('pengukuran_ke','=',$pengukuran_ke)
       ->get();

         return view('auditor.nilai.nilai_plot',[
           'pengukuran_ke' => $pengukuran_ke,
           'data_pohon' => $data_pohon,
           'jumlah_pohon'=>$jumlah_pohon,
           'jumlah_fauna'=>$jumlah_fauna,
           'data_ktk_kimia' => $data_ktk_kimia,
           'p_lbds'=>$p_lbds,
           'p_volume'=>$p_volume,
           'p_kerusakan'=>$p_kerusakan,
           'p_ktjk'=>$p_ktjk,
           'p_kimia'=>$p_kimia,
           'p_fisik'=>$p_fisik,
           'haksenp' =>$haksenp,
           'haksenf' =>$haksenf,
           'ni' =>$ni,
           'ln_ni' =>$ln_ni,
           'ni_ln_ni' =>$ni_ln_ni,
           'rata_h_aksen'=>$rata_h_aksen,
           'j_pliu' =>$j_pliu,
           'rata_j_pliu'=>$rata_j_pliu,
           'rata_dmg'=>$rata_dmg,
           'd_mg'=>$d_mg,
           'p_jpliu' => $p_jpliu,
           'p_dmg' => $p_dmg,
         ]);
     }

     public function home()
     {

       $id_user=Auth::User()->id;
         $last_id_klaster=DB::table('tbl_klaster_plot')->select('id_klaster_plot')->orderBy('id_klaster_plot','ASC')->get()->last();
         if($last_id_klaster==null){
           $last_id_klaster=1;
         }else{
           $last_id_klaster=$last_id_klaster->id_klaster_plot+1;
         }
         $provinsi=DB::table('provinsi')->get();
         $hak_milik=DB::table('tbl_hak_milik')->get();
         $jenis_hutan=DB::table('jenis_hutan')->get();
         $polatanam=DB::table('pola_tanam')->get();
         $provinsi=DB::table('tbl_klaster_plot')
         ->join('lokasi','lokasi.id_klaster_plot','=','tbl_klaster_plot.id_klaster_plot')
         ->join('provinsi','provinsi.id_provinsi','=','lokasi.id_provinsi')
         ->select('provinsi.id_provinsi','provinsi.nama_provinsi')
         ->groupBy('provinsi.nama_provinsi','provinsi.id_provinsi')
         ->where('input_by',$id_user)
         ->get();

         // mengembalikan nilai data klaster
         $data_klaster = DB::table('kategori_klaster')
         ->where('input_by','=',Auth::user()->id)
         ->orderBy('kategori')->get();

         return view('auditor.penilaian.skoring_home',[
           'data_klaster' => $data_klaster,
           'provinsi'		=> $provinsi,
           'hak_milik'		=> $hak_milik,
           'jenis_hutan'	=> $jenis_hutan,
           'pola_tanam'    => $polatanam,
           'lokasi' => $provinsi,
         ]);
     }

     public function kabupaten_skor(Request $req)
     {
         $id_prov= Input::get('id_prov');
         $data_prov=DB::table('lokasi')
         ->join('tbl_klaster_plot','tbl_klaster_plot.id_klaster_plot','=','lokasi.id_klaster_plot')
         ->join('kabupaten','kabupaten.id','=','lokasi.id_kabupaten')
         ->where([['lokasi.id_provinsi','=',$id_prov],['tbl_klaster_plot.input_By','=',Auth::user()->id]])
         ->groupBy('kabupaten.nama_kabupaten','lokasi.id_kabupaten')
         ->select('kabupaten.nama_kabupaten','lokasi.id_kabupaten')
         ->get();
         return response()->json($data_prov);

     }

     public function kecamatan_skor(Request $req)
     {
         $id_kab= Input::get('id_kab');
         $data_kab=DB::table('lokasi')
         ->join('tbl_klaster_plot','tbl_klaster_plot.id_klaster_plot','=','lokasi.id_klaster_plot')
         ->join('kecamatan','kecamatan.id','=','lokasi.id_kecamatan')
         ->where([['lokasi.id_kabupaten','=',$id_kab],['tbl_klaster_plot.input_By','=',Auth::user()->id]])
         ->groupBy('kecamatan.nama_kecamatan','lokasi.id_kecamatan')
         ->select('kecamatan.nama_kecamatan','lokasi.id_kecamatan')
         ->get();
         return response()->json($data_kab);

     }

     public function pengukuran_ke(Request $r)
     {
       $id_data_klaster=Input::get('id_data_klaster');

       // $dapeng=DB::table('lokasi')
       // ->join('tbl_klaster_plot','tbl_klaster_plot.id_klaster_plot','=','lokasi.id_klaster_plot')
       // ->join('tbl_plot','tbl_plot.id_klaster_plot','=','tbl_klaster_plot.id_klaster_plot')
       // ->join('pengukuran_master','pengukuran_master.id_plot','=','tbl_plot.id_plot')
       // ->where('lokasi.id_provinsi',$id_prov)
       // ->select('pengukuran_master.pengukuran_ke')
       // ->groupBy('pengukuran_ke')
       // ->get();

       $dapeng=DB::table('kategori_klaster')
       ->join('tbl_klaster_plot','tbl_klaster_plot.id_data_klaster','=','kategori_klaster.id_data_klaster')
       ->join('tbl_plot','tbl_plot.id_klaster_plot','=','tbl_klaster_plot.id_klaster_plot')
       ->join('pengukuran_master','pengukuran_master.id_plot','=','tbl_plot.id_plot')
       ->where('kategori_klaster.id_data_klaster',$id_data_klaster)
       ->select('pengukuran_master.pengukuran_ke')
       ->groupBy('pengukuran_ke')
       ->get();

       return response()->json($dapeng);
     }

}
