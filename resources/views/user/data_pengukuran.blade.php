@extends('layouts.layout')
@section('title','Halaman Pengukuran')
@section('active-treeview','active')
@section('active_pengukuran','active')
@section('breadcrumb')
<li><a href="{{route('user.home')}}"><i class="fa fa-dashboard"></i> Home</a></li>
<li><a href="#">Data Pengukuran</a></li>
@endsection
@section('main_section')
  <div class="row">
    <div class="col-xs-12">
      <div class="box">
        <div class="box-header">
          <h3 class="box-title">Data Pengukuran</h3>
          <button type="button" class=" btn btn-primary btn-xs pull-right" data-toggle="modal" data-target="#tambah3">
            <i class="fa fa-plus"></i></button>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <table id="data_pengukuran" class="table table-bordered table-striped">
            <thead>
            <tr>
              <th style="width:4%">No.</th>
              <th style="width:10%">Provinsi</th>
              <th style="width:20%">Kabupaten</th>
              <th style="width:10%">Kecamatan</th>
              <th style="width:7%">Klaster Plot</th>
              <th style="width:10%">Kepemilikan</th>
              <th style="width:17%">Tipe Hutan</th>
              <th style="width:7%">Fungsi Hutan</th>
              <th style="width:7%">Luas Hutan</th>
              <th style="width:8%">Aksi</th>
            </tr>
            </thead>
            <tbody>
              @php ($id=1) @foreach($data as $d)
            <tr>
              <td>{{$id}}</td>
              <td>{{$d->nama_provinsi}}</td>
              <td>{{$d->nama_kabupaten}}</td>
              <td>{{$d->nama_kecamatan}}</td>
              <td>{{$d->nama_klaster}}</td>
              <td>{{$d->hak_milik}}</td>
              <td>{{$d->nama}}</td>
              <td>{{$d->fungsi}}</td>
              <td>{{$d->luas}} ha</td>
              <td>
              <a class="fa fa-search btn btn-success btn-xs" data-info="" href="{{route('user.detail_klaster', encrypt($d->id_klaster_plot))}}"></a>
              <a class="fa fa-edit btn btn-warning btn-xs" data-klasterid={{$d->id_klaster_plot}} data-toggle="modal" data-target="#edit_pengukuran" href=""></a>
              <a class="fa fa-fire btn btn-info btn-xs" data-info="" href="{{route('user.isi_nilai_tertimbang', encrypt($d->id_klaster_plot))}}"></a>
              <a class="fa fa-eraser btn btn-danger btn-xs" data-klasterid={{$d->id_klaster_plot}} data-toggle="modal" data-target="#delete_pengukuran" href=""></a>
              </td>
            </tr>
            @php ($id++)
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

   {{-- include modal --}}
   @include('user.include.data_pengukuran.modal-delete')
   @include('user.include.data_pengukuran.modal-edit')
   @include('user.include.data_pengukuran.modal-tambah3')
   {{--@include('user/include/data_pengukuran/modal-tambah')--}}

@section('data_table')
<!-- DataTables -->
<script src="{{asset('Admin/bower_components/datatables.net/js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('Admin/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js')}}"></script>
@endsection

  <!-- jquery untuk mengatur datatable -->
   @section('script_table')
   <script>
   $(function () {
     $('#data_pengukuran').DataTable({
       'paging'      : true,
       'lengthChange': true,
       'searching'   : true,
       'ordering'    : true,
       "order"       : [[ 0, "asc" ]],
       'info'        : true,
       'autoWidth'   : false,
       'lengthMenu'  : [[5,10,20],[5,10,20]]
     })
   })
    </script>
   @endsection

  @endsection
