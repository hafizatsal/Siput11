<div class="modal fade" id="modal_tambah_tajuk">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Kondisi Tajuk</h4>
      </div>
      <div class="modal-body">
        <form role="form" method="post" action="{{route('user.tambah_tajuk')}}"
        onsubmit="document.getElementById('submit_tajuk').disabled=true;
        document.getElementById('submit_tajuk').value='Sedang menyimpan...';">
          {{csrf_field()}}
          <div class="box-body">
            <h5>Data Pengukuran :</h5>
            <div class="col-md-6">
            <div id="input-lcr" class="form-group">
              <label for="lcr">Live Crown Ratio * (%) </label>
              <input type="hidden" class="form-control" name="id_pengukuran_t" id="id_pengukuran_t" value="">
              <input type="hidden" class="form-control" name="id_tanaman2" id="id_tanaman2" value="">
              <input type="text" class="form-control" name="lcr" id="lcr" value="" placeholder="%">
            </div>
          </div>

          <div class="col-md-6">

          <div id="input-cden" class="form-group">
            <label for="cden">Crown Density * (%) </label>
            <input type="text" class="form-control" name="cden" id="cden" value="" placeholder="%">
          </div>
        </div>
  <div class="col-md-6">
    <div class="form-group">
      <label for="ft">Foliage Transparancy (%) </label>
      <input type="text" class="form-control" name="ft" id="ft" placeholder="%" readonly>
    </div>
  </div>

  <div class="col-md-6">
    <div id="input-dieback" class="form-group">
      <label for="cdb">Dieback * (m) </label>
      <input type="text" class="form-control" name="cdb" id="cdb" placeholder="%">
    </div>
  </div>

  <div class="col-md-6">
    <div id="input-cdw" class="form-group">
      <label for="cdw">Crown Diameter Width * (m)</label>
      <input type="text" class="form-control" name="cdw" id="cdw" placeholder="m">
    </div>
  </div>

  <div class="col-md-6">
    <div id="input-cd90" class="form-group">
      <label for="cd90">Crown Diameter at 90 * (m)</label>
      <input type="text" class="form-control" name="cd90" id="cd90" placeholder="m">
    </div>
  </div>

  <div class="col-md-12">
    <div class="form-group">
      <label for="cd">Crown Diameter (m)</label>
      <input type="text" class="form-control" name="cd" id="cd" placeholder="m" readonly>
    </div>
  </div>

          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
          <input type="submit" id="submit_tajuk" class="btn btn-primary" value="Simpan">
        </div>
            </form>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
  <!-- /.modal -->

