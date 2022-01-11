@extends('admin.layoutadmin')

@section('header')
    <section class="content-header">
        <h1>
          Rubro de Gasto
          <small>Editar Rubro de Gasto</small>
        </h1>
        <ol class="breadcrumb">
          <li><a href="{{route('dashboard')}}"><i class="fa fa-tachometer-alt"></i> Inicio</a></li>
          <li><a href="{{route('rubro_gasto.index')}}"><i class="fa fa-list"></i> Rubro de Gasto</a></li>
          <li class="active">Actualizar</li>
        </ol>
    </section>
@stop

@section('content')
    <form method="POST" id="RubroGastoEditForm"  action="{{route('rubro_gasto.update', $rubro_gasto)}}">
            {{csrf_field()}}
            {{ method_field('PUT') }}
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-body">
                        <div class="row">
                            <div class="col-sm-4">
                                <label for="rubro_gasto">Rubro Gasto:</label>
                                <input type="text" class="form-control" placeholder="Rubro de Gasto" id="rubro_gasto" name="rubro_gasto" value="{{old('rubro_gasto', $rubro_gasto->rubro_gasto)}}">
                            </div>
                        </div>
                        <br>
                        <div class="text-right m-t-15">
                            <a class='btn btn-primary form-button' href="{{ route('rubro_gasto.index') }}">Regresar</a>
                            <button class="btn btn-success form-button" id="ButtonRubroGastoUpdate">Actualizar</button>
                        </div>

                    </div>
                </div>
            </div>
    </form>
    <div class="loader loader-bar"></div>

@stop


@push('styles')

@endpush

