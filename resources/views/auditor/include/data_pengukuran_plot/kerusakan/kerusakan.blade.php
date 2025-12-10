<div class="modal fade" id="modal_tambah_kerusakan">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Kerusakan Pohon</h4>
      </div>
      <div class="modal-body">
        <form role="form" method="post" action="{{route('auditor.tambah_kerusakan')}}"
        onsubmit="document.getElementById('submit_kerusakan').disabled=true;
        document.getElementById('submit_kerusakan').value='Sedang menyimpan...';">
          {{csrf_field()}}
          <div class="box-body">
            <h5>Data Pengukuran :</h5>

            <div class="form-group">
              <div class="col-md-12">
              <label>Kode Kerusakan 1</label>
              </div>
              <div id="input-lokasi1" class="col-md-3">
                <input type="hidden" class="form-control" name="id_pengukuran_r" id="id_pengukuran_r" value="">
                <input type="hidden" class="form-control" name="id_tanaman" id="id_tanaman" value="">
                <input type="text" class="form-control" name="DgL1" id="DgL1" value="" placeholder="DgL1">
              </div>
              <div id="input-tipe1" class="col-md-3">
                <input type="text" class="form-control" name="DgT1" id="DgT1" value="" placeholder="DgT1">
              </div>
              <div id="input-keparahan1" class="col-md-3">
                <input type="text" class="form-control" name="SrVT1" id="SrVT1" value="" placeholder="Svrt1">
              </div>
              <div class="col-md-3">
                <a id="k_add1" class="btn btn-primary fa fa-plus"></a>
              </div>
            </div>


            <div id="K2" class="form-group">
              <div class="col-md-12">
              <label>Kode Kerusakan 2</label>
              </div>
              <div id="input-lokasi2" class="col-md-3">
              <input type="text" class="form-control" name="DgL2" id="DgL2" placeholder="DgL2">
              </div>
              <div id="input-tipe2" class="col-md-3">
              <input type="text" class="form-control" name="DgT2" id="DgT2" placeholder="DgT2">
              </div>
              <div id="input-keparahan2" class="col-md-3">
              <input type="text" class="form-control" name="SrVT2" id="SrVT2" placeholder="Svrt2">
              </div>
              <div class="col-md-3">
              <a id="k_r2" class="btn btn-danger fa fa-minus"></a>
                <a id="k_add2" class="btn btn-primary fa fa-plus"></a>
              </div>
            </div>

            <div id="K3" class="form-group">
              <div class="col-md-12">
              <label>Kode Kerusakan 3</label>
              </div>
              <div id="input-lokasi3" class="col-md-3">
              <input type="text" class="form-control" name="DgL3" id="DgL3" placeholder="DgL3">
              </div>
              <div id="input-tipe3" class="col-md-3">
              <input type="text" class="form-control" name="DgT3" id="DgT3" placeholder="DgT3">
              </div>
              <div id="input-keparahan3" class="col-md-3">
              <input type="text" class="form-control" name="SrVT3" id="SrVT3" placeholder="Svrt3">
              </div>
              <div class="col-md-3">
                <a id="k_r3" class="btn btn-danger fa fa-minus"></a>
              </div>
            </div>

            <div class="row"> </div>
            <div class="hilang" style="display:none;">
            <h5>Perhitungan :</h5>

            <div id="N1" class="form-group">
              <div class="col-md-12">
              <label for="pengukuran_jarak">Nilai Kerusakan 1</label>
              </div>
              <div class="col-md-3">
                <input type="text" class="form-control" name="hDgL1" id="hDgL1" value="" placeholder="DgL1" readonly>
              </div>
              <div class="col-md-3">
                <input type="text" class="form-control" name="hDgT1" id="hDgT1" value="" placeholder="DgT1" readonly>
              </div>
              <div class="col-md-3">
                <input type="text" class="form-control" name="hSrVT1" id="hSrVT1" value="" placeholder="SrVT1" readonly>
              </div>
            </div>


            <div id="N2" class="form-group">
              <div class="col-md-12">
              <label for="pengukuran_keliling">Nilai Kerusakan 2</label>
              </div>
              <div class="col-md-3">
              <input type="text" class="form-control" name="hDgL2" id="hDgL2" placeholder="DgL2" readonly>
              </div>
              <div class="col-md-3">
              <input type="text" class="form-control" name="hDgT2" id="hDgT2" placeholder="DgT2" readonly>
              </div>
              <div class="col-md-3">
              <input type="text" class="form-control" name="hSrVT2" id="hSrVT2" placeholder="SrVT2" readonly>
              </div>
            </div>

            <div id="N3" class="form-group">
              <div class="col-md-12">
              <label for="pengukuran_diameter">Nilai Kerusakan 3</label>
              </div>
              <div class="col-md-3">
              <input type="text" class="form-control" name="hDgL3" id="hDgL3" placeholder="DgL3" readonly>
              </div>
              <div class="col-md-3">
              <input type="text" class="form-control" name="hDgT3" id="hDgT3" placeholder="DgT3" readonly>
              </div>
              <div class="col-md-3">
              <input type="text" class="form-control" name="hSrVT3" id="hSrVT3" placeholder="SrVT3" readonly>
              </div>
            </div>

            <div class="row"> </div>
            <h5>Hasil:</h5>
            <div class="col-md-12">
            <div class="form-group">
              <label for="TLI">TLI</label>
              <input type="text" class="form-control" name="hasil_tli" id="hasil_tli"  placeholder="m2" readonly>
            </div>
            </div>

      </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
        <input type="submit" id="submit_kerusakan" class="btn btn-primary" value="Simpan">
      </div>
          </form>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
