<div class="modal fade" id="edit_tipe">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Edit Kerusakan Tipe</h4>
      </div>
      <div class="modal-body">
        <form role="form" method="get" action="{{route('admin.edit_tipe_kerusakan')}}"
        onsubmit="document.getElementById('edit_tipe_kerusakan2').disabled=true;
        document.getElementById('edit_tipe_kerusakan2').value='Sedang menyimpan...';">
          {{csrf_field()}}
    <div class="box-body">

      <label for="kode_tipe_edit">Kode</label>
      <input type="text" required class="form-control" name="kode_tipe_edit" id="kode_tipe_edit" value="" placeholder="Kode" readonly>

      <label for="tipe_edit">Tipe Kerusakan</label>
      <input type="text" required class="form-control" name="tipe_edit" id="tipe_edit" value="" placeholder="Tipe Kerusakan">


      <label for="nilai_edit">Nilai</label>
      <input type="text" required class="form-control" name="nilai_edit" id="nilai_edit" value="" placeholder="Nilai">

    </div>
    <!-- /.box-body -->

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
        <input type="submit" id="edit_tipe_kerusakan2" class="btn btn-primary" value="Simpan">
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

  $('#edit_tipe').on('show.bs.modal', function(event){
     var button = $(event.relatedTarget);
     var nm_tipe = button.data('nm_tipe');

     $.ajax({
         type: 'post',
         url: '{{route("admin.json_tipe_kerusakan")}}',
         data: {
           '_token': $('input[name=_token]').val(),
           'id': nm_tipe,
         },
         success: function (data) {
           if (data.length > 0) {
           $.each(data, function (key, value) {
             $('#kode_tipe_edit').val(value['kode']);
             $('#tipe_edit').val(value['type']);
             $('#nilai_edit').val(value['nilai']);
           });
         }
         else{
           $('#kode_tipe_edit').val("");
           $('#tipe_edit').val("");
           $('#nilai_edit').val("");
         }
       }
       });
  });

});
</script>
