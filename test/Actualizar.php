<?php
class Actualizar{

    public function __construct(){
        echo "Actualizando";
    }

    public function actualizar($usuario){
        $mysqli =new mysqli('localhost','root','','asistencia_empleados');
        $id_usuario = $usuario[0];
        $nombres = $usuario[1];
        $apellidos = $usuario[2];
        $sueldo_base =$usuario[3];
        $direccion = $usuario[4];
        $sexo = $usuario[5];
        $estado_civil = $usuario[6];
        $curp =$usuario[7];
        $sql = "UPDATE empleados SET nombres = '$nombres', apellidos = '$apellidos', 
        sueldo_base = '$sueldo_base', direccion = '$direccion',".
        "sexo = '$sexo', estado_civil = '$estado_civil', curp = '$curp' 
        WHERE id = ".$id_usuario;
        $exito=$mysqli->query($sql);
          if($exito){
              return true;
          }
          else{
              return false;
          }

    }
}

    
?>