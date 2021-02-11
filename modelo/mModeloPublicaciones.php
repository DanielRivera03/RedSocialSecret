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
class PublicacionesUsuarios{
    // VARIABLES DE GESTION
        // -> CONSULTA USUARIOS
        private $IdUsuario;
        private $NombreUsuario;
        private $ApellidoUsuario;
        private $UsuarioUnico;
        private $CorreoUsuario;
        private $PaisUsuario;
        private $CiudadUsuario;
        private $TelefonoUsuario;
        private $GeneroUsuario;
        private $FechaNacimientoUsuario;
        private $PrivacidadUsuario;
        private $FotoPerfilUsuario;
        private $FotoPortadaUsuario;
        // -> CONSULTA DETALLES USUARIOS
        private $ReligionUsuario;
        private $EmpleoUsuario;
        private $EscuelaUsuario;
        private $UniversidadUsuario;
        private $DeportesUsuario;
        private $InteresesUsuario;
        private $GenerosMusicalesUsuario;
        private $SituacionSentimentalUsuario;
        private $ComprobacionPerfil;
        private $SobreMiUsuario;
        // -> CONSULTA PUBLICACIONES
        private $FotosSubidasUsuario;
        // FUNCIONES PARA OBTENER DATOS DE USUARIOS
        // ID UNICO
        public function setIdUsuario($valor_retorno){
            $this->IdUsuario=$valor_retorno;
        }
        public function getIdUsuario(){
            return $this->IdUsuario;
        }
        // NOMBRES DE USUARIOS
        public function setNombreUsuario($valor_retorno){
            $this->NombreUsuario=$valor_retorno;
        }
        public function getNombreUsuario(){
            return $this->NombreUsuario;
        }
        // APELLIDOS DE USUARIOS
        public function setApellidoUsuario($valor_retorno){
            $this->ApellidoUsuario=$valor_retorno;
        }
        public function getApellidoUsuario(){
            return $this->ApellidoUsuario;
        }
        // USUARIO UNICO
        public function setUsuarioUnico($valor_retorno){
            $this->UsuarioUnico=$valor_retorno;
        }
        public function getUsuarioUnico(){
            return $this->UsuarioUnico;
        }
        // CORREO DE USUARIOS
        public function setCorreoUsuario($valor_retorno){
            $this->CorreoUsuario=$valor_retorno;
        }
        public function getCorreoUsuario(){
            return $this->CorreoUsuario;
        }
        // PAIS DE RESIDENCIA USUARIOS
        public function setPaisUsuario($valor_retorno){
            $this->PaisUsuario=$valor_retorno;
        }
        public function getPaisUsuario(){
            return $this->PaisUsuario;
        }
        // CIUDAD DE RESIDENCIA USUARIOS
        public function setCiudadUsuario($valor_retorno){
            $this->CiudadUsuario=$valor_retorno;
        }
        public function getCiudadUsuario(){
            return $this->CiudadUsuario;
        }
        // TELEFONO DE USUARIOS
        public function setTelefonoUsuario($valor_retorno){
            $this->TelefonoUsuario=$valor_retorno;
        }
        public function getTelefonoUsuario(){
            return $this->TelefonoUsuario;
        }
        // GENERO DE USUARIOS
        public function setGeneroUsuario($valor_retorno){
            $this->GeneroUsuario=$valor_retorno;
        }
        public function getGeneroUsuario(){
            return $this->GeneroUsuario;
        }
        // FECHA DE NACIMIENTO DE USUARIOS
        public function setFechaNacimientoUsuario($valor_retorno){
            $this->FechaNacimientoUsuario=$valor_retorno;
        }
        public function getFechaNacimientoUsuario(){
            return $this->FechaNacimientoUsuario;
        }
        // PRIVACIDAD DE USUARIOS
        public function setPrivacidadUsuario($valor_retorno){
            $this->PrivacidadUsuario=$valor_retorno;
        }
        public function getPrivacidadUsuario(){
            return $this->PrivacidadUsuario;
        }
        // FOTO DE PERFIL DE USUARIOS
        public function setFotoPerfilUsuario($valor_retorno){
            $this->FotoPerfilUsuario=$valor_retorno;
        }
        public function getFotoPerfilUsuario(){
            return $this->FotoPerfilUsuario;
        }
        // FOTO DE PORTADA DE USUARIOS
        public function setFotoPortadaUsuario($valor_retorno){
            $this->FotoPortadaUsuario=$valor_retorno;
        }
        public function getFotoPortadaUsuario(){
            return $this->FotoPortadaUsuario;
        }
        // RELIGION DE USUARIOS
        public function setReligionUsuario($valor_retorno){
            $this->ReligionUsuario=$valor_retorno;
        }
        public function getReligionUsuario(){
            return $this->ReligionUsuario;
        }
        // EMPLEO DE USUARIOS
        public function setEmpleoUsuario($valor_retorno){
            $this->EmpleoUsuario=$valor_retorno;
        }
        public function getEmpleoUsuario(){
            return $this->EmpleoUsuario;
        }
        // ESCUELA DE USUARIOS
        public function setEscuelaUsuario($valor_retorno){
            $this->EscuelaUsuario=$valor_retorno;
        }
        public function getEscuelaUsuario(){
            return $this->EscuelaUsuario;
        }
        // UNIVERSIDAD DE USUARIOS
        public function setUniversidadUsuario($valor_retorno){
            $this->UniversidadUsuario=$valor_retorno;
        }
        public function getUniversidadUsuario(){
            return $this->UniversidadUsuario;
        }
        // DEPORTES DE USUARIOS
        public function setDeportesUsuario($valor_retorno){
            $this->DeportesUsuario=$valor_retorno;
        }
        public function getDeportesUsuario(){
            return $this->DeportesUsuario;
        }
        // INTERESES DE USUARIOS
        public function setInteresesUsuario($valor_retorno){
            $this->InteresesUsuario=$valor_retorno;
        }
        public function getInteresesUsuario(){
            return $this->InteresesUsuario;
        }
        // GENEROS MUSICALES DE USUARIOS
        public function setGenerosMusicalesUsuario($valor_retorno){
            $this->GenerosMusicalesUsuario=$valor_retorno;
        }
        public function getGenerosMusicalesUsuario(){
            return $this->GenerosMusicalesUsuario;
        }
        // SITUACION SENTIMENTAL DE USUARIOS
        public function setSituacionSentimentalUsuario($valor_retorno){
            $this->SituacionSentimentalUsuario=$valor_retorno;
        }
        public function getSituacionSentimentalUsuario(){
            return $this->SituacionSentimentalUsuario;
        }
        // COMPROBACION ESTADO DETALLES PERFIL DE USUARIOS
        public function setComprobacionPerfil($valor_retorno){
            $this->ComprobacionPerfil=$valor_retorno;
        }
        public function getComprobacionPerfil(){
            return $this->ComprobacionPerfil;
        }
        // SOBRE MI DE USUARIOS
        public function setSobreMiUsuario($valor_retorno){
            $this->SobreMiUsuario=$valor_retorno;
        }
        public function getSobreMiUsuario(){
            return $this->SobreMiUsuario;
        }
        // FOTOS SUBIDAS DE USUARIOS
        public function setFotosSubidasUsuario($valor_retorno){
            $this->FotosSubidasUsuario=$valor_retorno;
        }
        public function getFotosSubidasUsuario(){
            return $this->FotosSubidasUsuario;
        }
        // CONSULTA Y EDICION DE PERFILES DE USUARIOS {PERFILES PROPIETARIOS}
        public function ConsultarDetallesPerfilUsuario($conectarsistema1,$IdNombreUsuarios){
            $resultado=mysqli_query($conectarsistema1,"CALL ConsultarDetallesPerfilUsuarios('".$IdNombreUsuarios."');");
            $Publicaciones=mysqli_fetch_array($resultado); // RECORRIDO EN BUSCA DE REGISTRO CONSULTADO
            /*
                -> IMPORTANTE: UNICAMENTE LOS DATOS SE EXTRAERAN SI EXISTEN REGISTROS EN LA CONSULTA
                REALIZADA POR LA PLATAFORMA... SI NO EXISTEN SIMPLEMENTE NO MUESTRA NADA AL USUARIO
                HASTA QUE EL COMPLETE LA SECCION EN CUESTION
            */
            if(mysqli_num_rows($resultado)>0){
                 // OBTENER VALORES EXTRAIDOS EN LA CONSULTA
                // -> CONSULTA USUARIOS
                $this->setIdUsuario($Publicaciones['id']);
                $this->setNombreUsuario($Publicaciones['nombres']);
                $this->setApellidoUsuario($Publicaciones['apellidos']);
                $this->setUsuarioUnico($Publicaciones['usuario']);
                $this->setCorreoUsuario($Publicaciones['correo']);
                $this->setPaisUsuario($Publicaciones['pais']);
                $this->setCiudadUsuario($Publicaciones['ciudad']);
                $this->setTelefonoUsuario($Publicaciones['telefono']);
                $this->setGeneroUsuario($Publicaciones['genero']);
                $this->setFechaNacimientoUsuario($Publicaciones['fechanacimiento']);
                $this->setPrivacidadUsuario($Publicaciones['privacidad']);
                $this->setFotoPerfilUsuario($Publicaciones['fotoperfil']);
                // -> CONSULTA DETALLES USUARIOS
                $this->setReligionUsuario($Publicaciones['religion']);
                $this->setEmpleoUsuario($Publicaciones['empleo']);
                $this->setEscuelaUsuario($Publicaciones['escuela']);
                $this->setUniversidadUsuario($Publicaciones['universidad']);
                $this->setDeportesUsuario($Publicaciones['deportes']);
                $this->setInteresesUsuario($Publicaciones['intereses']);
                $this->setGenerosMusicalesUsuario($Publicaciones['generosmusicales']);
                $this->setSituacionSentimentalUsuario($Publicaciones['situacionsentimental']);
                $this->setSobreMiUsuario($Publicaciones['sobremi']);
            }// CIERRE if(mysqli_num_rows($resultado)>0){
    }
    public function ConsultarDetallesPerfilUsuarioGeneral($conectarsistema11,$IdUsuarios){
        $resultado2=mysqli_query($conectarsistema11,"CALL ConsultarDetallesPerfilUsuarios('".$IdUsuarios."');");
        $Publicaciones=mysqli_fetch_array($resultado2); // RECORRIDO EN BUSCA DE REGISTRO CONSULTADO
            /*
                -> IMPORTANTE: UNICAMENTE LOS DATOS SE EXTRAERAN SI EXISTEN REGISTROS EN LA CONSULTA
                REALIZADA POR LA PLATAFORMA... SI NO EXISTEN SIMPLEMENTE NO MUESTRA NADA AL USUARIO
                HASTA QUE EL COMPLETE LA SECCION EN CUESTION
            */
            if(mysqli_num_rows($resultado2)>0){
                 // OBTENER VALORES EXTRAIDOS EN LA CONSULTA
                // -> CONSULTA USUARIOS
                $this->setIdUsuario($Publicaciones['id']);
                $this->setNombreUsuario($Publicaciones['nombres']);
                $this->setApellidoUsuario($Publicaciones['apellidos']);
                $this->setUsuarioUnico($Publicaciones['usuario']);
                $this->setCorreoUsuario($Publicaciones['correo']);
                $this->setPaisUsuario($Publicaciones['pais']);
                $this->setCiudadUsuario($Publicaciones['ciudad']);
                $this->setTelefonoUsuario($Publicaciones['telefono']);
                $this->setGeneroUsuario($Publicaciones['genero']);
                $this->setFechaNacimientoUsuario($Publicaciones['fechanacimiento']);
                $this->setPrivacidadUsuario($Publicaciones['privacidad']);
                $this->setFotoPerfilUsuario($Publicaciones['fotoperfil']);
                $this->setFotoPortadaUsuario($Publicaciones['foto_portada']);
                // -> CONSULTA DETALLES USUARIOS
                $this->setReligionUsuario($Publicaciones['religion']);
                $this->setEmpleoUsuario($Publicaciones['empleo']);
                $this->setEscuelaUsuario($Publicaciones['escuela']);
                $this->setUniversidadUsuario($Publicaciones['universidad']);
                $this->setDeportesUsuario($Publicaciones['deportes']);
                $this->setInteresesUsuario($Publicaciones['intereses']);
                $this->setGenerosMusicalesUsuario($Publicaciones['generosmusicales']);
                $this->setSituacionSentimentalUsuario($Publicaciones['situacionsentimental']);
                $this->setSobreMiUsuario($Publicaciones['sobremi']);
            }// CIERRE if(mysqli_num_rows($resultado)>0){
    }
    // INSERTAR NUEVAS PUBLICACIONES {TODOS} LOS USUARIOS DE ESTA PLATAFORMA
    public function RegistrarNuevasPublicaciones($conectarsistema,$mensajepublicacion,$fotopublicacion,$IdUsuarios){
        // LLAMADO DE RUTINA CON PASE DE PARAMETROS
        $resultado=mysqli_query($conectarsistema,"CALL RegistrarPublicacionesNuevas('".$mensajepublicacion."','".$fotopublicacion."','".$IdUsuarios."');");
        if($resultado){
            return "OK";
        }else{
            return "Error: Lo sentimos ha ocurrido un error inesperado. Intenta más tarde...";
        }
    }
    // CONSULTAR PUBLICACIONES EN PERFIL DE USUARIOS ESPECIFICA {PERFIL PROPIETARIO}
    public function ConsultarPerfilUsuarios($conectarsistema,$IdUsuarios){
        $resultado=mysqli_query($conectarsistema,"CALL ConsultarPerfilUsuariosPublicaciones('".$IdUsuarios."');");
        return $resultado;
    }
    // CONSULTAR PUBLICACIONES EN PERFIL DE USUARIOS ESPECIFICA {TODOS LOS PERFILES REGISTRADOS}
    public function ConsultarPerfilUsuariosGeneral($conectarsistema,$IdUsuarios){
        $resultado=mysqli_query($conectarsistema,"CALL ConsultarPerfilesGeneralPublicaciones('".$IdUsuarios."');");
        return $resultado;
    }
    // CONSULTAR FOTOGRAFIAS SUBIDAS PERFILES USUARIOS PROPIETARIOS {MINIATURAS}
     public function ConsultarFotosSubidasPerfilUsuario($conectarsistema3,$IdNombreUsuarios){
        $resultado1=mysqli_query($conectarsistema3,"CALL ConsultarFotosSubidasPerfilPropietario('".$IdNombreUsuarios."');");
        return $resultado1;
    }
     // CONSULTAR FOTOGRAFIAS SUBIDAS PERFILES USUARIOS PROPIETARIOS {MINIATURAS -> TODOS LOS PERFILES}
     public function ConsultarFotosSubidasPerfilUsuarioGeneral($conectarsistema3,$IdUsuarios){
        $resultado1=mysqli_query($conectarsistema3,"CALL ConsultarFotosSubidasPerfilPropietario('".$IdUsuarios."');");
        return $resultado1;
    }
    // CONSULTAR FOTOGRAFIAS SUBIDAS PERFILES USUARIOS PROPIETARIOS {COMPLETA -> MULTIMEDIA}
    public function ConsultarFotosSubidasCompletaPerfilUsuario($conectarsistema4,$IdNombreUsuarios){
        $resultado1=mysqli_query($conectarsistema4,"CALL ConsultarVistaCompletaFotosSubidasPerfilesPropietarios('".$IdNombreUsuarios."');");
        return $resultado1;
    }
    // CONSULTAR FOTOGRAFIAS SUBIDAS TODOS LOS PERFILES  {COMPLETA -> MULTIMEDIA}
    public function ConsultarFotosSubidasCompletaPerfilUsuarioGeneral($conectarsistema4,$IdUsuarios){
        $resultado1=mysqli_query($conectarsistema4,"CALL ConsultarVistaCompletaFotosSubidasPerfilesPropietarios('".$IdUsuarios."');");
        return $resultado1;
    }
    // FUNCION PARA ELIMINAR DEFINITIVAMENTE PUBLICACIONES DE HISTORIAS
    public function EliminarHistoriasPublicadas($conectarsistema,$IdPublicaciones){
        $resultado=mysqli_query($conectarsistema,"CALL BorrarHistoriasPublicadasPerfilUsuarios('".$IdPublicaciones."');");
        if($resultado){
            return "OK";
        }else{
            return "Error: Lo sentimos ha ocurrido un error inesperado. Intenta más tarde...";
        }
        return $resultado;
    }
     // CONSULTAR COMENTARIOS REGISTRADOS PERFILES USUARIOS PROPIETARIOS {TODOS LOS USUARIOS}
     public function ConsultarComentariosPerfilPropietario($conectarsistema5,$IdPublicaciones){
        $resultado1=mysqli_query($conectarsistema5,"CALL ConsultarComentariosPerfilPropietario('".$IdPublicaciones."');");
        // SOLO DEVOLVER RESULTADO SI EN CONSULTA SE ENCUENTRAN REGISTROS QUE COINCIDAN
        // CON LOS DIFERENTES ID UNICOS DE PUBLICACIONES REGISTRADOS POR USUARIOS
        if(mysqli_num_rows($resultado1)>0){
            return $resultado1;
        }
    }
    // REGISTRAR COMENTARIOS PUBLICACIONES {TODA LA PLATAFORMA -> TODOS LOS USUARIOS -> TODOS LOS PERFILES}
    public function RegistrarNuevosComentarios($conectarsistema,$Comentario,$IdUsuarios,$IdPublicaciones){
        // LLAMADO DE RUTINA CON PASE DE PARAMETROS
        $resultado=mysqli_query($conectarsistema,"CALL RegistrarComentariosPublicacionesPerfiles('".$Comentario."','".$IdUsuarios."','".$IdPublicaciones."');");
        if($resultado){
            return "OK";
        }else{
            return "Error: Lo sentimos ha ocurrido un error inesperado. Intenta más tarde...";
        }
    }
    // FUNCION PARA ELIMINAR DEFINITIVAMENTE COMENTARIOS DE PUBLICACIONES HISTORIAS
    public function EliminarComentariosHistoriasPublicadas($conectarsistema,$IdComentariosPublicaciones){
        $resultado=mysqli_query($conectarsistema,"CALL EliminarComentariosRegistrados('".$IdComentariosPublicaciones."');");
        if($resultado){
            return "OK";
        }else{
            return "Error: Lo sentimos ha ocurrido un error inesperado. Intenta más tarde...";
        }
        return $resultado;
    }
    // CONSULTAR AMIGOS CONFIRMADOS PERFILES PROPIETARIOS {MINIATURAS}
    public function ConsultarAmigosPerfilesPropietarios($conectarsistema6,$IdUsuarios){
        $resultado=mysqli_query($conectarsistema6,"CALL ConsultarAmigosMiniaturaPerfilesPropietarios('".$IdUsuarios."');");
        return $resultado;
    }
    // CONSULTAR AMIGOS CONFIRMADOS TODOS LOS PERFILES {MINIATURAS}
    public function ConsultarAmigosPerfilesGeneral($conectarsistema6,$IdUsuarios){
        $resultado=mysqli_query($conectarsistema6,"CALL ConsultarAmigosMiniaturaPerfilesGeneral('".$IdUsuarios."');");
        return $resultado;
    }
    // CONSULTAR AMIGOS CONFIRMADOS PERFILES PROPIETARIOS {MENU SECUNDARIO PRINCIPAL}
    public function ConsultarAmigosPerfilesPropietariosPrincipal($conectarsistema9,$IdUsuarios){
        $resultado=mysqli_query($conectarsistema9,"CALL ConsultarAmigosPerfilesPropietarios('".$IdUsuarios."');");
        return $resultado;
    }
    // CONSULTAR AMIGOS CONFIRMADOS TODOS LOS PERFILES {MENU SECUNDARIO PRINCIPAL}
    public function ConsultarAmigosPerfilesGeneralPrincipal($conectarsistema9,$IdUsuarios){
        $resultado=mysqli_query($conectarsistema9,"CALL ConsultarAmigosPerfilesGenerales('".$IdUsuarios."');");
        return $resultado;
    }
    // FUNCION PARA ELIMINAR DEFINITIVAMENTE AMIGOS PREVIAMENTE ACEPTADOS
    public function EliminarAmigos($conectarsistema,$IdUsuarios){
        $resultado=mysqli_query($conectarsistema,"CALL EliminarAmigosConfirmados('".$IdUsuarios."');");
        if($resultado){
            return "OK";
        }else{
            return "Error: Lo sentimos ha ocurrido un error inesperado. Intenta más tarde...";
        }
        return $resultado;
    }
    // CONSULTAR NOMBRES Y APELLIDOS COMENTARIOS REGISTRADOS POR TODOS LOS USUARIOS
    // TODAS LAS PUBLICACIONES DE LA PLATAFORMA
    public function ConsultarNombresUsuariosComentarios($conectarsistema13,$IdPublicaciones){
        $resultado=mysqli_query($conectarsistema13,"CALL ConsultarNombresComentarios('".$IdPublicaciones."');");
        return $resultado;
    }
    // CONSULTAR SOLICITUDES NUEVAS DE AMISTAD {VISTA LIMITADA}
    public function ConsultarSolicitudesAmistad($conectarsistema14,$IdSolicitudAmigo){
        $resultado=mysqli_query($conectarsistema14,"CALL ConsultaSolicitudesAmistad('".$IdSolicitudAmigo."');");
        return $resultado;
    }
    // CONSULTAR NOTIFICACIONES AMIGOS -> SOLICITUDES ACEPTADAS {VISTA LIMITADA}
    public function ConsultarNotificacionesAmigos($conectarsistema16,$IdUsuarios){
        $resultado=mysqli_query($conectarsistema16,"CALL ConsultarNotificacionesAmigos('".$IdUsuarios."');");
        return $resultado;
    }
     // CONSULTAR NOTIFICACIONES AMIGOS -> SOLICITUDES ACEPTADAS {VISTA COMPLETA}
     public function ConsultarNotificacionesAmigosCompleta($conectarsistema18,$IdUsuarios){
        $resultado=mysqli_query($conectarsistema18,"CALL ConsultaNotificacionesAmigosCompleta('".$IdUsuarios."');");
        return $resultado;
    }
     // CONSULTAR NOTIFICACIONES COMENTARIOS -> COMENTARIOS NUEVOS REGISTRADOS {VISTA COMPLETA}
     public function ConsultarNotificacionesComentariosCompleta($conectarsistema19,$IdUsuarios){
        $resultado=mysqli_query($conectarsistema19,"CALL ConsultaNotificacionesComentariosCompleta('".$IdUsuarios."');");
        return $resultado;
    }
    // FUNCION PARA ELIMINAR DEFINITIVAMENTE NOTIFICACIONES DE SOLICITUDES DE AMISTAD ACEPTADAS
    public function EliminarNotificacionSolicitudesAceptadas($conectarsistema,$IdSolicitudes){
        $resultado=mysqli_query($conectarsistema,"CALL EliminarNotificacionesSolicitudesAceptadas('".$IdSolicitudes."');");
        if($resultado){
            return "OK";
        }else{
            return "Error: Lo sentimos ha ocurrido un error inesperado. Intenta más tarde...";
        }
        return $resultado;
    }
     // FUNCION PARA ELIMINAR DEFINITIVAMENTE NOTIFICACIONES DE COMENTARIOS REGISTRADOS POR LOS DEMAS USUARIOS
     public function EliminarNotificacionComentariosRegistrados($conectarsistema,$IdSolicitudes){
        $resultado=mysqli_query($conectarsistema,"CALL EliminarNotificacionesComentariosRegistrados('".$IdSolicitudes."');");
        if($resultado){
            return "OK";
        }else{
            return "Error: Lo sentimos ha ocurrido un error inesperado. Intenta más tarde...";
        }
        return $resultado;
    }
    // CONSULTAR SOLICITUDES NUEVAS DE AMISTAD {VISTA COMPLETA}
    public function ConsultarSolicitudesAmistadCompleta($conectarsistema20,$IdSolicitudAmigo){
        $resultado=mysqli_query($conectarsistema20,"CALL ConsultaSolicitudesAmistadCompleta('".$IdSolicitudAmigo."');");
        return $resultado;
    }
    // CONSULTAR TODAS LAS PUBLICACIONES REGISTRADAS EN EL INICIO DE ESTA APLICACION
    /*
        -> IMPORTANTE
            EN ESTA SECCION SE MUESTRAN ABSOLUTAMENTE TODAS LAS PUBLICACIONES REGISTRADAS...
            TOMANDO EN CUENTA EL FILTRO SI EL USUARIO LOGUEADO HA ACEPTADO LA SOLICITUD DE 
            AMISTAD DE X USUARIOS -> SOLO LOS USUARIOS QUE COINCIDAN EN ESTA CONSULTA, SE 
            DESPLEGARAN LAS DIFERENTES PUBLICACIONES CON LA COINCIDENCIA MENCIONADA
            ------------------------------------------------------------------------------------
            --> PARA NO SATURAR EL INICIO SOLO SE MUESTRAN  20 PUBLICACIONES <--
            POR CADA NUEVA PUBLICACION SE SUSTITUYEN CON LAS PREVIAMENTE VISTAS
            ------------------------------------------------------------------------------------
    */
    public function ConsultarPublicacionesInicio($conectarsistema,$IdSolicitudAmigo){
        // $IdSolicitudAmigo -> ID UNICO DE REFERENCIA PARA SABER SI EL USUARIO QUE HA INICIADO
        // SESION ES AMIGO O NO DE LAS DIFERENTES PUBLICACIONES REGISTRADAS POR TODOS LOS USUARIOS
        $resultado=mysqli_query($conectarsistema,"CALL ConsultarPublicacionesInicio('".$IdSolicitudAmigo."');");
		return $resultado;
    }
    // REGISTRAR NUEVAS REACCIONES {ME GUSTA} -> TODOS LOS USUARIOS -> TODA LA PLATAFORMA
    public function RegistrarNuevasReacciones($conectarsistema,$IdUsuarios,$IdPublicaciones){
        // LLAMADO DE RUTINA CON PASE DE PARAMETROS
        $resultado=mysqli_query($conectarsistema,"CALL RegistrarNuevasReaccionesPublicaciones('".$IdUsuarios."','".$IdPublicaciones."');");
        if($resultado){
            return "OK";
        }else{
            return "Error: Lo sentimos ha ocurrido un error inesperado. Intenta más tarde...";
        }
    }
    // CONSULTAR TODOS LOS CUMPLEAÑEROS DE ESTE DIA
    public function ConsultarCumpleanerosActuales($conectarsistema24,$IdSolicitudAmigo){
        // $IdSolicitudAmigo -> ID UNICO DE REFERENCIA PARA SABER SI EL USUARIO QUE HA INICIADO
        // SESION ES AMIGO O NO DE LAS DIFERENTES PUBLICACIONES REGISTRADAS POR TODOS LOS USUARIOS
        $resultado=mysqli_query($conectarsistema24,"CALL ConsultarCumpleanosEsteDia('".$IdSolicitudAmigo."');");
		return $resultado;
    }
    // CONSULTAR TODA LA MENSAJERIA RECIBIDA POR LOS USUARIOS
    public function ConsultarMensajeriaRecibida($conectarsistema26){
        $resultado=mysqli_query($conectarsistema26,"CALL ConsultarMensajesRecibidos();");
		return $resultado;
    }
    // REGISTRAR MENSAJES CHAT GENERAL {TODA LA PLATAFORMA -> TODOS LOS USUARIOS}
    public function RegistrarMensajesChatGeneral($conectarsistema,$Mensaje,$IdUsuarios){
        // LLAMADO DE RUTINA CON PASE DE PARAMETROS
        $resultado=mysqli_query($conectarsistema,"CALL RegistrarMensajesChatGeneral('".$Mensaje."','".$IdUsuarios."');");
        if($resultado){
            return "OK";
        }else{
            return "Error: Lo sentimos ha ocurrido un error inesperado. Intenta más tarde...";
        }
    }
    /*
        -> ESTE MANTENIMIENTO ESTA TOTALMENTE OPERATIVO, POR MOTIVOS DE VISUALIZACION
        SE OPTO POR HACER UNA ACTUALIZACION, AL MOMENTO DE "ELIMINAR" UN MENSAJE
        SIMPLEMENTE MUESTRE EN PANTALLA -> [MENSAJE HA SIDO RETIRADO]

        -> SI DECIDES HABILITARLO PUEDES HACERLO BAJO TU DISCRESION <-
    */
    // FUNCION PARA ELIMINAR DEFINITIVAMENTE MENSAJES INDIVIDUALES REGISTRADOS EN CHAT GENERAL
    public function EliminarMensajesIndividualesChatGeneral($conectarsistema,$IdMensajes){
        $resultado=mysqli_query($conectarsistema,"CALL EliminarMensajesIndividualesChatGeneral('".$IdMensajes."');");
        if($resultado){
            return "OK";
        }else{
            return "Error: Lo sentimos ha ocurrido un error inesperado. Intenta más tarde...";
        }
        return $resultado;
    }
    // FUNCION PARA RETIRAR MENSAJES PREVIAMENTE INGRESADOS POR USUARIOS {ACTUALIZACION}
    public function RetirarMensajesIndividualesChatGeneral($conectarsistema,$IdMensajes){
        $resultado=mysqli_query($conectarsistema,"CALL RetirarMensajesChatGeneral('".$IdMensajes."');");
        if($resultado){
            return "OK";
        }else{
            return "Error: Lo sentimos ha ocurrido un error inesperado. Intenta más tarde...";
        }
        return $resultado;
    }
    // CONSULTAR EVENTOS REGISTRADOS -> FILTRADOS POR PAIS DE RESIDENCIA USUARIOS
    // VERSION COMPLETA -> PAGINA DEDICADA EXCLUSIVAMENTE A ELLO
    public function ConsultarEventosRegistrados($conectarsistema25,$Pais){
        $resultado=mysqli_query($conectarsistema25,"CALL ConsultarEventosRegistrados('".$Pais."');");
        return $resultado;
    }
    // CONSULTAR EVENTOS REGISTRADOS -> FILTRADOS POR PAIS DE RESIDENCIA USUARIOS
    // VERSION LIMITADA -> VISUALIZACION EXCLUSIVA EN FEED (INICIO) DE ESTA APLICACION
    public function ConsultarEventosRegistradosMiniatura($conectarsistema29,$Pais){
        $resultado=mysqli_query($conectarsistema29,"CALL ConsultarEventosRegistradosMiniatura('".$Pais."');");
        return $resultado;
    }
     // REGISTRAR VIDEOS MUSICALES -> MULTIMEDIA {TODA LA PLATAFORMA -> TODOS LOS USUARIOS}
     public function RegistrarVideosMusicales($conectarsistema,$TituloVideo,$Video,$IdUsuarios){
        // LLAMADO DE RUTINA CON PASE DE PARAMETROS
        $resultado=mysqli_query($conectarsistema,"CALL RegistroVideosMusicales('".$TituloVideo."','".$Video."','".$IdUsuarios."');");
        if($resultado){
            return "OK";
        }else{
            return "Error: Lo sentimos ha ocurrido un error inesperado. Intenta más tarde...";
        }
    }
    // CONSULTAR VIDEOS MUSICALES SUBIDOS -> TODOS LOS USUARIOS
    // VERSION COMPLETA -> SE LIMITO LA VISTA A 60 ELEMENTOS MAXIMO
    public function ConsultarVideosMusicales($conectarsistema){
        $resultado=mysqli_query($conectarsistema,"CALL ConsultarVideosMusicalesSubidos();");
        return $resultado;
    }
    // FUNCION PARA ELIMINAR DEFINITIVAMENTE VIDEOS MUSICALES SUBIDOS
    // SEGUN FILTRO POR ID DE USUARIO QUE LO PUBLICO -> {IdVideo}
    public function EliminarVideosMusicales($conectarsistema,$IdVideo){
        $resultado=mysqli_query($conectarsistema,"CALL EliminarVideosMusicales('".$IdVideo."');");
        if($resultado){
            return "OK";
        }else{
            return "Error: Lo sentimos ha ocurrido un error inesperado. Intenta más tarde...";
        }
        return $resultado;
    }
}// CIERRE class PublicacionesUsuarios
?>