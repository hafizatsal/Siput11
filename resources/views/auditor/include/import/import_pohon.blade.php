<div class="modal fade" id="modal_import_pohon">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Import Pohon</h4>
      </div>
      <div class="modal-body">
        <form role="form" method="post" action="{{route('auditor.import_pohon')}}" enctype="multipart/form-data"
        onsubmit="document.getElementById('import_pohon').disabled=true;
        document.getElementById('import_pohon').value='Sedang import...';">
          {{csrf_field()}}
          <div class="box-body">

          <div class="col-md-12">
            <input type="hidden" name="import_id_pengukuran_phn" id="import_id_pengukuran_phn" value="{{$id}}">
            <input type="hidden" name="import_pengukuran_ke_phn" id="import_pengukuran_ke_phn" value="{{$data_pengukuran->pengukuran_ke}}">
            <input type="hidden" name="id_klaster_import_phn" id="id_klaster_import_phn" value="{{$data_pengukuran->id_klaster_plot}}">
            <input type="hidden" name="import_id_plot_phn" id="import_id_plot_phn" value="{{$id_plot}}">
            <input type="file" name="file">
          </div>
          </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
        <input type="submit" id="import_pohon" class="btn btn-primary" value="Import">
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
  $('#modal_import_pohon').on('show.bs.modal', function(event){
  alert('Untuk import data pohon, gunakan template yang telah disediakan pada halaman utama!');
  });
});
</script>
@endpush