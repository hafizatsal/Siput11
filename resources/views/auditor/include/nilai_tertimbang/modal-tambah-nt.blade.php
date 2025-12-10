<div class="modal fade" id="tambah_indikator">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Tambah Indikator</h4>
      </div>
      <div class="modal-body">
        <form role="form" method="post" action="{{route('auditor.indikator/insert')}}">
          {{csrf_field()}}
    <div class="box-body">
      <input type="text" class="form-control" name="id_klaster" id="id_klaster" value="{{$nama[0]->id_klaster_plot}}">
      <div class="form-group">
        <label for="nama_indikator">Pilih Indikator</label>
        <select class="form-control" name="nama_indikator" id="nama_indikator">
          <option value="" disable="true" selected="true">Nama Indikator</option>
          @foreach ($master_tertimbang as $key => $value)
            <option value="{{$value->id_master_tertimbang}}">{{$value->nama}}</option>
          @endforeach
        </select>
      </div>
      <div class="form-group">
        <label for="nilai_indikator">Nilai Indikator</label>
        <input type="text" class="form-control" name="nilai_indikator" id="nilai_indikator" placeholder="Nilai Indikator">
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
