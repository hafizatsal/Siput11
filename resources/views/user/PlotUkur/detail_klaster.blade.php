@extends('layouts.layout')
@section('title','Halaman Klaster')
@section('active_plot_ukur','active')
@section('active_klaster','active')
@section('judul_halaman','Halaman Detail Klaster')
@section('css')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.4.0/dist/leaflet.css"
   integrity="sha512-puBpdR0798OZvTTbP4A8Ix/l+A4dHDD0DGqYW6RQ+9jxkRFclaxxQb/SJAWZfWAkuyeQUytO7+7N4QKrDh+drA=="
   crossorigin=""/>

   <!-- Make sure you put this AFTER Leaflet's CSS -->
@endsection
<style>
#mapid { height: 700px; }
</style>
@section('breadcrumb')
<li><a href="{{route('user.data_klaster')}}">Data Klaster</a></li>
<li><a href="{{route('user.klaster_plot',encrypt($id_data_klaster2))}}">Data Klaster Plot</a></li>
<li><a href="#">Detail Klaster</a></li>
@endsection
@section('main_section')
<!-- page content -->
<div class="row">
  <div class="col-md-4">
      <h4>Detail Klaster Plot &nbsp</h4>
    <div class="box">
      <div class="box-header">
      </div>
      <!-- /.box-header -->
      <div class="box-body">
        <table id="" class="table table-striped">
          <thead>
            <input type="hidden" id="id_cl" name="id_cl" value="{{$data->id_klaster_plot}}">
          </thead>
          <tbody>
            <tr>
              <td>Kode Klaster</td>
              <td> :</td>
              <td>{{$data->nama_klaster}}</td>
            </tr>
            <tr>
              <td>Tipe Hutan</td>
              <td> :</td>
              <td>{{$data->tipe_hutan}}</td>
            </tr>
            <tr>
              <td>Fungsi Hutan</td>
              <td> :</td>
              <td>{{$data->fungsi}}</td>
            </tr>
            <tr>
              <td>Jenis Tanaman</td>
              <td> :</td>
              <td>{{$data->jenis_tanaman}}</td>
            </tr>
            <tr>
              <td>Provinsi</td>
              <td> :</td>
              <td>{{$data->nama_provinsi}}</td>
            </tr>
            <tr>
                <td>Kabupaten</td>
                <td> :</td>
                <td>{{$data->nama_kabupaten}}</td>
            </tr>
            <tr>
                <td>Kecamatan</td>
                <td> :</td>
                <td>{{$data->nama_kecamatan}}</td>
            </tr>
            <tr>
                <td>Desa</td>
                <td> :</td>
                <td>{{$data->nama_desa}}</td>
            </tr>
            <tr>
                <td>Titik Koordinat</td>
                <td> </td>
                <td></td>
            </tr>
            <tr>
                <td>Lintang</td>
                <td> : </td>
                <td>{{$koor_ls_ful_p}} {{$ket_lintang_p}}</td>
            </tr>
            <tr>
                <td>Bujur</td>
                <td> : </td>
                <td>{{$koor_bt_ful_p}} {{$ket_bujur_p}}</td>
            </tr>
            <tr>
                <td>Altitude</td>
                <td> : </td>
                <td>{{$data->altitude}} m dpl</td>
            </tr>
            <tr>
              <td>Tahun Tanam / Umur</td>
              <td> :</td>
              <td>{{$data->tahun_tanam}} / {{$data->usia}}</td>
            </tr>
            <tr>
              <td>Luas</td>
              <td> :</td>
              <td>{{$data->luas}} Ha</td>
            </tr>
            <tr>
                <td>Nama Pengelola</td>
                <td> :</td>
                <td>{{$data->pengelola}}</td>
            </tr>
            <tr>
                <td>Jarak Tanam</td>
                <td> :</td>
                <td>{{$data->jarak_tanam_x}} X {{$data->jarak_tanam_y}} m</td>
            </tr>
            <tr>
                <td>Pola Tanam</td>
                <td> : </td>
                <td>{{$data->nama_pola}}</td>
            </tr>
            <tr>
              <td colspan="3">Titik Ikat Klaster Plot Ukur</td>
            </tr>
            <tr>
                <td>Nama Titik Ikat</td>
                <td> : </td>
                <td>{{$data->nama_titik_ikat}}</td>
            </tr>
            <tr>
              <td>Azimuth</td>
              <td> : </td>
              <td>{{$data->azimuth}} ᴼ</td>
            </tr>
            <tr>
              <td>Jarak</td>
              <td> : </td>
              <td>{{$data->jarak_ke_titik_ikat}} m</td>
            </tr>
            <tr>
              <td>Koordinat</td>
              <td>  </td>
              <td>  </td>
            </tr>
            <tr>
              <td>Lintang</td>
              <td> : </td>
              <td>{{$koor_ls_ful_p_ikat}} {{$ket_lintang_p_ikat}}</td>
            </tr>
            <tr>
                <td>Bujur</td>
                <td> : </td>
                <td>{{$koor_bt_ful_p_ikat}} {{$ket_bujur_p_ikat}}</td>
            </tr>
          </tbody>
          <tfoot>

          </tfoot>
        </table>
      </div>
      <!-- /.box-body -->
    </div>
    <!-- /.box -->
  </div>
  <!-- /.col -->

  <div class="col-md-8">
      <h4> Koordinat Titik Pusat Klaster Plot</h4>
    <div class="box">
      <div class="box-header">
      </div>
      <!-- /.box-header -->
      <div class="box-body">
        <div class="col-xs-12 table-responsive">
        <table id="detail_pengukuran" class="table table-striped">
          <thead>
            <th style="text-align: center; vertical-align: middle">Nomor</th>
            <th style="text-align: center; vertical-align: middle">Nama Plot</th>
            <th style="text-align: center; vertical-align: middle">Koordinat</th>
            <th style="text-align: center; vertical-align: middle">Aksi</th>
          </thead>
          <tbody>
      @php ($id=0) @foreach($plot as $p)
            <tr>
              <td style="text-align: center; vertical-align: middle">{{$id+1}}.</td>
              <td style="text-align: center; vertical-align: middle">{{$p->nama_plot}}</td>
              <td style="text-align: center; vertical-align: middle">{{$koor_ls_ful[$id]}} {{$ket_lintang[$id]}} || {{$koor_bt_ful[$id]}} {{$ket_bujur[$id]}}</td>

              <td style="text-align: center; vertical-align: middle">
                @if($ijin==Auth::user()->id)
                <a class="btn btn-warning btn-md" data-plotid={{$p->id_plot}} data-nama_plot="{{$p->nama_plot}}" data-koorlintang="{{$lintang_masked[$id]}}" data-koorbujur="{{$bujur_masked[$id]}}" data-toggle="modal" data-target="#edit-plot" href="#"><i class="fa fa-edit"></i></a>
                @endif
                <a class="btn btn-success btn-md" href="{{ route('user.lihat_plot', encrypt($p->id_plot))}}"><i class="fa fa-bar-chart-o"></i></a>
              </td>
            </tr>
            @php($id++)
            @endforeach
          </tbody>
          <tfoot>

          </tfoot>
        </table>
      </div>
      </div>
      <!-- /.box-body -->
    </div>
    <!-- /.box -->
  </div>

  <div class="col-md-8">
    <div class="box box-success">
    <div class="box-header with-border">
      <h3 class="box-title">Lokasi Klaster</h3>
        <div class="box-tools pull-right">
          <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
          </button>
          </div>
    </div>

    <div id="mapid" class="box-body chart-responsive">

    </div>
    </div>
    <!-- /.box-body -->
  </div>
  <!-- /.box -->

