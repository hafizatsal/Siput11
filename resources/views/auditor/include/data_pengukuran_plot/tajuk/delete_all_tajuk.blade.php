<div class="modal modal-danger fade" id="modal_delete_all">
       <div class="modal-dialog">
         <div class="modal-content">
           <div class="modal-header">
             <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span></button>
             <h4 class="modal-title">Hapus Semua Data</h4>
           </div>
           <form class="" action="{{route('auditor.hapus_all_tajuk')}}" method="get">
             {{csrf_field()}}
           <div class="modal-body">
             <p>Yakin ingin menghapus semua data?</p>
             <input type="hidden" name="hapus_id_all" id="hapus_id_all" value="">
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
       $('#modal_delete_all').on('show.bs.modal', function(event){
          var button2 = $(event.relatedTarget);
          var pohon2 = button2.data('info2');
          var modal2 = $(this)
         modal2.find('.modal-body #hapus_id_all').val(pohon2);

       });
    });
       </script>
