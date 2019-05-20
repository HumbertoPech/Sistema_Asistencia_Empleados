
function cambiarContrasenia(method, url,form) {
    
    var xhttp;
    var data= new FormData(form);
    data.append("operacion","cambio");
    if (window.XMLHttpRequest) {
        // code for modern browsers
        xhttp = new XMLHttpRequest();
    } else {
        // code for IE6, IE5
        xhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            var respuesta= xhttp.responseText;
            alert(respuesta);
        }
    }
    xhttp.open("POST", url,true);
    xhttp.send(data);
}

function registrar(url,tipoRegistro){
    var xhttp;
    var data= new FormData();
    data.append("operacion",tipoRegistro);
    if (window.XMLHttpRequest) {
        // code for modern browsers
        xhttp = new XMLHttpRequest();
    } else {
        // code for IE6, IE5
        xhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            var respuesta= xhttp.responseText;
            alert(respuesta);
        }
    }
    xhttp.open("POST", url,true);
    xhttp.send(data);
}


function validarFormulario(form){
    var valido=true;
    var maxCaracteres=6;
    if(form.elements["newPassword"].value.size < maxCaracteres){
        valido=false;
    }
    if(form.elements["newPassword"].value !== form.elements["repeatNewPassword"].value) {
        valido = false;
    }
    return valido;
}


