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
        var TituloVideo = document.getElementById("titulo").value; // TITULO DE VIDEO
        var VideoUrlElement = document.getElementById("video_url");
        var VideoUrl = VideoUrlElement ? VideoUrlElement.value.trim() : "";
        var sourceSelectElement = document.getElementById("tipo_fuente");
        var sourceSelect = sourceSelectElement ? sourceSelectElement.value : "";
        
        // ALERTA NOMBRE DE USUARIO NO UNICO VACIO
        if(TituloVideo ==""){
            AlertaUsuarioMostrar("Campo Incompleto","Debe ingresar el título de la publicación","warning");
            return false;
        }
        
        if(VideoUrl == ""){
            AlertaUsuarioMostrar("Campo Incompleto","Debe ingresar un enlace válido para compartir","warning");
            return false;
        }

        // Validación de URLs por plataforma
        if (sourceSelect === 'youtube') {
            if (!/^(https?:\/\/)?(www\.)?(youtube\.com|youtu\.be)\/.+$/i.test(VideoUrl)) {
                AlertaUsuarioMostrar("Enlace Inválido", "Por favor ingresa un enlace de YouTube válido.", "warning");
                return false;
            }
        } else if (sourceSelect === 'spotify') {
            if (!/^(https?:\/\/)?(open\.spotify\.com)\/.+$/i.test(VideoUrl)) {
                AlertaUsuarioMostrar("Enlace Inválido", "Por favor ingresa un enlace de Spotify válido.", "warning");
                return false;
            }
        } else if (sourceSelect === 'itunes') {
            if (!/^(https?:\/\/)?([a-z0-9-]+\.)*apple\.com\/.+$/i.test(VideoUrl) && !/^https?:\/\/audio-ssl\.itunes\.apple\.com\/.+$/i.test(VideoUrl)) {
                AlertaUsuarioMostrar("Enlace Inválido", "Por favor ingresa un enlace de iTunes/Apple Music válido.", "warning");
                return false;
            }
        }
        
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
            if(respuesta == "OK"){
                // MENSAJE DE CONFIRMACION EXITOSO
                AlertaUsuarioMostrar("Publicacion Exitosa","Enhorabuena, has compartido tu música/clip con éxito","success");
                // 1.5 SEGUNDOS DE RETRASO PARA MOSTRAR ALERTA Y REFRESCAR
                setTimeout(function(){
                    location.reload();
                }, 1500);
            } else if (respuesta == "ERROR_INVALID_URL") {
                AlertaUsuarioMostrar("Enlace Inválido", "Por favor ingresa un enlace válido para la plataforma seleccionada.", "warning");
            } else { // FALLO PROCESAMIENTO DE DATOS -> DENTRO DEL SISTEMA
                AlertaUsuarioMostrar("Error","Lo sentimos, no pudimos procesar en estos momentos tu petición.","error");
            }
            // FALLO PROCESAMIENTO DE DATOS -> FUERA DEL SISTEMA
        }).fail(function(respuesta) {
            AlertaUsuarioMostrar("Error", "Error al procesar la solicitud.", "error");
        });
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
