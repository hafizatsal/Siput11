@section('css')
<link rel="stylesheet" href="{{asset('Admin/bower_components/select2/dist/css/select2.min.css')}}">
@endsection
<div class="modal fade" id="modal_edit_pohon">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Edit Data Pohon</h4>
      </div>
      <div class="modal-body">
        <form role="form" method="post" action="{{route('auditor.edit_pohon_plot')}}"
        onsubmit="document.getElementById('submit_pohon2').disabled=true;
        document.getElementById('submit_pohon2').value='Sedang memperbarui...';">
          {{csrf_field()}}
          <div class="box-body">

            <div class="form-group">
              <label for="edit_nama_pohon">Nama Pohon</label>
              <select class="form-control" name="edit_nama_pohon" id="edit_nama_pohon" style="width: 100%;">
                <option value="" disable="true" selected="true">Pilih Pohon</option>
                @foreach ($master_pohon as $key => $value)
                <option value="{{$value->id_jenis_tanaman}}">{{$value->nama_tanaman}} ({{$value->nama_latin}})</option>
                @endforeach
              </select>
            </div>

            <div class="form-group">
              <input type="hidden" class="form-control" name="edit_id_pohon" id="edit_id_pohon" value="">
            </div>

          </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
        <input type="submit" id="submit_pohon2" class="btn btn-primary" value="Simpan">
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
  $('#edit_nama_pohon').select2({
    placeholder:"Ubah Pohon"
  });
$('#modal_edit_pohon').on('show.bs.modal', function(event){

   var button = $(event.relatedTarget);
   var data_pohon = button.data('pohon');
   var jenis = button.data('jenis');

   var modal = $(this)
  modal.find('#edit_id_pohon').val(data_pohon);
  $('#edit_nama_pohon').val(jenis).trigger('change');

});

    });
</script>
