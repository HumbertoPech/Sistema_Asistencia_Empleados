<?php

function consultar($query){
    //require_once('../core/conexion.php'); 
    require_once($_SERVER['DOCUMENT_ROOT'].'/Sistema_Asistencia_Empleados/core/conexion.php');
    $conector = new Conexion();
    $conexion= $conector ->get_conexion();
    $arrayRespuesta = array();
    if($conexion){
        $resultado = $conexion->query($query);
        if (!empty($resultado)) {
            while($row = $resultado->fetch_assoc()){                     
                $arrayRespuesta[]=$row;
            }
        }else{
            $arrayRespuesta["error"] = "No se encontro información en la base de datos.";
        }
    }else{
        $arrayRespuesta["error"] = "Ha ocurrido un error con la conexión a la base de datos.";
    }    
    $conector->close_conexion();
    //var_dump( $arrayRespuesta);
    return $arrayRespuesta;
}


function actualizar($query){
    require_once($_SERVER['DOCUMENT_ROOT'].'/Sistema_Asistencia_Empleados/core/conexion.php');
    $conector = new Conexion();
    $conexion = $conector ->get_conexion();
    $resultado = "";    
    if($conexion){
        $resultado= $conexion->query($query);
    }else{
    	$resultado = "Error";
    }
    $conector->close_conexion();
    return $resultado; 
}

?>