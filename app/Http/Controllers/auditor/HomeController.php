<?php

namespace App\Http\Controllers\auditor;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Exceptions\CustomException;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
class HomeController extends Controller
{
  public function __construct()
  {
      $this->middleware('auth');
  }

  public function index()
  {
        $pengumuman = DB::table('pengumuman')->get();
      return view('auditor.home',compact('pengumuman'));
  }

  public function titik(Request $request)
    {
        // Ambil id_plot dari request (POST/GET)
        $id_plot = $request->input('id_plot');

        $data_klaster_plot = DB::table('tbl_klaster_plot')
            ->join('kategori_klaster', 'kategori_klaster.id_data_klaster', '=', 'tbl_klaster_plot.id_data_klaster')
            ->leftJoin('tbl_plot', 'tbl_plot.id_klaster_plot', '=', 'tbl_klaster_plot.id_klaster_plot')
            // ->where('kategori_klaster.input_by','=', Auth::user()->id)
            ->where('kategori_klaster.pengukuran_ke', '=', 1)
            ->where('kategori_klaster.verif', '=', 1)
            ->get();

        $tli_f   = [];
        $vcr_f   = [];
        $lbds_f  = [];
        $volume_f= [];
        $cec_f   = [];

        if (count($data_klaster_plot) != 0) {
            for ($r = 0; $r < count($data_klaster_plot); $r++) {

                $id_pengukuran = DB::table('pengukuran_master')
                    ->where('id_plot', $data_klaster_plot[$r]->id_plot)
                    ->where('pengukuran_ke', '=', 1)
                    ->get();

                if (count($id_pengukuran) != 0) {
                    $id_pengukuran1[$r] = $id_pengukuran[0]->id_pengukuran;
                }
    $id_pengukuran_kedua=DB::table('pengukuran_master')->where('id_plot',$data_klaster_plot[$r]->id_plot)
    ->where('pengukuran_ke','=',2)->get();

    if(count($id_pengukuran_kedua)!=0){
      $id_pengukuran2[$r]=$id_pengukuran_kedua[0]->id_pengukuran;
    }
    else{
      $id_pengukuran2[$r]=0;
    }

    $id_pengukuran_ketiga=DB::table('pengukuran_master')->where('id_plot',$data_klaster_plot[$r]->id_plot)
    ->where('pengukuran_ke','=',3)->get();

    if(count($id_pengukuran_ketiga)!=0){
      $id_pengukuran3[$r]=$id_pengukuran_ketiga[0]->id_pengukuran;
    }
    else{
      $id_pengukuran3[$r]=0;
    }

    //biodiv pohon
    $jumlah_pohon=DB::table('data_tanaman_plot')
    ->select(DB::raw("table_master_jenis_tanaman.nama_tanaman,table_master_jenis_tanaman.nama_latin,COUNT(*) as jumlah"))
    ->join(
    'table_master_jenis_tanaman',
    'table_master_jenis_tanaman.id_jenis_tanaman','=','data_tanaman_plot.id_master_jenis_tanaman'
    )
    ->where('data_tanaman_plot.id_plot','=',$data_klaster_plot[$r]->id_plot)
    ->where('data_tanaman_plot.status','=','1')
    ->where('data_tanaman_plot.pengukuran_ke','=',1)
    ->groupBy(DB::raw('table_master_jenis_tanaman.nama_tanaman,table_master_jenis_tanaman.nama_latin'))
    ->orderBy('table_master_jenis_tanaman.nama_tanaman')
    ->get();

    //biodiv pohon
    $jumlah_pohon2=DB::table('data_tanaman_plot')
    ->select(DB::raw("table_master_jenis_tanaman.nama_tanaman,table_master_jenis_tanaman.nama_latin,COUNT(*) as jumlah"))
    ->join(
    'table_master_jenis_tanaman',
    'table_master_jenis_tanaman.id_jenis_tanaman','=','data_tanaman_plot.id_master_jenis_tanaman'
    )
    ->where('data_tanaman_plot.id_plot','=',$data_klaster_plot[$r]->id_plot)
    ->where('data_tanaman_plot.status','=','1')
    ->where('data_tanaman_plot.pengukuran_ke','=',2)
    ->groupBy(DB::raw('table_master_jenis_tanaman.nama_tanaman,table_master_jenis_tanaman.nama_latin'))
    ->orderBy('table_master_jenis_tanaman.nama_tanaman')
    ->get();

    //biodiv pohon
    $jumlah_pohon3=DB::table('data_tanaman_plot')
    ->select(DB::raw("table_master_jenis_tanaman.nama_tanaman,table_master_jenis_tanaman.nama_latin,COUNT(*) as jumlah"))
    ->join(
    'table_master_jenis_tanaman',
    'table_master_jenis_tanaman.id_jenis_tanaman','=','data_tanaman_plot.id_master_jenis_tanaman'
    )
    ->where('data_tanaman_plot.id_plot','=',$data_klaster_plot[$r]->id_plot)
    ->where('data_tanaman_plot.status','=','1')
    ->where('data_tanaman_plot.pengukuran_ke','=',3)
    ->groupBy(DB::raw('table_master_jenis_tanaman.nama_tanaman,table_master_jenis_tanaman.nama_latin'))
    ->orderBy('table_master_jenis_tanaman.nama_tanaman')
    ->get();

    if(count($jumlah_pohon)!=0){
      $data_biodiv_pohon = DB::table('data_tanaman_plot')
      ->where('id_plot','=',$data_klaster_plot[$r]->id_plot)
      ->where('status','=','1')
      ->where('pengukuran_ke','=',1)
      ->get();

      $jmlh_phn = count($data_biodiv_pohon);
      $jenis_pohon=DB::table('data_tanaman_plot')
      ->select(DB::raw("table_master_jenis_tanaman.nama_tanaman,data_tanaman_plot.id_master_jenis_tanaman, COUNT(*) as jumlah"))
      ->join('table_master_jenis_tanaman','table_master_jenis_tanaman.id_jenis_tanaman','=','data_tanaman_plot.id_master_jenis_tanaman')
      ->where('data_tanaman_plot.id_plot','=',$data_klaster_plot[$r]->id_plot)
      ->where('status','=','1')
      ->where('pengukuran_ke','=',1)
      ->groupBy(DB::raw('table_master_jenis_tanaman.nama_tanaman,data_tanaman_plot.id_master_jenis_tanaman'))
      ->orderBy('table_master_jenis_tanaman.nama_tanaman')
      ->get();

      $h_aksen[$r]=0;
      $tot_jpliu[$r]=0;
      if($jmlh_phn!=0){
        for($z=0;$z<count($jenis_pohon);$z++){
          $n[$z]=$jenis_pohon[$z]->jumlah;
          $ni[$z]=$n[$z]/$jmlh_phn;
          $ln_ni[$z]=log($ni[$z]);
          $ni_ln_ni[$z]=-1*$ni[$z]*$ln_ni[$z];
          $h_aksen[$r]+=$ni_ln_ni[$z];
          if(count($jenis_pohon)==1){
            $j_pliu[$z] = 0;
          }
          else{
            $j_pliu[$z] = $ni_ln_ni[$z]/log(count($jenis_pohon));
          }
          $tot_jpliu[$r]+=$j_pliu[$z];
        }

        $h_aksen[$r]=round($h_aksen[$r],3);
        $tot_jpliu[$r]=round($tot_jpliu[$r],3);
      }
      else{
        $h_aksen[$r]=0;
        $tot_jpliu[$r]=0;
      }
    }
    else{
      $h_aksen[$r]=0;
      $tot_jpliu[$r]=0;
    }
    //endbiodiv

    //pengke2
    if(count($jumlah_pohon2)!=0){
      $data_klaster_plot2[$r] = DB::table('kategori_klaster')
      ->where('id_data_klaster2','=',$data_klaster_plot[$r]->id_data_klaster)
      ->where('pengukuran_ke','=',2)
      ->first();

      $data_biodiv_pohon2 = DB::table('data_tanaman_plot')
      ->where('id_plot','=',$data_klaster_plot[$r]->id_plot)
      ->where('status','=','1')
      ->where('pengukuran_ke','=',2)
      ->get();

      $jmlh_phn2 = count($data_biodiv_pohon2);
      $jenis_pohon2=DB::table('data_tanaman_plot')
      ->select(DB::raw("table_master_jenis_tanaman.nama_tanaman,data_tanaman_plot.id_master_jenis_tanaman, COUNT(*) as jumlah"))
      ->join('table_master_jenis_tanaman','table_master_jenis_tanaman.id_jenis_tanaman','=','data_tanaman_plot.id_master_jenis_tanaman')
      ->where('data_tanaman_plot.id_plot','=',$data_klaster_plot[$r]->id_plot)
      ->where('status','=','1')
      ->where('pengukuran_ke','=',2)
      ->groupBy(DB::raw('table_master_jenis_tanaman.nama_tanaman,data_tanaman_plot.id_master_jenis_tanaman'))
      ->orderBy('table_master_jenis_tanaman.nama_tanaman')
      ->get();

      $h_aksen2[$r]=0;
      $tot_jpliu2[$r]=0;
      if($jmlh_phn2!=0){
        for($z2=0;$z2<count($jenis_pohon2);$z2++){
          $n2[$z2]=$jenis_pohon2[$z2]->jumlah;
          $ni2[$z2]=$n2[$z2]/$jmlh_phn2;
          $ln_ni2[$z2]=log($ni2[$z2]);
          $ni_ln_ni2[$z2]=-1*$ni2[$z2]*$ln_ni2[$z2];
          $h_aksen2[$r]+=$ni_ln_ni2[$z2];
          if(count($jenis_pohon2)==1){
            $j_pliu2[$z2] = 0;
          }
          else{
            $j_pliu2[$z2] = $ni_ln_ni2[$z2]/log(count($jenis_pohon2));
          }
          $tot_jpliu2[$r]+=$j_pliu2[$z2];
        }

        $h_aksen2[$r]=round($h_aksen2[$r],3);
        $tot_jpliu2[$r]=round($tot_jpliu2[$r],3);
      }
      else{
        $h_aksen2[$r]=0;
        $tot_jpliu2[$r]=0;
      }
    }
    else{
      $h_aksen2[$r]=0;
      $tot_jpliu2[$r]=0;
      $app2 = app();
      $data_klaster_plot2[$r] = $app2->make('stdClass');
      $data_klaster_plot2[$r]->nama_pengukur = "Belum ada data";
      $data_klaster_plot2[$r]->tahun_pengukuran = "Belum ada data";

    }
    //endbiodiv

    //pengke3
    if(count($jumlah_pohon3)!=0){
      $data_klaster_plot3[$r] = DB::table('kategori_klaster')
      ->where('id_data_klaster2','=',$data_klaster_plot[$r]->id_data_klaster)
      ->where('pengukuran_ke','=',3)
      ->first();

      $data_biodiv_pohon3 = DB::table('data_tanaman_plot')
      ->where('id_plot','=',$data_klaster_plot[$r]->id_plot)
      ->where('status','=','1')
      ->where('pengukuran_ke','=',3)
      ->get();

      $jmlh_phn3 = count($data_biodiv_pohon3);
      $jenis_pohon3=DB::table('data_tanaman_plot')
      ->select(DB::raw("table_master_jenis_tanaman.nama_tanaman,data_tanaman_plot.id_master_jenis_tanaman, COUNT(*) as jumlah"))
      ->join('table_master_jenis_tanaman','table_master_jenis_tanaman.id_jenis_tanaman','=','data_tanaman_plot.id_master_jenis_tanaman')
      ->where('data_tanaman_plot.id_plot','=',$data_klaster_plot[$r]->id_plot)
      ->where('status','=','1')
      ->where('pengukuran_ke','=',3)
      ->groupBy(DB::raw('table_master_jenis_tanaman.nama_tanaman,data_tanaman_plot.id_master_jenis_tanaman'))
      ->orderBy('table_master_jenis_tanaman.nama_tanaman')
      ->get();

      $h_aksen3[$r]=0;
      $tot_jpliu3[$r]=0;
      if($jmlh_phn3!=0){
        for($z3=0;$z3<count($jenis_pohon3);$z3++){
          $n3[$z3]=$jenis_pohon3[$z3]->jumlah;
          $ni3[$z3]=$n3[$z3]/$jmlh_phn3;
          $ln_ni3[$z3]=log($ni3[$z3]);
          $ni_ln_ni3[$z3]=-1*$ni3[$z3]*$ln_ni3[$z3];
          $h_aksen3[$r]+=$ni_ln_ni3[$z3];
          if(count($jenis_pohon3)==1){
            $j_pliu3[$z3] = 0;
          }
          else{
            $j_pliu3[$z3] = $ni_ln_ni3[$z3]/log(count($jenis_pohon3));
          }
          $tot_jpliu3[$r]+=$j_pliu3[$z3];
        }

        $h_aksen3[$r]=round($h_aksen3[$r],3);
        $tot_jpliu3[$r]=round($tot_jpliu3[$r],3);
      }
      else{
        $h_aksen3[$r]=0;
        $tot_jpliu3[$r]=0;
      }
    }
    else{
      $h_aksen3[$r]=0;
      $tot_jpliu3[$r]=0;
      $app3 = app();
      $data_klaster_plot3[$r] = $app3->make('stdClass');
      $data_klaster_plot3[$r]->nama_pengukur = "Belum ada data";
      $data_klaster_plot3[$r]->tahun_pengukuran = "Belum ada data";
    }
    //endbiodiv


    //biodivFauna
    $jumlah_fauna=DB::table('data_fauna')
    ->join(
    'tabel_master_fauna',
    'tabel_master_fauna.id_jenis_fauna','=','data_fauna.id_master_fauna'
    )
    ->where('id_plot_fauna','=',$data_klaster_plot[$r]->id_plot)
    ->where('pengukuran_ke','=',1)
    ->get();

    //biodivFauna
    $jumlah_fauna2=DB::table('data_fauna')
    ->join(
    'tabel_master_fauna',
    'tabel_master_fauna.id_jenis_fauna','=','data_fauna.id_master_fauna'
    )
    ->where('id_plot_fauna','=',$data_klaster_plot[$r]->id_plot)
    ->where('pengukuran_ke','=',2)
    ->get();

    //biodivFauna
    $jumlah_fauna3=DB::table('data_fauna')
    ->join(
    'tabel_master_fauna',
    'tabel_master_fauna.id_jenis_fauna','=','data_fauna.id_master_fauna'
    )
    ->where('id_plot_fauna','=',$data_klaster_plot[$r]->id_plot)
    ->where('pengukuran_ke','=',3)
    ->get();

    $h_aksenf[$r]=0;
    $tot_jpliuf[$r]=0;
    if(count($jumlah_fauna)!=0){
      $total_fauna=0;
      $tot_data_fauna[$r]=count($jumlah_fauna);

      for($s=0;$s<$tot_data_fauna[$r];$s++){
        $total_fauna+=$jumlah_fauna[$s]->jumlah;
      }

      for($t=0;$t<$tot_data_fauna[$r];$t++){
        $nf[$t]=$jumlah_fauna[$t]->jumlah;
        $nif[$t]=$nf[$t]/$total_fauna;
        $ln_nif[$t]=log($nif[$t]);
        $ni_ln_nif[$t]=-1*$nif[$t]*$ln_nif[$t];
        $h_aksenf[$r]+=$ni_ln_nif[$t];
        if($tot_data_fauna[$r]==0 || $tot_data_fauna[$r]==1 ){
           $j_pliuf[$t]=0;
        }
        else{
          $j_pliuf[$t] = $ni_ln_nif[$t]/log($tot_data_fauna[$r]);
        }

        $tot_jpliuf[$r]+=$j_pliuf[$t];
      }


      $h_aksenf[$r]=round($h_aksenf[$r],3);
      $tot_jpliuf[$r]=round($tot_jpliuf[$r],3);
    }
    else{
      $h_aksenf[$r]=0;
      $tot_jpliuf[$r]=0;
    }
    //endbiodiv

    //pengke2
    $h_aksenf2[$r]=0;
    $tot_jpliuf2[$r]=0;
    if(count($jumlah_fauna2)!=0){
      $total_fauna2=0;
      $tot_data_fauna2[$r]=count($jumlah_fauna2);

      for($s2=0;$s2<$tot_data_fauna2[$r];$s2++){
        $total_fauna2+=$jumlah_fauna2[$s2]->jumlah;
      }

      for($t2=0;$t2<$tot_data_fauna2[$r];$t2++){
        $nf2[$t2]=$jumlah_fauna2[$t2]->jumlah;
        $nif2[$t2]=$nf2[$t2]/$total_fauna2;
        $ln_nif2[$t2]=log($nif2[$t2]);
        $ni_ln_nif2[$t2]=-1*$nif2[$t2]*$ln_nif2[$t2];
        $h_aksenf2[$r]+=$ni_ln_nif2[$t2];
        if($tot_data_fauna2[$r]==0 || $tot_data_fauna2[$r]==1 ){
           $j_pliuf2[$t2]=0;
        }
        else{
          $j_pliuf2[$t2] = $ni_ln_nif2[$t2]/log($tot_data_fauna2[$r]);
        }

        $tot_jpliuf2[$r]+=$j_pliuf2[$t2];
      }


      $h_aksenf2[$r]=round($h_aksenf2[$r],3);
      $tot_jpliuf2[$r]=round($tot_jpliuf2[$r],3);
    }
    else{
      $h_aksenf2[$r]=0;
      $tot_jpliuf2[$r]=0;
    }
    //endbiodiv

    //pengke3
    $h_aksenf3[$r]=0;
    $tot_jpliuf3[$r]=0;
    if(count($jumlah_fauna3)!=0){
      $total_fauna3=0;
      $tot_data_fauna3[$r]=count($jumlah_fauna3);

      for($s3=0;$s3<$tot_data_fauna3[$r];$s3++){
        $total_fauna3+=$jumlah_fauna3[$s3]->jumlah;
      }

      for($t3=0;$t3<$tot_data_fauna3[$r];$t3++){
        $nf3[$t3]=$jumlah_fauna3[$t3]->jumlah;
        $nif3[$t3]=$nf3[$t3]/$total_fauna3;
        $ln_nif3[$t3]=log($nif3[$t3]);
        $ni_ln_nif3[$t3]=-1*$nif3[$t3]*$ln_nif3[$t3];
        $h_aksenf3[$r]+=$ni_ln_nif3[$t3];
        if($tot_data_fauna3[$r]==0 || $tot_data_fauna3[$r]==1 ){
           $j_pliuf3[$t3]=0;
        }
        else{
          $j_pliuf3[$t3] = $ni_ln_nif3[$t3]/log($tot_data_fauna3[$r]);
        }

        $tot_jpliuf3[$r]+=$j_pliuf3[$t3];
      }


      $h_aksenf3[$r]=round($h_aksenf3[$r],3);
      $tot_jpliuf3[$r]=round($tot_jpliuf3[$r],3);
    }
    else{
      $h_aksenf3[$r]=0;
      $tot_jpliuf3[$r]=0;
    }
    //endbiodiv



  }

  if(count($id_pengukuran1)!=0){

      for ($k=0; $k < count($id_pengukuran1); $k++) {

        $lbds=0;
        $tli=0;
        $vcr=0;
        $lbds=0;
        $volume=0;

        //lbds
      $data_lbds = DB::table('pengukuran_master')
      ->join('lbds','lbds.id_pengukuran','=','pengukuran_master.id_pengukuran')
      ->select('Hasil_LBDS','v')
      ->where('pengukuran_master.id_pengukuran',$id_pengukuran1[$k])
      ->get();

      // untuk lbds
      if(count($data_lbds)!=0){
        for ($l=0; $l < count ($data_lbds); $l++) {
          // nilai total lbds plot
          $lbds+=$data_lbds[$l]->Hasil_LBDS;
        }
        // nilai lbds plot
        $lbds_f[$k]=($lbds/count($data_lbds));
        $lbds_f[$k]=round($lbds_f[$k],3);
      }
      else{
        $lbds_f[$k]=0;
      }
      // endlbds

      // pli
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
          $tli_f[$k]=round($tli_f[$k],3);
        }
        else{
          $tli_f[$k]=0;
        }
        //endpli


        // tajuk
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
            $vcr_f[$k]=round($vcr_f[$k],3);
          }
          else{
            $vcr_f[$k]=0;
          }
          //endtajuk


          // volume
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
            $volume_f[$k]=($volume/count($data_pengukuran_volume));
            $volume_f[$k]=round($volume_f[$k],3);
          }
          else{
            $volume_f[$k]=0;
          }
            //endvolume

    }

