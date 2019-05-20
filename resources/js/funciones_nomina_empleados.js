function busqueda(){
    var texto = document.getElementById("txtnom").value;
    var parametros = {
        "texto" : texto
    };

    $.ajax({
        data: parametros,
        url: "../../libs/busqueda_nomina_semanal.php",
        type: "POST",
        success: function(response){
            $("#datos").html(response);
        }

    });
}

function validarFecha(fecha_inicio, fecha_fin){
    var fecha_ini = new Date(fecha_inicio);
    var fecha_fini = new Date(fecha_fin);
    if(fecha_ini<=fecha_fini){
        return true;
    }else{
        return false;
    }
}

function busquedaPorFecha(){
    var texto = document.getElementById("txtnom").value;
    var fecha_inicio = document.getElementById("fecha_inicio").value;
    var fecha_fin = document.getElementById("fecha_fin").value;
    //Fechas vacias
    if(fecha_inicio==="" || fecha_fin===""){
        alert("Tienes que llenar la fecha de inicio y de fin");
    }else{
        if(validarFecha(fecha_inicio, fecha_fin)){
            console.log(fecha_fin);
            console.log(fecha_inicio);
            var parametros = {
                "texto" : texto,
                "fecha_inicio" : fecha_inicio,
                "fecha_fin" : fecha_fin
            };
        
            $.ajax({
                data: parametros,
                url: "../../libs/busqueda_nomina_semanal.php",
                type: "POST",
                success: function(response){
                    $("#datos").html(response);
                }
        
            });  
        }else{
            alert("Las fechas no son menores o iguales");
        }
    }
  
}

