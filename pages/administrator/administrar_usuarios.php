<?php include("../../core/conexion.php") ?>
<?php include("../includes/header.php");
$estados_nombres = array();
$estados_nombres[1]="Activo";
$estados_nombres[2]="Baja";
$estados_nombres[3]="Suspendido";
$estados_nombres[4]="Vacaciones";
session_start();
?>
  
<div class="container p-4">

    <div class="row">  

        <div class="col-md-8">
            <table class="table table-bordered">
                <thead>

                    <tr>
                        <th>Nombre</th>
                        <th>Estado</th>
                        <th>Ver</th>
                        <th>Vacaciones</th>
                        <th>Suspencion</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $query = "SELECT id, nombre, id_estado FROM empleados";
                    $resultado =  mysqli_query($conn, $query);
                    while($row = mysqli_fetch_array($resultado)){ ?>
                            <tr>
                                <td> <?php echo $row['nombre']?> </td>
                                <td> <?php echo $row['id_estado'].$estados_nombres[$row['id_estado']] ?> </td>
                                <td>
                                    <a href="edit.php?id=<?php echo $row['id']?>" class="btn btn-secondary">
                                    <i class="fas fa-eye"></i>
                                    </a>
                                </td>
                                <td>
                                    <a href="vacas.php?id=<?php echo $row['id']?>" class="btn btn-secondary">
                                    <i class="fas fa-plane"></i>
                                    </a>
                                </td>
                                <td>
                                    <a href="suspen.php?id=<?php echo $row['id']?>" class="btn btn-secondary">
                                    <i class="fas fa-calendar-times"></i>
                                    </a>
                                </td>
                            </tr>
                    <?php } ?>
                </tbody>

            </table>
        
        
        </div>
    
    </div>

</div> 

<?php include("includes/footer.php") ?>

