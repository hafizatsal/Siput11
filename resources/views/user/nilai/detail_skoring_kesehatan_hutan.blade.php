@extends('layouts.layout')
@section('title','Halaman Skoring')
@section('css')
  <link rel="stylesheet" href="{{asset('Admin/bower_components/morris.js/morris.css')}}">
  <link rel="stylesheet" href="{{asset('Admin/cdn/table-responsive.css')}}">
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.4.0/dist/leaflet.css"
     integrity="sha512-puBpdR0798OZvTTbP4A8Ix/l+A4dHDD0DGqYW6RQ+9jxkRFclaxxQb/SJAWZfWAkuyeQUytO7+7N4QKrDh+drA=="
     crossorigin=""/>
  <link rel="stylesheet" href="https://unpkg.com/esri-leaflet-geocoder@2.2.13/dist/esri-leaflet-geocoder.css"
    integrity="sha512-v5YmWLm8KqAAmg5808pETiccEohtt8rPVMGQ1jA6jqkWVydV5Cuz3nJ9fQ7ittSxvuqsvI9RSGfVoKPaAJZ/AQ=="
    crossorigin="">
@endsection
@section('active_penilaian','active')
@section('active_nilai_akhir','active')
@section('judul_halaman','Halaman Skoring')
@section('breadcrumb')
<li><a href="javascript:history.back()">Nilai Akhir Kesehatan Hutan</a></li>
<li><a href="#">Nilai Kesehatan Plot</a></li>
@endsection
@section('main_section')

<!-- nilai kesehatan klaster -->
@if($jumlah_plot!=1)
<div class="box box-success">
  <div class="box-header with-border">
    <h3 class="box-title"><b>Skoring Kesehatan Hutan Klaster Plot {{$kode_klaster_plot}}</b></h3>
    <div class="box-tools pull-right">
      <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
      </button>
      </div>
  </div>

  <!-- BAR CHART -->
  <div class="box-body chart-responsive">
    <h4>Pengukuran ke-{{$pengukuran_ke}}</h4>
    <canvas id="densityChart" width="600" height="150"></canvas>
    <div class="text-center">
      <button type="button" name="button" class="btn btn-success"></button>Baik
      <button type="button" name="button" class="btn btn-warning"></button>Sedang
      <button type="button" name="button" class="btn btn-danger"></button>Buruk
    </div>
  </div>
  <!-- /.box-body -->
</div>
@endif
<!-- /.box -->

<!-- peta lokasi pemantauan -->
<div class="box box-success">
      <div class="box-header with-border">
        <h3 class="box-title"><b>Lokasi Plot Penilaian dan atau Pemantauan Kesehatan Hutan</b></h3>
      </div>
      <div class="box-body">
        <div id="mapid" class="box-body chart-responsive" style="height:250px;"></div>
      </div>
    </div>
<!-- /.box-body -->

<!-- nilai kesehatan klaster -->
<div class="box box-info">
  <div class="box-header with-border">
    <h3 class="box-title"><b>Nilai Kesehatan per Plot</b></h3>
    <div class="box-tools pull-right">
      <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
    </div>
  </div>
  <div class="box-body">
    <div class="table-responsive">
      <table id="nilai_kesehatan" class="table table-bordered table-striped">
        <thead>
          <tr>
            <th style="vertical-align: middle; width:15%;">Nama Plot</th>
            <th style="vertical-align: middle;">Nilai Kesehatan per Plot</th>
            <th style="text-align: center; vertical-align: middle; width:4%">Kondisi</th>
            <th style="text-align: center; vertical-align: middle; width:4%">Lihat Detail</th>
          </tr>
        </thead>
        <tbody>
          @php($i=0)@foreach($id_plot as $value)
          <tr>
            <td>{{$value->nama_plot}}</td>
            <td>
              {{$na_total[$i]}}
            </td>
            <td style="text-align: center; vertical-align: middle">
              @if($nilai_skor[$i]=="Baik")<span class='label label-success'>O</span>@endif
              @if($nilai_skor[$i]=="Sedang")<span class='label label-warning'>O</span>@endif
              @if($nilai_skor[$i]=="Buruk")<span class='label label-danger'>O</span>@endif
            </td>

            <td style="text-align: center; vertical-align: middle">
              <form id="detail{{$i}}" method="post" class="" action="{{route('user.penilaian_kesehatan.plot')}}">
                {{csrf_field()}}
                <input type="hidden" id="pengukuran_ke" name="pengukuran_ke" value="{{$pengukuran_ke}}">
                <input type="hidden" id="id_plot" name="id_plot" value="{{$value->id_plot}}">
                <input type="hidden" id="p_lbds" name="p_lbds" value="{{$p_lbds}}">
                <input type="hidden" id="p_volume" name="p_volume" value="{{$p_volume}}">
                <input type="hidden" id="p_kerusakan" name="p_kerusakan" value="{{$p_kerusakan}}">
                <input type="hidden" id="p_ktjk" name="p_ktjk" value="{{$p_ktjk}}">
                <input type="hidden" id="p_kimia" name="p_kimia" value="{{$p_kimia}}">
                <input type="hidden" id="sifat-sifat_kimia" name="sifat-sifat_kimia" value="{{$sifat_kimia}}">
                <input type="hidden" id="p_fisik" name="p_fisik" value="{{$p_fisik}}">
                <input type="hidden" id="p_jpliu" name="p_jpliu" value="{{$p_jpliu}}">
                <input type="hidden" id="p_dmg" name="p_dmg" value="{{$p_dmg}}">
                <input type="hidden" id="haksenp" name="haksenp" value="{{$haksenp}}">
                <input type="hidden" id="haksenf" name="haksenf" value="{{$haksenf}}">
              </form>

              <a class="fa fa-search btn btn-success btn-xs" onclick="document.getElementById('detail{{$i}}').submit()"></a>

            </td>
          </tr>
          @php($i++)
          @endforeach

        </tbody>
        <tfoot></tfoot>
      </table>
    </div>
  </div>
  <!-- /.box-body -->
