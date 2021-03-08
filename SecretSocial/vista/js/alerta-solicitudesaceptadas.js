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
     AceptarSolititudesAmistad(IDAmigoSolicitud); // ID UNICO DE HISTORIAS
     e.preventDefault();
    });
   });
   function AceptarSolititudesAmistad(IDAmigoSolicitud){ 
    Swal.fire({
        title: '¿Desea aceptar su solicitud de amistad?',
        text: "Al confirmar, el será tú amigo, no obstante si tú deseas ser amigo de este usuario, debes enviarle una solicitud de amistad.",
        icon: 'info',
        showCancelButton: true,
        confirmButtonColor: '#EA2027',
        cancelButtonColor: '#5758BB',
        confirmButtonText: 'Confirmar',
        cancelButtonText: 'Cancelar',
     preConfirm: function() {
       return new Promise(function() {
          $.ajax({
          url: '../controlador/cRegistroNuevosUsuarios.php?nuevoregistro=aceptar-solicitud-amistad&idsolicitudamigo='+IDAmigoSolicitud,
          type: 'POST',
             data: 'idsolicitudamigo='+IDAmigoSolicitud, // COMPARACION PREVIA ANTES DE EJECUTAR ACCION EN SERVIDOR
             dataType: 'json'
          })
          .done(function(respuesta){ // SI MODELO EJECUTA PETICION, REALIZA PETICION
            if(respuesta=="OK"){
                 // 0.4 SEGUNDOS DE RETRASO PARA MOSTRAR ALERTA Y REFRESCAR
                 setTimeout(function(){
                    location.reload();
                }, 400);
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