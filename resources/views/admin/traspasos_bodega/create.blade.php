@extends('admin.layoutadmin')

@section('header')
<section class="content-header">
    <h1>
        Traspasos de Bodega
        <small>Crear Traspaso</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{route('dashboard')}}"><i class="fa fa-tachometer-alt"></i> Inicio</a></li>
        <li><a href="{{route('traspasos_bodega.index')}}"><i class="fa fa-list"></i> Traspasos de Bodega</a></li>
        <li class="active">Crear</li>
    </ol>
</section>
@stop

@section('content')
<form method="POST" id="TraspasoForm" action="{{route('traspasos_bodega.save')}}" autocomplete="off">
    {{csrf_field()}}
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-body">
                <div class="row">
                    <div class="col-md-6 col-sm-12">
                        <label for="bodega_origen">Bodega de Origen:</label>
                        <select name="bodega_origen" id="bodega_origen" class="form-control" autofocus tabindex="1">
                            @foreach ($bodegas_origen as $bodegao)
                            <option value="{{$bodegao->id}}">{{$bodegao->nombre}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6 col-sm-12">
                        <label for="bodega_destino">Bodega de Destino:</label>
                        <select name="bodega_destino" id="bodega_destino" class="form-control" tabindex="2">
                            @foreach ($bodegas_destino as $bodegad)
                            <option value="{{$bodegad->id}}">{{$bodegad->nombre}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-md-4 col-sm-12">
                        <label for="producto_id">Producto:</label>
                        <select name="producto_id" class="selectpicker form-control" data-live-search="true" id="producto_id">
                            <option value="default">Seleccione una producto</option>
                            @foreach ($productos as $pro)
                            <option value="{{$pro->id}}">{{$pro->descripcion}}</option>
                            @endforeach
                            </select>
                    </div>
                    <div class="col-md-4 col-sm-12">
                        <label for="imei">Imei:</label>
                        <select name="imei" class="form-control"  id="imei">

                        </select>
                        <input type="hidden" class="form-control" name="imeir" id="imeir" value="X">
                    </div>
                    <div class="col-md-4 col-sm-12">
                        <label for="cantidad">Cantidad:</label>
                        <input type="number" class="form-control" placeholder="Cantidad de producto a transferir" id="cantidad" name="cantidad" value="1" tabindex="4">
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-md-6 col-sm-12">
                        <label for="nombre_prod">Nombre del Producto:</label>
                        <input type="text" class="form-control" placeholder="Nombre comercial del producto" name="nombre_prod" id="nombre_prod" readonly>
                        <input type="text" name="grupo_prod" readonly hidden id="grupo_prod">
                    </div>
                    <div class="col-md-6 col-sm-12">
                        <label for="stock">Existencias en bodega de origen:</label>
                        <input type="number" class="form-control" placeholder="Existencias del producto" name="stock" id="existencias" readonly>
                    </div>
                </div>
                <br>
                <div class="row">
                            <div class="col-sm-6">
                                <div class="text-left m-t-15">
                                    <h3>Detalle</h3>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="text-right m-t-15" style="margin-top: 15px; margin-bottom: 10px">
                                    <button id="agregar-detalle" class="btn btn-success form-button" tabindex="5">Agregar al detalle</button>
                                </div>
                            </div>
                        </div>
                        <br>
                        <table id="detalle-table" class="table table-striped table-bordered no-margin-bottom dt-responsive nowrap"  width="100%">
                        </table>
                        <br>
                <div class="text-right m-t-15">
                    <a class='btn btn-primary form-button' href="{{ route('traspasos_bodega.index') }}">Regresar</a>
                    <button id="ButtonTraspaso" class="btn btn-success form-button" tabindex="5">Guardar</button>
                </div>

            </div>
        </div>
    </div>
</form>
<div class="loader loader-bar"></div>

@stop


@push('styles')
<style>
    div.col-md-6 {
        margin-bottom: 15px;
    }

    .customreadonly {
        background-color: #eee;
        cursor: not-allowed;
        pointer-events: none;
    }

    .switch-field {
        display: flex;
        margin-bottom: 36px;
        overflow: hidden;
    }

    .switch-field input {
        position: absolute !important;
        clip: rect(0, 0, 0, 0);
        height: 1px;
        width: 1px;
        border: 0;
        overflow: hidden;
    }

    .switch-field label {
        background-color: #e4e4e4;
        color: rgba(0, 0, 0, 0.6);
        font-size: 14px;
        line-height: 1;
        text-align: center;
        padding: 8px 16px;
        margin-right: -1px;
        border: 1px solid rgba(0, 0, 0, 0.2);
        box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.3), 0 1px rgba(255, 255, 255, 0.1);
        transition: all 0.1s ease-in-out;
        width: 50%;
    }

    .switch-field label:hover {
        cursor: pointer;
    }

    .switch-field input:checked+label {
        background-color: #55bd8c;
        box-shadow: none;
    }

    .switch-field label:first-of-type {
        border-radius: 4px 0 0 4px;
    }

    .switch-field label:last-of-type {
        border-radius: 0 4px 4px 0;
    }

</style>


@endpush


@push('scripts')
<script defer src="{{asset('js/traspasos_bodega/create.js')}}"></script>
<script defer src="{{asset('js/traspasos_bodega/detalle.js')}}"></script>

<script defer>
   


    $("#producto_id").change(function () {
	var producto_id = $("#producto_id").val();
    var bodega_id = $("#bodega_origen").val();

	var url = "/traspasos_bodega/getProductoData/" + producto_id + "/" + bodega_id;
	if (producto_id != "") {
		$.getJSON( url , function ( result ) {
			$("input[name='nombre_prod'] ").val(result[0].descripcion);
            $("input[name='producto_id'] ").val(result[0].id);
            $("input[name='grupo_prod'] ").val(result[0].grupo);
            $('#existencias').val(result[0].existencias);
		});
	}

    var url = "/pedidos/getImei/" + producto_id + "/" + bodega_id;
    if (producto_id != "") {
		$.getJSON( url , function ( result ) {
            document.getElementById("imei").innerHTML += "<option value='default'>- - -</option>";
			
            for (var i=0; i<result.length; i++){
                document.getElementById("imei").innerHTML += "<option value='"+result[i].id+"'>"+ result[i].imei  + "</option>";
            }

		});
	}

    });

    
  $("#imei").change(function () {
	
    var filas =  detalle_table.rows().count();
    var imei = $("#imei").find('option:selected').text();

    if (filas>0)
    {
        for (var i=0; i<filas; i++)
        {
            if(imei == detalle_table.cell(i,2).data())
            {
                alertify.set('notifier', 'position', 'top-center');
                alertify.error('Error, no puede agregar un IMEI que ya se agregó a la venta, seleccione otro IMEI')

                $("input[name='imeir'] ").val(null);
            }
            else
            {
                $("input[name='imeir'] ").val("X");
            }
        }
    }
    
    });


    function chkflds() {
      if ($('#nombre_prod').val() && $('#cantidad').val() ) {
          return true
      }else{
          return false
      }
  }


    $('#agregar-detalle').click(function(e){
      e.preventDefault();
      if(chkflds()){
          
        if ( ( ($('#grupo_prod').val() <= 2) && $('#imeir').val() && ( $('#cantidad').val() == 1 ) && ($("#imei").find('option:selected').text() != "- - -") )  ||  ( ($('#grupo_prod').val() >= 3) && (  parseInt($('#cantidad').val()) <= parseInt($('#existencias').val()) ) && ( $('#cantidad').val() >= 1 ) ) ) {

          detalle_table.row.add({
              'producto_id': $('#producto_id').val(),
              'producto': $('#nombre_prod').val(),
              'cantidad': $('#cantidad').val(),
              'imei'  : $("#imei").find('option:selected').text(),
          }).draw();

          //resets form data
          $('#producto_id').val(null);
          $('#cantidad').val(1);
          $('#nombre_prod').val(null);
          $('#imei').empty();
          $('#imei').val('default');

        }else{
            alertify.set('notifier', 'position', 'top-center');
            alertify.error  ('La cantidad para un teléfono o tableta/teléfono debe ser 1 o debería seleccionar un imei para el teléfono además no debe estar repetido o la cantidad es mayor a la existencia en bodega.')
        }
        
      }else{
          alertify.set('notifier', 'position', 'top-center');
          alertify.error  ('Debe seleccionar un producto válido, ingresar una cantidad o la cantidad debe ser menor o igual a las existencias en bodega')
      }
  });



    $(document).one('click', '#ButtonTraspaso', function(e){
      e.preventDefault();

      if ($('#TraspasoForm').valid()) {
          var arr1 = $('#TraspasoForm').serializeArray();
          var arr2 = detalle_table.rows().data().toArray();
          var arr3 = arr1.concat(arr2);

          $.ajax({
              type: 'POST',
              url: "{{route('traspasos_bodega.save')}}",
              headers:{'X-CSRF-TOKEN': $('#tokenReset').val(),},
              data: JSON.stringify(arr3),
              dataType: 'json',
              success: function(){
                  $('#bodega_origen').val('default');
                  $('#bodega_destino').val('default');
                  $('#producto_id').val('default');
                  detalle_table.rows().remove().draw();
                  window.location.assign('/traspasos_bodega?ajaxSuccess')
              },
              error: function(){
                  alertify.set('notifier', 'position', 'top-center');
                  alertify.error('Hubo un error al registrar el traspaso')
              }
          })
      }
   
  });



</script>
@endpush
