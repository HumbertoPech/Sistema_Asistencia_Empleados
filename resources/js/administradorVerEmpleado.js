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
    let dias_de_la_semana = ["Lunes", "Martes","Miercoles","Jueves","Viernes"];
    const DIAS_LABORALES = 5;
    //let date = new Time('06:07:00');
    //console.log("HORAS: " + date.getHours());
    for(let i = 0; i < DIAS_LABORALES; i++){
        let formData = new FormData();
        formData.append("operacion","actualizarHorarioEmpleado");
        formData.append("id_usuario",document.getElementById("id_usuario").value);
        formData.append("dia", dias_de_la_semana[i]);
        formData.append("hora_entrada",document.getElementById("hora_entrada"+i).value);
        
        let hora_entrada = document.getElementById("hora_entrada"+i).value;
        let hora_salida = document.getElementById("hora_salida"+i).value;
        let dia = dias_de_la_semana[i];
        let diferencia = hora_salida - hora_entrada;
        console.log("Dia: " + dia + " hora entrada = " + hora_entrada + " hora_salida= " + hora_salida + " diferencia = " + diferencia);
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

function checarHora(tipo,contador,dia){
    let stringHorario = document.getElementById(tipo+contador).value;
    let splitHorario = stringHorario.split(":");
        
    let hora = parseInt(splitHorario[0]);
    let minutos = parseInt(splitHorario[1]);
    if(tipo == "hora_entrada"){
        
        if(hora<8){
            //Error
            document.getElementById("invalid-feedback-"+dia).style.display="inline";
            document.getElementById("botonGuardarHorario").disabled=true;
            return;
        }else{
            if(hora <= 12){
                let horaSalida = hora+8; //tienen que ser 8 horas laborales!!!
                let strMinutosSalida;
                if(minutos < 10){
                    strMinutosSalida = "0"+minutos;
                }else{
                    strMinutosSalida = minutos;
                }
                let strHoraSalida = horaSalida+":"+strMinutosSalida;
                document.getElementById("hora_salida"+contador).value=strHoraSalida;
            }else{
                //Error
                document.getElementById("invalid-feedback-"+dia).style.display="inline";
                document.getElementById("botonGuardarHorario").disabled=true;
                return;
            }
        } 
    }else if(tipo == "hora_salida"){
        if(hora > 20){
            //error
            document.getElementById("invalid-feedback-"+dia).style.display="inline";
            document.getElementById("botonGuardarHorario").disabled=true;
            return;
        }else{
            if(hora >= 16){
                let horaEntrada = hora - 8;
                let strMinutosEntrada;
                if(minutos>0){
                    if(hora == 20){
                        //Error Ya es tarde
                        document.getElementById("invalid-feedback-"+dia).style.display="inline";
                        document.getElementById("botonGuardarHorario").disabled=true;;
                        strMinutosEntrada = "00";
                        return;
                    }else{
                        if(minutos < 10){
                            strMinutosEntrada = "0"+minutos;
                        }else{
                            strMinutosEntrada = minutos;
                        }
                    }
                }else{
                    strMinutosEntrada = "00";
                }

                if(horaEntrada<10){
                    stringHoraEntraFinal = "0"+horaEntrada;
                    console.log("Hora ahora" + stringHoraEntraFinal);
                }else{
                    stringHoraEntraFinal = horaEntrada;
                }
                
                let strHoraEntrada = stringHoraEntraFinal+":"+strMinutosEntrada;
                document.getElementById("hora_entrada"+contador).value=strHoraEntrada;
            }else{
                //error
                document.getElementById("invalid-feedback-"+dia).style.display="inline";
                document.getElementById("botonGuardarHorario").disabled=true;
                return
            }
        }
    }
    document.getElementById("invalid-feedback-"+dia).style.display="none";
    document.getElementById("botonGuardarHorario").disabled = false;
}

function errorHorario(){

}