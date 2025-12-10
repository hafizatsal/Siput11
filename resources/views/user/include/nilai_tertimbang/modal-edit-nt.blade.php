<div class="modal fade" id="edit_nt">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Edit Indikator</h4>
      </div>
      <div class="modal-body">
        <form role="form" method="get" action="{{route('user.edit_tertimbang')}}"
        onsubmit="document.getElementById('submit').disabled=true;
        document.getElementById('submit').value='Sedang memperbarui...';">
          {{csrf_field()}}
    <div class="box-body">
      <div class="form-group">
      <input type="hidden" class="form-control" name="id_indikator2" id="id_indikator2" value="">
      </div>

      <div class="form-group">
        <label for="nama_indikator2">Nama Indikator</label>
        <input type="text" class="form-control" name="nama_indikator2" id="nama_indikator2" value="" readonly>
      </div>

      <div class="form-group">
        <label for="nilai_indikator2">Nilai Indikator</label>
        <input type="text" class="form-control" name="nilai_indikator2" id="nilai_indikator2" placeholder="Nilai Indikator">
      </div>
    </div>
    <!-- /.box-body -->

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
        <input type="submit" id="submit" class="btn btn-primary" value="Simpan"/>
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
  $('#edit_nt').on('show.bs.modal', function(event){
     var button = $(event.relatedTarget);
     var ntid = button.data('ntid');
     var param = button.data('param');
     var nama = button.data('nama');
     var modal = $(this)
    modal.find('#id_indikator2').val(ntid);
    $('#nilai_indikator2').val(param);
    $('#nama_indikator2').val(nama);


  });

    });
  </script>
