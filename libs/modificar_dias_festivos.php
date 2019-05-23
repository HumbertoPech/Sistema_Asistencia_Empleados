<?php
    date_default_timezone_set("America/Mexico_City");
    $fecha_hoy = date("Y-m-d");

    include '../core/conexion.php';
    if(isset($_POST['submit']))
    {
        if(isset($_POST['fecha_entrada'])){
            $dateSelected = $_POST['fecha_entrada'];
            if($dateSelected == ""){
                ?>
                <script>
                    alert('No has seleccionado una fecha'); 
                </script>
                <?php
            }else{
                $id = $_POST['varname'];
                modificarDiaFestivo($dateSelected, $id);    
            }
        }else{
            echo "No se seleccionó fecha";
        }?>
        
        <script> 
            window.location.href='../pages/administrator/mostrar_dias_festivos.php';
        </script>
        <!--<script>
            alert('El Registro ha sido Modificado'); 
            window.location.href='mostrar_dias_festivos.php';
        </script>-->
<?php
    }
    function isDiaFestivoRegistrado($dateSelected){
        $sql = "SELECT * FROM dias_festivos where fecha = '$dateSelected'";
        //$sql = "SELECT * FROM dias_festivos where fecha = '$dateSelected'";
        $con = new Conexion();
        $conexion = $con->get_conexion(); 
        if($conexion){
            $resultado = $conexion->query($sql);
    
            while($dia_festivo_registrado = $resultado->fetch_assoc()){
                $conexion = $con->close_conexion();
    
                return true;
            }
            return false;
        }
        return false;
    }
    function modificarDiaFestivo($dateSelected, $id){
        global $fecha_hoy;
        if ($dateSelected > $fecha_hoy){
            if(!isDiaFestivoRegistrado($dateSelected)){
                $sql = "UPDATE dias_festivos SET fecha = '$dateSelected' WHERE id = '$id'";
                $con = new Conexion();
                $conexion = $con->get_conexion(); 
                if($conexion){
                    $resultado = $conexion->query($sql);
                }
                ?>
                <script>
                    alert('Dia actualizado correctamente'); 
                </script>
                <?php
            }else{
                ?>
                <script>
                    alert('El dia festivo ya estaba registrado en la base de datos'); 
                </script>
                <?php              
            }
        }else{
            ?>
            <script>
                alert('No puedes elegir una fecha menor o igual a la actual'); 
            </script>
            <?php               
        }
    }
?>

