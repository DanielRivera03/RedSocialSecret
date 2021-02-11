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
     EliminarSolititudesAmistad(IDSolicitudAmistad); // ID UNICO DE HISTORIAS
     e.preventDefault();
    });
   });
   function EliminarSolititudesAmistad(IDSolicitudAmistad){ 
    Swal.fire({
        title: '¿Desea rechazar esta solicitud?',
        text: "Al hacerlo, no habrá forma de revertir esta acción.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#EA2027',
        cancelButtonColor: '#5758BB',
        confirmButtonText: 'Confirmar',
        cancelButtonText: 'Cancelar',
     preConfirm: function() {
       return new Promise(function() {
          $.ajax({
          url: '../controlador/cRegistroNuevosUsuarios.php?nuevoregistro=eliminar-solicitud-amistad&idsolicitudamigo='+IDSolicitudAmistad,
          type: 'POST',
             data: 'idsolicitudamigo='+IDSolicitudAmistad, // COMPARACION PREVIA ANTES DE EJECUTAR ACCION EN SERVIDOR
             dataType: 'json'
          })
          .done(function(respuesta){ // SI MODELO EJECUTA PETICION, REALIZA PETICION
            if(respuesta=="OK"){
                AlertaUsuarioMostrar("Solicitud Rechazada","Has rechazado con éxito la solicitud de este usuario... No obstante si él así lo desea puede enviarte nuevamente una solicitud nueva.","success");
                 // 3.8 SEGUNDOS DE RETRASO PARA MOSTRAR ALERTA Y REFRESCAR
                 setTimeout(function(){
                    location.href="../controlador/cPublicacionesUsuarios.php?publicaciones=retorno-solicitudamistad";
                }, 3800);
            }else{
                AlertaUsuarioMostrar("Solicitud Ya Enviada","Lo sentimos, ya has enviado previamente una solicitud de amistad a este usuario...","error");
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