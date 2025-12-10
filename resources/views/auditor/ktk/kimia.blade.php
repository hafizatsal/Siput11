@extends('layouts.layoutauditor')
@section('title','Data Pengukuran')
@section('active_data_pengukuran','active')
@section('active_kualitas_tapak','active')
@section('breadcrumb')
<li><a href="#">Kualitas Tapak Kimia</a></li>
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
             <option value="{{route('auditor.kimia', encrypt($id_pengukuran))}}">{{$nama_plots[$no]}}</option>
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
          <h3>Data Kualitas Tapak (Kimia)
          </h3>
          <h4>
            <a class="btn btn-success btn-xs" href="{{route('auditor.lbds', encrypt($id))}}">Pertumbuhan</a>
            <a class="btn btn-danger btn-xs" href="{{route('auditor.kerusakan', encrypt($id))}}">Kerusakan Pohon</a>
            <a class="btn btn-warning btn-xs" href="{{route('auditor.tajuk', encrypt($id))}}">Kondisi Tajuk</a>
            <a class="btn btn-primary btn-xs" href="{{route('auditor.bio_pohon',encrypt($id))}}">Biodiversitas Pohon</a>
            <a class="btn btn-primary btn-xs" href="{{route('auditor.bio_fauna',encrypt($id))}}">Biodiversitas Fauna</a>
            <a class="btn btn-info btn-xs" href="">Kualitas Tapak (Kimia)</a>
            <a class="btn btn-info btn-xs" href="{{route('auditor.fisika',encrypt($id))}}">Kualitas Tapak (Fisik)</a>
        </h4>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <div class="col-xs-12 table-responsive">
          <table id="data_ktk_kimia" class="table table-bordered table-striped">
            <thead>
            <tr>
              <th>No.</th>
              <th>Kode Klaster</th>
              <th>Sifat Kimia</th>
              <th>
                <div class="tooltips">
                  CEC (me/100 g)
                  <span class="tooltiptexts">Cation Exchange Capacity</span>
                </div>
              </th>
            </tr>
            </thead>
            <tbody>
              @php($nmr=1) @foreach($data_ktk_kimia as $sifat_kimia)
            <tr>
              <td>{{$nmr++}}</td>
              <td>{{$sifat_kimia->nama_klaster}}</td>
              <td>{{$sifat_kimia->sifat_kimia}}</td>
              <td>{{$sifat_kimia->cec}}</td>
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

<script src="{{asset('Admin/modal_ajax.min.js')}}"></script>
<script src="{{asset('Admin/bower_components/jquery/dist/jquery.min.js')}}"></script>

{{-- include modal --}}
@include('auditor.include.isi_pengukuran.modal_detail')
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
     $('#data_ktk_kimia').DataTable({
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
