@extends('layouts.layout')
@section('title','Halaman Skoring')
@section('css')
  <link rel="stylesheet" href="{{asset('Admin/bower_components/morris.js/morris.css')}}">
  <link rel="stylesheet" href="{{asset('Admin/cdn/table-responsive.css')}}">
@endsection
@section('active_penilaian','active')
@section('active_nilai_akhir','active')
@section('judul_halaman','Halaman Skoring')
@section('breadcrumb')
<li><a href="#">Nilai Akhir Kesehatan Hutan</a></li>
@endsection
@section('main_section')
<!-- BAR CHART -->
@if($jumlah_penilaian>1)
<div class="box box-success">
  <div class="box-header with-border">
    <h3 class="box-title">Kesehatan Hutan di {{$id_klaster[0]->kategori}}</h3>
    <h4>Nilai Perubahan</h4>

    <div class="box-tools pull-right">
      <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
      </button>
      </div>
  </div>
  <div class="box-body chart-responsive">
    <div class="chart" id="line-chart" style="height: 300px;"></div>
  </div>
  <!-- /.box-body -->
</div>
<!-- /.box -->
@endif

<div class="box box-info">
  <div class="box-header with-border">
    <h3 class="box-title">Nilai Kesehatan Hutan</h3>
    <h4>
      <form id="skor_akhir" method="post" class="" action="{{route('user.penilaian_kesehatan')}}">
      {{csrf_field()}}
      <input type="hidden" id="nama_data_klaster1" name="nama_data_klaster1" value="{{$id_data_klaster}}">
      <input type="hidden" id="pengukuran_ke" name="pengukuran_ke" value="{{$pengukuran_ke}}">
      <input type="hidden" id="p_lbds" name="p_lbds" value="{{$p_lbds}}">
      <input type="hidden" id="p_volume" name="p_volume" value="{{$p_volume}}">
      <input type="hidden" id="p_kerusakan" name="p_kerusakan" value="{{$p_kerusakan}}">
      <input type="hidden" id="p_ktjk" name="p_ktjk" value="{{$p_ktjk}}">
      <input type="hidden" id="p_kimia" name="p_kimia" value="{{$p_kimia}}">
      <input type="hidden" id="p_fisik" name="p_fisik" value="{{$p_fisik}}">
      <input type="hidden" id="haksenp" name="haksenp" value="{{$haksenp}}">
      <input type="hidden" id="haksenf" name="haksenf" value="{{$haksenf}}">
      </form>

    </h4>

    <div class="box-tools pull-right">
      <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
      </button>
      </div>
  </div>
  <div class="box-body">
    <div class="row">
      <div class="col-xs-12 table-responsive">
    <table id="nilai_kesehatan" class="table table-bordered table-striped">
      <thead>
      <tr>
        <th style="text-align: center; vertical-align: middle">Pengukuran-Ke</th>
        <th style="text-align: center; vertical-align: middle">Nama Pengukur</th>
        @if($p_lbds!="")
        <th  style="text-align: center; vertical-align: middle">
            Nilai Lbds
        </th>
        @endif
        @if($p_volume!="")
        <th  style="text-align: center; vertical-align: middle">
            Nilai Volume
        </th>
        @endif
        @if($p_ktjk!="")
        <th  style="text-align: center; vertical-align: middle">
            Nilai Tajuk
        </th>
        @endif
        @if($p_kerusakan!="")
        <th style="text-align: center; vertical-align: middle">
             Nilai Kerusakan
        </th>
        @endif
        @if($haksenp!="")
        <th style="text-align: center; vertical-align: middle">
             Nilai H' Pohon
        </th>
        @endif
        @if($p_jpliu!="")
        <th style="text-align: center; vertical-align: middle">
             Nilai J' Pohon
        </th>
        @endif
        @if($p_dmg!="")
        <th style="text-align: center; vertical-align: middle">
             Nilai DMg Pohon
        </th>
        @endif
        @if($haksenf!="")
        <th style="text-align: center; vertical-align: middle">
             Nilai H' Fauna
        </th>
        @endif
        @if($p_jpliuf!="")
        <th style="text-align: center; vertical-align: middle">
             Nilai J' Fauna
        </th>
        @endif
        @if($p_dmgf!="")
        <th style="text-align: center; vertical-align: middle">
             Nilai DMg Fauna
        </th>
        @endif
        @if($p_kimia!="")
        <th style="text-align: center; vertical-align: middle">
             Nilai Tapak
        </th>
        @endif
        <th style="text-align: center; vertical-align: middle">Nilai Total</th>
        <th style="text-align: center; vertical-align: middle; width:4%">Lihat Detail</th>
      </tr>
      </thead>
      <tbody>

      <tr>
        <td>1</td>
        <td>{{$id_klaster[0]->nama_pengukur}}</td>
        @if($p_lbds!="")
        <td>
          {{$na_total_lbds[0]}}
        </td>
        @endif
        @if($p_volume!="")
        <td>
          {{$na_total_volume[0]}}
        </td>
        @endif
        @if($p_ktjk!="")
        <td>
          {{$na_total_tajuk[0]}}
        </td>
        @endif
        @if($p_kerusakan!="")
        <td>
          {{$na_total_kerusakan[0]}}
        </td>
        @endif
        @if($haksenp!="")
        <td>
          {{$na_total_biodiv_pohon[0]}}
        </td>
        @endif
        @if($p_jpliu!="")
        <td>
          {{$na_total_biodiv_pohon_jpliu[0]}}
        </td>
        @endif
        @if($p_dmg!="")
        <td>
          {{$na_total_biodiv_pohon_dmg[0]}}
        </td>
        @endif
        @if($haksenf!="")
        <td>
          {{$na_total_biodiv_fauna[0]}}
        </td>
        @endif
        @if($p_jpliuf!="")
        <td>
          {{$na_total_biodiv_fauna_jpliuf[0]}}
        </td>
        @endif
        @if($p_dmgf!="")
        <td>
          {{$na_total_biodiv_fauna_dmgf[0]}}
        </td>
        @endif
        @if($p_kimia!="")
        <td>
          {{$na_total_cec[0]}}
        </td>
        @endif
        <td>{{$na_seluruh[0]}}</td>

        <td style="text-align: center; vertical-align: middle">

          <form id="pengukuran_pertama" method="post" class="" action="{{route('user.penilaian_kesehatan')}}">
          {{csrf_field()}}
          <input type="hidden" id="pengukuranke" name="pengukuranke" value="1">
          <input type="hidden" id="tahun_pengukuran" name="tahun_pengukuran" value="{{$id_klaster[0]->id_data_klaster}}">
          <input type="hidden" id="lbds" name="lbds" value="{{$p_lbds}}">
          <input type="hidden" id="volume" name="volume" value="{{$p_volume}}">
          <input type="hidden" id="kerusakan" name="kerusakan" value="{{$p_kerusakan}}">
          <input type="hidden" id="ktjk" name="ktjk" value="{{$p_ktjk}}">
          <input type="hidden" id="kimia" name="kimia" value="{{$p_kimia}}">
          <input type="hidden" id="sifat-sifat_kimia" name="sifat-sifat_kimia" value="{{$sifat_kimia}}">
          <input type="hidden" id="fisik" name="fisik" value="{{$p_fisik}}">
          <input type="hidden" id="haksenp" name="haksenp" value="{{$haksenp}}">
          <input type="hidden" id="jpliu" name="jpliu" value="{{$p_jpliu}}">
          <input type="hidden" id="dmg" name="dmg" value="{{$p_dmg}}">
          <input type="hidden" id="haksenf" name="haksenf" value="{{$haksenf}}">
          <input type="hidden" id="jpliuf" name="jpliuf" value="{{$p_jpliuf}}">
          <input type="hidden" id="dmgf" name="dmgf" value="{{$p_dmgf}}">
          </form>

          <a class="fa fa-search btn btn-success btn-xs" onclick="document.getElementById('pengukuran_pertama').submit()"></a>

        </td>
      </tr>

      <tr>
        <td>2</td>
        <td>{{$id_klaster2[0]->nama_pengukur}}</td>
        @if($p_lbds!="")
        <td>
          {{$na_total_lbds2[0]}}
        </td>
        @endif
        @if($p_volume!="")
        <td>
          {{$na_total_volume2[0]}}
        </td>
        @endif
        @if($p_ktjk!="")
        <td>
          {{$na_total_tajuk2[0]}}
        </td>
        @endif
        @if($p_kerusakan!="")
        <td>
          {{$na_total_kerusakan2[0]}}
        </td>
        @endif
        @if($haksenp!="")
        <td>
          {{$na_total_biodiv_pohon2[0]}}
        </td>
        @endif
        @if($p_jpliu!="")
        <td>
          {{$na_total_biodiv_pohon_jpliu2[0]}}
        </td>
        @endif
        @if($p_dmg!="")
        <td>
          {{$na_total_biodiv_pohon_dmg2[0]}}
        </td>
        @endif
        @if($haksenf!="")
        <td>
          {{$na_total_biodiv_fauna2[0]}}
        </td>
        @endif
        @if($p_jpliuf!="")
        <td>
          {{$na_total_biodiv_fauna_jpliuf2[0]}}
        </td>
        @endif
        @if($p_dmgf!="")
        <td>
          {{$na_total_biodiv_fauna_dmgf2[0]}}
        </td>
        @endif
        @if($p_kimia!="")
        <td>
          {{$na_total_cec2[0]}}
        </td>
        @endif
        <td>{{$na_seluruh2[0]}}</td>

        <td style="text-align: center; vertical-align: middle">

          <form id="pengukuran_kedua" method="post" class="" action="{{route('user.penilaian_kesehatan')}}">
          {{csrf_field()}}
          <input type="hidden" id="pengukuranke" name="pengukuranke" value="2">
          <input type="hidden" id="tahun_pengukuran" name="tahun_pengukuran" value="{{$id_klaster2[0]->id_data_klaster2}}">
          <input type="hidden" id="lbds" name="lbds" value="{{$p_lbds}}">
          <input type="hidden" id="volume" name="volume" value="{{$p_volume}}">
          <input type="hidden" id="kerusakan" name="kerusakan" value="{{$p_kerusakan}}">
          <input type="hidden" id="ktjk" name="ktjk" value="{{$p_ktjk}}">
          <input type="hidden" id="kimia" name="kimia" value="{{$p_kimia}}">
          <input type="hidden" id="sifat-sifat_kimia" name="sifat-sifat_kimia" value="{{$sifat_kimia}}">
          <input type="hidden" id="fisik" name="fisik" value="{{$p_fisik}}">
          <input type="hidden" id="haksenp" name="haksenp" value="{{$haksenp}}">
          <input type="hidden" id="jpliu" name="jpliu" value="{{$p_jpliu}}">
          <input type="hidden" id="dmg" name="dmg" value="{{$p_dmg}}">
          <input type="hidden" id="haksenf" name="haksenf" value="{{$haksenf}}">
          <input type="hidden" id="jpliuf" name="jpliuf" value="{{$p_jpliuf}}">
          <input type="hidden" id="dmgf" name="dmgf" value="{{$p_dmgf}}">
          </form>

          <a class="fa fa-search btn btn-success btn-xs" onclick="document.getElementById('pengukuran_kedua').submit()"></a>

        </td>
      </tr>

      </tbody>
      <tfoot>

      </tfoot>
    </table>
  </div>
  </div>

  </div>
  <!-- /.box-body -->
