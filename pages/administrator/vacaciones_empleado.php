<?php
include("../../core/conexion.php");
$con = new Conexion();
$conexion = $con->get_conexion(); 

if(isset($_GET['id_usuario'])){
    $id = $_GET['id_usuario'];
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
}


if(isset($_GET['update'])){

    $id=$_GET['id_usuario'];
    $gestor = fopen("bitacora.txt","a+");
    
    $fecha_inicio = new DateTime($_GET['fecha_inicio']);
    $fecha_inicio = $fecha_inicio->format('Y-m-d');
    $fecha_termino = new DateTime($_GET['fecha_termino']);
    $fecha_termino = $fecha_termino->format('Y-m-d');

    $query = "INSERT into vacaciones_empleados(id_empleado, fecha_inicio, fecha_termino) VALUES ($id,'$fecha_inicio', '$fecha_termino')";
    fwrite($gestor,"QUERY=>$query");
    if($conexion){
        //var_dump($result);
        $resultado = $conexion->query($query);
    }
}

if (isset($_POST['delete'])) {
    if($conexion){
        $query = "SELECT id from vacaciones_empleados where id_empleado = ".$_POST['id_empleado']." order by id desc limit 1";
        $resultado = $conexion->query($query);
        $last = mysqli_fetch_array($resultado);
        $query2 = "DELETE from vacaciones_empleados where id = ".$last['id']."";
        $resultado2 = $conexion->query($query2);

    }
}

?>


<?php include("../../resources/html/header_admin_empleados.html");?>
<div class="container-fluid">
<div id ="encabezado" class="row sticky-top bg-dark text-white shadow-sm">
                <div class="d-flex align-items-center col-2">
                    <a href="administrar_empleados.php" ><button type="button" class="btn btn-primary">Regresar</button></a>
                </div>
                <div class="d-flex align-items-center col-10">
                    <h1 align="center">Vacaciones </h1>
                </div>
            </div>
    <h2><?php echo $nombre; ?></h2>
    <div class="row">
        <div class="col-md-6 mx-auto">
            <div class="card card-body">
                <form id="combo" name="combo">
                <label for="" class="control-label">Agregar periodo vacacional</label>
                    <div class="form-group">
                        <label for="" class="control-label">Selecciona fecha inicio: </label>
                        <input class="form-control" id="fecha_inicio" name="fecha_inicio" type="date" value="">
                    </div>
                    <div class="form-group">
                        <label for="" class="control-label">Selecciona fecha termino: </label>
                        <input class="form-control" type="date" name="fecha_termino" id="fecha_termino" value="">
                    </div>
                    
                    <a onclick = "enviar()"  class="btn btn-success text-white" name="update" id="boton" data-type="vacaciones_empleado" data-id="<?php echo $_GET['id_usuario'];?>">
                        Update
                    </a>
                
                </form>
            </div>
        </div>
    </div>
</div>
<script>
function enviar(){
    console.log("paso");
    console.log(document.getElementById('fecha_inicio').value);
    if(document.getElementById('fecha_inicio').value=="" || document.getElementById('fecha_termino').value==""){
        alert("Seleccione fechas");
        return;
    }
    window.location.href="?id_usuario="+document.getElementById('id_user').value + "&update=true&fecha_inicio="+document.getElementById('fecha_inicio').value+"&fecha_termino="+document.getElementById('fecha_termino').value;
}
</script>
<div class="container p-6">
    <div class="row">
        <div class="col-md-9">
            <div id="success-alert" class="alert alert-success alert-dismissible fade" role="alert">
                <strong>OK!</strong> Se ha agregado un nuevo registro.
                
            </div>
            <table class="table table-bordered" id="tabla">
                <thead>
                    <tr>
                        <th>ID Empleado</th>
                        <th>Inicio</th>
                        <th>Termino</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $query = "SELECT id_empleado, fecha_inicio, fecha_termino FROM vacaciones_empleados where id_empleado =".$_GET['id_usuario'];
                        $counter = 0;
                        //$conexion = $con->get_conexion(); 
                        if($conexion){
                            $resultado = $conexion->query($query);
                            $numResults = mysqli_num_rows($resultado);
                            if($resultado){
                                while($row = $resultado->fetch_assoc()){
                                    ?>
                                    <tr>
                                        <td> <?php echo $row['id_empleado']?> </td>
                                        <td> <?php echo $row['fecha_inicio']?> </td>
                                        <td> <?php echo $row['fecha_termino']?> </td>
                                        <td>
                                            <?php 
                                                if (++$counter == $numResults) {
                                                    echo '<button id="delete-button" type="button" class="btn btn-outline-danger" data-type="vacaciones_empleado" data-id="'.$row['id_empleado'].'">Eliminar</button>';
                                                }
                                            ?>
                                        </td>
                                    </tr>
                            <?php }
                            }
 
                            
                        }
                        //$conexion = $con->close_conexion();?>

                </tbody>
            </table>
        </div>
    </div>
</div>


<?php require("../../resources/html/footer_admin_empleados.html");
echo "<button id='id_user' type='hidden' value='$id'></button>";?>
