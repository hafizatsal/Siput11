<div class="modal fade" id="modalEditPengukuran">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <form id="formEditPengukuran" method="POST">
                @csrf
                @method('PUT')

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                    <h4 class="modal-title">Edit Data Pengukuran</h4>
                </div>

                <div class="modal-body">

                    <div class="nav-tabs-custom">
                        <ul class="nav nav-tabs">
                            <li class="active"><a href="#edit_tab_hutan" data-toggle="tab">Data Hutan</a></li>
                            <li><a href="#edit_tab_klaster" data-toggle="tab">Data Klaster</a></li>
                        </ul>

                        <div class="tab-content">

                            {{-- ================= TAB DATA HUTAN ================= --}}
                            <div class="tab-pane active" id="edit_tab_hutan">

                                <div class="row">

                                    <div class="col-md-4">
                                        <label>ID Klaster Plot</label>
                                        <input type="text" class="form-control" id="edit_id_klaster_plot" name="id_klaster_plot">
                                    </div>

                                    <div class="col-md-4">
                                        <label>Kepemilikan</label>
                                        <select name="kepemilikan" id="edit_kepemilikan" class="form-control">
                                            <option value="">=== Pilih ===</option>
                                            @foreach($kepemilikan as $v)
                                                <option value="{{ $v->id_hak_milik }}">{{ $v->hak_milik }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-md-4">
                                        <label>Jenis Hutan</label>
                                        <select name="jenis" id="edit_jenis" class="form-control">
                                            <option value="">=== Pilih ===</option>
                                            @foreach($jenis as $v)
                                                <option value="{{ $v->id_jenis_hutan }}">{{ $v->nama }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-md-4">
                                        <label>Fungsi Hutan</label>
                                        <select name="fungsi" id="edit_fungsi" class="form-control">
                                            <option value="">=== Pilih ===</option>
                                        </select>
                                    </div>

                                    <div class="col-md-4">
                                        <label>Nama Pengelola</label>
                                        <input type="text" name="pengelola" id="edit_pengelola" class="form-control">
                                    </div>

                                    <div class="col-md-4">
                                        <label>Keterangan Pengelola</label>
                                        <select name="ket_pengelola" id="edit_ket_pengelola" class="form-control">
                                            <option value="">=== Pilih ===</option>
                                            @foreach($jenis_pengelola as $v)
                                                <option value="{{ $v->id_jenis_pengelola }}">{{ $v->jenis_pengelola }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    {{-- WILAYAH --}}
                                    <div class="col-md-4">
                                        <label>Provinsi</label>
                                        <select name="provinsi" id="edit_provinsi" class="form-control">
                                            <option value="">=== Pilih ===</option>
                                            @foreach($provinsi as $v)
                                                <option value="{{ $v->id_provinsi }}">{{ $v->nama_provinsi }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-md-4">
                                        <label>Kabupaten</label>
                                        <select name="kabupaten" id="edit_kabupaten" class="form-control">
                                            <option value="">=== Pilih ===</option>
                                        </select>
                                    </div>

                                    <div class="col-md-4">
                                        <label>Kecamatan</label>
                                        <select name="kecamatan" id="edit_kecamatan" class="form-control">
                                            <option value="">=== Pilih ===</option>
                                        </select>
                                    </div>

                                    <div class="col-md-4">
                                        <label>Desa</label>
                                        <select name="desa" id="edit_desa" class="form-control">
                                            <option value="">=== Pilih ===</option>
                                        </select>
                                    </div>

                                    <div class="col-md-4">
                                        <label>Pola Tanam</label>
                                        <select name="pola_tanam" id="edit_pola_tanam" class="form-control">
                                            <option value="">=== Pilih ===</option>
                                            @foreach($pola as $v)
                                                <option value="{{ $v->id_pola_tanam }}">{{ $v->nama_pola }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                </div>

                            </div>

                            {{-- ================= TAB DATA KLASTER ================= --}}
                            <div class="tab-pane" id="edit_tab_klaster">

                                <div class="row">

                                    <div class="col-md-6">
                                        <label>Nama Titik Ikat</label>
                                        <input type="text" name="nama_titik_ikat" id="edit_nama_titik_ikat" class="form-control">
                                    </div>

                                    <div class="col-md-6">
                                        <label>Kode Klaster Plot</label>
                                        <input type="text" name="kode_klaster_plot" id="edit_kode_klaster_plot" class="form-control">
                                    </div>

                                    <div class="col-md-6">
                                        <label>Luas Hutan (Ha)</label>
                                        <input type="text" name="luas" id="edit_luas" class="form-control">
                                    </div>

                                    <div class="col-md-6">
                                        <label>Jarak Titik Ikat (m)</label>
                                        <input type="text" name="jarak_titik_ikat" id="edit_jarak_titik_ikat" class="form-control">
                                    </div>

                                    <div class="col-md-6">
                                        <label>Azimuth</label>
                                        <input type="text" name="azimuth" id="edit_azimuth" class="form-control">
                                    </div>

                                    <div class="col-md-6">
                                        <label>Tahun Tanam</label>
                                        <input type="text" name="tahun_tanam" id="edit_tahun_tanam" class="form-control">
                                    </div>

                                    <div class="col-md-6">
                                        <label>Jarak Tanam Panjang (m)</label>
                                        <input type="text" name="jarak_tanam_x" id="edit_jarak_tanam_x" class="form-control">
                                    </div>

                                    <div class="col-md-6">
                                        <label>Jarak Tanam Lebar (m)</label>
                                        <input type="text" name="jarak_tanam_y" id="edit_jarak_tanam_y" class="form-control">
                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

                <div class="modal-footer">
                    <button class="btn btn-default" data-dismiss="modal">Tutup</button>
                    <button class="btn btn-primary" type="submit">Simpan Perubahan</button>
                </div>

            </form>

        </div>
    </div>
</div>

{{-- ================ SCRIPT UNTUK FILL OTOMATIS ================ --}}
@push('script_tambahan')
<script>
    $(document).on("click", ".btnEditPengukuran", function () {

        const data = $(this).data();

        // Set action URL
        $("#formEditPengukuran").attr("action", data.action);

        // TAB 1
        $("#edit_id_klaster_plot").val(data.id_klaster_plot);
        $("#edit_kepemilikan").val(data.kepemilikan);
        $("#edit_jenis").val(data.jenis);
        $("#edit_pengelola").val(data.pengelola);
        $("#edit_ket_pengelola").val(data.ket_pengelola);

        // Wilayah
        $("#edit_provinsi").val(data.provinsi).trigger("change");
        setTimeout(() => {
            $("#edit_kabupaten").val(data.kabupaten).trigger("change");
            setTimeout(() => {
                $("#edit_kecamatan").val(data.kecamatan).trigger("change");
                setTimeout(() => {
                    $("#edit_desa").val(data.desa);
                }, 500);
            }, 500);
        }, 500);

        $("#edit_pola_tanam").val(data.pola_tanam);

        // TAB 2
        $("#edit_nama_titik_ikat").val(data.nama_titik_ikat);
        $("#edit_kode_klaster_plot").val(data.kode_klaster_plot);
        $("#edit_luas").val(data.luas);
        $("#edit_jarak_titik_ikat").val(data.jarak_titik_ikat);
        $("#edit_azimuth").val(data.azimuth);
        $("#edit_tahun_tanam").val(data.tahun_tanam);
        $("#edit_jarak_tanam_x").val(data.jarak_tanam_x);
        $("#edit_jarak_tanam_y").val(data.jarak_tanam_y);

        // Tampilkan modal
        $("#modalEditPengukuran").modal("show");
    });

    // AJAX jenis → fungsi
    $('#edit_jenis').on('change', function(){
        $.get("{{ url('auditor/json-fungsi2') }}?id_jenis=" + this.value, function(data){
            $('#edit_fungsi').empty();
            $('#edit_fungsi').append('<option value="">=== Pilih ===</option>');
            $.each(data, function(i,v){
                $('#edit_fungsi').append(`<option value="${v.id_fungsi}">${v.fungsi}</option>`);
            });
        });
    });

    // AJAX wilayah
    $('#edit_provinsi').on('change', function(){
        $.get("{{ url('auditor/json-kabupaten2') }}?id_provinsi=" + this.value, function(data){
            $('#edit_kabupaten').empty().append('<option value="">=== Pilih ===</option>');
            $.each(data, (i,v)=>{
                $('#edit_kabupaten').append(`<option value="${v.id}">${v.nama_kabupaten}</option>`);
            });
        });
    });

    $('#edit_kabupaten').on('change', function(){
        $.get("{{ url('auditor/json-kecamatan2') }}?id=" + this.value, function(data){
            $('#edit_kecamatan').empty().append('<option value="">=== Pilih ===</option>');
            $.each(data, (i,v)=>{
                $('#edit_kecamatan').append(`<option value="${v.id}">${v.nama_kecamatan}</option>`);
            });
        });
    });

    $('#edit_kecamatan').on('change', function(){
        $.get("{{ url('auditor/json-desa2') }}?id=" + this.value, function(data){
            $('#edit_desa').empty().append('<option value="">=== Pilih ===</option>');
            $.each(data, (i,v)=>{
                $('#edit_desa').append(`<option value="${v.id}">${v.nama_desa}</option>`);
            });
        });
    });
</script>
@endpush