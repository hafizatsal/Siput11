@extends('layouts.adminlayout')
@section('title','Manajemen Nilai Keparahan Kerusakan')
@section('active_indikator','active')
@section('active_krkeparahan','active')
@section('breadcrumb')
<li><a href="{{route('admin.home')}}"><i class="fa fa-fw fa-home"></i> Home</a></li>
<li><a href="#">Nilai Keparahan Kerusakan</a></li>
@endsection
@section('main_section')
  <div class="row">
    <div class="col-xs-12">
      <div class="box">
        <div class="box-header">
          <h3 class="box-title">Nilai Keparahan Kerusakan</h3>
          <button type="button" class=" btn btn-primary btn-xs pull-right" data-toggle="modal" data-target="#tambah_keparahan">
            <i class="fa fa-plus"></i></button>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <div class="col-xs-12">
          <table id="data_tanah" class="table table-bordered table-striped">
            <thead>
            <tr>
              <th style="width:4%">Keparahan</th>
              <th>Nilai</th>
              <th>Aksi</th>

            </tr>
            </thead>
            <tbody>
            @foreach($data as $d)
            <tr>
              <td>{{$d->keparahan}}</td>
              <td>{{$d->nilai}}</td>
              <td>
              <a class="fa fa-edit btn btn-warning btn-xs" data-nm_keparahan="{{$d->keparahan}}" data-toggle="modal" data-target="#edit_keparahan"></a>
              <a class="fa fa-trash btn btn-danger btn-xs" data-nm_keparahan="{{$d->keparahan}}" data-toggle="modal" data-target="#delete_keparahan"></a>
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

  @include('admin.include.data_keparahan_kerusakan.modal_tambah_keparahan')
  @include('admin.include.data_keparahan_kerusakan.modal_delete_keparahan')
  @include('admin.include.data_keparahan_kerusakan.modal_edit_keparahan')


@section('data_table')
<!-- DataTables -->
<script src="{{asset('Admin/bower_components/datatables.net/js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('Admin/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js')}}"></script>
@endsection


  @endsection
