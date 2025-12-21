@section('css')
<link rel="stylesheet" href="{{asset('Admin/bower_components/select2/dist/css/select2.min.css')}}">
@endsection
<div class="modal fade" id="modal_edit_fisik">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Edit Data Kualitas Tapak (Fisika)</h4>
      </div>
      <div class="modal-body">
        <form role="form" method="post" action="{{route('user.edit_fisik')}}"
        onsubmit="document.getElementById('ubah_ktk').disabled=true;
        document.getElementById('ubah_ktk').value='Sedang memperbarui...';">
          {{csrf_field()}}
          <div class="box-body">

            <div class="form-group">
              <input type="hidden" name="id_ktk" id="id_ktk" value="">
              <label for="tambah_titik_plot">Titik Plot</label>
              @if($data_pengukuran->nama_plot=="PLOT 2")
              <input type="text" class="form-control" id="tambah_titik_plot2" name="tambah_titik_plot2" value="1-2" readonly>
              @elseif($data_pengukuran->nama_plot=="PLOT 3")
              <input type="text" class="form-control" id="tambah_titik_plot2" name="tambah_titik_plot2" value="1-3" readonly>
              @elseif($data_pengukuran->nama_plot=="PLOT 4")
              <input type="text" class="form-control" id="tambah_titik_plot2" name="tambah_titik_plot2" value="1-4" readonly>
              @endif
              <input type="hidden" id="id_klaster_plot2" name="id_klaster_plot2" value="{{$id_klaster}}">
              <input type="hidden" id="id_plot2" name="id_plot2" value="{{$id_plot}}">
              <input type="hidden" id="pengukuran_ke2" name="pengukuran_ke2" value="{{$pengukuran_ke}}">
            </div>

            <div id="edit-terbuka" class="form-group">
              <label for="terbuka2">Terbuka (%)*</label>
              <input type="text" class="form-control" name="terbuka2" id="terbuka2" value="">
            </div>

            <div class="form-group">
              <label for="tertutup2">Tertutup (%)*</label>
              <input type="text" class="form-control" id="tertutup2" name="tertutup2" value="" readonly>
            </div>

            <div id="edit-tekstur" class="form-group">
              <label for="tekstur2">Tekstur *</label>
              <input type="text" class="form-control" id="tekstur2" name="tekstur2" value="">
            </div>

            <div id="edit-warna" class="form-group">
              <label for="warna2">Warna *</label>
              <input type="text" class="form-control" id="warna2" name="warna2" value="">
            </div>

            <div id="edit-ketebalan" class="form-group">
              <label for="ketebalan2">Ketebalan (cm)*</label>
              <input type="text" class="form-control" id="ketebalan2" name="ketebalan2" value="">
            </div>

            <div class="row">
              <div class="col-xs-6">
                <div id="edit-lintang" class="form-group">
                  <label class="control-label">Lintang</label>
                  <div class="input-group">
                      <input type="text" class="form-control" placeholder="00 ᴼ 00 &rsquo; 00.00 &rdquo;" data-inputmask="'mask': ['99 ᴼ 99 &rsquo; 99.99 &rdquo;']" data-mask_tanah2 id="lintang2" name="lintang2">
                      <!-- insert this line -->
                      <span class="input-group-addon" style="width:0px; padding-left:0px; padding-right:0px; border:none;"></span>

                      <select class="form-control" name="pilih_lintang2" id="pilih_lintang2">
                        <option value="LS" selected>LS</option>
                        <option value="LU">LU</option>
                      </select>
                  </div>
                </div>
              </div>
              <div class="col-xs-6">
                <div id="edit-bujur" class="form-group">
                  <label class="control-label">Bujur</label>
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="00 ᴼ 00 &rsquo; 00.00 &rdquo;" data-inputmask="'mask': ['999 ᴼ 99 &rsquo; 99.99 &rdquo;']" data-mask_tanah2 id="bujur2" name="bujur2">
                        <!-- insert this line -->
                        <span class="input-group-addon" style="width:0px; padding-left:0px; padding-right:0px; border:none;"></span>

                        <select class="form-control" name="pilih_bujur2" id="pilih_bujur2">
                          <option value="BT" selected>BT</option>
                          <option value="BB">BB</option>
                        </select>
                    </div>
                </div>
              </div>
            </div>

          </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
        <input type="submit" id="ubah_ktk" class="btn btn-primary" value="Simpan">
      </div>
          </form>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
