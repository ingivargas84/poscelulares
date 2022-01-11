@extends('admin.layoutadmin')

@section('header')
<section class="content-header">
    <h1>
        Facturas
        <small>Registrar una Factura</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{route('dashboard')}}"><i class="fa fa-tachometer-alt"></i> Inicio</a></li>
        <li><a href="{{route('facturas.index')}}"><i class="fa fa-list"></i> Facturas</a></li>
        <li class="active">Crear</li>
    </ol>
</section>
@stop

@section('content')
<form method="POST" id="FacturaForm" action="{{route('facturas.save')}}" autocomplete="off">
    {{csrf_field()}}
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-body">
                <div class="row">
                    <div class="col-sm-4">
                        <label for="pedido_maestro_id">Venta a Facturar:</label>
                        <select name="pedido_maestro_id" class="form-control" id="pedido_maestro_id">
                            <option value="default">Seleccione una Venta</option>
                            @foreach ($ventas as $ven)
                            <option value="{{$ven->id}}">{{$ven->no_pedido}} - Q. {{$ven->total}} </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-sm-8">
                        <input type="hidden" class="form-control" name="pedido" id="pedido">
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-sm-3">
                        <label for="nit">Nit:</label>
                        <input type="text" class="form-control" name="nit" id="nit" placeholder="Ingrese el nit">
                    </div>
                    <div class="col-sm-5">
                        <label for="nombre_factura">Nombre del Cliente:</label>
                        <input type="text" class="form-control" name="nombre_factura" id="nombre_factura" placeholder="Ingrese el nombre del cliente">
                    </div>
                    <div class="col-sm-4">
                        <label for="direccion">Dirección:</label>
                        <input type="text" class="form-control" name="direccion" id="direccion" placeholder="Ingrese la direccion del cliente">
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-sm-4">
                        <label for="fecha_factura">Fecha Factura:</label>
                        <input type="text" class="form-control" name="fecha_factura" id="fecha_factura" readonly placeholder="Fecha de la factura">
                    </div>
                    <div class="col-sm-4">
                        <label for="serie_factura">Serie Factura:</label>
                        <input type="text" class="form-control" name="serie_factura" id="serie_factura" placeholder="Ingrese la serie de la factura" >
                    </div>
                    <div class="col-sm-4">
                        <label for="no_factura">Número Factura:</label>
                        <input type="text" class="form-control" name="no_factura" id="no_factura" placeholder="Ingrese el número de la factura" >
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-sm-4">
                        <label for="subtotal">Subtotal</label>
                        <input type="text" class="form-control" name="subtotal" id="subtotal" placeholder="Ingrese el subtotal de la factura">
                    </div>
                    <div class="col-sm-4">
                        <label for="impuestos">Impuesto (IVA):</label>
                        <input type="text" class="form-control" name="impuestos" id="impuestos" placeholder="Ingrese el impuesto de la factura">
                    </div>
                    <div class="col-sm-4">
                        <label for="total">Total Factura:</label>
                         <input type="text" class="form-control" name="total" id="total" placeholder="Ingrese el total de la factura" >
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="text-left m-t-15">
                            <h3>Detalle Factura</h3>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="text-right m-t-15" style="margin-top: 15px; margin-bottom: 10px">
                            
                        </div>
                    </div>
                </div>
                <br>
                <table id="detalle-table" class="table table-striped table-bordered no-margin-bottom dt-responsive nowrap" width="100%">
                </table>
                <br>
            </div>
            <div class="modal-footer">
                <a class='btn btn-primary form-button' href="{{ route('facturas.index') }}">Regresar</a>
                <button id="ButtonFactura" class="btn btn-success form-button">Guardar</button>
            </div>
            <br>

        </div>
    </div>
    </div>
</form>
<div class="loader loader-bar"></div>
@stop


@push('styles')

