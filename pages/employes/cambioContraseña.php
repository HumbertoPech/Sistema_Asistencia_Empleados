<?php
session_start();
//dato de prueba
$_SESSION['id_usuario']= '1';
?>

<!DOCTYPE html>
<html>
<head>
   <meta charset="UTF-8">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous"> 
  <link rel="stylesheet" href="../../resources/css/login.css">

    <!--//Revisar la ruta donde estarán los js //-->
  <script src="../../resources/js/ajaxEmpleado.js"></script>

</head>
<body>
<div class="container">
   <div class="box-signout">
      <button class="btn-signout" onclick="location.href='indexEmpleado.html'"><i class="fa fa-sign-out fa-2x"></i><br>Regresar</button> 
  </div>

  <div class="card card-container">

    <form class="form-signin" id="cambioPassword" method="POST">
      <label>
        <h2>Cambio Contrase&ntilde;a</h2>
      </label>
      <span id="reauth-email" class="reauth-email"></span>
        <div id="panel" style="display: none">
            <p id="error-panel-message"></p>
        </div>
      <input type="password" name="currentPassword" class="form-control" placeholder="Contrase&ntilde;a actual" required>
      <input type="password" name="newPassword" id="newPassword" class="form-control" placeholder="Contrase&ntilde;a nueva"
             required onkeyup="validarPassword()">
            <label id='size-message'></label>

      <input type="password" name="repeatNewPassword" id="repeatNewPassword" class="form-control" placeholder="Repetir contrase&ntilde;a nueva"
             required onkeyup=" validarPassword()">
        <label id='match-message'></label>
      <button class="btn btn-lg btn-primary btn-block btn-signin" id="cambiarPassword" type="submit" >Cambiar</button>
    </form>               
  </div>
</div>
</body>
</html>

<script language="JavaScript">
  window.onload= function () {

      document.getElementById("cambioPassword").onsubmit=function () {
          if (validarFormulario(this)){
            //verificarnombre de las carpetas y la ruta
              urlLocation= "http://localhost/Sistema_Asistencia_Empleados/libs/operacionesEmpleados.php";
              cambiarContrasenia("POST",urlLocation,this);
          }else{
              alert("Error en contrase\u00f1a nueva.Rellenar bien el formulario");
          }
      };
  }

  function validarPassword(form) {
      var maxCaracteres=6;
      if(document.getElementById("newPassword").value.length < maxCaracteres){
          document.getElementById("size-message").textContent= "Demasiado corta. Minimo 6 caracteres";
      }else{
          document.getElementById("size-message").textContent= "Buena";
      }
      if(document.getElementById("newPassword").value !== document.getElementById("repeatNewPassword").value) {
          document.getElementById("match-message").textContent= "Las contrase\u00f1as no coinciden";
      }else{
          document.getElementById("match-message").textContent= "";
      }
  }

</script>
