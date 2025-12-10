<div class="modal fade" id="tambah_kabupaten">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Tambah Kabupaten</h4>
      </div>
      <div class="modal-body">
        <form role="form" method="get" action="{{route('admin.kabupaten.insert')}}"
        onsubmit="document.getElementById('submit_kabupaten').disabled=true;
        document.getElementById('submit_kabupaten').value='Sedang menyimpan...';">
          {{csrf_field()}}
    <div class="box-body">
      <div id="kabupaten" class="form-group">
      <label for="nama_kabupaten">Nama Kabupaten</label>
      <input type="hidden" name="id_provinsi" id="id_provinsi" value="{{$id_provinsi}}">
      <input type="text" required class="form-control" name="nama_kabupaten" id="nama_kabupaten" value="" placeholder="Kabupaten">
      <label hidden id="label_nama_kabupaten" class="control-label">Kabupaten harus diisi!</label>
      </div>
    </div>
    <!-- /.box-body -->

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
        <input type="submit" id="submit_kabupaten" class="btn btn-primary" value="Simpan">
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

var v_nama_kabupaten=0;

  $('#kabupaten').on('input', function() {
    nama_kabupaten = $('#nama_kabupaten').val();
    if(nama_kabupaten!=""){
      $('#kabupaten').attr("class", "form-group has-success");
      $('#label_nama_kabupaten').hide();
      v_nama_kabupaten=1;
      // console.log(v_nama_kabupaten);
    }
    else {
      v_nama_kabupaten=0;
     $('#label_nama_kabupaten').show();
      $('#kabupaten').attr("class", "form-group has-error");
      // console.log(v_nama_kabupaten);
    }
  });

});
</script>
