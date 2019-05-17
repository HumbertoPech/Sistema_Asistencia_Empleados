<?php
session_start();

function cambiarContrasenia(){
	 require_once("consultas.php");

	// //verificar que devuelve la bd.
	$query= "SELECT * FROM empleados WHERE usuario = '". $_SESSION['usuario'] . "'";
	$datos= consultar($query);

	if($datos){
		$passwordUser = trim($datos['contrasena']);	

		if( strcmp(trim($_POST["currentPassword"]),$passwordUser)== 0 ){
			//conectar con la bd y cambiar contraseña;
		 	//UPDATE `empleados` SET `contrasena`= '123456' WHERE usuario= 'ua1998';
		    $query = "UPDATE `empleados` SET `contrasena`= ' ".$_POST["newPassword"]."' WHERE `usuario`= '". $_SESSION['usuario'] . "'";
		    $consultaRealizada = actualizar($query);
	    	if( $consultaRealizada){
	        	echo "contraseña cambiada";
	    	}else{
	        	echo "No se cambió la contraseña";
	    	}
		 }else{
			echo ("contraseña incorrecta");
		}

	}else{
		echo "No existe el empleado.";
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