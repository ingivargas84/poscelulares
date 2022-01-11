@extends('admin.layoutadmin')

@section('header')
    <section class="content-header">
        <h1>
          Gastos
          <small>Crear Gasto</small>
        </h1>
        <ol class="breadcrumb">
          <li><a href="{{route('dashboard')}}"><i class="fa fa-tachometer-alt"></i> Inicio</a></li>
          <li><a href="{{route('gastos.index')}}"><i class="fa fa-list"></i> Gastos</a></li>
          <li class="active">Crear</li>
        </ol>
    </section>
@stop

@section('content')
    <form method="POST" id="GastosForm"  action="{{route('gastos.save')}}">
            {{csrf_field()}}
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-body">
                        <div class="row">
                            <div class="col-sm-4">
                                <label for="rubro_gasto_id">Rubro Gasto:</label>
                                <select name="rubro_gasto_id" id="rubro_gasto_id" class="form-control">
                                <option value="default">Seleccione un Rubro de Gasto</option>
                                    @foreach ($rubro_gasto as $rg)
                                        <option value="{{$rg->id}}">{{$rg->rubro_gasto}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-sm-4">
                                <label for="monto">Monto:</label>
                                <input type="text" class="form-control" placeholder="Monto" name="monto" id="monto" >
                            </div>
                            <div class="col-sm-4">
                                <label for="documento">Documento:</label>
                                <input type="text" class="form-control" placeholder="Documento y número" name="documento" id="documento" >
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-sm-12">
                                <label for="descripcion">Descripcion:</label>
                                <input type="text" class="form-control" placeholder="Descripcion" name="descripcion" id="descripcion" >
                            </div>
                        </div>
                        <br>
                        <div class="text-right m-t-15">
                            <a class='btn btn-primary form-button' href="{{ route('gastos.index') }}">Regresar</a>
                            <button id="ButtonGastos" class="btn btn-success form-button">Guardar</button>
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

<script src="{{asset('js/gastos/create.js')}}"></script>
@endpush