</div>

<!-- range skor klaster -->
<div class="box box-primary collapsed-box">
  <div class="box-header with-border">
    <h3 class="box-title"><b>Range Skor Kesehatan Klaster Plot {{$kode_klaster_plot}}</b></h3>
    <div class="box-tools pull-right">
      <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
      <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
    </div>
  </div>
  <div class="box-body">
    <div class="table-responsive">
      <table id="nilai_kesehatan" class="table table-bordered table-striped">
        <thead>
          <tr>
            <th style="vertical-align: middle">Skor</th>
            <th style="text-align: center; vertical-align: middle">Min</th>
            <th style="text-align: center; vertical-align: middle">-</th>
            <th style="text-align: center; vertical-align: middle">Max</th>
            <th>Kondisi</th>
          </tr>
        </thead>
        <tbody>
          @for($i=1;$i<=3;$i++)
          <tr>
            <td>{{$i}}</td>
            <td>{{$range_nks_l[$i-1]}}</td>
            <td>-</td>
            <td>{{$range_nks_r[$i]}}</td>
            <td>@if($kondisi[$i-1]=="Baik") <span class="label label-success">O</span> @elseif($kondisi[$i-1]=="Sedang") <span class="label label-warning">O</span> @else <span class="label label-danger">O</span> @endif{{$kondisi[$i-1]}}</td>
          </tr>
          @endfor
        </tbody>
        <tfoot></tfoot>
      </table>
    </div>
  </div>
</div>

@if($p_kimia!="")
<div class="box box-warning">
  <div class="box-header with-border">
    <h3 class="box-title"><b>Data Kualitas Tapak (Kimia)</b></h3>
  </div>
  <!-- /.box-header -->
  <div class="box-body">
    <div class="table-responsive">
      <table id="" class="table table-bordered table-striped">
        <thead>
          <tr>
            <th>Sifat Kimia</th>
            <th>CEC (me/100 g)</th>
          </tr>
        </thead>
        <tbody>
          @php($id=1) @foreach($data_ktk_kimia as $sifat_kimia)
          <tr>
            <td>{{$sifat_kimia->sifat_kimia}}</td>
            <td>{{$sifat_kimia->cec}}</td>
          </tr>
          @php($id++)
          @endforeach
          @if($id==1)
          <td style="text-align: center; vertical-align: middle" colspan="2"> Tidak ada data </td>
          @endif
        </tbody>
        <tfoot></tfoot>
      </table>
    </div>
  </div>
  <!-- /.box-body -->
  </div>
@endif

@if($p_fisik!="")
<div class="box box-warning">
    <div class="box-header with-border">
      <h3 class="box-title"><b>Data Kualitas Tapak (Fisika)</b></h3>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
      <div class="table-responsive">
        <table id="data_ktk_fisik" class="table table-bordered table-striped">
          <thead>
            <tr>
              <th rowspan="2" style="text-align: center; vertical-align: middle">Titik Plot</th>
              <th colspan="2" style="text-align: center; vertical-align: middle">Penutupan tanah <br> %</th>
              <th rowspan="2" style="text-align: center; vertical-align: middle">Tekstur tanah</th>
              <th rowspan="2" style="text-align: center; vertical-align: middle">Warna tanah</th>
              <th rowspan="2" style="text-align: center; vertical-align: middle">Ketebalan <br> Lapisan tanah <br> (cm)</th>
              <th colspan="2" style="text-align: center; vertical-align: middle">Titik Koordinat</th>
            </tr>
            <tr>
              <th style="text-align: center; vertical-align: middle">Terbuka</th>
              <th style="text-align: center; vertical-align: middle">Tertutup</th>
              <th style="text-align: center; vertical-align: middle">Lintang <br> o/U/S</th>
              <th style="text-align: center; vertical-align: middle">Bujur <br> o/B/T</th>
            </tr>
          </thead>
          <tbody>
            @php($format = "%d ᴼ %d ’ %s ” %s")

            @php($nmr=1) @foreach($data_fisik as $data_fisik)
            @php($l_splitName_p = explode(' ', $data_fisik->lintang_tanah, 2))
            @php($l_splitName2_p= explode(' ', $l_splitName_p[1], 2))
            @php($l_splitName3_p= explode(' ', $l_splitName2_p[1], 2))
            <?php
            if($l_splitName_p[0]>=0){
              $ket_lintang_pt='LU';
            }
            else{
              $ket_lintang_pt='LS';
              $l_splitName_p[0]=$l_splitName_p[0]*-1;
            }?>

            @php($l_splitName_pb = explode(' ', $data_fisik->bujur_tanah, 2))
            @php($l_splitName2_pb= explode(' ', $l_splitName_pb[1], 2))
            @php($l_splitName3_pb= explode(' ', $l_splitName2_pb[1], 2))
            <?php
            if($l_splitName_pb[0]>=0){
              $ket_bujur_pt='BT';
            }
            else{
              $ket_bujur_pt='BB';
              $l_splitName_pb[0]=$l_splitName_pb[0]*-1;
            }?>
            <tr>
              <td>{{$data_fisik->titik_plot}}</td>
              <td>{{$data_fisik->terbuka}}</td>
              <td>{{$data_fisik->tertutup}}</td>
              <td>{{$data_fisik->tekstur}}</td>
              <td>{{$data_fisik->warna_tanah}}</td>
              <td>{{$data_fisik->ketebalan}}</td>
              <td>{{sprintf($format, $l_splitName_p[0], $l_splitName2_p[0], $l_splitName3_p[0],$ket_lintang_pt)}}</td>
              <td>{{sprintf($format, $l_splitName_pb[0], $l_splitName2_pb[0], $l_splitName3_pb[0],$ket_bujur_pt)}}</td>
            </tr>
            @endforeach
          </tbody>
          <tfoot></tfoot>
        </table>
      </div>
    </div>
    <!-- /.box-body -->
  </div>
