<div class="modal fade" id="tambah3">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
                <h4 class="modal-title">Tambah Data Pengukuran (Versi Lengkap)</h4>
            </div>

            <div class="modal-body">

                <form id="formPengukuran" method="POST" action="{{ url('auditor/data_pengukuran/insert') }}">
                    @csrf

                    <div class="nav-tabs-custom">
                        <ul class="nav nav-tabs">
                            <li class="active"><a href="#tab_hutan" data-toggle="tab">Data Hutan</a></li>
                            <li><a href="#tab_klaster" data-toggle="tab">Data Klaster</a></li>
                        </ul>

                        <div class="tab-content">

                            {{-- ================= TAB 1 – DATA HUTAN ================= --}}
                            <div class="tab-pane active" id="tab_hutan">

                                <div class="row">
                                    <div class="col-md-4">
                                        <label>ID Klaster Plot</label>
                                        <input type="text" class="form-control" name="id_klaster_plot">
                                    </div>

                                    <div class="col-md-4">
                                        <label>Kepemilikan</label>
                                        <select name="kepemilikan" class="form-control">
                                            <option value="">=== Pilih ===</option>
                                            @foreach($kepemilikan as $v)
                                                <option value="{{ $v->id_hak_milik }}">{{ $v->hak_milik }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-md-4">
                                        <label>Jenis Hutan</label>
                                        <select name="jenis" id="jenis" class="form-control">
                                            <option value="">=== Pilih ===</option>
                                            @foreach($jenis as $v)
                                                <option value="{{ $v->id_jenis_hutan }}">{{ $v->nama }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-md-4">
                                        <label>Fungsi Hutan</label>
                                        <select name="fungsi" id="fungsi" class="form-control">
                                            <option value="">=== Pilih ===</option>
                                        </select>
                                    </div>

                                    <div class="col-md-4">
                                        <label>Nama Pengelola</label>
                                        <input type="text" class="form-control" name="pengelola">
                                    </div>

                                    <div class="col-md-4">
                                        <label>Keterangan Pengelola</label>
                                        <select class="form-control" name="ket_pengelola">
                                            <option value="">=== Pilih ===</option>
                                            @foreach($jenis_pengelola as $v)
                                                <option value="{{ $v->id_jenis_pengelola }}">{{ $v->jenis_pengelola }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    {{-- Wilayah --}}
                                    <div class="col-md-4">
                                        <label>Provinsi</label>
                                        <select name="provinsi" id="provinsi" class="form-control">
                                            <option value="">=== Pilih ===</option>
                                            @foreach($provinsi as $v)
                                                <option value="{{ $v->id_provinsi }}">{{ $v->nama_provinsi }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-md-4">
                                        <label>Kabupaten</label>
                                        <select name="kabupaten" id="kabupaten" class="form-control">
                                            <option value="">=== Pilih ===</option>
                                        </select>
                                    </div>

                                    <div class="col-md-4">
                                        <label>Kecamatan</label>
                                        <select name="kecamatan" id="kecamatan" class="form-control">
                                            <option value="">=== Pilih ===</option>
                                        </select>
                                    </div>

                                    <div class="col-md-4">
                                        <label>Desa</label>
                                        <select name="desa" id="desa" class="form-control">
                                            <option value="">=== Pilih ===</option>
                                        </select>
                                    </div>

                                    <div class="col-md-4">
                                        <label>Pola Tanam</label>
                                        <select name="pola_tanam" class="form-control">
                                            <option value="">=== Pilih ===</option>
                                            @foreach($pola as $v)
                                                <option value="{{ $v->id_pola_tanam }}">{{ $v->nama_pola }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                            </div>

                            {{-- ================= TAB 2 – DATA KLASTER ================= --}}
                            <div class="tab-pane" id="tab_klaster">

                                <div class="row">
                                    <div class="col-md-6">
                                        <label>Nama Titik Ikat</label>
                                        <input type="text" class="form-control" name="nama_titik_ikat">
                                    </div>

                                    <div class="col-md-6">
                                        <label>Kode Klaster Plot</label>
                                        <input type="text" class="form-control" name="kode_klaster_plot">
                                    </div>

                                    <div class="col-md-6">
                                        <label>Luas Hutan (Ha)</label>
                                        <input type="text" class="form-control" name="luas">
                                    </div>

                                    <div class="col-md-6">
                                        <label>Jarak Titik Ikat ke Pusat Plot 1 (m)</label>
                                        <input type="text" class="form-control" name="jarak_titik_ikat">
                                    </div>

                                    <div class="col-md-6">
                                        <label>Azimuth ke Titik Pusat</label>
                                        <input type="text" class="form-control" name="azimuth">
                                    </div>

                                    <div class="col-md-6">
                                        <label>Tahun Tanam</label>
                                        <input type="text" class="form-control" name="tahun_tanam">
                                    </div>

                                    <div class="col-md-6">
                                        <label>Jarak Tanam — Panjang (m)</label>
                                        <input type="text" class="form-control" name="jarak_tanam_x">
                                    </div>

                                    <div class="col-md-6">
                                        <label>Jarak Tanam — Lebar (m)</label>
                                        <input type="text" class="form-control" name="jarak_tanam_y">
                                    </div>
                                </div>

                            </div>

                        </div>{{-- tab-content --}}
                    </div>{{-- nav-tabs-custom --}}

            </div>{{-- modal-body --}}

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>

            </form>

        </div>
    </div>
</div>

{{-- ==================== AJAX SCRIPT ==================== --}}
<script>
    // AJAX Jenis → Fungsi
    $('#jenis').on('change', function() {
        var id = $(this).val();
        $.get("{{ url('auditor/json-fungsi2') }}?id_jenis=" + id, function(data){
            $('#fungsi').empty().append('<option value="">=== Pilih ===</option>');
            $.each(data, function(i, v){
                $('#fungsi').append('<option value="' + v.id_fungsi + '">' + v.fungsi + '</option>');
            });
        });
    });

    // AJAX Provinsi → Kabupaten
    $('#provinsi').on('change', function(){
        var id = $(this).val();
        $.get("{{ url('auditor/json-kabupaten2') }}?id_provinsi=" + id, function(data){
            $('#kabupaten').empty().append('<option value="">=== Pilih ===</option>');
            $('#kecamatan').empty().append('<option value="">=== Pilih ===</option>');
            $('#desa').empty().append('<option value="">=== Pilih ===</option>');
            $.each(data, function(i, v){
                $('#kabupaten').append('<option value="' + v.id + '">' + v.nama_kabupaten + '</option>');
            });
        });
    });

    // AJAX Kabupaten → Kecamatan
    $('#kabupaten').on('change', function(){
        var id = $(this).val();
        $.get("{{ url('auditor/json-kecamatan2') }}?id=" + id, function(data){
            $('#kecamatan').empty().append('<option value="">=== Pilih ===</option>');
            $('#desa').empty().append('<option value="">=== Pilih ===</option>');
            $.each(data, function(i, v){
                $('#kecamatan').append('<option value="' + v.id + '">' + v.nama_kecamatan + '</option>');
            });
        });
    });

    // AJAX Kecamatan → Desa
    $('#kecamatan').on('change', function(){
        var id = $(this).val();
        $.get("{{ url('auditor/json-desa2') }}?id=" + id, function(data){
            $('#desa').empty().append('<option value="">=== Pilih ===</option>');
            $.each(data, function(i, v){
                $('#desa').append('<option value="' + v.id + '">' + v.nama_desa + '</option>');
            });
        });
    });
</script>
