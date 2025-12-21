@extends('layouts.layout')
@section('title','Data Pengukuran')
@section('active_data_pengukuran','active')
@section('active_kualitas_tapak','active')
@section('breadcrumb')
<li><a href="{{route('user.data_indikator', encrypt($id))}}">Data Indikator</a></li>
<li><a href="{{route('user.pengukuran_ktk',encrypt($id))}}">Paramater Kualitas Tapak</a></li>
<li><a href="#">Kualitas Tapak Fisika</a></li>
@endsection
@section('main_section')


<div class="row">
   <div class="col-xs-12">
     <div class="box">
       <div class="box-header">
           <h2><i class="fa fa-globe"></i> Data Pengukuran Plot
             <a style="margin-left:10px;" class="btn btn-info pull-right" data-toggle="modal" data-target="#modal_detail" href="#"><i class="fa fa-fw fa-info-circle"></i>Detail</a>
           </h2>
       </div>
        <div class="box-body">
       <div class="col-xs-12 table-responsive">
       <table id="detail_plot" class="table table-striped">
         <tbody>
           <tr>
             <td>Pilih Plot</td>
             <td> :
           <select id="pilihplot" name="pilihplot" onchange="location = this.value;">
             <option value="">Pilih Plot</option>
            @php($no=0) @foreach($id_pengukuran as $id_pengukuran)
             <option value="{{route('user.fisika', encrypt($id_pengukuran))}}">{{$nama_plots[$no]}}</option>
             @php($no++)
             @endforeach
           </select>
           </td>
           </tr>
          <tr>
            <td>Plot Aktif</td>
            <td> : {{ $data_pengukuran->nama_plot ?? '-' }} (Pengukuran ke-{{ $data_pengukuran->pengukuran_ke ?? '-' }})</td>
          </tr>
         </tbody>
         <tfoot>

         </tfoot>
       </table>
     </div>
   </div>
 </div>
</div>
</div>
@if($data_pengukuran->nama_plot!="PLOT 1")
<div class="row">

  <div class="col-xs-12">
    <div class="box collapsed-box">
      <div class="box-header">
        <div class="box-tools pull-right">
          <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
          </button>
        </div>
          <h2> <i class="fa fa-fw fa-camera"></i>Foto Dokumentasi
            <a style="margin-left:10px;" class="btn btn-primary pull-right" data-toggle="modal" data-target="#modal_tambah_foto" href="#"><i class="fa fa-fw fa-plus"></i>Tambah</a>
          </h2>
        </div>
        <div class="box-body">
          @if(count($data_foto_pengukuran)!=0)
          @foreach($data_foto_pengukuran as $data_foto_pengukuran)
          <div class="gallery">
            <a target="_blank" href="{{asset('upload/pengukuran/ktk/'. $data_foto_pengukuran->filename)}}">
              <img src="{{asset('upload/pengukuran/ktk/'. $data_foto_pengukuran->filename)}}" alt="{{$data_foto_pengukuran->title}}" width="600" height="400">
            </a>
            <div class="desc">{{$data_foto_pengukuran->keterangan}}</div>
            <div style="margin-bottom: 50px" class="footer-gallery">
              <a style="margin-left: 10px;" type="button" name="edit_foto_pengukuran" id="edit_foto_pengukuran" data-foto="{{$data_foto_pengukuran->id_foto_ktk}}" class="btn btn-warning pull-left"  data-toggle="modal" data-target="#modal_edit_foto">edit</a>
              <a style="margin-right: 10px;" type="button" name="delete_foto_pengukuran" id="delete_foto_pengukuran" data-foto="{{$data_foto_pengukuran->id_foto_ktk}}" class="btn btn-danger pull-right"  data-toggle="modal" data-target="#modal_delete_foto">delete</a>
            </div>
          </div>
          @endforeach

          @else
          Belum ada foto yang ditambahkan!
          @endif
        </div>
      </div>
    </div>
  </div>
