<div class="modal modal-danger fade" id="delete_instansi">
       <div class="modal-dialog">
         <div class="modal-content">
           <div class="modal-header">
             <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span></button>
             <h4 class="modal-title">Hapus Data</h4>
           </div>
           <form class="" action="{{route('admin.hapus_instansi')}}" method="post">
             {{csrf_field()}}
           <div class="modal-body">
             <p>Yakin ingin menghapus data?</p>
             <input type="hidden" name="hapus_id_instansi" id="hapus_id_instansi" value="">
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
       $('#delete_instansi').on('show.bs.modal', function(event){
          var button = $(event.relatedTarget);
          var nm_instansi = button.data('id_instansi');
          var modal = $(this)
         modal.find('.modal-body #hapus_id_instansi').val(nm_instansi);
       });
    });
</script>

