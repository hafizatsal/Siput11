<div class="modal fade" id="edit_fauna">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Edit Fauna</h4>
      </div>
      <div class="modal-body">
        <form role="form" method="post" action="{{route('admin.edit_fauna')}}"
        onsubmit="document.getElementById('edit_fauna').disabled=true;
        document.getElementById('edit_fauna').value='Sedang menyimpan...';">
          {{csrf_field()}}
    <div class="box-body">
      <div id="fauna2" class="form-group">
      <label for="nama_fauna2">Nama Fauna</label>
      <input type="hidden" class="form-control" name="id_fauna2" id="id_fauna2" value="">
      <input type="text" required class="form-control" name="nama_fauna2" id="nama_fauna2" value="" placeholder="Nama Fauna">
      <label hidden id="label_nama_fauna2" class="control-label">Nama fauna harus diisi!</label>
      </div>

      <div id="latin_fauna2" class="form-group">
      <label for="nama_latin_fauna2">Nama Latin Fauna</label>
      <input type="text" required class="form-control" name="nama_latin_fauna2" id="nama_latin_fauna2" value="" placeholder="Nama Latin Fauna">
      <label hidden id="label_nama_latin_fauna2" class="control-label">Nama latin fauna harus diisi!</label>
      </div>

    </div>
    <!-- /.box-body -->

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
        <input type="submit" id="edit_fauna" class="btn btn-primary" value="Simpan">
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

var v_nama_fauna2=0;
var v_nama_latin_fauna2=0;

  $('#fauna2').on('input', function() {
    nama_fauna2 = $('#nama_fauna2').val();
    if(nama_fauna2!=""){
      $('#fauna2').attr("class", "form-group has-success");
      $('#label_nama_fauna2').hide();
      v_nama_fauna2=1;
    }
    else {
      v_nama_fauna2=0;
     $('#label_nama_fauna2').show();
      $('#fauna2').attr("class", "form-group has-error");
    }
  });


  $('#latin_fauna2').on('input', function() {
    nama_latin_fauna2 = $('#nama_latin_fauna2').val();
    if(nama_latin_fauna2!=""){
      $('#latin_fauna2').attr("class", "form-group has-success");
      $('#label_nama_latin_fauna2').hide();
      v_nama_latin_fauna2=1;
    }
    else {
      v_nama_latin_fauna2=0;
     $('#label_nama_latin_fauna2').show();
      $('#latin_fauna2').attr("class", "form-group has-error");
    }
  });

  $('#edit_fauna').on('show.bs.modal', function(event){
    var button = $(event.relatedTarget);
    var id_fauna = button.data('id_fauna');
    $.ajax({
        type: 'post',
        url: '{{route("admin.json_fauna")}}',
        data: {
          '_token': $('input[name=_token]').val(),
          'id': id_fauna,
        },
        success: function (data) {
          if (data.length > 0) {
          $.each(data, function (key, value) {
            $('#id_fauna2').val(value['id_jenis_fauna']);
            $('#nama_fauna2').val(value['nama_fauna']);
            $('#nama_latin_fauna2').val(value['nama_latin_fauna']);
            $('#kategori_fauna2').val(value['kategori']);
          });
        }
        else{
          $('#id_fauna2').val("");
          $('#nama_fauna2').val("");
          $('#nama_latin_fauna2').val("");
          $('#kategori_fauna2').val("");
        }
      }
      });

  });

});
</script>

