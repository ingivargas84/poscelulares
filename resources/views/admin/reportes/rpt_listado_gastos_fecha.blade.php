@extends('admin.layoutadmin')

@section('header')
    <section class="content-header">
        <h1>
          Detalle de Gastos
        </h1>
    </section>
@stop

@section('content')
    <form method="POST" id="RptListadoGastosForm"  action="{{route('reportes.pdf_listado_gastos_fecha')}}" >
            {{csrf_field()}}
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-body">
                        <div class="row">
                            <div class="col-sm-4">
                                <label for="tienda_id">Tienda:</label>
                                <select name="tienda_id" class="form-control" id="tienda_id" >
                                    <option value="default">Todas las tiendas</option>
                                    @foreach ($tiendas as $td)
                                    <option value="{{$td->id}}">{{$td->tienda}}</option>
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
                            <button id="ButtonRptListadoGastos" class="btn btn-success form-button" >Generar PDF</button>
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


</script>

@endpush
