<?php
date_default_timezone_set("America/Mexico_City");
require '../core/conexion.php';
//session_start();
$con = new Conexion();
$conexion = $con->get_conexion();
$today =  date("Y-m-d");
$query = "SELECT td.id AS id_td, td.hora_entrada, td.en_nomina, td.hora_salida, td.fecha, td.horas_trabajadas, emp.id as id_emp, emp.nombres, emp.apellidos from trabajo_diario td inner join empleados emp on emp.id = td.id_empleado where td.horas_trabajadas is null and td.fecha < '$today'";
$tmp = "<table class='table table-bordered'>
            <tr>
            <th>Nombre de Empleado</th>
                <th>Hora Entrada</th>
                <th>Hora Salida</th>
                <th>Fecha</th>
                <th>Horas Trabajadas</th>
                <th>Solucionar</th>
            </tr>";

if($conexion){
    $resultado = $conexion->query($query);
    if (!empty($resultado)) {
        while($row = $resultado->fetch_array()){
            $in_out="hora_entrada";
            if(!isset($row['hora_entrada'])){
                $in_out = "hora_entrada";
            }else if(!isset($row['hora_salida'])){
                $in_out = "hora_salida";
            }
            $tmp.="<tr><td>".$row['nombres']." ".$row['apellidos']."</td>";
            $tmp.="<td>".$row['hora_entrada']."</td>
            <td>".$row['hora_salida']."</td>
            <td>".$row['fecha']."</td>
            <td>".$row['horas_trabajadas']."</td>
            <td><a href='../../pages/administrator/solucionar_pendiente.php?id_trabajo_diario=".$row['id_td']."' class='btn btn-secondary'>Solucionar</a></td>";
            $tmp.="</tr>";     
        }
        $tmp.="</table>";
        echo $tmp;
    }
}
$conexion = $con->close_conexion();  
?>          


