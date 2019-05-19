<?php
session_start();
require_once("consultas.php") ;

function cambiarContrasenia(){
	 require_once("consultas.php");

	 $actualPassword= $_POST["currentPassword"];
	 $id_usuario= $_SESSION['id_usuario'];

	 if( verificarContrasenia($actualPassword,$id_usuario) ){
				
	 	$newPassword= $_POST['newPassword'];
	 	$hashPassword = password_hash($newPassword, PASSWORD_DEFAULT);

	 	//UPDATE `empleados` SET `contrasena`= '123456' WHERE usuario= 'ua1998';
	 	$query = "UPDATE `empleados` SET `contrasena`= ' ".$hashPassword."' WHERE `id`= '". $id_usuario . "'";
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
		if(password_verify($password, $registro['contrasena'])){
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
        case 'checkIn':
        		checkIn();
        		break;   
        default:
            break;
 }

 function checkIn(){
 	calcularHorasDiarias(2, date('2019-05-19'));
}

//TODO pre condición, se hizo check-out.
function calcularHorasDiarias($id_empleado,$fecha){
	$query= "SELECT * FROM trabajo_diario WHERE id = '". $id_empleado. "' AND fecha= ' " . $fecha."'";
	$registro= consultar($query);
	if($registro){
		$horaEntrada= new DateTime($registro['hora_entrada']);
		$horaSalida = new DateTime($registro['hora_salida']);
		if($horaEntrada!= NULL && $horaSalida != NULL ){
			
			if( enTiempoTolerancia($horaEntrada)){
				$intervalo= $horaEntrada->diff($horaSalida);
				$horas = $intervalo->format("%H.%i");//08.30

				$query= "UPDATE `trabajo_diario` SET `horas_trabajadas`= ' ".$horas."' WHERE `id`= '". $id_empleado . "' AND fecha= ' " . $fecha."'";
				$actualizacionRealizada = actualizar($query);
			 	if( $actualizacionRealizada){
			 		echo "Horas calculadas";
			 	}else{
			 		echo "Horas no calculadas";
			 	}
				
			}else{
				//Descontarle los minutos que se pasó al horario de entrada
				//Calcular cuantas horas trabajó
				//Descontarle 1.
			}
		}

	}else{
		echo "Empleado no existe";
		return false;
	}

}

function enTiempoTolerancia($horaRegistroEntrada){
	$minutosTolerancia= 6;
	$horaEntrada= //obtener hora de entrada de la BD;
	$retardo= $horaEntrada->diff($horaRegistroEntrada);
	if(//los minutos del retardo son mayores que los minutos de tolerancia, entonces false)
	return true;
}
?>