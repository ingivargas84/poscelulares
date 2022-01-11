@extends('admin.layoutadmin')

@section('header')
<section class="content-header">
    <h1>
        Anulación de Facturas
        <small>Registrar una Anulación</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{route('dashboard')}}"><i class="fa fa-tachometer-alt"></i> Inicio</a></li>
        <li><a href="{{route('facturas.index')}}"><i class="fa fa-list"></i> Facturas</a></li>
        <li class="active">Crear</li>
    </ol>
</section>
@stop

@section('content')
<form method="POST" id="FacturaAnulaForm" action="{{route('facturas.destroy')}}" autocomplete="off">
    {{csrf_field()}}
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-body">
            <div class="row">
                    <div class="col-md-12 col-sm-12 text-center">
                        <h2><strong>Información de la Factura</strong></h2>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-md-4 col-sm-4">
                        <h4><strong>NIT:</strong> {{$factura->nit}} </h4>
                    </div>
                    <div class="col-md-4 col-sm-4">
                        <h4><strong>Nombre Cliente:</strong> {{$factura->nombre_factura}} </h4>
                    </div>
                    <div class="col-md-4 col-sm-4">
                        <h4><strong>Dirección:</strong> {{$factura->direccion}}</h4>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-md-4 col-sm-4">
                        <h4><strong>Fecha Factura:</strong> {{Carbon\Carbon::parse($factura->fecha_factura)->format('d-m-Y')}} </h4>
                    </div>
                    <div class="col-md-4 col-sm-4">
                        <h4><strong>Serie Factura:</strong> {{$factura->serie_factura}} </h4>
                    </div>
                    <div class="col-md-4 col-sm-4">
                        <h4><strong>Número Factura:</strong> {{$factura->no_factura}} </h4>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-md-4 col-sm-4">
                        <h4><strong>Subtotal:</strong> Q. {{$factura->subtotal}} </h4>
                    </div> 
                    <div class="col-md-4 col-sm-4">
                        <h4><strong>Impuestos:</strong> Q. {{$factura->impuestos}} </h4>
                    </div>
                    <div class="col-md-4 col-sm-4">
                        <h4><strong>Total:</strong> Q. {{$factura->total}} </h4>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-sm-3">
                        <label for="factura_id">Codigo Factura:</label>
                        <input type="text" class="form-control" name="factura_id" id="factura_id" value="{{$factura->id}}">
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-sm-12">
                        <label for="motivo_anulacion">Motivo de Anulación:</label>
                        <input type="text" class="form-control" name="motivo_anulacion" id="motivo_anulacion" placeholder="Ingrese la razón para Anular la presente factura">
                    </div>
                </div>

                <br>
            <div class="modal-footer">
                <a class='btn btn-primary form-button' href="{{ route('facturas.index') }}">Regresar</a>
                <button id="ButtonAnulaFactura" class="btn btn-success form-button">Anular</button>
            </div>
            <br>

        </div>
    </div>
    </div>
</form>
<div class="loader loader-bar"></div>
@stop


@push('styles')


<script>
   var validator = $("#FacturaAnulaForm").validate({

ignore: [],
onkeyup:false,
rules: {
    motivo_anulacion:{
        required: true
    }
},
messages: {
    motivo_anulacion: {
        required: "Por favor, ingrese el motivo para anular la factura"
    }

}
});

$("#ButtonAnulaFactura").click(function(event) {
if ($('#FacturaAnulaForm').valid()) {
    $('.loader').addClass("is-active");
    var btnAceptar=document.getElementById("ButtonAnulaFactura");
    var disableButton = function() { this.disabled = true; };
    btnAceptar.addEventListener('click', disableButton , false);
} else {
    validator.focusInvalid();
}
});
</script>

@endpush