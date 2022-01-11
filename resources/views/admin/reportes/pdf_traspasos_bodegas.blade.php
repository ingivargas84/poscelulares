<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Traspasos entre Bodegas</title>
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
       <div class="row">
        <div class="col-md-12">

        <table class="table table-striped table-bordered" border="1" cellspadding=2>
            <tr>
                <td style="width:100%; text-align:center; font-size:25px" colspan=2><strong>TIENDAS MELANY</strong></td>
            </tr>
        </table>
        <h2 style="width:100%; text-align:center">TRASPASOS ENTRE BODEGAS ENTRE FECHAS </h2>

            <table cellspacing=0 cellpadding=2 width= 800 class="table table-striped table-bordered">   
                <tr>
                    <td style="font-size:15px;" width="50%"> </td>
                    <td style="font-size:15px; text-align:right;" width="50%"> <strong> Del </strong> {{{Carbon\Carbon::parse($fecha_inicial)->format('d-m-Y')}}}  <strong> Al </strong> {{{Carbon\Carbon::parse($fecha_final)->format('d-m-Y')}}} </td>
                </tr>
            </table>
            <hr>
            <table border="0" cellspacing=0 cellpadding=2 width= 800 class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th width=10%>Fecha</th>
                        <th width=15%>Bodega Origen</th>
                        <th width=15%>Bodega Destino</th>
                        <th width=15%>Usuario</th>
                        <th width=25%>Producto</th>
                        <th width=10%>Cantidad</th>
                        <th width=10%>IMEI</th>
                        
                    </tr>
                </thead>
                <tbody>
                
                    @foreach ($data as $ed)
                    <tr>
                        <td style="font-size:12px; text-align:center;">{{Carbon\Carbon::parse($ed->fecha)->format('d-m-Y')}}</td>
                        <td style="font-size:12px; text-align:center;">{{ $ed->origen }}</td>
                        <td style="font-size:12px; text-align:center;">{{ $ed->destino }}</td>
                        <td style="font-size:12px; text-align:center;">{{ $ed->usuario }}</td>
                        <td style="font-size:12px; text-align:center;">{{ $ed->descripcion }}</td>
                        <td style="font-size:12px; text-align:center;">{{ $ed->cantidad }}</td>
                        <td style="font-size:12px; text-align:center;">{{ $ed->imei }}</td>
                    </tr>

                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

</body>
</html>