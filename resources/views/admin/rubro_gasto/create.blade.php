@extends('admin.layoutadmin')

@section('header')
    <section class="content-header">
        <h1>
          Rubros de Gasto
          <small>Crear Rubro de Gasto</small>
        </h1>
        <ol class="breadcrumb">
          <li><a href="{{route('dashboard')}}"><i class="fa fa-tachometer-alt"></i> Inicio</a></li>
          <li><a href="{{route('rubro_gasto.index')}}"><i class="fa fa-list"></i> Rubros de Gasto</a></li>
          <li class="active">Crear</li>
        </ol>
    </section>
@stop

@section('content')
    <form method="POST" id="RubroGastoForm"  action="{{route('rubro_gasto.save')}}">
            {{csrf_field()}}
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-body">
                        <div class="row">
                            <div class="col-sm-6">
                                <label for="rubro_gasto">Rubro de Gasto:</label>
                                <input type="text" class="form-control" placeholder="Rubro de Gasto:" name="rubro_gasto" id="rubro_gasto" >
                            </div>
                        </div>
                        <br>
                        <div class="text-right m-t-15">
                            <a class='btn btn-primary form-button' href="{{ route('rubro_gasto.index') }}">Regresar</a>
                            <button class="btn btn-success form-button" id="ButtonRubroGasto">Crear Rubro de Gasto</button>
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

<script src="{{asset('js/rubro_gasto/create.js')}}"></script>
@endpush
