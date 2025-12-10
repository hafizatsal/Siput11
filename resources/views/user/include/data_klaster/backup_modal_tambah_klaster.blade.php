@section('css')
<link rel="stylesheet" href="{{asset('Admin/bower_components/select2/dist/css/select2.min.css')}}">
<link rel="stylesheet" href="{{asset('Admin/dist/css/AdminLTE.min.css')}}">
@endsection
<div class="modal fade" id="tambah_klaster_plot">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Tambah Data Klaster Plot</h4>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-12">
            <div class="nav-tabs-custom" id="tabtambah">
              <ul class="nav nav-tabs">
                <li id="tab5" class="active"><a href="#tab_5" data-toggle="tab">Identitas Klaster Plot Ukur (1)</a></li>
                <li id="tab6" class="disabled"><a id=tabs6>Identitas Klaster Plot Ukur (2)</a></li>
              </ul>
              <div class="tab-content">

                <!-- Untuk tab Data Hutan -->
                <div class="tab-pane active" id="tab_5">
                  <form id="formsatu" method="post" class="" action="{{route('user.insert_klaster')}}"
                  onsubmit="document.getElementById('submit').disabled=true;
                  document.getElementById('submit').value='Sedang menyimpan...';">
                  {{csrf_field()}}

                  <div class="col-md-12">
                    <h4>Koordinat Klaster: </h4>
                  </div>

                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="control-label">Lintang</label>
                      <div class="input-group">
                          <input type="text" class="form-control" placeholder="00 ᴼ 00 &rsquo; 00.00 &rdquo;" data-inputmask="'mask': ['99 ᴼ 99 &rsquo; 99.99 &rdquo;']" data-mask2 id="koor_lintang_klaster" name="koor_lintang_klaster">
                          <!-- insert this line -->
                          <span class="input-group-addon" style="width:0px; padding-left:0px; padding-right:0px; border:none;"></span>

                          <select class="form-control" name="pilih_lintang_klaster2" id="pilih_lintang_klaster2">
                            <option value="LS" selected>LS</option>
                            <option value="LU">LU</option>
                          </select>
                      </div>
                    </div>
                  </div>

                <div class="col-md-6">
                  <div class="form-group">
                    <label class="control-label">Bujur</label>
                      <div class="input-group">
                          <input type="text" class="form-control" placeholder="00 ᴼ 00 &rsquo; 00.00 &rdquo;" data-inputmask="'mask': ['999 ᴼ 99 &rsquo; 99.99 &rdquo;']" data-mask2 id="koor_bujur_klaster" name="koor_bujur_klaster">
                          <!-- insert this line -->
                          <span class="input-group-addon" style="width:0px; padding-left:0px; padding-right:0px; border:none;"></span>

                          <select class="form-control" name="pilih_bujur_klaster2" id="pilih_bujur_klaster2">
                            <option value="BT" selected>BT</option>
                            <option value="BB">BB</option>
                          </select>
                      </div>
                  </div>
                </div>

                <div class="col-md-12">
                  <div id="input-altitude" class="form-group">
                  <label class="control-label">Altitude (m dpl)</label>
                  <input type="text" class="form-control" placeholder="(m dpl)" name="altitude" id="altitude" value="">
                  <label hidden id="id_altitude" class="control-label"><i>Altitude harus diisi!</i></label>
                  </div>
                </div>

                  <div class="col-md-6">
                  <div id="input-pemilik" class="form-group">
                    <input type="hidden" id="tahun_pengukuran" name="tahun_pengukuran" value="{{$data_pengukuran->tahun_pengukuran}}">
                    <input type="hidden" id="pengukuran_ke" name="pengukuran_ke" value="{{$data_pengukuran->pengukuran_ke}}">
                    <input type="hidden" id="nama_pengukur" name="nama_pengukur" value="{{$data_pengukuran->nama_pengukur}}">
                    <label for="kepemilikan">Status Hukum Lahan</label>
                    <input type="hidden" id="id_tambah_data_klaster" name="id_tambah_data_klaster" value="{{$data_nama_klaster->id_data_klaster}}">
                    <select class="form-control" name="kepemilikan" id="kepemilikan">
                      <option value="" disable="true" selected="true">=== Pilih Status Hukum === </option>
                      @foreach ($kepemilikan as $key => $value)
                      <option value="{{$value->id_hak_milik}}">{{$value->hak_milik}}</option>
                      @endforeach
                    </select>
                    <label hidden id="id_pemilik" class="control-label"><i>Status Hukum harus diisi!</i></label>
                  </div>

                  <div id="input-jenis-hutan" class="form-group">
                    <label for="jenis">Tipe Hutan</label>
                    <input type="text" class="form-control" name="jenis" id="jenis" placeholder="Contoh: Hutan Taman Nasional">
                    <label hidden id="id_jenis" class="control-label"><i>Tipe hutan salah! (6-50 huruf).</i></label>
                  </div>

                  <div id="input-fungsi-hutan" class="form-group">
                    <label for="fungsi">Fungsi Hutan</label>
                    <select class="form-control" name="fungsi" id="fungsi">
                      <option value="" disable="true" selected="true">=== Silahkan Pilih === </option>
                      @foreach ($fungsi as $key => $value)
                        <option value="{{$value->id_fungsi_hutan}}">{{$value->fungsi}}</option>
                      @endforeach
                    </select>
                    <label hidden id="id_fungsi" class="control-label"><i>Fungsi hutan harus diisi!</i></label>
                  </div>

                  <div id="input-pengelola-hutan" class="form-group">
                    <label for="pengelola">Nama Pengelola</label>
                    <input type="text" class="form-control" name="pengelola" id="pengelola" placeholder="Pengelola">
                    <label hidden id="id_pengelola" class="control-label"><i>Nama pengelola salah! (5-50 huruf).</i></label>
                  </div>

                  <div id="input-keterangan-pengelola" class="form-group">
                  <label for="ket_pengelola">Keterangan Pengelola</label>
                  <select class="form-control" name="ket_pengelola" id="ket_pengelola">
                    <option value="" disable="true" selected="true">Silahkan Pilih</option>
                    @foreach ($jenis_pengelola as $key => $value)
                      <option value="{{$value->jenis_pengelola}}">{{$value->jenis_pengelola}}</option>
                    @endforeach
                  </select>
                  <label hidden id="id_keterangan_pengelola" class="control-label"><i>Keterangan pengelola harus diisi!</i></label>
                </div>
                  </div>

                  <div class="col-md-6">

                    <div id="input-provinsi" class="form-group">
                      <label for="provinsi">Provinsi</label>
                      <select class="form-control" name="provinsi" id="provinsi">
                        <option value="" disable="true" selected="true">=== Silahkan Pilih === </option>
                        @foreach ($provinsi as $key => $value)
                          <option value="{{$value->id_provinsi}}">{{$value->nama_provinsi}}</option>
                        @endforeach
                      </select>
                      <label hidden id="id_provinsi" class="control-label"><i>Provinsi harus diisi!</i></label>
                    </div>

                    <div id="input-kabupaten" class="form-group">
                      <label for="kabupaten">Kabupaten</label>
                      <select class="form-control" name="kabupaten" id="kabupaten">
                        <option value="" disable="true" selected="true">=== Silahkan Pilih === </option>
                      </select>
                      <label hidden id="id_kabupaten" class="control-label"><i>Kabupaten harus diisi!</i></label>
                    </div>

                    <div id="input-kecamatan" class="form-group">
                      <label for="kecamatan">Kecamatan</label>
                      <select class="form-control" name="kecamatan" id="kecamatan">
                        <option value="" disable="true" selected="true">=== Silahkan Pilih === </option>
                      </select>
                      <label hidden id="id_kecamatan" class="control-label"><i>Kecamatan harus diisi!</i></label>
                    </div>

                    <div id="input-desa" class="form-group">
                      <label for="desa">Desa</label>
                      <select class="form-control" name="desa" id="desa">
                        <option value="" disable="true" selected="true">=== Silahkan Pilih === </option>
                      </select>
                      <label hidden id="id_desa" class="control-label"><i>Desa harus diisi!</i></label>
                    </div>

                    <div id="input-pola-tanam" class="form-group">
                      <label for="pola_tanam">Pola Tanam</label>
                      <select class="form-control" name="pola_tanam" id="pola_tanam">
                        <option value="" disable="true" selected="true">=== Silahkan Pilih ===</option>
                        @foreach ($pola as $key => $value)
                          <option value="{{$value->id_pola_tanam}}">{{$value->nama_pola}}</option>
                        @endforeach
                        <option value="0">Lain-lain</option>
                      </select>
                      <label hidden id="id_pola_tanam" class="control-label"><i>Pola tanam harus diisi!</i></label>
                    </div>
                  </div>

                  <div class="col-md-12 has-error">
                  <label hidden id="id_lanjut" class="control-label">Pastikan data yang diisikan benar!</label>
                </div>

                  <div class="form-group">
                      <div class="col-md-12">
                          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Kembali</button>
                          <button type="button" id="btnljt" class="btn btn-primary pull-right">Lanjut</button>
                      </div>
                  </div>

                </div>

                <!-- Untuk tab Data Klaster -->
                <div class="tab-pane" id="tab_6">
                  <div class="col-md-12">
                    <div id="input-titik-ikat" class="form-group">
                        <label class="control-label">Nama Titik Ikat</label>
                        <input type="text" class="form-control" name= "nama_titik_ikat" id="nama_titik_ikat" placeholder="Contoh : Jembatan Sekampung, Tower Operator,dll">
                        <label hidden id="id_titik_ikat" class="control-label"><i>Titik ikat salah! (6-50 huruf).</i></label>
                    </div>
                  </div>

                    <div class="col-md-6">
                      <div class="form-group">
                        <label class="control-label">Lintang</label>
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="00 ᴼ 00 &rsquo; 00.00 &rdquo;" data-inputmask="'mask': ['99 ᴼ 99 &rsquo; 99.99 &rdquo;']" data-mask2 id="koor_lintang" name="koor_lintang">
                            <!-- insert this line -->
                            <span class="input-group-addon" style="width:0px; padding-left:0px; padding-right:0px; border:none;"></span>

                            <select class="form-control" name="pilih_lintang2" id="pilih_lintang2">
                              <option value="LS" selected>LS</option>
                              <option value="LU">LU</option>
                            </select>
                        </div>
                      </div>
                    </div>

                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="control-label">Bujur</label>
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="00 ᴼ 00 &rsquo; 00.00 &rdquo;" data-inputmask="'mask': ['999 ᴼ 99 &rsquo; 99.99 &rdquo;']" data-mask2 id="koor_bujur" name="koor_bujur">
                            <!-- insert this line -->
                            <span class="input-group-addon" style="width:0px; padding-left:0px; padding-right:0px; border:none;"></span>

                            <select class="form-control" name="pilih_bujur2" id="pilih_bujur2">
                              <option value="BT" selected>BT</option>
                              <option value="BB">BB</option>
                            </select>
                        </div>
                    </div>
                  </div>

                    <div class="col-md-6">
                      <div id="input-kode-klaster-plot" class="form-group">
                          <label class="control-label">Kode Klaster Plot</label>
                          <input type="text" name="kode_klaster_plot" id="kode_klaster_plot" class="form-control" placeholder="Contoh : CL1,CL2,CL3,dst">
                          <label hidden id="id_kode_klaster_plot" class="control-label"><i>Kode klaster plot salah! (3-10 huruf).</i></label>
                      </div>

                      <div id="input-luas-hutan" class="form-group">
                          <label class="control-label">Luas Hutan</label>
                          <input type="text" name="luas" id="luas" class="form-control" placeholder="Hektar">
                          <label hidden id="id_luas_hutan" class="control-label"><i>Luas hutan harus diisi!</i></label>
                      </div>
                    </div>

                    <div class="col-md-6">
                      <div id="input-jarak-titik-ikat" class="form-group">
                          <label class="control-label">Jarak titik ikat ke titik pusat plot 1</label>
                          <input type="text" name="jarak_titik_ikat" id="jarak_titik_ikat" class="form-control" placeholder="meter">
                          <label hidden id="id_jarak_titik_ikat" class="control-label"><i>Jarak titik ikat harus diisi!</i></label>
                      </div>

                      <div id="input-azimuth" class="form-group">
                          <label class="control-label">Azimuth Ke Titik Pusat Plot 1</label>
                          <input type="text" name="azimuth" id="azimuth" class="form-control" placeholder="o">
                          <label hidden id="id_azimuth" class="control-label"><i>Azimuth harus diisi!</i></label>
                      </div>
                    </div>

                    <div class="col-md-6">
                      <div id="input-tahun-tanam" class="form-group">
                      <label class="control-label">Tahun Tanam</label>
                      <input type="text" name="tahun_tanam" id="tahun_tanam" class="form-control" placeholder="2014, 2015, 2016, dst">
                      <label hidden id="id_tahun_tanam" class="control-label"><i>Tahun tanam salah! (Format: 2007,2008,2009).</i></label>
                      </div>
                    </div>
                      <div class="col-md-6">
                        <div id="input-usia" class="form-group">
                          <label class="control-label">Umur</label>
                        <input type="number" name="usia" id="usia" class="form-control" placeholder="tahun">
                        <label hidden id="id_usia" class="control-label"><i>Usia salah! (Format: 1,2,3).</i></label>
                      </div>
                      </div>
                      <div class="col-md-12">
                        <h4>Jarak Tanam: </h4>
                      </div>

                    <div class="col-md-6">
                      <div id="input-panjang" class="form-group">
                          <label class="control-label">Panjang</label>
                          <input type="number" name="jarak_tanam_x" id="jarak_tanam_x" class="form-control" placeholder="meter">
                          <label hidden id="id_panjang" class="control-label"><i>Panjang harus diisi!</i></label>
                      </div>

                    </div>

                    <div class="col-md-6">
                      <div id="input-lebar" class="form-group">
                          <label class="control-label">Lebar</label>
                          <input type="number" name="jarak_tanam_y" id="jarak_tanam_y" class="form-control" placeholder="meter">
                          <label hidden id="id_lebar" class="control-label"><i>Lebar harus diisi!</i></label>
                      </div>
                    </div>

                    <div class="form-group">
                      <div class="col-md-12">
                        <button type="button" id="btnkmbli" class="btn btn-default">Kembali</button>
                        <input type="submit" disabled id="submit" class="btn btn-primary pull-right" value="Simpan"/>
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
<script src="{{asset('Admin/modal_ajax.min.js')}}"></script>
<!-- InputMask -->
<script src="{{asset('Admin/plugins/input-mask/jquery.inputmask.js')}}"></script>
<script src="{{asset('Admin/plugins/input-mask/jquery.inputmask.date.extensions.js')}}"></script>
<script src="{{asset('Admin/plugins/input-mask/jquery.inputmask.extensions.js')}}"></script>
<script src="{{asset('Admin/bower_components/select2/dist/js/select2.full.min.js')}}"></script>

  <script type="text/javascript">
  $('#test_multi').select2();
  $('[data-mask]').inputmask()

