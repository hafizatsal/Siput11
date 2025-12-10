@section('css')
<link rel="stylesheet" href="{{asset('Admin/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css')}}">
@endsection
<div class="modal fade" id="banned_user">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Ban User</h4>
      </div>
      <div class="modal-body">
        <form role="form" method="post" action="{{route('admin.ban_user')}}"
        onsubmit="document.getElementById('submit_banned').disabled=true;
        document.getElementById('submit_banned').value='Sedang memperbarui...';">
          {{csrf_field()}}
          <div class="box-body">
            <input type="hidden" class="form-control" id="id_pengguna" name="id_pengguna" value="">

            <div class="form-group">
              <label for="nama">Banned sampai</label>
              <input placeholder="yyy-dd-mm" type="text" class="form-control" id="tanggal_banned" name="tanggal_banned" value="">
            </div>

          </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
        <input type="submit" id="submit_banned" class="btn btn-primary" value="Simpan">
      </div>
          </form>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
<script>
$(document).ready(function(){

    $('#banned_user').on('show.bs.modal', function(event){
      var button = $(event.relatedTarget);
      var nm_banned = button.data('nm_user');
      var nm_tgl_banned = button.data('nm_banned');
      var modal = $(this)
      modal.find('#id_pengguna').val(nm_banned);
      modal.find('#tanggal_banned').val(nm_tgl_banned);
    });
    $('#tanggal_banned').datepicker({
      format : 'yyyy-mm-dd',
      autoclose: true
    }).on('show.bs.modal', function(event) {
      event.stopPropagation();
    });


});
</script>
