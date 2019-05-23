<?php include("../../resources/html/header_admin_empleados.html");
?>

<body onload="mostrarPendientes();">
    <div class="container-fluid">
    <div id ="encabezado" class="row sticky-top bg-dark text-white shadow-sm">
                <div class="d-flex align-items-center col-2">
                    <a href="indexAdmin.html" ><button type="button" class="btn btn-primary">Regresar</button></a>
                </div>
                <div class="d-flex align-items-center col-10">
                    <h1 align="center">Pendientes </h1>
                </div>
            </div>
            <nav class="navbar navbar-dark bg-dark"> 
    <div class="container">
        <a href=""  class="navbar-brand">Solución de Pendientes de Empleados</a>
    </div>
</nav>
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