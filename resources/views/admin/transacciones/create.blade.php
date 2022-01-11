@extends('admin.layoutadmin')

@section('header')
    <section class="content-header">
        <h1>
          Transaccion Bancaria
          <small>Registro de Transaccion</small>
        </h1>
        <ol class="breadcrumb">
          <li><a href="{{route('dashboard')}}"><i class="fa fa-tachometer-alt"></i> Inicio</a></li>
          <li><a href="{{route('transacciones.index')}}"><i class="fa fa-list"></i> Transacciones</a></li>
          <li class="active">Crear</li>
        </ol>
    </section>
@stop

@section('content')
    <form method="POST" id="TransaccionesForm"  action="{{route('transacciones.save')}}">
            {{csrf_field()}}
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-body">
                        <div class="row">
                            <div class="col-sm-4">
                                <label for="tienda_id">Tienda:</label>
                                <select name="tienda_id" id="tienda_id" class="form-control">
                                <option value="default">Seleccione una Tienda</option>
                                    @foreach ($tienda as $rg)
                                        <option value="{{$rg->id}}">{{$rg->tienda}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-sm-4">
                                <label for="banco_id">Banco:</label>
                                <select name="banco_id" id="banco_id" class="form-control">
                                <option value="default">Seleccione un Banco</option>
                                    @foreach ($banco as $bc)
                                        <option value="{{$bc->id}}">{{$bc->banco}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-sm-4">
                                <label for="tipo_transaccion_id">Transacción:</label>
                                <select name="tipo_transaccion_id" id="tipo_transaccion_id" class="form-control">
                                <option value="default">Seleccione una Transaccion</option>
                                    @foreach ($tipo_transaccion as $tr)
                                        <option value="{{$tr->id}}">{{$tr->tipo_transaccion}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-sm-4">
                                <label for="monto_total">Monto Real:</label>
                                <input type="text" class="form-control" placeholder="Monto Real" name="monto_total" id="monto_total" >
                            </div>
                            <div class="col-sm-4">
                                <label for="monto_cobrado">Monto Cobrado:</label>
                                <input type="text" class="form-control" placeholder="Monto Cobrado" name="monto_cobrado" id="monto_cobrado" >
                            </div>
                            <div class="col-sm-4">
                                <label for="monto_favor">Monto a Favor:</label>
                                <input type="text" class="form-control" placeholder="Monto a Favor" name="monto_favor" id="monto_favor" >
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-sm-12">
                                <label for="descripcion">Descripcion:</label>
                                <input type="text" class="form-control" placeholder="Descripción" name="descripcion" id="descripcion" >
                            </div>
                        </div>
                        <br>
                        <div class="text-right m-t-15">
                            <a class='btn btn-primary form-button' href="{{ route('transacciones.index') }}">Regresar</a>
                            <button id="ButtonTransacciones" class="btn btn-success form-button">Guardar</button>
                        </div>

                    </div>
                </div>
            </div>
    </form>
    <div class="loader loader-bar"></div>

@stop


@push('styles')

@endpush

@push('scripts')
<script>

$("#tipo_transaccion_id").change(function () {
	var tipo_transaccion_id = $("#tipo_transaccion_id").val();
	
	if (tipo_transaccion_id == 4) {

        $("input[name='monto_favor'] ").val(2);

	}
});


$(document).on('focusout', '#monto_total', function(){

    if ($("#tipo_transaccion_id").val() == 4)
    {
        if ($("#monto_total").val() <= 5000 ){

            $('#monto_cobrado').val(null);
            let tot = parseFloat($('#monto_total').val()) + parseFloat($('#monto_favor').val());
            tot = tot.toFixed(2);
            $('#monto_cobrado').val(tot);

        }
        else
        {
            alertify.set('notifier', 'position', 'top-center');
            alertify.error  ('Error, no se puede pagar un cheque que su valor sea mayor a Q5,000.00')
        }
    }
          
});


$(document).on('focusout', '#monto_cobrado', function(){

if ($("#tipo_transaccion_id").val() !== 4)
{
    $('#monto_favor').val(null);
      let tot = parseFloat($('#monto_cobrado').val()) - parseFloat($('#monto_total').val());
      tot = tot.toFixed(2);
      $('#monto_favor').val(tot);

}


      
});
</script>

<script src="{{asset('js/transacciones/create.js')}}"></script>
@endpush
