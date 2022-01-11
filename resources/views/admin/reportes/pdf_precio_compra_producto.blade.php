<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Historial de Precio Compra por Producto</title>
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
        <h2 style="width:100%; text-align:center">HISTORIAL DE PRECIO COMPRA POR PRODUCTO </h2>

            <table cellspacing=0 cellpadding=2 width= 800 class="table table-striped table-bordered">   
                <tr>
                    <td style="font-size:15px;" width="90%">  <strong> Teléfono: </strong> {{{ $prods[0]->descripcion}}}</td>
                    <td style="font-size:15px; text-align:right;" width="10%"> </td>
                </tr>
                <tr>
                    <td style="font-size:15px;" width="90%"> El precio Q {{{ $precio_mayor[0]->precio_compra}}} se ha usado para comprar por {{{ $precio_mayor[0]->cantidad}}} veces, la última se realizó el {{Carbon\Carbon::parse($fecha_mayor[0]->fecha_ingreso)->format('d-m-Y')}}  </td>
                    <td style="font-size:15px; text-align:right;" width="10%"> </td>
                </tr>
            </table>
            <hr>
            <table border="0" cellspacing=0 cellpadding=2 width= 800 class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th width=30%>Fecha Compra</th>
                        <th width=40%>Proveedor</th>
                        <th width=20%>Precio de Compra</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $total = 0; ?>
                    <?php $num = 0; ?>

                    @foreach ($data as $ed)
                    <tr>
                        <td style="font-size:13px; text-align:center;">{{Carbon\Carbon::parse($ed->fecha_factura)->format('d-m-Y')}}</td>
                        <td style="font-size:13px; text-align:center;">{{ $ed->nombre_comercial }}</td>
                        <td style="font-size:13px; text-align:center;">Q. {{number_format((float) $ed->precio_compra, 2) }}</td>
                    </tr>

                    <?php
                        $total = $total + $ed->precio_compra;
                        $num = $num + 1;
                    ?>
                    @endforeach
                </tbody>
            </table>
            <br>
            <table cellspacing=0 cellpadding=2 width= 800 class="table table-striped table-bordered">   
                <tr>
                    <td style="font-size:15px;" width="50%">  <strong> </strong></td>
                    <td style="font-size:17px; text-align:right;" width="50%"> <strong> Precio Promedio de Compra: </strong>Q. <?php echo number_format($total/$num, 2, ".", ","); ?> </td>
                </tr>
            </table>
        </div>
    </div>
</div>

</body>
</html>