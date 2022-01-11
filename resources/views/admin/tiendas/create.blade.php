@extends('admin.layoutadmin')

@section('header')
    <section class="content-header">
        <h1>
          Tiendas
          <small>Crear Tienda</small>
        </h1>
        <ol class="breadcrumb">
          <li><a href="{{route('dashboard')}}"><i class="fa fa-tachometer-alt"></i> Inicio</a></li>
          <li><a href="{{route('tiendas.index')}}"><i class="fa fa-list"></i> Tiendas</a></li>
          <li class="active">Crear</li>
        </ol>
    </section>
@stop

@section('content')
    <form method="POST" id="TiendaForm"  action="{{route('tiendas.save')}}">
            {{csrf_field()}}
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-body">
                        <div class="row">
                            <div class="col-sm-4">
                                <label for="tienda">Nombre Tienda:</label>
                                <input type="text" class="form-control" placeholder="Nombre de la Tienda" name="tienda" >
                            </div>
                            <div class="col-sm-8">
                                <label for="descripcion">Descripción:</label>
                                <input type="text" class="form-control" placeholder="Descripción:" name="descripcion" >
                            </div>
                        </div>
                        <br>
                        <div class="text-right m-t-15">
                            <a class='btn btn-primary form-button' href="{{ route('tiendas.index') }}">Regresar</a>
                            <button id="ButtonTienda" class="btn btn-success form-button">Guardar</button>
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

<script src="{{asset('js/tiendas/create.js')}}"></script>
@endpush
