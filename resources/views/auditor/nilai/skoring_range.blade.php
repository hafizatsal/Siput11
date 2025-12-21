@extends('layouts.layout')
@section('title','Halaman Skoring')
@section('css')
@endsection
@section('active_penilaian','active')
@section('active_range_skor','active')
@section('judul_halaman','Halaman Skoring')
@section('breadcrumb')
<li><a href="{{route('home')}}"><i class="fa fa-dashboard"></i> Home</a></li>
<li><a href="#">Data Penilaian</a></li>
@endsection
@section('main_section')

<div class="box box-primary">
  <div class="box-header with-border">
    <h3 class="box-title">Range Skor Kesehatan Hutan</h3>

    <h4>
      <form id="skor_akhir" method="post" class="" action="{{route('/penilaian/kesehatan')}}">
      {{csrf_field()}}
      <input type="hidden" id="nama_data_klaster1" name="nama_data_klaster1" value="{{$id_data_klaster}}">
      <input type="hidden" id="pengukuran_ke" name="pengukuran_ke" value="{{$pengukuran_ke}}">
      <input type="hidden" id="param_prod" name="param_prod" value="{{$param_prod}}">
      <input type="hidden" id="param_vit" name="param_vit" value="{{$param_vit}}">
      <input type="hidden" id="param_ktk" name="param_ktk" value="{{$param_ktk}}">
      <input type="hidden" id="param_biodiv" name="param_biodiv" value="{{$param_biodiv}}">
      </form>

      <form id="skor_indikator" method="post" class="" action="{{route('auditor.penilaian.kesehatan')}}">
      {{csrf_field()}}
      <input type="hidden" id="nama_data_klaster1" name="nama_data_klaster1" value="{{$id_data_klaster}}">
      <input type="hidden" id="pengukuran_ke" name="pengukuran_ke" value="{{$pengukuran_ke}}">
      <input type="hidden" id="param_prod" name="param_prod" value="{{$param_prod}}">
      <input type="hidden" id="param_vit" name="param_vit" value="{{$param_vit}}">
      <input type="hidden" id="param_ktk" name="param_ktk" value="{{$param_ktk}}">
      <input type="hidden" id="param_biodiv" name="param_biodiv" value="{{$param_biodiv}}">
      </form>

      <form id="skor_tertimbang" method="post" class="" action="{{route('auditor.penilaian.kesehatan')}}">
      {{csrf_field()}}
      <input type="hidden" id="nama_data_klaster1" name="nama_data_klaster1" value="{{$id_data_klaster}}">
      <input type="hidden" id="pengukuran_ke" name="pengukuran_ke" value="{{$pengukuran_ke}}">
      <input type="hidden" id="param_prod" name="param_prod" value="{{$param_prod}}">
      <input type="hidden" id="param_vit" name="param_vit" value="{{$param_vit}}">
      <input type="hidden" id="param_ktk" name="param_ktk" value="{{$param_ktk}}">
      <input type="hidden" id="param_biodiv" name="param_biodiv" value="{{$param_biodiv}}">
      </form>

      <form id="skor_skor" method="post" class="" action="{{route('auditor.penilaian.kesehatan')}}">
      {{csrf_field()}}
      <input type="hidden" id="nama_data_klaster1" name="nama_data_klaster1" value="{{$id_data_klaster}}">
      <input type="hidden" id="pengukuran_ke" name="pengukuran_ke" value="{{$pengukuran_ke}}">
      <input type="hidden" id="param_prod" name="param_prod" value="{{$param_prod}}">
      <input type="hidden" id="param_vit" name="param_vit" value="{{$param_vit}}">
      <input type="hidden" id="param_ktk" name="param_ktk" value="{{$param_ktk}}">
      <input type="hidden" id="param_biodiv" name="param_biodiv" value="{{$param_biodiv}}">
      </form>

      <form id="skor_range" method="post" class="" action="{{route('auditor.penilaian.kesehatan')}}">
      {{csrf_field()}}
      <input type="hidden" id="nama_data_klaster1" name="nama_data_klaster1" value="{{$id_data_klaster}}">
      <input type="hidden" id="pengukuran_ke" name="pengukuran_ke" value="{{$pengukuran_ke}}">
      <input type="hidden" id="param_prod" name="param_prod" value="{{$param_prod}}">
      <input type="hidden" id="param_vit" name="param_vit" value="{{$param_vit}}">
      <input type="hidden" id="param_ktk" name="param_ktk" value="{{$param_ktk}}">
      <input type="hidden" id="param_biodiv" name="param_biodiv" value="{{$param_biodiv}}">
      </form>

      <form id="skor_analisis" method="post" class="" action="{{route('auditor.penilaian.kesehatan')}}">
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
    <div class="col-md-3">
      <h4 style="text-align:center">Pertumbuhan Pohon</h4>
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

  <div class="col-md-3">
    <h4 style="text-align:center">Kondisi Tajuk</h4>
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
    <tfoot>

    </tfoot>
  </table>
</div>

<div class="col-md-3">
  <h4 style="text-align:center">Kerusakan Pohon</h4>
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
  <tfoot>

  </tfoot>
</table>
</div>

<div class="col-md-3">
  <h4 style="text-align:center">Biodiversitas Pohon</h4>
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
  <tfoot>

  </tfoot>
</table>
</div>
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
@push('script_tambahan')
<script type="text/javascript">
</script>
@endpush

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
   
</script>@endsection
@endsection

