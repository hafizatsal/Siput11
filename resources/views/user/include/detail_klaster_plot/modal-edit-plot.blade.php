<div class="modal fade" id="edit-plot">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Edit Koordinat Titik Pusat Klaster Plot</h4>
      </div>
      <div class="modal-body">
        <form role="form" method="post" action="{{route('user.editPlot')}}"
                onsubmit="document.getElementById('submit').disabled=true;
        document.getElementById('submit').value='Sedang memperbarui...';">
            {{csrf_field()}}
    <div class="box-body">
      <input type="hidden" class="form-control" name="id_plot" id="id_plot" value="">
      <input type="hidden" class="form-control" name="return_url" id="return_url" value="">
      <div class="form-group col-md-12 col-xs-12 col-sm-12">
        <label for="nama_plot">Nama Plot</label>
        <input readonly type="text" class="form-control" name="nama_plot" id="nama_plot" placeholder="Nama Plot">
      </div>

    <div class="col-xs-6">
      <div class="form-group">
        <label class="control-label">Lintang</label>
        <div id="koordinat_lintang" class="form-group">
        <div class="input-group">
            <input type="text" class="form-control" id="lintang" name="lintang">
            <span class="input-group-addon" style="width:0px; padding-left:0px; padding-right:0px; border:none;"></span>

            <select class="form-control" name="pilih_lintang" id="pilih_lintang">
              <option value="LS" selected>LS</option>
              <option value="LU">LU</option>
            </select>
        </div>
        <label hidden id="id_lintang" class="control-label"><i>Lintang harus sesuai dengan format!</i></label>
      </div>
      </div>
    </div>

  <div class="col-xs-6">
    <div class="form-group">
      <label class="control-label">Bujur</label>
      <div id="koordinat_bujur" class="form-group">
        <div class="input-group">
            <input type="text" class="form-control" id="koordinat" name="koordinat">
            <span class="input-group-addon" style="width:0px; padding-left:0px; padding-right:0px; border:none;"></span>

            <select class="form-control" name="pilih_bujur" id="pilih_bujur">
              <option value="BT" selected>BT</option>
              <option value="BB">BB</option>
            </select>
        </div>
        <label hidden id="id_bujur" class="control-label"><i>Bujur harus sesuai dengan format!</i></label>
      </div>
    </div>
  </div>

    </div>
    <!-- /.box-body -->

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Kembali</button>
        <input type="submit" id="submit" class="btn btn-primary" value="Simpan"/>
      </div>
        </form>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
<!-- InputMask -->
@section('script_tambahan')
<script src="{{asset('Admin/plugins/input-mask/jquery.inputmask.js')}}"></script>
<script src="{{asset('Admin/plugins/input-mask/jquery.inputmask.date.extensions.js')}}"></script>
<script src="{{asset('Admin/plugins/input-mask/jquery.inputmask.extensions.js')}}"></script>
@endsection

  @section('script_table')
  <script>
