@extends('layouts.layoutauditor')
@section('title','Halaman Skoring')
@section('css')
  <link rel="stylesheet" href="{{asset('Admin/bower_components/morris.js/morris.css')}}">
@endsection
@section('active-treeview','active')
@section('active_skoring','active')
@section('judul_halaman','Halaman Skoring Plot')
@section('breadcrumb')
<li><a href="{{route('home')}}"><i class="fa fa-dashboard"></i> Home</a></li>
<li><a href="#">Data Penilaian</a></li>
@endsection
@section('main_section')

<div class="box box-info">
  <div class="box-header with-border">
    <h3 class="box-title">Nilai Kesehatan Hutan</h3>

    <div class="box-tools pull-right">
      <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
      </button>
      </div>
  </div>
  <div class="box-body">

    <div class="col-md-12">
    <table id="nilai_kesehatan" class="table table-bordered table-striped">
      <thead>
      <tr>
        <th style="vertical-align: middle">Kode Klaster</th>
                    <th style="text-align: center; vertical-align: middle">Kabupaten</th>
                    <th style="text-align: center; vertical-align: middle">Kecamatan</th>
                    <th style="">Nilai Kesehatan Hutan <br> (Nilai Produktifitas + Nilai Tajuk +<br> Nilai Kerusakan + Nilai Biodiversitas)</th>
                    <th>Kondisi</th>
                    <th>Lihat Detail</th>
      </tr>
      </thead>
      <tbody>
@foreach($id_klaster as $value)
      <tr>
        <td>{{$value->nama_klaster}}</td>
        <td>{{$value->nama_kabupaten}}</td>
        <td>{{$value->nama_kecamatan}}</td>
        <td>{{10*$nilai_tertimbang[0]}} + {{10*$nilai_tertimbang[1]}} + {{10*$nilai_tertimbang[2]}} + {{10*$nilai_tertimbang[3]}} = {{$skor_akhir}}</td>
        <td>Baik <span class='label label-success pull-right'>O</span></td>
        <td>
        <a class="fa fa-search btn btn-success btn-xs" data-info="" href=""></a>
        </td>
      </tr>
    @endforeach

      </tbody>
      <tfoot>

      </tfoot>
    </table>
  </div>
  </div>
  <!-- /.box-body -->
</div>


<div class="box box-primary  collapsed-box">
  <div class="box-header with-border">
    <h3 class="box-title">Nilai Indikator Kesehatan Hutan</h3>

    <div class="box-tools pull-right">
      <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
      </button>
      <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
    </div>
  </div>
  <div class="box-body">
    <table id="Nilai_Indikator" class="table table-bordered table-striped">
      <thead>
      <tr>
              <th style="vertical-align: middle">Kode Klaster</th>
              <th style="text-align: center; vertical-align: middle">Kabupaten</th>
              <th style="text-align: center; vertical-align: middle">Kecamatan</th>
              <th style="font-size: 11px">Nilai Produktifitas <br> (Skor Produktifitas x NT Produktifitas)</th>
              <th style="font-size: 11px">Nilai Kondisi Tajuk <br> (Skor Kondisi Tajuk x NT Kondisi Tajuk)</th>
              <th style="font-size: 11px">Nilai Kerusakan Pohon <br> (Skor Kerusakan x NT Kerusakan)</th>
              <th style="font-size: 11px">Nilai Biodiversitas <br> (Skor Biodiversitas x NT Biodiversitas)</th>
      </tr>
      </thead>
      <tbody>
@foreach($id_klaster as $value)
      <tr>
        <td>{{$value->nama_klaster}}</td>
        <td>{{$value->nama_kabupaten}}</td>
        <td>{{$value->nama_kecamatan}}</td>
        <td>10 x {{$nilai_tertimbang[0]}}= {{10*$nilai_tertimbang[0]}}</td>
        <td>10 x {{$nilai_tertimbang[1]}}= {{10*$nilai_tertimbang[1]}}</td>
        <td>10 x {{$nilai_tertimbang[2]}}= {{10*$nilai_tertimbang[2]}}</td>
        <td>10 x {{$nilai_tertimbang[3]}}= {{10*$nilai_tertimbang[3]}}</td>
      </tr>
