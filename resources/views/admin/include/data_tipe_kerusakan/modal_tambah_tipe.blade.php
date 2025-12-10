<div class="modal fade" id="tambah_tipe">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Tambah Kode Kerusakan Tipe</h4>
      </div>
      <div class="modal-body">
        <form role="form" method="get" action="{{route('admin.nilai_kerusakan_tipe.insert')}}"
        onsubmit="document.getElementById('submit_tipe_kerusakan').disabled=true;
        document.getElementById('submit_tipe_kerusakan').value='Sedang menyimpan...';">
          {{csrf_field()}}
    <div class="box-body">
      <label for="kode_tipe">Kode</label>
      <input type="text" required class="form-control" name="kode_tipe" id="kode_tipe" value="" placeholder="Kode">

      <label for="tipe">Tipe Kerusakan</label>
      <input type="text" required class="form-control" name="tipe" id="tipe" value="" placeholder="Tipe Kerusakan">


      <label for="nilai">Nilai</label>
      <input type="text" required class="form-control" name="nilai" id="nilai" value="" placeholder="Nilai">

    </div>
    <!-- /.box-body -->

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
        <input type="submit" id="submit_tipe_kerusakan" class="btn btn-primary" value="Simpan">
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
