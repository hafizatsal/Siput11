<div class="modal modal-danger fade" id="delete_lokasi">
       <div class="modal-dialog">
         <div class="modal-content">
           <div class="modal-header">
             <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span></button>
             <h4 class="modal-title">Hapus Data</h4>
           </div>
           <form class="" action="{{route('admin.hapus_lokasi')}}" method="get">
             {{csrf_field()}}
           <div class="modal-body">
             <p>Apakah anda yakin ingin menghapus data provinsi <span id="hapus_nama_provinsi"></span> ini?</p>
             <input type="hidden" name="hapus_id_lokasi" id="hapus_id_lokasi" value="">
           </div>
           <div class="modal-footer">
             <button type="button" class="btn btn-outline" data-dismiss="modal">Close</button>
             <button type="submit" class="btn btn-warning">OK</button>
           </form>
           </div>
         </div>
         <!-- /.modal-content -->
       </div>
       <!-- /.modal-dialog -->
     </div>

<script type="text/javascript">
$(document).ready(function(){
       $('#delete_lokasi').on('show.bs.modal', function(event){
          var button = $(event.relatedTarget);
          var nm_lokasi = button.data('nm_lokasi');
          var nama_provinsi = button.data('nama_provinsi');
          var modal = $(this)
         modal.find('.modal-body #hapus_id_lokasi').val(nm_lokasi);
         modal.find('.modal-body #hapus_nama_provinsi').text(nama_provinsi || '');
       });
    });
</script>
