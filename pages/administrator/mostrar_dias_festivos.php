<!DOCTYPE html>
<html>
<head>
<style>
table, th, td {
    border: 1px solid black;
}
</style>
</head>
<body>
    <?php
    include 'conexion.php';
    $sql = "SELECT * FROM dias_festivos";
    $result = $conn->query($sql);
    echo "<h3>DIAS FESTIVOS</h3>";
    if ($result->num_rows > 0) {
        echo "<table><tr><th>FECHA</th><th>EDITAR</th><th>ELIMINAR</th></tr>";
        // output data of each row
        while($row = $result->fetch_assoc()) {
            $id = $row['id'];
            echo "<tr><td>" . $row["fecha"]. "</td>";
            echo "<td><form method='post' action='modificar_dias_festivos.php'<label><input type='date' name='fecha_entrada' id='fecha_entrada' value='''></label><input type='hidden' name='varname' value='$id'><input type='submit' name='submit' value='Aceptar'><br></form></td>";
            echo '<td><a href="eliminar_dias_festivos.php?id=' . $row['id'].'&fecha='.$row['fecha'].'.">Delete</a></td></tr>';
        }
        echo "</table>";
    } else {
        echo "0 results";
    }
    $conn->close();
    ?> 
    <h4>Agregar nuevo dia festivo<h4>
    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
    <label>
        <input type="date" name="fecha_entrada" id="fecha_entrada" value="<?php echo date("Y-m-d");?>">
    </label>
    <input type="submit" name="submit" value="Aceptar"><br>
    </form>
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
    include 'conexion.php';
    $sql = "SELECT * FROM dias_festivos where fecha = '$dateSelected'";
    $resultado = $conn->query($sql);
    while($dia_festivo_registrado = $resultado->fetch_assoc()){
        echo "Ya esta registrado";
        $conn->close();
        return true;
    }
    return false;
}
function agregarNuevoDiaFestivo($dateSelected){
    global $fecha_hoy;
    if ($dateSelected > $fecha_hoy){
        include 'conexion.php';
        if(!isDiaFestivoRegistrado($dateSelected)){
            $sql = "INSERT INTO dias_festivos (fecha) VALUES ('$dateSelected')";
            $resultado = $conn->query($sql);
            $conn->close();
            echo "<script type='text/javascript'>";
            echo "alert('Dia agregado correctamente');";
            echo "</script>";
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
?>
