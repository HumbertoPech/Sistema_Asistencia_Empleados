<?php
include("../../core/conexion.php");
$con = new Conexion();
$conexion = $con->get_conexion(); 
$id;
if(isset($_GET['id_trabajo_diario'])){
    $id = $_GET['id_trabajo_diario'];
    //$conexion = $con->close_conexion();
}

if(isset($_POST['id'])){
    $id = $_POST['id'];
}
if(isset($_POST["dato_final"])){
    
    $dato_final = $_POST['dato_final'];
    $tipo = $_POST['tipo'];
    $descripcion = $_POST['descripcion'];
    $id = $_POST['id'];
    var_dump($descripcion);

    $query = "INSERT into solucion_pendientes (id_trabajo_diario, dato_original, dato_final, tipo, descripcion) values ($id, null,null, '$tipo', '$descripcion')";
    $query = "INSERT into 'solucion_pendientes' ('id_trabajo_diario', 'dato_original', 'dato_final', 'tipo', 'descripcion') values (3, '05:00:00','22:00:00', 'E', 'mi mama')";

    $query = "INSERT INTO `solucion_pendientes` (`id`, `id_trabajo_diario`, `dato_original`, `dato_final`, `tipo`, `descripcion`) VALUES (NULL, '2', '09:00:00', '19:00:00', 'E', 'SDFSDF')";
    //$query = "INSERT INTO 'trabajo_diario' ('id', 'id_empleado', 'en_nomina', 'hora_entrada', 'hora_salida', 'fecha', 'horas_trabajadas') VALUES (NULL, '1', '', '05:00:00', '22:00:00', '2019-05-20', NULL)";
    if($conexion){
        $resultado = $conexion->query($query);
        var_dump($resultado);
        $query2 = "UPDATE trabajo_diario SET hora_salida ='$dato_final' where id = $id  ";
        $resultado2 = $conexion->query($query2);
    }
}


?>
<?php include("../../resources/html/header_admin_empleados.html");?>
<script type="text/javascript" src="../../resources/js/funciones_solucionar_pendientes.js"></script>
<h1 hidden id="text"><?php echo $id?></h1>

<div class="container p-4">
    <div class="row">
        <div class="col-md-6 mx-auto">
            <div class="card card-body">
                <form action=<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?> method="post">
                    <p hidden id="hora_ini">Dato original:</p>
                    <input type="hidden" id="id" name="id" value=<?php$id?>>
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

