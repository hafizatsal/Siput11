<div class="modal fade" id="modalDeletePengukuran">
    <div class="modal-dialog">
        <div class="modal-content">

            <form id="formDeletePengukuran" method="POST">
                @csrf
                @method('DELETE')

                <div class="modal-header bg-danger">
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                    <h4 class="modal-title">Hapus Data Pengukuran</h4>
                </div>

                <div class="modal-body">
                    <h4 class="text-center">
                        <b>Apakah Anda yakin ingin menghapus data ini?</b>
                    </h4>

                    <p class="text-center text-muted" id="hapus_keterangan" style="font-size: 14px;">
                        <!-- Keterangan diisi otomatis -->
                    </p>

                    <input type="hidden" id="delete_id" name="id">
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">
                        Batal
                    </button>
                    <button type="submit" class="btn btn-danger">
                        Hapus
                    </button>
                </div>

            </form>

        </div>
    </div>
</div>

{{-- ================= SCRIPT DELETE ================= --}}
@push('script_tambahan')
<script>
    // Saat tombol delete ditekan
    $(document).on("click", ".btnDeletePengukuran", function () {

        // Ambil data dari button
        const data = $(this).data();

        // Set action URL form delete
        $("#formDeletePengukuran").attr("action", data.action);

        // Simpan ID jika dibutuhkan
        $("#delete_id").val(data.id);

        // Tampilkan keterangan
        $("#hapus_keterangan").html(
            "Data dengan ID: <b>" + data.id + "</b> akan dihapus secara permanen."
        );

        // Tampilkan modal
        $("#modalDeletePengukuran").modal("show");
    });
</script>
@endpush