@extends('admin.layoutadmin')

@section('header')
    <section class="content-header">
        <h1>
          Asignación de Banco a Tienda
        </h1>
        <ol class="breadcrumb">
          <li><a href="{{route('dashboard')}}"><i class="fa fa-tachometer-alt"></i> Inicio</a></li>
          <li><a href="{{route('bancostiendas.index')}}"><i class="fa fa-list"></i> Bancos Tiendas</a></li>
          <li class="active">Actualizar</li>
        </ol>
    </section>
@stop

@section('content')
    <form method="POST" id="BancosTiendasEditForm"  action="{{route('bancostiendas.update', $bancos_tiendas)}}">
            {{csrf_field()}}
            {{ method_field('PUT') }}
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-body">
                        <div class="row">
                            <div class="col-sm-6">
                                <label for="tienda_id">Tienda:</label>
                                <select name="tienda_id" id="tienda_id" class="form-control">
                                <option value="default">Seleccione una Tienda</option>
                                    @foreach ($tiendas as $td)
                                        @if ($td->id == $bancos_tiendas->tienda_id)
                                            <option value="{{$td->id}}" selected >{{$td->tienda}}</option>
                                        @else
                                            <option value="{{$td->id}}">{{$td->tienda}}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-sm-6">
                                <label for="banco_id">Banco:</label>
                                <select name="banco_id" id="banco_id" class="form-control">
                                <option value="default">Seleccione un Banco</option>
                                    @foreach ($bancos as $bc)
                                        @if ($bc->id == $bancos_tiendas->banco_id)
                                            <option value="{{$bc->id}}" selected >{{$bc->banco}}</option>
                                        @else
                                            <option value="{{$bc->id}}">{{$bc->banco}}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <br>
                        <div class="text-right m-t-15">
                            <a class='btn btn-primary form-button' href="{{ route('bancostiendas.index') }}">Regresar</a>
                            <button class="btn btn-success form-button" id="ButtonBancoTieddaUpdate">Actualizar</button>
                        </div>

                    </div>
                </div>
            </div>
    </form>
    <div class="loader loader-bar"></div>

@stop


@push('styles')

@endpush

