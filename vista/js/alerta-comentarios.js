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
        e.preventDefault(e); // "e" IDENTIFICADOR DE ACCION PARA CAPTURAR EVENTO DE FORMULARIO
        var IDPublicaciones = $(this).data('id'); // ID ENVIADA POR GET DESDE EL CONTROLADOR HACIA EL MODELO
        $.ajax({
            url: '../controlador/cPublicacionesUsuarios.php?publicaciones=registrarcomentariosperfiles&idpublicacion='+IDPublicaciones,
            type: "POST",
            dataType: 'json',
            data:  new FormData(this),
            contentType: false,
            cache: false,
            processData:false,
        }).done(function(respuesta){
            // SI ACCION ES CONFIRMADA POR EL MODELO, REALIZA ACTUALIZACION DE PERFIL
            if(respuesta == "OK"){
                // 0.40 SEGUNDOS DE RETRASO PARA MOSTRAR ALERTA Y REFRESCAR
                setTimeout(function(){
                    location.reload();
                }, 400);
            }
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

// EVITAR INGRESOS NULOS -> O DEJAR BOTON DE ENVIO CON ACCION NULA SIN INGRESO DE TEXTO
function ValidarEnvios(){
    var comentario = document.getElementById("comentarios").value; 
    if(comentario.length <=0){
        $('#comentarios').prop('disabled', true);
        document.getElementsByName('caja_comentarios')[0].placeholder='😈 Debes escribir algo, refresca la página para desbloquear.';
    }else{
        $('#comentarios').prop('disabled', false);
    }
}