<style>
    div.col-md-6 {
        margin-bottom: 15px;
    }

    .customreadonly {
        background-color: #eee;
        cursor: not-allowed;
        pointer-events: none;
    }

    .switch-field {
        display: flex;
        margin-bottom: 20px;
        overflow: hidden;
    }

    .switch-field input {
        position: absolute !important;
        clip: rect(0, 0, 0, 0);
        height: 1px;
        width: 1px;
        border: 0;
        overflow: hidden;
    }

    .switch-field label {
        background-color: #e4e4e4;
        color: rgba(0, 0, 0, 0.6);
        font-size: 14px;
        line-height: 1;
        text-align: center;
        padding: 8px 16px;
        margin-right: -1px;
        border: 1px solid rgba(0, 0, 0, 0.2);
        box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.3), 0 1px rgba(255, 255, 255, 0.1);
        transition: all 0.1s ease-in-out;
        width: 50%
    }

    .switch-field label:hover {
        cursor: pointer;
    }

    .switch-field input:checked+label {
        background-color: #55bd8c;
        box-shadow: none;
    }

    .switch-field label:first-of-type {
        border-radius: 4px 0 0 4px;
    }

    .switch-field label:last-of-type {
        border-radius: 0 4px 4px 0;
    }
</style>

@endpush



@push('scripts')

<script>
    $("#pedido_maestro_id").change(function() {
        var pedido_maestro_id = $("#pedido_maestro_id").val();
        var url = "/facturas/getVentaData/" + pedido_maestro_id;
        if (pedido_maestro_id != "") {
            $.getJSON(url, function(result) {
                $("input[name='pedido'] ").val(result[0].id);
                $("input[name='nit'] ").val(result[0].nit);
                $("input[name='nombre_factura'] ").val(result[0].nombre);
                $("input[name='direccion'] ").val(result[0].direccion);
                $("input[name='fecha_factura'] ").val(result[0].fecha_ingreso);
                $("input[name='total'] ").val(result[0].total);
                $("input[name='subtotal'] ").val( (result[0].total / 1.12 ) );
                $("input[name='impuestos'] ").val( (result[0].total - (result[0].total / 1.12 )) );


                $filas = result.length;

                for(i=0; i<$filas; i++)
                {
                    detalle_table.row.add({
                    'producto_id': result[i].producto_id,
                    'producto': result[i].producto,
                    'imei': result[i].imei,
                    'cantidad': result[i].cantidad,
                    'precio_unitario': result[i].precio,
                    'subtotal': result[i].subtotal,
                }).draw();
            }


            });
        }
    });



    $(document).on('click', '#ButtonFactura', function(e) {
        e.preventDefault();
        if ($('#FacturaForm').valid()) {
            var arr1 = $('#FacturaForm').serializeArray();
            var arr2 = detalle_table.rows().data().toArray();
            var arr3 = arr1.concat(arr2);

            $.ajax({
                type: 'POST',
                url: "{{route('facturas.save')}}",
                headers: {
                    'X-CSRF-TOKEN': $('#tokenReset').val(),
                },
                data: JSON.stringify(arr3),
                dataType: 'json',
                success: function() {
                    $('#pedidos_maestro_id').val('default');
                    $('#nit').val('default');
                    $('#nombre_factura').val('default');
                    $('#direccion').val(null);
                    $('#fecha_factura').val(null);
                    $('#serie_factura').val(null);
                    $('#no_factura').val(null);
                    $('#subtotal').val(null);
                    $('#impuestos').val(null);
                    $('#total').val(null);
                    detalle_table.rows().remove().draw();
                    window.location.assign('/facturas?ajaxSuccess')
                },
                error: function() {
                    alertify.set('notifier', 'position', 'top-center');
                    alertify.error('Hubo un error al registrar la factura')
                }
            })
        }
    });
</script>

<script src="{{asset('js/facturas/detalle.js')}}"></script>{{-- datatable --}}
<script src="{{asset('js/facturas/create.js')}}"></script>{{-- validator --}}
@endpush