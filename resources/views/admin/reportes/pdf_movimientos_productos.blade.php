<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Movimientos de Producto</title>
    <link rel="stylesheet" type="text/css" href="/public/style.css">
    <style>
        .table {
            width: 700px;
            height: auto;
        }
        th {
            background-color: gray;
            color: white;
        }
        table {
            border-collapse: collapse;
            border: 0px solid black;
        }
                
    </style>
</head>
<body>
    <div class="container">
        <div class="col-md-12">

        <table class="table table-striped table-bordered" border="1" cellspadding=2>
            <tr>
                <td style="width:100%; text-align:center; font-size:25px" colspan=2><strong>TIENDAS MELANY</strong></td>
            </tr>   
        </table>
        <br>
        <h2 style="width:100%; text-align:center">MOVIMIENTOS DE PRODUCTO </h2>

            <br>
            <h3 style="width:100%; text-align:left"><strong><u>Datos del Producto</u></strong></h2>
            <table cellspacing=0 cellpadding=2 width= 800 class="table table-striped table-bordered">   
                <tr>
                    <td style="font-size:15px;" width="60%">  <strong> Producto: </strong> {{{$compra_imei[0]->codigo}}}-{{{$compra_imei[0]->descripcion}}} </td>
                    <td style="font-size:15px; text-align:right;" width="40%"> <strong> IMEI: </strong> {{{$imei}}} </td>
                </tr>
                <tr>
                    <td style="font-size:15px;" width="60%">  <strong> Precio de Venta: </strong> Q {{{ $compra_imei[0]->precio_venta}}} </td>
                    <td style="font-size:15px; text-align:right;" width="40%"> <strong> Estado del Teléfono: </strong> {{{$compra_imei[0]->estado_venta}}}  </td>
                </tr>
                @if ($compra_imei[0]->estado_venta_id == 1)
                <tr>
                    <td style="font-size:15px;" width="60%">  <strong> Bodega de Ubicación: </strong> {{{$compra_imei[0]->bodega}}} </td>
                    <td style="font-size:15px; text-align:right;" width="40%">  </td>
                </tr>
                @endif
            </table>
            <br>
            <hr>
            <h3 style="width:100%; text-align:left"><strong><u>Datos de la Compra</u></strong></h2>
            <table cellspacing=0 cellpadding=2 width= 800 class="table table-striped table-bordered">   
                <tr>
                    <td style="font-size:15px;" width="50%">  <strong> Proveedor: </strong> {{{$compra_imei[0]->nombre_comercial}}}</td>
                    <td style="font-size:15px; text-align:right;" width="50%"> <strong> Documento Compra: </strong> {{{$compra_imei[0]->serie_factura}}}-{{{$compra_imei[0]->num_factura}}} </td>
                </tr>
                <tr>
                    <td style="font-size:15px;" width="50%">  <strong> Fecha de Compra: </strong> {{Carbon\Carbon::parse($compra_imei[0]->fecha_factura)->format('d-m-Y')}} </td>
                    <td style="font-size:15px; text-align:right;" width="50%"> <strong> Precio de Compra: </strong> Q {{{ $compra_imei[0]->precio_compra}}} </td>
                </tr>
                <tr>
                    <td style="font-size:15px;" width="50%">  <strong> Usuario que registró la compra: </strong> {{{$compra_imei[0]->name}}} </td>
                    <td style="font-size:15px; text-align:right;" width="50%">  </td>
                </tr>
            </table>
            <br>
            <hr>
            <h3 style="width:100%; text-align:left"><strong><u>Datos de los Traslados</u></strong></h3>

            @if (count($traslado_imei) == 0)
            <table cellspacing=0 cellpadding=2 width= 800 class="table table-striped table-bordered">   
                <tr>
                    <td style="font-size:15px;" width="50%">  <strong> Aun no hay datos de traslados para este IMEI </strong> </td>
                    <td style="font-size:15px; text-align:right;" width="50%">  </td>
                </tr>
            </table>
            @endif
            <table border="0" cellspacing=0 cellpadding=2 width= 800 class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th width=25%>Fecha Traslado</th>
                        <th width=25%>Usuario</th>
                        <th width=25%>Bodega Origen</th>
                        <th width=25%>Bodega Destino</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($traslado_imei as $ed)
                    <tr>
                        <td style="font-size:13px; text-align:center;">{{Carbon\Carbon::parse($ed->fecha_traslado)->format('d-m-Y')}}</td>
                        <td style="font-size:13px; text-align:center;">{{ $ed->name }}</td>
                        <td style="font-size:13px; text-align:center;">{{ $ed->origen }}</td>
                        <td style="font-size:13px; text-align:center;">{{ $ed->destino }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <br>
            <hr>
            <h3 style="width:100%; text-align:left"><strong><u>Datos de la Venta</u></strong></h2>

            @if ($compra_imei[0]->estado_venta_id == 2)

            <table cellspacing=0 cellpadding=2 width= 800 class="table table-striped table-bordered">   
                <tr>
                    <td style="font-size:15px;" width="50%">  <strong> Fecha de Venta: </strong> {{Carbon\Carbon::parse($venta_imei[0]->fecha_venta)->format('d-m-Y')}} </td>
                    <td style="font-size:15px; text-align:right;" width="50%"> <strong> Usuario que Vendió: </strong> {{{$venta_imei[0]->name}}} </td>
                </tr>
                <tr>
                    <td style="font-size:15px;" width="50%">  <strong> NIT del Cliente: </strong> {{{$venta_imei[0]->nit}}}</td>
                    <td style="font-size:15px; text-align:right;" width="50%"> <strong> Nombre del Cliente: </strong> {{{$venta_imei[0]->cliente}}} </td>
                </tr>
                <tr>
                    <td style="font-size:15px;" width="50%">  <strong> Código de la Venta: </strong> {{{$venta_imei[0]->no_pedido}}}</td>
                    <td style="font-size:15px; text-align:right;" width="50%"> <strong> Precio que se Vendió: </strong> Q {{{ $compra_imei[0]->precio_venta}}} </td>
                </tr>
            </table>
            @elseif ($compra_imei[0]->estado_venta_id == 1)
            <table cellspacing=0 cellpadding=2 width= 800 class="table table-striped table-bordered">   
                <tr>
                    <td style="font-size:15px;" width="50%">  <strong> Aun no hay datos de registro de Venta </strong> </td>
                    <td style="font-size:15px; text-align:right;" width="50%">  </td>
                </tr>
            </table>
            @endif
            
          
        </div>
    </div>
</div>

</body>
</html>