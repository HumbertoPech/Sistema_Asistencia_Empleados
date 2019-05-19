<?php
session_start();

function cambiarContrasenia(){
	 require_once("consultas.php");
	 $actualPassword= $_POST["currentPassword"];
	 $id_usuario= $_SESSION['id_usuario'];
	 if( verificarContrasenia($actualPassword,$id_usuario) ){
				
	 	$newPassword= $_POST['newPassword'];
	 	//$hashPassword = password_hash($newPassword, PASSWORD_DEFAULT);
       
	 	//UPDATE `empleados` SET `contrasena`= '123456' WHERE usuario= 'ua1998';
	 	$query = "UPDATE `empleados` SET `contrasena`= ' ".$newPassword."' WHERE `id`= '". $id_usuario . "'";
	 	$actualizacionRealizada = actualizar($query);
	 	if( $actualizacionRealizada){
	 		echo "Contraseña cambiada";
	 	}else{
	 		echo "No se cambió la contraseña";
	 	}
	 }
		 
}

function verificarContrasenia($password,$id_usuario){
	 require_once("consultas.php");

	$query= "SELECT * FROM empleados WHERE id = '". $id_usuario. "'";
	$registro= consultar($query);
	
	if($registro){
		if($password==$registro['contrasena']){
			return true;
		}else{
			echo "Contraseña incorrecta";
			return false;
		}
	}else{
		echo "Empleado no existe";
		return false;
	}

}


switch ($_POST['operacion']) {
        case 'cambio':
            cambiarContrasenia();
            break;
        default:
            break;
 }

?>