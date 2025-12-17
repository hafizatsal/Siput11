<div class="modal fade" id="tambah_klaster_plot">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span>
				</button>
				<h4 class="modal-title">Tambah Data Klaster Plot</h4>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-md-12">
						<div class="nav-tabs-custom" id="tabtambah">
							<ul class="nav nav-tabs">
								<li id="tab5" class="active"><a id="tabs5" href="#tab_5">Identitas Klaster Plot Ukur</a>
								</li>
								<li id="tab6" class="disabled"><a id=tabs6>Titik Ikat Klaster Plot Ukur</a>
								</li>
							</ul>
							<div class="tab-content">
								<!-- tab 5 -->
								<div class="tab-pane active" id="tab_5">
                  <form id="formsatu" method="post">
                  {{csrf_field()}}
                    <input type="hidden" id="id_tambah_data_klaster" name="id_tambah_data_klaster" value="{{$data_nama_klaster->id_data_klaster}}">
                    <input type="hidden" id="tahun_pengukuran" name="tahun_pengukuran" value="{{$data_pengukuran->tahun_pengukuran}}">
                    <input type="hidden" id="pengukuran_ke" name="pengukuran_ke" value="{{$data_pengukuran->pengukuran_ke}}">
                    <input type="hidden" id="nama_pengukur" name="nama_pengukur" value="{{$data_pengukuran->nama_pengukur}}">
                    <!-- kode klaster plot dan status-->
										<div class="row">
											<div class="col-md-6">
												<div id="input-kode-klaster-plot" class="form-group">
													<label>Kode Klaster Plot *</label>
													<input type="text" name="kode_klaster_plot" id="kode_klaster_plot" class="form-control" placeholder="Contoh : CL1,CL2,CL3,dst">
													<label hidden id="id_kode_klaster_plot" class="control-label"><i>Kode klaster plot salah! (3-10 huruf).</i>
													</label>
												</div>
											</div>
											<div class="col-md-6">
												<div id="input-pemilik" class="form-group">
													<label class="control-label">Status Hukum Lahan *</label>
													<select class="form-control" name="kepemilikan" id="kepemilikan">
														<option value="" disable="true" selected="true">=== Pilih Status Hukum ===</option>
                            @foreach ($kepemilikan as $key => $value)
														<option value="{{$value->id_hak_milik}}">{{$value->hak_milik}}</option>
                            @endforeach</select>
													<label hidden id="id_pemilik" class="control-label"><i>Kepemilikan harus diisi!</i>
													</label>
												</div>
											</div>
										</div>
										<!-- jenis fungsi -->
										<div class="row">
											<div class="col-md-6">
												<div id="input-jenis-hutan" class="form-group">
													<label class="control-label">Tipe Hutan *</label>
													<input type="text" class="form-control" name="jenis" id="jenis" placeholder="Contoh: Hutan Taman Nasional">
													<label hidden id="id_jenis" class="control-label"><i>Tipe hutan salah! (2-50 huruf).</i>
													</label>
												</div>
											</div>
											<div class="col-md-6">
												<div id="input-fungsi-hutan" class="form-group">
													<label>Fungsi Hutan *</label>
													<select class="form-control" name="fungsi" id="fungsi">
														<option value="" disable="true" selected="true">=== Silahkan Pilih ===</option>@foreach ($fungsi as $key => $value)
														<option value="{{$value->id_fungsi_hutan}}">{{$value->fungsi}}</option>@endforeach</select>
													<label hidden id="id_fungsi" class="control-label"><i>Fungsi hutan harus diisi!</i>
													</label>
												</div>
											</div>
										</div>
										<!-- provinsi -->
										<div class="row">
											<div class="col-md-12">
												<div id="input-provinsi" class="form-group">
													<label>Provinsi *</label>
													<select class="form-control" name="provinsi" id="provinsi">
														<option value="" disable="true" selected="true">=== Silahkan Pilih ===</option>@foreach ($provinsi as $key => $value)
														<option value="{{$value->id_provinsi}}">{{$value->nama_provinsi}}</option>@endforeach</select>
													<label hidden id="id_provinsi" class="control-label"><i>Provinsi harus diisi!</i>
													</label>
												</div>
											</div>
										</div>
										<!-- kabupaten -->
										<div class="row">
											<div class="col-md-12">
												<div id="input-kabupaten" class="form-group">
													<label>Kabupaten *</label>
													<select class="form-control" name="kabupaten" id="kabupaten">
														<option value="" disable="true" selected="true">=== Silahkan Pilih ===</option>
													</select>
													<label hidden id="id_kabupaten" class="control-label"><i>Kabupaten harus diisi!</i>
													</label>
												</div>
											</div>
										</div>
										<!-- kecamatan -->
										<div class="row">
											<div class="col-md-12">
												<div id="input-kecamatan" class="form-group">
													<label>Kecamatan *</label>
													<select class="form-control" name="kecamatan" id="kecamatan">
														<option value="" disable="true" selected="true">=== Silahkan Pilih ===</option>
													</select>
													<label hidden id="id_kecamatan" class="control-label"><i>Kecamatan harus diisi!</i>
													</label>
												</div>
											</div>
										</div>
										<!-- desa -->
										<div class="row">
											<div class="col-md-12">
												<div id="input-desa" class="form-group">
													<label class="control-label">Desa *</label>
													<select class="form-control" name="desa" id="desa">
														<option value="" disable="true" selected="true">=== Silahkan Pilih ===</option>
													</select>
													<label hidden id="id_desa" class="control-label"><i>Desa harus diisi!</i>
													</label>
												</div>
											</div>
										</div>
										<!-- koordinat -->
										<div class="row">
											<div class="col-md-12">
												<h4>Titik Koordinat Klaster Plot Ukur:</h4>
											</div>
										</div>
										<!-- lintang dan bujur -->
										<div class="row">
											<div class="col-xs-6">
												<div class="form-group">
													<label class="control-label">Lintang</label>
													<div id="lintang_klaster" class="form-group">
														<div class="input-group">
															<input type="text" class="form-control" placeholder="00 ᴼ 00 &rsquo; 00.00 &rdquo;" data-inputmask="'mask': ['99 ᴼ 99 &rsquo; 99.99 &rdquo;']" data-mask2 id="koor_lintang_klaster" name="koor_lintang_klaster">
															<!-- insert this line --> <span class="input-group-addon" style="width:0px; padding-left:0px; padding-right:0px; border:none;"></span>
															<select class="form-control" name="pilih_lintang_klaster2" id="pilih_lintang_klaster2">
																<option value="LS" selected>LS</option>
																<option value="LU">LU</option>
															</select>
														</div>
														<label hidden id="id_lintang_klaster" class="control-label"><i>Lintang harus sesuai dengan format!</i>
														</label>
													</div>
												</div>
											</div>
											<div class="col-xs-6">
												<div class="form-group">
													<label class="control-label">Bujur</label>
													<div id="bujur_klaster" class="form-group">
														<div class="input-group">
															<input type="text" class="form-control" placeholder="00 ᴼ 00 &rsquo; 00.00 &rdquo;" data-inputmask="'mask': ['999 ᴼ 99 &rsquo; 99.99 &rdquo;']" data-mask2 id="koor_bujur_klaster" name="koor_bujur_klaster">
															<!-- insert this line --> <span class="input-group-addon" style="width:0px; padding-left:0px; padding-right:0px; border:none;"></span>
															<select class="form-control" name="pilih_bujur_klaster2" id="pilih_bujur_klaster2">
																<option value="BT" selected>BT</option>
																<option value="BB">BB</option>
															</select>
														</div>
														<label hidden id="id_bujur_klaster" class="control-label"><i>Bujur harus sesuai dengan format!</i>
														</label>
													</div>
												</div>
											</div>
										</div>
										<!-- altitude -->
										<div class="row">
											<div class="col-md-6">
												<div id="input-altitude" class="form-group">
													<label class="control-label">Altitude (m dpl)</label>
													<input type="text" class="form-control" placeholder="(m dpl)" name="altitude" id="altitude" value="">
													<label hidden id="id_altitude" class="control-label"><i>Altitude harus berupa angka!</i>
													</label>
												</div>
											</div>
											<div class="col-md-6">
												<div id="input-luas-hutan" class="form-group">
													<label>Luas Hutan (hektar)</label>
													<input type="text" name="luas" id="luas" class="form-control" placeholder="Hektar">
													<label hidden id="id_luas_hutan" class="control-label"><i>Luas hutan harus berupa angka!</i>
													</label>
												</div>
											</div>
										</div>
										<!-- tahun tanam dan umur -->
										<div class="row">
											<div class="col-md-6">
												<div id="input-tahun-tanam" class="form-group">
													<label class="control-label">Tahun Tanam</label>
													<input type="text" name="tahun_tanam" id="tahun_tanam" class="form-control" placeholder="2014, 2015, 2016, dst">
													<label hidden id="id_tahun_tanam" class="control-label"><i>Tahun tanam salah! (Format: yyyy).</i>
													</label>
												</div>
											</div>
											<div class="col-md-6">
												<div id="input-usia" class="form-group">
													<label class="control-label">Umur</label>
													<input type="number" name="usia" id="usia" class="form-control" placeholder="tahun">
												</div>
											</div>
										</div>
										<!-- pengelola -->
										<div class="row">
											<div class="col-md-6">
												<div id="input-pengelola-hutan" class="form-group">
													<label>Nama Pengelola</label>
													<input type="text" class="form-control" name="pengelola" id="pengelola" placeholder="Pengelola">
												</div>
											</div>
											<div class="col-md-6">
												<div id="input-keterangan-pengelola" class="form-group">
													<label>Keterangan Pengelola</label>
													<select class="form-control" name="ket_pengelola" id="ket_pengelola">
														<option value="" disable="true" selected="true">Silahkan Pilih</option>@foreach ($jenis_pengelola as $key => $value)
														<option value="{{$value->jenis_pengelola}}">{{$value->jenis_pengelola}}</option>@endforeach</select>
													</label>
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-md-12">
												<h4>Jarak Tanam:</h4>
											</div>
										</div>
										<!-- jarak tanam -->
										<div class="row">
											<div class="col-md-6">
												<div id="input-panjang" class="form-group">
													<label class="control-label">Panjang</label>
													<input type="text" name="jarak_tanam_x" id="jarak_tanam_x" class="form-control" placeholder="meter">
													<label hidden id="id_panjang" class="control-label"><i>Panjang tidak valid!</i>
													</label>
												</div>
											</div>
											<div class="col-md-6">
												<div id="input-lebar" class="form-group">
													<label class="control-label">Lebar</label>
													<input type="text" name="jarak_tanam_y" id="jarak_tanam_y" class="form-control" placeholder="meter">
													<label hidden id="id_lebar" class="control-label"><i>Lebar tidak valid!</i>
													</label>
												</div>
											</div>
										</div>
										<!-- pola tanam -->
										<div class="row">
											<div class="col-md-12">
												<div id="input-pola-tanam" class="form-group">
													<label>Pola Tanam</label>
													<select class="form-control" name="pola_tanam" id="pola_tanam">
														<option value="" disable="true" selected="true">=== Silahkan Pilih ===</option>@foreach ($pola as $key => $value)
														<option value="{{$value->id_pola_tanam}}">{{$value->nama_pola}}</option>@endforeach
													</select>
												</div>
											</div>
										</div>
										<!-- jenis tanaman -->
										<div class="row">
											<div class="col-md-12">
												<div id="input-jenis-tanaman" class="form-group">
													<label>Jenis Tanaman</label>
													<input type="text" name="jenis_tanaman" id="jenis_tanaman" class="form-control" placeholder="Contoh: sengon, jagung, singkong, pisang" value="">
												</div>
											</div>
										</div>
										<!-- label error -->
										<div class="row">
											<div class="col-md-12 has-error">
												<label hidden id="id_lanjut" class="control-label">Pastikan data yang diisikan benar!</label>
											</div>
										</div>
										<!-- button -->
										<div class="form-group">
											<div class="col-md-12">
												<br/>
												<button type="button" class="btn btn-default pull-left" data-dismiss="modal">Kembali</button>
												<button type="button" id="btnljt" class="btn btn-primary pull-right">Lanjut</button>
											</div>
										</div>
								</div>
								<div class="tab-pane" id="tab_6">
									<br/>
									<!-- nama titik ikat -->
									<div class="row">
										<div class="col-md-12">
											<div id="input-titik-ikat" class="form-group">
												<label>Nama Titik Ikat *</label>
												<input type="text" class="form-control" name="nama_titik_ikat" id="nama_titik_ikat" placeholder="Contoh : Jembatan Sekampung, Tower Operator,dll">
												<label hidden id="id_titik_ikat" class="control-label"><i>Titik ikat salah! (2-50 huruf).</i>
												</label>
											</div>
										</div>
									</div>
									<!-- koordinat -->
									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<div id="lintang_ikat" class="form-group">
													<label class="control-label">Lintang</label>
													<div class="input-group">
														<input type="text" class="form-control" placeholder="00 ᴼ 00 &rsquo; 00.00 &rdquo;" data-inputmask="'mask': ['99 ᴼ 99 &rsquo; 99.99 &rdquo;']" data-mask2 id="koor_lintang" name="koor_lintang">
														<!-- insert this line --> <span class="input-group-addon" style="width:0px; padding-left:0px; padding-right:0px; border:none;"></span>
														<select class="form-control" name="pilih_lintang2" id="pilih_lintang2">
															<option value="LS" selected>LS</option>
															<option value="LU">LU</option>
														</select>
													</div>
													<label hidden id="id_lintang_ikat" class="control-label"><i>Lintang harus sesuai dengan format!</i>
													</label>
												</div>
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label class="control-label">Bujur</label>
												<div id="bujur_ikat" class="form-group">
													<div class="input-group">
														<input type="text" class="form-control" placeholder="00 ᴼ 00 &rsquo; 00.00 &rdquo;" data-inputmask="'mask': ['999 ᴼ 99 &rsquo; 99.99 &rdquo;']" data-mask2 id="koor_bujur" name="koor_bujur">
														<!-- insert this line --> <span class="input-group-addon" style="width:0px; padding-left:0px; padding-right:0px; border:none;"></span>
														<select class="form-control" name="pilih_bujur2" id="pilih_bujur2">
															<option value="BT" selected>BT</option>
															<option value="BB">BB</option>
														</select>
													</div>
													<label hidden id="id_bujur_ikat" class="control-label"><i>Bujur harus sesuai dengan format!</i>
													</label>
												</div>
											</div>
										</div>
									</div>
									<!-- azimuth dan jarak -->
									<div class="row">
										<div class="col-md-6">
											<div id="input-azimuth" class="form-group">
												<label class="control-label">Azimuth Ke Titik Pusat Plot 1</label>
												<input type="text" name="azimuth" id="azimuth" class="form-control" placeholder="o">
												<label hidden id="id_azimuth" class="control-label"><i>Azimuth harus diisi!</i>
												</label>
											</div>
										</div>
										<div class="col-md-6">
											<div id="input-jarak-titik-ikat" class="form-group">
												<label class="control-label">Jarak titik ikat ke titik pusat plot 1</label>
												<input type="text" name="jarak_titik_ikat" id="jarak_titik_ikat" class="form-control" placeholder="meter">
												<label hidden id="id_jarak_titik_ikat" class="control-label"><i>Jarak titik ikat harus diisi!</i>
												</label>
											</div>
										</div>
									</div>

									<div class="form-group">
										<div class="col-md-12">
											<br/>
											<button type="button" id="btnkmbli" class="btn btn-default">Kembali</button>
											<button type="button" id="submit" class="btn btn-primary pull-right">Simpan</button>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- /.modal-content -->
		</div>
		<!-- /.modal-dialog -->
	</div>
	<!-- /.modal -->
