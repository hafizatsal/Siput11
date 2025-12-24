<div class="modal fade" id="tambah_pohon">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Tambah Pohon</h4>
      </div>
      <div class="modal-body">
        <form role="form" method="post" action="{{route('admin.pohon.insert')}}"
        onsubmit="document.getElementById('submit_pohon').disabled=true;
        document.getElementById('submit_pohon').value='Sedang menyimpan...';">
          {{csrf_field()}}
    <div class="box-body">
      <div id="pohon" class="form-group">
      <label for="nama_pohon">Nama Pohon</label>
      <input type="text" required class="form-control" name="nama_pohon" id="nama_pohon" value="">
      <label hidden id="label_nama_pohon" class="control-label">Nama pohon harus diisi!</label>
      </div>

      <div id="latin_pohon" class="form-group">
      <label for="nama_latin_pohon">Nama Latin Pohon</label>
      <input type="text" required class="form-control" name="nama_latin_pohon" id="nama_latin_pohon" value="">
      <label hidden id="label_nama_latin_pohon" class="control-label">Nama latin pohon harus diisi!</label>
      </div>

    </div>
    <!-- /.box-body -->

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
        <input type="submit" id="submit_pohon" class="btn btn-primary" value="Simpan">
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

var v_nama_pohon=0;
var v_nama_latin_pohon=0;

  $('#pohon').on('input', function() {
    nama_pohon = $('#nama_pohon').val();
    if(nama_pohon!=""){
      $('#pohon').attr("class", "form-group has-success");
      $('#label_nama_pohon').hide();
      v_nama_pohon=1;
      // console.log(v_nama_pohon);
    }
    else {
      v_nama_pohon=0;
     $('#label_nama_pohon').show();
      $('#pohon').attr("class", "form-group has-error");
      // console.log(v_nama_pohon);
    }
  });


  $('#latin_pohon').on('input', function() {
    nama_latin_pohon = $('#nama_latin_pohon').val();
    if(nama_latin_pohon!=""){
      $('#latin_pohon').attr("class", "form-group has-success");
      $('#label_nama_latin_pohon').hide();
      v_nama_latin_pohon=1;
      // console.log(v_nama_latin_pohon);
    }
    else {
      v_nama_latin_pohon=0;
     $('#label_nama_latin_pohon').show();
      $('#latin_pohon').attr("class", "form-group has-error");
      // console.log(v_nama_latin_pohon);
    }
  });

});
</script>

