@extends('admin.layoutadmin')

@section('header')
<section class="content-header">
    <h1>
        Existencias
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{route('dashboard')}}"><i class="fa fa-tachometer-alt"></i> Inicio</a></li>
        <li><a href="{{route('productos.index')}}"><i class="fa fa-list"></i> Productos</a></li>
        <li class="active">Ver</li>
    </ol>
</section>
@stop

@section('content')
<form id="CotizacionForm">
    {{csrf_field()}}
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-body">
                <div class="row">
                    <div class="col-md-12 col-sm-12 text-center">
                        <h2><strong><u>Existencias de Productos</u></strong></h2>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-md-6 col-sm-6">
                        <h4><strong>Código del Producto:</strong> {{$existencias[0]->codigo}} </h4>
                    </div>
                    <div class="col-md-6 col-sm-6" >
                        <h4 style="text-align:right;"><strong>Precio de Venta:</strong> Q. {{$existencias[0]->precio_venta}} </h4>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 col-sm-12">
                        <h4><strong>Producto:</strong> {{$existencias[0]->descripcion}} </h4>                    
                    </div>
                </div>
                <div class="col-md-12 col-sm-12 text-center">
                        <h3><strong><u>Existencias por Tienda</u></strong></h3>
                    </div>

                <table border="1" cellspacing=0 cellpadding=2 width= 800 class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th width=60% style="font-size:18px; text-align:left;">Tienda</th>
                                <th width=40% style="font-size:18px; text-align:center;">Existencias</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($existencias as $ex)
                            <tr>
                                <td style="font-size:15px; text-align:left;">{{$ex->tienda}}</td>
                                <td style="font-size:15px; text-align:center;">{{ $ex->existencias }}</td>                                
                            </tr>
                            @endforeach
                        </tbody>
                </table>
                <div class="col-md-12 col-sm-12 text-center">
                        <h3><strong><u>Existencias por Bodega</u></strong></h3>
                    </div>
                <table border="1" cellspacing=0 cellpadding=2 width= 800 class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th width=40% style="font-size:18px; text-align:left;">Tienda</th>
                                <th width=40% style="font-size:18px; text-align:left;">Bodega</th>
                                <th width=20% style="font-size:18px; text-align:center;">Existencias</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($existenciasbod as $exb)
                            <tr>
                                <td style="font-size:15px; text-align:left;">{{$exb->tienda}}</td>
                                <td style="font-size:15px; text-align:left;">{{$exb->nombre}}</td>
                                <td style="font-size:15px; text-align:center;">{{ $exb->existencias }}</td>                                
                            </tr>
                            @endforeach
                        </tbody>
                </table>
                <br>

                <div class="text-right m-t-15">
                    <a class='btn btn-primary form-button' href="{{ route('productos.index') }}">Regresar</a>
                </div>
                
            </div>
        </div>
    </div>
</form>
<div class="loader loader-bar"></div>
@stop


@push('styles')

@endpush