(function($){
  $(document).ready(function(){
    var DEG = '\u00B0';
    var LINTANG_DIGITS = 8; // DDMMSSss
    var BUJUR_DIGITS = 9; // DDDMMSSss

    $('#lintang').attr('placeholder', `00 ${DEG} 00 ' 00.00 \"`);
    $('#koordinat').attr('placeholder', `000 ${DEG} 00 ' 00.00 \"`);

    var v_lintang = 1;
    var v_bujur = 1;
    var valid_lintang = new RegExp(`^[0-9]{2} ${DEG} [0-9]{2} ' [0-9]{2}\\.[0-9]{2} \"$`);
    var valid_bujur = new RegExp(`^[0-9]{3} ${DEG} [0-9]{2} ' [0-9]{2}\\.[0-9]{2} \"$`);

    function toggleSubmit() {
      $('#submit').prop('disabled', !(v_lintang && v_bujur));
    }

    function digitsOnly(value, limit) {
      var digits = (value || '').toString().replace(/\D/g, '');
      if (limit && digits.length > limit) {
        digits = digits.slice(0, limit);
      }
      return digits;
    }

    function isAllZeros(value, limit) {
      var digits = digitsOnly(value, limit);
      return digits.length > 0 && /^0+$/.test(digits);
    }

    function formatDmsFromDigits(digits, degLen) {
      var deg = digits.slice(0, degLen);
      var min = digits.slice(degLen, degLen + 2);
      var sec = digits.slice(degLen + 2, degLen + 6);
      var out = '';

      if (deg.length) {
        out += deg;
        if (deg.length === degLen) {
          out += ' ' + DEG + ' ';
        }
      }
      if (min.length) {
        out += min;
        if (min.length === 2) {
          out += " ' ";
        }
      }
      if (sec.length) {
        out += sec.slice(0, 2);
        if (sec.length > 2) {
          out += '.' + sec.slice(2, 4);
        }
        if (sec.length === 4) {
          out += ' "';
        }
      }
      return out;
    }

    function updateLintang() {
      var digits = digitsOnly($('#lintang').val(), LINTANG_DIGITS);
      $('#lintang').val(formatDmsFromDigits(digits, 2));
      var lintang = $('#lintang').val();
      if (valid_lintang.test(lintang)) {
        $('#koordinat_lintang').attr("class", "form-group has-success");
        $('#id_lintang').hide();
        v_lintang=1;
      }
      else {
        v_lintang=0;
        $('#id_lintang').show();
        $('#koordinat_lintang').attr("class", "form-group has-error");
      }
      toggleSubmit();
    }

    function updateBujur() {
      var digits = digitsOnly($('#koordinat').val(), BUJUR_DIGITS);
      $('#koordinat').val(formatDmsFromDigits(digits, 3));
      var bujur = $('#koordinat').val();
      if (valid_bujur.test(bujur)) {
        $('#koordinat_bujur').attr("class", "form-group has-success");
        $('#id_bujur').hide();
        v_bujur=1;
      }
      else {
        v_bujur=0;
        $('#id_bujur').show();
        $('#koordinat_bujur').attr("class", "form-group has-error");
      }
      toggleSubmit();
    }

    $('#lintang').on('input', updateLintang);
    $('#koordinat').on('input', updateBujur);
    $('#lintang').on('focus', function() {
      if (isAllZeros($(this).val(), LINTANG_DIGITS)) {
        $(this).val('');
        updateLintang();
      }
    });
    $('#koordinat').on('focus', function() {
      if (isAllZeros($(this).val(), BUJUR_DIGITS)) {
        $(this).val('');
        updateBujur();
      }
    });

    function formatDms(raw, pad) {
      var parts = (raw || '').toString().trim().split(/\s+/);
      if (parts.length < 3) {
        return '';
      }
      var deg = Math.abs(parseFloat(parts[0]) || 0).toString().padStart(pad, '0');
      var min = (parts[1] || '0').toString().padStart(2, '0');
      var sec = (parts[2] || '0').toString();
      return deg + ' ' + DEG + ' ' + min + " ' " + sec + ' \"';
    }

    $('#edit-plot').on('show.bs.modal', function(event){
       var button = $(event.relatedTarget);
       var plotid = button.data('plotid');
       var nama_plot = button.data('nama_plot');

       var modal = $(this);
       modal.find('#id_plot').val(plotid);
       modal.find('#return_url').val(window.location.href);
       modal.find('#nama_plot').val(nama_plot);

       var pisah = button.data('koorbujur');
       var arr = (pisah || '').toString().trim().split(/\s+/);
       var int_bujur = parseInt(arr[0], 10);
       if(int_bujur>=0){
         modal.find('#pilih_bujur').val('BT');
       }
       else{
         modal.find('#pilih_bujur').val('BB');
       }
       var bujur = formatDms(pisah, 3);
       if (isAllZeros(pisah, BUJUR_DIGITS)) {
         bujur = '';
       }

       var pisah2 = button.data('koorlintang');
       var arr2 = (pisah2 || '').toString().trim().split(/\s+/);
       var int_lintang = parseInt(arr2[0], 10);
       if(int_lintang>=0){
         modal.find('#pilih_lintang').val('LU');
       }
       else{
         modal.find('#pilih_lintang').val('LS');
       }
       var lintang = formatDms(pisah2, 2);
       if (isAllZeros(pisah2, LINTANG_DIGITS)) {
         lintang = '';
       }

       modal.find('#lintang').val(lintang);
       modal.find('#koordinat').val(bujur);

       updateLintang();
       updateBujur();
    });
  });
})(jQuery);
  </script>
  @endsection
