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
    // #enviosolicitud IDENTIDICADOR DE ID -> ACCION A EJECUTAR
    $(document).on('click', '#aceptar-solicitudes', function(e){
     var IDAmigoSolicitud = $(this).data('id'); // ID ENVIADA POR GET DESDE EL CONTROLADOR HACIA EL MODELO
     var element = $(this);
     AceptarSolititudesAmistad(IDAmigoSolicitud, element); // ID UNICO DE HISTORIAS
     e.preventDefault();
    });
   });
   function AceptarSolititudesAmistad(IDAmigoSolicitud, element){ 
    Swal.fire({
        title: '¿Desea aceptar su solicitud de amistad?',
        text: "Al confirmar, el será tú amigo, no obstante si tú deseas ser amigo de este usuario, debes enviarle una solicitud de amistad.",
        icon: 'info',
        showCancelButton: true,
        confirmButtonColor: '#EA2027',
        cancelButtonColor: '#5758BB',
        confirmButtonText: 'Confirmar',
        cancelButtonText: 'Cancelar',
        showLoaderOnConfirm: true,
        preConfirm: function() {
          return new Promise(function(resolve) {
             $.ajax({
             url: '../controlador/cRegistroNuevosUsuarios.php?nuevoregistro=aceptar-solicitud-amistad&idsolicitudamigo='+IDAmigoSolicitud,
             type: 'POST',
                data: 'idsolicitudamigo='+IDAmigoSolicitud, // COMPARACION PREVIA ANTES DE EJECUTAR ACCION EN SERVIDOR
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
                    title: '¡Solicitud Aceptada!',
                    text: 'Ahora son amigos.',
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
                    // 2. If in resultadosbusqueda (search results page)
                    else if ($('#searchTabs').length) {
                        element.replaceWith('<button class="btn btn-secondary mr-2" disabled><i class="ri-check-line mr-1"></i> Amigos</button>');
                    }
                    // 3. If in listadosolicitudesamistad.php page
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