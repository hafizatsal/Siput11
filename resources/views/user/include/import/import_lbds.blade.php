<div class="modal fade" id="modal_import_lbds">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Import Pertumbuhan</h4>
      </div>
      <div class="modal-body">
        <form role="form" method="post" action="{{route('user.import_lbds')}}" enctype="multipart/form-data"
        onsubmit="document.getElementById('import_lbds').disabled=true;
        document.getElementById('import_lbds').value='Sedang import...';">
          {{csrf_field()}}
          <div class="box-body">

          <div class="col-md-12">
            <input type="hidden" name="import_id_pengukuran" id="import_id_pengukuran" value="{{$id}}">
            <input type="hidden" name="import_pengukuran_ke" id="import_pengukuran_ke" value="{{$data_pengukuran->pengukuran_ke}}">
            <input type="hidden" name="id_klaster_import" id="id_klaster_import" value="{{$data_pengukuran->id_klaster_plot}}">
            <input type="hidden" name="import_id_plot" id="import_id_plot" value="{{$id_plot}}">
            <input type="file" name="file">
          </div>
          </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
        <input type="submit" id="import_lbds" class="btn btn-primary" value="Import">
      </div>
          </form>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<script type="text/javascript">
$(document).ready(function() {
  $('#modal_import_lbds').on('show.bs.modal', function(event){
  alert('Untuk import data pertumbuhan, gunakan template yang telah disediakan pada halaman utama!');
  });
});
</script>
