<?php
    date_default_timezone_set("America/Mexico_City");
    $fecha_hoy = date("d-m-Y");
    //$fecha_hoy = date('20-05-2019'); //poner en comentarios
    $fecha_inicio_semana;
    $fecha_fin_semana;
    $dias_festivos = array();
    include("../core/conexion.php");
    $con = new Conexion();
    $conexion = $con->get_conexion();  
  //MAIN
  function calcularSueldosSemanales(){
    global $fecha_hoy, $fecha_fin_semana, $fecha_inicio_semana;
    $fecha_inicio_semana = date("Y-m-d",strtotime($fecha_hoy."- 1 week"));
    $fecha_fin_semana = date("Y-m-d",strtotime($fecha_inicio_semana."+ 4 days"));
    if(!isNominaSemanalCalculada()){
      calcularDiasFestivosEnSemana();
      calcularSueldoEmpleadoSemanal();
      echo "<script type='text/javascript'>";
      echo "alert('Nomina semanal calculada correctamente');";
      echo "</script>";
    }else{
      echo "<script type='text/javascript'>";
      echo "alert('Ya se calculo previamente el sueldo de esta semana');";
      echo "</script>";
    }
  }

  function isNominaSemanalCalculada(){
    global $fecha_fin_semana, $fecha_inicio_semana, $conexion, $con;
    $query = "SELECT * FROM nomina_semanal WHERE fecha_inicio = '$fecha_inicio_semana' AND fecha_termino = '$fecha_fin_semana'";
    if($conexion){
        $resultado = $conexion->query($query);
        $filas = $resultado->num_rows;
        if($filas>0){
            return true;
        }else{
            return false;
        }
    }else{
        return false;
    }
}

  function calcularDiasFestivosEnSemana(){
    global $fecha_inicio_semana, $fecha_fin_semana, $dias_festivos, $conexion, $con;
    $sql = "SELECT * FROM dias_festivos WHERE fecha BETWEEN '$fecha_inicio_semana' AND '$fecha_fin_semana'";

    if($conexion){
        $resultado = $conexion->query($sql);
        if (!empty($resultado)) {
            while($dia_festivo = $resultado->fetch_array()){
                $dias_festivos[] = date("d-m-Y", strtotime($dia_festivo["fecha"]));
            }
        }
    }else{
        echo "<script type='text/javascript'>";
        echo "alert('Error con la conexion de base de datos');";
        echo "</script>";
    }
}

  function calcularSueldoEmpleadoSemanal()
  {
    global $dias_festivos, $conexion, $con;
    $EMPLEADO_BAJA = 2;
    $HORAS_DIARIAS = 8;
    $sql = "SELECT * FROM empleados WHERE id_estado != $EMPLEADO_BAJA";

    if($conexion){
        $resultado = $conexion->query($sql);
        if (!empty($resultado)) {
            while($empleado = $resultado->fetch_array()){
                $empleado_info = array();
                $empleado_info['id'] = $empleado['id'];
                $empleado_info['nombre'] = $empleado['nombres'];
                $empleado_info['apellido'] = $empleado['apellidos'];
                $empleado_info['sueldo base'] = $empleado['sueldo_base'];
                $empleado_info['id estado'] = $empleado['id_estado'];
                $dias_en_suspension = array();
                $dias_en_suspension = getDiasEnSuspension($empleado['id']);
                $empleado_info['dias en suspension'] = $dias_en_suspension;
                $dias_en_vacaciones = array();
                $dias_en_vacaciones = getDiasEnVacaciones($empleado['id']);
                $empleado_info['dias en vacaciones'] = $dias_en_vacaciones;
                $empleado_info['dias festivos y vacaciones'] = array_unique(array_merge($dias_en_vacaciones, $dias_festivos));
                //calcular el sueldo
                $sueldo_semanal = 0;
                $dias_festivos_vacaciones = sizeof($empleado_info['dias festivos y vacaciones']);

                $sueldo_semanal = $dias_festivos_vacaciones*$HORAS_DIARIAS*$empleado_info['sueldo base'];
                //falta buscar lo que se le va a pagar por los dias trabajados
                $horas_trabajadas = obtenerHorasTrabajadas($empleado['id']);
                $empleado_info['horas trabajadas'] = $horas_trabajadas;
                $sueldo_semanal = $sueldo_semanal + $horas_trabajadas*$empleado_info['sueldo base'];
                $empleado_info['sueldo semanal'] = $sueldo_semanal;
                guardarSueldoSemanal($empleado_info);
            }
        }
    }else{
        echo "<script type='text/javascript'>";
        echo "alert('Error con la conexion de base de datos');";
        echo "</script>";
    }    
    //$conexion = $con->close_conexion();  
}
function getDiasEnSuspension($id_empleado){
    global $fecha_inicio_semana, $fecha_fin_semana, $conexion, $con;
    $sql = "SELECT * FROM suspension_empleados WHERE id_empleado = $id_empleado AND (fecha_inicio OR fecha_termino BETWEEN '$fecha_inicio_semana' AND '$fecha_fin_semana')";
    $suspensiones_empleado = array();

    if($conexion){
        $resultado = $conexion->query($sql);
        if (!empty($resultado)) {
            while($suspension_empleado = $resultado->fetch_array()){
                $fechaInicio = $suspension_empleado["fecha_inicio"];
                $fechaFin = $suspension_empleado["fecha_termino"];
                $fechaMostrar = date("d-m-Y", strtotime($fechaInicio));
                while(strtotime($fechaMostrar) <= strtotime($fechaFin)) {
                    $suspensiones_empleado[] = $fechaMostrar;
                    $fechaMostrar = date("d-m-Y", strtotime($fechaMostrar . " + 1 day"));
                }                
            }
        }
    }else{
        echo "<script type='text/javascript'>";
        echo "alert('Error con la conexion de base de datos');";
        echo "</script>";
    }
    //$conexion = $con->close_conexion();  
    return $suspensiones_empleado;
  }

  function getDiasEnVacaciones($id_empleado){
    global $fecha_inicio_semana, $fecha_fin_semana, $conexion, $con;
    $sql = "SELECT * FROM vacaciones_empleados WHERE id_empleado = $id_empleado AND (fecha_inicio OR fecha_termino BETWEEN '$fecha_inicio_semana' AND '$fecha_fin_semana')";
    $vacaciones_empleado = array();
    if($conexion){
        $resultado = $conexion->query($sql);
        if (!empty($resultado)) {
            while($vacacion_empleado = $resultado->fetch_array()){
                $fechaInicio = $vacacion_empleado["fecha_inicio"];
                $fechaFin = $vacacion_empleado["fecha_termino"];
                $fechaMostrar = date("d-m-Y", strtotime($fechaInicio));
                while(strtotime($fechaMostrar) <= strtotime($fechaFin)) {
                    $vacaciones_empleado[] = $fechaMostrar;
                    $fechaMostrar = date("d-m-Y", strtotime($fechaMostrar . " + 1 day"));
                }                
            }
        }
    }else{
        echo "<script type='text/javascript'>";
        echo "alert('Error con la conexion de base de datos');";
        echo "</script>";
    }
    //$conexion = $con->close_conexion();  
    return $vacaciones_empleado;
  }
  
  function obtenerHorasTrabajadas($id_empleado){
    global $fecha_fin_semana, $fecha_inicio_semana, $conexion, $con;
    $sql = "SELECT * FROM trabajo_diario WHERE horas_trabajadas is not null AND id_empleado = '$id_empleado' AND fecha BETWEEN '$fecha_inicio_semana' AND '$fecha_fin_semana'";
    $horas_trabajadas = 0.0;

    if($conexion){
        $resultado = $conexion->query($sql);
        if (!empty($resultado)) {
            while($trabajo_diario = $resultado->fetch_array()){
                $horas_trabajadas = $horas_trabajadas + $trabajo_diario['horas_trabajadas'];       
            }
        }
    }else{
        echo "<script type='text/javascript'>";
        echo "alert('Error con la conexion de base de datos');";
        echo "</script>";
    }
    //$conexion = $con->close_conexion(); 
    return $horas_trabajadas;
  }
  function guardarSueldoSemanal($empleado){
    global $fecha_fin_semana, $fecha_inicio_semana, $dias_festivos, $conexion, $con;
    $id_empleado = $empleado['id'];
    $horas_trabajadas = $empleado['horas trabajadas'];
    $sueldo_semanal = $empleado['sueldo semanal'];
    $sql = "INSERT INTO nomina_semanal (id_empleado, horas_trabajadas, sueldo_total, fecha_inicio, fecha_termino) VALUES ('$id_empleado', '$horas_trabajadas', '$sueldo_semanal', '$fecha_inicio_semana', '$fecha_fin_semana')";
    //$resultado = $conn->query($sql);
    $HORAS_DIARIAS = 8;
    if($conexion){
        $resultado = $conexion->query($sql);
        if (!$resultado) {
            echo "<script type='text/javascript'>";
            echo "alert('Error con la consulta de base de datos');";
            echo "</script>";
        }else{
            $last_id_nomina_semanal = $conexion->insert_id;
            foreach ($dias_festivos as &$valor) {
                $fecha = date("Ymd", strtotime($valor));
                $sueldo_pagado = $empleado['sueldo base']*$HORAS_DIARIAS;
                $sql2 = "INSERT INTO dias_nomina_semanal (id_nomina_semanal, fecha, tipo, pago) VALUES ($last_id_nomina_semanal, $fecha, 'Dia festivo', $sueldo_pagado)";
                $resultado2 = $conexion->query($sql2);

            }

            foreach ($empleado['dias en vacaciones'] as &$valor) {
                $fecha = date("Ymd", strtotime($valor));
                $sueldo_pagado = $empleado['sueldo base']*$HORAS_DIARIAS;
                $sql3 = "INSERT INTO dias_nomina_semanal (id_nomina_semanal, fecha, tipo, pago) VALUES ($last_id_nomina_semanal, $fecha, 'Dia de vacacion', $sueldo_pagado)";
                $resultado3 = $conexion->query($sql3);
            }

            foreach ($empleado['dias en suspension'] as &$valor) {
                $fecha = date("Ymd", strtotime($valor));
                $sql4 = "INSERT INTO dias_nomina_semanal(id_nomina_semanal, tipo, fecha, pago) VALUES ($last_id_nomina_semanal,'Dia de suspension',$fecha,0)";
                $resultado4 = $conexion->query($sql4);
                if (!$resultado4) {
                    echo "<script type='text/javascript'>";
                    echo "alert('Error con el query de base de datos');";
                    echo "</script>";
                }
     
            }
        }
    }else{
        echo "<script type='text/javascript'>";
        echo "alert('Error con la conexion de base de datos');";
        echo "</script>";
    }
    //$conexion = $con->close_conexion();  
}
  calcularSueldosSemanales();
?>