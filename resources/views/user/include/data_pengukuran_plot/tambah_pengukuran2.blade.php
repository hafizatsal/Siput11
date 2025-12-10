@section('css')
<link rel="stylesheet" href="{{asset('Admin/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css')}}">
@endsection
<div class="modal fade" id="modal_tambah_pengukuran2">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Tambah Pengukuran</h4>
      </div>
      <div class="modal-body">
        <form role="form" method="post" action="{{route('user.pengukuran.insert2')}}">
          {{csrf_field()}}
          <div class="box-body">
            <label for="pengukuran_ke2">Pengukuran ke-</label>
            <input required type="text" class="form-control" name="pengukuran_ke2" id="pengukuran_ke2" value="" readonly>

            <div class="form-group">
              <label for="datepicker">Tanggal Pengukuran</label>
              <div class="input-group date">
                <div class="input-group-addon">
                  <i class="fa fa-calendar"></i>
                </div>
                <input required type="text" class="form-control pull-right" name="tanggal_pengukuran" id="datepicker">
              </div>
              <!-- /.input group -->
            </div>
            <!-- /.form group -->
            <div class="form-group">
              <label for="nama_pengukur">Nama Pengukur</label>
              <input type="hidden" class="form-control" name="id_plot" id="id_plot" value="">
              <input required type="text" class="form-control" name="nama_pengukur" id="nama_pengukur" placeholder="Masukkan nama">
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
