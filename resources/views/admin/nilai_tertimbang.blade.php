@extends('layouts.adminlayout')
@section('title','Halaman Tertimbang')
@section('active_nilai_tertimbang','active')
@section('breadcrumb')
<li><a href="{{route('admin.home')}}"><i class="fa fa-dashboard"></i> Home</a></li>
<li><a href="#">Data Nilai Tertimbang</a></li>
@endsection
@section('main_section')
  <div class="row">
    <div class="col-xs-12">
      <div class="box">
        <div class="box-header">
          <h3 class="box-title">Data Nilai Tertimbang</h3>
          <button type="button" class=" btn btn-primary btn-xs" data-toggle="modal" data-target="#tambah_tertimbang">
            <i class="fa fa-plus"></i></button>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <table id="data_pengukuran" class="table table-bordered table-striped">
            <thead>
            <tr>
              <th>No.</th>
              <th>Nama</th>
              <th>Aksi</th>

            </tr>
            </thead>
            <tbody>
            @php ($id=1) @foreach($data as $d)
            <tr>
              <td>{{$id++}}</td>
              <td>{{$d->nama}}</td>
              <td>
              <a class="fa fa-edit btn btn-warning btn-xs" data-nm_tertimbang={{$d->id_master_tertimbang}} data-toggle="modal" data-target="#edit_tertimbang"></a>
              <a class="fa fa-trash btn btn-danger btn-xs" data-nm_tertimbang={{$d->id_master_tertimbang}} data-toggle="modal" data-target="#delete_tertimbang"></a>
              </td>
            </tr>
            @endforeach
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
  </div>
  <!-- /.row -->

   <!-- /.content -->
   @include('admin.include.data_tertimbang.modal_tambah_tertimbang')
   @include('admin.include.data_tertimbang.modal_edit_tertimbang')
   @include('admin.include.data_tertimbang.modal_delete_tertimbang')

@section('data_table')
<!-- DataTables -->
<script src="{{asset('Admin/bower_components/datatables.net/js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('Admin/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js')}}"></script>
@endsection

   @section('script_table')
   <script>
   $(function () {
     $('#data_pengukuran').DataTable({
       'paging'      : true,
       'lengthChange': true,
       'searching'   : true,
       'ordering'      :false,
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