    for ($k_2=0; $k_2 < count($id_pengukuran2); $k_2++) {
      $lbds2=0;
      $tli2=0;
      $vcr2=0;
      $lbds2=0;
      $volume2=0;
      //lbds
    $data_lbds2 = DB::table('pengukuran_master')
    ->join('lbds','lbds.id_pengukuran','=','pengukuran_master.id_pengukuran')
    ->select('Hasil_LBDS','v')
    ->where('pengukuran_master.id_pengukuran',$id_pengukuran2[$k_2])
    ->get();

    // untuk lbds
    if(count($data_lbds2)!=0){
      for ($l=0; $l < count ($data_lbds2); $l++) {
        // nilai total lbds plot
        $lbds2+=$data_lbds2[$l]->Hasil_LBDS;
      }
      // nilai lbds plot
      $lbds_f2[$k_2]=($lbds2/count($data_lbds2));
      $lbds_f2[$k_2]=round($lbds_f2[$k_2],3);
    }
    else{
      $lbds_f2[$k_2]=0;
    }
    // endlbds

    // pli
    $data_pengukuran2=DB::table('pengukuran_master')
      ->join('kerusakan_pohon','kerusakan_pohon.id_pengukuran','=','pengukuran_master.id_pengukuran')
      ->select('tli')
      ->where('pengukuran_master.id_pengukuran',$id_pengukuran2[$k_2])->get();

      // untuk kerusakan
      if(count($data_pengukuran2)!=0){
        for ($l=0; $l < count ($data_pengukuran2); $l++) {
          // nilai total tli plot
          $tli2+=$data_pengukuran2[$l]->tli;
        }
        // nilai pli plot
        $tli_f2[$k_2]=($tli2/count($data_pengukuran2));
        $tli_f2[$k_2]=round($tli_f2[$k_2],3);
      }
      else{
        $tli_f2[$k_2]=0;
      }
      //endpli


      // tajuk
      $data_pengukuran_tajuk2=DB::table('pengukuran_master')
        ->join('kondisi_tajuk','kondisi_tajuk.id_pengukuran','=','pengukuran_master.id_pengukuran')
        ->select('vcri')
        ->where('pengukuran_master.id_pengukuran',$id_pengukuran2[$k_2])->get();
        // untuk tajuk
        if(count($data_pengukuran_tajuk2)!=0){
          for ($l=0; $l < count ($data_pengukuran_tajuk2); $l++) {
            // nilai total vcr plot
            $vcr2+=$data_pengukuran_tajuk2[$l]->vcri;
          }
          // nilai vcr plot
          $vcr_f2[$k_2]=($vcr2/count($data_pengukuran_tajuk2));
          $vcr_f2[$k_2]=round($vcr_f2[$k_2],3);
        }
        else{
          $vcr_f2[$k_2]=0;
        }
        //endtajuk


        // volume
        $data_pengukuran_volume2=DB::table('pengukuran_master')
          ->join('lbds','lbds.id_pengukuran','=','pengukuran_master.id_pengukuran')
          ->select('Hasil_LBDS','v')
          ->where('pengukuran_master.id_pengukuran',$id_pengukuran2[$k_2])->get();

          // untuk volume
          if(count($data_pengukuran_volume2)!=0){
          for ($l=0; $l < count ($data_pengukuran_volume2); $l++) {
            // nilai total lbds plot
            $volume2+=$data_pengukuran_volume2[$l]->v;
          }
          // nilai volume plot
          $volume_f2[$k_2]=($volume2/count($data_pengukuran_volume2));
          $volume_f2[$k_2]=round($volume_f2[$k_2],3);
        }
        else{
          $volume_f2[$k_2]=0;
        }
          //endvolume

    }

