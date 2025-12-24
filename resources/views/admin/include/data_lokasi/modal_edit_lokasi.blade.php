<div class="modal fade" id="edit_lokasi">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Edit Lokasi</h4>
      </div>
      <div class="modal-body">
        <form role="form" method="post" action="{{route('admin.edit_lokasi')}}"
        onsubmit="document.getElementById('edit_kabupaten').disabled=true;
        document.getElementById('edit_kabupaten').value='Sedang menyimpan...';">
          {{csrf_field()}}
    <div class="box-body">
      <div id="lokasi2" class="form-group">
      <label for="nama_lokasi2">Nama Lokasi</label>
      <input type="hidden" name="id_lokasi2" id="id_lokasi2" value="">
      <input type="text" required class="form-control" name="nama_lokasi2" id="nama_lokasi2" value="" placeholder="Provinsi">
      <label hidden id="label_nama_lokasi2" class="control-label">Lokasi harus diisi!</label>
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

var v_nama_lokasi2=0;

  $('#lokasi2').on('input', function() {
    nama_lokasi2 = $('#nama_lokasi2').val();
    if(nama_lokasi2!=""){
      $('#lokasi2').attr("class", "form-group has-success");
      $('#label_nama_lokasi2').hide();
      v_nama_lokasi2=1;
      // console.log(v_nama_lokasi2);
    }
    else {
      v_nama_lokasi2=0;
     $('#label_nama_lokasi2').show();
      $('#lokasi2').attr("class", "form-group has-error");
      // console.log(v_nama_lokasi2);
    }
  });

  $('#edit_lokasi').on('show.bs.modal', function(event){
     var button = $(event.relatedTarget);
     var nm_lokasi = button.data('nm_lokasi');

     $.ajax({
         type: 'post',
         url: '{{route("admin.json_lokasi")}}',
         data: {
           '_token': $('input[name=_token]').val(),
           'id': nm_lokasi,
         },
         success: function (data) {
           if (data.length > 0) {
           $.each(data, function (key, value) {
             $('#id_lokasi2').val(value['id_provinsi']);
             $('#nama_lokasi2').val(value['nama_provinsi']);
           });
         }
         else{
           $('#id_lokasi2').val("");
           $('#nama_lokasi2').val("");
         }
       }
       });
  });

});
</script>

