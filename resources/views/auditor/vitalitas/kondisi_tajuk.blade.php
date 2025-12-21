@extends('layouts.layoutauditor')
@section('title','Data Pengukuran')
@section('active_data_pengukuran','active')
@section('active_vitalitas','active')
@section('breadcrumb')
<li><a href="#">Kondisi Tajuk</a></li>
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
             <option value="{{route('auditor.tajuk', encrypt($id_pengukuran))}}">{{$nama_plots[$no]}}</option>
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
            <a target="_blank" href="{{asset('upload/pengukuran/tajuk/'. $data_foto_pengukuran->filename)}}">
              <img src="{{asset('upload/pengukuran/tajuk/'. $data_foto_pengukuran->filename)}}" alt="{{$data_foto_pengukuran->title}}" width="600" height="400">
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

<!-- /.content -->
<div class="row">
  <div class="col-xs-12 table">
    <div class="box">
        <div class="box-header">
          <h3>Data Kondisi Tajuk
          </h3>
          <h4>
            <a class="btn btn-success btn-xs" href="{{route('auditor.lbds',encrypt($id))}}">Pertumbuhan</a>
            <a class="btn btn-danger btn-xs" href="{{route('auditor.kerusakan', encrypt($id))}}">Kerusakan Pohon</a>
            <a class="btn btn-warning btn-xs" href="">Kondisi Tajuk</a>
            <a class="btn btn-primary btn-xs" href="{{route('auditor.bio_pohon',encrypt($id))}}">Biodiversitas Pohon</a>
            <a class="btn btn-primary btn-xs" href="{{route('auditor.bio_fauna',encrypt($id))}}">Biodiversitas Fauna</a>
            <a class="btn btn-info btn-xs" href="{{route('auditor.kimia',encrypt($id))}}">Kualitas Tapak (Kimia)</a>
            <a class="btn btn-info btn-xs" href="{{route('auditor.fisika',encrypt($id))}}">Kualitas Tapak (Fisika)</a>
        </h4>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <div class="col-xs-12 table-responsive">
          <table id="data_kondisi_tajuk" class="table table-bordered table-striped">
            <thead>
            <tr>
              <th>No.</th>
              <th>Nama Pohon</th>
              <th>Jenis Nilai</th>
              <th>
                <div class="tooltips">
                  lcr (%)
                  <span class="tooltiptexts">Live Crown Ratio</span>
                </div>
                </th>
              <th>
                <div class="tooltips">
                  cden (%)
                  <span class="tooltiptexts">Crown Density</span>
                </div>
                </th>
              <th>
                <div class="tooltips">
                  ft (%)
                  <span class="tooltiptexts">Foliage Transparancy</span>
                </div>
                </th>
              <th>
                <div class="tooltips">
                  cdb (%)
                  <span class="tooltiptexts">Crown Dieback</span>
                </div>
                </th>
              <th>
                <div class="tooltips">
                  cdw (m)
                  <span class="tooltiptexts">Crown Diamter Width</span>
                </div>
                </th>
              <th>
                <div class="tooltips">
                  cd90 (m)
                  <span class="tooltiptexts">Crown Diamter at 90ᴼ</span>
                </div>
                </th>
              <th>
                <div class="tooltips">
                  cd (m)
                  <span class="tooltiptexts">Crown Diameter</span>
                </div>
                </th>
              <th>
                <div class="tooltips">
                  vcri (kesimpulan)
                  <span class="tooltiptexts">Visual Crown Rating</span>
                </div>
                </th>
            </tr>
            </thead>
            <tbody>
              @php ($nmr=1) @foreach($data_pohon as $d)
            <tr>
              <td>{{$nmr++}}</td>
              <td>{{$d->nama_tanaman}}</td>
              <td>Nilai</td>
              <td>{{$d->lcr}}</td>
              <td>{{$d->cden}}</td>
              <td>{{$d->ft}}</td>
              <td>{{$d->cdb}}</td>
              <td>{{$d->cdw}}</td>
              <td>{{$d->cd90}}</td>
              <td>{{$d->cd}}</td>
              <td></td>
            </tr>
            <tr>
              <td></td>
              <td><i>{{$d->nama_latin}}</i></td>
              <td>Perhitungan</td>
              <td>{{$d->nlcr}}</td>
              <td>{{$d->ncden}}</td>
              <td>{{$d->nft}}</td>
              <td>{{$d->ncdb}}</td>
              <td></td>
              <td></td>
              <td>{{$d->ncd}}</td>
              <td>{{$d->vcri}} ({{$d->kesimpulan}})</td>
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

@push('script_tambahan')
<script src="{{asset('Admin/modal_ajax.min.js')}}"></script>
@endpush

{{-- include modal --}}
@include('auditor.include.isi_pengukuran.modal_detail')
@include('auditor.include.isi_pengukuran.modal_tambah_tanaman')
@include('auditor.include.data_pengukuran_plot.tajuk.tajuk')
@include('auditor.include.data_pengukuran_plot.tajuk.modal_tambah_foto_pengukuran')
@include('auditor.include.data_pengukuran_plot.tajuk.modal_edit_foto_pengukuran')
@include('auditor.include.data_pengukuran_plot.tajuk.modal_delete_foto')
@include('auditor.include.data_pengukuran_plot.tajuk.modal_delete_tajuk')
@include('auditor.include.data_pengukuran_plot.tajuk.delete_all_tajuk')
@include('auditor.include.import.import_tajuk')
@include('auditor.include.import.import_pohon')

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
     $('#data_kondisi_tajuk').DataTable({
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
