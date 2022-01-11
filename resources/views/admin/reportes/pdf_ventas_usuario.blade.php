<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Reporte Ventas por Usuario y Fechas</title>
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
        <h2 style="width:100%; text-align:center">VENTAS POR USUARIO Y RANGO DE FECHAS </h2>
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
                    <td style="font-size:15px;" width="50%">  <strong> Usuario: </strong>{{{ $usuarios[0]->name }}}</td>
                    <td style="font-size:15px; text-align:right;" width="50%"> </td>
                </tr>
            </table>
            <hr>
            <table border="0" cellspacing=0 cellpadding=2 width= 800 class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th width=15%>Fecha</th>
                        <th width=50%>Producto</th>
                        <th width=15%>Cantidad</th>
                        <th width=20%>Imei</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $ed)
                    <tr>
                        <td style="font-size:13px; text-align:center;">{{Carbon\Carbon::parse($ed->fecha_ingreso)->format('d-m-Y')}}</td>
                        <td style="font-size:13px; text-align:center;">{{ $ed->id }} - {{ $ed->descripcion }}</td>
                        <td style="font-size:13px; text-align:center;">{{ $ed->cantidad }}</td>
                        <td style="font-size:13px; text-align:center;">{{ $ed->imei }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <br>
            <br>
            <br>
            <hr>
            <br>
            <h2 style="width:100%; text-align:center">RESUMEN DE VENTAS POR COMPAÑÍA </h2>
            <table border="0" cellspacing=0 cellpadding=2 width= 800 class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th width=20%>Compañía</th>
                        <th width=35%>Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($resumen as $res)
                    <tr>
                        <td style="font-size:13px; text-align:center;">{{ $res->compania }}</td>
                        <td style="font-size:13px; text-align:center;">{{ $res->total }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

</body>
</html>