<?php
/*
Página con las funciones necesarias para el modulo de empleado: Check In- CheckOut y cambio de contraseña.
@author Wendy Sosa
*/
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

/*
Realiza el cambio de contraseña del empleado.Primero verifica que la contraseña introducida sea la del empleado y luego modifica la contraseña.
@author Wendy Sosa
@return error 204 si no se modificó la contraseña.
*/
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

/*
Verifica que la contraseña del empleado en la base de datos sea igual a la contraseña introducida.
@author Wendy Sosa
@param string $password contraseña a revisar 
@param int $id_empleado id del empleado a revisar
@return false si la contraseña no existe o es incorrecta. True de otro modo
*/
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

/*
Verifica que la hora actual esté dentro de los rangos permitidos para realizar check-in y para realizar check-out.
Regresa echo "checkIn" si está en rango para check-in 
Regresa echo "checkOut" si está en rango para check-out 
@author Wendy Sosa
*/
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
		//Revisar si la hora actual es igual o una hora despues de la hora de entrada.
		//Medida de modificación de hora de entrada: horas
		if($horaActual>= $horaEntrada && $horaActual<= ($horaEntrada->modify('+1 hour'))){
			if(!registroRealizado("hora_entrada")){
				echo "checkIn";
			}
		} 
		//revisar si la hora actual es igual que la hora de salida o hasta una hora después.
		$horaSalida= new DateTime($registro['hora_salida']);
		//Medida de modificacion de hora de salida: horas.
	    if($horaActual>= $horaSalida && $horaActual<= ($horaSalida->modify('+1 hour'))){
			if(!registroRealizado("hora_salida")){
				echo "checkOut";
			}
		}		
	}
}

/*
Verifica la existencia de un registro de trabajo diario de check-in o check-out de el dia actual.
Formato de la fecha: Año-mes-dias
@author Wendy Sosa
@param string $tipoRegistro dato a verificar existencia: checkIn o checkOut
@return false si no existe un registro. True si existe un registro del dia actual.
*/
function registroRealizado($tipoRegistro){
	date_default_timezone_set('America/Merida');
	$fecha= date("Y-m-d");
 	$id_empleado= $_SESSION['id_usuario'];
 	$query= "SELECT * FROM trabajo_diario WHERE id_empleado = '". $id_empleado. "' AND fecha= ' " . $fecha."'";
	$registro= consultar($query);
	if($registro){
		if($registro[$tipoRegistro] != NULL){
			return true;
		}	
	}
	return false;
}

