@extends('layouts.layout')
@section('title','Halaman Skoring')
@section('css')
  <link rel="stylesheet" href="{{asset('Admin/bower_components/morris.js/morris.css')}}">
  <link rel="stylesheet" href="{{asset('Admin/cdn/table-responsive.css')}}">
  <link rel="" href="https://cdn.datatables.net/buttons/1.5.6/css/buttons.bootstrap.min.css">
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
<li><a href="#">Nilai Akhir Kesehatan Hutan</a></li>
@endsection
@section('main_section')

<!-- grafik nilai keshut -->
@if($jumlah_penilaian>1)
<div class="box box-success">
  <div class="box-header with-border">
    <h3 class="box-title"><b>Grafik Kesehatan Hutan di {{$id_klaster[0]->kategori}}</b></h3>
    <div class="box-tools pull-right">
      <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
      <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
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
<!-- /.box -->
@endif

<!-- peta lokasi keshut -->
<div class="box box-success">
  <div class="box-header with-border">
    <h3 class="box-title"><b>Lokasi Klaster Plot Penilaian dan atau Pemantauan Kesehatan Hutan</b></h3>
    <div class="box-tools pull-right">
      <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
      <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
    </div>
  </div>
  <div class="box-body">
    <div id="mapid" class="box-body chart-responsive" style="height:250px;"></div>
  </div>
</div>
<!-- /.box -->

