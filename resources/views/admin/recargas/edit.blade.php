@extends('admin.layoutadmin')

@section('header')
    <section class="content-header">
        <h1>
          Editar Saldo de Recargas
        </h1>
        <ol class="breadcrumb">
          <li><a href="{{route('dashboard')}}"><i class="fa fa-tachometer-alt"></i> Inicio</a></li>
          <li><a href="{{route('recargas.index')}}"><i class="fa fa-list"></i> Recargas</a></li>
          <li class="active">Actualizar</li>
        </ol>
    </section>
@stop

@section('content')
    <form method="POST" id="EditRecargasForm"  action="{{route('recargas.update', $saldorecargas)}}">
            {{csrf_field()}}
            {{ method_field('PUT') }}
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-body">
                        <div class="row">
                            <div class="col-sm-4">
                                <label for="tienda_id">Tiendas:</label>
                                <select name="tienda_id" id="tienda_id" class="form-control">
                                <option value="default">Seleccione una Tienda</option>
                                    @foreach ($tiendas as $td)
                                        @if ($td->id == $saldorecargas->tienda_id)
                                            <option value="{{$td->id}}" selected >{{$td->tienda}}</option>
                                        @else
                                            <option value="{{$td->id}}">{{$td->tienda}}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-sm-4">
                                <label for="compania_id">Compañia:</label>
                                <select name="compania_id" id="compania_id" class="form-control">
                                <option value="default">Seleccione una Compañía</option>
                                    @foreach ($companias as $cm)
                                        @if ($cm->id == $saldorecargas->compania_id)
                                            <option value="{{$cm->id}}" selected >{{$cm->compania}}</option>
                                        @else
                                            <option value="{{$cm->id}}">{{$cm->compania}}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-sm-4">
                                <label for="saldo">Saldo:</label>
                                <input type="text" class="form-control" placeholder="Saldo" name="saldo" id="saldo" value="{{old('saldo', $saldorecargas->saldo)}}">
                            </div>
                        </div>
                        <br>
                        
                        <div class="text-right m-t-15">
                            <a class='btn btn-primary form-button' href="{{ route('recargas.index') }}">Regresar</a>
                            <button class="btn btn-success form-button" id="ButtonRecargasUpdate">Actualizar</button>
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

@endpush