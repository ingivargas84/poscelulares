@extends('admin.layoutadmin')

@section('header')
    <section class="content-header">
        <h1>
          Productos IMEI
          <small>Editar IMEI</small>
        </h1>
        <ol class="breadcrumb">
          <li><a href="{{route('dashboard')}}"><i class="fa fa-tachometer-alt"></i> Inicio</a></li>
          <li><a href="{{route('compras.indeximei')}}"><i class="fa fa-list"></i> Productos Imei</a></li>
          <li class="active">Actualizar</li>
        </ol>
    </section>
@stop

@section('content')
    <form method="POST" id="ImeiEditForm"  action="{{route('compras.updateimei', $producto_imei)}}">
            {{csrf_field()}}
            {{ method_field('PUT') }}
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-body">
                        <div class="row">
                            <div class="col-sm-2">
                                <label for="imei_id">IMEI Código:</label>
                                <input type="text" class="form-control"  name="imei_id" id="imei_id" value="{{old('id', $producto_imei->id)}}">
                            </div>
                            <div class="col-sm-6">
                                <label for="producto_id">Producto:</label>
                                <select name="producto_id" class="selectpicker form-control" data-live-search="true" id="producto_id">
                                    <option value="default">Seleccione un Producto</option>
                                    @foreach ($productos as $pro)
                                        @if ($pro->id == $producto_imei->producto_id)
                                            <option value="{{$pro->id}}" selected >{{$pro->descripcion}}</option>
                                        @else
                                            <option value="{{$pro->id}}">{{$pro->descripcion}}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-sm-4">
                                <label for="imei">IMEI:</label>
                                <input type="text" class="form-control" placeholder="IMEI" name="imei" id="imei" value="{{old('imei', $producto_imei->imei)}}">
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-sm-6">
                                <label for="bodega_id">Bodega:</label>
                                <select name="bodega_id" class="form-control" id="bodega_id">
                                    <option value="default">Seleccione una Bodega</option>
                                    @foreach ($bodegas as $bb)
                                        @if ($bb->id == $producto_imei->bodega_id)
                                            <option value="{{$bb->id}}" selected >{{$bb->nombre}}</option>
                                        @else
                                            <option value="{{$bb->id}}">{{$bb->nombre}}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-sm-6">
                                <label for="estado_venta_id">Estado Imei:</label>
                                <select name="estado_venta_id" class="form-control" id="estado_venta_id">
                                    <option value="default">Seleccione un Estado</option>
                                    @foreach ($estado_venta as $ev)
                                        @if ($ev->id == $producto_imei->estado_venta_id)
                                            <option value="{{$ev->id}}" selected >{{$ev->estado_venta}}</option>
                                        @else
                                            <option value="{{$ev->id}}">{{$ev->estado_venta}}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <br>
                        <br>
                        <div class="text-right m-t-15">
                            <a class='btn btn-primary form-button' href="{{ route('compras.indeximei') }}">Regresar</a>
                            <button class="btn btn-success form-button" id="ButtonUpdateImei">Actualizar</button>
                        </div>

                    </div>
                </div>
            </div>
    </form>
    <div class="loader loader-bar"></div>

@stop


@push('styles')

@endpush

