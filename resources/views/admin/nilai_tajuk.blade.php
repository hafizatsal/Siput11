@extends('layouts.adminlayout')
@section('title','Manajemen Nilai Tajuk')
@section('active_indikator','active')
@section('active_tajuk','active')
@section('breadcrumb')
<li><a href="{{route('admin.home')}}"><i class="fa fa-fw fa-home"></i> Home</a></li>
<li><a href="#">Nilai Tajuk</a></li>
@endsection
@section('main_section')
  <div class="row">
    <div class="col-xs-12">
      <div class="box">
        <div class="box-header">
          <h3 class="box-title">Data Batas Tajuk</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <div class="col-xs-12 table-responsive">
          <table id="data_tanah" class="table table-bordered table-striped">
            <thead>
            <tr>
              <th style="width:4%">No.</th>
              <th>Nama Parameter</th>
              <th>Batas Atas</th>
              <th>Batas Bawah</th>
              <th style="width:12%">Aksi</th>

            </tr>
            </thead>
            <tbody>
            @php ($id=1) @foreach($data as $d)
            <tr>
              <td>{{$id++}}</td>
              <td>{{$d->nama_parameter}}</td>
              <td>{{$d->batas_atas}}</td>
              <td>{{$d->batas_bawah}}</td>
              <td>
              <a class="fa fa-edit btn btn-warning btn-xs" data-nm_tajuk="{{$d->id_kondisi_tajuk}}" data-toggle="modal" data-target="#edit_tajuk"></a>
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
      <!-- /.box -->
    </div>
    <!-- /.col -->
  </div>
  <!-- /.row -->
  <script src="{{asset('Admin/modal_ajax.min.js')}}"></script>
  <script src="{{asset('Admin/bower_components/jquery/dist/jquery.min.js')}}"></script>

@include('admin.include.data_indikator.modal_edit_tajuk')

@section('data_table')
<!-- DataTables -->
<script src="{{asset('Admin/bower_components/datatables.net/js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('Admin/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js')}}"></script>
@endsection


  @endsection
