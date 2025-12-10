<div class="modal modal-danger fade" id="modal_delete_foto">
       <div class="modal-dialog">
         <div class="modal-content">
           <div class="modal-header">
             <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span></button>
             <h4 class="modal-title">Hapus Foto</h4>
           </div>
           <form class="" action="{{route('user.hapus_foto_ktk')}}" method="get">
             {{csrf_field()}}
           <div class="modal-body">
             <p>Yakin ingin menghapus data?</p>
             <input type="hidden" name="hapus_id_foto" id="hapus_id_foto" value="">
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
       $('#modal_delete_foto').on('show.bs.modal', function(event){
          var button = $(event.relatedTarget);
          var foto = button.data('foto');
          var modal = $(this)
         modal.find('.modal-body #hapus_id_foto').val(foto);

       });
    });
       </script>
