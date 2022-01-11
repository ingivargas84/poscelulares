@extends('admin.layoutadmin')

@section('header')
    <section class="content-header">
        <h1>
          Traslado Bancos
        </h1>
        <ol class="breadcrumb">
          <li><a href="{{route('dashboard')}}"><i class="fa fa-tachometer-alt"></i> Inicio</a></li>
          <li><a href="{{route('traslados_bancos.index')}}"><i class="fa fa-list"></i> Traslados Bancos</a></li>
          <li class="active">Crear</li>
        </ol>
    </section>
@stop

@section('content')
    <form method="POST" id="TrasladoBancosForm"  action="{{route('traslados_bancos.save')}}">
            {{csrf_field()}}
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-body">
                        <div class="row">
                            <div class="col-sm-3">
                                <label for="tienda_origen_id">Tienda Origen:</label>
                                <select name="tienda_origen_id" id="tienda_origen_id" class="form-control">
                                <option value="default">Seleccione una Tienda Origen</option>
                                    @foreach ($tiendas as $td1)
                                        <option value="{{$td1->id}}">{{$td1->tienda}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-sm-3">
                                <label for="tienda_destino_id">Tienda Destino:</label>
                                <select name="tienda_destino_id" id="tienda_destino_id" class="form-control">
                                <option value="default">Seleccione una Tienda Destino</option>
                                    @foreach ($tiendas as $td2)
                                        <option value="{{$td2->id}}">{{$td2->tienda}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-sm-3">
                                <label for="banco_id">Banco:</label>
                                <select name="banco_id" id="banco_id" class="form-control">
                                <option value="default">Seleccione un Banco</option>
                                    @foreach ($bancos as $bc)
                                        <option value="{{$bc->id}}">{{$bc->banco}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-sm-3">
                                <label for="monto">Monto:</label>
                                <input type="text" class="form-control" placeholder="Monto" name="monto" id="monto" >
                            </div>
                        </div>
                        <br>
                        <div class="text-right m-t-15">
                            <a class='btn btn-primary form-button' href="{{ route('traslados_bancos.index') }}">Regresar</a>
                            <button id="ButtonTrasladoBancos" class="btn btn-success form-button">Guardar</button>
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

<script src="{{asset('js/traslados_bancos/create.js')}}"></script>
@endpush
