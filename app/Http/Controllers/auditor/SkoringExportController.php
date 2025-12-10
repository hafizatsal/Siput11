<?php

namespace App\Http\Controllers\auditor;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class SkoringExportController extends Controller
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
    public function exportNilaiAkhir(Request $req)
    {
      $id_data_klaster = $req->nama_data_klaster1;
      $pengukuran_ke=$req->pengukuran_ke;
      $param_vit=$req->param_vit;
      $param_ktk=$req->param_ktk;
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


      $lbds_v=[];
      $lbds=[];
      $vcrc=[];
      $tli=[];
      $bio_pohon=[];
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
               $h_aksen[$i]=0;
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

                $h_aksen[$i]=0;
                $d_mg[$i]=0;
                if($jumlah_pohon[$i]!=0){
                  $jml_jenis[$i] = count($jenis_pohon[$i]);
                  for($o=0;$o<count($jenis_pohon[$i]);$o++){
                    $n[$o]=$jenis_pohon[$i][$o]->jumlah;
                    $ni[$o]=$n[$o]/$jumlah_pohon[$i];
                    $ln_ni[$o]=log($ni[$o]);
                    $ni_ln_ni[$o]=$ni[$o]*$ln_ni[$o];
                    $h_aksen[$i]-=$ni_ln_ni[$o];
                    $rata_h_aksen[$i]+=$h_aksen[$i];
                  }

                  $d_mg[$i]=($jml_jenis_klaster[$i]-1)/log($jumlah_pohon_klaster[$i]);
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

                 $j_pliu_klaster[$i]=$h_aksen_klaster[$i]/log($jml_jenis_klaster[$i]);
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
               $h_aksenf[$i]=$h_aksenf[$i]/$tot_data_fauna[$i];
               $d_mgf[$i]=($tot_data_fauna[$i]-1)/log($jumlah_fauna[$i]);

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

                  $kategori = $id_klaster[0]->kategori;
                  $data = $nilai_akhir_kesehatan_hutan;
                  $skor_kes = $nilai_skor_akhir;
                  $kondisi = $kondisi_keshut;
                  $lbds = $lbds_r;
                  $volume = $volume_r;
                  $vcr = $vcr_r;
                  $cli = $tli_r;
                  $biodivh_pohon = $h_aksen_klaster;
                  $biodivhf_fauna = $h_aksenf;
                  $kimia_tapak = $cec_r;

                  $max_lbds = $range_lbds_r[10];
                  $min_lbds = $range_lbds_l[0];
                  $intv_lbds = $const_lbds;

                  $max_volume = $range_volume_r[10];
                  $min_volume = $range_volume_l[0];
                  $intv_volume = $const_volume;

                  $max_vcr = $range_vcr_r[10];
                  $min_vcr = $range_vcr_l[0];
                  $intv_vcr = $const_vcr;

                  $max_tli = $range_tli_l[10];
                  $min_tli = $range_tli_r[0];
                  $intv_tli = $const_tli;

                  $max_h_aksen = $range_h_aksen_r[10];
                  $min_h_aksen = $range_h_aksen_l[0];
                  $intv_h_aksen = $const_h_aksen;

                  $max_h_aksenf = $range_h_aksen_rf[10];
                  $min_h_aksenf = $range_h_aksen_lf[0];
                  $intv_h_aksenf = $const_h_aksenf;

                  $max_cec = $range_cec_r[10];
                  $min_cec = $range_cec_l[0];
                  $intv_cec = $const_cec;

                  $range_lbds_max = $range_lbds_r;
                  $range_lbds_min = $range_lbds_l;

                  $range_volume_max = $range_volume_r;
                  $range_volume_min = $range_volume_l;

                  $range_vcr_max = $range_vcr_r;
                  $range_vcr_min = $range_vcr_l;

                  $range_tli_max = $range_tli_l;
                  $range_tli_min = $range_tli_r;

                  $range_h_aksen_max = $range_h_aksen_r;
                  $range_h_aksen_min = $range_h_aksen_l;

                  $range_h_aksenf_max = $range_h_aksen_rf;
                  $range_h_aksenf_min = $range_h_aksen_lf;

                  $range_cec_max = $range_cec_r;
                  $range_cec_min = $range_cec_l;

                  $kesimpulan = $nilai_skor;
                  $nt_prod = $nt_produktivitas[0];
                  $nt_ktjk = $nt_ktjk[0];
                  $nt_kerusakan = $nt_kerusakan[0];
                  $nt_biodiv = $nt_biodiv[0];
                  $nt_biodivf = $nt_biodivf[0];
                  $nt_ktpk = $nt_ktpk[0];
                }

                return Excel::create('Nilai Akhir Kesehatan Hutan '.$kategori, function($excel) use ($data, $skor_kes,$kondisi,$kategori,$lbds,$volume,$vcr,$cli,$biodivh_pohon,$biodivhf_fauna,$kimia_tapak,$max_lbds,$min_lbds,$intv_lbds,
                $range_lbds_max,$range_lbds_min,$skor_lbds,$kesimpulan,$nt_prod,$nt_ktjk,$nt_kerusakan,$nt_biodiv,$nt_biodivf,$nt_ktpk,$max_volume,$min_volume,$intv_volume,$max_vcr,$min_vcr,$intv_vcr,$max_tli,$min_tli,$intv_tli,$max_h_aksen,$min_h_aksen,$intv_h_aksen,
                $max_h_aksenf,$min_h_aksenf,$intv_h_aksenf,$max_cec,$min_cec,$intv_cec,
                $range_volume_max,$range_volume_min,$skor_volume,$range_vcr_max,$range_vcr_min,$skor_vcr,$range_tli_max,$range_tli_min,$skor_tli,$range_h_aksen_max,$range_h_aksen_min,$skor_h_aksen,$range_h_aksenf_max,$range_h_aksenf_min,$skor_h_aksenf,$range_cec_max,$range_cec_min,$skor_cec,$pengukuran_ke) {
                    $excel->sheet('NilaiAkhir', function($sheet) use ($data, $skor_kes,$kondisi,$kategori,$lbds,$volume,$vcr,$cli,$biodivh_pohon,$biodivhf_fauna,$kimia_tapak,$max_lbds,$min_lbds,$intv_lbds,
                    $range_lbds_max,$range_lbds_min,$skor_lbds,$kesimpulan,$nt_prod,$nt_ktjk,$nt_kerusakan,$nt_biodiv,$nt_biodivf,$nt_ktpk,$max_volume,$min_volume,$intv_volume,$max_vcr,$min_vcr,$intv_vcr,$max_tli,$min_tli,$intv_tli,$max_h_aksen,$min_h_aksen,$intv_h_aksen,
                    $max_h_aksenf,$min_h_aksenf,$intv_h_aksenf,$max_cec,$min_cec,$intv_cec,
                    $range_volume_max,$range_volume_min,$skor_volume,$range_vcr_max,$range_vcr_min,$skor_vcr,$range_tli_max,$range_tli_min,$skor_tli,$range_h_aksen_max,$range_h_aksen_min,$skor_h_aksen,$range_h_aksenf_max,$range_h_aksenf_min,$skor_h_aksenf,$range_cec_max,$range_cec_min,$skor_cec,$pengukuran_ke)
                    {
                      $jumlah_baris = 2;
                        $sheet->rows(array(
                          array('','LBDS', 'Volume', 'VCR', 'CLI', 'H\' Pohon', 'H\' Fauna', 'Tapak Kimia')
                        ));

                        for($i=0;$i<count($lbds);$i++){
                        $sheet->rows(array(
                          array($data[$i]->Kode_Klaster,$lbds[$i],$volume[$i],$vcr[$i],$cli[$i],$biodivh_pohon[$i],$biodivhf_fauna[$i],$kimia_tapak[$i])
                        ));
                        $jumlah_baris++;
                          }

                          $sheet->rows(array(
                            array('',''),
                            array('Nilai Maks', $max_lbds,$max_volume,$max_vcr,$max_tli,$max_h_aksen,$max_h_aksenf,$max_cec),
                            array('Nilai Min', $min_lbds,$min_volume,$min_vcr,$min_tli,$min_h_aksen,$min_h_aksenf,$min_cec),
                            array('Interval Skor', $intv_lbds,$intv_volume,$intv_vcr,$intv_tli,$intv_h_aksen,$intv_h_aksenf,$intv_cec),
                            array('',''),
                            array('Skor', 'LBDS', 'Volume', 'VCR', 'CLI', 'H\' Pohon', 'H\' Fauna', 'Tapak Kimia')
                          ));
                          $jumlah_baris+=6;

                          for($i=1;$i<=10;$i++){
                            $sheet->rows(array(
                              array($i, $range_lbds_min[$i-1].' - '. $range_lbds_max[$i], $range_volume_min[$i-1].' - '. $range_volume_max[$i], $range_vcr_min[$i-1].' - '. $range_vcr_max[$i], $range_tli_min[$i-1].' - '. $range_tli_max[$i],
                              $range_h_aksen_min[$i-1].' - '. $range_h_aksen_max[$i], $range_h_aksenf_min[$i-1].' - '. $range_h_aksenf_max[$i], $range_cec_min[$i-1].' - '. $range_cec_max[$i])
                            ));
                            $jumlah_baris++;
                        }

                        $sheet->rows(array(
                          array(''),
                          array('', 'LBDS', 'Volume', 'VCR', 'CLI', 'H\' Pohon', 'H\' Fauna', 'Tapak Kimia', 'NKH')
                        ));

                        $sheet->prependRow(1, array('Nilai Akhir Kesehatan Hutan di '. $kategori));
                        $sheet->prependRow(2, array('Pengukuran ke-'. $pengukuran_ke));

                        $jumlah_baris+=4;

                        for($i=0;$i<count($lbds);$i++){
                          $sheet->rows(array(
                            array($data[$i]->Kode_Klaster, $skor_lbds[$i],$skor_volume[$i],$skor_vcr[$i],$skor_tli[$i],$skor_h_aksen[$i],$skor_h_aksenf[$i],$skor_cec[$i],"=B".$jumlah_baris."*O2+C".$jumlah_baris."*O2+D".$jumlah_baris."*O3+E".$jumlah_baris."*O4+F".$jumlah_baris."*O5+G"
                          .$jumlah_baris."*O6+H".$jumlah_baris."*O7")
                          ));
                          $jumlah_baris++;
                        }



                        $sheet->rows(array(
                          array('',''),
                          array($skor_kes[0]->jenis, $skor_kes[0]->nilai),
                          array($skor_kes[1]->jenis, $skor_kes[1]->nilai),
                          array($skor_kes[2]->jenis, $skor_kes[2]->nilai),
                          array('', ''),
                          array($kondisi[0]->jenis, $kondisi[0]->max, $kondisi[0]->mins),
                          array($kondisi[1]->jenis, $kondisi[1]->max, $kondisi[1]->mins),
                          array($kondisi[2]->jenis, $kondisi[2]->max, $kondisi[2]->mins)
                        ));

                        $sheet->rows(array(
                          array('',''),
                          array('Kesimpulan'),
                          array('','NKH','Status')
                        ));

                        for($i=0;$i<count($lbds);$i++){
                          $sheet->rows(array(
                            array($data[$i]->Kode_Klaster,$data[$i]->Nilai_Akhir,$kesimpulan[$i])
                          ));
                        }

                        $sheet->cell('N1', function($cell) {
                          $cell->setValue('Indikator');
                        });

                        $sheet->cell('N2', function($cell) {
                          $cell->setValue('Pertumbuhan Pohon');
                        });

                        $sheet->cell('N3', function($cell) {
                          $cell->setValue('Kondisi Tajuk');
                        });

                        $sheet->cell('N4', function($cell) {
                          $cell->setValue('Kerusakan Pohon');
                        });

                        $sheet->cell('N5', function($cell) {
                          $cell->setValue('Bidoversitas Pohon');
                        });

                        $sheet->cell('N6', function($cell) {
                          $cell->setValue('Biodiversitas Fauna');
                        });

                        $sheet->cell('N7', function($cell) {
                          $cell->setValue('Kualitas Tapak');
                        });

                        $sheet->cell('N9', function($cell) {
                          $cell->setValue('Nilai Skor =(nilai max-nilai min)/jumlah interval');
                        });

                        $sheet->cell('N10', function($cell) {
                          $cell->setValue('NKH = nilai skor * nilai tertimbang');
                        });

                        $sheet->cell('O1', function($cell) {
                          $cell->setValue('Nilai Tertimbang');
                        });

                        $sheet->cell('O2', function($cell) use($nt_prod) {
                          $cell->setValue($nt_prod);
                        });

                        $sheet->cell('O3', function($cell) use($nt_ktjk) {
                          $cell->setValue($nt_ktjk);
                        });

                        $sheet->cell('O4', function($cell) use($nt_kerusakan) {
                          $cell->setValue($nt_kerusakan);
                        });

                        $sheet->cell('O5', function($cell) use($nt_biodiv) {
                          $cell->setValue($nt_biodiv);
                        });

                        $sheet->cell('O6', function($cell) use($nt_biodivf) {
                          $cell->setValue($nt_biodivf);
                        });

                        $sheet->cell('O7', function($cell) use($nt_ktpk) {
                          $cell->setValue($nt_ktpk);
                        });



                        $sheet->cell('A1:H1', function($cell) {
                          // manipulate the cell
                          $cell->setFontSize(14);
                          $cell->setFontWeight('bold');
                        });
                        //
                        $sheet->mergeCells('A1:H1');
                        $sheet->mergeCells('A2:H2');
                        $sheet->mergeCells('N9:P9');
                        $sheet->mergeCells('N10:P10');
                        //
                        $sheet->cell('A1', function($cell) {
                          // manipulate the cell
                          $cell->setAlignment('center');
                          $cell->setValignment('center');
                        });

                        $sheet->cell('A2', function($cell) {
                          // manipulate the cell
                          $cell->setAlignment('center');
                          $cell->setValignment('center');
                        });

                    });

                    $excel->setTitle('Nilai Kesehatan Hutan (NKH) '.$kategori);
                    $excel->setDescription('Hasil pengolahan nilai akhir kesehatan hutan by SIPUT');
                    $excel->setCreator(Auth::user()->nama);
                    $excel->setCompany('SIPUT');
                    $excel->setManager('Rendy');
                })->download('xlsx');
    }
}
