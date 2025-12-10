@extends('layouts.layout')
@section('title','Nilai Tertimbang')
@section('active_plot_ukur','active')
@section('active_data_klaster','active')
@section('breadcrumb')
<li><a href="{{route('user.data_klaster')}}">Data Klaster</a></li>
<li><a href="#">Nilai Tertimbang</a></li>
@endsection
@section('main_section')
  <div class="row">
    <div class="col-xs-12">
      <div class="box">
        <div class="box-header">

          <h3 class="box-title">Nilai Tertimbang {{$nama->kategori}}</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <div class="col-xs-12 table-responsive">
          <table id="nilai_tertimbang" class="table table-bordered table-striped">
            <thead>
            <tr>
              <th style="width:4%">Nomor</th>
              <th>Nama Parameter</th>
              <th>Nilai</th>
              <th style="width:5%">Aksi</th>
            </tr>
            </thead>
            <tbody>

              <tr>
                <td style="vertical-align: middle">1.</td>
                <td style="vertical-align: middle">Produktivitas</td>
                <td style="vertical-align: middle">{{$data_nilai->nilai_prod}}</td>
                <td style="vertical-align: middle">
                  <a class="btn btn-warning btn-md" data-ntid="{{$data_nilai->id}}" data-param="{{$data_nilai->nilai_prod}}" data-nama="Produktivitas" data-toggle="modal" data-target="#edit_nt"> <i class="fa fa-edit"></i> </a>
                </td>
              </tr>

              <tr>
                <td style="vertical-align: middle">2.</td>
                <td style="vertical-align: middle">Kerusakan Pohon</td>
                <td style="vertical-align: middle">{{$data_nilai->nilai_kphn}}</td>
                <td style="vertical-align: middle">
                  <a class="btn btn-warning btn-md" data-ntid="{{$data_nilai->id}}" data-param="{{$data_nilai->nilai_kphn}}" data-nama="Kerusakan Pohon" data-toggle="modal" data-target="#edit_nt"> <i class="fa fa-edit"></i> </a>
                </td>
              </tr>

              <tr>
                <td style="vertical-align: middle">3.</td>
                <td style="vertical-align: middle">Kondisi Tajuk</td>
                <td style="vertical-align: middle">{{$data_nilai->nilai_ktjk}}</td>
                <td style="vertical-align: middle">
                  <a class="btn btn-warning btn-md" data-ntid="{{$data_nilai->id}}" data-param="{{$data_nilai->nilai_ktjk}}" data-nama="Kondisi Tajuk" data-toggle="modal" data-target="#edit_nt"> <i class="fa fa-edit"></i> </a>
                </td>
              </tr>

              <tr>
                <td style="vertical-align: middle">4.</td>
                <td style="vertical-align: middle">Biodiversitas Pohon</td>
                <td style="vertical-align: middle">{{$data_nilai->nilai_kjpb}}</td>
                <td style="vertical-align: middle">
                  <a class="btn btn-warning btn-md" data-ntid="{{$data_nilai->id}}" data-param="{{$data_nilai->nilai_kjpb}}" data-nama="Biodiversitas Pohon" data-toggle="modal" data-target="#edit_nt"> <i class="fa fa-edit"></i> </a>
                </td>
              </tr>

              <tr>
                <td style="vertical-align: middle">5.</td>
                <td style="vertical-align: middle">Biodiversitas Fauna</td>
                <td style="vertical-align: middle">{{$data_nilai->nilai_kjfb}}</td>
                <td style="vertical-align: middle">
                  <a class="btn btn-warning btn-md" data-ntid="{{$data_nilai->id}}" data-param="{{$data_nilai->nilai_kjfb}}" data-nama="Biodiversitas Fauna" data-toggle="modal" data-target="#edit_nt"> <i class="fa fa-edit"></i> </a>
                </td>
              </tr>

              <tr>
                <td style="vertical-align: middle">6.</td>
                <td style="vertical-align: middle">Kualitas Tapak (Kimia)</td>
                <td style="vertical-align: middle">{{$data_nilai->nilai_ktpk}}</td>
                <td>
                  <a class="btn btn-warning btn-md" data-ntid="{{$data_nilai->id}}" data-param="{{$data_nilai->nilai_ktpk}}" data-nama="Kualitas Tapak" data-toggle="modal" data-target="#edit_nt"> <i class="fa fa-edit"></i> </a>
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

   <!-- /.content -->


   <script src="{{asset('Admin/modal_ajax.min.js')}}"></script>
   <script src="{{asset('Admin/bower_components/jquery/dist/jquery.min.js')}}"></script>
   {{-- include modal --}}
   @include('user.include.nilai_tertimbang.modal-edit-nt')


@section('data_table')
<!-- DataTables -->
<script src="{{asset('Admin/bower_components/datatables.net/js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('Admin/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js')}}"></script>
@endsection

   @section('script_table')
   <script>
   $(function () {
     $('#nilai_tertimbang').DataTable({
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
