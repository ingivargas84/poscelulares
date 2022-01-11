@extends('admin.layoutadmin')

@section('header')
    <section class="content-header">
        <h1>
          Máximos y Mínimos
          <small>Editar Máximos y Mínimos</small>
        </h1>
        <ol class="breadcrumb">
          <li><a href="{{route('dashboard')}}"><i class="fa fa-tachometer-alt"></i> Inicio</a></li>
          <li><a href="{{route('bodegamaxmin.index')}}"><i class="fa fa-list"></i> Máximos y Mínimos</a></li>
          <li class="active">Actualizar</li>
        </ol>
    </section>
@stop

@section('content')
    <form method="POST" id="MaximosMinimosEditForm"  action="{{route('bodegamaxmin.update', $bodegamaxmin)}}">
            {{csrf_field()}}
            {{ method_field('PUT') }}
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-body">
                        <div class="row">
                            <div class="col-sm-6">
                                <label for="tienda_id">Tienda:</label>
                                <select name="tienda_id" class="form-control" id="tienda_id">
                                    <option value="default">Seleccione una Tienda</option>
                                    @foreach ($tiendas as $tt)
                                        @if ($tt->id == $bodegamaxmin->tienda_id)
                                            <option value="{{$tt->id}}" selected >{{$tt->tienda}}</option>
                                        @else
                                            <option value="{{$tt->id}}">{{$tt->tienda}}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-sm-6">
                                <label for="producto_id">Producto:</label>
                                <select name="producto_id" class="form-control" id="producto_id">
                                    <option value="default">Seleccione un Producto</option>
                                    @foreach ($productos as $pr)
                                        @if ($pr->id == $bodegamaxmin->producto_id)
                                            <option value="{{$pr->id}}" selected >{{$pr->descripcion}}</option>
                                        @else
                                            <option value="{{$pr->id}}">{{$pr->descripcion}}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>

                        </div>
                        <br>
                        <div class="row">
                            <div class="col-sm-6">
                                <label for="stock_maximo">Máximo:</label>
                                <input type="text" class="form-control" placeholder="Máximo" name="stock_maximo" id="stock_maximo" value="{{old('bodegamaxmin', $bodegamaxmin->stock_maximo)}}">
                            </div>
                            <div class="col-sm-6">
                                <label for="stock_minimo">Minimo:</label>
                                <input type="text" class="form-control" placeholder="Mínimo" name="stock_minimo" id="stock_minimo" value="{{old('bodegamaxmin', $bodegamaxmin->stock_minimo)}}">
                            </div>

                        </div>
                        <br>
                        <div class="text-right m-t-15">
                            <a class='btn btn-primary form-button' href="{{ route('bodegamaxmin.index') }}">Regresar</a>
                            <button class="btn btn-success form-button" id="ButtonMaximosMinimosUpdate">Actualizar</button>
                        </div>

                    </div>
                </div>
            </div>
    </form>
    <div class="loader loader-bar"></div>

@stop


@push('styles')

@endpush

