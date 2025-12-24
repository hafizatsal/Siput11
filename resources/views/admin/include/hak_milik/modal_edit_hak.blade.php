<div class="modal fade" id="edit_hak">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Edit Hak</h4>
      </div>
      <div class="modal-body">
        <form role="form" method="post" action="{{route('admin.edit_hak')}}"
        onsubmit="document.getElementById('edit_hak').disabled=true;
        document.getElementById('edit_hak').value='Sedang menyimpan...';">
          {{csrf_field()}}
    <div class="box-body">
      <div id="hak_milik2" class="form-group">
      <label for="nama_hak_milik2">Nama Hak Milik</label>
      <input type="hidden" class="form-control" name="id_hak_milik2" id="id_hak_milik2" value="">
      <input type="text" required class="form-control" name="nama_hak_milik2" id="nama_hak_milik2" value="" placeholder="Nama Hak">
      <label hidden id="label_nama_hak_milik2" class="control-label">Hak milik harus diisi!</label>
      </div>
    </div>
    <!-- /.box-body -->

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
        <input type="submit" id="edit_hak" class="btn btn-primary" value="Simpan">
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

var v_nama_hak_milik2=0;

  $('#hak_milik2').on('input', function() {
    nama_hak_milik2 = $('#nama_hak_milik2').val();
    if(nama_hak_milik2!=""){
      $('#hak_milik2').attr("class", "form-group has-success");
      $('#label_nama_hak_milik2').hide();
      v_nama_hak_milik2=1;
      // console.log(v_nama_hak_milik2);
    }
    else {
      v_nama_hak_milik2=0;
     $('#label_nama_hak_milik2').show();
      $('#hak_milik2').attr("class", "form-group has-error");
      // console.log(v_nama_hak_milik2);
    }
  });

    $('#edit_hak').on('show.bs.modal', function(event){
       var button = $(event.relatedTarget);
       var nm_hak_milik = button.data('nm_hak');

       $.ajax({
           type: 'post',
           url: '{{route("admin.json_hak")}}',
           data: {
             '_token': $('input[name=_token]').val(),
             'id': nm_hak_milik,
           },
           success: function (data) {
             if (data.length > 0) {
             $.each(data, function (key, value) {
               $('#id_hak_milik2').val(value['id_hak_milik']);
               $('#nama_hak_milik2').val(value['hak_milik']);
             });
           }
           else{
             $('#id_hak_milik2').val("");
             $('#nama_hak_milik2').val("");
           }
         }
         });
    });

});
</script>

