@extends('layouts.adminlayout')
@section('title','Halaman Plot')
@section('active_plot','active')
@section('breadcrumb')
<li><a href="{{route('admin.home')}}"><i class="fa fa-dashboard"></i> Home</a></li>
<li><a href="#">Data Plot</a></li>
@endsection
@section('main_section')
  <div class="row">
    <div class="col-xs-12">
      <div class="box">
        <div class="box-header">
          <h3 class="box-title">Data Plot</h3>
          <button type="button" class=" btn btn-primary btn-xs" data-toggle="modal" data-target="#tambah">
            <i class="fa fa-plus"></i></button>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <table id="data_pengukuran" class="table table-bordered table-striped">
            <thead>
            <tr>
              <th>.</th>
              <th></th>
              <th></th>
              <th></th>
              <th></th>
              <th></th>

            </tr>
            </thead>
            <tbody>

            <tr>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td>
              <a class="fa fa-plus btn btn-info btn-xs" data-info=""href="#"></a>
              <a class="fa fa-edit btn btn-warning btn-xs" data-toggle="modal" data-target="#edit_pengukuran" href="#"></a>
              <a class="fa fa-trash btn btn-danger btn-xs" data-toggle="modal" data-target="#delete_pengukuran" href=""></a>
              </td>
            </tr>
            <tr>
              <td>Rendy</td>
              <td>Internet
                Explorer 5.0
              </td>
              <td>Win 95+</td>
              <td>5</td>
              <td>C</td>
              <td>Win 95+</td>
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
  </div>
  <!-- /.row -->

   <!-- /.content -->

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
