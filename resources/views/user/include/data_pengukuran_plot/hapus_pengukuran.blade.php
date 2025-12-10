<div class="modal modal-danger fade" id="hapus_data_pengukuran">
       <div class="modal-dialog">
         <div class="modal-content">
           <div class="modal-header">
             <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span></button>
             <h4 class="modal-title">Hapus Data</h4>
           </div>
           <form class="" action="{{route('user.pengukuran.hapus')}}" method="get">
             {{csrf_field()}}
           <div class="modal-body">
             <p>Yakin ingin menghapus data?</p>
             <input type="hidden" name="hapus_id" id="hapus_id" value="">
           </div>
           <div class="modal-footer">
             <button type="button" class="btn btn-outline" data-dismiss="modal">Keluar</button>
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
       $('#hapus_data_pengukuran').on('show.bs.modal', function(event){
          var button = $(event.relatedTarget);
          var dpp = button.data('pengukuran');
          var modal = $(this)
         modal.find('.modal-body #hapus_id').val(dpp);
       });
    });
       </script>
