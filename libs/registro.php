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
$contrasena=generador_contrasena();
//$contrasena_encriptada=password_hash($contrasena,PASSWORD_DEFAULT);
$id_estado=1;
$usuario=generador_usuario($nombres,$apellidos);




$usuarios= $mysqli->query("SELECT nombres, apellidos FROM empleados
WHERE curp= '".$curp."' AND usuario= '".$usuario."' ");

if($usuarios->num_rows ==0){
    $sqlregistro="INSERT INTO empleados (nombres, apellidos, usuario,contrasena,sueldo_base,id_estado,direccion,fecha_nacimiento,sexo,estado_civil,curp) VALUES ('$nombres', '$apellidos', '$usuario', '$contrasena','$sueldo','$id_estado','$direccion','$fechanac','$sexo','$estadocivil','$curp')";
    $mysqli->query($sqlregistro);
    $usuarios= $mysqli->query("SELECT id FROM empleados
    WHERE curp= '".$curp."' ");
    $datos=$usuarios->fetch_assoc();
    $id_registro=$datos['id'];
    $sqlsesion="INSERT INTO empleado_intentos (id_empleado,estado,numero_intentos) VALUES ('$id_registro',1,0)";
    $mysqli->query($sqlsesion);
    echo json_encode(array('error' =>false,'user' =>$usuario, 'password'=>$contrasena));
}
else{
    echo json_encode(array('error' =>true));
}
$mysqli->close();




?>