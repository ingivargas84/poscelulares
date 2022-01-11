@extends('admin.layoutadmin')

@section('header')
<section class="content-header">
    <h1>
        Listado de Cuentas por Cobrar
        <small>Todos las Cuentas por Cobrar</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{route('dashboard')}}"><i class="fa fa-home"></i>Inicio</a></li>
        <li class="active">Cuentas por Cobrar</li>
    </ol>
</section>

@endsection

@section('content')
@include('admin.users.confirmarAccionModal')
<div class="loader loader-bar is-active"></div>
<div class="box">
    <!-- /.box-header -->
    <div class="box-body">
        <input type="hidden" name="rol_user" value="{{auth()->user()->roles[0]->name}}">
        <table id="cuentas_cobrar_table" class="table table-striped table-bordered no-margin-bottom dt-responsive nowrap"
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
    $(document).ready(function () {
        $('.loader').fadeOut(225);
        //loads the datatable
        cuentas_cobrar_table.ajax.url("{{route('cuentas_cobrar.getJson')}}").load();
    });

</script>
<script src="{{asset('js/cuentas_cobrar/index.js')}}"></script>
@endpush