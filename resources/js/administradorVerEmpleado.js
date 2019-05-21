function deshabilitarTodo(){
    deshabilitarOpciones(true,"inputsInformacionPersonal");
    deshabilitarOpciones(true,"inputsHorarioPersonal");

    //document.getElementById("botonCancelarInformacion").style.display="none";
    //let elemento = document.getElementById("inputContrasena");
    //elemento.type="password";
}

function deshabilitarOpciones(boolean,tipo){
    let elementos = document.getElementsByClassName(tipo);
    console.log(elementos[0].name);
    for(let i=0; i < elementos.length; i++){
        elementos[i].disabled=boolean;
    }
}

function intercambiarOpciones(botonPresionado){
    let id = botonPresionado.id;
    if(id == "botonEditarInformacion"){
        deshabilitarOpciones(false,"inputsInformacionPersonal");
        document.getElementById("botonCancelarInformacion").style.display="inline";
        document.getElementById("botonGuardarInformacion").disabled=false;
        botonPresionado.disabled=true;
    }else if(id == "botonCancelarInformacion"){
        botonPresionado.style.display="none";
        deshabilitarOpciones(true,"inputsInformacionPersonal");
        document.getElementById("botonEditarInformacion").disabled=false;
        document.getElementById("botonGuardarInformacion").disabled=true;
    }else if(id=="botonEditarHorario"){
        deshabilitarOpciones(false,"inputsHorarioPersonal");
        document.getElementById("botonCancelarHorario").style.display="inline";
        document.getElementById("botonGuardarHorario").disabled=false;
        botonPresionado.disabled=true;
    }else if(id=="botonCancelarHorario"){
        botonPresionado.style.display="none";
        deshabilitarOpciones(true,"inputsHorarioPersonal");
        document.getElementById("botonEditarHorario").disabled=false;
        document.getElementById("botonGuardarHorario").disabled=true;
    }
}

function verContrasena(){
    let mensaje = "Esciba la contraseña de administrado para confirmar";
    let contrasenaAdmin = prompt(mensaje);
    if(contrasenaAdmin != null){
        let esValido = comprobarContrasenaAdmin(contrasenaAdmin);
        if(esValido){
            document.getElementById("inputContrasena").type="text";
            document.getElementById("verContrasenaUs").disabled=true;
        }else{
            alert("Contraseña incorrecta");
        }
    }else{
        alert("Operación cancelada");
    }
}

function resetIntentosUsuario(elemento){
    let mensaje = "¿Seguro quieres reiniciar los intentos del empleado?";
    if(!confirmacionUsuario(mensaje)){
        alert("Operación cancelada");
        return;
    }
    let xmlhttp = new XMLHttpRequest();
    let formData = new FormData();
    formData.append("operacion","resetIntentosEmpleado");
    formData.append("id_usuario",document.getElementById("id_usuario").value);
    xmlhttp.onreadystatechange = function(){
        if(this.readyState == 4 && this.status == 200){
            //Recuperar contraseña si es válido
            //let respuesta = JSON.parse(this.response);
            elemento.disabled=true;
            alert("Se reinicio los intentos de log-in del empleado a 0");
        }
    };

    xmlhttp.open("POST","../../libs/operacionesAdministrador.php",true);
    xmlhttp.send(formData);
}

function comprobarContrasenaAdmin(contrasenaRecibida){
    let xmlhttp = new XMLHttpRequest();
    let formData = new FormData();
    let esValido;
    formData.append("operacion","comprobarContrasena");
    formData.append("contrasenaAdmin",contrasenaRecibida);
    xmlhttp.onreadystatechange = function(){
        if(this.readyState == 4 && this.status == 200){
            //Recuperar contraseña si es válido
            let respuesta = JSON.parse(this.response);
            esValido= respuesta['resultado'];
        }
    };

    xmlhttp.open("POST","../../libs/operacionesAdministrador.php",false);
    xmlhttp.send(formData);
    return esValido;
}

