<div class="modal modal-danger fade" id="modal_status">
       <div class="modal-dialog">
         <div class="modal-content">
           <div class="modal-header">
             <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span></button>
             <h4 class="modal-title">Ubah Status Pohon</h4>
           </div>
           <form class="" action="{{route('auditor.status_pohon')}}" method="get">
             {{csrf_field()}}
           <div class="modal-body">
             <p>Yakin ingin mengubah status pohon?</p>
             <input type="hidden" name="status_id" id="status_id" value="">
             <input type="hidden" id="status" name="status" value="">
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
       $('#modal_status').on('show.bs.modal', function(event){
          var button = $(event.relatedTarget);
          var pohon = button.data('pohon');
          var status = button.data('info');
          var modal = $(this)
         modal.find('.modal-body #status_id').val(pohon);
         modal.find('.modal-body #status').val(status);

       });
    });
       </script>
