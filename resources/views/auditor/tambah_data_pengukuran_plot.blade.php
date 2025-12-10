@extends('layouts.layout')
@section('title','Data Pengukuran')
@section('active-treeview','active')
@section('active_pengukuran','active')
@section('breadcrumb')
<li><a href="{{route('auditor.klaster.data_klaster.detail', encrypt($id_klaster))}}">Detail Klaster</a></li>
<li><a href="{{route('auditor.plot.lihat_plot', encrypt($id_plot))}}">Detail Data Plot</a></li>
<li><a href="#">Data Pengukuran Plot</a></li>
@endsection
@section('main_section')


<div class="row">
   <div class="col-xs-12">
     <div class="box">
       <div class="box-header">
           <h2><i class="fa fa-globe"></i> Data Pengukuran Plot
           <a class="btn btn-success pull-right" data-klasterid="" data-toggle="modal" data-target="#modal_tambah_fauna" href=""><i class="fa fa-plus"></i>Tambah Fauna</a>
           <a class="btn btn-info pull-right" data-klasterid="" data-toggle="modal" data-target="#modal_tambah_tanaman" href=""><i class="fa fa-plus"></i>Tambah Pohon</a>
         </h2> &nbsp
       </div>
        <div class="box-body">
       <div class="col-xs-12 table-responsive">
       <table id="detail_plot" class="table table-striped">
         <tbody>
           <tr>
             <td>Nama Plot</td>
             <td> :  {{$data_pengukuran->nama_plot}}</td>
             <td></td>
           </tr>

           <tr>
             <td>Pengukuran ke</td>
             <td> : {{$data_pengukuran->pengukuran_ke}} </td>
             <td></td>
           </tr>

           <tr>
             <td>Tanggal Pengukuran</td>
             <td> : {{$data_pengukuran->tahun_pengukuran}}</td>
             <td></td>
           </tr>

           <tr>
             <td>Nama Pengukur</td>
             <td> : {{$data_pengukuran->nama_pengukur}}</td>
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

<!-- /.content -->
<div class="row">
  <div class="col-xs-12 table">
    <div class="box">
        <div class="box-header">
          <h3 class="box-title">Data Pengukuran Pohon </h3>
          <h4>
            <a class="btn btn-success btn-xs" href="{{route('auditor.pertumbuhan', encrypt($data_pengukuran->id_pengukuran))}}">Pertumbuhan</a>
            <a class="btn btn-danger btn-xs">Kerusakan Pohon</a>
            <a class="btn btn-warning btn-xs" >Kondisi Tajuk</a>
        </h4>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <table id="tambah_data_pengukuran_plot" class="table table-bordered table-striped">
            <thead>
            <tr>
              <th style="width:4%">#</th>
              <th style="width:30%">Nama Pohon</th>
              <th style="width:25%">Nama Latin</th>
              <th style="width:31%" class="indikator">Indikator</th>
              <th style="width:10%" class="status">Status</th>
            </tr>
            </thead>
            <tbody>
              @php ($nmr=1) @foreach($data_pohon as $d)
            <tr>
              <td>{{$nmr++}}</td>
              <td>{{$d->nama_tanaman}} </td>
              <td>{{$d->nama_latin}} </td>
               @if($d->status==1)
              <td class="indikator"> <!-- -->
                <a class="btn btn-success btn-xs" data-info="{{$d->id_tanaman_plot}}" data-info_pengukuran="{{$data_pengukuran->id_pengukuran}}" data-toggle="modal" data-target="#modal_tambah_pertumbuhan">Pertumbuhan</a>
                <a class="btn btn-danger btn-xs" data-info="{{$d->id_tanaman_plot}}" data-info_pengukuran="{{$data_pengukuran->id_pengukuran}}" data-toggle="modal" data-target="#modal_tambah_kerusakan">Kerusakan Pohon</a>
                <a class="btn btn-warning btn-xs" data-info="{{$d->id_tanaman_plot}}" data-info_pengukuran="{{$data_pengukuran->id_pengukuran}}" data-toggle="modal" data-target="#modal_tambah_tajuk">Kondisi Tajuk</a>
              </td>
              <td>
                <a class="btn btn-success btn-xs" data-info="0" data-pohon="{{$d->id_tanaman_plot}}" data-toggle="modal" data-target="#modal_status">Hidup</a>
              </td>
                @else
                <td class="indikator"> <!-- -->
                  <a class="btn btn-success btn-xs" data-info="{{$d->id_tanaman_plot}}" data-info_pengukuran="{{$data_pengukuran->id_pengukuran}}" data-toggle="modal" data-target="#modal_tambah_pertumbuhan" disabled>Pertumbuhan</a>
                  <a class="btn btn-danger btn-xs" data-info="{{$d->id_tanaman_plot}}" data-info_pengukuran="{{$data_pengukuran->id_pengukuran}}" data-toggle="modal" data-target="#modal_tambah_kerusakan" disabled>Kerusakan Pohon</a>
                  <a class="btn btn-warning btn-xs" data-info="{{$d->id_tanaman_plot}}" data-info_pengukuran="{{$data_pengukuran->id_pengukuran}}" data-toggle="modal" data-target="#modal_tambah_tajuk" disabled>Kondisi Tajuk</a>
                </td>
                <td>
                <a class="btn btn-danger btn-xs" data-info="1" data-pohon="{{$d->id_tanaman_plot}}" data-toggle="modal" data-target="#modal_status">Mati</a>
                </td>
                @endif

            </tr>