function cambiarEstadoEmpleado(estadoAnterior, estadoNuevo){
    let mensaje = "¿Seguro quieres poner al empleado como: "+ estadoNuevo.name+"?";
    if(!confirmacionUsuario(mensaje)){
        alert("Operación cancelada");
        return;
    }
    let xmlhttp = new XMLHttpRequest();
    let formData = new FormData();
    formData.append("operacion","cambiarEstadoEmpleado");
    formData.append("id_usuario",document.getElementById("id_usuario").value);
    formData.append("estado_nuevo",estadoNuevo.name);
    xmlhttp.onreadystatechange = function(){
        if(this.readyState == 4 && this.status == 200){
            //let respuesta = JSON.parse(this.response);
            console.log(this.respuesta);
            estadoAnterior.style.display="inline";
            estadoNuevo.style.display="none";
            alert("Se cambio el estado del empleado a: " + estadoNuevo.name);
        }
    };

    xmlhttp.open("POST","../../libs/operacionesAdministrador.php",true);
    xmlhttp.send(formData);
}

function actualizarInformacionEmpleado(){
    let mensaje = "¿Seguro quieres actualizar información del empleado?";
    if(!confirmacionUsuario(mensaje)){
        alert("Operación cancelada");
        return;
    }
    let formData = new FormData();
    //buscar una mejor forma
    let formulario = document.formularioInfo;
    formData.append("operacion","actualizarInformacionEmpleado");
    formData.append("id_usuario",document.getElementById("id_usuario").value)
    formData.append("nombres",formulario.nombres.value);
    formData.append("apellidos",formulario.apellidos.value);
    formData.append("sexo",formulario.sexo.value);
    formData.append("estado_civil",formulario.estado_civil.value);
    formData.append("fecha_nacimiento",formulario.fecha_nacimiento.value);
    console.log("Fecha de nacimiento:" + formulario.fecha_nacimiento.value);
    formData.append("curp",formulario.curp.value);
    formData.append("direccion",formulario.direccion.value);
    formData.append("sueldo_base",formulario.sueldo_base.value);
    formData.append("fecha_inicio",formulario.fecha_inicio.value);
    let xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function(){
        if(this.readyState == 4 && this.status == 200){
            intercambiarOpciones(document.getElementById("botonCancelarInformacion"));
            alert("Información actualizada");
        }
    };

    xmlhttp.open("POST","../../libs/operacionesAdministrador.php",true);
    xmlhttp.send(formData);
}

function actualizarHorarioEmpleado(){
    let mensaje = "¿Seguro quieres actualizar información del empleado?";
    if(!confirmacionUsuario(mensaje)){
        alert("Operación cancelada");
        return;
    }
    dias_de_la_semana = ["Lunes", "Martes","Miercoles","Jueves","Viernes"];
    const DIAS_LABORALES = 5;
    for(let i = 0; i < DIAS_LABORALES; i++){
        let formData = new FormData();
        formData.append("operacion","actualizarHorarioEmpleado");
        formData.append("id_usuario",document.getElementById("id_usuario").value);
        formData.append("dia", dias_de_la_semana[i]);
        formData.append("hora_entrada",document.getElementById("hora_entrada"+i).value);
        formData.append("hora_salida",document.getElementById("hora_salida"+i).value);
        let xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function(){
            if(this.readyState == 4 && this.status == 200){
                //Do_nothing_at_the_moment
            }
        };

        xmlhttp.open("POST","../../libs/operacionesAdministrador.php",true);
        xmlhttp.send(formData);
    }
    intercambiarOpciones(document.getElementById("botonCancelarHorario"));
    alert("Horario actualizado");
}

function confirmacionUsuario(mensaje){
    let confirmacion = confirm(mensaje);
    if(!confirmacion){
        return false;
    }
    return true;
}