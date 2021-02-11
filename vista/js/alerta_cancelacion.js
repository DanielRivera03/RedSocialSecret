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
    $("#cancelar_registro").on('submit',(function(e){
        // VALIDACION DE ELEMENTOS DE FORMULARIO
        var MotivoCancelarUsuario = document.getElementById("motivo_cancelacion").value; // NOMBRE NO UNICO DE USUARIO
        var DetalleCancelarUsuario = document.getElementById("detalle_cancelacion").value; // APELLIDO NO UNICO DE USUARIO
        /*
            --> ALERTAS DE ERRORES
        */
        // ALERTA MOTIVO DE CANCELACION VACIO
        if(MotivoCancelarUsuario ==""){
            AlertaUsuarioMostrar("Campo Incompleto","Motivo de cancelación es requerido, complete ese campo.","warning");
            return false;
        }
        // ALERTA DETALLE DE CANCELACION VACIO
        if(DetalleCancelarUsuario ==""){
            AlertaUsuarioMostrar("Campo Incompleto","Detalle de cancelación es requerido, complete ese campo.","warning");
            return false;
            /*
                --> SI TODO SE CUMPLE, ENTONCES...
                    INGRESA ACCION A BASE DE DATOS
            */
        }else{
            e.preventDefault(e); // "e" IDENTIFICADOR DE ACCION PARA CAPTURAR EVENTO DE FORMULARIO
            $.ajax({
                url: "../controlador/cRegistroNuevosUsuarios.php?nuevoregistro=cancelar_perfil",
                type: "POST",
                dataType: 'json',
                data:  new FormData(this),
                contentType: false,
                cache: false,
                processData:false,
            }).done(function(respuesta){
            // SI ACCION ES CONFIRMADA POR EL MODELO, REALIZA ACTUALIZACION DE PERFIL
                if(respuesta == "OK"){
                    // MENSAJE DE CONFIRMACION EXITOSO
                    AlertaUsuarioMostrar("Cancelación Completada","Usted acaba de cancelar su registro, acción que no es reversible. Espere un momento por favor...","success");
                    // DESHABILITAR CAMPOS LUEGO DE INGRESAR ACCION A BASE DE DATOS
                    $('#motivo_cancelacion').prop('disabled', true);
                    $('#detalle_cancelacion').prop('disabled', true);
                    $('#enviar').prop('disabled', true);
                    // DESHABILITAR NAVEGACION DE MENU SUPERIOR
                    $('#informacionpersonal').prop('disabled', true);
                    $('#importante').prop('disabled', true);
                    $('#registrocancelar').prop('disabled', true);
                    // 5 SEGUNDOS DE RETRASO PARA MOSTRAR ALERTA
                    setTimeout( function(){
                        location.href="../controlador/ControlInicioSesiones.php?validarsesion=perfilcompletado";
                    }, 5000);
                }else{ // FALLO PROCESAMIENTO DE DATOS -> DENTRO DEL SISTEMA
                    AlertaUsuarioMostrar("Error","Lo sentimos, verifica si cumples con todos los campos, si todo está bien, por favor vuelve más tarde...","error");
                }
                // FALLO PROCESAMIENTO DE DATOS -> FUERA DEL SISTEMA
            }).fail(function(respuesta) {
                AlertaUsuarioMostrar("Error",respuesta,"error");
            });
            }
        }));
    });
// FUNCION PARA MOSTRAR ALERTAS A USUARIOS
function AlertaUsuarioMostrar(titulo, descripcion, icono) {
    Swal.fire(
        titulo, // ENCABEZADO 
        descripcion, // CUERPO
        icono // ICONO DE ALERTA
    );
}