@endforeach
            </tbody>
            <tfoot>

            </tfoot>
          </table>
        </div>
        <!-- /.box-body -->
      </div>
  </div>
</div>

<div class="row">
 <div class="col-xs-12 table">
  <div class="box">
  <div class="box-header">
   <h2>Data Biodiversitas Pohon
<a class="btn btn-info pull-right" data-klasterid="" data-toggle="modal" data-target="#modal_tambah_tanaman" href=""><i class="fa fa-plus"></i></a>
   </h2> &nbsp
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

<script src="{{asset('Admin/modal_ajax.min.js')}}"></script>
<script src="{{asset('Admin/bower_components/jquery/src/jquery.js')}}"></script>
<script src="{{asset('Admin/bower_components/jquery/dist/jquery.min.js')}}"></script>

{{-- include modal --}}
@include('auditor.include.isi_pengukuran.modal_tambah_tanaman')
@include('auditor.include.isi_pengukuran.pohon.modal_status_pohon')
@include('auditor.include.isi_pengukuran.fauna.modal_tambah_fauna')
@include('auditor.include.isi_pengukuran.fauna.modal_edit_fauna')
@include('auditor.include.isi_pengukuran.fauna.modal_delete_fauna')
@include('auditor.include.data_pengukuran_plot.pertumbuhan.pertumbuhan')
@include('auditor.include.data_pengukuran_plot.kerusakan.kerusakan')
@include('auditor.include.data_pengukuran_plot.tajuk.tajuk')

@section('data_table')
<!-- DataTables -->
<script src="{{asset('Admin/bower_components/datatables.net/js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('Admin/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js')}}"></script>
@endsection

