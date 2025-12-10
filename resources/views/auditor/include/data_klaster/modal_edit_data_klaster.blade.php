<div class="modal fade" id="modal_edit_data_klaster">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Edit Data Klaster</h4>
      </div>
      <div class="modal-body">
        <form role="form" method="post" action="{{route('auditor.data_klaster.edit')}}"
        onsubmit="document.getElementById('submit2').disabled=true;
        document.getElementById('submit2').value='Sedang memperbarui...';">
          {{csrf_field()}}
          <div id="edit_input-pengukuranke" class="form-group">
            <input type="hidden" name="id_data_klaster" id="id_data_klaster" value="">

                </label>
                  <select required class="form-control" name="edit_pengukuranke1" id="edit_pengukuranke1" style="display:none;">
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                  </select>
          </div>

            <div id="edit_input-nama_pengukur" class="form-group">
              <label for="edit_nama_pengukur" class="control-label">Nama Pengukur *</label>
              <input type="text" class="form-control" name="edit_nama_pengukur" id="edit_nama_pengukur" value="" placeholder="Contoh : Rendy" required>
              <label hidden id="edit_nama_label" class="control-label">Nama pengukur salah! (Alfabet 2-50 huruf).</label>
            </div>

            <div id="edit_nama_kategori" class="form-group">
              <label for="edit_kategori_modal" class="control-label">Kategori *</label>
              <input type="text" class="form-control" name="edit_kategori_modal" id="edit_kategori_modal" value="" placeholder="Contoh : Hutan Rakyat Lampung" required>
              <label hidden id="edit_kategori_label" class="control-label">Kategori salah! (Alfabet 2-50 huruf).</label>
            </div>

            <div id="edit_nama_tahun" class="form-group">
              <label for="edit_tahun_pengukuran_modal" class="control-label">Tahun Pengukuran *</label>
              <input type="text" class="form-control" name="edit_tahun_pengukuran_modal" id="edit_tahun_pengukuran_modal" value="" placeholder="Contoh : 2018-12-31" required>
              <label hidden id="edit_tahun_label" class="control-label">Tahun pengukuran salah! (Format: yyyy-mm-dd).</label>
            </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Kembali</button>
        <input type="submit" id="submit2" class="btn btn-primary" value="Simpan">
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
  $('#modal_edit_data_klaster').on('show.bs.modal', function(event){
    var button = $(event.relatedTarget);
    var id_data_klaster = button.data('data_klaster');
    var nama = button.data('nama_pengukur');
    var kategori = button.data('kategori');
    var tahun = button.data('tahun');
    var pengke = button.data('pengke');
    var modal = $(this)
    if(id_data_klaster!=null){
      modal.find('#id_data_klaster').val(id_data_klaster);
      modal.find('#edit_nama_pengukur').val(nama);
      modal.find('#edit_kategori_modal').val(kategori);
      modal.find('#edit_tahun_pengukuran_modal').val(tahun);
      modal.find('#edit_pengukuranke1').val(pengke);
    }

    $('#edit_tahun_pengukuran_modal').datepicker({
      format : 'yyyy-mm-dd',
      autoclose: true
    });
    var v_nama_pengukur=1;
    var v_kategori=1;
    var v_pengukuran=1;

    $('#edit_nama_pengukur').on('input', function() {
      nama_pengukur = $('#edit_nama_pengukur').val();
      var valid_pengukur = /^[a-zA-Z, ]{2,50}$/; //untuk validasi nama pengukur
      if(nama_pengukur.match(valid_pengukur)){
        $('#edit_input-nama_pengukur').attr("class", "form-group has-success");
        $('#edit_nama_label').hide();
        v_nama_pengukur=1;
        if(v_nama_pengukur==1 && v_kategori==1 && v_pengukuran==1){
          $('#submit').prop("disabled",false);
        }
        else{
          $('#submit').prop("disabled",true);
        }
      }
      else {
        $('#edit_nama_label').show();
        $('#edit_input-nama_pengukur').attr("class", "form-group has-error");
        $('#submit').prop("disabled",true);
      }
    });

    $('#edit_kategori_modal').on('input', function() {
      var kategori = $('#edit_kategori_modal').val();
      var valid_kategori = /^[a-zA-Z ]{2,50}$/; //untuk validasi kategori
      if(kategori.match(valid_kategori)){
        $('#edit_nama_kategori').attr("class", "form-group has-success");
        $('#edit_kategori_label').hide();
        v_nama_pengukur=1;
        if(v_nama_pengukur==1 && v_kategori==1 && v_pengukuran==1){
          $('#submit').prop("disabled",false);
        }
        else{
          $('#submit').prop("disabled",true);
        }
      }
      else {
        $('#edit_kategori_label').show();
        $('#edit_nama_kategori').attr("class", "form-group has-error");
        $('#submit').prop("disabled",true);
      }
    });

    $('#edit_tahun_pengukuran_modal').on('input', function() {
      var tahun_pengukuran = $('#edit_tahun_pengukuran_modal').val();
      var valid_tahun = /^[1-2][0-9]{3}-[0-1][0-9]-[0-3][0-9]$/; //untuk validasi tahun
      if(tahun_pengukuran.match(valid_tahun)){
        $('#edit_nama_tahun').attr("class", "form-group has-success");
        $('#edit_tahun_label').hide();
        v_nama_pengukur=1;
        if(v_nama_pengukur==1 && v_kategori==1 && v_pengukuran==1){
          $('#submit').prop("disabled",false);
        }
        else{
          $('#submit').prop("disabled",true);
        }
      }
      else {
        $('#edit_tahun_label').show();
        $('#edit_nama_tahun').attr("class", "form-group has-error");
        $('#submit').prop("disabled",true);
      }
    });

  });
});
</script>
