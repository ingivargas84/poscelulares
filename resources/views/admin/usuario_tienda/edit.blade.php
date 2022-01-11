@extends('admin.layoutadmin')

@section('header')
    <section class="content-header">
        <h1>
          Asignación de Usuario a Tienda
          <small>Editar Asignación</small>
        </h1>
        <ol class="breadcrumb">
          <li><a href="{{route('dashboard')}}"><i class="fa fa-tachometer-alt"></i> Inicio</a></li>
          <li><a href="{{route('usuario_tienda.index')}}"><i class="fa fa-list"></i> Asignación</a></li>
          <li class="active">Actualizar</li>
        </ol>
    </section>
@stop

@section('content')
    <form method="POST" id="Usuario_TiendaEditForm"  action="{{route('usuario_tienda.update', $usuario_tienda)}}">
            {{csrf_field()}}
            {{ method_field('PUT') }}
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-body">
                        <div class="row">
                            <div class="col-sm-6">
                                <label for="user_id">Usuario:</label>
                                <select name="user_id" class="form-control" id="user_id">
                                    <option value="default">Seleccione un Usuario</option>
                                    @foreach ($usuarios as $us)
                                        @if ($us->id == $usuario_tienda->user_id)
                                            <option value="{{$us->id}}" selected >{{$us->name}}</option>
                                        @else
                                            <option value="{{$us->id}}">{{$us->name}}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-sm-6">
                                <label for="tienda_id">Tienda:</label>
                                <select name="tienda_id" class="form-control" id="tienda_id">
                                    <option value="default">Seleccione una Tienda</option>
                                    @foreach ($tiendas as $tt)
                                        @if ($tt->id == $usuario_tienda->tienda_id)
                                            <option value="{{$tt->id}}" selected >{{$tt->tienda}}</option>
                                        @else
                                            <option value="{{$tt->id}}">{{$tt->tienda}}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>

                        </div>
                        <br>
                        <div class="text-right m-t-15">
                            <a class='btn btn-primary form-button' href="{{ route('usuario_tienda.index') }}">Regresar</a>
                            <button class="btn btn-success form-button" id="ButtonUsuario_TiendaUpdate">Actualizar</button>
                        </div>

                    </div>
                </div>
            </div>
    </form>
    <div class="loader loader-bar"></div>

@stop


@push('styles')

@endpush

