<div class="modal fade" id="edit_user">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Edit User</h4>
      </div>
      <div class="modal-body">
        <form role="form" method="post" action="">
          {{csrf_field()}}
    <div class="box-body">
      <div id="nama_pengguna2" class="form-group">
      <label for="nama_user2">Nama</label>
      <input type="text" class="form-control" name="nama_user2" id="nama_user2" value="" placeholder="Nama">
      <label hidden id="label_nama_user2" class="control-label">Nama harus diisi!</label>
      </div>

      <div id="nama_username2" class="form-group">
        <label for="username2">Username</label>
        <input type="text" class="form-control" name="username2" id="username2" placeholder="Username">
        <label hidden id="label_username2" class="control-label">Username harus diisi!</label>
      </div>

      <div id="email_user2" class="form-group">
        <label for="email2">Email</label>
        <input type="text" class="form-control" name="email2" id="email2" placeholder="Email">
        <label hidden id="label_email2" class="control-label">Email harus diisi!</label>
      </div>

      <div id="password_user2" class="form-group">
        <label for="password2">Password</label>
        <input type="password" class="form-control" name="password2" id="password2" placeholder="Password">
        <label hidden id="label_password2" class="control-label">Password harus diisi!</label>
      </div>

      <div id="co_password_user2" class="form-group">
        <label for="co_password2">Confirmation Password</label>
        <input type="password" class="form-control" name="co_password2" id="co_password2" placeholder="Confirmation Password">
        <label hidden id="label_co_password2" class="control-label">Password tidak cocok!</label>
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

<script type="text/javascript">
$(document).ready(function(){
var v_nama_user2=0;
var v_username2=0;
var v_email2=0;
var v_password2=0;
var v_co_password2=0;

  $('#nama_pengguna2').on('input', function() {
    nama_user2 = $('#nama_user2').val();
  //  console.log(nama_user2);
    if(nama_user2!=""){
      $('#nama_pengguna2').attr("class", "form-group has-success");
      $('#label_nama_user2').hide();
      v_nama_user2=1;
      // console.log(v_nama_user2);
    }
    else {
      v_nama_user2=0;
      $('#label_nama_user2').show();
      $('#nama_pengguna2').attr("class", "form-group has-error");
      // console.log(v_nama_user2);
    }
  });

  $('#nama_username2').on('input', function() {
    username2 = $('#username2').val();
   console.log(username2);
    if(username2!=""){
      $('#nama_username2').attr("class", "form-group has-success");
      $('#label_username2').hide();
      v_username2=1;
      // console.log(v_username2);
    }
    else {
      v_username2=0;
     $('#label_username2').show();
      $('#nama_username2').attr("class", "form-group has-error");
      // console.log(v_username2);
    }
  });

var valid_email2 = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/ //validasi email
  $('#email_user2').on('input', function() {
    email2 = $('#email2').val();
   console.log(email2);
    if(email2.match(valid_email2)){
      $('#email_user2').attr("class", "form-group has-success");
      $('#label_email2').hide();
      v_email2=1;
      // console.log(v_email2);
    }
    else if(email2==""){
      v_email2=0;
    $('#label_email2').text("Email tidak boleh kosong!");
     $('#label_email2').show();
      $('#email_user2').attr("class", "form-group has-error");
      // console.log(v_email2);
    }
    else {
      v_email2=0;
      $('#label_email2').text("Email tidak valid!");
     $('#label_email2').show();
      $('#email_user2').attr("class", "form-group has-error");
      // console.log(v_email2);
    }
  });

  $('#password_user2').on('input', function() {
    password2 = $('#password2').val();
   console.log(password2);
    if(password2!=""){
      if(co_password2==password2){
        $('#co_password_user2').attr("class", "form-group has-success");
        $('#label_co_password2').hide();
      }
      else {
        $('#co_password_user2').attr("class", "form-group has-error");
        $('#label_co_password2').show();
      }
      $('#password_user2').attr("class", "form-group has-success");
      $('#label_password2').hide();
      v_password2=1;
      // console.log(v_password2);
    }
    else {
      v_password2=0;
     $('#label_co_password2').show();
      $('#password_user2').attr("class", "form-group has-error");
      $('#co_password_user2').attr("class", "form-group has-error");
      // console.log(v_password2);
    }
  });

  $('#co_password_user2').on('input', function() {
    co_password2 = $('#co_password2').val();
   console.log(co_password2);
    if(co_password2==password2 && co_password2!=""){
      $('#co_password_user2').attr("class", "form-group has-success");
      $('#password_user2').attr("class", "form-group has-success");
      $('#label_co_password2').hide();
      v_co_password2=1;
      // console.log(v_co_password2);
    }
    else {
      v_co_password2=0;
     $('#label_co_password2').show();
      $('#co_password_user2').attr("class", "form-group has-error");
      $('#password_user2').attr("class", "form-group has-error");
      // console.log(v_co_password2);
    }
  });

});
</script>
