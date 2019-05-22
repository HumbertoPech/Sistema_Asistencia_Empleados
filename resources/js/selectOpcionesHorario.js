opcionesSelect("horas-entrada-lunes","minutos-entrada-lunes");
opcionesSelect("horas-entrada-martes","minutos-entrada-martes");
opcionesSelect("horas-entrada-miercoles","minutos-entrada-miercoles");
opcionesSelect("horas-entrada-jueves","minutos-entrada-jueves");
opcionesSelect("horas-entrada-viernes","minutos-entrada-viernes");

opcionesSelectSalida("horas-salida-lunes","minutos-salida-lunes");
opcionesSelectSalida("horas-salida-martes","minutos-salida-martes");
opcionesSelectSalida("horas-salida-miercoles","minutos-salida-miercoles");
opcionesSelectSalida("horas-salida-jueves","minutos-salida-jueves");
opcionesSelectSalida("horas-salida-viernes","minutos-salida-viernes");


function opcionesSelect(horasSelect,minutosSelect){
    
  for(var x=8;x<13;x++){
  var option = document.createElement("option");
      option.text =   x;
      option.value =  x;
    
  var selectLunes = document.getElementById(horasSelect);
  selectLunes.appendChild(option);

  }
  for(var x=0;x<60;x++){
  var option = document.createElement("option");
    if(x<10){
      option.text = "0" + x.toString();
      option.value = "0" + x.toString();
    }

    else{
      option.text = x.toString();
      option.value = x.toString();
    }
  var selectLunes = document.getElementById(minutosSelect);
  selectLunes.appendChild(option);
  }  
}

function opcionesSelectSalida(horasSelect,minutosSelect){
    
    for(var x=12;x<21;x++){
    var option = document.createElement("option");
        option.text =   x;
        option.value =  x;
      
    var selectLunes = document.getElementById(horasSelect);
    selectLunes.appendChild(option);
  
    }
    for(var x=0;x<60;x++){
    var option = document.createElement("option");
      if(x<10){
        option.text = "0" + x.toString();
        option.value = "0" + x.toString();
      }
  
      else{
        option.text = x.toString();
        option.value = x.toString();
      }
    var selectLunes = document.getElementById(minutosSelect);
    selectLunes.appendChild(option);
    }  
  }

window.onload= function () {
    document.getElementById("horas-entrada-lunes").onchange=function () {
        valorFuncion= document.getElementById("horas-entrada-lunes").value;
        if(valorFuncion==12){
        valor=parseInt(valorFuncion);
        valor=valor+8;
        document.ready = document.getElementById("horas-salida-lunes").value =valor;
        document.ready = document.getElementById("minutos-entrada-lunes").value ="00";
        document.ready = document.getElementById("minutos-salida-lunes").value ="00";
        }
        else{
        valor=parseInt(valorFuncion);
        valor=valor+8;
        document.ready = document.getElementById("horas-salida-lunes").value =valor;
        }
    };
    document.getElementById("horas-entrada-martes").onchange=function () {
        valorFuncion= document.getElementById("horas-entrada-martes").value;
        if(valorFuncion==12){
        valor=parseInt(valorFuncion);
        valor=valor+8;
        document.ready = document.getElementById("horas-salida-martes").value =valor;
        document.ready = document.getElementById("minutos-entrada-martes").value ="00";
        document.ready = document.getElementById("minutos-salida-martes").value ="00";
        }
        else{
        valor=parseInt(valorFuncion);
        valor=valor+8;
        document.ready = document.getElementById("horas-salida-martes").value =valor;
        }
    };
    document.getElementById("horas-entrada-miercoles").onchange=function () {
        valorFuncion= document.getElementById("horas-entrada-miercoles").value;
        if(valorFuncion==12){
        valor=parseInt(valorFuncion);
        valor=valor+8;
        document.ready = document.getElementById("horas-salida-miercoles").value =valor;
        document.ready = document.getElementById("minutos-entrada-miercoles").value ="00";
        document.ready = document.getElementById("minutos-salida-miercoles").value ="00";
        }
        else{
        valor=parseInt(valorFuncion);
        valor=valor+8;
        document.ready = document.getElementById("horas-salida-miercoles").value =valor;
        }
    };
    document.getElementById("horas-entrada-jueves").onchange=function () {
        valorFuncion= document.getElementById("horas-entrada-jueves").value;
        if(valorFuncion==12){
        valor=parseInt(valorFuncion);
        valor=valor+8;
        document.ready = document.getElementById("horas-salida-jueves").value =valor;
        document.ready = document.getElementById("minutos-entrada-jueves").value ="00";
        document.ready = document.getElementById("minutos-salida-jueves").value ="00";
        }
        else{
        valor=parseInt(valorFuncion);
        valor=valor+8;
        document.ready = document.getElementById("horas-salida-jueves").value =valor;
        }
    };
    document.getElementById("horas-entrada-viernes").onchange=function () {
        valorFuncion= document.getElementById("horas-entrada-viernes").value;
        if(valorFuncion==12){
        valor=parseInt(valorFuncion);
        valor=valor+8;
        document.ready = document.getElementById("horas-salida-viernes").value =valor;
        document.ready = document.getElementById("minutos-entrada-viernes").value ="00";
        document.ready = document.getElementById("minutos-salida-viernes").value ="00";
        }
        else{
        valor=parseInt(valorFuncion);
        valor=valor+8;
        document.ready = document.getElementById("horas-salida-viernes").value =valor;
        }
    };


    document.getElementById("minutos-entrada-lunes").onchange=function () {
        var valorMinutos = document.getElementById("minutos-entrada-lunes").value;
        document.ready = document.getElementById("minutos-salida-lunes").value =valorMinutos;
    };

    document.getElementById("minutos-entrada-martes").onchange=function () {
        var valorMinutos = document.getElementById("minutos-entrada-martes").value;
        document.ready = document.getElementById("minutos-salida-martes").value =valorMinutos;
    };

    document.getElementById("minutos-entrada-miercoles").onchange=function () {
        var valorMinutos = document.getElementById("minutos-entrada-miercoles").value;
        document.ready = document.getElementById("minutos-salida-miercoles").value =valorMinutos;
    };

    document.getElementById("minutos-entrada-jueves").onchange=function () {
        var valorMinutos = document.getElementById("minutos-entrada-jueves").value;
        document.ready = document.getElementById("minutos-salida-jueves").value =valorMinutos;
    };

    document.getElementById("minutos-entrada-viernes").onchange=function () {
        var valorMinutos = document.getElementById("minutos-entrada-viernes").value;
        document.ready = document.getElementById("minutos-salida-viernes").value =valorMinutos;
    };
}

