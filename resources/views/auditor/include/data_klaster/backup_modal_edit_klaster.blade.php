<div class="modal fade" id="edit_klaster_plot">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">Edit Data Klaster Plot</h4>
        </div>
        <div class="modal-body">
        <div class="row">
            <div class="col-md-12">
              <div class="nav-tabs-custom" id="tabedit">
                <ul class="nav nav-tabs">
                  <li id="tab3" class="active"><a href="#tab_3" data-toggle="tab">Identitas Klaster Plot Ukur (1)</a></li>
                  <li id="tab4" class="disabled"><a id=tabs4>Identitas Klaster Plot Ukur (2)</a></li>
                </ul>
                <div class="tab-content">

                  <!-- Untuk tab Data Hutan -->
                  <div class="tab-pane active" id="tab_3">
                    <form id="formedit" class="" action="{{route('auditor.data_klaster.edit')}}" method="get"
                    onsubmit="document.getElementById('submit2').disabled=true;
                    document.getElementById('submit2').value='Sedang memperbarui...';">
                      {{csrf_field()}}
                  <div id="klaster2" class="form-group">
                    <input type="hidden" class="form-control" name="id_klaster_plot2" id="id_klaster_plot2" value="">
                    <label hidden id="id_label2" class="control-label">Harus berupa angka!</label>
                  </div>

                  <div class="col-md-12">
                    <h4>Koordinat Klaster: </h4>
                  </div>

                 <div class="col-md-6">
                   <div class="form-group">
                      <label class="control-label">Lintang</label>
                      <div id="lintang_klaster2" class="form-group">
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="00 ᴼ 00 &rsquo; 00.00 &rdquo;" data-inputmask="'mask': ['99 ᴼ 99 &rsquo; 99.99 &rdquo;']" data-mask2 id="koor_lintang2_klaster" name="koor_lintang2_klaster">
                            <!-- insert this line -->
                            <span class="input-group-addon" style="width:0px; padding-left:0px; padding-right:0px; border:none;"></span>

                            <select class="form-control" name="pilih_lintang_klaster" id="pilih_lintang_klaster">
                              <option value="LS" selected>LS</option>
                              <option value="LU">LU</option>
                            </select>
                        </div>
                        <label hidden id="id_lintang_klaster2" class="control-label"><i>Lintang harus sesuai dengan format!</i></label>
                     </div>
                   </div>
                  </div>

              <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label">Bujur</label>
                    <div id="bujur_klaster2" class="form-group">
                      <div class="input-group">
                          <input type="text" class="form-control" placeholder="00 ᴼ 00 &rsquo; 00.00 &rdquo;" data-inputmask="'mask': ['999 ᴼ 99 &rsquo; 99.99 &rdquo;']" data-mask2 id="koor_bujur2_klaster" name="koor_bujur2_klaster">
                          <!-- insert this line -->
                          <span class="input-group-addon" style="width:0px; padding-left:0px; padding-right:0px; border:none;"></span>

                          <select class="form-control" name="pilih_bujur_klaster" id="pilih_bujur_klaster">
                            <option value="BT" selected>BT</option>
                            <option value="BB">BB</option>
                          </select>
                      </div>
                      <label hidden id="id_bujur_klaster2" class="control-label"><i>Bujur harus sesuai dengan format!</i></label>
                    </div>
                 </div>
               </div>

                <div class="col-md-12">
                  <div id="input-altitude2" class="form-group">
                  <label class="control-label">Altitude (m dpl)</label>
                  <input type="text" class="form-control" placeholder="(m dpl)" name="altitude2" id="altitude2" value="">
                  <label hidden id="id_altitude2" class="control-label"><i>Altitude harus diisi!</i></label>
                  </div>
                </div>

                    <div class="col-md-6">
                      <div id="input-pemilik2" class="form-group">
                      <label class="control-label">Status Hukum Lahan</label>
                      <select class="form-control" name="kepemilikan2" id="kepemilikan2">
                        <option value="" disable="true" selected="true">=== Pilih Status Hukum === </option>
                        @foreach ($kepemilikan as $key => $value)
                          <option value="{{$value->id_hak_milik}}">{{$value->hak_milik}}</option>
                        @endforeach
                      </select>
                      <label hidden id="id_pemilik2" class="control-label"><i>Kepemilikan harus diisi!</i></label>
                        </div>

                      <div id="input-jenis-hutan2" class="form-group">
                        <label class="control-label">Tipe Hutan</label>
                        <input type="text" class="form-control" name="jenis2" id="jenis2" placeholder="Contoh: Hutan Taman Nasional">
                        <label hidden id="id_jenis2" class="control-label"><i>Tipe hutan salah! (6-50 huruf).</i></label>
                      </div>

                      <div id="input-fungsi-hutan2" class="form-group">
                        <label>Fungsi Hutan</label>
                        <select class="form-control" name="fungsi2" id="fungsi2">
                        <option value="" disable="true" selected="true">=== Silahkan Pilih === </option>
                        @foreach ($fungsi as $key => $value)
                          <option value="{{$value->id_fungsi_hutan}}">{{$value->fungsi}}</option>
                        @endforeach
                      </select>
                      <label hidden id="id_fungsi2" class="control-label"><i>Fungsi hutan harus diisi!</i></label>
                      </div>

                      <div id="input-pengelola-hutan2" class="form-group">
                      <label>Nama Pengelola</label>
                      <input type="text" class="form-control" name="pengelola2" id="pengelola2" placeholder="Pengelola">
                      <label hidden id="id_pengelola2" class="control-label"><i>Nama pengelola salah! (5-50 huruf).</i></label>
                      </div>

                      <div id="input-keterangan-pengelola2" class="form-group">
                      <label>Keterangan Pengelola</label>
                      <select class="form-control" name="ket_pengelola2" id="ket_pengelola2">
                        <option value="" disable="true" selected="true">Silahkan Pilih</option>
                        @foreach ($jenis_pengelola as $key => $value)
                          <option value="{{$value->jenis_pengelola}}">{{$value->jenis_pengelola}}</option>
                        @endforeach
                      </select>
                      <label hidden id="id_keterangan_pengelola2" class="control-label"><i>Keterangan pengelola harus diisi!</i></label>
                      </div>
                    </div>

                    <div class="form-group col-md-6">

                      <div id="input-provinsi2" class="form-group">
                      <label>Provinsi</label>
                      <select class="form-control" name="provinsi2" id="provinsi2">
                        <option value="" disable="true" selected="true">=== Silahkan Pilih === </option>
                        @foreach ($provinsi as $key => $value)
                          <option value="{{$value->id_provinsi}}">{{$value->nama_provinsi}}</option>
                        @endforeach
                      </select>
                      <label hidden id="id_provinsi2" class="control-label"><i>Provinsi harus diisi!</i></label>
                      </div>

                      <div id="input-kabupaten2" class="form-group">
                      <label>Kabupaten</label>
                      <select class="form-control" name="kabupaten2" id="kabupaten2">
                        <option value="" disable="true" selected="true">=== Silahkan Pilih === </option>
                      </select>
                      <label hidden id="id_kabupaten2" class="control-label"><i>Kabupaten harus diisi!</i></label>
                      </div>

                      <div id="input-kecamatan2" class="form-group">
                      <label>Kecamatan</label>
                      <select class="form-control" name="kecamatan2" id="kecamatan2">
                        <option value="" disable="true" selected="true">=== Silahkan Pilih === </option>
                      </select>
                      <label hidden id="id_kecamatan2" class="control-label"><i>Kecamatan harus diisi!</i></label>
                      </div>

                      <div id="input-desa2" class="form-group">
                      <label class="control-label">Nama Desa</label>
                      <select class="form-control" name="desa2" id="desa2">
                        <option value="" disable="true" selected="true">=== Silahkan Pilih === </option>
                      </select>
                      <label hidden id="id_desa2" class="control-label"><i>Desa harus diisi!</i></label>
                      </div>

                      <div id="input-pola-tanam2" class="form-group">
                      <label>Pola Tanam</label>
                      <select class="form-control" name="pola_tanam2" id="pola_tanam2">
                        <option value="" disable="true" selected="true">=== Silahkan Pilih ===</option>
                        @foreach ($pola as $key => $value)
                          <option value="{{$value->id_pola_tanam}}">{{$value->nama_pola}}</option>
                        @endforeach
                        <option value="0">Lain-lain</option>
                      </select>
                      <label hidden id="id_pola_tanam2" class="control-label"><i>Pola tanam harus diisi!</i></label>
                    </div>
                  </div>

                  <div class="col-md-12 has-error">
                  <label hidden id="id_lanjut2" class="control-label">Pastikan data yang diisikan benar!</label>
                </div>

                  <div class="form-group">
                      <div class="col-md-12">
                          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Kembali</button>
                          <button type="button" id="btnljt2" class="btn btn-primary pull-right">Lanjut</button>
                      </div>
                  </div>

                  </div>

                  <!-- Untuk tab Data Klaster -->
                  <div class="tab-pane" id="tab_4">
                    <div class="col-md-12">
                    <div id="input-titik-ikat2" class="form-group">
                      <label>Nama Titik Ikat</label>
                      <input type="text" class="form-control" name= "nama_titik_ikat2" id="nama_titik_ikat2" placeholder="Contoh : Jembatan Sekampung, Tower Operator,dll">
                      <label hidden id="id_titik_ikat2" class="control-label"><i>Titik ikat salah! (6-50 huruf).</i></label>
                    </div>
                    </div>


                      <div class="col-md-6">
                        <div class="form-group">
                          <div id="lintang_ikat2" class="form-group">
                          <label class="control-label">Lintang</label>
                          <div class="input-group">
                              <input type="text" class="form-control" placeholder="00 ᴼ 00 &rsquo; 00.00 &rdquo;" data-inputmask="'mask': ['99 ᴼ 99 &rsquo; 99.99 &rdquo;']" data-mask2 id="koor_lintang2" name="koor_lintang2">
                              <!-- insert this line -->
                              <span class="input-group-addon" style="width:0px; padding-left:0px; padding-right:0px; border:none;"></span>

                              <select class="form-control" name="pilih_lintang" id="pilih_lintang">
                                <option value="LS" selected>LS</option>
                                <option value="LU">LU</option>
                              </select>
                          </div>
                          <label hidden id="id_lintang_ikat2" class="control-label"><i>Lintang harus sesuai dengan format!</i></label>
                          </div>
                        </div>
                      </div>

                    <div class="col-md-6">
                      <div class="form-group">
                        <label class="control-label">Bujur</label>
                        <div id="bujur_ikat2" class="form-group">
                          <div class="input-group">
                              <input type="text" class="form-control" placeholder="00 ᴼ 00 &rsquo; 00.00 &rdquo;" data-inputmask="'mask': ['999 ᴼ 99 &rsquo; 99.99 &rdquo;']" data-mask2 id="koor_bujur2" name="koor_bujur2">
                              <!-- insert this line -->
                              <span class="input-group-addon" style="width:0px; padding-left:0px; padding-right:0px; border:none;"></span>

                              <select class="form-control" name="pilih_bujur" id="pilih_bujur">
                                <option value="BT" selected>BT</option>
                                <option value="BB">BB</option>
                              </select>
                          </div>
                          <label hidden id="id_bujur_ikat2" class="control-label"><i>Bujur harus sesuai dengan format!</i></label>
                          </div>
                      </div>
                    </div>

                    <div class="col-md-6">
                      <div id="input-kode-klaster-plot2" class="form-group">
                      <label>Kode Klaster Plot</label>
                      <input type="text" name="kode_klaster_plot2" id="kode_klaster_plot2" class="form-control" placeholder="Contoh : CL1,CL2,CL3,dst">
                      <label hidden id="id_kode_klaster_plot2" class="control-label"><i>Kode klaster plot salah! (3-10 huruf).</i></label>
                      </div>

                    <div id="input-luas-hutan2" class="form-group">
                      <label>Luas Hutan</label>
                      <input type="text" name="luas2" id="luas2" class="form-control" placeholder="Hektar">
                      <label hidden id="id_luas_hutan2" class="control-label"><i>Luas hutan harus diisi!</i></label>
                    </div>
                    </div>

                    <div class="col-md-6">
                      <div id="input-jarak-titik-ikat2" class="form-group">
                      <label class="control-label">Jarak titik ikat ke titik pusat plot 1</label>
                      <input type="text" name="jarak_titik_ikat2" id="jarak_titik_ikat2" class="form-control" placeholder="meter">
                      <label hidden id="id_jarak_titik_ikat2" class="control-label"><i>Jarak titik ikat harus diisi!</i></label>
                      </div>

                      <div id="input-azimuth2" class="form-group">
                      <label class="control-label">Azimuth Ke Titik Pusat Plot 1</label>
                      <input type="text" name="azimuth2" id="azimuth2" class="form-control" placeholder="o">
                      <label hidden id="id_azimuth2" class="control-label"><i>Azimuth harus diisi!</i></label>
                    </div>
                  </div>

                    <div class="col-md-6">
                      <div id="input-tahun-tanam2" class="form-group">
                      <label class="control-label">Tahun Tanam</label>
                      <input type="text" name="tahun_tanam2" id="tahun_tanam2" class="form-control" placeholder="2014, 2015, 2016, dst">
                      <label hidden id="id_tahun_tanam2" class="control-label"><i>Tahun tanam salah! (Format: 2007,2008,2009).</i></label>
                      </div>
                    </div>
                      <div class="col-md-6">
                        <div id="input-usia2" class="form-group">
                          <label class="control-label">Umur</label>
                        <input type="number" name="usia2" id="usia2" class="form-control" placeholder="tahun">
                        <label hidden id="id_usia2" class="control-label"><i>Usia salah! (Format: 1,2,3).</i></label>
                      </div>
                      </div>
                      <div class="col-md-12">
                        <h4>Jarak Tanam: </h4>
                      </div>

                    <div class="col-md-6">
                      <div id="input-panjang2" class="form-group">
                      <label class="control-label">Panjang</label>
                      <input type="number" name="jarak_tanam_x2" id="jarak_tanam_x2" class="form-control" placeholder="meter">
                      <label hidden id="id_panjang2" class="control-label"><i>Panjang harus diisi!</i></label>
                    </div>

                    </div>

                    <div class="col-md-6">
                      <div id="input-lebar2" class="form-group">
                      <label class="control-label">Lebar</label>
                      <input type="number" name="jarak_tanam_y2" id="jarak_tanam_y2" class="form-control" placeholder="meter">
                      <label hidden id="id_lebar2" class="control-label"><i>Lebar harus diisi!</i></label>
                    </div>
                  </div>

                  <div class="form-group">
                    <div class="col-md-12">
                      <button type="button" id="btnkmbli2" class="btn btn-default">Kembali</button>
                      <input type="submit" id="submit2" class="btn btn-primary pull-right" value="Simpan"/>
                    </div>
                  </div>
                  </form>
                </div>

                </div>
              </div>
            </div>
          </div>
        </div>
      <div class="modal-footer">
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
@push('script_tambahan')
<script src="{{asset('Admin/modal_ajax.min.js')}}"></script>
@endpush
<!-- InputMask -->
@section('script_tambahan')
<script src="{{asset('Admin/plugins/input-mask/jquery.inputmask.js')}}"></script>
<script src="{{asset('Admin/plugins/input-mask/jquery.inputmask.date.extensions.js')}}"></script>
<script src="{{asset('Admin/plugins/input-mask/jquery.inputmask.extensions.js')}}"></script>
@endsection

  @section('script_table')
  <script>
