<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Detalle de Ventas por Fecha y Tienda</title>
    <link rel="stylesheet" type="text/css" href="/public/style.css">
    <style>
        .table {
            width: 960px;
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
        body { 
            background-image: url("./images/fondoH3.png"); 
            background-repeat: no-repeat; 
        }
                
    </style>
</head>
<body>
    <div class="container">
       <div class="row">
        <div class="col-md-12">
        <br>
        <h2 style="width:100%; text-align:center">DETALLE DE VENTAS POR FECHA Y TIENDA </h2>

            <br>
            <br>
            <br>
            <br>
            <br>
            <table cellspacing=0 cellpadding=2 width= 800 class="table table-striped table-bordered">   
                <tr>
                @if ( $tienda == "default")
                    <td style="font-size:15px;" width="50%">  <strong> Tienda: </strong> Todas las tiendas</td>
                @else
                    <td style="font-size:15px;" width="50%">  <strong> Tienda: </strong> {{{ $tiendas[0]->tienda}}}</td>
                @endif
                    
                    <td style="font-size:15px; text-align:right;" width="50%"> <strong> Fecha: </strong> {{{Carbon\Carbon::parse($fecha)->format('d-m-Y')}}} </td>
                </tr>
            </table>
            <hr>
            <table border="0" cellspacing=0 cellpadding=2 width= 800 class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th width=15%>Usuario</th>
                        <th width=35%>Descripción</th>
                        <th width=15%>Imei</th>
                        <th width=10%>Cant</th>
                        <th width=10%>Precio</th>
                        <th width=15%>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $ed)
                    <tr>
                        <td style="font-size:12px; text-align:left;">{{$ed->username}}</td>
                        <td style="font-size:12px; text-align:left;">{{$ed->descripcion}}</td>
                        <td style="font-size:12px; text-align:center;">{{ $ed->imei }}</td>
                        <td style="font-size:12px; text-align:center;">{{ $ed->cantidad }}</td>
                        <td style="font-size:12px; text-align:right;">Q. {{{number_format((float) $ed->precio, 2) }}}</td>
                        <td style="font-size:12px; text-align:right;">Q. {{{number_format((float) $ed->subtotal, 2) }}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <br><br>
            <table cellspacing=0 cellpadding=2 width= 800 class="table table-striped table-bordered">   
                <tr>
                    <td style="font-size:15px;" width="50%"></td>
                    <td style="font-size:18px; text-align:right;" width="50%"> <strong> Subtotal: </strong> Q. {{{number_format((float) $total[0]->total, 2) }}} </td>
                </tr>
                <tr>
                    <td style="font-size:15px;" width="50%"></td>
                    <td style="font-size:18px; text-align:right;" width="50%"> <strong> Descuentos: </strong> Q. {{{number_format((float) $descuentos[0]->descuentos, 2) }}} </td>
                </tr>
                <tr>
                    <td style="font-size:15px;" width="50%"></td>
                    <td style="font-size:18px; text-align:right;" width="50%"> <strong> Total: </strong> Q. {{{number_format((float) $total[0]->total - $descuentos[0]->descuentos, 2) }}} </td>
                </tr>
            </table>
            
        </div>
    </div>
</div>

</body>
</html>