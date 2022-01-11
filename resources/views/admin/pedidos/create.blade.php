@extends('admin.layoutadmin')

@section('header')
    <section class="content-header">
        <h1>
          Ventas
            <small>Registrar una Venta a la bodega {{$bodegas[0]->nombre}}</small>
        </h1>
        <ol class="breadcrumb">
          <li><a href="{{route('dashboard')}}"><i class="fa fa-tachometer-alt"></i> Inicio</a></li>
          <li><a href="{{route('pedidos.index')}}"><i class="fa fa-list"></i> Pedidos</a></li>
          <li class="active">Crear</li>
        </ol>
    </section>
@stop

@section('content')
    <form method="POST" id="PedidoForm"  action="{{route('pedidos.save')}}">
            {{csrf_field()}}
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-body">
                        <div class="row">
                            <div class="col-sm-4">
                                <label for="cliente_id">Cliente:</label>
                                <select name="cliente_id" class="form-control" id="clientes" autofocus tabindex="1">
                                    @foreach ($clientes as $cliente)
                                        <option value="{{$cliente->id}}">{{$cliente->nombre_cliente}}</option>
                                    @endforeach
                                </select>
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
                                    <option value="default">- - -</option>
                                </select>
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
                                <label for="subtotal">Subtotal:</label>
                                <div class="input-group">
                                    <span class="input-group-addon">Q.</span>
                                    <input type="number" class="form-control customreadonly" placeholder="Subtotal" name="subtotal" id="subtotal">
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
                                <label for="total_ingreso">Total:</label>
                                <div class="input-group">
                                    <span class="input-group-addon">Q.</span>
                                    <input type="text" class="form-control customreadonly" placeholder="Total del Pedido" name="total_ingreso" id="total">
                                </div>
                            </div>
                        </div>
                            <div class="text-right m-t-15">
                                <a class='btn btn-primary form-button' href="{{ route('pedidos.index') }}">Regresar</a>
                                <button id="ButtonPedido" class="btn btn-success form-button">Guardar</button>
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

$(document).ready(function () {
    //change selectboxes to selectize mode to be searchable
    $("#clientes").select2();
  });
  //fix validation error message always displaying.
  $("#clientes").on("select2:close", function (e) {
      $(this).valid();
  });
  


  $("#producto_id").change(function () {
	var producto_id = $("#producto_id").val();
    var bodega_id = $("#bodega_id").find('option:selected').val();
	var url = "/pedidos/getProductoData/" + producto_id + "/" + bodega_id;
	if (producto_id != "") {
		$.getJSON( url , function ( result ) {
			$("input[name='descripcion'] ").val(result[0].descripcion);
            $("input[name='prod_id'] ").val(result[0].id);
            $('#precio').val(result[0].precio_venta);
            $('#stock').val(result[0].existencias);
		});
	}

    var url = "/pedidos/getImei/" + producto_id + "/" + bodega_id;
    if (producto_id != "") {
		$.getJSON( url , function ( result ) {
			
            for (var i=0; i<result.length; i++){
                document.getElementById("imei").innerHTML += "<option value='"+result[i].id+"'>"+ result[i].imei  + "</option>";
            }

		});
	}

    });


      //calculates subtotal desde cantidad
      $(document).on('focusout', '#cantidad', function(){
          $('#subtotal').val(null);
          let sub = parseFloat($('#precio').val()) * parseFloat($('#cantidad').val());
          sub = sub.toFixed(2);
          $('#subtotal').val(sub);
      });

      //calculates subtotal desde precio compra
      $(document).on('focusout', '#precio', function(){
          $('#subtotal').val(null);
          let sub = parseFloat($('#precio').val()) * parseFloat($('#cantidad').val());
          sub = sub.toFixed(2);
          $('#subtotal').val(sub);
      });

  //checks for empty fields
  function chkflds() {
      if ($('#descripcion').val() && $('#cantidad').val() && $('#precio').val() && $('#subtotal').val() ) {
          return true
      }else{
          return false
      }
  }

  $('#agregar-detalle').click(function(e){
      e.preventDefault();
      if(chkflds()){
          //adds the form data to the table

          detalle_table.row.add({
              'producto_id': $('#prod_id').val(),
              'producto': $('#descripcion').val(),
              'cantidad': $('#cantidad').val(),
              'precio'  : $('#precio').val(),
              'imei'  : $("#imei").find('option:selected').text(),
              'subtotal': $('#subtotal').val(),
          }).draw();
          //adds all subtotal row data and sets the total input
          var total = 0;
          detalle_table.column(5).data().each(function(value, index){
              total = total + parseFloat(value);
              // parseFloat(total);
              $('#total').val(total);
              $('#total-error').remove();
          });
          //resets form data
          $('#descripcion').val(null);
          $('#cantidad').val(null);
          $('#precio').val(null);
          $('#subtotal').val(null);
          $('#producto_id').val('default');
          $('#imei').val('default');
          $('#stock').val(null);
      }else{
          alertify.set('notifier', 'position', 'top-center');
          alertify.error  ('Debe seleccionar un producto y una cantidad menor o igual a las existencias en bodega')
      }
  });



  $(document).one('click', '#ButtonPedido', function(e){
      e.preventDefault();
      $('#cantidad').rules('remove','existencia');
      if ($('#PedidoForm').valid()) {
          var arr1 = $('#PedidoForm').serializeArray();
          var arr2 = detalle_table.rows().data().toArray();
          var arr3 = arr1.concat(arr2);

          $.ajax({
              type: 'POST',
              url: "{{route('pedidos.save')}}",
              headers:{'X-CSRF-TOKEN': $('#tokenReset').val(),},
              data: JSON.stringify(arr3),
              dataType: 'json',
              success: function(){
                  $('#cliente_id').val('default');
                  $('#imei').val('default');
                  $('#producto_id').val('default');
                  $('#serie-factura').val(null);
                  $('#total').val(null);
                  detalle_table.rows().remove().draw();
                  window.location.assign('/pedidos?ajaxSuccess')
              },
              error: function(){
                  alertify.set('notifier', 'position', 'top-center');
                  alertify.error('Hubo un error al registrar la venta')
              }
          })
      }
  });


</script>

<script src="{{asset('js/pedidos/new.js')}}"></script>{{-- datatable --}}
<script src="{{asset('js/pedidos/create.js')}}"></script>{{-- validator --}}
@endpush
