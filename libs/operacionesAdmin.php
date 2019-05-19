<?php
function generador_contrasena(){
	return mt_rand(1000, 9999);
  }
  
function generador_usuario($nombres,$apellidos){
	  
	$nombre_usuario = explode(" ",strtolower($nombres));
	$apellido_usuario = explode(" ",strtolower($apellidos));
	$numero_usuario=mt_rand(1000, 9999);
	$usuario_final=$nombre_usuario[0] . $apellido_usuario[0] . $numero_usuario;
	return $usuario_final;
  }
?>