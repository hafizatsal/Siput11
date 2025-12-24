<div class="modal modal-danger fade" id="delete_desa">
       <div class="modal-dialog">
         <div class="modal-content">
           <div class="modal-header">
             <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span></button>
             <h4 class="modal-title">Hapus Data</h4>
           </div>
           <form class="" action="{{route('admin.hapus_desa')}}" method="post">
             {{csrf_field()}}
           <div class="modal-body">
             <p>Yakin ingin menghapus data?</p>
             <input type="hidden" name="hapus_id_desa" id="hapus_id_desa" value="">
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
       $('#delete_desa').on('show.bs.modal', function(event){
          var button = $(event.relatedTarget);
          var nm_desa = button.data('nm_desa');
          var modal = $(this)
         modal.find('.modal-body #hapus_id_desa').val(nm_desa);
       });
    });
</script>

