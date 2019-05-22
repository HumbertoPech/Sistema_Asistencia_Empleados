
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
    id = document.getElementById("text").innerHTML;
    dato_original = document.getElementById("hora_original").value; //SI ES IN / OUT
    dato_final = document.getElementById("dato_final").value;
    tipo = document.getElementById("tipo").value;
    descripcion = document.getElementById("descripcion").value;
    console.log(id);
    var parametros = {
        "id" : id,
        "dato_original" : dato_original,
        "dato_final" : dato_final,
        "tipo" : tipo,
        "descripcion" : descripcion
    };
    $.ajax({
        data: parametros,
        url: "../../pages/administrator/solucionar_pendiente.php",
        type: "POST"
    });
}



