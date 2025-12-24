<div class="modal fade" id="tambah_tanah">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Tambah Sifat Tanah</h4>
      </div>
      <div class="modal-body">
        <form role="form" method="post" action="{{route('admin.tanah.insert')}}"
        onsubmit="document.getElementById('submit_tanah').disabled=true;
        document.getElementById('submit_tanah').value='Sedang menyimpan...';">
          {{csrf_field()}}
    <div class="box-body">
      <div id="indikator_tanah" class="form-group">
      <label for="nama_indikator_tanah">Sifat Tanah</label>
      <input type="text" required class="form-control" name="nama_indikator_tanah" id="nama_indikator_tanah" value="" placeholder="Sifat Tanah">
      <label hidden id="label_nama_indikator_tanah" class="control-label">Sifat tanah harus diisi!</label>
      </div>
    </div>
    <!-- /.box-body -->

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
        <input type="submit" id="submit_tanah" class="btn btn-primary" value="Simpan">
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

var v_nama_indikator_tanah=0;

  $('#indikator_tanah').on('input', function() {
    nama_indikator_tanah = $('#nama_indikator_tanah').val();
    if(nama_indikator_tanah!=""){
      $('#indikator_tanah').attr("class", "form-group has-success");
      $('#label_nama_indikator_tanah').hide();
      v_nama_indikator_tanah=1;
      // console.log(v_nama_indikator_tanah);
    }
    else {
      v_nama_indikator_tanah=0;
     $('#label_nama_indikator_tanah').show();
      $('#indikator_tanah').attr("class", "form-group has-error");
      // console.log(v_nama_indikator_tanah);
    }
  });

});
</script>

