@extends('admin.layoutadmin')

@section('header')
<section class="content-header">
    <h1>
        Listado de Ventas
        <small>Todas las Ventas</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{route('dashboard')}}"><i class="fa fa-home"></i> Inicio</a></li>
        <li class="active">Ventas</li>
    </ol>
</section>

@endsection

@section('content')
@include('admin.users.confirmarAccionModal')
<div class="loader loader-bar is-active"></div>
<div class="box">
    <div class="box-header">
        <a class="btn btn-primary pull-right" href="{{route('pedidos.newcontado')}}">
            <i class="fa fa-plus"></i>Agregar Venta</a>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
        <input type="hidden" name="rol_user" value="{{auth()->user()->roles[0]->name}}">
        <table id="pedidos-table" class="table table-striped table-bordered no-margin-bottom dt-responsive nowrap"
            width="100%">
        </table>
        <input type="hidden" id="urlActual" value="{{url()->current()}}">
    </div>
    <!-- /.box-body -->
</div>
<!-- /.box -->

@endsection


@push('styles')


@endpush

@push('scripts')
<script>
    //show the warehouse selection modal to create an order

    $(document).ready(function () {
        $('.loader').fadeOut(225);
        //loads the datatable
        pedidos_table.ajax.url("{{route('pedidos.getJson')}}").load();
        //check if the insert view sent a message
        if (window.location.href.indexOf("ajaxSuccess") > -1) {
            alertify.set('notifier', 'position', 'top-center');
            alertify.success('El pedido se ha registrado exitosamente.')
            window.history.replaceState({}, document.title, "/pedidos");
        }else if(window.location.href.indexOf("lastDetail") > -1){
          alertify.set('notifier', 'position', 'top-center');
          alertify.warning('El pedido no contienen registros y ha sido eliminado.')
          window.history.replaceState({}, document.title, "/pedidos");
        }
    });

</script>
<script src="{{asset('js/pedidos/index.js')}}"></script>
@endpush