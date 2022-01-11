@extends('admin.layoutadmin')

@section('header')
    <section class="content-header">
        <h1>
          CLIENTES
          <small>Crear Cliente</small>
        </h1>
        <ol class="breadcrumb">
          <li><a href="{{route('dashboard')}}"><i class="fa fa-tachometer-alt"></i> Inicio</a></li>
          <li><a href="{{route('clientes.index')}}"><i class="fa fa-list"></i> Clientes</a></li>
          <li class="active">Crear</li>
        </ol>
    </section>
@stop

@section('content')
    <form method="POST" id="ClienteForm"  action="{{route('clientes.save')}}">
            {{csrf_field()}}
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-body">
                        <div class="row">
                            <div class="col-sm-4">
                                <label for="nit">Nit:</label>
                                <input type="text" class="form-control" placeholder="Nit:" name="nit" >
                            </div>
                            <div class="col-sm-8">
                                <label for="nombre_cliente">Nombre:</label>
                                <input type="text" class="form-control" placeholder="Nombre del cliente" name="nombre_cliente" >
                            </div> 
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-sm-4">
                                <label for="dias_credito">Días de crédito</label>
                                <input type="text" class="form-control" name="dias_credito" placeholder="Días de crédito">
                            </div>
                            <div class="col-sm-8">
                                <label for="direccion">Dirección:</label>
                                <input type="text" class="form-control" placeholder="Dirección:" name="direccion" >
                            </div>
                           
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-sm-4">
                                <label for="email">E-mail:</label>
                                <input type="text" class="form-control" placeholder="E-mail:" name="email" >
                            </div>
                            <div class="col-sm-4">
                                <label for="fec_nacimiento">Fecha Nacimiento:</label>
                                <div class="input-group date" id="fec_nacimiento">
                                <input class="form-control" name="fec_nacimiento" id="fec_nacimiento" placeholder="Fecha Nacimiento" tabindex="3">
                                <div class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></div>
                        </div>
                            </div>
                            <div class="col-sm-4">
                                <label for="telefonos">Telefonos:</label>
                                <input type="text" class="form-control" placeholder="Teléfonos:" name="telefonos" >
                            </div>
                        </div>
                        <br>
                        <div class="text-right m-t-15">
                            <a class='btn btn-primary form-button' href="{{ route('clientes.index') }}">Regresar</a>
                            <button id="ButtonCliente" class="btn btn-success form-button">Guardar</button>
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

    

$(document).ready(function(){

    $('#fec_nacimiento').datepicker({
        language: "es",
        todayHighlight: true,
        clearBtn: true,
        format: 'dd-mm-yyyy',
        autoclose: true,
    }).datepicker("setDate", new Date());

});


    $.validator.addMethod("nitUnico", function(value, element) {
        var valid = false;
        $.ajax({
            type: "GET",
            async: false,
            url: "{{route('clientes.nitDisponible')}}",
            data: "nit=" + value,
            dataType: "json",
            success: function(msg) {
                valid = !msg;
            }
        });
        return valid;
    }, "El nit ya está registrado en el sistema");
</script>

<script src="{{asset('js/clientes/create.js')}}"></script>
@endpush
