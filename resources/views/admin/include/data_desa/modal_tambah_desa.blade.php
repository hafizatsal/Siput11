<div class="modal fade" id="tambah_desa">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Tambah Desa</h4>
      </div>
      <div class="modal-body">
        <form role="form" method="post" action="{{route('admin.desa.insert')}}"
        onsubmit="document.getElementById('submit_desa').disabled=true;
        document.getElementById('submit_desa').value='Sedang menyimpan...';">
          {{csrf_field()}}
    <div class="box-body">
      <div id="desa" class="form-group">
      <label for="nama_desa">Nama Desa</label>
      <input type="hidden" name="id_kecamatan" id="id_kecamatan" value="{{$id_kecamatan}}">
      <input type="text" required class="form-control" name="nama_desa" id="nama_desa" value="" placeholder="Desa">
      <label hidden id="label_nama_desa" class="control-label">Desa harus diisi!</label>
      </div>
    </div>
    <!-- /.box-body -->

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
        <input type="submit" id="submit_desa" class="btn btn-primary" value="Simpan">
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

var v_nama_desa=0;

  $('#desa').on('input', function() {
    nama_desa = $('#nama_desa').val();
    if(nama_desa!=""){
      $('#desa').attr("class", "form-group has-success");
      $('#label_nama_desa').hide();
      v_nama_desa=1;
      // console.log(v_nama_desa);
    }
    else {
      v_nama_desa=0;
     $('#label_nama_desa').show();
      $('#desa').attr("class", "form-group has-error");
      // console.log(v_nama_desa);
    }
  });

});
</script>