<script type="text/javascript">
$(document).ready(function() {
  // variabel untuk menampung jumlah nilai 3, 2, dan 1
  var jumlah_nilai=[0,0,0,0,0];
  //

  $('#modal_tambah_tajuk').on('show.bs.modal', function(event){
    $('#lcr').val(0);
    $('#cden').val(0);
    $('#ft').val(100);
    $('#cdb').val(0);
    $('#cdw').val(0);
    $('#cd90').val(0);
    $('#cd').val(0);
  var button = $(event.relatedTarget);
  var info = button.data('info');
  var info_pengukuran = button.data('info_pengukuran');
  var modal = $(this)
  modal.find('#id_pengukuran_t').val(info_pengukuran);
  modal.find('#id_tanaman2').val(info);

  var error_lcr=1;
  var error_cden=1;
  var error_dieback=1;
  var error_cdw=1;
  var error_cd90=1;

  $('#lcr').on('input', function () {
      lcr = $('#lcr').val();
      var angka = /^([0-9]{1,}(\.[0-9]{1,}){0,1})$/; //validasi angka
      if (lcr.match(angka) && lcr!=null) {
        $('#input-lcr').attr("class", "form-group has-success");
        error_lcr=1;
      } else {
        $('#input-lcr').attr("class", "form-group has-error");
        error_lcr=0;
      }
      if(error_lcr + error_cden + error_dieback + error_cdw + error_cd90 == 5){
  		$('#submit_tajuk').prop("disabled",false);
  		}
  		else {
  		$('#submit_tajuk').prop("disabled",true);
  		}

    });

    $('#cden').on('input', function () {
        cden = $('#cden').val();
        var angka = /^([0-9]{1,}(\.[0-9]{1,}){0,1})$/; //validasi angka
        if (cden.match(angka) && cden!=null) {
          $('#input-cden').attr("class", "form-group has-success");
          error_cden=1;
        } else {
          $('#input-cden').attr("class", "form-group has-error");
          error_cden=0;
        }
        if(error_lcr + error_cden + error_dieback + error_cdw + error_cd90 == 5){
    		$('#submit_tajuk').prop("disabled",false);
    		}
    		else {
    		$('#submit_tajuk').prop("disabled",true);
    		}

      });

      $('#cdb').on('input', function () {
          dieback = $('#cdb').val();
          var angka = /^([0-9]{1,}(\.[0-9]{1,}){0,1})$/; //validasi angka
          if (dieback.match(angka) && dieback!=null) {
            $('#input-dieback').attr("class", "form-group has-success");
            error_dieback=1;
          } else {
            $('#input-dieback').attr("class", "form-group has-error");
            error_dieback=0;
          }
          if(error_lcr + error_cden + error_dieback + error_cdw + error_cd90 == 5){
      		$('#submit_tajuk').prop("disabled",false);
      		}
      		else {
      		$('#submit_tajuk').prop("disabled",true);
      		}

        });

        $('#cdw').on('input', function () {
            cdw = $('#cdw').val();
            var angka = /^([0-9]{1,}(\.[0-9]{1,}){0,1})$/; //validasi angka
            if (cdw.match(angka) && cdw!=null) {
              $('#input-cdw').attr("class", "form-group has-success");
              error_cdw=1;
            } else {
              $('#input-cdw').attr("class", "form-group has-error");
              error_cdw=0;
            }
            if(error_lcr + error_cden + error_dieback + error_cdw + error_cd90 == 5){
        		$('#submit_tajuk').prop("disabled",false);
        		}
        		else {
        		$('#submit_tajuk').prop("disabled",true);
        		}

          });

          $('#cd90').on('input', function () {
              cd90 = $('#cd90').val();
              var angka = /^([0-9]{1,}(\.[0-9]{1,}){0,1})$/; //validasi angka
              if (cd90.match(angka) && cd90!=null) {
                $('#input-cd90').attr("class", "form-group has-success");
                error_cd90=1;
              } else {
                $('#input-cd90').attr("class", "form-group has-error");
                error_cd90=0;
              }
              if(error_lcr + error_cden + error_dieback + error_cdw + error_cd90 == 5){
          		$('#submit_tajuk').prop("disabled",false);
          		}
          		else {
          		$('#submit_tajuk').prop("disabled",true);
          		}

            });

  $.ajax({
      type: 'post',
      url: '{{route("user.json_data_kondisi_tajuk2")}}',
      data: {
        '_token': $('input[name=_token]').val(),
        'id': info_pengukuran,
        'id2': info,
      },
      success: function (data) {
        if (data.length > 0) {
          $.each(data, function (key, value) {
            $('#lcr').val(value['lcr']);
            $('#cden').val(value['cden']);
            $('#ft').val(value['ft']);
            $('#cdb').val(value['cdb']);
            $('#cdw').val(value['cdw']);
            $('#cd90').val(value['cd90']);
            $('#cd').val(value['cd']);

            $('#hasil_lcr').val(value['nlcr']);
            if(value['nlcr']==3){
              jumlah_nilai[0]=3;
            }
            else if(value['nlcr']==2){
              jumlah_nilai[0]=2;
            }
            else if(value['nlcr']==1){
              jumlah_nilai[0]=1;
            }

            $('#hasil_cden').val(value['ncden']);
            if(value['ncden']==3){
              jumlah_nilai[1]=3;
            }
            else if(value['ncden']==2){
              jumlah_nilai[1]=2;
            }
            else if(value['ncden']==1){
              jumlah_nilai[1]=1;
            }

            $('#hasil_ft').val(value['nft']);
            if(value['nft']==3){
              jumlah_nilai[2]=3;
            }
            else if(value['nft']==2){
              jumlah_nilai[2]=2;
            }
            else if(value['nft']==1){
              jumlah_nilai[2]=1;
            }

            $('#hasil_cdb').val(value['ncdb']);
            if(value['ncdb']==3){
              jumlah_nilai[3]=3;
            }
            else if(value['ncdb']==2){
              jumlah_nilai[3]=2;
            }
            else if(value['ncdb']==1){
              jumlah_nilai[3]=1;
            }

            $('#hasil_cd').val(value['ncd']);
            if(value['ncd']==3){
              jumlah_nilai[4]=3;
            }
            else if(value['ncd']==2){
              jumlah_nilai[4]=2;
            }
            else if(value['ncd']==1){
              jumlah_nilai[4]=1;
            }

            $('#hasil_vcr').val(value['vcri']);
            $('#kesimpulan').val(value['kesimpulan']);

          });
      }
      else{

      }
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

    $('#submit_tajuk').prop("disabled",false);
    $('#input-lcr').attr("class", "form-group");
    $('#input-cden').attr("class", "form-group");
    $('#input-dieback').attr("class", "form-group");
    $('#input-cdw').attr("class", "form-group");
    $('#input-cd90').attr("class", "form-group");

    var error_lcr=1;
    var error_cden=1;
    var error_dieback=1;
    var error_cdw=1;
    var error_cd90=1;


    // $('#hasil_lcr').val("");
    // $('#hasil_cden').val("");
    // $('#hasil_ft').val("");
    // $('#hasil_cdb').val("");
    // $('#hasil_cd').val("");
    // $('#hasil_vcr').val("");
    // $('#kesimpulan').val("");
      });



  // // perhitungan kondisi Tajuk
  // var cden=0;
  // var ft = 0;
  // var cd = 0;
  // var cdw = 0;
  // var cd90 = 0;
  // var lcr = 0;
  // var cden = 0;
  // var id_tajuk=0;
  // // variabel menampung jumlah 3, 2 , 1
  // var tiga=0;
  // var dua=0;
  // var satu=0;
  // //
  // var vcr=0;
  // var kesimpulan = "Sangat Rendah";
  //--------------------------------------
      // $('#hasil_vcr').val(vcr);
      // $('#kesimpulan').val(kesimpulan);
  //--------------------------------------
  $('#cden').keyup(function() {
    cden=parseFloat($(this).val());
    ft=100-cden;
    $('#ft').val(ft);

    // id_tajuk=2;
     //  $.get('/user/json-tajuk?id_tajuk=' + id_tajuk , function(data){
     //   $.each(data, function(index, tajukObj){
     //     batas_atas_cden=tajukObj.batas_atas;
     //     batas_bawah_cden=tajukObj.batas_bawah;
     //     if(cden>=batas_atas_cden){
     //       $('#hasil_cden').val(3);
     //       jumlah_nilai[1]=3;
     //     }
     //     else if(cden<batas_bawah_cden){
     //       $('#hasil_cden').val(1);
     //       jumlah_nilai[1]=1;
     //     }
     //     else{
     //       $('#hasil_cden').val(2);
     //       jumlah_nilai[1]=2;
     //     }
     //     tiga=0;
     //     dua=0;
     //     satu=0;
     //     for(var i = 0; i < 5; i++){
     //       if(jumlah_nilai[i] == 3){
     //        tiga+=1;
     //      }
     //      else if(jumlah_nilai[i] == 2){
     //       dua+=1;
     //     }
     //     else if(jumlah_nilai[i] == 1){
     //      satu+=1;
     //    }
     //     }
     //
     //   });
     // });

  //   id_tajuk=3;
  //     $.get('/user/json-tajuk?id_tajuk=' + id_tajuk , function(data){
  //      $.each(data, function(index, tajukObj){
  //        batas_atas_ft=tajukObj.batas_atas;
  //        batas_bawah_ft=tajukObj.batas_bawah;
  //        if(ft>=batas_atas_ft){
  //          $('#hasil_ft').val(1);
  //          jumlah_nilai[2]=1;
  //        }
  //        else if(ft<batas_bawah_ft){
  //          $('#hasil_ft').val(3);
  //          jumlah_nilai[2]=3;
  //        }
  //        else{
  //          $('#hasil_ft').val(2);
  //          jumlah_nilai[2]=2;
  //        }
  //        tiga=0;
  //        dua=0;
  //        satu=0;
  //        for(var i = 0; i < 5; i++){
  //          if(jumlah_nilai[i] == 3){
  //           tiga+=1;
  //         }
  //         else if(jumlah_nilai[i] == 2){
  //          dua+=1;
  //        }
  //        else if(jumlah_nilai[i] == 1){
  //         satu+=1;
  //       }
  //        }
  //
  // if(tiga==5 || (dua==1 && satu==0 && tiga==4)){
  //  $('#hasil_vcr').val(4);
  //  $('#kesimpulan').val("Tinggi");
  // }
  // else if(satu>0 && satu!=5){
  //  $('#hasil_vcr').val(2);
  //  $('#kesimpulan').val("Rendah");
  // }
  // else if(satu==5){
  //  $('#hasil_vcr').val(1);
  //  $('#kesimpulan').val("Sangat Rendah");
  // }
  // else {
  //  $('#hasil_vcr').val(3);
  //  $('#kesimpulan').val("Sedang");
  // }
  //      });
  //    });

    });

  $('#cdw').keyup(function() {
    cdw= parseFloat($(this).val());
    cd90= parseFloat($('#cd90').val());
    cd=(cdw+cd90)/2;
    $('#cd').val(cd);

  //   id_tajuk=5;
  //     $.get('/user/json-tajuk?id_tajuk=' + id_tajuk , function(data){
  //      $.each(data, function(index, tajukObj){
  //        batas_atas_cd=tajukObj.batas_atas;
  //        batas_bawah_cd=tajukObj.batas_bawah;
  //        if(cd>=batas_atas_cd){
  //          $('#hasil_cd').val(3);
  //          jumlah_nilai[4]=3;
  //        }
  //        else if(cd<=batas_bawah_cd){
  //          $('#hasil_cd').val(1);
  //          jumlah_nilai[4]=1;
  //        }
  //        else{
  //          $('#hasil_cd').val(2);
  //          jumlah_nilai[4]=2;
  //        }
  //        tiga=0;
  //        dua=0;
  //        satu=0;
  //        for(var i = 0; i < 5; i++){
  //          if(jumlah_nilai[i] == 3){
  //           tiga+=1;
  //         }
  //         else if(jumlah_nilai[i] == 2){
  //          dua+=1;
  //        }
  //        else if(jumlah_nilai[i] == 1){
  //         satu+=1;
  //       }
  //        }
  //
  // if(tiga==5 || (dua==1 && satu==0 && tiga==4)){
  //  $('#hasil_vcr').val(4);
  //  $('#kesimpulan').val("Tinggi");
  // }
  // else if(satu>0 && satu!=5){
  //  $('#hasil_vcr').val(2);
  //  $('#kesimpulan').val("Rendah");
  // }
  // else if(satu==5){
  //  $('#hasil_vcr').val(1);
  //  $('#kesimpulan').val("Sangat Rendah");
  // }
  // else {
  //  $('#hasil_vcr').val(3);
  //  $('#kesimpulan').val("Sedang");
  // }
  //      });
  //    });
    });

  $('#cd90').keyup(function() {
    cd90= parseFloat($(this).val());
    cdw=  parseFloat($('#cdw').val());
    cd=(cd90+cdw)/2;
    $('#cd').val(cd);

    // id_tajuk=5;
    //   $.get('/user/json-tajuk?id_tajuk=' + id_tajuk , function(data){
    //    $.each(data, function(index, tajukObj){
    //      batas_atas_cd=tajukObj.batas_atas;
    //      batas_bawah_cd=tajukObj.batas_bawah;
    //      if(cd>=batas_atas_cd){
    //        $('#hasil_cd').val(3);
    //        jumlah_nilai[4]=3;
    //      }
    //      else if(cd<batas_bawah_cd){
    //        $('#hasil_cd').val(1);
    //        jumlah_nilai[4]=1;
    //      }
    //      else{
    //        $('#hasil_cd').val(2);
    //        jumlah_nilai[4]=2;
    //      }
    //      tiga=0;
    //      dua=0;
    //      satu=0;
    //      for(var i = 0; i < 5; i++){
    //        if(jumlah_nilai[i] == 3){
    //         tiga+=1;
    //       }
    //       else if(jumlah_nilai[i] == 2){
    //        dua+=1;
    //      }
    //      else if(jumlah_nilai[i] == 1){
    //       satu+=1;
    //     }
    //      }
    //
    //      if(tiga==5 || (dua==1 && satu==0 && tiga==4)){
    //        $('#hasil_vcr').val(4);
    //        $('#kesimpulan').val("Tinggi");
    //      }
    //      else if(satu>0 && satu!=5){
    //        $('#hasil_vcr').val(2);
    //        $('#kesimpulan').val("Rendah");
    //      }
    //      else if(satu==5){
    //        $('#hasil_vcr').val(1);
    //        $('#kesimpulan').val("Sangat Rendah");
    //      }
    //      else {
    //        $('#hasil_vcr').val(3);
    //        $('#kesimpulan').val("Sedang");
    //      }
    //    });
    //  });
    });

    // perhitungannya

  // nilai lcr
  //   $('#lcr').keyup(function() {
  //   lcr= parseInt($(this).val());
  //   id_tajuk=1;
  //     $.get('/user/json-tajuk?id_tajuk=' + id_tajuk , function(data){
  //      $.each(data, function(index, tajukObj){
  //        batas_atas_lcr=tajukObj.batas_atas;
  //        batas_bawah_lcr=tajukObj.batas_bawah;
  //        if(lcr>=batas_atas_lcr){
  //          $('#hasil_lcr').val(3);
  //          jumlah_nilai[0]=3;
  //        }
  //        else if(lcr<batas_bawah_lcr){
  //          $('#hasil_lcr').val(1);
  //          jumlah_nilai[0]=1;
  //        }
  //        else{
  //          $('#hasil_lcr').val(2);
  //          jumlah_nilai[0]=2;
  //        }
  //        tiga=0;
  //        dua=0;
  //        satu=0;
  //        for(var i = 0; i < 5; i++){
  //          if(jumlah_nilai[i] == 3){
  //           tiga+=1;
  //         }
  //         else if(jumlah_nilai[i] == 2){
  //          dua+=1;
  //        }
  //        else if(jumlah_nilai[i] == 1){
  //         satu+=1;
  //       }
  //        }
  //
  // if(tiga==5 || (dua==1 && satu==0 && tiga==4)){
  //  $('#hasil_vcr').val(4);
  //  $('#kesimpulan').val("Tinggi");
  // }
  // else if(satu>0 && satu!=5){
  //  $('#hasil_vcr').val(2);
  //  $('#kesimpulan').val("Rendah");
  // }
  // else if(satu==5){
  //  $('#hasil_vcr').val(1);
  //  $('#kesimpulan').val("Sangat Rendah");
  // }
  // else {
  //  $('#hasil_vcr').val(3);
  //  $('#kesimpulan').val("Sedang");
  // }
  //      });
  //    });
  //   });

        // nilai cdb
  //           $('#cdb').keyup(function() {
  //           cdb= parseInt($(this).val());
  //
  //           id_tajuk=4;
  //             $.get('/user/json-tajuk?id_tajuk=' + id_tajuk , function(data){
  //              $.each(data, function(index, tajukObj){
  //                batas_atas_cdb=tajukObj.batas_atas;
  //                batas_bawah_cdb=tajukObj.batas_bawah;
  //                if(cdb>=batas_atas_cdb){
  //                  $('#hasil_cdb').val(1);
  //                  jumlah_nilai[3]=1;
  //                }
  //                else if(cdb<=batas_bawah_cdb){
  //                  $('#hasil_cdb').val(3);
  //                  jumlah_nilai[3]=3;
  //                }
  //                else{
  //                  $('#hasil_cdb').val(2);
  //                  jumlah_nilai[3]=2;
  //                }
  //                tiga=0;
  //                dua=0;
  //                satu=0;
  //                for(var i = 0; i < 5; i++){
  //                  if(jumlah_nilai[i] == 3){
  //                   tiga+=1;
  //                 }
  //                 else if(jumlah_nilai[i] == 2){
  //                  dua+=1;
  //                }
  //                else if(jumlah_nilai[i] == 1){
  //                 satu+=1;
  //               }
  //                }
  //
  // if(tiga==5 || (dua==1 && satu==0 && tiga==4)){
  //  $('#hasil_vcr').val(4);
  //  $('#kesimpulan').val("Tinggi");
  // }
  // else if(satu>0 && satu!=5){
  //  $('#hasil_vcr').val(2);
  //  $('#kesimpulan').val("Rendah");
  // }
  // else if(satu==5){
  //  $('#hasil_vcr').val(1);
  //  $('#kesimpulan').val("Sangat Rendah");
  // }
  // else {
  //  $('#hasil_vcr').val(3);
  //  $('#kesimpulan').val("Sedang");
  // }
  //              });
  //            });
  //           });
  });
</script>
