@extends('admin.layoutadmin')

@section('header')
    <section class="content-header">
        <h1>
          Modelos
          <small>Editar Modelos</small>
        </h1>
        <ol class="breadcrumb">
          <li><a href="{{route('dashboard')}}"><i class="fa fa-tachometer-alt"></i> Inicio</a></li>
          <li><a href="{{route('modelos.index')}}"><i class="fa fa-list"></i> Modelos</a></li>
          <li class="active">Actualizar</li>
        </ol>
    </section>
@stop

@section('content')
    <form method="POST" id="ModeloEditForm"  action="{{route('modelos.update', $modelo)}}">
            {{csrf_field()}}
            {{ method_field('PUT') }}
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-body">
                        <div class="row">
                            <div class="col-sm-6">
                                <label for="modelo">Modelo:</label>
                                <input type="text" class="form-control" placeholder="Modelo" name="modelo" id="modelo" value="{{old('modelo', $modelo->modelo)}}">
                            </div>
                            <div class="col-sm-6">
                                <label for="marca_id">Marca:</label>
                                <select name="marca_id" class="form-control" id="marca_id">
                                    <option value="default">Seleccione una Marca</option>
                                    @foreach ($marcas as $mar)
                                        @if ($mar->id == $modelo->marca_id)
                                            <option value="{{$mar->id}}" selected >{{$mar->marca}}</option>
                                        @else
                                            <option value="{{$mar->id}}">{{$mar->marca}}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>

                        </div>
                        <br>
                        <div class="text-right m-t-15">
                            <a class='btn btn-primary form-button' href="{{ route('modelos.index') }}">Regresar</a>
                            <button class="btn btn-success form-button" id="ButtonModeloUpdate">Actualizar</button>
                        </div>

                    </div>
                </div>
            </div>
    </form>
    <div class="loader loader-bar"></div>

@stop


@push('styles')

@endpush

