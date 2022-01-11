@extends('admin.layoutadmin')

@section('header')
<section class="content-header">
    <h1>
        Traspasos entre Bodegas
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{route('dashboard')}}"><i class="fa fa-tachometer-alt"></i> Inicio</a></li>
        <li><a href="{{route('traspasos_bodega.index')}}"><i class="fa fa-list"></i> Traspasos Bodega</a></li>
        <li class="active">Ver</li>
    </ol>
</section>
@stop

@section('content')
<form id="VentasShowForm">
    {{csrf_field()}}
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-body">
                <div class="row">
                    <div class="col-md-12 col-sm-12 text-center">
                        <h2><strong>Información del Traspaso</strong></h2>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-md-6 col-sm-6">
                        <h4><strong>Bodega Origen:</strong> {{$tm[0]->bodega_origen}} </h4>
                    </div>
                    <div class="col-md-6 col-sm-6">
                        <h4><strong>Bodega Destino:</strong> {{$tm[0]->bodega_destino}} </h4>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-md-6 col-sm-6">
                        <h4><strong>Fecha del Traslado:</strong> {{Carbon\Carbon::parse($tm[0]->created_at)->format('d-m-Y')}} </h4>
                    </div>
                    <div class="col-md-6 col-sm-6">
                        <h4><strong>Usuario que realizó el Traspaso:</strong> {{$tm[0]->user}} </h4>
                    </div>
                </div>
                <br>
                <table border="1" cellspacing=0 cellpadding=2 width= 800 class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th width=40% style="font-size:15px; text-align:left;">Producto</th>
                                <th width=30% style="font-size:15px; text-align:center;">Imei</th>
                                <th width=30% style="font-size:15px; text-align:center;">Cantidad</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($td as $t)
                            <tr>
                                <td style="font-size:14px; text-align:left;">{{$t->producto}}</td>
                                <td style="font-size:14px; text-align:center;">{{$t->imei}}</td>
                                <td style="font-size:14px; text-align:center;">{{ $t->cantidad }}</td>
                                
                            </tr>
                            @endforeach
                        </tbody>
                        </table>
                       
                    </div>
                    <br>
                    <div class="text-right m-t-15">
                    <a class='btn btn-primary form-button' href="{{ route('traspasos_bodega.index') }}">Regresar</a>
                </div>
                
            </div>
        </div>
    </div>
</form>
<div class="loader loader-bar"></div>
@stop


@push('styles')

@endpush
