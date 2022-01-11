@extends('admin.layoutadmin')

@section('header')
<section class="content-header">
    <h1>
        Asignar IMEI
        <small>Registrar Códigos IMEI</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{route('dashboard')}}"><i class="fa fa-tachometer-alt"></i> Inicio</a></li>
        <li><a href="{{route('compras.index')}}"><i class="fa fa-list"></i> Compras</a></li>
        <li class="active">Asignar IMEI</li>
    </ol>
</section>
@stop

@section('content')
<form method="POST" id="ImeiForm" action="{{route('compras.saveimei')}}" autocomplete="off">
    {{csrf_field()}}
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-body">
                <div class="row">
                    <div class="col-sm-2">
                        <label for="detalle_id">Detalle Id:</label>
                        <input type="text" class="form-control" name="detalle_id" id="detalle_id" value="{{$ingresoDetalle->id}}" tabindex="1">
                        <input type="hidden" class="form-control" name="maestro_id" id="maestro_id" value="{{$ingresoDetalle->ingreso_maestro_id}}">
                    </div>
                    <div class="col-sm-2">
                        <label for="producto_id">Producto Id:</label>
                        <input type="text" class="form-control" name="producto_id" id="producto_id" value="{{$idet[0]->producto_id}}" tabindex="1">
                    </div>
                    <div class="col-sm-8">
                        <label for="producto">Producto:</label>
                        <input type="text" class="form-control" name="producto" id="producto" value="{{$producto[0]->descripcion}}" tabindex="2">
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-sm-4">
                        <label for="cantidad">Cantidad:</label>
                        <input type="text" class="form-control" name="cantidad" id="cantidad" value="{{$idet[0]->cantidad}}" tabindex="3">
                    </div>
                    <div class="col-sm-4">
                        <label for="precio_compra">Precio de Compra:</label>
                        <input type="text" class="form-control" name="precio_compra" id="precio_compra" value="{{$idet[0]->precio_compra}}" tabindex="4">
                    </div>
                    <div class="col-sm-4">
                        <label for="subtotal">Subtotal:</label>
                        <input type="text" class="form-control" name="subtotal" id="subtotal" value="{{$idet[0]->subtotal}}" tabindex="5">
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-sm-5">
                        <label for="codimei">Código IMEI:</label>
                        <input type="number" class="form-control" name="codimei" id="codimei" tabindex="6">
                        <input type="hidden" class="form-control" name="count" id="count" value="0">
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
                            <button id="agregar-detalle" class="btn btn-success form-button" tabindex="7">Agregar al detalle</button>
                        </div>
                    </div>
                </div>
                <br>
                <table id="imei-table" class="table table-striped table-bordered no-margin-bottom dt-responsive nowrap" width="100%">
                </table>
                <br>
                <div class="text-right m-t-15">
                    <a class='btn btn-primary form-button' href="{{ route('compras.index') }}">Regresar</a>
                    <button id="ButtonImei" class="btn btn-success form-button">Guardar</button>
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


$("#ImeiForm").show(function () {

    $('#codimei').focus();

    var detalle_id = $("#detalle_id").val();

    var url = "/compras/getimeis/" + detalle_id ;
    if (detalle_id != "") {
        $.getJSON( url , function ( result ) {
        
            $filas = result.length;

            for(i=0; i<$filas; i++)
            {
                imei_table.row.add({
                    'imei': result[i].imei
                }).draw();
            }
        });
    }
});



function chkflds() {
        if ($('#codimei').val() ) {
            return true
        } else {
            return false
        }
    }


    $('#agregar-detalle').click(function(e) {
        e.preventDefault();

        var codimei = $("#codimei").val();
	    var url = "/compras/getImei/" + codimei ;
		$.getJSON( url , function ( result ) {
            $filas = result.length;
        

        if ($filas == 0){
        
            if (chkflds()) {
                var c1 = parseFloat($('#cantidad').val());
                var c2 = parseFloat($('#count').val());

                if (c1 == c2){
                    alertify.set('notifier', 'position', 'top-center');
                    alertify.error('Ya no puede ingresar más imei, el total ya se ha ingresado')
                }
                else
                {
                
                    var codimei = $('#codimei').val();
                    var largo = codimei.length;


                    if (largo == 15){

                        var conteo = parseFloat($('#count').val());
                        conteo = conteo + 1;
                        $("input[name='count'] ").val(conteo);
                
                        imei_table.row.add({
                        'imei': $('#codimei').val()
                        }).draw();

                        //resets form data
                        $('#codimei').focus();
                        $('#codimei').val(null);
                        $("input[name='imeiunico'] ").val("X");

                    }else{
                        alertify.set('notifier', 'position', 'top-center');
                        alertify.error('El largo del IMEI debe ser de 15 dígitos')
                    }

            
                }

            } else {
                alertify.set('notifier', 'position', 'top-center');
                alertify.error('Debe ingresar un imei o el IMEI ya se encuentra registrado en el sistema')
            }

        } else {
            alertify.set('notifier', 'position', 'top-center');
            alertify.error('El IMEI ya se encuentra registrado en el sistema')
        }

    });

    });


    




    $(document).on('click', '#ButtonImei', function(e) {
        var maestro_id = $("#maestro_id").val();

        e.preventDefault();
        if ($('#ImeiForm').valid()) {
            var arr1 = $('#ImeiForm').serializeArray();
            var arr2 = imei_table.rows().data().toArray();
            var arr3 = arr1.concat(arr2);

            $.ajax({
                type: 'POST'
                , url: "{{route('compras.saveimei')}}"
                , headers: {
                    'X-CSRF-TOKEN': $('#tokenReset').val()
                , }
                , data: JSON.stringify(arr3)
                , dataType: 'json'
                , success: function() {
                    $('#codimei').val(null);
                    imei_table.rows().remove().draw();
                    window.location.assign('/compras/'+ maestro_id+'')
                }
                , error: function() {
                    alertify.set('notifier', 'position', 'top-center');
                    alertify.error('Hubo un error al registrar el registro de Imeis')
                }
            })
        }
    });

</script>

<script src="{{asset('js/compras/imei.js')}}"></script>{{-- datatable --}}
@endpush
