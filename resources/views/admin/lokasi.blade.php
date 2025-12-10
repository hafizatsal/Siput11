@extends('layouts.adminlayout')
@section('title','Manajemen Lokasi')
@section('active_lokasi','active')
@section('breadcrumb')
<li><a href="{{route('admin.home')}}"><i class="fa fa-fw fa-home"></i> Home</a></li>
<li><a href="#">Data Lokasi</a></li>
@endsection
@section('main_section')
  <div class="row">
    <div class="col-xs-12">
      <div class="box">
        <div class="box-header">
          <h3 class="box-title">Data Lokasi</h3>
          <button type="button" class=" btn btn-primary btn-xs pull-right" data-toggle="modal" data-target="#tambah_lokasi">
            <i class="fa fa-plus"></i></button>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <div class="col-xs-12 table-responsive">
          <table id="data_lokasi" class="table table-bordered table-striped">
            <thead>
            <tr>
              <th style="width:4%">No.</th>
              <th>Nama Provinsi</th>
              <th style="width:15%">Aksi</th>

            </tr>
            </thead>
            <tbody>
            @php ($id=1) @foreach($data as $d)
            <tr>
              <td>{{$id++}}</td>
              <td>{{$d->nama_provinsi}}</td>
              <td>
              <a class="fa fa-search btn btn-info btn-xs" data-info=""href="{{route('admin.kabupaten', encrypt($d->id_provinsi))}}"></a>
              <a class="fa fa-edit btn btn-warning btn-xs" data-nm_lokasi="{{$d->id_provinsi}}" data-toggle="modal" data-target="#edit_lokasi"></a>
              <a class="fa fa-trash btn btn-danger btn-xs" data-nm_lokasi="{{$d->id_provinsi}}" data-toggle="modal" data-target="#delete_lokasi" href=""></a>
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

   @include('admin.include.data_lokasi.modal_tambah_lokasi')
   @include('admin.include.data_lokasi.modal_edit_lokasi')
   @include('admin.include.data_lokasi.modal_delete_lokasi')

@section('data_table')
<!-- DataTables -->
<script src="{{asset('Admin/bower_components/datatables.net/js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('Admin/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js')}}"></script>
@endsection

   @section('script_table')
    <script>
   $(function () {
     $('#data_lokasi').DataTable({
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
