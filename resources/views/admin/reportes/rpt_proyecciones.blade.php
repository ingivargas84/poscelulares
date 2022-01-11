@extends('admin.layoutadmin')

@section('header')
    <section class="content-header">
        <h1>
          Reporte de Proyecciones
        </h1>
    </section>
@stop

@section('content')
    <form method="POST" id="RptProyeccionesForm"  action="{{route('reportes.pdf_proyecciones')}}" >
            {{csrf_field()}}
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-body">
                        <div class="row">
                            <div class="col-sm-6">
                                <label for="proyeccion">Tipo Proyección:</label>
                                <select name="proyeccion" class="selectpicker form-control" id="proyeccion">
                                    <option value="default">Elija un tipo de proyección</option>
                                    <option value="1">Poner en Oferta</option>
                                    <option value="2">Hacer Pedido</option>
                                    
                                </select>
                            </div>
                            <div class="col-sm-6">
                                <label for="fecha_inicial">Fecha Inicial:</label>
                                <div class="input-group date" id="fecha_inicial">
                                    <input class="form-control" name="fecha_inicial" id="fecha_inicial" placeholder="Fecha Inicial">
                                    <div class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></div>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="text-right m-t-15">
                            <a class='btn btn-primary form-button' href="{{ route('dashboard') }}">Regresar</a>
                            <button id="ButtonRptProyecciones" class="btn btn-success form-button" >Generar PDF</button>
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



    $.validator.addMethod("select", function (value, element, arg) {
    return arg !== value;
    }, "Debe seleccionar una proyección");



var validator = $('#RptProyeccionesForm').validate({
    onkeyup: false,
    ignore: [],
    rules: {
        proyeccion: {
            required: true,
            select: 'default'
        }
    },
    messages: {
        proyeccion: {
            required: "Debe seleccionar una proyección"
        },
    }
});

</script>

@endpush
