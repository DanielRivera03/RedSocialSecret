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
    // #eliminarhistorias IDENTIDICADOR DE ID -> ACCION A EJECUTAR
    $(document).on('click', '#borraramigo', function(e){
     var IDAmigos = $(this).data('id'); // ID ENVIADA POR GET DESDE EL CONTROLADOR HACIA EL MODELO
     BorrarAmigo(IDAmigos); // ID UNICO DE HISTORIAS
     e.preventDefault();
    });
   });
   function BorrarAmigo(IDAmigos){ 
    Swal.fire({
        title: '¿Realmente desea eliminar este amigo?',
        text: "Al hacer clic en el botón confirmar, esta acción no es reversible. No obstante si el usuario lo desea, puede enviarle nuevamente una solicitud de amistad",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#EA2027',
        cancelButtonColor: '#5758BB',
        confirmButtonText: 'Confirmar',
        cancelButtonText: 'Cancelar',
     preConfirm: function() {
       return new Promise(function() {
          $.ajax({
          url: '../controlador/cPublicacionesUsuarios.php?publicaciones=eliminar-amigos&idamigo='+IDAmigos,
          type: 'POST',
             data: 'idamigo='+IDAmigos, // COMPARACION PREVIA ANTES DE EJECUTAR ACCION EN SERVIDOR
             dataType: 'json'
          })
          .done(function(respuesta){ // SI MODELO EJECUTA PETICION, REALIZA PETICION
            if(respuesta=="OK"){
                AlertaUsuarioMostrar("Amigo Eliminado","Su petición se ha completado con éxito","success");
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