<div class="modal fade" id="edit_kecamatan">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Edit Kecamatan</h4>
      </div>
      <div class="modal-body">
        <form role="form" method="get" action="{{route('admin.edit_kecamatan')}}"
        onsubmit="document.getElementById('edit_kecamatan').disabled=true;
        document.getElementById('edit_kecamatan').value='Sedang menyimpan...';">
          {{csrf_field()}}
    <div class="box-body">
      <div id="kecamatan2" class="form-group">
      <label for="nama_kecamatan2">Nama Kecamatan</label>
      <input type="hidden" name="edit_id_kab" id="edit_id_kab" value="{{$id_kabupaten}}">
      <input type="hidden" name="edit_id_kec" id="edit_id_kec" value="">
      <input type="text" required class="form-control" name="nama_kecamatan2" id="nama_kecamatan2" value="" placeholder="Kecamatan">
      <label hidden id="label_nama_kecamatan2" class="control-label">Kecamatan harus diisi!</label>
      </div>
    </div>
    <!-- /.box-body -->

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
        <input type="submit" id="edit_kecamatan" class="btn btn-primary" value="Simpan">
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

var v_nama_kecamatan2=0;

  $('#kecamatan2').on('input', function() {
    nama_kecamatan2 = $('#nama_kecamatan2').val();
    if(nama_kecamatan2!=""){
      $('#kecamatan2').attr("class", "form-group has-success");
      $('#label_nama_kecamatan2').hide();
      v_nama_kecamatan2=1;
      // console.log(v_nama_kecamatan2);
    }
    else {
      v_nama_kecamatan2=0;
     $('#label_nama_kecamatan2').show();
      $('#kecamatan2').attr("class", "form-group has-error");
      // console.log(v_nama_kecamatan2);
    }
  });

  $('#edit_kecamatan').on('show.bs.modal', function(event){
     var button = $(event.relatedTarget);
     var nm_kecamatan = button.data('nm_kecamatan');

     $.ajax({
         type: 'post',
         url: '{{route("admin.json_kecamatan")}}',
         data: {
           '_token': $('input[name=_token]').val(),
           'id': nm_kecamatan,
         },
         success: function (data) {
           if (data.length > 0) {
           $.each(data, function (key, value) {
             $('#edit_id_kec').val(value['id']);
             $('#nama_kecamatan2').val(value['nama_kecamatan']);
           });
         }
         else{
           $('#edit_id_kec').val("");
           $('#nama_kecamatan2').val("");
         }
       }
       });
  });

});
</script>
