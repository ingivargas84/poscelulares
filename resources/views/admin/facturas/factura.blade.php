<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Factura</title>
    <link rel="stylesheet" type="text/css" href="/public/style.css">
    <style>
        .table {
            width: 350px;
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
        .footer {
            position: fixed;
            left: 0;
            bottom: 225;
            width: 100%;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
       <div class="row">
        <div class="col-md-12">
            <table cellspacing=0 cellpadding=2 width= 350 class="table table-striped table-bordered">
                <tr>
                    <td style="font-size:15px; text-align:left;" width="80%"> {{Carbon\Carbon::parse($factura[0]->fecha_factura)->format('d-m-Y')}} </td>
                </tr>
            </table>
            <table cellspacing=0 cellpadding=2 width= 350 class="table table-striped table-bordered">
                <tr>
                    <td style="font-size:15px; text-align:left;" width="100%"> {{{ $factura[0]->nombre_factura }}}  </td>
                </tr>
                <tr>
                    <td style="font-size:15px; text-align:right;" width="100%"> {{{ $factura[0]->nit }}}  </td>
                </tr>
                <tr>
                    <td style="font-size:15px; text-align:center;" width="100%"> {{{ $factura[0]->direccion }}}  </td>
                </tr>
            </table>

            <table border="0" cellspacing=0 cellpadding=2 width=350  class="table table-striped table-bordered">
                <tbody>
                    @foreach ($facturadetalle as $fd)
                    <tr>
                        <td style="font-size:12px; text-align:center;">{{ $fd->cantidad }}</td>
                        <td style="font-size:12px; text-align:left;"> {{ $fd->descripcion}}</td>
                        <td style="font-size:12px; text-align:right;">{{{number_format((float) $fd->subtotal, 2) }}}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="footer">
    <table cellspacing=0 cellpadding=2 width= 350 class="table table-striped table-bordered">
          <tr>
             <td style="font-size:14px; text-align:right;" width="100%"> {{{number_format((float) $factura[0]->total, 2) }}} </td>
          </tr>
    </table>

</div>
</body>
</html>
