@extends('admin.layoutadmin')

@section('header')
    <section class="content-header">
        <h1>
          PRODUCTOS
          <small>Editar Producto</small>
        </h1>
        <ol class="breadcrumb">
          <li><a href="{{route('dashboard')}}"><i class="fa fa-tachometer-alt"></i> Inicio</a></li>
          <li><a href="{{route('productos.index')}}"><i class="fa fa-list"></i> Productos</a></li>
          <li class="active">Actualizar</li>
        </ol>
    </section>
@stop

@section('content')
    <form method="POST" id="ProductoForm"  action="{{route('productos.update', $producto)}}">
            {{csrf_field()}}
            {{ method_field('PUT') }}
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-body">
                        <div class="row">
                            <div class="col-sm-4 {{$errors->has('codigo')? 'has-error' : ''}}">
                                <label for="codigo">Codigo:</label>
                                <input type="text" class="form-control" placeholder="Codigo" name="codigo" value="{{old('codigo', $producto->codigo)}}">
                            </div>
                            <div class="col-sm-4">
                                <label for="marca_id">Marca:</label>
                                <select name="marca_id" class="form-control">
                                    @foreach ($marcas as $mar)
                                        @if ($mar->id == $producto->marca_id)
                                            <option value="{{$mar->id}}" selected >{{$mar->marca}}</option>
                                        @else
                                            <option value="{{$mar->id}}">{{$mar->marca}}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-sm-4">
                                <label for="modelo_id">Modelo:</label>
                                <select name="modelo_id" class="form-control">
                                    @foreach ($modelos as $mod)
                                        @if ($mod->id == $producto->modelo_id)
                                            <option value="{{$mod->id}}" selected >{{$mod->modelo}}</option>
                                        @else
                                            <option value="{{$mod->id}}">{{$mod->modelo}}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-sm-3">
                                <label for="precio_venta">Precio de Venta:</label>
                                <input type="text" class="form-control" name="precio_venta" value="{{old('precio_Venta', $producto->precio_venta)}}">
                            </div>
                            <div class="col-sm-3">
                                <label for="color">Color:</label>
                                <input type="text" class="form-control" name="color" value="{{old('color', $producto->color)}}">
                            </div>
                            <div class="col-sm-3">
                                <label for="compania_id">Compañía:</label>
                                <select name="compania_id" class="form-control">
                                    @foreach ($companias as $com)
                                        @if ($com->id == $producto->compania_id)
                                            <option value="{{$com->id}}" selected >{{$com->compania}}</option>
                                        @else
                                            <option value="{{$com->id}}">{{$com->compania}}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-sm-3">
                                <label for="presentacion">Grupo:</label>
                                <select name="presentacion" class="form-control">
                                    @foreach ($presentaciones as $pre)
                                        @if ($pre->id == $producto->presentacion)
                                            <option value="{{$pre->id}}" selected >{{$pre->presentacion}}</option>
                                        @else
                                            <option value="{{$pre->id}}">{{$pre->presentacion}}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-sm-12">
                                <label for="descripcion">Descripción:</label>
                                <input type="text" class="form-control" name="descripcion" value="{{old('descripcion', $producto->descripcion)}}">
                            </div> 
                        </div>
                        <br>
                        <div class="text-right m-t-15">
                            <a class='btn btn-primary form-button' href="{{ route('productos.index') }}">Regresar</a>
                            <button class="btn btn-success form-button" id="ButtonProductoUpdate">Guardar</button>
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


<script src="{{asset('js/productos/edit.js')}}"></script>

@endpush