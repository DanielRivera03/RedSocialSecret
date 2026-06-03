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
     var element = $(this);
     BorrarNotificaciones(IDNotificaciones, element); // ID UNICO DE HISTORIAS
     e.preventDefault();
    });
   });
   function BorrarNotificaciones(IDNotificaciones, element){ 
    Swal.fire({
        title: '¿Realmente desea eliminar esta notificación?',
        text: "Al hacer clic en el botón confirmar, no habrá forma de recuperarlo",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#EA2027',
        cancelButtonColor: '#5758BB',
        confirmButtonText: 'Confirmar',
        cancelButtonText: 'Cancelar',
        showLoaderOnConfirm: true,
        preConfirm: function() {
          return new Promise(function(resolve) {
             $.ajax({
             url: '../controlador/cPublicacionesUsuarios.php?publicaciones=eliminar-notificaciones-comentarios&idnotificacion='+IDNotificaciones,
             type: 'POST',
                data: 'idnotificacion='+IDNotificaciones, // COMPARACION PREVIA ANTES DE EJECUTAR ACCION EN SERVIDOR
                dataType: 'json'
             })
             .done(function(respuesta){ // SI MODELO EJECUTA PETICION, REALIZA PETICION
                resolve(respuesta);
             })
             .fail(function(){
                resolve("error");
             });
          });
        },    
        allowOutsideClick: () => !Swal.isLoading()
    }).then((result) => {
        if (result.isConfirmed) {
            var respuesta = result.value;
            if (respuesta === "OK") {
                Swal.fire({
                    title: 'Notificación Eliminada',
                    text: 'Se ha eliminado la notificación.',
                    icon: 'success',
                    timer: 1500,
                    showConfirmButton: false
                });
                
                // Dynamic DOM update without reload
                if (element && element.length) {
                    var cardItem = element.closest('.iq-card');
                    if (!cardItem.length) {
                        cardItem = element.closest('li'); // fallback if styled differently
                    }
                    if (cardItem.length) {
                        cardItem.fadeOut(400, function() {
                            $(this).remove();
                        });
                    }
                }
            } else {
                AlertaUsuarioMostrar("Error", "Lo sentimos, en estos momentos no podemos procesar tu solicitud, por favor vuelve más tarde...", "error");
            }
        }
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