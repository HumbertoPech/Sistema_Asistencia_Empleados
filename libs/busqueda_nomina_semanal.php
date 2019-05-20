<?php
include("../core/conexion.php");
session_start();
$con = new Conexion();
$conexion = $con->get_conexion();  
$query = "SELECT emp.nombres, emp.apellidos, emp.id, ns.id as id_ns, ns.horas_trabajadas, ns.sueldo_total, ns.dias_festivos, ns.fecha_termino, ns.fecha_inicio from empleados emp  inner join nomina_semanal ns on emp.id = ns.id_empleado ORDER BY fecha_inicio ASC";

if($_POST["texto"] != ""){
    $query = "SELECT emp.nombres, emp.apellidos, emp.id, ns.id as id_ns, ns.horas_trabajadas, ns.sueldo_total, ns.dias_festivos, ns.fecha_termino, ns.fecha_inicio from empleados emp inner join nomina_semanal ns on emp.id = ns.id_empleado AND CONCAT(emp.nombres, ' ',emp.apellidos) LIKE '%".$_POST["texto"]."%' ORDER BY  fecha_inicio ASC";

    if(isset($_POST["fecha_inicio"]) && isset($_POST["fecha_fin"])){
        $fecha_inicio = $_POST["fecha_inicio"];
        $fecha_fin = $_POST["fecha_fin"];
        $query .= " and ns.fecha_inicio BETWEEN '$fecha_inicio' AND '$fecha_fin' and ns.fecha_termino BETWEEN  '$fecha_inicio' AND '$fecha_fin'";
    }
}else{
    if(isset($_POST["fecha_inicio"]) && isset($_POST["fecha_fin"])){
        $fecha_inicio = $_POST["fecha_inicio"];
        $fecha_fin = $_POST["fecha_fin"];
        $query .= " and ns.fecha_inicio BETWEEN '$fecha_inicio' AND '$fecha_fin' and ns.fecha_termino BETWEEN  '$fecha_inicio' AND '$fecha_fin'";
    }
}
$tmp = "<table class='table table-hover style='border='1'; width=70%'>
            <tr style='background-color: darkorange;'>
                <th>Nombre de empleado</th>
                <th>Horas trabajadas</th>
                <th>Sueldo pagado</th>
                <th>Dias festivos y vacaciones</th>
                <th>Fecha inicio de semana</th>
                <th>Fecha fin de semana</th>
                <th>Información de días</th>
            </tr>";

if($conexion){
    $resultado = $conexion->query($query);
    if (!empty($resultado)) {
        while($row = $resultado->fetch_array()){
            $tmp.="<tr>
            <td>".$row["nombres"]." ".$row["apellidos"]."</td>
            <td>".$row["horas_trabajadas"]."</td>
            <td>"."$".$row["sueldo_total"]."</td>
            <td>".$row["dias_festivos"]."</td>
            <td>".$row["fecha_inicio"]."</td>
            <td>".$row["fecha_termino"]."</td>";
            
            $id_nomina_semanal = $row['id_ns'];
            $query2 = "SELECT * from dias_nomina_semanal where id_nomina_semanal = '$id_nomina_semanal'";
            $resultado2 = $conexion->query($query2);
            if (!empty($resultado2)){
                $tmp.="<td>";
                while($row2 = $resultado2->fetch_array()){
                    $tmp.=$row2["fecha"]."  ".$row2["tipo"]."  $".$row2["pago"]."<br>";
                }
                $tmp.="</td>";
            }
            $tmp.="</tr>";     
        }
        $tmp.="</table>";
        echo $tmp;
    }
}

$conexion = $con->close_conexion();  


?>          