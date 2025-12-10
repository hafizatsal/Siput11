@extends('layouts.layoutauditor')
@section('title','Data Pengukuran')
@section('active_data_pengukuran','active')
@section('active_kualitas_tapak','active')
@section('breadcrumb')
<li><a href="#">Kualitas Tapak Fisik</a></li>
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
             <option value="{{route('auditor.fisika', encrypt($id_pengukuran))}}">{{$nama_plots[$no]}}</option>
             @php($no++)
             @endforeach
           </select>
            </td>
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
            <div style="margin-bottom: 10px" class="footer-gallery">
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
          <h3>Data Kualitas Tapak (Fisik)
          </h3>
          <h4>
            <a class="btn btn-success btn-xs" href="{{route('auditor.lbds', encrypt($id))}}">Pertumbuhan</a>
            <a class="btn btn-danger btn-xs" href="{{route('auditor.kerusakan', encrypt($id))}}">Kerusakan Pohon</a>
            <a class="btn btn-warning btn-xs" href="{{route('auditor.tajuk', encrypt($id))}}">Kondisi Tajuk</a>
            <a class="btn btn-primary btn-xs" href="{{route('auditor.bio_pohon',encrypt($id))}}">Biodiversitas Pohon</a>
            <a class="btn btn-primary btn-xs" href="{{route('auditor.bio_fauna',encrypt($id))}}">Biodiversitas Fauna</a>
            <a class="btn btn-info btn-xs" href="{{route('auditor.kimia',encrypt($id))}}">Kualitas Tapak (Kimia)</a>
            <a class="btn btn-info btn-xs" href="">Kualitas Tapak (Fisik)</a>
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
@include('auditor.include.isi_pengukuran.modal_detail')
@include('auditor.include.data_pengukuran_plot.ktk.modal_tambah_foto_pengukuran')
@include('auditor.include.data_pengukuran_plot.ktk.modal_edit_foto_pengukuran')
@include('auditor.include.data_pengukuran_plot.ktk.modal_delete_foto')
@include('auditor.include.isi_pengukuran.modal_tambah_ktk_fisik')
@include('auditor.include.isi_pengukuran.modal_edit_ktk_fisik')
@include('auditor.include.isi_pengukuran.modal_delete_ktk_fisik')


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