</div>

<div class="row">
    <!-- Div Photo Dokumentasi -->
    <!-- <div class="col-md-12">
    <h2>Photo Dokumentasi <small> Opsional </small>
      <a class="btn btn-primary pull-right" id="btn-up-foto"><i class="glyphicon glyphicon-camera"></i></a>
    </h2>
    <div class="row"></div>
    <div class="box">
      <div class="thumbnail">
        <div class="image view view-first">
          <img style="width: 100%; height: 100%;display: block;" src="" alt="image">
          <div class="mask">
            <p></p>
            <div class="tools tools-bottom">
              <a href="#"><i class="fa fa-link"></i></a>
              <a href="#"><i class="fa fa-pencil"></i></a>
              <a href="#"><i class="fa fa-times"></i></a>
            </div>
          </div>
        </div>
        <div class="caption">
          <p></p>
        </div>
      </div>

    </div>
    <h2>Foto Belum ada silahkan Tambah Foto</h2>
    </div> -->

<!-- <div class="col-md-12">
      <div class="box">
    <div class="timeline-item">
  <div class="col-md-12">
  <h3 class="timeline-header"><a href="#">Gallery</h3>
  </div>
  <div class="timeline-body"> -->
    <!-- <img src="https://png.icons8.com/color/1600/circled-user-male-skin-type-1-2.png/150x100" alt="..." class="margin"> -->
    <!-- <img src="http://placehold.it/150x100" alt="..." class="margin">
    <img src="http://placehold.it/150x100" alt="..." class="margin">
    <img src="http://placehold.it/150x100" alt="..." class="margin">
  </div>
</div>
</div>
</div> -->

</div>

<script src="{{asset('Admin/modal_ajax.min.js')}}"></script>
<script src="{{asset('Admin/bower_components/jquery/dist/jquery.min.js')}}"></script>
  @include('user.include.detail_klaster_plot.modal-edit-plot')

  @section('data_table')
  <!-- DataTables -->
  <script src="{{asset('Admin/bower_components/datatables.net/js/jquery.dataTables.min.js')}}"></script>
  <script src="{{asset('Admin/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js')}}"></script>
  @endsection
  <script src="https://unpkg.com/leaflet@1.4.0/dist/leaflet.js"
    integrity="sha512-QVftwZFqvtRNi0ZyCtsznlKSWOStnDORoefr1enyq5mVL4tmKB3S/EnC3rRJcxCPavG10IcrVGSmPh6Qw5lwrg=="
    crossorigin=""></script>
  <script>
  var PointIcon = L.Icon.extend({
      options: {
          iconSize:     [40, 40],
          iconAnchor:   [20, 45],
          popupAnchor:  [0, -38]
      }
  });
  var Plot1 =new PointIcon({iconUrl: 'https://cdn0.iconfinder.com/data/icons/small-n-flat/24/678111-map-marker-512.png'});
  var polyline = Array();
  var latlngs = Array();
  var maker1;
  var maker2;
  var maker3;
  var maker4;

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
  layers: [OpenStreetMap_Mapnik]
}).setView([{{$koordinat_lintang_angka_klaster}}, {{$koordinat_bujur_angka_klaster}}], 10);
// var mymap = L.map('mapid');

