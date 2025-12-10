<?php

namespace App\Http\Controllers\auditor;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class SkoringControllerNew extends Controller
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
   * fungsi untuk menampilkan nilai keseluruhan kesehatan hutan
   *
   * @return \Illuminate\Http\Response
   */
   public function index(Request $req)
   {
     $req->validate([
         'tahun_pengukuran'=>'required|integer',
         'pengukuranke'=>'required',
       ]);

       $id_data_klaster = $req->tahun_pengukuran; // id kategori klaster
       $pengukuran_ke=$req->pengukuranke; // pengukuran ke

       // parameter
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
       if($sifat_kimia!=="" && $sifat_kimia !=null){
         $sifat_kimia_text = DB::table("tbl_sifat_kimia_tanah")->where('id_parameter_kimia','=',$sifat_kimia)->first()->sifat_kimia;
       }
       else{
         $sifat_kimia_text = "";
       }

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
       else{
         // jika pengukuran pertama
         if($pengukuran_ke==1){
           $id_klaster = $this->PengukuranKe($id_data_klaster,1);
         }

         // jika pengukuran perubahan
         else if($pengukuran_ke==99){
           $id_klaster = $this->PengukuranKe($id_data_klaster,1);
           $id_klaster2 = $this->PengukuranKe2($id_data_klaster,2);

           if(count($id_klaster)>0 && count($id_klaster2)>0){
             // Untuk perhitungan lebih dari sama dengan 1 klaster
             $jumlah_penilaian = count($id_klaster);
             if ($jumlah_penilaian>=1){
               // memberikan array data tanaman per klaster
               for($i=0;$i<count($id_klaster);$i++){
                 $data_tanaman[$i]=DB::table('data_tanaman_plot')
                 ->join('tbl_plot','tbl_plot.id_plot','=','data_tanaman_plot.id_plot')
                 ->join('table_master_jenis_tanaman','table_master_jenis_tanaman.id_jenis_tanaman','=','data_tanaman_plot.id_master_jenis_tanaman')
                 ->where('data_tanaman_plot.id_klaster_plot',$id_klaster[$i]->id_klaster_plot)
                 ->where('data_tanaman_plot.pengukuran_ke','=',$pengukuran_ke)
                 ->get();
               }

               // inisialisasi nilai awal
               $m=0;
               $tli_r=[];
               $vcr_r=[];
               $lbds_r=[];
               $volume_r=[];
               $cec_r=[];

               // looping sampai id klaster habis
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
                        $data_pengukuran_ktk_kimia = $this->DataPengukuranKimia($id_cl,1,$sifat_kimia);

                        // jika data sifat ada
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
                      // mendapatkan nilai tli klaster
                      $tli_f[$k] = $this->DataPengukuran("kerusakan",$id_pengukuran1[$k]);
                    }
                    else{
                      $tli_f[$k]=0;
                    }

                    // untuk data pengukuran tajuk
                    if($p_ktjk!=""){
                      $vcr_f[$k] = $this->DataPengukuran("tajuk",$id_pengukuran1[$k]);
                    }
                    else{
                      $vcr_f[$k]=0;
                    }

                    // untuk data pengukuran lbds
                    if($p_lbds!=""){
                      $lbds_f[$k] = $this->DataPengukuran("lbds",$id_pengukuran1[$k]);
                    }
                    else{
                      $lbds_f[$k]=0;
                    }

                    // untuk data pengukuran volume
                    if($p_volume!=""){
                      $volume_f[$k] = $this->DataPengukuran("volume",$id_pengukuran1[$k]);
                    }
                    else{
                      $volume_f[$k]=0;
                    }

                    // nilai total parameter klaster
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

                  // untuk dibagi 4 plot ?
                  $cec_r[$m]=$cec_r[$m]/count($id_pengukuran1);
                  $tli_r[$m]=$tli_r[$m]/count($id_pengukuran1);
                  $vcr_r[$m]=$vcr_r[$m]/count($id_pengukuran1);
                  $lbds_r[$m]=$lbds_r[$m]/count($id_pengukuran1);
                  $volume_r[$m]=$volume_r[$m]/count($id_pengukuran1);
                  //

                }
                else{
                  // jika id klaster tidak ada
                  if($id_cl==""){
                    $pesan= "Data pengukuran tidak tersedia";
                    return view('user.penilaian_kurang',[
                      'pesan' => $pesan,
                    ]);
                  }
                  else{
                    $pesan= "Salah satu pengukuran tidak tersedia";
                    return view('user.pengukuran_kurang',[
                      'pesan' => $pesan,
                      'id_klaster' => $id_cl,
                    ]);
                  }
                }
                $m++;

                // data biodiversitas pohon
                $rata_h_aksen[$i]=0;
                $j_pliu_klaster[$i] = 0;
                $d_mg[$i]=0;
                for($q=0;$q<count($plot);$q++){
                  $h_aksen[$q]=0;
                  // jika haksen pohon yg dipilih
                  if($haksenp!=""){
                    $h_aksen[$q] = $this->BiodiversitasPohon($plot[$q]->id_plot,1);
                    // jika param jpliu tidak ada maka h aksen diitung di haksen
                    if($p_jpliu==""){
                      $rata_h_aksen[$i]+=$h_aksen[$q];
                    }
                  }

                  // jika jpliu pohon dipilih
                  if($p_jpliu!=""){
                    $h_aksen[$q] = $this->BiodiversitasPohon($plot[$q]->id_plot,1);

                    $rata_h_aksen[$i]+=$h_aksen[$q];

                      $jenis_pohon_klaster[$q]=DB::table('data_tanaman_plot')
                        ->select(DB::raw("data_tanaman_plot.id_master_jenis_tanaman, COUNT(*) as jumlah"))
                        ->where('data_tanaman_plot.id_plot','=',$plot[$q]->id_plot)
                        ->where('status','=','1')
                        ->where('pengukuran_ke','=',1)
                        ->groupBy(DB::raw('data_tanaman_plot.id_master_jenis_tanaman'))
                        ->get();
                      $jml_jenis_klaster[$q] = count($jenis_pohon_klaster[$q]);

                      if($jml_jenis_klaster[$q]>1){
                        $j_pliu_klaster[$i]+=$h_aksen[$q]/log($jml_jenis_klaster[$q]);
                    }
                  }
                }
                // APAKAH DIBAGI DENGAN 4?
                // nilai haksen pohon
                $h_aksen_klaster[$i] = $rata_h_aksen[$i]/4;
                // nilai jpliu pohon
                $j_pliu_klaster[$i] = $j_pliu_klaster[$i]/4;

                // dmg biodiversitas pohon
                if($p_dmg!=""){
                  $d_mg[$i] = $this->BiodivDmgPohon(1,$id_klaster[$i]->id_klaster_plot);
                }
                  // END

                // jika haksen fauna yang dipilih
                $h_aksenf[$i]=0;
                if($haksenf!=""){
                  if($p_jpliuf==""){
                    $h_aksenf[$i]= $this->BiodivFauna($id_cl,1);
                  }

                }

                // data jpliu fauna
                $j_pliuf[$i] = 0;
                if($p_jpliuf!=""){
                  $h_aksenf[$i]= $this->BiodivFauna($id_cl,1);

                  $data_biodiv_fauna[$i] = DB::table('data_fauna')
                  ->where('id_klaster_plot_fauna','=',$id_cl)
                  ->where('pengukuran_ke','=',1)
                  ->get();
                  $tot_data_fauna[$i]=count($data_biodiv_fauna[$i]);

                  if($tot_data_fauna[$i]>1){
                    $j_pliuf[$i] = $h_aksenf[$i]/log($tot_data_fauna[$i]);
                  }
                }

                // data dmg fauna
                $d_mgf[$i]=0;
                if($p_dmgf!=""){
                  $d_mgf[$i] = $this->BiodivDmgFauna(1,$id_cl);
                }
               }

               // hanya pembulatan
               for ($a=0;$a<count($tli_r);$a++){
                 $cec_r[$a]=round(($cec_r[$a]),3);
                 $lbds_r[$a]=round(($lbds_r[$a]),3);
                 $volume_r[$a]=round(($volume_r[$a]),3);
                 $tli_r[$a]=round(($tli_r[$a]),3);
                 $vcr_r[$a]=round(($vcr_r[$a]),3);
                 $d_mg[$a]=round($d_mg[$a],3);
                 $h_aksenf[$a]=round($h_aksenf[$a],3);
                 $j_pliuf[$a]=round($j_pliuf[$a],3);
                 $d_mgf[$a]=round($d_mgf[$a],3);
                 $j_pliu_klaster[$a]=round($j_pliu_klaster[$a],3);
                 $h_aksen_klaster[$a]=round($h_aksen_klaster[$a],3);
               }

               // UNTUK PERHITUNGAN NILAI SKOR INDIKATOR
               $range_cec_l=0;
               $range_cec_r=0;
               for ($i=0;$i<count($id_klaster);$i++){
                   $skor_cec[$i]=0;
                   $skor_lbds[$i]=0;
                   $skor_volume[$i]=0;
                   $skor_tli[$i]=0;
                   $skor_vcr[$i]=0;
                   $skor_h_aksen[$i]=0;
                   $skor_j_pliu[$i]=0;
                   $skor_d_mg[$i]=0;
                   $skor_h_aksenf[$i]=0;
                   $skor_j_pliuf[$i]=0;
                   $skor_d_mgf[$i]=0;
               }

               // range nilai skor Ktk kimia
               if($p_kimia!=""){
                 $range = $this->rangeSkorIndikator($cec_r,$id_klaster);
                 $range_cec_l=$range[0];
                 $range_cec_r=$range[1];
                 $skor_cec=$range[2];
               }

               // range nilai skor Produktivitas
               //lbds
               $range_lbds_l=0;
               $range_lbds_r=0;
               if($p_lbds!=""){
                 $range = $this->rangeSkorIndikator($lbds_r,$id_klaster);
                 $range_lbds_l=$range[0];
                 $range_lbds_r=$range[1];
                 $skor_lbds=$range[2];
               }

               //volume_v
               $range_volume_l=0;
               $range_volume_r=0;
               if($p_volume!=""){
                 $range = $this->rangeSkorIndikator($volume_r,$id_klaster);
                 $range_volume_l=$range[0];
                 $range_volume_r=$range[1];
                 $skor_volume=$range[2];
               }

               // range nilai skor kerusakan
               $range_tli_l=0;
               $range_tli_r=0;
               if($p_kerusakan!=""){
                 $range = $this->rangeSkorIndikatorKerusakan($tli_r,$id_klaster);
                 $range_tli_l=$range[0];
                 $range_tli_r=$range[1];
                 $skor_tli=$range[2];
               }

               // range nilai skor tajuk
               $range_vcr_l=0;
               $range_vcr_r=0;
               if($p_ktjk!=""){
                 $range = $this->rangeSkorIndikator($vcr_r,$id_klaster);
                 $range_vcr_l=$range[0];
                 $range_vcr_r=$range[1];
                 $skor_vcr=$range[2];
               }

               // range nilai skor h_aksen
               $range_h_aksen_l=0;
               $range_h_aksen_r=0;
               if($haksenp!=""){
                 $range = $this->rangeSkorIndikator($h_aksen_klaster,$id_klaster);
                 $range_h_aksen_l=$range[0];
                 $range_h_aksen_r=$range[1];
                 $skor_h_aksen=$range[2];
               }

               // range nilai skor j_pliup
               $range_j_pliu_l=0;
               $range_j_pliu_r=0;
               if($p_jpliu!=""){
                 $range = $this->rangeSkorIndikator($j_pliu_klaster,$id_klaster);
                 $range_j_pliu_l=$range[0];
                 $range_j_pliu_r=$range[1];
                 $skor_j_pliu=$range[2];
               }

               // range nilai skor d_mg
               $range_d_mg_l=0;
               $range_d_mg_r=0;
               if($p_dmg!=""){
                 $range = $this->rangeSkorIndikator($d_mg,$id_klaster);
                 $range_d_mg_l=$range[0];
                 $range_d_mg_r=$range[1];
                 $skor_d_mg=$range[2];
               }

               // range nilai skor h_aksenf
               $range_h_aksen_lf=0;
               $range_h_aksen_rf=0;
               if($haksenf!=""){
                 $range = $this->rangeSkorIndikator($h_aksenf,$id_klaster);
                 $range_h_aksen_lf=$range[0];
                 $range_h_aksen_rf=$range[1];
                 $skor_h_aksenf=$range[2];
               }

               // range nilai skor jpliuf
               $range_j_pliu_lf=0;
               $range_j_pliu_rf=0;
               if($p_jpliuf!=""){
                 $range = $this->rangeSkorIndikator($j_pliuf,$id_klaster);
                 $range_j_pliu_lf=$range[0];
                 $range_j_pliu_rf=$range[1];
                 $skor_j_pliuf=$range[2];
               }

               // range nilai skor dmgf
               $range_d_mg_lf=0;
               $range_d_mg_rf=0;
               if($p_dmgf!=""){
                 $range = $this->rangeSkorIndikator($d_mgf,$id_klaster);
                 $range_d_mg_lf=$range[0];
                 $range_d_mg_rf=$range[1];
                 $skor_d_mgf=$range[2];
               }

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

              $na_total_cec[0] = 0;
              $na_total_lbds[0] = 0;
              $na_total_volume[0] = 0;
              $na_total_kerusakan[0] = 0;
              $na_total_tajuk[0] = 0;
              $na_total_biodiv_pohon[0] = 0;
              $na_total_biodiv_pohon_jpliu[0] = 0;
              $na_total_biodiv_pohon_dmg[0] = 0;
              $na_total_biodiv_fauna[0] = 0;
              $na_total_biodiv_fauna_jpliuf[0] = 0;
              $na_total_biodiv_fauna_dmgf[0] = 0;
              for ($i=0; $i < count($id_klaster); $i++) {
                  //  nilai akhir ktk kimia
                  $na_cec[$i]=$skor_cec[$i]*$nt_ktpk[$i];
                  $na_total_cec[0] += $na_cec[$i];
                  //  nilai akhir Produktivitas lbds
                  $na_lbds[$i]=$skor_lbds[$i]*$nt_produktivitas[$i];
                  $na_total_lbds[0] += $na_lbds[$i];
                  //  nilai akhir Produktivitas volume
                  $na_volume[$i]=$skor_volume[$i]*$nt_produktivitas[$i];
                  $na_total_volume[0] += $na_volume[$i];
                  //  nilai akhir kerusakan pohon
                  $na_kerusakan[$i]=$skor_tli[$i]*$nt_kerusakan[$i];
                  $na_total_kerusakan[0] += $na_kerusakan[$i];
                  //  nilai akhir kondisi tajuk
                  $na_tajuk[$i]=$skor_vcr[$i]*$nt_ktjk[$i];
                  $na_total_tajuk[0] += $na_tajuk[$i];
                  //  nilai akhir biodiversitas pohon haksen
                  $na_biodiv_pohon[$i]=$skor_h_aksen[$i]*$nt_biodiv[$i];
                  $na_total_biodiv_pohon[0] += $na_biodiv_pohon[$i];
                  //  nilai akhir biodiversitas pohon jpliu
                  $na_biodiv_pohon_jpliu[$i]=$skor_j_pliu[$i]*$nt_biodiv[$i];
                  $na_total_biodiv_pohon_jpliu[0] += $na_biodiv_pohon_jpliu[$i];
                  //  nilai akhir biodiversitas pohon dmg
                  $na_biodiv_pohon_dmg[$i]=$skor_d_mg[$i]*$nt_biodiv[$i];
                  $na_total_biodiv_pohon_dmg[0] += $na_biodiv_pohon_dmg[$i];
                  //  nilai akhir biodiversitas fauna
                  $na_biodiv_fauna[$i]=$skor_h_aksenf[$i]*$nt_biodivf[$i];
                  $na_total_biodiv_fauna[0] += $na_biodiv_fauna[$i];
                  $na_biodiv_fauna_jpliuf[$i]=$skor_j_pliuf[$i]*$nt_biodivf[$i];
                  $na_total_biodiv_fauna_jpliuf[0] += $na_biodiv_fauna_jpliuf[$i];
                  $na_biodiv_fauna_dmgf[$i]=$skor_d_mgf[$i]*$nt_biodivf[$i];
                  $na_total_biodiv_fauna_dmgf[0] += $na_biodiv_fauna_dmgf[$i];
              }

              $na_total_cec[0] = $na_total_cec[0]/$i;
              $na_total_lbds[0] = $na_total_lbds[0]/$i;
              $na_total_volume[0] = $na_total_volume[0]/$i;
              $na_total_kerusakan[0] = $na_total_kerusakan[0]/$i;
              $na_total_tajuk[0] = $na_total_tajuk[0]/$i;
              $na_total_biodiv_pohon[0] = $na_total_biodiv_pohon[0]/$i;
              $na_total_biodiv_pohon_jpliu[0] = $na_total_biodiv_pohon_jpliu[0]/$i;
              $na_total_biodiv_pohon_dmg[0] = $na_total_biodiv_pohon_dmg[0]/$i;
              $na_total_biodiv_fauna[0] = $na_total_biodiv_fauna[0]/$i;
              $na_total_biodiv_fauna_jpliuf[0] = $na_total_biodiv_fauna_jpliuf[0]/$i;
              $na_total_biodiv_fauna_dmgf[0] = $na_total_biodiv_fauna_dmgf[0]/$i;

              // nilai total indikator
              $na_seluruh[0] = 0;
              for ($i=0; $i < count($id_klaster); $i++) {
                $na_total[$i]=$na_kerusakan[$i]+$na_tajuk[$i]+$na_biodiv_pohon[$i]+$na_biodiv_pohon_jpliu[$i]+$na_biodiv_pohon_dmg[$i]+$na_lbds[$i]+$na_volume[$i]+$na_biodiv_fauna[$i]+$na_biodiv_fauna_jpliuf[$i]+$na_cec[$i];
                $na_seluruh[0] += $na_total[$i];
              }
              $na_seluruh[0] = $na_seluruh[0]/$i;


              // PENGUKURAN KE 2
              // inisialisasi nilai awal
              $kedua_m=0;
              $kedua_tli_r=[];
              $kedua_vcr_r=[];
              $kedua_lbds_r=[];
              $kedua_volume_r=[];
              $kedua_cec_r=[];

              // looping sampai id klaster habis
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
                     if($sifat_kimia==""){
                       $kedua_cec_f[$kedua_i]=0;
                     }
                     else{
                       $kedua_data_pengukuran_ktk_kimia = $this->DataPengukuranKimia($kedua_id_cl,2,$sifat_kimia);

                       // jika data sifat ada
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
                     // mendapatkan nilai tli klaster
                     $kedua_tli_f[$kedua_k] = $this->DataPengukuran("kerusakan",$kedua_id_pengukuran1[$kedua_k]);
                   }
                   else{
                     $kedua_tli_f[$kedua_k]=0;
                   }

                   // untuk data pengukuran tajuk
                   if($p_ktjk!=""){
                     $kedua_vcr_f[$kedua_k] = $this->DataPengukuran("tajuk",$kedua_id_pengukuran1[$kedua_k]);
                   }
                   else{
                     $kedua_vcr_f[$kedua_k]=0;
                   }

                   // untuk data pengukuran lbds
                   if($p_lbds!=""){
                     $kedua_lbds_f[$kedua_k] = $this->DataPengukuran("lbds",$kedua_id_pengukuran1[$kedua_k]);
                   }
                   else{
                     $kedua_lbds_f[$kedua_k]=0;
                   }

                   // untuk data pengukuran volume
                   if($p_volume!=""){
                     $kedua_volume_f[$kedua_k] = $this->DataPengukuran("volume",$kedua_id_pengukuran1[$kedua_k]);
                   }
                   else{
                     $kedua_volume_f[$kedua_k]=0;
                   }

                   // nilai total parameter klaster
                   //nilai total KTPK
                   $kedua_cec_r[$kedua_m]+=$kedua_cec_f[$kedua_i];
                   // nilai total PLI
                   $kedua_tli_r[$kedua_m]+=$kedua_tli_f[$kedua_k];
                   // nilai total VCR
                   $kedua_vcr_r[$kedua_m]+=$kedua_vcr_f[$kedua_k];
                   // nilai total LBDS
                   $kedua_lbds_r[$kedua_m]+=$kedua_lbds_f[$kedua_k];
                   // nilai total Volume
                   $kedua_volume_r[$kedua_m]+=$kedua_volume_f[$kedua_k];

                 }

                 // untuk dibagi 4 plot ?
                 $kedua_cec_r[$kedua_m]=$kedua_cec_r[$kedua_m]/count($kedua_id_pengukuran1);
                 $kedua_tli_r[$kedua_m]=$kedua_tli_r[$kedua_m]/count($kedua_id_pengukuran1);
                 $kedua_vcr_r[$kedua_m]=$kedua_vcr_r[$kedua_m]/count($kedua_id_pengukuran1);
                 $kedua_lbds_r[$kedua_m]=$kedua_lbds_r[$kedua_m]/count($kedua_id_pengukuran1);
                 $kedua_volume_r[$kedua_m]=$kedua_volume_r[$kedua_m]/count($kedua_id_pengukuran1);
                 //

               }
               else{
                 // jika id klaster tidak ada
                 if($kedua_id_cl==""){
                   $kedua_pesan= "Data pengukuran tidak tersedia";
                   return view('user.penilaian_kurang',[
                     'pesan' => $kedua_pesan,
                   ]);
                 }
                 else{
                   $kedua_pesan= "Salah satu pengukuran tidak tersedia";
                   return view('user.pengukuran_kurang',[
                     'pesan' => $kedua_pesan,
                     'id_klaster' => $kedua_id_cl,
                   ]);
                 }
               }
               $kedua_m++;

               // data biodiversitas pohon
               $kedua_rata_h_aksen[$kedua_i]=0;
               $kedua_j_pliu_klaster[$kedua_i] = 0;
               $kedua_d_mg[$kedua_i]=0;
               for($kedua_q=0;$kedua_q<count($kedua_plot);$kedua_q++){
                 $kedua_h_aksen[$kedua_q]=0;
                 // jika haksen pohon yg dipilih
                 if($haksenp!=""){
                   $kedua_h_aksen[$kedua_q] = $this->BiodiversitasPohon($kedua_plot[$kedua_q]->id_plot,2);
                   // jika param jpliu tidak ada maka h aksen diitung di haksen
                   if($p_jpliu==""){
                     $kedua_rata_h_aksen[$kedua_i]+=$kedua_h_aksen[$kedua_q];
                   }
                 }

                 // jika jpliu pohon dipilih
                 if($p_jpliu!=""){
                   $kedua_h_aksen[$kedua_q] = $this->BiodiversitasPohon($kedua_plot[$kedua_q]->id_plot,2);

                   $kedua_rata_h_aksen[$kedua_i]+=$kedua_h_aksen[$kedua_q];

                     $kedua_jenis_pohon_klaster[$kedua_q]=DB::table('data_tanaman_plot')
                       ->select(DB::raw("data_tanaman_plot.id_master_jenis_tanaman, COUNT(*) as jumlah"))
                       ->where('data_tanaman_plot.id_plot','=',$kedua_plot[$kedua_q]->id_plot)
                       ->where('status','=','1')
                       ->where('pengukuran_ke','=',2)
                       ->groupBy(DB::raw('data_tanaman_plot.id_master_jenis_tanaman'))
                       ->get();
                     $kedua_jml_jenis_klaster[$kedua_q] = count($kedua_jenis_pohon_klaster[$kedua_q]);

                     if($kedua_jml_jenis_klaster[$kedua_q]>1){
                     $kedua_j_pliu_klaster[$kedua_i]+=$kedua_h_aksen[$kedua_q]/log($kedua_jml_jenis_klaster[$kedua_q]);
                   }
                 }
               }
               // APAKAH DIBAGI DENGAN 4?
               // nilai haksen pohon
               $kedua_h_aksen_klaster[$kedua_i] = $kedua_rata_h_aksen[$kedua_i]/4;
               // nilai jpliu pohon
               $kedua_j_pliu_klaster[$kedua_i] = $kedua_j_pliu_klaster[$kedua_i]/4;

               // dmg biodiversitas pohon
               if($p_dmg!=""){
                 $kedua_d_mg[$kedua_i] = $this->BiodivDmgPohon(2,$id_klaster2[$kedua_i]->id_klaster_plot);
               }
                 // END

               // jika haksen fauna yang dipilih
               $kedua_h_aksenf[$kedua_i]=0;
               if($haksenf!=""){
                 if($p_jpliuf==""){
                   $kedua_h_aksenf[$kedua_i]= $this->BiodivFauna($kedua_id_cl,2);
                 }

               }

               // data jpliu fauna
               $kedua_j_pliuf[$kedua_i] = 0;
               if($p_jpliuf!=""){
                 $kedua_h_aksenf[$kedua_i]= $this->BiodivFauna($kedua_id_cl,2);

                 $kedua_data_biodiv_fauna[$kedua_i] = DB::table('data_fauna')
                 ->where('id_klaster_plot_fauna','=',$kedua_id_cl)
                 ->where('pengukuran_ke','=',2)
                 ->get();
                 $kedua_tot_data_fauna[$kedua_i]=count($kedua_data_biodiv_fauna[$kedua_i]);

                 if($kedua_tot_data_fauna[$kedua_i]>1){
                   $kedua_j_pliuf[$kedua_i] = $kedua_h_aksenf[$kedua_i]/log($kedua_tot_data_fauna[$kedua_i]);
                 }
               }

               // data dmg fauna
               $kedua_d_mgf[$kedua_i]=0;
               if($p_dmgf!=""){
                 $kedua_d_mgf[$kedua_i] = $this->BiodivDmgFauna(2,$kedua_id_cl);
               }
              }

              // hanya pembulatan
              for ($kedua_a=0;$kedua_a<count($kedua_tli_r);$kedua_a++){
                $kedua_cec_r[$kedua_a]=round(($kedua_cec_r[$kedua_a]),3);
                $kedua_lbds_r[$kedua_a]=round(($kedua_lbds_r[$kedua_a]),3);
                $kedua_volume_r[$kedua_a]=round(($kedua_volume_r[$kedua_a]),3);
                $kedua_tli_r[$kedua_a]=round(($kedua_tli_r[$kedua_a]),3);
                $kedua_vcr_r[$kedua_a]=round(($kedua_vcr_r[$kedua_a]),3);
                $kedua_d_mg[$kedua_a]=round($kedua_d_mg[$kedua_a],3);
                $kedua_h_aksenf[$kedua_a]=round($kedua_h_aksenf[$kedua_a],3);
                $kedua_j_pliuf[$kedua_a]=round($kedua_j_pliuf[$kedua_a],3);
                $kedua_d_mgf[$kedua_a]=round($kedua_d_mgf[$kedua_a],3);
                $kedua_j_pliu_klaster[$kedua_a]=round($kedua_j_pliu_klaster[$kedua_a],3);
                $kedua_h_aksen_klaster[$kedua_a]=round($kedua_h_aksen_klaster[$kedua_a],3);
              }

              // UNTUK PERHITUNGAN NILAI SKOR INDIKATOR
              $kedua_range_cec_l=0;
              $kedua_range_cec_r=0;
              for ($kedua_i=0;$kedua_i<count($id_klaster2);$kedua_i++){
                  $kedua_skor_cec[$kedua_i]=0;
                  $kedua_skor_lbds[$kedua_i]=0;
                  $kedua_skor_volume[$kedua_i]=0;
                  $kedua_skor_tli[$kedua_i]=0;
                  $kedua_skor_vcr[$kedua_i]=0;
                  $kedua_skor_h_aksen[$kedua_i]=0;
                  $kedua_skor_j_pliu[$kedua_i]=0;
                  $kedua_skor_d_mg[$kedua_i]=0;
                  $kedua_skor_h_aksenf[$kedua_i]=0;
                  $kedua_skor_j_pliuf[$kedua_i]=0;
                  $kedua_skor_d_mgf[$kedua_i]=0;
              }

              // range nilai skor Ktk kimia
              if($p_kimia!=""){
                $kedua_range = $this->rangeSkorIndikator($kedua_cec_r,$id_klaster2);
                $kedua_range_cec_l=$kedua_range[0];
                $kedua_range_cec_r=$kedua_range[1];
                $kedua_skor_cec=$kedua_range[2];
              }

              // range nilai skor Produktivitas
              //lbds
              $kedua_range_lbds_l=0;
              $kedua_range_lbds_r=0;
              if($p_lbds!=""){
                $kedua_range = $this->rangeSkorIndikator($kedua_lbds_r,$id_klaster2);
                $kedua_range_lbds_l=$kedua_range[0];
                $kedua_range_lbds_r=$kedua_range[1];
                $kedua_skor_lbds=$kedua_range[2];
              }

              //volume_v
              $kedua_range_volume_l=0;
              $kedua_range_volume_r=0;
              if($p_volume!=""){
                $kedua_range = $this->rangeSkorIndikator($kedua_volume_r,$id_klaster2);
                $kedua_range_volume_l=$kedua_range[0];
                $kedua_range_volume_r=$kedua_range[1];
                $kedua_skor_volume=$kedua_range[2];
              }

              // range nilai skor kerusakan
              $kedua_range_tli_l=0;
              $kedua_range_tli_r=0;
              if($p_kerusakan!=""){
                $kedua_range = $this->rangeSkorIndikatorKerusakan($kedua_tli_r,$id_klaster2);
                $kedua_range_tli_l=$kedua_range[0];
                $kedua_range_tli_r=$kedua_range[1];
                $kedua_skor_tli=$kedua_range[2];
              }

              // range nilai skor tajuk
              $kedua_range_vcr_l=0;
              $kedua_range_vcr_r=0;
              if($p_ktjk!=""){
                $kedua_range = $this->rangeSkorIndikator($kedua_vcr_r,$id_klaster2);
                $kedua_range_vcr_l=$kedua_range[0];
                $kedua_range_vcr_r=$kedua_range[1];
                $kedua_skor_vcr=$kedua_range[2];
              }

              // range nilai skor h_aksen
              $kedua_range_h_aksen_l=0;
              $kedua_range_h_aksen_r=0;
              if($haksenp!=""){
                $kedua_range = $this->rangeSkorIndikator($kedua_h_aksen_klaster,$id_klaster2);
                $kedua_range_h_aksen_l=$kedua_range[0];
                $kedua_range_h_aksen_r=$kedua_range[1];
                $kedua_skor_h_aksen=$kedua_range[2];
              }

              // range nilai skor j_pliup
              $kedua_range_j_pliu_l=0;
              $kedua_range_j_pliu_r=0;
              if($p_jpliu!=""){
                $kedua_range = $this->rangeSkorIndikator($kedua_j_pliu_klaster,$id_klaster2);
                $kedua_range_j_pliu_l=$kedua_range[0];
                $kedua_range_j_pliu_r=$kedua_range[1];
                $kedua_skor_j_pliu=$kedua_range[2];
              }

              // range nilai skor d_mg
              $kedua_range_d_mg_l=0;
              $kedua_range_d_mg_r=0;
              if($p_dmg!=""){
                $kedua_range = $this->rangeSkorIndikator($kedua_d_mg,$id_klaster2);
                $kedua_range_d_mg_l=$kedua_range[0];
                $kedua_range_d_mg_r=$kedua_range[1];
                $kedua_skor_d_mg=$kedua_range[2];
              }

              // range nilai skor h_aksenf
              $kedua_range_h_aksen_lf=0;
              $kedua_range_h_aksen_rf=0;
              if($haksenf!=""){
                $kedua_range = $this->rangeSkorIndikator($kedua_h_aksenf,$id_klaster2);
                $kedua_range_h_aksen_lf=$kedua_range[0];
                $kedua_range_h_aksen_rf=$kedua_range[1];
                $kedua_skor_h_aksenf=$kedua_range[2];
              }

              // range nilai skor jpliuf
              $kedua_range_j_pliu_lf=0;
              $kedua_range_j_pliu_rf=0;
              if($p_jpliuf!=""){
                $kedua_range = $this->rangeSkorIndikator($kedua_j_pliuf,$id_klaster2);
                $kedua_range_j_pliu_lf=$kedua_range[0];
                $kedua_range_j_pliu_rf=$kedua_range[1];
                $kedua_skor_j_pliuf=$kedua_range[2];
              }

              // range nilai skor dmgf
              $kedua_range_d_mg_lf=0;
              $kedua_range_d_mg_rf=0;
              if($p_dmgf!=""){
                $kedua_range = $this->rangeSkorIndikator($kedua_d_mgf,$id_klaster2);
                $kedua_range_d_mg_lf=$kedua_range[0];
                $kedua_range_d_mg_rf=$kedua_range[1];
                $kedua_skor_d_mgf=$kedua_range[2];
              }

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

             $kedua_na_total_cec[0] = 0;
             $kedua_na_total_lbds[0] = 0;
             $kedua_na_total_volume[0] = 0;
             $kedua_na_total_kerusakan[0] = 0;
             $kedua_na_total_tajuk[0] = 0;
             $kedua_na_total_biodiv_pohon[0] = 0;
             $kedua_na_total_biodiv_pohon_jpliu[0] = 0;
             $kedua_na_total_biodiv_pohon_dmg[0] = 0;
             $kedua_na_total_biodiv_fauna[0] = 0;
             $kedua_na_total_biodiv_fauna_jpliuf[0] = 0;
             $kedua_na_total_biodiv_fauna_dmgf[0] = 0;
             for ($kedua_i=0; $kedua_i < count($id_klaster2); $kedua_i++) {
                 //  nilai akhir ktk kimia
                 $kedua_na_cec[$kedua_i]=$kedua_skor_cec[$kedua_i]*$kedua_nt_ktpk[$kedua_i];
                 $kedua_na_total_cec[0] += $kedua_na_cec[$kedua_i];
                 //  nilai akhir Produktivitas lbds
                 $kedua_na_lbds[$kedua_i]=$kedua_skor_lbds[$kedua_i]*$kedua_nt_produktivitas[$kedua_i];
                 $kedua_na_total_lbds[0] += $kedua_na_lbds[$kedua_i];
                 //  nilai akhir Produktivitas volume
                 $kedua_na_volume[$kedua_i]=$kedua_skor_volume[$kedua_i]*$kedua_nt_produktivitas[$kedua_i];
                 $kedua_na_total_volume[0] += $kedua_na_volume[$kedua_i];
                 //  nilai akhir kerusakan pohon
                 $kedua_na_kerusakan[$kedua_i]=$kedua_skor_tli[$kedua_i]*$kedua_nt_kerusakan[$kedua_i];
                 $kedua_na_total_kerusakan[0] += $kedua_na_kerusakan[$kedua_i];
                 //  nilai akhir kondisi tajuk
                 $kedua_na_tajuk[$kedua_i]=$kedua_skor_vcr[$kedua_i]*$kedua_nt_ktjk[$kedua_i];
                 $kedua_na_total_tajuk[0] += $kedua_na_tajuk[$kedua_i];
                 //  nilai akhir biodiversitas pohon haksen
                 $kedua_na_biodiv_pohon[$kedua_i]=$kedua_skor_h_aksen[$kedua_i]*$kedua_nt_biodiv[$kedua_i];
                 $kedua_na_total_biodiv_pohon[0] += $kedua_na_biodiv_pohon[$kedua_i];
                 //  nilai akhir biodiversitas pohon jpliu
                 $kedua_na_biodiv_pohon_jpliu[$kedua_i]=$kedua_skor_j_pliu[$kedua_i]*$kedua_nt_biodiv[$kedua_i];
                 $kedua_na_total_biodiv_pohon_jpliu[0] += $kedua_na_biodiv_pohon_jpliu[$kedua_i];
                 //  nilai akhir biodiversitas pohon dmg
                 $kedua_na_biodiv_pohon_dmg[$kedua_i]=$kedua_skor_d_mg[$kedua_i]*$kedua_nt_biodiv[$kedua_i];
                 $kedua_na_total_biodiv_pohon_dmg[0] += $kedua_na_biodiv_pohon_dmg[$kedua_i];
                 //  nilai akhir biodiversitas fauna
                 $kedua_na_biodiv_fauna[$kedua_i]=$kedua_skor_h_aksenf[$kedua_i]*$kedua_nt_biodivf[$kedua_i];
                 $kedua_na_total_biodiv_fauna[0] += $kedua_na_biodiv_fauna[$kedua_i];
                 $kedua_na_biodiv_fauna_jpliuf[$kedua_i]=$kedua_skor_j_pliuf[$kedua_i]*$kedua_nt_biodivf[$kedua_i];
                 $kedua_na_total_biodiv_fauna_jpliuf[0] += $kedua_na_biodiv_fauna_jpliuf[$kedua_i];
                 $kedua_na_biodiv_fauna_dmgf[$kedua_i]=$kedua_skor_d_mgf[$kedua_i]*$kedua_nt_biodivf[$kedua_i];
                 $kedua_na_total_biodiv_fauna_dmgf[0] += $kedua_na_biodiv_fauna_dmgf[$kedua_i];
             }
             $kedua_na_total_cec[0] = $kedua_na_total_cec[0]/$kedua_i;
             $kedua_na_total_lbds[0] = $kedua_na_total_lbds[0]/$kedua_i;
             $kedua_na_total_volume[0] = $kedua_na_total_volume[0]/$kedua_i;
             $kedua_na_total_kerusakan[0] = $kedua_na_total_kerusakan[0]/$kedua_i;
             $kedua_na_total_tajuk[0] = $kedua_na_total_tajuk[0]/$kedua_i;
             $kedua_na_total_biodiv_pohon[0] = $kedua_na_total_biodiv_pohon[0]/$kedua_i;
             $kedua_na_total_biodiv_pohon_jpliu[0] = $kedua_na_total_biodiv_pohon_jpliu[0]/$kedua_i;
             $kedua_na_total_biodiv_pohon_dmg[0] = $kedua_na_total_biodiv_pohon_dmg[0]/$kedua_i;
             $kedua_na_total_biodiv_fauna[0] = $kedua_na_total_biodiv_fauna[0]/$kedua_i;
             $kedua_na_total_biodiv_fauna_jpliuf[0] = $kedua_na_total_biodiv_fauna_jpliuf[0]/$kedua_i;
             $kedua_na_total_biodiv_fauna_dmgf[0] = $kedua_na_total_biodiv_fauna_dmgf[0]/$kedua_i;

             // nilai total indikator
             $kedua_na_seluruh[0] = 0;
             for ($kedua_i=0; $kedua_i < count($id_klaster2); $kedua_i++) {
               $kedua_na_total[$kedua_i]=$kedua_na_kerusakan[$kedua_i]+$kedua_na_tajuk[$kedua_i]+$kedua_na_biodiv_pohon[$kedua_i]+$kedua_na_biodiv_pohon_jpliu[$kedua_i]+$kedua_na_biodiv_pohon_dmg[$kedua_i]+$kedua_na_lbds[$kedua_i]+$kedua_na_volume[$kedua_i]+$kedua_na_biodiv_fauna[$kedua_i]+$kedua_na_biodiv_fauna_jpliuf[$kedua_i]+$kedua_na_cec[$kedua_i];
               $kedua_na_seluruh[0] += $kedua_na_total[$kedua_i];
             }
             $kedua_na_seluruh[0] = $kedua_na_seluruh[0]/$kedua_i;

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

             return view('auditor.nilai.skoring_perubahan',[
               'jumlah_penilaian' => $jumlah_penilaian,
               'id_data_klaster' => $id_data_klaster,
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
             ]);
           }
           else {
               return view('auditor.home',[

                 ]);
           }
           }
         }

         // tambah kode jika semua pengukuran ?
         else if($pengukuran_ke=="%"){
           $id_klaster = $this->PengukuranKe($id_data_klaster,1);
           $id_klaster2 = $this->PengukuranKe2($id_data_klaster,2);
           $id_klaster3 = $this->PengukuranKe2($id_data_klaster,3);

           if(count($id_klaster)>0 && count($id_klaster2)>0 && count($id_klaster3)>0){

             // Untuk perhitungan lebih dari sama dengan 1 klaster
             $jumlah_penilaian = count($id_klaster);
             if ($jumlah_penilaian>=1){
               // memberikan array data tanaman per klaster
               for($i=0;$i<count($id_klaster);$i++){
                 $data_tanaman[$i]=DB::table('data_tanaman_plot')
                 ->join('tbl_plot','tbl_plot.id_plot','=','data_tanaman_plot.id_plot')
                 ->join('table_master_jenis_tanaman','table_master_jenis_tanaman.id_jenis_tanaman','=','data_tanaman_plot.id_master_jenis_tanaman')
                 ->where('data_tanaman_plot.id_klaster_plot',$id_klaster[$i]->id_klaster_plot)
                 ->where('data_tanaman_plot.pengukuran_ke','=',$pengukuran_ke)
                 ->get();
               }

               // inisialisasi nilai awal
               $m=0;
               $tli_r=[];
               $vcr_r=[];
               $lbds_r=[];
               $volume_r=[];
               $cec_r=[];

               // looping sampai id klaster habis
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
                        $data_pengukuran_ktk_kimia = $this->DataPengukuranKimia($id_cl,1,$sifat_kimia);

                        // jika data sifat ada
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
                      // mendapatkan nilai tli klaster
                      $tli_f[$k] = $this->DataPengukuran("kerusakan",$id_pengukuran1[$k]);
                    }
                    else{
                      $tli_f[$k]=0;
                    }

                    // untuk data pengukuran tajuk
                    if($p_ktjk!=""){
                      $vcr_f[$k] = $this->DataPengukuran("tajuk",$id_pengukuran1[$k]);
                    }
                    else{
                      $vcr_f[$k]=0;
                    }

                    // untuk data pengukuran lbds
                    if($p_lbds!=""){
                      $lbds_f[$k] = $this->DataPengukuran("lbds",$id_pengukuran1[$k]);
                    }
                    else{
                      $lbds_f[$k]=0;
                    }

                    // untuk data pengukuran volume
                    if($p_volume!=""){
                      $volume_f[$k] = $this->DataPengukuran("volume",$id_pengukuran1[$k]);
                    }
                    else{
                      $volume_f[$k]=0;
                    }

                    // nilai total parameter klaster
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

                  // untuk dibagi 4 plot ?
                  $cec_r[$m]=$cec_r[$m]/count($id_pengukuran1);
                  $tli_r[$m]=$tli_r[$m]/count($id_pengukuran1);
                  $vcr_r[$m]=$vcr_r[$m]/count($id_pengukuran1);
                  $lbds_r[$m]=$lbds_r[$m]/count($id_pengukuran1);
                  $volume_r[$m]=$volume_r[$m]/count($id_pengukuran1);
                  //

                }
                else{
                  // jika id klaster tidak ada
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
                $rata_h_aksen[$i]=0;
                $j_pliu_klaster[$i] = 0;
                $d_mg[$i]=0;
                for($q=0;$q<count($plot);$q++){
                  $h_aksen[$q]=0;
                  // jika haksen pohon yg dipilih
                  if($haksenp!=""){
                    $h_aksen[$q] = $this->BiodiversitasPohon($plot[$q]->id_plot,1);
                    // jika param jpliu tidak ada maka h aksen diitung di haksen
                    if($p_jpliu==""){
                      $rata_h_aksen[$i]+=$h_aksen[$q];
                    }
                  }

                  // jika jpliu pohon dipilih
                  if($p_jpliu!=""){
                    $h_aksen[$q] = $this->BiodiversitasPohon($plot[$q]->id_plot,1);

                    $rata_h_aksen[$i]+=$h_aksen[$q];

                      $jenis_pohon_klaster[$q]=DB::table('data_tanaman_plot')
                        ->select(DB::raw("data_tanaman_plot.id_master_jenis_tanaman, COUNT(*) as jumlah"))
                        ->where('data_tanaman_plot.id_plot','=',$plot[$q]->id_plot)
                        ->where('status','=','1')
                        ->where('pengukuran_ke','=',1)
                        ->groupBy(DB::raw('data_tanaman_plot.id_master_jenis_tanaman'))
                        ->get();
                      $jml_jenis_klaster[$q] = count($jenis_pohon_klaster[$q]);

                      if($jml_jenis_klaster[$q]>1){
                      $j_pliu_klaster[$i]+=$h_aksen[$q]/log($jml_jenis_klaster[$q]);
                    }
                  }
                }
                // APAKAH DIBAGI DENGAN 4?
                // nilai haksen pohon
                $h_aksen_klaster[$i] = $rata_h_aksen[$i]/4;
                // nilai jpliu pohon
                $j_pliu_klaster[$i] = $j_pliu_klaster[$i]/4;

                // dmg biodiversitas pohon
                if($p_dmg!=""){
                  $d_mg[$i] = $this->BiodivDmgPohon(1,$id_klaster[$i]->id_klaster_plot);
                }
                  // END

                // jika haksen fauna yang dipilih
                $h_aksenf[$i]=0;
                if($haksenf!=""){
                  if($p_jpliuf==""){
                    $h_aksenf[$i]= $this->BiodivFauna($id_cl,1);
                  }

                }

                // data jpliu fauna
                $j_pliuf[$i] = 0;
                if($p_jpliuf!=""){
                  $h_aksenf[$i]= $this->BiodivFauna($id_cl,1);

                  $data_biodiv_fauna[$i] = DB::table('data_fauna')
                  ->where('id_klaster_plot_fauna','=',$id_cl)
                  ->where('pengukuran_ke','=',1)
                  ->get();
                  $tot_data_fauna[$i]=count($data_biodiv_fauna[$i]);

                  if($tot_data_fauna[$i]>1){
                    $j_pliuf[$i] = $h_aksenf[$i]/log($tot_data_fauna[$i]);
                  }
                }

                // data dmg fauna
                $d_mgf[$i]=0;
                if($p_dmgf!=""){
                  $d_mgf[$i] = $this->BiodivDmgFauna(1,$id_cl);
                }
               }

               // hanya pembulatan
               for ($a=0;$a<count($tli_r);$a++){
                 $cec_r[$a]=round(($cec_r[$a]),3);
                 $lbds_r[$a]=round(($lbds_r[$a]),3);
                 $volume_r[$a]=round(($volume_r[$a]),3);
                 $tli_r[$a]=round(($tli_r[$a]),3);
                 $vcr_r[$a]=round(($vcr_r[$a]),3);
                 $d_mg[$a]=round($d_mg[$a],3);
                 $h_aksenf[$a]=round($h_aksenf[$a],3);
                 $j_pliuf[$a]=round($j_pliuf[$a],3);
                 $d_mgf[$a]=round($d_mgf[$a],3);
                 $j_pliu_klaster[$a]=round($j_pliu_klaster[$a],3);
                 $h_aksen_klaster[$a]=round($h_aksen_klaster[$a],3);
               }

               // UNTUK PERHITUNGAN NILAI SKOR INDIKATOR
               $range_cec_l=0;
               $range_cec_r=0;
               for ($i=0;$i<count($id_klaster);$i++){
                   $skor_cec[$i]=0;
                   $skor_lbds[$i]=0;
                   $skor_volume[$i]=0;
                   $skor_tli[$i]=0;
                   $skor_vcr[$i]=0;
                   $skor_h_aksen[$i]=0;
                   $skor_j_pliu[$i]=0;
                   $skor_d_mg[$i]=0;
                   $skor_h_aksenf[$i]=0;
                   $skor_j_pliuf[$i]=0;
                   $skor_d_mgf[$i]=0;
               }

               // range nilai skor Ktk kimia
               if($p_kimia!=""){
                 $range = $this->rangeSkorIndikator($cec_r,$id_klaster);
                 $range_cec_l=$range[0];
                 $range_cec_r=$range[1];
                 $skor_cec=$range[2];
               }

               // range nilai skor Produktivitas
               //lbds
               $range_lbds_l=0;
               $range_lbds_r=0;
               if($p_lbds!=""){
                 $range = $this->rangeSkorIndikator($lbds_r,$id_klaster);
                 $range_lbds_l=$range[0];
                 $range_lbds_r=$range[1];
                 $skor_lbds=$range[2];
               }

               //volume_v
               $range_volume_l=0;
               $range_volume_r=0;
               if($p_volume!=""){
                 $range = $this->rangeSkorIndikator($volume_r,$id_klaster);
                 $range_volume_l=$range[0];
                 $range_volume_r=$range[1];
                 $skor_volume=$range[2];
               }

               // range nilai skor kerusakan
               $range_tli_l=0;
               $range_tli_r=0;
               if($p_kerusakan!=""){
                 $range = $this->rangeSkorIndikatorKerusakan($tli_r,$id_klaster);
                 $range_tli_l=$range[0];
                 $range_tli_r=$range[1];
                 $skor_tli=$range[2];
               }

               // range nilai skor tajuk
               $range_vcr_l=0;
               $range_vcr_r=0;
               if($p_ktjk!=""){
                 $range = $this->rangeSkorIndikator($vcr_r,$id_klaster);
                 $range_vcr_l=$range[0];
                 $range_vcr_r=$range[1];
                 $skor_vcr=$range[2];
               }

               // range nilai skor h_aksen
               $range_h_aksen_l=0;
               $range_h_aksen_r=0;
               if($haksenp!=""){
                 $range = $this->rangeSkorIndikator($h_aksen_klaster,$id_klaster);
                 $range_h_aksen_l=$range[0];
                 $range_h_aksen_r=$range[1];
                 $skor_h_aksen=$range[2];
               }

               // range nilai skor j_pliup
               $range_j_pliu_l=0;
               $range_j_pliu_r=0;
               if($p_jpliu!=""){
                 $range = $this->rangeSkorIndikator($j_pliu_klaster,$id_klaster);
                 $range_j_pliu_l=$range[0];
                 $range_j_pliu_r=$range[1];
                 $skor_j_pliu=$range[2];
               }

               // range nilai skor d_mg
               $range_d_mg_l=0;
               $range_d_mg_r=0;
               if($p_dmg!=""){
                 $range = $this->rangeSkorIndikator($d_mg,$id_klaster);
                 $range_d_mg_l=$range[0];
                 $range_d_mg_r=$range[1];
                 $skor_d_mg=$range[2];
               }

               // range nilai skor h_aksenf
               $range_h_aksen_lf=0;
               $range_h_aksen_rf=0;
               if($haksenf!=""){
                 $range = $this->rangeSkorIndikator($h_aksenf,$id_klaster);
                 $range_h_aksen_lf=$range[0];
                 $range_h_aksen_rf=$range[1];
                 $skor_h_aksenf=$range[2];
               }

               // range nilai skor jpliuf
               $range_j_pliu_lf=0;
               $range_j_pliu_rf=0;
               if($p_jpliuf!=""){
                 $range = $this->rangeSkorIndikator($j_pliuf,$id_klaster);
                 $range_j_pliu_lf=$range[0];
                 $range_j_pliu_rf=$range[1];
                 $skor_j_pliuf=$range[2];
               }

               // range nilai skor dmgf
               $range_d_mg_lf=0;
               $range_d_mg_rf=0;
               if($p_dmgf!=""){
                 $range = $this->rangeSkorIndikator($d_mgf,$id_klaster);
                 $range_d_mg_lf=$range[0];
                 $range_d_mg_rf=$range[1];
                 $skor_d_mgf=$range[2];
               }

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

              $na_total_cec[0] = 0;
              $na_total_lbds[0] = 0;
              $na_total_volume[0] = 0;
              $na_total_kerusakan[0] = 0;
              $na_total_tajuk[0] = 0;
              $na_total_biodiv_pohon[0] = 0;
              $na_total_biodiv_pohon_jpliu[0] = 0;
              $na_total_biodiv_pohon_dmg[0] = 0;
              $na_total_biodiv_fauna[0] = 0;
              $na_total_biodiv_fauna_jpliuf[0] = 0;
              $na_total_biodiv_fauna_dmgf[0] = 0;
              for ($i=0; $i < count($id_klaster); $i++) {
                  //  nilai akhir ktk kimia
                  $na_cec[$i]=$skor_cec[$i]*$nt_ktpk[$i];
                  $na_total_cec[0] += $na_cec[$i];
                  //  nilai akhir Produktivitas lbds
                  $na_lbds[$i]=$skor_lbds[$i]*$nt_produktivitas[$i];
                  $na_total_lbds[0] += $na_lbds[$i];
                  //  nilai akhir Produktivitas volume
                  $na_volume[$i]=$skor_volume[$i]*$nt_produktivitas[$i];
                  $na_total_volume[0] += $na_volume[$i];
                  //  nilai akhir kerusakan pohon
                  $na_kerusakan[$i]=$skor_tli[$i]*$nt_kerusakan[$i];
                  $na_total_kerusakan[0] += $na_kerusakan[$i];
                  //  nilai akhir kondisi tajuk
                  $na_tajuk[$i]=$skor_vcr[$i]*$nt_ktjk[$i];
                  $na_total_tajuk[0] += $na_tajuk[$i];
                  //  nilai akhir biodiversitas pohon haksen
                  $na_biodiv_pohon[$i]=$skor_h_aksen[$i]*$nt_biodiv[$i];
                  $na_total_biodiv_pohon[0] += $na_biodiv_pohon[$i];
                  //  nilai akhir biodiversitas pohon jpliu
                  $na_biodiv_pohon_jpliu[$i]=$skor_j_pliu[$i]*$nt_biodiv[$i];
                  $na_total_biodiv_pohon_jpliu[0] += $na_biodiv_pohon_jpliu[$i];
                  //  nilai akhir biodiversitas pohon dmg
                  $na_biodiv_pohon_dmg[$i]=$skor_d_mg[$i]*$nt_biodiv[$i];
                  $na_total_biodiv_pohon_dmg[0] += $na_biodiv_pohon_dmg[$i];
                  //  nilai akhir biodiversitas fauna
                  $na_biodiv_fauna[$i]=$skor_h_aksenf[$i]*$nt_biodivf[$i];
                  $na_total_biodiv_fauna[0] += $na_biodiv_fauna[$i];
                  $na_biodiv_fauna_jpliuf[$i]=$skor_j_pliuf[$i]*$nt_biodivf[$i];
                  $na_total_biodiv_fauna_jpliuf[0] += $na_biodiv_fauna_jpliuf[$i];
                  $na_biodiv_fauna_dmgf[$i]=$skor_d_mgf[$i]*$nt_biodivf[$i];
                  $na_total_biodiv_fauna_dmgf[0] += $na_biodiv_fauna_dmgf[$i];
              }

              $na_total_cec[0] = $na_total_cec[0]/$i;
              $na_total_lbds[0] = $na_total_lbds[0]/$i;
              $na_total_volume[0] = $na_total_volume[0]/$i;
              $na_total_kerusakan[0] = $na_total_kerusakan[0]/$i;
              $na_total_tajuk[0] = $na_total_tajuk[0]/$i;
              $na_total_biodiv_pohon[0] = $na_total_biodiv_pohon[0]/$i;
              $na_total_biodiv_pohon_jpliu[0] = $na_total_biodiv_pohon_jpliu[0]/$i;
              $na_total_biodiv_pohon_dmg[0] = $na_total_biodiv_pohon_dmg[0]/$i;
              $na_total_biodiv_fauna[0] = $na_total_biodiv_fauna[0]/$i;
              $na_total_biodiv_fauna_jpliuf[0] = $na_total_biodiv_fauna_jpliuf[0]/$i;
              $na_total_biodiv_fauna_dmgf[0] = $na_total_biodiv_fauna_dmgf[0]/$i;

              // nilai total indikator
              $na_seluruh[0] = 0;
              for ($i=0; $i < count($id_klaster); $i++) {
                $na_total[$i]=$na_kerusakan[$i]+$na_tajuk[$i]+$na_biodiv_pohon[$i]+$na_biodiv_pohon_jpliu[$i]+$na_biodiv_pohon_dmg[$i]+$na_lbds[$i]+$na_volume[$i]+$na_biodiv_fauna[$i]+$na_biodiv_fauna_jpliuf[$i]+$na_cec[$i];
                $na_seluruh[0] += $na_total[$i];
              }
              $na_seluruh[0] = $na_seluruh[0]/$i;


              // PENGUKURAN KE 2
              // inisialisasi nilai awal
              $kedua_m=0;
              $kedua_tli_r=[];
              $kedua_vcr_r=[];
              $kedua_lbds_r=[];
              $kedua_volume_r=[];
              $kedua_cec_r=[];

              // looping sampai id klaster habis
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
                     if($sifat_kimia==""){
                       $kedua_cec_f[$kedua_i]=0;
                     }
                     else{
                       $kedua_data_pengukuran_ktk_kimia = $this->DataPengukuranKimia($kedua_id_cl,2,$sifat_kimia);

                       // jika data sifat ada
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
                     // mendapatkan nilai tli klaster
                     $kedua_tli_f[$kedua_k] = $this->DataPengukuran("kerusakan",$kedua_id_pengukuran1[$kedua_k]);
                   }
                   else{
                     $kedua_tli_f[$kedua_k]=0;
                   }

                   // untuk data pengukuran tajuk
                   if($p_ktjk!=""){
                     $kedua_vcr_f[$kedua_k] = $this->DataPengukuran("tajuk",$kedua_id_pengukuran1[$kedua_k]);
                   }
                   else{
                     $kedua_vcr_f[$kedua_k]=0;
                   }

                   // untuk data pengukuran lbds
                   if($p_lbds!=""){
                     $kedua_lbds_f[$kedua_k] = $this->DataPengukuran("lbds",$kedua_id_pengukuran1[$kedua_k]);
                   }
                   else{
                     $kedua_lbds_f[$kedua_k]=0;
                   }

                   // untuk data pengukuran volume
                   if($p_volume!=""){
                     $kedua_volume_f[$kedua_k] = $this->DataPengukuran("volume",$kedua_id_pengukuran1[$kedua_k]);
                   }
                   else{
                     $kedua_volume_f[$kedua_k]=0;
                   }

                   // nilai total parameter klaster
                   //nilai total KTPK
                   $kedua_cec_r[$kedua_m]+=$kedua_cec_f[$kedua_i];
                   // nilai total PLI
                   $kedua_tli_r[$kedua_m]+=$kedua_tli_f[$kedua_k];
                   // nilai total VCR
                   $kedua_vcr_r[$kedua_m]+=$kedua_vcr_f[$kedua_k];
                   // nilai total LBDS
                   $kedua_lbds_r[$kedua_m]+=$kedua_lbds_f[$kedua_k];
                   // nilai total Volume
                   $kedua_volume_r[$kedua_m]+=$kedua_volume_f[$kedua_k];

                 }

                 // untuk dibagi 4 plot ?
                 $kedua_cec_r[$kedua_m]=$kedua_cec_r[$kedua_m]/count($kedua_id_pengukuran1);
                 $kedua_tli_r[$kedua_m]=$kedua_tli_r[$kedua_m]/count($kedua_id_pengukuran1);
                 $kedua_vcr_r[$kedua_m]=$kedua_vcr_r[$kedua_m]/count($kedua_id_pengukuran1);
                 $kedua_lbds_r[$kedua_m]=$kedua_lbds_r[$kedua_m]/count($kedua_id_pengukuran1);
                 $kedua_volume_r[$kedua_m]=$kedua_volume_r[$kedua_m]/count($kedua_id_pengukuran1);
                 //

               }
               else{
                 // jika id klaster tidak ada
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
               $kedua_rata_h_aksen[$kedua_i]=0;
               $kedua_j_pliu_klaster[$kedua_i] = 0;
               $kedua_d_mg[$kedua_i]=0;
               for($kedua_q=0;$kedua_q<count($kedua_plot);$kedua_q++){
                 $kedua_h_aksen[$kedua_q]=0;
                 // jika haksen pohon yg dipilih
                 if($haksenp!=""){
                   $kedua_h_aksen[$kedua_q] = $this->BiodiversitasPohon($kedua_plot[$kedua_q]->id_plot,2);
                   // jika param jpliu tidak ada maka h aksen diitung di haksen
                   if($p_jpliu==""){
                     $kedua_rata_h_aksen[$kedua_i]+=$kedua_h_aksen[$kedua_q];
                   }
                 }

                 // jika jpliu pohon dipilih
                 if($p_jpliu!=""){
                   $kedua_h_aksen[$kedua_q] = $this->BiodiversitasPohon($kedua_plot[$kedua_q]->id_plot,2);

                   $kedua_rata_h_aksen[$kedua_i]+=$kedua_h_aksen[$kedua_q];

                     $kedua_jenis_pohon_klaster[$kedua_q]=DB::table('data_tanaman_plot')
                       ->select(DB::raw("data_tanaman_plot.id_master_jenis_tanaman, COUNT(*) as jumlah"))
                       ->where('data_tanaman_plot.id_plot','=',$kedua_plot[$kedua_q]->id_plot)
                       ->where('status','=','1')
                       ->where('pengukuran_ke','=',2)
                       ->groupBy(DB::raw('data_tanaman_plot.id_master_jenis_tanaman'))
                       ->get();
                     $kedua_jml_jenis_klaster[$kedua_q] = count($kedua_jenis_pohon_klaster[$kedua_q]);

                     if($kedua_jml_jenis_klaster[$kedua_q]>1){
                     $kedua_j_pliu_klaster[$kedua_i]+=$kedua_h_aksen[$kedua_q]/log($kedua_jml_jenis_klaster[$kedua_q]);
                   }
                 }
               }
               // APAKAH DIBAGI DENGAN 4?
               // nilai haksen pohon
               $kedua_h_aksen_klaster[$kedua_i] = $kedua_rata_h_aksen[$kedua_i]/4;
               // nilai jpliu pohon
               $kedua_j_pliu_klaster[$kedua_i] = $kedua_j_pliu_klaster[$kedua_i]/4;

               // dmg biodiversitas pohon
               if($p_dmg!=""){
                 $kedua_d_mg[$kedua_i] = $this->BiodivDmgPohon(2,$id_klaster2[$kedua_i]->id_klaster_plot);
               }
                 // END

               // jika haksen fauna yang dipilih
               $kedua_h_aksenf[$kedua_i]=0;
               if($haksenf!=""){
                 if($p_jpliuf==""){
                   $kedua_h_aksenf[$kedua_i]= $this->BiodivFauna($kedua_id_cl,2);
                 }

               }

               // data jpliu fauna
               $kedua_j_pliuf[$kedua_i] = 0;
               if($p_jpliuf!=""){
                 $kedua_h_aksenf[$kedua_i]= $this->BiodivFauna($kedua_id_cl,2);

                 $kedua_data_biodiv_fauna[$kedua_i] = DB::table('data_fauna')
                 ->where('id_klaster_plot_fauna','=',$kedua_id_cl)
                 ->where('pengukuran_ke','=',2)
                 ->get();
                 $kedua_tot_data_fauna[$kedua_i]=count($kedua_data_biodiv_fauna[$kedua_i]);

                 if($kedua_tot_data_fauna[$kedua_i]>1){
                   $kedua_j_pliuf[$kedua_i] = $kedua_h_aksenf[$kedua_i]/log($kedua_tot_data_fauna[$kedua_i]);
                 }
               }

               // data dmg fauna
               $kedua_d_mgf[$kedua_i]=0;
               if($p_dmgf!=""){
                 $kedua_d_mgf[$kedua_i] = $this->BiodivDmgFauna(2,$kedua_id_cl);
               }
              }

              // hanya pembulatan
              for ($kedua_a=0;$kedua_a<count($kedua_tli_r);$kedua_a++){
                $kedua_cec_r[$kedua_a]=round(($kedua_cec_r[$kedua_a]),3);
                $kedua_lbds_r[$kedua_a]=round(($kedua_lbds_r[$kedua_a]),3);
                $kedua_volume_r[$kedua_a]=round(($kedua_volume_r[$kedua_a]),3);
                $kedua_tli_r[$kedua_a]=round(($kedua_tli_r[$kedua_a]),3);
                $kedua_vcr_r[$kedua_a]=round(($kedua_vcr_r[$kedua_a]),3);
                $kedua_d_mg[$kedua_a]=round($kedua_d_mg[$kedua_a],3);
                $kedua_h_aksenf[$kedua_a]=round($kedua_h_aksenf[$kedua_a],3);
                $kedua_j_pliuf[$kedua_a]=round($kedua_j_pliuf[$kedua_a],3);
                $kedua_d_mgf[$kedua_a]=round($kedua_d_mgf[$kedua_a],3);
                $kedua_j_pliu_klaster[$kedua_a]=round($kedua_j_pliu_klaster[$kedua_a],3);
                $kedua_h_aksen_klaster[$kedua_a]=round($kedua_h_aksen_klaster[$kedua_a],3);
              }

              // UNTUK PERHITUNGAN NILAI SKOR INDIKATOR
              $kedua_range_cec_l=0;
              $kedua_range_cec_r=0;
              for ($kedua_i=0;$kedua_i<count($id_klaster2);$kedua_i++){
                  $kedua_skor_cec[$kedua_i]=0;
                  $kedua_skor_lbds[$kedua_i]=0;
                  $kedua_skor_volume[$kedua_i]=0;
                  $kedua_skor_tli[$kedua_i]=0;
                  $kedua_skor_vcr[$kedua_i]=0;
                  $kedua_skor_h_aksen[$kedua_i]=0;
                  $kedua_skor_j_pliu[$kedua_i]=0;
                  $kedua_skor_d_mg[$kedua_i]=0;
                  $kedua_skor_h_aksenf[$kedua_i]=0;
                  $kedua_skor_j_pliuf[$kedua_i]=0;
                  $kedua_skor_d_mgf[$kedua_i]=0;
              }

              // range nilai skor Ktk kimia
              if($p_kimia!=""){
                $kedua_range = $this->rangeSkorIndikator($kedua_cec_r,$id_klaster2);
                $kedua_range_cec_l=$kedua_range[0];
                $kedua_range_cec_r=$kedua_range[1];
                $kedua_skor_cec=$kedua_range[2];
              }

              // range nilai skor Produktivitas
              //lbds
              $kedua_range_lbds_l=0;
              $kedua_range_lbds_r=0;
              if($p_lbds!=""){
                $kedua_range = $this->rangeSkorIndikator($kedua_lbds_r,$id_klaster2);
                $kedua_range_lbds_l=$kedua_range[0];
                $kedua_range_lbds_r=$kedua_range[1];
                $kedua_skor_lbds=$kedua_range[2];
              }

              //volume_v
              $kedua_range_volume_l=0;
              $kedua_range_volume_r=0;
              if($p_volume!=""){
                $kedua_range = $this->rangeSkorIndikator($kedua_volume_r,$id_klaster2);
                $kedua_range_volume_l=$kedua_range[0];
                $kedua_range_volume_r=$kedua_range[1];
                $kedua_skor_volume=$kedua_range[2];
              }

              // range nilai skor kerusakan
              $kedua_range_tli_l=0;
              $kedua_range_tli_r=0;
              if($p_kerusakan!=""){
                $kedua_range = $this->rangeSkorIndikatorKerusakan($kedua_tli_r,$id_klaster2);
                $kedua_range_tli_l=$kedua_range[0];
                $kedua_range_tli_r=$kedua_range[1];
                $kedua_skor_tli=$kedua_range[2];
              }

              // range nilai skor tajuk
              $kedua_range_vcr_l=0;
              $kedua_range_vcr_r=0;
              if($p_ktjk!=""){
                $kedua_range = $this->rangeSkorIndikator($kedua_vcr_r,$id_klaster2);
                $kedua_range_vcr_l=$kedua_range[0];
                $kedua_range_vcr_r=$kedua_range[1];
                $kedua_skor_vcr=$kedua_range[2];
              }

              // range nilai skor h_aksen
              $kedua_range_h_aksen_l=0;
              $kedua_range_h_aksen_r=0;
              if($haksenp!=""){
                $kedua_range = $this->rangeSkorIndikator($kedua_h_aksen_klaster,$id_klaster2);
                $kedua_range_h_aksen_l=$kedua_range[0];
                $kedua_range_h_aksen_r=$kedua_range[1];
                $kedua_skor_h_aksen=$kedua_range[2];
              }

              // range nilai skor j_pliup
              $kedua_range_j_pliu_l=0;
              $kedua_range_j_pliu_r=0;
              if($p_jpliu!=""){
                $kedua_range = $this->rangeSkorIndikator($kedua_j_pliu_klaster,$id_klaster2);
                $kedua_range_j_pliu_l=$kedua_range[0];
                $kedua_range_j_pliu_r=$kedua_range[1];
                $kedua_skor_j_pliu=$kedua_range[2];
              }

              // range nilai skor d_mg
              $kedua_range_d_mg_l=0;
              $kedua_range_d_mg_r=0;
              if($p_dmg!=""){
                $kedua_range = $this->rangeSkorIndikator($kedua_d_mg,$id_klaster2);
                $kedua_range_d_mg_l=$kedua_range[0];
                $kedua_range_d_mg_r=$kedua_range[1];
                $kedua_skor_d_mg=$kedua_range[2];
              }

              // range nilai skor h_aksenf
              $kedua_range_h_aksen_lf=0;
              $kedua_range_h_aksen_rf=0;
              if($haksenf!=""){
                $kedua_range = $this->rangeSkorIndikator($kedua_h_aksenf,$id_klaster2);
                $kedua_range_h_aksen_lf=$kedua_range[0];
                $kedua_range_h_aksen_rf=$kedua_range[1];
                $kedua_skor_h_aksenf=$kedua_range[2];
              }

              // range nilai skor jpliuf
              $kedua_range_j_pliu_lf=0;
              $kedua_range_j_pliu_rf=0;
              if($p_jpliuf!=""){
                $kedua_range = $this->rangeSkorIndikator($kedua_j_pliuf,$id_klaster2);
                $kedua_range_j_pliu_lf=$kedua_range[0];
                $kedua_range_j_pliu_rf=$kedua_range[1];
                $kedua_skor_j_pliuf=$kedua_range[2];
              }

              // range nilai skor dmgf
              $kedua_range_d_mg_lf=0;
              $kedua_range_d_mg_rf=0;
              if($p_dmgf!=""){
                $kedua_range = $this->rangeSkorIndikator($kedua_d_mgf,$id_klaster2);
                $kedua_range_d_mg_lf=$kedua_range[0];
                $kedua_range_d_mg_rf=$kedua_range[1];
                $kedua_skor_d_mgf=$kedua_range[2];
              }

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

             $kedua_na_total_cec[0] = 0;
             $kedua_na_total_lbds[0] = 0;
             $kedua_na_total_volume[0] = 0;
             $kedua_na_total_kerusakan[0] = 0;
             $kedua_na_total_tajuk[0] = 0;
             $kedua_na_total_biodiv_pohon[0] = 0;
             $kedua_na_total_biodiv_pohon_jpliu[0] = 0;
             $kedua_na_total_biodiv_pohon_dmg[0] = 0;
             $kedua_na_total_biodiv_fauna[0] = 0;
             $kedua_na_total_biodiv_fauna_jpliuf[0] = 0;
             $kedua_na_total_biodiv_fauna_dmgf[0] = 0;
             for ($kedua_i=0; $kedua_i < count($id_klaster2); $kedua_i++) {
                 //  nilai akhir ktk kimia
                 $kedua_na_cec[$kedua_i]=$kedua_skor_cec[$kedua_i]*$kedua_nt_ktpk[$kedua_i];
                 $kedua_na_total_cec[0] += $kedua_na_cec[$kedua_i];
                 //  nilai akhir Produktivitas lbds
                 $kedua_na_lbds[$kedua_i]=$kedua_skor_lbds[$kedua_i]*$kedua_nt_produktivitas[$kedua_i];
                 $kedua_na_total_lbds[0] += $kedua_na_lbds[$kedua_i];
                 //  nilai akhir Produktivitas volume
                 $kedua_na_volume[$kedua_i]=$kedua_skor_volume[$kedua_i]*$kedua_nt_produktivitas[$kedua_i];
                 $kedua_na_total_volume[0] += $kedua_na_volume[$kedua_i];
                 //  nilai akhir kerusakan pohon
                 $kedua_na_kerusakan[$kedua_i]=$kedua_skor_tli[$kedua_i]*$kedua_nt_kerusakan[$kedua_i];
                 $kedua_na_total_kerusakan[0] += $kedua_na_kerusakan[$kedua_i];
                 //  nilai akhir kondisi tajuk
                 $kedua_na_tajuk[$kedua_i]=$kedua_skor_vcr[$kedua_i]*$kedua_nt_ktjk[$kedua_i];
                 $kedua_na_total_tajuk[0] += $kedua_na_tajuk[$kedua_i];
                 //  nilai akhir biodiversitas pohon haksen
                 $kedua_na_biodiv_pohon[$kedua_i]=$kedua_skor_h_aksen[$kedua_i]*$kedua_nt_biodiv[$kedua_i];
                 $kedua_na_total_biodiv_pohon[0] += $kedua_na_biodiv_pohon[$kedua_i];
                 //  nilai akhir biodiversitas pohon jpliu
                 $kedua_na_biodiv_pohon_jpliu[$kedua_i]=$kedua_skor_j_pliu[$kedua_i]*$kedua_nt_biodiv[$kedua_i];
                 $kedua_na_total_biodiv_pohon_jpliu[0] += $kedua_na_biodiv_pohon_jpliu[$kedua_i];
                 //  nilai akhir biodiversitas pohon dmg
                 $kedua_na_biodiv_pohon_dmg[$kedua_i]=$kedua_skor_d_mg[$kedua_i]*$kedua_nt_biodiv[$kedua_i];
                 $kedua_na_total_biodiv_pohon_dmg[0] += $kedua_na_biodiv_pohon_dmg[$kedua_i];
                 //  nilai akhir biodiversitas fauna
                 $kedua_na_biodiv_fauna[$kedua_i]=$kedua_skor_h_aksenf[$kedua_i]*$kedua_nt_biodivf[$kedua_i];
                 $kedua_na_total_biodiv_fauna[0] += $kedua_na_biodiv_fauna[$kedua_i];
                 $kedua_na_biodiv_fauna_jpliuf[$kedua_i]=$kedua_skor_j_pliuf[$kedua_i]*$kedua_nt_biodivf[$kedua_i];
                 $kedua_na_total_biodiv_fauna_jpliuf[0] += $kedua_na_biodiv_fauna_jpliuf[$kedua_i];
                 $kedua_na_biodiv_fauna_dmgf[$kedua_i]=$kedua_skor_d_mgf[$kedua_i]*$kedua_nt_biodivf[$kedua_i];
                 $kedua_na_total_biodiv_fauna_dmgf[0] += $kedua_na_biodiv_fauna_dmgf[$kedua_i];
             }
             $kedua_na_total_cec[0] = $kedua_na_total_cec[0]/$kedua_i;
             $kedua_na_total_lbds[0] = $kedua_na_total_lbds[0]/$kedua_i;
             $kedua_na_total_volume[0] = $kedua_na_total_volume[0]/$kedua_i;
             $kedua_na_total_kerusakan[0] = $kedua_na_total_kerusakan[0]/$kedua_i;
             $kedua_na_total_tajuk[0] = $kedua_na_total_tajuk[0]/$kedua_i;
             $kedua_na_total_biodiv_pohon[0] = $kedua_na_total_biodiv_pohon[0]/$kedua_i;
             $kedua_na_total_biodiv_pohon_jpliu[0] = $kedua_na_total_biodiv_pohon_jpliu[0]/$kedua_i;
             $kedua_na_total_biodiv_pohon_dmg[0] = $kedua_na_total_biodiv_pohon_dmg[0]/$kedua_i;
             $kedua_na_total_biodiv_fauna[0] = $kedua_na_total_biodiv_fauna[0]/$kedua_i;
             $kedua_na_total_biodiv_fauna_jpliuf[0] = $kedua_na_total_biodiv_fauna_jpliuf[0]/$kedua_i;
             $kedua_na_total_biodiv_fauna_dmgf[0] = $kedua_na_total_biodiv_fauna_dmgf[0]/$kedua_i;

             // nilai total indikator
             $kedua_na_seluruh[0] = 0;
             for ($kedua_i=0; $kedua_i < count($id_klaster2); $kedua_i++) {
               $kedua_na_total[$kedua_i]=$kedua_na_kerusakan[$kedua_i]+$kedua_na_tajuk[$kedua_i]+$kedua_na_biodiv_pohon[$kedua_i]+$kedua_na_biodiv_pohon_jpliu[$kedua_i]+$kedua_na_biodiv_pohon_dmg[$kedua_i]+$kedua_na_lbds[$kedua_i]+$kedua_na_volume[$kedua_i]+$kedua_na_biodiv_fauna[$kedua_i]+$kedua_na_biodiv_fauna_jpliuf[$kedua_i]+$kedua_na_cec[$kedua_i];
               $kedua_na_seluruh[0] += $kedua_na_total[$kedua_i];
             }
             $kedua_na_seluruh[0] = $kedua_na_seluruh[0]/$kedua_i;

             // PENGUKURAN KE 3
             // inisialisasi nilai awal
              $ketiga_m=0;
              $ketiga_tli_r=[];
              $ketiga_vcr_r=[];
              $ketiga_lbds_r=[];
              $ketiga_volume_r=[];
              $ketiga_cec_r=[];

              // looping sampai id klaster habis
              for ($ketiga_i=0; $ketiga_i < count($id_klaster2); $ketiga_i++) {
                // untuk mengetahui id klaster saat ini
                $ketiga_id_cl=$id_klaster2[$ketiga_i]->id_klaster_plot;
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
                     if($sifat_kimia==""){
                       $ketiga_cec_f[$ketiga_i]=0;
                     }
                     else{
                       $ketiga_data_pengukuran_ktk_kimia = $this->DataPengukuranKimia($ketiga_id_cl,3,$sifat_kimia);

                       // jika data sifat ada
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
                     // mendapatkan nilai tli klaster
                     $ketiga_tli_f[$ketiga_k] = $this->DataPengukuran("kerusakan",$ketiga_id_pengukuran1[$ketiga_k]);
                   }
                   else{
                     $ketiga_tli_f[$ketiga_k]=0;
                   }

                   // untuk data pengukuran tajuk
                   if($p_ktjk!=""){
                     $ketiga_vcr_f[$ketiga_k] = $this->DataPengukuran("tajuk",$ketiga_id_pengukuran1[$ketiga_k]);
                   }
                   else{
                     $ketiga_vcr_f[$ketiga_k]=0;
                   }

                   // untuk data pengukuran lbds
                   if($p_lbds!=""){
                     $ketiga_lbds_f[$ketiga_k] = $this->DataPengukuran("lbds",$ketiga_id_pengukuran1[$ketiga_k]);
                   }
                   else{
                     $ketiga_lbds_f[$ketiga_k]=0;
                   }

                   // untuk data pengukuran volume
                   if($p_volume!=""){
                     $ketiga_volume_f[$ketiga_k] = $this->DataPengukuran("volume",$ketiga_id_pengukuran1[$ketiga_k]);
                   }
                   else{
                     $ketiga_volume_f[$ketiga_k]=0;
                   }

                   // nilai total parameter klaster
                   //nilai total KTPK
                   $ketiga_cec_r[$ketiga_m]+=$ketiga_cec_f[$ketiga_i];
                   // nilai total PLI
                   $ketiga_tli_r[$ketiga_m]+=$ketiga_tli_f[$ketiga_k];
                   // nilai total VCR
                   $ketiga_vcr_r[$ketiga_m]+=$ketiga_vcr_f[$ketiga_k];
                   // nilai total LBDS
                   $ketiga_lbds_r[$ketiga_m]+=$ketiga_lbds_f[$ketiga_k];
                   // nilai total Volume
                   $ketiga_volume_r[$ketiga_m]+=$ketiga_volume_f[$ketiga_k];

                 }

                 // untuk dibagi 4 plot ?
                 $ketiga_cec_r[$ketiga_m]=$ketiga_cec_r[$ketiga_m]/count($ketiga_id_pengukuran1);
                 $ketiga_tli_r[$ketiga_m]=$ketiga_tli_r[$ketiga_m]/count($ketiga_id_pengukuran1);
                 $ketiga_vcr_r[$ketiga_m]=$ketiga_vcr_r[$ketiga_m]/count($ketiga_id_pengukuran1);
                 $ketiga_lbds_r[$ketiga_m]=$ketiga_lbds_r[$ketiga_m]/count($ketiga_id_pengukuran1);
                 $ketiga_volume_r[$ketiga_m]=$ketiga_volume_r[$ketiga_m]/count($ketiga_id_pengukuran1);
                 //

               }
               else{
                 // jika id klaster tidak ada
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
               $ketiga_rata_h_aksen[$ketiga_i]=0;
               $ketiga_j_pliu_klaster[$ketiga_i] = 0;
               $ketiga_d_mg[$ketiga_i]=0;
               for($ketiga_q=0;$ketiga_q<count($ketiga_plot);$ketiga_q++){
                 $ketiga_h_aksen[$ketiga_q]=0;
                 // jika haksen pohon yg dipilih
                 if($haksenp!=""){
                   $ketiga_h_aksen[$ketiga_q] = $this->BiodiversitasPohon($ketiga_plot[$ketiga_q]->id_plot,3);
                   // jika param jpliu tidak ada maka h aksen diitung di haksen
                   if($p_jpliu==""){
                     $ketiga_rata_h_aksen[$ketiga_i]+=$ketiga_h_aksen[$ketiga_q];
                   }
                 }

                 // jika jpliu pohon dipilih
                 if($p_jpliu!=""){
                   $ketiga_h_aksen[$ketiga_q] = $this->BiodiversitasPohon($ketiga_plot[$ketiga_q]->id_plot,3);

                   $ketiga_rata_h_aksen[$ketiga_i]+=$ketiga_h_aksen[$ketiga_q];

                     $ketiga_jenis_pohon_klaster[$ketiga_q]=DB::table('data_tanaman_plot')
                       ->select(DB::raw("data_tanaman_plot.id_master_jenis_tanaman, COUNT(*) as jumlah"))
                       ->where('data_tanaman_plot.id_plot','=',$ketiga_plot[$ketiga_q]->id_plot)
                       ->where('status','=','1')
                       ->where('pengukuran_ke','=',3)
                       ->groupBy(DB::raw('data_tanaman_plot.id_master_jenis_tanaman'))
                       ->get();
                     $ketiga_jml_jenis_klaster[$ketiga_q] = count($ketiga_jenis_pohon_klaster[$ketiga_q]);

                     if($ketiga_jml_jenis_klaster[$ketiga_q]>1){
                     $ketiga_j_pliu_klaster[$ketiga_i]+=$ketiga_h_aksen[$ketiga_q]/log($ketiga_jml_jenis_klaster[$ketiga_q]);
                   }
                 }
               }
               // APAKAH DIBAGI DENGAN 4?
               // nilai haksen pohon
               $ketiga_h_aksen_klaster[$ketiga_i] = $ketiga_rata_h_aksen[$ketiga_i]/4;
               // nilai jpliu pohon
               $ketiga_j_pliu_klaster[$ketiga_i] = $ketiga_j_pliu_klaster[$ketiga_i]/4;

               // dmg biodiversitas pohon
               if($p_dmg!=""){
                 $ketiga_d_mg[$ketiga_i] = $this->BiodivDmgPohon(3,$id_klaster2[$ketiga_i]->id_klaster_plot);
               }
                 // END

               // jika haksen fauna yang dipilih
               $ketiga_h_aksenf[$ketiga_i]=0;
               if($haksenf!=""){
                 if($p_jpliuf==""){
                   $ketiga_h_aksenf[$ketiga_i]= $this->BiodivFauna($ketiga_id_cl,3);
                 }

               }

               // data jpliu fauna
               $ketiga_j_pliuf[$ketiga_i] = 0;
               if($p_jpliuf!=""){
                 $ketiga_h_aksenf[$ketiga_i]= $this->BiodivFauna($ketiga_id_cl,3);

                 $ketiga_data_biodiv_fauna[$ketiga_i] = DB::table('data_fauna')
                 ->where('id_klaster_plot_fauna','=',$ketiga_id_cl)
                 ->where('pengukuran_ke','=',3)
                 ->get();
                 $ketiga_tot_data_fauna[$ketiga_i]=count($ketiga_data_biodiv_fauna[$ketiga_i]);

                 if($ketiga_tot_data_fauna[$ketiga_i]>1){
                   $ketiga_j_pliuf[$ketiga_i] = $ketiga_h_aksenf[$ketiga_i]/log($ketiga_tot_data_fauna[$ketiga_i]);
                 }
               }

               // data dmg fauna
               $ketiga_d_mgf[$ketiga_i]=0;
               if($p_dmgf!=""){
                 $ketiga_d_mgf[$ketiga_i] = $this->BiodivDmgFauna(3,$ketiga_id_cl);
               }
              }

              // hanya pembulatan
              for ($ketiga_a=0;$ketiga_a<count($ketiga_tli_r);$ketiga_a++){
                $ketiga_cec_r[$ketiga_a]=round(($ketiga_cec_r[$ketiga_a]),3);
                $ketiga_lbds_r[$ketiga_a]=round(($ketiga_lbds_r[$ketiga_a]),3);
                $ketiga_volume_r[$ketiga_a]=round(($ketiga_volume_r[$ketiga_a]),3);
                $ketiga_tli_r[$ketiga_a]=round(($ketiga_tli_r[$ketiga_a]),3);
                $ketiga_vcr_r[$ketiga_a]=round(($ketiga_vcr_r[$ketiga_a]),3);
                $ketiga_d_mg[$ketiga_a]=round($ketiga_d_mg[$ketiga_a],3);
                $ketiga_h_aksenf[$ketiga_a]=round($ketiga_h_aksenf[$ketiga_a],3);
                $ketiga_j_pliuf[$ketiga_a]=round($ketiga_j_pliuf[$ketiga_a],3);
                $ketiga_d_mgf[$ketiga_a]=round($ketiga_d_mgf[$ketiga_a],3);
                $ketiga_j_pliu_klaster[$ketiga_a]=round($ketiga_j_pliu_klaster[$ketiga_a],3);
                $ketiga_h_aksen_klaster[$ketiga_a]=round($ketiga_h_aksen_klaster[$ketiga_a],3);
              }

              // UNTUK PERHITUNGAN NILAI SKOR INDIKATOR
              $ketiga_range_cec_l=0;
              $ketiga_range_cec_r=0;
              for ($ketiga_i=0;$ketiga_i<count($id_klaster2);$ketiga_i++){
                  $ketiga_skor_cec[$ketiga_i]=0;
                  $ketiga_skor_lbds[$ketiga_i]=0;
                  $ketiga_skor_volume[$ketiga_i]=0;
                  $ketiga_skor_tli[$ketiga_i]=0;
                  $ketiga_skor_vcr[$ketiga_i]=0;
                  $ketiga_skor_h_aksen[$ketiga_i]=0;
                  $ketiga_skor_j_pliu[$ketiga_i]=0;
                  $ketiga_skor_d_mg[$ketiga_i]=0;
                  $ketiga_skor_h_aksenf[$ketiga_i]=0;
                  $ketiga_skor_j_pliuf[$ketiga_i]=0;
                  $ketiga_skor_d_mgf[$ketiga_i]=0;
              }

              // range nilai skor Ktk kimia
              if($p_kimia!=""){
                $ketiga_range = $this->rangeSkorIndikator($ketiga_cec_r,$id_klaster2);
                $ketiga_range_cec_l=$ketiga_range[0];
                $ketiga_range_cec_r=$ketiga_range[1];
                $ketiga_skor_cec=$ketiga_range[2];
              }

              // range nilai skor Produktivitas
              //lbds
              $ketiga_range_lbds_l=0;
              $ketiga_range_lbds_r=0;
              if($p_lbds!=""){
                $ketiga_range = $this->rangeSkorIndikator($ketiga_lbds_r,$id_klaster2);
                $ketiga_range_lbds_l=$ketiga_range[0];
                $ketiga_range_lbds_r=$ketiga_range[1];
                $ketiga_skor_lbds=$ketiga_range[2];
              }

              //volume_v
              $ketiga_range_volume_l=0;
              $ketiga_range_volume_r=0;
              if($p_volume!=""){
                $ketiga_range = $this->rangeSkorIndikator($ketiga_volume_r,$id_klaster2);
                $ketiga_range_volume_l=$ketiga_range[0];
                $ketiga_range_volume_r=$ketiga_range[1];
                $ketiga_skor_volume=$ketiga_range[2];
              }

              // range nilai skor kerusakan
              $ketiga_range_tli_l=0;
              $ketiga_range_tli_r=0;
              if($p_kerusakan!=""){
                $ketiga_range = $this->rangeSkorIndikatorKerusakan($ketiga_tli_r,$id_klaster2);
                $ketiga_range_tli_l=$ketiga_range[0];
                $ketiga_range_tli_r=$ketiga_range[1];
                $ketiga_skor_tli=$ketiga_range[2];
              }

              // range nilai skor tajuk
              $ketiga_range_vcr_l=0;
              $ketiga_range_vcr_r=0;
              if($p_ktjk!=""){
                $ketiga_range = $this->rangeSkorIndikator($ketiga_vcr_r,$id_klaster2);
                $ketiga_range_vcr_l=$ketiga_range[0];
                $ketiga_range_vcr_r=$ketiga_range[1];
                $ketiga_skor_vcr=$ketiga_range[2];
              }

              // range nilai skor h_aksen
              $ketiga_range_h_aksen_l=0;
              $ketiga_range_h_aksen_r=0;
              if($haksenp!=""){
                $ketiga_range = $this->rangeSkorIndikator($ketiga_h_aksen_klaster,$id_klaster2);
                $ketiga_range_h_aksen_l=$ketiga_range[0];
                $ketiga_range_h_aksen_r=$ketiga_range[1];
                $ketiga_skor_h_aksen=$ketiga_range[2];
              }

              // range nilai skor j_pliup
              $ketiga_range_j_pliu_l=0;
              $ketiga_range_j_pliu_r=0;
              if($p_jpliu!=""){
                $ketiga_range = $this->rangeSkorIndikator($ketiga_j_pliu_klaster,$id_klaster2);
                $ketiga_range_j_pliu_l=$ketiga_range[0];
                $ketiga_range_j_pliu_r=$ketiga_range[1];
                $ketiga_skor_j_pliu=$ketiga_range[2];
              }

              // range nilai skor d_mg
              $ketiga_range_d_mg_l=0;
              $ketiga_range_d_mg_r=0;
              if($p_dmg!=""){
                $ketiga_range = $this->rangeSkorIndikator($ketiga_d_mg,$id_klaster2);
                $ketiga_range_d_mg_l=$ketiga_range[0];
                $ketiga_range_d_mg_r=$ketiga_range[1];
                $ketiga_skor_d_mg=$ketiga_range[2];
              }

              // range nilai skor h_aksenf
              $ketiga_range_h_aksen_lf=0;
              $ketiga_range_h_aksen_rf=0;
              if($haksenf!=""){
                $ketiga_range = $this->rangeSkorIndikator($ketiga_h_aksenf,$id_klaster2);
                $ketiga_range_h_aksen_lf=$ketiga_range[0];
                $ketiga_range_h_aksen_rf=$ketiga_range[1];
                $ketiga_skor_h_aksenf=$ketiga_range[2];
              }

              // range nilai skor jpliuf
              $ketiga_range_j_pliu_lf=0;
              $ketiga_range_j_pliu_rf=0;
              if($p_jpliuf!=""){
                $ketiga_range = $this->rangeSkorIndikator($ketiga_j_pliuf,$id_klaster2);
                $ketiga_range_j_pliu_lf=$ketiga_range[0];
                $ketiga_range_j_pliu_rf=$ketiga_range[1];
                $ketiga_skor_j_pliuf=$ketiga_range[2];
              }

              // range nilai skor dmgf
              $ketiga_range_d_mg_lf=0;
              $ketiga_range_d_mg_rf=0;
              if($p_dmgf!=""){
                $ketiga_range = $this->rangeSkorIndikator($ketiga_d_mgf,$id_klaster2);
                $ketiga_range_d_mg_lf=$ketiga_range[0];
                $ketiga_range_d_mg_rf=$ketiga_range[1];
                $ketiga_skor_d_mgf=$ketiga_range[2];
              }

              // nilai Tertimbang
              for ($ketiga_i=0; $ketiga_i < count($id_klaster2); $ketiga_i++) {

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

             $ketiga_na_total_cec[0] = 0;
             $ketiga_na_total_lbds[0] = 0;
             $ketiga_na_total_volume[0] = 0;
             $ketiga_na_total_kerusakan[0] = 0;
             $ketiga_na_total_tajuk[0] = 0;
             $ketiga_na_total_biodiv_pohon[0] = 0;
             $ketiga_na_total_biodiv_pohon_jpliu[0] = 0;
             $ketiga_na_total_biodiv_pohon_dmg[0] = 0;
             $ketiga_na_total_biodiv_fauna[0] = 0;
             $ketiga_na_total_biodiv_fauna_jpliuf[0] = 0;
             $ketiga_na_total_biodiv_fauna_dmgf[0] = 0;
             for ($ketiga_i=0; $ketiga_i < count($id_klaster2); $ketiga_i++) {
                 //  nilai akhir ktk kimia
                 $ketiga_na_cec[$ketiga_i]=$ketiga_skor_cec[$ketiga_i]*$ketiga_nt_ktpk[$ketiga_i];
                 $ketiga_na_total_cec[0] += $ketiga_na_cec[$ketiga_i];
                 //  nilai akhir Produktivitas lbds
                 $ketiga_na_lbds[$ketiga_i]=$ketiga_skor_lbds[$ketiga_i]*$ketiga_nt_produktivitas[$ketiga_i];
                 $ketiga_na_total_lbds[0] += $ketiga_na_lbds[$ketiga_i];
                 //  nilai akhir Produktivitas volume
                 $ketiga_na_volume[$ketiga_i]=$ketiga_skor_volume[$ketiga_i]*$ketiga_nt_produktivitas[$ketiga_i];
                 $ketiga_na_total_volume[0] += $ketiga_na_volume[$ketiga_i];
                 //  nilai akhir kerusakan pohon
                 $ketiga_na_kerusakan[$ketiga_i]=$ketiga_skor_tli[$ketiga_i]*$ketiga_nt_kerusakan[$ketiga_i];
                 $ketiga_na_total_kerusakan[0] += $ketiga_na_kerusakan[$ketiga_i];
                 //  nilai akhir kondisi tajuk
                 $ketiga_na_tajuk[$ketiga_i]=$ketiga_skor_vcr[$ketiga_i]*$ketiga_nt_ktjk[$ketiga_i];
                 $ketiga_na_total_tajuk[0] += $ketiga_na_tajuk[$ketiga_i];
                 //  nilai akhir biodiversitas pohon haksen
                 $ketiga_na_biodiv_pohon[$ketiga_i]=$ketiga_skor_h_aksen[$ketiga_i]*$ketiga_nt_biodiv[$ketiga_i];
                 $ketiga_na_total_biodiv_pohon[0] += $ketiga_na_biodiv_pohon[$ketiga_i];
                 //  nilai akhir biodiversitas pohon jpliu
                 $ketiga_na_biodiv_pohon_jpliu[$ketiga_i]=$ketiga_skor_j_pliu[$ketiga_i]*$ketiga_nt_biodiv[$ketiga_i];
                 $ketiga_na_total_biodiv_pohon_jpliu[0] += $ketiga_na_biodiv_pohon_jpliu[$ketiga_i];
                 //  nilai akhir biodiversitas pohon dmg
                 $ketiga_na_biodiv_pohon_dmg[$ketiga_i]=$ketiga_skor_d_mg[$ketiga_i]*$ketiga_nt_biodiv[$ketiga_i];
                 $ketiga_na_total_biodiv_pohon_dmg[0] += $ketiga_na_biodiv_pohon_dmg[$ketiga_i];
                 //  nilai akhir biodiversitas fauna
                 $ketiga_na_biodiv_fauna[$ketiga_i]=$ketiga_skor_h_aksenf[$ketiga_i]*$ketiga_nt_biodivf[$ketiga_i];
                 $ketiga_na_total_biodiv_fauna[0] += $ketiga_na_biodiv_fauna[$ketiga_i];
                 $ketiga_na_biodiv_fauna_jpliuf[$ketiga_i]=$ketiga_skor_j_pliuf[$ketiga_i]*$ketiga_nt_biodivf[$ketiga_i];
                 $ketiga_na_total_biodiv_fauna_jpliuf[0] += $ketiga_na_biodiv_fauna_jpliuf[$ketiga_i];
                 $ketiga_na_biodiv_fauna_dmgf[$ketiga_i]=$ketiga_skor_d_mgf[$ketiga_i]*$ketiga_nt_biodivf[$ketiga_i];
                 $ketiga_na_total_biodiv_fauna_dmgf[0] += $ketiga_na_biodiv_fauna_dmgf[$ketiga_i];
             }
             $ketiga_na_total_cec[0] = $ketiga_na_total_cec[0]/$ketiga_i;
             $ketiga_na_total_lbds[0] = $ketiga_na_total_lbds[0]/$ketiga_i;
             $ketiga_na_total_volume[0] = $ketiga_na_total_volume[0]/$ketiga_i;
             $ketiga_na_total_kerusakan[0] = $ketiga_na_total_kerusakan[0]/$ketiga_i;
             $ketiga_na_total_tajuk[0] = $ketiga_na_total_tajuk[0]/$ketiga_i;
             $ketiga_na_total_biodiv_pohon[0] = $ketiga_na_total_biodiv_pohon[0]/$ketiga_i;
             $ketiga_na_total_biodiv_pohon_jpliu[0] = $ketiga_na_total_biodiv_pohon_jpliu[0]/$ketiga_i;
             $ketiga_na_total_biodiv_pohon_dmg[0] = $ketiga_na_total_biodiv_pohon_dmg[0]/$ketiga_i;
             $ketiga_na_total_biodiv_fauna[0] = $ketiga_na_total_biodiv_fauna[0]/$ketiga_i;
             $ketiga_na_total_biodiv_fauna_jpliuf[0] = $ketiga_na_total_biodiv_fauna_jpliuf[0]/$ketiga_i;
             $ketiga_na_total_biodiv_fauna_dmgf[0] = $ketiga_na_total_biodiv_fauna_dmgf[0]/$ketiga_i;

             // nilai total indikator
             $ketiga_na_seluruh[0] = 0;
             for ($ketiga_i=0; $ketiga_i < count($id_klaster2); $ketiga_i++) {
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

         }
         // jika bukan pengukuran pertama
         else{
           $id_klaster = $this->PengukuranKe2($id_data_klaster,$pengukuran_ke);

           $id_data_klaster2 = DB::table('kategori_klaster')->where('id_data_klaster2','=',$id_data_klaster)
           ->where('pengukuran_ke','=',$pengukuran_ke)->first();
         }

         // menghitung jumlah klaster
         $jumlah_penilaian = count($id_klaster);

         // jika jumlah klaster lebih dari atau sama dengan 1
         if ($jumlah_penilaian>=1){
           // memberikan array data tanaman per klaster
           for($i=0;$i<count($id_klaster);$i++){
             $data_tanaman[$i]=DB::table('data_tanaman_plot')
             ->join('tbl_plot','tbl_plot.id_plot','=','data_tanaman_plot.id_plot')
             ->join('table_master_jenis_tanaman','table_master_jenis_tanaman.id_jenis_tanaman','=','data_tanaman_plot.id_master_jenis_tanaman')
             ->where('data_tanaman_plot.id_klaster_plot',$id_klaster[$i]->id_klaster_plot)
             ->where('data_tanaman_plot.pengukuran_ke','=',$pengukuran_ke)
             ->get();
           }

           // inisialisasi nilai awal
           $m=0;
           $tli_r=[];
           $vcr_r=[];
           $lbds_r=[];
           $volume_r=[];
           $cec_r=[];

           // looping sampai id klaster habis
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
                    $data_pengukuran_ktk_kimia = $this->DataPengukuranKimia($id_cl,$pengukuran_ke,$sifat_kimia);

                    // jika data sifat ada
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
                  // mendapatkan nilai tli klaster
                  $tli_f[$k] = $this->DataPengukuran("kerusakan",$id_pengukuran1[$k]);
                }
                else{
                  $tli_f[$k]=0;
                }

                // untuk data pengukuran tajuk
                if($p_ktjk!=""){
                  $vcr_f[$k] = $this->DataPengukuran("tajuk",$id_pengukuran1[$k]);
                }
                else{
                  $vcr_f[$k]=0;
                }

                // untuk data pengukuran lbds
                if($p_lbds!=""){
                  $lbds_f[$k] = $this->DataPengukuran("lbds",$id_pengukuran1[$k]);
                }
                else{
                  $lbds_f[$k]=0;
                }

                // untuk data pengukuran volume
                if($p_volume!=""){
                  $volume_f[$k] = $this->DataPengukuran("volume",$id_pengukuran1[$k]);
                }
                else{
                  $volume_f[$k]=0;
                }

                // nilai total parameter klaster
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

              // untuk dibagi 4 plot ?
              $cec_r[$m]=$cec_r[$m]/count($id_pengukuran1);
              $tli_r[$m]=$tli_r[$m]/count($id_pengukuran1);
              $vcr_r[$m]=$vcr_r[$m]/count($id_pengukuran1);
              $lbds_r[$m]=$lbds_r[$m]/count($id_pengukuran1);
              $volume_r[$m]=$volume_r[$m]/count($id_pengukuran1);
              //

            }
            else{
              // jika id klaster tidak ada
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
            $rata_h_aksen[$i]=0;
            $j_pliu_klaster[$i] = 0;
            $d_mg[$i]=0;
            for($q=0;$q<count($plot);$q++){
              $h_aksen[$q]=0;
              // jika haksen pohon yg dipilih
              if($haksenp!=""){
                $h_aksen[$q] = $this->BiodiversitasPohon($plot[$q]->id_plot,$pengukuran_ke);
                // jika param jpliu tidak ada maka h aksen diitung di haksen
                if($p_jpliu==""){
                  $rata_h_aksen[$i]+=$h_aksen[$q];
                }
              }

              // jika jpliu pohon dipilih
              if($p_jpliu!=""){
                $h_aksen[$q] = $this->BiodiversitasPohon($plot[$q]->id_plot,$pengukuran_ke);

                $rata_h_aksen[$i]+=$h_aksen[$q];

                  $jenis_pohon_klaster[$q]=DB::table('data_tanaman_plot')
                    ->select(DB::raw("data_tanaman_plot.id_master_jenis_tanaman, COUNT(*) as jumlah"))
                    ->where('data_tanaman_plot.id_plot','=',$plot[$q]->id_plot)
                    ->where('status','=','1')
                    ->where('pengukuran_ke','=',$pengukuran_ke)
                    ->groupBy(DB::raw('data_tanaman_plot.id_master_jenis_tanaman'))
                    ->get();
                  $jml_jenis_klaster[$q] = count($jenis_pohon_klaster[$q]);

                  if($jml_jenis_klaster[$q]>1){
                  $j_pliu_klaster[$i]+=$h_aksen[$q]/log($jml_jenis_klaster[$q]);
                }
              }
            }
            // APAKAH DIBAGI DENGAN 4?
            // nilai haksen pohon
            $h_aksen_klaster[$i] = $rata_h_aksen[$i]/4;
            // nilai jpliu pohon
            $j_pliu_klaster[$i] = $j_pliu_klaster[$i]/4;

            // dmg biodiversitas pohon
            if($p_dmg!=""){
              $d_mg[$i] = $this->BiodivDmgPohon($pengukuran_ke,$id_klaster[$i]->id_klaster_plot);
            }
              // END

            // jika haksen fauna yang dipilih
            $h_aksenf[$i]=0;
            if($haksenf!=""){
              if($p_jpliuf==""){
                $h_aksenf[$i]= $this->BiodivFauna($id_cl,$pengukuran_ke);
              }

            }

            // data jpliu fauna
            $j_pliuf[$i] = 0;
            if($p_jpliuf!=""){
              $h_aksenf[$i]= $this->BiodivFauna($id_cl,$pengukuran_ke);

              $data_biodiv_fauna[$i] = DB::table('data_fauna')
              ->where('id_klaster_plot_fauna','=',$id_cl)
              ->where('pengukuran_ke','=',$pengukuran_ke)
              ->get();
              $tot_data_fauna[$i]=count($data_biodiv_fauna[$i]);

              if($tot_data_fauna[$i]>1){
                $j_pliuf[$i] = $h_aksenf[$i]/log($tot_data_fauna[$i]);
              }
            }

            // data dmg fauna
            $d_mgf[$i]=0;
            if($p_dmgf!=""){
              $d_mgf[$i] = $this->BiodivDmgFauna($pengukuran_ke,$id_cl);
            }
           }

           // hanya pembulatan
           for ($a=0;$a<count($tli_r);$a++){
             $cec_r[$a]=round(($cec_r[$a]),3);
             $lbds_r[$a]=round(($lbds_r[$a]),3);
             $volume_r[$a]=round(($volume_r[$a]),3);
             $tli_r[$a]=round(($tli_r[$a]),3);
             $vcr_r[$a]=round(($vcr_r[$a]),3);
             $d_mg[$a]=round($d_mg[$a],3);
             $h_aksenf[$a]=round($h_aksenf[$a],3);
             $j_pliuf[$a]=round($j_pliuf[$a],3);
             $d_mgf[$a]=round($d_mgf[$a],3);
             $j_pliu_klaster[$a]=round($j_pliu_klaster[$a],3);
             $h_aksen_klaster[$a]=round($h_aksen_klaster[$a],3);
           }

           // UNTUK PERHITUNGAN NILAI SKOR INDIKATOR
           $range_cec_l=0;
           $range_cec_r=0;
           for ($i=0;$i<count($id_klaster);$i++){
               $skor_cec[$i]=0;
               $skor_lbds[$i]=0;
               $skor_volume[$i]=0;
               $skor_tli[$i]=0;
               $skor_vcr[$i]=0;
               $skor_h_aksen[$i]=0;
               $skor_j_pliu[$i]=0;
               $skor_d_mg[$i]=0;
               $skor_h_aksenf[$i]=0;
               $skor_j_pliuf[$i]=0;
               $skor_d_mgf[$i]=0;
           }

           // range nilai skor Ktk kimia
           if($p_kimia!=""){
             $range = $this->rangeSkorIndikator($cec_r,$id_klaster);
             $range_cec_l=$range[0];
             $range_cec_r=$range[1];
             $skor_cec=$range[2];
           }

           // range nilai skor Produktivitas
           //lbds
           $range_lbds_l=0;
           $range_lbds_r=0;
           if($p_lbds!=""){
             $range = $this->rangeSkorIndikator($lbds_r,$id_klaster);
             $range_lbds_l=$range[0];
             $range_lbds_r=$range[1];
             $skor_lbds=$range[2];
           }

           //volume_v
           $range_volume_l=0;
           $range_volume_r=0;
           if($p_volume!=""){
             $range = $this->rangeSkorIndikator($volume_r,$id_klaster);
             $range_volume_l=$range[0];
             $range_volume_r=$range[1];
             $skor_volume=$range[2];
           }

           // range nilai skor kerusakan
           $range_tli_l=0;
           $range_tli_r=0;
           if($p_kerusakan!=""){
             $range = $this->rangeSkorIndikatorKerusakan($tli_r,$id_klaster);
             $range_tli_l=$range[0];
             $range_tli_r=$range[1];
             $skor_tli=$range[2];
           }

           // range nilai skor tajuk
           $range_vcr_l=0;
           $range_vcr_r=0;
           if($p_ktjk!=""){
             $range = $this->rangeSkorIndikator($vcr_r,$id_klaster);
             $range_vcr_l=$range[0];
             $range_vcr_r=$range[1];
             $skor_vcr=$range[2];
           }

           // range nilai skor h_aksen
           $range_h_aksen_l=0;
           $range_h_aksen_r=0;
           if($haksenp!=""){
             $range = $this->rangeSkorIndikator($h_aksen_klaster,$id_klaster);
             $range_h_aksen_l=$range[0];
             $range_h_aksen_r=$range[1];
             $skor_h_aksen=$range[2];
           }

           // range nilai skor j_pliup
           $range_j_pliu_l=0;
           $range_j_pliu_r=0;
           if($p_jpliu!=""){
             $range = $this->rangeSkorIndikator($j_pliu_klaster,$id_klaster);
             $range_j_pliu_l=$range[0];
             $range_j_pliu_r=$range[1];
             $skor_j_pliu=$range[2];
           }

           // range nilai skor d_mg
           $range_d_mg_l=0;
           $range_d_mg_r=0;
           if($p_dmg!=""){
             $range = $this->rangeSkorIndikator($d_mg,$id_klaster);
             $range_d_mg_l=$range[0];
             $range_d_mg_r=$range[1];
             $skor_d_mg=$range[2];
           }

           // range nilai skor h_aksenf
           $range_h_aksen_lf=0;
           $range_h_aksen_rf=0;
           if($haksenf!=""){
             $range = $this->rangeSkorIndikator($h_aksenf,$id_klaster);
             $range_h_aksen_lf=$range[0];
             $range_h_aksen_rf=$range[1];
             $skor_h_aksenf=$range[2];
           }

           // range nilai skor jpliuf
           $range_j_pliu_lf=0;
           $range_j_pliu_rf=0;
           if($p_jpliuf!=""){
             $range = $this->rangeSkorIndikator($j_pliuf,$id_klaster);
             $range_j_pliu_lf=$range[0];
             $range_j_pliu_rf=$range[1];
             $skor_j_pliuf=$range[2];
           }

           // range nilai skor dmgf
           $range_d_mg_lf=0;
           $range_d_mg_rf=0;
           if($p_dmgf!=""){
             $range = $this->rangeSkorIndikator($d_mgf,$id_klaster);
             $range_d_mg_lf=$range[0];
             $range_d_mg_rf=$range[1];
             $skor_d_mgf=$range[2];
           }

           // nilai Tertimbang
           for ($i=0; $i < count($id_klaster); $i++) {
             // jika pengukuran pertama
             if($pengukuran_ke==1){
               $nt_kr=DB::table('nilai_tertimbang_copy')
               ->where('id_data_klaster','=',$id_data_klaster)->get();

               if(count($nt_kr)==0){
                 $nt_ktpk[$i]=0;
                 $nt_kerusakan[$i]=0;
                 $nt_produktivitas[$i]=0;
                 $nt_ktjk[$i]=0;
                 $nt_biodiv[$i]=0;
                 $nt_biodivf[$i]=0;
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
                 $nt_ktpk[$i]=0;
                 $nt_kerusakan[$i]=0;
                 $nt_produktivitas[$i]=0;
                 $nt_ktjk[$i]=0;
                 $nt_biodiv[$i]=0;
                 $nt_biodivf[$i]=0;
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


          for ($i=0; $i < count($id_klaster); $i++) {
              //  nilai akhir ktk kimia
              $na_cec[$i]=$skor_cec[$i]*$nt_ktpk[$i];
              //  nilai akhir Produktivitas lbds
              $na_lbds[$i]=$skor_lbds[$i]*$nt_produktivitas[$i];
              //  nilai akhir Produktivitas volume
              $na_volume[$i]=$skor_volume[$i]*$nt_produktivitas[$i];
              //  nilai akhir kerusakan pohon
              $na_kerusakan[$i]=$skor_tli[$i]*$nt_kerusakan[$i];
              //  nilai akhir kondisi tajuk
              $na_tajuk[$i]=$skor_vcr[$i]*$nt_ktjk[$i];
              //  nilai akhir biodiversitas pohon haksen
              $na_biodiv_pohon[$i]=$skor_h_aksen[$i]*$nt_biodiv[$i];
              //  nilai akhir biodiversitas pohon jpliu
              $na_biodiv_pohon_jpliu[$i]=$skor_j_pliu[$i]*$nt_biodiv[$i];
              //  nilai akhir biodiversitas pohon dmg
              $na_biodiv_pohon_dmg[$i]=$skor_d_mg[$i]*$nt_biodiv[$i];
              //  nilai akhir biodiversitas fauna
              $na_biodiv_fauna[$i]=$skor_h_aksenf[$i]*$nt_biodivf[$i];
              $na_biodiv_fauna_jpliuf[$i]=$skor_j_pliuf[$i]*$nt_biodivf[$i];
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

            'nilai_lbds' => $lbds_r,
            'range_lbds_l' => $range_lbds_l,
            'range_lbds_r' => $range_lbds_r,
            'skor_lbds' => $skor_lbds,
            'na_lbds' => $na_lbds,

            'nilai_volume' => $volume_r,
            'range_volume_l' => $range_volume_l,
            'range_volume_r' => $range_volume_r,
            'skor_volume' => $skor_volume,
            'na_volume' => $na_volume,

            'nilai_tli' => $tli_r,
            'range_tli_l' => $range_tli_l,
            'range_tli_r' => $range_tli_r,
            'skor_tli' => $skor_tli,
            'na_kerusakan' => $na_kerusakan,

            'nilai_vcr' => $vcr_r,
            'range_vcr_l' => $range_vcr_l,
            'range_vcr_r' => $range_vcr_r,
            'skor_vcr' => $skor_vcr,
            'na_tajuk' => $na_tajuk,

            'h_aksen' => $h_aksen,
            'h_aksen_klaster' => $h_aksen_klaster,
            'range_h_aksen_l' => $range_h_aksen_l,
            'range_h_aksen_r' => $range_h_aksen_r,
            'skor_h_aksen' => $skor_h_aksen,
            'na_biodiv_pohon' => $na_biodiv_pohon,

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
            'parameter_sifat_kimia' => $sifat_kimia_text,
          ]);

          }
         // jika jumlah klaster kurang dari 1
         else {
           return view('auditor.penilaian_kurang',[
             'pesan' => "Pengukuran tidak lengkap",
           ]);
         }
       }
     }

   // untuk mengembalikan nilai id klaster
   public function PengukuranKe($id_data_klaster,$ke){
     $id_klaster = DB::table('kategori_klaster')
     ->leftjoin('tbl_klaster_plot','tbl_klaster_plot.id_data_klaster','=','kategori_klaster.id_data_klaster')
     ->leftjoin('lokasi','lokasi.id_klaster_plot','=','tbl_klaster_plot.id_klaster_plot')
     ->leftjoin('desa','desa.id','=','lokasi.id_desa')
     ->leftjoin('kecamatan','kecamatan.id','=','lokasi.id_kecamatan')
     ->leftjoin('kabupaten','kabupaten.id','=','lokasi.id_kabupaten')
     ->leftjoin('provinsi','provinsi.id_provinsi','=','lokasi.id_provinsi')
     ->where([['kategori_klaster.id_data_klaster','like',$id_data_klaster]])
     ->where('kategori_klaster.pengukuran_ke','=',$ke)
     ->orderBy('tbl_klaster_plot.nama_klaster','asc')
     ->get();

     return $id_klaster;
   }

   // untuk mengembalikan nilai id klaster
   public function PengukuranKe2($id_data_klaster,$ke){
     $id_klaster = DB::table('kategori_klaster')
     ->leftjoin('tbl_klaster_plot','tbl_klaster_plot.id_data_klaster','=','kategori_klaster.id_data_klaster2')
     ->leftjoin('lokasi','lokasi.id_klaster_plot','=','tbl_klaster_plot.id_klaster_plot')
     ->leftjoin('desa','desa.id','=','lokasi.id_desa')
     ->leftjoin('kecamatan','kecamatan.id','=','lokasi.id_kecamatan')
     ->leftjoin('kabupaten','kabupaten.id','=','lokasi.id_kabupaten')
     ->leftjoin('provinsi','provinsi.id_provinsi','=','lokasi.id_provinsi')
     ->where([['kategori_klaster.id_data_klaster2','like',$id_data_klaster]])
     ->where('kategori_klaster.pengukuran_ke','=',$ke)
     ->orderBy('tbl_klaster_plot.nama_klaster','asc')
     ->get();

     return $id_klaster;
   }

   // untuk mengembalikan nilai cec
   public function DataPengukuranKimia($id_cl,$pengukuran_ke,$sifat_kimia){
     $data_pengukuran_ktk_kimia= DB::table('ktk_kimia')
     ->where('kode_klaster','=',$id_cl)
     ->where('pengukuran_ke','=',$pengukuran_ke)
     ->where('id_sifat','=',$sifat_kimia)
     ->get();

     return $data_pengukuran_ktk_kimia;
   }

   // untuk mengembalikan nilai tli klaster
   public function DataPengukuran($parameter, $id_pengukuran){
     // jika parameter kerusakan
     if($parameter=="kerusakan"){
       $data_pengukuran=DB::table('pengukuran_master')
         ->join('kerusakan_pohon','kerusakan_pohon.id_pengukuran','=','pengukuran_master.id_pengukuran')
         ->select('tli')
         ->where('pengukuran_master.id_pengukuran',$id_pengukuran)->get();

         if(count($data_pengukuran)!=0){
           $tli=0;
           for ($l=0; $l < count ($data_pengukuran); $l++) {
             // nilai total tli plot
             $tli+=$data_pengukuran[$l]->tli;
           }
           // nilai pli plot
           $nilai_klaster=($tli/count($data_pengukuran));
         }
         else{
           $nilai_klaster=0;
         }
     }
     // jika parameter kondisi tajuk
     else if($parameter=="tajuk"){
       $data_pengukuran=DB::table('pengukuran_master')
          ->join('kondisi_tajuk','kondisi_tajuk.id_pengukuran','=','pengukuran_master.id_pengukuran')
          ->select('vcri')
          ->where('pengukuran_master.id_pengukuran',$id_pengukuran)->get();

          if(count($data_pengukuran)!=0){
            $vcr =0;
            for ($l=0; $l < count ($data_pengukuran); $l++) {
              // nilai total vcr plot
              $vcr+=$data_pengukuran[$l]->vcri;
            }
            // nilai vcr plot
            $nilai_klaster=($vcr/count($data_pengukuran));
          }
          else{
            $nilai_klaster=0;
          }
     }
     // jika parameter lbds
     else if($parameter=="lbds"){
       $data_pengukuran=DB::table('pengukuran_master')
       ->join('lbds','lbds.id_pengukuran','=','pengukuran_master.id_pengukuran')
       ->select('Hasil_LBDS','v')
       ->where('pengukuran_master.id_pengukuran',$id_pengukuran)->get();

          if(count($data_pengukuran)!=0){
            $lbds =0;
            for ($l=0; $l < count ($data_pengukuran); $l++) {
              // nilai total lbds plot
              $lbds+=$data_pengukuran[$l]->Hasil_LBDS;
            }
            // nilai lbds plot
            $nilai_klaster=$lbds;
          }
          else{
            $nilai_klaster=0;
          }
     }
     // jika parameter volume
     else if($parameter=="volume"){
       $data_pengukuran=DB::table('pengukuran_master')
       ->join('lbds','lbds.id_pengukuran','=','pengukuran_master.id_pengukuran')
       ->select('Hasil_LBDS','v')
       ->where('pengukuran_master.id_pengukuran',$id_pengukuran)->get();

          if(count($data_pengukuran)!=0){
            $volume =0;
            for ($l=0; $l < count ($data_pengukuran); $l++) {
              // nilai total volume plot
              $volume+=$data_pengukuran[$l]->v;
            }
            // nilai lbds plot
            $nilai_klaster=$volume;
          }
          else{
            $nilai_klaster=0;
          }
     }

    return $nilai_klaster;
   }

   // untuk mengembalikan nilai biodiversitas pohon2
   public function BiodiversitasPohon($plot,$pengukuran_ke){
     $data_biodiv_pohon = DB::table('data_tanaman_plot')
     ->where('id_plot','=',$plot)
     ->where('status','=','1')
     ->where('pengukuran_ke','=',$pengukuran_ke)
     ->get();
     $jumlah_pohon=count($data_biodiv_pohon);
     $jenis_pohon=DB::table('data_tanaman_plot')
     ->select(DB::raw("data_tanaman_plot.id_master_jenis_tanaman, COUNT(*) as jumlah"))
     ->where('data_tanaman_plot.id_plot','=',$plot)
     ->where('status','=','1')
     ->where('pengukuran_ke','=',$pengukuran_ke)
     ->groupBy(DB::raw('data_tanaman_plot.id_master_jenis_tanaman'))
     ->get();

     $h_aksen=0;
     // jika jumlah pohon tidak nol
     if($jumlah_pohon!=0){
       for($o=0;$o<count($jenis_pohon);$o++){
         $n[$o]=$jenis_pohon[$o]->jumlah;
         $ni[$o]=$n[$o]/$jumlah_pohon;
         $ln_ni[$o]=log($ni[$o]);
         $ni_ln_ni[$o]=$ni[$o]*$ln_ni[$o];
         $h_aksen-=$ni_ln_ni[$o];
       }
     }

     return $h_aksen;
   }

   // untuk mengembalikan nilai dmg pohon
   public function BiodivDmgPohon($pengukuran_ke,$id_klaster){
     $data_biodiv_pohon_klaster = DB::table('data_tanaman_plot')
     ->where('id_klaster_plot','=',$id_klaster)
     ->where('status','=','1')
     ->where('pengukuran_ke','=',$pengukuran_ke)
     ->get();
     $jumlah_pohon_klaster=count($data_biodiv_pohon_klaster);

     $jenis_pohon_klaster=DB::table('data_tanaman_plot')
     ->select(DB::raw("data_tanaman_plot.id_master_jenis_tanaman, COUNT(*) as jumlah"))
     ->where('data_tanaman_plot.id_klaster_plot','=',$id_klaster)
     ->where('status','=','1')
     ->where('pengukuran_ke','=',$pengukuran_ke)
     ->groupBy(DB::raw('data_tanaman_plot.id_master_jenis_tanaman'))
     ->get();
     $jml_jenis_klaster = count($jenis_pohon_klaster);

     $d_mg = 0;
     if($jumlah_pohon_klaster>1){
         $d_mg=($jml_jenis_klaster-1)/log($jumlah_pohon_klaster);
     }

     return $d_mg;
   }

   // untuk mengembalikan nilai biodiversitas fauna
   public function BiodivFauna($id_cl,$pengukuran_ke){
     $data_biodiv_fauna = DB::table('data_fauna')
     ->where('id_klaster_plot_fauna','=',$id_cl)
     ->where('pengukuran_ke','=',$pengukuran_ke)
     ->get();
     $h_aksenf=0;
     $total_fauna=0;
     $tot_data_fauna=count($data_biodiv_fauna);
     if($tot_data_fauna!=0){
       for($s=0;$s<$tot_data_fauna;$s++){
         $total_fauna+=$data_biodiv_fauna[$s]->jumlah;
       }

       for($t=0;$t<$tot_data_fauna;$t++){
         $nf[$t]=$data_biodiv_fauna[$t]->jumlah;
         $nif[$t]=$nf[$t]/$total_fauna;
         $ln_nif[$t]=log($nif[$t]);
         $ni_ln_nif[$t]=$nif[$t]*$ln_nif[$t];
         $h_aksenf-=$ni_ln_nif[$t];
       }
     }

     return $h_aksenf;
   }

   // untuk mengembalikan  nilai biodiv dmg fauna
   public function BiodivDmgFauna($pengukuran_ke,$id_cl){
     $data_biodiv_fauna = DB::table('data_fauna')
     ->where('id_klaster_plot_fauna','=',$id_cl)
     ->where('pengukuran_ke','=',$pengukuran_ke)
     ->get();

     $tot_data_fauna=count($data_biodiv_fauna);
     $total_fauna = 0;
     for($s=0;$s<$tot_data_fauna;$s++){
       $total_fauna+=$data_biodiv_fauna[$s]->jumlah;
     }

     $d_mgf = 0;
     if($total_fauna>1){
       $d_mgf=($tot_data_fauna-1)/log($total_fauna);
    }

     return $d_mgf;
   }

   // untuk mengembalikan nilai range skor
   public function rangeSkorIndikator($value,$id_klaster){
     $const=(max($value)-min($value))/10;
     $range_param_l=[];
     $range_param_init=min($value);
     $range_param_l[0]=min($value);
     $range_param_r=[];
     for ($i=1;$i<10;$i++){
       $range_param_init+=$const;
       $range_param_l[$i]=round($range_param_init,3);
       $range_param_r[$i]=round(($range_param_l[$i]-0.001),3);
     }
     $range_param_r[10]=round(max($value),3);

     for ($i=0; $i < count($id_klaster); $i++) {
       $skor_param[$i]=1;
       for ($j=0; $j < count($range_param_l); $j++) {
         if($value[$i]>=$range_param_l[$j] && $value[$i]<=$range_param_r[$j+1]){
           break;
         }
         if($skor_param[$i]<10){
           $skor_param[$i]++;
        }
       }
     }

     return array($range_param_l,$range_param_r,$skor_param);
   }

   // untuk mengembalikan nilai range skor kerusakan
   public function rangeSkorIndikatorKerusakan($value,$id_klaster){
     $const=(max($value)-min($value))/10;
     $range_param_r=[];
     $range_param_init=max($value);
     $range_param_r[0]=max($value);
     $range_param_l=[];
     for ($i=1;$i<10;$i++){
       $range_param_init-=$const;
       $range_param_r[$i]=round($range_param_init,3);
       $range_param_l[$i]=round(($range_param_r[$i]+0.001),3);
     }
     $range_param_l[10]=round(min($value),3);

     for ($i=0; $i < count($id_klaster); $i++) {
       $skor_param[$i]=0;
       for ($j=0; $j < count($range_param_l); $j++) {
         if($skor_param[$i]<10){
           $skor_param[$i]++;
         }
         if($value[$i]>=$range_param_l[$j+1] && $value[$i]<=$range_param_r[$j]){
           break;
         }
       }
     }

     return array($range_param_l,$range_param_r,$skor_param);
   }
}
