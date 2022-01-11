@extends('admin.layoutadmin')

@section('header')
    <section class="content-header">
        <h1>
          Máximos y Mínimos
          <small>Crear Registro</small>
        </h1>
        <ol class="breadcrumb">
          <li><a href="{{route('dashboard')}}"><i class="fa fa-tachometer-alt"></i> Inicio</a></li>
          <li><a href="{{route('bodegamaxmin.index')}}"><i class="fa fa-list"></i> Máximos y Mínimos</a></li>
          <li class="active">Crear</li>
        </ol>
    </section>
@stop

@section('content')
    <form method="POST" id="MaximoMinimoForm"  action="{{route('bodegamaxmin.save')}}">
            {{csrf_field()}}
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-body">
                        <div class="row">
                            <div class="col-sm-6">
                                <label for="producto_id">Producto:</label>
                                <select name="producto_id" class="selectpicker form-control" data-live-search="true" id="producto_id">
                                    <option value="default">Seleccione un Producto</option>
                                    @foreach ($productos as $pr)
                                    <option value="{{$pr->id}}">{{$pr->descripcion}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-sm-6">
                                <label for="tienda_id">Tienda:</label>
                                <select name="tienda_id" class="form-control" id="tienda_id">
                                    <option value="default">Seleccione una Tienda</option>
                                    @foreach ($tiendas as $tt)
                                    <option value="{{$tt->id}}">{{$tt->tienda}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-sm-6">
                                <label for="stock_maximo">Máximo:</label>
                                <input type="text" class="form-control" placeholder="Máximo" name="stock_maximo" id="stock_maximo" >
                            </div>
                            <div class="col-sm-6">
                                <label for="stock_minimo">Mínimo:</label>
                                <input type="text" class="form-control" placeholder="Minimo" name="stock_minimo" id="stock_minimo" >
                            </div>
                        </div>
                        <br>
                        <div class="text-right m-t-15">
                            <a class='btn btn-primary form-button' href="{{ route('bodegamaxmin.index') }}">Regresar</a>
                            <button id="ButtonMaximoMinimo" class="btn btn-success form-button">Guardar</button>
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

<script src="{{asset('js/bodegamaxmin/create.js')}}"></script>
@endpush