<?php
require '../core/conexion.php';
//session_start();
$con = new Conexion();
$conexion = $con->get_conexion();  
$estados_nombres = array();
$estados_nombres[1]="Activo";
$estados_nombres[2]="Baja";
$query = "SELECT * from empleados";
if($_POST["texto"] != ""){
    $query = "SELECT * from empleados where CONCAT(nombres, ' ',apellidos) LIKE '%".$_POST["texto"]."%'";
}
$tmp = "<table class='table table-bordered'>
            <tr>
                <th>Nombre</th>
                <th>Estado</th>
                <th>Ver</th>
                <th>Vacaciones</th>
                <th>Suspensión</th>
            </tr>";

if($conexion){
    $resultado = $conexion->query($query);
    if (!empty($resultado)) {
        while($row = $resultado->fetch_array()){
            $tmp.="<tr><td>".$row['nombres']." ".$row['apellidos']."</td>";
            $tmp.="<td>".$row['id_estado'].$estados_nombres[$row['id_estado']]."</td>
            <td><a href='../../pages/administrator/verEmpleado.php?id_usuario=".$row['id']."'class='btn btn-secondary'><i class='fas fa-eye'></i></a></td>
            <td><a href='../../pages/administrator/vacaciones_empleado.php?id_usuario=".$row['id']."'  class='btn btn-secondary'><i class='fas fa-plane'></i></a></td>
            <td><a href='../../pages/administrator/suspensiones_empleado.php?id_usuario=".$row['id']."'  class='btn btn-secondary'>
            <i class='fas fa-calendar-times'></i>
            </a></td>";
            $tmp.="</tr>";     
        }
        $tmp.="</table>";
        echo $tmp;
    }
}

$conexion = $con->close_conexion();  


?>          