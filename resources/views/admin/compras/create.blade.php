@extends('admin.layoutadmin')

@section('header')
<section class="content-header">
    <h1>
        COMPRAS
        <small>Registrar una Compra</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{route('dashboard')}}"><i class="fa fa-tachometer-alt"></i> Inicio</a></li>
        <li><a href="{{route('compras.index')}}"><i class="fa fa-list"></i> Compras</a></li>
        <li class="active">Crear</li>
    </ol>
</section>
@stop

@section('content')
<form method="POST" id="CompraForm" action="{{route('compras.save')}}" autocomplete="off">
    {{csrf_field()}}
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-body">
                <div class="row">
                    <div class="col-sm-4">
                        <label for="proveedor_id">Proveedor:</label>
                        <select name="proveedor_id" class="form-control" id="proveedores" autofocus tabindex="1">
                            <option value="default">Seleccione un proveedor</option>
                            @foreach ($proveedores as $prov)
                            <option value="{{$prov->id}}">{{$prov->nombre_comercial}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-sm-4">
                        <label for="serie_factura">Serie de la Factura:</label>
                        <input type="text" class="form-control" placeholder="No. de serie de la factura" name="serie_factura" id="serie-factura" tabindex="2">
                    </div>
                    <div class="col-sm-4">
                        <label for="num_factura">No. de la Factura:</label>
                        <input type="number" class="form-control" name="num_factura" placeholder="No. de la factura" id="no-factura" tabindex="3">
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-sm-4">
                        <label for="fecha_factura">Fecha de la factura:</label>
                        <div class="input-group date" id="fecha-factura-dp">
                            <input class="form-control" name="fecha_factura" id="fecha-factura" tabindex="4" placeholder="Fecha de realización de la compra.">
                            <div class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></div>
                            <input type="hidden" class="form-control" name="fechaunica" id="fechaunica">
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <label for="fecha_compra">Fecha de compra:</label>
                        <div class="input-group date" id="fecha-compra-dp">
                            <input class="form-control" name="fecha_compra" id="fecha-compra" tabindex="5" placeholder="Fecha de emisión de la factura.">
                            <div class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <label for="bodega_id">Bodega:</label>
                        <select name="bodega_id" class="form-control" id="bodegas" tabindex="6">
                            @foreach ($bodegas as $bod)
                            <option value="{{$bod->id}}">{{$bod->nombre}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-sm-6">
                        <label for="producto_id">Producto:</label>
                        <select name="producto_id" class="selectpicker form-control" data-live-search="true" id="producto_id" tabindex="7">
                            <option value="default">Seleccione un Producto</option>
                            @foreach ($productos as $pro)
                            <option value="{{$pro->id}}">{{$pro->descripcion}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-sm-6">
                        <label for="descripcion">Descripcion producto:</label>
                        <input type="text" class="form-control" placeholder="Descripcion producto" name="descripcion" readonly id="descripcion">
                        <input type="text" name="prod_id" readonly hidden id="prod_id">
                    </div>
                    <div class="col-sm-3">
                        <label for="cantidad">Cantidad:</label>
                        <input type="number" class="form-control" placeholder="Cantidad del producto" name="cantidad" id="cantidad" tabindex="8">
                    </div>
                    <div class="col-sm-3">
                        <label for="precio_compra">Precio de Compra:</label>
                        <input type="number" class="form-control" placeholder="Precio de Compra" name="precio_compra" id="precio-compra" tabindex="9">
                    </div>
                </div>

                <br>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="text-left m-t-15">
                            <h3>Detalle</h3>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="text-right m-t-15" style="margin-top: 15px; margin-bottom: 10px">
                            <button id="agregar-detalle" class="btn btn-success form-button" tabindex="10">Agregar al detalle</button>
                        </div>
                    </div>
                </div>
                <br>
                <table id="detalle-table" class="table table-striped table-bordered no-margin-bottom dt-responsive nowrap" width="100%">
                </table>
                <br>
                <div class="row">
                    <div class="col-sm-4">
                        <label for="total_ingreso">Total:</label>
                        <div class="input-group">
                            <span class="input-group-addon">Q.</span>
                            <input type="text" class="form-control customreadonly" placeholder="Total de la compra" name="total_ingreso" id="total_ingreso">
                        </div>
                    </div>
                </div>
                <div class="text-right m-t-15">
                    <a class='btn btn-primary form-button' href="{{ route('compras.index') }}">Regresar</a>
                    <button id="ButtonCompra" class="btn btn-success form-button">Guardar</button>
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

    //datepicker settings
    $('#fecha-factura-dp').datepicker({
        language: "es", 
        todayHighlight: true, 
        clearBtn: true, 
        format: 'dd-mm-yyyy',
        autoclose: true, 
    })


    $('#fecha-compra-dp').datepicker({
        language: "es", 
        todayHighlight: true, 
        clearBtn: true, 
        format: 'dd-mm-yyyy',
        autoclose: true, 
    })


    $("#fecha-factura-dp").change(function () {

        var fecha = $('#fecha-factura-dp').datepicker('getDate');
        var hoy = new Date();
        var diff = hoy - fecha;
        var dias = diff/(1000*60*60*24);

        if (dias > 5)
        {
            $("input[name='fechaunica'] ").val(null);
        }
        else if (dias < 0)
        {
            alertify.set('notifier', 'position', 'top-center');
            alertify.error('Debe seleccionar una fecha de hoy o anterior al día de hoy')

            $("input[name='fechaunica'] ").val("X");
        }

    });


    $("#producto_id").change(function () {
	var producto_id = $("#producto_id").val();
	var url = "/compras/getProductoData/" + producto_id ;
	if (producto_id != "") {
		$.getJSON( url , function ( result ) {
			$("input[name='descripcion'] ").val(result[0].descripcion);
            $("input[name='prod_id'] ").val(result[0].id);
            $("input[name='precio_compra'] ").val(result[0].precio_compra);
		});
	}
    });



    function chkflds() {
        if ($('#descripcion').val() && $('#cantidad').val()  && $('#precio-compra').val()) {
            return true
        } else {
            return false
        }
    }

    $('#agregar-detalle').click(function(e) {
        e.preventDefault();
        if (chkflds()) {
            //calculates the subtotal
            var subt = parseFloat($('#precio-compra').val()) * parseFloat($('#cantidad').val());
            //limits subtotal decimal places to two
            subt = subt.toFixed(2);
            //adds the form data to the table
            detalle_table.row.add({
                'producto_id': $('#prod_id').val(),
                'producto': $('#descripcion').val(),
                'cantidad': $('#cantidad').val(),
                'precio_compra': $('#precio-compra').val(),
                'subtotal': subt
            }).draw();
            //adds all subtotal row data and sets the total input
            var total = 0;
            detalle_table.column(4).data().each(function(value, index) {
                total = total + parseFloat(value);
                // parseFloat(total);
                $('#total_ingreso').val(total);
                $('#total-error').remove();
            });
            //resets form data
            $('#descripcion').val(null);
            $('#cantidad').val(null);
            $('#presentacion').val(null);
            $('#precio-compra').val(null);
            $('#producto_id').val('default');
        } else {
            alertify.set('notifier', 'position', 'top-center');
            alertify.error('Debe seleccionar un producto, cantidad o precio; o la fecha es mayor a 5 dias')
        }
    });


    $(document).on('click', '#ButtonCompra', function(e) {
        e.preventDefault();

        var num = detalle_table.rows().count();

        if ($('#fechaunica').val()){

        if ($('#CompraForm').valid() && (num > 0)) {
            var arr1 = $('#CompraForm').serializeArray();
            var arr2 = detalle_table.rows().data().toArray();
            var arr3 = arr1.concat(arr2);

            $.ajax({
                type: 'POST', 
                url: "{{route('compras.save')}}", 
                headers: {
                    'X-CSRF-TOKEN': $('#tokenReset').val(), 
                }, 
                data: JSON.stringify(arr3), 
                dataType: 'json', 
                success: function() {
                    $('#proveedores').val('default');
                    $('#bodegas').val('default');
                    $('#producto_id').val('default');
                    $('#serie-factura').val(null);
                    $('#fecha-compra').val(null);
                    $('#no-factura').val(null);
                    $('#fecha-factura').val(null);
                    $('#total').val(null);
                    detalle_table.rows().remove().draw();
                    window.location.assign('/compras?ajaxSuccess')
                }, 
                error: function() {
                    alertify.set('notifier', 'position', 'top-center');
                    alertify.error('Hubo un error al registrar la compra')
                }
            })
        }
        else
        {
            alertify.set('notifier', 'position', 'top-center');
            alertify.error('Error, No hay datos en el detalle, agregue algun producto')
      }
    }
    else
    {
            alertify.set('notifier', 'position', 'top-center');
            alertify.error('Error!! - La fecha de la factura es mayor a 5 dias, no se permite el registro de la misma')
    }
    });


</script>

<script src="{{asset('js/compras/new.js')}}"></script>{{-- datatable --}}
<script src="{{asset('js/compras/create.js')}}"></script>{{-- validator --}}
@endpush
