@extends('layouts.layout')
@section('title','Halaman Pertumbuhan')
@section('active-treeview','active')
@section('active_pengukuran','active')
@section('breadcrumb')
<li><a href="#">Data Pertumbuhan</a></li>
@endsection
@section('main_section')
  <div class="row">
    <div class="col-xs-12">
      <div class="box">
        <div class="box-header">
          <h3 class="box-title">Data Pertumbuhan</h3>
          <button type="button" class=" btn btn-primary btn-xs pull-right" data-toggle="modal" data-target="#tambah3">
            <i class="fa fa-plus"></i></button>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <table id="data_pertumbuhan" class="table table-bordered table-striped">
            <thead>
            <tr>
              <th>No.</th>
              <th>Nama Pohon</th>
              <th>Nama Latin</th>
              <th>Jarak</th>
              <th>Keliling</th>
              <th>Diameter</th>
              <th>Tinggi</th>
              <th>Lbds</th>
              <th>v</th>
              <th>Aksi</th>
            </tr>
            </thead>
            <tbody>
              @php ($id=1) @foreach($data_pohon as $d)
            <tr>
              <td>{{$id++}}</td>
              <td>{{$d->nama_tanaman}}</td>
              <td>{{$d->nama_latin}}</td>
              <td>{{$d->jarak}}</td>
              <td>{{$d->keliling}}</td>
              <td>{{$d->jarijari}}</td>
              <td>{{$d->tinggi}}</td>
              <td>{{$d->Hasil_LBDS}}</td>
              <td>{{$d->v}}</td>
              <td>
                <a class="fa fa-edit btn btn-warning btn-xs" data-info="{{$d->id_tanaman_plot}}" data-info_pengukuran="{{$data_pengukuran->id_pengukuran}}" data-toggle="modal" data-target="#modal_tambah_pertumbuhan"></a>
                <a class="fa fa-eraser btn btn-danger btn-xs" data-klasterid= data-toggle="modal" data-target="" href=""></a>
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

  <script src="{{asset('Admin/modal_ajax.min.js')}}"></script>
  <script src="{{asset('Admin/bower_components/jquery/src/jquery.js')}}"></script>
  <script src="{{asset('Admin/bower_components/jquery/dist/jquery.min.js')}}"></script>

  @include('auditor.include.data_pengukuran_plot.pertumbuhan.pertumbuhan')

@section('data_table')
<!-- DataTables -->
<script src="{{asset('Admin/bower_components/datatables.net/js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('Admin/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js')}}"></script>
@endsection

  <!-- jquery untuk mengatur datatable -->
   @section('script_table')
   <script>
   $(function () {
     $('#data_pertumbuhan').DataTable({
       'paging'      : true,
       'lengthChange': true,
       'searching'   : true,
       'ordering'    : true,
       "order"       : [[ 0, "asc" ]],
       'info'        : true,
       'autoWidth'   : false
     })
   })
    </script>
   @endsection

  @endsection
