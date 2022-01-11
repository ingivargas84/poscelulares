@extends('admin.layoutadmin')

@section('header')
    <section class="content-header">
        <h1>
          Historial de Precio de Compra por Producto
        </h1>
    </section>
@stop

@section('content')
    <form method="POST" id="RptPrecioCompraProductoForm"  action="{{route('reportes.pdf_precio_compra_producto')}}" >
            {{csrf_field()}}
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-body">
                        <div class="row">
                            <div class="col-sm-12">
                                <label for="producto_id">Producto:</label>
                                <select name="producto_id" class="selectpicker form-control" data-live-search="true" id="producto_id" tabindex="1">
                                    <option value="default">Seleccione un Producto</option>
                                    @foreach ($productos as $cl)
                                    <option value="{{$cl->id}}">{{$cl->descripcion}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <br>
                        <div class="text-right m-t-15">
                            <a class='btn btn-primary form-button' href="{{ route('dashboard') }}">Regresar</a>
                            <button id="ButtonRptPrecioCompraProducto" class="btn btn-success form-button" >Generar PDF</button>
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

$.validator.addMethod("select", function (value, element, arg) {
    return arg !== value;
    }, "Debe seleccionar un producto");



var validator = $('#RptPrecioCompraProductoForm').validate({
    onkeyup: false,
    ignore: [],
    rules: {
        producto_id: {
            required: true,
            select: 'default'
        }
    },
    messages: {
        producto_id: {
            required: "Debe seleccionar un producto"
        },
    }
});

</script>

@endpush
