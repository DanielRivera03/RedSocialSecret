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
    $("#form").on('submit',(function(e){ // "e" IDENTIFICADOR DE ACCION PARA CAPTURAR EVENTO DE FORMULARIO
        // VALIDACION DE ELEMENTOS DE FORMULARIO
        var NombreUsuario = document.getElementById("nombre").value; // NOMBRE NO UNICO DE USUARIO
        var ApellidoUsuario = document.getElementById("apellido").value; // APELLIDO NO UNICO DE USUARIO
        var CorreoUsuario = document.getElementById("correo").value; // CORREO DE USUARIO
        var PaisUsuario = document.getElementById("pais").value; // PAIS RESIDENCIA DE USUARIO
        var CiudadUsuario = document.getElementById("ciudad").value; // CIUDAD RESIDENCIA DE USUARIO
        var TelefonoUsuario = document.getElementById("telefono").value; // TELEFONO DE USUARIO
        var PrivacidadUsuario = document.getElementById("privacidad").value; // PRIVACIDAD PERFIL DE USUARIO
        var FechaNacimiento = document.getElementById("fecha_nacimiento").value; // FECHA DE NACIMIENTO
        var ClaveNueva = document.getElementById("clavenueva").value; // CONTRASEÑA NUEVA DE USUARIO
        var ClaveRepetida = document.getElementById("claverepetida").value; // CONTRIL INGRESO CONTRASEÑA
        /*
            --> ALERTAS DE ERRORES
        */
        // ALERTA NOMBRE DE USUARIO NO UNICO VACIO
        if(NombreUsuario ==""){
            AlertaUsuarioMostrar("Campo Incompleto","Nombre de usuario es requerido, complete ese campo","warning");
            return false;
        }
        // ALERTA APELLIDO DE USUARIO NO UNICO VACIO
        if(ApellidoUsuario ==""){
            AlertaUsuarioMostrar("Campo Incompleto","Apellido de usuario es requerido, complete ese campo","warning");
            return false;
        }
        // ALERTA CORREO VACIO
        if(CorreoUsuario ==""){
            AlertaUsuarioMostrar("Campo Incompleto","Correo es requerido, complete ese campo","warning");
            return false;
        }
        // ALERTA PAIS RESIDENCIA VACIO
        if(PaisUsuario ==""){
            AlertaUsuarioMostrar("Campo Incompleto","País de residencia es requerido, seleccione un país","warning");
            return false;
        }
        // ALERTA CIUDAD RESIDENCIA VACIO
        if(CiudadUsuario ==""){
            AlertaUsuarioMostrar("Campo Incompleto","Ciudad de residencia es requerido, complete ese campo","warning");
            return false;
        }
        // ALERTA TELEFONO VACIO
        if(TelefonoUsuario ==""){
            AlertaUsuarioMostrar("Campo Incompleto","Teléfono es requerido, complete ese campo","warning");
            return false;
        }
        // ALERTA PRIVACIDAD VACIO
        if(PrivacidadUsuario ==""){
            AlertaUsuarioMostrar("Campo Incompleto","Privacidad de perfil es requerido, seleccione una opcion","warning");
            return false;
        }
         // ALERTA FECHA NACIMIENTO VACIO
         if(FechaNacimiento ==""){
            AlertaUsuarioMostrar("Campo Incompleto","Fecha de Nacimiento es requerido, ingrese una fecha válida","warning");
            return false;
            /*
                --> SI TODO SE CUMPLE, ENTONCES...
                    INGRESA ACCION A BASE DE DATOS
            */
        }
        // ALERTA FECHA NACIMIENTO VACIO
        if(ClaveNueva ==""){
            AlertaUsuarioMostrar("Campo Incompleto","Contraseña es requerida, ingrese una contraseña válida","warning");
            return false;
        }
        if(ClaveRepetida ==""){
            AlertaUsuarioMostrar("Campo Incompleto","Debe repetir su nueva contraseña ingresada","warning");
            return false;
        }
        if(ClaveNueva!=ClaveRepetida){
            AlertaUsuarioMostrar("Error","Lo sentimos, la contraseña debe coincidir","error");
            return false;
             /*
                --> SI TODO SE CUMPLE, ENTONCES...
                    INGRESA ACCION A BASE DE DATOS
            */
        }else{
        e.preventDefault(e); // "e" IDENTIFICADOR DE ACCION PARA CAPTURAR EVENTO DE FORMULARIO
        $.ajax({
            url: "../controlador/cRegistroNuevosUsuarios.php?nuevoregistro=peticion-editarperfil",
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
                AlertaUsuarioMostrar("Perfil Editado","Enhorabuena 💓 petición de edición de perfil de usuario completada con éxito... Serás redirigido a tu perfil, espera un momento...","success");
                // DESHABILITAR CAMPOS LUEGO DE INGRESAR ACCION A BASE DE DATOS
                $('#fotoperfil').prop('disabled', true);
                $('#nombre').prop('disabled', true);
                $('#apellido').prop('disabled', true);
                $('#usuariounico').prop('disabled', true);
                $('#correo').prop('disabled', true);
                $('#clavenueva').prop('disabled', true);
                $('#claverepetida').prop('disabled', true);
                $('#correo').prop('disabled', true);
                $('#genero').prop('disabled', true);
                $('#pais').prop('disabled', true);
                $('#ciudad').prop('disabled', true);
                $('#telefono').prop('disabled', true);
                $('#privacidad').prop('disabled', true);
                $('#fecha_nacimiento').prop('disabled', true);
                $('#enviar').prop('disabled', true);
                // DESHABILITAR NAVEGACION DE MENU SUPERIOR
                $('#importante').prop('disabled', true);
                $('#registrocancelar').prop('disabled', true);
                // 5 SEGUNDOS DE RETRASO PARA MOSTRAR ALERTA Y REDIRECCIONAR
                setTimeout(function(){
                    location.href="../controlador/cPublicacionesUsuarios.php?publicaciones=retorno-edicionperfil";
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
