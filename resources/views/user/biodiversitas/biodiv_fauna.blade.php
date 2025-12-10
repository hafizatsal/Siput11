@extends('layouts.layout')
@section('title','Data Pengukuran')
@section('active_data_pengukuran','active')
@section('active_biodiversitas','active')
@section('breadcrumb')
<li><a href="{{route('user.data_indikator', encrypt($id))}}">Data Indikator</a></li>
<li><a href="{{route('user.pengukuran_biodiversitas',encrypt($id))}}">Paramater Biodiversitas</a></li>
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
             <option value="{{route('user.bio_fauna', encrypt($id_pengukuran))}}">{{$nama_plots[$no]}}</option>
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

<div class="row">
  <div class="col-xs-12 table">
    <div class="box">
      <div class="box-header">
    <h3>Data Biodiversitas Fauna
      @if(count($data_fauna)==0)
        <a style="margin-left:10px;" class="btn btn-primary pull-right" data-toggle="modal" data-target="#modal_import_fauna" href="#"><i class="fa fa-fw fa-file-excel-o"></i>Import Fauna</a>
      @endif
      <a class="btn btn-info pull-right" data-klasterid="" data-toggle="modal" data-target="#modal_tambah_fauna" href=""><i class="fa fa-plus"></i></a>
    </h3>
    <h4>
      <a class="btn btn-success btn-xs" href="{{route('user.lbds',encrypt($id))}}">Pertumbuhan</a>
      <a class="btn btn-danger btn-xs" href="{{route('user.kerusakan', encrypt($id))}}">Kerusakan Pohon</a>
      <a class="btn btn-warning btn-xs" href="{{route('user.tajuk', encrypt($id))}}">Kondisi Tajuk</a>
      <a class="btn btn-primary btn-xs" href="{{route('user.bio_pohon',encrypt($id))}}">Biodiversitas Pohon</a>
      <a class="btn btn-primary btn-xs" href="">Biodiversitas Fauna</a>
      <a class="btn btn-info btn-xs" href="{{route('user.kimia',encrypt($id))}}">Kualitas Tapak (Kimia)</a>
      <a class="btn btn-info btn-xs" href="{{route('user.fisika',encrypt($id))}}">Kualitas Tapak (Fisik)</a>
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
          <th style="width:10%">Aksi</th>
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
                  <td>
                    <a class="fa fa-edit btn btn-warning btn-xs" data-fauna="{{$d->id_fauna}}" data-jenis="{{$d->id_master_fauna}}" data-jumlah="{{$d->jumlah}}" data-toggle="modal" data-target="#modal_edit_fauna"></a>
                    <a class="fa fa-trash btn btn-danger btn-xs" data-fauna="{{$d->id_fauna}}" data-jenis="{{$d->id_master_fauna}}" data-toggle="modal" data-target="#modal_delete_fauna"></a>
                  </td>
                 </tr>
        @endforeach
      </tbody>
      <thead>
      <tr>
        <th>Jumlah</th>
        <th></th>
        <th></th>
        <th>{{$jumlah_total}}</th>
        <th></th>
      </tr>

      <tr style="height:50px; background-color: #FFFFFF;">
        <th></th>
        <th></th>
        <th></th>
        <th></th>
        <th>
          @if(count($data_fauna)>0)
            <a class="fa fa-eraser btn btn-danger btn-xs" data-info2="{{$data_pengukuran->id_plot}}" data-pengukuran_ke="{{$data_pengukuran->pengukuran_ke}}" data-toggle="modal" data-target="#modal_delete_all" href="#">Hapus semua</a>
          @endif
        </th>
      </tr>
      </thead>
    </table>
  </div>
</div>
</div>
</div>
</div>

<script src="{{asset('Admin/modal_ajax.min.js')}}"></script>
<script src="{{asset('Admin/bower_components/jquery/dist/jquery.min.js')}}"></script>

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

<script type="text/javascript">
$(document).ready(function() {


 });
</script>

   @section('script_table')
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
   @endsection

  @endsection
