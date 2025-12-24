<div class="modal fade" id="tambah_hak">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Tambah Hak</h4>
      </div>
      <div class="modal-body">
        <form role="form" method="post" action="{{route('admin.hmjf.insert')}}"
        onsubmit="document.getElementById('submit_hak').disabled=true;
        document.getElementById('submit_hak').value='Sedang menyimpan...';">
          {{csrf_field()}}
    <div class="box-body">
      <div id="hak_milik" class="form-group">
      <label for="nama_hak_milik">Nama Hak Milik</label>
      <input type="text" required class="form-control" name="nama_hak_milik" id="nama_hak_milik" value="" placeholder="Nama Hak">
      <label hidden id="label_nama_hak_milik" class="control-label">Hak milik harus diisi!</label>
      </div>
    </div>
    <!-- /.box-body -->

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
        <input type="submit" id="submit_hak" class="btn btn-primary" value="Simpan">
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

var v_nama_hak_milik=0;

  $('#hak_milik').on('input', function() {
    nama_hak_milik = $('#nama_hak_milik').val();
    if(nama_hak_milik!=""){
      $('#hak_milik').attr("class", "form-group has-success");
      $('#label_nama_hak_milik').hide();
      v_nama_hak_milik=1;
      // console.log(v_nama_hak_milik);
    }
    else {
      v_nama_hak_milik=0;
     $('#label_nama_hak_milik').show();
      $('#hak_milik').attr("class", "form-group has-error");
      // console.log(v_nama_hak_milik);
    }
  });

});
</script>

