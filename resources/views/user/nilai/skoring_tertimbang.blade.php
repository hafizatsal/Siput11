@extends('layouts.layout')
@section('title','Halaman Skoring')
@section('css')
  <link rel="stylesheet" href="{{asset('Admin/bower_components/morris.js/morris.css')}}">
@endsection
@section('active_penilaian','active')
@section('active_nilai_tertimbang','active')
@section('judul_halaman','Halaman Skoring')
@section('breadcrumb')
<li><a href="{{route('home')}}"><i class="fa fa-dashboard"></i> Home</a></li>
<li><a href="#">Data Penilaian</a></li>
@endsection
@section('main_section')

<div class="box box-primary">
  <div class="box-header with-border">
    <h3 class="box-title">Data Nilai Tertimbang</h3>
    <h4>
      <form id="skor_akhir" method="post" class="" action="{{route('user.penilaian_kesehatan')}}">
      {{csrf_field()}}
      <input type="hidden" id="nama_data_klaster1" name="nama_data_klaster1" value="{{$id_data_klaster}}">
      <input type="hidden" id="pengukuran_ke" name="pengukuran_ke" value="{{$pengukuran_ke}}">
      <input type="hidden" id="param_prod" name="param_prod" value="{{$param_prod}}">
      <input type="hidden" id="param_vit" name="param_vit" value="{{$param_vit}}">
      <input type="hidden" id="param_ktk" name="param_ktk" value="{{$param_ktk}}">
      <input type="hidden" id="param_biodiv" name="param_biodiv" value="{{$param_biodiv}}">
      </form>

      <form id="skor_indikator" method="post" class="" action="{{route('user.penilaian_kesehatan')}}">
      {{csrf_field()}}
      <input type="hidden" id="nama_data_klaster1" name="nama_data_klaster1" value="{{$id_data_klaster}}">
      <input type="hidden" id="pengukuran_ke" name="pengukuran_ke" value="{{$pengukuran_ke}}">
      <input type="hidden" id="param_prod" name="param_prod" value="{{$param_prod}}">
      <input type="hidden" id="param_vit" name="param_vit" value="{{$param_vit}}">
      <input type="hidden" id="param_ktk" name="param_ktk" value="{{$param_ktk}}">
      <input type="hidden" id="param_biodiv" name="param_biodiv" value="{{$param_biodiv}}">
      </form>

      <form id="skor_tertimbang" method="post" class="" action="{{route('user.penilaian_kesehatan')}}">
      {{csrf_field()}}
      <input type="hidden" id="nama_data_klaster1" name="nama_data_klaster1" value="{{$id_data_klaster}}">
      <input type="hidden" id="pengukuran_ke" name="pengukuran_ke" value="{{$pengukuran_ke}}">
      <input type="hidden" id="param_prod" name="param_prod" value="{{$param_prod}}">
      <input type="hidden" id="param_vit" name="param_vit" value="{{$param_vit}}">
      <input type="hidden" id="param_ktk" name="param_ktk" value="{{$param_ktk}}">
      <input type="hidden" id="param_biodiv" name="param_biodiv" value="{{$param_biodiv}}">
      </form>

      <form id="skor_skor" method="post" class="" action="{{route('user.penilaian_kesehatan')}}">
      {{csrf_field()}}
      <input type="hidden" id="nama_data_klaster1" name="nama_data_klaster1" value="{{$id_data_klaster}}">
      <input type="hidden" id="pengukuran_ke" name="pengukuran_ke" value="{{$pengukuran_ke}}">
      <input type="hidden" id="param_prod" name="param_prod" value="{{$param_prod}}">
      <input type="hidden" id="param_vit" name="param_vit" value="{{$param_vit}}">
      <input type="hidden" id="param_ktk" name="param_ktk" value="{{$param_ktk}}">
      <input type="hidden" id="param_biodiv" name="param_biodiv" value="{{$param_biodiv}}">
      </form>

      <form id="skor_range" method="post" class="" action="{{route('user.penilaian_kesehatan')}}">
      {{csrf_field()}}
      <input type="hidden" id="nama_data_klaster1" name="nama_data_klaster1" value="{{$id_data_klaster}}">
      <input type="hidden" id="pengukuran_ke" name="pengukuran_ke" value="{{$pengukuran_ke}}">
      <input type="hidden" id="param_prod" name="param_prod" value="{{$param_prod}}">
      <input type="hidden" id="param_vit" name="param_vit" value="{{$param_vit}}">
      <input type="hidden" id="param_ktk" name="param_ktk" value="{{$param_ktk}}">
      <input type="hidden" id="param_biodiv" name="param_biodiv" value="{{$param_biodiv}}">
      </form>

      <form id="skor_analisis" method="post" class="" action="{{route('user.penilaian_kesehatan')}}">
      {{csrf_field()}}
      <input type="hidden" id="nama_data_klaster1" name="nama_data_klaster1" value="{{$id_data_klaster}}">
      <input type="hidden" id="pengukuran_ke" name="pengukuran_ke" value="{{$pengukuran_ke}}">
      <input type="hidden" id="param_prod" name="param_prod" value="{{$param_prod}}">
      <input type="hidden" id="param_vit" name="param_vit" value="{{$param_vit}}">
      <input type="hidden" id="param_ktk" name="param_ktk" value="{{$param_ktk}}">
      <input type="hidden" id="param_biodiv" name="param_biodiv" value="{{$param_biodiv}}">
      </form>

      <a class="btn btn-primary btn-xs" onclick="document.getElementById('skor_akhir').submit()">Nilai Akhir Kesehatan</a>
      <a class="btn btn-primary btn-xs" onclick="document.getElementById('skor_indikator').submit()">Nilai Indikator</a>
      <a class="btn btn-primary btn-xs" onclick="document.getElementById('skor_tertimbang').submit()">Nilai Tertimbang</a>
      <a class="btn btn-primary btn-xs" onclick="document.getElementById('skor_skor').submit()">Nilai Skor</a>
      <a class="btn btn-primary btn-xs" onclick="document.getElementById('skor_range').submit()">Range Skor</a>
      <a class="btn btn-primary btn-xs" onclick="document.getElementById('skor_analisis').submit()">Nilai Analisis</a>
    </h4>
  </div>
  <div class="box-body">
    <table id="Nilai_Tertimbang" class="table table-bordered table-striped">
      <thead>

      <tr>
              <th style="vertical-align: middle">Kode <br> Klaster</th>
              <th style="text-align: center; vertical-align: middle">Kabupaten</th>
              <th style="text-align: center; vertical-align: middle">Kecamatan</th>
              <th style="text-align: center; vertical-align: middle">NT <br> Produktifitas</th>
              <th style="text-align: center; vertical-align: middle">NT Kondisi <br> Tajuk</th>
              <th style="text-align: center; vertical-align: middle">NT Kerusakan <br> Pohon</th>
              <th style="text-align: center; vertical-align: middle">NT <br> Biodiversitas</th>
      </tr>
      </thead>
      <tbody>
