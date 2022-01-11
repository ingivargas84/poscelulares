@extends('admin.layoutadmin')

@section('header')
    <section class="content-header">
        <h1>
          Marcas
          <small>Crear Marca</small>
        </h1>
        <ol class="breadcrumb">
          <li><a href="{{route('dashboard')}}"><i class="fa fa-tachometer-alt"></i> Inicio</a></li>
          <li><a href="{{route('marcas.index')}}"><i class="fa fa-list"></i> Marcas</a></li>
          <li class="active">Crear</li>
        </ol>
    </section>
@stop

@section('content')
    <form method="POST" id="MarcaForm"  action="{{route('marcas.save')}}">
            {{csrf_field()}}
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-body">
                        <div class="row">
                            <div class="col-sm-6">
                                <label for="marca">Marca:</label>
                                <input type="text" class="form-control" placeholder="Marca" name="marca" id="marca" >
                            </div>
                        </div>
                        <br>
                        <div class="text-right m-t-15">
                            <a class='btn btn-primary form-button' href="{{ route('marcas.index') }}">Regresar</a>
                            <button id="ButtonMarca" class="btn btn-success form-button">Guardar</button>
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
<script src="{{asset('js/marcas/create.js')}}"></script>
@endpush

