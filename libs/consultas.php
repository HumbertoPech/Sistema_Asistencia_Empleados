<?php
include_once('../core/conexion.php');
function consultar($query){
	 
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

function insertar($query){
    $conector = new Conexion();
      $conexion= $conector ->get_conexion(); 
     if($conexion){
         $resultado= $conexion->query($query);
          return $resultado;
     }
     $conector->close_conexion();
}
?>