@extends('layouts.layoutauditor')
@section('title','Halaman Utama')
@section('active_home','active')
@section('judul_halaman','Halaman Utama')
@section('breadcrumb')
<li><a href="#">Home</a></li>
@endsection
@section('css')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.4.0/dist/leaflet.css"
   integrity="sha512-puBpdR0798OZvTTbP4A8Ix/l+A4dHDD0DGqYW6RQ+9jxkRFclaxxQb/SJAWZfWAkuyeQUytO7+7N4QKrDh+drA=="
   crossorigin=""/>
   <link rel="stylesheet" href="https://unpkg.com/esri-leaflet-geocoder@2.2.13/dist/esri-leaflet-geocoder.css"
    integrity="sha512-v5YmWLm8KqAAmg5808pETiccEohtt8rPVMGQ1jA6jqkWVydV5Cuz3nJ9fQ7ittSxvuqsvI9RSGfVoKPaAJZ/AQ=="
    crossorigin="">
<link rel="stylesheet" href="{{asset('cluster_marker/dist/MarkerCluster.css')}}">
<link rel="stylesheet" href="{{asset('cluster_marker/dist/MarkerCluster.Default.css')}}">

   <!-- Make sure you put this AFTER Leaflet's CSS -->
@endsection
<style>
#mapid { height: 500px; }
</style>
@section('main_section')

<div class="row">
   <div class="col-xs-12">
     <div class="box box-primary animated fadeIn">
       <div class="box-header with-border">
         <h3 class="box-title"><b>Selamat datang, {{Auth::user()->nama}} .</b></h3>
         <div class="box-tools pull-right">
           <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
           </button>
         </div>
       </div>
        <div class="box-body">
          <p class="pengumuman_1">{!! $pengumuman[0]->isi_pengumuman !!}</p>

          <br/>
          <!-- <marquee behavior="scroll" direction="right" scrollamount="1"> -->
          <center><img src="{{asset('img/Siput.png')}}" alt="Siput" class=" responsive"></center>
          <!-- </marquee> -->
          <br/>
          <p>Berikut ini adalah beberapa file yang dibutuhkan untuk dapat menggunakan Sistem Informasi Penilaian Kesehatan Hutan.</p>
          <p><span class="fa fa-fw fa-book"></span> Panduan penggunaan SIPUT dapat di unduh <a href="{{route('auditor.download_panduan_siput')}}">disini</a>.</p>
          <p><span class="fa fa-fw fa-file-pdf-o"></span> Panduan <i>import</i> data pengukuran kesehatan hutan dapat di unduh <a href="{{route('auditor.download_panduan_import')}}">disini</a>.</p>
          <p><span class="fa fa-fw fa-file-word-o"></span> Format <i>Tally Sheet </i> Klaster Plot untuk pengukuran kesehatan hutan dapat di unduh <a href="{{route('auditor.download_template_tally_sheet_word')}}">disini</a>.</p>
          <p><span class="fa fa-fw fa-file-excel-o"></span> Format <i>Tally Sheet </i> Klaster Plot untuk <i>import</i> data pengukuran kesehatan hutan dapat di unduh <a href="{{route('auditor.download_template_tally_sheet_excel')}}">disini</a>.</p>

            <p>{!! $pengumuman[1]->isi_pengumuman !!}</p>

            <marquee direction="left"><p style="color: red;">Jika ada masalah dengan sistem, mohon hubungi administrator (<b>siputunila@gmail.com</b>).</p></marquee>
        </div>
      </div>
    </div>
</div>

<div class="row">
  <div class="col-md-12">
    <div class="box box-success animated fadeIn">
    <div class="box-header with-border">
      <h3 class="box-title"><b>Lokasi Klaster Plot Penilaian dan atau Pemantauan Kesehatan Hutan</h3></b>
    </div>

    <div id="mapid" class="box-body chart-responsive">

    </div>
    </div>
    <!-- /.box-body -->
  </div>
</div>