@endforeach
      </tbody>
      <tfoot>

      </tfoot>
    </table>
  </div>
  <!-- /.box-body -->
</div>

<div class="box box-primary  collapsed-box">
  <div class="box-header with-border">
    <h3 class="box-title">Data Nilai Tertimbang</h3>

    <div class="box-tools pull-right">
      <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
      </button>
      <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
    </div>
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
@php ($id=1) @foreach($id_klaster as $value)
      <tr>
        <td>{{$value->nama_klaster}}</td>
        <td>{{$value->nama_kabupaten}}</td>
        <td>{{$value->nama_kecamatan}}</td>
        <td>{{$nilai_tertimbang[0]}}</td>
        <td>{{$nilai_tertimbang[1]}}</td>
        <td>{{$nilai_tertimbang[2]}}</td>
        <td>{{$nilai_tertimbang[3]}}</td>
      </tr>
      @endforeach
      </tbody>
      <tfoot>

      </tfoot>
    </table>
  </div>
  <!-- /.box-body -->
</div>

<div class="box box-primary  collapsed-box">
  <div class="box-header with-border">
    <h3 class="box-title">Skor Kesehatan Hutan Per Klaster</h3>

    <div class="box-tools pull-right">
      <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
      </button>
      <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
    </div>
  </div>
  <div class="box-body">
    <table id="Kesehatan_klaster" class="table table-bordered table-striped">
      <thead>
      <tr>
              <th style="vertical-align: middle">Kode <br> Klaster</th>
              <th style="text-align: center; vertical-align: middle">Kabupaten</th>
              <th style="text-align: center; vertical-align: middle">Kecamatan</th>
              <th style="text-align: center; vertical-align: middle">Skor <br> Produktifitas</th>
              <th style="text-align: center; vertical-align: middle">Skor Kondisi <br> Tajuk</th>
              <th style="text-align: center; vertical-align: middle">Skor Kerusakan <br> Pohon</th>
              <th style="text-align: center; vertical-align: middle">Skor <br> Biodiversitas</th>
      </tr>
      </thead>
      <tbody>
@foreach($id_klaster as $value)
      <tr>
        <td>{{$value->nama_klaster}}</td>
        <td>{{$value->nama_kabupaten}}</td>
        <td>{{$value->nama_kecamatan}}</td>
        <td>10</td>
        <td>10</td>
        <td>10</td>
        <td>10</td>
      </tr>
@endforeach
      </tbody>
      <tfoot>

      </tfoot>
    </table>
  </div>
  <!-- /.box-body -->
</div>

<div class="box box-primary  collapsed-box">
  <div class="box-header with-border">
    <h3 class="box-title">Data Indikator Klaster</h3>

    <div class="box-tools pull-right">
      <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
      </button>
      <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
    </div>
  </div>
  <div class="box-body">
    <table id="Indikator_klaster" class="table table-bordered table-striped">
      <thead>
      <tr>
              <th style="vertical-align: middle">No.</th>
              <th style="text-align: center; vertical-align: middle">Nama <br> Klaster</th>
              <th style="text-align: center; vertical-align: middle">Kabupaten</th>
              <th style="text-align: center; vertical-align: middle">Kecamatan</th>
              <th style="text-align: center; vertical-align: middle">Produktifitas</th>
              <th style="text-align: center; vertical-align: middle">Kerusakan <br> Pohon</th>
              <th style="text-align: center; vertical-align: middle">Kondisi <br> Tajuk</th>
              <th style="text-align: center; vertical-align: middle">Biodiversitas <br> Pohon</th>
      </tr>
      </thead>
      <tbody>
@php($nmr=1) @foreach($id_klaster as $value)
      <tr>
        <td>{{$nmr++}}</td>
        <td>{{$value->nama_klaster}}</td>
        <td>{{$value->nama_kabupaten}}</td>
        <td>{{$value->nama_kecamatan}}</td>
        <td>{{$nilai_lbds}}</td>
        <td>{{$nilai_tli}}</td>
        <td>{{$nilai_vcr}}</td>
        <td>{{$h_aksen}}</td>
      </tr>
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
<script type="text/javascript">

</script>

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
