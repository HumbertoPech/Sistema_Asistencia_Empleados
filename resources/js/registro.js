jQuery(document).on('submit','#form-sign',function(event){
    event.preventDefault();
    console.log($(this).serialize);
    jQuery.ajax({
        url: '../../libs/registro.php',
        type: 'POST',
        dataType: 'json',
        data: $(this).serialize(),
        beforeSend: function(){
          $('.btn-sign').val('Validando...');
        }
    })

    .done(function(respuesta) {
        
        if(!respuesta.error){
            console.log(respuesta);
            location.href= 'datosUsuario.html';
            localStorage.setItem('usuario',respuesta.user);
            localStorage.setItem('password',respuesta.password);
        }
        else{
            alert('Hay error con los datos ingresados. Intentalo de nuevo.');
            $('.btn-sign').val('Registrar');
        }
    })

    .fail(function(respu){
        console.log(respu.responseText);
    })

    .always(function(respuesta){
        console.log(respuesta);
        console.log("complete");
    });
});