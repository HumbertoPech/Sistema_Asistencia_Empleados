<?php
  session_start();
  //dato de prueba
?>
<!DOCTYPE html>
<html>
<head>
  <link rel="stylesheet" href="../../resources/css/login.css">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <!--//Revisar la ruta donde estarán los js //-->
  <script src="../../resources/js/ajaxEmpleado.js"></script>
</head>
<body>
  <div class="container-fluid">
    <div class="box-signout">
      <a href="loginEmpleado.html"><button class=" btn-dark btn-signout"><i class="fa fa-sign-out fa-2x"></i><br>Cerrar Sesión</button></a> 
    </div>
     
    <div class="row justify-content-center">   
      <div class="col-md-8 buttons-box justify-content-center">
        <button class="btn-icon" id="registrarEntrada" style="display:none;"><i class="fa fa-calendar-check-o fa-5x"></i><br> Registrar Entrada</button>
        <button class="btn-icon" id="registrarSalida"  style="display:none;"><i class="fa fa-calendar-times-o fa-5x"></i><br> Registrar Salida</button>
        <button class="btn-icon" onclick= "location.href='cambioContraseña.php'"> <i class="fa fa-key fa-5x"></i><br> Cambiar Contraseña</button>
      </div> 
          
    </div>
  </div>
</body>
</html> 

<script language="JavaScript">
  window.onload= function () {
    
    if(verificarEstadoEmpleado()){
      verificarHorarios();
    }   

    document.getElementById("registrarEntrada").onclick= function(){      
          registrar("checkIn");
    }
    document.getElementById("registrarSalida").onclick=function () {
          registrar("checkOut");
      };
  }

</script>
