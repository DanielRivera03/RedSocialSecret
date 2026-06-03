/*
--------------------------------------------------------
║            SECRET - RED SOCIAL PHP NATIVO            ║
--------------------------------------------------------           
    AUTOR: DANIEL RIVERA (danielrivera03)
    Github: https://github.com/DanielRivera03
    VERSIONES TESTEADAS: 7.3 a 8.0
    -> VERSIONES INFERIORES PROBABLEMENTE TENGAN
    ALGUN CONFLICTO. TOMAR EN CUENTA.
    COPYRIGHT © 2020 - 2021
--------------------------------------------------------
*/ 

$(document).ready(function(){
    $("#form").on('submit',(function(e){ // "e" IDENTIFICADOR DE ACCION PARA CAPTURAR EVENTO DE FORMULARIO
        // VALIDACION DE ELEMENTOS DE FORMULARIO
        var CajaTextoPublicaciones = document.getElementById("publicaciones_usuarios").value; // NOMBRE NO UNICO DE USUARIO
        var CajaFotosPublicaciones = document.getElementById("input-file-max-fs").value; // APELLIDO NO UNICO DE USUARIO
        /*
            --> ALERTAS DE ERRORES
        */
        // ALERTA NOMBRE DE USUARIO NO UNICO VACIO
        if(CajaTextoPublicaciones ==""){
            AlertaUsuarioMostrar("Campo Incompleto","Debe ingresar un texto a compartir con los demás usuarios","warning");
            return false;
        }
        // ALERTA APELLIDO DE USUARIO NO UNICO VACIO
        if(CajaFotosPublicaciones ==""){
            AlertaUsuarioMostrar("Campo Incompleto","Debe incluir una foto en sus historias, por favor adjunte una","warning");
            return false;
        
            /*
                --> SI TODO SE CUMPLE, ENTONCES...
                    INGRESA ACCION A BASE DE DATOS
            */
        }else{
        e.preventDefault(e); // "e" IDENTIFICADOR DE ACCION PARA CAPTURAR EVENTO DE FORMULARIO
        $.ajax({
            url: "../controlador/cPublicacionesUsuarios.php?publicaciones=registrarpublicacion",
            type: "POST",
            dataType: 'json',
            data:  new FormData(this),
            contentType: false,
            cache: false,
            processData:false,
        }).done(function(respuesta){
            // SI ACCION ES CONFIRMADA POR EL MODELO, REALIZA ACTUALIZACION DE PERFIL
            if(respuesta == "OK"){
                Swal.fire({
                    title: "Publicación Exitosa",
                    text: "Enhorabuena, has compartido tu historia con éxito",
                    icon: "success",
                    timer: 2000,
                    showConfirmButton: false
                });
                
                // Dynamically reset post form and modal without reload
                $("#post-modal").modal('hide');
                $("#form")[0].reset();
                $("#image-collage-preview").empty();
                
                // Reset gradients and sentiments
                $(".btn-gradient-select").removeClass("active");
                $(".btn-gradient-select[data-gradient='']").addClass("active");
                $("#fondo_gradiente_input").val("");
                $("#contador").text("");
                
                // Reset Feed Infinito to load the new post at the top
                if (window.FeedInfinito && typeof window.FeedInfinito.reset === "function") {
                    window.FeedInfinito.reset();
                }
            }else{ // FALLO PROCESAMIENTO DE DATOS -> DENTRO DEL SISTEMA
                AlertaUsuarioMostrar("Error","Lo sentimos, no pudimos procesar en estos momentos tu petición.","error");
            }
            // FALLO PROCESAMIENTO DE DATOS -> FUERA DEL SISTEMA
        }).fail(function(respuesta) {
            AlertaUsuarioMostrar("Error",respuesta,"error");
        });
        }
    }));
});
// FUNCION PARA MOSTRAR ALERTAS A USUARIOS
function AlertaUsuarioMostrar(titulo, descripcion, icono) {
    Swal.fire(
        titulo, // ENCABEZADO 
        descripcion, // CUERPO
        icono // ICONO DE ALERTA
    );
}
