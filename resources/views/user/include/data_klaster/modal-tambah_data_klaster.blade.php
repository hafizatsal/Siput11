@section('css')
<link rel="stylesheet" href="{{asset('Admin/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css')}}">
@endsection
<div class="modal fade" id="tambah_data_klaster">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Tambah Data Kategori Klaster</h4>
      </div>
      <div class="modal-body">
        <form method="post" class="" action="{{route('user.data_klaster.insert')}}"
        onsubmit="document.getElementById('submit').disabled=true;
        document.getElementById('submit').value='Sedang menyimpan...';">
        {{csrf_field()}}

        <div id="input-pengukuranke" class="form-group">
              <label for="pengukuranke1">Pengukuran ke# *
              </label>
                <select required class="form-control" name="pengukuranke1" id="pengukuranke1">
                  <option value="1">1</option>
                  <option value="2">2</option>
                  <option value="3">3</option>
                </select>
        </div>

          <div id="input-nama_pengukur" class="form-group">
            <label for="nama_pengukur" class="control-label">Nama Pengukur *</label>
            <input type="text" class="form-control" name="nama_pengukur" id="nama_pengukur" value="" placeholder="Contoh : Rendy" required>
            <label hidden id="nama_label" class="control-label">Nama pengukur salah! (Alfabet 2-50 huruf).</label>
          </div>

          <div id="input-pengukur_pertama" class="form-group" style="display:none;">
            <label for="pengukur_pertama" class="control-label">Kategori Pengukuran (pengukur) *</label>
            <select class="form-control" name="pengukur_pertama" id="pengukur_pertama">
              <option value="">Pilih Pengukur Pertama</option>
              @foreach($data_kategori as $data_kategori)
                <option value="{{$data_kategori->kategori}}">{{$data_kategori->kategori}} ({{$data_kategori->nama_pengukur}})</option>
              @endforeach
            </select>
            <label hidden id="pengukur_pertama_label" class="control-label">Pengukur harus diisi.</label>
          </div>

          <div class="form-group" id="input-tahun_pengukuran_pertama" style="display:none;">
            <label for="tahun_pengukuran_pertama" class="control-label">Tahun Pengukuran Pertama *</label>
                  <select class="form-control" name="tahun_pengukuran_pertama" id="tahun_pengukuran_pertama">
                    <option value="">Pilih Tahun Pengukuran</option>
                  </select>
              <label hidden id="tahun_pengukuran_pertama_label" class="control-label">Tahun harus diisi.</label>
          </div>

          <div id="nama_kategori" class="form-group">
            <label for="kategori_modal" class="control-label">Kategori *</label>
            <input type="text" class="form-control" name="kategori_modal" id="kategori_modal" value="" placeholder="Contoh : Hutan Rakyat Lampung">
            <label hidden id="kategori_label" class="control-label">Kategori salah! (Alfabet 2-50 huruf).</label>
          </div>

          <div id="nama_tahun" class="form-group">
            <label for="tahun_pengukuran_modal" class="control-label">Tahun Pengukuran *</label>
            <input type="text" class="form-control" name="tahun_pengukuran_modal" id="tahun_pengukuran_modal" value="" placeholder="Contoh : 2018-12-31" required>
            <label hidden id="tahun_label" class="control-label">Tahun pengukuran salah! (Format: yyyy-mm-dd).</label>
          </div>
      </div>
    <div class="modal-footer">
      <button type="button" id="btnkmbli" class="btn btn-default pull-left" data-dismiss="modal">Kembali</button>
      <input type="submit" disabled id="submit" class="btn btn-primary pull-right"  value="Simpan"/>
    </div>
      </form>
  </div>
    <!-- /.modal-content -->
 </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
@section('data_table')
<!-- DataTables -->
<script src="{{asset('Admin/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js')}}"></script>
@endsection

