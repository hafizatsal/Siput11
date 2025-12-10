@extends('layouts.layoutauditor')
@section('title','Nilai Plot')
@section('active_penilaian','active')
@section('active_nilai_akhir','active')
@section('breadcrumb')
<li><a href="javascript:history.go(-2)">Nilai Akhir Kesehatan Hutan</a></li>
<li><a href="javascript:history.back()">Nilai Kesehatan Plot</a></li>
<li><a href="#">Nilai Plot</a></li>
@endsection
@section('main_section')
<div class="box">
  <div class="box-header with-border">
    <h3 class="box-title"><b>Data Kesehatan Pohon</b></h3>
  </div>
  <!-- /.box-header -->

  <!-- data pengukuran -->
  <div class="box-body">
    <h4>Pengukuran ke-{{$pengukuran_ke}}</h4>
    <div class="table-responsive">
      <table id="" class="table table-bordered table-striped">
        <thead>
          <tr>
            <th style="vertical-align: middle; width:5%;">Nomor</th>
            <th style="vertical-align: middle;">Nama Pohon</th>
            <th style="vertical-align: middle;">Nama Latin</th>
            @if($p_lbds!="")
            <th style="vertical-align: middle;">LBDS <br> (m<sup>2</sup>)</th>
            @endif
            @if($p_volume!="")
            <th style="vertical-align: middle;">Volume <br> (m<sup>3</sup>)</th>
            @endif
            @if($p_ktjk!="")
            <th style="vertical-align: middle;">VCR</th>
            @endif
            @if($p_kerusakan!="")
            <th style="vertical-align: middle;">TLI</th>
            @endif
          </tr>
        </thead>
        <tbody>
          @php($i=1) @php($tot_lbds=0) @php($tot_vol=0) @php($tot_tajuk=0) @php($tot_kerusakan=0) @foreach($data_pohon as $value)
          <tr>
            <td>{{$i}}</td>
            <td>{{$value->nama_tanaman}}</td>
            <td><i>{{$value->nama_latin}}</i></td>
            @if($p_lbds!="")
            <td>{{round($value->Hasil_LBDS,2)}}</td>
            @endif
            @if($p_volume!="")
            <td>{{round($value->v,2)}}</td>
            @endif
            @if($p_ktjk!="")
            <td>{{$value->vcri}}</td>
            @endif
            @if($p_kerusakan!="")
            <td>{{$value->tli}}</td>
            @endif
            @php($tot_lbds+=$value->Hasil_LBDS)
            @php($tot_vol+=$value->v)
            @php($tot_tajuk+=$value->vcri)
            @php($tot_kerusakan+=$value->tli)
            @php($i++)
            @endforeach
          </tr>
        </tbody>
        <thead>
          <th>Jumlah</th>
          <th></th>
          <th></th>
          @if($p_lbds!="")
          <th>{{round($tot_lbds,2)}}</th>
          @endif
          @if($p_volume!="")
          <th>{{round($tot_vol,2)}}</th>
          @endif
          @if($p_ktjk!="")
          <th>{{$tot_tajuk}}</th>
          @endif
          @if($p_kerusakan!="")
          <th>{{$tot_kerusakan}}</th>
          @endif
        </thead>
        <tfoot></tfoot>
      </table>
    </div>
  </div>
  <!-- /.box-body -->
</div>

@if($haksenp!="")
<div class="box">
  <div class="box-header with-border">
    <h3 class="box-title"><b>Data Pohon dalam Plot</b></h2>
  </div>
  <div class="box-body">
    <div class="table-responsive">
      <table id="tbl_biodiversitas" class="table table-bordered table-striped">
        <thead>
          <tr>
            <th style="width:5%">#</th>
            <th style="width:42%">Nama Pohon</th>
            <th style="width:43%">Nama Latin Pohon</th>
            <th style="width:10%">Jumlah</th>
            <th>ni</th>
            <th>ln(ni)</th>
            <th>H'</th>
            @if($p_jpliu)
            <th>J'</th>
            @endif
            @if($p_dmg)
            <th>DMg</th>
            @endif
          </tr>
        </thead>
        <tbody>
          @php ($id=1) @php($jumlah_individu=0) @php($jumlah_seluruh=0)
          @php($jumlah_total=0)
          @foreach($jumlah_pohon as $j)
          <tr>
            <td>{{$id++}}</td>
            <td>{{$j->nama_tanaman}}</td>
            <td><i>{{$j->nama_latin}}</i></td>
            <td>{{$j->jumlah}}</td>
            <td>{{$ni[$id-2]}}</td>
            <td>{{$ln_ni[$id-2]}}</td>
            <td>{{$ni_ln_ni[$id-2]}}</td>
            @if($p_jpliu)
            <th>{{$j_pliu[$id-2]}}</th>
            @endif
            @if($p_dmg)
            <th>{{$d_mg[$id-2]}}</th>
            @endif
            @php($jumlah_individu+=$j->jumlah)
          </tr>
          @endforeach
        </tbody>
        <thead>
          <th>Jumlah</th>
          <th></th>
          <th></th>
          <th>{{$jumlah_individu}}</th>
          <th></th>
          <th><th>@if($haksenp!=""){{$rata_h_aksen}}@endif</th></th>
          @if($p_jpliu)
          <th>{{$rata_j_pliu}}</th>
          @endif
          @if($p_dmg)
          <th>{{$rata_dmg}}</th>
          @endif
        </thead>
      </table>
    </div>
  </div>
</div>
@endif

@if($haksenf!="")
<div class="box">
  <div class="box-header with-border">
    <h3 class="box-title"><b>Data Fauna dalam Plot</b></h3>
  </div>
  <div class="box-body">
    <div class="table-responsive">
      <table class="table table-bordered table-striped" id="table-indikator" style="padding:10px;">
        <thead>
          <tr>
            <th>#</th>
            <th>Nama Fauna</th>
            <th>Nama Latin</th>
            <th>Jumlah</th>
          </tr>
        </thead>
        <tbody>
          @php ($nmr=1) @php($jumlah_total=0) @foreach($jumlah_fauna as $d)
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
          <th>Jumlah</th>
          <th></th>
          <th></th>
          <th>{{$jumlah_total}}</th>
        </thead>
      </table>
    </div>
  </div>
</div>
@endif

@section('data_table')
<!-- DataTables -->
<script src="{{asset('Admin/bower_components/datatables.net/js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('Admin/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js')}}"></script>
@endsection

   @section('script_table')
   <script>
   $(function () {
     $('#data_pengukuran').DataTable({
       'paging'      : true,
       'lengthChange': true,
       'searching'   : true,
       'ordering'      :false,
       'info'        : true,
       'autoWidth'   : false
     })
     $('#example2').DataTable({
       'paging'      : true,
       'lengthChange': false,
       'searching'   : false,
       'ordering'    : true,
       'info'        : true,
       'autoWidth'   : false
     })
   })
    </script>
   @endsection

  @endsection
