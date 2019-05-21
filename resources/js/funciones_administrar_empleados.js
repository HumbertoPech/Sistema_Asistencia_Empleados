$(document).ready(function(){

    $("#boton").click(function(){
        var type = $(this).data('type');
        var id = $(this).data('id');
        updateRows(type, id);
    });

    $(".form-control").change(function(){
        var val = $(this).val();

        if(!val) {
            $(this).addClass("is-invalid");
        }else {
            $(this).removeClass("is-invalid");
        }
    });

    $("#delete-button").click(function(){
        var type = $(this).data('type');
        var id = $(this).data('id');

        deleteRow(type, id);
    });

    var updateRows = function(type, id) {
        var fechaInicio = $("#fecha_inicio").val();
        var fechaTermino = $("#fecha_termino").val();

        if(!fechaInicio && !fechaTermino){
            $("#fecha_inicio").addClass("is-invalid");
            $("#fecha_termino").addClass("is-invalid");
        }else {
            $.ajax({
                url: type + ".php?id=" + id,
                method: "POST",
                data: {fecha_inicio: fechaInicio, fecha_termino: fechaTermino, update: true},
                success: function(){
                    $("#tabla").find("#delete-button").remove();
                    $("#tabla").find("tbody").append("<tr><td>"+id+"</td><td>"+fechaInicio+"</td><td>"+fechaTermino+"</td><td><button id='delete-button' type='button' class='btn btn-outline-danger' data-type='"+type+"' data-id='"+id+"'>Eliminar</button></td></tr>");
                    $("#success-alert").addClass('show');
                    setTimeout(function(){
                        $("#success-alert").removeClass('show');
                    }, 2000);
                },
                error: function(err){
                    console.error(err);
                }
            });
        }
    }

    var deleteRow = function(type, id) {
        var type = type;
        var id = id;
        $.ajax({
            url: type + ".php",
            method: "POST",
            data: {id_emplado: id, delete: true},
            success: function(){
                location.reload();
            },
            error: function(err){
                console.error(err);
            }
        });
    }
});
