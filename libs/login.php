<?php
session_start();
//Se realiza la conexión 
require '../core/conexion.php';
$conector = new Conexion();
$mysqli= $conector ->get_conexion();
//Hace un retardo de 1 segundo
sleep(1);
//Parametros a evaluar
$user=$_POST['user'];
$password=$_POST['pass'];
//Query que busca si existe el registro del usuario en la base de datos
$usuarios= $mysqli->query("SELECT id, id_estado, usuario, contrasena, fecha_inicio FROM empleados
WHERE usuario= '".$user."' ");

//Si existe el usuario, el query debe tener mas de 1 elemento
if($usuarios->num_rows == 1){
    $datos=$usuarios->fetch_assoc(); 
    //Se verifica si el empleado esta en su fecha de inicio de trabajo
    $dia_hoy = new DateTime("now");
    $dia_inicio = new DateTime($datos['fecha_inicio']);
    if($dia_inicio<$dia_hoy){
      //Verifica si el empleado esta activo
      if($datos['id_estado']!=2){
        $data= $mysqli->query("SELECT numero_intentos FROM empleado_intentos
        WHERE id_empleado= '".$datos['id']."' ");
        $numero_intentos=$data->fetch_assoc(); 
        //Verifica si el empleado no se encuentra bloqueado por numero de intentos
        if($numero_intentos['numero_intentos']!=3){ 
            //Verifica que la contraseña es correcta y reinicia el numero de intentos
            if($password==$datos['contrasena']){  
              $sql = $mysqli->query("UPDATE empleado_intentos SET numero_intentos=0 WHERE id_empleado='".$datos['id']."' ");
              $_SESSION['id_usuario']=$datos['id'];
              echo json_encode(array('error' =>false,'id'=>$_SESSION['id_usuario'])); 
            }
            //Si la contraseña no es correcta, aumenta los intentos
            else{
              $aumento_intentos=$numero_intentos['numero_intentos']+1;
              $sql = $mysqli->query("UPDATE empleado_intentos SET numero_intentos='$aumento_intentos' WHERE id_empleado='".$datos['id']."' ");
              echo json_encode(array('error' =>true, 'tipo'=>'Hay un error en los datos. Verifique su información.'));
            }   
        }
        else{
          echo json_encode(array('error' =>true, 'tipo'=>'Has excedido el número de intentos, la cuennta se ha bloqueado. Contacte al administrador.'));
        }
      }
      else{
        echo json_encode(array('error' =>true, 'tipo'=>'Esta cuenta se encuentra inactiva por el momento. Contacte al administrador.'));
      }
    }
    else{
      echo json_encode(array('error' =>true, 'tipo'=>'Esta cuenta aún no puede recibir asistencias.'));
    }   
}
else{
    echo json_encode(array('error' =>true, 'tipo'=>'Hay un error en los datos. Verifique su informaciónn.'));
}
$mysqli->close();
?>