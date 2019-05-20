<?php
if(isset($_POST['operacion'])){
    switch ($_POST['operacion']) {
        case 'comprobarContrasena':
            comprobarContrasena();
            break;
        case 'resetIntentosEmpleado':
            resetIntentosUsuario();
            break;
        case 'cambiarEstadoEmpleado':
            cambiarEstadoEmpleado();
            break;
        case 'actualizarInformacionEmpleado':
            actualizarInformacionEmpleado();
            break;
        case 'actualizarHorarioEmpleado':
            actualizarHorarioEmpleado();
            break;
        default:
            break;
    }
}

function comprobarContrasena(){
    require_once("../config/config.php");
    require_once(LIBS_PATH."consultas.php");
    $contrasenaRecibida = $_POST['contrasenaAdmin'];
    //ver si se encripta la contraseña
    $sql = "SELECT contrasena FROM administrador WHERE id = 1";
    $contrasenaAdmin=consultar($sql)[0]['contrasena'];
    $resultado['resultado'] = false;
    if($contrasenaAdmin == $contrasenaRecibida){
        $resultado['resultado'] = true;
    }
    echo json_encode($resultado);
}

function resetIntentosUsuario(){
    require_once("../config/config.php");
    require_once(LIBS_PATH."consultas.php");
    $id_usuario = $_POST['id_usuario'];
    $sql = "UPDATE empleado_intentos SET numero_intentos = 0 WHERE id_empleado =" . $id_usuario;
    json_encode(actualizar($sql));
}

function cambiarEstadoEmpleado(){
    require_once("../config/config.php");
    require_once(LIBS_PATH."consultas.php");
    $id_usuario = $_POST['id_usuario'];
    $estado_nuevo = $_POST['estado_nuevo'];
    $sql = "UPDATE empleados SET id_estado = (SELECT id FROM estados WHERE nombre = '$estado_nuevo') WHERE id =".$id_usuario;
    json_encode(actualizar($sql));
}

function actualizarInformacionEmpleado(){
    require_once("../config/config.php");
    require_once(LIBS_PATH."consultas.php");
    $id_usuario = $_POST['id_usuario'];
    $nombres = $_POST['nombres'];
    $apellidos = $_POST['apellidos'];
    $sueldo_base = $_POST['sueldo_base'];
    $direccion = $_POST['direccion'];
    $sexo = $_POST['sexo'];
    $estado_civil = $_POST['estado_civil'];
    $curp = $_POST['curp'];
    $fecha_inicio = $_POST['fecha_inicio'];
    $sql = "UPDATE empleados SET nombres = '$nombres', apellidos = '$apellidos', sueldo_base = '$sueldo_base', direccion = '$direccion',".
    "sexo = '$sexo', estado_civil = '$estado_civil', curp = '$curp', fecha_inicio = '$fecha_inicio' WHERE id = ".$id_usuario;
    json_encode(actualizar($sql));
}

function actualizarHorarioEmpleado(){
    require_once("../config/config.php");
    require_once(LIBS_PATH."consultas.php");
    $id_usuario = $_POST['id_usuario'];
    $dia = $_POST['dia'];
    $hora_entrada = $_POST['hora_entrada'];
    $hora_salida = $_POST['hora_salida'];
    $sql = "UPDATE horarios SET hora_entrada = '$hora_entrada', hora_salida = '$hora_salida' WHERE id_empleado = ". $id_usuario ." AND dia = '$dia'";
    json_encode(actualizar($sql));      
}

