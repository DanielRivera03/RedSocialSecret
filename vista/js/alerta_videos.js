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
    $("#videos").on('submit',(function(e){ // "e" IDENTIFICADOR DE ACCION PARA CAPTURAR EVENTO DE FORMULARIO
        // VALIDACION DE ELEMENTOS DE FORMULARIO
        var TituloVideo = document.getElementById("titulo").value; // TITULO DE VIDEO
        var VideoArchivo = document.getElementById("input-file-max-fs").value; // ARCHIVO MULTIMEDIA A SUBIR
        /*
            --> ALERTAS DE ERRORES
        */
        // ALERTA NOMBRE DE USUARIO NO UNICO VACIO
        if(TituloVideo ==""){
            AlertaUsuarioMostrar("Campo Incompleto","Debe ingresar el título del vídeo","warning");
            return false;
        }
        // ALERTA APELLIDO DE USUARIO NO UNICO VACIO
        if(VideoArchivo ==""){
            AlertaUsuarioMostrar("Campo Incompleto","Debe incluir un vídeo en su publicación, por favor adjunte uno","warning");
            return false;
        
            /*
                --> SI TODO SE CUMPLE, ENTONCES...
                    INGRESA ACCION A BASE DE DATOS
            */
        }else{
        e.preventDefault(e); // "e" IDENTIFICADOR DE ACCION PARA CAPTURAR EVENTO DE FORMULARIO
        $.ajax({
            url: "../controlador/cPublicacionesUsuarios.php?publicaciones=registro-secretvideos",
            type: "POST",
            dataType: 'json',
            data:  new FormData(this),
            contentType: false,
            cache: false,
            processData:false,
        }).done(function(respuesta){
            // SI ACCION ES CONFIRMADA POR EL MODELO, REALIZA ACTUALIZACION DE PERFIL
            if(respuesta == "OK"){
                // MENSAJE DE CONFIRMACION EXITOSO
                AlertaUsuarioMostrar("Publicacion Exitosa","Enhorabuena, has compartido tu vídeo musical con éxito","success");
                // 1.5 SEGUNDOS DE RETRASO PARA MOSTRAR ALERTA Y REFRESCAR
                setTimeout(function(){
                    location.reload();
                }, 1500);
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