var baseMaps = {
    "OSM": OpenStreetMap_Mapnik,
    "Google Maps" : gmaps,
    "Satelite": satelite
};

L.control.layers(baseMaps).addTo(mymap);

var marker;
var bounds = Array();
@for($i=0;$i<4;$i++)
@if($koor_lintang_plot[$i]!=0 && $koor_bujur_plot[$i]!=0)
  @if($i%4==0)
  marker1 = L.marker([{{$koor_lintang_plot[$i]}}, {{$koor_bujur_plot[$i]}}], {icon: Plot1}).addTo(mymap);
  latlngs.push(marker1.getLatLng());
  bounds.push(marker1.getLatLng());
  marker1.bindPopup("<b>{{$plot[$i]->nama_plot}}</b>");
  L.circle([{{$koor_lintang_plot[$i]}}, {{$koor_bujur_plot[$i]}}], {radius: 17.95}).addTo(mymap);
  L.circle([{{$koor_lintang_plot[$i]}}, {{$koor_bujur_plot[$i]}}], {radius: 7.32, fillColor: 'green', color: 'green'}).addTo(mymap);

  @elseif($i%4==1)
  marker2 = L.marker([{{$koor_lintang_plot[$i]}}, {{$koor_bujur_plot[$i]}}]).addTo(mymap);
  latlngs.push(marker1.getLatLng());
  latlngs.push(marker2.getLatLng());
  bounds.push(marker2.getLatLng());
  marker2.bindPopup("<b>{{$plot[$i]->nama_plot}}</b>");
  L.circle([{{$koor_lintang_plot[$i]}}, {{$koor_bujur_plot[$i]}}], {radius: 17.95}).addTo(mymap);
  L.circle([{{$koor_lintang_plot[$i]}}, {{$koor_bujur_plot[$i]}}], {radius: 7.32, fillColor: 'green', color: 'green'}).addTo(mymap);

  @elseif($i%4==2)
  marker3 = L.marker([{{$koor_lintang_plot[$i]}}, {{$koor_bujur_plot[$i]}}]).addTo(mymap);
  latlngs.push(marker1.getLatLng());
  latlngs.push(marker3.getLatLng());
  bounds.push(marker3.getLatLng());
  marker3.bindPopup("<b>{{$plot[$i]->nama_plot}}</b>");
  L.circle([{{$koor_lintang_plot[$i]}}, {{$koor_bujur_plot[$i]}}], {radius: 17.95}).addTo(mymap);
  L.circle([{{$koor_lintang_plot[$i]}}, {{$koor_bujur_plot[$i]}}], {radius: 7.32, fillColor: 'green', color: 'green'}).addTo(mymap);

  @else
  marker4 = L.marker([{{$koor_lintang_plot[$i]}}, {{$koor_bujur_plot[$i]}}]).addTo(mymap);
  latlngs.push(marker1.getLatLng());
  latlngs.push(marker4.getLatLng());
  bounds.push(marker4.getLatLng());
  marker4.bindPopup("<b>{{$plot[$i]->nama_plot}}</b>");
  L.circle([{{$koor_lintang_plot[$i]}}, {{$koor_bujur_plot[$i]}}], {radius: 17.95}).addTo(mymap);
  L.circle([{{$koor_lintang_plot[$i]}}, {{$koor_bujur_plot[$i]}}], {radius: 7.32, fillColor: 'green', color: 'green'}).addTo(mymap);

  @endif
@endif
@endfor
polyline = L.polyline(latlngs, {color: 'red'}).addTo(mymap);
mymap.fitBounds(bounds);
  </script>

  <!-- jquery untuk mengatur datatable -->
   @section('script_table')
    <script>
   $(function () {
     $('#biodiv_shannon_wiener').DataTable({
       'paging'      : true,
       'lengthChange': true,
       'searching'   : true,
       'ordering'    : false,
       'info'        : true,
       'autoWidth'   : false,
       'lengthMenu'  : [[5,10,20],[5,10,20]]
     })
   })

   $(function () {
     $('#biodiv_shannon_wiener_fauna').DataTable({
       'paging'      : true,
       'lengthChange': true,
       'searching'   : true,
       'ordering'    : false,
       'info'        : true,
       'autoWidth'   : false,
       'lengthMenu'  : [[5,10,20],[5,10,20]]
     })
   })
    </script>
   @endsection

@endsection