@endif
<!-- /.content -->
<div class="row">
  <div class="col-xs-12 table">
    <div class="box">
        <div class="box-header">
          <h3>Data Kualitas Tapak (Fisika)
            @if($data_pengukuran->nama_plot!="PLOT 1" && count($data_fisik)==0)
            <a class="btn btn-info pull-right" data-klasterid="" data-toggle="modal" data-target="#modal_tambah_fisik" href=""><i class="fa fa-plus"></i></a>
            @endif
          </h3>
          <h4>
            <a class="btn btn-success btn-xs" href="{{route('user.lbds', encrypt($id))}}">Pertumbuhan</a>
            <a class="btn btn-danger btn-xs" href="{{route('user.kerusakan', encrypt($id))}}">Kerusakan Pohon</a>
            <a class="btn btn-warning btn-xs" href="{{route('user.tajuk', encrypt($id))}}">Kondisi Tajuk</a>
            <a class="btn btn-primary btn-xs" href="{{route('user.bio_pohon',encrypt($id))}}">Biodiversitas Pohon</a>
            <a class="btn btn-primary btn-xs" href="{{route('user.bio_fauna',encrypt($id))}}">Biodiversitas Fauna</a>
            <a class="btn btn-info btn-xs" href="{{route('user.kimia',encrypt($id))}}">Kualitas Tapak (Kimia)</a>
            <a class="btn btn-info btn-xs" href="">Kualitas Tapak (Fisika)</a>
        </h4>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <div class="col-xs-12 table-responsive">
          <table id="data_ktk_fisik" class="table table-bordered table-striped">
            <thead>
            <tr>
              <th rowspan="2" style="text-align: center; vertical-align: middle">Titik Plot</th>
              <th colspan="2" style="text-align: center; vertical-align: middle">Penutupan tanah <br> %</th>
              <th rowspan="2" style="text-align: center; vertical-align: middle">Tekstur tanah</th>
              <th rowspan="2" style="text-align: center; vertical-align: middle">Warna tanah</th>
              <th rowspan="2" style="text-align: center; vertical-align: middle">Ketebalan <br> Lapisan tanah <br> (cm)</th>
              <th colspan="2" style="text-align: center; vertical-align: middle">Titik Koordinat</th>
              <th rowspan="2" style="text-align: center; vertical-align: middle">Aksi</th>
            </tr>
            <tr>
              <th style="text-align: center; vertical-align: middle">Terbuka</th>
              <th style="text-align: center; vertical-align: middle">Tertutup</th>
              <th style="text-align: center; vertical-align: middle">Lintang <br> o/U/S</th>
              <th style="text-align: center; vertical-align: middle">Bujur <br> o/B/T</th>
            </tr>
            </thead>
            <tbody>
              @php($nmr=1) @foreach($data_fisik as $data_fisik)
            <tr>
              <td>{{$data_fisik->titik_plot}}</td>
              <td>{{$data_fisik->terbuka}}</td>
              <td>{{$data_fisik->tertutup}}</td>
              <td>{{$data_fisik->tekstur}}</td>
              <td>{{$data_fisik->warna_tanah}}</td>
              <td>{{$data_fisik->ketebalan}}</td>
              <td>{{$koor_ls_ful_pt}} {{$ket_lintang_pt}}</td>
              <td>{{$koor_bt_ful_pt}} {{$ket_bujur_pt}}</td>
              <td>
                <a class="fa fa-edit btn btn-warning btn-xs" data-fisik="{{$data_fisik->id_ktk}}" data-info_pengukuran="" data-toggle="modal" data-target="#modal_edit_fisik"></a>
                <a class="fa fa-eraser btn btn-danger btn-xs" data-fisik="{{$data_fisik->id_ktk}}" data-toggle="modal" data-target="#modal_delete_ktk_fisik" href="#"></a>
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
  </div>
</div>

<script src="{{asset('Admin/modal_ajax.min.js')}}"></script>
<script src="{{asset('Admin/bower_components/jquery/dist/jquery.min.js')}}"></script>

{{-- include modal --}}
@include('user.include.isi_pengukuran.modal_detail')
@include('user.include.data_pengukuran_plot.ktk.modal_tambah_foto_pengukuran')
@include('user.include.data_pengukuran_plot.ktk.modal_edit_foto_pengukuran')
@include('user.include.data_pengukuran_plot.ktk.modal_delete_foto')
@include('user.include.isi_pengukuran.modal_tambah_ktk_fisik')
@include('user.include.isi_pengukuran.modal_edit_ktk_fisik')
@include('user.include.isi_pengukuran.modal_delete_ktk_fisik')


@section('data_table')
<!-- DataTables -->
<script src="{{asset('Admin/bower_components/datatables.net/js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('Admin/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js')}}"></script>
@endsection

   @section('script_table')
   <script>
   $(function () {
     $('#data_ktk_fisik').DataTable({
       'paging'      : true,
       'lengthChange': true,
       'searching'   : true,
       'ordering'    : false,
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