@section('script_tambahan')
  <script src="{{asset('Admin/bower_components/select2/dist/js/select2.full.min.js')}}"></script>
  <script src="{{asset('Admin/plugins/input-mask/jquery.inputmask.js')}}"></script>
  <script src="{{asset('Admin/plugins/input-mask/jquery.inputmask.date.extensions.js')}}"></script>
  <script src="{{asset('Admin/plugins/input-mask/jquery.inputmask.extensions.js')}}"></script>
@endsection
<script type="text/javascript">
  $(document).ready(function(){
    $('[data-mask_tanah2]').inputmask();
  var tertutup;
    $('#terbuka2').keyup(function() {
      tertutup = 100-parseFloat($('#terbuka2').val());
      $('#tertutup2').val(tertutup);
    });

    $('#modal_edit_fisik').on('show.bs.modal', function(event){
      var button = $(event.relatedTarget);
      var fisik = button.data('fisik');
      $('#id_ktk').val(fisik);
      $.ajax({
          type: 'post',
          url: '{{route("user.json_sifat_fisik")}}',
          data: {
            '_token': $('input[name=_token]').val(),
            'id': fisik,
          },
          success: function (data) {
            if (data.length > 0) {
              $.each(data, function (key, value) {
                $('#id_klaster_plot2').val(value['kode_klaster']);
                $('#id_plot2').val(value['kode_plot']);
                $('#pengukuran_ke2').val(value['pengukuran_ke']);
                $('#terbuka2').val(value['terbuka']);
                $('#tertutup2').val(value['tertutup']);
                $('#warna2').val(value['warna_tanah']);
                $('#tekstur2').val(value['tekstur']);
                $('#ketebalan2').val(value['ketebalan']);
                $('#lintang2').val(value['lintang_tanah']);
                $('#bujur2').val(value['bujur_tanah']);

                var pisah2=value['lintang_tanah'];
                 var arr2= pisah2.split(' ');

                 var int_lintang= parseInt(arr2[0]);
                 if(int_lintang>=0){
                   $('#pilih_lintang2').val('LU')
                 }
                 else{
                   $('#pilih_lintang2').val('LS')
                  }

                  var pisah=value['bujur_tanah'];

                   var arr= pisah.split(' ');

                   var int_bujur= parseInt(arr[0]);
                   if(int_bujur>=0){
                     $('#pilih_bujur2').val('BT')
                   }
                   else{
                     $('#pilih_bujur2').val('BB')
                   }

                   var bujur = arr[0] + ' ᴼ ' + arr[1] + ' ’ ' + arr[2] + ' ”';
                   var lintang = arr2[0] + ' ᴼ ' + arr2[1] + ' ’ ' + arr2[2] + ' ”';

                   $('#lintang2').val(lintang);
                   $('#bujur2').val(bujur);

              });
          }
          else{
            $('#id_klaster_plot2').val("");
            $('#id_plot2').val("");
            $('#pengukuran_ke2').val("");
            $('#terbuka').val("");
            $('#tertutup').val("");
            $('#ketebalan').val("");
            $('#lintang').val("");
            $('#bujur').val("");
          }
        }
        });

        error_terbuka=1;
        error_tekstur=1;
        error_warna=1;
        error_ketebalan=1;
        error_lintang=1;
        error_bujur=1;

        $('#terbuka2').on('input', function () {
            terbuka2 = $('#terbuka2').val();
            var angka = /^[1-9]{0,1}[0-9]$|^100$/; //validasi angka
            if (terbuka2.match(angka) && terbuka2!=null) {
              $('#edit-terbuka').attr("class", "form-group has-success");
              error_terbuka=1;
            } else {
              $('#edit-terbuka').attr("class", "form-group has-error");
              error_terbuka=0;
            }
            if(error_terbuka + error_tekstur + error_warna + error_ketebalan + error_lintang + error_bujur == 6){
        		$('#ubah_ktk').prop("disabled",false);
        		}
        		else {
        		$('#ubah_ktk').prop("disabled",true);
        		}
          });

          $('#tekstur2').on('input', function () {
              tekstur2 = $('#tekstur2').val();
              if (tekstur2!="") {
                $('#edit-tekstur').attr("class", "form-group has-success");
                error_tekstur=1;
              } else {
                $('#edit-tekstur').attr("class", "form-group has-error");
                error_tekstur=0;
              }
              if(error_terbuka + error_tekstur + error_warna + error_ketebalan + error_lintang + error_bujur == 6){
          		$('#ubah_ktk').prop("disabled",false);
          		}
          		else {
          		$('#ubah_ktk').prop("disabled",true);
          		}
            });

            $('#warna2').on('input', function () {
                warna2 = $('#warna2').val();
                if (warna2!="") {
                  $('#edit-warna').attr("class", "form-group has-success");
                  error_warna=1;
                } else {
                  $('#edit-warna').attr("class", "form-group has-error");
                  error_warna=0;
                }
                if(error_terbuka + error_tekstur + error_warna + error_ketebalan + error_lintang + error_bujur == 6){
            		$('#ubah_ktk').prop("disabled",false);
            		}
            		else {
            		$('#ubah_ktk').prop("disabled",true);
            		}
              });

          $('#ketebalan2').on('input', function () {
              ketebalan2 = $('#ketebalan2').val();
              var angka = /^([0-9]{1,}(\.[0-9]{1,}){0,1})$/; //validasi angka
              if (ketebalan2.match(angka) && ketebalan2!=null) {
                $('#edit-ketebalan').attr("class", "form-group has-success");
                error_ketebalan=1;
              } else {
                $('#edit-ketebalan').attr("class", "form-group has-error");
                error_ketebalan=0;
              }
              if(error_terbuka + error_tekstur + error_warna + error_ketebalan + error_lintang + error_bujur == 6){
          		$('#ubah_ktk').prop("disabled",false);
          		}
          		else {
          		$('#ubah_ktk').prop("disabled",true);
          		}
            });

            $('#lintang2').on('input', function () {
                lintang2 = $('#lintang2').val();
                var angka = /^[0-9]{2} ᴼ [0-9]{2} ’ [0-9]{2}\.[0-9]{2} ”$/; //validasi angka
                if (lintang2.match(angka) && lintang2!=null) {
                  $('#edit-lintang').attr("class", "form-group has-success");
                  error_lintang=1;
                } else {
                  $('#edit-lintang').attr("class", "form-group has-error");
                  error_lintang=0;
                }
                if(error_terbuka + error_tekstur + error_warna + error_ketebalan + error_lintang + error_bujur == 6){
            		$('#ubah_ktk').prop("disabled",false);
            		}
            		else {
            		$('#ubah_ktk').prop("disabled",true);
            		}
              });

              $('#bujur2').on('input', function () {
                  bujur2 = $('#bujur2').val();
                  var angka = /^[0-9]{3} ᴼ [0-9]{2} ’ [0-9]{2}\.[0-9]{2} ”$/; //validasi angka
                  if (bujur2.match(angka) && bujur2!=null) {
                    $('#edit-bujur').attr("class", "form-group has-success");
                    error_bujur=1;
                  } else {
                    $('#edit-bujur').attr("class", "form-group has-error");
                    error_bujur=0;
                  }
                  if(error_terbuka + error_tekstur + error_warna + error_ketebalan + error_lintang + error_bujur == 6){
              		$('#ubah_ktk').prop("disabled",false);
              		}
              		else {
              		$('#ubah_ktk').prop("disabled",true);
              		}
                });


    });

    $('#modal_edit_fisik').on('hidden.bs.modal', function(){
      $('#ubah_ktk').prop("disabled",false);
      error_terbuka=1;
      error_tekstur=1;
      error_warna=1;
      error_ketebalan=1;
      error_lintang=1;
      error_bujur=1;

      $('#edit-terbuka').attr("class", "form-group");
      $('#edit-tekstur').attr("class", "form-group");
      $('#edit-warna').attr("class", "form-group");
      $('#edit-ketebalan').attr("class", "form-group");
      $('#edit-lintang').attr("class", "form-group");
      $('#edit-bujur').attr("class", "form-group");

      $('#terbuka2').val(0);
      $('#tekstur2').val("");
      $('#warna2').val("");
      $('#ketebalan2').val("");
      $('#lintang2').val("00 ᴼ 00 ’ 00.00 ”");
      $('#bujur2').val("000 ᴼ 00 ’ 00.00 ”");

    });

  });
</script>

