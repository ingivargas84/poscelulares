@extends('admin.layoutadmin')

@section('header')
    <section class="content-header">
        <h1>
          Ventas por Usuario y Fecha
        </h1>
    </section>
@stop

@section('content')
    <form method="POST" id="RptVentasUsuarioForm"  action="{{route('reportes.pdf_ventas_usuario')}}" >
            {{csrf_field()}}
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-body">
                        <div class="row">
                            <div class="col-sm-4">
                                <label for="user_id">Usuario:</label>
                                <select name="user_id" class="form-control" id="user_id" >
                                    <option value="default">Seleccione un Usuario</option>
                                    @foreach ($usuarios as $us)
                                    <option value="{{$us->id}}">{{$us->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-sm-4">
                                <label for="fecha_inicial">Fecha Inicial:</label>
                                <div class="input-group date" id="fecha_inicial">
                                    <input class="form-control" name="fecha_inicial" id="fecha_inicial" placeholder="Fecha Inicial">
                                    <div class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <label for="fecha_final">Fecha Final:</label>
                                <div class="input-group date" id="fecha_final">
                                    <input class="form-control" name="fecha_final" id="fecha_final" placeholder="Fecha Final">
                                    <div class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></div>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="text-right m-t-15">
                            <a class='btn btn-primary form-button' href="{{ route('dashboard') }}">Regresar</a>
                            <button id="ButtonRptVentasUsuario" class="btn btn-success form-button" >Generar PDF</button>
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



var validator = $('#RptVentasUsuarioForm').validate({
    onkeyup: false,
    ignore: [],
    rules: {
        user_id: {
            required: true,
            select: 'default'
        }
    },
    messages: {
        user_id: {
            required: "Debe seleccionar un usuario"
        },
    }
});



</script>

@endpush
