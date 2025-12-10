@section('css')
<link rel="stylesheet" href="{{asset('Admin/bower_components/select2/dist/css/select2.min.css')}}">
@endsection
<div class="modal fade" id="modal_tambah_tanaman">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Tambah Data Pohon</h4>
      </div>
      <div class="modal-body">

        <form role="form" method="post" action="{{route('auditor.tambah_pohon')}}"
        onsubmit="document.getElementById('submit_pohon').disabled=true;
        document.getElementById('submit_pohon').value='Sedang menyimpan...';">
          {{csrf_field()}}
          <div class="box-body">

            <div id="input-nama" class="form-group">
                <label>Nama Pohon *</label>
                <select class="form-control" name="nama_pohon" id="nama_pohon" style="width: 100%;">
                  <option value="" required selected="true">Pilih Pohon</option>
                  @foreach ($master_pohon as $key => $value)
                  <option value="{{$value->id_jenis_tanaman}}">{{$value->nama_tanaman}} ({{$value->nama_latin}})</option>
                  @endforeach
                </select>
              </div>

              <input type="hidden" id="id_klasters_plot" name="id_klasters_plot" value="{{$id_klaster}}">
              <input type="hidden" id="pengukurans_ke" name="pengukurans_ke" value="{{$pengukuran_ke}}">

            <div id="input-jumlah" class="form-group">
              <label for="jumlah">Jumlah *</label>
              <input type="text" class="form-control" name="jumlah" id="jumlah" placeholder="">
              <input type="hidden" class="form-control" name="id_plot_pohon" id="id_plot_pohon" value={{$id_plot}}>
            </div>
          </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
        <input disabled type="submit" id="submit_pohon" class="btn btn-primary" value="Simpan">
      </div>
          </form>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
@section('script_tambahan')
<script src="{{asset('Admin/bower_components/select2/dist/js/select2.full.min.js')}}"></script>
@endsection
<script type="text/javascript">
$(document).ready(function(){
  $('#modal_tambah_tanaman').on('show.bs.modal', function(event){
    alert("Perhatian! Data pohon masih dalam tahap pengembangan!");

    var error_jumlah=0;
    var error_nama=0;

    $('#jumlah').on('input', function () {
        jumlah = $('#jumlah').val();
        var angka = /^([1-9][0-9]{0,})$/; //validasi angka
        if (jumlah.match(angka) && jumlah!=null) {
          $('#input-jumlah').attr("class", "form-group has-success");
          error_jumlah=1;
        } else {
          $('#input-jumlah').attr("class", "form-group has-error");
          error_jumlah=0;
        }
        if(error_jumlah + error_nama == 2){
    		$('#submit_pohon').prop("disabled",false);
    		}
    		else {
    		$('#submit_pohon').prop("disabled",true);
    		}
      });

      $('#nama_pohon').on('change', function () {
          nama_pohon = $('#nama_pohon').val();
          if (nama_pohon!=null) {
            $('#input-nama').attr("class", "form-group has-success");
            error_nama=1;
          } else {
            $('#input-nama').attr("class", "form-group has-error");
            error_nama=0;
          }
          if(error_jumlah + error_nama == 2){
      		$('#submit_pohon').prop("disabled",false);
      		}
      		else {
      		$('#submit_pohon').prop("disabled",true);
      		}
        });

  });

  $('#modal_tambah_tanaman').on('hidden.bs.modal', function(){
    $('#submit_pohon').prop("disabled",true);
    $('#jumlah').val("");
    $('#nama_pohon').val("").trigger('change');
    var error_jumlah = 0;
    var error_nama = 0;
    $('#input-nama').attr("class", "form-group");
    $('#input-jumlah').attr("class", "form-group");
  });

$('#nama_pohon').select2({
  placeholder:"Nama Pohon"
});
});
</script>
