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

if (session_status() === PHP_SESSION_NONE) {
    session_set_cookie_params(0, '/');
    session_start();
}
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
        
        $nombres_fotos = [];
        if (isset($_FILES['fotospublicaciones']) && is_array($_FILES['fotospublicaciones']['name'])) {
            $total_archivos = min(5, count($_FILES['fotospublicaciones']['name']));
            for ($i = 0; $i < $total_archivos; $i++) {
                if ($_FILES['fotospublicaciones']['error'][$i] === UPLOAD_ERR_OK) {
                    $nombre_original = $_FILES['fotospublicaciones']['name'][$i];
                    $ext = strtolower(pathinfo($nombre_original, PATHINFO_EXTENSION));
                    if (in_array($ext, ['png', 'jpg', 'jpeg'])) {
                        // Generate a unique name to prevent collisions
                        $nombre_unico = uniqid('story_', true) . '_' . rand(1000, 9999) . '.' . $ext;
                        $RutaDestino = '../vista/images/fotospublicaciones/' . $nombre_unico;
                        if (move_uploaded_file($_FILES['fotospublicaciones']['tmp_name'][$i], $RutaDestino)) {
                            $nombres_fotos[] = $nombre_unico;
                        }
                    }
                }
            }
        }
        
        $fotopublicacion = implode(',', $nombres_fotos);
        $IdUsuarios = $_SESSION['id_usuario']; // ID UNICO DE USUARIO REGISTRADO
        
        $fondo_gradiente = isset($_POST['fondo_gradiente']) ? trim($_POST['fondo_gradiente']) : null;
        $sentimiento = isset($_POST['sentimiento']) ? trim($_POST['sentimiento']) : null;
        if (empty($fondo_gradiente)) $fondo_gradiente = null;
        if (empty($sentimiento)) $sentimiento = null;

        // EVITAR INGRESO VACIO, O MAL INTENCIONADO
        if(empty($mensajepublicacion) && empty($fotopublicacion)){
            header("location:../Feed/inicio");
        }else{
            $consulta=$Publicaciones->RegistrarNuevasPublicaciones($conectarsistema,$mensajepublicacion,$fotopublicacion,$IdUsuarios, $fondo_gradiente, $sentimiento);
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
          // CONSULTAR NOTIFICACIONES REACCIONES -> TODOS LOS USUARIOS
          $consulta4=$Publicaciones->ConsultarNotificacionesReaccionesCompleta($conectarsistema2, $IdUsuarios);
          // CONSULTAR NOTIFICACIONES MENSAJES -> TODOS LOS USUARIOS
          $consulta5=$Publicaciones->ConsultarNotificacionesMensajesCompleta($conectarsistema3, $IdUsuarios);
         // TODAS LAS CONSULTAS ANIDADAS EN UNA SOLA PAGINA
        require('../vista/listadonotificaciones.php');
        // CIERRE DE CONEXIONES
        $conectarsistema->close(); // CERRANDO CONEXION
        $conectarsistema1->close(); // CERRANDO CONEXION AUXILIAR 1
        $conectarsistema2->close();
        $conectarsistema3->close();
        $conectarsistema14->close(); // CERRANDO CONEXION AUXILIAR 14
        $conectarsistema16->close(); // CERRANDO CONEXION AUXILIAR 16
    break;  
    // OBTENER CANTIDAD DE NOTIFICACIONES PARA POLLING EN TIEMPO REAL
    case "count-notificaciones":
        $IdUsuarios = $_SESSION['id_usuario'];
        $count_amigos = mysqli_num_rows($Publicaciones->ConsultarNotificacionesAmigosCompleta($conectarsistema, $IdUsuarios));
        $count_comentarios = mysqli_num_rows($Publicaciones->ConsultarNotificacionesComentariosCompleta($conectarsistema1, $IdUsuarios));
        $count_reacciones = mysqli_num_rows($Publicaciones->ConsultarNotificacionesReaccionesCompleta($conectarsistema2, $IdUsuarios));
        $count_mensajes = mysqli_num_rows($Publicaciones->ConsultarNotificacionesMensajesCompleta($conectarsistema3, $IdUsuarios));
        echo json_encode([
            "status" => "OK",
            "count" => ($count_amigos + $count_comentarios + $count_reacciones + $count_mensajes)
        ]);
        $conectarsistema->close();
        $conectarsistema1->close();
        $conectarsistema2->close();
        $conectarsistema3->close();
    break;

    // RESPONDER DETALLES DE NOTIFICACIONES EN VIVO
    case "live-notifications":
        $IdUsuarios = $_SESSION['id_usuario'];
        $notifs = [];

        // 1. Amigos
        $resAmigos = $Publicaciones->ConsultarNotificacionesAmigosCompleta($conectarsistema, $IdUsuarios);
        if ($resAmigos) {
            while ($row = mysqli_fetch_assoc($resAmigos)) {
                $notifs[] = [
                    'id_notif' => 'amigo_' . $row['idnotificacionamigos'],
                    'tipo' => 'amigo',
                    'actor_id' => $row['idamigo'],
                    'nombres' => $row['nombres'],
                    'apellidos' => $row['apellidos'],
                    'fotoperfil' => $row['fotoperfil'],
                    'usuario' => $row['usuario'],
                    'mensaje' => '¡Ahora eres amigo de ' . $row['nombres'] . ' ' . $row['apellidos'] . '!',
                    'fecha' => $row['fecha_notificacion'],
                    'extra' => $row['usuario']
                ];
            }
        }

        // 2. Comentarios
        $resComentarios = $Publicaciones->ConsultarNotificacionesComentariosCompleta($conectarsistema1, $IdUsuarios);
        if ($resComentarios) {
            while ($row = mysqli_fetch_assoc($resComentarios)) {
                if ($row['usuario'] != $_SESSION['usuario_unico']) {
                    $notifs[] = [
                        'id_notif' => 'comentario_' . $row['idnotificacioncomentarios'],
                        'tipo' => 'comentario',
                        'actor_id' => $row['id'],
                        'nombres' => $row['nombres'],
                        'apellidos' => $row['apellidos'],
                        'fotoperfil' => $row['fotoperfil'],
                        'usuario' => $row['usuario'],
                        'mensaje' => $row['nombres'] . ' ' . $row['apellidos'] . ' comentó tu publicación.',
                        'fecha' => $row['fecha_notificacion'],
                        'extra' => $row['idpublicacion']
                    ];
                }
            }
        }

        // 3. Reacciones
        $resReacciones = $Publicaciones->ConsultarNotificacionesReaccionesCompleta($conectarsistema2, $IdUsuarios);
        if ($resReacciones) {
            while ($row = mysqli_fetch_assoc($resReacciones)) {
                if ($row['usuario'] != $_SESSION['usuario_unico']) {
                    $notifs[] = [
                        'id_notif' => 'reaccion_' . $row['idnotificacionreacciones'],
                        'tipo' => 'reaccion',
                        'actor_id' => $row['id_reaccionador'],
                        'nombres' => $row['nombres'],
                        'apellidos' => $row['apellidos'],
                        'fotoperfil' => $row['fotoperfil'],
                        'usuario' => $row['usuario'],
                        'mensaje' => $row['nombres'] . ' ' . $row['apellidos'] . ' reaccionó a tu publicación.',
                        'fecha' => $row['fecha_notificacion'],
                        'extra' => $row['idpublicacion']
                    ];
                }
            }
        }

        // 4. Mensajes
        $resMensajes = $Publicaciones->ConsultarNotificacionesMensajesCompleta($conectarsistema3, $IdUsuarios);
        if ($resMensajes) {
            while ($row = mysqli_fetch_assoc($resMensajes)) {
                $notifs[] = [
                    'id_notif' => 'mensaje_' . $row['idnotificacionmensajes'],
                    'tipo' => 'mensaje',
                    'actor_id' => $row['id_remitente'],
                    'nombres' => $row['nombres'],
                    'apellidos' => $row['apellidos'],
                    'fotoperfil' => $row['fotoperfil'],
                    'usuario' => $row['usuario'],
                    'mensaje' => 'Te envió un mensaje: ' . $row['mensaje'],
                    'fecha' => $row['fecha_notificacion'],
                    'extra' => $row['id_mensaje']
                ];
            }
        }

        // 5. Solicitudes de amistad recibidas (pendientes)
        $resSolicitudes = mysqli_query($conectarsistema, "SELECT idsolicitudamistad, fecha_creacion, id AS sender_id, nombres, apellidos, fotoperfil, usuario FROM vista_solicitudesamistad WHERE idsolicitudamigo = '$IdUsuarios' AND estado = 0");
        if ($resSolicitudes) {
            while ($row = mysqli_fetch_assoc($resSolicitudes)) {
                $notifs[] = [
                    'id_notif' => 'solicitud_' . $row['idsolicitudamistad'],
                    'tipo' => 'solicitud_amistad',
                    'actor_id' => $row['sender_id'],
                    'nombres' => $row['nombres'],
                    'apellidos' => $row['apellidos'],
                    'fotoperfil' => $row['fotoperfil'],
                    'usuario' => $row['usuario'],
                    'mensaje' => $row['nombres'] . ' ' . $row['apellidos'] . ' te ha enviado una solicitud de amistad.',
                    'fecha' => $row['fecha_creacion'],
                    'extra' => $row['usuario']
                ];
            }
        }

        // 6. Reacciones a Historias (Likes en historias)
        $storyReactionsQuery = "SELECT hm.id_megusta, hm.fecha_megusta, hm.id_usuario AS actor_id, u.nombres, u.apellidos, u.fotoperfil, u.usuario, hm.id_historia
                                FROM historia_megusta hm
                                JOIN historias h ON hm.id_historia = h.id
                                JOIN usuarios u ON hm.id_usuario = u.id
                                WHERE h.id_usuario = '$IdUsuarios' AND hm.id_usuario <> '$IdUsuarios'";
        $resStoryReactions = mysqli_query($conectarsistema, $storyReactionsQuery);
        if ($resStoryReactions) {
            while ($row = mysqli_fetch_assoc($resStoryReactions)) {
                $notifs[] = [
                    'id_notif' => 'story_like_' . $row['id_megusta'],
                    'tipo' => 'reaccion_historia',
                    'actor_id' => $row['actor_id'],
                    'nombres' => $row['nombres'],
                    'apellidos' => $row['apellidos'],
                    'fotoperfil' => $row['fotoperfil'],
                    'usuario' => $row['usuario'],
                    'mensaje' => $row['nombres'] . ' ' . $row['apellidos'] . ' reaccionó a tu historia.',
                    'fecha' => $row['fecha_megusta'],
                    'extra' => $row['id_historia']
                ];
            }
        }

        // Ordenar desc por fecha
        usort($notifs, function($a, $b) {
            return strcmp($b['fecha'], $a['fecha']);
        });

        echo json_encode(['status' => 'OK', 'notifications' => $notifs]);
        $conectarsistema->close();
        $conectarsistema1->close();
        $conectarsistema2->close();
        $conectarsistema3->close();
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
    // ELIMINAR DEFINITIVAMENTE NOTIFICACIONES DE REACCIONES EN PUBLICACIONES
    case "eliminar-notificaciones-reacciones":
        $IdSolicitudes=$_GET['idnotificacion'];
        if(empty($IdSolicitudes)){
            header("location:../Feed/inicio");
        }else{
            $consulta=$Publicaciones->EliminarNotificacionReaccionesRegistradas($conectarsistema,$IdSolicitudes);
            echo json_encode($consulta);
        }
        $conectarsistema->close();
    break;
    // ELIMINAR DEFINITIVAMENTE NOTIFICACIONES DE MENSAJES RECIBIDOS
    case "eliminar-notificaciones-mensajes":
        $IdSolicitudes=$_GET['idnotificacion'];
        if(empty($IdSolicitudes)){
            header("location:../Feed/inicio");
        }else{
            $consulta=$Publicaciones->EliminarNotificacionMensajesRecibidos($conectarsistema,$IdSolicitudes);
            echo json_encode($consulta);
        }
        $conectarsistema->close();
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
        $TipoReaccion = isset($_POST['tipo_reaccion']) ? intval($_POST['tipo_reaccion']) : 1;
        // EVITAR INGRESO VACIO O MAL INTENCIONADO
        if(empty($IdPublicaciones)){
            header("location:../Feed/inicio");
       }else{
            // REGISTRO DE NUEVAS REACCIONES 
            $consulta=$Publicaciones->RegistrarNuevasReacciones($conectarsistema,$IdUsuarios,$IdPublicaciones, $TipoReaccion);
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
        
        // Paginación
        $pagina = isset($_GET['pagina']) ? intval($_GET['pagina']) : 1;
        if ($pagina < 1) $pagina = 1;
        $limite = 30;
        
        $totalVideos = $Publicaciones->ContarTotalVideosMusicales($conectarsistema);
        $totalPaginas = ceil($totalVideos / $limite);
        if ($totalPaginas < 1) $totalPaginas = 1;
        if ($pagina > $totalPaginas) $pagina = $totalPaginas;
        $offset = ($pagina - 1) * $limite;

        // CONSULTAR VIDEOS MUSICALES SUBIDOS paginados
        $consulta2=$Publicaciones->ConsultarVideosMusicales($conectarsistema, $limite, $offset);
        
        // TODAS LAS CONSULTAS ANIDADAS EN UNA SOLA PAGINA
        require('../vista/multimedia-videos.php');
        $conectarsistema->close(); // CERRANDO CONEXION
        $conectarsistema14->close(); // CERRANDO CONEXION AUXILIAR 14
        $conectarsistema16->close(); // CERRANDO CONEXION AUXILIAR 16
    break;  
    // REGISTRO DE NUEVOS VIDEOS MUSICALES -> TODOS LOS USUARIOS -> TODA LA PLATAFORMA
    case "registro-secretvideos":
        $IdUsuarios=$_SESSION['id_usuario']; // ID UNICO DE USUARIO REGISTRADO
        $TituloVideo=isset($_POST['titulo_video']) ? trim($_POST['titulo_video']) : '';
        $Video = isset($_POST['video_url']) ? trim($_POST['video_url']) : '';
        $tipo_fuente = isset($_POST['tipo_fuente']) ? trim($_POST['tipo_fuente']) : '';
        
        if(empty($TituloVideo) || empty($Video) || empty($tipo_fuente)){
            echo json_encode("ERROR_EMPTY_FIELDS");
            $conectarsistema->close();
            exit();
        }

        // Validación estricta del lado del servidor
        $valid = false;
        if ($tipo_fuente === 'youtube' && (stripos($Video, 'youtube.com') !== false || stripos($Video, 'youtu.be') !== false)) {
            $valid = true;
        } elseif ($tipo_fuente === 'spotify' && stripos($Video, 'spotify.com') !== false) {
            $valid = true;
        } elseif ($tipo_fuente === 'itunes' && (stripos($Video, 'apple.com') !== false || stripos($Video, 'itunes.apple.com') !== false || stripos($Video, 'audio-ssl.itunes.apple.com') !== false)) {
            $valid = true;
        }

        if (!$valid) {
            echo json_encode("ERROR_INVALID_URL");
            $conectarsistema->close();
            exit();
        }

        $VideoEsc = mysqli_real_escape_string($conectarsistema, $Video);
        $TituloVideoEsc = mysqli_real_escape_string($conectarsistema, $TituloVideo);
        $consulta=$Publicaciones->RegistrarVideosMusicales($conectarsistema,$TituloVideoEsc,$VideoEsc,$IdUsuarios);
        echo json_encode($consulta);
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
    case "listar-reels":
        header('Content-Type: application/json; charset=utf-8');
        $current_user_id = $_SESSION['id_usuario'];
        $res = $Publicaciones->ConsultarReels($conectarsistema, $current_user_id);
        $reels = [];
        if ($res) {
            while ($row = mysqli_fetch_assoc($res)) {
                $reels[] = $row;
            }
        }
        echo json_encode($reels);
        $conectarsistema->close();
        exit();
    break;
    case "reaccion-reel":
        header('Content-Type: application/json; charset=utf-8');
        $reel_id = isset($_POST['id_video']) ? intval($_POST['id_video']) : 0;
        $current_user_id = $_SESSION['id_usuario'];
        if ($reel_id > 0) {
            $res = $Publicaciones->ReaccionarReel($conectarsistema, $reel_id, $current_user_id);
            echo json_encode($res);
        } else {
            echo json_encode(['status' => 'ERROR', 'error' => 'ID_INVALIDO']);
        }
        $conectarsistema->close();
        exit();
    break;
    case "registro-reel":
        header('Content-Type: application/json; charset=utf-8');
        $titulo = isset($_POST['titulo']) ? trim($_POST['titulo']) : '';
        $usuario_id = $_SESSION['id_usuario'];
        
        if (empty($titulo) || !isset($_FILES['video_file'])) {
            echo json_encode(['status' => 'ERROR', 'error' => 'CAMPOS_VACIOS']);
            $conectarsistema->close();
            exit();
        }
        
        if ($_FILES['video_file']['error'] !== UPLOAD_ERR_OK) {
            echo json_encode(['status' => 'ERROR', 'error' => 'ERROR_UPLOAD']);
            $conectarsistema->close();
            exit();
        }
        
        $nombre_original = $_FILES['video_file']['name'];
        $ext = strtolower(pathinfo($nombre_original, PATHINFO_EXTENSION));
        if (!in_array($ext, ['mp4', 'webm'])) {
            echo json_encode(['status' => 'ERROR', 'error' => 'FORMATO_INVALIDO']);
            $conectarsistema->close();
            exit();
        }
        
        $target_dir = '../vista/multimedia/reels/';
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true);
        }
        
        $nombre_unico = uniqid('reel_', true) . '_' . rand(1000, 9999) . '.' . $ext;
        $target_file = $target_dir . $nombre_unico;
        
        if (move_uploaded_file($_FILES['video_file']['tmp_name'], $target_file)) {
            $titulo_esc = mysqli_real_escape_string($conectarsistema, $titulo);
            $video_esc = mysqli_real_escape_string($conectarsistema, $nombre_unico);
            $res = mysqli_query($conectarsistema, "INSERT INTO reels (usuario_id, video, titulo_video) VALUES ($usuario_id, '$video_esc', '$titulo_esc')");
            if ($res) {
                echo json_encode(['status' => 'OK']);
            } else {
                echo json_encode(['status' => 'ERROR', 'error' => 'DB_ERROR']);
            }
        } else {
            echo json_encode(['status' => 'ERROR', 'error' => 'ERROR_UPLOAD']);
        }
        $conectarsistema->close();
        exit();
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