<script type="text/javascript">
$(document).ready(function() {
  // variabel untuk menampung jumlah nilai 3, 2, dan 1
  var jumlah_nilai=[0,0,0,0,0];
  //
    $("#K2").hide();
    $("#K3").hide();
    $("#N2").hide();
    $("#N3").hide();
  //BAGIAN SHOW HIDE INPUT KODE KERUSAKAN
  $('#k_add1').click(function(){
    $("#K2").show();
    $("#N2").show();
    $("#k_add2").show();
    $("#k_r2").show();
    $("#k_add1").hide();

  });

  $('#k_add2').click(function(){
    $("#K3").show();
    $("#N3").show();
    $("#k_add2").hide();
    $("#k_r2").hide();
  });

  $('#k_r3').click(function(){
    $("#K3").hide();
    $("#N3").hide();
    $("#k_add2").show();
    $("#k_r2").show();
  });

  $('#k_r2').click(function(){
    $("#K2").hide();
    $("#N2").hide();
    $("#k_add1").show();
  });

  $('#modal_tambah_tajuk').on('show.bs.modal', function(event){
  var button = $(event.relatedTarget);
  var info = button.data('info');
  var info_pengukuran = button.data('info_pengukuran');
  var modal = $(this)
  modal.find('#id_pengukuran_t').val(info_pengukuran);
  modal.find('#id_tanaman2').val(info);

  $.get('/user/json-data_kondisi_tajuk?id_pengukuran=' + info_pengukuran + '&id_tanaman=' + info, function(data){
    if(data.length!=0){
   $.each(data, function(index, tajukObj){
     $('#lcr').val(tajukObj.lcr);
     $('#cden').val(tajukObj.cden);
     $('#ft').val(tajukObj.ft);
     $('#cdb').val(tajukObj.cdb);
     $('#cdw').val(tajukObj.cdw);
     $('#cd90').val(tajukObj.cd90);
     $('#cd').val(tajukObj.cd);

     $('#hasil_lcr').val(tajukObj.nlcr);
     if(tajukObj.nlcr==3){
       jumlah_nilai[0]=3;
     }
     else if(tajukObj.nlcr==2){
       jumlah_nilai[0]=2;
     }
     else if(tajukObj.nlcr==1){
       jumlah_nilai[0]=1;
     }

     $('#hasil_cden').val(tajukObj.ncden);
     if(tajukObj.ncden==3){
       jumlah_nilai[1]=3;
     }
     else if(tajukObj.ncden==2){
       jumlah_nilai[1]=2;
     }
     else if(tajukObj.ncden==1){
       jumlah_nilai[1]=1;
     }

     $('#hasil_ft').val(tajukObj.nft);
     if(tajukObj.nft==3){
       jumlah_nilai[2]=3;
     }
     else if(tajukObj.nft==2){
       jumlah_nilai[2]=2;
     }
     else if(tajukObj.nft==1){
       jumlah_nilai[2]=1;
     }

     $('#hasil_cdb').val(tajukObj.ncdb);
     if(tajukObj.ncdb==3){
       jumlah_nilai[3]=3;
     }
     else if(tajukObj.ncdb==2){
       jumlah_nilai[3]=2;
     }
     else if(tajukObj.ncdb==1){
       jumlah_nilai[3]=1;
     }

     $('#hasil_cd').val(tajukObj.ncd);
     if(tajukObj.ncd==3){
       jumlah_nilai[4]=3;
     }
     else if(tajukObj.ncd==2){
       jumlah_nilai[4]=2;
     }
     else if(tajukObj.ncd==1){
       jumlah_nilai[4]=1;
     }

     $('#hasil_vcr').val(tajukObj.vcri);
     $('#kesimpulan').val(tajukObj.kesimpulan);
     console.log(jumlah_nilai);
   });
 }
 });
  });

  $('#modal_tambah_tajuk').on('hidden.bs.modal', function(){
    $('#lcr').val("");
    $('#cden').val("");
    $('#ft').val("");
    $('#cdb').val("");
    $('#cdw').val("");
    $('#cd90').val("");
    $('#cd').val("");
    $('#hasil_lcr').val("");
    $('#hasil_cden').val("");
    $('#hasil_ft').val("");
    $('#hasil_cdb').val("");
    $('#hasil_cd').val("");
    // $('#hasil_vcr').val("");
    // $('#kesimpulan').val("");
      });

  $('#modal_tambah_kerusakan').on('show.bs.modal', function(event){
  var button3 = $(event.relatedTarget);
  var info3 = button3.data('info');
  var info_pengukuran = button3.data('info_pengukuran');
  var modal3 = $(this)
  modal3.find('#id_pengukuran_r').val(info_pengukuran);
  modal3.find('#id_tanaman').val(info3);

  $.get('/user/json-data_kerusakan?id_pengukuran=' + info_pengukuran + '&id_tanaman=' + info3, function(data){
    if(data.length!=0){
   $.each(data, function(index, kerusakanObj){
     $('#DgL1').val(kerusakanObj.kdDgL1);
     $('#DgT1').val(kerusakanObj.kdDgT1);
     $('#SrVT1').val(kerusakanObj.kdSrVT1);
     $('#DgL2').val(kerusakanObj.kdDgL2);
     $('#DgT2').val(kerusakanObj.kdDgT2);
     $('#SrVT2').val(kerusakanObj.kdSrVT2);
     $('#DgL3').val(kerusakanObj.kdDgL3);
     $('#DgT3').val(kerusakanObj.kdDgT3);
     $('#SrVT3').val(kerusakanObj.kdSrVT3);

     $('#hDgL1').val(kerusakanObj.nDgL1);
     $('#hDgT1').val(kerusakanObj.nDgT1);
     $('#hSrVT1').val(kerusakanObj.nSrVT1);
     $('#hDgL2').val(kerusakanObj.nDgL2);
     $('#hDgT2').val(kerusakanObj.nDgT2);
     $('#hSrVT2').val(kerusakanObj.nSrVT2);
     $('#hDgL3').val(kerusakanObj.nDgL3);
     $('#hDgT3').val(kerusakanObj.nDgT3);
     $('#hSrVT3').val(kerusakanObj.nSrVT3);
     $('#hasil_tli').val(kerusakanObj.tli);
   });
 }
 });
  });

  $('#modal_tambah_kerusakan').on('hidden.bs.modal', function(){
    $('#DgL1').val("");
    $('#DgT1').val("");
    $('#SrVT1').val("");
    $('#DgL2').val("");
    $('#DgT2').val("");
    $('#SrVT2').val("");
    $('#DgL3').val("");
    $('#DgT3').val("");
    $('#SrVT3').val("");

    $('#hDgL1').val("");
    $('#hDgT1').val("");
    $('#hSrVT1').val("");
    $('#hDgL2').val("");
    $('#hDgT2').val("");
    $('#hSrVT2').val("");
    $('#hDgL3').val("");
    $('#hDgT3').val("");
    $('#hSrVT3').val("");
    $('#hasil_tli').val("");
      });

  // perhitungan kerusakan lokasi
var DgL1=0;
var nilai_lokasi=0;
  $('#DgL1').keyup(function() {
           DgL1=$(this).val();
           if(DgL1==""){
             DgL1=0;
           }
           $.get('/user/json-kerusakan_lokasi?kode=' + DgL1, function(data){
             if(data.length==0){
               $('#hDgL1').val("null"); //tambahin validasi error
             }
             else{
             $.each(data, function(index, kerusakanlokasiObj){
           nilai_lokasi=kerusakanlokasiObj.nilai;
          $('#hDgL1').val(nilai_lokasi);
          // perhitungan nilai TLI
          // rumus = total (kode_kerusakan_lokasi*kode_kerusakan_type*kode_kerusakan_keparahan)
          $('#hasil_tli').val( $('#hDgL1').val()*$('#hDgT1').val()*$('#hSrVT1').val() +
                               $('#hDgL2').val()*$('#hDgT2').val()*$('#hSrVT2').val() +
                               $('#hDgL3').val()*$('#hDgT3').val()*$('#hSrVT3').val() );
        });
          }
      });
    });

    // perhitungan kerusakan tipe
  var DgT1=0;
  var nilai_tipe=0;
    $('#DgT1').keyup(function() {
             DgT1=$(this).val();
             if(DgT1==""){
               DgT1=0;
             }
             $.get('/user/json-kerusakan_tipe?kode=' + DgT1, function(data){
               if(data.length==0){
                 $('#hDgT1').val("null"); //tambahin validasi error
               }
               else{
               $.each(data, function(index, kerusakantipeObj){
             nilai_tipe=kerusakantipeObj.nilai;
            $('#hDgT1').val(nilai_tipe);
            // perhitungan nilai TLI
            // rumus = total (kode_kerusakan_lokasi*kode_kerusakan_type*kode_kerusakan_keparahan)
            $('#hasil_tli').val( $('#hDgL1').val()*$('#hDgT1').val()*$('#hSrVT1').val() +
                                 $('#hDgL2').val()*$('#hDgT2').val()*$('#hSrVT2').val() +
                                 $('#hDgL3').val()*$('#hDgT3').val()*$('#hSrVT3').val() );
          });
        }
        });
      });

      // perhitungan kerusakan keparahan
    var SrVT1=0;
    var nilai_keparahan=0;
      $('#SrVT1').keyup(function() {
               SrVT1=$(this).val();
               if(SrVT1==""){
                 SrVT1=0;
               }
               $.get('/user/json-kerusakan_keparahan?tingkat=' + SrVT1, function(data){
                 if(data.length==0){
                   $('#hSrVT1').val("null"); //tambahin validasi error
                 }
                 else{
                 $.each(data, function(index, kerusakankeparahanObj){
               nilai_keparahan=kerusakankeparahanObj.nilai;
              $('#hSrVT1').val(nilai_keparahan);
              // perhitungan nilai TLI
              // rumus = total (kode_kerusakan_lokasi*kode_kerusakan_type*kode_kerusakan_keparahan)
              $('#hasil_tli').val( $('#hDgL1').val()*$('#hDgT1').val()*$('#hSrVT1').val() +
                                   $('#hDgL2').val()*$('#hDgT2').val()*$('#hSrVT2').val() +
                                   $('#hDgL3').val()*$('#hDgT3').val()*$('#hSrVT3').val() );
            });
          }
          });
        });


        // perhitungan kerusakan lokasi 2
      var DgL2=0;
      var nilai_lokasi=0;
        $('#DgL2').keyup(function() {
                 DgL2=$(this).val();
                 if(DgL2==""){
                   DgL2=0;
                 }
                 $.get('/user/json-kerusakan_lokasi?kode=' + DgL2, function(data){
                   if(data.length==0){
                     $('#hDgL2').val("null"); //tambahin validasi error
                   }
                   else{
                   $.each(data, function(index, kerusakanlokasiObj){
                 nilai_lokasi=kerusakanlokasiObj.nilai;
                $('#hDgL2').val(nilai_lokasi);
                // perhitungan nilai TLI
                // rumus = total (kode_kerusakan_lokasi*kode_kerusakan_type*kode_kerusakan_keparahan)
                $('#hasil_tli').val( $('#hDgL1').val()*$('#hDgT1').val()*$('#hSrVT1').val() +
                                     $('#hDgL2').val()*$('#hDgT2').val()*$('#hSrVT2').val() +
                                     $('#hDgL3').val()*$('#hDgT3').val()*$('#hSrVT3').val() );
              });
                }
            });
          });

          // perhitungan kerusakan tipe 2
        var DgT2=0;
        var nilai_tipe=0;
          $('#DgT2').keyup(function() {
                   DgT2=$(this).val();
                   if(DgT2==""){
                     DgT2=0;
                   }
                   $.get('/user/json-kerusakan_tipe?kode=' + DgT2, function(data){
                     if(data.length==0){
                       $('#hDgT2').val("null"); //tambahin validasi error
                     }
                     else{
                     $.each(data, function(index, kerusakantipeObj){
                   nilai_tipe=kerusakantipeObj.nilai;
                  $('#hDgT2').val(nilai_tipe);
                  // perhitungan nilai TLI
                  // rumus = total (kode_kerusakan_lokasi*kode_kerusakan_type*kode_kerusakan_keparahan)
                  $('#hasil_tli').val( $('#hDgL1').val()*$('#hDgT1').val()*$('#hSrVT1').val() +
                                       $('#hDgL2').val()*$('#hDgT2').val()*$('#hSrVT2').val() +
                                       $('#hDgL3').val()*$('#hDgT3').val()*$('#hSrVT3').val() );
                });
              }
              });
            });

            // perhitungan kerusakan keparahan 2
          var SrVT2=0;
          var nilai_keparahan=0;
            $('#SrVT2').keyup(function() {
                     SrVT2=$(this).val();
                     if(SrVT2==""){
                       SrVT2=0;
                     }
                     $.get('/user/json-kerusakan_keparahan?tingkat=' + SrVT2, function(data){
                       if(data.length==0){
                         $('#hSrVT2').val("null"); //tambahin validasi error
                       }
                       else{
                       $.each(data, function(index, kerusakankeparahanObj){
                     nilai_keparahan=kerusakankeparahanObj.nilai;
                    $('#hSrVT2').val(nilai_keparahan);
                    // perhitungan nilai TLI
                    // rumus = total (kode_kerusakan_lokasi*kode_kerusakan_type*kode_kerusakan_keparahan)
                    $('#hasil_tli').val( $('#hDgL1').val()*$('#hDgT1').val()*$('#hSrVT1').val() +
                                         $('#hDgL2').val()*$('#hDgT2').val()*$('#hSrVT2').val() +
                                         $('#hDgL3').val()*$('#hDgT3').val()*$('#hSrVT3').val() );
                  });
                }
                });
              });

              // perhitungan kerusakan lokasi 3
            var DgL3=0;
            var nilai_lokasi=0;
              $('#DgL3').keyup(function() {
                       DgL3=$(this).val();
                       if(DgL3==""){
                         DgL3=0;
                       }
                       $.get('/user/json-kerusakan_lokasi?kode=' + DgL3, function(data){
                         if(data.length==0){
                           $('#hDgL3').val("null"); //tambahin validasi error
                         }
                         else{
                         $.each(data, function(index, kerusakanlokasiObj){
                       nilai_lokasi=kerusakanlokasiObj.nilai;
                      $('#hDgL3').val(nilai_lokasi);
                      // perhitungan nilai TLI
                      // rumus = total (kode_kerusakan_lokasi*kode_kerusakan_type*kode_kerusakan_keparahan)
                      $('#hasil_tli').val( $('#hDgL1').val()*$('#hDgT1').val()*$('#hSrVT1').val() +
                                           $('#hDgL2').val()*$('#hDgT2').val()*$('#hSrVT2').val() +
                                           $('#hDgL3').val()*$('#hDgT3').val()*$('#hSrVT3').val() );
                    });
                      }
                  });
                });

                // perhitungan kerusakan tipe 3
              var DgT3=0;
              var nilai_tipe=0;
                $('#DgT3').keyup(function() {
                         DgT3=$(this).val();
                         if(DgT3==""){
                           DgT3=0;
                         }
                         $.get('/user/json-kerusakan_tipe?kode=' + DgT3, function(data){
                           if(data.length==0){
                             $('#hDgT3').val("null"); //tambahin validasi error
                           }
                           else{
                           $.each(data, function(index, kerusakantipeObj){
                         nilai_tipe=kerusakantipeObj.nilai;
                        $('#hDgT3').val(nilai_tipe);
                        // perhitungan nilai TLI
                        // rumus = total (kode_kerusakan_lokasi*kode_kerusakan_type*kode_kerusakan_keparahan)
                        $('#hasil_tli').val( $('#hDgL1').val()*$('#hDgT1').val()*$('#hSrVT1').val() +
                                             $('#hDgL2').val()*$('#hDgT2').val()*$('#hSrVT2').val() +
                                             $('#hDgL3').val()*$('#hDgT3').val()*$('#hSrVT3').val() );
                      });
                    }
                    });
                  });

                  // perhitungan kerusakan keparahan 3
                var SrVT3=0;
                var nilai_keparahan=0;
                  $('#SrVT3').keyup(function() {
                           SrVT3=$(this).val();
                           if(SrVT3==""){
                             SrVT3=0;
                           }
                           $.get('/user/json-kerusakan_keparahan?tingkat=' + SrVT3, function(data){
                             if(data.length==0){
                               $('#hSrVT3').val("null"); //tambahin validasi error
                             }
                             else{
                             $.each(data, function(index, kerusakankeparahanObj){
                           nilai_keparahan=kerusakankeparahanObj.nilai;
                          $('#hSrVT3').val(nilai_keparahan);
                          // perhitungan nilai TLI
                          // rumus = total (kode_kerusakan_lokasi*kode_kerusakan_type*kode_kerusakan_keparahan)
                          $('#hasil_tli').val( $('#hDgL1').val()*$('#hDgT1').val()*$('#hSrVT1').val() +
                                               $('#hDgL2').val()*$('#hDgT2').val()*$('#hSrVT2').val() +
                                               $('#hDgL3').val()*$('#hDgT3').val()*$('#hSrVT3').val() );
                        });
                      }
                      });
                    });

  // perhitungan kondisi Tajuk
  var cden=0;
  var ft = 0;
  var cd = 0;
  var cdw = 0;
  var cd90 = 0;
  var lcr = 0;
  var cden = 0;
  var id_tajuk=0;
  // variabel menampung jumlah 3, 2 , 1
  var tiga=0;
  var dua=0;
  var satu=0;
  //
  var vcr=0;
  var kesimpulan = "sementara";
//--------------------------------------
      $('#hasil_vcr').val(vcr);
      $('#kesimpulan').val(kesimpulan);
//--------------------------------------
  $('#cden').keyup(function() {
    cden=$(this).val();
    ft=100-cden;
    $('#ft').val(ft);

    id_tajuk=2;
      $.get('/user/json-tajuk?id_tajuk=' + id_tajuk , function(data){
       $.each(data, function(index, tajukObj){
         batas_atas_cden=tajukObj.batas_atas;
         batas_bawah_cden=tajukObj.batas_bawah;
         if(cden>=batas_atas_cden){
           $('#hasil_cden').val(3);
           jumlah_nilai[1]=3;
         }
         else if(cden<batas_bawah_cden){
           $('#hasil_cden').val(1);
           jumlah_nilai[1]=1;
         }
         else{
           $('#hasil_cden').val(2);
           jumlah_nilai[1]=2;
         }
         tiga=0;
         dua=0;
         satu=0;
         for(var i = 0; i < 5; i++){
           if(jumlah_nilai[i] == 3){
            tiga+=1;
          }
          else if(jumlah_nilai[i] == 2){
           dua+=1;
         }
         else if(jumlah_nilai[i] == 1){
          satu+=1;
        }
         }
          console.log(satu + " " + dua + " " + tiga);

       });
     });

    id_tajuk=3;
      $.get('/user/json-tajuk?id_tajuk=' + id_tajuk , function(data){
       $.each(data, function(index, tajukObj){
         batas_atas_ft=tajukObj.batas_atas;
         batas_bawah_ft=tajukObj.batas_bawah;
         if(ft>=batas_atas_ft){
           $('#hasil_ft').val(1);
           jumlah_nilai[2]=1;
         }
         else if(ft<batas_bawah_ft){
           $('#hasil_ft').val(3);
           jumlah_nilai[2]=3;
         }
         else{
           $('#hasil_ft').val(2);
           jumlah_nilai[2]=2;
         }
         tiga=0;
         dua=0;
         satu=0;
         for(var i = 0; i < 5; i++){
           if(jumlah_nilai[i] == 3){
            tiga+=1;
          }
          else if(jumlah_nilai[i] == 2){
           dua+=1;
         }
         else if(jumlah_nilai[i] == 1){
          satu+=1;
        }
         }
 console.log(satu + " " + dua + " " + tiga);
 if(tiga==5 || (dua==1 && satu==0 && tiga==4)){
   $('#hasil_vcr').val(4);
   $('#kesimpulan').val("Tinggi");
 }
 else if(satu>0 && satu!=5){
   $('#hasil_vcr').val(2);
   $('#kesimpulan').val("Rendah");
 }
 else if(satu==5){
   $('#hasil_vcr').val(1);
   $('#kesimpulan').val("Sangat Rendah");
 }
 else {
   $('#hasil_vcr').val(3);
   $('#kesimpulan').val("Sedang");
 }
       });
     });

    });

  $('#cdw').keyup(function() {
    cdw= parseFloat($(this).val());
    cd90= parseFloat($('#cd90').val());
    cd=(cdw+cd90)/2;
    $('#cd').val(cd);

    id_tajuk=5;
      $.get('/user/json-tajuk?id_tajuk=' + id_tajuk , function(data){
       $.each(data, function(index, tajukObj){
         batas_atas_cd=tajukObj.batas_atas;
         batas_bawah_cd=tajukObj.batas_bawah;
         if(cd>=batas_atas_cd){
           $('#hasil_cd').val(3);
           jumlah_nilai[4]=3;
         }
         else if(cd<=batas_bawah_cd){
           $('#hasil_cd').val(1);
           jumlah_nilai[4]=1;
         }
         else{
           $('#hasil_cd').val(2);
           jumlah_nilai[4]=2;
         }
         tiga=0;
         dua=0;
         satu=0;
         for(var i = 0; i < 5; i++){
           if(jumlah_nilai[i] == 3){
            tiga+=1;
          }
          else if(jumlah_nilai[i] == 2){
           dua+=1;
         }
         else if(jumlah_nilai[i] == 1){
          satu+=1;
        }
         }
 console.log(satu + " " + dua + " " + tiga);
 if(tiga==5 || (dua==1 && satu==0 && tiga==4)){
   $('#hasil_vcr').val(4);
   $('#kesimpulan').val("Tinggi");
 }
 else if(satu>0 && satu!=5){
   $('#hasil_vcr').val(2);
   $('#kesimpulan').val("Rendah");
 }
 else if(satu==5){
   $('#hasil_vcr').val(1);
   $('#kesimpulan').val("Sangat Rendah");
 }
 else {
   $('#hasil_vcr').val(3);
   $('#kesimpulan').val("Sedang");
 }
       });
     });
    });

  $('#cd90').keyup(function() {
    cd90= parseFloat($(this).val());
    cdw=  parseFloat($('#cdw').val());
    cd=(cd90+cdw)/2;
    $('#cd').val(cd);

    id_tajuk=5;
      $.get('/user/json-tajuk?id_tajuk=' + id_tajuk , function(data){
       $.each(data, function(index, tajukObj){
         batas_atas_cd=tajukObj.batas_atas;
         batas_bawah_cd=tajukObj.batas_bawah;
         if(cd>=batas_atas_cd){
           $('#hasil_cd').val(3);
           jumlah_nilai[4]=3;
         }
         else if(cd<batas_bawah_cd){
           $('#hasil_cd').val(1);
           jumlah_nilai[4]=1;
         }
         else{
           $('#hasil_cd').val(2);
           jumlah_nilai[4]=2;
         }
         tiga=0;
         dua=0;
         satu=0;
         for(var i = 0; i < 5; i++){
           if(jumlah_nilai[i] == 3){
            tiga+=1;
          }
          else if(jumlah_nilai[i] == 2){
           dua+=1;
         }
         else if(jumlah_nilai[i] == 1){
          satu+=1;
        }
         }

         console.log(satu + " " + dua + " " + tiga);
         if(tiga==5 || (dua==1 && satu==0 && tiga==4)){
           $('#hasil_vcr').val(4);
           $('#kesimpulan').val("Tinggi");
         }
         else if(satu>0 && satu!=5){
           $('#hasil_vcr').val(2);
           $('#kesimpulan').val("Rendah");
         }
         else if(satu==5){
           $('#hasil_vcr').val(1);
           $('#kesimpulan').val("Sangat Rendah");
         }
         else {
           $('#hasil_vcr').val(3);
           $('#kesimpulan').val("Sedang");
         }
       });
     });
    });

    // perhitungannya

// nilai lcr
    $('#lcr').keyup(function() {
    lcr= parseInt($(this).val());
    id_tajuk=1;
      $.get('/user/json-tajuk?id_tajuk=' + id_tajuk , function(data){
       $.each(data, function(index, tajukObj){
         batas_atas_lcr=tajukObj.batas_atas;
         batas_bawah_lcr=tajukObj.batas_bawah;
         if(lcr>=batas_atas_lcr){
           $('#hasil_lcr').val(3);
           jumlah_nilai[0]=3;
         }
         else if(lcr<=batas_bawah_lcr){
           $('#hasil_lcr').val(1);
           jumlah_nilai[0]=1;
         }
         else{
           $('#hasil_lcr').val(2);
           jumlah_nilai[0]=2;
         }
         tiga=0;
         dua=0;
         satu=0;
         for(var i = 0; i < 5; i++){
           if(jumlah_nilai[i] == 3){
            tiga+=1;
          }
          else if(jumlah_nilai[i] == 2){
           dua+=1;
         }
         else if(jumlah_nilai[i] == 1){
          satu+=1;
        }
         }
 console.log(satu + " " + dua + " " + tiga);
 if(tiga==5 || (dua==1 && satu==0 && tiga==4)){
   $('#hasil_vcr').val(4);
   $('#kesimpulan').val("Tinggi");
 }
 else if(satu>0 && satu!=5){
   $('#hasil_vcr').val(2);
   $('#kesimpulan').val("Rendah");
 }
 else if(satu==5){
   $('#hasil_vcr').val(1);
   $('#kesimpulan').val("Sangat Rendah");
 }
 else {
   $('#hasil_vcr').val(3);
   $('#kesimpulan').val("Sedang");
 }
       });
     });
    });

        // nilai cdb
            $('#cdb').keyup(function() {
            cdb= parseInt($(this).val());

            id_tajuk=4;
              $.get('/user/json-tajuk?id_tajuk=' + id_tajuk , function(data){
               $.each(data, function(index, tajukObj){
                 batas_atas_cdb=tajukObj.batas_atas;
                 batas_bawah_cdb=tajukObj.batas_bawah;
                 if(cdb>=batas_atas_cdb){
                   $('#hasil_cdb').val(1);
                   jumlah_nilai[3]=1;
                 }
                 else if(cdb<=batas_bawah_cdb){
                   $('#hasil_cdb').val(3);
                   jumlah_nilai[3]=3;
                 }
                 else{
                   $('#hasil_cdb').val(2);
                   jumlah_nilai[3]=2;
                 }
                 tiga=0;
                 dua=0;
                 satu=0;
                 for(var i = 0; i < 5; i++){
                   if(jumlah_nilai[i] == 3){
                    tiga+=1;
                  }
                  else if(jumlah_nilai[i] == 2){
                   dua+=1;
                 }
                 else if(jumlah_nilai[i] == 1){
                  satu+=1;
                }
                 }
 console.log(satu + " " + dua + " " + tiga);
 if(tiga==5 || (dua==1 && satu==0 && tiga==4)){
   $('#hasil_vcr').val(4);
   $('#kesimpulan').val("Tinggi");
 }
 else if(satu>0 && satu!=5){
   $('#hasil_vcr').val(2);
   $('#kesimpulan').val("Rendah");
 }
 else if(satu==5){
   $('#hasil_vcr').val(1);
   $('#kesimpulan').val("Sangat Rendah");
 }
 else {
   $('#hasil_vcr').val(3);
   $('#kesimpulan').val("Sedang");
 }
               });
             });
            });


 });
</script>

   @section('script_table')
   <script>
   $(function () {
     $('#tambah_data_pengukuran_plot').DataTable({
       'paging'      : true,
       'lengthChange': true,
       'searching'   : true,
       'ordering'    : false,
       'info'        : true,
       'autoWidth'   : false
     })
   })
    </script>
   @endsection

  @endsection
