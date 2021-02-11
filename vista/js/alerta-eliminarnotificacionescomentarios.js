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
    // #eliminar-notificacion-comentarios IDENTIDICADOR DE ID -> ACCION A EJECUTAR
    $(document).on('click', '#eliminar-notificacion-comentarios', function(e){
     var IDNotificaciones = $(this).data('id'); // ID ENVIADA POR GET DESDE EL CONTROLADOR HACIA EL MODELO
     BorrarNotificaciones(IDNotificaciones); // ID UNICO DE HISTORIAS
     e.preventDefault();
    });
   });
   function BorrarNotificaciones(IDNotificaciones){ 
    Swal.fire({
        title: '¿Realmente desea eliminar esta notificación?',
        text: "Al hacer clic en el botón confirmar, no habrá forma de recuperarlo",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#EA2027',
        cancelButtonColor: '#5758BB',
        confirmButtonText: 'Confirmar',
        cancelButtonText: 'Cancelar',
     preConfirm: function() {
       return new Promise(function() {
          $.ajax({
          url: '../controlador/cPublicacionesUsuarios.php?publicaciones=eliminar-notificaciones-comentarios&idnotificacion='+IDNotificaciones,
          type: 'POST',
             data: 'idnotificacion='+IDNotificaciones, // COMPARACION PREVIA ANTES DE EJECUTAR ACCION EN SERVIDOR
             dataType: 'json'
          })
          .done(function(respuesta){ // SI MODELO EJECUTA PETICION, REALIZA PETICION
            if(respuesta=="OK"){
                    location.reload();
            }
          })
          .fail(function(){
            AlertaUsuarioMostrar("Error","Lo sentimos, en estos momentos no podemos procesar tu solicitud, por favor vuelve más tarde...","error");
          });
       });
        },    
    }); 
   }

// FUNCION PARA MOSTRAR ALERTAS A USUARIOS
function AlertaUsuarioMostrar(titulo, descripcion, icono) {
    Swal.fire(
        titulo, // ENCABEZADO 
        descripcion, // CUERPO
        icono // ICONO DE ALERTA
    );
}