@php ($i=0) @foreach($id_klaster as $value)
      <tr>
        <td>{{$value->nama_klaster}}</td>
        <td>{{$value->nama_kabupaten}}</td>
        <td>{{$value->nama_kecamatan}}</td>
        <td>{{$nt_produktivitas[$i]}}</td>
        <td>{{$nt_ktjk[$i]}}</td>
        <td>{{$nt_kerusakan[$i]}}</td>
        <td>{{$nt_biodiv[$i]}}</td>
      </tr>
      @php($i++)
@endforeach
      </tbody>
      <tfoot>

      </tfoot>
    </table>
  </div>
  <!-- /.box-body -->
</div>

@section('data_table')
<!-- <script src="{{asset('Admin/dist/js/adminlte.min.js')}}"></script> TAMBAHAN UNTUK EXPANDABLE -->
<script src="{{asset('Admin/bower_components/raphael/raphael.min.js')}}"></script>
<script src="{{asset('Admin/bower_components/morris.js/morris.min.js')}}"></script>
<script src="{{asset('Admin/bower_components/datatables.net/js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('Admin/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js')}}"></script>
@endsection
<script src="{{asset('Admin/bower_components/jquery/dist/jquery.min.js')}}"></script>

   @section('script_table')
   <script>
   $(function () {
     $('#Nilai_Indikator').DataTable({
       'paging'      : true,
       'lengthChange': true,
       'searching'   : true,
       'ordering'      :false,
       'info'        : true,
       'autoWidth'   : false
     })
     $('#Nilai_Tertimbang').DataTable({
       'paging'      : true,
       'lengthChange': true,
       'searching'   : true,
       'ordering'      :true,
       'info'        : true,
       'autoWidth'   : false
     })
     $('#example2').DataTable({
       'paging'      : true,
       'lengthChange': false,
       'searching'   : false,
       'ordering'    : true,
       'info'        : true,
       'autoWidth'   : false
     })
   })
   </script>
   @endsection
@endsection


