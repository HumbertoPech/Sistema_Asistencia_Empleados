<?php
session_start();
require '../core/conexion.php';
$conector = new Conexion();
$mysqli= $conector ->get_conexion();
sleep(2);
$user=$_POST['user'];
$password=$_POST['pass'];

$usuarios= $mysqli->query("SELECT id, usuario, contrasena FROM empleados
WHERE usuario= '".$user."' ");

if($usuarios->num_rows ==1){
  $datos=$usuarios->fetch_assoc(); 
  $data= $mysqli->query("SELECT numero_intentos FROM empleado_intentos
  WHERE id_empleado= '".$datos['id']."' ");
  $numero_intentos=$data->fetch_assoc(); 
   if($numero_intentos['numero_intentos']!=3){ 
       if($password==$datos['contrasena']){
        
        $sql = $mysqli->query("UPDATE empleado_intentos SET numero_intentos=0 WHERE id_empleado='".$datos['id']."' ");
        $_SESSION['id_usuario']=$datos['id'];
        echo json_encode(array('error' =>false,'id'=>$_SESSION['id_usuario'])); 
       }
       else{
         $aumento_intentos=$numero_intentos['numero_intentos']+1;
         $sql = $mysqli->query("UPDATE empleado_intentos SET numero_intentos='$aumento_intentos' WHERE id_empleado='".$datos['id']."' ");
         echo json_encode(array('error' =>true, 'tipo'=>'Hay un error en los datos. Verifique su información.'));
       }   
   }
   else{
     echo json_encode(array('error' =>true, 'tipo'=>'La cuenta esta bloqueada en este momento. Contacte al administrador.'));
   }   
}
else{
    echo json_encode(array('error' =>true, 'tipo'=>'Hay un error en los datos. Verifique su informaciónn.'));
}
$mysqli->close();


?>