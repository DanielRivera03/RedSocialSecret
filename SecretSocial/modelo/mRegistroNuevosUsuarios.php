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
    class RegistroUsuariosNuevos{
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
        // CONSULTA Y EDICION DE PERFILES DE USUARIOS
        public function ConsultarPerfilUsuario($conectarsistema,$IdUsuarioPerfil){
            $resultado=mysqli_query($conectarsistema,"CALL ConsultarPeticionEditarPerfil('".$IdUsuarioPerfil."');");
            $Usuarios=mysqli_fetch_array($resultado); // RECORRIDO EN BUSCA DE REGISTRO CONSULTADO
            // OBTENER VALORES EXTRAIDOS EN LA CONSULTA
            // -> CONSULTA USUARIOS
            if(mysqli_num_rows($resultado)>0){
                // MOSTRAR DATOS SOLAMENTE SI EXISTE UNA COINCIDENCIA Y ENCUENTRA REGISTROS
                // CASO CONTRARIO NO SE MUESTRA NADA -> Y SE IMPLEMENTE MENSAJE DE PERFIL INCOMPLETO
                $this->setIdUsuario($Usuarios['id']);
                $this->setNombreUsuario($Usuarios['nombres']);
                $this->setApellidoUsuario($Usuarios['apellidos']);
                $this->setUsuarioUnico($Usuarios['usuario']);
                $this->setCorreoUsuario($Usuarios['correo']);
                $this->setPaisUsuario($Usuarios['pais']);
                $this->setCiudadUsuario($Usuarios['ciudad']);
                $this->setTelefonoUsuario($Usuarios['telefono']);
                $this->setGeneroUsuario($Usuarios['genero']);
                $this->setFechaNacimientoUsuario($Usuarios['fechanacimiento']);
                $this->setPrivacidadUsuario($Usuarios['privacidad']);
                $this->setFotoPerfilUsuario($Usuarios['fotoperfil']);
                // -> CONSULTA DETALLES USUARIOS
                $this->setReligionUsuario($Usuarios['religion']);
                $this->setEmpleoUsuario($Usuarios['empleo']);
                $this->setEscuelaUsuario($Usuarios['escuela']);
                $this->setUniversidadUsuario($Usuarios['universidad']);
                $this->setDeportesUsuario($Usuarios['deportes']);
                $this->setInteresesUsuario($Usuarios['intereses']);
                $this->setGenerosMusicalesUsuario($Usuarios['generosmusicales']);
                $this->setSituacionSentimentalUsuario($Usuarios['situacionsentimental']);
                $this->setComprobacionPerfil($Usuarios['comprobacionperfil']);
                $this->setSobreMiUsuario($Usuarios['sobremi']);
            }
        }
        // FUNCION PARA INSERTAR NUEVOS USUARIOS A BASE DE DATOS
        public function InsertarNuevosUsuarios($conectarsistema,$NombreUsuarios,$ApellidoUsuarios,$CorreoUsuarios,$ClaveUsuarios){
            // LLAMADO DE RUTINA CON PASE DE PARAMETROS
            $resultado=mysqli_query($conectarsistema,"CALL RegistrarUsuariosNuevos('".$NombreUsuarios."','".$ApellidoUsuarios."','".$CorreoUsuarios."','".$ClaveUsuarios."');");
            /*
                INFORMAR AL USUARIO ESTADO DE ACCION
                -> IMPORTANTE: EN ESTA ACCION SE DECIDIO DEJAR QUE PHP DECIDA DONDE ENVIAR AL USUARIO
                MEDIANTE LAS URL'S PREPARADAS ESPECIFICAMENTE PARA TAL ACCION. TODOS LOS DEMAS PROCESOS
                SE MANEJAN CON AJAX. {1}
            */
            if($resultado){
                header('location:../RegistroExitoso/confirmacionregistro');
            }else{
                header('location:../RegistroFallido/error_registro');
            }
            return $resultado;
        }
        // FUNCION PARA COMPLETAR PERFIL DE USUARIOS NUEVOS REGISTRADOS CON FOTO
        public function CompletarPerfilNuevosUsuarios($conectarsistema,$IdUsuarios,$NombreUsuarios,$ApellidoUsuarios,$UsuarioUnico,$CorreoUsuarios,$FotoPerfil,$Pais,$Ciudad,$Telefono,$Genero,$FechaNacimiento,$Privacidad,$EstadoPerfil){
            // LLAMADO DE RUTINA CON PASE DE PARAMETROS
            $resultado=mysqli_query($conectarsistema,"CALL CompletarRegistroNuevosUsuarios('".$IdUsuarios."','".$NombreUsuarios."','".$ApellidoUsuarios."','".$UsuarioUnico."','".$CorreoUsuarios."','".$FotoPerfil."','".$Pais."','".$Ciudad."','".$Telefono."','".$Genero."','".$FechaNacimiento."','".$Privacidad."','".$EstadoPerfil."');");
            if($resultado){
                return "OK";
            }else{
                return "Error: Lo sentimos ha ocurrido un error inesperado. Intenta más tarde...";
            }
        }
        // FUNCION PARA COMPLETAR PERFIL DE USUARIOS NUEVOS REGISTRADOS SIN FOTO
        public function CompletarPerfilNuevosUsuariosSinFoto($conectarsistema,$IdUsuarios,$NombreUsuarios,$ApellidoUsuarios,$UsuarioUnico,$CorreoUsuarios,$Pais,$Ciudad,$Telefono,$Genero,$FechaNacimiento,$Privacidad,$EstadoPerfil){
            // LLAMADO DE RUTINA CON PASE DE PARAMETROS
            $resultado=mysqli_query($conectarsistema,"CALL CompletarRegistroNuevosUsuariosSinFoto('".$IdUsuarios."','".$NombreUsuarios."','".$ApellidoUsuarios."','".$UsuarioUnico."','".$CorreoUsuarios."','".$Pais."','".$Ciudad."','".$Telefono."','".$Genero."','".$FechaNacimiento."','".$Privacidad."','".$EstadoPerfil."');");
            if($resultado){
                return "OK";
            }else{
                return "Error: Lo sentimos ha ocurrido un error inesperado. Intenta más tarde...";
            }
        }
        // FUNCION PARA INSERTAR CANCELACION DE PERFIL USUARIOS
        public function CancelacionPerfilUsuarios($conectarsistema,$NombreUsuarios,$ApellidoUsuarios,$CorreoUsuarios,$MotivoUsuarios,$DetalleUsuarios,$IdUsuario){
            // LLAMADO DE RUTINA CON PASE DE PARAMETROS
            $resultado=mysqli_query($conectarsistema,"CALL CancelarPerfilUsuarios('".$NombreUsuarios."','".$ApellidoUsuarios."','".$CorreoUsuarios."','".$MotivoUsuarios."','".$DetalleUsuarios."','".$IdUsuario."');");
            if($resultado){
                return "OK";
            }else{
                return "Error: Lo sentimos ha ocurrido un error inesperado. Intenta más tarde...";
            }
        }
        // FUNCION PARA EDITAR PERFIL DE USUARIOS REGISTRADOS CON FOTO
        public function EditarPerfilUsuarioFoto($conectarsistema,$IdUsuarios,$NombreUsuarios,$ApellidoUsuarios,$UsuarioUnico,$CorreoUsuarios,$Contrasenia,$FotoPerfil,$FotoPortada,$Pais,$Ciudad,$Telefono,$Genero,$FechaNacimiento,$Privacidad,$EstadoPerfil,$EstadoUsuario){
            // LLAMADO DE RUTINA CON PASE DE PARAMETROS
            $resultado=mysqli_query($conectarsistema,"CALL EditarPerfilUsuariosConFoto('".$IdUsuarios."','".$NombreUsuarios."','".$ApellidoUsuarios."','".$UsuarioUnico."','".$CorreoUsuarios."','".$Contrasenia."','".$FotoPerfil."','".$FotoPortada."','".$Pais."','".$Ciudad."','".$Telefono."','".$Genero."','".$FechaNacimiento."','".$Privacidad."','".$EstadoPerfil."','".$EstadoUsuario."');");
            if($resultado){
                return "OK";
            }else{
                return "Error: Lo sentimos ha ocurrido un error inesperado. Intenta más tarde...";
            }
        }
        // FUNCION PARA EDITAR PERFIL DE USUARIOS REGISTRADOS SIN FOTO
        // -> FOTO DE PORTADA VACIO
        public function EditarPerfilUsuarioSinFotoPortada($conectarsistema,$IdUsuarios,$NombreUsuarios,$ApellidoUsuarios,$UsuarioUnico,$CorreoUsuarios,$Contrasenia,$FotoPerfil,$Pais,$Ciudad,$Telefono,$Genero,$FechaNacimiento,$Privacidad,$EstadoPerfil,$EstadoUsuario){
            // LLAMADO DE RUTINA CON PASE DE PARAMETROS
            $resultado=mysqli_query($conectarsistema,"CALL EditarPerfilUsuariosSinFotoPortada('".$IdUsuarios."','".$NombreUsuarios."','".$ApellidoUsuarios."','".$UsuarioUnico."','".$CorreoUsuarios."','".$Contrasenia."','".$FotoPerfil."','".$Pais."','".$Ciudad."','".$Telefono."','".$Genero."','".$FechaNacimiento."','".$Privacidad."','".$EstadoPerfil."','".$EstadoUsuario."');");
            if($resultado){
                return "OK";
            }else{
                return "Error: Lo sentimos ha ocurrido un error inesperado. Intenta más tarde...";
            }
        }
        // FUNCION PARA EDITAR PERFIL DE USUARIOS REGISTRADOS SIN FOTO
        // -> FOTO DE PERFIL VACIO
        public function EditarPerfilUsuarioSinFotoPerfil($conectarsistema,$IdUsuarios,$NombreUsuarios,$ApellidoUsuarios,$UsuarioUnico,$CorreoUsuarios,$Contrasenia,$FotoPortada,$Pais,$Ciudad,$Telefono,$Genero,$FechaNacimiento,$Privacidad,$EstadoPerfil,$EstadoUsuario){
            // LLAMADO DE RUTINA CON PASE DE PARAMETROS
            $resultado=mysqli_query($conectarsistema,"CALL EditarPerfilSinFotoPerfil('".$IdUsuarios."','".$NombreUsuarios."','".$ApellidoUsuarios."','".$UsuarioUnico."','".$CorreoUsuarios."','".$Contrasenia."','".$FotoPortada."','".$Pais."','".$Ciudad."','".$Telefono."','".$Genero."','".$FechaNacimiento."','".$Privacidad."','".$EstadoPerfil."','".$EstadoUsuario."');");
            if($resultado){
                return "OK";
            }else{
                return "Error: Lo sentimos ha ocurrido un error inesperado. Intenta más tarde...";
            }
        }
        // FUNCION PARA EDITAR PERFIL DE USUARIOS REGISTRADOS SIN FOTO
        // -> FOTO DE PERFIL VACIO
        public function EditarPerfilUsuarioSinFotos($conectarsistema,$IdUsuarios,$NombreUsuarios,$ApellidoUsuarios,$UsuarioUnico,$CorreoUsuarios,$Contrasenia,$Pais,$Ciudad,$Telefono,$Genero,$FechaNacimiento,$Privacidad,$EstadoPerfil,$EstadoUsuario){
            // LLAMADO DE RUTINA CON PASE DE PARAMETROS
            $resultado=mysqli_query($conectarsistema,"CALL EditarPerfilSinFotos('".$IdUsuarios."','".$NombreUsuarios."','".$ApellidoUsuarios."','".$UsuarioUnico."','".$CorreoUsuarios."','".$Contrasenia."','".$Pais."','".$Ciudad."','".$Telefono."','".$Genero."','".$FechaNacimiento."','".$Privacidad."','".$EstadoPerfil."','".$EstadoUsuario."');");
            if($resultado){
                return "OK";
            }else{
                return "Error: Lo sentimos ha ocurrido un error inesperado. Intenta más tarde...";
            }
        }
        // FUNCION PARA INSERTAR NUEVOS DETALLES DE PERFIL DE USUARIOS REGISTRADOS
        public function RegistrarDetallesPerfilUsuarios($conectarsistema,$IdUsuarios,$ReligionUsuarios,$EmpleoUsuarios,$EscuelaUsuarios,$UniversidadUsuarios,$DeportesUsuarios,$InteresesUsuarios,$GenerosMusicalesUsuarios,$SituacionSentimentalUsuarios,$ComprobacionPerfilDetalles,$SobreMiUsuarios){
            // LLAMADO DE RUTINA CON PASE DE PARAMETROS
            $resultado=mysqli_query($conectarsistema,"CALL RegistrarDetallesUsuariosPerfiles('".$IdUsuarios."','".$ReligionUsuarios."','".$EmpleoUsuarios."','".$EscuelaUsuarios."','".$UniversidadUsuarios."','".$DeportesUsuarios."','".$InteresesUsuarios."','".$GenerosMusicalesUsuarios."','".$SituacionSentimentalUsuarios."','".$ComprobacionPerfilDetalles."','".$SobreMiUsuarios."');");
            if($resultado){
                return "OK";
            }else{
                return "Error: Lo sentimos ha ocurrido un error inesperado. Intenta más tarde...";
            }
            return $resultado;
        }
        // FUNCION PARA MODIFICAR DETALLES DE PERFIL DE USUARIOS REGISTRADOS
        public function ModificarDetallesPerfilUsuarios($conectarsistema,$IdUsuarios,$ReligionUsuarios,$EmpleoUsuarios,$EscuelaUsuarios,$UniversidadUsuarios,$DeportesUsuarios,$InteresesUsuarios,$GenerosMusicalesUsuarios,$SituacionSentimentalUsuarios,$ComprobacionPerfilDetalles,$SobreMiUsuarios){
            // LLAMADO DE RUTINA CON PASE DE PARAMETROS
            $resultado=mysqli_query($conectarsistema,"CALL MantenimientoDetallesPerfilUsuarios('".$IdUsuarios."','".$ReligionUsuarios."','".$EmpleoUsuarios."','".$EscuelaUsuarios."','".$UniversidadUsuarios."','".$DeportesUsuarios."','".$InteresesUsuarios."','".$GenerosMusicalesUsuarios."','".$SituacionSentimentalUsuarios."','".$ComprobacionPerfilDetalles."','".$SobreMiUsuarios."');");
            if($resultado){
                return "OK";
            }else{
                return "Error: Lo sentimos ha ocurrido un error inesperado. Intenta más tarde...";
            }
            return $resultado;
        }
        // FUNCION PARA ELIMINAR DEFINITIVAMENTE USUARIOS
        public function EliminarUsuariosRegistrados($conectarsistema,$IdUsuario){
		    $resultado=mysqli_query($conectarsistema,"CALL EliminarUsuarioRegistrado('".$IdUsuario."');");
            if($resultado){
                return "OK";
            }else{
                return "Error: Lo sentimos ha ocurrido un error inesperado. Intenta más tarde...";
            }
            return $resultado;
        }
        // FUNCION PARA CONSULTAR -> EXPLORAR AMIGOS REGISTRADOS {TODOS LOS USUARIOS}
        public function ConsultarAmigosRegistradosGeneral($conectarsistema){
		    $resultado=mysqli_query($conectarsistema,"CALL ConsultarExplorarAmigos();");
            return $resultado;
        }
        // FUNCION PARA ENVIAR NUEVAS SOLICITUDES DE AMISTAD -> TODOS LOS USUARIOS
        public function RegistroSolicitudAmistadUsuarios($conectarsistema,$IdUsuario,$IdSolicitudAmigos){
            // LLAMADO DE RUTINA CON PASE DE PARAMETROS
            $resultado=mysqli_query($conectarsistema,"CALL RegistroSolicitudesAmistadUsuarios('".$IdUsuario."','".$IdSolicitudAmigos."');");
            if($resultado){
                return "OK";
            }else{
                return "Error: Lo sentimos ha ocurrido un error inesperado. Intenta más tarde...";
            }
        }
         // FUNCION PARA ACEPTAR SOLICITUDES DE AMISTAD -> TODOS LOS USUARIOS
         public function AceptarSolicitudesAmistadUsuarios($conectarsistema,$IdUsuario,$IdSolicitudAmigos){
            // LLAMADO DE RUTINA CON PASE DE PARAMETROS
            $resultado=mysqli_query($conectarsistema,"CALL AceptarSolicitudesNuevosAmigos('".$IdUsuario."','".$IdSolicitudAmigos."');");
            if($resultado){
                return "OK";
            }else{
                return "Error: Lo sentimos ha ocurrido un error inesperado. Intenta más tarde...";
            }
        }
        // FUNCION PARA ELIMINAR -> RECHAZAR SOLICITUDES DE AMISTAD
        public function EliminarSolicitudesAmistad($conectarsistema,$IdSolicitudAmistad){
		    $resultado=mysqli_query($conectarsistema,"CALL EliminarSolicitudesAmistad('".$IdSolicitudAmistad."');");
            if($resultado){
                return "OK";
            }else{
                return "Error: Lo sentimos ha ocurrido un error inesperado. Intenta más tarde...";
            }
            return $resultado;
        }
        // CONSULTAR SOLICITUDES NUEVAS DE AMISTAD {VISTA LIMITADA}
        public function ConsultarSolicitudesAmistad($conectarsistema21,$IdUsuarios){
            $resultado=mysqli_query($conectarsistema21,"CALL ConsultaSolicitudesAmistad('".$IdUsuarios."');");
            return $resultado;
        }
        // CONSULTAR NOTIFICACIONES AMIGOS -> SOLICITUDES ACEPTADAS {VISTA LIMITADA}
        public function ConsultarNotificacionesAmigos($conectarsistema22,$IdUsuarios){
            $resultado=mysqli_query($conectarsistema22,"CALL ConsultarNotificacionesAmigos('".$IdUsuarios."');");
            return $resultado;
        }
        // BUSCADOR SECRET SOCIAL -> CONSULTA DE USUARIOS
        public function BuscadorSecretSocialUsuarios($conectarsistema,$Busqueda){
            $resultado=mysqli_query($conectarsistema,"CALL ConsultarBuscadorSecret('".$Busqueda."');");
            return $resultado;
        }
    }// CIERRE class RegistroUsuariosNuevos
?>