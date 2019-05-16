<?php

function cambiarContrasenia(){
	$passwordUser= //obtener contraseña de la base de datos=
	if(strcmp($_POST["currentPassword"], $passwordUser)==0){
		//conectar con la bd y cambiar contraseña;
	}else{
		echo "contraseña incorrecta";
	}
}

switch ($_POST['operacion']) {
        case 'cambio':
            cambiarContrasenia();
            break;
        default:
            break;
    }

?>