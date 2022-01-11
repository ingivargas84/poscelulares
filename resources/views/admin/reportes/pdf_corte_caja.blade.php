<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Corte de Caja</title>
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

        <br>
        <h2 style="width:100%; text-align:center">CORTE DE CAJA </h2>
        <br>
        <br>
        <br>
        <br>
        <br>
            <table cellspacing=0 cellpadding=2 width= 800 class="table table-striped table-bordered">   
                <tr>
                    <td style="font-size:15px;" width="50%">  <strong> Tienda: </strong>  {{{ $tiendas[0]->tienda }}}</td>
                    <td style="font-size:15px; text-align:right;" width="50%"> <strong> Fecha: </strong> {{{Carbon\Carbon::parse($fecha)->format('d-m-Y')}}} </td>
                </tr>
            </table>
            <hr>
            <br>
            <br>
            <br>
            <br>
            <table cellspacing=0 cellpadding=2 width= 800 class="table table-striped table-bordered">   
                <tr>
                    <td style="font-size:17px;" width="70%">  <strong>(+) Total Ventas del Día: </strong> </td>
                    <td style="font-size:17px; text-align:right;" width="30%"> Q. {{{number_format((float) $total_venta[0]->total, 2) }}}  </td>
                </tr>
                <tr>
                    <td style="font-size:17px;" width="70%">  <strong>(-) Gastos del Día: </strong> </td>
                    <td style="font-size:17px; text-align:right; border-bottom: 1px solid #000205;" width="30%"> Q. {{{number_format((float) $total_gastos[0]->total, 2) }}}  </td>
                </tr>
                <tr>
                    <td style="font-size:17px;" width="70%">  <strong>(*) Saldo en Caja (Según Sistema): </strong> </td>
                    <td style="font-size:17px; text-align:right; border-bottom: 1px double #000205;" width="30%"> Q. {{{number_format((float) $saldo_caja, 2) }}}  </td>
                </tr>
            </table>
            
        </div>
    </div>
</div>

</body>
</html>