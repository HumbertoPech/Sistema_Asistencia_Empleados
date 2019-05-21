    <!DOCTYPE html>
    <html>
    <?php
        session_start();
    ?>
    <head>
        <meta charset='utf-8'>
        <meta http-equiv='X-UA-Compatible' content='IE=edge'>
        <title>Sección de nóminas</title>
        <!--<meta name='viewport' content='width=device-width, initial-scale=1'>-->
        <script src="../../resources/libraries/nom_jquery.min.js"></script>
        <meta http-equiv="Content-Type" content="text/html; charset-UTF-8">
        <link rel='stylesheet' type='text/css' media='screen' href='../../resources/css/vista_nominas.css'>
    </head>
    <body onload="busqueda();">
        <div class="titulo">
            <h1>Administración de días festivos</h1>
        </div>
        <script type="text/javascript" src="../../resources/js/funciones_dias_festivos.js"></script>

        <div id="agregar_dia_festivo">
        <h4>Agregar nuevo dia festivo<h4>
            <label>
                <input type="date" name="fecha_entrada" id="fecha_entrada">
            </label>
                <button onclick="validarDiaFestivo();"> Agregar dia festivo</button>
        </div>
            

        <div class="botones">
            <table>
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


    
        <div id="datos">
    
        </div>  
    </body>
    </html>