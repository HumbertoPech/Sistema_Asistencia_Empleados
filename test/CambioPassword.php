<?php
class Cambio{

    public function __construct(){
        echo "Cambiando";
    }

    public function cambioPassword($id_usuario,$password_actual,$password_nuevo){
        $mysqli =new mysqli('localhost','root','','asistencia_empleados');
        $actualPassword= $password_actual;
        $id_usuario= $id_usuario;
        $verificación_contraseña;
        $query_registro= "SELECT * FROM empleados WHERE id = '". $id_usuario. "'";
       $registro= $mysqli->query($query_registro);
       if($registro){
        $datos=$registro->fetch_assoc(); 
           if(trim($actualPassword) == trim($datos['contrasena'])){
               $verificación_contraseña = true;
           }else{
               echo "Contraseña incorrecta";
               $verificación_contraseña=false;
           }
       }else{
           echo "Empleado no existe";
           $verificación_contraseña = false;
       }
        
        if($verificación_contraseña){
            $newPassword= $password_nuevo;       
            $query = "UPDATE `empleados` SET `contrasena`= '".$newPassword."' 
            WHERE `id`= '". $id_usuario . "'";
            $actualizacionRealizada = $mysqli->query($query);;
            if( $actualizacionRealizada){
                echo "Contraseña cambiada";
                return true;
            }else{
                echo "No se cambió la contraseña";
                return false;
            }
        }
        else{
            return false;
        }

    }

}

    
?>