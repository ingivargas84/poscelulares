<!-- Modal -->
<div class="modal fade" id="modalConfirmarAccion" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <form method="POST" id="ConfirmarAccionForm">
        {{--{{ method_field('put') }}--}}

      <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title" id="myModalLabel">Desea continuar con la desactivación o eliminación?</h4>
            </div>
            <div class="modal-body">

              <input type="hidden" name="_token" id="tokenConfirmarAccion" value="{{ csrf_token() }}">
              <input type="hidden" name="id" id="idConfirmacion">
              <input type="hidden" name="pedido_id">
              <input type="hidden" name="orden_id">
              <input type="hidden" name="bodega_id">
              <input type="hidden" name="precio_cuenta">

            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
              <button type="submit" class="btn btn-primary" id="btnConfirmarAccion" >Autorizar</button>
            </div>
          </div>
        </div>
    </form>
</div>

@push('scripts')
   <script>

    if(window.location.hash === '#confirmar')
    {
        $('#modalConfirmarAccion').modal('show');
    }

    $('#modalConfirmarAccion').on('hide.bs.modal', function(){
        $("#ConfirmarAccionForm").validate().resetForm();
		document.getElementById("ConfirmarAccionForm").reset();
        window.location.hash = '#';
        window.location.reload();

    });

    $('#modalConfirmarAccion').on('shown.bs.modal', function(){
        window.location.hash = '#confirmar';

    });

    $('#modalConfirmarAccion').on('shown.bs.modal', function(event){
        var button = $(event.relatedTarget);
        var id = button.data('id');
        var pedido_id = button.data('pedido_id');
        var orden_id = button.data('orden_id');
        var bodega_id = button.data('bodega_id');
        var precio = button.data('precio');

        var modal = $(this);
        modal.find(".modal-body input[name='id']").val(id);
        modal.find(".modal-body input[name='pedido_id']").val(pedido_id);
        modal.find(".modal-body input[name='orden_id']").val(orden_id);
        modal.find(".modal-body input[name='bodega_id']").val(bodega_id);
        modal.find(".modal-body input[name='precio_cuenta']").val(precio);

    });

    function BorrarFormularioConfirmar() {
        $("#ConfirmarAccionForm :input").each(function () {
            $(this).val('');
        });
    };


    </script>
@endpush
