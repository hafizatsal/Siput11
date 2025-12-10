<div class="modal fade" id="edit_fungsi">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Edit Fungsi</h4>
      </div>
      <div class="modal-body">
        <form role="form" method="get" action="{{route('admin.edit_fungsi')}}"
        onsubmit="document.getElementById('edit_fungsi').disabled=true;
        document.getElementById('edit_fungsi').value='Sedang menyimpan...';">
          {{csrf_field()}}
    <div class="box-body">
      <div id="fungsi_hutan2" class="form-group">
      <label for="nama_fungsi_hutan2">Nama Fungsi Hutan</label>
      <input type="hidden" class="form-control" name="id_fungsi_hutan2" id="id_fungsi_hutan2" value="">
      <input type="text" required class="form-control" name="nama_fungsi_hutan2" id="nama_fungsi_hutan2" value="" placeholder="Nama Fungsi">
      <label hidden id="label_nama_fungsi_hutan2" class="control-label">Fungsi hutan harus diisi!</label>
      </div>
    </div>
    <!-- /.box-body -->

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
        <input type="submit" id="edit_fungsi" class="btn btn-primary" value="Simpan">
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

var v_nama_fungsi_hutan2=0;

  $('#fungsi_hutan2').on('input', function() {
    nama_fungsi_hutan2 = $('#nama_fungsi_hutan2').val();
    if(nama_fungsi_hutan2!=""){
      $('#fungsi_hutan2').attr("class", "form-group has-success");
      $('#label_nama_fungsi_hutan2').hide();
      v_nama_fungsi_hutan2=1;
      // console.log(v_nama_fungsi_hutan2);
    }
    else {
      v_nama_fungsi_hutan2=0;
     $('#label_nama_fungsi_hutan2').show();
      $('#fungsi_hutan2').attr("class", "form-group has-error");
      // console.log(v_nama_fungsi_hutan2);
    }
  });

  $('#edit_fungsi').on('show.bs.modal', function(event){
     var button = $(event.relatedTarget);
     var nm_fungsi = button.data('nm_fungsi');

     $.ajax({
         type: 'post',
         url: '{{route("admin.json_fungsi")}}',
         data: {
           '_token': $('input[name=_token]').val(),
           'id': nm_fungsi,
         },
         success: function (data) {
           if (data.length > 0) {
           $.each(data, function (key, value) {
             $('#id_fungsi_hutan2').val(value['id_fungsi_hutan']);
             $('#nama_fungsi_hutan2').val(value['fungsi']);
           });
         }
         else{
           $('#id_fungsi_hutan2').val("");
           $('#nama_fungsi_hutan2').val("");
         }
       }
       });
  });

});
</script>
