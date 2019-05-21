<?php
  session_start();
  //dato de prueba
?>
<!DOCTYPE html>
<html>
<head>
  <link rel="stylesheet" href="../../resources/css/login.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <!--//Revisar la ruta donde estarán los js //-->
  <script src="../../resources/js/ajaxEmpleado.js"></script>
</head>
<body>
  <div class="container">
    <div class="box-signout">
      <button class="btn-signout"><i class="fa fa-sign-out fa-2x"></i><br>Cerrar Sesión</button> 
    </div>
     
    <div class="row">
      <div class="col-md-12 buttons-box"> 
        <button class="btn-icon" id="registrarEntrada" disabled><i class="fa fa-calendar-check-o fa-5x"></i><br> Registrar Entrada</button>

        <button class="btn-icon" id="registrarSalida"  disabled><i class="fa fa-calendar-times-o fa-5x"></i><br> Registrar Salida</button>
        <button class="btn-icon" onclick= "location.href='cambioContraseña.php'"> <i class="fa fa-key fa-5x"></i><br> Cambiar Contraseña</button>
      </div>    
    </div>
  </div>
</body>
</html> 

<script language="JavaScript">
  window.onload= function () {
    
    document.getElementById("registrarSalida").disabled=false;
    //escribir funcion para verificar la hora de entrada o de salida y ver que botón se activa
    document.getElementById("registrarSalida").onclick=function () {
      urlLocation= "http://localhost/Sistema_Asistencia_Empleados/libs/operacionesEmpleados.php";
          registrar(urlLocation, "checkOut");
      };
  }

</script>
