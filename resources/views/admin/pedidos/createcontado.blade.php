@extends('admin.layoutadmin')

@section('header')
    <section class="content-header">
        <h1>
          Ventas
            <small>Registrar una Venta</small>
        </h1>
        <ol class="breadcrumb">
          <li><a href="{{route('dashboard')}}"><i class="fa fa-tachometer-alt"></i> Inicio</a></li>
          <li><a href="{{route('pedidos.index')}}"><i class="fa fa-list"></i> Pedidos</a></li>
          <li class="active">Crear</li>
        </ol>
    </section>
@stop

@section('content')
    <form method="POST" id="PedidoFormContado"  action="{{route('pedidos.savecontado')}}">
            {{csrf_field()}}
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-body">
                        <div class="row">
                            <div class="col-sm-4">
                                <label for="nit">NIT:</label>
                                <input type="text" class="form-control" name="nit" placeholder="NIT" id="nit">
                                <input type="hidden" name="cliente_id" id="cliente_id" value=1>
                            </div>
                            <div class="col-sm-8">
                                <label for="nombre">Nombre:</label>
                                <input type="text" class="form-control" name="nombre" placeholder="Nombre Cliente" id="nombre">
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-sm-4">
                                <label for="direccion">Dirección:</label>
                                <input type="text" class="form-control" name="direccion" placeholder="Dirección" id="direccion">
                            </div>
                            <div class="col-sm-4">
                                <label for="forma_pago_id">Forma de Pago:</label>
                                <select name="forma_pago_id" class="form-control" id="forma_pago_id" autofocus tabindex="1">
                                    @foreach ($formas_pago as $fp)
                                        <option value="{{$fp->id}}">{{$fp->nombre}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-sm-4">
                                <label for="bodega_id">Bodega:</label>
                                <select name="bodega_id" class="form-control" id="bodega_id" autofocus tabindex="1">
                                    @foreach ($bodegas as $bod)
                                        <option value="{{$bod->id}}">{{$bod->nombre}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-sm-4">
                                <label for="porcentaje">Porcentaje Descuento %:</label>
                                <input type="number" class="form-control" name="porcentaje" id="porcentaje" value="0">
                            </div>
                            <div class="col-sm-4">
                                <label for="descuento_porcentaje">Descuento por Porcentaje:</label>
                                <input type="number" disabled class="form-control" name="descuento_porcentaje" id="descuento_porcentaje" value="0">
                            </div>
                            <div class="col-sm-4">
                                <label for="descuento_valores">Descuento por Valor:</label>
                                <input type="number" class="form-control" name="descuento_valores" id="descuento_valores" value="0">
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-sm-6">
                                <label for="producto_id">Producto:</label>
                                <select name="producto_id" class="selectpicker form-control" data-live-search="true" id="producto_id">
                                    <option value="default">Seleccione una producto</option>
                                    @foreach ($productos as $pro)
                                    <option value="{{$pro->id}}">{{$pro->descripcion}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-sm-3">
                                <label for="imei">IMEI:</label>
                                <select name="imei" class="form-control" id="imei">
                                </select>
                                <input type="hidden" class="form-control" name="imeir" id="imeir" value="X">
                            </div>
                            <div class="col-sm-3">
                                <label for="stock">Existencias:</label>
                                <input type="number" class="form-control customreadonly" name="stock" placeholder="Existencias del producto en bodegas" id="stock">
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-sm-6">
                                <label for="descripcion">Descripcion producto:</label>
                                <input type="text" class="form-control" placeholder="Descripcion producto" name="descripcion" readonly id="descripcion">
                                <input type="text" name="prod_id" readonly hidden id="prod_id">
                                <input type="text" name="grupo_prod" readonly hidden id="grupo_prod">
                            </div>
                            <div class="col-sm-2">
                                <label for="cantidad">Cantidad:</label>
                                <input type="number" class="form-control" name="cantidad" placeholder="Cantidad del Producto" id="cantidad" tabindex="3">
                            </div>
                            <div class="col-sm-2">
                                <label for="precio">Precio:</label>
                                <div class="input-group">
                                    <span class="input-group-addon">Q.</span>
                                    <input type="number" class="form-control customreadonly" placeholder="Precio unitario del producto" name="precio" id="precio">
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <label for="subtotalv">Subtotal:</label>
                                <div class="input-group">
                                    <span class="input-group-addon">Q.</span>
                                    <input type="number" class="form-control customreadonly" placeholder="Subtotal" name="subtotalv" id="subtotalv">
                                </div>
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
                        <div class="row">
                            <div class="col-sm-4">
                                <label for="subtotal">SubTotal:</label>
                                <div class="input-group">
                                    <span class="input-group-addon">Q.</span>
                                    <input type="text" class="form-control customreadonly" placeholder="Subtotal del Pedido" name="subtotal" id="subtotal">
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <label for="total_ingreso">Total:</label>
                                <div class="input-group">
                                    <span class="input-group-addon">Q.</span>
                                    <input type="text" class="form-control customreadonly" placeholder="Total del Pedido" name="total_ingreso" id="total">
                                </div>
                            </div>
                        </div>
                            <div class="text-right m-t-15">
                                <a class='btn btn-primary form-button' href="{{ route('pedidos.index') }}">Regresar</a>
                                <button id="ButtonPedidoContado" class="btn btn-success form-button">Guardar</button>
                            </div>
                        <br>

                    </div>
                </div>
            </div>
    </form>
    <div class="loader loader-bar"></div>
@stop


@push('styles')

<style>
    .customreadonly{
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
        /* box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.3), 0 1px rgba(255, 255, 255, 0.1); */
        transition: all 0.1s ease-in-out;
    }

    .switch-field label:hover {
        cursor: pointer;
    }

    .switch-field input:checked + label {
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

<script>


  $("#producto_id").change(function () {
	var producto_id = $("#producto_id").val();
    var bodega_id = $("#bodega_id").find('option:selected').val();
	var url = "/pedidos/getProductoData/" + producto_id + "/" + bodega_id;
	if (producto_id != "") {
		$.getJSON( url , function ( result ) {
			$("input[name='descripcion'] ").val(result[0].descripcion);
            $("input[name='prod_id'] ").val(result[0].id);
            $("input[name='grupo_prod'] ").val(result[0].grupo);
            $('#precio').val(result[0].precio_venta);
            $('#stock').val(result[0].existencias);
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
 


      //calculates subtotal desde cantidad
      $(document).on('focusout', '#cantidad', function(){
          $('#subtotalv').val(null);
          let sub = parseFloat($('#precio').val()) * parseFloat($('#cantidad').val());
          sub = sub.toFixed(2);
          $('#subtotalv').val(sub);
      });

      //calculates subtotal desde precio compra
      $(document).on('focusout', '#precio', function(){
          $('#subtotalv').val(null);
          let sub = parseFloat($('#precio').val()) * parseFloat($('#cantidad').val());
          sub = sub.toFixed(2);
          $('#subtotalv').val(sub);
      });


  //checks for empty fields
  function chkflds() {
      if ($('#descripcion').val() && $('#cantidad').val() && $('#precio').val() && $('#subtotalv').val() ) {
        return true
      }else{
        return false
      }
  }


  $("#imei").change(function () {
	
    var filas =  detalle_table.rows().count();
    var imei = $("#imei").find('option:selected').text();
    var desc = $("#descripcion").val();

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



  $('#agregar-detalle').click(function(e){
      e.preventDefault();
      if(chkflds()){


        if ( ( ($('#grupo_prod').val() <= 2) && $('#imeir').val() && ( $('#cantidad').val() == 1 ) && ($("#imei").find('option:selected').text() != "- - -") )  ||  ( ($('#grupo_prod').val() >= 3) && (  parseInt($('#cantidad').val()) <= parseInt($('#stock').val()) ) && ( $('#cantidad').val() >= 1 ) ) ) {

                detalle_table.row.add({
                    'producto_id': $('#prod_id').val(),
                    'producto': $('#descripcion').val(),
                    'cantidad': $('#cantidad').val(),
                    'precio'  : $('#precio').val(),
                    'imei'  : $("#imei").find('option:selected').text(),
                    'subtotalv': $('#subtotalv').val(),
                }).draw();
                //adds all subtotal row data and sets the total input
        

                var total = 0;
                detalle_table.column(5).data().each(function(value, index){
                total = total + parseFloat(value);
              // parseFloat(total);
                $('#subtotal').val(total);
                $('#subtotal-error').remove();
            });

          var porcentaje = $("#porcentaje").val();
          var subtotal = $("#subtotal").val();
          var desc_porcentaje = (subtotal * porcentaje) / 100;
          var descuento_valor = $("#descuento_valores").val();
          var tot = subtotal - desc_porcentaje - descuento_valor;
          $('#descuento_porcentaje').val(desc_porcentaje);
          $('#total').val(tot);

          //resets form data
          $('#descripcion').val(null);
          $('#cantidad').val(null);
          $('#precio').val(null);
          $('#subtotalv').val(null);
          $('#producto_id').val('default');
          $('#imei').empty();
          $('#imei').val('default');
          $('#stock').val(null);

        
        
        }else{
            alertify.set('notifier', 'position', 'top-center');
            alertify.error  ('La cantidad para un teléfono o tableta/teléfono debe ser 1 o debería seleccionar un imei para el teléfono además no debe estar repetido o la cantidad es mayor a la existencia en bodega.')
        }
      }else{
          alertify.set('notifier', 'position', 'top-center');
          alertify.error  ('Debe seleccionar un producto válido, ingresar una cantidad o la cantidad debe ser menor o igual a las existencias en bodega')
      }
  });



  $(document).one('click', '#ButtonPedidoContado', function(e){
      e.preventDefault();

      var num = detalle_table.rows().count();
      
      if (($('#PedidoFormContado').valid()) && (num > 0)) {
          var arr1 = $('#PedidoFormContado').serializeArray();
          var arr2 = detalle_table.rows().data().toArray();
          var arr3 = arr1.concat(arr2);

          $.ajax({
              type: 'POST',
              url: "{{route('pedidos.savecontado')}}",
              headers:{
                  'X-CSRF-TOKEN': $('#tokenReset').val(),
              },
              data: JSON.stringify(arr3),
              dataType: 'json',
              success: function(){
                  $('#nit').val(null);
                  $('#nombre').val(null);
                  $('#direccion').val(null);
                  $('#imei').val('default');
                  $('#producto_id').val('default');
                  $('#subtotal').val(null);
                  $('#total').val(null);
                  detalle_table.rows().remove().draw();
                  window.location.assign('/pedidos?ajaxSuccess')
              },
              error: function(){
                  alertify.set('notifier', 'position', 'top-center');
                  alertify.error('Hubo un error al registrar la venta')
              }
          })
      }else{
            alertify.set('notifier', 'position', 'top-center');
            alertify.error('Error, No hay datos en el detalle, agregue algun producto')
      }
  });


</script>

<script src="{{asset('js/pedidos/new.js')}}"></script>{{-- datatable --}}
<script src="{{asset('js/pedidos/create.js')}}"></script>{{-- validator --}}
@endpush
