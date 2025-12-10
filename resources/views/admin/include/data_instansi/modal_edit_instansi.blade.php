<div class="modal fade" id="edit_instansi">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Edit Instansi</h4>
      </div>
      <div class="modal-body">
        <form role="form" method="get" action="{{route('admin.edit_instansi')}}"
        onsubmit="document.getElementById('edit_instansi').disabled=true;
        document.getElementById('edit_instansi').value='Sedang menyimpan...';">
          {{csrf_field()}}
    <div class="box-body">
      <div id="instansi2" class="form-group">
      <label for="nama_instansi2">Nama Instansi</label>
      <input type="hidden" class="form-control" name="id_instansi2" id="id_instansi2" value="">
      <input type="text" class="form-control" required name="nama_instansi2" id="nama_instansi2" value="" placeholder="Nama Instansi">
      <label hidden id="label_nama_instansi2" class="control-label">Nama instansi2 harus diisi!</label>
      </div>

    </div>
    <!-- /.box-body -->

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
        <input type="submit" id="edit_instansi" class="btn btn-primary" value="Simpan">
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

var v_nama_instansi2=0;

  $('#instansi2').on('input', function() {
    nama_instansi2 = $('#nama_instansi2').val();
    if(nama_instansi2!=""){
      $('#instansi2').attr("class", "form-group has-success");
      $('#label_nama_instansi2').hide();
      v_nama_instansi2=1;
      // console.log(v_nama_instansi2);
    }
    else {
      v_nama_instansi2=0;
     $('#label_nama_instansi2').show();
      $('#instansi2').attr("class", "form-group has-error");
      // console.log(v_nama_instansi2);
    }
  });

  $('#edit_instansi').on('show.bs.modal', function(event){
     var button = $(event.relatedTarget);
     var nm_instansi = button.data('id_instansi');

     $.ajax({
         type: 'post',
         url: '{{route("admin.json_instansi")}}',
         data: {
           '_token': $('input[name=_token]').val(),
           'id': nm_instansi,
         },
         success: function (data) {
           if (data.length > 0) {
           $.each(data, function (key, value) {
             $('#id_instansi2').val(value['id']);
             $('#nama_instansi2').val(value['nama_instansi']);
           });
         }
         else{
           $('#id_instansi2').val("");
           $('#nama_instansi2').val("");
         }
       }
       });
  });

});
</script>