function validarCalculoNominas(){

}
<?php
  date_default_timezone_set("America/Mexico_City");
  //var_dump(date_default_timezone_get());
  $fecha_hoy = date("d-m-Y");
  $fecha_hoy = date('22-04-2019'); //poner en comentarios
  $fecha_inicio_semana;
  $fecha_fin_semana;
  $dias_festivos = array();
  
  //MAIN
  function calcularSueldosSemanales(){
    global $fecha_hoy, $fecha_fin_semana, $fecha_inicio_semana;
    define('LUNES',1);  
    $dia_hoy = isLunes($fecha_hoy);
    $dias_diferencia = 0;
    if($dia_hoy == LUNES){
      $fecha_inicio_semana = date("Y-m-d",strtotime($fecha_hoy."- 1 week"));
    }else{
      //$dias_diferencia = $dia_hoy - LUNES;
      //$fecha_inicio_semana = date("Y-m-d",strtotime($fecha_hoy."- 1 week - ".$dias_diferencia." days"));
    }
    $fecha_fin_semana = date("Y-m-d",strtotime($fecha_inicio_semana."+ 4 days"));
    if(!isNominaSemanalCalculada()){
      calcularDiasFestivosEnSemana();
      calcularSueldoEmpleadoSemanal();
      echo "<script type='text/javascript'>";
      echo "alert('Nomina semanal calculada correctamente');";
      echo "</script>";
    }else{
      echo "<script type='text/javascript'>";
      echo "alert('Ya se calculó previamente el sueldo de esta semana');";
      echo "</script>";
    }
    require("views/calculo_nominas_vista.html");
  }
  function isLunes($fecha){
    $fechats = strtotime($fecha); //pasamos a timestamp
    //el parametro w en la funcion date indica que queremos el dia de la semana
    //lo devuelve en numero 0 domingo, 1 lunes,....
    switch (date('w', $fechats)){
      case 1: return true; break;
      case 0:
      case 2: 
      case 3: 
      case 4: 
      case 5:
      case 6: return false; break;
    }
  }

  function isNominaSemanalCalculada(){
    include 'conexion.php';
    $sql = "SELECT * FROM nomina_semanal WHERE fecha_inicio = '$fecha_inicio_semana' AND fecha_termino = '$fecha_fin_semana'";
    $resultado = $conn->query($sql);
    while($trabajo_diario = $resultado->fetch_assoc()){
      echo "si esta calculado";
      $conn->close();
      return true;
    }
    echo "No esta calculado";
    $conn->close();
    return false;
  }

  function calcularDiasFestivosEnSemana(){
    include 'conexion.php';
    global $fecha_inicio_semana, $fecha_fin_semana, $dias_festivos;
    $sql = "SELECT * FROM dias_festivos WHERE fecha BETWEEN '$fecha_inicio_semana' AND '$fecha_fin_semana'";
    $resultado = $conn->query($sql);
    while( $dia_festivo = $resultado->fetch_assoc()){
      $dias_festivos[] = date("d-m-Y", strtotime($dia_festivo["fecha"]));
    }
    $conn->close();
  }

  function calcularSueldoEmpleadoSemanal()
  {
    include 'conexion.php';
    global $dias_festivos;
    $EMPLEADO_BAJA = 2;
    $HORAS_DIARIAS = 8;
    $sql = "SELECT * FROM empleados WHERE id_estado != $EMPLEADO_BAJA";
    $resultado = $conn->query($sql);
    
    while( $empleado = $resultado->fetch_assoc()){
      $empleado_info = array();
      $empleado_info['id'] = $empleado['id'];
      $empleado_info['nombre'] = $empleado['nombre'];
      $empleado_info['apellido'] = $empleado['apellido'];
      $empleado_info['sueldo base'] = $empleado['sueldo_base'];
      $empleado_info['id estado'] = $empleado['id_estado'];
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
      var_dump($empleado_info);
      echo "sueldo semanal   ".$empleado_info['sueldo semanal'];
      guardarSueldoSemanal($empleado_info);
    }
    //var_dump(sizeof($dias_festivos));
    $conn->close();
  }

  function getDiasEnVacaciones($id_empleado){
    include 'conexion.php';
    global $fecha_inicio_semana, $fecha_fin_semana;
    $sql = "SELECT * FROM vacaciones_empleados WHERE id_empleado = $id_empleado AND fecha_inicio OR fecha_termino BETWEEN '$fecha_inicio_semana' AND '$fecha_fin_semana'";
    $resultado = $conn->query($sql);
    $vacaciones_empleado = array();
    while( $vacacion_empleado = $resultado->fetch_assoc()){
      $fechaInicio = $vacacion_empleado["fecha_inicio"];
      $fechaFin = $vacacion_empleado["fecha_termino"];
      $fechaMostrar = date("d-m-Y", strtotime($fechaInicio));
      while(strtotime($fechaMostrar) <= strtotime($fechaFin)) {
        $vacaciones_empleado[] = $fechaMostrar;
        $fechaMostrar = date("d-m-Y", strtotime($fechaMostrar . " + 1 day"));
      }
    }
    $conn->close();
    return $vacaciones_empleado;
  }
  
  function obtenerHorasTrabajadas($id_empleado){
    include 'conexion.php';
    global $fecha_fin_semana, $fecha_inicio_semana;//CHECAR
    $sql = "SELECT * FROM trabajo_diario WHERE en_nomina = 'SI' AND id_empleado = '$id_empleado' AND fecha BETWEEN '$fecha_inicio_semana' AND '$fecha_fin_semana'";
    $resultado = $conn->query($sql);
    $horas_trabajadas = 0;
    while($trabajo_diario = $resultado->fetch_assoc()){
      var_dump($trabajo_diario);
      $horas_trabajadas = $horas_trabajadas + $trabajo_diario['horas_trabajadas'];
    }
    $conn->close();
    return $horas_trabajadas;
  }
  function guardarSueldoSemanal($empleado){
    include 'conexion.php';
    global $fecha_fin_semana, $fecha_inicio_semana, $dias_festivos;
    $num_dias_festivos = sizeof($empleado['dias festivos y vacaciones']);
    $id_empleado = $empleado['id'];
    $horas_trabajadas = $empleado['horas trabajadas'];
    $sueldo_semanal = $empleado['sueldo semanal'];
    $sql = "INSERT INTO nomina_semanal (id_empleado, horas_trabajadas, sueldo_total, dias_festivos, fecha_inicio, fecha_termino) VALUES ('$id_empleado', '$horas_trabajadas', '$sueldo_semanal', '$num_dias_festivos', '$fecha_inicio_semana', '$fecha_fin_semana')";
    $resultado = $conn->query($sql);
    $conn->close();
  }
  calcularSueldosSemanales();

?>