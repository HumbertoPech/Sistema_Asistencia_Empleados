<?php
class Vacaciones{

    public function __construct(){
        echo "Actualizando";
    }

    public function agregar($id_usuario,$fecha_iniciar,$fecha_final){
        $mysqli =new mysqli('localhost','root','','asistencia_empleados');
        $id=$id_usuario;
        $fecha_inicio = new DateTime($fecha_iniciar);
        $fecha_inicio = $fecha_inicio->format('Y-m-d');
        $fecha_termino = new DateTime($fecha_final);
        $fecha_termino = $fecha_termino->format('Y-m-d');
        $query = "INSERT into vacaciones_empleados(id_empleado, fecha_inicio, fecha_termino)
         VALUES ($id,'$fecha_inicio', '$fecha_termino')";
        $exito=$mysqli->query($query);
        if($exito){
            return true;
        }
        else{
            return false;
        }
    }
}

    
?>