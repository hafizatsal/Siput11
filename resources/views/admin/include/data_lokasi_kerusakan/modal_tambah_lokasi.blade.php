<div class="modal fade" id="tambah_lokasi">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Tambah Kode Kerusakan Lokasi</h4>
      </div>
      <div class="modal-body">
        <form role="form" method="post" action="{{route('admin.nilai_kerusakan_lokasi.insert')}}"
        onsubmit="document.getElementById('submit_lokasi_kerusakan').disabled=true;
        document.getElementById('submit_lokasi_kerusakan').value='Sedang menyimpan...';">
          {{csrf_field()}}
    <div class="box-body">
      <label for="kode_lokasi">Kode</label>
      <input type="text" required class="form-control" name="kode_lokasi" id="kode_lokasi" value="" placeholder="Kode">

      <label for="lokasi">Lokasi Kerusakan</label>
      <input type="text" required class="form-control" name="lokasi" id="lokasi" value="" placeholder="Lokasi Kerusakan">


      <label for="nilai">Nilai</label>
      <input type="text" required class="form-control" name="nilai" id="nilai" value="" placeholder="Nilai">

    </div>
    <!-- /.box-body -->

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
        <input type="submit" id="submit_lokasi_kerusakan" class="btn btn-primary" value="Simpan">
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

