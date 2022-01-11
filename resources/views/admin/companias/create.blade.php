@extends('admin.layoutadmin')

@section('header')
    <section class="content-header">
        <h1>
          Compañias
          <small>Crear Compañia</small>
        </h1>
        <ol class="breadcrumb">
          <li><a href="{{route('dashboard')}}"><i class="fa fa-tachometer-alt"></i> Inicio</a></li>
          <li><a href="{{route('companias.index')}}"><i class="fa fa-list"></i> Compañias</a></li>
          <li class="active">Crear</li>
        </ol>
    </section>
@stop

@section('content')
    <form method="POST" id="CompaniaForm"  action="{{route('companias.save')}}">
            {{csrf_field()}}
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-body">
                        <div class="row">
                            <div class="col-sm-6">
                                <label for="compania">Compañia:</label>
                                <input type="text" class="form-control" placeholder="Compañia" name="compania" id="compania" >
                            </div>
                        </div>
                        <br>
                        <div class="text-right m-t-15">
                            <a class='btn btn-primary form-button' href="{{ route('companias.index') }}">Regresar</a>
                            <button id="ButtonCompania" class="btn btn-success form-button">Guardar</button>
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

<script src="{{asset('js/companias/create.js')}}"></script>
@endpush

