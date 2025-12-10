@extends('layouts.adminlayout')
@section('title','Manajemen User')
@section('active_user','active')
@section('breadcrumb')
<li><a href="{{route('admin.home')}}"><i class="fa fa-fw fa-home"></i> Home</a></li>
<li><a href="#">Data User</a></li>
@endsection
@section('main_section')
  <div class="row">
    <div class="col-xs-12">
      <div class="box">
        <div class="box-header">
          <h3 class="box-title">Data User</h3>
          <button type="button" class=" btn btn-primary btn-xs pull-right" data-toggle="modal" data-target="#tambah_user">
            <i class="fa fa-plus"></i></button>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <div class="col-xs-12 table-responsive">
          <table id="data_user" class="table table-bordered table-striped">
            <thead>
            <tr>
              <th style="width:4%">No.</th>
              <th>Nama</th>
              <th>Username</th>
              <th style="width:25%">Email</th>
              <th style="width:15%">Terakhir Login</th>
              <th style="width:15%">Terakhir Logout</th>
              <th style="width:10%">Banned Until</th>
              <th style="width:5%">Aksi</th>

            </tr>
            </thead>
            <tbody>
              @php ($id=1) @foreach($data as $d)
            <tr>
              <td>{{$id++}}</td>
              <td>{{$d->nama}}</td>
              <td>{{$d->username}}</td>
              <td>{{$d->email}}</td>
              <td>{{$d->last_login}}</td>
              <td>{{$d->logout_time}}</td>
              <td>{{$d->blocked_date}}</td>
              <td>
                @if($d->id_role!=1)
                <a class="fa fa-gear btn btn-warning" data-toggle="modal" data-nm_user={{$d->id}} data-nm_banned={{$d->blocked_date}} data-target="#banned_user" href="#"></a>
                @endif
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


   @include('admin.include.data_user.modal_tambah_user')
   @include('admin.include.data_user.modal_edit_user')
   @include('admin.include.data_user.modal_delete_user')
   @include('admin.include.data_user.modal_banned_user')

@section('data_table')
<!-- DataTables -->
<script src="{{asset('Admin/bower_components/datatables.net/js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('Admin/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js')}}"></script>
<script src="{{asset('Admin/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js')}}"></script>
@endsection

   @section('script_table')
    <script>
   $(function () {
     $('#data_user').DataTable({
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
