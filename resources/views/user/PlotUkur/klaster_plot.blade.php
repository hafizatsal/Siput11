@extends('layouts.layout')
@section('title','Halaman Klaster')
@section('active_plot_ukur','active')
@section('active_data_klaster_plot','active')
@section('breadcrumb')
<li><a href="{{route('user.data_klaster')}}">Data Klaster</a></li>
<li><a href="#">Data Klaster Plot</a></li>
@endsection
@section('main_section')
  <div class="row">
    <div class="col-xs-12">
      <div class="box">
        <div class="box-header">
          <h3 class="box-title">Data Klaster Plot {{$data_nama_klaster->kategori}}</h3>

          @if($ijin==Auth::user()->id)
          <button type="button" class=" btn btn-primary btn-xs pull-right custom_button" data-toggle="modal" data-target="#tambah_klaster_plot" data-backdrop="static" data-keyboard="false">
            <i class="fa fa-plus"></i> Tambah Klaster Plot</button>
          @endif
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <div class="col-xs-12 table-responsive">
          <table id="data_klaster_plot" class="table table-bordered table-striped">
            <thead>
            <tr>
              <th style="width:4%; text-align: center; vertical-align: middle">No.</th>
              <th style="width:10%; text-align: center; vertical-align: middle">Provinsi</th>
              <th style="width:20%; text-align: center; vertical-align: middle">Kabupaten</th>
              <th style="width:10%; text-align: center; vertical-align: middle">Kecamatan</th>
              <th style="width:7%; text-align: center; vertical-align: middle">Klaster Plot</th>
              <th style="width:10%; text-align: center; vertical-align: middle">Status <br> Lahan</th>
              <th style="width:10%; text-align: center; vertical-align: middle">Tipe Hutan</th>
              <th style="width:7%; text-align: center; vertical-align: middle">Fungsi Hutan</th>
              <th style="width:7%; text-align: center; vertical-align: middle">Luas Hutan</th>
              @if($ijin==Auth::user()->id)
              <th style="width:15%; text-align: center; vertical-align: middle">Aksi</th>
              @else
              <th style="width:7%; text-align: center; vertical-align: middle">Aksi</th>
              @endif
            </tr>
            </thead>
            <tbody>
              @php ($id=1) @foreach($data_klaster_plot as $d)
            <tr>
              <td style="vertical-align: middle" height="50">{{$id}}.</td>
              <td style="vertical-align: middle">{{$d->nama_provinsi}}</td>
              <td style="vertical-align: middle">{{$d->nama_kabupaten}}</td>
              <td style="vertical-align: middle">{{$d->nama_kecamatan}}</td>
              <td style="vertical-align: middle">{{$d->nama_klaster}}</td>
              <td style="vertical-align: middle">{{$d->hak_milik}}</td>
              <td style="vertical-align: middle">{{$d->tipe_hutan}}</td>
              <td style="vertical-align: middle">{{$d->fungsi}}</td>
              <td style="vertical-align: middle">{{$d->luas}} ha</td>
              <td style="vertical-align: middle">
              <a style="margin-top:10px" class="btn btn-success btn-xs" data-info="" href="{{route('user.detail_klaster', encrypt($d->id_klaster_plot))}}"> <i class="fa fa-search"></i> </a>
              @if($ijin==Auth::user()->id)
              <a style="margin-top:10px" class="btn btn-warning btn-xs" data-klasterid={{$d->id_klaster_plot}} data-toggle="modal" data-target="#edit_klaster_plot" href=""> <i class="fa fa-edit"></i> </a>
              <a style="margin-top:10px" class="btn btn-danger btn-xs" data-klasterid={{$d->id_klaster_plot}} data-toggle="modal" data-target="#delete_klaster_plot" href=""> <i class="fa fa-trash"></i> </a>
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
@include('user.include.data_klaster.modal-tambah_klaster_plot')
@include('user.include.data_klaster.modal-edit_klaster_plot')
@include('user.include.data_klaster.modal-delete_klaster_plot')

@section('data_table')
<!-- DataTables -->
<script src="{{asset('Admin/bower_components/datatables.net/js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('Admin/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js')}}"></script>
@endsection

  <!-- jquery untuk mengatur datatable -->
   @section('script_table')
    <script>
   $(function () {
     $('#data_klaster_plot').DataTable({
       'paging'      : true,
       'lengthChange': true,
       'searching'   : true,
       'ordering'    : true,
       "order"       : [[ 0, "asc" ]],
       'info'        : true,
       'autoWidth'   : false,
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