$(document).ready(function(){
  // variable untuk validasi, jika 0 artinya masih salah, jika 1 benar
  // 11 adalah jumlah input text nya yang menyatakan benar semua baru
  // bisa lanjut ke tab selanjutnya
  var validate = 0;
// untuk validasi kepemilikan

//validasi altitude2
var valid_altitude = /^[1-9]([0-9]{0,}(\.[0-9]){0,}[0-9]{0,})$/; //untuk validasi integer
var invalid_huruf_altitude = /[^0-9]/; //untuk validasi diluar integer
$('#input-altitude').on('input', function() {
altitude = $('#altitude').val();
if(altitude.match(valid_altitude)){
  $('#input-altitude').attr("class", "form-group has-success");
  $('#id_altitude').hide();
  v_altitude=1;
}

else if(altitude.match(invalid_huruf_altitude)){
 v_altitude=0;
 $('#id_altitude').text("Altitude harus berupa angka!");
 $('#id_altitude').show();
 $('#input-altitude').attr("class", "form-group has-error");
}

 else {
  v_altitude=0;
  $('#id_altitude').text("Altitude harus diisi!");
  $('#id_altitude').show();
  $('#input-altitude').attr("class", "form-group has-error");
}
});

var v_pemilik= 0;
$('#input-pemilik').on('change', function() {
  pemilik = $('#kepemilikan').val();
  if(pemilik!=""){
    $('#input-pemilik').attr("class", "form-group has-success");
    $('#id_pemilik').hide();
    v_pemilik=1;
  }
   else {
    v_pemilik=0;
    $('#id_pemilik').show();
    $('#input-pemilik').attr("class", "form-group has-error");
  }
});

// untuk validasi jenis hutan
var v_jenis=0;
$('#input-jenis-hutan').on('input', function() {
  jenis = $('#jenis').val();
  var valid_jenis = /^[a-zA-Z ]{6,50}$/; //untuk validasi kategori
  if(jenis.match(valid_jenis)){
    $('#input-jenis-hutan').attr("class", "form-group has-success");
    $('#id_jenis').hide();
    v_jenis=1;
  }
   else {
    v_jenis=0;
    $('#id_jenis').show();
    $('#input-jenis-hutan').attr("class", "form-group has-error");
  }
});

// untuk validasi fungsi hutan
var v_fungsi=0;
$('#input-fungsi-hutan').on('change', function() {
  fungsi = $('#fungsi').val();
  if(fungsi!=""){
    $('#input-fungsi-hutan').attr("class", "form-group has-success");
    $('#id_fungsi').hide();
    v_fungsi=1;
  }
   else {
    v_fungsi=0;
    $('#id_fungsi').show();
    $('#input-fungsi-hutan').attr("class", "form-group has-error");
  }
});

// untuk validasi nama pengelola hutan
var v_pengelola=0;
$('#input-pengelola-hutan').on('input', function() {
  var valid_pengelola = /^[a-zA-Z ]{5,50}$/; //untuk validasi kategori
  pengelola = $('#pengelola').val();
  if(pengelola.match(valid_pengelola)){
    $('#input-pengelola-hutan').attr("class", "form-group has-success");
    $('#id_pengelola').hide();
    v_pengelola=1;
  }
   else {
    v_pengelola=0;
    $('#id_pengelola').show();
    $('#input-pengelola-hutan').attr("class", "form-group has-error");
  }
});

// untuk validasi nama keterangan pengelola hutan
var v_keterangan_pengelola=0;
$('#input-keterangan-pengelola').on('change', function() {
  keterangan_pengelola = $('#ket_pengelola').val();
  if(keterangan_pengelola!=""){
    $('#input-keterangan-pengelola').attr("class", "form-group has-success");
    $('#id_keterangan_pengelola').hide();
    v_keterangan_pengelola=1;
  }
   else {
    v_keterangan_pengelola=0;
    $('#id_keterangan_pengelola').show();
    $('#input-keterangan-pengelola').attr("class", "form-group has-error");
  }
});

// untuk validasi nama provinsi
var v_provinsi=0;
var v_kabupaten=0;
var v_kecamatan=0;
var v_desa=0;
$('#input-provinsi').on('change', function() {
  provinsi = $('#provinsi').val();
  if(provinsi!=""){
    $('#input-provinsi').attr("class", "form-group has-success");
    $('#id_provinsi').hide();
    v_provinsi=1;
    v_kabupaten=0;
    v_kecamatan=0;
    v_desa=0;
    $('#id_kabupaten').show();
    $('#input-kabupaten').attr("class", "form-group has-error");
    $('#id_kecamatan').show();
    $('#input-kecamatan').attr("class", "form-group has-error");
    $('#id_desa').show();
    $('#input-desa').attr("class", "form-group has-error");
  }
   else {
   v_provinsi=0;
   v_kabupaten=0;
   v_kecamatan=0;
   v_desa=0;
    $('#id_provinsi').show();
    $('#input-provinsi').attr("class", "form-group has-error");
    $('#id_kabupaten').show();
    $('#input-kabupaten').attr("class", "form-group has-error");
    $('#id_kecamatan').show();
    $('#input-kecamatan').attr("class", "form-group has-error");
    $('#id_desa').show();
    $('#input-desa').attr("class", "form-group has-error");
  }
});

// untuk validasi nama kabupaten

$('#input-kabupaten').on('change', function() {
  kabupaten = $('#kabupaten').val();
  if(kabupaten!=""){
    $('#input-kabupaten').attr("class", "form-group has-success");
    $('#id_kabupaten').hide();
    v_kabupaten=1;
    v_kecamatan=0;
    v_desa=0;
    $('#id_kecamatan').show();
    $('#input-kecamatan').attr("class", "form-group has-error");
    $('#id_desa').show();
    $('#input-desa').attr("class", "form-group has-error");
  }
   else {
    v_kabupaten=0;
    v_kecamatan=0;
    v_desa=0;
    $('#id_kabupaten').show();
    $('#input-kabupaten').attr("class", "form-group has-error");
    $('#id_kecamatan').show();
    $('#input-kecamatan').attr("class", "form-group has-error");
    $('#id_desa').show();
    $('#input-desa').attr("class", "form-group has-error");
  }
});

// untuk validasi nama kecamatan

$('#input-kecamatan').on('change', function() {
  kecamatan = $('#kecamatan').val();
  if(kecamatan!=""){
    $('#input-kecamatan').attr("class", "form-group has-success");
    $('#id_kecamatan').hide();
    v_kecamatan=1;
    v_desa=0;
    $('#id_desa').show();
    $('#input-desa').attr("class", "form-group has-error");
  }
   else {
    v_kecamatan=0;
    v_desa=0;
    $('#id_kecamatan').show();
    $('#input-kecamatan').attr("class", "form-group has-error");
    $('#id_desa').show();
    $('#input-desa').attr("class", "form-group has-error");
  }
});

// untuk validasi nama desa

$('#input-desa').on('change', function() {
  desa = $('#desa').val();
  if(desa!=""){
    $('#input-desa').attr("class", "form-group has-success");
    $('#id_desa').hide();
    v_desa=1;
  }
   else {
    v_desa=0;
    $('#id_desa').show();
    $('#input-desa').attr("class", "form-group has-error");
  }
});

// untuk validasi pola tanam
var v_pola_tanam=0;
$('#input-pola-tanam').on('change', function() {
  pola_tanam = $('#pola_tanam').val();
  if(pola_tanam!=""){
    $('#input-pola-tanam').attr("class", "form-group has-success");
    $('#id_pola_tanam').hide();
    v_pola_tanam=1;
  }
   else {
    v_pola_tanam=0;
    $('#id_pola_tanam').show();
    $('#input-pola-tanam').attr("class", "form-group has-error");
  }
});

// untuk validasi nama titik ikat
var v_titik_ikat=0;
var v_kode_klaster_plot=0;
var v_luas_hutan=0;
var v_jarak_titik_ikat=0;
var v_azimuth=0;
var v_usia=0;
var v_tahun_tanam=1;
var v_panjang=1;
var v_lebar=1;
$('#input-titik-ikat').on('input', function() {
  titik_ikat = $('#nama_titik_ikat').val();
  var valid_titik_ikat = /^[a-zA-Z ]{6,50}$/; //untuk validasi kategori
  if(titik_ikat.match(valid_titik_ikat)){
    $('#input-titik-ikat').attr("class", "form-group has-success");
    $('#id_titik_ikat').hide();
    v_titik_ikat=1;
  }
   else {
    v_titik_ikat=0;
    $('#id_titik_ikat').show();
    $('#input-titik-ikat').attr("class", "form-group has-error");
  }
  if(v_titik_ikat+ v_kode_klaster_plot+ v_luas_hutan+ v_jarak_titik_ikat+ v_usia+ v_azimuth+ v_tahun_tanam+ v_panjang+ v_lebar==9){
  $('#submit').prop("disabled",false);
}
  else {
  $('#submit').prop("disabled",true);
}
});

// untuk validasi kode klaster plot

$('#input-kode-klaster-plot').on('input', function() {
  kode_klaster_plot = $('#kode_klaster_plot').val();
  var valid_kode_klaster = /^[a-zA-Z][a-zA-Z0-9]{2,9}$/; //untuk validasi kode klaster
  if(kode_klaster_plot.match(valid_kode_klaster)){
    $('#input-kode-klaster-plot').attr("class", "form-group has-success");
    $('#id_kode_klaster_plot').hide();
    v_kode_klaster_plot=1;
  }
   else {
    v_kode_klaster_plot=0;
    $('#id_kode_klaster_plot').show();
    $('#input-kode-klaster-plot').attr("class", "form-group has-error");
  }
  if(v_titik_ikat+ v_kode_klaster_plot+ v_luas_hutan+ v_jarak_titik_ikat+ v_usia+ v_azimuth+ v_tahun_tanam+ v_panjang+ v_lebar==9){
  $('#submit').prop("disabled",false);
}
  else {
  $('#submit').prop("disabled",true);
}
});

// untuk validasi luas hutan

var valid_luas_hutan = /^[1-9]([0-9]{0,}(\.[0-9]){0,}[0-9]{0,})$/; //untuk validasi integer
var invalid_huruf_luas_hutan = /[^0-9]/; //untuk validasi diluar integer
$('#input-luas-hutan').on('input', function() {
  luas_hutan = $('#luas').val();
  if(luas_hutan.match(valid_luas_hutan)){
    $('#input-luas-hutan').attr("class", "form-group has-success");
    $('#id_luas_hutan').hide();
    v_luas_hutan=1;
  }

  else if(luas_hutan.match(invalid_huruf_luas_hutan)){
   v_luas_hutan=0;
   $('#id_luas_hutan').text("luas hutan harus berupa angka!");
   $('#id_luas_hutan').show();
   $('#input-luas-hutan').attr("class", "form-group has-error");
 }

   else {
    v_luas_hutan=0;
    $('#id_luas_hutan').text("Luas hutan harus diisi!");
    $('#id_luas_hutan').show();
    $('#input-luas-hutan').attr("class", "form-group has-error");
  }
  if(v_titik_ikat+ v_kode_klaster_plot+ v_luas_hutan+ v_jarak_titik_ikat+ v_usia+ v_azimuth+ v_tahun_tanam+ v_panjang+ v_lebar==9){
  $('#submit').prop("disabled",false);
}
  else {
  $('#submit').prop("disabled",true);
}
});

// untuk validasi jarak titik ikat

var valid_jarak_titik_ikat = /^[1-9]([0-9]{0,}(\.[0-9]){0,}[0-9]{0,})$/; //untuk validasi integer
var invalid_huruf_jarak_titik_ikat = /[^0-9]/; //untuk validasi diluar integer
$('#input-jarak-titik-ikat').on('input', function() {
  jarak_titik_ikat = $('#jarak_titik_ikat').val();
  if(jarak_titik_ikat.match(valid_jarak_titik_ikat)){
    $('#input-jarak-titik-ikat').attr("class", "form-group has-success");
    $('#id_jarak_titik_ikat').hide();
    v_jarak_titik_ikat=1;
  }

  else if(jarak_titik_ikat.match(invalid_huruf_jarak_titik_ikat)){
   v_jarak_titik_ikat=0;
   $('#id_jarak_titik_ikat').text("Jarak titik ikat harus berupa angka!");
   $('#id_jarak_titik_ikat').show();
   $('#input-jarak-titik-ikat').attr("class", "form-group has-error");
 }

   else { //untuk validasi isian masih kosong
    v_jarak_titik_ikat=0;
    $('#id_jarak_titik_ikat').text("Jarak titik ikat harus diisi!");
    $('#id_jarak_titik_ikat').show();
    $('#input-jarak-titik-ikat').attr("class", "form-group has-error");
  }
  if(v_titik_ikat+ v_kode_klaster_plot+ v_luas_hutan+ v_jarak_titik_ikat+ v_usia+ v_azimuth+ v_tahun_tanam+ v_panjang+ v_lebar==9){
  $('#submit').prop("disabled",false);
}
  else {
  $('#submit').prop("disabled",true);
}
});

// untuk validasi azimuth

var valid_azimuth = /^[1-9]([0-9]{0,}(\.[0-9]){0,}[0-9]{0,})$/; //untuk validasi integer
var invalid_huruf_azimuth = /[^0-9]/; //untuk validasi diluar integer
$('#input-azimuth').on('input', function() {
  azimuth = $('#azimuth').val();
  if(azimuth.match(valid_azimuth)){
    $('#input-azimuth').attr("class", "form-group has-success");
    $('#id_azimuth').hide();
    v_azimuth=1;
  }

  else if(azimuth.match(invalid_huruf_azimuth)){
   v_azimuth=0;
   $('#id_azimuth').text("Azimuth harus berupa angka!");
   $('#id_azimuth').show();
   $('#input-azimuth').attr("class", "form-group has-error");
 }

   else {
    v_azimuth=0;
    $('#id_azimuth').text("azimuth harus diisi!");
    $('#id_azimuth').show();
    $('#input-azimuth').attr("class", "form-group has-error");
  }
  if(v_titik_ikat+ v_kode_klaster_plot+ v_luas_hutan+ v_jarak_titik_ikat+ v_usia+ v_azimuth+ v_tahun_tanam+ v_panjang+ v_lebar==9){
  $('#submit').prop("disabled",false);
}
  else {
  $('#submit').prop("disabled",true);
}
});

// untuk validasi usia

var valid_usia = /^[1-9]([0-9]){0,}$/; //untuk validasi integer
var invalid_huruf_usia = /[^0-9]/; //untuk validasi diluar integer
$('#input-usia').on('input', function() {
usia = $('#usia').val();
if(usia.match(valid_usia)){
  $('#input-usia').attr("class", "form-group has-success");
  $('#id_usia').hide();
  v_usia=1;
}

else if(usia.match(invalid_huruf_usia)){
 v_usia=0;
 $('#id_usia').text("Usia harus berupa angka!");
 $('#id_usia').show();
 $('#input-usia').attr("class", "form-group has-error");
}

 else {
  v_usia=0;
  $('#id_usia').text("Usia harus diisi!");
  $('#id_usia').show();
  $('#input-usia').attr("class", "form-group has-error");
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
var invalid_tahun_tanam = /[^\d]/; //untuk validasi selain tahun
$('#input-tahun-tanam').on('input', function() {
  tahun_tanam = $('#tahun_tanam').val();
  if(tahun_tanam.match(valid_tahun_tanam)){
    $('#input-tahun-tanam').attr("class", "form-group has-success");
    $('#id_tahun_tanam').hide();
    v_tahun_tanam=1;
  }

  else if(tahun_tanam.match(invalid_tahun_tanam)){
   v_tahun_tanam=0;
   $('#id_tahun_tanam').text("tahun tanam harus berupa angka! (Format: 2007,2008,2009).");
   $('#id_tahun_tanam').show();
   $('#input-tahun-tanam').attr("class", "form-group has-error");
 }

   else {
    v_tahun_tanam=0;
    $('#id_tahun_tanam').text("tahun tanam tidak valid!  (Format: 2007,2008,2009).");
    $('#id_tahun_tanam').show();
    $('#input-tahun-tanam').attr("class", "form-group has-error")
  }
  if(v_titik_ikat+ v_kode_klaster_plot+ v_luas_hutan+ v_jarak_titik_ikat+ v_azimuth+ v_tahun_tanam+ v_panjang+ v_lebar==8){
  $('#submit').prop("disabled",false);
}
  else {
  $('#submit').prop("disabled",true);
}
});

// untuk validasi panjang tanam

var valid_panjang = /^[1-9]([0-9]{0,}(\.[0-9]){0,}[0-9]{0,})$/; //untuk validasi integer
var invalid_huruf_panjang = /[^0-9]/; //untuk validasi diluar integer
$('#input-panjang').on('input', function() {
  panjang = $('#jarak_tanam_x').val();
  if(panjang.match(valid_panjang)){
    $('#input-panjang').attr("class", "form-group has-success");
    $('#id_panjang').hide();
    v_panjang=1;
  }

  else if(panjang.match(invalid_huruf_panjang)){
   v_panjang=0;
   $('#id_panjang').text("panjang tidak valid!");
   $('#id_panjang').show();
   $('#input-panjang').attr("class", "form-group has-error");
 }

   else {
    v_panjang=0;
    $('#id_panjang').text("panjang harus diisi!");
    $('#id_panjang').show();
    $('#input-panjang').attr("class", "form-group has-error");
  }
  if(v_titik_ikat+ v_kode_klaster_plot+ v_luas_hutan+ v_jarak_titik_ikat+ v_usia+ v_azimuth+ v_tahun_tanam+ v_panjang+ v_lebar==9){
  $('#submit').prop("disabled",false);
}
  else {
  $('#submit').prop("disabled",true);
}
});

// untuk validasi lebar tanam

var valid_lebar = /^[1-9]([0-9]{0,}(\.[0-9]){0,}[0-9]{0,})$/; //untuk validasi integer
var invalid_huruf_lebar = /[^0-9]/; //untuk validasi diluar integer
$('#input-lebar').on('input', function() {
  lebar = $('#jarak_tanam_y').val();
  if(lebar.match(valid_lebar)){
    $('#input-lebar').attr("class", "form-group has-success");
    $('#id_lebar').hide();
    v_lebar=1;
  }

  else if(lebar.match(invalid_huruf_lebar)) {
   v_lebar=0;
   $('#id_lebar').text("lebar tidak valid!");
   $('#id_lebar').show();
   $('#input-lebar').attr("class", "form-group has-error");
 }

   else {
    v_lebar=0;
    $('#id_lebar').text("lebar harus diisi!");
    $('#id_lebar').show();
    $('#input-lebar').attr("class", "form-group has-error");
  }
  if(v_titik_ikat+ v_kode_klaster_plot+ v_luas_hutan+ v_jarak_titik_ikat+ v_usia+ v_azimuth+ v_tahun_tanam+ v_panjang+ v_lebar==9){
  $('#submit').prop("disabled",false);
}
  else {
  $('#submit').prop("disabled",true);
}
});

  $('#provinsi').on('change', function(e){
    var id_provinsi = e.target.value;
    $.ajax({
        type: 'post',
        url: '{{route("user.json_kabupaten2")}}',
        data: {
          '_token': $('input[name=_token]').val(),
          'id': id_provinsi,
        },
        success: function (data) {
            if (data.length > 0) {
              $('#kabupaten').empty();
              $('#kabupaten').append('<option value="" disable="true" selected="true">=== Silahkan Pilih === </option>');

              $('#kecamatan').empty();
              $('#kecamatan').append('<option value="" disable="true" selected="true">=== Silahkan Pilih === </option>');


              $('#desa').empty();
              $('#desa').append('<option value="" disable="true" selected="true">=== Silahkan Pilih === </option>');

              $.each(data, function (key, value) {
              $('#kabupaten').append('<option value="' + value['id'] + '">' + value['nama_kabupaten'] + '</option>');
              });
            }
            else{
              $('#kabupaten').empty();
              $('#kabupaten').append('<option value="" disable="true" selected="true">Data kosong</option>');

              $('#kecamatan').empty();
              $('#kecamatan').append('<option value="" disable="true" selected="true">Data kosong</option>');

              $('#desa').empty();
              $('#desa').append('<option value="" disable="true" selected="true">Data kosong</option>');

              }
            }
          });
        });

  $('#kabupaten').on('change', function(e){
    var id = e.target.value;
    $.ajax({
        type: 'post',
        url: '{{route("user.json_kecamatan2")}}',
        data: {
          '_token': $('input[name=_token]').val(),
          'id': id,
        },
        success: function (data) {
            if (data.length > 0) {
              $('#kecamatan').empty();
              $('#kecamatan').append('<option value="" disable="true" selected="true">=== Silahkan Pilih === </option>');

              $('#desa').empty();
              $('#desa').append('<option value="" disable="true" selected="true">=== Silahkan Pilih === </option>');

              $.each(data, function (key, value) {
              $('#kecamatan').append('<option value="' + value['id'] + '">' + value['nama_kecamatan'] + '</option>');
              });
            }
            else{
              $('#kecamatan').empty();
              $('#kecamatan').append('<option value="" disable="true" selected="true">Data kosong</option>');

              $('#desa').empty();
              $('#desa').append('<option value="" disable="true" selected="true">Data kosong</option>');

              }
            }
          });
  });

  $('#kecamatan').on('change', function(e){
    var id = e.target.value;
    $.ajax({
        type: 'post',
        url: '{{route("user.json_desa2")}}',
        data: {
          '_token': $('input[name=_token]').val(),
          'id': id,
        },
        success: function (data) {
            if (data.length > 0) {
              $('#desa').empty();
              $('#desa').append('<option value="" disable="true" selected="true">=== Silahkan Pilih === </option>');

              $.each(data, function (key, value) {
              $('#desa').append('<option value="' + value['id'] + '">' + value['nama_desa'] + '</option>');
              });
            }
            else{
              $('#desa').empty();
              $('#desa').append('<option value="" disable="true" selected="true">Data kosong</option>');

              }
            }
          });
  });

  $('#btnljt').click(function(e){
    validate= v_altitude+v_pemilik+ v_jenis+ v_fungsi+ v_pengelola+ v_keterangan_pengelola+ v_provinsi+ v_kabupaten+ v_kecamatan+ v_desa+ v_pola_tanam;
    // validate=11;
    if(validate==11){
      $('#id_lanjut').hide();
      e.preventDefault();
      $('#tabs6').attr("href", "#tab_6");
      $('#tabtambah a[href="#tab_6"]').tab('show');
      $('#tabs6').removeAttr("href");
    }
    else{
      $('#id_lanjut').show();
    }
  });
  $('#btnkmbli').click(function(e){
      e.preventDefault();
      $('#tabtambah a[href="#tab_5"]').tab('show');
  });

});
</script>