<script src="https://unpkg.com/leaflet@1.4.0/dist/leaflet.js"
  integrity="sha512-QVftwZFqvtRNi0ZyCtsznlKSWOStnDORoefr1enyq5mVL4tmKB3S/EnC3rRJcxCPavG10IcrVGSmPh6Qw5lwrg=="
  crossorigin=""></script>
  <script src="https://unpkg.com/esri-leaflet@2.2.4/dist/esri-leaflet.js"
    integrity="sha512-tyPum7h2h36X52O2gz+Pe8z/3l+Y9S1yEUscbVs5r5aEY5dFmP1WWRY/WLLElnFHa+k1JBQZSCDGwEAnm2IxAQ=="
    crossorigin=""></script>
  <script src="https://unpkg.com/esri-leaflet-geocoder@2.2.13/dist/esri-leaflet-geocoder.js"
    integrity="sha512-zdT4Pc2tIrc6uoYly2Wp8jh6EPEWaveqqD3sT0lf5yei19BC1WulGuh5CesB0ldBKZieKGD7Qyf/G0jdSe016A=="
    crossorigin=""></script>
  <script src="{{asset('cluster_marker/dist/leaflet.markercluster.js')}}"></script>
  <script src="{{asset('Admin/modal_ajax.min.js')}}"></script>
<script>

// var mymap = L.map('mapid',{scrollWheelZoom:false}).setView([-3.864255, 122.167969], 4);
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
});

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

