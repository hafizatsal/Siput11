@extends('layouts.layout')
@section('title','Data Plot')
@section('css')
<link rel="stylesheet" href="{{asset('Admin/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css')}}">
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.4.0/dist/leaflet.css"
   integrity="sha512-puBpdR0798OZvTTbP4A8Ix/l+A4dHDD0DGqYW6RQ+9jxkRFclaxxQb/SJAWZfWAkuyeQUytO7+7N4QKrDh+drA=="
   crossorigin=""/>
   <style>
   #mapid { height: 200px; }
   </style>
@endsection
@section('active_plot_ukur','active')
@section('active_data_plot','active')
@section('breadcrumb')
<li><a href="{{route('user.data_klaster')}}">Data Klaster</a></li>
<li><a href="{{route('user.klaster_plot',encrypt($id_data_klaster2))}}">Data Klaster Plot</a></li>
<li><a href="{{route('user.detail_klaster', encrypt($id_klaster))}}">Detail Klaster</a></li>
<li><a href="#">Detail Data Plot</a></li>
@endsection
@section('main_section')
<div class="row">
   <div class="col-xs-12">
     <div class="box">
       <div class="box-header">
           <h2><i class="fa fa-globe"></i> Data Plot</h2>
       </div>
        <div class="box-body">
       <div class="col-xs-12 table-responsive">
       <table id="detail_plot" class="table table-striped">
         <tbody>
           <tr>
             <td>Nama Pengelola</td>
             <td> : {{$nama_plot->pengelola}}</td>
             <td></td>
           </tr>

           <tr>
             <td>Status Pengelola</td>
             <td> : {{$nama_plot->ket_pengelola}}</td>
             <td></td>
           </tr>

           <tr>
             <td>Nama Klaster</td>
             <td> : {{$nama_plot->nama_klaster}}</td>
             <td></td>
           </tr>

           <tr>
             <td>Nama Plot</td>
             <td> : {{$nama_plot->nama_plot}}</td>
             <td></td>
           </tr>

           <tr>
             <td>Luas</td>
             <td> : {{$nama_plot->luas}} Ha</td>
             <td></td>
           </tr>

           <tr>
             <td>Pola Tanam</td>
             <td> : {{$nama_plot->nama_pola}}</td>
             <td></td>
           </tr>

           <tr>
             <td>Koordinat Titik Pusat</td>
             <td> : {{$koor_ls_ful_p}} {{$ket_lintang_p}} , {{$koor_bt_ful_p}} {{$ket_bujur_p}}</td>
             <td></td>
           </tr>

         </tbody>
         <tfoot>

         </tfoot>
       </table>
     </div>
   </div>
 </div>
</div>
</div>

<div class="row">
  <div class="col-md-12">
    <div class="box box-success">
    <div class="box-header with-border">
      <h3 class="box-title">Lokasi Plot Penilaian</h3>
    </div>

    <div id="mapid" class="box-body chart-responsive">

    </div>
    </div>
    <!-- /.box-body -->
  </div>
</div>

<div class="row">
  <div class="col-lg-12">
  <div class="box">
    <div class="box-header">
        <h4>Data Pohon Plot</h4>
    </div>
     <div class="box-body">
       <div class="col-xs-12 table-responsive">
       <table id="data_pohon3" class="table table-bordered table-striped">
         <thead>
           <tr>
             <th style="width:5%">No.</th>
             <th style="width:42%">Nama Pohon</th>
             <th style="width:43%">Nama Latin Pohon</th>
             <th style="width:10%">Jumlah</th>
             <th style="width:10%">Jumlah Pengukuran ke-2</th>
             <th style="width:10%">Jumlah Pengukuran ke-3</th>
           </tr>
           </thead>
           <tbody>
    @php ($id=1) @php($pohon_p1=0) @php($pohon_p2=0) @php($pohon_p3=0) @php($jumlah_seluruh=0)
    @php($jumlah_total=0)
     @foreach($data_pohon as $a)
           <tr>
             <td>{{$id++}}.</td>
             <td>{{$a->nama_tanaman}}</td>
             <td>{{$a->nama_latin}}</td>
             <td>{{$pohon_peng1[$id-2]}}</td>
             <td>{{$pohon_peng2[$id-2]}}</td>
             <td>{{$pohon_peng3[$id-2]}}</td>
            @php($pohon_p1+=$pohon_peng1[$id-2])
            @php($pohon_p2+=$pohon_peng2[$id-2])
            @php($pohon_p3+=$pohon_peng3[$id-2])

           </tr>
    @endforeach
      </tbody>
    <thead>
    <th>Jumlah</th>
    <th></th>
    <th></th>
    <th>{{$pohon_p1}}</th>
    <th>{{$pohon_p2}}</th>
    <th>{{$pohon_p3}}</th>
    </thead>
       </table>
     </div>
     </div>
   </div>
  </div>

