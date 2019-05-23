<!DOCTYPE html>
<html>
<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>Sección de nóminas</title>
    <!--<meta name='viewport' content='width=device-width, initial-scale=1'>-->
    <script src="../../resources/libraries/nom_jquery.min.js"></script>
    <meta http-equiv="Content-Type" content="text/html; charset-UTF-8">
    <link rel='stylesheet' type='text/css' media='screen' href='../../resources/css/vista_nominas.css'>
<?php include("../../resources/html/header_admin_empleados.html");
?>
</head>

<body onload="busqueda();">
<div class="container-fluid">
<div id ="encabezado" class="row sticky-top bg-dark text-white shadow-sm">
                <div class="d-flex align-items-center col-2">
                    <a href="indexAdmin.html" ><button type="button" class="btn btn-primary">Regresar</button></a>
                </div>
                <div class="d-flex align-items-center col-10">
                    <h1 align="center">N&oacute;minas </h1>
                </div>
            </div>
    <div class="titulo">
        <h1>Sección de Nóminas</h1>
    </div>

    <div lass="col-md-8">
        <table class="table table-bordered">
            <tr>
                <td>
                    <button onclick="validarCalculoNominas();"> Calcular nómina semanal</button>
                </td>
                <div id="mensaje_de_exito">
                </div>
                    <button onclick="location.href='../../libs/generar_reporte_nominas.php'">Exportar nómina semanal a excel</button>
                </td>
            </tr>
        </table>
    </div>

    <div class="container p-4">

    <div class="row">
        <div class="colu-md5-6 mx-auto;">
            <div class = "class carrd body">
        
            </div>
            <p>
                <label>Buscar por fecha y nombre de empleado</label><br>
                <label>Fecha de comienzo: <input id="fecha_inicio" name="fecha_inicio" type="date"></input></label> &nbsp;&nbsp;&nbsp;&nbsp;  <br>                        
                <label>Fecha de término: <input id="fecha_fin" name="fecha_fin" type="date"></input></label>
            </p>
            <p>
                <input type="text" id="txtnom" name="txtnom" class="form-control" placeholder="Buscar empleado..." value="" onkeyup="busqueda();"></input>
            </p>
            <script type="text/javascript" src="../../resources/js/funciones_nomina_empleados.js"></script>

        </div>
        <button onclick="busquedaPorFecha();">Buscar</button>
    </div>
   </div>  


    <div id="datos">

    </div>
    <!--<div class="tabla-nominas">
        <table border="1">
            <thead>
                <th>Nombre de empleado</th>
                <th>Horas trabajadas</th>
                <th>Sueldo pagado</th>
                <th>Días festivos y vacaciones</th>
                <th>Fecha inicio de semana</th>
                <th>Fecha termino de semana</th>
                <th>Información de días de nómina</th>            
            </thead>
            <tbody>
                <tr>
                    <td>Ulises Ancona Graniel</td>
                    <td>5</td>
                    <td>18.5</td>
                    <td>8</td> 
                    <td>19/05/2019</td>
                    <td>29/05/2019</td>          
                    <td>Dia festivo 29/05/2019 <br> 
                        Dia vacacion 27/05/2019 <br>
                        Dia suspension 25/05/2019 <br>
                    </td>                                       
                </tr>                
            </tbody>
        </table>
    </div>-->
</div>
</body>
<?php require("../../resources/html/footer_admin_empleados.html");?>

</html>