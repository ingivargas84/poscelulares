<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Reporte de Proyecciones</title>
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

        <h2 style="width:100%; text-align:center">REPORTE DE PROYECCIONES </h2>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
            <table cellspacing=0 cellpadding=2 width= 800 class="table table-striped table-bordered">   
                <tr>
                    <td style="font-size:15px;" width="50%">  <strong> Tipo de Proyección: </strong> {{{ $tipo_proyeccion }}}</td>
                    <td style="font-size:15px; text-align:right;" width="50%">  <strong> Fecha: </strong> {{Carbon\Carbon::parse($fecha_inicial)->format('d-m-Y')}}</td>
                </tr>
               
            </table>
            <hr>
            <h2 style="width:100%; text-align:center">EN CONSTRUCCIÓN </h2>
            <hr>
        </div>
    </div>
</div>

</body>
</html>