</div>

<div class="row">
  <div class="col-lg-12">
  <div class="box">
    <div class="box-header">
        <h4>Data Fauna Plot</h4>
    </div>
     <div class="box-body">
       <div class="col-xs-12 table-responsive">
       <table id="data_pohon3" class="table table-bordered table-striped">
         <thead>
           <tr>
             <th style="width:5%">No.</th>
             <th style="width:42%">Nama Fauna</th>
             <th style="width:43%">Nama Latin Fauna</th>
             <th style="width:10%">Jumlah</th>
             <th style="width:10%">Jumlah Pengukuran ke-2</th>
             <th style="width:10%">Jumlah Pengukuran ke-3</th>
           </tr>
           </thead>
           <tbody>
    @php ($id=1) @php($fauna_p1=0) @php($fauna_p2=0) @php($fauna_p3=0) @php($jumlah_seluruh=0)
    @php($jumlah_total=0)
     @foreach($data_fauna as $l)
           <tr>
             <td>{{$id++}}.</td>
             <td>{{$l->nama_fauna}}</td>
             <td>{{$l->nama_latin_fauna}}</td>
             <td>{{$fauna_peng1[$id-2]}}</td>
             <td>{{$fauna_peng2[$id-2]}}</td>
             <td>{{$fauna_peng3[$id-2]}}</td>
            @php($fauna_p1+=$fauna_peng1[$id-2])
            @php($fauna_p2+=$fauna_peng2[$id-2])
            @php($fauna_p3+=$fauna_peng3[$id-2])

           </tr>
    @endforeach
      </tbody>
    <thead>
    <th>Jumlah</th>
    <th></th>
    <th></th>
    <th>{{$fauna_p1}}</th>
    <th>{{$fauna_p2}}</th>
    <th>{{$fauna_p3}}</th>
    </thead>
       </table>
     </div>
     </div>
   </div>
  </div>

</div>

  <script src="{{asset('Admin/modal_ajax.min.js')}}"></script>
  <script src="{{asset('Admin/bower_components/jquery/dist/jquery.min.js')}}"></script>
   <!-- /.content -->

@section('data_table')
<!-- DataTables -->
<script src="{{asset('Admin/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js')}}"></script>
<script src="{{asset('Admin/bower_components/datatables.net/js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('Admin/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js')}}"></script>
@endsection
<script src="https://unpkg.com/leaflet@1.4.0/dist/leaflet.js"
  integrity="sha512-QVftwZFqvtRNi0ZyCtsznlKSWOStnDORoefr1enyq5mVL4tmKB3S/EnC3rRJcxCPavG10IcrVGSmPh6Qw5lwrg=="
  crossorigin=""></script>

<script type="text/javascript">

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

var mymap = L.map('mapid',
  {scrollWheelZoom:false,
  layers: [OpenStreetMap_Mapnik]}).setView([{{$koordinat_lintang_angka_klaster}}, {{$koordinat_bujur_angka_klaster}}], 12);

  var baseMaps = {
      "OSM": OpenStreetMap_Mapnik,
      "Google Maps" : gmaps,
      "Satelite": satelite
  };

  L.control.layers(baseMaps).addTo(mymap);

@if($koordinat_lintang_angka_klaster!=0 && $koordinat_bujur_angka_klaster!=0)
var marker = L.marker([{{$koordinat_lintang_angka_klaster}}, {{$koordinat_bujur_angka_klaster}}]).addTo(mymap);
@endif
$( document ).ready(function() {
 $('#datepicker').datepicker({
   format : 'yyyy-mm-dd',
   autoclose: true
 });

 $('#datepicker2').datepicker({
   format : 'yyyy-mm-dd',
   autoclose: true
 });
 });

</script>

   @section('script_table')
   <script>
   $(function () {
     $('#tambah_data_pengukuran').DataTable({
       'paging'      : false,
       'lengthChange': true,
       'searching'   : false,
       'ordering'    :false,
       'info'        : true,
       'autoWidth'   : false
     })
   })
    </script>
   @endsection

  @endsection