$(document).ready(function(){
var PointIcon = L.Icon.extend({
    options: {
        iconSize:     [40, 40],
        iconAnchor:   [20, 40],
        popupAnchor:  [0, -38]
    }
});

var markers = L.markerClusterGroup();


var Plot1 =new PointIcon({iconUrl: 'https://cdn0.iconfinder.com/data/icons/small-n-flat/24/678111-map-marker-512.png'});
var marker="";
var maker1;
var maker2;
var maker3;
var maker4;
@php($l=0)
@php($m=0)
var latlngs = Array();
var multilatlng = new Array();
var polyline = Array();
@php($n=0)
var o=0;
var n=0;
$.ajax({
    type: 'get',
    url: '{{route("auditor.koordinat_home")}}',
    data: {
      '_token': $('input[name=_token]').val(),
      'id': 1,
    },
    success: function (data) {
      if (data.length > 0) {
        $.each(data, function (key, value) {

            if(n%4==0){
              marker1= L.marker([value['lintang'], value['bujur']], {icon: Plot1});
              markers.addLayer(marker1).addTo(mymap);
               marker1.bindPopup("<div class='row'>" +
                                  "<div class='col-md-12'>" +
                                  "<div class='nav-tabs-custom'>" +
                                  "<ul class='nav nav-tabs'>" +
                                  "<li class='active'><a href='#tab_1' data-toggle='tab'>Pengukuran ke 1</a></li>" +
                                  "<li><a href='#tab_2' data-toggle='tab'>Pengukuran ke 2</a></li>" +
                                  "<li><a href='#tab_3' data-toggle='tab'>Pengukuran ke 3</a></li>" +
                                  "</ul>" +
                                  "<div class='tab-content'>" +
                                    "<div class='tab-pane fade in active' id='tab_1'>" +
                                    "<p><b>Identitas Plot Ukur</b></p>" +
                                    "Klaster: " + value['nama_klaster'] + ", " + value['nama_plot'] +
                                    "<br/> Kategori: " + value['kategori'] +
                                    "<br/> Tanggal Pengukuran: " + value['tahun_pengukuran'] +
                                    "<br/> Nama Pengukur: " + value['nama_pengukur'] +
                                    "<br/> Koordinat: " + value['lintangFull'] +
                                    ", " + value['bujurFull'] +
                                    "<br/> <br/> Parameter Kesehatan Hutan: " +
                                    "<br/> LBDS: " + value['lbds'] +
                                    "&emsp;&emsp; Volume: " + value['volume'] +
                                    "<br/> VCR: " + value['vcr'] +
                                    "&emsp;&emsp;&nbsp;&nbsp; PLI: " + value['pli'] +
                                    "<br/> <br/> Biodiversitas Pohon: " + "&emsp;&emsp; Biodiversitas Fauna: " +
                                    "<br/> H': " + value['haksen'] + "&nbsp;&nbsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp; H': " + value['haksenf'] +
                                    "<br/> J': " + value['jpliu'] + "&nbsp;&nbsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp; J': " + value['jpliuf'] +
                                    "</div>" +
                                    "<div class='tab-pane fade' id='tab_2'>" +
                                    "<p><b>Identitas Plot Ukur</b></p>" +
                                    "Klaster: " + value['nama_klaster'] + ", " + value['nama_plot'] +
                                    "<br/> Kategori: " + value['kategori'] +
                                    "<br/> Tanggal Pengukuran: " + value['tahun_pengukuran2'] +
                                    "<br/> Nama Pengukur: " + value['nama_pengukur2'] +
                                    "<br/> Koordinat: " + value['lintangFull'] +
                                    ", " + value['bujurFull'] +
                                    "<br/> <br/> Parameter Kesehatan Hutan: " +
                                    "<br/> LBDS: " + value['lbds2'] +
                                    "&emsp;&emsp; Volume: " + value['volume2'] +
                                    "<br/> VCR: " + value['vcr2'] +
                                    "&emsp;&emsp;&nbsp;&nbsp; PLI: " + value['pli2'] +
                                    "<br/> <br/> Biodiversitas Pohon: " + "&emsp;&emsp; Biodiversitas Fauna: " +
                                    "<br/> H': " + value['haksen2'] + "&nbsp;&nbsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp; H': " + value['haksenf2'] +
                                    "<br/> J': " + value['jpliu2'] + "&nbsp;&nbsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp; J': " + value['jpliuf2'] +
                                    "</div>" +
                                    "<div class='tab-pane fade' id='tab_3'>" +
                                    "<p><b>Identitas Plot Ukur</b></p>" +
                                    "Klaster: " + value['nama_klaster'] + ", " + value['nama_plot'] +
                                    "<br/> Kategori: " + value['kategori'] +
                                    "<br/> Tanggal Pengukuran: " + value['tahun_pengukuran3'] +
                                    "<br/> Nama Pengukur: " + value['nama_pengukur3'] +
                                    "<br/> Koordinat: " + value['lintangFull'] +
                                    ", " + value['bujurFull'] +
                                    "<br/> <br/> Parameter Kesehatan Hutan: " +
                                    "<br/> LBDS: " + value['lbds3'] +
                                    "&emsp;&emsp; Volume: " + value['volume3'] +
                                    "<br/> VCR: " + value['vcr3'] +
                                    "&emsp;&emsp;&nbsp;&nbsp; PLI: " + value['pli3'] +
                                    "<br/> <br/> Biodiversitas Pohon: " + "&emsp;&emsp; Biodiversitas Fauna: " +
                                    "<br/> H': " + value['haksen3'] + "&nbsp;&nbsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp; H': " + value['haksenf3'] +
                                    "<br/> J': " + value['jpliu3'] + "&nbsp;&nbsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp; J': " + value['jpliuf3'] +
                                  "</div>" +
                                " </div>" +
                                "</div>" +
                              "</div>" +
                              "</div>",{minWidth: 450, closeOnClick: true});

               L.circle([value['lintang'], value['bujur']], {radius: 17.95}).addTo(mymap);
               L.circle([value['lintang'], value['bujur']], {radius: 7.32, fillColor: 'green', color: 'green'}).addTo(mymap);

                latlngs.push(marker1.getLatLng());
            }
            else if(n%4==1){
              marker2= L.marker([value['lintang'], value['bujur']]);
              markers.addLayer(marker2).addTo(mymap);
               marker2.bindPopup("<div class='row'>" +
                                  "<div class='col-md-12'>" +
                                  "<div class='nav-tabs-custom'>" +
                                  "<ul class='nav nav-tabs'>" +
                                  "<li class='active'><a href='#tab_1' data-toggle='tab'>Pengukuran ke 1</a></li>" +
                                  "<li><a href='#tab_2' data-toggle='tab'>Pengukuran ke 2</a></li>" +
                                  "<li><a href='#tab_3' data-toggle='tab'>Pengukuran ke 3</a></li>" +
                                  "</ul>" +
                                  "<div class='tab-content'>" +
                                    "<div class='tab-pane fade in active' id='tab_1'>" +
                                    "<p><b>Identitas Plot Ukur</b></p>" +
                                    "Klaster: " + value['nama_klaster'] + ", " + value['nama_plot'] +
                                    "<br/> Kategori: " + value['kategori'] +
                                    "<br/> Tanggal Pengukuran: " + value['tahun_pengukuran'] +
                                    "<br/> Nama Pengukur: " + value['nama_pengukur'] +
                                    "<br/> Koordinat: " + value['lintangFull'] +
                                    ", " + value['bujurFull'] +
                                    "<br/> <br/> Parameter Kesehatan Hutan: " +
                                    "<br/> LBDS: " + value['lbds'] +
                                    "&emsp;&emsp; Volume: " + value['volume'] +
                                    "<br/> VCR: " + value['vcr'] +
                                    "&emsp;&emsp;&nbsp;&nbsp; PLI: " + value['pli'] +
                                    "<br/> <br/> Biodiversitas Pohon: " + "&emsp;&emsp; Biodiversitas Fauna: " +
                                    "<br/> H': " + value['haksen'] + "&nbsp;&nbsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp; H': " + value['haksenf'] +
                                    "<br/> J': " + value['jpliu'] + "&nbsp;&nbsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp; J': " + value['jpliuf'] +
                                    "</div>" +
                                    "<div class='tab-pane fade' id='tab_2'>" +
                                    "<p><b>Identitas Plot Ukur</b></p>" +
                                    "Klaster: " + value['nama_klaster'] + ", " + value['nama_plot'] +
                                    "<br/> Kategori: " + value['kategori'] +
                                    "<br/> Tanggal Pengukuran: " + value['tahun_pengukuran2'] +
                                    "<br/> Nama Pengukur: " + value['nama_pengukur2'] +
                                    "<br/> Koordinat: " + value['lintangFull'] +
                                    ", " + value['bujurFull'] +
                                    "<br/> <br/> Parameter Kesehatan Hutan: " +
                                    "<br/> LBDS: " + value['lbds2'] +
                                    "&emsp;&emsp; Volume: " + value['volume2'] +
                                    "<br/> VCR: " + value['vcr2'] +
                                    "&emsp;&emsp;&nbsp;&nbsp; PLI: " + value['pli2'] +
                                    "<br/> <br/> Biodiversitas Pohon: " + "&emsp;&emsp; Biodiversitas Fauna: " +
                                    "<br/> H': " + value['haksen2'] + "&nbsp;&nbsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp; H': " + value['haksenf2'] +
                                    "<br/> J': " + value['jpliu2'] + "&nbsp;&nbsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp; J': " + value['jpliuf2'] +
                                    "</div>" +
                                    "<div class='tab-pane fade' id='tab_3'>" +
                                    "<p><b>Identitas Plot Ukur</b></p>" +
                                    "Klaster: " + value['nama_klaster'] + ", " + value['nama_plot'] +
                                    "<br/> Kategori: " + value['kategori'] +
                                    "<br/> Tanggal Pengukuran: " + value['tahun_pengukuran3'] +
                                    "<br/> Nama Pengukur: " + value['nama_pengukur3'] +
                                    "<br/> Koordinat: " + value['lintangFull'] +
                                    ", " + value['bujurFull'] +
                                    "<br/> <br/> Parameter Kesehatan Hutan: " +
                                    "<br/> LBDS: " + value['lbds3'] +
                                    "&emsp;&emsp; Volume: " + value['volume3'] +
                                    "<br/> VCR: " + value['vcr3'] +
                                    "&emsp;&emsp;&nbsp;&nbsp; PLI: " + value['pli3'] +
                                    "<br/> <br/> Biodiversitas Pohon: " + "&emsp;&emsp; Biodiversitas Fauna: " +
                                    "<br/> H': " + value['haksen3'] + "&nbsp;&nbsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp; H': " + value['haksenf3'] +
                                    "<br/> J': " + value['jpliu3'] + "&nbsp;&nbsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp; J': " + value['jpliuf3'] +
                                  "</div>" +
                                " </div>" +
                                "</div>" +
                              "</div>" +
                              "</div>",{minWidth: 450, closeOnClick: true});
               L.circle([value['lintang'], value['bujur']], {radius: 17.95}).addTo(mymap);
               L.circle([value['lintang'], value['bujur']], {radius: 7.32, fillColor: 'green', color: 'green'}).addTo(mymap);

                latlngs.push(marker2.getLatLng());
                latlngs.push(marker1.getLatLng());
            }
            else if(n%4==2){
              marker3= L.marker([value['lintang'], value['bujur']]);
              markers.addLayer(marker3).addTo(mymap);
               marker3.bindPopup("<div class='row'>" +
                                  "<div class='col-md-12'>" +
                                  "<div class='nav-tabs-custom'>" +
                                  "<ul class='nav nav-tabs'>" +
                                  "<li class='active'><a href='#tab_1' data-toggle='tab'>Pengukuran ke 1</a></li>" +
                                  "<li><a href='#tab_2' data-toggle='tab'>Pengukuran ke 2</a></li>" +
                                  "<li><a href='#tab_3' data-toggle='tab'>Pengukuran ke 3</a></li>" +
                                  "</ul>" +
                                  "<div class='tab-content'>" +
                                    "<div class='tab-pane fade in active' id='tab_1'>" +
                                    "<p><b>Identitas Plot Ukur</b></p>" +
                                    "Klaster: " + value['nama_klaster'] + ", " + value['nama_plot'] +
                                    "<br/> Kategori: " + value['kategori'] +
                                    "<br/> Tanggal Pengukuran: " + value['tahun_pengukuran'] +
                                    "<br/> Nama Pengukur: " + value['nama_pengukur'] +
                                    "<br/> Koordinat: " + value['lintangFull'] +
                                    ", " + value['bujurFull'] +
                                    "<br/> <br/> Parameter Kesehatan Hutan: " +
                                    "<br/> LBDS: " + value['lbds'] +
                                    "&emsp;&emsp; Volume: " + value['volume'] +
                                    "<br/> VCR: " + value['vcr'] +
                                    "&emsp;&emsp;&nbsp;&nbsp; PLI: " + value['pli'] +
                                    "<br/> <br/> Biodiversitas Pohon: " + "&emsp;&emsp; Biodiversitas Fauna: " +
                                    "<br/> H': " + value['haksen'] + "&nbsp;&nbsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp; H': " + value['haksenf'] +
                                    "<br/> J': " + value['jpliu'] + "&nbsp;&nbsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp; J': " + value['jpliuf'] +
                                    "</div>" +
                                    "<div class='tab-pane fade' id='tab_2'>" +
                                    "<p><b>Identitas Plot Ukur</b></p>" +
                                    "Klaster: " + value['nama_klaster'] + ", " + value['nama_plot'] +
                                    "<br/> Kategori: " + value['kategori'] +
                                    "<br/> Tanggal Pengukuran: " + value['tahun_pengukuran2'] +
                                    "<br/> Nama Pengukur: " + value['nama_pengukur2'] +
                                    "<br/> Koordinat: " + value['lintangFull'] +
                                    ", " + value['bujurFull'] +
                                    "<br/> <br/> Parameter Kesehatan Hutan: " +
                                    "<br/> LBDS: " + value['lbds2'] +
                                    "&emsp;&emsp; Volume: " + value['volume2'] +
                                    "<br/> VCR: " + value['vcr2'] +
                                    "&emsp;&emsp;&nbsp;&nbsp; PLI: " + value['pli2'] +
                                    "<br/> <br/> Biodiversitas Pohon: " + "&emsp;&emsp; Biodiversitas Fauna: " +
                                    "<br/> H': " + value['haksen2'] + "&nbsp;&nbsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp; H': " + value['haksenf2'] +
                                    "<br/> J': " + value['jpliu2'] + "&nbsp;&nbsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp; J': " + value['jpliuf2'] +
                                    "</div>" +
                                    "<div class='tab-pane fade' id='tab_3'>" +
                                    "<p><b>Identitas Plot Ukur</b></p>" +
                                    "Klaster: " + value['nama_klaster'] + ", " + value['nama_plot'] +
                                    "<br/> Kategori: " + value['kategori'] +
                                    "<br/> Tanggal Pengukuran: " + value['tahun_pengukuran3'] +
                                    "<br/> Nama Pengukur: " + value['nama_pengukur3'] +
                                    "<br/> Koordinat: " + value['lintangFull'] +
                                    ", " + value['bujurFull'] +
                                    "<br/> <br/> Parameter Kesehatan Hutan: " +
                                    "<br/> LBDS: " + value['lbds3'] +
                                    "&emsp;&emsp; Volume: " + value['volume3'] +
                                    "<br/> VCR: " + value['vcr3'] +
                                    "&emsp;&emsp;&nbsp;&nbsp; PLI: " + value['pli3'] +
                                    "<br/> <br/> Biodiversitas Pohon: " + "&emsp;&emsp; Biodiversitas Fauna: " +
                                    "<br/> H': " + value['haksen3'] + "&nbsp;&nbsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp; H': " + value['haksenf3'] +
                                    "<br/> J': " + value['jpliu3'] + "&nbsp;&nbsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp; J': " + value['jpliuf3'] +
                                  "</div>" +
                                " </div>" +
                                "</div>" +
                              "</div>" +
                              "</div>",{minWidth: 450, closeOnClick: true});
               L.circle([value['lintang'], value['bujur']], {radius: 17.95}).addTo(mymap);
               L.circle([value['lintang'], value['bujur']], {radius: 7.32, fillColor: 'green', color: 'green'}).addTo(mymap);
                latlngs.push(marker3.getLatLng());
                latlngs.push(marker1.getLatLng());
            }
            else{
              marker4= L.marker([value['lintang'], value['bujur']]);
              markers.addLayer(marker4).addTo(mymap);
               marker4.bindPopup("<div class='row'>" +
                                  "<div class='col-md-12'>" +
                                  "<div class='nav-tabs-custom'>" +
                                  "<ul class='nav nav-tabs'>" +
                                  "<li class='active'><a href='#tab_1' data-toggle='tab'>Pengukuran ke 1</a></li>" +
                                  "<li><a href='#tab_2' data-toggle='tab'>Pengukuran ke 2</a></li>" +
                                  "<li><a href='#tab_3' data-toggle='tab'>Pengukuran ke 3</a></li>" +
                                  "</ul>" +
                                  "<div class='tab-content'>" +
                                    "<div class='tab-pane fade in active' id='tab_1'>" +
                                    "<p><b>Identitas Plot Ukur</b></p>" +
                                    "Klaster: " + value['nama_klaster'] + ", " + value['nama_plot'] +
                                    "<br/> Kategori: " + value['kategori'] +
                                    "<br/> Tanggal Pengukuran: " + value['tahun_pengukuran'] +
                                    "<br/> Nama Pengukur: " + value['nama_pengukur'] +
                                    "<br/> Koordinat: " + value['lintangFull'] +
                                    ", " + value['bujurFull'] +
                                    "<br/> <br/> Parameter Kesehatan Hutan: " +
                                    "<br/> LBDS: " + value['lbds'] +
                                    "&emsp;&emsp; Volume: " + value['volume'] +
                                    "<br/> VCR: " + value['vcr'] +
                                    "&emsp;&emsp;&nbsp;&nbsp; PLI: " + value['pli'] +
                                    "<br/> <br/> Biodiversitas Pohon: " + "&emsp;&emsp; Biodiversitas Fauna: " +
                                    "<br/> H': " + value['haksen'] + "&nbsp;&nbsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp; H': " + value['haksenf'] +
                                    "<br/> J': " + value['jpliu'] + "&nbsp;&nbsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp; J': " + value['jpliuf'] +
                                    "</div>" +
                                    "<div class='tab-pane fade' id='tab_2'>" +
                                    "<p><b>Identitas Plot Ukur</b></p>" +
                                    "Klaster: " + value['nama_klaster'] + ", " + value['nama_plot'] +
                                    "<br/> Kategori: " + value['kategori'] +
                                    "<br/> Tanggal Pengukuran: " + value['tahun_pengukuran2'] +
                                    "<br/> Nama Pengukur: " + value['nama_pengukur2'] +
                                    "<br/> Koordinat: " + value['lintangFull'] +
                                    ", " + value['bujurFull'] +
                                    "<br/> <br/> Parameter Kesehatan Hutan: " +
                                    "<br/> LBDS: " + value['lbds2'] +
                                    "&emsp;&emsp; Volume: " + value['volume2'] +
                                    "<br/> VCR: " + value['vcr2'] +
                                    "&emsp;&emsp;&nbsp;&nbsp; PLI: " + value['pli2'] +
                                    "<br/> <br/> Biodiversitas Pohon: " + "&emsp;&emsp; Biodiversitas Fauna: " +
                                    "<br/> H': " + value['haksen2'] + "&nbsp;&nbsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp; H': " + value['haksenf2'] +
                                    "<br/> J': " + value['jpliu2'] + "&nbsp;&nbsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp; J': " + value['jpliuf2'] +
                                    "</div>" +
                                    "<div class='tab-pane fade' id='tab_3'>" +
                                    "<p><b>Identitas Plot Ukur</b></p>" +
                                    "Klaster: " + value['nama_klaster'] + ", " + value['nama_plot'] +
                                    "<br/> Kategori: " + value['kategori'] +
                                    "<br/> Tanggal Pengukuran: " + value['tahun_pengukuran3'] +
                                    "<br/> Nama Pengukur: " + value['nama_pengukur3'] +
                                    "<br/> Koordinat: " + value['lintangFull'] +
                                    ", " + value['bujurFull'] +
                                    "<br/> <br/> Parameter Kesehatan Hutan: " +
                                    "<br/> LBDS: " + value['lbds3'] +
                                    "&emsp;&emsp; Volume: " + value['volume3'] +
                                    "<br/> VCR: " + value['vcr3'] +
                                    "&emsp;&emsp;&nbsp;&nbsp; PLI: " + value['pli3'] +
                                    "<br/> <br/> Biodiversitas Pohon: " + "&emsp;&emsp; Biodiversitas Fauna: " +
                                    "<br/> H': " + value['haksen3'] + "&nbsp;&nbsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp; H': " + value['haksenf3'] +
                                    "<br/> J': " + value['jpliu3'] + "&nbsp;&nbsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp; J': " + value['jpliuf3'] +
                                  "</div>" +
                                " </div>" +
                                "</div>" +
                              "</div>" +
                              "</div>",{minWidth: 450, closeOnClick: true});
               L.circle([value['lintang'], value['bujur']], {radius: 17.95}).addTo(mymap);
               L.circle([value['lintang'], value['bujur']], {radius: 7.32, fillColor: 'green', color: 'green'}).addTo(mymap);

                latlngs.push(marker4.getLatLng());
               multilatlng.push(latlngs);
               latlngs = new Array();
            }
            n= n+1;

        });

        for(var k=0;k<n;k++){
        polyline[k] = L.polyline(multilatlng, {color: 'red'}).addTo(mymap);
      }
    }
    else{
      console.log("tidak ditemukan");
    }
  }
  });

var searchControl = L.esri.Geocoding.geosearch().addTo(mymap);

  var results = L.layerGroup().addTo(mymap);

  searchControl.on('results', function(data){
    results.clearLayers();
    for (var i = data.results.length - 1; i >= 0; i--) {
      results.addLayer(L.marker(data.results[i].latlng));
    }
  });
});
</script>

@endsection
