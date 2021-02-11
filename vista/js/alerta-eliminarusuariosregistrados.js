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
    $(document).on('click', '#eliminarcuentausuarios', function(e){
     var IDUsuariosUnico = $(this).data('id'); // ID ENVIADA POR GET DESDE EL CONTROLADOR HACIA EL MODELO
     BorrarUsuarios(IDUsuariosUnico); // ID UNICO DE HISTORIAS
     e.preventDefault();
    });
   });
   function BorrarUsuarios(IDUsuariosUnico){ 
    Swal.fire({
        title: '¿Realmente desea darse de baja?',
        text: "Al hacer clic en el botón confirmar, no habrá forma revertir la acción",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#EA2027',
        cancelButtonColor: '#5758BB',
        confirmButtonText: 'Confirmar',
        cancelButtonText: 'Cancelar',
     preConfirm: function() {
       return new Promise(function() {
          $.ajax({
          url: '../controlador/cRegistroNuevosUsuarios.php?nuevoregistro=eliminar-usuarios-definitivamente&idusuariounico='+IDUsuariosUnico,
          type: 'POST',
             data: 'idusuariounico='+IDUsuariosUnico, // COMPARACION PREVIA ANTES DE EJECUTAR ACCION EN SERVIDOR
             dataType: 'json'
          })
          .done(function(respuesta){ // SI MODELO EJECUTA PETICION, REALIZA PETICION
            if(respuesta=="OK"){
                let timerInterval;
                Swal.fire({
                    icon: 'success',
                    title: 'Usuario Eliminado',
                    text: 'Lamentamos mucho esta situación, gracias por usar Secret. Te esperamos nuevamente con los brazos abiertos. Espera un momento, procesando...',
                    timer: 6000,
                    timerProgressBar: true,
                    didOpen: () => {
                      Swal.showLoading()
                      timerInterval = setInterval(() => {
                        const content = Swal.getContent()
                        if (content) {
                          const b = content.querySelector('b')
                          if (b) {
                            b.textContent = Swal.getTimerLeft()
                          }
                        }
                      }, 100)
                    },
                    willClose: () => {
                      clearInterval(timerInterval)
                    }
                  })
                 // 6 SEGUNDOS DE RETRASO PARA MOSTRAR ALERTA Y REFRESCAR
                 setTimeout(function(){
                    // REGRESO AL INICIO DE LA PLATAFORMA CON ACCION DE ELIMINACION COMPLETADA
                    location.href="../controlador/cRegistroNuevosUsuarios.php?nuevoregistro=retorno-usuarioseliminados";
                }, 6000);
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