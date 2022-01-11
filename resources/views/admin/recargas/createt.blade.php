@extends('admin.layoutadmin')

@section('header')
    <section class="content-header">
        <h1>
          Trasladar Saldo
          <small>Trasladar Saldo</small>
        </h1>
        <ol class="breadcrumb">
          <li><a href="{{route('dashboard')}}"><i class="fa fa-tachometer-alt"></i> Inicio</a></li>
          <li><a href="{{route('recargas.index')}}"><i class="fa fa-list"></i> Recargas</a></li>
          <li class="active">Crear</li>
        </ol>
    </section>
@stop

@section('content')
    <form method="POST" id="RecargastForm"  action="{{route('recargas.savet')}}">
            {{csrf_field()}}
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-body">
                        <div class="row">
                            <div class="col-sm-4">
                                <label for="tienda_envia">Tienda Envia:</label>
                                <select name="tienda_envia" class="form-control" id="tienda_envia">
                                    
                                    @foreach ($tiendas as $tt)
                                    <option value="{{$tt->id}}">{{$tt->tienda}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-sm-4">
                                <label for="compania_id">Compañía:</label>
                                <select name="compania_id" class="form-control" id="compania_id">
                                    <option value="default">Seleccione una Compañía</option>
                                    @foreach ($companias as $comp)
                                    <option value="{{$comp->id}}">{{$comp->compania}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-sm-4">
                                <label for="tienda_recibe">Tienda Recibe:</label>
                                <select name="tienda_recibe" class="form-control" id="tienda_recibe">
                                    <option value="default">Seleccione una Tienda</option>
                                    @foreach ($tiendast as $ttt)
                                    <option value="{{$ttt->id}}">{{$ttt->tienda}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-sm-4">
                                <label for="total">Saldo a Trasladar:</label>
                                <input type="text" class="form-control" placeholder="Saldo a Trasladar:" name="total" id="total" >
                            </div>
                            <div class="col-sm-4">
                            </div>
                            <div class="col-sm-4">
                            </div>
                        </div>
                        <br>
                        <div class="text-right m-t-15">
                            <a class='btn btn-primary form-button' href="{{ route('recargas.index') }}">Regresar</a>
                            <button class="btn btn-success form-button" id="ButtonRecargat">Trasladar Saldo</button>
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

<script src="{{asset('js/recargas/create.js')}}"></script>
@endpush
