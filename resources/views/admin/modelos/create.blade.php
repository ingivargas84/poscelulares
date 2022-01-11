@extends('admin.layoutadmin')

@section('header')
    <section class="content-header">
        <h1>
          Modelos
          <small>Crear Modelo</small>
        </h1>
        <ol class="breadcrumb">
          <li><a href="{{route('dashboard')}}"><i class="fa fa-tachometer-alt"></i> Inicio</a></li>
          <li><a href="{{route('modelos.index')}}"><i class="fa fa-list"></i> Modelos</a></li>
          <li class="active">Crear</li>
        </ol>
    </section>
@stop

@section('content')
    <form method="POST" id="ModeloForm"  action="{{route('modelos.save')}}">
            {{csrf_field()}}
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-body">
                        <div class="row">
                            <div class="col-sm-6">
                                <label for="modelo">Modelo:</label>
                                <input type="text" class="form-control" placeholder="Modelo" name="modelo" id="modelo" >
                            </div>
                            <div class="col-sm-6">
                                <label for="marca_id">Marca:</label>
                                <select name="marca_id" class="form-control" id="marca_id">
                                    <option value="default">Seleccione una Marca</option>
                                    @foreach ($marcas as $mar)
                                    <option value="{{$mar->id}}">{{$mar->marca}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <br>
                        <div class="text-right m-t-15">
                            <a class='btn btn-primary form-button' href="{{ route('modelos.index') }}">Regresar</a>
                            <button id="ButtonModelo" class="btn btn-success form-button">Guardar</button>
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

<script src="{{asset('js/modelos/create.js')}}"></script>
@endpush