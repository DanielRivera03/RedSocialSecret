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
    // IMPORTANDO MODELO DE REGISTRO NUEVOS USUARIOS
    require('../modelo/mRegistroNuevosUsuarios.php');
    // CREANDO INSTANCIA DE CLASE REFERENCIADA
    $Usuarios=new RegistroUsuariosNuevos();
    // SI PETICION DE USUARIO NO HA SIDO PROCESADA ENTONCES...
    if(isset($_GET['nuevoregistro']))
    {
        $peticion_url=$_GET['nuevoregistro'];  // ENVIO GET DE VALOR ACCION {URL}
    }
    // ASIGNA VALOR POR DEFECTO...
    else
    {
        $peticion_url="altanuevousuario";  // CASO CONTRARIO, VALOR POR DEFECTO
    } 
    switch($peticion_url){
        // MOSTRAR FORMULARIO DE REGISTRO
        case 'altanuevousuario':
            require('../vista/registrarme.php');
            $conectarsistema->close(); // CERRANDO CONEXION
        break;
        // ENVIAR ACCION DE REGISTRO HACIA BASE DE DATOS
        case 'ok':
            /*
                LO SUGERIDO ES PRIMER NOMBRE Y APELLIDO.
                QUEDA A CRITERIO DE CADA USUARIO NUEVO...
            */
            // GUARDADO DE NOMBRE DE USUARIO PARA POSTERIOR BIENVENIDA
            $_SESSION['nombre_usuarioregistro']=$_POST['nombre_usuario']; 
            $NombreUsuarios=$_POST['nombre_usuario']; // PRIMER NOMBRE
            $ApellidoUsuarios=$_POST['apellido_usuario']; // PRIMER APELLIDO
            $CorreoUsuarios=$_POST['correo_usuario']; // CORREO USUARIO
            $cifrado = sha1($_POST['clave_usuario']); // CONTRASEÑA INGRESADA POR USUARIO
            $ClaveUsuarios=crypt($_POST['clave_usuario'],$cifrado); // CIFRAR CONTRASEÑA A INGRESAR
            // EVITAR INGRESO ACCIDENTAL O CON INTENCION VALORES NULOS
            if(empty($NombreUsuarios) && empty($ApellidoUsuarios) && empty($CorreoUsuarios) && empty($ClaveUsuarios)){
                header('location:../Error/camposvacios');
            }else{
                $consulta=$Usuarios->InsertarNuevosUsuarios($conectarsistema,$NombreUsuarios,$ApellidoUsuarios,$CorreoUsuarios,$ClaveUsuarios);
            }
            $conectarsistema->close(); // CERRANDO CONEXION
        break;
        // EVITAR INGRESO DE DATOS VACIOS
        case 'camposvacios':
            require('../vista/registrarme.php'); // REDIRECCIONAR A LA PAGINA DE REGISTRO
            $conectarsistema->close(); // CERRANDO CONEXION
        break;
        // CONFIRMACION USUARIO REGISTRADO
        case 'confirmacionregistro':
            require('../vista/Alertas/Registrarme/confirmacion_registro.php');
            $conectarsistema->close(); // CERRANDO CONEXION
        break;
        // ERROR DE USUARIO A REGISTRAR
        case 'error_registro':
            require('../vista/Alertas/Registrarme/error_registro.php');
            $conectarsistema->close(); // CERRANDO CONEXION
        break;
         // COMPLETAR PERFIL NUEVOS USUARIOS REGISTRADOS
         case "completarperfil":
            // SI ES VERDADERO, PROCEDE A MOSTRAR PANTALLA PARA COMPLETAR PERFIL DE NUEVO USUARIO REGISTRADO
            $ComprobadorPerfil = "true";
            header('location:../NuevosUsuarios/completarperfil='.$ComprobadorPerfil);
            $conectarsistema->close(); // CERRANDO CONEXION
        break;
        // FINALIZAR PROCESO DE REGISTRO NUEVOS USUARIOS
        case "finalizar_registro":
            $IdUsuarios = $_SESSION['id_usuario']; // ID UNICO DE USUARIO
            $NombreUsuarios=$_POST['nombre_usuario']; // PRIMER NOMBRE
            $ApellidoUsuarios=$_POST['apellido_usuario']; // PRIMER APELLIDO
            $UsuarioUnico=$_POST['nombre_usuariounico']; // NOMBRE DE USUARIO UNICO
            $UsuarioSinEspacios = trim($UsuarioUnico); // EVITAR USUARIOS UNICOS CON ESPACIOS EN BLANCO
            $CorreoUsuarios=$_POST['correo_usuario']; // CORREO USUARIO
            $Pais=$_POST['pais_residenciausuario']; // PAIS DE RESIDENCIA USUARIO
            $Ciudad=$_POST['ciudad_residenciausuario']; // CIUDAD DE RESIDENCIA USUARIO
            $Telefono=$_POST['telefono_usuario']; // TELEFONO DE USUARIO
            $Genero=$_POST['genero_usuarios']; // GENERO DE USUARIO
            $Privacidad=$_POST['privacidad_perfilusuario']; // PRIVACIDAD PERFIL DE USUARIO
            $FechaNacimiento = $_POST['fecha_nacimiento']; // FECHA DE NACIMIENTO USUARIO
            // SI ES IGUAL A {1} COMPLETAR PERFIL -> {0} USUARIO YA HA FINALIZADO EL REGISTRO
            $EstadoPerfil=0; // ESTADO COMPROBACION DE PERFIL DE USUARIO
            $FotoPerfil=$_FILES['fotoperfil']['name']; // FOTO DE PERFIL DE USUARIO
            $RutaDestino='../vista/images/fotosperfiles/'.$FotoPerfil; // RUTA DE DESTINO GUARDADO DE FOTOS
            $ExtensionFoto=$_FILES['fotoperfil']['type']; // CAPTURA EL TIPO DE FOTO {EXTENSION}
            // EVITAR INGRESO VACIO {ACCIDENTAL O CON INTENCION}
            if(empty($IdUsuarios) && empty($NombreUsuarios) && empty($ApellidoUsuarios) && empty($UsuarioUnico) && empty($CorreoUsuarios) && empty($Pais) && empty($Ciudad) && empty($Telefono) && empty($Genero) && empty($FechaNacimiento) && empty($Privacidad) && empty($EstadoPerfil)){
                location('cRegistroNuevosUsuarios.php?nuevoregistro=completarperfil');
            }else{
                // INGRESO DE CONSULTA HACIA BASE DE DATOS CON DATOS DE USUARIOS
                if(empty($FotoPerfil)){
                    // SI USUARIO DECIDE NO MODIFICAR FOTO DE PERFIL POR DEFECTO ENTONCES
                    $consulta=$Usuarios->CompletarPerfilNuevosUsuariosSinFoto($conectarsistema,$IdUsuarios,$NombreUsuarios,$ApellidoUsuarios,$UsuarioSinEspacios,$CorreoUsuarios,$Pais,$Ciudad,$Telefono,$Genero,$FechaNacimiento,$Privacidad,$EstadoPerfil);
                    // ENVIANDO RESPUESTA DE ACCION A MODELO
                    echo json_encode($consulta);
                }else{
                    // SI USUARIO MODIFICA FOTO DE PERFIL POR DEFECTO ENTONCES
                    $consulta=$Usuarios->CompletarPerfilNuevosUsuarios($conectarsistema,$IdUsuarios,$NombreUsuarios,$ApellidoUsuarios,$UsuarioSinEspacios,$CorreoUsuarios,$FotoPerfil,$Pais,$Ciudad,$Telefono,$Genero,$FechaNacimiento,$Privacidad,$EstadoPerfil);
                    // COPIA ARCHIVO SUBIDO CON NOMBRE FINAL A LA RUTA ESTABLECIDA
                    copy($_FILES['fotoperfil']['tmp_name'],$RutaDestino);
                    // ACTUALIZANDO VARIABLE DE SESION LUEGO DE PETICION DE EDICION
                    $_SESSION['fotos_perfiles'] = $FotoPerfil;
                    // ENVIANDO RESPUESTA DE ACCION A MODELO
                    echo json_encode($consulta);
                }// CIERRE if(empty($FotoPerfil))
            }
            $conectarsistema->close(); // CERRANDO CONEXION
        break;
        // CANCELACION DE PERFIL USUARIOS
        case "cancelar_perfil":
            $NombreUsuarios=$_POST['nombre_usuario']; // PRIMER NOMBRE
            $ApellidoUsuarios=$_POST['apellido_usuario']; // PRIMER APELLIDO
            $CorreoUsuarios=$_POST['correo_usuario']; // CORREO CANCELACION USUARIO
            $MotivoUsuarios=$_POST['motivo_cancelar']; // MOTIVO CANCELACION USUARIO
            $DetalleUsuarios=$_POST['detalle_cancelar']; // DETALLE CANCELACION USUARIO
            $IdUsuario = $_SESSION['id_usuario']; // ID UNICO DE USUARIO
            // EVITAR INGRESO VACIO {ACCIDENTAL O CON INTENCION}
            if(empty($NombreUsuarios) && empty($ApellidoUsuarios) && empty($CorreoUsuarios) && empty($MotivoUsuarios) && empty($DetalleUsuarios)){
                location('cRegistroNuevosUsuarios.php?nuevoregistro=completarperfil');
            }else{
                // GUARDAR REGISTRO HISTORICO USUARIO CANCELADO
                $consulta=$Usuarios->CancelacionPerfilUsuarios($conectarsistema,$NombreUsuarios,$ApellidoUsuarios,$CorreoUsuarios,$MotivoUsuarios,$DetalleUsuarios,$IdUsuario);
                // ENVIANDO RESPUESTA DE ACCION A MODELO
                echo json_encode($consulta);
            }
            $conectarsistema->close(); // CERRANDO CONEXION
        break;
        // EDITAR PERFILES DE USUARIOS YA COMPLETADOS
        case "editar-perfil":
            $IdUsuarioPerfil=$_GET['usuario']; // TOMAR ID USUARIO UNICO -> CONSULTAR EN BASE DE DATOS
            $IdUsuarios=$_SESSION['id_usuario']; // ID UNICO DE USUARIO REGISTRADO
            $consulta=$Usuarios->ConsultarPerfilUsuario($conectarsistema,$IdUsuarioPerfil);
            // CONSULTAR SOLICITUDES DE AMISTAD RECIBIDAS
            $consulta1=$Usuarios->ConsultarSolicitudesAmistad($conectarsistema21,$IdUsuarios);
            // CONSULTAR NOTIFICACIONES AMIGOS ACEPTADOS -> TODOS LOS USUARIOS
            $consulta2=$Usuarios->ConsultarNotificacionesAmigos($conectarsistema22,$IdUsuarios);
            // SI PETICION ES EXITOSA, MUESTRA EN PANTALLA SU SOLICITUD  
            require('../vista/editar-perfil.php');  
            $conectarsistema->close(); // CERRANDO CONEXION
        break;
        // ENVIO DE PETICION HACIA BASE DE DATOS CON DATOS ACTUALIZADOS
        case "peticion-editarperfil":
            $IdUsuarios = $_SESSION['id_usuario']; // ID UNICO DE USUARIO
            $NombreUsuarios=$_POST['nombre_usuario']; // PRIMER NOMBRE
            $ApellidoUsuarios=$_POST['apellido_usuario']; // PRIMER APELLIDO
            $cifrado = sha1($_POST['clave_usuario']); // CONTRASEÑA INGRESADA POR USUARIO
            $Contrasenia=crypt($_POST['clave_usuario'],$cifrado); // CIFRAR CONTRASEÑA A INGRESAR
            // IMPORTANTE -> CAMPO USUARIO UNICO NO ES ACTUALIZABLE, RAZON POR LA CUAL SE
            // TOMA LA VARIABLE DE SESION DE LOS USUARIOS REGISTRADOS
            $UsuarioUnico=$_SESSION['usuario_unico']; // NOMBRE DE USUARIO UNICO
            $CorreoUsuarios=$_POST['correo_usuario']; // CORREO USUARIO
            $Pais=$_POST['pais_residenciausuario']; // PAIS DE RESIDENCIA USUARIO
            $Ciudad=$_POST['ciudad_residenciausuario']; // CIUDAD DE RESIDENCIA USUARIO
            $Telefono=$_POST['telefono_usuario']; // TELEFONO DE USUARIO
            $Genero=$_POST['genero_usuarios']; // GENERO DE USUARIO
            $Privacidad=$_POST['privacidad_perfilusuario']; // PRIVACIDAD PERFIL DE USUARIO
            $FechaNacimiento = $_POST['fecha_nacimiento']; // FECHA DE NACIMIENTO USUARIO
            // SI ES IGUAL A {1} COMPLETAR PERFIL -> {0} USUARIO YA HA FINALIZADO EL REGISTRO
            /*
                IMPORTANTE -> TODOS LOS USUARIOS QUE YA COMPLETARON SU PERFIL, AUTOMATICAMENTE
                OBTIENEN EL VALOR DE 0 {CERO}... SI UN USUARIO DECIDE DARSE DE BAJA, TENDRÁ QUE 
                REALIZAR ESA PETICIÓN EN EL APARTADO ESPECÍFICO PARA ESA ACCIÓN
                --> APLICA PARA ESTADO DE USUARIO IGUALMENTE <--
            */
            $EstadoPerfil=0; // ESTADO COMPROBACION DE PERFIL DE USUARIO
            $EstadoUsuario="activo";// SE ASUME QUE EL USUARIO ESTA ACTIVO MIENTRAS NO REALICE PETICION
            $FotoPerfil=$_FILES['fotoperfil']['name']; // FOTO DE PERFIL DE USUARIO
            // FOTO DE PERFIL
            $RutaDestino='../vista/images/fotosperfiles/'.$FotoPerfil; // RUTA DE DESTINO GUARDADO DE FOTOS
            $ExtensionFoto=$_FILES['fotoperfil']['type']; // CAPTURA EL TIPO DE FOTO {EXTENSION}
            // FOTO DE PORTADA
            $FotoPortada=$_FILES['fotosportadas']['name']; // FOTO DE PORTADA DE USUARIO
            $RutaDestinoPortada='../vista/images/fotosportadas/'.$FotoPortada; // RUTA DE DESTINO GUARDADO DE FOTOS
            $ExtensionFotoPortada=$_FILES['fotosportadas']['type']; // CAPTURA EL TIPO DE FOTO {EXTENSION}
            /*
                -> COPIA DE ARCHIVOS MULTIMEDIA AL MOMENTO DE ACTUALIZAR A CARPETA DE PUBLICACIONES
                PARA CUANDO SE EJECUTE EL DISPARADOR, DICHOS ARCHIVOS EXISTAN
            */
            // CLONACION RUTA FOTO DE PORTADA
            $RutaDestinoPortada1='../vista/images/fotospublicaciones/'.$FotoPortada; // RUTA DE DESTINO GUARDADO DE FOTOS
            // CLONACION RUTA FOTO DE PERFIL
            $RutaDestino1='../vista/images/fotospublicaciones/'.$FotoPerfil; // RUTA DE DESTINO GUARDADO DE FOTOS
            // EVITAR INGRESO VACIO {ACCIDENTAL O CON INTENCION}
            if(empty($IdUsuarios) && empty($NombreUsuarios) && empty($ApellidoUsuarios) && empty($UsuarioUnico) && empty($CorreoUsuarios) && empty($Pais) && empty($Ciudad) && empty($Telefono) && empty($Genero) && empty($FechaNacimiento) && empty($Privacidad) && empty($EstadoPerfil) && empty($EstadoUsuario)){
                location('cRegistroNuevosUsuarios.php?nuevoregistro=editarperfil');
            }else{
                // INGRESO DE CONSULTA HACIA BASE DE DATOS CON DATOS DE USUARIOS
                /*
                    --> IMPORTANTE: SE COMPRUEBA QUE PROCEDIMIENTO REALIZAN LOS USUARIOS
                    1. SOLO ACTUALIZACION DE DATOS PERSONALES {NO -> FOTO PERFIL / PORTADA}
                    2. SOLO ACTUALIZACION DE FOTO DE PORTADA
                    3. SOLO ACTUALIZACION DE FOTO DE PERFIL
                    4. ACTUALIZACION DE AMBOS CAMPOS {SI -> FOTO PERFIL / FOTO PORTADA}
                    --> TODOS LOS DEMAS CAMPOS NO SUFREN NINGUN EFECTO ESPECIAL <--
                    ---------------------------------------------------------------------------------
                    --> TODOS LOS PROCEDIMIENTOS ALMACENADOS SE ENCUENTRAN SEPARADOS
                    POR CADA ACCION QUE COMPRUEBA ESTE CONTROLADOR, ENVIANDO PETICION
                    AL MODELO DE DATOS.
                    --> CUALQUIER CAMBIO SE DEBE MODIFICAR LA LOGICA APLICADA <--
                    ---------------------------------------------------------------------------------
                */
                // SOLO ACTUALIZACION DE DATOS PERSONALES {NO FOTO DE PERFIL -> NO FOTO DE PORTADA}
                if(empty($FotoPerfil) && empty($FotoPortada)){
                    // SOLO ACTUALIZACION DATOS PERSONALES {SIN ARCHIVOS MULTIMEDIA}
                    $consulta=$Usuarios->EditarPerfilUsuarioSinFotos($conectarsistema,$IdUsuarios,$NombreUsuarios,$ApellidoUsuarios,$UsuarioUnico,$CorreoUsuarios,$Contrasenia,$Pais,$Ciudad,$Telefono,$Genero,$FechaNacimiento,$Privacidad,$EstadoPerfil,$EstadoUsuario);
                    // ENVIANDO RESPUESTA DE ACCION A MODELO
                    echo json_encode($consulta);
                }else if(empty($FotoPortada)){// FOTO DE PERFIL VACIO
                    // SOLO ACTUALIZACION FOTO DE PORTADA
                    $consulta=$Usuarios->EditarPerfilUsuarioSinFotoPortada($conectarsistema,$IdUsuarios,$NombreUsuarios,$ApellidoUsuarios,$UsuarioUnico,$CorreoUsuarios,$Contrasenia,$FotoPerfil,$Pais,$Ciudad,$Telefono,$Genero,$FechaNacimiento,$Privacidad,$EstadoPerfil,$EstadoUsuario);
                     // SI FOTO DE PORTADA NO SE ACTUALIZA -> SE ASUME CAMBIO FOTO DE PERFIL
                    // COPIA ARCHIVO SUBIDO CON NOMBRE FINAL A LA RUTA ESTABLECIDA
                    copy($_FILES['fotoperfil']['tmp_name'],$RutaDestino);
                    // CLONACION RUTA FOTO DE PERFIL
                    copy($_FILES['fotoperfil']['tmp_name'],$RutaDestino1);
                    // ACTUALIZANDO VARIABLE DE SESION LUEGO DE PETICION DE EDICION
                    $_SESSION['fotos_perfiles'] = $FotoPerfil;
                    // ENVIANDO RESPUESTA DE ACCION A MODELO
                    echo json_encode($consulta);
                }else if(empty($FotoPerfil)){// FOTO DE PORTADA VACIO
                    // SOLO ACTUALIZACION FOTO DE PERFIL
                    $consulta=$Usuarios->EditarPerfilUsuarioSinFotoPerfil($conectarsistema,$IdUsuarios,$NombreUsuarios,$ApellidoUsuarios,$UsuarioUnico,$CorreoUsuarios,$Contrasenia,$FotoPortada,$Pais,$Ciudad,$Telefono,$Genero,$FechaNacimiento,$Privacidad,$EstadoPerfil,$EstadoUsuario);
                     // SI FOTO DE PERFIL NO SE ACTUALIZA -> SE ASUME CAMBIO FOTO DE PORTADA
                    // COPIA ARCHIVO SUBIDO CON NOMBRE FINAL A LA RUTA ESTABLECIDA
                    copy($_FILES['fotosportadas']['tmp_name'],$RutaDestinoPortada);
                    // CLONACION RUTA FOTO DE PORTADA
                    copy($_FILES['fotosportadas']['tmp_name'],$RutaDestinoPortada1);
                    // ACTUALIZANDO VARIABLE DE SESION LUEGO DE PETICION DE EDICION
                    $_SESSION['fotos_portadas'] = $FotoPortada;
                    // ENVIANDO RESPUESTA DE ACCION A MODELO
                    echo json_encode($consulta);
                }else{// AMBOS CAMPOS COMPLETADOS
                    // SI USUARIO MODIFICA FOTO DE PERFIL POR DEFECTO ENTONCES
                    $consulta=$Usuarios->EditarPerfilUsuarioFoto($conectarsistema,$IdUsuarios,$NombreUsuarios,$ApellidoUsuarios,$UsuarioUnico,$CorreoUsuarios,$Contrasenia,$FotoPerfil,$FotoPortada,$Pais,$Ciudad,$Telefono,$Genero,$FechaNacimiento,$Privacidad,$EstadoPerfil,$EstadoUsuario);
                    // SI AMBOS CAMPOS SE ACTUALIZAN, ENTONCES COPIA ARCHIVOS EN AMBAS UBICACIONES
                    // COPIA ARCHIVO SUBIDO CON NOMBRE FINAL A LA RUTA ESTABLECIDA
                    copy($_FILES['fotoperfil']['tmp_name'],$RutaDestino); // FOTO DE PERFIL
                    // COPIA ARCHIVO SUBIDO CON NOMBRE FINAL A LA RUTA ESTABLECIDA
                    copy($_FILES['fotosportadas']['tmp_name'],$RutaDestinoPortada); // FOTO DE PORTADA
                     // CLONACION RUTA FOTO DE PERFIL
                     copy($_FILES['fotoperfil']['tmp_name'],$RutaDestino1);
                      // CLONACION RUTA FOTO DE PORTADA
                    copy($_FILES['fotosportadas']['tmp_name'],$RutaDestinoPortada1);
                    // ACTUALIZANDO VARIABLE DE SESION LUEGO DE PETICION DE EDICION
                    $_SESSION['fotos_portadas'] = $FotoPortada; // FOTO DE PORTADA
                    // ACTUALIZANDO VARIABLE DE SESION LUEGO DE PETICION DE EDICION
                    $_SESSION['fotos_perfiles'] = $FotoPerfil; // FOTO DE PERFIL
                    // ENVIANDO RESPUESTA DE ACCION A MODELO
                    echo json_encode($consulta);
                }// CIERRE if(empty($FotoPerfil))
            }
            $conectarsistema->close(); // CERRANDO CONEXION
        break;
        // REGISTRAR -> ACTUALIZAR DATOS DE DETALLES DE USUARIOS -> PERFIL DE USUARIOS
        case "peticion-detallesusuarios":
            $IdUsuarios = $_SESSION['id_usuario']; // ID UNICO DE USUARIO REGISTRADO
            $ReligionUsuarios = $_POST['religion_detalleusuario']; // RELIGIONES DE USUARIOS
            $EmpleoUsuarios = $_POST['profesion_detalleusuario']; // PROFESION DE USUARIOS
            $EscuelaUsuarios = $_POST['escuela_detalleusuario']; // FORMACION INICIAL DE USUARIOS
            $UniversidadUsuarios = $_POST['universidad_detalleusuario']; // FORMACION SUPERIOR DE USUARIOS
            $DeportesUsuarios = $_POST['deportes_detalleusuario']; // DEPORTES DE USUARIOS
            $InteresesUsuarios = $_POST['intereses_detalleusuario']; // INTERESES AMOROSOS DE USUARIOS
            // GENEROS MUSICALES DE USUARIOS
            $GenerosMusicalesUsuarios = $_POST['generosmusicales_detalleusuario'];
            // SITUACION SENTIMENTAL DE USUARIOS
            $SituacionSentimentalUsuarios = $_POST['situacionsentimental_detalleusuario'];
            // SI COMPROBACION ES IGUAL A 1 -> ES USUARIO NUEVO Y NUNCA HA REALIZADO ESTE PROCESO
            // SI COMPROBACION ES IGUAL A 0 -> ES UN USUARIO ANTIGUO Y SALTA AL PROXIMO PROCESO
            $ComprobacionPerfilDetalles = 0; // -> USUARIOS NUEVOS
            $SobreMiUsuarios = $_POST['sobremi_detalleusuario']; // DESCRIPCION CORTA SOBRE USUARIOS
            /*
                IMPORTANTE -> SI EL USUARIO REGISTRA POR PRIMERA VEZ SU INFORMACION DE DETALLES
                DE USUARIOS, TODOS LOS CAMPOS ESTARÁN VACÍOS, POR LO CUAL SE ASUME QUE LA PETICIÓN
                A REALIZAR SERÁ UN REGISTRO...
            */
            // EVITAR INGRESO VACIO O MAL INTENCIONADO
            if(empty($SobreMiUsuarios)){
                header("location:../Feed/inicio");
            }else{
                $consulta=$Usuarios->RegistrarDetallesPerfilUsuarios($conectarsistema,$IdUsuarios,$ReligionUsuarios,$EmpleoUsuarios,$EscuelaUsuarios,$UniversidadUsuarios,$DeportesUsuarios,$InteresesUsuarios,$GenerosMusicalesUsuarios,$SituacionSentimentalUsuarios,$ComprobacionPerfilDetalles,$SobreMiUsuarios);
                // ENVIANDO RESPUESTA DE ACCION A MODELO
                echo json_encode($consulta);
            }
            $conectarsistema->close(); // CERRANDO CONEXION
        break;
        // USUARIOS ANTIGUOS REGISTRADOS, REALIZA ACTUALIZACION UNICAMENTE
        case "peticion-modificardetallesusuarios":
            $IdUsuarios = $_SESSION['id_usuario']; // ID UNICO DE USUARIO REGISTRADO
            $ReligionUsuarios = $_POST['religion_detalleusuario']; // RELIGIONES DE USUARIOS
            $EmpleoUsuarios = $_POST['profesion_detalleusuario']; // PROFESION DE USUARIOS
            $EscuelaUsuarios = $_POST['escuela_detalleusuario']; // FORMACION INICIAL DE USUARIOS
            $UniversidadUsuarios = $_POST['universidad_detalleusuario']; // FORMACION SUPERIOR DE USUARIOS
            $DeportesUsuarios = $_POST['deportes_detalleusuario']; // DEPORTES DE USUARIOS
            $InteresesUsuarios = $_POST['intereses_detalleusuario']; // INTERESES AMOROSOS DE USUARIOS
            // GENEROS MUSICALES DE USUARIOS
            $GenerosMusicalesUsuarios = $_POST['generosmusicales_detalleusuario'];
            // SITUACION SENTIMENTAL DE USUARIOS
            $SituacionSentimentalUsuarios = $_POST['situacionsentimental_detalleusuario'];
            // SI COMPROBACION ES IGUAL A 1 -> ES USUARIO NUEVO Y NUNCA HA REALIZADO ESTE PROCESO
            // SI COMPROBACION ES IGUAL A 0 -> ES UN USUARIO ANTIGUO Y SALTA AL PROXIMO PROCESO
            $ComprobacionPerfilDetalles = 0; // -> USUARIOS ANTIGUOS
            $SobreMiUsuarios = $_POST['sobremi_detalleusuario']; // DESCRIPCION CORTA SOBRE USUARIOS
            // SI EXISTE UN SOLO CAMPO LLENO SE ASUME QUE ES UNA ACTUALIZACIÓN
            $consulta=$Usuarios->ModificarDetallesPerfilUsuarios($conectarsistema,$IdUsuarios,$ReligionUsuarios,$EmpleoUsuarios,$EscuelaUsuarios,$UniversidadUsuarios,$DeportesUsuarios,$InteresesUsuarios,$GenerosMusicalesUsuarios,$SituacionSentimentalUsuarios,$ComprobacionPerfilDetalles,$SobreMiUsuarios);
            // ENVIANDO RESPUESTA DE ACCION A MODELO
            echo json_encode($consulta);
            $conectarsistema->close(); // CERRANDO CONEXION
        break;
        // ELIMINAR PARA SIEMPRE USUARIOS REGISTRADOS
        case "eliminar-usuarios-definitivamente":
            $IdUsuario=$_GET['idusuariounico'];
            // EVITAR INGRESO VACIO O MAL INTENCIONADO
            if(empty($IdUsuario)){
                header("location:../Feed/inicio");
            }else{
                $consulta=$Usuarios->EliminarUsuariosRegistrados($conectarsistema,$IdUsuario);
                // ENVIANDO RESPUESTA DE ACCION A MODELO
                echo json_encode($consulta);
            }
            $conectarsistema->close(); // CERRANDO CONEXION
        break;
        // RETORNO INICIO DE APLICACION -> USUARIOS ELIMINADOS
        case "retorno-usuarioseliminados":
            session_unset();
            session_destroy();
            header('location:../index.php');
            $conectarsistema->close(); // CERRANDO CONEXION
        break;
        // VISTA DE TODOS LOS USUARIOS REGISTRADOS SIN EXCEPCION
        case "explorar-amigos":
            $IdUsuarios=$_SESSION['id_usuario']; // ID UNICO DE USUARIO REGISTRADO
            // EXPLORAR TODOS LOS USUARIOS REGISTRADOS
            $consulta=$Usuarios->ConsultarAmigosRegistradosGeneral($conectarsistema);
             // CONSULTAR SOLICITUDES DE AMISTAD RECIBIDAS
            $consulta1=$Usuarios->ConsultarSolicitudesAmistad($conectarsistema14,$IdUsuarios);
            // CONSULTAR NOTIFICACIONES AMIGOS ACEPTADOS -> TODOS LOS USUARIOS
            $consulta2=$Usuarios->ConsultarNotificacionesAmigos($conectarsistema16,$IdUsuarios);
            require('../vista/listausuariosregistrados.php');
            $conectarsistema->close(); // CERRANDO CONEXION
            $conectarsistema14->close(); // CERRANDO CONEXION AUXILIAR 14
            $conectarsistema16->close(); // CERRANDO CONEXION AUXILIAR 16
        break;
        // REGISTRO -> ENVIO DE NUEVAS SOLICITUDES DE AMISTAD -> TODOS LOS USUARIOS
        case "registro-solicitud-amistad":
            $IdUsuarios = $_SESSION['id_usuario']; // ID UNICO DE USUARIO REGISTRADO
            $IdSolicitudAmigos = $_GET['idsolicitudamigo']; // ID UNICO USUARIO QUE RECIBE SOLICITUD ENVIADA
            // EVITAR INGRESO VACIO O MAL INTENCIONADO
            if(empty($IdSolicitudAmigos)){
                header("location:../Feed/inicio");
            }else{
                $consulta=$Usuarios->RegistroSolicitudAmistadUsuarios($conectarsistema,$IdUsuarios,$IdSolicitudAmigos);
                 // ENVIANDO RESPUESTA DE ACCION A MODELO
                echo json_encode($consulta);
            }
            $conectarsistema->close(); // CERRANDO CONEXION
        break;
        /*
            -> IMPORTANTE: AL ACEPTAR SOLICITUDES DE AMISTAD, AUTOMATICAMENTE EL ESTADO
            DENTRO DE LA TABLA SOLICITUDES DE AMISTAD CAMBIA A '1' {UNO} -> LO CUAL SE ASUME
            QUE EN EFECTO FUE ACEPTADA.

            -> EXTRA A TOMAR EN CUENTA -> SOLICITUDES DE AMISTAD / AMIGOS <-
            -----------------------------------------------------------------------------------------------
            -> LAS SOLICITUDES SE MANEJAN COMO SOLICITUDES DE SEGUIMIENTO, ES DECIR
            SI EL USUARIO '1' {UNO} ACEPTA AL USUARIO '2' {DOS} -> EL USUARIO '1' {UNO} ES AMIGO 
            DEL '2' {DOS}... PERO EL USUARIO '2' {DOS} DEBE ENVIAR SU SOLICITUD DE AMISTAD AL 
            USUARIO '1  {UNO} PARA SER AMIGOS
            -> NO ES POSIBLE EL ENVIO DE SOLICITUDES REPLICADAS <-
            -> POR RAZONES DE MEJOR PRONUNCIACION Y ALCANCE SE HA MANEJADO EL 
                TERMINO "AMIGOS" Y NO "SEGUIDORES".
            -----------------------------------------------------------------------------------------------    
        */
        // REGISTRO -> NUEVOS AMIGOS {ACEPTAR SOLICITUDES DE AMISTAD} -> TODOS LOS USUARIOS
        case "aceptar-solicitud-amistad":
            $IdUsuarios = $_SESSION['id_usuario']; // ID UNICO DE USUARIO REGISTRADO
            $IdSolicitudAmigos = $_GET['idsolicitudamigo']; // ID UNICO USUARIO QUE RECIBE SOLICITUD ENVIADA
            // EVITAR INGRESO VACIO O MAL INTENCIONADO
            if(empty($IdSolicitudAmigos)){
                header("location:../Feed/inicio");
            }else{
                $consulta=$Usuarios->AceptarSolicitudesAmistadUsuarios($conectarsistema,$IdUsuarios,$IdSolicitudAmigos);
                 // ENVIANDO RESPUESTA DE ACCION A MODELO
                echo json_encode($consulta);
            }
            $conectarsistema->close(); // CERRANDO CONEXION
        break;
        // ELIMINAR / RECHAZAR SOLICITUDES DE AMISTAD -> TODOS LOS USUARIOS
        case "eliminar-solicitud-amistad":
            $IdSolicitudAmistad = $_GET['idsolicitudamigo']; // ID UNICO USUARIO QUE RECIBE SOLICITUD ENVIADA
            // EVITAR PROCESAR ACCION NULA O VACIA
            if(empty($IdSolicitudAmistad)){
                header("location:../Feed/inicio");
            }else{
                $consulta=$Usuarios->EliminarSolicitudesAmistad($conectarsistema,$IdSolicitudAmistad);
                // ENVIANDO RESPUESTA DE ACCION A MODELO
                echo json_encode($consulta);
                }
            $conectarsistema->close(); // CERRANDO CONEXION
        break;
        // BUSCADOR DE USUARIOS -> BUSCADOR UNIVERSAL DE TODA LA PLATAFORMA
        case "resultados-busqueda":
            $IdUsuarios = $_SESSION['id_usuario']; // ID UNICO DE USUARIO REGISTRADO
            $Busqueda = $_POST['buscador']; // LECTURA DE PALABRAS INGRESADAS POR USUARIOS  
            // EVITAR PROCESAR BUSQUEDAS NULAS O VACIAS
            if(empty($Busqueda)){
                header("location:../Feed/inicio");
            }else{// SI BUSQUEDA EXISTEN COINCIDENCIAS -> MUESTRA RESULTADOS
                // CONSULTAR SOLICITUDES DE AMISTAD RECIBIDAS
                $consulta=$Usuarios->ConsultarSolicitudesAmistad($conectarsistema21,$IdUsuarios);
                // CONSULTAR NOTIFICACIONES AMIGOS ACEPTADOS -> TODOS LOS USUARIOS
                $consulta1=$Usuarios->ConsultarNotificacionesAmigos($conectarsistema22,$IdUsuarios);
                // BUSCADOR SECRET -> MOSTRAR SI EXISTEN COINCIDENCIAS EN LA BUSQUEDA
                $consulta2=$Usuarios->BuscadorSecretSocialUsuarios($conectarsistema,$Busqueda);
                // TODAS LAS CONSULTAS ANIDADAS EN UNA SOLA PAGINA
                require('../vista/resultadosbusqueda.php');
            }
            $conectarsistema->close(); // CERRANDO CONEXION
            $conectarsistema21->close(); // CERRANDO CONEXION AUXILIAR 21
            $conectarsistema22->close(); // CERRANDO CONEXION AUXILIAR 22
        break;
        // BLOQUEAR ACCIONES NO EXISTENTES
        default:
            session_unset();
            session_destroy();
            $peticion_url=$_GET['noautorizado'];
            header('location:../AccesoDenegado=restringido');
            $conectarsistema->close(); // CERRANDO CONEXION
        break;
    }// CIERRE switch($peticion_url)
?>