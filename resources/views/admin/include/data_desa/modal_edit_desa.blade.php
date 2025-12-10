<div class="modal fade" id="edit_desa">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Edit Desa</h4>
      </div>
      <div class="modal-body">
        <form role="form" method="get" action="{{route('admin.edit_desa')}}"
        onsubmit="document.getElementById('edit_desa').disabled=true;
        document.getElementById('edit_desa').value='Sedang menyimpan...';">
          {{csrf_field()}}
    <div class="box-body">
      <div id="desa2" class="form-group">
      <label for="nama_desa2">Nama Desa</label>
      <input type="hidden" name="edit_id_kec" id="edit_id_kec" value="{{$id_kecamatan}}">
      <input type="hidden" name="edit_id_desa" id="edit_id_desa" value="">
      <input type="text" required class="form-control" name="nama_desa2" id="nama_desa2" value="" placeholder="Desa">
      <label hidden id="label_nama_desa2" class="control-label">Desa harus diisi!</label>
      </div>
    </div>
    <!-- /.box-body -->

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Simpan</button>
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

var v_nama_desa2=0;

  $('#desa2').on('input', function() {
    nama_desa2 = $('#nama_desa2').val();
    if(nama_desa2!=""){
      $('#desa2').attr("class", "form-group has-success");
      $('#label_nama_desa2').hide();
      v_nama_desa2=1;
      // console.log(v_nama_desa2);
    }
    else {
      v_nama_desa2=0;
     $('#label_nama_desa2').show();
      $('#desa2').attr("class", "form-group has-error");
      // console.log(v_nama_desa2);
    }
  });

  $('#edit_desa').on('show.bs.modal', function(event){
     var button = $(event.relatedTarget);
     var nm_desa = button.data('nm_desa');

     $.ajax({
         type: 'post',
         url: '{{route("admin.json_desa")}}',
         data: {
           '_token': $('input[name=_token]').val(),
           'id': nm_desa,
         },
         success: function (data) {
           if (data.length > 0) {
           $.each(data, function (key, value) {
             $('#edit_id_desa').val(value['id']);
             $('#nama_desa2').val(value['nama_desa']);
           });
         }
         else{
           $('#edit_id_desa').val("");
           $('#nama_desa2').val("");
         }
       }
       });
  });

});
</script>
