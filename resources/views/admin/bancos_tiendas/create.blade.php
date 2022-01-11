@extends('admin.layoutadmin')

@section('header')
    <section class="content-header">
        <h1>
          Asignación de Tienda y Bancos
          <small>Crear Asignación</small>
        </h1>
        <ol class="breadcrumb">
          <li><a href="{{route('dashboard')}}"><i class="fa fa-tachometer-alt"></i> Inicio</a></li>
          <li><a href="{{route('bancostiendas.index')}}"><i class="fa fa-list"></i> Bancos Tiendas</a></li>
          <li class="active">Crear</li>
        </ol>
    </section>
@stop

@section('content')
    <form method="POST" id="BancosTiendasForm"  action="{{route('bancostiendas.save')}}">
            {{csrf_field()}}
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-body">
                        <div class="row">
                            <div class="col-sm-6">
                                <label for="tienda_id">Tienda:</label>
                                <select name="tienda_id" class="form-control" id="tienda_id">
                                    <option value="default">Seleccione una Tienda</option>
                                    @foreach ($tiendas as $td)
                                    <option value="{{$td->id}}">{{$td->tienda}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-sm-6">
                                <label for="banco_id">Bancos:</label>
                                <select name="banco_id" class="form-control" id="banco_id">
                                    <option value="default">Seleccione un Banco</option>
                                    @foreach ($bancos as $bc)
                                    <option value="{{$bc->id}}">{{$bc->banco}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <br>
                        <div class="text-right m-t-15">
                            <a class='btn btn-primary form-button' href="{{ route('bancostiendas.index') }}">Regresar</a>
                            <button id="ButtonBancosTiendas" class="btn btn-success form-button">Guardar</button>
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

<script>

</script>

<script src="{{asset('js/bancos_tiendas/create.js')}}"></script>
@endpush