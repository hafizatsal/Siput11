@section('css')
<link rel="stylesheet" href="{{asset('Admin/bower_components/select2/dist/css/select2.min.css')}}">
@endsection
<div class="modal fade" id="modal_tambah_kimia">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Tambah Data Kualitas Tapak (Kimia)</h4>
      </div>
      <div class="modal-body">
        <form role="form" method="post" action="{{route('auditor.tambah_kimia')}}"
        onsubmit="document.getElementById('submit_ktk').disabled=true;
        document.getElementById('submit_ktk').value='Sedang menyimpan...';">
          {{csrf_field()}}
          <div class="box-body">

            <div class="form-group">
              <label for="tambah_kode_klaster">Kode Klaster</label>
              <input type="text" class="form-control" id="tambah_kode_klaster" name="tambah_kode_klaster" value="{{$kode_klaster->nama_klaster}}" readonly>
              <input type="hidden" id="id_klasters_plot" name="id_klasters_plot" value="{{$id_klaster}}">
              <input type="hidden" id="pengukurans_ke" name="pengukurans_ke" value="{{$pengukuran_ke}}">
            </div>

            <div id="input-sifat" class="form-group">
              <label for="tambah_sifat">Parameter Kimia *</label>
              <select class="form-control" name="tambah_sifat" id="tambah_sifat" style="width: 100%;">
                <option value="" selected="true">Pilih Parameter</option>
                @foreach($parameter_kimia as $kimia)
                <option value="{{$kimia->id_parameter_kimia}}">{{$kimia->sifat_kimia}}</option>
                @endforeach
              </select>
              <input type="hidden" class="form-control" name="id_plot_pohon" id="id_plot_pohon" value={{$id_plot}} required>
            </div>

            <div id="input-cec" class="form-group">
              <label for="tambah_cec">CEC (me/100 g) *</label>
              <input type="text" class="form-control" id="tambah_cec" name="tambah_cec" value="">
            </div>

          </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
        <input disabled type="submit" id="submit_ktk" class="btn btn-primary" value="Simpan">
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
  $('#tambah_sifat').select2({
    placeholder:"Tambah Sifat"
  });

$('#modal_tambah_kimia').on('show.bs.modal', function(event){

  var error_sifat =0;
  var error_cec =0;

  $('#tambah_sifat').on('change', function () {
      tambah_sifat = $('#tambah_sifat').val();
      if (tambah_sifat!=null) {
        $('#input-sifat').attr("class", "form-group has-success");
        error_sifat=1;
      } else {
        $('#input-sifat').attr("class", "form-group has-error");
        error_sifat=0;
      }
      if(error_sifat + error_cec == 2){
  		$('#submit_ktk').prop("disabled",false);
  		}
  		else {
  		$('#submit_ktk').prop("disabled",true);
  		}
  });

  $('#tambah_cec').on('input', function () {
      tambah_cec = $('#tambah_cec').val();
      var angka = /^([0-9]{1,}(\.[0-9]{1,}){0,1})$/; //validasi angka
      if (tambah_cec.match(angka) && tambah_cec!=null) {
        $('#input-cec').attr("class", "form-group has-success");
        error_cec=1;
      } else {
        $('#input-cec').attr("class", "form-group has-error");
        error_cec=0;
      }
      if(error_sifat + error_cec == 2){
  		$('#submit_ktk').prop("disabled",false);
  		}
  		else {
  		$('#submit_ktk').prop("disabled",true);
  		}
  });

});

$('#modal_tambah_kimia').on('hidden.bs.modal', function(){
$('#submit_ktk').prop("disabled",true);
$('#tambah_sifat').val("").trigger('change');
$('#tambah_cec').val("");

$('#input-sifat').attr("class", "form-group");
$('#input-cec').attr("class", "form-group");

var error_sifat =0;
var error_cec =0;


});
});
</script>
