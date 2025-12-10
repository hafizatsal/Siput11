<div class="modal fade" id="edit_kabupaten">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Edit Kabupaten</h4>
      </div>
      <div class="modal-body">
        <form role="form" method="get" action="{{route('admin.edit_kabupaten')}}"
        onsubmit="document.getElementById('edit_kabupaten').disabled=true;
        document.getElementById('edit_kabupaten').value='Sedang menyimpan...';">
          {{csrf_field()}}
    <div class="box-body">
      <div id="kabupaten2" class="form-group">
      <label for="nama_kabupaten2">Nama Kabupaten</label>
      <input type="hidden" name="edit_id_prov" id="edit_id_prov" value="{{$id_provinsi}}">
      <input type="hidden" name="edit_id_kab" id="edit_id_kab" value="">
      <input type="text" required class="form-control" name="nama_kabupaten2" id="nama_kabupaten2" value="" placeholder="Kabupaten">
      <label hidden id="label_nama_kabupaten2" class="control-label">Kabupaten harus diisi!</label>
      </div>
    </div>
    <!-- /.box-body -->

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
        <input type="submit" id="edit_kabupaten" class="btn btn-primary" value="Simpan">
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

var v_nama_kabupaten2=0;

  $('#kabupaten2').on('input', function() {
    nama_kabupaten2 = $('#nama_kabupaten2').val();
    if(nama_kabupaten2!=""){
      $('#kabupaten2').attr("class", "form-group has-success");
      $('#label_nama_kabupaten2').hide();
      v_nama_kabupaten2=1;
      // console.log(v_nama_kabupaten2);
    }
    else {
      v_nama_kabupaten2=0;
     $('#label_nama_kabupaten2').show();
      $('#kabupaten2').attr("class", "form-group has-error");
      // console.log(v_nama_kabupaten2);
    }
  });

  $('#edit_kabupaten').on('show.bs.modal', function(event){
     var button = $(event.relatedTarget);
     var nm_kabupaten = button.data('nm_kabupaten');

     $.ajax({
         type: 'post',
         url: '{{route("admin.json_kabupaten")}}',
         data: {
           '_token': $('input[name=_token]').val(),
           'id': nm_kabupaten,
         },
         success: function (data) {
           if (data.length > 0) {
           $.each(data, function (key, value) {
             $('#edit_id_kab').val(value['id']);
             $('#nama_kabupaten2').val(value['nama_kabupaten']);
           });
         }
         else{
           $('#edit_id_kab').val("");
           $('#nama_kabupaten2').val("");
         }
       }
       });
  });

});
</script>
