@section('css')
<link rel="stylesheet" href="{{asset('Admin/bower_components/select2/dist/css/select2.min.css')}}">
@endsection
<div class="modal fade" id="modal_edit_fauna">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Edit Data Fauna</h4>
      </div>
      <div class="modal-body">
        <form role="form" method="post" action="{{route('user.edit_fauna_plot')}}"
        onsubmit="document.getElementById('submit_fauna2').disabled=true;
        document.getElementById('submit_fauna2').value='Sedang memperbarui...';">
          {{csrf_field()}}
          <div class="box-body">

            <div id="edit-nama" class="form-group">
              <label for="edit_nama_fauna">Nama Fauna</label>
              <select class="form-control" name="edit_nama_fauna" id="edit_nama_fauna" style="width:100%;">
                <option value="" disable="true" selected="true">Pilih Fauna</option>
                @foreach ($master_fauna as $key => $value)
                <option value="{{$value->id_jenis_fauna}}">{{$value->nama_fauna}}</option>
                @endforeach
              </select>
            </div>

            <div id="edit-jumlah" class="form-group">
              <label for="edit_jumlah_fauna">Jumlah</label>
              <input type="text" class="form-control" name="edit_jumlah_fauna" id="edit_jumlah_fauna" placeholder="">
              <input type="hidden" class="form-control" name="edit_id_fauna" id="edit_id_fauna" value="">
            </div>

          </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
        <input type="submit" id="submit_fauna2" class="btn btn-primary" value="Simpan">
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
  $('#edit_nama_fauna').select2({
    placeholder:"Ubah Fauna"
  });
$('#modal_edit_fauna').on('show.bs.modal', function(event){
   var button = $(event.relatedTarget);
   var data_fauna = button.data('fauna');
   var jenis = button.data('jenis');
   var jumlah = button.data('jumlah');
   var modal = $(this)
  modal.find('#edit_id_fauna').val(data_fauna);
       $('#edit_nama_fauna').val(jenis).trigger('change');
       $('#edit_jumlah_fauna').val(jumlah);

var error_jumlah=1;

       $('#edit_jumlah_fauna').on('input', function () {
           edit_jumlah_fauna = $('#edit_jumlah_fauna').val();
           var angka = /^([1-9][0-9]{0,})$/; //validasi angka
           if (edit_jumlah_fauna.match(angka) && edit_jumlah_fauna!=null) {
             $('#edit-jumlah').attr("class", "form-group has-success");
             error_jumlah=1;
           } else {
             $('#edit-jumlah').attr("class", "form-group has-error");
             error_jumlah=0;
           }
           if(error_jumlah == 1){
       		$('#submit_fauna2').prop("disabled",false);
       		}
       		else {
       		$('#submit_fauna2').prop("disabled",true);
       		}
         });

});

$('#modal_edit_fauna').on('hidden.bs.modal', function(){
  $('#submit_fauna2').prop("disabled",false);
  $('#jumlah_fauna2').val("");
  $('#nama_fauna2').val("").trigger('change');
  var error_jumlah = 1;
  $('#edit-jumlah').attr("class", "form-group");
});

    });
</script>
