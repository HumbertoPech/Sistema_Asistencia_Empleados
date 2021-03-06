<!DOCTYPE html>
<html>
<head>
<style>
table, th, td {
    border: 1px solid black;
}

</style>
<?php include("../../resources/html/header_admin_empleados.html");
?>
<div class="container-fluid">

<div id ="encabezado" class="row sticky-top bg-dark text-white shadow-sm">
                <div class="d-flex align-items-center col-2">
                    <a href="indexAdmin.html" ><button type="button" class="btn btn-primary">Regresar</button></a>
                </div>
                <div class="d-flex align-items-center col-10">
                    <h1 align="center">Administración de Días Festivos </h1>
                </div>
            </div>

</nav>
</head>
<body>
    <?php
    include '../../core/conexion.php';
    $sql = "SELECT * FROM dias_festivos order by fecha DESC";

    $con = new Conexion();
    echo "<h3>DIAS FESTIVOS</h3>";
    $conexion = $con->get_conexion(); 
    if($conexion){
        $resultado = $conexion->query($sql);
        if (!empty($resultado)) {
            echo "<table class='table row justify-content-center'><tr><th>FECHA</th><th>EDITAR</th><th>ELIMINAR</th></tr>";

            while($row = $resultado->fetch_array()){
                $id = $row['id'];
                echo "<tr><td>" . $row["fecha"]. "</td>";
                echo "<td><form method='post' action='../../libs/modificar_dias_festivos.php'<label><input type='date' name='fecha_entrada' id='fecha_entrada' value='''></label><input type='hidden' name='varname' value='$id'><input type='submit' name='submit' value='Aceptar'><br></form></td>";
                echo '<td><a href="../../libs/eliminar_dias_festivos.php?id=' . $row['id'].'&fecha='.$row['fecha'].'.">Delete</a></td></tr>';
            }
            echo "</table>";

        }
    }  
    $conexion = $con->close_conexion();  

    ?>
    <div class="row justify-content-center"> 
    <h4 class="col-12" align="center">Agregar nuevo dia festivo<h4>
    <form class="col-12" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
    <label>
        <input type="date" name="fecha_entrada" id="fecha_entrada" value="<?php echo date("Y-m-d");?>">
    </label>
    <input type="submit" name="submit" value="Aceptar"><br>
    </form>
</div>
</div>
</body>
</html>
<?php 
date_default_timezone_set("America/Mexico_City");
$fecha_hoy = date("Y-m-d");
if(isset($_POST['submit']))
{
    if(isset($_POST['fecha_entrada'])){
        $dateSelected = $_POST['fecha_entrada'];
        agregarNuevoDiaFestivo($dateSelected);    
    }else{
        echo "No se seleccionó fecha";
    }
}
function isDiaFestivoRegistrado($dateSelected){
    $sql = "SELECT * FROM dias_festivos where fecha = '$dateSelected'";
    $con = new Conexion();
    $conexion = $con->get_conexion(); 
    if($conexion){
        $resultado = $conexion->query($sql);

        while($dia_festivo_registrado = $resultado->fetch_assoc()){
            $conexion = $con->close_conexion();

            return true;
        }
    }
    $conexion = $con->close_conexion();

    return false;
}
function agregarNuevoDiaFestivo($dateSelected){
    global $fecha_hoy;
    if ($dateSelected > $fecha_hoy){
        if(!isDiaFestivoRegistrado($dateSelected)){
            
            $sql = "INSERT INTO dias_festivos (fecha) VALUES ('$dateSelected')";
            $con = new Conexion();
            $conexion = $con->get_conexion(); 
            if($conexion){
                $resultado = $conexion->query($sql);
                echo "<script type='text/javascript'>";
                echo "alert('Dia agregado correctamente');";
                echo "</script>";
            }  
            $conexion = $con->close_conexion();      
            header("Location: mostrar_dias_festivos.php");    
        }else{
            echo "<script type='text/javascript'>";
            echo "alert('El dia ya se encuentra registrado previamente');";
            echo "</script>";                
        }
    }else{
        echo "<script type='text/javascript'>";
        echo "alert('No puedes elegir una fecha menor o igual a la actual');";
        echo "</script>";   
    }
}
require("../../resources/html/footer_admin_empleados.html");

?>
