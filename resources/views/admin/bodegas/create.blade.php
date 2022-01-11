@extends('admin.layoutadmin')

@section('header')
    <section class="content-header">
        <h1>
          Bodegas
          <small>Crear Bodegas</small>
        </h1>
        <ol class="breadcrumb">
          <li><a href="{{route('dashboard')}}"><i class="fa fa-tachometer-alt"></i> Inicio</a></li>
          <li><a href="{{route('bodegas.index')}}"><i class="fa fa-list"></i> Bodegas</a></li>
          <li class="active">Crear</li>
        </ol>
    </section>
@stop

@section('content')
    <form method="POST" id="BodegaForm"  action="{{route('bodegas.save')}}">
            {{csrf_field()}}
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-body">
                        <div class="row">
                            <div class="col-sm-4">
                                <label for="nombre">Nombre Bodega:</label>
                                <input type="text" class="form-control" placeholder="Nombre Bodega" name="nombre" id="nombre" >
                            </div>
                            <div class="col-sm-4">
                                <label for="tipo">Tipo de Bodega:</label>
                                <select name="tipo" class="form-control" id="tipo">
                                    <option value="default">Seleccione una Tipo</option>
                                    @foreach ($tipos as $tt)
                                    <option value="{{$tt->id}}">{{$tt->tipo}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-sm-4">
                                <label for="tienda_id">Asignación de Tienda:</label>
                                <select name="tienda_id" class="form-control" id="tienda_id">
                                    <option value="default">Seleccione una Tienda</option>
                                    @foreach ($tiendas as $ti)
                                    <option value="{{$ti->id}}">{{$ti->tienda}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-sm-8">
                                <label for="descripcion">Descripción:</label>
                                <input type="text" class="form-control" placeholder="Descripcion" name="descripcion" id="descripcion" >
                            </div>
                        </div>
                        <br>
                        <div class="text-right m-t-15">
                            <a class='btn btn-primary form-button' href="{{ route('bodegas.index') }}">Regresar</a>
                            <button id="ButtonBodega" class="btn btn-success form-button">Guardar</button>
                        </div>

                    </div>
                </div>
            </div>
    </form>
    <div class="loader loader-bar"></div>

@stop


@push('styles')

@endpush

