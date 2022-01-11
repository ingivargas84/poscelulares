<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Listado de Teléfonos por imei en bodega</title>
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
        body { 
            background-image: url("./images/fondo4.png"); 
            background-repeat: no-repeat; 
        }
        .footer {
            position: fixed;
            left: 0;
            bottom: 160;
            width: 100%;
            text-align: center;
        }
                
    </style>
</head>
<body>
    <div class="container">
       <div class="row">
        <div class="col-md-12">
        
        <table class="table table-striped table-bordered" border="0" cellspadding=2>
            <tr>
            <td  style="text-align:left;">
            </td>
            </tr>
        </table>
        <br>
        <h2 style="width:100%; text-align:center">LISTADO DE IMEIS EN BODEGA </h2>
        <br>
        <br>
        <br>
        <br>
        <br>
        

            <table cellspacing=0 cellpadding=2 width= 800 class="table table-striped table-bordered">   
                <tr>
                    <td style="font-size:15px;" width="70%">  <strong> Teléfono: </strong> {{{ $prods[0]->descripcion}}}</td>
                    <td style="font-size:15px; text-align:right;" width="30%"> <strong> Total en Bodega: </strong> {{{ $total[0]->total}}} </td>
                </tr>
                <tr>
                    <td style="font-size:15px;" colspan=2 width="100%"> Reporte generado el {{{Carbon\Carbon::parse($fecha)->format('d-m-Y')}}} a las {{{Carbon\Carbon::parse($fecha)->format('H:m:s')}}} horas</td>
                    
                </tr>
            </table>
            <hr>
            <table border="0" cellspacing=0 cellpadding=2 width= 800 class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th width=40%>IMEI</th>
                        <th width=20%>Bodega</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $ed)
                    <tr>
                        <td style="font-size:13px; text-align:center;">{{$ed->imei}}</td>
                        <td style="font-size:13px; text-align:center;">{{ $ed->bodega }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            
        </div>
    </div>
</div>

</body>
</html>