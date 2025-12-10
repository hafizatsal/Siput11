<div class="modal fade" id="tambah_tertimbang">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Tambah Nilai Tertimbag</h4>
      </div>
      <div class="modal-body">
        <form role="form" method="get" action="tertimbang/insert">
          {{csrf_field()}}
    <div class="box-body">
      <div id="nilai_tertimbang" class="form-group">
      <label for="nama_nilai_tertimbang">Nama Nilai Tertimbang</label>
      <input type="text" required class="form-control" name="nama_nilai_tertimbang" id="nama_nilai_tertimbang" value="">
      <label hidden id="label_nama_nilai_tertimbang" class="control-label">Nilai tertimbang harus diisi!</label>
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

var v_nama_nilai_tertimbang=0;

  $('#nilai_tertimbang').on('input', function() {
    nama_nilai_tertimbang = $('#nama_nilai_tertimbang').val();
   console.log(nama_nilai_tertimbang);
    if(nama_nilai_tertimbang!=""){
      $('#nilai_tertimbang').attr("class", "form-group has-success");
      $('#label_nama_nilai_tertimbang').hide();
      v_nama_nilai_tertimbang=1;
      // console.log(v_nama_nilai_tertimbang);
    }
    else {
      v_nama_nilai_tertimbang=0;
     $('#label_nama_nilai_tertimbang').show();
      $('#nilai_tertimbang').attr("class", "form-group has-error");
      // console.log(v_nama_nilai_tertimbang);
    }
  });

});
</script>
