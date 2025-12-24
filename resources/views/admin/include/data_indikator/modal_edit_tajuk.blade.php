<div class="modal fade" id="edit_tajuk">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Edit Nilai Tajuk</h4>
      </div>
      <div class="modal-body">
        <form role="form" method="post" action="{{route('admin.edit_tajuk')}}"
        onsubmit="document.getElementById('edit_tajuk2').disabled=true;
        document.getElementById('edit_tajuk2').value='Sedang menyimpan...';">
          {{csrf_field()}}
    <div class="box-body">

      <label for="nama_tajuk">Nama Parameter Tajuk</label>
      <input type="hidden" class="form-control" name="id_tajuk" id="id_tajuk" value="">
      <input type="text" required class="form-control" name="nama_tajuk" id="nama_tajuk" value="" readonly>

      <label for="batas_atas">Batas Atas</label>
      <input type="text" required class="form-control" name="batas_atas" id="batas_atas" value="">

      <label for="batas_bawah">Batas Bawah</label>
      <input type="text" required class="form-control" name="batas_bawah" id="batas_bawah" value="">

    </div>
    <!-- /.box-body -->

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
        <input type="submit" id="edit_tajuk2" class="btn btn-primary" value="Simpan">
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

  $('#edit_tajuk').on('show.bs.modal', function(event){
     var button = $(event.relatedTarget);
     var nm_tajuk = button.data('nm_tajuk');

     $.ajax({
         type: 'post',
         url: '{{route("admin.json_tajuk")}}',
         data: {
           '_token': $('input[name=_token]').val(),
           'id': nm_tajuk,
         },
         success: function (data) {
           if (data.length > 0) {
           $.each(data, function (key, value) {
             $('#id_tajuk').val(value['id_kondisi_tajuk']);
             $('#nama_tajuk').val(value['nama_parameter']);
             $('#batas_atas').val(value['batas_atas']);
             $('#batas_bawah').val(value['batas_bawah']);
           });
         }
         else{
           $('#id_tajuk').val("");
           $('#nama_tajuk').val("");
           $('#batas_atas').val("");
           $('#batas_bawah').val("");
         }
       }
       });

  });

});
</script>

