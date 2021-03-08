<?php
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

session_start();
// IMPORTANDO ARCHIVO DE CONEXION
require('../modelo/conexion.php');
// IMPORTANDO MODELO DE PUBLICACIONES DE USUARIOS
require('../modelo/mModeloPublicaciones.php');
// CREANDO INSTANCIA DE CLASE REFERENCIADA
$Publicaciones=new PublicacionesUsuarios();
// SI PETICION DE USUARIO NO HA SIDO PROCESADA ENTONCES...
if(isset($_GET['publicaciones']))
{
    $peticion_url=$_GET['publicaciones'];  // ENVIO GET DE VALOR ACCION {URL}
}
// ASIGNA VALOR POR DEFECTO...
else
{
    $peticion_url="registrarpublicacion";  // CASO CONTRARIO, VALOR POR DEFECTO
} 
switch($peticion_url){
    // MOSTRAR TERMINOS Y CONDICIONES -> PRIVACIDAD A TODOS LOS USUARIOS
    case "privacidad-condiciones":
        // VISTA LIBRE -> ES POSIBLE VISUALIZAR SIN INICIAR SESION EN LA PLATAFORMA
        require('../vista/privacidad.php');
    break;    
    // MOSTRAR INICIO DE ESTA APLICACION -> FEED DE NOTICIAS {INICIO}
    case "inicio":
        $IdSolicitudAmigo = $_SESSION['id_usuario']; // ID USUARIO UNICO -> QUIEN RECIBE LAS SOLICITUDES
        $Pais = $_SESSION['pais_usuarios'];
        // CONSULTA DE TODAS LAS APLICACIONES REGISTRADAS -> POR TODOS LOS USUARIOS
        $consulta=$Publicaciones->ConsultarPublicacionesInicio($conectarsistema,$IdSolicitudAmigo);
        // CONSULTAR SOLICITUDES DE AMISTAD RECIBIDAS
        $consulta1=$Publicaciones->ConsultarSolicitudesAmistad($conectarsistema14,$IdSolicitudAmigo);
        // CONSULTAR NOTIFICACIONES AMIGOS ACEPTADOS -> TODOS LOS USUARIOS
        $consulta2=$Publicaciones->ConsultarNotificacionesAmigos($conectarsistema16,$IdSolicitudAmigo);
        // CONSULTAR CUMPLEAÑEROS DE ESTE DIA -> TODOS LOS USUARIOS QUE COINCIDA EL ID UNICO
        // QUE INDICA SI EL USUARIO QUE HA INICIADO SESION ES AMIGO O NO DEL AMIGO CONSULTADO
        $consulta3=$Publicaciones->ConsultarCumpleanerosActuales($conectarsistema5,$IdSolicitudAmigo);
        // CONSULTAR TODOS LOS EVENTOS REGISTRADOS POR TODOS LOS USUARIOS
        $consulta4=$Publicaciones->ConsultarEventosRegistradosMiniatura($conectarsistema2,$Pais);
        // TODAS LAS CONSULTAS ANIDADAS EN UNA SOLA PAGINA
        require('../vista/inicio.php');
        $conectarsistema->close(); // CERRANDO CONEXION
        $conectarsistema2->close(); // CERRANDO CONEXION AUXILIAR 2
        $conectarsistema5->close(); // CERRANDO CONEXION AUXILIAR 5
        $conectarsistema14->close(); // CERRANDO CONEXION AUXILIAR 14
        $conectarsistema16->close(); // CERRANDO CONEXION AUXILIAR 16
    break;
    // REGISTRAR TODAS LAS PUBLICACIONES DE TODOS LOS USUARIOS DE ESTA PLATAFORMA
    case "registrarpublicacion":
        $mensajepublicacion = $_POST['historiausuario']; // HISTORIA NUEVA PUBLICACION
        $fotopublicacion=$_FILES['fotospublicaciones']['name']; // FOTO DE HISTORIA DE PUBLICACION
        $RutaDestino='../vista/images/fotospublicaciones/'.$fotopublicacion; // DESTINO GUARDADO DE FOTOS
        $ExtensionFoto=$_FILES['fotospublicaciones']['type']; // CAPTURA EL TIPO DE FOTO {EXTENSION}
        $IdUsuarios = $_SESSION['id_usuario']; // ID UNICO DE USUARIO REGISTRADO
        // EVITAR INGRESO VACIO, O MAL INTENCIONADO
        if(empty($mensajepublicacion) && empty($fotopublicacion)){
            header("location:../Feed/inicio");
        }else{
            $consulta=$Publicaciones->RegistrarNuevasPublicaciones($conectarsistema,$mensajepublicacion,$fotopublicacion,$IdUsuarios);
            // COPIA ARCHIVO SUBIDO CON NOMBRE FINAL A LA RUTA ESTABLECIDA
            copy($_FILES['fotospublicaciones']['tmp_name'],$RutaDestino);
            // ENVIANDO RESPUESTA A MODELO
            echo json_encode($consulta);
        }
        $conectarsistema->close(); // CERRANDO CONEXION
    break;
    /*
        -> IMPORTANTE
            CASO SOLAMENTE PARA MOSTRAR INFORMACION ESTRICTAMENTE DE PERFILES PROPIETARIOS
                -> PARA EL CASO DE LA VISTA DE TODOS LOS USUARIOS REGISTRADOS ES EL SIGUIENTE CASO
    */
    // MOSTRAR PERFIL DE USUARIO PERSONAL -> PERFILES PROPIETARIOS
     case "perfil-usuario":
        // CONSULTA PUBLICACIONES DE USUARIOS
        $IdUsuarios = $_SESSION['id_usuario']; // ID UNICO DE USUARIO REGISTRADO
        $IdNombreUsuarios = $_SESSION['usuario_unico']; // ID UNICO DE USUARIO REGISTRADO
        $IdSolicitudAmigo = $_SESSION['id_usuario']; // ID USUARIO UNICO -> QUIEN RECIBE LAS SOLICITUDES
        // CONSULTAR PUBLICACIONES REGISTRADAS POR EL USUARIO A CONSULTAR {PERFIL PROPIETARIO}
        $consulta=$Publicaciones->ConsultarPerfilUsuarios($conectarsistema,$IdUsuarios);
        // CONSULTA DETALLES PERFIL DE USUARIOS
        $consulta1=$Publicaciones->ConsultarDetallesPerfilUsuario($conectarsistema1,$IdNombreUsuarios);
        // CONSULTA FOTOS SUBIDAS PERFIL DE USUARIOS {MINIATURAS}
        $consulta2=$Publicaciones->ConsultarFotosSubidasPerfilUsuario($conectarsistema3,$IdNombreUsuarios);
        // CONSULTA FOTOS SUBIDAS PERFIL DE USUARIOS {COMPLETA -> SECCION MULTIMEDIA}
        $consulta3=$Publicaciones->ConsultarFotosSubidasCompletaPerfilUsuario($conectarsistema4,$IdNombreUsuarios);
        // CONSULTAR TODOS LOS AMIGOS CONFIRMADOS -> {PERFILES PROPIETARIOS}
        // MINIATURAS
        $consulta4=$Publicaciones->ConsultarAmigosPerfilesPropietarios($conectarsistema6,$IdUsuarios);
        // MENU SECUNDARIO PRINCIPAL
        $consulta5=$Publicaciones->ConsultarAmigosPerfilesPropietariosPrincipal($conectarsistema9,$IdUsuarios);
        // CONSULTAR SOLICITUDES DE AMISTAD RECIBIDAS
        $consulta6=$Publicaciones->ConsultarSolicitudesAmistad($conectarsistema14,$IdSolicitudAmigo);
        // CONSULTAR NOTIFICACIONES AMIGOS ACEPTADOS -> TODOS LOS USUARIOS
        $consulta7=$Publicaciones->ConsultarNotificacionesAmigos($conectarsistema16,$IdUsuarios);
        // TODAS LAS CONSULTAS ANIDADAS EN UNA SOLA PAGINA
        require('../vista/perfil.php');
        // CIERRE DE CONEXIONES
        $conectarsistema->close(); // CERRANDO CONEXION PRINCIPAL
        $conectarsistema1->close(); // CERRANDO CONEXION AUXILIAR 1
        $conectarsistema3->close(); // CERRANDO CONEXION AUXILIAR 3
        $conectarsistema4->close(); // CERRANDO CONEXION AUXILIAR 4
        $conectarsistema6->close(); // CERRANDO CONEXION AUXILIAR 6
        $conectarsistema9->close(); // CERRANDO CONEXION AUXILIAR 9
        $conectarsistema14->close(); // CERRANDO CONEXION AUXILIAR 14
        $conectarsistema16->close(); // CERRANDO CONEXION AUXILIAR 16
    break;
    // MOSTRAR PERFIL DE USUARIOS REGISTRADOS -> TODOS LOS PERFILES DE USUARIOS
    case "perfil-general":
        // CONSULTA PUBLICACIONES DE USUARIOS
        $IdUsuarios = $_GET['usuario']; // ID NOMBRE DE USUARIO UNICO DE USUARIO REGISTRADO
        $ID = $_GET['id']; // ID NUMERICO UNICO DE USUARIO REGISTRADO
        $IdSolicitudAmigo = $_SESSION['id_usuario']; // ID USUARIO UNICO -> QUIEN RECIBE LAS SOLICITUDES
        // CONSULTAR PUBLICACIONES REGISTRADAS POR EL USUARIO A CONSULTAR {TODOS LOS PERFILES}
        $consulta=$Publicaciones->ConsultarPerfilUsuariosGeneral($conectarsistema,$IdUsuarios);
        // CONSULTA DETALLES PERFIL DE USUARIOS
        $consulta1=$Publicaciones->ConsultarDetallesPerfilUsuarioGeneral($conectarsistema11,$IdUsuarios);
        // CONSULTA FOTOS SUBIDAS PERFIL DE USUARIOS {MINIATURAS}
        $consulta2=$Publicaciones->ConsultarFotosSubidasPerfilUsuarioGeneral($conectarsistema3,$IdUsuarios);
        // CONSULTA FOTOS SUBIDAS PERFIL DE USUARIOS {COMPLETA -> SECCION MULTIMEDIA}
        $consulta3=$Publicaciones->ConsultarFotosSubidasCompletaPerfilUsuarioGeneral($conectarsistema4,$IdUsuarios);
         // CONSULTAR TODOS LOS AMIGOS CONFIRMADOS -> {TODOS LOS USUARIOS -> TODOS LOS PERFILES}
        // MINIATURAS
        $consulta4=$Publicaciones->ConsultarAmigosPerfilesGeneral($conectarsistema6,$ID);
        // MENU SECUNDARIO PRINCIPAL
        $consulta5=$Publicaciones->ConsultarAmigosPerfilesGeneralPrincipal($conectarsistema9,$ID);
        // CONSULTAR SOLICITUDES DE AMISTAD RECIBIDAS
        $consulta6=$Publicaciones->ConsultarSolicitudesAmistad($conectarsistema14,$IdSolicitudAmigo);
        // CONSULTAR NOTIFICACIONES AMIGOS ACEPTADOS -> TODOS LOS USUARIOS
        $consulta7=$Publicaciones->ConsultarNotificacionesAmigos($conectarsistema16,$IdSolicitudAmigo);
        // TODAS LAS CONSULTAS ANIDADAS EN UNA SOLA PAGINA
        require('../vista/perfilesgeneral.php');
        // CIERRE DE CONEXIONES
        $conectarsistema->close(); // CERRANDO CONEXION PRINCIPAL
        $conectarsistema1->close(); // CERRANDO CONEXION AUXILIAR 1
        $conectarsistema3->close(); // CERRANDO CONEXION AUXILIAR 3
        $conectarsistema4->close(); // CERRANDO CONEXION AUXILIAR 4
        $conectarsistema6->close(); // CERRANDO CONEXION AUXILIAR 6
        $conectarsistema9->close(); // CERRANDO CONEXION AUXILIAR 9
        $conectarsistema11->close(); // CERRANDO CONEXION AUXILIAR 11
        $conectarsistema14->close(); // CERRANDO CONEXION AUXILIAR 14
        $conectarsistema16->close(); // CERRANDO CONEXION AUXILIAR 16
    break;    
    // MOSTRAR COMENTARIOS REGISTRADOS EN PUBLICACIONES {EXCLUSIVAMENTE PERFILES PROPIETARIOS}
    case "comentariosperfilusuario":
        $IdPublicaciones=$_GET['idpublicacion']; // ID UNICA DE PUBLICACION REGISTRADA
        // CONSULTA COMENTARIOS TODAS LAS PUBLICACIONES USUARIOS {PERFIL PROPIETARIO} 
        // TODOS LOS USUARIOS REGISTRADOS PUEDEN COMENTAR LAS PUBLICACIONES 
        $consulta=$Publicaciones->ConsultarComentariosPerfilPropietario($conectarsistema5,$IdPublicaciones);
        // CONSULTAR NOMBRES, APELLIDOS -> TODOS LOS COMENTARIOS REGISTRADOS
        $consulta1=$Publicaciones->ConsultarNombresUsuariosComentarios($conectarsistema,$IdPublicaciones);
        // ARCHIVO QUE ALOJA COMENTARIOS REGISTRADOS SEGUN ID DE PUBLICACION
        require('../vista/cargarcomentariosperfilpropietario.php');
        $conectarsistema->close(); // CERRANDO CONEXION
        $conectarsistema5->close(); // CERRANDO CONEXION AUXILIAR 5
    break;
    // BORRAR DEFINITIVAMENTE HISTORIAS PUBLICADAS
    case "borrar-historias":
        $IdPublicaciones=$_GET['idpublicacion']; // ID UNICA DE PUBLICACION REGISTRADA
        // EVITAR INGRESO VACIO O MAL INTENCIONADO
        if(empty($IdPublicaciones)){
            header("location:../Feed/inicio");
        }else{
            $consulta=$Publicaciones->EliminarHistoriasPublicadas($conectarsistema,$IdPublicaciones);
            // ENVIANDO RESPUESTA A MODELO
            echo json_encode($consulta);
        }
        $conectarsistema->close(); // CERRANDO CONEXION
    break;
    // REGISTRO DE NUEVOS COMENTARIOS {TODOS LOS USUARIOS -> TODAS LAS PUBLICACIONES}
    // APLICABLE DESDE LOS DIFERENTES PERFILES DE USUARIOS REGISTRADOS
    case "registrarcomentariosperfiles":
        $Comentario = $_POST['caja_comentarios']; // COMENTARIOS REGISTRADOS DE USUARIOS
        $IdUsuarios = $_SESSION['id_usuario']; // ID UNICO DE USUARIO REGISTRADO
        $IdPublicaciones=$_GET['idpublicacion']; // ID UNICA DE PUBLICACION REGISTRADA
        // EVITAR INGRESO VACIO O MAL INTENCIONADO
        if(empty($Comentario)){
            //header("location:ControlInicioSesiones.php?validarsesion=feed");
        }else{
            $consulta=$Publicaciones->RegistrarNuevosComentarios($conectarsistema,$Comentario,$IdUsuarios,$IdPublicaciones);
            echo json_encode($consulta);
        }// CIERRE if(empty($Comentario)){
        $conectarsistema->close(); // CERRANDO CONEXION
    break;
    // RETORNO EDICION DE PERFIL ENVIOS SOLICITUD DE AMISTAD / NOTIFICACIONES -> TODOS LOS USUARIOS {PERFIL PROPIETARIO}
    case "retorno-edicionperfil":   
    case "retorno-solicitudamistad":
    case "retorno-notificaciones":      
        header('location:../Perfil/'.$_SESSION['usuario_unico'].'');
        $conectarsistema->close(); // CERRANDO CONEXION PRINCIPAL
    break;
    // ELIMINAR COMENTARIOS REGISTRADOS -> TODAS LAS HISTORIAS PUBLICADAS QUE COINCIDAN
    // CON EL ID DEL USUARIO QUE REGISTRO ESE COMENTARIO
    case "eliminar-comentarios":
        $IdComentariosPublicaciones=$_GET['idcomentariopublicacion']; // ID UNICA DE PUBLICACION REGISTRADA
        // EVITAR INGRESO VACIO O MAL INTENCIONADO
        if(empty($IdComentariosPublicaciones)){
            header("location:../Feed/inicio");
        }else{
            $consulta=$Publicaciones->EliminarComentariosHistoriasPublicadas($conectarsistema,$IdComentariosPublicaciones);
            // ENVIANDO RESPUESTA A MODELO
            echo json_encode($consulta);
        }
        $conectarsistema->close(); // CERRANDO CONEXION
    break;
    // MOSTRAR TODAS LAS NOTIFICACIONES -> AMIGOS / COMENTARIOS (TODOS LOS USUARIOS)
    case "mostrar-notificaciones":
        $IdUsuarios = $_SESSION['id_usuario']; // ID NOMBRE DE USUARIO UNICO DE USUARIO REGISTRADO
        $IdSolicitudAmigo = $_SESSION['id_usuario']; // ID USUARIO UNICO -> QUIEN RECIBE LAS SOLICITUDES
        /*
            -> CONSULTAS NOTIFICACIONES MENU SUPERIOR / NO COMPLETAS VISTA LIMITADA
        */
         // CONSULTAR SOLICITUDES DE AMISTAD RECIBIDAS
         $consulta=$Publicaciones->ConsultarSolicitudesAmistad($conectarsistema14,$IdSolicitudAmigo);
         // CONSULTAR NOTIFICACIONES AMIGOS ACEPTADOS -> TODOS LOS USUARIOS
         $consulta1=$Publicaciones->ConsultarNotificacionesAmigos($conectarsistema16,$IdUsuarios);
         /*
            -> CONSULTAS NOTIFICACIONES COMPLETAS / PAGINA DEDICADA EXCLUSIVAMENTE PARA MOSTRARLAS
        */
         // CONSULTAR NOTIFICACIONES AMIGOS ACEPTADOS -> TODOS LOS USUARIOS
         $consulta2=$Publicaciones->ConsultarNotificacionesAmigosCompleta($conectarsistema,$IdUsuarios);
          // CONSULTAR NOTIFICACIONES NUEVOS COMENTARIOS REGISTRADOS -> TODOS LOS USUARIOS
          $consulta3=$Publicaciones->ConsultarNotificacionesComentariosCompleta($conectarsistema1,$IdUsuarios);
         // TODAS LAS CONSULTAS ANIDADAS EN UNA SOLA PAGINA
        require('../vista/listadonotificaciones.php');
        // CIERRE DE CONEXIONES
        $conectarsistema->close(); // CERRANDO CONEXION
        $conectarsistema1->close(); // CERRANDO CONEXION AUXILIAR 1
        $conectarsistema14->close(); // CERRANDO CONEXION AUXILIAR 14
        $conectarsistema16->close(); // CERRANDO CONEXION AUXILIAR 16
    break;  
    // ELIMINAR DEFINITIVAMENTE NOTIFICACIONES DE SOLICITUDES DE AMISTAD ACEPTADAS
    case "eliminar-notificaciones-amigos":
        $IdSolicitudes=$_GET['idnotificacion']; // ID UNICO DE NOTIFICACION REGISTRADA
        // EVITAR PROCESAR PETICION VACIA -> NULO
        if(empty($IdSolicitudes)){
            header("location:../Feed/inicio");
        }else{
            $consulta=$Publicaciones->EliminarNotificacionSolicitudesAceptadas($conectarsistema,$IdSolicitudes);
            // ENVIANDO RESPUESTA A MODELO
            echo json_encode($consulta);
        }
        $conectarsistema->close(); // CERRANDO CONEXION
    break;  
    // ELIMINAR DEFINITIVAMENTE NOTIFICACIONES DE COMENTARIOS REGISTRADOS EN PUBLICACIONES
    case "eliminar-notificaciones-comentarios":
        $IdSolicitudes=$_GET['idnotificacion']; // ID UNICO DE NOTIFICACION REGISTRADA
        // EVITAR PROCESAR PETICION VACIA -> NULO
        if(empty($IdSolicitudes)){
            header("location:../Feed/inicio");
        }else{
            $consulta=$Publicaciones->EliminarNotificacionComentariosRegistrados($conectarsistema,$IdSolicitudes);
            // ENVIANDO RESPUESTA A MODELO
            echo json_encode($consulta);
        }
        $conectarsistema->close(); // CERRANDO CONEXION
    break;
    // CONSULTAR TODAS LAS SOLICITUDES DE AMISTAD RECIBIDAS {VERSION EXTENDIDA -> COMPLETA}
    case "solicitudes-amistad":
        $IdSolicitudAmigo = $_SESSION['id_usuario']; // ID USUARIO UNICO -> QUIEN RECIBE LAS SOLICITUDES
        $IdUsuarios = $_SESSION['id_usuario']; // ID NOMBRE DE USUARIO UNICO DE USUARIO REGISTRADO
         /*
            -> CONSULTAS NOTIFICACIONES MENU SUPERIOR / NO COMPLETAS VISTA LIMITADA
        */
         // CONSULTAR SOLICITUDES DE AMISTAD RECIBIDAS
         $consulta=$Publicaciones->ConsultarSolicitudesAmistad($conectarsistema14,$IdSolicitudAmigo);
         // CONSULTAR NOTIFICACIONES AMIGOS ACEPTADOS -> TODOS LOS USUARIOS
         $consulta1=$Publicaciones->ConsultarNotificacionesAmigos($conectarsistema16,$IdUsuarios);
          /*
            -> CONSULTAS NOTIFICACIONES COMPLETAS / PAGINA DEDICADA EXCLUSIVAMENTE PARA MOSTRARLAS
        */
        // CONSULTAR SOLICITUDES DE AMISTAD RECIBIDAS -> VERSION EXTENDIDA
        $consulta3=$Publicaciones->ConsultarSolicitudesAmistadCompleta($conectarsistema20,$IdSolicitudAmigo);
        // TODAS LAS CONSULTAS ANIDADAS EN UNA SOLA PAGINA
        require('../vista/listadosolicitudesamistad.php');
        // CIERRE DE CONEXIONES
        $conectarsistema14->close(); // CERRANDO CONEXION AUXILIAR 14
        $conectarsistema16->close(); // CERRANDO CONEXION AUXILIAR 16
        $conectarsistema20->close(); // CERRANDO CONEXION AUXILIAR 20
    break;  
    // ELIMINAR AMIGOS CONFIRMADOS -> PERFILES PROPIETARIOS
    case "eliminar-amigos":
        $IdUsuarios=$_GET['idamigo'];
        // EVITAR PROCESAR PETICION VACIA -> NULO
        if(empty($IdUsuarios)){
            header("location:../Feed/inicio");
        }else{
            $consulta=$Publicaciones->EliminarAmigos($conectarsistema,$IdUsuarios);
            // ENVIANDO RESPUESTA A MODELO
            echo json_encode($consulta);
        }
        $conectarsistema->close(); // CERRANDO CONEXION
    break;  
    // EXPLORAR TODOS LOS AMIGOS ACEPTADOS -> PERFILES PROPIETARIOS
    case "explorar-amigos-aceptados":
        $IdUsuarios=$_SESSION['id_usuario']; // ID UNICO DE USUARIOS REGISTRADOS
        $consulta=$Publicaciones->ConsultarAmigosPerfilesPropietariosPrincipal($conectarsistema,$IdUsuarios);
        // CONSULTAR SOLICITUDES DE AMISTAD RECIBIDAS
        $consulta1=$Publicaciones->ConsultarSolicitudesAmistad($conectarsistema14,$IdUsuarios);
        // CONSULTAR NOTIFICACIONES AMIGOS ACEPTADOS -> TODOS LOS USUARIOS
        $consulta2=$Publicaciones->ConsultarNotificacionesAmigos($conectarsistema16,$IdUsuarios);
        // PAGINA A MOSTRAR -> CONSULTA REALIZADA
        require('../vista/listadoamigosaceptados.php');
        $conectarsistema->close(); // CERRANDO CONEXION
        $conectarsistema14->close(); // CERRANDO CONEXION AUXILIAR 14
        $conectarsistema16->close(); // CERRANDO CONEXION AUXILIAR 16
    break;    
    case "registro-reacciones":
        $IdPublicaciones=$_GET['idpublicacion']; // ID UNICA DE PUBLICACION REGISTRADA
        $IdUsuarios=$_SESSION['id_usuario']; // ID UNICO DE USUARIOS REGISTRADOS
        // EVITAR INGRESO VACIO O MAL INTENCIONADO
        if(empty($IdPublicaciones)){
            header("location:../Feed/inicio");
       }else{
            // REGISTRO DE NUEVAS REACCIONES 
            $consulta=$Publicaciones->RegistrarNuevasReacciones($conectarsistema,$IdUsuarios,$IdPublicaciones);
             // ENVIANDO RESPUESTA A MODELO
             echo json_encode($consulta);
        }
        $conectarsistema->close(); // CERRANDO CONEXION
    break;
    /*
        -> MENSAJERIA INTERNA -> SECRET
    */
    // MOSTRAR PAGINA DE MENSAJERIA INTERNA DE ESTA RED SOCIAL
    case "mensajeria-secret":
        // CONSULTA PUBLICACIONES DE USUARIOS
        $IdUsuarios = $_SESSION['id_usuario']; // ID UNICO DE USUARIO REGISTRADO
        $IdNombreUsuarios = $_SESSION['usuario_unico']; // ID UNICO DE USUARIO REGISTRADO
        $IdSolicitudAmigo = $_SESSION['id_usuario']; // ID USUARIO UNICO -> QUIEN RECIBE LAS SOLICITUDES
        // CONSULTAR SOLICITUDES DE AMISTAD RECIBIDAS
        $consulta=$Publicaciones->ConsultarSolicitudesAmistad($conectarsistema14,$IdSolicitudAmigo);
        // CONSULTAR NOTIFICACIONES AMIGOS ACEPTADOS -> TODOS LOS USUARIOS
        $consulta1=$Publicaciones->ConsultarNotificacionesAmigos($conectarsistema16,$IdSolicitudAmigo);
        /*
            --> CONSULTA DE MENSAJERIA RECIBIDA POR TODOS LOS USUARIOS
                 -> {CHAT GENERAL}
        */
        // CONSULTAR MENSAJERIA RECIBIDA -> TODOS LOS USUARIOS PUEDEN PARTICIPAR
        $consulta2=$Publicaciones->ConsultarMensajeriaRecibida($conectarsistema);
        // TODAS LAS CONSULTAS ANIDADAS EN UNA SOLA PAGINA
        require('../vista/mensajeriausuarios.php');
        $conectarsistema->close(); // CERRANDO CONEXION
        $conectarsistema14->close(); // CERRANDO CONEXION AUXILIAR 14
        $conectarsistema16->close(); // CERRANDO CONEXION AUXILIAR 16
    break;
    // REGISTRO DE NUEVOS MENSAJES CHAT GENERAL -> ENVIO A BASE DE DATOS
    case "registro-mensajes-chatgeneral":
        $Mensaje=$_POST['mensajes_chat']; // MENSAJE QUE TODOS LOS USUARIOS INGRESEN AL CHAT GENERAL
        $IdUsuarios = $_SESSION['id_usuario']; // ID UNICO DE USUARIO REGISTRADO
        if(empty($Mensaje)){
            header("location:../Feed/inicio");
        }else{
            $consulta=$Publicaciones->RegistrarMensajesChatGeneral($conectarsistema,$Mensaje,$IdUsuarios);
            // ENVIANDO RESPUESTA A MODELO
            echo json_encode($consulta);
        }
        $conectarsistema->close(); // CERRANDO CONEXION
    break;
    // ELIMINAR MENSAJES CHAT GENERAL -> SOLAMENTE MENSAJES INDIVIDUALES DENTRO DEL CHAT
    case "eliminar-mensajes-individuales-chat":
        $IdMensajes=$_GET['idunicomensaje']; // ID UNICO DE MENSAJE QUE TODOS LOS USUARIOS INGRESEN AL CHAT GENERAL
        if(empty($IdMensajes)){
            header("location:../Feed/inicio");
        }else{
            // CONSULTA PARA ELIMINAR DEFINITIVAMENTE MENSAJES HA SIDO DESHABILITADA
            #$consulta=$Publicaciones->EliminarMensajesIndividualesChatGeneral($conectarsistema,$IdMensajes);
            // RETIRAR MENSAJES INGRESADOS POR USUARIOS
            $consulta=$Publicaciones->RetirarMensajesIndividualesChatGeneral($conectarsistema,$IdMensajes);
            // ENVIANDO RESPUESTA A MODELO
            echo json_encode($consulta);
        }
        $conectarsistema->close(); // CERRANDO CONEXION
    break;
    // MULTIMEDIA -> VIDEOS PUBLICADOS POR TODOS LOS USUARIOS DE ESTA PLATAFORMA
    case "multimedia-secretvideos":
        $IdSolicitudAmigo = $_SESSION['id_usuario']; // ID USUARIO UNICO -> QUIEN RECIBE LAS SOLICITUDES
        // CONSULTAR SOLICITUDES DE AMISTAD RECIBIDAS
        $consulta=$Publicaciones->ConsultarSolicitudesAmistad($conectarsistema14,$IdSolicitudAmigo);
        // CONSULTAR NOTIFICACIONES AMIGOS ACEPTADOS -> TODOS LOS USUARIOS
        $consulta1=$Publicaciones->ConsultarNotificacionesAmigos($conectarsistema16,$IdSolicitudAmigo);
        // CONSULTAR VIDEOS MUSICALES SUBIDOS -> VISTA LIMITADA A 60 ELEMENTOS MAXIMO
        $consulta2=$Publicaciones->ConsultarVideosMusicales($conectarsistema);
        // TODAS LAS CONSULTAS ANIDADAS EN UNA SOLA PAGINA
        require('../vista/multimedia-videos.php');
        $conectarsistema->close(); // CERRANDO CONEXION
        $conectarsistema14->close(); // CERRANDO CONEXION AUXILIAR 14
        $conectarsistema16->close(); // CERRANDO CONEXION AUXILIAR 16
    break;  
    // REGISTRO DE NUEVOS VIDEOS MUSICALES -> TODOS LOS USUARIOS -> TODA LA PLATAFORMA
    case "registro-secretvideos":
        $IdUsuarios=$_SESSION['id_usuario']; // ID UNICO DE USUARIO REGISTRADO
        $TituloVideo=$_POST['titulo_video'];
        $Video=$_FILES['videosmultimedia']['name']; // ARCHIVO MULTIMEDIA SUBIDO POR DE USUARIO
        $RutaDestino='../vista/multimedia/videos/'.$Video; // RUTA DE DESTINO GUARDADO DE ARCHIVOS
        // UNICAMENTE SE ADMITEN VIDEOS FORMATO MP4 -> VALIDADO EN INPUT RESPECTIVO
        $ExtensionArchivo=$_FILES['videosmultimedia']['type']; // CAPTURA EL TIPO DE ARCHIVO {EXTENSION}
        if(empty($TituloVideo) && empty($Video)){
            header("location:../Feed/inicio");
        }else{
            $consulta=$Publicaciones->RegistrarVideosMusicales($conectarsistema,$TituloVideo,$Video,$IdUsuarios);
            // COPIA ARCHIVO SUBIDO CON NOMBRE FINAL A LA RUTA ESTABLECIDA
            copy($_FILES['videosmultimedia']['tmp_name'],$RutaDestino);
            // ENVIANDO RESPUESTA A MODELO
            echo json_encode($consulta);
        }
        $conectarsistema->close(); // CERRANDO CONEXION
    break;  
    // ELIMINAR VIDEOS MUSICALES REGISTRADOS -> TODOS LOS USUARIOS SEGUN SU ID DE PUBLICACION
    case "eliminar-secretvideos":
        $IdVideo=$_GET['idvideomusical']; // ID UNICO DE VIDEO REGISTRADO
        if(empty($IdVideo)){
            header("location:../Feed/inicio");
        }else{
            $consulta=$Publicaciones->EliminarVideosMusicales($conectarsistema,$IdVideo);
             // ENVIANDO RESPUESTA A MODELO
             echo json_encode($consulta);
        }
        $conectarsistema->close(); // CERRANDO CONEXION
    break;    
    // BLOQUEAR ACCIONES NO EXISTENTES
    default:
        session_unset();
        session_destroy();
        $peticion_url=$_GET['noautorizado'];
        header('location:../AccesoDenegado=restringido');
        $conectarsistema->close(); // CERRANDO CONEXION
    break;
}
?>