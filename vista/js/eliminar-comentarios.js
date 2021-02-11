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
    $(document).on('click', '#eliminarcomentarios', function(e){
     var IDComentarios = $(this).data('id'); // ID ENVIADA POR GET DESDE EL CONTROLADOR HACIA EL MODELO
     BorrarComentario(IDComentarios); // ID UNICO DE HISTORIAS
     e.preventDefault();
    });
   });
   function BorrarComentario(IDComentarios){ 
       return new Promise(function() {
          $.ajax({
          url: '../controlador/cPublicacionesUsuarios.php?publicaciones=eliminar-comentarios&idcomentariopublicacion='+IDComentarios,
          type: 'POST',
             data: 'idcomentariopublicacion='+IDComentarios, // COMPARACION PREVIA ANTES DE EJECUTAR ACCION EN SERVIDOR
             dataType: 'json'
          })
          .done(function(respuesta){ // SI MODELO EJECUTA PETICION, REALIZA PETICION
            if(respuesta=="OK"){
                 // 0.70 SEGUNDOS DE RETRASO PARA MOSTRAR ALERTA Y REFRESCAR
                 setTimeout(function(){
                    location.reload();
                }, 700);
            }
          })
          .fail(function(){
            AlertaUsuarioMostrar("Error","Lo sentimos, en estos momentos no podemos procesar tu solicitud, por favor vuelve más tarde...","error");
          });
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