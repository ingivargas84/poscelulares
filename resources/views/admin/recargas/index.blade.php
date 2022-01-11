@extends('admin.layoutadmin')

@section('header')
<section class="content-header">
    <h1>
      Listado de Saldos de Recargas
      <small>Todas las recargas</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="{{route('dashboard')}}"><i class="fa fa-home"></i> Inicio</a></li>
      <li class="active">Recargas</li>
    </ol>
  </section>

  @endsection

@section('content')
@include('admin.users.confirmarAccionModal')
<div class="loader loader-bar is-active"></div>
<div class="box">
    <div class="box-header">
    @role('Super-Administrador|Administrador|Encargado|Vendedor')
      <a class="btn btn-primary pull-right" href="{{route('recargas.newt')}}">
        <i class="fa fa-arrows-alt-h"></i>Trasladar Saldo
      </a>
      @endrole
      @role('Super-Administrador|Administrador|Encargado|Vendedor')
      <a class="btn btn-primary pull-right" href="{{route('recargas.newm')}}">
        <i class="fa fa-minus"></i>Registro de Saldo
      </a>
      @endrole
      @role('Super-Administrador|Administrador|Encargado|Vendedor')
      <a class="btn btn-primary pull-right" href="{{route('recargas.new')}}">
        <i class="fa fa-plus"></i>Agregar Saldo
      </a>
      @endrole
    </div>
    <!-- /.box-header -->
    <div class="box-body">
        <input type="hidden" name="rol_user" value="{{auth()->user()->roles[0]->name}}">
        <table id="recargas-table" class="table table-striped table-bordered no-margin-bottom dt-responsive nowrap"  width="100%">            
        </table>
        <input type="hidden" name="urlActual" value="{{url()->current()}}"> 
    </div>
    <!-- /.box-body -->
  </div>
  <!-- /.box --> 

@endsection


@push('styles')
 
 
@endpush

@push('scripts')
  <script>
    $(document).ready(function() {
      $('.loader').fadeOut(225);
      recargas_table.ajax.url("{{route('recargas.getJson')}}").load();
    });

  </script>
  <script src="{{asset('js/recargas/index.js')}}"></script>
@endpush