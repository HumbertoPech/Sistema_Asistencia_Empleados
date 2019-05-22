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
            location.href= 'indexEmpleado.php';
        }else if(this.status== 204){
            alert(respuesta);
        }
    }
    xhttp.open("POST", url,true);
    xhttp.send(data);
}

function registrar(tipoRegistro){
    var xhttp;
    var urlLocation= "http://localhost/Sistema_Asistencia_Empleados/libs/operacionesEmpleados.php";
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
            if(tipoRegistro== "checkIn"){
                document.getElementById("registrarEntrada").disabled=true;
            }else if (tipoRegistro== "checkOut"){
                document.getElementById("registrarSalida").disabled=true;
           }
            
        }
    }
    xhttp.open("POST", urlLocation,true);
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

function verificarHorarios(){
    var xhttp;
    var data= new FormData();
    var urlLocation= "http://localhost/Sistema_Asistencia_Empleados/libs/operacionesEmpleados.php";
    data.append("operacion","verificarHorarios");
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
            if(respuesta== "checkIn"){
                document.getElementById("registrarEntrada").style.display="inline";
                //document.getElementById("registrarEntrada").disabled=false;
            }else if (respuesta== "checkOut"){
                document.getElementById("registrarSalida").style.display="inline";
           }            
        }
    }
    xhttp.open("POST", urlLocation,true);
    xhttp.send(data);
}

/*true si pasó la verificacion y puede continuar .
False si no pasó la verificacion y no puede checkear ni entrada, ni salida.
*/
function verificarEstadoEmpleado(){
    //Verificar si está en vacaciones o suspendido
    var xhttp;
    var data= new FormData();
    var urlLocation= "http://localhost/Sistema_Asistencia_Empleados/libs/operacionesEmpleados.php";
    data.append("operacion","estadoEmpleado");
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
            if(respuesta == "vacaciones" || respuesta == "suspendido"){
                alert(respuesta);
                return false;
            }                       
        }
    }
    xhttp.open("POST", urlLocation,true);
    xhttp.send(data);
    return true;

}
