<div class="modal fade" id="modal_tambah_pertumbuhan">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Tambah Pertumbuhan</h4>
      </div>
      <div class="modal-body">
        <form role="form" method="post" action="{{route('auditor.tambah_pertumbuhan')}}"
        onsubmit="document.getElementById('submit_pertumbuhan_pohon').disabled=true;
        document.getElementById('submit_pertumbuhan_pohon').value='Sedang menyimpan...';">
          {{csrf_field()}}
          <div class="box-body">
            <h5>Data Pengukuran :</h5>
            <div class="col-md-6">

            <div id="input-azimuth" class="form-group">
              <label for="azimuth">Azimuth (ᴼ)</label>
              <input type="hidden" class="form-control" name="id_pengukuran" id="id_pengukuran" value="">
              <input type="hidden" class="form-control" name="id_tanaman3" id="id_tanaman3" value="">
              <input type="text" class="form-control" name="azimuth" id="azimuth" value="" placeholder="ᴼ">
              <label hidden id="azimuth_error"><i>Azimuth harus berupa angka!</i></label>
            </div>

            <div id="input-jarak" class="form-group">
              <label for="pengukuran_jarak">Jarak * (m)</label>
              <input type="text" class="form-control" name="pengukuran_jarak" id="pengukuran_jarak" value="" placeholder="m">
              <label hidden id="jarak_error"><i>Jarak harus berupa angka!</i></label>
            </div>

          </div>
            <div class="col-md-6">
            <div id="input-keliling" class="form-group">
              <label for="pengukuran_keliling">Keliling * (cm)</label>
              <input type="text" class="form-control" name="pengukuran_keliling" id="pengukuran_keliling" placeholder="cm">
              <label hidden id="keliling_error"><i>Keliling harus berupa angka!</i></label>
            </div>

            <div id="input-tinggi" class="form-group">
              <label for="pengukuran_tinggi">Tinggi * (m)</label>
              <input type="text" class="form-control" name="pengukuran_tinggi" id="pengukuran_tinggi" placeholder="m">
              <label hidden id="tinggi_error"><i>Tinggi harus berupa angka!</i></label>
            </div>
            </div>
          </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
        <input type="submit" id="submit_pertumbuhan_pohon" class="btn btn-primary" value="Simpan">
      </div>
          </form>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

