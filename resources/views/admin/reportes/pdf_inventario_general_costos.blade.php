<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Inventario General Costos</title>
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
        <h2 style="width:100%; text-align:center">INVENTARIO GENERAL CON COSTOS </h2>

            <table cellspacing=0 cellpadding=2 width= 800 class="table table-striped table-bordered">   
                <tr>
                    <td style="font-size:15px;" width="70%">  <strong> Fecha de Generación de Reporte: </strong> {{{Carbon\Carbon::parse($fecha)->format('d-m-Y H:m:s')}}}</td>
                    <td style="font-size:15px; text-align:right;" width="30%"> <strong> Usuario: </strong> {{{$usuario}}} </td>
                </tr>
                @if ($tienda == "default")
                <tr>
                    <td style="font-size:15px;" width="70%">  <strong> Todas las tiendas </strong></td>
                    <td style="font-size:15px; text-align:right;" width="30%"> </td>
                </tr>
                @else
                <tr>
                    <td style="font-size:15px;" width="70%">  <strong> Tienda: {{{$tiendas[0]->tienda}}} </strong></td>
                    <td style="font-size:15px; text-align:right;" width="30%"> </td>
                </tr>
                @endif
            </table>
            <hr>
            <table border="0" cellspacing=0 cellpadding=2 width= 800 class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th width=10%>Id</th>
                        <th width=35%>Producto</th>
                        <th width=15%>Existencias</th>
                        <th width=20%>Precio</th>
                        <th width=20%>Subtotal</th>
                        
                    </tr>
                </thead>
                <tbody>

                    <?php $total = 0; ?>

                    @foreach ($data as $ed)
                    <tr>
                        <td style="font-size:12px; text-align:center;">{{ $ed->id }}</td>
                        <td style="font-size:12px; text-align:center;">{{ $ed->descripcion }}</td>
                        <td style="font-size:12px; text-align:center;">{{ $ed->existencias }}</td>
                        <td style="font-size:12px; text-align:right;">Q. {{number_format((float) $ed->precio, 2) }}</td>
                        <td style="font-size:12px; text-align:right;">Q. {{number_format((float) $ed->existencias * $ed->precio, 2) }}</td>
                    </tr>

                    <?php
                        $total = $total + ($ed->existencias * $ed->precio);
                    ?>

                    @endforeach
                </tbody>
            </table>
            <br>
            <table cellspacing=0 cellpadding=2 width= 800 class="table table-striped table-bordered">   
                <tr>
                    <td style="font-size:15px;" width="50%">  <strong> </strong></td>
                    <td style="font-size:17px; text-align:right;" width="50%"> <strong> Total: </strong>Q. <?php echo number_format($total, 2, ".", ","); ?> </td>
                </tr>
            </table>
        </div>
    </div>
</div>

</body>
</html>