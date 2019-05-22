<?php include("../../resources/html/header_admin_empleados.html");
?>
<nav class="navbar navbar-dark bg-dark"> 
    <div class="container">
        <a href=""  class="navbar-brand">Solución de Pendientes de Empleados</a>
    </div>
</nav>
<body onload="mostrarPendientes();">
    <div class="container p-4">
        <div class="buscador-padre">
            <div class="buscador-hijo">
                <script type="text/javascript" src="../../resources/js/funciones_solucionar_pendientes.js"></script>
            </div>
        </div>
        <div id="datos">
        </div>
        <div class="row">  

            <div  id = "datos" class="col-md-8">
            </div>
        </div>

    </div> 

    <?php require("../../resources/html/footer_admin_empleados.html");?>
</body>