<div class="modal fade" id="tambah_fauna">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Tambah Fauna</h4>
      </div>
      <div class="modal-body">
        <form role="form" method="post" action="{{route('admin.fauna.insert')}}"
        onsubmit="document.getElementById('submit_fauna').disabled=true;
        document.getElementById('submit_fauna').value='Sedang menyimpan...';">
          {{csrf_field()}}
    <div class="box-body">
      <div id="fauna" class="form-group">
      <label for="nama_fauna">Nama Fauna</label>
      <input type="text" required class="form-control" name="nama_fauna" id="nama_fauna" value="" placeholder="Nama Fauna">
      <label hidden id="label_nama_fauna" class="control-label">Nama fauna harus diisi!</label>
      </div>

      <div id="latin_fauna" class="form-group">
      <label for="nama_latin_fauna">Nama Latin Fauna</label>
      <input type="text" required class="form-control" name="nama_latin_fauna" id="nama_latin_fauna" value="" placeholder="Nama Latin Fauna">
      <label hidden id="label_nama_latin_fauna" class="control-label">Nama latin fauna harus diisi!</label>
      </div>

    </div>
    <!-- /.box-body -->

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
        <input type="submit" id="submit_fauna" class="btn btn-primary" value="Simpan">
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

var v_nama_fauna=0;
var v_nama_latin_fauna=0;

  $('#fauna').on('input', function() {
    nama_fauna = $('#nama_fauna').val();
    if(nama_fauna!=""){
      $('#fauna').attr("class", "form-group has-success");
      $('#label_nama_fauna').hide();
      v_nama_fauna=1;
      // console.log(v_nama_fauna);
    }
    else {
      v_nama_fauna=0;
     $('#label_nama_fauna').show();
      $('#fauna').attr("class", "form-group has-error");
      // console.log(v_nama_fauna);
    }
  });


  $('#latin_fauna').on('input', function() {
    nama_latin_fauna = $('#nama_latin_fauna').val();
    if(nama_latin_fauna!=""){
      $('#latin_fauna').attr("class", "form-group has-success");
      $('#label_nama_latin_fauna').hide();
      v_nama_latin_fauna=1;
      // console.log(v_nama_latin_fauna);
    }
    else {
      v_nama_latin_fauna=0;
     $('#label_nama_latin_fauna').show();
      $('#latin_fauna').attr("class", "form-group has-error");
      // console.log(v_nama_latin_fauna);
    }
  });

});
</script>

