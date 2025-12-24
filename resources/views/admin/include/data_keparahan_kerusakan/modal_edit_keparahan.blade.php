<div class="modal fade" id="edit_keparahan">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Edit Kerusakan Keparahan</h4>
      </div>
      <div class="modal-body">
        <form role="form" method="post" action="{{route('admin.edit_keparahan_kerusakan')}}"
        onsubmit="document.getElementById('edit_keparahan_kerusakan2').disabled=true;
        document.getElementById('edit_keparahan_kerusakan2').value='Sedang menyimpan...';">
          {{csrf_field()}}
    <div class="box-body">
      <label for="keparahan_edit">Keparahan Kerusakan</label>
      <input type="text" required class="form-control" name="keparahan_edit" id="keparahan_edit" value="" placeholder="Keparahan Kerusakan" readonly>

      <label for="nilai_edit">Nilai</label>
      <input type="text" required class="form-control" name="nilai_edit" id="nilai_edit" value="" placeholder="Nilai">

    </div>
    <!-- /.box-body -->

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
        <input type="submit" id="edit_keparahan_kerusakan2" class="btn btn-primary" value="Simpan">
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

  $('#edit_keparahan').on('show.bs.modal', function(event){
     var button = $(event.relatedTarget);
     var nm_keparahan = button.data('nm_keparahan');

     $.ajax({
         type: 'post',
         url: '{{route("admin.json_keparahan_kerusakan")}}',
         data: {
           '_token': $('input[name=_token]').val(),
           'id': nm_keparahan,
         },
         success: function (data) {
           if (data.length > 0) {
           $.each(data, function (key, value) {
             $('#keparahan_edit').val(value['keparahan']);
             $('#nilai_edit').val(value['nilai']);
           });
         }
         else{
           $('#keparahan_edit').val("");
           $('#nilai_edit').val("");
         }
       }
       });
  });

});
</script>

