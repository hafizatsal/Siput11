@section('css')
<link rel="stylesheet" href="{{asset('Admin/bower_components/select2/dist/css/select2.min.css')}}">
@endsection
<div class="modal fade" id="modal_tambah_fauna">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Tambah Data Fauna</h4>
      </div>
      <div class="modal-body">
        <form role="form" method="post" action="{{route('auditor.tambah_fauna')}}"
        onsubmit="document.getElementById('submit_fauna').disabled=true;
        document.getElementById('submit_fauna').value='Sedang menyimpan...';">
          {{csrf_field()}}
          <div class="box-body">

            <div id="input-nama" class="form-group">
              <label for="nama_fauna">Nama Fauna *</label>
              <input type="hidden" id="id_klasters_plot_fauna" name="id_klasters_plot_fauna" value="{{$id_klaster}}">
              <input type="hidden" id="peng_ke" name="peng_ke" value="{{$pengukuran_ke}}">
              <select class="form-control" name="nama_fauna" id="nama_fauna" style="width:100%;">
                <option value="" disable="true" selected="true">Pilih Fauna</option>
                @foreach ($master_fauna as $key => $value)
                <option value="{{$value->id_jenis_fauna}}">{{$value->nama_fauna}} ({{$value->nama_latin_fauna}})</option>
                @endforeach
              </select>
            </div>

            <div id="input-jumlah" class="form-group">
              <label for="jumlah_fauna">Jumlah *</label>
              <input type="text" class="form-control" name="jumlah_fauna" id="jumlah_fauna" placeholder="">
              <input type="hidden" class="form-control" name="id_plot_fauna" id="id_plot_fauna" value={{$id_plot}}>
            </div>

          </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
        <input disabled type="submit" id="submit_fauna" class="btn btn-primary" value="Simpan">
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
  $('#modal_tambah_fauna').on('show.bs.modal', function(event){
    alert("Perhatian! Data fauna masih dalam tahap pengembangan!");

    $('#nama_fauna').select2({
      placeholder:"Nama Fauna"
    });
    var error_jumlah = 0;
    var error_nama = 0;

    $('#jumlah_fauna').on('input', function () {
        jumlah_fauna = $('#jumlah_fauna').val();
        var angka = /^([1-9][0-9]{0,})$/; //validasi angka
        if (jumlah_fauna.match(angka) && jumlah_fauna!=null) {
          $('#input-jumlah').attr("class", "form-group has-success");
          error_jumlah=1;
        } else {
          $('#input-jumlah').attr("class", "form-group has-error");
          error_jumlah=0;
        }
        if(error_jumlah + error_nama == 2){
    		$('#submit_fauna').prop("disabled",false);
    		}
    		else {
    		$('#submit_fauna').prop("disabled",true);
    		}
      });

      $('#nama_fauna').on('change', function () {
          nama_fauna = $('#nama_fauna').val();
          if (nama_fauna!=null) {
            $('#input-nama').attr("class", "form-group has-success");
            error_nama=1;
          } else {
            $('#input-nama').attr("class", "form-group has-error");
            error_nama=0;
          }
          if(error_jumlah + error_nama == 2){
      		$('#submit_fauna').prop("disabled",false);
      		}
      		else {
      		$('#submit_fauna').prop("disabled",true);
      		}
        });

  });

  $('#modal_tambah_fauna').on('hidden.bs.modal', function(){
    $('#submit_fauna').prop("disabled",true);
    $('#jumlah_fauna').val("");
    $('#nama_fauna').val("").trigger('change');
    var error_jumlah = 0;
    var error_nama = 0;
    $('#input-nama').attr("class", "form-group");
    $('#input-jumlah').attr("class", "form-group");
  });


    });
</script>
