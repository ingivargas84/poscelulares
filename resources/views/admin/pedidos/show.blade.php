@extends('admin.layoutadmin')

@section('header')
<section class="content-header">
    <h1>
        Venta
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{route('dashboard')}}"><i class="fa fa-tachometer-alt"></i> Inicio</a></li>
        <li><a href="{{route('pedidos.index')}}"><i class="fa fa-list"></i> Ventas</a></li>
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
                        <h2><strong>Información de la Venta</strong></h2>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-md-4 col-sm-4">
                        <h4><strong>NIT:</strong> {{$pm[0]->nit}} </h4>
                    </div>
                    <div class="col-md-4 col-sm-4">
                        <h4><strong>Nombre Cliente:</strong> {{$pm[0]->nombre}} </h4>
                    </div>
                    <div class="col-md-4 col-sm-4">
                        <h4><strong>Dirección:</strong> {{$pm[0]->direccion}}</h4>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-md-4 col-sm-4">
                        <h4><strong>Fecha de la Venta:</strong> {{Carbon\Carbon::parse($pm[0]->fecha)->format('d-m-Y')}} </h4>
                    </div>
                    <div class="col-md-4 col-sm-4">
                        <h4><strong>Bodega:</strong> {{$pm[0]->bodega}} </h4>
                    </div>
                    <div class="col-md-4 col-sm-4">
                        <h4><strong>Forma de Pago:</strong> {{$pm[0]->forma_pago}} </h4>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-md-4 col-sm-4">
                        <h4><strong>No de la Venta:</strong> {{$pm[0]->no_pedido}} </h4>
                    </div> 
                    <div class="col-md-4 col-sm-4">
                        <h4><strong>Vendedor:</strong> {{$pm[0]->vendedor}} </h4>
                    </div>
                </div>
                <br>
                <br>
                <table border="1" cellspacing=0 cellpadding=2 width= 800 class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th width=40% style="font-size:15px; text-align:left;">Producto</th>
                                <th width=15% style="font-size:15px; text-align:left;">Imei</th>
                                <th width=10% style="font-size:15px; text-align:center;">Cantidad</th>
                                <th width=15% style="font-size:15px; text-align:right;">Precio Unitario</th>
                                <th width=20% style="font-size:15px; text-align:right;">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pd as $p)
                            <tr>
                                <td style="font-size:14px; text-align:left;">{{$p->producto}}</td>
                                <td style="font-size:14px; text-align:left;">{{$p->imei}}</td>
                                <td style="font-size:14px; text-align:center;">{{ $p->cantidad }}</td>
                                <td style="font-size:14px; text-align:right;">Q. {{{number_format((float) $p->precio, 2) }}}</td>
                                <td style="font-size:14px; text-align:right;">Q. {{{number_format((float) $p->subtotal, 2) }}}</td>
                                
                            </tr>
                            @endforeach
                        </tbody>
                        </table>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-md-12 col-sm-12">
                            <h4 style="text-align:right"><strong>Subtotal:</strong> Q. {{number_format((float) $pm[0]->subtotal, 2) }} </h4>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 col-sm-12">
                            <h4 style="text-align:right"><strong>Descuento Porcentaje {{$pm[0]->porcentaje}}% :</strong> Q. {{number_format((float) $pm[0]->descuento_porcentaje, 2) }} </h4>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 col-sm-12">
                            <h4 style="text-align:right"><strong>Descuento Valores:</strong> Q. {{number_format((float) $pm[0]->descuento_valores, 2) }} </h4>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 col-sm-12">
                            <h4 style="text-align:right"><strong>Total:</strong> Q. {{number_format((float) $pm[0]->total, 2) }} </h4>
                        </div>
                    </div>
                    <br>
                    <div class="text-right m-t-15">
                    <a class='btn btn-primary form-button' href="{{ route('pedidos.index') }}">Regresar</a>
                </div>
                
            </div>
        </div>
    </div>
</form>
<div class="loader loader-bar"></div>
@stop


@push('styles')

@endpush