</div>


<script type="text/javascript">
$(document).ready(function() {

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

$('#DgL1').val("0");
$('#DgT1').val("0");
$('#SrVT1').val("0");
$('#DgL2').val("0");
$('#DgT2').val("0");
$('#SrVT2').val("0");
$('#DgL3').val("0");
$('#DgT3').val("0");
$('#SrVT3').val("0");

$('#modal_tambah_kerusakan').on('show.bs.modal', function(event){
  var button3 = $(event.relatedTarget);
  var info3 = button3.data('info');
  var info_pengukuran = button3.data('info_pengukuran');
  var modal3 = $(this)
  modal3.find('#id_pengukuran_r').val(info_pengukuran);
  modal3.find('#id_tanaman').val(info3);

  var error_lokasi1=1;
  var error_tipe1=1;
  var error_keparahan1=1;
  var error_lokasi2=1;
  var error_tipe2=1;
  var error_keparahan2=1;
  var error_lokasi3=1;
  var error_tipe3=1;
  var error_keparahan3=1;

  $('#input-lokasi1').on('input', function () {
      DgL1 = $('#DgL1').val();
      var angka = /^([0-9]{1,})$/; //validasi integer
      if (DgL1.match(angka) && DgL1!=null) {
        $('#input-lokasi1').attr("class", "col-md-3 form-group has-success");
        error_lokasi1=1;
      } else {
        $('#input-lokasi1').attr("class", "col-md-3 form-group has-error");
        error_lokasi1=0;
      }
      if(error_lokasi1 + error_tipe1 + error_keparahan1 + error_lokasi2 + error_tipe2 + error_keparahan2 + error_lokasi3 + error_tipe3 + error_keparahan3 == 9){
  		$('#submit_kerusakan').prop("disabled",false);
  		}
  		else {
  		$('#submit_kerusakan').prop("disabled",true);
  		}
    });
  $('#input-tipe1').on('input', function () {
        DgT1 = $('#DgT1').val();
        var angka = /^([0-9]{1,})$/; //validasi integer
        if (DgT1.match(angka) && DgL1!=null) {
          $('#input-tipe1').attr("class", "col-md-3 form-group has-success");
          error_tipe1=1;
        } else {
          $('#input-tipe1').attr("class", "col-md-3 form-group has-error");
          error_tipe1=0;
        }
        if(error_lokasi1 + error_tipe1 + error_keparahan1 + error_lokasi2 + error_tipe2 + error_keparahan2 + error_lokasi3 + error_tipe3 + error_keparahan3 == 9){
    		$('#submit_kerusakan').prop("disabled",false);
    		}
    		else {
    		$('#submit_kerusakan').prop("disabled",true);
    		}
      });
  $('#input-keparahan1').on('input', function () {
          SrVT1 = $('#SrVT1').val();
          var angka = /^([0-9]{1,})$/; //validasi integer
          if (SrVT1.match(angka) && DgL1!=null) {
            $('#input-keparahan1').attr("class", "col-md-3 form-group has-success");
            error_keparahan1=1;
          } else {
            $('#input-keparahan1').attr("class", "col-md-3 form-group has-error");
            error_keparahan1=0;
          }
          if(error_lokasi1 + error_tipe1 + error_keparahan1 + error_lokasi2 + error_tipe2 + error_keparahan2 + error_lokasi3 + error_tipe3 + error_keparahan3 == 9){
      		$('#submit_kerusakan').prop("disabled",false);
      		}
      		else {
      		$('#submit_kerusakan').prop("disabled",true);
      		}
        });
  $('#input-lokasi2').on('input', function () {
            DgL2 = $('#DgL2').val();
            var angka = /^([0-9]{1,})$/; //validasi integer
            if (DgL2.match(angka) && DgL1!=null) {
              $('#input-lokasi2').attr("class", "col-md-3 form-group has-success");
              error_lokasi2=1;
            } else {
              $('#input-lokasi2').attr("class", "col-md-3 form-group has-error");
              error_lokasi2=0;
            }
            if(error_lokasi1 + error_tipe1 + error_keparahan1 + error_lokasi2 + error_tipe2 + error_keparahan2 + error_lokasi3 + error_tipe3 + error_keparahan3 == 9){
        		$('#submit_kerusakan').prop("disabled",false);
        		}
        		else {
        		$('#submit_kerusakan').prop("disabled",true);
        		}
          });
  $('#input-tipe2').on('input', function () {
              DgT2 = $('#DgT2').val();
              var angka = /^([0-9]{1,})$/; //validasi integer
              if (DgT2.match(angka) && DgL1!=null) {
                $('#input-tipe2').attr("class", "col-md-3 form-group has-success");
                error_tipe2=1;
              } else {
                $('#input-tipe2').attr("class", "col-md-3 form-group has-error");
                error_tipe2=0;
              }
              if(error_lokasi1 + error_tipe1 + error_keparahan1 + error_lokasi2 + error_tipe2 + error_keparahan2 + error_lokasi3 + error_tipe3 + error_keparahan3 == 9){
          		$('#submit_kerusakan').prop("disabled",false);
          		}
          		else {
          		$('#submit_kerusakan').prop("disabled",true);
          		}
            });
  $('#input-keparahan2').on('input', function () {
                SrVT2 = $('#SrVT2').val();
                var angka = /^([0-9]{1,})$/; //validasi integer
                if (SrVT2.match(angka) && DgL1!=null) {
                  $('#input-keparahan2').attr("class", "col-md-3 form-group has-success");
                  error_keparahan2=1;
                } else {
                  $('#input-keparahan2').attr("class", "col-md-3 form-group has-error");
                  error_keparahan2=0;
                }
                if(error_lokasi1 + error_tipe1 + error_keparahan1 + error_lokasi2 + error_tipe2 + error_keparahan2 + error_lokasi3 + error_tipe3 + error_keparahan3 == 9){
            		$('#submit_kerusakan').prop("disabled",false);
            		}
            		else {
            		$('#submit_kerusakan').prop("disabled",true);
            		}
              });
  $('#input-lokasi3').on('input', function () {
                        DgL3 = $('#DgL3').val();
                        var angka = /^([0-9]{1,})$/; //validasi integer
                        if (DgL3.match(angka) && DgL1!=null) {
                          $('#input-lokasi3').attr("class", "col-md-3 form-group has-success");
                          error_lokasi3=1;
                        } else {
                          $('#input-lokasi3').attr("class", "col-md-3 form-group has-error");
                          error_lokasi3=0;
                        }
                        if(error_lokasi1 + error_tipe1 + error_keparahan1 + error_lokasi2 + error_tipe2 + error_keparahan2 + error_lokasi3 + error_tipe3 + error_keparahan3 == 9){
                    		$('#submit_kerusakan').prop("disabled",false);
                    		}
                    		else {
                    		$('#submit_kerusakan').prop("disabled",true);
                    		}
                      });
  $('#input-tipe3').on('input', function () {
                          DgT3 = $('#DgT3').val();
                          var angka = /^([0-9]{1,})$/; //validasi integer
                          if (DgT3.match(angka) && DgL1!=null) {
                            $('#input-tipe3').attr("class", "col-md-3 form-group has-success");
                            error_tipe3=1;
                          } else {
                            $('#input-tipe3').attr("class", "col-md-3 form-group has-error");
                            error_tipe3=0;
                          }
                          if(error_lokasi1 + error_tipe1 + error_keparahan1 + error_lokasi2 + error_tipe2 + error_keparahan2 + error_lokasi3 + error_tipe3 + error_keparahan3 == 9){
                      		$('#submit_kerusakan').prop("disabled",false);
                      		}
                      		else {
                      		$('#submit_kerusakan').prop("disabled",true);
                      		}
                        });
  $('#input-keparahan3').on('input', function () {
                            SrVT3 = $('#SrVT3').val();
                            var angka = /^([0-9]{1,})$/; //validasi integer
                            if (SrVT3.match(angka) && DgL1!=null) {
                              $('#input-keparahan3').attr("class", "col-md-3 form-group has-success");
                              error_keparahan3=1;
                            } else {
                              $('#input-keparahan3').attr("class", "col-md-3 form-group has-error");
                              error_keparahan3=0;
                            }
                            if(error_lokasi1 + error_tipe1 + error_keparahan1 + error_lokasi2 + error_tipe2 + error_keparahan2 + error_lokasi3 + error_tipe3 + error_keparahan3 == 9){
                        		$('#submit_kerusakan').prop("disabled",false);
                        		}
                        		else {
                        		$('#submit_kerusakan').prop("disabled",true);
                        		}
                          });
  $.ajax({
      type: 'post',
      url: '{{route("auditor.json_data_kerusakan2")}}',
      data: {
        '_token': $('input[name=_token]').val(),
        'id': info_pengukuran,
        'id2': info3,
      },
      success: function (data) {
        if (data.length > 0) {
          $.each(data, function (key, value) {
            $('#DgL1').val(value['kdDgL1']);
            $('#DgT1').val(value['kdDgT1']);
            $('#SrVT1').val(value['kdSrVT1']);
            $('#DgL2').val(value['kdDgL2']);
            $('#DgT2').val(value['kdDgT2']);
            $('#SrVT2').val(value['kdSrVT2']);
            $('#DgL3').val(value['kdDgL3']);
            $('#DgT3').val(value['kdDgT3']);
            $('#SrVT3').val(value['kdSrVT3']);

            $('#hDgL1').val(value['nDgL1']);
            $('#hDgT1').val(value['nDgT1']);
            $('#hSrVT1').val(value['nSrVT1']);
            $('#hDgL2').val(value['nDgL2']);
            $('#hDgT2').val(value['nDgT2']);
            $('#hSrVT2').val(value['nSrVT2']);
            $('#hDgL3').val(value['nDgL3']);
            $('#hDgT3').val(value['nDgT3']);
            $('#hSrVT3').val(value['nSrVT3']);
            $('#hasil_tli').val(value['tli']);
          });
      }
      else{

      }
    }
    });

});

$('#modal_tambah_kerusakan').on('hidden.bs.modal', function(){
  $('#DgL1').val("0");
  $('#DgT1').val("0");
  $('#SrVT1').val("0");
  $('#DgL2').val("0");
  $('#DgT2').val("0");
  $('#SrVT2').val("0");
  $('#DgL3').val("0");
  $('#DgT3').val("0");
  $('#SrVT3').val("0");

  var error_lokasi1=1;
  var error_tipe1=1;
  var error_keparahan1=1;
  var error_lokasi2=1;
  var error_tipe2=1;
  var error_keparahan2=1;
  var error_lokasi3=1;
  var error_tipe3=1;
  var error_keparahan3=1;

  $("#k_add1").show();
  $("#K2").hide();
  $("#K3").hide();
  $('#submit_kerusakan').prop("disabled",false);
  $('#input-lokasi1').attr("class", "col-md-3 form-group");
  $('#input-tipe1').attr("class", "col-md-3 form-group");
  $('#input-keparahan1').attr("class", "col-md-3 form-group");
  $('#input-lokasi2').attr("class", "col-md-3 form-group");
  $('#input-tipe2').attr("class", "col-md-3 form-group");
  $('#input-keparahan2').attr("class", "col-md-3 form-group");
  $('#input-lokasi3').attr("class", "col-md-3 form-group");
  $('#input-tipe3').attr("class", "col-md-3 form-group");
  $('#input-keparahan3').attr("class", "col-md-3 form-group");

    });



// // perhitungan kerusakan lokasi
// var DgL1=0;
// var nilai_lokasi=0;
// $('#DgL1').keyup(function() {
//          DgL1=$(this).val();
//          if(DgL1==""){
//            DgL1=0;
//          }
//          $.get('/user/json-kerusakan_lokasi?kode=' + DgL1, function(data){
//            if(data.length==0){
//              $('#hDgL1').val("0"); //tambahin validasi error
//            }
//            else{
//            $.each(data, function(index, kerusakanlokasiObj){
//          nilai_lokasi=kerusakanlokasiObj.nilai;
//         $('#hDgL1').val(nilai_lokasi);
//         // perhitungan nilai TLI
//         // rumus = total (kode_kerusakan_lokasi*kode_kerusakan_type*kode_kerusakan_keparahan)
//         $('#hasil_tli').val( $('#hDgL1').val()*$('#hDgT1').val()*$('#hSrVT1').val() +
//                              $('#hDgL2').val()*$('#hDgT2').val()*$('#hSrVT2').val() +
//                              $('#hDgL3').val()*$('#hDgT3').val()*$('#hSrVT3').val() );
//       });
//         }
//     });
//   });
//
//   // perhitungan kerusakan tipe
// var DgT1=0;
// var nilai_tipe=0;
//   $('#DgT1').keyup(function() {
//            DgT1=$(this).val();
//            if(DgT1==""){
//              DgT1=0;
//            }
//            $.get('/user/json-kerusakan_tipe?kode=' + DgT1, function(data){
//              if(data.length==0){
//                $('#hDgT1').val("0"); //tambahin validasi error
//              }
//              else{
//              $.each(data, function(index, kerusakantipeObj){
//            nilai_tipe=kerusakantipeObj.nilai;
//           $('#hDgT1').val(nilai_tipe);
//           // perhitungan nilai TLI
//           // rumus = total (kode_kerusakan_lokasi*kode_kerusakan_type*kode_kerusakan_keparahan)
//           $('#hasil_tli').val( $('#hDgL1').val()*$('#hDgT1').val()*$('#hSrVT1').val() +
//                                $('#hDgL2').val()*$('#hDgT2').val()*$('#hSrVT2').val() +
//                                $('#hDgL3').val()*$('#hDgT3').val()*$('#hSrVT3').val() );
//         });
//       }
//       });
//     });
//
//     // perhitungan kerusakan keparahan
//   var SrVT1=0;
//   var nilai_keparahan=0;
//     $('#SrVT1').keyup(function() {
//              SrVT1=$(this).val();
//              if(SrVT1==""){
//                SrVT1=0;
//              }
//              $.get('/user/json-kerusakan_keparahan?tingkat=' + SrVT1, function(data){
//                if(data.length==0){
//                  $('#hSrVT1').val("0"); //tambahin validasi error
//                }
//                else{
//                $.each(data, function(index, kerusakankeparahanObj){
//              nilai_keparahan=kerusakankeparahanObj.nilai;
//             $('#hSrVT1').val(nilai_keparahan);
//             // perhitungan nilai TLI
//             // rumus = total (kode_kerusakan_lokasi*kode_kerusakan_type*kode_kerusakan_keparahan)
//             $('#hasil_tli').val( $('#hDgL1').val()*$('#hDgT1').val()*$('#hSrVT1').val() +
//                                  $('#hDgL2').val()*$('#hDgT2').val()*$('#hSrVT2').val() +
//                                  $('#hDgL3').val()*$('#hDgT3').val()*$('#hSrVT3').val() );
//           });
//         }
//         });
//       });
//
//
//       // perhitungan kerusakan lokasi 2
//     var DgL2=0;
//     var nilai_lokasi=0;
//       $('#DgL2').keyup(function() {
//                DgL2=$(this).val();
//                if(DgL2==""){
//                  DgL2=0;
//                }
//                $.get('/user/json-kerusakan_lokasi?kode=' + DgL2, function(data){
//                  if(data.length==0){
//                    $('#hDgL2').val("0"); //tambahin validasi error
//                  }
//                  else{
//                  $.each(data, function(index, kerusakanlokasiObj){
//                nilai_lokasi=kerusakanlokasiObj.nilai;
//               $('#hDgL2').val(nilai_lokasi);
//               // perhitungan nilai TLI
//               // rumus = total (kode_kerusakan_lokasi*kode_kerusakan_type*kode_kerusakan_keparahan)
//               $('#hasil_tli').val( $('#hDgL1').val()*$('#hDgT1').val()*$('#hSrVT1').val() +
//                                    $('#hDgL2').val()*$('#hDgT2').val()*$('#hSrVT2').val() +
//                                    $('#hDgL3').val()*$('#hDgT3').val()*$('#hSrVT3').val() );
//             });
//               }
//           });
//         });
//
//         // perhitungan kerusakan tipe 2
//       var DgT2=0;
//       var nilai_tipe=0;
//         $('#DgT2').keyup(function() {
//                  DgT2=$(this).val();
//                  if(DgT2==""){
//                    DgT2=0;
//                  }
//                  $.get('/user/json-kerusakan_tipe?kode=' + DgT2, function(data){
//                    if(data.length==0){
//                      $('#hDgT2').val("0"); //tambahin validasi error
//                    }
//                    else{
//                    $.each(data, function(index, kerusakantipeObj){
//                  nilai_tipe=kerusakantipeObj.nilai;
//                 $('#hDgT2').val(nilai_tipe);
//                 // perhitungan nilai TLI
//                 // rumus = total (kode_kerusakan_lokasi*kode_kerusakan_type*kode_kerusakan_keparahan)
//                 $('#hasil_tli').val( $('#hDgL1').val()*$('#hDgT1').val()*$('#hSrVT1').val() +
//                                      $('#hDgL2').val()*$('#hDgT2').val()*$('#hSrVT2').val() +
//                                      $('#hDgL3').val()*$('#hDgT3').val()*$('#hSrVT3').val() );
//               });
//             }
//             });
//           });
//
//           // perhitungan kerusakan keparahan 2
//         var SrVT2=0;
//         var nilai_keparahan=0;
//           $('#SrVT2').keyup(function() {
//                    SrVT2=$(this).val();
//                    if(SrVT2==""){
//                      SrVT2=0;
//                    }
//                    $.get('/user/json-kerusakan_keparahan?tingkat=' + SrVT2, function(data){
//                      if(data.length==0){
//                        $('#hSrVT2').val("0"); //tambahin validasi error
//                      }
//                      else{
//                      $.each(data, function(index, kerusakankeparahanObj){
//                    nilai_keparahan=kerusakankeparahanObj.nilai;
//                   $('#hSrVT2').val(nilai_keparahan);
//                   // perhitungan nilai TLI
//                   // rumus = total (kode_kerusakan_lokasi*kode_kerusakan_type*kode_kerusakan_keparahan)
//                   $('#hasil_tli').val( $('#hDgL1').val()*$('#hDgT1').val()*$('#hSrVT1').val() +
//                                        $('#hDgL2').val()*$('#hDgT2').val()*$('#hSrVT2').val() +
//                                        $('#hDgL3').val()*$('#hDgT3').val()*$('#hSrVT3').val() );
//                 });
//               }
//               });
//             });
//
//             // perhitungan kerusakan lokasi 3
//           var DgL3=0;
//           var nilai_lokasi=0;
//             $('#DgL3').keyup(function() {
//                      DgL3=$(this).val();
//                      if(DgL3==""){
//                        DgL3=0;
//                      }
//                      $.get('/user/json-kerusakan_lokasi?kode=' + DgL3, function(data){
//                        if(data.length==0){
//                          $('#hDgL3').val("0"); //tambahin validasi error
//                        }
//                        else{
//                        $.each(data, function(index, kerusakanlokasiObj){
//                      nilai_lokasi=kerusakanlokasiObj.nilai;
//                     $('#hDgL3').val(nilai_lokasi);
//                     // perhitungan nilai TLI
//                     // rumus = total (kode_kerusakan_lokasi*kode_kerusakan_type*kode_kerusakan_keparahan)
//                     $('#hasil_tli').val( $('#hDgL1').val()*$('#hDgT1').val()*$('#hSrVT1').val() +
//                                          $('#hDgL2').val()*$('#hDgT2').val()*$('#hSrVT2').val() +
//                                          $('#hDgL3').val()*$('#hDgT3').val()*$('#hSrVT3').val() );
//                   });
//                     }
//                 });
//               });
//
//               // perhitungan kerusakan tipe 3
//             var DgT3=0;
//             var nilai_tipe=0;
//               $('#DgT3').keyup(function() {
//                        DgT3=$(this).val();
//                        if(DgT3==""){
//                          DgT3=0;
//                        }
//                        $.get('/user/json-kerusakan_tipe?kode=' + DgT3, function(data){
//                          if(data.length==0){
//                            $('#hDgT3').val("0"); //tambahin validasi error
//                          }
//                          else{
//                          $.each(data, function(index, kerusakantipeObj){
//                        nilai_tipe=kerusakantipeObj.nilai;
//                       $('#hDgT3').val(nilai_tipe);
//                       // perhitungan nilai TLI
//                       // rumus = total (kode_kerusakan_lokasi*kode_kerusakan_type*kode_kerusakan_keparahan)
//                       $('#hasil_tli').val( $('#hDgL1').val()*$('#hDgT1').val()*$('#hSrVT1').val() +
//                                            $('#hDgL2').val()*$('#hDgT2').val()*$('#hSrVT2').val() +
//                                            $('#hDgL3').val()*$('#hDgT3').val()*$('#hSrVT3').val() );
//                     });
//                   }
//                   });
//                 });
//
//                 // perhitungan kerusakan keparahan 3
//               var SrVT3=0;
//               var nilai_keparahan=0;
//                 $('#SrVT3').keyup(function() {
//                          SrVT3=$(this).val();
//                          if(SrVT3==""){
//                            SrVT3=0;
//                          }
//                          $.get('/user/json-kerusakan_keparahan?tingkat=' + SrVT3, function(data){
//                            if(data.length==0){
//                              $('#hSrVT3').val("0"); //tambahin validasi error
//                            }
//                            else{
//                            $.each(data, function(index, kerusakankeparahanObj){
//                          nilai_keparahan=kerusakankeparahanObj.nilai;
//                         $('#hSrVT3').val(nilai_keparahan);
//                         // perhitungan nilai TLI
//                         // rumus = total (kode_kerusakan_lokasi*kode_kerusakan_type*kode_kerusakan_keparahan)
//                         $('#hasil_tli').val( $('#hDgL1').val()*$('#hDgT1').val()*$('#hSrVT1').val() +
//                                              $('#hDgL2').val()*$('#hDgT2').val()*$('#hSrVT2').val() +
//                                              $('#hDgL3').val()*$('#hDgT3').val()*$('#hSrVT3').val() );
//                       });
//                     }
//                     });
//                   });
                });
</script>
