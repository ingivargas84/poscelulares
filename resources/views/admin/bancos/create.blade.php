@extends('admin.layoutadmin')

@section('header')
    <section class="content-header">
        <h1>
          Bancos
          <small>Crear Banco</small>
        </h1>
        <ol class="breadcrumb">
          <li><a href="{{route('dashboard')}}"><i class="fa fa-tachometer-alt"></i> Inicio</a></li>
          <li><a href="{{route('bancos.index')}}"><i class="fa fa-list"></i> Bancos</a></li>
          <li class="active">Crear</li>
        </ol>
    </section>
@stop

@section('content')
    <form method="POST" id="BancosForm"  action="{{route('bancos.save')}}">
            {{csrf_field()}}
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-body">
                        <div class="row">
                            <div class="col-sm-6">
                                <label for="banco">Banco:</label>
                                <input type="text" class="form-control" placeholder="Banco:" name="banco" id="banco" >
                            </div>
                        </div>
                        <br>
                        <div class="text-right m-t-15">
                            <a class='btn btn-primary form-button' href="{{ route('bancos.index') }}">Regresar</a>
                            <button class="btn btn-success form-button" id="ButtonBancos">Crear Banco</button>
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

<script src="{{asset('js/bancos/create.js')}}"></script>
@endpush
