@extends('layouts.adminlayout')
@section('title','Manajemen Sifat Kimia Tanah')
@section('active_sifat_tanah','active')
@section('breadcrumb')
<li><a href="{{route('admin.home')}}"><i class="fa fa-fw fa-home"></i> Home</a></li>
<li><a href="#">Data Sifat Tanah</a></li>
@endsection
@section('main_section')
  <div class="row">
    <div class="col-xs-12">
      <div class="box">
        <div class="box-header">
          <h3 class="box-title">Data Sifat Tanah</h3>
          <button type="button" class=" btn btn-primary btn-xs pull-right" data-toggle="modal" data-target="#tambah_tanah">
            <i class="fa fa-plus"></i></button>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <div class="col-xs-12 table-responsive">
          <table id="data_tanah" class="table table-bordered table-striped">
            <thead>
            <tr>
              <th style="width:4%">No.</th>
              <th>Nama Indikator</th>
              <th style="width:12%">Aksi</th>

            </tr>
            </thead>
            <tbody>
            @php ($id=1) @foreach($data as $d)
            <tr>
              <td>{{$id++}}</td>
              <td>{{$d->sifat_kimia}}</td>
              <td>
              <a class="fa fa-edit btn btn-warning btn-xs" data-nm_tanah={{$d->id_parameter_kimia}} data-toggle="modal" data-target="#edit_tanah"></a>
              <a class="fa fa-trash btn btn-danger btn-xs" data-nm_tanah={{$d->id_parameter_kimia}} data-toggle="modal" data-target="#delete_tanah"></a>
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

   <!-- /.content -->
   @include('admin.include.data_tanah.modal_tambah_tanah')
   @include('admin.include.data_tanah.modal_edit_tanah')
   @include('admin.include.data_tanah.modal_delete_tanah')

@section('data_table')
<!-- DataTables -->
<script src="{{asset('Admin/bower_components/datatables.net/js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('Admin/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js')}}"></script>
@endsection

   @section('script_table')
    <script>
   $(function () {
     $('#data_tanah').DataTable({
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
