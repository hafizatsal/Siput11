@extends('layouts.layout')
@section('title','Halaman Pengukuran')
@section('active_pengukuran','active')
@section('judul_halaman','Halaman Detail Plot')
@section('breadcrumb')
<li><a href="{{route('auditor.home')}}"><i class="fa fa-dashboard"></i> Home</a></li>
<li><a href="{{route('auditor.data_pengukuran_home')}}">Data Pengukuran</a></li>
<li><a href="{{route('auditor.detail', encrypt($id_klaster))}}">Detail Pengukuran</a></li>
<li><a href="#">Detail Plot</a></li>
@endsection
@section('main_section')
<!-- Main content -->
<div class="row">
   <div class="col-xs-12">
     <div class="box">
       <div class="box-header">
           <h2><i class="fa fa-globe"></i> Data Plot</h2>
       </div>
        <div class="box-body">
       <div class="col-xs-12 table-responsive">
       <table id="detail_plot" class="table table-striped">
         <tbody>
           <tr>
             <td>Nama Pengelola</td>
             <td> : {{$plot->pengelola}}</td>
             <td></td>
           </tr>

           <tr>
             <td>Status Pengelola</td>
             <td> : {{$plot->ket_pengelola}}</td>
             <td></td>
           </tr>

           <tr>
             <td>Luas</td>
             <td> : {{$plot->luas}} Ha</td>
             <td></td>
           </tr>

           <tr>
             <td>Koordinat Titik Pusat</td>
             <td> : {{$plot->koordinat_bt_display ?? $plot->koordinat_BT}}, {{$plot->koordinat_ls_display ?? $plot->koordinat_LS}}</td>
             <td></td>
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
       <h2>Pohon
         <a class="btn btn-success pull-right" href="{{route('auditor.tambah_pengukuran_plot', encrypt($plot->id_plot))}}"><i class="fa fa-search"></i></a>
         <a class="btn btn-info pull-right" data-klasterid="" data-toggle="modal" data-target="#modal_tambah_tanaman" href=""><i class="fa fa-plus"></i></a>
       </h2> &nbsp
           <div>
    <div class="box-body">
     <table id="tbl_tanaman" class="table table-bordered">
       <thead>
         <tr>
           <th style="width:5%">#</th>
           <th style="width:42%">Nama Pohon</th>
           <th style="width:43%">Nama Latin</th>
           <th style="width:10%">Aksi</th>
         </tr>
       </thead>
       <tbody>

@php ($nmr=1) @foreach($data as $d)
         <tr>
          <td>{{$nmr++}}</td>
          <td>{{$d->nama_tanaman}} </td>
          <td>{{$d->nama_latin}} </td>
          <td>
            <a class="fa fa-edit btn btn-warning btn-xs" data-pohon="{{$d->id}}" data-toggle="modal" data-target="#modal_edit_pohon"></a>
            <a class="fa fa-trash btn btn-danger btn-xs" data-pohon="{{$d->id}}" data-toggle="modal" data-target="#modal_delete_pohon"></a>
          </td>
         </tr>
@endforeach
       </tbody>
     </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="row">
 <div class="col-xs-12 table">
  <div class="box">
  <div class="box-header">
   <h2>Data Biodiversitas Pohon</h2> &nbsp
 </div>
<div class="box-body">
   <table id="tbl_biodiversitas" class="table table-bordered">
     <thead>
       <tr>
         <th style="width:5%">#</th>
         <th style="width:42%">Nama Pohon</th>
         <th style="width:43%">Nama Latin Pohon</th>
         <th style="width:10%">Jumlah</th>
       </tr>
       </thead>
       <tbody>
@php ($id=1) @php($jumlah_individu=0) @php($jumlah_seluruh=0)
@php($jumlah_total=0)
 @foreach($jumlah_pohon as $j)
       <tr>
        <td>{{$id++}}</td>
        <td>{{$j->nama_tanaman}}</td>
        <td>{{$j->nama_latin}}</td>
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

<div class="row">

  <div class="col-xs-12 table">
    <div class="box">
      <div class="box-header">
    <h2>Data Biodiversitas Fauna
      <a class="btn btn-info pull-right" data-klasterid="" data-toggle="modal" data-target="#modal_tambah_fauna" href=""><i class="fa fa-plus"></i></a>
    </h2>&nbsp
     </div>
     <div class="box-body">
    <table class="table table-bordered" id="table-indikator" style="padding:10px;">
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
                  <td>{{$d->nama_latin_fauna}} </td>
                  <td>{{$d->jumlah}} </td>
                  @php($jumlah_total+=$d->jumlah)
                  <td>
                    <a class="fa fa-edit btn btn-warning btn-xs" data-fauna="{{$d->id_fauna}}" data-toggle="modal" data-target="#modal_edit_fauna"></a>
                    <a class="fa fa-trash btn btn-danger btn-xs" data-fauna="{{$d->id_fauna}}" data-toggle="modal" data-target="#modal_delete_fauna"></a>
                  </td>
                 </tr>
        @endforeach
      </tbody>
      <thead>
      <th>Jumlah</th>
      <th></th>
      <th></th>
      <th>{{$jumlah_total}}</th>
      <th></th>
      </thead>
    </table>
</div>
</div>
</div>
</div>

<div class="row">
<div class="col-xs-12 table">
  <div class="box">
<div class="box-header">
  <h2>Kualitas Tapak</h2> &nbsp
</div>
<div class="box-body">
  <table id="tbl-tanah" class="table table-bordered">
    <thead>
      <tr>
        <th style="width:4%">#</th>
        <th style="width:20%">Titik Plot</th>
        <th style="width:20%">Nama Indikator</th>
        <th style="width:20%">Nilai</th>
        <th style="width:20%">Aksi</th>
      </tr>
    </thead>
    <tbody id="tbody_tanah">
      <tr><td colspan="5" style="text-align: center">Data Belum Ada</td></tr>
    </tbody>
  </table>
</div>
</div>
</div>
</div>

@include('auditor.include.isi_pengukuran.pohon.modal_edit_pohon')
@include('auditor.include.isi_pengukuran.pohon.modal_delete_pohon')

@section('data_table')
<script src="{{asset('Admin/bower_components/datatables.net/js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('Admin/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js')}}"></script>
@endsection
@section('script_table')
<script>
$(function () {
  $('#tbl_tanaman').DataTable({
    'paging'      : true,
    'lengthChange': true,
    'searching'   : true,
    'ordering'      :false,
    'info'        : true,
    'autoWidth'   : false
  })
})
</script>
@endsection

@endsection
