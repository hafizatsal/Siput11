@extends('layouts.layout')
@section('title','Data Plot')
@section('css')
<link rel="stylesheet" href="{{asset('Admin/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css')}}">
@endsection
@section('active_data_pengukuran','active')
@section('active_pengukuran_plot','active')
@section('breadcrumb')
<li><a href="#">Data Pengukuran Plot</a></li>
@endsection
@section('main_section')
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
             <td>Pilih Plot</td>
             <td> :
           <select id="pilihplot" name="pilihplot" onchange="location = this.value;">
             <option value="">Pilih Plot</option>
            @php($id=0) @foreach($id_plots as $id_plots)
             <option value="{{route('user.lihatpengukurans', encrypt($id_plots))}}">{{$nama_plots[$id]}}</option>
             @php($id++)
             @endforeach
           </select>
            </td>
            <td></td>
          </tr>
           <tr>
             <td>Nama Pengelola</td>
             <td> : {{$nama_plot->pengelola}}</td>
             <td></td>
           </tr>

           <tr>
             <td>Status Pengelola</td>
             <td> : {{$nama_plot->ket_pengelola}}</td>
             <td></td>
           </tr>

           <tr>
             <td>Nama Klaster</td>
             <td> : {{$nama_plot->nama_klaster}}</td>
             <td></td>
           </tr>

           <tr>
             <td>Nama Plot</td>
             <td> : {{$nama_plot->nama_plot}}
             </td>
             <td></td>
           </tr>

           <tr>
             <td>Luas</td>
             <td> : {{$nama_plot->luas}} Ha</td>
             <td></td>
           </tr>

           <tr>
             <td>Pola Tanam</td>
             <td> : {{$nama_plot->nama_pola}}</td>
             <td></td>
           </tr>

           <tr>
             <td>Koordinat Titik Pusat</td>
             <td> : {{$koor_ls_ful_p}} {{$ket_lintang_p}} , {{$koor_bt_ful_p}} {{$ket_bujur_p}}</td>
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
    <div class="col-xs-12">
      <div class="box">
        <div class="box-header">
          <h2>Data Pengukuran
          @if($jumlah_pengukuran <3)
          <button type="button" class="btn btn-primary btn-xs pull-right" data-toggle="modal" data-target="#modal_tambah_pengukuran">
            <i class="fa fa-plus"></i>Tambah</button>
            @endif
          </h2>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
       <div class="col-xs-12 table-responsive">
          <table id="tambah_data_pengukuran" class="table table-bordered table-striped">
            <thead>
            <tr>
              <th style="width:4%" >Pengukuran ke-</th>
              <th>Tanggal Pengukuran</th>
              <th>Nama Pengukur</th>
              <th style="width:10%" >Aksi</th>
              <th style="width:5%" >Status</th>
            </tr>
            </thead>
            <tbody>
              @php ($id=0) @foreach($data_pengukuran as $d)
            <tr>
              <td>{{$d->pengukuran_ke}}</td>
              <td>{{$d->tahun_pengukuran}}</td>
              <td>{{$d->nama_pengukur}}</td>
              <td>
              <a class="fa fa-search btn btn-success btn-xs" data-info="" href="{{route('user.data_indikator', encrypt($d->id_pengukuran), encrypt($d->id_plot) )}}"></a>
              <!-- <a class="fa fa-search btn btn-success btn-xs" data-info="" href="{{route('user.tambah_pengukuran_plot', encrypt($d->id_pengukuran), encrypt($d->id_plot) )}}"></a> -->
              <a class="fa fa-edit btn btn-warning btn-xs" data-pengukuran="{{$d->id_pengukuran}}" data-tahun="{{$d->tahun_pengukuran}}" data-nama="{{$d->nama_pengukur}}" data-pengke="{{$d->pengukuran_ke}}" data-toggle="modal" data-target="#modal_edit_pengukuran" href=""></a>
              @if($d->pengukuran_ke==$jumlah_pengukuran)
                <a class="fa fa-eraser btn btn-danger btn-xs" data-pengukuran="{{$d->id_pengukuran}}" data-toggle="modal" data-target="#hapus_data_pengukuran" href=""></a>
              @endif
              </td>
              <td style="text-align: center; vertical-align: middle;">
                @if($cek_status[$id]==1)<span class='label label-success'>O</span>@endif
                @if($cek_status[$id]==0)<span class='label label-danger'>O</span>@endif
              </td>
                @php($id++)
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
  <script src="{{asset('Admin/modal_ajax.min.js')}}"></script>
  <script src="{{asset('Admin/bower_components/jquery/dist/jquery.min.js')}}"></script>
   <!-- /.content -->
   {{-- include modal --}}
   @include('user.include.data_pengukuran_plot.edit_pengukuran')
   @include('user.include.data_pengukuran_plot.tambah_pengukuran')
   @include('user.include.data_pengukuran_plot.hapus_pengukuran')

@section('data_table')
<!-- DataTables -->
<script src="{{asset('Admin/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js')}}"></script>
@endsection

<script type="text/javascript">
$( document ).ready(function() {
 $('#datepicker').datepicker({
   format : 'yyyy-mm-dd',
   autoclose: true
 });

 $('#datepicker2').datepicker({
   format : 'yyyy-mm-dd',
   autoclose: true
 });

 });

</script>

  @endsection
