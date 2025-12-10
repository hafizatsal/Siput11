<div class="modal fade" id="tambah">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">Tambah Data Pengukuran</h4>
        </div>
        <div class="modal-body">

            <div class="col-md-12">
              <!-- Custom Tabs -->
              <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                  <li class="active"><a href="#tab_1" data-toggle="tab">Data Hutan</a></li>
                  <li><a href="#tab_2" data-toggle="tab">Data Klaster</a></li>
                </ul>
                <div class="tab-content">
                  <div class="tab-pane active" id="tab_1">

                    <form id="formsatu" method="post" class="form-horizontal" action="data_pengukuran/insert">
                      {{csrf_field()}}
                      <div class="col-md-12">
                        <div class="form-group">
                            <label class="control-label">Id Klaster</label>
                              <input type="text" class="form-control" name="id_klaster_plot" id="id_klaster_plot" value="" >
                        </div>
                      </div>

                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="kepemilikan">Kepemilikan</label>
                          <select class="form-control" name="kepemilikan" id="kepemilikan">
                            <option value="" disable="true" selected="true">=== Kepemilikan === </option>
                            @foreach ($kepemilikan as $key => $value)
                              <option value="{{$value->id_hak_milik}}">{{$value->hak_milik}}</option>
                            @endforeach
                          </select>
                        </div>

  <div class="form-group">
                          <label for="jenis">Jenis Hutan</label>
                          <select class="form-control" name="jenis" id="jenis">
                            <option value="" disable="true" selected="true">=== Silahkan Pilih === </option>
                            @foreach ($jenis as $key => $value)
                              <option value="{{$value->id_jenis_hutan}}">{{$value->nama}}</option>
                            @endforeach
                          </select>

                          <label for="fungsi">Fungsi Hutan</label>
                          <select class="form-control" name="fungsi" id="fungsi">
                            <option value="" disable="true" selected="true">=== Silahkan Pilih === </option>
                          </select>

                          <label for="pengelola">Nama Pengelola</label>
                          <input type="text" class="form-control" name="pengelola" id="pengelola" placeholder="Pengelola">

                          <label for="ket_pengelola">Keterangan Pengelola</label>
                          <select class="form-control" name="ket_pengelola" id="ket_pengelola">
                            <option value="" disable="true" selected="true">Silahkan Pilih</option>
                            @foreach ($jenis_pengelola as $key => $value)
                              <option value="{{$value->id_jenis_pengelola}}">{{$value->jenis_pengelola}}</option>
                            @endforeach
                          </select>
                        </div>

                      </div> <!--  untuk div col-md-12-->
                      <div class="col-md-1">
                      </div>
                      <div class="col-md-5">
                        <div class="form-group">
                          <label for="provinsi">Provinsi</label>
                          <select class="form-control" name="provinsi" id="provinsi">
                            <option value="" disable="true" selected="true">=== Silahkan Pilih === </option>
                            @foreach ($provinsi as $key => $value)
                              <option value="{{$value->id_provinsi}}">{{$value->nama_provinsi}}</option>
                            @endforeach
                          </select>

                          <label for="kabupaten">Kabupaten</label>
                          <select class="form-control" name="kabupaten" id="kabupaten">
                            <option value="" disable="true" selected="true">=== Silahkan Pilih === </option>
                          </select>

                          <label for="kecamatan">Kecamatan</label>
                          <select class="form-control" name="kecamatan" id="kecamatan">
                            <option value="" disable="true" selected="true">=== Silahkan Pilih === </option>
                          </select>

                          <label for="desa">Desa</label>
                          <select class="form-control" name="desa" id="desa">
                            <option value="" disable="true" selected="true">=== Silahkan Pilih === </option>
                          </select>

                          <label for="pola_tanam">Pola Tanam</label>
                          <select class="form-control" name="pola_tanam" id="pola_tanam">
                            <option value="" disable="true" selected="true">=== Silahkan Pilih ===</option>
                            @foreach ($pola as $key => $value)
                              <option value="{{$value->id_pola_tanam}}">{{$value->nama_pola}}</option>
                            @endforeach
                          </select>
                        </div>

                      </div> <!--  untuk div col-md-12-->


                        <div class="form-group">
                            <div class="col-md-9 col-md-offset-3">
                                <div id="messages"></div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-9 col-md-offset-3">
                                <button type="submit" class="btn btn-default pull-right">Validate</button>
                            </div>
                        </div>



                  </div>
                  <!-- /.tab-pane -->
                  <div class="tab-pane" id="tab_2">

                    <div class="col-md-12">
                      <div class="form-group">
                          <label class="control-label">Id Klaster</label>
                          <input type="text" name="luas" id="luas" class="form-control" placeholder="Hektar">
                      </div>
                    </div>

                  </div>

                  <!-- /.tab-pane -->

                </div>
                <!-- /.tab-content -->
              </div>
              <!-- nav-tabs-custom -->
            </div>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
          <input type="submit" name="submit" id="submitData" name="submitData" value="Simpan" class="btn btn-primary">
          </form>
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
  <!-- /.modal -->


<script src="{{asset('Admin/modal_ajax.min.js')}}"></script>

