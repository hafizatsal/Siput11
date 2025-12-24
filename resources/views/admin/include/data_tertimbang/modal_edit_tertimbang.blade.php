<div class="modal fade" id="edit_tertimbang">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Edit Nilai Tertimbag</h4>
      </div>
      <div class="modal-body">
        <form role="form" method="post" action="{{route('admin.edit_tertimbang')}}">
          {{csrf_field()}}
    <div class="box-body">
      <div id="nilai_tertimbang2" class="form-group">
      <label for="nama_nilai_tertimbang2">Nama Nilai Tertimbang</label>
      <input type="hidden" class="form-control" name="id_tertimbang2" id="id_tertimbang2" value="">
      <input type="text" required class="form-control" name="nama_nilai_tertimbang2" id="nama_nilai_tertimbang2" value="">
      <label hidden id="label_nama_nilai_tertimbang2" class="control-label">Nilai tertimbang harus diisi!</label>
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

var v_nama_nilai_tertimbang2=0;

  $('#nilai_tertimbang2').on('input', function() {
    nama_nilai_tertimbang2 = $('#nama_nilai_tertimbang2').val();
   console.log(nama_nilai_tertimbang2);
    if(nama_nilai_tertimbang2!=""){
      $('#nilai_tertimbang2').attr("class", "form-group has-success");
      $('#label_nama_nilai_tertimbang2').hide();
      v_nama_nilai_tertimbang2=1;
      // console.log(v_nama_nilai_tertimbang2);
    }
    else {
      v_nama_nilai_tertimbang2=0;
     $('#label_nama_nilai_tertimbang2').show();
      $('#nilai_tertimbang2').attr("class", "form-group has-error");
      // console.log(v_nama_nilai_tertimbang2);
    }
  });

  $('#edit_tertimbang').on('show.bs.modal', function(event){
    console.log(event);
     var button = $(event.relatedTarget);
     var nm_tertimbang = button.data('nm_tertimbang');
   $.get('json-tertimbang?id_tertimbang=' + nm_tertimbang, function(data){
     $.each(data, function(index, tertimbangObj){
       $('#id_tertimbang2').val(tertimbangObj.id_master_tertimbang);
       $('#nama_nilai_tertimbang2').val(tertimbangObj.nama);
      });
    });
  });

});
</script>

