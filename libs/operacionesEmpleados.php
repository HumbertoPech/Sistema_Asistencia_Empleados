<?php
session_start();
require_once("consultas.php") ;

switch ($_POST['operacion']) {
        case 'cambio':
            cambiarContrasenia();
            break;
        case 'checkIn':
        		checkIn();
        		break;  
        case 'checkOut':
        		checkOut();
        		break;		 
        default:
            break;
 }

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

 function checkIn(){ 	
 		
}

function checkOut(){
	//Revisar porqué la fecha me da un dia después jajaja 
	$fecha= date("Y-m-d");
	$id_empleado=1;
 	calcularHorasDiarias($id_empleado, $fecha);
}

// pre condición, se hizo check-out.
function calcularHorasDiarias($id_empleado,$fecha){
	
	$query= "SELECT * FROM trabajo_diario WHERE id_empleado = '". $id_empleado. "' AND fecha= ' " . $fecha."'";
	$registro= consultar($query);
	if($registro){
		$registroEntrada= new DateTime($registro['hora_entrada']);
		$registroSalida = new DateTime($registro['hora_salida']);

		if($registroEntrada!= NULL && $registroSalida != NULL ){
			
			if( enTiempoTolerancia($id_empleado,$registroEntrada,$fecha)){
				$intervaloTrabajado= $registroEntrada->diff($registroSalida);
				$horasTrabajadas = $intervaloTrabajado->format("%H.%i");//08.30				
			}else{

				$horaEntrada= obtenerHorarioEntrada($id_empleado,$fecha);	
				$retardo= $horaEntrada->diff($registroEntrada);
				$registroEntrada->sub($retardo);//Descontarle los minutos que se pasó al horario de entrada			
				$intervaloTrabajado= $registroEntrada->diff($registroSalida);//Calcular cuantas horas trabajó
				$horasTrabajadas= ($intervaloTrabajado->h)-1;//Descontarle 1.
			}

			$query= "UPDATE `trabajo_diario` SET `horas_trabajadas`= ' ".$horasTrabajadas."' WHERE `id_empleado`= '".$id_empleado . "' AND fecha= '" .$fecha."'";
			$actualizacionRealizada = actualizar($query);
		 	if( $actualizacionRealizada){
		 		echo "Horas calculadas";
		 	}else{
		 		echo "Horas no calculadas";
		 	}
		}
	}else{

		echo "Empleado o fecha no existente";
		return false;
	}
}
//condición: Sí hay hora de entrada existente.
function obtenerHorarioEntrada($id_empleado,$fecha){
	$diasSemana = array("domingo","lunes","martes","miercoles","jueves","viernes","sabado");
 	$diaRegistro= $diasSemana[$fecha->format("w")];
	
	$query="SELECT * FROM horarios WHERE id_empleado = '". $id_empleado. "' AND dia= '" .$diaRegistro."'";
	$registro= consultar($query);

	if($registro){
		$horaEntrada= new DateTime($registro['hora_entrada']);
	    return $horaEntrada;
	}else{
		echo "Horario de entrada no encontrado";
		exit();
	}
}

function enTiempoTolerancia($id_empleado,$horaRegistro,$fecha){
	$minutosTolerancia= 6;
	$horaEntrada= obtenerHorarioEntrada($id_empleado,$fecha);	
	$retardo= $horaEntrada->diff($horaRegistro);
	if($retardo->i > $minutosTolerancia){
		return false;
	}
	return true;		
}
?>