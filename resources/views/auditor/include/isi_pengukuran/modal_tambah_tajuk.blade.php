<div class="modal fade" id="modal_tambah_tajuk">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Tambah Tajuk</h4>
      </div>
      <div class="modal-body">
        <form role="form" method="post" action="">
          {{csrf_field()}}
          <div class="box-body">
            <h5>Data Pengukuran :</h5>

            <div class="form-group">
              <label for="pengukuran_jarak">Jarak</label>
              <input type="text" class="form-control" name="pengukuran_jarak" id="pengukuran_jarak" value="" placeholder="m">
            </div>

            <div class="form-group">
              <label for="pengukuran_keliling">Keliling</label>
              <input type="text" class="form-control" name="pengukuran_keliling" id="pengukuran_keliling" placeholder="cm">
            </div>

            <div class="form-group">
              <label for="pengukuran_diameter">Diameter</label>
              <input type="text" class="form-control" name="pengukuran_diameter" id="pengukuran_diameter" placeholder="cm">
            </div>

            <div class="form-group">
              <label for="pengukuran_tinggi">Tinggi</label>
              <input type="text" class="form-control" name="pengukuran_tinggi" id="pengukuran_tinggi" placeholder="m">
            </div>

            <h5>Hasil:</h5>

            <div class="form-group">
              <label for="hasil_lbds">LBDS</label>
              <input type="text" class="form-control" name="hasil_lbds" id="hasil_lbds"  placeholder="m2" readonly>
            </div>

            <div class="form-group">
              <label for="hasil_v">V</label>
              <input type="text" class="form-control" name="hasil_v" id="hasil_v"  placeholder="m3" readonly>
            </div>
          </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
        <input type="submit" class="btn btn-primary" value="Simpan">
      </div>
          </form>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
