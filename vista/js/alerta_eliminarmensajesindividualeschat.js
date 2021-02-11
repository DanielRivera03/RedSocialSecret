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
    // #eliminareventos IDENTIDICADOR DE ID -> ACCION A EJECUTAR
    $(document).on('click', '#eliminarmensajesindividuales', function(e){
     var IDMensajes = $(this).data('id'); // ID ENVIADA POR GET DESDE EL CONTROLADOR HACIA EL MODELO
     BorrarMensajes(IDMensajes); // ID UNICO DE HISTORIAS
     e.preventDefault();
    });
   });
   function BorrarMensajes(IDMensajes){ 
    Swal.fire({
        title: '¿Realmente desea eliminar este mensaje?',
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
          url: '../controlador/cPublicacionesUsuarios.php?publicaciones=eliminar-mensajes-individuales-chat&idunicomensaje='+IDMensajes,
          type: 'POST',
             data: 'idunicomensaje='+IDMensajes, // COMPARACION PREVIA ANTES DE EJECUTAR ACCION EN SERVIDOR
             dataType: 'json'
          })
          .done(function(respuesta){ // SI MODELO EJECUTA PETICION, REALIZA PETICION
            if(respuesta=="OK"){
                AlertaUsuarioMostrar("Mensaje Eliminado","Su petición se ha completado con éxito","success");
                 // 1.5 SEGUNDOS DE RETRASO PARA MOSTRAR ALERTA Y REFRESCAR
                 setTimeout(function(){
                    location.reload();
                }, 1500);
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