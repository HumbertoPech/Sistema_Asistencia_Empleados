function busqueda(){
    var texto = document.getElementById("txtnom").value;
    var parametros = {
        "texto" : texto
    };
    $.ajax({
        data: parametros,
        url: "../../libs/busqueda_empleados.php",
        type: "POST",
        success: function(response){
            $("#datos").html(response);
        }

    });
}