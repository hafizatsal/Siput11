@extends('layouts.adminlayout')
@section('title','Manajemen Fauna')
@section('active_fauna','active')
@section('breadcrumb')
<li><a href="{{route('admin.home')}}"><i class="fa fa-fw fa-home"></i> Home</a></li>
<li><a href="#">Data Fauna</a></li>
@endsection
@section('main_section')
  <div class="row">
    <div class="col-xs-12">
      <div class="box">
        <div class="box-header">
          <h3 class="box-title">Data Fauna</h3>
          <button type="button" class=" btn btn-primary btn-xs pull-right" data-toggle="modal" data-target="#tambah_fauna">
            <i class="fa fa-plus"></i></button>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <div class="col-xs-12 table-responsive">
          <table id="data_fauna" class="table table-bordered table-striped">
            <thead>
            <tr>
              <th style="width:4%">No.</th>
              <th>Nama Fauna</th>
              <th style="width:40%">Nama Latin</th>
              <th style="width:12%">Aksi</th>

            </tr>
            </thead>
            <tbody>
            @php ($id=1) @foreach($data as $d)
            <tr>
              <td>{{$id++}}</td>
              <td>{{$d->nama_fauna}}</td>
              <td><i>{{$d->nama_latin_fauna}}</i></td>
              <td>
              <a class="fa fa-edit btn btn-warning btn-xs" data-id_fauna={{$d->id_jenis_fauna}} data-toggle="modal" data-target="#edit_fauna" href="#"></a>
              <a class="fa fa-trash btn btn-danger btn-xs" data-id_fauna={{$d->id_jenis_fauna}} data-toggle="modal" data-target="#delete_fauna" href="#"></a>
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

   <!-- /.content -->

   <script src="{{asset('Admin/modal_ajax.min.js')}}"></script>
   <script src="{{asset('Admin/bower_components/jquery/dist/jquery.min.js')}}"></script>

   @include('admin.include.data_fauna.modal_tambah_fauna')
   @include('admin.include.data_fauna.modal_edit_fauna')
   @include('admin.include.data_fauna.modal_delete_fauna')

@section('data_table')
<!-- DataTables -->
<script src="{{asset('Admin/bower_components/datatables.net/js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('Admin/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js')}}"></script>
@endsection

   @section('script_table')
    <script>
   $(function () {
     $('#data_fauna').DataTable({
       'paging'      : true,
       'lengthChange': true,
       'searching'   : true,
       'ordering'      :false,
       'info'        : true,
       'autoWidth'   : false,
       'bStateSave'  : true,
       "language"    : {
         "search"       :        "Pencarian:",
         "lengthMenu"   : "Menampilkan _MENU_ data per halaman",
         "zeroRecords"  : "Nothing found - sorry",
         "info"         : "Halaman _PAGE_ dari _PAGES_",
         "infoEmpty"    : "Belum Ada Data Tersimpan",
         "infoFiltered" : "(filtered from _MAX_ total records)",
         "paginate" : {
           "first"      :   "Pertama",
           "last"       :   "Terakhir",
           "next"       :   "Selanjutnya",
           "previous"   :   "Sebelumnya"
         },
       }
     })
   })
    </script>
   @endsection

  @endsection