$('[data-mask2]').inputmask()
$(document).ready(function(){

  // variable untuk validasi, jika 0 artinya masih salah, jika 1 benar
  // 11 adalah jumlah input text nya yang menyatakan benar semua baru
  // bisa lanjut ke tab selanjutnya
  var validate2 = 0;

  // untuk validasi lintang
  var v_lintang_klaster2= 1;
  var valid_lintang_klaster = /^[0-9]{2} ᴼ [0-9]{2} ’ [0-9]{2}\.[0-9]{2} ”$/; //untuk validasi lintang
  $('#lintang_klaster2').on('keyup', function() {
  lintang_klaster2 = $('#koor_lintang2_klaster').val();
  if(lintang_klaster2.match(valid_lintang_klaster)){
    $('#lintang_klaster2').attr("class", "form-group has-success");
    $('#id_lintang_klaster2').hide();
    v_lintang_klaster2=1;
  }
  else {
    v_lintang_klaster2=0;
    $('#id_lintang_klaster2').show();
    $('#lintang_klaster2').attr("class", "form-group has-error");
  }
});

// untuk validasi bujur
var v_bujur_klaster2= 1;
var valid_bujur_klaster = /^[0-9]{3} ᴼ [0-9]{2} ’ [0-9]{2}\.[0-9]{2} ”$/; //untuk validasi bujur
$('#bujur_klaster2').on('keyup', function() {
bujur_klaster2 = $('#koor_bujur2_klaster').val();
if(bujur_klaster2.match(valid_bujur_klaster)){
  $('#bujur_klaster2').attr("class", "form-group has-success");
  $('#id_bujur_klaster2').hide();
  v_bujur_klaster2=1;
}
else {
  v_bujur_klaster2=0;
  $('#id_bujur_klaster2').show();
  $('#bujur_klaster2').attr("class", "form-group has-error");
}
});

  // untuk validasi id_klaster_plot2
  var v_klaster2= 1;
  var valid_klaster2 = /^[0-9]{1,}$/; //untuk validasi integer
  $('#klaster2').on('input', function() {
  klaster2 = $('#id_klaster_plot2').val();
  if(klaster2.match(valid_klaster2)){
    $('#klaster2').attr("class", "form-group has-success");
    $('#id_label2').hide();
    v_klaster2=1;
  }
  else {
    v_klaster2=0;
    $('#id_label2').show();
    $('#klaster2').attr("class", "form-group has-error");
  }
  });

  //validasi altitude2
  var v_altitude2=1;
  var valid_altitude2 = /^[1-9]([0-9]{0,}(\.[0-9]){0,}[0-9]{0,})$/; //untuk validasi integer
  var invalid_huruf_altitude2 = /[^0-9]/; //untuk validasi diluar integer
  $('#input-altitude2').on('input', function() {
  altitude2 = $('#altitude2').val();
  if(altitude2.match(valid_altitude2)){
    $('#input-altitude2').attr("class", "form-group has-success");
    $('#id_altitude2').hide();
    v_altitude2=1;
  }

  else if(altitude2.match(invalid_huruf_altitude2)){
   v_altitude2=0;
   $('#id_altitude2').text("Altitude harus berupa angka!");
   $('#id_altitude2').show();
   $('#input-altitude2').attr("class", "form-group has-error");
  }

   else {
    v_altitude2=0;
    $('#id_altitude2').text("Altitude harus diisi!");
    $('#id_altitude2').show();
    $('#input-altitude2').attr("class", "form-group has-error");
  }
});

  // untuk validasi kepemilikan2
  var v_pemilik2= 1;
  $('#input-pemilik2').on('change', function() {
  pemilik2 = $('#kepemilikan2').val();
  if(pemilik2!=""){
    $('#input-pemilik2').attr("class", "form-group has-success");
    $('#id_pemilik2').hide();
    v_pemilik2=1;
  }
   else {
    v_pemilik2=0;
    $('#id_pemilik2').show();
    $('#input-pemilik2').attr("class", "form-group has-error");
  }
  });

  // untuk validasi jenis hutan
  var v_jenis2=1;
  var v_fungsi2=1;
  $('#input-jenis-hutan2').on('input', function() {
  jenis2 = $('#jenis2').val();
  var valid_jenis = /^[a-zA-Z ]{6,50}$/; //untuk validasi kategori
  if(jenis2.match(valid_jenis)){
    $('#input-jenis-hutan2').attr("class", "form-group has-success");
    $('#id_jenis2').hide();
    v_jenis2=1;
  }
   else {
    v_jenis2=0;
    $('#id_jenis2').show();
    $('#input-jenis-hutan2').attr("class", "form-group has-error");
  }
  });

  // untuk validasi fungsi hutan

  $('#input-fungsi-hutan2').on('change', function() {
  fungsi2 = $('#fungsi2').val();
  if(fungsi2!=""){
    $('#input-fungsi-hutan2').attr("class", "form-group has-success");
    $('#id_fungsi2').hide();
    v_fungsi2=1;
  }
   else {
    v_fungsi2=0;
    $('#id_fungsi2').show();
    $('#input-fungsi-hutan2').attr("class", "form-group has-error");
  }
  });

  // untuk validasi nama pengelola hutan
  var v_pengelola2=1;
  $('#input-pengelola-hutan2').on('input', function() {
  pengelola2 = $('#pengelola2').val();
  var valid_pengelola = /^[a-zA-Z ]{5,50}$/; //untuk validasi kategori
  if(pengelola2.match(valid_pengelola)){
    $('#input-pengelola-hutan2').attr("class", "form-group has-success");
    $('#id_pengelola2').hide();
    v_pengelola2=1;
  }
   else {
    v_pengelola2=0;
    $('#id_pengelola2').show();
    $('#input-pengelola-hutan2').attr("class", "form-group has-error");
  }
  });

  // untuk validasi nama keterangan pengelola hutan
  var v_keterangan_pengelola2=1;
  $('#input-keterangan-pengelola2').on('change', function() {
  keterangan_pengelola2 = $('#ket_pengelola2').val();
  if(keterangan_pengelola2!=""){
    $('#input-keterangan-pengelola2').attr("class", "form-group has-success");
    $('#id_keterangan_pengelola2').hide();
    v_keterangan_pengelola2=1;
  }
   else {
    v_keterangan_pengelola2=0;
    $('#id_keterangan_pengelola2').show();
    $('#input-keterangan-pengelola2').attr("class", "form-group has-error");
  }
  });

  // untuk validasi nama provinsi
  var v_provinsi2=1;
  var v_kabupaten2=1;
  var v_kecamatan2=1;
  var v_desa2=1;
  $('#input-provinsi2').on('change', function() {
  provinsi2 = $('#provinsi2').val();
  if(provinsi2!=""){
    $('#input-provinsi2').attr("class", "form-group has-success");
    $('#id_provinsi2').hide();
    v_provinsi2=1;
    v_kabupaten2=0;
    v_kecamatan2=0;
    v_desa2=0;
    $('#id_kabupaten2').show();
    $('#input-kabupaten2').attr("class", "form-group has-error");
    $('#id_kecamatan2').show();
    $('#input-kecamatan2').attr("class", "form-group has-error");
    $('#id_desa2').show();
    $('#input-desa2').attr("class", "form-group has-error");
  }
   else {
   v_provinsi2=0;
   v_kabupaten2=0;
   v_kecamatan2=0;
   v_desa2=0;
    $('#id_provinsi2').show();
    $('#input-provinsi2').attr("class", "form-group has-error");
    $('#id_kabupaten2').show();
    $('#input-kabupaten2').attr("class", "form-group has-error");
    $('#id_kecamatan2').show();
    $('#input-kecamatan2').attr("class", "form-group has-error");
    $('#id_desa2').show();
    $('#input-desa2').attr("class", "form-group has-error");
  }
  });

  // untuk validasi nama kabupaten

  $('#input-kabupaten2').on('change', function() {
  kabupaten2 = $('#kabupaten2').val();
  if(kabupaten2!=""){
    $('#input-kabupaten2').attr("class", "form-group has-success");
    $('#id_kabupaten2').hide();
    v_kabupaten2=1;
    v_kecamatan2=0;
    v_desa2=0;
    $('#id_kecamatan2').show();
    $('#input-kecamatan2').attr("class", "form-group has-error");
    $('#id_desa2').show();
    $('#input-desa2').attr("class", "form-group has-error");
  }
   else {
    v_kabupaten2=0;
    v_kecamatan2=0;
    v_desa2=0;
    $('#id_kabupaten2').show();
    $('#input-kabupaten2').attr("class", "form-group has-error");
    $('#id_kecamatan2').show();
    $('#input-kecamatan2').attr("class", "form-group has-error");
    $('#id_desa2').show();
    $('#input-desa2').attr("class", "form-group has-error");
  }
  });

  // untuk validasi nama kecamatan

  $('#input-kecamatan2').on('change', function() {
  kecamatan2 = $('#kecamatan2').val();
  if(kecamatan2!=""){
    $('#input-kecamatan2').attr("class", "form-group has-success");
    $('#id_kecamatan2').hide();
    v_kecamatan2=1;
    v_desa2=0;
    $('#id_desa2').show();
    $('#input-desa2').attr("class", "form-group has-error");
  }
   else {
    v_kecamatan2=0;
    v_desa2=0;
    $('#id_kecamatan2').show();
    $('#input-kecamatan2').attr("class", "form-group has-error");
    $('#id_desa2').show();
    $('#input-desa2').attr("class", "form-group has-error");
  }
  });

  // untuk validasi nama desa

  $('#input-desa2').on('change', function() {
  desa2 = $('#desa2').val();
  if(desa2!=""){
    $('#input-desa2').attr("class", "form-group has-success");
    $('#id_desa2').hide();
    v_desa2=1;
  }
   else {
    v_desa2=0;
    $('#id_desa2').show();
    $('#input-desa2').attr("class", "form-group has-error");
  }
  });

  // untuk validasi pola tanam
  var v_pola_tanam2=1;
  $('#input-pola-tanam2').on('change', function() {
  pola_tanam2 = $('#pola_tanam2').val();
  if(pola_tanam2!=""){
    $('#input-pola-tanam2').attr("class", "form-group has-success");
    $('#id_pola_tanam2').hide();
    v_pola_tanam2=1;
  }
   else {
    v_pola_tanam2=0;
    $('#id_pola_tanam2').show();
    $('#input-pola-tanam2').attr("class", "form-group has-error");
  }
  });

  // untuk validasi nama titik ikat
  var v_titik_ikat2=1;
  var v_kode_klaster_plot2=1;
  var v_luas_hutan2=1;
  var v_jarak_titik_ikat2=1;
  var v_azimuth2=1;
  var v_usia2=1;
  var v_tahun_tanam2=1;
  var v_panjang2=1;
  var v_lebar2=1;
  $('#input-titik-ikat2').on('input', function() {
  titik_ikat2 = $('#nama_titik_ikat2').val();
  var valid_titik_ikat = /^[a-zA-Z ]{6,50}$/; //untuk validasi kategori
  if(titik_ikat2.match(valid_titik_ikat)){
    $('#input-titik-ikat2').attr("class", "form-group has-success");
    $('#id_titik_ikat2').hide();
    v_titik_ikat2=1;
  }
   else {
    v_titik_ikat2=0;
    $('#id_titik_ikat2').show();
    $('#input-titik-ikat2').attr("class", "form-group has-error");
  }

  if(v_titik_ikat2+ v_kode_klaster_plot2+ v_luas_hutan2+ v_jarak_titik_ikat2+ v_usia2+ v_azimuth2+ v_tahun_tanam2+ v_panjang2+ v_lebar2==9){
  $('#submit2').prop("disabled",false);
}
  else {
  $('#submit2').prop("disabled",true);
}

  });

  // untuk validasi lintang ikat
  var v_lintang_ikat2= 1;
  var valid_lintang_ikat = /^[0-9]{2} ᴼ [0-9]{2} ’ [0-9]{2}\.[0-9]{2} ”$/; //untuk validasi lintang
  $('#lintang_ikat2').on('keyup', function() {
  lintang_ikat2 = $('#koor_lintang2').val();
  if(lintang_ikat2.match(valid_lintang_ikat)){
    $('#lintang_ikat2').attr("class", "form-group has-success");
    $('#id_lintang_ikat2').hide();
    v_lintang_ikat2=1;
  }
  else {
    v_lintang_ikat2=0;
    $('#id_lintang_ikat2').show();
    $('#lintang_ikat2').attr("class", "form-group has-error");
  }
});

// untuk validasi bujur ikat
var v_bujur_ikat2= 1;
var valid_bujur_ikat = /^[0-9]{3} ᴼ [0-9]{2} ’ [0-9]{2}\.[0-9]{2} ”$/; //untuk validasi bujur
$('#bujur_ikat2').on('keyup', function() {
bujur_ikat2 = $('#koor_bujur2').val();
if(bujur_ikat2.match(valid_bujur_ikat)){
  $('#bujur_ikat2').attr("class", "form-group has-success");
  $('#id_bujur_ikat2').hide();
  v_bujur_ikat2=1;
}
else {
  v_bujur_ikat2=0;
  $('#id_bujur_ikat2').show();
  $('#bujur_ikat2').attr("class", "form-group has-error");
}
});

  // untuk validasi kode klaster plot

  $('#input-kode-klaster-plot2').on('input', function() {
  kode_klaster_plot2 = $('#kode_klaster_plot2').val();
  var valid_kode_klaster = /^[a-zA-Z][a-zA-Z0-9]{2,9}$/; //untuk validasi kode klaster
  if(kode_klaster_plot2.match(valid_kode_klaster)){
    $('#input-kode-klaster-plot2').attr("class", "form-group has-success");
    $('#id_kode_klaster_plot2').hide();
    v_kode_klaster_plot2=1;
  }
   else {
    v_kode_klaster_plot2=0;
    $('#id_kode_klaster_plot2').show();
    $('#input-kode-klaster-plot2').attr("class", "form-group has-error");
  }
  if(v_titik_ikat2+ v_kode_klaster_plot2+ v_luas_hutan2+ v_jarak_titik_ikat2+ v_usia2+v_azimuth2+ v_tahun_tanam2+ v_panjang2+ v_lebar2==9){
  $('#submit2').prop("disabled",false);
}
  else {
  $('#submit2').prop("disabled",true);
}
  });

  // untuk validasi luas hutan

  var valid_luas_hutan2 = /^[1-9]([0-9]{0,}(\.[0-9]){0,}[0-9]{0,})$/; //untuk validasi integer
  var invalid_huruf_luas_hutan2 = /[^0-9]/; //untuk validasi diluar integer
  $('#input-luas-hutan2').on('input', function() {
  luas_hutan2 = $('#luas2').val();
  if(luas_hutan2.match(valid_luas_hutan2)){
    $('#input-luas-hutan2').attr("class", "form-group has-success");
    $('#id_luas_hutan2').hide();
    v_luas_hutan2=1;
  }

  else if(luas_hutan2.match(invalid_huruf_luas_hutan2)){
   v_luas_hutan2=0;
   $('#id_luas_hutan2').text("luas hutan harus berupa angka!");
   $('#id_luas_hutan2').show();
   $('#input-luas-hutan2').attr("class", "form-group has-error");
  }

   else {
    v_luas_hutan2=0;
    $('#id_luas_hutan2').text("Luas hutan harus diisi!");
    $('#id_luas_hutan2').show();
    $('#input-luas-hutan2').attr("class", "form-group has-error");
  }
  if(v_titik_ikat2+ v_kode_klaster_plot2+ v_luas_hutan2+ v_jarak_titik_ikat2+ v_usia2+ v_azimuth2+ v_tahun_tanam2+ v_panjang2+ v_lebar2==9){
  $('#submit2').prop("disabled",false);
}
  else {
  $('#submit2').prop("disabled",true);
}
  });

  // untuk validasi jarak titik ikat

  var valid_jarak_titik_ikat2 = /^[1-9]([0-9]{0,}(\.[0-9]){0,}[0-9]{0,})$/; //untuk validasi integer
  var invalid_huruf_jarak_titik_ikat2 = /[^0-9]/; //untuk validasi diluar integer
  $('#input-jarak-titik-ikat2').on('input', function() {
  jarak_titik_ikat2 = $('#jarak_titik_ikat2').val();
  if(jarak_titik_ikat2.match(valid_jarak_titik_ikat2)){
    $('#input-jarak-titik-ikat2').attr("class", "form-group has-success");
    $('#id_jarak_titik_ikat2').hide();
    v_jarak_titik_ikat2=1;
  }

  else if(jarak_titik_ikat2.match(invalid_huruf_jarak_titik_ikat2)){
   v_jarak_titik_ikat2=0;
   $('#id_jarak_titik_ikat2').text("Jarak titik ikat harus berupa angka!");
   $('#id_jarak_titik_ikat2').show();
   $('#input-jarak-titik-ikat2').attr("class", "form-group has-error");
  }

   else { //untuk validasi isian masih kosong
    v_jarak_titik_ikat2=0;
    $('#id_jarak_titik_ikat2').text("Jarak titik ikat harus diisi!");
    $('#id_jarak_titik_ikat2').show();
    $('#input-jarak-titik-ikat2').attr("class", "form-group has-error");
  }
  if(v_titik_ikat2+ v_kode_klaster_plot2+ v_luas_hutan2+ v_jarak_titik_ikat2+ v_usia2+ v_azimuth2+ v_tahun_tanam2+ v_panjang2+ v_lebar2==9){
  $('#submit2').prop("disabled",false);
}
  else {
  $('#submit2').prop("disabled",true);
}
  });

  // untuk validasi azimuth

  var valid_azimuth2 = /^[1-9]([0-9]{0,}(\.[0-9]){0,}[0-9]{0,})$/; //untuk validasi integer
  var invalid_huruf_azimuth2 = /[^0-9]/; //untuk validasi diluar integer
  $('#input-azimuth2').on('input', function() {
  azimuth2 = $('#azimuth2').val();
  if(azimuth2.match(valid_azimuth2)){
    $('#input-azimuth2').attr("class", "form-group has-success");
    $('#id_azimuth2').hide();
    v_azimuth2=1;
  }

  else if(azimuth2.match(invalid_huruf_azimuth2)){
   v_azimuth2=0;
   $('#id_azimuth2').text("Azimuth harus berupa angka!");
   $('#id_azimuth2').show();
   $('#input-azimuth2').attr("class", "form-group has-error");
  }

   else {
    v_azimuth2=0;
    $('#id_azimuth2').text("azimuth harus diisi!");
    $('#id_azimuth2').show();
    $('#input-azimuth2').attr("class", "form-group has-error");
  }
  if(v_titik_ikat2+ v_kode_klaster_plot2+ v_luas_hutan2+ v_jarak_titik_ikat2+ v_usia2+ v_azimuth2+ v_tahun_tanam2+ v_panjang2+ v_lebar2==9){
  $('#submit2').prop("disabled",false);
}
  else {
  $('#submit2').prop("disabled",true);
}
  });

  // untuk validasi usia

  var valid_usia2 = /^[1-9]([0-9]){0,}$/; //untuk validasi integer
  var invalid_huruf_usia2 = /[^0-9]/; //untuk validasi diluar integer
  $('#input-usia2').on('input', function() {
  usia2 = $('#usia2').val();
  if(usia2.match(valid_usia2)){
    $('#input-usia2').attr("class", "form-group has-success");
    $('#id_usia2').hide();
    v_usia2=1;
  }

  else if(usia2.match(invalid_huruf_usia2)){
   v_usia2=0;
   $('#id_usia2').text("Usia harus berupa angka!");
   $('#id_usia2').show();
   $('#input-usia2').attr("class", "form-group has-error");
  }

   else {
    v_usia2=0;
    $('#id_usia2').text("Usia harus diisi!");
    $('#id_usia2').show();
    $('#input-usia2').attr("class", "form-group has-error");
  }
  if(v_titik_ikat2+ v_kode_klaster_plot2+ v_luas_hutan2+ v_jarak_titik_ikat2+ v_usia2+ v_azimuth2+ v_tahun_tanam2+ v_panjang2+ v_lebar2==9){
  $('#submit2').prop("disabled",false);
}
  else {
  $('#submit2').prop("disabled",true);
}
  });

  // untuk validasi tahun tanam

  var valid_tahun_tanam = /^([1-2][\d]{3}){0,1}(,[1-2][\d]{3}){0,2}$/; //untuk validasi tahun
  var invalid_tahun_tanam2 = /[^\d]/; //untuk validasi selain tahun
  $('#input-tahun-tanam2').on('input', function() {
  tahun_tanam2 = $('#tahun_tanam2').val();
  if(tahun_tanam2.match(valid_tahun_tanam)){
    $('#input-tahun-tanam2').attr("class", "form-group has-success");
    $('#id_tahun_tanam2').hide();
    v_tahun_tanam2=1;
  }

  else if(tahun_tanam2.match(invalid_tahun_tanam2)){
   v_tahun_tanam2=0;
   $('#id_tahun_tanam2').text("tahun tanam harus berupa angka! (Format: 2007,2008,2009).");
   $('#id_tahun_tanam2').show();
   $('#input-tahun-tanam2').attr("class", "form-group has-error");
  }

   else {
    v_tahun_tanam2=0;
    $('#id_tahun_tanam2').text("tahun tanam tidak valid!  (Format: 2007,2008,2009).");
    $('#id_tahun_tanam2').show();
    $('#input-tahun-tanam2').attr("class", "form-group has-error");
  }
  if(v_titik_ikat2+ v_kode_klaster_plot2+ v_luas_hutan2+ v_jarak_titik_ikat2+ v_usia2+ v_azimuth2+ v_tahun_tanam2+ v_panjang2+ v_lebar2==9){
  $('#submit2').prop("disabled",false);
}
  else {
  $('#submit2').prop("disabled",true);
}
  });

  // untuk validasi panjang tanam

  var valid_panjang2 = /^[1-9]([0-9]{0,}(\.[0-9]){0,}[0-9]{0,})$/; //untuk validasi integer
  var invalid_huruf_panjang2 = /[^0-9]/; //untuk validasi diluar integer
  $('#input-panjang2').on('input', function() {
  panjang2 = $('#jarak_tanam_x2').val();
  if(panjang2.match(valid_panjang2)){
    $('#input-panjang2').attr("class", "form-group has-success");
    $('#id_panjang2').hide();
    v_panjang2=1;
  }

  else if(panjang2.match(invalid_huruf_panjang2)){
   v_panjang2=0;
   $('#id_panjang2').text("panjang tidak valid!");
   $('#id_panjang2').show();
   $('#input-panjang2').attr("class", "form-group has-error");
  }

   else {
    v_panjang2=0;
    $('#id_panjang2').text("panjang harus diisi!");
    $('#id_panjang2').show();
    $('#input-panjang2').attr("class", "form-group has-error");
  }
  if(v_titik_ikat2+ v_kode_klaster_plot2+ v_luas_hutan2+ v_jarak_titik_ikat2+ v_usia2+ v_azimuth2+ v_tahun_tanam2+ v_panjang2+ v_lebar2==9){
  $('#submit2').prop("disabled",false);
}
  else {
  $('#submit2').prop("disabled",true);
}
  });

  // untuk validasi lebar tanam

  var valid_lebar2 = /^[1-9]([0-9]{0,}(\.[0-9]){0,}[0-9]{0,})$/; //untuk validasi integer
  var invalid_huruf_lebar2 = /[^0-9]/; //untuk validasi diluar integer
  $('#input-lebar2').on('input', function() {
  lebar2 = $('#jarak_tanam_y2').val();
  if(lebar2.match(valid_lebar2)){
    $('#input-lebar2').attr("class", "form-group has-success");
    $('#id_lebar2').hide();
    v_lebar2=1;
  }

  else if(lebar2.match(invalid_huruf_lebar2)) {
   v_lebar2=0;
   $('#id_lebar2').text("lebar tidak valid!");
   $('#id_lebar2').show();
   $('#input-lebar2').attr("class", "form-group has-error");
  }

   else {
    v_lebar2=0;
    $('#id_lebar2').text("lebar harus diisi!");
    $('#id_lebar2').show();
    $('#input-lebar2').attr("class", "form-group has-error");
  }
  if(v_titik_ikat2+ v_kode_klaster_plot2+ v_luas_hutan2+ v_jarak_titik_ikat2+ v_usia2+ v_azimuth2+ v_tahun_tanam2+ v_panjang2+ v_lebar2==9){
  $('#submit2').prop("disabled",false);
}
  else {
  $('#submit2').prop("disabled",true);
}
  });

    $('#provinsi2').on('change', function(e){
      var id_provinsi2 = e.target.value;
      $.ajax({
          type: 'post',
          url: '{{route("auditor.json_kabupaten2")}}',
          data: {
            '_token': $('input[name=_token]').val(),
            'id': id_provinsi2,
          },
          success: function (data) {
              if (data.length > 0) {
                $('#kabupaten2').empty();
                $('#kabupaten2').append('<option value="" disable="true" selected="true">=== Silahkan Pilih === </option>');

                $('#kecamatan2').empty();
                $('#kecamatan2').append('<option value="" disable="true" selected="true">=== Silahkan Pilih === </option>');


                $('#desa2').empty();
                $('#desa2').append('<option value="" disable="true" selected="true">=== Silahkan Pilih === </option>');

                $.each(data, function (key, value) {
                $('#kabupaten2').append('<option value="' + value['id'] + '">' + value['nama_kabupaten'] + '</option>');
                });
              }
              else{
                $('#kabupaten2').empty();
                $('#kabupaten2').append('<option value="" disable="true" selected="true">Data kosong</option>');

                $('#kecamatan2').empty();
                $('#kecamatan2').append('<option value="" disable="true" selected="true">Data kosong</option>');

                $('#desa2').empty();
                $('#desa2').append('<option value="" disable="true" selected="true">Data kosong</option>');

                }
              }
            });
    });

    $('#kabupaten2').on('change', function(e){
      var id = e.target.value;
      $.ajax({
          type: 'post',
          url: '{{route("auditor.json_kecamatan2")}}',
          data: {
            '_token': $('input[name=_token]').val(),
            'id': id,
          },
          success: function (data) {
              if (data.length > 0) {
                $('#kecamatan2').empty();
                $('#kecamatan2').append('<option value="" disable="true" selected="true">=== Silahkan Pilih === </option>');

                $('#desa2').empty();
                $('#desa2').append('<option value="" disable="true" selected="true">=== Silahkan Pilih === </option>');

                $.each(data, function (key, value) {
                $('#kecamatan2').append('<option value="' + value['id'] + '">' + value['nama_kecamatan'] + '</option>');
                });
              }
              else{
                $('#kecamatan2').empty();
                $('#kecamatan2').append('<option value="" disable="true" selected="true">Data kosong</option>');

                $('#desa2').empty();
                $('#desa2').append('<option value="" disable="true" selected="true">Data kosong</option>');

                }
              }
            });
    });

    $('#kecamatan2').on('change', function(e){
      var id = e.target.value;
      $.ajax({
          type: 'post',
          url: '{{route("auditor.json_desa2")}}',
          data: {
            '_token': $('input[name=_token]').val(),
            'id': id,
          },
          success: function (data) {
              if (data.length > 0) {
                $('#desa2').empty();
                $('#desa2').append('<option value="" disable="true" selected="true">=== Silahkan Pilih === </option>');

                $.each(data, function (key, value) {
                $('#desa2').append('<option value="' + value['id'] + '">' + value['nama_desa'] + '</option>');
                });
              }
              else{
                $('#desa2').empty();
                $('#desa2').append('<option value="" disable="true" selected="true">Data kosong</option>');

                }
              }
            });
    });

    $('#edit_klaster_plot').on('show.bs.modal', function(event){
       var button = $(event.relatedTarget);
       var klasterid = button.data('klasterid');
       var modal = $(this)
     modal.find('#id_klaster_plot2').val(klasterid);

     $.ajax({
         type: 'post',
         url: '{{route("auditor.json-data-klaster2")}}',
         data: {
           '_token': $('input[name=_token]').val(),
           'id': klasterid,
         },
         success: function (data) {
           $.each(data, function (key, value) {
           $('#altitude2').val(value['altitude']);
           $('#pengelola2').val(value['pengelola']);
           $('#ket_pengelola2').val(value['ket_pengelola']);
           $('#kepemilikan2').val(value['id_hak_milik']);
           $('#pola_tanam2').val(value['pola_tanam']);
           $('#nama_titik_ikat2').val(value['nama_titik_ikat']);
           $('#kode_klaster_plot2').val(value['nama_klaster']);
           $('#jarak_titik_ikat2').val(value['jarak_ke_titik_ikat']);
           $('#luas2').val(value['luas']);
           $('#azimuth2').val(value['azimuth']);
           $('#usia2').val(value['usia']);
           $('#lintang2').val(value['koordinat_LS']);
           $('#bujur2').val(value['koordinat_BT']);
           $('#tahun_tanam2').val(value['tahun_tanam']);
           $('#jarak_tanam_x2').val(value['jarak_tanam_x']);
           $('#jarak_tanam_y2').val(value['jarak_tanam_y']);
           $('#jenis2').val(value['tipe_hutan']);
           $('#provinsi2').val(value['id_provinsi']);
           $('#fungsi2').val(value['id_fungsi_hutan']);

           var pisah=value['koordinatBT'];
           var arr= pisah.split(' ');

           var int_bujur= parseInt(arr[0]);
           if(int_bujur>=0){
             $('#pilih_bujur').val('BT');
           }
           else{
             $('#pilih_bujur').val('BB');
           }

           var bujur = arr[0] + ' ᴼ ' + arr[1] + ' ’ ' + arr[2] + ' ”';

           var pisah2=value['koordinatLS'];
           var arr2= pisah2.split(' ');
           // lintang
           var int_lintang= parseInt(arr2[0]);
           if(int_lintang>=0){
             $('#pilih_lintang').val('LU');
           }
           else{
             $('#pilih_lintang').val('LS');
           }

           var lintang = arr2[0] + ' ᴼ ' + arr2[1] + ' ’ ' + arr2[2] + ' ”';
           $('#koor_bujur2').val(bujur);
           $('#koor_lintang2').val(lintang);

           //koordinat klaster

           var pisah_klaster=value['bujur_klaster'];
           var arr_klaster= pisah_klaster.split(' ');

           var int_bujur_klaster= parseInt(arr_klaster[0]);
           if(int_bujur_klaster>=0){
             $('#pilih_bujur_klaster').val('BT');
           }
           else{
             $('#pilih_bujur_klaster').val('BB');
           }

           var bujur_klaster = arr_klaster[0] + ' ᴼ ' + arr_klaster[1] + ' ’ ' + arr_klaster[2] + ' ”';

           var pisah2_klaster=value['lintang_klaster'];
           var arr2_klaster= pisah2_klaster.split(' ');
           // lintang
           var int_lintang_klaster= parseInt(arr2_klaster[0]);
           if(int_lintang_klaster>=0){
             $('#pilih_lintang_klaster').val('LU');
           }
           else{
             $('#pilih_lintang_klaster').val('LS');
           }

           var lintang_klaster = arr2_klaster[0] + ' ᴼ ' + arr2_klaster[1] + ' ’ ' + arr2_klaster[2] + ' ”';
           $('#koor_bujur2_klaster').val(bujur_klaster);
           $('#koor_lintang2_klaster').val(lintang_klaster);

             $.ajax({
                 type: 'post',
                 url: '{{route("auditor.json_kabupaten2")}}',
                 data: {
                   '_token': $('input[name=_token]').val(),
                   'id': value['id_provinsi'],
                 },
                 success: function (data) {
                       $('#kabupaten').empty();
                       $('#kabupaten').append('<option value="" disable="true" selected="true">=== Silahkan Pilih === </option>');
                       $.each(data, function (key, value) {
                       $('#kabupaten2').append('<option value="' + value['id'] + '">' + value['nama_kabupaten'] + '</option>');
                       });
                       $('#kabupaten2').val(value['id_kabupaten']);
                     }
                   });
                   //end ajax provinsi

                   $.ajax({
                       type: 'post',
                       url: '{{route("auditor.json_kecamatan2")}}',
                       data: {
                         '_token': $('input[name=_token]').val(),
                         'id': value['id_kabupaten'],
                       },
                       success: function (data) {
                             $('#kecamatan2').empty();
                             $('#kecamatan2').append('<option value="" disable="true" selected="true">=== Silahkan Pilih === </option>');
                             $.each(data, function (key, value) {
                             $('#kecamatan2').append('<option value="' + value['id'] + '">' + value['nama_kecamatan'] + '</option>');
                             });
                             $('#kecamatan2').val(value['id_kecamatan']);
                           }
                         });
                         //end ajax kecamatan2

                         $.ajax({
                             type: 'post',
                             url: '{{route("auditor.json_desa2")}}',
                             data: {
                               '_token': $('input[name=_token]').val(),
                               'id': value['id_kecamatan'],
                             },
                             success: function (data) {
                                   $('#desa2').empty();
                                   $('#desa2').append('<option value="" disable="true" selected="true">=== Silahkan Pilih === </option>');

                                   $.each(data, function (key, value) {
                                   $('#desa2').append('<option value="' + value['id'] + '">' + value['nama_desa'] + '</option>');
                                   });
                                   $('#desa2').val(value['id_desa']);
                                 }
                               });
                               //end ajax desa
         });
             }
           });

    });

    $('#btnljt2').click(function(e){
      validate2= v_altitude2+v_klaster2+ v_pemilik2+ v_jenis2+ v_fungsi2+ v_pengelola2+ v_keterangan_pengelola2+ v_provinsi2+ v_kabupaten2+ v_kecamatan2+ v_desa2+ v_pola_tanam2;
      // validate2=12;
      if(validate2==12){
        $('#id_lanjut2').hide();
        e.preventDefault();
        $('#tabs4').attr("href", "#tab_4");
        $('#tabedit a[href="#tab_4"]').tab('show');
        $('#tabs4').removeAttr("href");
    }
    else{
      $('#id_lanjut2').show();
    }
  });
    $('#btnkmbli2').click(function(e){
        e.preventDefault();
        $('#tabedit a[href="#tab_3"]').tab('show');
    });

    });
    </script>
@endsection