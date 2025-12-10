<div class="modal fade" id="tambah_keparahan">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Tambah Kerusakan Keparahan</h4>
      </div>
      <div class="modal-body">
        <form role="form" method="get" action="{{route('admin.nilai_kerusakan_keparahan.insert')}}"
        onsubmit="document.getElementById('submit_keparahan_kerusakan').disabled=true;
        document.getElementById('submit_keparahan_kerusakan').value='Sedang menyimpan...';">
          {{csrf_field()}}
    <div class="box-body">
      <label for="keparahan">Keparahan Kerusakan</label>
      <input type="text" required class="form-control" name="keparahan" id="keparahan" value="" placeholder="Keparahan Kerusakan">

      <label for="nilai">Nilai</label>
      <input type="text" required class="form-control" name="nilai" id="nilai" value="" placeholder="Nilai">

    </div>
    <!-- /.box-body -->

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
        <input type="submit" id="submit_keparahan_kerusakan" class="btn btn-primary" value="Simpan">
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