</div>


<div class="callout callout-info">
  <h4>Informasi!</h4>
  <p>Nilai tertimbang pengukuran ke-2 dan ke-3 mengikuti nilai tertimbang pengukuran pertama.</p>
</div>

@section('data_table')
<!-- <script src="{{asset('Admin/dist/js/adminlte.min.js')}}"></script> TAMBAHAN UNTUK EXPANDABLE -->
<script src="{{asset('Admin/bower_components/raphael/raphael.min.js')}}"></script>
<script src="{{asset('Admin/bower_components/morris.js/morris.min.js')}}"></script>
<script src="{{asset('Admin/bower_components/datatables.net/js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('Admin/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js')}}"></script>
<script src="{{asset('Admin/cdn/table-responsive.min.js')}}"></script>
@endsection
<script src="{{asset('Admin/bower_components/jquery/dist/jquery.min.js')}}"></script>
<script src="{{ asset ("js/chart.min.js") }}"></script>
<script src="{{ asset ("js/Chart.js") }}"></script>
<script src="{{asset('Admin/bower_components/raphael/raphael.min.js')}}"></script>
<script src="{{asset('Admin/bower_components/morris.js/morris.min.js')}}"></script>
<script type="text/javascript">

// LINE CHART
   var line = new Morris.Line({
     element: 'line-chart',
     resize: true,
     data: [
       {y: '{{$id_klaster[0]->tahun_pengukuran}}', lbds: {{$na_total_lbds[0]}}, tajuk: {{$na_total_tajuk[0]}}, kerusakan: {{$na_total_kerusakan[0]}}, Biodiversitas: {{$na_total_biodiv_pohon[0]}}, Tapak: {{$na_total_cec[0]}} },
       {y: '{{$id_klaster2[0]->tahun_pengukuran}}', lbds: {{$na_total_lbds2[0]}}, tajuk: {{$na_total_tajuk2[0]}}, kerusakan: {{$na_total_kerusakan2[0]}}, Biodiversitas: {{$na_total_biodiv_pohon2[0]}}, Tapak: {{$na_total_cec2[0]}} },
       ],
     xkey: 'y',
     ykeys: ['lbds', 'tajuk', 'kerusakan', 'Biodiversitas', 'Tapak'],
     labels: ['LBDS', 'Tajuk', 'Kerusakan', 'Biodiversitas', 'Tapak'],
     lineColors: ['#ff00bc','#2cff00','#7d2eff','#FFD700','#A52A2A'],
     hideHover: 'auto'
   });

</script>

   @section('script_table')
  <script>

   $(function () {

     $('#nilai_kesehatan').DataTable({
       'paging'      : true,
       'lengthChange': true,
       'searching'   : true,
       'ordering'      :true,
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





     $('a[data-toggle="tab"]').on('shown.bs.tab', function(e){
        $($.fn.dataTable.tables(true)).DataTable()
           .columns.adjust()
           .responsive.recalc();
     });
   })
   
  </script>
@endsection
@endsection


