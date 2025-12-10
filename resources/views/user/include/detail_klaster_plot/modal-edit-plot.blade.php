<div class="modal fade" id="edit-plot">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Edit Koordinat Titik Pusat Klaster Plot</h4>
      </div>
      <div class="modal-body">
        <form role="form" method="get" action="{{route('user.edit_klaster')}}"
        onsubmit="document.getElementById('submit').disabled=true;
        document.getElementById('submit').value='Sedang memperbarui...';">
          {{csrf_field()}}
    <div class="box-body">
      <input type="hidden" class="form-control" name="id_plot" id="id_plot" value="">
      <div class="form-group col-md-12 col-xs-12 col-sm-12">
        <label for="nama_plot">Nama Plot</label>
        <input readonly type="text" class="form-control" name="nama_plot" id="nama_plot" placeholder="Nama Plot">
      </div>

    <div class="col-xs-6">
      <div class="form-group">
        <label class="control-label">Lintang</label>
        <div id="koordinat_lintang" class="form-group">
        <div class="input-group">
            <input type="text" class="form-control" placeholder="00 ᴼ 00 &rsquo; 00.00 &rdquo;" data-inputmask="'mask': ['99 ᴼ 99 &rsquo; 99.99 &rdquo;']" data-mask2 id="lintang" name="lintang">
            <!-- insert this line -->
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
            <input type="text" class="form-control" placeholder="00 ᴼ 00 &rsquo; 00.00 &rdquo;" data-inputmask="'mask': ['999 ᴼ 99 &rsquo; 99.99 &rdquo;']" data-mask2 id="koordinat" name="koordinat">
            <!-- insert this line -->
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
  $('[data-mask2]').inputmask()
$(document).ready(function(){
  // untuk validasi lintang
  var v_lintang= 1;
  var valid_lintang = /^[0-9]{2} ᴼ [0-9]{2} ’ [0-9]{2}\.[0-9]{2} ”$/; //untuk validasi lintang
  $('#koordinat_lintang').on('keyup', function() {
  lintang = $('#lintang').val();
  if(lintang.match(valid_lintang)){
    $('#koordinat_lintang').attr("class", "form-group has-success");
    $('#id_lintang').hide();
    v_lintang=1;
  }
  else {
    v_lintang=0;
    $('#id_lintang').show();
    $('#koordinat_lintang').attr("class", "form-group has-error");
  }

  if(v_bujur+v_lintang==2){
  $('#submit').prop("disabled",false);
}
  else {
  $('#submit').prop("disabled",true);
}
  });

  // untuk validasi bujur
  var v_bujur= 1;
  var valid_bujur = /^[0-9]{3} ᴼ [0-9]{2} ’ [0-9]{2}\.[0-9]{2} ”$/; //untuk validasi bujur
  $('#koordinat_bujur').on('keyup', function() {
  bujur = $('#koordinat').val();
  if(bujur.match(valid_bujur)){
    $('#koordinat_bujur').attr("class", "form-group has-success");
    $('#id_bujur').hide();
    v_bujur=1;
  }
  else {
    v_bujur=0;
    $('#id_bujur').show();
    $('#koordinat_bujur').attr("class", "form-group has-error");
  }

  if(v_bujur+v_lintang==2){
  $('#submit').prop("disabled",false);
}
  else {
  $('#submit').prop("disabled",true);
}
  });

  $('#edit-plot').on('show.bs.modal', function(event){
     var button = $(event.relatedTarget);
     var plotid = button.data('plotid');
     var nama_plot = button.data('nama_plot');



     var modal = $(this)
    modal.find('#id_plot').val(plotid);
    modal.find('#nama_plot').val(nama_plot);

       var pisah=button.data('koorbujur');

        var arr= pisah.split(' ');

        var int_bujur= parseInt(arr[0]);
        if(int_bujur>=0){
          modal.find('#pilih_bujur').val('BT')
        }
        else{
          modal.find('#pilih_bujur').val('BB')
        }

        var bujur = arr[0] + ' ᴼ ' + arr[1] + ' ’ ' + arr[2] + ' ”';

       var pisah2=button.data('koorlintang');
        var arr2= pisah2.split(' ');

        var int_lintang= parseInt(arr2[0]);
        if(int_lintang>=0){
          modal.find('#pilih_lintang').val('LU')
        }
        else{
          modal.find('#pilih_lintang').val('LS')
         }

        var lintang = arr2[0] + ' ᴼ ' + arr2[1] + ' ’ ' + arr2[2] + ' ”';


         modal.find('#lintang').val(lintang);
         modal.find('#koordinat').val(bujur);


  });
    });
    </script>
  @endsection