@endif

@if($haksenf!="" || $p_jpliuf!="" || $p_dmgf!="")
<div class="box">
  <div class="box-header with-border">
    <h3 class="box-title"><b>Data Biodiversitas Fauna</b></h3>
  </div>
    <div class="box-body">
      <div class="table-responsive">
        <table class="table table-bordered table-striped" id="table-indikator" style="padding:10px;">
          <thead>
            <tr>
              <th style="width:10%">#</th>
              <th style="width:25%">Nama Fauna</th>
              <th style="width:25%">Nama Latin</th>
              <th>Jumlah</th>
              <th>ni</th>
              <th>ln(ni)</th>
              <th>H'</th>
              @if($p_jpliuf)
              <th>J'</th>
              @endif
              @if($p_dmgf)
              <th>DMg</th>
              @endif
            </tr>
          </thead>
          <tbody>
            @php ($nmr=1) @php($jumlah_total=0) @php($total_jpliuf=0) @php($total_dmgf=0) @foreach($jumlah_fauna as $d)
          <tr>
            <td>{{$nmr++}}</td>
            <td>{{$d->nama_fauna}} </td>
            <td><i>{{$d->nama_latin_fauna}} </i></td>
            <td>{{$nf[$nmr-2]}}</td>
            <td>{{$nif[$nmr-2]}}</td>
            <td>{{$ln_nif[$nmr-2]}}</td>
            <td>{{$ni_ln_nif[$nmr-2]}}</td>
            @if($p_jpliuf)
            <th>{{$j_pliuf[$nmr-2]}}</th>
            @endif
            @if($p_dmgf)
            <th>{{$d_mgf[$nmr-2]}}</th>
            @endif
            @php($jumlah_total+=$nf[$nmr-2])
            @php($total_jpliuf+=$j_pliuf[$nmr-2])
            @php($total_dmgf+=$d_mgf[$nmr-2])
          </tr>
          @endforeach
        </tbody>
        <thead>
        <th>Jumlah</th>
        <th></th>
        <th></th>
        <th>{{$jumlah_total}}</th>
        <th></th>
        <th></th>
        <th>@if($haksenf!=""){{$rata_h_aksenf}}@endif</th>
        @if($p_jpliuf)
        <th>{{$rata_j_pliuf}}</th>
        @endif
        @if($p_dmgf)
        <th>{{$rata_dmgf}}</th>
        @endif
        </thead>
      </table>
    </div>
  </div>
  </div>
@endif

