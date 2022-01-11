@extends('admin.layoutadmin')

@section('header')
    <section class="content-header">
        <h1>
          Reporte de Ventas por Imei y Producto
        </h1>
    </section>
@stop

@section('content')
    <form method="POST" id="RptInventarioGralForm"  action="{{route('reportes.pdf_inventario_general_costos')}}" >
            {{csrf_field()}}
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-body">
                        <div class="row">
                            <div class="col-sm-12">
                                <label for="tienda_id">Tiendas:</label>
                                <select name="tienda_id" class="selectpicker form-control" id="tienda_id">
                                    <option value="default">Todas las tiendas</option>
                                    @foreach ($tiendas as $td)
                                    <option value="{{$td->id}}">{{$td->tienda}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <br>
                        <div class="text-right m-t-15">
                            <a class='btn btn-primary form-button' href="{{ route('dashboard') }}">Regresar</a>
                            <button id="ButtonRptInventarioGral" class="btn btn-success form-button" >Generar PDF</button>
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

</script>

@endpush