@section('script_table')
<script>
  $(document).ready(function(){
    var v_nama_pengukur=0;
    var v_kategori=0;
    var v_pengukuran=0;

    $('#pengukuranke1').on('input', function(e) {
      var ukur_ke = e.target.value;
      if(ukur_ke!=1){
        $('#nama_kategori').fadeOut();
        $('#input-pengukur_pertama').fadeIn();
        $('#input-tahun_pengukuran_pertama').fadeIn();
        v_kategori=1;
      }
      else{
        $('#nama_kategori').fadeIn();
        v_kategori=0;
        $('#input-pengukur_pertama').fadeOut();
        $('#input-tahun_pengukuran_pertama').fadeOut();
      }
    });

    $('#pengukur_pertama').change(function(e){
      $(".loading").show();
      var kategori = e.target.value;
      var pengukuran_ke = 1;
      $.ajax({
          type: 'post',
          url: '{{route("user.json_data_tahun2")}}',
          data: {
            '_token': $('input[name=_token]').val(),
            'id': kategori,
            'pengke' : pengukuran_ke,
          },
          success: function (data) {
            if (data.length > 0) {
              $('#tahun_pengukuran_pertama').empty();
              $('#tahun_pengukuran_pertama').append('<option value="%" disable="true" selected="true">Pilih Tahun</option>');
              $.each(data, function (key, value) {
            $('#tahun_pengukuran_pertama').append('<option value="' + value['id_data_klaster'] + '">' + value['tahun_pengukuran'] + '</option>');
            });
          }
          else{
            $('#tahun_pengukuran_pertama').empty();
            $('#tahun_pengukuran_pertama').append('<option value="%" disable="true" selected="true">Data kosong</option>');
          }
          $(".loading").hide();
        }
        });
    });

    $('#tahun_pengukuran_modal').datepicker({
      format : 'yyyy-mm-dd',
      autoclose: true
    });

    $('#nama_pengukur').on('input', function() {
      nama_pengukur = $('#nama_pengukur').val();
      var valid_pengukur = /^[a-zA-Z,' ]{2,50}$/; //untuk validasi nama pengukur
      if(nama_pengukur.match(valid_pengukur)){
        $('#input-nama_pengukur').attr("class", "form-group has-success");
        $('#nama_label').hide();
        v_nama_pengukur=1;
        if(v_nama_pengukur==1 && v_kategori==1 && v_pengukuran==1){
          $('#submit').prop("disabled",false);
        }
        else{
          $('#submit').prop("disabled",true);
        }
      }
      else {
        $('#nama_label').show();
        $('#input-nama_pengukur').attr("class", "form-group has-error");
        $('#submit').prop("disabled",true);
        v_nama_pengukur=0;
        if(v_nama_pengukur==1 && v_kategori==1 && v_pengukuran==1){
          $('#submit').prop("disabled",false);
        }
        else{
          $('#submit').prop("disabled",true);
        }
      }
    });

    $('#kategori_modal').on('input', function() {
      var kategori = $('#kategori_modal').val();
      var valid_kategori = /^[a-zA-Z() ]{2,50}$/; //untuk validasi kategori
      if(kategori.match(valid_kategori)){
        $('#nama_kategori').attr("class", "form-group has-success");
        $('#kategori_label').hide();
        v_kategori=1;
        if(v_nama_pengukur==1 && v_kategori==1 && v_pengukuran==1){
          $('#submit').prop("disabled",false);
        }
        else{
          $('#submit').prop("disabled",true);
        }
      }
      else {
        $('#kategori_label').show();
        $('#nama_kategori').attr("class", "form-group has-error");
        $('#submit').prop("disabled",true);
        v_kategori=0;
      }
    });

    $('#tahun_pengukuran_modal').on('change', function() {
      var tahun_pengukuran = $('#tahun_pengukuran_modal').val();
      var valid_tahun = /^[1-2][0-9]{3}-[0-1][0-9]-[0-3][0-9]$/; //untuk validasi tahun
      if(tahun_pengukuran.match(valid_tahun)){
        $('#nama_tahun').attr("class", "form-group has-success");
        $('#tahun_label').hide();
        v_pengukuran=1;
        if(v_nama_pengukur==1 && v_kategori==1 && v_pengukuran==1){
          $('#submit').prop("disabled",false);
        }
        else{
          $('#submit').prop("disabled",true);
        }
      }
      else {
        $('#tahun_label').show();
        $('#nama_tahun').attr("class", "form-group has-error");
        $('#submit').prop("disabled",true);
        v_pengukuran=0;
      }
    });

    $('#tahun_pengukuran_modal').on('input', function() {
      var tahun_pengukuran2 = $('#tahun_pengukuran_modal').val();
      var valid_tahun = /^[1-2][0-9]{3}-[0-1][0-9]-[0-3][0-9]$/; //untuk validasi tahun
      if(tahun_pengukuran2.match(valid_tahun)){
        $('#nama_tahun').attr("class", "form-group has-success");
        $('#tahun_label').hide();
        v_pengukuran=1;
        if(v_nama_pengukur==1 && v_kategori==1 && v_pengukuran==1){
          $('#submit').prop("disabled",false);
        }
        else{
          $('#submit').prop("disabled",true);
        }
      }
      else {
        $('#tahun_label').show();
        $('#nama_tahun').attr("class", "form-group has-error");
        $('#submit').prop("disabled",true);
        v_pengukuran=0;
      }
    });

  });
</script>
@endsection