</div>


<!-- InputMask -->

<!-- 3️⃣ BARU PLUGIN -->
<!-- <script src="{{ asset('Admin/plugins/input-mask/jquery.inputmask.js') }}"></script>
<script src="{{ asset('Admin/plugins/input-mask/jquery.inputmask.extensions.js') }}"></script> -->

<script type = "text/javascript">
$(document).ready(function (){
  $('[data-mask]').inputmask();
        // variable untuk validasi, jika 0 artinya masih salah, jika 1 benar
        // 11 adalah jumlah input text nya yang menyatakan benar semua baru
        // bisa lanjut ke tab selanjutnya
       $('#formsatu').on('submit', function (e) {
    if (!$(this).data('allow-submit')) {
        e.preventDefault();
        return false;
    }
});

  var validate = 0;
  // untuk validasi lintang
  var v_lintang_klaster = 1;
  var valid_lintang_klaster = /^[0-9]{2} ᴼ [0-9]{2} ’ [0-9]{2}\.[0-9]{2} ”$/; //untuk validasi lintang
  $('#lintang_klaster').on('input', function () {
    lintang_klaster = $('#koor_lintang_klaster').val();
    if (lintang_klaster.match(valid_lintang_klaster)) {
      $('#lintang_klaster').attr("class", "form-group has-success");
      $('#id_lintang_klaster').hide();
      v_lintang_klaster = 1;
    } else {
      v_lintang_klaster = 0;
      $('#id_lintang_klaster').show();
      $('#lintang_klaster').attr("class", "form-group has-error");
    }
  });

  // untuk validasi bujur
  var v_bujur_klaster = 1;
  var valid_bujur_klaster = /^[0-9]{3} ᴼ [0-9]{2} ’ [0-9]{2}\.[0-9]{2} ”$/; //untuk validasi bujur
  $('#bujur_klaster').on('input', function () {
    bujur_klaster = $('#koor_bujur_klaster').val();
    if (bujur_klaster.match(valid_bujur_klaster)) {
      $('#bujur_klaster').attr("class", "form-group has-success");
      $('#id_bujur_klaster').hide();
      v_bujur_klaster = 1;
    } else {
      v_bujur_klaster = 0;
      $('#id_bujur_klaster').show();
      $('#bujur_klaster').attr("class", "form-group has-error");
    }
  });

  //validasi altitude
  var v_altitude = 1;
  var valid_altitude = /^([0-9]{0,}(\.[0-9]{1,}){0,1})$/; //untuk validasi integer
  var invalid_huruf_altitude = /[^0-9]/; //untuk validasi diluar integer
  $('#input-altitude').on('input', function () {
    altitude = $('#altitude').val();
    if (altitude.match(valid_altitude)) {
			$('#id_altitude').hide();
      $('#input-altitude').attr("class", "form-group has-success");
      v_altitude = 1;
    } else if (altitude.match(invalid_huruf_altitude)) {
			$('#id_altitude').show();
      v_altitude = 0;
      $('#input-altitude').attr("class", "form-group has-error");
    } else {
      v_altitude = 1;
			$('#id_altitude').hide();
      $('#input-altitude').attr("class", "form-group has-success");
    }
  });

  // validasi pemilik
  var v_pemilik = 0;
  $('#input-pemilik').on('change', function () {
    pemilik = $('#kepemilikan').val();
    if (pemilik != "") {
      $('#input-pemilik').attr("class", "form-group has-success");
      $('#id_pemilik').hide();
      v_pemilik = 1;
    } else {
      v_pemilik = 0;
      $('#id_pemilik').show();
      $('#input-pemilik').attr("class", "form-group has-error");
    }
  });

  // untuk validasi jenis hutan
  var v_jenis = 0;
  var valid_jenis = /^[a-zA-Z ]{2,50}$/; //untuk validasi jenis
  $('#input-jenis-hutan').on('input', function () {
    jenis = $('#jenis').val();
    if (jenis.match(valid_jenis)) {
      $('#input-jenis-hutan').attr("class", "form-group has-success");
      $('#id_jenis').hide();
      v_jenis = 1;
    } else {
      v_jenis = 0;
      $('#id_jenis').show();
      $('#input-jenis-hutan').attr("class", "form-group has-error");
    }
  });

  // untuk validasi fungsi hutan
  var v_fungsi = 0;
  $('#input-fungsi-hutan').on('change', function () {
    fungsi = $('#fungsi').val();
    if (fungsi != "") {
      $('#input-fungsi-hutan').attr("class", "form-group has-success");
      $('#id_fungsi').hide();
      v_fungsi = 1;
    } else {
      v_fungsi = 0;
      $('#id_fungsi').show();
      $('#input-fungsi-hutan').attr("class", "form-group has-error");
    }
  });

  // untuk validasi nama pengelola hutan
  var v_pengelola = 1;
  var valid_pengelola = /^[a-zA-Z ]{2,50}$/; //untuk validasi kategori
  $('#input-pengelola-hutan').on('input', function () {
    pengelola = $('#pengelola').val();
    if (pengelola.match(valid_pengelola)) {
      $('#input-pengelola-hutan').attr("class", "form-group has-success");
      v_pengelola = 1;
    } else {
      v_pengelola = 1;
      $('#input-pengelola-hutan').attr("class", "form-group has-success");
    }
  });

  // untuk validasi nama keterangan pengelola hutan
  var v_keterangan_pengelola = 1;
  $('#input-keterangan-pengelola').on('change', function () {
    keterangan_pengelola = $('#ket_pengelola').val();
    if (keterangan_pengelola != "") {
      $('#input-keterangan-pengelola').attr("class", "form-group has-success");
      v_keterangan_pengelola = 1;
    } else {
      v_keterangan_pengelola = 1;
      $('#input-keterangan-pengelola').attr("class", "form-group has-success");
    }
  });

// VALIDASI DROPDOWN WILAYAH
var v_provinsi = 0;
var v_kabupaten = 0;
var v_kecamatan = 0;
var v_desa = 0;


  // ================== PROVINSI ==================
$(document).on('change','#provinsi', function () {
    const id_provinsi = this.value;

    // VALIDASI + WARNA
    if (id_provinsi !== "") {
        $('#input-provinsi').removeClass('has-error').addClass('has-success');
        $('#id_provinsi').hide();
        v_provinsi = 1;
    } else {
        $('#input-provinsi').removeClass('has-success').addClass('has-error');
        $('#id_provinsi').show();
        v_provinsi = 0;
    }

    // RESET DROPDOWN BAWAHNYA
    v_kabupaten = 0; v_kecamatan = 0; v_desa = 0;
    $('#input-kabupaten').removeClass('has-success').addClass('has-error'); $('#id_kabupaten').show();
    $('#input-kecamatan').removeClass('has-success').addClass('has-error'); $('#id_kecamatan').show();
    $('#input-desa').removeClass('has-success').addClass('has-error'); $('#id_desa').show();

    $('#kabupaten').html('<option value="">=== Silahkan Pilih ===</option>');
    $('#kecamatan').html('<option value="">=== Silahkan Pilih ===</option>');
    $('#desa').html('<option value="">=== Silahkan Pilih ===</option>');

    if (id_provinsi === "") return;

    // AJAX LOAD KABUPATEN
    $(".loading").show();
    $.ajax({
        type: 'POST',
        url: '{{ route("user.json_kabupaten2") }}',
        data: {
            _token: $('input[name=_token]').val(),
            id: id_provinsi
        },
        success: function (data) {
            if (data.length > 0) {
                data.forEach(v => {
                    $('#kabupaten').append(`<option value="${v.id}">${v.nama_kabupaten}</option>`);
                });
            } else {
                $('#kabupaten').html('<option value="">Data kosong</option>');
            }
        },
        error: function (xhr) {
        console.error('STATUS:', xhr.status);
        console.error('RESPONSE:', xhr.responseText);
    },
        complete: function () { $(".loading").hide(); }
    });
});


// ================== KABUPATEN ==================
$(document).on('change', '#kabupaten', function () {
    const id_kabupaten = this.value;

    if (id_kabupaten !== "") {
        $('#input-kabupaten').removeClass('has-error').addClass('has-success');
        $('#id_kabupaten').hide();
        v_kabupaten = 1;
    } else {
        $('#input-kabupaten').removeClass('has-success').addClass('has-error');
        $('#id_kabupaten').show();
        v_kabupaten = 0;
    }

    // reset bawahnya
    v_kecamatan = 0; v_desa = 0;
    $('#input-kecamatan').removeClass('has-success').addClass('has-error'); $('#id_kecamatan').show();
    $('#input-desa').removeClass('has-success').addClass('has-error'); $('#id_desa').show();
    $('#kecamatan').html('<option value="">=== Silahkan Pilih ===</option>');
    $('#desa').html('<option value="">=== Silahkan Pilih ===</option>');

    if (id_kabupaten === "") return;

    $(".loading").show();
    $.ajax({
        type: 'POST',
        url: '{{ route("user.json_kecamatan2") }}',
        data: {
            _token: $('input[name=_token]').val(),
            id: id_kabupaten
        },
        success: function (data) {
            if (data.length > 0) {
                data.forEach(v => {
                    $('#kecamatan').append(`<option value="${v.id}">${v.nama_kecamatan}</option>`);
                });
            } else {
                $('#kecamatan').html('<option value="">Data kosong</option>');
            }
        },
        error: function (xhr) {
        console.error('STATUS:', xhr.status);
        console.error('RESPONSE:', xhr.responseText);
    },
        complete: function () { $(".loading").hide(); }
    });
});


// ================== KECAMATAN ==================
$(document).on('change','#kecamatan', function () {
    const id_kecamatan = this.value;

    if (id_kecamatan !== "") {
        $('#input-kecamatan').removeClass('has-error').addClass('has-success');
        $('#id_kecamatan').hide();
        v_kecamatan = 1;
    } else {
        $('#input-kecamatan').removeClass('has-success').addClass('has-error');
        $('#id_kecamatan').show();
        v_kecamatan = 0;
    }

    // reset desa
    v_desa = 0;
    $('#input-desa').removeClass('has-success').addClass('has-error');
    $('#id_desa').show();
    $('#desa').html('<option value="">=== Silahkan Pilih ===</option>');

    if (id_kecamatan === "") return;

    $(".loading").show();
    $.ajax({
        type: 'POST',
        url: '{{ route("user.json_desa2") }}',
        data: {
            _token: $('input[name=_token]').val(), // konsisten pakai ini aja
            id: id_kecamatan
        },
        success: function (data) {
            if (data.length > 0) {
                data.forEach(v => {
                    $('#desa').append(`<option value="${v.id}">${v.nama_desa}</option>`);
                });
            } else {
                $('#desa').html('<option value="">Data kosong</option>');
            }
        },
        error: function (xhr) {
        console.error('STATUS:', xhr.status);
        console.error('RESPONSE:', xhr.responseText);
    },
        complete: function () { $(".loading").hide(); }
    });
});

  // untuk validasi nama titik ikat
  var v_titik_ikat = 0;
  var valid_titik_ikat = /^[a-zA-Z ]{2,50}$/; //untuk validasi nama titik ikat
  $('#input-titik-ikat').on('input', function () {
    titik_ikat = $('#nama_titik_ikat').val();
    if (titik_ikat.match(valid_titik_ikat)) {
      $('#input-titik-ikat').attr("class", "form-group has-success");
      $('#id_titik_ikat').hide();
      v_titik_ikat = 1;
    } else {
      v_titik_ikat = 0;
      $('#id_titik_ikat').show();
      $('#input-titik-ikat').attr("class", "form-group has-error");
    }
		if(v_titik_ikat + v_azimuth + v_jarak_titik_ikat + v_lintang_ikat + v_bujur_ikat == 5){
		$('#submit').prop("disabled",false);
		}
		else {
		$('#submit').prop("disabled",true);
		}
  });

  // untuk validasi kode klaster plot
  var v_kode_klaster_plot = 0;
  var valid_kode_klaster = /^[a-zA-Z][a-zA-Z0-9]{2,9}$/; //untuk validasi kode klaster
  $('#input-kode-klaster-plot').on('input', function () {
    kode_klaster_plot = $('#kode_klaster_plot').val();
    if (kode_klaster_plot.match(valid_kode_klaster)) {
      $('#input-kode-klaster-plot').attr("class", "form-group has-success");
      $('#id_kode_klaster_plot').hide();
      v_kode_klaster_plot = 1;
    } else {
      v_kode_klaster_plot = 0;
      $('#id_kode_klaster_plot').show();
      $('#input-kode-klaster-plot').attr("class", "form-group has-error");
    }
  });

  // untuk validasi luas hutan
  var v_luas_hutan = 1;
  var valid_luas_hutan = /^([0-9]{0,}(\.[0-9]{1,}){0,1})$/; //untuk validasi integer
  var invalid_huruf_luas_hutan = /[^0-9]/; //untuk validasi diluar integer
  $('#input-luas-hutan').on('input', function () {
    luas_hutan = $('#luas').val();
    if (luas_hutan.match(valid_luas_hutan)) {
      $('#input-luas-hutan').attr("class", "form-group has-success");
      $('#id_luas_hutan').hide();
      v_luas_hutan = 1;
    } else if (luas_hutan.match(invalid_huruf_luas_hutan)) {
      v_luas_hutan = 0;
      $('#id_luas_hutan').show();
      $('#input-luas-hutan').attr("class", "form-group has-error");
    } else {
      v_luas_hutan = 1;
      $('#id_luas_hutan').hide();
      $('#input-luas-hutan').attr("class", "form-group has-success");
    }
  });

  // untuk validasi jarak titik ikat
  var v_jarak_titik_ikat = 1;
  var valid_jarak_titik_ikat = /^([0-9]{0,}(\.[0-9]{1,}){0,1})$/; //untuk validasi integer
  var invalid_huruf_jarak_titik_ikat = /[^0-9]/; //untuk validasi diluar integer
  $('#input-jarak-titik-ikat').on('input', function () {
    jarak_titik_ikat = $('#jarak_titik_ikat').val();
    if (jarak_titik_ikat.match(valid_jarak_titik_ikat)) {
      $('#input-jarak-titik-ikat').attr("class", "form-group has-success");
      $('#id_jarak_titik_ikat').hide();
      v_jarak_titik_ikat = 1;
    } else if (jarak_titik_ikat.match(invalid_huruf_jarak_titik_ikat)) {
      v_jarak_titik_ikat = 0;
      $('#id_jarak_titik_ikat').text("Jarak titik ikat harus berupa angka!");
      $('#id_jarak_titik_ikat').show();
      $('#input-jarak-titik-ikat').attr("class", "form-group has-error");
    } else { //untuk validasi isian masih kosong
      v_jarak_titik_ikat = 0;
      $('#id_jarak_titik_ikat').text("Jarak titik ikat harus diisi!");
      $('#id_jarak_titik_ikat').show();
      $('#input-jarak-titik-ikat').attr("class", "form-group has-error");
    }
		if(v_titik_ikat + v_azimuth + v_jarak_titik_ikat + v_lintang_ikat + v_bujur_ikat == 5){
		$('#submit').prop("disabled",false);
		}
		else {
		$('#submit').prop("disabled",true);
		}
  });

  // untuk validasi azimuth
  var v_azimuth = 1;
  var valid_azimuth = /^([0-9]{0,}(\.[0-9]{1,}){0,1})$/; //untuk validasi integer
  var invalid_huruf_azimuth = /[^0-9]/; //untuk validasi diluar integer
  $('#input-azimuth').on('input', function () {
    azimuth = $('#azimuth').val();
    if (azimuth.match(valid_azimuth)) {
      $('#input-azimuth').attr("class", "form-group has-success");
      $('#id_azimuth').hide();
      v_azimuth = 1;
    } else if (azimuth.match(invalid_huruf_azimuth)) {
      v_azimuth = 0;
      $('#id_azimuth').text("Azimuth harus berupa angka!");
      $('#id_azimuth').show();
      $('#input-azimuth').attr("class", "form-group has-error");
    } else {
      v_azimuth = 0;
      $('#id_azimuth').text("azimuth harus diisi!");
      $('#id_azimuth').show();
      $('#input-azimuth').attr("class", "form-group has-error");
    }
		if(v_titik_ikat + v_azimuth + v_jarak_titik_ikat + v_lintang_ikat + v_bujur_ikat == 5){
		$('#submit').prop("disabled",false);
		}
		else {
		$('#submit').prop("disabled",true);
		}
  });

  // untuk validasi usia
  var v_usia = 1;
  var valid_usia = /^[1-9]([0-9]){0,}$/; //untuk validasi integer
  var invalid_huruf_usia = /[^0-9]/; //untuk validasi diluar integer
  $('#input-usia').on('input', function () {
    usia = $('#usia').val();
    if (usia.match(valid_usia)) {
      $('#input-usia').attr("class", "form-group has-success");
      v_usia = 1;
    } else if (usia.match(invalid_huruf_usia)) {
      v_usia = 1;
      $('#input-usia').attr("class", "form-group has-success");
    } else {
      v_usia = 1;
      $('#input-usia').attr("class", "form-group has-success");
    }
  });

  // untuk validasi tahun tanam
  var v_tahun_tanam = 1;
  var valid_tahun_tanam = /^([1-2][\d]{3}){0,1}(,[1-2][\d]{3}){0,2}$/; //untuk validasi tahun
  var invalid_tahun_tanam = /[^\d]/; //untuk validasi selain tahun
  $('#input-tahun-tanam').on('input', function () {
    tahun_tanam = $('#tahun_tanam').val();
    if (tahun_tanam.match(valid_tahun_tanam) || tahun_tanam=="") {
			$('#id_tahun_tanam').hide();
      $('#input-tahun-tanam').attr("class", "form-group has-success");
      v_tahun_tanam = 1;
    } else {
      v_tahun_tanam = 0;
			$('#id_tahun_tanam').show();
      $('#input-tahun-tanam').attr("class", "form-group has-error");
    }
  });

  // untuk validasi jenis tanaman
  var v_jenis_tanaman = 1;
  var valid_jenis_tanaman = /^[a-zA-Z ]{0,50}$/; //untuk validasi jenis tanaman
  $('#input-jenis-tanaman').on('input', function () {
    jenis_tanaman = $('#jenis_tanaman').val();
    if (jenis_tanaman.match(valid_jenis_tanaman)) {
      $('#input-jenis-tanaman').attr("class", "form-group has-success");
      v_jenis_tanaman = 1;
    } else {
      v_jenis_tanaman = 1;
      $('#input-jenis-tanaman').attr("class", "form-group has-success");
    }
  });

  // untuk validasi panjang tanam
  var v_panjang = 1;
  var valid_panjang = /^([0-9]{0,}(\.[0-9]{1,}){0,1})$/; //untuk validasi integer
  var invalid_huruf_panjang = /[^0-9]/; //untuk validasi diluar integer
  $('#input-panjang').on('input', function () {
    panjang = $('#jarak_tanam_x').val();
    if (panjang.match(valid_panjang)) {
      $('#input-panjang').attr("class", "form-group has-success");
      $('#id_panjang').hide();
      v_panjang = 1;
    } else if (panjang.match(invalid_huruf_panjang)) {
      v_panjang = 0;
      $('#id_panjang').show();
      $('#input-panjang').attr("class", "form-group has-error");
    } else {
      v_panjang = 0;
      $('#id_panjang').show();
      $('#input-panjang').attr("class", "form-group has-error");
    }
  });

  // untuk validasi lebar tanam
  var v_lebar = 1;
  var valid_lebar = /^([0-9]{0,}(\.[0-9]{1,}){0,1})$/; //untuk validasi integer
  var invalid_huruf_lebar = /[^0-9]/; //untuk validasi diluar integer
  $('#input-lebar').on('input', function () {
    lebar = $('#jarak_tanam_y').val();
    if (lebar.match(valid_lebar)) {
      $('#input-lebar').attr("class", "form-group has-success");
      $('#id_lebar').hide();
      v_lebar = 1;
    } else if (lebar.match(invalid_huruf_lebar)) {
      v_lebar = 0;
      $('#id_lebar').show();
      $('#input-lebar').attr("class", "form-group has-error");
    } else {
      v_lebar = 0;
      $('#id_lebar').show();
      $('#input-lebar').attr("class", "form-group has-error");
    }
  });

  // event






  // untuk validasi lintang ikat
  var v_lintang_ikat = 1;
  var valid_lintang_ikat = /^[0-9]{2} ᴼ [0-9]{2} ’ [0-9]{2}\.[0-9]{2} ”$/; //untuk validasi lintang
  $('#lintang_ikat').on('input', function () {
    lintang_ikat = $('#koor_lintang').val();
    if (lintang_ikat.match(valid_lintang_ikat)) {
      $('#lintang_ikat').attr("class", "form-group has-success");
      $('#id_lintang_ikat').hide();
      v_lintang_ikat = 1;
    } else {
      v_lintang_ikat = 0;
      $('#id_lintang_ikat').show();
      $('#lintang_ikat').attr("class", "form-group has-error");
    }
		if(v_titik_ikat + v_azimuth + v_jarak_titik_ikat + v_lintang_ikat + v_bujur_ikat == 5){
		$('#submit').prop("disabled",false);
		}
		else {
		$('#submit').prop("disabled",true);
		}
  });

  // untuk validasi bujur ikat
  var v_bujur_ikat = 1;
  var valid_bujur_ikat = /^[0-9]{3} ᴼ [0-9]{2} ’ [0-9]{2}\.[0-9]{2} ”$/; //untuk validasi bujur
  $('#bujur_ikat').on('input', function () {
    bujur_ikat = $('#koor_bujur').val();
    if (bujur_ikat.match(valid_bujur_ikat)) {
      $('#bujur_ikat').attr("class", "form-group has-success");
      $('#id_bujur_ikat').hide();
      v_bujur_ikat = 1;
    } else {
      v_bujur_ikat = 0;
      $('#id_bujur_ikat').show();
      $('#bujur_ikat').attr("class", "form-group has-error");
    }
		if(v_titik_ikat + v_azimuth + v_jarak_titik_ikat + v_lintang_ikat + v_bujur_ikat == 5){
		$('#submit').prop("disabled",false);
		}
		else {
		$('#submit').prop("disabled",true);
		}
  });

  function isValid(v) {
    return v === 1;
}

 $('#btnljt').click(function (e) {
    e.preventDefault();

    const wajib = [
        v_pemilik,
        v_jenis,
        v_fungsi,
        v_provinsi,
        v_kabupaten,
        v_kecamatan,
        v_desa,
        v_lintang_klaster,
        v_bujur_klaster
    ];

    const semuaValid = wajib.every(isValid);

    if (semuaValid) {
        $('#id_lanjut').hide();

        $('#tabs6').attr("href", "#tab_6");
        $('#tabtambah a[href="#tab_6"]').tab('show');
        $('#tabs6').removeAttr("href");
        $('#tab5').addClass("disabled");
        $('#tabs5').removeAttr("href");

    } else {
        $('#id_lanjut').show();
    }
});

  $('#btnkmbli').click(function (e) {
    e.preventDefault();
    $('#tabs5').attr("href", "#tab_5");
    $('#tabtambah a[href="#tab_5"]').tab('show');
    $('#tabs5').removeAttr("href");
  });
$('#formsatu').on('keydown', function (e) {
    if (e.key === 'Enter') {
        e.preventDefault();
        return false;
    }
});

// ================================
// SUBMIT AMAN (HANYA VIA TOMBOL)
// ================================
$('#submit').on('click', function (e) {
    e.preventDefault();

    $(this).prop('disabled', true).text('Sedang menyimpan...');

    $('#formsatu')
        .data('allow-submit', true)
        .attr('action', '{{ route("user.insert_klaster") }}')
        .submit();
});
});
</script>
