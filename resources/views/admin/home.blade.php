@extends('layouts.adminlayout')
@section('title','Halaman Utama')
@section('active_home','active')
@section('judul_halaman','Sistem Informasi Penilaian Kesehatan Hutan')
@section('breadcrumb')
<li><a href="#"><i class="fa fa-fw fa-home"></i>Home</a></li>
@endsection
@section('main_section')
      <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-teal">
            <div class="inner">
              <h3>{{$jumlah_user}}</h3>

              <p>Pengguna Terdaftar</p>
            </div>
            <div class="icon">
              <i class="ion ion-person-add"></i>
            </div>
            <a href="{{route('admin.user')}}" class="small-box-footer">Selengkapnya <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>

        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-green">
              <div class="inner">
                <h3>{{$jumlah_sifat}}</h3>

                <p>Data Sifat Tanah</p>
              </div>
              <div class="icon">
                <i class="fa fa-fw fa-road"></i>
              </div>
              <a href="{{route('admin.sifat_tanah')}}" class="small-box-footer">Selengkapnya <i class="fa fa-arrow-circle-right"></i></a>
            </div>
          </div>

          <div class="col-lg-3 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-primary">
                <div class="inner">
                  <h3>{{$jumlah_pohon}}</h3>

                  <p>Jenis Pohon Ditemukan</p>
                </div>
                <div class="icon">
                  <i class="fa fa-fw fa-tree"></i>
                </div>
                <a href="{{route('admin.pohon')}}" class="small-box-footer">Selengkapnya <i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div>

            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-maroon">
                  <div class="inner">
                    <h3>{{$jumlah_fauna}}</h3>

                    <p>Jenis Fauna Ditemukan</p>
                  </div>
                  <div class="icon">
                    <i class="fa fa-fw fa-paw"></i>
                  </div>
                  <a href="{{route('admin.fauna')}}" class="small-box-footer">Selengkapnya <i class="fa fa-arrow-circle-right"></i></a>
                </div>
              </div>

              <div class="row">
                <div class="col-xs-12">
                  <div class="box">
                    <div class="box-header">

                      <h3 class="box-title">Riwayat Login</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                      <div class="col-xs-12 table-responsive">
                      <table id="riwayat_login" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                          <th style="width:4%">Nomor</th>
                          <th>Nama Pengguna</th>
                          <th style="width:20%">Waktu login</th>
                          <th style="width:20%">Waktu logout</th>
                        </tr>
                        </thead>
                        <tbody>
                          @php($nomor=1) @foreach($riwayat as $riwayat)
                          <tr>
                            <td style="width:4%">{{$nomor++}}</td>
                            <td>{{$riwayat->username}}</td>
                            <td>{{$riwayat->time_login}}</td>
                            <td>{{$riwayat->time_logout}}</td>
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
              @section('data_table')
              <!-- DataTables -->
              <script src="{{asset('Admin/bower_components/datatables.net/js/jquery.dataTables.min.js')}}"></script>
              <script src="{{asset('Admin/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js')}}"></script>
              @endsection

                 @section('script_table')
                    <script>
                 $(function () {
                   $('#riwayat_login').DataTable({
                     'paging'      : true,
                     'lengthChange': true,
                     'searching'   : true,
                     'ordering'      :false,
                     'info'        : true,
                     'autoWidth'   : false,
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
