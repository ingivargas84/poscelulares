@extends('admin.layoutadmin')

@section('header')
    <section class="content-header">
        <h1>
          Bancos
          <small>Editar Bancos</small>
        </h1>
        <ol class="breadcrumb">
          <li><a href="{{route('dashboard')}}"><i class="fa fa-tachometer-alt"></i> Inicio</a></li>
          <li><a href="{{route('bancos.index')}}"><i class="fa fa-list"></i> Bancos</a></li>
          <li class="active">Actualizar</li>
        </ol>
    </section>
@stop

@section('content')
    <form method="POST" id="BancosEditForm"  action="{{route('bancos.update', $banco)}}">
            {{csrf_field()}}
            {{ method_field('PUT') }}
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-body">
                        <div class="row">
                            <div class="col-sm-4">
                                <label for="banco">Banco:</label>
                                <input type="text" class="form-control" placeholder="Rubro de Gasto" id="banco" name="banco" value="{{old('banco', $banco->banco)}}">
                            </div>
                        </div>
                        <br>
                        <div class="text-right m-t-15">
                            <a class='btn btn-primary form-button' href="{{ route('bancos.index') }}">Regresar</a>
                            <button class="btn btn-success form-button" id="ButtonBancoUpdate">Actualizar</button>
                        </div>

                    </div>
                </div>
            </div>
    </form>
    <div class="loader loader-bar"></div>

@stop


@push('styles')

@endpush

