@extends('layouts.adminlayout')
@section('title','Halaman Pengukuran')
@section('active-treeview','active')
@section('active_pengukuran','active')

@section('main_section')
  <div class="row">
    <div class="col-xs-12">
      <div class="box">
        <div class="box-header">
          <h3 class="box-title">Data Pengukuran Admin</h3>
          <button type="button" class=" btn btn-primary btn-xs" data-toggle="modal" data-target="#tambah">
            <i class="fa fa-plus"></i></button>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <table id="data_pengukuran" class="table table-bordered table-striped">
            <thead>
            <tr>
              <th>Provinsi</th>
              <th>Kabupaten</th>
              <th>Kecamatan</th>
              <th>Klaster Plot</th>
              <th>Kepemilikan</th>
              <th>Tipe Hutan</th>
              <th>Fungsi Hutan</th>
              <th>Luas Hutan</th>
              <th>Aksi</th>
            </tr>
            </thead>
            <tbody>
              @php ($id=1) @foreach($data as $d)
            <tr>
              <td>{{$id++}}</td>
              <td>{{$d->nama_klaster}}</td>
              <td>{{$d->pengelola}}</td>
              <td>{{$d->koordinatLS}},{{$d->koordinatBT}}</td>
              <td>{{$d->luas}}</td>
              <td>{{$d->pola_tanam}}</td>
              <td>{{$d->tahun_tanam}}</td>
              <td>{{$d->tahun_tanam}}</td>
              <td>
              <a class="fa fa-plus btn btn-info btn-xs" data-info=""href="#"></a>
              <a class="fa fa-edit btn btn-warning btn-xs" data-toggle="modal" data-target="#edit_pengukuran" href="#"></a>
              <a class="fa fa-trash btn btn-danger btn-xs" data-toggle="modal" data-target="#delete_pengukuran" href=""></a>
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

   {{-- include modal --}}
   @include('user.include.data_pengukuran.modal-tambah')
   @include('user.include.data_pengukuran.modal-delete')
   @include('user.include.data_pengukuran.modal-edit')
   {{--//include modal --}}
   {{--@include('user/include/data_pengukuran/scripts')--}}


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