<!-- nilai keshut -->
<div class="box box-info">
  <div class="box-header with-border">
    <h3 class="box-title"><b>Nilai Kesehatan Hutan</b></h3>
      <form id="skor_akhir" method="post" class="" action="{{route('penilaian_kesehatan')}}">
        {{csrf_field()}}
        <input type="hidden" id="nama_data_klaster1" name="nama_data_klaster1" value="{{$id_data_klaster}}">
        <input type="hidden" id="pengukuran_ke" name="pengukuran_ke" value="{{$pengukuran_ke}}">
        <input type="hidden" id="p_lbds" name="p_lbds" value="{{$p_lbds}}">
        <input type="hidden" id="p_volume" name="p_volume" value="{{$p_volume}}">
        <input type="hidden" id="p_kerusakan" name="p_kerusakan" value="{{$p_kerusakan}}">
        <input type="hidden" id="p_ktjk" name="p_ktjk" value="{{$p_ktjk}}">
        <input type="hidden" id="p_kimia" name="p_kimia" value="{{$p_kimia}}">
        <input type="hidden" id="p_fisik" name="p_fisik" value="{{$p_fisik}}">
        <input type="hidden" id="haksenp" name="haksenp" value="{{$haksenp}}">
        <input type="hidden" id="haksenf" name="haksenf" value="{{$haksenf}}">
      </form>

    <div id="export_nilai_kesehatan"></div>

    <div class="box-tools pull-right">
      <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
      <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
    </div>
  </div>
  <div class="box-body">
      <table id="nilai_kesehatan" class="table table-bordered table-striped">
        <div class="box-tools pull-right">
          <form class="" action="{{route('penilaian_klaster_export')}}" method="POST">
            {{ csrf_field() }}
            <input type="hidden" id="nama_data_klaster1" name="nama_data_klaster1" value="{{$id_data_klaster}}">
            <input type="hidden" id="pengukuran_ke" name="pengukuran_ke" value="{{$pengukuran_ke}}">
            <input type="hidden" id="p_lbds" name="p_lbds" value="{{$p_lbds}}">
            <input type="hidden" id="p_volume" name="p_volume" value="{{$p_volume}}">
            <input type="hidden" id="p_kerusakan" name="p_kerusakan" value="{{$p_kerusakan}}">
            <input type="hidden" id="p_ktjk" name="p_ktjk" value="{{$p_ktjk}}">
            <input type="hidden" id="p_kimia" name="p_kimia" value="{{$p_kimia}}">
            <input type="hidden" id="sifat-sifat_kimia" name="sifat-sifat_kimia" value="{{$sifat_kimia}}">
            <input type="hidden" id="p_fisik" name="p_fisik" value="{{$p_fisik}}">
            <input type="hidden" id="haksenp" name="haksenp" value="{{$haksenp}}">
            <input type="hidden" id="p_jpliu" name="p_jpliu" value="{{$p_jpliu}}">
            <input type="hidden" id="p_dmg" name="p_dmg" value="{{$p_dmg}}">
            <input type="hidden" id="haksenf" name="haksenf" value="{{$haksenf}}">
            <input type="hidden" id="p_jpliuf" name="p_jpliuf" value="{{$p_jpliuf}}">
            <input type="hidden" id="p_dmgf" name="p_dmgf" value="{{$p_dmgf}}">
            <input class="btn btn-primary" type="submit" value="Export">
          </form>
        </div>
        <thead>
          <tr>
            <th style="vertical-align: middle">Kode <br> Klaster <br> Plot</th>
            <th style="text-align: center; vertical-align: middle">Kabupaten</th>
            <th style="text-align: center; vertical-align: middle">Kecamatan</th>
            <th style="">Nilai Kesehatan Hutan <br>
              @if($p_lbds!="")
              Nilai LBDS @if($jmlh_param>1) + @endif
              @endif
              @if($p_volume!="")
              Nilai Volume @if($p_ktjk!="" || $p_kerusakan!="" || $haksenp!="" || $p_jpliu!="" || $p_dmg!="" || $haksenf!="" || $p_jpliuf!="" || $p_dmgf!="" || $p_kimia!="") + @endif
              @endif
              @if($p_ktjk!="")
              Nilai VCRc @if($p_kerusakan!="" || $haksenp!="" || $p_jpliu!="" || $p_dmg!="" || $haksenf!="" || $p_jpliuf!="" || $p_dmgf!="" || $p_kimia!="") + @endif
              @endif
              @if($p_kerusakan!="")
              Nilai CLI @if($haksenp!="" || $p_jpliu!="" || $p_dmg!="" || $haksenf!="" || $p_jpliuf!="" || $p_dmgf!="" || $p_kimia!="") + @endif
              @endif
              @if($haksenp!="")
              Nilai H' Pohon @if($p_jpliu!="" || $p_dmg!="" || $haksenf!="" || $p_jpliuf!="" || $p_dmgf!="" || $p_kimia!="") + @endif
              @endif
              @if($p_jpliu!="")
              Nilai J' Pohon @if($p_dmg!="" || $haksenf!="" || $p_jpliuf!="" || $p_dmgf!="" || $p_kimia!="") + @endif
              @endif
              @if($p_dmg!="")
              Nilai DMg Pohon @if($haksenf!="" || $p_jpliuf!="" || $p_dmgf!="" || $p_kimia!="") + @endif
              @endif
              @if($haksenf!="")
              Nilai H' Fauna @if($p_jpliuf!="" || $p_dmgf!="" || $p_kimia!="") + @endif
              @endif
              @if($p_jpliuf!="")
              Nilai J' Fauna @if($p_dmgf!="" || $p_kimia!="") + @endif
              @endif
              @if($p_dmgf!="")
              Nilai DMg Fauna @if($p_kimia!="") + @endif
              @endif
              @if($p_kimia!="")
              Nilai {{$parameter_sifat_kimia}}
              @endif
            </th>
            <th style="text-align: center; vertical-align: middle; width:4%">Kondisi</th>
            <th style="text-align: center; vertical-align: middle; width:4%">Lihat Detail</th>
          </tr>
        </thead>

        <tbody>
          @php($i=0)@foreach($id_klaster as $value)
          <tr>
            <td style="vertical-align: middle">{{$value->nama_klaster}}</td>
            <td>{{$value->nama_kabupaten}}</td>
            <td>{{$value->nama_kecamatan}}</td>
            <td>
              @if($p_lbds!="")
              {{$na_lbds[$i]}} @if($jmlh_param>1) + @endif
              @endif
              @if($p_volume!="")
              {{$na_volume[$i]}} @if($p_ktjk!="" || $p_kerusakan!="" || $haksenp!="" || $p_jpliu!="" || $p_dmg!="" || $haksenf!="" || $p_jpliuf!="" || $p_dmgf!="" || $p_kimia!="") + @endif
              @endif
              @if($p_ktjk!="")
              {{$na_tajuk[$i]}} @if($p_kerusakan!="" || $haksenp!="" || $p_jpliu!="" || $p_dmg!="" || $haksenf!="" || $p_jpliuf!="" || $p_dmgf!="" || $p_kimia!="") + @endif
              @endif
              @if($p_kerusakan!="")
              {{$na_kerusakan[$i]}} @if($haksenp!="" || $p_jpliu!="" || $p_dmg!="" || $haksenf!="" || $p_jpliuf!="" || $p_dmgf!="" || $p_kimia!="") + @endif
              @endif
              @if($haksenp!="")
              {{$na_biodiv_pohon[$i]}} @if($p_jpliu!="" || $p_dmg!="" || $haksenf!="" || $p_jpliuf!="" || $p_dmgf!="" || $p_kimia!="") + @endif
              @endif
              @if($p_jpliu!="")
              {{$na_biodiv_pohon_jpliu[$i]}} @if($p_dmg!="" || $haksenf!="" || $p_jpliuf!="" || $p_dmgf!="" || $p_kimia!="") + @endif
              @endif
              @if($p_dmg!="")
              {{$na_biodiv_pohon_dmg[$i]}} @if($haksenf!="" || $p_jpliuf!="" || $p_dmgf!="" || $p_kimia!="") + @endif
              @endif
              @if($haksenf!="")
              {{$na_biodiv_fauna[$i]}} @if($p_jpliuf!="" || $p_dmgf!="" || $p_kimia!="") + @endif
              @endif
              @if($p_jpliuf!="")
              {{$na_biodiv_fauna_jpliuf[$i]}} @if($p_dmgf!="" || $p_kimia!="") + @endif
              @endif
              @if($p_dmgf!="")
              {{$na_biodiv_fauna_dmgf[$i]}} @if($p_kimia!="") + @endif
              @endif
              @if($p_kimia!="")
              {{$na_cec[$i]}}
              @endif
              @if($jmlh_param>1) = {{$na_total[$i]}} @endif
            </td>
            <td style="text-align: center; vertical-align: middle">
              @if($nilai_skor[$i]=="Baik")<span class='label label-success'>O</span>@endif
              @if($nilai_skor[$i]=="Sedang")<span class='label label-warning'>O</span>@endif
              @if($nilai_skor[$i]=="Buruk")<span class='label label-danger'>O</span>@endif
            </td>
            <td style="text-align: center; vertical-align: middle">
              <form id="detail{{$i}}" method="post" class="" action="{{route('penilaian_kesehatan.detail')}}">
                {{csrf_field()}}
                <input type="hidden" id="pengukuran_ke" name="pengukuran_ke" value="{{$pengukuran_ke}}">
                <input type="hidden" id="id_klaster_plot" name="id_klaster_plot" value="{{$value->id_klaster_plot}}">
                <input type="hidden" id="p_lbds" name="p_lbds" value="{{$p_lbds}}">
                <input type="hidden" id="p_volume" name="p_volume" value="{{$p_volume}}">
                <input type="hidden" id="p_kerusakan" name="p_kerusakan" value="{{$p_kerusakan}}">
                <input type="hidden" id="p_ktjk" name="p_ktjk" value="{{$p_ktjk}}">
                <input type="hidden" id="p_kimia" name="p_kimia" value="{{$p_kimia}}">
                <input type="hidden" id="sifat-sifat_kimia" name="sifat-sifat_kimia" value="{{$sifat_kimia}}">
                <input type="hidden" id="p_fisik" name="p_fisik" value="{{$p_fisik}}">
                <input type="hidden" id="haksenp" name="haksenp" value="{{$haksenp}}">
                <input type="hidden" id="p_jpliu" name="p_jpliu" value="{{$p_jpliu}}">
                <input type="hidden" id="p_dmg" name="p_dmg" value="{{$p_dmg}}">
                <input type="hidden" id="haksenf" name="haksenf" value="{{$haksenf}}">
                <input type="hidden" id="p_jpliuf" name="p_jpliuf" value="{{$p_jpliuf}}">
                <input type="hidden" id="p_dmgf" name="p_dmgf" value="{{$p_dmgf}}">
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
  <!-- /.box-body -->
