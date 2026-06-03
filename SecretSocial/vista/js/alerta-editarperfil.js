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
        }
        
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
    }));

    // NUEVO FORMULARIO PARA CAMBIAR CONTRASEÑA
    $("#form_cambiar_clave").on('submit',(function(e){
        e.preventDefault();
        
        var ClaveActual = document.getElementById("clave_actual").value;
        var ClaveNueva = document.getElementById("clave_nueva").value;
        var ClaveNuevaRepetida = document.getElementById("clave_nueva_repetida").value;
        
        if(ClaveActual == ""){
            AlertaUsuarioMostrar("Campo Incompleto","La contraseña actual es requerida.","warning");
            return false;
        }
        if(ClaveNueva == ""){
            AlertaUsuarioMostrar("Campo Incompleto","La nueva contraseña es requerida.","warning");
            return false;
        }
        if(ClaveNueva.length < 8){
            AlertaUsuarioMostrar("Contraseña muy corta","La nueva contraseña debe tener al menos 8 caracteres.","warning");
            return false;
        }
        if(ClaveNuevaRepetida == ""){
            AlertaUsuarioMostrar("Campo Incompleto","Debe confirmar su nueva contraseña.","warning");
            return false;
        }
        if(ClaveNueva !== ClaveNuevaRepetida){
            AlertaUsuarioMostrar("Error de coincidencia","Las nuevas contraseñas no coinciden.","error");
            return false;
        }
        
        $.ajax({
            url: "../controlador/cRegistroNuevosUsuarios.php?nuevoregistro=peticion-cambiarclave",
            type: "POST",
            dataType: 'json',
            data: {
                clave_actual: ClaveActual,
                clave_nueva: ClaveNueva
            }
        }).done(function(respuesta){
            if(respuesta == "OK"){
                AlertaUsuarioMostrar("Contraseña Actualizada","Enhorabuena 🔑 tu contraseña ha sido cambiada con éxito. Se ha enviado un correo de confirmación de seguridad.","success");
                $("#form_cambiar_clave")[0].reset();
            }else if(respuesta == "INCORRECT_CURRENT"){
                AlertaUsuarioMostrar("Contraseña Incorrecta","La contraseña actual ingresada es incorrecta. Por favor verifícala.","error");
            }else{
                AlertaUsuarioMostrar("Error", respuesta || "Hubo un error al intentar cambiar la contraseña.","error");
            }
        }).fail(function(respuesta) {
            AlertaUsuarioMostrar("Error","No se pudo procesar la solicitud. Por favor intenta más tarde.","error");
        });
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
