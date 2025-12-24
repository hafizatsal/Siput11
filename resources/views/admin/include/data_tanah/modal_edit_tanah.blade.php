<div class="modal fade" id="edit_tanah">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Edit Sifat Tanah</h4>
      </div>
      <div class="modal-body">
        <form role="form" method="post" action="{{route('admin.edit_tanah')}}"
        onsubmit="document.getElementById('edit_tanah').disabled=true;
        document.getElementById('edit_tanah').value='Sedang menyimpan...';">
          {{csrf_field()}}
    <div class="box-body">
      <div id="indikator_tanah2" class="form-group">
      <label for="nama_indikator_tanah2">Sifat Tanah</label>
      <input type="hidden" class="form-control" name="id_tanah2" id="id_tanah2" value="">
      <input type="text" required class="form-control" name="nama_indikator_tanah2" id="nama_indikator_tanah2" value="" placeholder="Sifat Tanah">
      <label hidden id="label_nama_indikator_tanah2" class="control-label">Sifat tanah harus diisi!</label>
      </div>
    </div>
    <!-- /.box-body -->

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
        <input type="submit" id="edit_tanah" class="btn btn-primary" value="Simpan">
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

var v_nama_indikator_tanah2=0;

  $('#indikator_tanah2').on('input', function() {
    nama_indikator_tanah2 = $('#nama_indikator_tanah2').val();
    if(nama_indikator_tanah2!=""){
      $('#indikator_tanah2').attr("class", "form-group has-success");
      $('#label_nama_indikator_tanah2').hide();
      v_nama_indikator_tanah2=1;
      // console.log(v_nama_indikator_tanah2);
    }
    else {
      v_nama_indikator_tanah2=0;
     $('#label_nama_indikator_tanah2').show();
      $('#indikator_tanah2').attr("class", "form-group has-error");
      // console.log(v_nama_indikator_tanah2);
    }
  });

  $('#edit_tanah').on('show.bs.modal', function(event){
     var button = $(event.relatedTarget);
     var nm_tanah = button.data('nm_tanah');

     $.ajax({
         type: 'post',
         url: '{{route("admin.json_tanah")}}',
         data: {
           '_token': $('input[name=_token]').val(),
           'id': nm_tanah,
         },
         success: function (data) {
           if (data.length > 0) {
           $.each(data, function (key, value) {
             $('#id_tanah2').val(value['id_parameter_kimia']);
             $('#nama_indikator_tanah2').val(value['sifat_kimia']);
           });
         }
         else{
           $('#id_tanah2').val("");
           $('#nama_indikator_tanah2').val("");
         }
       }
       });
  });

});
</script>

