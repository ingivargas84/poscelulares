@extends('admin.layoutadmin')

@section('header')
    <section class="content-header">
        <h1>
          PRODUCTOS
          <small>Crear Producto</small>
        </h1>
        <ol class="breadcrumb">
          <li><a href="{{route('dashboard')}}"><i class="fa fa-tachometer-alt"></i> Inicio</a></li>
          <li><a href="{{route('productos.index')}}"><i class="fa fa-list"></i> Productos</a></li>
          <li class="active">Crear</li>
        </ol>
    </section>
@stop

@section('content')
    <form method="POST" id="ProductoForm"  action="{{route('productos.save')}}">
            {{csrf_field()}}
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-body">
                        <div class="row">
                            <div class="col-sm-4">
                                <label for="codigo">Código:</label>
                                <input type="text" class="form-control" placeholder="Código del producto" name="codigo" id="codigo" >
                            </div>
                            <div class="col-sm-4">
                                <label for="marca_id">Marca:</label>
                                <select name="marca_id" id="marca_id" class="form-control">
                                <option value="default">Seleccione una Marca</option>
                                    @foreach ($marcas as $mar)
                                        <option value="{{$mar->id}}">{{$mar->marca}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-sm-4">
                                <label for="modelo_id">Modelo:</label>
                                <select name="modelo_id" id="modelo_id" class="form-control">
                                    <option value="default">Seleccione un Modelo</option>
                                </select>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-sm-3">
                                <label for="precio_venta">Precio de Venta:</label>
                                <input type="number" class="form-control" placeholder="Precio de venta" name="precio_venta" >
                            </div>
                            <div class="col-sm-3">
                                <label for="color">Color:</label>
                                <input type="text" class="form-control" placeholder="Color" name="color" id="color" >
                            </div>
                            <div class="col-sm-3">
                                <label for="compania_id">Compañia:</label>
                                <select name="compania_id" id="compania_id" class="form-control">
                                <option value="default">Seleccione una Compañía</option>
                                    @foreach ($companias as $com)
                                        <option value="{{$com->id}}">{{$com->compania}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-sm-3">
                                <label for="presentacion">Grupo:</label>
                                <select name="presentacion" id="presentacion" class="form-control">
                                <option value="default">Seleccione un Grupo</option>
                                    @foreach ($presentaciones as $presentacion)
                                        <option value="{{$presentacion->id}}">{{$presentacion->presentacion}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-sm-12">
                                <label for="descripcion">Descripción:</label>
                                <input type="text" class="form-control" placeholder="Descripcion" name="descripcion" id="descripcion" >
                            </div>
                        </div>
                        <br>
                        <div class="text-right m-t-15">
                            <a class='btn btn-primary form-button' href="{{ route('productos.index') }}">Regresar</a>
                            <button id="ButtonProducto" class="btn btn-success form-button">Guardar</button>
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
<script src="{{asset('js/productos/create.js')}}"></script>

<script>

    $("#marca_id").change(function () {
        
	var marca_id = $("#marca_id").val();
	var url = "/productos/getModelos/" + marca_id ;

	if (marca_id != "") {
		$.getJSON( url , function ( result ) {

            for (var i=0; i<result.length; i++){
                document.getElementById("modelo_id").innerHTML += "<option value='"+result[i].id+"'>"+ result[i].modelo  + "</option>";
            }
                  
		});
	}
    });



    $("#presentacion").change(function () {

        var grupo = $(this).find('option:selected').text();
        var modelo = $("#modelo_id").find('option:selected').text();
        var color = $('#color').val();
        var marca = $("#marca_id").find('option:selected').text();
        var compania = $("#compania_id").find('option:selected').text();

        $('#descripcion').val(grupo + ' ' + marca + ' ' + modelo + ', ' + color + ', ' + compania );

    });

</script>
@endpush