/*
Verifica si el empleado está de vacaciones o suspendido.
@author Wendy Sosa
*/
function verificarEstadoEmpleado(){
	date_default_timezone_set('America/Merida');
	//Formato de la fecha: Año-mes-dias
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

/*
Realiza el registro de check-in del empleado actual.
@author Wendy Sosa
*/
function checkIn(){ 
	/*Formato de la fecha: Año-mes-dias
	Formato de la hora: Hora-minutos-segundos
	*/
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


/*
Realiza el registro de check-out del empleado actual y si existe el check-in calcula las horas diarias trabajadas.
@author Wendy Sosa
*/
function checkOut(){
	date_default_timezone_set('America/Merida');
	/*Formato de la fecha: Año-mes-dias
	Formato de la hora: Hora-minutos-segundos
	*/
	$fecha= date("Y-m-d");
 	$hora= date("H:i:s");
 	$id_empleado= $_SESSION['id_usuario'];
 	$query= "SELECT * FROM trabajo_diario WHERE id_empleado = '". $id_empleado. "' AND fecha= ' " . $fecha."'";
	$registro= consultar($query);
	//Si existe un registro de trabajo del dia de hoy, actualiza agregando el check-out
	if($registro){
		$query="UPDATE `trabajo_diario` SET `hora_salida`= ' ".$hora."' WHERE `id_empleado`= '".$id_empleado . "' AND fecha= '" .$fecha."'";
		if(actualizar($query)){
			echo ("CheckOut realizado el $fecha a las $hora");
			calcularHorasDiarias($id_empleado,$fecha);
		}else{
			echo ("CheckIn NO realizado: $query");
		}

	}else{
	//Si no existe un registro de trabajo del dia de hoy, lo crea agregando el check-out
		$query= "INSERT INTO `trabajo_diario` (`id_empleado`, `en_nomina`, `hora_salida`, `fecha`) VALUES ( $id_empleado, 'NO', '$hora', '$fecha')";
		if(insertar($query)){
			echo ("CheckOut realizado el $fecha a las $hora");
			calcularHorasDiarias($id_empleado, $fecha);
		}else{
			echo ("CheckIn NO realizado: $query");
		}
	} 	
}


/*
Calcula las horas diarias trabajadas del empleado.
Se invoca bajo el supuesto de que se hizo check-out y los horarios de entrada y salida están en el rango establecido.
@author Wendy Sosa
@param int $id_empleado id del empleado a revisar
@param string $fecha fecha a la cual calcular horas trabajadas 
@return false si el empleado o la fecha no existen.
*/
function calcularHorasDiarias($id_empleado,$fecha){
	$query= "SELECT * FROM trabajo_diario WHERE id_empleado = '". $id_empleado. "' AND fecha= ' " . $fecha."'";
	$registro= consultar($query);
	if($registro){
		$registroEntrada= new DateTime($registro['hora_entrada']);
		$registroSalida = new DateTime($registro['hora_salida']);

		if($registroEntrada!= NULL && $registroSalida != NULL ){
			//Verificacion de si el empleado realizó check-in dentro del rango de tolerancia a retardos
			if( enTiempoTolerancia($id_empleado,$registroEntrada,$fecha)){
				//Se calculan las horas trabajadas restando la hora de entrada y la hora de salida.
				$intervaloTrabajado= $registroEntrada->diff($registroSalida);
				//Unidades de horas trabajadas= horas. Los minutos se transforman en unidades de horas.
				$horasTrabajadas = $intervaloTrabajado->h + (($intervaloTrabajado->i)/60);

			}else{//Si el empleado se pasó de la hora de tolerancia
				$horaEntrada= obtenerHorarioEntrada($id_empleado,$fecha);	
				$retardo= $horaEntrada->diff($registroEntrada);
				$registroEntrada->sub($retardo);//Descontar los minutos que se pasó del horario de entrada			
				$intervaloTrabajado= $registroEntrada->diff($registroSalida);//Calcular cuantas horas trabajó sin el retardo 
				//Unidades de horas trabajadas= horas. Los minutos se transforman en unidades de horas.
				$horasTrabajadas = (($intervaloTrabajado->h)-1) + (($intervaloTrabajado->i)/60);//Descontarle 1 hora al total de horas trabajadas.
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

/*
Obtiene el horario de entrada del empleado y la fecha indicadas.
@author Wendy Sosa
@param int $id_empleado id del empleado a buscar
@param string $fecha fecha para buscar hora de entrada. 
@return DateTime $horaEntrada la hora de entrada si existe.  
*/
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

/*
Verifica si se hizo el registro de entrada en el tiempo de tolerancia indicado.
@author Wendy Sosa
@param int $id_empleado id del empleado a buscar
@param string $fecha fecha para buscar el horario de entrada. 
@param DateTime $horaRegistro hora en la que el empleado realizó su registro de entrada 
@return boolean true si se registró dentro de los minutos de tolerancia.False de otro modo.   
*/
function enTiempoTolerancia($id_empleado,$horaRegistro,$fecha){
	//Unidades de tiempo de tolerancia: Minutos.
	$minutosTolerancia= 6;
	$horaEntrada= obtenerHorarioEntrada($id_empleado,$fecha);	
	$retardo= $horaEntrada->diff($horaRegistro);
	$retardoAMinutos= (($retardo->h)*60) + ($retardo->i);
	//Unidades de tiempo de tolerancia: Minutos.
	if($retardoAMinutos > $minutosTolerancia){
		return false;
	}
	return true;		
}
?>