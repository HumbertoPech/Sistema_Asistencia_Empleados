<?php
include("../../core/conexion.php");
$con = new Conexion();
$conexion = $con->get_conexion(); 

/*if(isset($_GET['id_trabajo_diario'])){
    $id = $_GET['id_trabajo_diario'];
    $query = "SELECT emp.*, vac.fecha_inicio as fecha_inicio_vac, vac.fecha_termino as fecha_termino_vac, susp.fecha_inicio as fecha_inicio_susp, susp.fecha_termino as fecha_termino_susp FROM empleados emp left join vacaciones_empleados vac on emp.id = vac.id_empleado left join suspension_empleados susp on emp.id = susp.id_empleado WHERE emp.id = $id";
    //$conexion = $con->get_conexion(); 
    if($conexion){
        $resultado = $conexion->query($query);

        while($row = $resultado->fetch_assoc()){
            $estad = $row['id_estado'];
            $nombre = $row['nombres']." ".$row['apellidos'];
            $sueldo= $row['sueldo_base'];
        }
    }
    //$conexion = $con->close_conexion();
}*/


if(isset($_POST['solucionar'])){
    $id=$_GET['id_trabajo_diario'];
    $query = "INSERT into solucion_pendientes(id_trabajo_diario, dato_original, dato_final, tipo, descripcion) VALUES ($id,20190501, 20190505, 'e', 'nada mas')";
    if($conexion){
        var_dump($result);
        $resultado = $conexion->query($query);
    }
    var_dump($result);

}

?>
<?php include("../../resources/html/header_admin_empleados.html");?>
<div class="container p-4">
    <div class="row">
        <div class="col-md-6 mx-auto">
            <div class="card card-body">
                <form id="combo" name="combo">
                <label for="" class="control-label">Solucionar pendiente</label>                 
                    <a href="#" class="btn btn-success text-white" name="solucionar" id="boton" data-type="solucionar_pendiente" data-id="<?php echo $_GET['id_trabajo_diario'];?>">
                        Solucionar pendiente
                    </a>
                </form>
            </div>
        </div>
    </div>
</div>
<?php require("../../resources/html/footer_admin_empleados.html");?>
