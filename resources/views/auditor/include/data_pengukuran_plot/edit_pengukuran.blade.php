<div class="modal fade" id="modal_edit_pengukuran">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Edit Pengukuran</h4>
      </div>
      <div class="modal-body">
        <form role="form" method="get" action="{{route('auditor.pengukuran.edit')}}">
          {{csrf_field()}}
          <div class="box-body">
            <label for="pengukuran_ke">Pengukuran ke-</label>
            <input type="text" class="form-control" name="edit_pengukuran_ke" id="edit_pengukuran_ke" value="" readonly>

            <div class="form-group">
              <label for="edit_tanggal_pengukuran">Tanggal Pengukuran</label>
              <div class="input-group date">
                <div class="input-group-addon">
                  <i class="fa fa-calendar"></i>
                </div>
                <input type="text" class="form-control pull-right" name="edit_tanggal_pengukuran" id="datepicker2">
              </div>
              <!-- /.input group -->
            </div>
            <!-- /.form group -->
            <div class="form-group">
              <label for="nama_pengukur">Nama Pengukur</label>
              <input type="hidden" class="form-control" name="edit_id_plot" id="edit_id_plot" value="">
              <input type="text" class="form-control" name="edit_nama_pengukur" id="edit_nama_pengukur" placeholder="Masukkan nama">
            </div>
          </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Keluar</button>
        <input type="submit" class="btn btn-primary" value="Simpan">
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

$(document).ready(function(){
    $('#modal_edit_pengukuran').on('show.bs.modal', function(event){
       var button = $(event.relatedTarget);
       var dpp = button.data('pengukuran');
       var dtahun = button.data('tahun');
       var dnama = button.data('nama');
       var pengke = button.data('pengke');
       var modal = $(this)
       if(dpp!=null){
         modal.find('#edit_id_plot').val(dpp);
         modal.find('#edit_pengukuran_ke').val(pengke);
         modal.find('#datepicker2').val(dtahun);
         modal.find('#edit_nama_pengukur').val(dnama);
       }
    });
    });
  </script>
@endpush