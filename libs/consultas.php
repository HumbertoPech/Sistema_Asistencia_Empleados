<?php

function consultar($query){
	include_once('../core/conexion.php'); 
    $conector = new Conexion();
    $conexion= $conector ->get_conexion();

    if($conexion){
        $arrayRespuesta = array();
        $resultado = $conexion->query($query);
        if (!empty($resultado)) {
            while($row = $resultado->fetch_assoc()){                     
                $arrayRespuesta=$row;
            }
        }
    }    
    $conector->close_conexion();
    return $arrayRespuesta;
}


function actualizar($query){
	 
      $conector = new Conexion();
 	  $conexion= $conector ->get_conexion(); 
     if($conexion){
          $resultado= $conexion->query($query);
          return $resultado;
     }else{
     	echo "conexión con la BD fallida";
     }
     $conector->close_conexion(); 
}

?>