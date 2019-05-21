<?php
date_default_timezone_set("America/Mexico_City");
$fecha_hoy = date("Y-m-d");
require('../core/conexion.php');

if (isset($_GET['id']) && is_numeric($_GET['id']))
{
    $id = $_GET['id'];
    $fecha = $_GET['fecha'];
    // delete the entry
    if($fecha>$fecha_hoy){
        $sql = "DELETE FROM dias_festivos WHERE id=$id";
        $con = new Conexion();
        $conexion = $con->get_conexion(); 
        if($conexion){
            $resultado = $conexion->query($sql);
        }  
        $conexion = $con->close_conexion();          
    }else{
        echo "<script type='text/javascript'>";
        echo "alert('No puedes elegir una fecha menor o igual a la actual');";
        echo "</script>";          
    }

    // redirect back to the view page
    header("Location: ../pages/administrator/mostrar_dias_festivos.php");
}else{
    header("Location: ../pages/administrator/mostrar_dias_festivos.php");
}
?>