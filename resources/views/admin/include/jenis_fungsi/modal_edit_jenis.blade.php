<div class="modal fade" id="edit_jenis">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Edit Jenis</h4>
      </div>
      <div class="modal-body">
        <form role="form" method="get" action="">
          {{csrf_field()}}
    <div class="box-body">
      <div id="jenis_hutan2" class="form-group">
      <label for="nama_jenis_hutan2">Nama Jenis Hutan</label>
      <input type="text" required class="form-control" name="nama_jenis_hutan2" id="nama_jenis_hutan2" value="">
      <label hidden id="label_nama_jenis_hutan2" class="control-label">Jenis hutan harus diisi!</label>
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

var v_nama_jenis_hutan2=0;

  $('#jenis_hutan2').on('input', function() {
    nama_jenis_hutan2 = $('#nama_jenis_hutan2').val();
   console.log(nama_jenis_hutan2);
    if(nama_jenis_hutan2!=""){
      $('#jenis_hutan2').attr("class", "form-group has-success");
      $('#label_nama_jenis_hutan2').hide();
      v_nama_jenis_hutan2=1;
      // console.log(v_nama_jenis_hutan2);
    }
    else {
      v_nama_jenis_hutan2=0;
     $('#label_nama_jenis_hutan2').show();
      $('#jenis_hutan2').attr("class", "form-group has-error");
      // console.log(v_nama_jenis_hutan2);
    }
  });

});
</script>
