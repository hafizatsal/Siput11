@section('css')
<link rel="stylesheet" href="{{asset('Admin/bower_components/select2/dist/css/select2.min.css')}}">
@endsection
<div class="modal fade" id="modal_edit_kimia">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Edit Data Kualitas Tapak (Kimia)</h4>
      </div>
      <div class="modal-body">
        <form role="form" method="post" action="{{route('auditor.edit_kimia')}}"
        onsubmit="document.getElementById('submit_ktk2').disabled=true;
        document.getElementById('submit_ktk2').value='Sedang memperbarui...';">
          {{csrf_field()}}
          <div class="box-body">

            <div class="form-group">
              <label for="edit_kode_klaster">Kode Klaster</label>
              <input type="text" class="form-control" id="edit_kode_klaster" name="edit_kode_klaster" value="{{$kode_klaster->nama_klaster}}" readonly>
              <input type="hidden" id="id_ktk2" name="id_ktk2" value="">
              <input type="hidden" id="pengukurans_ke2" name="pengukurans_ke2" value="{{$pengukuran_ke}}">
            </div>

            <div id="edit-sifat" class="form-group">
              <label for="edit_sifat">Parameter Kimia</label>
              <select class="form-control" name="edit_sifat" id="edit_sifat" style="width:100%;">
                <option value="" selected="true">Pilih Parameter</option>
                @foreach($parameter_kimia as $kimia)
                <option value="{{$kimia->id_parameter_kimia}}">{{$kimia->sifat_kimia}}</option>
                @endforeach
              </select>
              <input type="hidden" class="form-control" name="id_plot_pohon2" id="id_plot_pohon2" value={{$id_plot}} required>
            </div>

            <div id="edit-cec" class="form-group">
              <label for="edit_cec">CEC (me/100 g)</label>
              <input type="text" class="form-control" id="edit_cec" name="edit_cec" value="">
            </div>

          </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
        <input type="submit" id="submit_ktk2" class="btn btn-primary" value="Simpan">
      </div>
          </form>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
@section('script_tambahan')
<script src="{{asset('Admin/bower_components/select2/dist/js/select2.full.min.js')}}"></script>
@endsection
<script type="text/javascript">
$(document).ready(function(){
  $('#edit_sifat').select2({
    placeholder:"Ubah Sifat"
  });
$('#modal_edit_kimia').on('show.bs.modal', function(event){
  var button = $(event.relatedTarget);
  var kimia = button.data('kimia');
  var cec = button.data('cec');
  var id_ktk = button.data('id_ktk');
  var modal = $(this)
  modal.find('#edit_sifat').val(kimia).trigger('change');
  $('#edit_cec').val(cec);
  $('#id_ktk2').val(id_ktk);

  var error_cec=1;

  $('#edit_cec').on('input', function () {
      edit_cec = $('#edit_cec').val();
      var angka = /^([0-9]{1,}(\.[0-9]{1,}){0,1})$/; //validasi angka
      if (edit_cec.match(angka) && edit_cec!=null) {
        $('#edit-cec').attr("class", "form-group has-success");
        error_cec=1;
      } else {
        $('#edit-cec').attr("class", "form-group has-error");
        error_cec=0;
      }
      if(error_cec == 1){
  		$('#submit_ktk2').prop("disabled",false);
  		}
  		else {
  		$('#submit_ktk2').prop("disabled",true);
  		}
  });

});

$('#modal_edit_kimia').on('hidden.bs.modal', function(event){
var error_cec=1;
$('#submit_ktk2').prop("disabled",false);
$('#edit_cec').val("");
$('#input-cec').attr("class", "form-group");
});
});
</script>