@push('script_tambahan')
<script type="text/javascript">
$(document).ready(function() {
  $('#modal_tambah_pertumbuhan').on('show.bs.modal', function(event){
    var button2 = $(event.relatedTarget);
    var info2 = button2.data('info');
    var info_pengukuran = button2.data('info_pengukuran');
    var modal2 = $(this)
    modal2.find('#id_pengukuran').val(info_pengukuran);
    modal2.find('#id_tanaman3').val(info2);

    $.ajax({
      type: 'post',
      url: '{{route("auditor.json_data_pertumbuhan2")}}',
      data: {
        '_token': $('input[name=_token]').val(),
        'id': info_pengukuran,
        'id2': info2,
      },
      success: function (data) {
        if (data.length > 0) {
          $.each(data, function (key, value) {
          $('#azimuth').val(value['azimuth']);
          $('#pengukuran_jarak').val(value['jarak']);
          // $('#pengukuran_keliling').val(value['keliling']);
          $('#pengukuran_keliling').val(value['keliling']);
          $('#pengukuran_tinggi').val(value['tinggi']);
          // $('#hasil_lbds').val(value['Hasil_LBDS']);
          // $('#hasil_v').val(value['v']);
          });
      }
      else{

      }
    }
  });
  var error_azimuth=1;
  var error_keliling=1;
  var error_jarak=1;
  var error_tinggi=1;

  $('#azimuth').on('input', function () {
      azimuth = $('#azimuth').val();
      var angka = /^([0-9]{1,}(\.[0-9]{1,}){0,1})$/; //validasi angka
      if (azimuth.match(angka) && azimuth!=null) {
        $('#input-azimuth').attr("class", "form-group has-success");
        $('#azimuth_error').hide();
        error_azimuth=1;
      } else {
        $('#input-azimuth').attr("class", "form-group has-error");
        $('#azimuth_error').show();
        error_azimuth=0;
      }
      if(error_azimuth + error_keliling + error_jarak + error_tinggi == 4){
  		$('#submit_pertumbuhan_pohon').prop("disabled",false);
  		}
  		else {
  		$('#submit_pertumbuhan_pohon').prop("disabled",true);
  		}
    });

  $('#pengukuran_keliling').on('input', function () {
      keliling = $('#pengukuran_keliling').val();
      var angka = /^([0-9]{1,}(\.[0-9]{1,}){0,1})$/; //validasi angka
      if (keliling.match(angka) && keliling!=null) {
        $('#input-keliling').attr("class", "form-group has-success");
        $('#keliling_error').hide();
        error_keliling=1;
      } else {
        $('#input-keliling').attr("class", "form-group has-error");
        $('#keliling_error').show();
        error_keliling=0;
      }
      if(error_azimuth + error_keliling + error_jarak + error_tinggi == 4){
  		$('#submit_pertumbuhan_pohon').prop("disabled",false);
  		}
  		else {
  		$('#submit_pertumbuhan_pohon').prop("disabled",true);
  		}
    });
  $('#pengukuran_jarak').on('input', function () {
      jarak = $('#pengukuran_jarak').val();
      var angka = /^([0-9]{1,}(\.[0-9]{1,}){0,1})$/; //validasi angka
      if (jarak.match(angka) && jarak!=null) {
        $('#input-jarak').attr("class", "form-group has-success");
        $('#jarak_error').hide();
        error_jarak=1;
      } else {
        $('#input-jarak').attr("class", "form-group has-error");
        $('#jarak_error').show();
        error_jarak=0;
      }
      if(error_azimuth + error_keliling + error_jarak + error_tinggi == 4){
  		$('#submit_pertumbuhan_pohon').prop("disabled",false);
  		}
  		else {
  		$('#submit_pertumbuhan_pohon').prop("disabled",true);
  		}
  });
  $('#pengukuran_tinggi').on('input', function () {
      tinggi = $('#pengukuran_tinggi').val();
      var angka = /^([0-9]{1,}(\.[0-9]{1,}){0,1})$/; //validasi angka
      if (tinggi.match(angka) && tinggi!=null) {
        $('#input-tinggi').attr("class", "form-group has-success");
        $('#tinggi_error').hide();
        error_tinggi=1;
      } else {
        $('#input-tinggi').attr("class", "form-group has-error");
        $('#tinggi_error').show();
        error_tinggi=0;
      }
      if(error_azimuth + error_keliling + error_jarak + error_tinggi == 4){
  		$('#submit_pertumbuhan_pohon').prop("disabled",false);
  		}
  		else {
  		$('#submit_pertumbuhan_pohon').prop("disabled",true);
  		}
    });
      });


  $('#modal_tambah_pertumbuhan').on('hidden.bs.modal', function(){
    $('#submit_pertumbuhan_pohon').prop("disabled",false);

    $('#input-azimuth').attr("class", "form-group");
    $('#azimuth_error').hide();
    $('#input-keliling').attr("class", "form-group");
    $('#keliling_error').hide();
    $('#input-jarak').attr("class", "form-group");
    $('#jarak_error').hide();
    $('#input-tinggi').attr("class", "form-group");
    $('#tinggi_error').hide();

    $('#azimuth').val("");
    $('#pengukuran_jarak').val("");
    // $('#pengukuran_keliling').val("");
    $('#pengukuran_diameter').val("");
    $('#pengukuran_tinggi').val("");
    // $('#hasil_lbds').val("");
    // $('#hasil_v').val("");
    });

    //perhitungan lbds
    var diameter = 0;
    var keliling = 0;
    var lbds     = 0;
    // $('#pengukuran_keliling').keyup(function() {
    //         keliling=$(this).val();
    //         diameter=(keliling/3.14);
    //    $('#pengukuran_diameter').val(diameter);
    //  });

    // $('#pengukuran_diameter').keyup(function() {
    //        diameter=$(this).val();
    //        keliling = diameter*3.14;
    //   $('#pengukuran_keliling').val(keliling);
    //  });

     //perhitungan v
     // $('#pengukuran_tinggi').keyup(function() {
     //       diameter=$('#pengukuran_diameter').val();
     //   });
     });
</script>
@endpush