    for ($k_3=0; $k_3 < count($id_pengukuran3); $k_3++) {
      $lbds3=0;
      $tli3=0;
      $vcr3=0;
      $lbds3=0;
      $volume3=0;
      //lbds
    $data_lbds3 = DB::table('pengukuran_master')
    ->join('lbds','lbds.id_pengukuran','=','pengukuran_master.id_pengukuran')
    ->select('Hasil_LBDS','v')
    ->where('pengukuran_master.id_pengukuran',$id_pengukuran3[$k_3])
    ->get();

    // untuk lbds
    if(count($data_lbds3)!=0){
      for ($l=0; $l < count ($data_lbds3); $l++) {
        // nilai total lbds plot
        $lbds3+=$data_lbds3[$l]->Hasil_LBDS;
      }
      // nilai lbds plot
      $lbds_f3[$k_3]=($lbds3/count($data_lbds3));
      $lbds_f3[$k_3]=round($lbds_f3[$k_3],3);
    }
    else{
      $lbds_f3[$k_3]=0;
    }
    // endlbds

    // pli
    $data_pengukuran3=DB::table('pengukuran_master')
      ->join('kerusakan_pohon','kerusakan_pohon.id_pengukuran','=','pengukuran_master.id_pengukuran')
      ->select('tli')
      ->where('pengukuran_master.id_pengukuran',$id_pengukuran3[$k_3])->get();

      // untuk kerusakan
      if(count($data_pengukuran3)!=0){
        for ($l=0; $l < count ($data_pengukuran3); $l++) {
          // nilai total tli plot
          $tli3+=$data_pengukuran3[$l]->tli;
        }
        // nilai pli plot
        $tli_f3[$k_3]=($tli3/count($data_pengukuran3));
        $tli_f3[$k_3]=round($tli_f3[$k_3],3);
      }
      else{
        $tli_f3[$k_3]=0;
      }
      //endpli


      // tajuk
      $data_pengukuran_tajuk3=DB::table('pengukuran_master')
        ->join('kondisi_tajuk','kondisi_tajuk.id_pengukuran','=','pengukuran_master.id_pengukuran')
        ->select('vcri')
        ->where('pengukuran_master.id_pengukuran',$id_pengukuran3[$k_3])->get();
        // untuk tajuk
        if(count($data_pengukuran_tajuk3)!=0){
          for ($l=0; $l < count ($data_pengukuran_tajuk3); $l++) {
            // nilai total vcr plot
            $vcr3+=$data_pengukuran_tajuk3[$l]->vcri;
          }
          // nilai vcr plot
          $vcr_f3[$k_3]=($vcr3/count($data_pengukuran_tajuk3));
          $vcr_f3[$k_3]=round($vcr_f3[$k_3],3);
        }
        else{
          $vcr_f3[$k_3]=0;
        }
        //endtajuk


        // volume
        $data_pengukuran_volume3=DB::table('pengukuran_master')
          ->join('lbds','lbds.id_pengukuran','=','pengukuran_master.id_pengukuran')
          ->select('Hasil_LBDS','v')
          ->where('pengukuran_master.id_pengukuran',$id_pengukuran3[$k_3])->get();

          // untuk volume
          if(count($data_pengukuran_volume3)!=0){
          for ($l=0; $l < count ($data_pengukuran_volume3); $l++) {
            // nilai total lbds plot
            $volume3+=$data_pengukuran_volume3[$l]->v;
          }
          // nilai volume plot
          $volume_f3[$k_3]=($volume3/count($data_pengukuran_volume3));
          $volume_f3[$k_3]=round($volume_f3[$k_3],3);
        }
        else{
          $volume_f3[$k_3]=0;
        }
          //endvolume

    }



  }


    $jumlah_data = count($data_klaster_plot);
    if($jumlah_data!=0){
      for($i=0;$i<$jumlah_data;$i++){
          $koordinatBujur[$i] = $data_klaster_plot[$i]->koordinat_BT;
          $splitName_p[$i] = explode(' ', $koordinatBujur[$i], 2);
          $splitName2_p[$i]= explode(' ', $splitName_p[$i][1], 2);
          $splitName3_p[$i]= explode(' ', $splitName2_p[$i][1], 2);
          if($splitName_p[$i][0]>=0){
            $long_derajat=$splitName_p[$i][0];
            $ket_bujur_p[$i]='BT';

            $menit_b = $splitName2_p[$i][0]/60;
            $detik_b = $splitName3_p[$i][0]/3600;

            $koordinat_bujur_angka_klaster[$i] = $long_derajat + $menit_b + $detik_b;
          }
          else{
            $ket_bujur_p[$i]='BB';
            $splitName_p[$i][0]=$splitName_p[$i][0]*-1;
            $long_derajat=$splitName_p[$i][0]*-1;

            $menit_b = $splitName2_p[$i][0]/60;
            $detik_b = $splitName3_p[$i][0]/3600;

            $koordinat_bujur_angka_klaster[$i] = $long_derajat - $menit_b - $detik_b;
          }

          $koor_bt_ful_p[$i]=$splitName_p[$i][0].' ᴼ '.$splitName2_p[$i][0].' ’ '.$splitName3_p[$i][0].' ” '.$ket_bujur_p[$i];


          $koordinatLintang[$i] = $data_klaster_plot[$i]->koordinat_LS;
          $l_splitName_p[$i] = explode(' ', $koordinatLintang[$i], 2);
          $l_splitName2_p[$i]= explode(' ', $l_splitName_p[$i][1], 2);
          $l_splitName3_p[$i]= explode(' ', $l_splitName2_p[$i][1], 2);
          if($l_splitName_p[$i][0]>=0){
            $ket_lintang_p[$i]='LU';
            $lat_derajat=$l_splitName_p[$i][0];
            $menit_l = $l_splitName2_p[$i][0]/60;
            $detik_l = $l_splitName3_p[$i][0]/3600;
            $koordinat_lintang_angka_klaster[$i] = $lat_derajat + $menit_l + $detik_l;

          }
          else{
            $ket_lintang_p[$i]='LS';
            $l_splitName_p[$i][0]=$l_splitName_p[$i][0]*-1;

            $lat_derajat=$l_splitName_p[$i][0]*-1;
            $menit_l = $l_splitName2_p[$i][0]/60;
            $detik_l = $l_splitName3_p[$i][0]/3600;
            $koordinat_lintang_angka_klaster[$i] = $lat_derajat - $menit_l - $detik_l;
          }

          $koor_ls_ful_p[$i]=$l_splitName_p[$i][0].' ᴼ '.$l_splitName2_p[$i][0].' ’ '.$l_splitName3_p[$i][0].' ” '.$ket_lintang_p[$i];

          $app = app();
          $koordinat_lokasi[$i] = $app->make('stdClass');
          $koordinat_lokasi[$i]->nama_klaster = $data_klaster_plot[$i]->nama_klaster;
          $koordinat_lokasi[$i]->kategori = $data_klaster_plot[$i]->kategori;
          $koordinat_lokasi[$i]->pengukuran_ke = $data_klaster_plot[$i]->pengukuran_ke;
          $koordinat_lokasi[$i]->tahun_pengukuran = $data_klaster_plot[$i]->tahun_pengukuran;
          $koordinat_lokasi[$i]->nama_pengukur = $data_klaster_plot[$i]->nama_pengukur;
          $koordinat_lokasi[$i]->nama_plot = $data_klaster_plot[$i]->nama_plot;
          $koordinat_lokasi[$i]->bujur = $koordinat_bujur_angka_klaster[$i];
          $koordinat_lokasi[$i]->lintang = $koordinat_lintang_angka_klaster[$i];
          $koordinat_lokasi[$i]->lintangFull = $koor_ls_ful_p[$i];
          $koordinat_lokasi[$i]->bujurFull = $koor_bt_ful_p[$i];
          $koordinat_lokasi[$i]->lbds = $lbds_f[$i];
          $koordinat_lokasi[$i]->pli = $tli_f[$i];
          $koordinat_lokasi[$i]->vcr = $vcr_f[$i];
          $koordinat_lokasi[$i]->volume = $volume_f[$i];
          $koordinat_lokasi[$i]->haksen = $h_aksen[$i];
          $koordinat_lokasi[$i]->jpliu = $tot_jpliu[$i];

          $koordinat_lokasi[$i]->haksenf = $h_aksenf[$i];
          $koordinat_lokasi[$i]->jpliuf = $tot_jpliuf[$i];

          $koordinat_lokasi[$i]->nama_pengukur2 = $data_klaster_plot2[$i]->nama_pengukur;
          $koordinat_lokasi[$i]->tahun_pengukuran2 = $data_klaster_plot2[$i]->tahun_pengukuran;
          $koordinat_lokasi[$i]->lbds2 = $lbds_f2[$i];
          $koordinat_lokasi[$i]->pli2 = $tli_f2[$i];
          $koordinat_lokasi[$i]->vcr2 = $vcr_f2[$i];
          $koordinat_lokasi[$i]->volume2 = $volume_f2[$i];
          $koordinat_lokasi[$i]->haksen2 = $h_aksen2[$i];
          $koordinat_lokasi[$i]->jpliu2 = $tot_jpliu2[$i];
          $koordinat_lokasi[$i]->haksenf2 = $h_aksenf2[$i];
          $koordinat_lokasi[$i]->jpliuf2 = $tot_jpliuf2[$i];

          $koordinat_lokasi[$i]->nama_pengukur3 = $data_klaster_plot3[$i]->nama_pengukur;
          $koordinat_lokasi[$i]->tahun_pengukuran3 = $data_klaster_plot3[$i]->tahun_pengukuran;
          $koordinat_lokasi[$i]->lbds3 = $lbds_f3[$i];
          $koordinat_lokasi[$i]->pli3 = $tli_f3[$i];
          $koordinat_lokasi[$i]->vcr3 = $vcr_f3[$i];
          $koordinat_lokasi[$i]->volume3 = $volume_f3[$i];
          $koordinat_lokasi[$i]->haksen3 = $h_aksen3[$i];
          $koordinat_lokasi[$i]->jpliu3 = $tot_jpliu3[$i];
          $koordinat_lokasi[$i]->haksenf3 = $h_aksenf3[$i];
          $koordinat_lokasi[$i]->jpliuf3 = $tot_jpliuf3[$i];
        }
    }
}
else{
  $koordinat_lokasi=0;
}

    return response()->json($koordinat_lokasi);
  }
}
