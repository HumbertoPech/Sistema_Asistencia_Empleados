<?php include("../../resources/html/header_admin_empleados.html");
?>
<nav class="navbar navbar-dark bg-dark"> 
    <div class="container">
        <a href=""  class="navbar-brand">Administración de Empleados</a>
    </div>
</nav>
<body onload="busqueda();">
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


