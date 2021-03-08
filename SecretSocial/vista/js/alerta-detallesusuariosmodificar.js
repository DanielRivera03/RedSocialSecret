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
    $("#detallesusuarios_modificar").on('submit',(function(e){ // "e" IDENTIFICADOR DE ACCION PARA CAPTURAR EVENTO DE FORMULARIO
    var SobreMi = document.getElementById("sobremi").value; // DESCRIPCION CORTA DE USUARIO
    if(SobreMi==""){
        AlertaUsuarioMostrar("Campo Incompleto","Sobre mí es requerido, por favor complete ese campo","warning");
    }else{
        e.preventDefault(e); // "e" IDENTIFICADOR DE ACCION PARA CAPTURAR EVENTO DE FORMULARIO
        $.ajax({
            url: "../controlador/cRegistroNuevosUsuarios.php?nuevoregistro=peticion-modificardetallesusuarios",
            type: "POST",
            dataType: 'json',
            data:  new FormData(this),
            contentType: false,
            cache: false,
            processData:false,
        }).done(function(respuesta){
            // SI ACCION ES CONFIRMADA POR EL MODELO, REALIZA ACTUALIZACION DE PERFIL
            if(respuesta == "OK"){
                // PRIMERA VEZ -> NUEVA INSERCIÓN
                // MENSAJE DE CONFIRMACION EXITOSO
                AlertaUsuarioMostrar("Registro Modificado","Enhorabuena, edición de detalles de usuario ha finalizado con éxito, serás redirigido a tu perfil...","success");
                // DESHABILITAR CAMPOS LUEGO DE INGRESAR ACCION A BASE DE DATOS
                $('#enviar').prop('disabled', true);
                $('#enviardetalles').prop('disabled', true);
                // DESHABILITAR NAVEGACION DE MENU SUPERIOR
                $('#informaciondetalles-usuarios').prop('disabled', true);
                $('#informacion-personal').prop('disabled', true);
                // 1.5 SEGUNDOS DE RETRASO PARA MOSTRAR ALERTA Y REDIRECCIONAR
                setTimeout(function(){
                    location.href="../controlador/cPublicacionesUsuarios.php?publicaciones=retorno-edicionperfil";
                }, 1500);
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