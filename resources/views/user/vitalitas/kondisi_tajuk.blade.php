@extends('layouts.layout')
@section('title','Data Pengukuran')
@section('active_data_pengukuran','active')
@section('active_vitalitas','active')
@section('breadcrumb')
<li><a href="{{route('user.data_indikator', encrypt($id))}}">Data Indikator</a></li>
<li><a href="{{route('user.pengukuran_vitalitas',encrypt($id))}}">Paramater Vitalitas</a></li>
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
             <option value="{{route('user.tajuk', encrypt($id_pengukuran))}}">{{$nama_plots[$no]}}</option>
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

  <div class="col-xs-12">
    <div class="box collapsed-box">
      <div class="box-header">
        <div class="box-tools pull-right">
          <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
          </button>
        </div>
          <h2> <i class="fa fa-fw fa-camera"></i>Foto Dokumentasi
            <a style="margin-left:10px;" class="btn btn-primary pull-right" data-toggle="modal" data-target="#modal_tambah_foto" href="#"><i class="fa fa-fw fa-plus"></i>Tambah</a>
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
            <div style="margin-bottom: 50px" class="footer-gallery">
              <a style="margin-left: 10px;" type="button" name="edit_foto_pengukuran" id="edit_foto_pengukuran" data-foto="{{$data_foto_pengukuran->id_foto_tajuk}}" class="btn btn-warning pull-left"  data-toggle="modal" data-target="#modal_edit_foto">edit</a>
              <a style="margin-right: 10px;" type="button" name="delete_foto_pengukuran" id="delete_foto_pengukuran" data-foto="{{$data_foto_pengukuran->id_foto_tajuk}}" class="btn btn-danger pull-right"  data-toggle="modal" data-target="#modal_delete_foto">delete</a>
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
            @if((count($data_pohon_import)==0) && (count($data_pohon)!=0))
              <a style="margin-left:10px;" class="btn btn-success pull-right" data-toggle="modal" data-target="#modal_import_tajuk" href="#"><i class="fa fa-fw fa-file-excel-o"></i></a>
            @endif
            @if(count($data_pohon)==0)
              <a style="margin-left:10px;" class="btn btn-primary pull-right" data-toggle="modal" data-target="#modal_import_pohon" href="#"><i class="fa fa-fw fa-file-excel-o"></i>Import Pohon</a>
            @endif
            <a style="margin-left:10px;" class="btn btn-info pull-right" data-toggle="modal" data-target="#modal_tambah_tanaman" href="#"><i class="fa fa-plus"></i></a>
          </h3>
          <h4>
            <a class="btn btn-success btn-xs" href="{{route('user.lbds',encrypt($id))}}">Pertumbuhan</a>
            <a class="btn btn-danger btn-xs" href="{{route('user.kerusakan', encrypt($id))}}">Kerusakan Pohon</a>
            <a class="btn btn-warning btn-xs" href="">Kondisi Tajuk</a>
            <a class="btn btn-primary btn-xs" href="{{route('user.bio_pohon',encrypt($id))}}">Biodiversitas Pohon</a>
            <a class="btn btn-primary btn-xs" href="{{route('user.bio_fauna',encrypt($id))}}">Biodiversitas Fauna</a>
            <a class="btn btn-info btn-xs" href="{{route('user.kimia',encrypt($id))}}">Kualitas Tapak (Kimia)</a>
            <a class="btn btn-info btn-xs" href="{{route('user.fisika',encrypt($id))}}">Kualitas Tapak (Fisik)</a>
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
              <th>Aksi</th>
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
              <td>
                <a class="fa fa-edit btn btn-warning btn-xs" data-info="{{$d->id_tanaman_plot}}" data-info_pengukuran="{{$data_pengukuran->id_pengukuran}}" data-toggle="modal" data-target="#modal_tambah_tajuk"></a>
                <a class="fa fa-eraser btn btn-danger btn-xs" data-info="{{$d->id}}" data-toggle="modal" data-target="#modal_delete_tajuk" href="#"></a>
              </td>
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
              <td></td>
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
                  <th></th>
                  <th></th>
                  <th></th>
                  <th></th>
                  <th></th>
                  <th></th>
                  <th></th>
                  <th>
                    @if(count($data_pohon)>0)
                      <a class="fa fa-eraser btn btn-danger btn-xs" data-info2="{{$data_pengukuran->id_pengukuran}}" data-toggle="modal" data-target="#modal_delete_all" href="#">Hapus semua</a>
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

<script src="{{asset('Admin/modal_ajax.min.js')}}"></script>
<script src="{{asset('Admin/bower_components/jquery/dist/jquery.min.js')}}"></script>

{{-- include modal --}}
@include('user.include.isi_pengukuran.modal_detail')
@include('user.include.isi_pengukuran.modal_tambah_tanaman')
@include('user.include.data_pengukuran_plot.tajuk.tajuk')
@include('user.include.data_pengukuran_plot.tajuk.modal_tambah_foto_pengukuran')
@include('user.include.data_pengukuran_plot.tajuk.modal_edit_foto_pengukuran')
@include('user.include.data_pengukuran_plot.tajuk.modal_delete_foto')
@include('user.include.data_pengukuran_plot.tajuk.modal_delete_tajuk')
@include('user.include.data_pengukuran_plot.tajuk.delete_all_tajuk')
@include('user.include.import.import_tajuk')
@include('user.include.import.import_pohon')

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
