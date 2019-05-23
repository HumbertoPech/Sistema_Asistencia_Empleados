<?php
require '../core/conexion.php';
require '../libs/operacionesAdmin.php';

$conector = new Conexion();
$mysqli= $conector ->get_conexion();
sleep(2);
$nombres=$_POST['nombres'];
$apellidos=$_POST['apellidos'];
$fechanac=$_POST['fechanac'];
$direccion=$_POST['direccion'];
$sueldo=$_POST['sueldo'];
$sexo=$_POST['sexo'];
$estadocivil=$_POST['estadocivil'];
$curp=$_POST['curp'];
$fecha_inicio=$_POST['fechainicio'];
$contrasena=generador_contrasena();
$id_estado=1;
$usuario=generador_usuario($nombres,$apellidos);
$horario_entrada_lunes=$_POST['horas-entrada-lunes'] . ':' . $_POST['minutos-entrada-lunes'];
$horario_salida_lunes=$_POST['horas-salida-lunes'] . ':' . $_POST['minutos-salida-lunes'];
$horario_entrada_martes=$_POST['horas-entrada-martes'] . ':' . $_POST['minutos-entrada-martes'];
$horario_salida_martes=$_POST['horas-salida-martes'] . ':' . $_POST['minutos-salida-martes'];
$horario_entrada_miercoles=$_POST['horas-entrada-miercoles'] . ':' . $_POST['minutos-entrada-miercoles'];
$horario_salida_miercoles=$_POST['horas-salida-miercoles'] . ':' . $_POST['minutos-salida-miercoles'];
$horario_entrada_jueves=$_POST['horas-entrada-jueves'] . ':' . $_POST['minutos-entrada-jueves'];
$horario_salida_jueves=$_POST['horas-salida-jueves'] . ':' . $_POST['minutos-salida-jueves'];
$horario_entrada_viernes=$_POST['horas-entrada-viernes'] . ':' . $_POST['minutos-entrada-viernes'];
$horario_salida_viernes=$_POST['horas-salida-viernes'] . ':' . $_POST['minutos-salida-viernes'];

$array_datos=array(
    'nombre'=>$nombres,
    'apellidos'=>$apellidos,
    'fechanac'=>$fechanac,
    'direccion'=>$direccion,
    'sueldo'=>$sueldo,
    'sexo'=>$sexo,
    'estadocivil'=>$estadocivil,
    'curp'=>$curp,
    'horarioentradalunes'=>$horario_entrada_lunes,
    'horariosalidalunes'=>$horario_salida_lunes,
    'horarioentradamartes'=>$horario_entrada_martes,
    'horariosalidamartes'=>$horario_salida_martes,
    'horarioentradamiercoles'=>$horario_entrada_miercoles,
    'horariosalidamiercoles'=>$horario_salida_miercoles,
    'horarioentradajueves' => $horario_entrada_jueves, 
    'horariosalidajueves'=>$horario_salida_jueves,
    'horarioentradaviernes'=>$horario_entrada_viernes,
    'horariosalidaviernes'=>$horario_salida_viernes,
    'fechainicio'=>$fecha_inicio
);
$usuarios= $mysqli->query("SELECT nombres, apellidos FROM empleados
WHERE curp= '".$curp."' AND usuario= '".$usuario."' ");
if($usuarios->num_rows ==0){

    $sqlregistro="INSERT INTO empleados (nombres, apellidos, usuario,contrasena,sueldo_base,id_estado,direccion,fecha_nacimiento,sexo,estado_civil,curp,fecha_inicio) VALUES ('$nombres', '$apellidos', '$usuario', '$contrasena','$sueldo','$id_estado','$direccion','$fechanac','$sexo','$estadocivil','$curp','$fecha_inicio')";

    $mysqli->query($sqlregistro);

    $usuarios= $mysqli->query("SELECT id FROM empleados
    WHERE curp= '".$curp."' ");

    $datos=$usuarios->fetch_assoc();
    $id_registro=$datos['id'];
    $sqlsesion="INSERT INTO empleado_intentos (id_empleado,estado,numero_intentos) VALUES ('$id_registro',1,0)";
    $mysqli->query($sqlsesion);
    $sql_horario_lunes="INSERT INTO horarios (id_empleado,dia,hora_entrada,hora_salida) VALUES ('$id_registro','Lunes','$horario_entrada_lunes','$horario_salida_lunes')";
    $sql_horario_martes="INSERT INTO horarios (id_empleado,dia,hora_entrada,hora_salida) VALUES ('$id_registro','Martes','$horario_entrada_martes','$horario_salida_martes')";
    $sql_horario_miercoles="INSERT INTO horarios (id_empleado,dia,hora_entrada,hora_salida) VALUES ('$id_registro','Miercoles','$horario_entrada_miercoles','$horario_salida_miercoles')";
    $sql_horario_jueves="INSERT INTO horarios (id_empleado,dia,hora_entrada,hora_salida) VALUES ('$id_registro','Jueves','$horario_entrada_jueves','$horario_salida_jueves')";
    $sql_horario_viernes="INSERT INTO horarios (id_empleado,dia,hora_entrada,hora_salida) VALUES ('$id_registro','Viernes','$horario_entrada_viernes','$horario_salida_viernes')";
    $mysqli->query($sql_horario_lunes);
    $mysqli->query($sql_horario_martes);
    $mysqli->query($sql_horario_miercoles);
    $mysqli->query($sql_horario_jueves);
    $mysqli->query($sql_horario_viernes);   
    echo json_encode(array('error' =>false,'user' =>$usuario, 'password'=>$contrasena,'datosUsuario'=>$array_datos));
}
else{
    echo json_encode(array('error' =>true));
}
$mysqli->close();




?>