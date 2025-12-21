@extends('layouts.layoutauditor')
@section('title','Data Pengukuran')
@section('active_data_pengukuran','active')
@section('active_biodiversitas','active')
@section('breadcrumb')
<li><a href="#">Biodiversitas Fauna</a></li>
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
             <option value="{{route('auditor.bio_fauna', encrypt($id_pengukuran))}}">{{$nama_plots[$no]}}</option>
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

<div class="row">
  <div class="col-xs-12 table">
    <div class="box">
      <div class="box-header">
    <h3>Data Biodiversitas Fauna
    </h3>
    <h4>
      <a class="btn btn-success btn-xs" href="{{route('auditor.lbds',encrypt($id))}}">Pertumbuhan</a>
      <a class="btn btn-danger btn-xs" href="{{route('auditor.kerusakan', encrypt($id))}}">Kerusakan Pohon</a>
      <a class="btn btn-warning btn-xs" href="{{route('auditor.tajuk', encrypt($id))}}">Kondisi Tajuk</a>
      <a class="btn btn-primary btn-xs" href="{{route('auditor.bio_pohon',encrypt($id))}}">Biodiversitas Pohon</a>
      <a class="btn btn-primary btn-xs" href="">Biodiversitas Fauna</a>
      <a class="btn btn-info btn-xs" href="{{route('auditor.kimia',encrypt($id))}}">Kualitas Tapak (Kimia)</a>
      <a class="btn btn-info btn-xs" href="{{route('auditor.fisika',encrypt($id))}}">Kualitas Tapak (Fisika)</a>
  </h4>
     </div>
     <div class="box-body">
       <div class="col-xs-12 table-responsive">
    <table class="table table-bordered table-striped" id="table-fauna" style="padding:10px;">
      <thead>
        <tr>
          <th style="width:5%">#</th>
          <th style="width:35%">Nama Fauna</th>
          <th style="width:35%">Nama Latin</th>
          <th style="width:15%">Jumlah</th>
        </tr>
      </thead>
      <tbody>
        @php ($nmr=1) @php($jumlah_total=0) @foreach($data_fauna as $d)
                 <tr>
                  <td>{{$nmr++}}</td>
                  <td>{{$d->nama_fauna}} </td>
                  <td><i>{{$d->nama_latin_fauna}} </i></td>
                  <td>{{$d->jumlah}} </td>
                  @php($jumlah_total+=$d->jumlah)
                 </tr>
        @endforeach
      </tbody>
      <thead>
      <tr>
        <th>Jumlah</th>
        <th></th>
        <th></th>
        <th>{{$jumlah_total}}</th>
      </tr>
      </thead>
    </table>
  </div>
</div>
</div>
</div>
</div>

@push('script_tambahan')
<script src="{{asset('Admin/modal_ajax.min.js')}}"></script>
@endpush

{{-- include modal --}}
@include('user.include.isi_pengukuran.modal_detail')
@include('user.include.isi_pengukuran.fauna.modal_tambah_fauna')
@include('user.include.isi_pengukuran.fauna.modal_edit_fauna')
@include('user.include.isi_pengukuran.fauna.modal_delete_fauna')
@include('user.include.isi_pengukuran.fauna.delete_all_fauna')
@include('user.include.import.import_fauna')

@section('script_tambahan')
<script src="{{asset('Admin/bower_components/select2/dist/js/select2.full.min.js')}}"></script>
@endsection

@section('data_table')
<!-- DataTables -->
<script src="{{asset('Admin/bower_components/datatables.net/js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('Admin/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js')}}"></script>
@endsection

@push('script_tambahan')
<script type="text/javascript">
$(document).ready(function() {


 });
</script>
@endpush

   @section('script_table')
   <script>
   $(function () {
     $('#table-fauna').DataTable({
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
