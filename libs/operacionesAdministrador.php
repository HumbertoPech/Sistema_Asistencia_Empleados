<?php
/**
 * Las variables son pasadas mediante la variable global $_POST[] por el navegador,
 * entre estas variables se encuentra una llamada 'operacion', esta define que función es requerida
 * para generar una salida en formato JSON, que será leído por el navegador (mediante AJAX)
 */
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

/**
 * Comprueba la contraseña del administrador. Devuelve true si la contraseña recibida es
 * la misma que se encuentra en la BD.
 */
function comprobarContrasena(){
    require_once("../config/config.php");
    require_once(LIBS_PATH."consultas.php");
    $contrasenaRecibida = $_POST['contrasenaAdmin'];
    //ver si se encripta la contraseña
    $sql = "SELECT contrasena FROM administrador WHERE id = 1";
    $contrasenaAdmin=consultar($sql)['contrasena'];
    $resultado['resultado'] = false;
    if($contrasenaAdmin == $contrasenaRecibida){
        $resultado['resultado'] = true;
    }
    echo json_encode($resultado);
}

/**
 * Formatea los intentos de inicio de sesión de los usuarios a 0. Devuelve el número de
 * filas actualizadas en la bd.
 */
function resetIntentosUsuario(){
    require_once("../config/config.php");
    require_once(LIBS_PATH."consultas.php");
    $id_usuario = $_POST['id_usuario'];
    $sql = "UPDATE empleado_intentos SET numero_intentos = 0 WHERE id_empleado =" . $id_usuario;
    json_encode(actualizar($sql));
}

/**
 * Cambia el estado del empleaddo (de baja a activo, o viceversa), dependiendo de lo que fue enviado.
 * Devuelve las filas afectadas.
 */
function cambiarEstadoEmpleado(){
    require_once("../config/config.php");
    require_once(LIBS_PATH."consultas.php");
    $id_usuario = $_POST['id_usuario'];
    $estado_nuevo = $_POST['estado_nuevo'];
    $sql = "UPDATE empleados SET id_estado = (SELECT id FROM estados WHERE nombre = '$estado_nuevo') WHERE id =".$id_usuario;
    json_encode(actualizar($sql));
}

/**
 * Actualiza la información principal del empleado. 
 * Devuelve las filas afectadas.
 */
function actualizarInformacionEmpleado(){
    require_once("../config/config.php");
    require_once(LIBS_PATH."consultas.php");
    $id_usuario = $_POST['id_usuario'];
    $nombres = $_POST['nombres'];
    $apellidos = $_POST['apellidos'];
    $sueldo_base = $_POST['sueldo_base'];
    $direccion = $_POST['direccion'];
    $fecha_nacimiento = $_POST['fecha_nacimiento'];
    $sexo = $_POST['sexo'];
    $estado_civil = $_POST['estado_civil'];
    $curp = $_POST['curp'];
    $fecha_inicio = $_POST['fecha_inicio'];
    $sql = "UPDATE empleados SET nombres = '$nombres', apellidos = '$apellidos', sueldo_base = '$sueldo_base', direccion = '$direccion',".
    "fecha_nacimiento = '$fecha_nacimiento', sexo = '$sexo', estado_civil = '$estado_civil', curp = '$curp', fecha_inicio = '$fecha_inicio' WHERE id = ".$id_usuario;
    json_encode(actualizar($sql));
}

/**
 * Actualiza el horario del empleado, de acuerdo al día enviado.
 * Devuelve el número de filas afectadas.
 */
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

