<div class="modal fade" id="tambah_fungsi">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Tambah Fungsi</h4>
      </div>
      <div class="modal-body">
        <form role="form" method="post" action="{{route('admin.fungsi.insert')}}"
        onsubmit="document.getElementById('submit_fungsi').disabled=true;
        document.getElementById('submit_fungsi').value='Sedang menyimpan...';">
          {{csrf_field()}}
    <div class="box-body">
      <div id="fungsi_hutan" class="form-group">
      <label for="nama_fungsi_hutan">Nama Fungsi Hutan</label>
      <input type="text" required class="form-control" name="nama_fungsi_hutan" id="nama_fungsi_hutan" value="" placeholder="Nama Fungsi">
      <label hidden id="label_nama_fungsi_hutan" class="control-label">Fungsi hutan harus diisi!</label>
      </div>
    </div>
    <!-- /.box-body -->

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
        <input type="submit" id="submit_fungsi" class="btn btn-primary" value="Simpan">
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

var v_nama_fungsi_hutan=0;

  $('#fungsi_hutan').on('input', function() {
    nama_fungsi_hutan = $('#nama_fungsi_hutan').val();
    if(nama_fungsi_hutan!=""){
      $('#fungsi_hutan').attr("class", "form-group has-success");
      $('#label_nama_fungsi_hutan').hide();
      v_nama_fungsi_hutan=1;
      // console.log(v_nama_fungsi_hutan);
    }
    else {
      v_nama_fungsi_hutan=0;
     $('#label_nama_fungsi_hutan').show();
      $('#fungsi_hutan').attr("class", "form-group has-error");
      // console.log(v_nama_fungsi_hutan);
    }
  });

});
</script>

