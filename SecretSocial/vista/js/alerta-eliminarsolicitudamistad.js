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
    // #rechazar-solicitudes IDENTIDICADOR DE ID -> ACCION A EJECUTAR
    $(document).on('click', '#rechazar-solicitudes', function(e){
     var IDSolicitudAmistad = $(this).data('id'); // ID ENVIADA POR GET DESDE EL CONTROLADOR HACIA EL MODELO
     var element = $(this);
     EliminarSolititudesAmistad(IDSolicitudAmistad, element); // ID UNICO DE HISTORIAS
     e.preventDefault();
    });
   });
   function EliminarSolititudesAmistad(IDSolicitudAmistad, element){ 
    Swal.fire({
        title: '¿Desea rechazar esta solicitud?',
        text: "Al hacerlo, no habrá forma de revertir esta acción.",
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
             url: '../controlador/cRegistroNuevosUsuarios.php?nuevoregistro=eliminar-solicitud-amistad&idsolicitudamigo='+IDSolicitudAmistad,
             type: 'POST',
                data: 'idsolicitudamigo='+IDSolicitudAmistad, // COMPARACION PREVIA ANTES DE EJECUTAR ACCION EN SERVIDOR
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
                    title: 'Solicitud Rechazada',
                    text: 'Has rechazado con éxito la solicitud de este usuario.',
                    icon: 'success',
                    timer: 2000,
                    showConfirmButton: false
                });
                
                // Dynamic DOM updates without reload
                if (element && element.length) {
                    // 1. If in topnav dropdown
                    var dropdownItem = element.closest('.iq-friend-request');
                    if (dropdownItem.length) {
                        dropdownItem.fadeOut(400, function() {
                            $(this).remove();
                            updateFriendRequestCounts();
                        });
                    }
                    // 2. If in listadosolicitudesamistad.php page
                    else {
                        var cardItem = element.closest('.iq-card');
                        if (cardItem.length) {
                            cardItem.fadeOut(400, function() {
                                $(this).remove();
                                updateFriendRequestCounts();
                            });
                        }
                    }
                }
            } else {
                AlertaUsuarioMostrar("Error", "Lo sentimos, en estos momentos no podemos procesar tu solicitud, por favor vuelve más tarde...", "error");
            }
        }
    }); 
   }

   function updateFriendRequestCounts() {
       var badge = $('#friend-requests-count-badge');
       var dot = $('#friend-requests-dot');
       if (badge.length) {
           var currentCount = parseInt(badge.text()) || 0;
           var newCount = Math.max(0, currentCount - 1);
           badge.text(newCount);
           if (newCount <= 0) {
               badge.hide();
               dot.hide();
               if ($('#friend-requests-dropdown-list').length) {
                   $('#friend-requests-dropdown-list').html('<div class="text-center p-4 text-muted"><p class="mb-0">No tienes solicitudes pendientes</p></div>');
               }
           }
       }
   }

// FUNCION PARA MOSTRAR ALERTAS A USUARIOS
function AlertaUsuarioMostrar(titulo, descripcion, icono) {
    Swal.fire(
        titulo, // ENCABEZADO 
        descripcion, // CUERPO
        icono // ICONO DE ALERTA
    );
}