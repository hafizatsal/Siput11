@extends('layouts.layoutauditor')
@section('title','Data Pengukuran')
@section('active_data_pengukuran','active')
@section('active_vitalitas','active')
@section('breadcrumb')
<li><a href="#">Kerusakan Pohon</a></li>
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
             <option value="{{route('auditor.kerusakan', encrypt($id_pengukuran))}}">{{$nama_plots[$no]}}</option>
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
            <a target="_blank" href="{{asset('upload/pengukuran/kerusakan/'. $data_foto_pengukuran->filename)}}">
              <img src="{{asset('upload/pengukuran/kerusakan/'. $data_foto_pengukuran->filename)}}" alt="{{$data_foto_pengukuran->title}}" width="600" height="400">
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
          <h3>Data Kerusakan Pohon
          </h3>
          <h4>
            <a class="btn btn-success btn-xs" href="{{route('auditor.lbds',encrypt($id))}}">Pertumbuhan</a>
            <a class="btn btn-danger btn-xs" href="">Kerusakan Pohon</a>
            <a class="btn btn-warning btn-xs" href="{{route('auditor.tajuk', encrypt($id))}}">Kondisi Tajuk</a>
            <a class="btn btn-primary btn-xs" href="{{route('auditor.bio_pohon',encrypt($id))}}">Biodiversitas Pohon</a>
            <a class="btn btn-primary btn-xs" href="{{route('auditor.bio_fauna',encrypt($id))}}">Biodiversitas Fauna</a>
            <a class="btn btn-info btn-xs" href="{{route('auditor.kimia',encrypt($id))}}">Kualitas Tapak (Kimia)</a>
            <a class="btn btn-info btn-xs" href="{{route('auditor.fisika',encrypt($id))}}">Kualitas Tapak (Fisika)</a>
        </h4>

        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <div class="col-xs-12 table-responsive">
          <table id="data_kerusakan" class="table table-bordered table-striped">
            <thead>
            <tr>
              <th style="text-align: center; vertical-align: middle">No.</th>
              <th style="text-align: center; vertical-align: middle">Nama Pohon</th>
              <th style="text-align: center; vertical-align: middle">Jenis Nilai</th>
              <th style="text-align: center; vertical-align: middle">
                <div class="tooltips">
                  DgL1
                  <span class="tooltiptexts">Kode Lokasi</span>
                </div>
              </th>
              <th style="text-align: center; vertical-align: middle">
                <div class="tooltips">
                  DgT1
                  <span class="tooltiptexts">Kode Tipe</span>
                </div>
                </th>
              <th style="text-align: center; vertical-align: middle">
                <div class="tooltips">
                  Svrt1
                  <span class="tooltiptexts">Kode Keparahan</span>
                </div>
                </th>
              <th style="text-align: center; vertical-align: middle">
                <div class="tooltips">
                  DgL2
                  <span class="tooltiptexts">Kode Lokasi</span>
                </div>
                </th>
              <th style="text-align: center; vertical-align: middle">
                <div class="tooltips">
                  DgT2
                  <span class="tooltiptexts">Kode Tipe</span>
                </div>
                </th>
              <th style="text-align: center; vertical-align: middle">
                <div class="tooltips">
                  Svrt2
                  <span class="tooltiptexts">Kode Keparahan</span>
                </div>
                </th>
              <th style="text-align: center; vertical-align: middle">
                <div class="tooltips">
                  DgL3
                  <span class="tooltiptexts">Kode Lokasi</span>
                </div>
                </th>
              <th style="text-align: center; vertical-align: middle">
                <div class="tooltips">
                  DgT3
                  <span class="tooltiptexts">Kode Tipe</span>
                </div>
                </th>
              <th style="text-align: center; vertical-align: middle">
                <div class="tooltips">
                  Svrt3
                  <span class="tooltiptexts">Kode Keparahan</span>
                </div>
                </th>
              <th style="text-align: center; vertical-align: middle">
                <div class="tooltips">
                  TLI
                  <span class="tooltiptexts">Tree Damage Level Index</span>
                </div>
                </th>

            </tr>
            </thead>
            <tbody>
              @php ($nmr=1) @foreach($data_pohon as $d)
            <tr>
              <td>{{$nmr++}}</td>
              <td>{{$d->nama_tanaman}}</td>
              <td>Kode Kerusakan</td>
              <td>{{$d->kdDgL1}}</td>
              <td>{{$d->kdDgT1}}</td>
              <td>{{$d->kdSrVT1}}</td>
              <td>{{$d->kdDgL2}}</td>
              <td>{{$d->kdDgT2}}</td>
              <td>{{$d->kdSrVT2}}</td>
              <td>{{$d->kdDgL3}}</td>
              <td>{{$d->kdDgT3}}</td>
              <td>{{$d->kdSrVT3}}</td>
              <td>{{$d->tli}}</td>

            </tr>
            <tr>
              <td></td>
              <td><i>{{$d->nama_latin}}</i></td>
              <td>Perhitungan</td>
              <td>{{$d->nDgL1}}</td>
              <td>{{$d->nDgT1}}</td>
              <td>{{$d->nSrVT1}}</td>
              <td>{{$d->nDgL2}}</td>
              <td>{{$d->nDgT2}}</td>
              <td>{{$d->nSrVT2}}</td>
              <td>{{$d->nDgL3}}</td>
              <td>{{$d->nDgT3}}</td>
              <td>{{$d->nSrVT3}}</td>
              <td></td>
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
@include('user.include.isi_pengukuran.modal_detail')
@include('user.include.isi_pengukuran.modal_tambah_tanaman')
@include('user.include.data_pengukuran_plot.kerusakan.modal_tambah_foto_pengukuran')
@include('user.include.data_pengukuran_plot.kerusakan.modal_edit_foto_pengukuran')
@include('user.include.data_pengukuran_plot.kerusakan.modal_delete_foto')
@include('user.include.data_pengukuran_plot.kerusakan.kerusakan')
@include('user.include.data_pengukuran_plot.kerusakan.modal_delete_kerusakan')
@include('user.include.data_pengukuran_plot.kerusakan.delete_all_kerusakan')
@include('user.include.import.import_kerusakan')
@include('user.include.import.import_pohon')

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
     $('#data_kerusakan').DataTable({
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
