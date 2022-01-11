<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Reporte de Imeis y Productos por Fecha</title>
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

        

        <h2 style="width:100%; text-align:center">LISTADO DE IMEIS VENDIDOS POR PRODUCTO Y FECHA </h2>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>

            <table cellspacing=0 cellpadding=2 width= 800 class="table table-striped table-bordered">
                <tr>
                    <td style="font-size:15px;" width="50%"> <strong> Fecha Inicial: </strong>  {{{Carbon\Carbon::parse($fecha_inicial)->format('d-m-Y')}}}</td>
                    <td style="font-size:15px; text-align:right;" width="50%"> <strong> Fecha Final:</strong> {{{Carbon\Carbon::parse($fecha_final)->format('d-m-Y')}}}</td>
                </tr>    
                <tr>
                    <td style="font-size:15px;" width="50%">  <strong> Teléfono: </strong>{{{ $producto }}} - {{{ $telefono[0]->descripcion }}}</td>
                    <td style="font-size:15px; text-align:right;" width="50%"> <strong> Precio de Venta: </strong> Q. {{{number_format((float) $telefono[0]->precio_venta, 2) }}} </td>
                </tr>
                <tr>
                    <td style="font-size:15px;" width="50%">  <strong> Cantidad Vendidos: </strong> {{{ $total_vendidos[0]->total_vendidos }}}</td>
                    <td style="font-size:15px; text-align:right;" width="50%"> <strong> SubTotal Vendido en Quetzales: </strong> Q. {{{number_format((float) $total_vendidos[0]->total_quetzales, 2) }}} </td>
                </tr>
                <tr>
                    <td style="font-size:15px;" width="50%">  <strong> Total Descuentos: </strong> Q. {{{number_format((float) $total_descuentos[0]->descuentos, 2) }}}</td>
                    <td style="font-size:15px; text-align:right;" width="50%"> <strong> Total Vendido en Quetzales: </strong> Q. {{{number_format((float) $total_vendidos[0]->total_quetzales - $total_descuentos[0]->descuentos, 2) }}} </td>
                </tr>
            </table>
            <hr>
            <table border="0" cellspacing=0 cellpadding=2 width= 800 class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th width=15%>IMEI</th>
                        <th width=20%>Fecha</th>
                        <th width=20%>Tienda</th>
                        <th width=25%>Usuario</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $ed)
                    <tr>
                        <td style="font-size:13px; text-align:center;">{{$ed->imei}}</td>
                        <td style="font-size:13px; text-align:center;">{{Carbon\Carbon::parse($ed->fecha)->format('d-m-Y')}}</td>
                        <td style="font-size:13px; text-align:center;">{{ $ed->tienda }}</td>
                        <td style="font-size:13px; text-align:center;">{{ $ed->name }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

</body>
</html>