@extends('layouts.layout')
@section('title','Data Pengukuran')
@section('active_data_pengukuran','active')
@section('active_biodiversitas','active')
@section('breadcrumb')
<li><a href="{{route('user.data_indikator', encrypt($id))}}">Data Indikator</a></li>
<li><a href="{{route('user.pengukuran_biodiversitas',encrypt($id))}}">Paramater Biodiversitas</a></li>
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
             <option value="{{route('user.bio_pohon', encrypt($id_pengukuran))}}">{{$nama_plots[$no]}}</option>
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
            @if(count($data_pohon)==0)
              <a style="margin-left:10px;" class="btn btn-primary pull-right" data-toggle="modal" data-target="#modal_import_pohon" href="#"><i class="fa fa-fw fa-file-excel-o"></i>Import Pohon</a>
            @endif
            <a class="btn btn-info pull-right" data-klasterid="" data-toggle="modal" data-target="#modal_tambah_tanaman" href=""><i class="fa fa-plus"></i></a>
          </h3>
          <h4>
            <a class="btn btn-success btn-xs" href="{{route('user.lbds',encrypt($id))}}">Pertumbuhan</a>
            <a class="btn btn-danger btn-xs" href="{{route('user.kerusakan', encrypt($id))}}">Kerusakan Pohon</a>
            <a class="btn btn-warning btn-xs" href="{{route('user.tajuk', encrypt($id))}}">Kondisi Tajuk</a>
            <a class="btn btn-primary btn-xs" href="">Biodiversitas Pohon</a>
            <a class="btn btn-primary btn-xs" href="{{route('user.bio_fauna',encrypt($id))}}">Biodiversitas Fauna</a>
            <a class="btn btn-info btn-xs" href="{{route('user.kimia',encrypt($id))}}">Kualitas Tapak (Kimia)</a>
            <a class="btn btn-info btn-xs" href="{{route('user.fisika',encrypt($id))}}">Kualitas Tapak (Fisik)</a>
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
              <th style="width:10%" class="">Aksi</th>
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
                <a class="btn btn-success btn-xs" data-info="0" data-pohon="{{$d->id_tanaman_plot}}" data-toggle="modal" data-target="#modal_status">Hidup</a>
              </td>
                @else
                <td>
                <a class="btn btn-danger btn-xs" data-info="1" data-pohon="{{$d->id_tanaman_plot}}" data-toggle="modal" data-target="#modal_status">Mati</a>
                </td>
                @endif
                <td>
                  <a class="fa fa-edit btn btn-warning btn-xs" data-pohon="{{$d->id_tanaman_plot}}" data-jenis="{{$d->id_master_jenis_tanaman}}" data-toggle="modal" data-target="#modal_edit_pohon"></a>
                  <a class="fa fa-trash btn btn-danger btn-xs" data-pohon="{{$d->id_tanaman_plot}}" data-jenis="{{$d->id_master_jenis_tanaman}}" data-toggle="modal" data-target="#modal_delete_pohon"></a>
                </td>

            </tr>
            @endforeach
            </tbody>
            <tfoot>
              <thead>
                <tr style="height:50px; background-color: #FFFFFF;">
                  <th></th>
                  <th></th>
                  <th></th>
                  <th></th>
                  <th>
                    @if(count($data_pohon)>0)
                      <a class="fa fa-eraser btn btn-danger btn-xs" data-info2="{{$data_pengukuran->id_plot}}" data-pengukuran_ke="{{$data_pengukuran->pengukuran_ke}}" data-toggle="modal" data-target="#modal_delete_all" href="#">Hapus semua</a>
                    @endif
                  </th>
                </tr>
              </thead>
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
