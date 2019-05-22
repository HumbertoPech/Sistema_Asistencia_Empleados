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
        case 'verificarHorarios':
        		verificarHorarios();
        		break;
        case 'estadoEmpleado':
        		verificarEstadoEmpleado();			 
        default:
            break;
}

function cambiarContrasenia(){
	 require_once("consultas.php");
	 $actualPassword= $_POST["currentPassword"];
	 $id_empleado= $_SESSION['id_usuario'];
	 if( verificarContrasenia($actualPassword,$id_empleado) ){
				
	 	$newPassword= $_POST['newPassword'];       
	 	//UPDATE `empleados` SET `contrasena`= '123456' WHERE usuario= 'ua1998';
	 	$query = "UPDATE `empleados` SET `contrasena`= '".$newPassword."' WHERE `id`= '". $id_empleado . "'";
	 	$actualizacionRealizada = actualizar($query);
	 	if( $actualizacionRealizada){
	 		echo "Contraseña cambiada";
	 	}else{
	 		echo "No se cambió la contraseña";
	 		return http_response_code(204);
	 	}
	 }
		 
}

function verificarContrasenia($password,$id_empleado){
	require_once("consultas.php");

	$query= "SELECT * FROM empleados WHERE id = '". $id_empleado. "'";
	$registro= consultar($query);
	
	if($registro){
		if(trim($password) == trim($registro['contrasena'])){
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

function verificarHorarios(){
	date_default_timezone_set('America/Merida');
	$id_empleado= $_SESSION['id_usuario'];
	$diasSemana = array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sabado");
 	$diaRegistro= $diasSemana[date("w")];
	$query="SELECT * FROM horarios WHERE id_empleado = '". $id_empleado. "' AND dia= '" .$diaRegistro."'";
	$registro= consultar($query);

	if($registro){		
		$horaActual= new DateTime('Now');
		$horaEntrada= new DateTime($registro['hora_entrada']);
			//si la hora actual es igual o una hora despues de la hora de entrada.
		if($horaActual>= $horaEntrada && $horaActual<= ($horaEntrada->modify('+1 hour'))){
			if(!registroRealizado("hora_entrada")){
				echo "checkIn";
			}
		} 
		//revisar si la hora actual es igual que la hora de salida o hasta la hora de cierre de la empresa.
		$horaSalida= new DateTime($registro['hora_salida']);
	    if($horaActual>= $horaSalida && $horaActual<= ($horaSalida->modify('+1 hour'))){
			if(!registroRealizado("hora_salida")){
				echo "checkOut";
			}
		}		
	}
}

function registroRealizado($tipoRegistro){
	date_default_timezone_set('America/Merida');
	$fecha= date("Y-m-d");
 	$id_empleado= $_SESSION['id_usuario'];
 	$query= "SELECT * FROM trabajo_diario WHERE id_empleado = '". $id_empleado. "' AND fecha= ' " . $fecha."'";
	$registro= consultar($query);
	if($registro){
	//verificar que haya un registro en la tabla trabajos_diarios que tenga una entrada o una salida registrada.
		if($registro[$tipoRegistro] != NULL){
			return true;
		}	
	}
	return false;//si no hay, return false;	 
}


function verificarEstadoEmpleado(){
	date_default_timezone_set('America/Merida');
 	$fecha= date("Y-m-d");
	$id_empleado= $_SESSION['id_usuario'];
 	$query= "SELECT * FROM suspension_empleados WHERE id_empleado = '". $id_empleado. "' AND '" .$fecha. "' BETWEEN fecha_inicio AND fecha_termino";
	$registro= consultar($query);	//obtener empleado de la tabla suspension_empleados.
	
	if($registro){ 
			echo "suspendido";
			return;
	}	
	$query= "SELECT * FROM vacaciones_empleados WHERE id_empleado = '". $id_empleado. "' AND '" .$fecha. "' BETWEEN fecha_inicio AND fecha_termino";
	$registro= consultar($query);
	if($registro){ 
			echo "vacaciones";
			return;			
	}
}

function checkIn(){ 
 	date_default_timezone_set('America/Merida');
 	$fecha= date("Y-m-d");
 	$hora= date("H:i:s");
 	$id_empleado= $_SESSION['id_usuario'];
 	$query= "INSERT INTO `trabajo_diario` (`id_empleado`, `en_nomina`, `hora_entrada`, `fecha`) VALUES ( $id_empleado, 'NO', '$hora', '$fecha')";
	if(insertar($query)){
		echo ("CheckIn realizado el $fecha a las $hora");
	}else{
		echo ("CheckIn NO realizado: $query");
	}
}

function checkOut(){
	date_default_timezone_set('America/Merida');
	$fecha= date("Y-m-d");
 	$hora= date("H:i:s");
 	$id_empleado= $_SESSION['id_usuario'];
 	$query= "SELECT * FROM trabajo_diario WHERE id_empleado = '". $id_empleado. "' AND fecha= ' " . $fecha."'";
	$registro= consultar($query);

	if($registro){
		$query="UPDATE `trabajo_diario` SET `hora_salida`= ' ".$hora."' WHERE `id_empleado`= '".$id_empleado . "' AND fecha= '" .$fecha."'";
		if(actualizar($query)){
			echo ("CheckOut realizado el $fecha a las $hora");
			calcularHorasDiarias($id_empleado,$fecha);
		}else{
			echo ("CheckIn NO realizado: $query");
		}

	}else{
		$query= "INSERT INTO `trabajo_diario` (`id_empleado`, `en_nomina`, `hora_salida`, `fecha`) VALUES ( $id_empleado, 'NO', '$hora', '$fecha')";
		if(insertar($query)){
			echo ("CheckOut realizado el $fecha a las $hora");
			calcularHorasDiarias($id_empleado, $fecha);
		}else{
			echo ("CheckIn NO realizado: $query");
		}
	} 	
}

// pre condición, se hizo check-out y los horarios están bien establecidos.Si se pasa del rango de tolerancia, pero el horario de check-in es anterior a la hora de entrada, da  -1.
function calcularHorasDiarias($id_empleado,$fecha){
	$query= "SELECT * FROM trabajo_diario WHERE id_empleado = '". $id_empleado. "' AND fecha= ' " . $fecha."'";
	$registro= consultar($query);
	if($registro){
		$registroEntrada= new DateTime($registro['hora_entrada']);
		$registroSalida = new DateTime($registro['hora_salida']);

		if($registroEntrada!= NULL && $registroSalida != NULL ){
			
			if( enTiempoTolerancia($id_empleado,$registroEntrada,$fecha)){
				$intervaloTrabajado= $registroEntrada->diff($registroSalida);
				$horasTrabajadas = $intervaloTrabajado->h + (($intervaloTrabajado->i)/60);//08.30				
			}else{

				$horaEntrada= obtenerHorarioEntrada($id_empleado,$fecha);	
				$retardo= $horaEntrada->diff($registroEntrada);
				$registroEntrada->sub($retardo);//Descontarle los minutos que se pasó al horario de entrada			
				$intervaloTrabajado= $registroEntrada->diff($registroSalida);//Calcular cuantas horas trabajó
				$horasTrabajadas = (($intervaloTrabajado->h)-1) + (($intervaloTrabajado->i)/60);//Descontarle 1.
			}
			$query= "UPDATE `trabajo_diario` SET `horas_trabajadas`= ' ".$horasTrabajadas."' WHERE `id_empleado`= '".$id_empleado . "' AND fecha= '" .$fecha."'";
			$actualizacionRealizada = actualizar($query);
		 	if( !$actualizacionRealizada){
		 	 	exit();
		 	}
		}
	}else{
		echo "Empleado o fecha no existente";
		return false;
	}
}
//condición: Sí hay hora de entrada existente.
function obtenerHorarioEntrada($id_empleado,$fecha){
	$diasSemana = array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sabado");
 	$diaRegistro= $diasSemana[date("w",strtotime($fecha))];
	
	$query="SELECT * FROM horarios WHERE id_empleado = '". $id_empleado. "' AND dia= '" .$diaRegistro."'";
	$registro= consultar($query);

	if($registro){
		$horaEntrada= new DateTime($registro['hora_entrada']);
	    return $horaEntrada;
	}else{
		exit();
	}
}

//Revisar el cambio si se pasa por horas.
function enTiempoTolerancia($id_empleado,$horaRegistro,$fecha){
	$minutosTolerancia= 6;
	$horaEntrada= obtenerHorarioEntrada($id_empleado,$fecha);	
	$retardo= $horaEntrada->diff($horaRegistro);
	$retardoAMinutos= (($retardo->h)*60) + ($retardo->i);
	if($retardoAMinutos > $minutosTolerancia){
		return false;
	}
	return true;		
}
?>