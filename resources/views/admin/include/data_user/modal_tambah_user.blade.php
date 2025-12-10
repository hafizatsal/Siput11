<div class="modal fade" id="tambah_user">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Tambah User</h4>
      </div>
      <div class="modal-body">
        <form role="form" method="post" action="{{route('admin.user.insert')}}"
        onsubmit="document.getElementById('submit_user').disabled=true;
        document.getElementById('submit_user').value='Sedang menyimpan...';">
          {{csrf_field()}}
    <div class="box-body">
      <div id="nama_pengguna" class="form-group">
      <label for="nama_user">Nama</label>
      <input type="text" required class="form-control" name="nama_user" id="nama_user" value="" placeholder="Nama">
      <label hidden id="label_nama_user" class="control-label">Nama harus diisi!</label>
      </div>

      <div id="nama_username" class="form-group">
        <label for="username">Username</label>
        <input type="text" required class="form-control" name="username" id="username" placeholder="Username">
        <label hidden id="label_username" class="control-label">Username harus diisi!</label>
      </div>

      <div id="email_user" class="form-group">
        <label for="email">Email</label>
        <input type="text" required class="form-control" name="email" id="email" placeholder="Email">
        <label hidden id="label_email" class="control-label">Email harus diisi!</label>
      </div>

    <div id="instansi_user" class="form-group">
      <label for="instansi">Instansi</label>
      <input type="text" required class="form-control" name="instansi" id="instansi" placeholder="Instansi">
      <label hidden id="label_instansi" class="control-label">Instansi harus diisi!</label>
    </div>

    <div id="peran_user" class="form-group">
      <label for="peran">Peran</label>
      <select required class="form-control" name="peran" id="peran">
        <option value="">Pilih Peran</option>
        @foreach($peran as $peran)
        <option value="{{$peran->id}}">{{$peran->role_name}}</option>
        @endforeach
      </select>
      <label hidden id="label_peran" class="control-label">Peran harus diisi!</label>
    </div>
    </div>
    <!-- /.box-body -->

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
        <input type="submit" id="submit_user" class="btn btn-primary" value="Simpan">
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
var v_nama_user=0;
var v_username=0;
var v_email=0;
var v_password=0;
var v_co_password=0;
var v_instansi=0;
var v_peran=0;

  $('#nama_pengguna').on('input', function() {
    nama_user = $('#nama_user').val();
    if(nama_user!=""){
      $('#nama_pengguna').attr("class", "form-group has-success");
      $('#label_nama_user').hide();
      v_nama_user=1;
    }
    else {
      v_nama_user=0;
      $('#label_nama_user').show();
      $('#nama_pengguna').attr("class", "form-group has-error");
    }
  });

  $('#nama_username').on('input', function() {
    username = $('#username').val();
    if(username!=""){
      $('#nama_username').attr("class", "form-group has-success");
      $('#label_username').hide();
      v_username=1;
    }
    else {
      v_username=0;
     $('#label_username').show();
      $('#nama_username').attr("class", "form-group has-error");
    }
  });

var valid_email = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/ //validasi email
  $('#email_user').on('input', function() {
    email = $('#email').val();
    if(email.match(valid_email)){
      $('#email_user').attr("class", "form-group has-success");
      $('#label_email').hide();
      v_email=1;
    }
    else if(email==""){
      v_email=0;
    $('#label_email').text("Email tidak boleh kosong!");
     $('#label_email').show();
      $('#email_user').attr("class", "form-group has-error");
    }
    else {
      v_email=0;
      $('#label_email').text("Email tidak valid!");
     $('#label_email').show();
      $('#email_user').attr("class", "form-group has-error");
    }
  });

  $('#password_user').on('input', function() {
    password = $('#password').val();
    if(password!=""){
      if(co_password==password){
        $('#co_password_user').attr("class", "form-group has-success");
        $('#label_co_password').hide();
      }
      else {
        $('#co_password_user').attr("class", "form-group has-error");
        $('#label_co_password').show();
      }
      $('#password_user').attr("class", "form-group has-success");
      $('#label_password').hide();
      v_password=1;
    }
    else {
      v_password=0;
     $('#label_co_password').show();
      $('#password_user').attr("class", "form-group has-error");
      $('#co_password_user').attr("class", "form-group has-error");
    }
  });

  $('#co_password_user').on('input', function() {
    co_password = $('#co_password').val();
    if(co_password==password && co_password!=""){
      $('#co_password_user').attr("class", "form-group has-success");
      $('#password_user').attr("class", "form-group has-success");
      $('#label_co_password').hide();
      v_co_password=1;
    }
    else {
      v_co_password=0;
     $('#label_co_password').show();
      $('#co_password_user').attr("class", "form-group has-error");
      $('#password_user').attr("class", "form-group has-error");
    }
  });

  $('#instansi_user').on('change', function() {
    instansi = $('#instansi').val();
    if(instansi!=""){
      $('#instansi_user').attr("class", "form-group has-success");
      $('#label_instansi').hide();
      v_instansi=1;
    }
     else {
      v_instansi=0;
      $('#label_instansi').show();
      $('#instansi_user').attr("class", "form-group has-error");
    }
  });

  $('#peran_user').on('change', function() {
    peran = $('#peran').val();
    if(peran!=""){
      $('#peran_user').attr("class", "form-group has-success");
      $('#label_peran').hide();
      v_peran=1;
    }
     else {
      v_peran=0;
      $('#label_peran').show();
      $('#peran_user').attr("class", "form-group has-error");
    }
  });

});
</script>
