<div class="modal fade" id="modal_tambah_pengukuran">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Tambah Pengukuran</h4>
      </div>
      <div class="modal-body">
        <form role="form" method="post" action="">
          {{csrf_field()}}
          <div class="box-body">
            <label for="pengukuran_ke">Pengukuran ke-</label>
            <input type="text" class="form-control" name="pengukuran_ke" id="pengukuran_ke" value="{{$hitung+1}}" readonly>

            <div class="form-group">
              <label for="datepicker">Tanggal Pengukuran</label>
              <div class="input-group date">
                <div class="input-group-addon">
                  <i class="fa fa-calendar"></i>
                </div>
                <input type="text" class="form-control pull-right" id="datepicker">
              </div>
              <!-- /.input group -->
            </div>
            <!-- /.form group -->
            <div class="form-group">
              <label for="nama_pengukur">Nama Pengukur</label>
              <input type="text" class="form-control" name="nama_pengukur" id="nama_pengukur" placeholder="Masukkan nama">
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