</div>

<!-- range skor keshut -->
<div class="box box-primary collapsed-box">
  <div class="box-header with-border">
    <h3 class="box-title"><b>Range Skor Kesehatan Hutan</b></h3>
    <div class="box-tools pull-right">
      <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
      <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
    </div>
  </div>
  <div class="box-body">
    <div class="table-responsive">
      <table id="range_kesehatan" class="table table-bordered table-striped">
        <thead>
          <tr>
            <th style="text-align: center; vertical-align: middle">Skor</th>
            <th style="text-align: center; vertical-align: middle">Min</th>
            <th style="text-align: center; vertical-align: middle">-</th>
            <th style="text-align: center; vertical-align: middle">Max</th>
            <th>Kondisi</th>
          </tr>
        </thead>
        <tbody>
          @for($i=1;$i<=3;$i++)
          <tr>
            <td style="text-align: center; vertical-align: middle">{{$i}}</td>
            <td style="text-align: center; vertical-align: middle">{{$range_nks_l[$i-1]}}</td>
            <td style="text-align: center; vertical-align: middle">-</td>
            <td style="text-align: center; vertical-align: middle">{{$range_nks_r[$i]}}</td>
            <td>
              @if($kondisi[$i-1]=="Baik") <span class="label label-success">O</span> @elseif($kondisi[$i-1]=="Sedang") <span class="label label-warning">O</span> @else <span class="label label-danger">O</span> @endif {{$kondisi[$i-1]}}
            </td>
          </tr>
          @endfor
        </tbody>
        <tfoot>

        </tfoot>
      </table>
    </div>
  </div>
