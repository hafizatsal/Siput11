<div class="modal fade" id="tambah_jenis">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Tambah Jenis</h4>
      </div>
      <div class="modal-body">
        <form role="form" method="post" action="">
          {{csrf_field()}}
    <div class="box-body">
      <div id="jenis_hutan" class="form-group">
      <label for="nama_jenis_hutan">Nama Jenis Hutan</label>
      <input type="text" required class="form-control" name="nama_jenis_hutan" id="nama_jenis_hutan" value="">
      <label hidden id="label_nama_jenis_hutan" class="control-label">Jenis hutan harus diisi!</label>
      </div>
    </div>
    <!-- /.box-body -->

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save changes</button>
      </div>
        </form>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<script src="{{asset('Admin/modal_ajax.min.js')}}"></script>
<script src="{{asset('Admin/bower_components/jquery/src/jquery.js')}}"></script>
<script type="text/javascript">
$(document).ready(function(){

var v_nama_jenis_hutan=0;

  $('#jenis_hutan').on('input', function() {
    nama_jenis_hutan = $('#nama_jenis_hutan').val();
   console.log(nama_jenis_hutan);
    if(nama_jenis_hutan!=""){
      $('#jenis_hutan').attr("class", "form-group has-success");
      $('#label_nama_jenis_hutan').hide();
      v_nama_jenis_hutan=1;
      // console.log(v_nama_jenis_hutan);
    }
    else {
      v_nama_jenis_hutan=0;
     $('#label_nama_jenis_hutan').show();
      $('#jenis_hutan').attr("class", "form-group has-error");
      // console.log(v_nama_jenis_hutan);
    }
  });

});
</script>

