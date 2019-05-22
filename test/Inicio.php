<?php
class Inicio{

public function __construct(){
    echo "Logeando";
}

public function entrar($usuario,$contrasena){
    $mysqli =new mysqli('localhost','root','','asistencia_empleados');
    sleep(2);
    $user=$usuario;
    $password=$contrasena;
    $usuarios= $mysqli->query("SELECT id, id_estado, usuario, contrasena, fecha_inicio FROM empleados
    WHERE usuario= '".$user."' ");
    
    if($usuarios->num_rows ==1){
        $datos=$usuarios->fetch_assoc(); 
        $dia_hoy = new DateTime("now");
        $dia_inicio = new DateTime($datos['fecha_inicio']);
        if($dia_inicio<$dia_hoy){ 
          
            if($datos['id_estado']!=2){
                $data= $mysqli->query("SELECT numero_intentos FROM empleado_intentos
                WHERE id_empleado= '".$datos['id']."' ");
                $numero_intentos=$data->fetch_assoc(); 
                if($numero_intentos['numero_intentos']!=3){      
                    if($password==(string) $datos['contrasena']){  
                    $sql = $mysqli->query("UPDATE empleado_intentos SET numero_intentos=0 WHERE id_empleado='".$datos['id']."' ");
                    $_SESSION['id_usuario']=$datos['id'];
                    return true; 
                    }
                    else{
                    $aumento_intentos=$numero_intentos['numero_intentos']+1;
                    $sql = $mysqli->query("UPDATE empleado_intentos SET numero_intentos='$aumento_intentos' WHERE id_empleado='".$datos['id']."' ");
                    return false;
                    }   
                }
                else{
                return false;
                }
            }
            else{
                return false;
            }
        }
        else{
         return false;
        }   
    }
    else{
        return false;
    }
    $mysqli->close();
 }
}

    
?>