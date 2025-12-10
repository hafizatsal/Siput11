<div class="modal fade" id="modal_tambah_foto">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Tambah Foto Pengukuran</h4>
      </div>
      <div class="modal-body">

        <form role="form" method="post" action="{{route('auditor.tambah_foto_pertumbuhan')}}" enctype="multipart/form-data"
        onsubmit="document.getElementById('submit_foto').disabled=true;
        document.getElementById('submit_foto').value='Sedang menyimpan...';">
          {{csrf_field()}}
          <div class="box-body">

            <div class="form-group">
                <label>Judul Foto *</label>
                <input type="text" class="form-control" name="judul_foto" id="judul_foto" value="">
            </div>

              <input type="hidden" id="id_pengukuran" name="id_pengukuran" value="{{$data_pengukuran->id_pengukuran}}">

              <div class="form-group">
                <label for="file_foto">Foto *</label>
                  <input type="file" name="file_foto">
              </div>

              <div class="form-group">
                  <label>Keterangan</label>
                  <textarea class="form-control" name="keterangan_foto" id="keterangan_foto" rows="3" placeholder="Masukkan keterangan ..."></textarea>
              </div>

          </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
        <input type="submit" id="submit_foto" class="btn btn-primary" value="Simpan">
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

});
</script>
