<?php
require '../core/conexion.php';
//session_start();
$con = new Conexion();
$conexion = $con->get_conexion();  
$query = "SELECT td.id, td.hora_entrada, td.en_nomina, td.hora_salida, td.fecha, td.horas_trabajadas, emp.id as id_emp, emp.nombres, emp.apellidos from trabajo_diario td inner join empleados emp on emp.id = td.id_empleado where td.horas_trabajadas is null";
$tmp = "<table class='table table-bordered'>
            <tr>
            <th>Nombre de Empleado</th>
                <th>En nómina</th>
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
            $tmp.="<tr><td>".$row['nombres']." ".$row['apellidos']."</td>";
            $tmp.="<td>".$row['en_nomina']."</td>
            <td>".$row['hora_entrada']."</td>
            <td>".$row['hora_salida']."</td>
            <td>".$row['fecha']."</td>
            <td>".$row['horas_trabajadas']."</td>
            <td><a href='../../pages/administrator/solucionar_pendiente.php?id_trabajo_diario=".$row['id']."'class='btn btn-secondary'>Solucionar</a></td>";
            $tmp.="</tr>";     
        }
        $tmp.="</table>";
        echo $tmp;
    }
}
$conexion = $con->close_conexion();  
?>          