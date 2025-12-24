<div class="modal fade" id="edit_pohon">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Edit Pohon</h4>
      </div>
      <div class="modal-body">
        <form role="form" method="post" action="{{route('admin.edit_pohon')}}"
        onsubmit="document.getElementById('edit_pohon').disabled=true;
        document.getElementById('edit_pohon').value='Sedang menyimpan...';">
          {{csrf_field()}}
    <div class="box-body">
      <div id="pohon2" class="form-group">
      <label for="nama_pohon2">Nama Pohon</label>
      <input type="hidden" class="form-control" name="id_pohon2" id="id_pohon2" value="">
      <input type="text" required class="form-control" name="nama_pohon2" id="nama_pohon2" value="" placeholder="Nama Pohon">
      <label hidden id="label_nama_pohon2" class="control-label">Nama pohon2 harus diisi!</label>
      </div>

      <div id="latin_pohon2" class="form-group">
      <label for="nama_latin_pohon2">Nama Latin Pohon</label>
      <input type="text" required class="form-control" name="nama_latin_pohon2" id="nama_latin_pohon2" value="" placeholder="Nama Latin Pohon">
      <label hidden id="label_nama_latin_pohon2" class="control-label">Nama latin pohon2 harus diisi!</label>
      </div>

    </div>
    <!-- /.box-body -->

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
        <input type="submit" id="edit_pohon" class="btn btn-primary" value="Simpan">
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

var v_nama_pohon2=0;
var v_nama_latin_pohon2=0;

  $('#pohon2').on('input', function() {
    nama_pohon2 = $('#nama_pohon2').val();
    if(nama_pohon2!=""){
      $('#pohon2').attr("class", "form-group has-success");
      $('#label_nama_pohon2').hide();
      v_nama_pohon2=1;
      // console.log(v_nama_pohon2);
    }
    else {
      v_nama_pohon2=0;
     $('#label_nama_pohon2').show();
      $('#pohon2').attr("class", "form-group has-error");
      // console.log(v_nama_pohon2);
    }
  });


  $('#latin_pohon2').on('input', function() {
    nama_latin_pohon2 = $('#nama_latin_pohon2').val();
    if(nama_latin_pohon2!=""){
      $('#latin_pohon2').attr("class", "form-group has-success");
      $('#label_nama_latin_pohon2').hide();
      v_nama_latin_pohon2=1;
      // console.log(v_nama_latin_pohon2);
    }
    else {
      v_nama_latin_pohon2=0;
     $('#label_nama_latin_pohon2').show();
      $('#latin_pohon2').attr("class", "form-group has-error");
      // console.log(v_nama_latin_pohon2);
    }
  });

  $('#edit_pohon').on('show.bs.modal', function(event){
     var button = $(event.relatedTarget);
     var nm_pohon = button.data('nm_pohon');

     $.ajax({
         type: 'post',
         url: '{{route("admin.json_pohon")}}',
         data: {
           '_token': $('input[name=_token]').val(),
           'id': nm_pohon,
         },
         success: function (data) {
           if (data.length > 0) {
           $.each(data, function (key, value) {
             $('#id_pohon2').val(value['id_jenis_tanaman']);
             $('#nama_pohon2').val(value['nama_tanaman']);
             $('#nama_latin_pohon2').val(value['nama_latin']);
           });
         }
         else{
           $('#id_pohon2').val("");
           $('#nama_pohon2').val("");
           $('#nama_latin_pohon2').val("");
         }
       }
       });
  });

});
</script>

