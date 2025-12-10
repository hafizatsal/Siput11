<div class="modal fade" id="tambah_lokasi">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Tambah Provinsi</h4>
      </div>
      <div class="modal-body">
        <form role="form" method="get" action="{{route('admin.lokasi.insert')}}"
        onsubmit="document.getElementById('submit_lokasi').disabled=true;
        document.getElementById('submit_lokasi').value='Sedang menyimpan...';">
          {{csrf_field()}}
    <div class="box-body">
      <div id="lokasi" class="form-group">
      <label for="nama_lokasi">Nama Provinsi</label>
      <input type="text" required class="form-control" name="nama_lokasi" id="nama_lokasi" value="" placeholder="Provinsi">
      <label hidden id="label_nama_lokasi" class="control-label">Provinsi harus diisi!</label>
      </div>
    </div>
    <!-- /.box-body -->

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
        <input type="submit" id="submit_lokasi" class="btn btn-primary" value="Simpan">
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

var v_nama_lokasi=0;

  $('#lokasi').on('input', function() {
    nama_lokasi = $('#nama_lokasi').val();
   console.log(nama_lokasi);
    if(nama_lokasi!=""){
      $('#lokasi').attr("class", "form-group has-success");
      $('#label_nama_lokasi').hide();
      v_nama_lokasi=1;
      // console.log(v_nama_lokasi);
    }
    else {
      v_nama_lokasi=0;
     $('#label_nama_lokasi').show();
      $('#lokasi').attr("class", "form-group has-error");
      // console.log(v_nama_lokasi);
    }
  });

});
</script>
