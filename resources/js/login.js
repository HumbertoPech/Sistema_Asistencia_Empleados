jQuery(document).on('submit','#form-sign',function(event){
    event.preventDefault();

    jQuery.ajax({
        url: '../../libs/login.php',
        type: 'POST',
        dataType: 'json',
        data: $(this).serialize(),
        beforeSend: function(){
          $('.btn-signin').val('Validando...');
        }
    })

    .done(function(respuesta) {
        if(!respuesta.error){
            location.href= 'indexEmpleado.php';
           
        }
        else{
            alert(respuesta.tipo);
            $('.btn-signin').val('Iniciar Sesión');
        }
    })

    .fail(function(respu){
        console.log(respu.responseText);
    })

    .always(function(respuesta){
        console.log("complete");
        
    });
});

function startTime() {
    var today = new Date();
    var hr = today.getHours();
    var min = today.getMinutes();
    var sec = today.getSeconds();
    ap = (hr < 12) ? "<span>AM</span>" : "<span>PM</span>";
    hr = (hr == 0) ? 12 : hr;
    hr = (hr > 12) ? hr - 12 : hr;
    //Add a zero in front of numbers<10
    hr = checkTime(hr);
    min = checkTime(min);
    sec = checkTime(sec);
    document.getElementById("clock").innerHTML = hr + ":" + min + ":" + sec + " " + ap;
    
    var months = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
    var days = ['Domingo', 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado'];
    var curWeekDay = days[today.getDay()];
    var curDay = today.getDate();
    var curMonth = months[today.getMonth()];
    var curYear = today.getFullYear();
    var date = curWeekDay+" "+curDay+" de "+curMonth+" "+curYear;


    document.getElementById("date").innerHTML = date;
    
    var time = setTimeout(function(){ startTime() }, 500);

}
function checkTime(i) {
    if (i < 10) {
        i = "0" + i;
    }
    return i;
}