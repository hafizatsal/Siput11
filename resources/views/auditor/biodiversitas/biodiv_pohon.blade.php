@extends('layouts.layoutauditor')
@section('title','Data Pengukuran')
@section('active_data_pengukuran','active')
@section('active_biodiversitas','active')
@section('breadcrumb')
<li><a href="#">Biodiversitas Pohon</a></li>
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
             <option value="{{route('auditor.bio_pohon', encrypt($id_pengukuran))}}">{{$nama_plots[$no]}}</option>
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

<!-- /.content -->
<div class="row">
  <div class="col-xs-12 table">
    <div class="box">
        <div class="box-header">
          <h3>Data Pohon Plot
          </h3>
          <h4>
            <a class="btn btn-success btn-xs" href="{{route('auditor.lbds',encrypt($id))}}">Pertumbuhan</a>
            <a class="btn btn-danger btn-xs" href="{{route('auditor.kerusakan', encrypt($id))}}">Kerusakan Pohon</a>
            <a class="btn btn-warning btn-xs" href="{{route('auditor.tajuk', encrypt($id))}}">Kondisi Tajuk</a>
            <a class="btn btn-primary btn-xs" href="">Biodiversitas Pohon</a>
            <a class="btn btn-primary btn-xs" href="{{route('auditor.bio_fauna',encrypt($id))}}">Biodiversitas Fauna</a>
            <a class="btn btn-info btn-xs" href="{{route('auditor.kimia',encrypt($id))}}">Kualitas Tapak (Kimia)</a>
            <a class="btn btn-info btn-xs" href="{{route('auditor.fisika',encrypt($id))}}">Kualitas Tapak (Fisik)</a>
        </h4>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <div class="col-xs-12 table-responsive">
          <table id="data_pohon_plot" class="table table-bordered table-striped">
            <thead>
            <tr>
              <th style="width:4%">#</th>
              <th style="width:30%">Nama Pohon</th>
              <th style="width:25%">Nama Latin</th>
              <th style="width:10%" class="status">Status</th>
            </tr>
            </thead>
            <tbody>
              @php ($nmr=1) @foreach($data_pohon as $d)
            <tr>
              <td>{{$nmr++}}</td>
              <td>{{$d->nama_tanaman}} </td>
              <td><i>{{$d->nama_latin}}</i> </td>
               @if($d->status==1)
              <td>
                <a class="btn btn-success btn-xs" data-info="0" data-pohon="{{$d->id_tanaman_plot}}" data-toggle="modal" data-target="#">Hidup</a>
              </td>
                @else
                <td>
                <a class="btn btn-danger btn-xs" data-info="1" data-pohon="{{$d->id_tanaman_plot}}" data-toggle="modal" data-target="#">Mati</a>
                </td>
                @endif

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

<div class="row">
 <div class="col-xs-12 table">
  <div class="box">
  <div class="box-header">
   <h2>Data Biodiversitas Pohon dalam Plot
   </h2> &nbsp
 </div>
<div class="box-body">
   <table id="data_biodiv_plot" class="table table-bordered table-striped">
     <thead>
       <tr>
         <th style="width:5%">#</th>
         <th style="width:42%">Nama Pohon</th>
         <th style="width:43%">Nama Latin Pohon</th>
         <th style="width:10%">Jumlah</th>
       </tr>
       </thead>
       <tbody>
@php ($nmr=1) @php($jumlah_individu=0) @php($jumlah_seluruh=0)
@php($jumlah_total=0)
 @foreach($jumlah_pohon as $j)
       <tr>
        <td>{{$nmr++}}</td>
        <td>{{$j->nama_tanaman}}</td>
        <td><i>{{$j->nama_latin}}</i></td>
        <td>{{$j->jumlah}}</td>
        @php($jumlah_individu+=$j->jumlah)

       </tr>
@endforeach
  </tbody>
<thead>
  <th>Jumlah</th>
  <th></th>
  <th></th>
  <th>{{$jumlah_individu}}</th>
</thead>
   </table>
 </div>
</div>
</div>
</div>

<script src="{{asset('Admin/modal_ajax.min.js')}}"></script>

{{-- include modal --}}
@include('user.include.isi_pengukuran.modal_detail')
@include('user.include.isi_pengukuran.modal_tambah_tanaman')
@include('user.include.isi_pengukuran.pohon.modal_status_pohon')
@include('user.include.isi_pengukuran.pohon.modal_edit_pohon')
@include('user.include.isi_pengukuran.pohon.modal_delete_pohon')
@include('user.include.isi_pengukuran.pohon.delete_all_pohon')
@include('user.include.import.import_pohon')

@section('data_table')
<!-- DataTables -->
<script src="{{asset('Admin/bower_components/datatables.net/js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('Admin/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js')}}"></script>
@endsection

   @section('script_table')
    <script>
   $(function () {
     $('#data_pohon_plot').DataTable({
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

   $(function () {
     $('#data_biodiv_plot').DataTable({
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
