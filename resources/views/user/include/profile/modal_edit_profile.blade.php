<div class="modal fade" id="modal_edit_profile">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Edit Profile</h4>
      </div>
      <div class="modal-body">
        <form role="form" method="post" action="{{route('user.profile_edit')}}" enctype="multipart/form-data"
        onsubmit="document.getElementById('profile').disabled=true;
        document.getElementById('profile').value='Sedang memperbarui...';">
          {{csrf_field()}}
          <div class="box-body">

            <div class="form-group">
              <label for="nama">Nama Lengkap</label>
              <input type="hidden" class="form-control" id="id_pengguna" name="id_pengguna" value="{{Auth::user()->id}}">
              <input type="text" class="form-control" id="nama" name="nama" value="{{Auth::user()->nama}}">
            </div>

            <div class="form-group">
              <label for="file">Upload foto</label>
              <input type="file" name="file">
            </div>

          </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
        <input type="submit" id="profile" class="btn btn-primary" value="Simpan">
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
  $('#modal_edit_profile').on('show.bs.modal', function(event){

  });
});
</script>
