@extends('admin.layoutadmin')

@section('header')
    <section class="content-header">
        <h1>
          Detalle de Ventas por Tienda y Fecha
        </h1>
    </section>
@stop

@section('content')
    <form method="POST" id="RptVentasFechaTiendaForm"  action="{{route('reportes.pdf_ventas_fecha_tienda')}}" >
            {{csrf_field()}}
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-body">
                        <div class="row">
                            <div class="col-sm-6">
                                <label for="tienda_id">Tienda:</label>
                                <select name="tienda_id" class="form-control" id="tienda_id" >
                                    @if ($rol[0]->id < 3)
                                    <option value="default">Todas las Tiendas</option>
                                    @endif
                                    @foreach ($tiendas as $td)
                                    <option value="{{$td->id}}">{{$td->tienda}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 col-sm-6">
                                <label for="fecha">Fecha:</label>
                                <div class="input-group date" id="fecha">
                                    <input class="form-control" name="fecha" id="fecha" placeholder="Fecha">
                                    <div class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></div>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="text-right m-t-15">
                            <a class='btn btn-primary form-button' href="{{ route('dashboard') }}">Regresar</a>
                            <button id="ButtonRptVentasFechaTienda" class="btn btn-success form-button" >Generar PDF</button>
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
    $('#fecha').datepicker({
        language: "es",
        todayHighlight: true,
        clearBtn: true,
        format: 'dd-mm-yyyy',
        autoclose: true,
    }).datepicker("setDate", new Date());



</script>


@endpush
