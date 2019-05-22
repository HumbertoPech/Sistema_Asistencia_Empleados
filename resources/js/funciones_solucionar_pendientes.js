
function mostrarPendientes(){
    var texto ="j";
    var parametros = {
        "texto" : texto
    };
    $.ajax({
        data: parametros,
        url: "../../libs/ver_pendientes.php",
        type: "POST",
        success: function(response){
            $("#datos").html(response);
        }

    });
}

function solucionarPendiente(){
}


