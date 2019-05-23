<?php include("../../resources/html/header_admin_empleados.html");
?>
<nav class="navbar navbar-dark bg-dark"> 
    <div class="container">
    <div id ="encabezado" class="row sticky-top bg-dark text-white shadow-sm">
                <div class="d-flex align-items-center col-2">
                    <a href="indexAdmin.html" ><button type="button" class="btn btn-primary">Regresar</button></a>
                </div>
                <div class="d-flex align-items-center col-10">
                    <h1 align="center">Administraci&oacute;n de Empleados </h1>
                </div>
            </div>
    </div>
</nav>
<body onload="busqueda();">
<a href="registro.html" ><button type="button" class="btn btn-warning">Registrar Empleado</button></a>
    <div class="container p-4">
        <div class="buscador-padre">
            <div class="buscador-hijo">
                    <input type="text" id="txtnom" name="txtnom" class="form-control" placeholder="Buscar empleado..." value="" onkeyup="busqueda();"></input>
                <script type="text/javascript" src="../../resources/js/funciones_buscar_empleados.js"></script>

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


