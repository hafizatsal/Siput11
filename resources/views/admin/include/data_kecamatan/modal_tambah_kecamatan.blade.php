<div class="modal fade" id="tambah_kecamatan">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Tambah Kecamatan</h4>
      </div>
      <div class="modal-body">
        <form role="form" method="get" action="{{route('admin.kecamatan.insert')}}"
        onsubmit="document.getElementById('submit_kecamatan').disabled=true;
        document.getElementById('submit_kecamatan').value='Sedang menyimpan...';">
          {{csrf_field()}}
    <div class="box-body">
      <div id="kecamatan" class="form-group">
      <label for="nama_kecamatan">Nama Kecamatan</label>
      <input type="hidden" name="id_kabupaten" id="id_kabupaten" value="{{$id_kabupaten}}">
      <input type="text" required class="form-control" name="nama_kecamatan" id="nama_kecamatan" value="" placeholder="Kecamatan">
      <label hidden id="label_nama_kecamatan" class="control-label">Kecamatan harus diisi!</label>
      </div>
    </div>
    <!-- /.box-body -->

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
        <input type="submit" id="submit_kecamatan" class="btn btn-primary" value="Simpan">
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

var v_nama_kecamatan=0;

  $('#kecamatan').on('input', function() {
    nama_kecamatan = $('#nama_kecamatan').val();
    if(nama_kecamatan!=""){
      $('#kecamatan').attr("class", "form-group has-success");
      $('#label_nama_kecamatan').hide();
      v_nama_kecamatan=1;
      // console.log(v_nama_kecamatan);
    }
    else {
      v_nama_kecamatan=0;
     $('#label_nama_kecamatan').show();
      $('#kecamatan').attr("class", "form-group has-error");
      // console.log(v_nama_kecamatan);
    }
  });

});
</script>
