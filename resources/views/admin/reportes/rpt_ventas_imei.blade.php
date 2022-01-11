@extends('admin.layoutadmin')

@section('header')
    <section class="content-header">
        <h1>
          Reporte de Ventas por Imei y Producto
        </h1>
    </section>
@stop

@section('content')
    <form method="POST" id="RptVentasImeiForm"  action="{{route('reportes.pdf_ventas_imei')}}" >
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
                        <div class="row">
                            <div class="col-md-6 col-sm-6">
                                <label for="fecha_inicial">Fecha Inicial:</label>
                                <div class="input-group date" id="fecha_inicial">
                                    <input class="form-control" name="fecha_inicial" id="fecha_inicial" placeholder="Fecha Inicial" tabindex="4">
                                    <div class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></div>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6">
                                <label for="fecha_final">Fecha Final:</label>
                                <div class="input-group date" id="fecha_final">
                                    <input class="form-control" name="fecha_final" id="fecha_final" placeholder="Fecha Final" tabindex="5">
                                    <div class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></div>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="text-right m-t-15">
                            <a class='btn btn-primary form-button' href="{{ route('dashboard') }}">Regresar</a>
                            <button id="ButtonRptVentasImei" class="btn btn-success form-button" >Generar PDF</button>
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

    //datepicker settings
    $('#fecha_inicial').datepicker({
        language: "es",
        todayHighlight: true,
        clearBtn: true,
        format: 'dd-mm-yyyy',
        autoclose: true,
    }).datepicker("setDate", new Date());


    $('#fecha_final').datepicker({
        language: "es",
        todayHighlight: true,
        clearBtn: true,
        format: 'dd-mm-yyyy',
        autoclose: true,
    }).datepicker("setDate", new Date());


    $.validator.addMethod("select", function (value, element, arg) {
    return arg !== value;
    }, "Debe seleccionar un producto");



var validator = $('#RptVentasImeiForm').validate({
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
