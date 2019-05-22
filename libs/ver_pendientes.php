<?php
require '../core/conexion.php';
//session_start();
$con = new Conexion();
$conexion = $con->get_conexion();  

/*if($_POST["texto"] != ""){

}*/

$query = "SELECT td.id, td.hora_entrada, td.en_nomina, td.hora_salida, td.fecha, td.horas_trabajadas, emp.id as id_emp, emp.nombres, emp.apellidos from trabajo_diario td inner join empleados emp on emp.id = td.id_empleado where td.horas_trabajadas is null";
$tmp = "<table class='table table-bordered'>
            <tr>
            <th>Nombre de Empleado</th>
                <th>En nómina</th>
                <th>Hora Entrada</th>
                <th>Hora Salida</th>
                <th>Fecha</th>
                <th>Horas Trabajadas</th>
                <th>Solucionar</th>

            </tr>";

if($conexion){
    $resultado = $conexion->query($query);
    if (!empty($resultado)) {
        while($row = $resultado->fetch_array()){
            $tmp.="<tr><td>".$row['nombres']." ".$row['apellidos']."</td>";
            $tmp.="<td>".$row['en_nomina']."</td>
            <td>".$row['hora_entrada']."</td>
            <td>".$row['hora_salida']."</td>
            <td>".$row['fecha']."</td>
            <td>".$row['horas_trabajadas']."</td>
            <td>
            <div class='modal fade' id='modalForm' role='dialog'>
            <div class='modal-dialog'>
                <div class='modal-content'>
                    <!-- Modal Header -->
                    <div class='modal-header'>
                        <button type='button' class='close' data-dismiss='modal'>
                            <span aria-hidden='true'>&times;</span>
                            <span class='sr-only'>Close</span>
                        </button>
                        <h4 class='modal-title' id='myModalLabel'>Solucionar Pendintes</h4>
                    </div>
                    
                    <!-- Modal Body -->
                    <div class='modal-body'>
                        <p class='statusMsg'></p>
                        <form role='form'>
                            <div class='form-group'>
                                <label for='inputName'>Name</label>
                                <input type='text' class='form-control' id='inputName' placeholder='Enter your name'/>
                            </div>
                            <div class='form-group'>
                                <label for='inputEmail'>Email</label>
                                <input type='email' class='form-control' id='inputEmail' placeholder='Enter your email'/>
                            </div>
                            <div class='form-group'>
                                <label for='inputMessage'>Message</label>
                                <textarea class='form-control' id='inputMessage' placeholder='Enter your message'></textarea>
                            </div>
                        </form>
                    </div>
                    
                    <!-- Modal Footer -->
                    <div class='modal-footer'>
                        <button type='button' class='btn btn-default' data-dismiss='modal'>Close</button>
                        <button type='button' class='btn btn-primary submitBtn' onclick=''>SUBMIT</button>
                    </div>
                </div>
            </div>
            </div>
            <!-- Button to trigger modal -->
            <button class='btn btn-success btn-lg' data-toggle='modal' data-target='#modalForm'>
                Open Contact Form
            </button>
        </td>";
            $tmp.="</tr>";     
        }
        $tmp.="</table>";
        echo $tmp;
    }
}

$conexion = $con->close_conexion();  


?>          