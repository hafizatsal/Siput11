<div class="modal modal-danger fade" id="delete_keparahan">
       <div class="modal-dialog">
         <div class="modal-content">
           <div class="modal-header">
             <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span></button>
             <h4 class="modal-title">Hapus Data</h4>
           </div>
           <form class="" action="{{route('admin.hapus_keparahan_kerusakan')}}" method="post">
             {{csrf_field()}}
           <div class="modal-body">
             <p>Yakin ingin menghapus data?</p>
             <input type="hidden" name="hapus_id_keparahan" id="hapus_id_keparahan" value="">
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
       $('#delete_keparahan').on('show.bs.modal', function(event){
          var button = $(event.relatedTarget);
          var nm_keparahan = button.data('nm_keparahan');
          var modal = $(this)
         modal.find('.modal-body #hapus_id_keparahan').val(nm_keparahan);
       });
    });
</script>