</div>

<!-- nilai perhitungan -->
<div class="box">
  <div class="box-header with-border">
    <h3 class="box-title"><b>Nilai Perhitungan Kesehatan Hutan</b></h3>
    <div class="box-tools pull-right">
      <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
      <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
    </div>
  </div>
  <div class="box-body">
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
                <th>Kode <br> Klaster <br> Plot</th>
                @if($p_lbds!="")
                <th>Nilai LBDS <br> (NS X NT)</th>
                @endif
                @if($p_volume!="")
                <th>Nilai Volume <br> (NS X NT)</th>
                @endif
                @if($p_ktjk!="")
                <th>Nilai Kondisi Tajuk <br> (NS X NT)</th>
                @endif
                @if($p_kerusakan!="")
                <th>Nilai Kerusakan <br> (NS X NT)</th>
                @endif
                @if($haksenp!="")
                <th>Nilai H' Pohon <br> (NS X NT)</th>
                @endif
                @if($p_jpliu!="")
                <th>Nilai J' Pohon <br> (NS X NT)</th>
                @endif
                @if($p_dmg!="")
                <th>Nilai DMg Pohon <br> (NS X NT)</th>
                @endif
                @if($haksenf!="")
                <th>Nilai H' Fauna <br> (NS X NT)</th>
                @endif
                @if($p_jpliuf!="")
                <th>Nilai J' Fauna <br> (NS X NT)</th>
                @endif
                @if($p_dmgf!="")
                <th>Nilai DMg Fauna <br> (NS X NT)</th>
                @endif
                @if($p_kimia!="")
                <th>Nilai K.Tapak <br> (NS X NT)</th>
                @endif
              </tr>
            </thead>
            <tbody>
              @php($i=0) @foreach($id_klaster as $value)
              <tr>
                <td>{{$value->nama_klaster}}</td>
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
                <td>{{$skor_h_aksen[$i]}} x {{$nt_biodiv[$i]}} = {{$na_biodiv_pohon[$i]}}</td>
                @endif
                @if($p_jpliu!="")
                <td>{{$skor_j_pliu[$i]}} x {{$nt_biodiv[$i]}} = {{$na_biodiv_pohon_jpliu[$i]}}</td>
                @endif
                @if($p_dmg!="")
                <td>{{$skor_d_mg[$i]}} x {{$nt_biodiv[$i]}} = {{$na_biodiv_pohon_dmg[$i]}}</td>
                @endif
                @if($haksenf!="")
                <td>{{$skor_h_aksenf[$i]}} x {{$nt_biodivf[$i]}} = {{$na_biodiv_fauna[$i]}}</td>
                @endif
                @if($p_jpliuf!="")
                <td>{{$skor_j_pliuf[$i]}} x {{$nt_biodivf[$i]}} = {{$na_biodiv_fauna_jpliuf[$i]}}</td>
                @endif
                @if($p_dmgf!="")
                <td>{{$skor_d_mgf[$i]}} x {{$nt_biodivf[$i]}} = {{$na_biodiv_fauna_dmgf[$i]}}</td>
                @endif
                @if($p_kimia!="")
                <td>{{$skor_cec[$i]}} x {{$nt_ktpk[$i]}} = {{$na_cec[$i]}}</td>
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
                <th>Kode <br> Klaster <br> Plot</th>
                @if($p_lbds!="" || $p_volume!="")
                <th>Nilai Tertimbang Produktifitas</th>
                @endif
                @if($p_ktjk!="")
                <th>Nilai Tertimbang Kondisi Tajuk</th>
                @endif
                @if($p_kerusakan!="")
                <th>Nilai Tertimbang Kerusakan</th>
                @endif
                @if($haksenp!="")
                <th>Nilai Tertimbang Biodiversitas Pohon</th>
                @endif
                @if($haksenf!="")
                <th>Nilai Tertimbang Biodiversitas Fauna</th>
                @endif
                @if($p_kimia!="")
                <th>Nilai Tertimbang Kualitas Tapak ({{$parameter_sifat_kimia}})</th>
                @endif
              </tr>
            </thead>
            <tbody>
              @php ($i=0) @foreach($id_klaster as $value)
              <tr>
                <td>{{$value->nama_klaster}}</td>
                @if($p_lbds!="" || $p_volume!="")
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
                @if($haksenf!="")
                <td>{{$nt_biodivf[$i]}}</td>
                @endif
                @if($p_kimia!="")
                <td>{{$nt_ktpk[$i]}}</td>
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
                <th>Kode <br> Klaster <br> Plot</th>
                @if($p_lbds!="")
                <th>Nilai Skor Pertumbuhan <br> (LBDS)</th>
                @endif
                @if($p_volume!="")
                <th>Nilai Skor Pertumbuhan <br> (Volume)</th>
                @endif
                @if($p_ktjk!="")
                <th>Nilai Skor <br> Kondisi Tajuk (VCRc)</th>
                @endif
                @if($p_kerusakan!="")
                <th>Nilai Skor <br> Kerusakan (CLI)</th>
                @endif
                @if($haksenp!="")
                <th>Nilai Skor Biodiversitas <br>Pohon (H')</th>
                @endif
                @if($p_jpliu!="")
                <th>Nilai Skor Biodiversitas <br>Pohon (J')</th>
                @endif
                @if($p_dmg!="")
                <th>Nilai Skor Biodiversitas <br>Pohon (DMg)</th>
                @endif
                @if($haksenf!="")
                <th>Nilai Skor Biodiversitas <br>Fauna (H') </th>
                @endif
                @if($p_jpliuf!="")
                <th>Nilai Skor Biodiversitas <br>Fauna (J')</th>
                @endif
                @if($p_dmgf!="")
                <th>Nilai Skor Biodiversitas <br>Fauna (DMg)</th>
                @endif
                @if($p_kimia!="")
                <th>Nilai Skor <br> Kualitas Tapak ({{$parameter_sifat_kimia}})</th>
                @endif
              </tr>
            </thead>
            <tbody>
              @php($i=0) @foreach($id_klaster as $value)
              <tr>
                <td>{{$value->nama_klaster}}</td>
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
                <td>{{$skor_d_mg[$i]}}</td>
                @endif
                @if($haksenf!="")
                <td>{{$skor_h_aksenf[$i]}}</td>
                @endif
                @if($p_jpliuf!="")
                <td>{{$skor_j_pliuf[$i]}}</td>
                @endif
                @if($p_dmgf!="")
                <td>{{$skor_d_mgf[$i]}}</td>
                @endif
                @if($p_kimia!="")
                <td>{{$skor_cec[$i]}}</td>
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
                <th style="vertical-align: middle">Kode <br> Klaster <br> Plot</th>
                @if($p_lbds!="")
                <th style="vertical-align: middle">LBDS <br> (m<sup>2</sup>)</th>
                @endif
                @if($p_volume!="")
                <th style="vertical-align: middle">Volume <br> (m<sup>3</sup>)</th>
                @endif
                @if($p_ktjk!="")
                <th style="vertical-align: middle">VCRc</th>
                @endif
                @if($p_kerusakan!="")
                <th style="vertical-align: middle">CLI</th>
                @endif
                @if($haksenp!="")
                <th style="vertical-align: middle">H' <br> Pohon</th>
                @endif
                @if($p_jpliu!="")
                <th style="vertical-align: middle">J' <br> Pohon</th>
                @endif
                @if($p_dmg!="")
                <th style="vertical-align: middle">DMg <br> Pohon</th>
                @endif
                @if($haksenf!="")
                <th style="vertical-align: middle">H' <br> Fauna</th>
                @endif
                @if($p_jpliuf!="")
                <th style="vertical-align: middle">J' <br> Fauna</th>
                @endif
                @if($p_dmgf!="")
                <th style="vertical-align: middle">DMg <br> Fauna</th>
                @endif
                @if($p_kimia!="")
                <th style="vertical-align: middle">Kualitas <br> Tapak ({{$parameter_sifat_kimia}})</th>
                @endif

              </tr>
            </thead>
            <tbody>
              @php($i=0) @foreach($id_klaster as $value)
              <tr>
                <td>{{$value->nama_klaster}}</td>
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
                <td>{{$h_aksen_klaster[$i]}}</td>
                @endif
                @if($p_jpliu!="")
                <td>{{$j_pliu_klaster[$i]}}</td>
                @endif
                @if($p_dmg!="")
                <td>{{$d_mg[$i]}}</td>
                @endif
                @if($haksenf!="")
                <td>{{$h_aksenf[$i]}}</td>
                @endif
                @if($p_jpliuf!="")
                <td>{{$j_pliuf[$i]}}</td>
                @endif
                @if($p_dmgf!="")
                <td>{{$d_mgf[$i]}}</td>
                @endif
                @if($p_kimia!="")
                <td>{{$nilai_cec[$i]}}</td>
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
        <table id="Nilai_Tertimbang" class="table table-bordered table-striped">
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
          <tfoot></tfoot>
        </table>
      </div>
    </div>
    @endif

    @if($p_volume!="")
    <div class="col-md-3">
      <h4 style="text-align:center">Range Pertumbuhan Pohon <br>(Volume)</h4>
      <div class="col-xs-12 table-responsive">
        <table id="Nilai_Tertimbang" class="table table-bordered table-striped">
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
      <h4 style="text-align:center">Range Kondisi Tajuk Pohon <br> (VCRc)</h4>
      <div class="col-xs-12 table-responsive">
        <table id="Nilai_Tertimbang" class="table table-bordered table-striped">
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
      <h4 style="text-align:center">Range Kerusakan Pohon <br> (CLI)</h4>
      <div class="col-xs-12 table-responsive">
        <table id="Nilai_Tertimbang" class="table table-bordered table-striped">
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
        <table id="Nilai_Tertimbang" class="table table-bordered table-striped">
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

    @if($p_jpliu!="")
    <div class="col-md-3">
      <h4 style="text-align:center">Range Biodiversitas Pohon <br> (J')</h4>
      <div class="col-xs-12 table-responsive">
        <table id="Nilai_Tertimbang" class="table table-bordered table-striped">
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

    @if($p_dmg!="")
    <div class="col-md-3">
      <h4 style="text-align:center">Range Biodiversitas Pohon <br> (DMg)</h4>
      <div class="col-xs-12 table-responsive">
        <table id="Nilai_Tertimbang" class="table table-bordered table-striped">
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
              <td>{{$range_d_mg_l[$i-1]}}</td>
              <td>-</td>
              <td>{{$range_d_mg_r[$i]}}</td>
            </tr>
            @endfor
          </tbody>
          <tfoot></tfoot>
        </table>
      </div>
    </div>
    @endif

    @if($haksenf!="")
    <div class="col-md-3">
      <h4 style="text-align:center">Range Biodiversitas Fauna <br> (H')</h4>
      <div class="col-xs-12 table-responsive">
        <table id="Nilai_Tertimbang" class="table table-bordered table-striped">
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
              <td>{{$range_h_aksen_lf[$i-1]}}</td>
              <td>-</td>
              <td>{{$range_h_aksen_rf[$i]}}</td>
            </tr>
            @endfor
          </tbody>
          <tfoot></tfoot>
        </table>
      </div>
    </div>
    @endif

    @if($p_jpliuf!="")
    <div class="col-md-3">
      <h4 style="text-align:center">Range Biodiversitas Fauna <br> (J')</h4>
      <div class="col-xs-12 table-responsive">
        <table id="Nilai_Tertimbang" class="table table-bordered table-striped">
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
              <td>{{$range_j_pliu_lf[$i-1]}}</td>
              <td>-</td>
              <td>{{$range_j_pliu_rf[$i]}}</td>
            </tr>
            @endfor
          </tbody>
          <tfoot></tfoot>
        </table>
      </div>
    </div>
    @endif

    @if($p_dmgf!="")
    <div class="col-md-3">
      <h4 style="text-align:center">Range Biodiversitas Fauna <br> (DMg)</h4>
      <div class="col-xs-12 table-responsive">
        <table id="Nilai_Tertimbang" class="table table-bordered table-striped">
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
              <td>{{$range_d_mg_lf[$i-1]}}</td>
              <td>-</td>
              <td>{{$range_d_mg_rf[$i]}}</td>
            </tr>
            @endfor
          </tbody>
          <tfoot></tfoot>
        </table>
      </div>
    </div>
    @endif

    @if($p_kimia!="")
    <div class="col-md-3">
      <h4 style="text-align:center">Range Kualitas Tapak <br> ({{$parameter_sifat_kimia}})</h4>
      <div class="col-xs-12 table-responsive">
        <table id="Nilai_Tertimbang" class="table table-bordered table-striped">
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
              <td>{{$range_cec_l[$i-1]}}</td>
              <td>-</td>
              <td>{{$range_cec_r[$i]}}</td>
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
<script src="{{ asset ('js/chart.min.js') }}"></script>
<script src="{{ asset ('js/Chart.js') }}"></script>
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
<?php if($jumlah_penilaian>1){ ?>
var densityCanvas = document.getElementById("densityChart");
Chart.defaults.global.legend.display = false;
Chart.defaults.global.defaultFontFamily = "Lato";
Chart.defaults.global.defaultFontSize = 18;

// array untuk menampung nilai akhir
var skor_akhir=[];

<?php
for ($i=0;$i<count($na_total);$i++){
?>
skor_akhir[{{ $i }}]={{ $na_total[$i] }}
<?php
}?>

// untuk memberikan tambahan tinggi grafik
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

// array untuk menyimpan warna merah kuning hijau
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
    labels: [@foreach($id_klaster as $value)
      "{{$value->nama_klaster}}",
    @endforeach],
    datasets: [densityData],
    options: options,
  }
});
<?php } ?>

// untuk menyimpan citra satelite
var satelite = L.tileLayer('http://{s}.google.com/vt/lyrs=s,h&x={x}&y={y}&z={z}',{
    maxZoom: 20,
    subdomains:['mt0','mt1','mt2','mt3']});

// untuk citra osm
var OpenStreetMap_Mapnik = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
maxZoom: 19,
attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
});

// untuk citra gmaps
var gmaps = L.tileLayer('http://{s}.google.com/vt/lyrs=m&x={x}&y={y}&z={z}',{
    maxZoom: 20,
    subdomains:['mt0','mt1','mt2','mt3']});

// menampilkan peta osm
var mymap = L.map('mapid',{
  scrollWheelZoom:false,
  layers: [OpenStreetMap_Mapnik]});

// koordinat peta indo
var mapIndonesia = [
[5.528511, 95.20752],
[-8.754795, 103.271484],
[-11.092166, 141.240234],
[6.315299, 142.910156]
];
mymap.fitBounds(mapIndonesia);

// layer
var baseMaps = {
    "OSM": OpenStreetMap_Mapnik,
    "Google Maps" : gmaps,
    "Satelite": satelite
};

L.control.layers(baseMaps).addTo(mymap);

var bounds= Array();

$(document).ready(function(){
  @foreach($id_klaster as $value)
    koordinatLintang ="{{$value->lintang_klaster}}";
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

    koordinatBujur = "{{$value->bujur_klaster}}";
    split_bujur = koordinatBujur.split(' ');
    splitName_p = split_bujur[0];
    splitName2_p= split_bujur[1];
    splitName3_p= split_bujur[2];
    menit_b = splitName2_p/60;
    detik_b = splitName3_p/3600;

    if(splitName_p<0){
      koordinat_bujur_angka_klaster = parseFloat(splitName_p) - parseFloat(menit_b) - parseFloat(detik_b);
      ketBujur = " BB";
    }
    else{
      koordinat_bujur_angka_klaster = parseFloat(splitName_p) + parseFloat(menit_b) + parseFloat(detik_b);
      ketBujur = " BT";
    }
    marker = L.marker([koordinat_lintang_angka_klaster, koordinat_bujur_angka_klaster]).addTo(mymap);
    bounds.push(marker.getLatLng());
    marker.bindPopup("{{$value->nama_klaster}} <br/> Koordinat: " +
                      Math.abs(l_splitName_p) + " ᴼ " + l_splitName2_p + " ' " + l_splitName3_p + " \" "
                       + ketLintang + ", " + Math.abs(splitName_p) +
                        " ᴼ " + splitName2_p + " ' " + splitName3_p + " \" " + ketBujur);
  @endforeach
  mymap.fitBounds(bounds);
});

</script>
  @section('script_table')
   $(function () {
     var table = $('#nilai_kesehatan').DataTable({
       'responsive'  : true,
       'paging'      : true,
       'lengthChange': true,
       'searching'   : false,
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

     var table_indikator =$('#Nilai_Indikator').DataTable({
       'responsive'  : true,
       'paging'      : true,
       'lengthChange': true,
       'searching'   : true,
       'ordering'      :true,
       'info'        : true,
       'autoWidth'   : false,
       'bStateSave'  : true,
       'buttons'     : [ {extend: 'excel', text: 'export to excel'}],
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
   @endsection
@endsection
