<div class="modal modal-danger fade" id="delete_tertimbang">
       <div class="modal-dialog">
         <div class="modal-content">
           <div class="modal-header">
             <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span></button>
             <h4 class="modal-title">Hapus Data</h4>
           </div>
           <form class="" action="{{route('admin.hapus_tertimbang')}}" method="post">
             {{csrf_field()}}
           <div class="modal-body">
             <p>Yakin ingin menghapus data?</p>
             <input type="text" name="hapus_id_tertimbang" id="hapus_id_tertimbang" value="">
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

     <script src="{{asset('Admin/modal_ajax.min.js')}}"></script>
<script src="{{asset('Admin/bower_components/jquery/src/jquery.js')}}"></script>
       <script type="text/javascript">
$(document).ready(function(){
       $('#delete_tertimbang').on('show.bs.modal', function(event){
         console.log(event);
          var button = $(event.relatedTarget);
          var nm_tertimbang = button.data('nm_tertimbang');
          var modal = $(this)
         modal.find('.modal-body #hapus_id_tertimbang').val(nm_tertimbang);
       });
    });
       </script>

