@extends('admin.layoutadmin')

@section('header')
    <section class="content-header">
        <h1>
          Saldos Bancos
        </h1>
        <ol class="breadcrumb">
          <li><a href="{{route('dashboard')}}"><i class="fa fa-tachometer-alt"></i> Inicio</a></li>
          <li><a href="{{route('saldos_bancos.index')}}"><i class="fa fa-list"></i> Saldos Bancos</a></li>
          <li class="active">Crear</li>
        </ol>
    </section>
@stop

@section('content')
    <form method="POST" id="SaldoBancosForm"  action="{{route('saldos_bancos.save')}}">
            {{csrf_field()}}
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-body">
                        <div class="row">
                            <div class="col-sm-4">
                                <label for="tienda_id">Tienda:</label>
                                <select name="tienda_id" id="tienda_id" class="form-control">
                                <option value="default">Seleccione una Tienda</option>
                                    @foreach ($tiendas as $td1)
                                        <option value="{{$td1->id}}">{{$td1->tienda}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-sm-4">
                                <label for="banco_id">Banco:</label>
                                <select name="banco_id" id="banco_id" class="form-control">
                                <option value="default">Seleccione un Banco</option>
                                    @foreach ($bancos as $bc)
                                        <option value="{{$bc->id}}">{{$bc->banco}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-sm-4">
                                <label for="saldo_inicial">Saldo Inicial:</label>
                                <input type="text" class="form-control" placeholder="Saldo Inicial" name="saldo_inicial" id="saldo_inicial" >
                            </div>
                        </div>
                        <br>
                        <div class="text-right m-t-15">
                            <a class='btn btn-primary form-button' href="{{ route('saldos_bancos.index') }}">Regresar</a>
                            <button id="ButtonSaldoBancos" class="btn btn-success form-button">Guardar</button>
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

<script src="{{asset('js/saldos_bancos/create.js')}}"></script>
@endpush