<!-- nilai perhitungan -->
<div class="box">
  <div class="box-header with-border">
    <h3 class="box-title"><b>Nilai Perhitungan Kesehatan Hutan per Plot</b></h3>
    <div class="box-tools pull-right">
      <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
      <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
    </div>
  </div>
  <div class="box-body">
    <!-- Custom Tabs -->
    <div class="nav-tabs-custom">
      <ul class="nav nav-tabs">
        <li class="active"><a href="#tab_4" data-toggle="tab">Nilai Analisis</a></li>
        <li><a href="#tab_3" data-toggle="tab">Nilai Skor</a></li>
        <li><a href="#tab_2" data-toggle="tab">Nilai Tertimbang</a></li>
        <li><a href="#tab_1" data-toggle="tab">Nilai Indikator Kesehatan</a></li>
      </ul>
      <div class="tab-content">
        <div class="tab-pane fade" id="tab_1">
          <table id="Nilai_Indikator" class="table table-bordered table-striped">
            <thead>
              <tr>
                <th style="text-align: center; vertical-align: middle">Nama Plot</th>
                @if($p_lbds!="")
                <th style="text-align: center; vertical-align: middle">Nilai LBDS <br> (NS X NT)</th>
                @endif
                @if($p_volume!="")
                <th style="text-align: center; vertical-align: middle">Nilai Volume <br> (NS X NT)</th>
                @endif
                @if($p_ktjk!="")
                <th style="text-align: center; vertical-align: middle">Nilai Kondisi Tajuk <br> (NS X NT)</th>
                @endif
                @if($p_kerusakan!="")
                <th style="text-align: center; vertical-align: middle">Nilai Kerusakan <br> (NS X NT)</th>
                @endif
                @if($haksenp!="")
                <th style="text-align: center; vertical-align: middle">Nilai H' Pohon <br> (NS X NT)</th>
                @endif
                @if($p_jpliu!="")
                <th style="text-align: center; vertical-align: middle">Nilai J' Pohon <br> (NS X NT)</th>
                @endif
                @if($p_dmg!="")
                <th style="text-align: center; vertical-align: middle">Nilai DMg Pohon <br> (NS X NT)</th>
                @endif
              </tr>
            </thead>
            <tbody>
              @php($i=0) @foreach($id_plot as $value)
              <tr>
                <td>{{$value->nama_plot}}</td>
                @if($p_lbds!="")
                <td>{{$skor_lbds[$i]}} x {{$nt_produktivitas[$i]}} = {{$na_lbds[$i]}}</td>
                @endif
                @if($p_volume!="")
                <td>{{$skor_volume[$i]}} x {{$nt_produktivitas[$i]}} = {{$na_volume[$i]}}</td>
                @endif
                @if($p_ktjk!="")
                <td>{{$skor_vcr[$i]}} x {{$nt_ktjk[$i]}} = {{$na_tajuk[$i]}}</td>
                @endif
                @if($p_kerusakan!="")
                <td>{{$skor_tli[$i]}} x {{$nt_kerusakan[$i]}} = {{$na_kerusakan[$i]}}</td>
                @endif
                @if($haksenp!="")
                <td>{{$skor_h_aksen[$i]}} x {{$nt_biodiv[$i]}} = {{$na_h_aksen[$i]}}</td>
                @endif
                @if($p_jpliu!="")
                <td>{{$skor_j_pliu[$i]}} x {{$nt_biodiv[$i]}} = {{$na_j_pliu[$i]}}</td>
                @endif
                @if($p_dmg!="")
                <td>{{$skor_dmg[$i]}} x {{$nt_biodiv[$i]}} = {{$na_dmg[$i]}}</td>
                @endif
              </tr>
              @php($i++)
              @endforeach
            </tbody>
            <tfoot></tfoot>
          </table>
        </div>
        <!-- /.tab-pane -->

        <div class="tab-pane fade" id="tab_2">
          <table id="Nilai_Tertimbang" class="table table-bordered table-striped">
            <thead>
              <tr>
                <th style="text-align: center; vertical-align: middle">Nama Plot</th>
                @if($p_lbds!="")
                <th style="text-align: center; vertical-align: middle">Nilai Tertimbang <br> Produktifitas</th>
                @endif
                @if($p_ktjk!="")
                <th style="text-align: center; vertical-align: middle">Nilai Tertimbang Kondisi <br> Tajuk</th>
                @endif
                @if($p_kerusakan!="")
                <th style="text-align: center; vertical-align: middle">Nilai Tertimbang Kerusakan</th>
                @endif
                @if($haksenp!="")
                <th style="text-align: center; vertical-align: middle">Nilai Tertimbang H' <br> Pohon</th>
                @endif
                @if($p_jpliu!="")
                <th style="text-align: center; vertical-align: middle">Nilai Tertimbang J' <br> Pohon</th>
                @endif
                @if($p_dmg!="")
                <th style="text-align: center; vertical-align: middle">Nilai Tertimbang DMg <br> Pohon</th>
                @endif
              </tr>
            </thead>
            <tbody>
              @php ($i=0) @foreach($id_plot as $value)
              <tr>
                <td>{{$value->nama_plot}}</td>
                @if($p_lbds!="")
                <td>{{$nt_produktivitas[$i]}}</td>
                @endif
                @if($p_ktjk!="")
                <td>{{$nt_ktjk[$i]}}</td>
                @endif
                @if($p_kerusakan!="")
                <td>{{$nt_kerusakan[$i]}}</td>
                @endif
                @if($haksenp!="")
                <td>{{$nt_biodiv[$i]}}</td>
                @endif
                @if($p_jpliu!="")
                <td>{{$nt_biodiv[$i]}}</td>
                @endif
                @if($p_dmg!="")
                <td>{{$nt_biodiv[$i]}}</td>
                @endif
              </tr>
              @php($i++)
              @endforeach
            </tbody>
            <tfoot></tfoot>
          </table>
        </div>
        <!-- /.tab-pane -->

        <div class="tab-pane fade" id="tab_3">
          <table id="nilai_skor" class="table table-bordered table-striped">
            <thead>
              <tr>
                <th style="text-align: center; vertical-align: middle">Nama Plot</th>
                @if($p_lbds!="")
                <th style="text-align: center; vertical-align: middle">Nilai Skor Pertumbuhan <br> (LBDS)</th>
                @endif
                @if($p_volume!="")
                <th style="text-align: center; vertical-align: middle">Nilai Skor Pertumbuhan<br> (Volume)</th>
                @endif
                @if($p_ktjk!="")
                <th style="text-align: center; vertical-align: middle">Nilai Skor <br> Kondisi Tajuk (VCRp)</th>
                @endif
                @if($p_kerusakan!="")
                <th style="text-align: center; vertical-align: middle">Nilai Skor <br> Kerusakan (PLI)</th>
                @endif
                @if($haksenp!="")
                <th style="text-align: center; vertical-align: middle">Nilai Skor Biodiversitas <br>Pohon (H')</th>
                @endif
                @if($p_jpliu!="")
                <th style="text-align: center; vertical-align: middle">Nilai Skor Biodiversitas <br>Pohon (J')</th>
                @endif
                @if($p_dmg!="")
                <th style="text-align: center; vertical-align: middle">Nilai Skor Biodiversitas <br>Pohon (DMg)</th>
                @endif
              </tr>
            </thead>
            <tbody>
              @php($i=0) @foreach($id_plot as $value)
              <tr>
                <td>{{$value->nama_plot}}</td>
                @if($p_lbds!="")
                <td>{{$skor_lbds[$i]}}</td>
                @endif
                @if($p_volume!="")
                <td>{{$skor_volume[$i]}}</td>
                @endif
                @if($p_ktjk!="")
                <td>{{$skor_vcr[$i]}}</td>
                @endif
                @if($p_kerusakan!="")
                <td>{{$skor_tli[$i]}}</td>
                @endif
                @if($haksenp!="")
                <td>{{$skor_h_aksen[$i]}}</td>
                @endif
                @if($p_jpliu!="")
                <td>{{$skor_j_pliu[$i]}}</td>
                @endif
                @if($p_dmg!="")
                <td>{{$skor_dmg[$i]}}</td>
                @endif
              </tr>
              @php($i++)
              @endforeach
            </tbody>
            <tfoot></tfoot>
          </table>
        </div>
        <!-- /.tab-pane -->

        <div class="tab-pane fade in active" id="tab_4">
          <table id="nilai_analisis" class="table table-bordered table-striped">
            <thead>
              <tr>
                <th style="text-align: center; vertical-align: middle">Nama Plot</th>
                @if($p_lbds!="")
                <th style="text-align: center; vertical-align: middle">LBDS <br> (m<sup>2</sup>)</th>
                @endif
                @if($p_volume!="")
                <th style="text-align: center; vertical-align: middle">Volume <br> (m<sup>3</sup>)</th>
                @endif
                @if($p_ktjk!="")
                <th style="text-align: center; vertical-align: middle">VCRp</th>
                @endif
                @if($p_kerusakan!="")
                <th style="text-align: center; vertical-align: middle">PLI</th>
                @endif
                @if($haksenp!="")
                <th style="text-align: center; vertical-align: middle">H' Pohon</th>
                @endif
                @if($p_jpliu)
                <th style="text-align: center; vertical-align: middle">J' Pohon</th>
                @endif
                @if($p_dmg)
                <th style="text-align: center; vertical-align: middle">DMg Pohon</th>
                @endif
              </tr>
            </thead>
            <tbody>
              @php($i=0) @foreach($id_plot as $value)
              <tr>
                <td>{{$value->nama_plot}}</td>
                @if($p_lbds!="")
                <td>{{$nilai_lbds[$i]}}</td>
                @endif
                @if($p_volume!="")
                <td>{{$nilai_volume[$i]}}</td>
                @endif
                @if($p_ktjk!="")
                <td>{{$nilai_vcr[$i]}}</td>
                @endif
                @if($p_kerusakan!="")
                <td>{{$nilai_tli[$i]}}</td>
                @endif
                @if($haksenp!="")
                <td>{{$rata_h_aksen[$i]}}</td>
                @endif
                @if($p_jpliu)
                <td>{{$rata_j_pliu[$i]}}</td>
                @endif
                @if($p_dmg)
                <td>{{$rata_dmg[$i]}}</td>
                @endif
              </tr>
              @php($i++)
              @endforeach
            </tbody>
            <tfoot></tfoot>
          </table>
        </div>
        <!-- /.tab-pane -->

      </div>
      <!-- /.tab-content -->
    </div>
  </div>
</div>

<!-- range skor parameter -->
<div class="box box-primary  collapsed-box">
  <div class="box-header with-border">
    <h3 class="box-title"><b>Range Skor Parameter</b></h3>
    <div class="box-tools pull-right">
      <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
      <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
    </div>
  </div>
  <div class="box-body">
    @if($p_lbds!="")
    <div class="col-md-3">
      <h4 style="text-align:center">Range Pertumbuhan Pohon <br>(LBDS)</h4>
      <div class="col-xs-12 table-responsive">
        <table id="" class="table table-bordered table-striped">
          <thead>
            <tr>
              <th>Skor</th>
              <th>Min</th>
              <th>-</th>
              <th>Max</th>
            </tr>
          </thead>
          <tbody>
            @php($skor=0) @for($i=1;$i<=10;$i++)
            <tr>
              <td>{{++$skor}}</td>
              <td>{{$range_lbds_l[$i-1]}}</td>
              <td>-</td>
              <td>{{$range_lbds_r[$i]}}</td>
            </tr>
            @endfor
          </tbody>
          <tfoot>

          </tfoot>
        </table>
      </div>
    </div>
    @endif

    @if($p_volume!="")
    <div class="col-md-3">
      <h4 style="text-align:center">Range Pertumbuhan Pohon <br>(Volume)</h4>
      <div class="col-xs-12 table-responsive">
        <table id="" class="table table-bordered table-striped">
          <thead>
            <tr>
              <th>Skor</th>
              <th>Min</th>
              <th>-</th>
              <th>Max</th>
            </tr>
          </thead>
          <tbody>
            @php($skor=0) @for($i=1;$i<=10;$i++)
            <tr>
              <td>{{++$skor}}</td>
              <td>{{$range_volume_l[$i-1]}}</td>
              <td>-</td>
              <td>{{$range_volume_r[$i]}}</td>
            </tr>
            @endfor
          </tbody>
          <tfoot></tfoot>
        </table>
      </div>
    </div>
    @endif

    @if($p_ktjk!="")
    <div class="col-md-3">
      <h4 style="text-align:center">Range Kondisi Tajuk Pohon <br> (VCRp)</h4>
      <div class="col-xs-12 table-responsive">
        <table id="" class="table table-bordered table-striped">
          <thead>
            <tr>
              <th>Skor</th>
              <th>Min</th>
              <th>-</th>
              <th>Max</th>
            </tr>
          </thead>
          <tbody>
            @php($skor=0) @for($i=1;$i<=10;$i++)
            <tr>
              <td>{{++$skor}}</td>
              <td>{{$range_vcr_l[$i-1]}}</td>
              <td>-</td>
              <td>{{$range_vcr_r[$i]}}</td>
            </tr>
            @endfor
          </tbody>
          <tfoot></tfoot>
        </table>
      </div>
    </div>
    @endif

    @if($p_kerusakan!="")
    <div class="col-md-3">
      <h4 style="text-align:center">Range Kerusakan Pohon <br> (PLI)</h4>
      <div class="col-xs-12 table-responsive">
        <table id="" class="table table-bordered table-striped">
          <thead>
            <tr>
              <th>Skor</th>
              <th>Min</th>
              <th>-</th>
              <th>Max</th>
            </tr>
          </thead>
          <tbody>

            @php($skor=0) @for($i=1;$i<=10;$i++)
            <tr>
              <td>{{++$skor}}</td>
              <td>{{$range_tli_l[$i]}}</td>
              <td>-</td>
              <td>{{$range_tli_r[$i-1]}}</td>
            </tr>
            @endfor
          </tbody>
          <tfoot></tfoot>
        </table>
      </div>
    </div>
    @endif

    @if($haksenp!="")
    <div class="col-md-3">
      <h4 style="text-align:center">Range Biodiversitas Pohon <br> (H')</h4>
      <div class="col-xs-12 table-responsive">
        <table id="" class="table table-bordered table-striped">
          <thead>
            <tr>
              <th>Skor</th>
              <th>Min</th>
              <th>-</th>
              <th>Max</th>
            </tr>
          </thead>
          <tbody>

            @php($skor=0) @for($i=1;$i<=10;$i++)
            <tr>
              <td>{{++$skor}}</td>
              <td>{{$range_h_aksen_l[$i-1]}}</td>
              <td>-</td>
              <td>{{$range_h_aksen_r[$i]}}</td>
            </tr>
            @endfor

          </tbody>
          <tfoot></tfoot>
        </table>
      </div>
    </div>
    @endif

    @if($j_pliu!="" && is_array($range_j_pliu_l) && is_array($range_j_pliu_r))
    <div class="col-md-3">
      <h4 style="text-align:center">Range Biodiversitas Pohon <br> (J')</h4>
      <div class="col-xs-12 table-responsive">
        <table id="" class="table table-bordered table-striped">
          <thead>
            <tr>
              <th>Skor</th>
              <th>Min</th>
              <th>-</th>
              <th>Max</th>
            </tr>
          </thead>
          <tbody>

            @php($skor=0) @for($i=1;$i<=10;$i++)
            <tr>
              <td>{{++$skor}}</td>
              <td>{{$range_j_pliu_l[$i-1]}}</td>
              <td>-</td>
              <td>{{$range_j_pliu_r[$i]}}</td>
            </tr>
            @endfor
          </tbody>
          <tfoot></tfoot>
        </table>
      </div>
    </div>
    @endif

    @if($d_mg!="" && is_array($range_dmg_l) && is_array($range_dmg_r))
    <div class="col-md-3">
      <h4 style="text-align:center">Range Biodiversitas Pohon <br> (DMg)</h4>
      <div class="col-xs-12 table-responsive">
        <table id="" class="table table-bordered table-striped">
          <thead>
            <tr>
              <th>Skor</th>
              <th>Min</th>
              <th>-</th>
              <th>Max</th>
            </tr>
          </thead>
          <tbody>
            @php($skor=0) @for($i=1;$i<=10;$i++)
            <tr>
              <td>{{++$skor}}</td>
              <td>{{$range_dmg_l[$i-1]}}</td>
              <td>-</td>
              <td>{{$range_dmg_r[$i]}}</td>
            </tr>
            @endfor
          </tbody>
          <tfoot></tfoot>
        </table>
      </div>
    </div>
    @endif

  </div>
  <!-- /.box-body -->
</div>

@section('data_table')
<!-- <script src="{{asset('Admin/dist/js/adminlte.min.js')}}"></script> TAMBAHAN UNTUK EXPANDABLE -->
<script src="{{asset('Admin/bower_components/raphael/raphael.min.js')}}"></script>
<script src="{{asset('Admin/bower_components/morris.js/morris.min.js')}}"></script>
<script src="{{asset('Admin/bower_components/datatables.net/js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('Admin/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js')}}"></script>
<script src="{{asset('Admin/cdn/table-responsive.min.js')}}"></script>
@endsection
<script src="{{asset('Admin/bower_components/jquery/dist/jquery.min.js')}}"></script>
<script src="{{ asset ("js/chart.min.js") }}"></script>
<script src="{{ asset ("js/Chart.js") }}"></script>
<script src="https://unpkg.com/leaflet@1.4.0/dist/leaflet.js"
  integrity="sha512-QVftwZFqvtRNi0ZyCtsznlKSWOStnDORoefr1enyq5mVL4tmKB3S/EnC3rRJcxCPavG10IcrVGSmPh6Qw5lwrg=="
  crossorigin=""></script>
<script src="https://unpkg.com/esri-leaflet@2.2.4/dist/esri-leaflet.js"
  integrity="sha512-tyPum7h2h36X52O2gz+Pe8z/3l+Y9S1yEUscbVs5r5aEY5dFmP1WWRY/WLLElnFHa+k1JBQZSCDGwEAnm2IxAQ=="
  crossorigin=""></script>
<script src="https://unpkg.com/esri-leaflet-geocoder@2.2.13/dist/esri-leaflet-geocoder.js"
  integrity="sha512-zdT4Pc2tIrc6uoYly2Wp8jh6EPEWaveqqD3sT0lf5yei19BC1WulGuh5CesB0ldBKZieKGD7Qyf/G0jdSe016A=="
  crossorigin=""></script>
<script type="text/javascript">

var densityCanvas = document.getElementById("densityChart");
Chart.defaults.global.legend.display = false;
Chart.defaults.global.defaultFontFamily = "Lato";
Chart.defaults.global.defaultFontSize = 18;

var skor_akhir=[];

<?php
for ($i=0;$i<count($na_total);$i++){
?>
skor_akhir[{{ $i }}]={{ $na_total[$i] }}
<?php
}?>
// value maksnya
var maks={{ max($na_total) }};
var maks2= parseInt(maks);
if(maks2>=0 && maks2<10){
  skor_akhir[{{ $i+1 }}] = maks2+0.5;
}
else if(maks2>=10 && maks2<100){
  skor_akhir[{{ $i+1 }}] = maks2+5;
}
else if(maks2>=100 && maks2<1000){
  skor_akhir[{{ $i+1 }}] = maks2+50;
}
else{
  skor_akhir[{{ $i+1 }}] = maks2+500;
}
var warna=[];

<?php
for ($i=0;$i<count($nilai_skor);$i++){
if($nilai_skor[$i]=="Buruk"){
  ?>
  warna[{{ $i }}]='rgba(208, 15, 18, 0.6)';
  <?php
}else if($nilai_skor[$i]=="Sedang"){
  ?>
  warna[{{ $i }}]='rgba(192, 208, 15, 0.6)';
  <?php
}else if($nilai_skor[$i]=="Baik"){
  ?>
  warna[{{ $i }}]='rgba(0, 255, 0, 0.6)';
  <?php
}}
?>
var max_val= ({{ max($na_total) }})+5;
var densityData = {
  data: skor_akhir,
  backgroundColor: warna,
  borderWidth: 2,
  hoverBorderWidth: 0
};

var options = {
  responsive: true,
  scales: {
    ticks: {
      beginAtZero: true,
    }
  },
  elements: {
    rectangle: {
      borderSkipped: 'left',
    }
  },
};

var barChart = new Chart(densityCanvas, {
  type: 'bar',
  data: {
    labels: [@foreach($id_plot as $value)
      "{{$value->nama_plot}}",
    @endforeach],
    datasets: [densityData],
    options: options,
  }
});

var satelite = L.tileLayer('http://{s}.google.com/vt/lyrs=s,h&x={x}&y={y}&z={z}',{
    maxZoom: 20,
    subdomains:['mt0','mt1','mt2','mt3']});

var OpenStreetMap_Mapnik = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
maxZoom: 19,
attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
});
var gmaps = L.tileLayer('http://{s}.google.com/vt/lyrs=m&x={x}&y={y}&z={z}',{
    maxZoom: 20,
    subdomains:['mt0','mt1','mt2','mt3']});

var mymap = L.map('mapid',{
  scrollWheelZoom:false,
  layers: [OpenStreetMap_Mapnik]});

var mapIndonesia = [
[5.528511, 95.20752],
[-8.754795, 103.271484],
[-11.092166, 141.240234],
[6.315299, 142.910156]
];
mymap.fitBounds(mapIndonesia);

var baseMaps = {
    "OSM": OpenStreetMap_Mapnik,
    "Google Maps" : gmaps,
    "Satelite": satelite
};

L.control.layers(baseMaps).addTo(mymap);

var bounds= Array();
var polyline = Array();
var latlngs = Array();

$(document).ready(function(){
  @foreach($id_plot as $value)
    koordinatLintang ="{{$value->koordinat_LS}}";
    split_lintang = koordinatLintang.split(' ');
    l_splitName_p = split_lintang[0];
    l_splitName2_p= split_lintang[1];
    l_splitName3_p= split_lintang[2];
    menit_l = l_splitName2_p/60;
    detik_l = l_splitName3_p/3600;

    if(l_splitName_p<0){
      koordinat_lintang_angka_klaster = parseFloat(l_splitName_p) - parseFloat(menit_l) - parseFloat(detik_l);
      ketLintang = " LS";
    }
    else{
      koordinat_lintang_angka_klaster = parseFloat(l_splitName_p) +parseFloat(menit_l) + parseFloat(detik_l);
      ketLintang = " LU";
    }

    koordinatBujur = "{{$value->koordinat_BT}}";
    split_bujur = koordinatBujur.split(' ');
    splitName_p = split_bujur[0];
    splitName2_p= split_bujur[1];
    splitName3_p= split_bujur[2];
    menit_b = splitName2_p/60;
    detik_b = splitName3_p/3600;

    if(splitName_p<0){
      koordinat_bujur_angka_klaster = parseFloat(splitName_p) - parseFloat(menit_b) - parseFloat(detik_b);
      ketBujur = "BB";
    }
    else{
      koordinat_bujur_angka_klaster = parseFloat(splitName_p) + parseFloat(menit_b) + parseFloat(detik_b);
      ketBujur = "BT";
    }
    marker = L.marker([koordinat_lintang_angka_klaster, koordinat_bujur_angka_klaster]).addTo(mymap);
    bounds.push(marker.getLatLng());
    marker.bindPopup("{{$value->nama_plot}} <br/> Koordinat: " +
                      Math.abs(l_splitName_p) + " ᴼ " + l_splitName2_p + " ' " + l_splitName3_p + " \" "
                       + ketLintang + ", " + Math.abs(splitName_p) +
                        " ᴼ " + splitName2_p + " ' " + splitName3_p + " \" " + ketBujur);
    L.circle([koordinat_lintang_angka_klaster, koordinat_bujur_angka_klaster], {radius: 17.95}).addTo(mymap);
    L.circle([koordinat_lintang_angka_klaster, koordinat_bujur_angka_klaster], {radius: 7.32, fillColor: 'green', color: 'green'}).addTo(mymap);
    if("{{$value->nama_plot}}"=="PLOT 1"){
      latlngs[0] = marker.getLatLng();
    }
    if("{{$value->nama_plot}}"=="PLOT 2"){
      latlngs[1] = latlngs[0];
      latlngs[2] = marker.getLatLng();
    }
    if("{{$value->nama_plot}}"=="PLOT 3"){
      latlngs[3] = latlngs[0];
      latlngs[4] = marker.getLatLng();
    }
    if("{{$value->nama_plot}}"=="PLOT 4"){
      latlngs[5] = latlngs[0];
      latlngs[6] = marker.getLatLng();
    }
  @endforeach
  mymap.fitBounds(bounds);
  polyline = L.polyline(latlngs, {color: 'red'}).addTo(mymap);
});

</script>

   @section('script_table')
  <script>

   $(function () {
     $('#Nilai_Indikator').DataTable({
       'responsive'  : true,
       'paging'      : true,
       'lengthChange': true,
       'searching'   : true,
       'ordering'    :true,
       'info'        : true,
       'autoWidth'   : false,
       'bStateSave'  : true,
       "language"    : {
         "search"       :        "Pencarian:",
         "lengthMenu"   : "Menampilkan _MENU_ data per halaman",
         "zeroRecords"  : "Nothing found - sorry",
         "info"         : "Halaman _PAGE_ dari _PAGES_",
         "infoEmpty"    : "Belum Ada Data Tersimpan",
         "infoFiltered" : "(filtered from _MAX_ total records)",
         "paginate" : {
           "first"      :   "Pertama",
           "last"       :   "Terakhir",
           "next"       :   "Selanjutnya",
           "previous"   :   "Sebelumnya"
         },
       }
     })
     $('#Nilai_Tertimbang').DataTable({
       'responsive'  : true,
       'paging'      : true,
       'lengthChange': true,
       'searching'   : true,
       'ordering'      :true,
       'info'        : true,
       'autoWidth'   : false,
       'bStateSave'  : true,
       "language"    : {
         "search"       :        "Pencarian:",
         "lengthMenu"   : "Menampilkan _MENU_ data per halaman",
         "zeroRecords"  : "Nothing found - sorry",
         "info"         : "Halaman _PAGE_ dari _PAGES_",
         "infoEmpty"    : "Belum Ada Data Tersimpan",
         "infoFiltered" : "(filtered from _MAX_ total records)",
         "paginate" : {
           "first"      :   "Pertama",
           "last"       :   "Terakhir",
           "next"       :   "Selanjutnya",
           "previous"   :   "Sebelumnya"
         },
       }
     })
     $('#nilai_skor').DataTable({
       'responsive'  : true,
       'paging'      : true,
       'lengthChange': true,
       'searching'   : true,
       'ordering'      :true,
       'info'        : true,
       'autoWidth'   : false,
       'bStateSave'  : true,
       "language"    : {
         "search"       :        "Pencarian:",
         "lengthMenu"   : "Menampilkan _MENU_ data per halaman",
         "zeroRecords"  : "Nothing found - sorry",
         "info"         : "Halaman _PAGE_ dari _PAGES_",
         "infoEmpty"    : "Belum Ada Data Tersimpan",
         "infoFiltered" : "(filtered from _MAX_ total records)",
         "paginate" : {
           "first"      :   "Pertama",
           "last"       :   "Terakhir",
           "next"       :   "Selanjutnya",
           "previous"   :   "Sebelumnya"
         },
       }
     })
     $('#nilai_analisis').DataTable({
       'responsive'  : true,
       'paging'      : true,
       'lengthChange': true,
       'searching'   : true,
       'ordering'      :true,
       'info'        : true,
       'autoWidth'   : false,
       'bStateSave'  : true,
       "language"    : {
         "search"       :        "Pencarian:",
         "lengthMenu"   : "Menampilkan _MENU_ data per halaman",
         "zeroRecords"  : "Nothing found - sorry",
         "info"         : "Halaman _PAGE_ dari _PAGES_",
         "infoEmpty"    : "Belum Ada Data Tersimpan",
         "infoFiltered" : "(filtered from _MAX_ total records)",
         "paginate" : {
           "first"      :   "Pertama",
           "last"       :   "Terakhir",
           "next"       :   "Selanjutnya",
           "previous"   :   "Sebelumnya"
         },
       }
     })

     $('a[data-toggle="tab"]').on('shown.bs.tab', function(e){
        $($.fn.dataTable.tables(true)).DataTable()
           .columns.adjust()
           .responsive.recalc();
     });
   })
   
  </script>
@endsection
@endsection


