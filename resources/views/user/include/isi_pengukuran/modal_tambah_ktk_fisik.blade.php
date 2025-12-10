@section('css')
<link rel="stylesheet" href="{{asset('Admin/bower_components/select2/dist/css/select2.min.css')}}">
@endsection
<div class="modal fade" id="modal_tambah_fisik">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Tambah Data Kualitas Tapak (Fisik)</h4>
      </div>
      <div class="modal-body">
        <form role="form" method="post" action="{{route('user.tambah_fisik')}}"
        onsubmit="document.getElementById('submit_ktk').disabled=true;
        document.getElementById('submit_ktk').value='Sedang menyimpan...';">
          {{csrf_field()}}
          <div class="box-body">

            <div class="form-group">
              <label for="tambah_titik_plot">Titik Plot</label>
              @if($data_pengukuran->nama_plot=="PLOT 2")
              <input type="text" class="form-control" id="tambah_titik_plot" name="tambah_titik_plot" value="1-2" readonly>
              @elseif($data_pengukuran->nama_plot=="PLOT 3")
              <input type="text" class="form-control" id="tambah_titik_plot" name="tambah_titik_plot" value="1-3" readonly>
              @elseif($data_pengukuran->nama_plot=="PLOT 4")
              <input type="text" class="form-control" id="tambah_titik_plot" name="tambah_titik_plot" value="1-4" readonly>
              @endif
              <input type="hidden" id="id_klaster_plot" name="id_klaster_plot" value="{{$id_klaster}}">
              <input type="hidden" id="id_plot" name="id_plot" value="{{$id_plot}}">
              <input type="hidden" id="pengukuran_ke" name="pengukuran_ke" value="{{$pengukuran_ke}}">
            </div>

            <div id="input-terbuka" class="form-group">
              <label for="terbuka">Terbuka (%)*</label>
              <input type="text" class="form-control" name="terbuka" id="terbuka" value="">
            </div>

            <div class="form-group">
              <label for="tertutup">Tertutup (%)*</label>
              <input type="text" class="form-control" id="tertutup" name="tertutup" value="" readonly>
            </div>

            <div id="input-tekstur" class="form-group">
              <label for="tekstur">Tekstur *</label>
              <input type="text" class="form-control" id="tekstur" name="tekstur" value="">
            </div>

            <div id="input-warna" class="form-group">
              <label for="warna">Warna *</label>
              <input type="text" class="form-control" id="warna" name="warna" value="">
            </div>

            <div id="input-ketebalan" class="form-group">
              <label for="ketebalan">Ketebalan (cm)*</label>
              <input type="text" class="form-control" id="ketebalan" name="ketebalan" value="">
            </div>

              <div class="row">
                <div class="col-xs-6">
                  <div id="input-lintang" class="form-group">
                    <label class="control-label">Lintang</label>
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="00 ᴼ 00 &rsquo; 00.00 &rdquo;" data-inputmask="'mask': ['99 ᴼ 99 &rsquo; 99.99 &rdquo;']" data-mask_tanah id="lintang" name="lintang">
                        <!-- insert this line -->
                        <span class="input-group-addon" style="width:0px; padding-left:0px; padding-right:0px; border:none;"></span>

                        <select class="form-control" name="pilih_lintang" id="pilih_lintang">
                          <option value="LS" selected>LS</option>
                          <option value="LU">LU</option>
                        </select>
                    </div>
                  </div>
                </div>
                <div class="col-xs-6">
                  <div id="input-bujur" class="form-group">
                    <label class="control-label">Bujur</label>
                      <div class="input-group">
                          <input type="text" class="form-control" placeholder="00 ᴼ 00 &rsquo; 00.00 &rdquo;" data-inputmask="'mask': ['999 ᴼ 99 &rsquo; 99.99 &rdquo;']" data-mask_tanah id="bujur" name="bujur">
                          <!-- insert this line -->
                          <span class="input-group-addon" style="width:0px; padding-left:0px; padding-right:0px; border:none;"></span>

                          <select class="form-control" name="pilih_bujur" id="pilih_bujur">
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
        <input disabled type="submit" id="submit_ktk" class="btn btn-primary" value="Simpan">
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
@section('script_table')
<script>
  $('[data-mask_tanah]').inputmask()
  $(document).ready(function(){
  var tertutup;
    $('#terbuka').keyup(function() {
      tertutup = 100-parseInt($('#terbuka').val());
      $('#tertutup').val(tertutup);
    });
$('#modal_tambah_fisik').on('show.bs.modal', function(event){
    error_terbuka=0;
    error_tekstur=0;
    error_warna=0;
    error_ketebalan=0;
    error_lintang=0;
    error_bujur=0;

    $('#terbuka').on('input', function () {
        terbuka = $('#terbuka').val();
        var angka = /^[1-9]{0,1}[0-9]$|^100$/; //validasi angka
        if (terbuka.match(angka) && terbuka!=null) {
          $('#input-terbuka').attr("class", "form-group has-success");
          error_terbuka=1;
        } else {
          $('#input-terbuka').attr("class", "form-group has-error");
          error_terbuka=0;
        }
        if(error_terbuka + error_tekstur + error_warna + error_ketebalan + error_lintang + error_bujur == 6){
        $('#submit_ktk').prop("disabled",false);
        }
        else {
        $('#submit_ktk').prop("disabled",true);
        }
      });

      $('#tekstur').on('input', function () {
          tekstur = $('#tekstur').val();
          if (tekstur!="") {
            $('#input-tekstur').attr("class", "form-group has-success");
            error_tekstur=1;
          } else {
            $('#input-tekstur').attr("class", "form-group has-error");
            error_tekstur=0;
          }
          if(error_terbuka + error_tekstur + error_warna + error_ketebalan + error_lintang + error_bujur == 6){
          $('#submit_ktk').prop("disabled",false);
          }
          else {
          $('#submit_ktk').prop("disabled",true);
          }
        });

        $('#warna').on('input', function () {
            warna = $('#warna').val();
            if (warna!="") {
              $('#input-warna').attr("class", "form-group has-success");
              error_warna=1;
            } else {
              $('#input-warna').attr("class", "form-group has-error");
              error_warna=0;
            }
            if(error_terbuka + error_tekstur + error_warna + error_ketebalan + error_lintang + error_bujur == 6){
            $('#submit_ktk').prop("disabled",false);
            }
            else {
            $('#submit_ktk').prop("disabled",true);
            }
          });

      $('#ketebalan').on('input', function () {
          ketebalan = $('#ketebalan').val();
          var angka = /^([0-9]{1,}(\.[0-9]{1,}){0,1})$/; //validasi angka
          if (ketebalan.match(angka) && ketebalan!=null) {
            $('#input-ketebalan').attr("class", "form-group has-success");
            error_ketebalan=1;
          } else {
            $('#input-ketebalan').attr("class", "form-group has-error");
            error_ketebalan=0;
          }
          if(error_terbuka + error_tekstur + error_warna + error_ketebalan + error_lintang + error_bujur == 6){
          $('#submit_ktk').prop("disabled",false);
          }
          else {
          $('#submit_ktk').prop("disabled",true);
          }
        });

        $('#lintang').on('input', function () {
            lintang = $('#lintang').val();
            var angka = /^[0-9]{2} ᴼ [0-9]{2} ’ [0-9]{2}\.[0-9]{2} ”$/; //validasi angka
            if (lintang.match(angka) && lintang!=null) {
              $('#input-lintang').attr("class", "form-group has-success");
              error_lintang=1;
            } else {
              $('#input-lintang').attr("class", "form-group has-error");
              error_lintang=0;
            }
            if(error_terbuka + error_tekstur + error_warna + error_ketebalan + error_lintang + error_bujur == 6){
            $('#submit_ktk').prop("disabled",false);
            }
            else {
            $('#submit_ktk').prop("disabled",true);
            }
          });

          $('#bujur').on('input', function () {
              bujur = $('#bujur').val();
              var angka = /^[0-9]{3} ᴼ [0-9]{2} ’ [0-9]{2}\.[0-9]{2} ”$/; //validasi angka
              if (bujur.match(angka) && bujur!=null) {
                $('#input-bujur').attr("class", "form-group has-success");
                error_bujur=1;
              } else {
                $('#input-bujur').attr("class", "form-group has-error");
                error_bujur=0;
              }
              if(error_terbuka + error_tekstur + error_warna + error_ketebalan + error_lintang + error_bujur == 6){
              $('#submit_ktk').prop("disabled",false);
              }
              else {
              $('#submit_ktk').prop("disabled",true);
              }
            });

          });

          $('#modal_tambah_fisik').on('hidden.bs.modal', function(event){
            error_terbuka=0;
            error_tekstur=0;
            error_warna=0;
            error_ketebalan=0;
            error_lintang=0;
            error_bujur=0;

            $('#input-terbuka').attr("class", "form-group");
            $('#input-tekstur').attr("class", "form-group");
            $('#input-warna').attr("class", "form-group");
            $('#input-ketebalan').attr("class", "form-group");
            $('#input-lintang').attr("class", "form-group");
            $('#input-bujur').attr("class", "form-group");

            $('#terbuka').val(0);
            $('#tertutup').val(0);
            $('#tekstur').val("");
            $('#warna').val("");
            $('#ketebalan').val("");
            $('#lintang').val("00 ᴼ 00 ’ 00.00 ”");
            $('#bujur').val("000 ᴼ 00 ’ 00.00 ”");
          });

  });
</script>
@endsection
