@extends('layouts.layoutauditor')
@section('title','Halaman Pengukuran')
@section('active_data_pengukuran','active')
@section('active_pengukuran_plot','active')
@section('breadcrumb')
<!-- <li><a href="{{route('auditor.klaster.data_klaster.detail', encrypt($id_klaster_plot))}}">Detail Klaster</a></li> -->
<li><a href="#">Data Indikator</a></li>
@endsection
@section('main_section')
  <div class="row">
    <div class="col-xs-12">
      <div class="box">
        <div class="box-header">
          <h3 class="box-title">Data Indikator</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <div class="col-xs-12 table-responsive">
          <table id="data_klaster" class="table table-bordered table-striped">
            <thead>
            <tr>
              <th style="width:5%">No.</th>
              <th>Nama Indikator</th>
              <th style="width:5%">Aksi</th>
            </tr>
            </thead>
            <tbody>

            <tr>
              <td>1</td>
              <td>Produktivitas</td>
              <td>
              <a class="fa fa-search btn btn-success btn-xs" data-info="" href="{{route('auditor.pengukuran_produktivitas', encrypt($id))}}"></a>
              </td>
            </tr>

            <tr>
              <td>2</td>
              <td>Vitalitas</td>
              <td>
              <a class="fa fa-search btn btn-success btn-xs" data-info="" href="{{route('auditor.pengukuran_vitalitas', encrypt($id))}}"></a>
              </td>
            </tr>

            <tr>
              <td>3</td>
              <td>Biodiversitas</td>
              <td>
              <a class="fa fa-search btn btn-success btn-xs" data-info="" href="{{route('auditor.pengukuran_biodiversitas', encrypt($id))}}"></a>
              </td>
            </tr>

            <tr>
              <td>4</td>
              <td>Kualitas Tapak</td>
              <td>
              <a class="fa fa-search btn btn-success btn-xs" data-info="" href="{{route('auditor.pengukuran_ktk', encrypt($id))}}"></a>
              </td>
            </tr>

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
@push('script_tambahan')
  <script src="{{asset('Admin/modal_ajax.min.js')}}"></script>
@endpush
@section('data_table')
<!-- DataTables -->
<script src="{{asset('Admin/bower_components/datatables.net/js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('Admin/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js')}}"></script>
@endsection

  <!-- jquery untuk mengatur datatable -->
   @section('script_table')
   <script>
   $(function () {
     $('#data_klaster').DataTable({
       'paging'      : true,
       'lengthChange': true,
       'searching'   : true,
       'ordering'    : true,
       "order"       : [[ 0, "asc" ]],
       'info'        : true,
       'autoWidth'   : false,
       'lengthMenu'  : [[5,10,20],[5,10,20]],
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