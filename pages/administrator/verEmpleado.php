<?php
//require_once("../../config/config.php");
//require_once ( $_SERVER['DOCUMENT_ROOT'].'/Sistema_Asistencia_Empleados/libs/consultas.php');
//require_once("../../libs/consultas.php");

require_once("../../config/config.php");
require_once(LIBS_PATH."consultas.php");
$id_empleado = $_GET['id_empleado'];
$data = consultar("SELECT * FROM empleados where id = ".$id_empleado);
//$xs = consultar("SELECT * FROM horarios where id_empleado = 1");
//var_dump($data);
//var_dump($xs);
?>

<!DOCTYPE html>
<html lang="es-MX">
    <head>

        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    </head>
    <body onload="deshabilitarTodo()">
        <div class="container-fluid ">
            <div id ="encabezado" class="row sticky-top bg-dark text-white shadow-sm">
                <div class="d-flex align-items-center col-2">
                    <button type="button" class="btn btn-primary">Regresar</button>
                </div>
                <div class="d-flex align-items-center col-10">
                    <h1 align="center">Ver empleado </h1>
                </div>
            </div>
            <div class = "row">
                <div class="bd-highlight col-md-2"></div>
                <div id="informacion_empleado" class=" col-md-8  bd-highlight shadow-sm p-3 mb-5 bg-white rounded">
                    <h2 align="left">Informaci&oacute;n del empleado</h2>
                    <form id="formularioInformacion" name = "formularioInfo">
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <input type="hidden" id="id_usuario" name="id_usuario" value="<?=$data["id"]?>">
                                <label for="inputNombres">Nombre(s)</label>
                                <input type="text" class="form-control inputsInformacionPersonal" name="nombres" id="inputNombres" placeholder="Nombres(s)" value="<?=$data["nombres"]?>">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="inputApellidos">Apellido(s)</label>
                                <input type="text" class="form-control inputsInformacionPersonal" name="apellidos" id="inputApellidos" placeholder="Apellidos(s)" value="<?=$data["apellidos"];?>">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-2">
                                <label for="inputSexo">Sexo</label>
                                <select id="inputSexo" class="form-control inputsInformacionPersonal" name="sexo">
                                    <option valued = "<?=$data["sexo"];?>" selected><?=$data["sexo"];?></option>
                                    <option value="Hombre">Hombre</option>
                                    <option value="Mujer">Mujer</option>
                                </select>
                            </div>
                            <div class="form-group col-md-2">
                                <label for="inputEstadoCivil">Estado civil</label>
                                <select id="inputEstadoCivil" class="form-control inputsInformacionPersonal" name="estado_civil">
                                    <option valued="<?=$data["estado_civil"];?>" selected><?=$data["estado_civil"];?></option>
                                    <option value="Soltero">Soltero</option>
                                    <option value="Casado">Casado</option>
                                    <option value="Viudo">Viudo</option>
                                    <option value="Divorciado">Divorciado</option>
                                </select>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="inputFechaNac">Fecha de nacimiento</label>
                                <input type="date" class="form-control inputsInformacionPersonal" name="fecha_nacimiento" id="inputFechaNac" placeholder="" value="<?=$data["fecha_nacimiento"];?>" min="1939-01-01" max="2001-12-31">
                            </div>
                            <div class="form-group col-md-5">
                                <label for="inputCurp">CURP</label>
                                <input type="text" class="form-control inputsInformacionPersonal" name="curp" id="inputCurp" placeholder="CURP" value="<?=$data["curp"];?>">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-8">
                                <label for="inputDireccion">Direcci&oacute;n</label>
                                <input type="text" class="form-control inputsInformacionPersonal" name="direccion" id="inputDireccion" placeholder="Direcci&oacute;n" value="<?= $data["direccion"];?>">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="inputSueldo">Sueldo base</label>
                                <input type="number" class="form-control inputsInformacionPersonal" name="sueldo_base" id="inputSueldo" placeholder="0" value="<?= $data["sueldo_base"];?>">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6"></div>
                            <div class="form-group col-md-2">
                                <label for="inputFechaInicio">Fecha inicio</label>
                                <input type="date" class="form-control inputsInformacionPersonal" name="fecha_inicio" id="inputFechaInicio" placeholder="" value="<?=$data["fecha_inicio"];?>">
                            </div>
                            <div class="form-group col-md-2">
                                <label for="inputUsuario">Usuario</label>
                                <input type="text" class="form-control" name="usuario" id="inputUsuario" placeholder="Usuario" value="<?=$data["usuario"]?>" readonly>
                            </div>
                            <div class="form-group col-md-2">
                                <label for="inputContrasena">Contrase&ntilde;a</label>
                                <input type="password" class="form-control" name="contrasena" id="inputContrasena" placeholder="Contrase&ntilde;a" value="<?=$data["contrasena"];?>" readonly>
                                <button type="button" class="btn btn-info float-right" style="margin-top:.2em;" id= "verContrasenaUs" onClick="verContrasena()">Ver</button>
                            </div>   
                        </div>
                        <div class="form-row justify-content-center">
                            <button type="button" class="btn btn-primary btn-md" id="botonGuardarInformacion" disabled onClick = "actualizarInformacionEmpleado()">Guardar</button>
                            <button type="reset" class="btn btn-secondary btn-md" id="botonCancelarInformacion" onClick="intercambiarOpciones(this)" style="display:none; margin-left:.8em;">Cancelar</button>
                        </div>
                    </form>
                </div>
                <div class=" bd-highlight col-md-2" style="margin-bottom:5em;">
                    <button type="button" class="btn btn-danger" id="botonEditarInformacion" onClick="intercambiarOpciones(this)">Editar</button>
                    
                </div>
            </div>
            <div class = "row">
                <div class="bd-highlight col-md-2"></div>
                <div id="horario_empleado" class=" col-md-8  bd-highlight shadow-sm p-3 mb-5 bg-white rounded">
                    <h2 align="left">Horario del empleado</h2>
                    <form>
                        <div class="col-lg-12" style="padding-left:0;">
                            <table class="table table-striped table-responsive-sm">
                                <thead>
                                    <tr>
                                        <th scope="col"></th>
                                        <th scope="col">Lunes</th>
                                        <th scope="col">Martes</th>
                                        <th scope="col">Mi&eacute;rcoles</th>
                                        <th scope="col">Jueves</th>
                                        <th scope="col">Viernes</th>
                                    </tr>
                                </thead>
                                <tbody>
                                        <?php
                                            $dias_de_la_semana = array("Lunes", "Martes","Miercoles","Jueves","Viernes");
                                            //Optimizar
                                            mostrarHorario("Hora entrada","hora_entrada");
                                            mostrarHorario("Hora salida","hora_salida");
                                            
                                            function mostrarHorario($tipo,$nombre_bd){
                                                global $dias_de_la_semana, $contador, $id_empleado;
                                                $contador = 0;
                                                echo "<tr><th scope='row'>$tipo</th>";   
                                                foreach($dias_de_la_semana as $dia){
                                                    $query = "SELECT * FROM horarios WHERE id_empleado =".$id_empleado." AND dia = '$dia'";
                                                    $informacion_dia = consultar($query);
                                                    //$name = $nombre_bd.":".$dia;
                                                    $name = $nombre_bd.$contador;
                                                    //<div class="invalid-feedback">You must agree before submitting.</div>
                                                    echo "<td> <input onchange=checarHora('$nombre_bd',$contador,'$dia') type='time' class='form-control inputsHorarioPersonal' name='$name' id='$name' value=".$informacion_dia["$nombre_bd"].">";
                                                    if($nombre_bd=="hora_salida"){
                                                        echo "<div class ='invalid-feedback' id='invalid-feedback-".$dia."'>Horario no permitido. Checarlo.</div>";
                                                    }   
                                                    echo "</td>";
                                                    $contador++;                            
                                                }
                                                echo "</tr>";
                                            }
                                        ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="form-row justify-content-center">
                                <button type="button" class="btn btn-primary btn-md" id="botonGuardarHorario" disabled onClick="actualizarHorarioEmpleado()">Guardar</button>
                                <button type="reset" class="btn btn-secondary btn-md" id="botonCancelarHorario" onClick="intercambiarOpciones(this)" style="display:none; margin-left:.8em;">Cancelar</button>
                        </div>
                    </form>
                </div>
                <div class="bd-highlight col-md-2" style="margin-bottom:4em;">
                    <button type="button" class="btn btn-danger" id="botonEditarHorario" onClick="intercambiarOpciones(this)">Editar</button>
                </div>
            </div>
            <div class="d-flex justify-content-center fixed-bottom bg-dark text-white shadow-sm">
                <div class="p-2" id="botonIntentos">
                    <?php
                        $query = "SELECT numero_intentos FROM empleado_intentos WHERE id_empleado=".$data['id'];
                        $empleadoIntentos = consultar($query);
                        if($empleadoIntentos['numero_intentos']>=3){
                            echo '<button  type="button" class="btn btn-secondary" onClick="resetIntentosUsuario(this)">Reset Intentos</button>';
                        }else{
                            echo '<button  type="button" class="btn btn-secondary" disabled>Reset Intentos</button>';
                        }
                    ?>
                     
                </div>
                <div class="p-2" id="botonEstado">
                    <?php
                    //cambiar -> usar método JavasScript: Con un input hidden en que estado está
                        $query = "SELECT nombre FROM estados WHERE id =". $data['id_estado'];
                        $estado = consultar($query);
                        if($estado['nombre']=="activo"){
                            echo "<button type='button' name = 'baja' id = 'baja' class='btn btn-danger' onClick = 'cambiarEstadoEmpleado("."activo".","."baja".")'>Dar de baja</button>";
                            echo "<button type='button' name = 'activo' id = 'activo' class='btn btn-success' style='display:none;' onClick = 'cambiarEstadoEmpleado("."baja".","."activo".")'>Activar</button>";
                        }else if($estado['nombre']=="baja"){
                            echo "<button type='button' name = 'baja' id = 'baja' class='btn btn-danger'  style='display:none;' onClick = 'cambiarEstadoEmpleado("."activo".","."baja".")'>Dar de baja</button>";
                            echo "<button type='button' name = 'activo' id = 'activo' class='btn btn-success'' onClick = 'cambiarEstadoEmpleado("."baja".","."activo".")'>Activar</button>";
                        }                  
                    ?>
                </div>
                
            </div>
        </div>
    </body>
    <!--El código JavaScript utilizado esta en el archivo siguiente-->
    <script src="../../resources/js/administradorVerEmpleado.js"></script>
</html>