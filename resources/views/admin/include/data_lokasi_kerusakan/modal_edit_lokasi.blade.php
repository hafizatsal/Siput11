<div class="modal fade" id="edit_lokasi">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Edit Kerusakan Lokasi</h4>
      </div>
      <div class="modal-body">
        <form role="form" method="post" action="{{route('admin.edit_lokasi_kerusakan')}}"
        onsubmit="document.getElementById('edit_lokasi_kerusakan').disabled=true;
        document.getElementById('edit_lokasi_kerusakan').value='Sedang menyimpan...';">
          {{csrf_field()}}
    <div class="box-body">

      <label for="kode_lokasi_edit">Kode</label>
      <input type="text" required class="form-control" name="kode_lokasi_edit" id="kode_lokasi_edit" value="" placeholder="Kode" readonly>

      <label for="lokasi_edit">Lokasi Kerusakan</label>
      <input type="text" required class="form-control" name="lokasi_edit" id="lokasi_edit" value="" placeholder="Lokasi Kerusakan">


      <label for="nilai_edit">Nilai</label>
      <input type="text" required class="form-control" name="nilai_edit" id="nilai_edit" value="" placeholder="Nilai">

    </div>
    <!-- /.box-body -->

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
        <input type="submit" id="edit_lokasi_kerusakan" class="btn btn-primary" value="Simpan">
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

  $('#edit_lokasi').on('show.bs.modal', function(event){
     var button = $(event.relatedTarget);
     var nm_lokasi = button.data('nm_lokasi');

     $.ajax({
         type: 'post',
         url: '{{route("admin.json_lokasi_kerusakan")}}',
         data: {
           '_token': $('input[name=_token]').val(),
           'id': nm_lokasi,
         },
         success: function (data) {
           if (data.length > 0) {
           $.each(data, function (key, value) {
             $('#kode_lokasi_edit').val(value['kode']);
             $('#lokasi_edit').val(value['lokasi']);
             $('#nilai_edit').val(value['nilai']);
           });
         }
         else{
           $('#kode_lokasi_edit').val("");
           $('#lokasi_edit').val("");
           $('#nilai_edit').val("");
         }
       }
       });
  });

});
</script>

