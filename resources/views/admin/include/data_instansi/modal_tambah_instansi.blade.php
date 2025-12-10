<div class="modal fade" id="tambah_instansi">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Tambah Instansi</h4>
      </div>
      <div class="modal-body">
        <form role="form" method="get" action="{{route('admin.instansi.insert')}}"
        onsubmit="document.getElementById('submit_instansi').disabled=true;
        document.getElementById('submit_instansi').value='Sedang menyimpan...';">
          {{csrf_field()}}
    <div class="box-body">
      <div id="instansi" class="form-group">
      <label for="nama_instansi">Nama Instansi</label>
      <input type="text" class="form-control" required name="nama_instansi" id="nama_instansi" value="" placeholder="Nama Instansi">
      <label hidden id="label_nama_instansi" class="control-label">Nama instansi harus diisi!</label>
      </div>


    </div>
    <!-- /.box-body -->

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
        <input type="submit" id="submit_instansi" class="btn btn-primary" value="Simpan">
      </div>
        </form>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<script type="text/javascript">
$(document).ready(function(){

var v_nama_instansi=0;

  $('#instansi').on('input', function() {
    nama_instansi = $('#nama_instansi').val();
    if(nama_instansi!=""){
      $('#instansi').attr("class", "form-group has-success");
      $('#label_nama_instansi').hide();
      v_nama_instansi=1;
    }
    else {
      v_nama_instansi=0;
     $('#label_nama_instansi').show();
      $('#instansi').attr("class", "form-group has-error");
    }
  });

});
</script>
