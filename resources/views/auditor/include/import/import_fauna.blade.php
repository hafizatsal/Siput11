<div class="modal fade" id="modal_import_fauna">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Import Fauna</h4>
      </div>
      <div class="modal-body">
        <form role="form" method="post" action="{{route('auditor.import_fauna')}}" enctype="multipart/form-data"
        onsubmit="document.getElementById('import_fauna').disabled=true;
        document.getElementById('import_fauna').value='Sedang import...';">
          {{csrf_field()}}
          <div class="box-body">

          <div class="col-md-12">
            <input type="hidden" name="import_id_pengukuran_fhn" id="import_id_pengukuran_fhn" value="{{$id}}">
            <input type="hidden" name="import_pengukuran_ke_fhn" id="import_pengukuran_ke_fhn" value="{{$data_pengukuran->pengukuran_ke}}">
            <input type="hidden" name="id_klaster_import_fhn" id="id_klaster_import_fhn" value="{{$data_pengukuran->id_klaster_plot}}">
            <input type="hidden" name="import_id_plot_fhn" id="import_id_plot_fhn" value="{{$id_plot}}">
            <input type="file" name="file">
          </div>
          </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
        <input type="submit" id="import_fauna" class="btn btn-primary" value="Import">
      </div>
          </form>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

@push('script_tambahan')
<script type="text/javascript">
$(document).ready(function() {
  $('#modal_import_fauna').on('show.bs.modal', function(event){
  alert('Untuk import data fauna, gunakan template yang telah disediakan pada halaman utama!');
  });
});
</script>
@endpush