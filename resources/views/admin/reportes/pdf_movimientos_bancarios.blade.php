<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Detalle de Movimientos Bancarios</title>
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
            <h2 style="width:100%; text-align:center">DETALLE DE MOVIMIENTOS BANCARIOS </h2>

            <br>
            <table cellspacing=0 cellpadding=2 width= 800 class="table table-striped table-bordered">   
                <tr>
                @if ( $tienda == "default")
                    <td style="font-size:15px;" width="50%">  <strong> Tienda: </strong> Todas las tiendas</td>
                @else
                    <td style="font-size:15px;" width="50%">  <strong> Tienda: </strong> {{{ $tiendas[0]->tienda}}}</td>
                @endif

                @if ( $usuario == "default")
                    <td style="font-size:15px; text-align:right;" width="50%">  <strong> Usuario: </strong> Todos los Usuarios</td>
                @else
                    <td style="font-size:15px; text-align:right;" width="50%">  <strong> Usuario: </strong> {{{ $usuarios[0]->name}}}</td>
                @endif
                </tr>
                <tr>
                    <td style="font-size:15px;" width="50%"> <strong> Fecha Inicio: </strong> {{{Carbon\Carbon::parse($fecha_inicial)->format('d-m-Y')}}} </td>
                    <td style="font-size:15px; text-align:right;" width="50%"> <strong> Fecha Final: </strong> {{{Carbon\Carbon::parse($fecha_final)->format('d-m-Y')}}} </td>
                </tr>
            </table>
            <hr>
            <table border="0" cellspacing=0 cellpadding=2 width= 800 class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th width=15%>Tienda</th>
                        <th width=10%>Usuario</th>
                        <th width=10%>Fecha</th>
                        <th width=10%>Banco</th>
                        <th width=10%>Transacción</th>
                        <th width=15%>Monto Favor</th>
                        <th width=15%>Monto</th>
                        <th width=15%>Monto Cobrado</th>
                    </tr>
                </thead>
                <tbody>

                <?php $total = 0; $favor = 0; $monto = 0 ?>

                    @foreach ($trans_bancos as $ed)
                    <tr>
                        <td style="font-size:12px; text-align:left;">{{$ed->tienda}}</td>
                        <td style="font-size:12px; text-align:left;">{{$ed->name}}</td>
                        <td style="font-size:12px; text-align:center;">{{Carbon\Carbon::parse($ed->fecha_transaccion)->format('d-m-Y')}}</td>
                        <td style="font-size:12px; text-align:center;">{{ $ed->banco }}</td>
                        <td style="font-size:12px; text-align:center;">{{ $ed->tipo_transaccion }}</td>
                        <td style="font-size:12px; text-align:right;">Q. {{{number_format((float) $ed->monto_favor, 2) }}}</td>
                        <td style="font-size:12px; text-align:right;">Q. {{{number_format((float) $ed->monto_total, 2) }}}</td>
                        <td style="font-size:12px; text-align:right;">Q. {{{number_format((float) $ed->monto_total + $ed->monto_favor, 2) }}}</td>
                    </tr>

                    <?php
                        $total = $total + ($ed->monto_total + $ed->monto_favor);
                        $favor = $favor + ($ed->monto_favor);
                        $monto = $monto + ($ed->monto_total);
                    ?>
                    @endforeach
                </tbody>
            </table>
            <br>
            <table cellspacing=0 cellpadding=2 width= 800 class="table table-striped table-bordered">   
                <tr>
                    <td style="font-size:15px; text-align:right;" width="54%"><strong> Totales: </strong></td>
                    <td style="font-size:12px; text-align:right;" width="15%"> <strong> Q. <?php echo number_format($favor, 2, ".", ","); ?></strong>  </td>
                    <td style="font-size:12px; text-align:right;" width="16%"> <strong> Q. <?php echo number_format($monto, 2, ".", ","); ?> </strong>  </td>
                    <td style="font-size:12px; text-align:right;" width="15%"> <strong> Q. <?php echo number_format($total, 2, ".", ","); ?>  </td>
                </tr>
            </table>
            
        </div>
    </div>
</div>

</body>
</html>