<script src="http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script src="http://cdnjs.cloudflare.com/ajax/libs/bootstrap-validator/0.4.5/js/bootstrapvalidator.min.js"></script>

  <script type="text/javascript">

      $('#validateForm').bootstrapValidator({
        // excluded: [':disabled'],
        container: '#messages',
      feedbackIcons: {
          valid: 'glyphicon glyphicon-ok',
          invalid: 'glyphicon glyphicon-remove',
          validating: 'glyphicon glyphicon-refresh'
      },

      fields: {
        pengelola: {
            validators: {
              stringLength: {
                min: 2,
                message: 'Nama minimal 2 huruf!'
              },
              notEmpty: {
                message: 'Nama masih kosong'
              }
            }
        },
      //
      //   id_klaster_plot: {
      //       validators: {
      //         numeric: {
      //           message: 'id klaster berupa angka'
      //         },
      //         notEmpty: {
      //           message: 'masukkan id klaster'
      //         }
      //       }
      //   },
      //
      //   kepemilikan: {
      //       validators: {
      //         notEmpty: {
      //           message: 'Tidak boleh kosong'
      //         }
      //       }
      //   },
      //
      //   jenis: {
      //       validators: {
      //         notEmpty: {
      //           message: 'Tidak boleh kosong'
      //         }
      //       }
      //   },
      //
      //   fungsi: {
      //       validators: {
      //         notEmpty: {
      //           message: 'Tidak boleh kosong'
      //         }
      //       }
      //   },
      //
      //   ket_pengelola: {
      //       validators: {
      //         notEmpty: {
      //           message: 'Tidak boleh kosong'
      //         }
      //       }
      //   },
      //
      //   provinsi: {
      //       validators: {
      //         notEmpty: {
      //           message: 'Tidak boleh kosong'
      //         }
      //       }
      //   },
      //
      //   kabupaten: {
      //       validators: {
      //         notEmpty: {
      //           message: 'Tidak boleh kosong'
      //         }
      //       }
      //   },
      //
      //   kecamatan: {
      //       validators: {
      //         notEmpty: {
      //           message: 'Tidak boleh kosong'
      //         }
      //       }
      //   },
      //
      //   desa: {
      //       validators: {
      //         notEmpty: {
      //           message: 'Tidak boleh kosong'
      //         }
      //       }
      //   },
      //
      //   pola_tanam: {
      //       validators: {
      //         notEmpty: {
      //           message: 'Tidak boleh kosong'
      //         }
      //       }
      //   },
      //
    },

                  });
                  $('#formsatu').bootstrapValidator({
                      container: '#messages',
                      feedbackIcons: {
                          valid: 'glyphicon glyphicon-ok',
                          invalid: 'glyphicon glyphicon-remove',
                          validating: 'glyphicon glyphicon-refresh'
                      },
                      fields: {
                          id_klaster_plot: {
                              validators: {
                                numeric: {
                                  message: 'harus berupa angka!'
                                },
                                  notEmpty: {
                                      message: 'The full name is required and cannot be empty'
                                  }
                              }
                          },

                            pengelola: {
                                validators: {
                                  numeric: {
                                    message: 'harus berupa angka!'
                                  },
                                  notEmpty: {
                                    message: 'Tidak boleh kosong'
                                  }
                                }
                            },

                      }
                  });


  $('#jenis').on('change', function(e){
    console.log(e);
    var id_jenis_hutan = e.target.value;
    $.get('json-fungsi?id_jenis=' + id_jenis_hutan, function(data){
      console.log(data);
      $('#fungsi').empty();
      if(id_jenis_hutan == 0){
        $('#fungsi').append('<option value="" disable="true" selected="true">=== Silahkan Pilih === </option>');
      }
      $.each(data, function(index, fungsiObj){
        $('#fungsi').append('<option value="" disable="true" selected="true">=== Silahkan Pilih === </option>');
        $('#fungsi').append('<option value="' + fungsiObj.id_fungsi + '">' + fungsiObj.fungsi + '</option>');

      })
    });
  });

    $('#provinsi').on('change', function(e){
      console.log(e);
      var id_provinsi = e.target.value;
      $.get('json-kabupaten?id_provinsi=' + id_provinsi, function(data){
        console.log(data);
        $('#kabupaten').empty();
        $('#kabupaten').append('<option value="" disable="true" selected="true">=== Silahkan Pilih === </option>');


        $('#kecamatan').empty();
        $('#kecamatan').append('<option value="" disable="true" selected="true">=== Silahkan Pilih === </option>');


        $('#desa').empty();
        $('#desa').append('<option value="" disable="true" selected="true">=== Silahkan Pilih === </option>');


        $.each(data, function(index, kabupatenObj){
          $('#kabupaten').append('<option value="' + kabupatenObj.id + '">' + kabupatenObj.nama_kabupaten + '</option>');

        })
      });
    });

    $('#kabupaten').on('change', function(e){
      console.log(e);
      var id = e.target.value;
      $.get('json-kecamatan?id=' + id, function(data){
        console.log(data);
        $('#kecamatan').empty();
        $('#kecamatan').append('<option value="" disable="true" selected="true">=== Silahkan Pilih === </option>');

        $('#desa').empty();
        $('#desa').append('<option value="" disable="true" selected="true">=== Silahkan Pilih === </option>');


        $.each(data, function(index, kecamatanObj){
          $('#kecamatan').append('<option value="' + kecamatanObj.id + '">' + kecamatanObj.nama_kecamatan + '</option>');

        });
      });
    });

    $('#kecamatan').on('change', function(e){
      console.log(e);
      var id = e.target.value;
      $.get('json-desa?id=' + id, function(data){
        console.log(data);
        $('#desa').empty();
        $('#desa').append('<option value="" disable="true" selected="true">=== Silahkan Pilih === </option>');

        $.each(data, function(index, desaObj){
          $('#desa').append('<option value="' + desaObj.id + '">' + desaObj.nama_desa + '</option>');

        });
      });
    });

    // $('#sistem_koordinat').on('change', function(e){
    //   var nilai = e.target.value;
    //   if(nilai == '1'){
    //     $("#bujur").hide();
    //     $("#lintang").hide();
    //   }
    //   else if(nilai == '0'){
    //     $("#bujur").show();
    //     $("#lintang").show();
    //   }
    // });
  </script>
