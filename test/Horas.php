<?php
class Horas{

    public function __construct(){
        echo "Calculando";
    }

    public function calcular($id_empleado,$fecha){
    //Busca el registro de empleado con la fecha en la tabla de trabajo_diario
    $mysqli =new mysqli('localhost','root','','asistencia_empleados');
    $query= "SELECT * FROM trabajo_diario WHERE id_empleado = '". $id_empleado. "' AND fecha= ' " . $fecha."'";
    $registro=$mysqli->query($query);
	if($registro){
        $datos=$registro->fetch_assoc(); 
		$registroEntrada= new DateTime($datos['hora_entrada']);
		$registroSalida = new DateTime($datos['hora_salida']);
		if($registroEntrada!= NULL && $registroSalida != NULL ){
            $enTiempoTolerancia=true;
            $minutosTolerancia= 6;
            $horaEntrada;
            //Calcular dia de la semana de la fecha
            $diasSemana = array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sabado");
            $diaRegistro= $diasSemana[date("w",strtotime($fecha))];
            echo $fecha;
            echo $diaRegistro;
            //Checa el horario de entrada y salida del empleado
            $query_horario="SELECT * FROM horarios WHERE id_empleado = '". $id_empleado. "' AND dia= '" .$diaRegistro."'";
            $registro_horario= $mysqli->query($query_horario);
            if($registro_horario){
                echo 'Si z ...';
                $datos_horario=$registro_horario->fetch_assoc(); 
                $horaEntrada= new DateTime($datos_horario['hora_entrada']);
                echo $datos_horario['hora_entrada'];
            }else{
                return false;
            }	
            //Calcula la diferencia entre retardo (si existe) y la tolerancia
            $retardo= $horaEntrada->diff($registroEntrada);
            $retardoAMinutos= (($retardo->h)*60) + ($retardo->i);
            if($retardoAMinutos > $minutosTolerancia){
                $enTiempoTolerancia=false;
            }
            //Esta en tiempo de tolerancia?			
			if($enTiempoTolerancia){
				$intervaloTrabajado= $registroEntrada->diff($registroSalida);
				$horasTrabajadas = $intervaloTrabajado->h + (($intervaloTrabajado->i)/60);//08.30				
            }
            //Hacer si no esta en tiempo de tolerancia
            else{
                $hora_Entrada;
                $diasSemana = array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sabado");
                $diaRegistro= $diasSemana[date("w",strtotime($fecha))];
                
                $query_hora="SELECT * FROM horarios WHERE id_empleado = '". $id_empleado. "' AND dia= '" .$diaRegistro."'";
                $registro_hora= $mysqli->query($query_hora);
                   
                if($registro_hora){
                    $datos_hora=$registro_hora->fetch_assoc(); 
                    $hora_Entrada= new DateTime($datos_hora['hora_entrada']);
                }else{
                    return false;
                }	
				$retardo= $hora_Entrada->diff($registroEntrada);
				$registroEntrada->sub($retardo);//Descontarle los minutos que se pasó al horario de entrada			
				$intervaloTrabajado= $registroEntrada->diff($registroSalida);//Calcular cuantas horas trabajó
				$horasTrabajadas = (($intervaloTrabajado->h)-1) + (($intervaloTrabajado->i)/60);//Descontarle 1.
            }
            //Actualiza las horas trabadas
			$query_actualizar= "UPDATE `trabajo_diario` SET `horas_trabajadas`= ' ".$horasTrabajadas."' WHERE `id_empleado`= '".$id_empleado . "' AND fecha= '" .$fecha."'";
            $actualizacionRealizada = $mysqli->query($query_actualizar);
            
		 	if( !$actualizacionRealizada){
		 	 	return false;
             }
             else{
                 return true;
             }
		}
	}else{
		echo "Empleado o fecha no existente";
		return false;
	}
        

    }
}

    
?>