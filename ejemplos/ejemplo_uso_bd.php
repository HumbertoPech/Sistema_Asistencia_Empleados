<?php
    session_start();
    echo $_SESSION['id_usuario']."JAJAJA2";
    echo $_SESSION['url_base'];
    $_SESSION['eliminarImagen'] = true;
    $url_base=$_SESSION['url_base'];
    require_once("../core/Conexion.php");
    $con = new Conexion();
    $conexion = $con->get_conexion();
    $id = $_POST['variable'];
    /*echo "<script type='text/javascript'>
            alert('$id.aaa.$nuevo');
    </script>";*/   
    $query = "UPDATE publicaciones SET disponibilidad=false WHERE id_usuario='$id'";
    
    //$query = "DELETE from publicaciones WHERE id_publicacion=$id";
    $resultado = $conexion->query($query);
    if($resultado){
        echo "Si se eliminó";
    }else{
        echo "No se eliminó"; 
    }
    header("vista/perfil_usuarioVista.php");
    mysqli_close($conexion);


    
?>