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
    $("#form").on('submit',(function(e){
        // VALIDACION DE ELEMENTOS DE FORMULARIO
        var NombreEvento = document.getElementById("nombre_evento").value; // NOMBRE DEL EVENTO
        var DescripcionEvento = document.getElementById("descripcion_evento").value; // DESCRIPCION DEL EVENTO
        var DireccionEvento = document.getElementById("direccion_evento").value; // DIRECCION DEL EVENTO
        var InicioEvento = document.getElementById("diainicio_evento").value; // FECHA INICIO DEL EVENTO
        var FinEvento = document.getElementById("diafin_evento").value; // FECHA FIN DEL EVENTO
        var FotoEvento = document.getElementById("foto_evento").value; // FOTO DEL EVENTO
        /*
            --> ALERTAS DE ERRORES
        */
        // ALERTA MOTIVO DE CANCELACION VACIO
        if(NombreEvento ==""){
            AlertaUsuarioMostrar("Campo Incompleto","Nombre del evento es requerido, complete ese campo.","warning");
            return false;
        }
        if(DescripcionEvento ==""){
            AlertaUsuarioMostrar("Campo Incompleto","Descripción del evento es requerido, complete ese campo.","warning");
            return false;
        }
        if(DireccionEvento ==""){
            AlertaUsuarioMostrar("Campo Incompleto","Dirección del evento es requerido, complete ese campo.","warning");
            return false;
        }
        if(InicioEvento ==""){
            AlertaUsuarioMostrar("Campo Incompleto","Fecha de Inicio del evento es requerido, complete ese campo.","warning");
            return false;
        }
        if(FinEvento ==""){
            AlertaUsuarioMostrar("Campo Incompleto","Fecha de finalización del evento es requerido, complete ese campo.","warning");
            return false;
        }
        if(FotoEvento ==""){
            AlertaUsuarioMostrar("Campo Incompleto","Foto del evento es requerido, complete ese campo.","warning");
            return false;
        }
        // ALERTA DETALLE DE CANCELACION VACIO
        
            /*
                --> SI TODO SE CUMPLE, ENTONCES...
                    INGRESA ACCION A BASE DE DATOS
            */
        else{
            e.preventDefault(e); // "e" IDENTIFICADOR DE ACCION PARA CAPTURAR EVENTO DE FORMULARIO
            $.ajax({
                url: "../controlador/cEventosSecretSocial.php?eventos_sociales=registrar-nuevo-evento",
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
                    AlertaUsuarioMostrar("Evento Social Registrado","Enhorabuena, acabas de registrar un nuevo evento social disponible en tu localidad","success");
                    // 2 SEGUNDOS DE RETRASO PARA MOSTRAR ALERTA
                    setTimeout( function(){
                        location.href="../Eventos/mostrareventos";
                    }, 2000);
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
