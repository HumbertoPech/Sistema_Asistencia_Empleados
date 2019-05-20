function busqueda(){
    var texto = document.getElementById("txtnom").value;
    var parametros = {
        "texto" : texto
    };

    $.ajax({
        data: parametros,
        url: "../../libs/busqueda_nomina_semanal.php",
        type: "POST",
        success: function(response){
            $("#datos").html(response);
        }

    });
}

function validarFecha(fecha_inicio, fecha_fin){
    var fecha_ini = new Date(fecha_inicio);
    var fecha_fini = new Date(fecha_fin);
    if(fecha_ini<=fecha_fini){
        return true;
    }else{
        return false;
    }
}

function busquedaPorFecha(){
    var texto = document.getElementById("txtnom").value;
    var fecha_inicio = document.getElementById("fecha_inicio").value;
    var fecha_fin = document.getElementById("fecha_fin").value;
    //Fechas vacias
    if(fecha_inicio==="" || fecha_fin===""){
        alert("Tienes que llenar la fecha de inicio y de fin");
    }else{
        if(validarFecha(fecha_inicio, fecha_fin)){
            console.log(fecha_fin);
            console.log(fecha_inicio);
            var parametros = {
                "texto" : texto,
                "fecha_inicio" : fecha_inicio,
                "fecha_fin" : fecha_fin
            };
        
            $.ajax({
                data: parametros,
                url: "../../libs/busqueda_nomina_semanal.php",
                type: "POST",
                success: function(response){
                    $("#datos").html(response);
                }
        
            });  
        }else{
            alert("Las fechas no son menores o iguales");
        }
    }
  
}