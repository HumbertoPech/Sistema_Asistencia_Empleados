<?php
include("../../core/conexion.php");
$con = new Conexion();
$conexion = $con->get_conexion(); 
$id;
if(isset($_GET['id_trabajo_diario'])){
    $id = $_GET['id_trabajo_diario'];
    //$conexion = $con->close_conexion();
}

if(isset($_POST["dato_final"])){
    
    $dato_final = $_POST['dato_final'];
    $tipo = $_POST['tipo'];
    $descripcion = $_POST['descripcion'];
    $id = $_POST['id'];
    $query = "INSERT into solucion_pendientes (id_trabajo_diario, dato_original, dato_final, tipo, descripcion) values ($id, '$dato_final', '$dato_final', '$tipo', '$descripcion')";
    if($conexion){
        $resultado = $conexion->query($query);
        $query2 = "SELECT * from  trabajo_diario where id = $id";
        $resultado2 = $conexion->query($query2);

        while($row = $resultado2->fetch_array()){
            $query3="";
            if(!isset($row['hora_entrada'])){
                
                $query3 = "UPDATE trabajo_diario SET hora_entrada ='$dato_final' where id = $id";
            }else if(!isset($row['hora_salida'])){
                $query3 = "UPDATE trabajo_diario SET hora_salida ='$dato_final' where id = $id";
            }
            $resultado3 = $conexion->query($query3);
            calcularHorasDiarias($id);
            

        }
        header("Location: modulo_pendientes.php");

    }
}

function calcularHorasDiarias($id){
	global $conexion;
	$query= "SELECT * FROM trabajo_diario WHERE id = '$id'";
    $resultado = $conexion->query($query);
    while($registro = $resultado->fetch_array()){
        if($resultado){
            $registroEntrada= new DateTime($registro['hora_entrada']);
            $registroSalida = new DateTime($registro['hora_salida']);
    
            if($registroEntrada!= NULL && $registroSalida != NULL ){
                
                    $intervaloTrabajado= $registroEntrada->diff($registroSalida);
                    $horasTrabajadas = $intervaloTrabajado->format("%H.%i");//08.30		
                    //Descontar los minutos que se pasó del horario de entrada			
                    $intervaloTrabajado= $registroEntrada->diff($registroSalida);//Calcular cuantas horas trabajó sin el retardo 
                    //Unidades de horas trabajadas= horas. Los minutos se transforman en unidades de horas.
                    $horasTrabajadas = (($intervaloTrabajado->h)-1) + (($intervaloTrabajado->i)/60);//Descontarle 1 hora al total de horas trabajadas.

                    
                    $query= "UPDATE `trabajo_diario` SET `horas_trabajadas`= ' ".$horasTrabajadas."' WHERE `id`= '".$id."'";
                    $resultado = $conexion->query($query);
                    if($resultado){
                        echo "Exito";
                        return true;
                    }
                    return false;
    
            }else{
            return false;
            }
        }else{
    
            echo "Empleado o fecha no existente";
            return false;
        }
    }


}
include("../../resources/html/header_admin_empleados.html");?>
<script type="text/javascript" src="../../resources/js/funciones_solucionar_pendientes.js"></script>
<h1 hidden id="text"><?php echo $id ?></h1>

<div class="container-fluid">
<div id ="encabezado" class="row sticky-top bg-dark text-white shadow-sm">
                <div class="d-flex align-items-center col-2">
                    <a href="modulo_pendientes.php" ><button type="button" class="btn btn-primary">Regresar</button></a>
                </div>
                <div class="d-flex align-items-center col-10">
                    <h1 align="center">Solucionar pendiente </h1>
                </div>
            </div>
    <div class="row">
        <div class="col-md-6 mx-auto">
            <div class="card card-body">
                <form action=<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?> method="post">
                    <p hidden id="hora_ini">Dato original:</p>
                    <input type="hidden" id="id" name="id" value=<?php echo $id?>>
                    <p>Dato final: <input type="time" name = "dato_final" id="dato_final" min="08:00" max="20:00" step="600" required></p>
                    <label>Tipo de pendiente:</label>
                    <SELECT NAME="tipo" name="tipo" id="tipo" SIZE=1> 
                        <OPTION VALUE="E">Entrada</OPTION>
                        <OPTION VALUE="S">Salida</OPTION> 
                    </SELECT> 
                    <p>Descripción de solución: <input type="text" name="descripcion" id="descripcion"></p>
                    <input type="submit">
                </form>
            </div>
        </div>
    </div>
</div>
<?php require("../../resources/html/footer_admin_empleados.html");?>

