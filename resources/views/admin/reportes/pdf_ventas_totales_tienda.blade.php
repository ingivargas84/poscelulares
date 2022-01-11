<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Ventas Totales por Tienda</title>
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
        body { 
            background-image: url("./images/fondo4.png"); 
            background-repeat: no-repeat; 
        }
        table {
            border-collapse: collapse;
            border: 0px solid black;
        }
                
    </style>
</head>
<body>
    <div class="container">
       <div class="row">
        <div class="col-md-12">

        <h2 style="width:100%; text-align:center">VENTAS TOTALES POR TIENDA Y PERÍODO DE TIEMPO </h2>
        <br>
        <br>
        <br>
        <br>
        <br>
            <table cellspacing=0 cellpadding=2 width= 800 class="table table-striped table-bordered">   
                <tr>
                    <td style="font-size:15px; text-align:right;" width="50%"> <strong> Del: </strong> {{{Carbon\Carbon::parse($fecha_inicial)->format('d-m-Y')}}} al {{{Carbon\Carbon::parse($fecha_final)->format('d-m-Y')}}} </td>

                </tr>
            </table>
            <hr>
            <table border="0" cellspacing=0 cellpadding=2 width= 800 class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th width=70%>TIENDA</th>
                        <th width=30%>Total Venta</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $ed)
                    <tr>
                        <td style="font-size:15px; text-align:center;">{{$ed->tienda}}</td>
                        <td style="font-size:15px; text-align:right;">Q. {{number_format((float) $ed->total, 2) }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <table cellspacing=0 cellpadding=2 width= 800 class="table table-striped table-bordered">   
                <tr>
                    <td style="font-size:15px;" width="50%"></td>
                    <td style="font-size:18px; text-align:right;" width="50%"> <strong> Total: </strong> Q. {{{number_format((float) $total[0]->total, 2) }}} </td>
                </tr>
            </table>
            <br>
            <hr>
            <h3 style="width:100%; text-align:center">Producto mas vendido por tienda </h2>
            <table border="0" cellspacing=0 cellpadding=2 width= 800 class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th width=25%>TIENDA</th>
                        <th width=50%>PRODUCTO</th>
                        <th width=25%>CANT VENDIDA</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($productos_tienda as $pt)
                    <tr>
                        <td style="font-size:15px; text-align:center;">{{$pt->tienda}}</td>
                        <td style="font-size:15px; text-align:center;">{{$pt->descripcion}}</td>
                        <td style="font-size:15px; text-align:center;">{{$pt->cantidad}}</td>
                    </tr>
                    @endforeach
                    
                </tbody>
            </table>
            <br>
            <hr>
            <h3 style="width:100%; text-align:center">Usuario con más unidades vendidas </h2>
            <table border="0" cellspacing=0 cellpadding=2 width= 800 class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th width=30%>TIENDA</th>
                        <th width=40%>USUARIO</th>
                        <th width=30%>UNIDADES VENDIDAS</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($usuarios_ventas as $uv)
                    <tr>
                        <td style="font-size:15px; text-align:center;">{{$uv->tienda}}</td>
                        <td style="font-size:15px; text-align:center;">{{$uv->name}}</td>
                        <td style="font-size:15px; text-align:center;">{{$uv->uni_vendidas}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

</body>
</html>