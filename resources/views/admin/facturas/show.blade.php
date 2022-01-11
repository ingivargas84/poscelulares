@extends('admin.layoutadmin')

@section('header')
<section class="content-header">
    <h1>
        Ventas por Factura
        <small>Detalle del Factura No. {{$factura[0]->serie_factura}}-{{$factura[0]->no_factura}}</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{route('dashboard')}}"><i class="fa fa-tachometer-alt"></i> Inicio</a></li>
        <li><a href="{{route('facturas.index')}}"><i class="fa fa-list"></i> Ventas por Factura</a></li>
        <li class="active">Detalle</li>
    </ol>
</section>
@stop

@section('content')
<form id="FacturasShowForm">
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
                        <h4><strong>NIT:</strong> {{$factura[0]->nit}} </h4>
                    </div>
                    <div class="col-md-4 col-sm-4">
                        <h4><strong>Nombre Cliente:</strong> {{$factura[0]->nombre_factura}} </h4>
                    </div>
                    <div class="col-md-4 col-sm-4">
                        <h4><strong>Dirección:</strong> {{$factura[0]->direccion}}</h4>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-md-4 col-sm-4">
                        <h4><strong>Fecha Factura:</strong> {{Carbon\Carbon::parse($factura[0]->fecha_factura)->format('d-m-Y')}} </h4>
                    </div>
                    <div class="col-md-4 col-sm-4">
                        <h4><strong>Serie Factura:</strong> {{$factura[0]->serie_factura}} </h4>
                    </div>
                    <div class="col-md-4 col-sm-4">
                        <h4><strong>Número Factura:</strong> {{$factura[0]->mo_factura}} </h4>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-md-4 col-sm-4">
                        <h4><strong>Subtotal:</strong> Q. {{$factura[0]->subtotal}} </h4>
                    </div> 
                    <div class="col-md-4 col-sm-4">
                        <h4><strong>Impuestos:</strong> Q. {{$factura[0]->impuestos}} </h4>
                    </div>
                    <div class="col-md-4 col-sm-4">
                        <h4><strong>Total:</strong> Q. {{$factura[0]->total}} </h4>
                    </div>
                </div>
                <br>

                @if ($factura[0]->estado == 1)
                <div class="row">
                    <div class="col-md-4 col-sm-4">
                        <h4 style="color:green"><strong>Estado: {{$factura[0]->estado_fac}} </strong> </h4>
                    </div> 
                    <div class="col-md-4 col-sm-4">
                    </div>
                    <div class="col-md-4 col-sm-4">
                    </div>
                </div>
                @elseif ($factura[0]->estado == 4)
                <div class="row">
                    <div class="col-md-4 col-sm-4">
                        <h4 style="color:red"><strong>Estado: Anulado </strong> </h4>
                    </div> 
                    <div class="col-md-4 col-sm-4">
                        <h4><strong>Fecha Anulación:</strong> {{$factura[0]->fecha_anulacion}} </h4>
                    </div>
                    <div class="col-md-4 col-sm-4">
                        <h4><strong>Usuario que Anuló:</strong> {{$factura[0]->us_anula}} </h4>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-md-12 col-sm-12">
                        <h4><strong>Razón:</strong> {{$factura[0]->razon_anulacion}} </h4>
                    </div> 
                </div>
                @endif
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
                            @foreach ($facturadetalle as $fd)
                            <tr>
                                <td style="font-size:14px; text-align:left;">{{$fd->descripcion}}</td>
                                <td style="font-size:14px; text-align:left;">{{$fd->imei}}</td>
                                <td style="font-size:14px; text-align:center;">{{ $fd->cantidad }}</td>
                                <td style="font-size:14px; text-align:right;">Q. {{{number_format((float) $fd->precio_unitario, 2) }}}</td>
                                <td style="font-size:14px; text-align:right;">Q. {{{number_format((float) $fd->subtotal, 2) }}}</td>
                                
                            </tr>
                            @endforeach
                        </tbody>
                        </table>
                    </div>
                    <br>
                <div class="row">
                    <div class="col-md-6 col-sm-6">
                        <h4><strong>Fecha y hora creacion:</strong> {{$factura[0]->created_at}} </h4>
                    </div> 
                    <div class="col-md-6 col-sm-6">
                        <h4><strong>Usuario que creó:</strong> {{$factura[0]->us_crea}} </h4>
                    </div>
                </div>
                <br>
                    <div class="text-right m-t-15">
                    <a class='btn btn-primary form-button' href="{{ route('facturas.index') }}">Regresar</a>
                </div>
                
            </div>
        </div>
    </div>
</form>
<div class="loader loader-bar"></div>
@stop


@push('styles')

@endpush
