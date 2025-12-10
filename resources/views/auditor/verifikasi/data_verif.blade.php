@extends('layouts.layoutauditor')
@section('title','Halaman Data Verifikasi')
@section('active_verif','active')
@section('css')
<link rel="stylesheet" href="{{asset('Admin/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css')}}">
@endsection
@section('breadcrumb')
<li><a href="{{route('auditor.data_klaster')}}">Data Verifikasi</a></li>
@endsection
@section('main_section')
    <div class="row">
      <div class="col-xs-12">
      <div class="box">
        <div class="box-header">
          <h3 class="box-title">Data Kategori Klaster</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <div class="col-xs-12 table-responsive">
          <table id="data_kategori_klaster" class="table table-bordered table-hover">
            <thead>
            <tr>
              <th style="width:5%; text-align: center; vertical-align: middle">No.</th>
              <th style="width:5%; text-align: center; vertical-align: middle">Pengukuran Ke</th>
              <th style="width:17%; text-align: center; vertical-align: middle">Tahun Pengukuran</th>
              <th style="width:18%; text-align: center; vertical-align: middle">Nama Pengukur</th>
              <th style="width:25%; text-align: center; vertical-align: middle">Kategori</th>
              <th style="width:10%; text-align: center; vertical-align: middle">Penginput</th>
              <th style="width:15%; text-align: center; vertical-align: middle">Status Verifikasi</th>
            </tr>
            </thead>
            <tbody>
              @php ($id=1) @foreach($data_klaster as $d)
            <tr>
              <td style="vertical-align: middle">{{$id}}.</td>
              <td style="vertical-align: middle">{{$d->pengukuran_ke}}</td>
              <td style="vertical-align: middle">{{$d->tahun_pengukuran}}</td>
              <td style="vertical-align: middle">{{$d->nama_pengukur}}</td>
              <td style="vertical-align: middle">{{$d->kategori}}<span id="add_here"></span></td>
              <td style="vertical-align: middle">{{$d->username}}</td>
              <td style="vertical-align: middle">
                @if($d->verif==0)
              <a class="btn btn-danger btn-xs" data-data_klaster={{$d->id_data_klaster}} data-toggle="modal" data-target="#modal_verif_data_klaster" href=""> <i class="fa fa-close"></i> Belum diverifikasi</a>
                @else
              <a class="btn btn-success btn-xs" data-data_klaster={{$d->id_data_klaster}} data-toggle="modal" data-target="#modal_unverif_data_klaster" href=""> <i class="fa fa-check"></i> Terverifikasi</a>
                @endif
              </td>
            </tr>
            @php ($id++)
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

@include('auditor.include.verifikasi.modal_verif_data_klaster')
@include('auditor.include.verifikasi.modal_unverif_data_klaster')
@section('data_table')
<!-- DataTables -->
<script src="{{asset('Admin/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js')}}"></script>
<script src="{{asset('Admin/bower_components/datatables.net/js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('Admin/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js')}}"></script>
@endsection
  <!-- jquery untuk mengatur datatable -->
   @section('script_table')
    <script>
   $(function () {
     $('#data_kategori_klaster').DataTable({
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
         "info"         : "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
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
