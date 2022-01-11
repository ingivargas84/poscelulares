@extends('admin.layoutadmin')

@section('header')
<section class="content-header">
    <h1>
      Listado de Imeis
      <small>Todos los Imeis</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="{{route('dashboard')}}"><i class="fa fa-home"></i> Inicio</a></li>
      <li class="active">Listado de Imeis</li>
    </ol>
  </section>

  @endsection

@section('content')
<div class="loader loader-bar is-active"></div>
<div class="box">
    
    <!-- /.box-header -->
    <div class="box-body">
        <input type="hidden" name="rol_user" value="{{auth()->user()->roles[0]->name}}">
        <table id="comprasimei-table" class="table table-striped table-bordered no-margin-bottom dt-responsive nowrap"  width="100%">            
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
      comprasimei_table.ajax.url("{{route('compras.getJsonimei')}}").load();
    });

  </script>
  <script src="{{asset('js/compras/indeximei.js')}}"></script>
@endpush