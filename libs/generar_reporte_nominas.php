<?php
	header('Content-type:application/xls');
	header('Content-Disposition: attachment; filename=reporte_nominas.xls');
	include('../core/conexion.php');
	$con=new Conexion();
	$conexion = $con->get_conexion();  
	$query = "SELECT emp.nombres, emp.apellidos, emp.id as emp_id, ns.id as id_ns, ns.horas_trabajadas, ns.sueldo_total, ns.dias_festivos, ns.fecha_termino, ns.fecha_inicio from empleados emp  inner join nomina_semanal ns on emp.id = ns.id_empleado ORDER BY fecha_inicio ASC";
?>

<table border="1">
	<tr style="background-color:darkorange;">
		<th>Id de empleado</th>
		<th>Nombres de empleado</th>
		<th>Apellidos de empleado</th>
		<th>Fecha inicio de semana</th>
		<th>Fecha termino de semana</th>
		<th>Sueldo pagado</th>
		<th>Numero de dias festivos y vacaciones</th>
		<th>Dias de la semana de nomina</th>
	</tr>
	<?php 
		if($conexion){
			$resultado = $conexion->query($query);
			if (!empty($resultado)) {
				while ($row = $resultado->fetch_array()) {
					?>
						<tr>
							<td><?php echo $row['emp_id']; ?></td>
							<td><?php echo $row['nombres']; ?></td>
							<td><?php echo $row['apellidos']; ?></td>
							<td><?php echo $row['fecha_inicio']; ?></td>
							<td><?php echo $row['fecha_termino']; ?></td>
							<td><?php echo $row['sueldo_total']; ?></td>
							<td><?php echo $row['dias_festivos']; ?></td>
							<?php
							$id_nomina_semanal = $row['id_ns'];
							$query2 = "SELECT * from dias_nomina_semanal where id_nomina_semanal = '$id_nomina_semanal'";
							$resultado2 = $conexion->query($query2);
							if (!empty($resultado2)){
								?>
								<td>
								<?php
								while($row2 = $resultado2->fetch_array()){
								?>	
									<?php
										echo $row2["fecha"]."  ".$row2["tipo"]."  $".$row2["pago"]."<br>";	
								}	?>
								</td>
								<?php
							}
								?>
						</tr>
					<?php
				}
			}
		}
		$conexion = $con->close_conexion();  
	?>
</table>