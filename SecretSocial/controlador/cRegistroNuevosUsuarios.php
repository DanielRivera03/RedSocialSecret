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
    // DEFINIR URL BASE DINÁMICA
    $protocol = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http');
    $base_dir = rtrim(str_replace('\\', '/', dirname(dirname($_SERVER['SCRIPT_NAME']))), '/');
    $base_url = $protocol . '://' . $_SERVER['HTTP_HOST'] . $base_dir;
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
                if($consulta){
                    // Enviar correo de bienvenida profesional y amigable al usuario registrado
                    require_once('mail_helper.php');
                    $logoPath = __DIR__ . '/../vista/images/logo-full.png';
                    $adjuntosCid = [];
                    if (file_exists($logoPath)) {
                        $adjuntosCid['logo_img'] = $logoPath;
                        $logoSrc = 'cid:logo_img';
                    } else {
                        $logoSrc = '';
                    }
                    
                    $asunto = "¡Te damos la bienvenida a Secret Social! — Completa tu perfil";
                    $anio = date('Y');
                    
                    $htmlContent = '
                    <!DOCTYPE html>
                    <html lang="es">
                    <head>
                        <meta charset="UTF-8">
                        <title>¡Te damos la bienvenida a Secret Social!</title>
                        <style>
                            body { font-family: "Helvetica Neue", Helvetica, Arial, sans-serif; background-color: #f4f6f8; margin: 0; padding: 0; -webkit-font-smoothing: antialiased; }
                            .btn-cta:hover { background: linear-gradient(135deg, #b92025, #9e1418) !important; }
                        </style>
                    </head>
                    <body style="margin: 0; padding: 0; background-color: #f4f6f8;">
                        <table border="0" cellpadding="0" cellspacing="0" width="100%" style="table-layout: fixed;">
                            <tr>
                                <td align="center" style="padding: 40px 0 20px 0; background-color: #f4f6f8;">
                                    <table border="0" cellpadding="0" cellspacing="0" width="600" style="background-color: #ffffff; border-radius: 16px; box-shadow: 0 8px 24px rgba(0,0,0,0.06); overflow: hidden; border: 1px solid #eef2f6;">
                                        <!-- HEADER -->
                                        <tr>
                                            <td align="center" style="padding: 35px 40px; background: linear-gradient(135deg, #e53935 0%, #b92025 100%); text-align: center;">
                                                ' . ($logoSrc ? '<img src="' . $logoSrc . '" alt="Secret Social Logo" style="max-height: 55px; display: block; margin: 0 auto;">' : '<h1 style="color:#ffffff; margin:0; font-size:28px;">Secret Social</h1>') . '
                                            </td>
                                        </tr>
                                        <!-- BODY -->
                                        <tr>
                                            <td style="padding: 40px 40px 30px 40px; color: #334155; line-height: 1.7; font-size: 15px;">
                                                <h2 style="margin-top: 0; color: #b92025; font-size: 22px; font-weight: 700;">¡Hola, ' . htmlspecialchars($NombreUsuarios, ENT_QUOTES, 'UTF-8') . '!</h2>
                                                <p style="margin-bottom: 20px;">Nos alegra enormemente darte la bienvenida oficial a <strong>Secret®</strong>, un espacio diseñado especialmente para conectar, interactuar y compartir contenido en tiempo real con total libertad y confianza.</p>
                                                
                                                <!-- AVISO COMPLETAR PERFIL -->
                                                <div style="background-color: #fff8f8; border-left: 4px solid #e53935; padding: 20px; margin: 25px 0; border-radius: 4px 12px 12px 4px;">
                                                    <h3 style="margin: 0 0 8px 0; color: #b92025; font-size: 16px; font-weight: bold;">⚠️ Recordatorio de paso obligatorio</h3>
                                                    <p style="margin: 0; color: #475569; font-size: 14px; line-height: 1.5;">
                                                        Para poder comenzar a utilizar la red social y desbloquear todas las funciones (como publicar en tu muro, agregar amigos, chatear y navegar por el Marketplace), <strong>debes completar tu perfil de usuario</strong> con tus datos básicos. ¡Es sumamente rápido!
                                                    </p>
                                                </div>
                                                
                                                <!-- BOTON CTA -->
                                                <div style="text-align: center; margin: 35px 0;">
                                                    <a class="btn-cta" href="' . $base_url . '/IniciarSesion/inicio" style="display: inline-block; background: linear-gradient(135deg, #e53935 0%, #b92025 100%); color: #ffffff !important; text-decoration: none; padding: 14px 35px; font-weight: bold; font-size: 15px; border-radius: 30px; box-shadow: 0 6px 20px rgba(185, 32, 37, 0.25); text-align: center;">Completar mi Perfil Ahora</a>
                                                </div>
                                                
                                                <p style="margin-top: 25px; font-weight: bold; color: #1e293b;">¿Qué podrás hacer al completar tu perfil?</p>
                                                <ul style="padding-left: 20px; margin-bottom: 0; line-height: 1.8; color: #475569;">
                                                    <li style="margin-bottom: 6px;"><strong>Compartir contenido:</strong> Publica fotos, historias y estados de ánimo en tu muro.</li>
                                                    <li style="margin-bottom: 6px;"><strong>Conectar con amigos:</strong> Explora el directorio de usuarios, envía solicitudes de amistad e interactúa.</li>
                                                    <li style="margin-bottom: 6px;"><strong>Navegar en Marketplace:</strong> Descubre y publica productos en venta dentro de la red social de manera directa.</li>
                                                </ul>
                                                
                                                <hr style="border: 0; border-top: 1px solid #f1f5f9; margin: 30px 0;">
                                                
                                                <p style="margin-bottom: 0;">¡Estamos ansiosos por ver tus primeras publicaciones en la comunidad!</p>
                                                <p style="margin-top: 10px; font-weight: bold; color: #1e293b;">El equipo de Secret Social</p>
                                            </td>
                                        </tr>
                                        <!-- FOOTER -->
                                        <tr>
                                            <td align="center" style="padding: 25px 40px; background-color: #f8fafc; border-top: 1px solid #f1f5f9; color: #94a3b8; font-size: 12px; text-align: center; line-height: 1.5;">
                                                <p style="margin: 0 0 8px 0;">Este es un mensaje automático enviado tras tu registro en Secret Social.</p>
                                                <p style="margin: 0 0 8px 0;">&copy; ' . $anio . ' Secret Social. Todos los derechos reservados.</p>
                                                <p style="margin: 0;"><a href="' . $base_url . '/IniciarSesion/inicio" style="color: #b92025; text-decoration: none;">Iniciar Sesión</a> | <a href="https://github.com/DanielRivera03" style="color: #b92025; text-decoration: none;">Soporte</a></p>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </body>
                    </html>';
                    
                    $textContent = "¡Hola, " . $NombreUsuarios . "!\n\nTe damos la bienvenida a Secret Social.\n\nPara poder hacer uso completo de la red social, es indispensable que completes tu perfil de usuario.\n\nPuedes iniciar sesión y completar tus datos en la siguiente dirección:\n" . $base_url . "/IniciarSesion/inicio\n\n¡Te esperamos!\n\nEl equipo de Secret Social";
                    
                    enviarCorreo($CorreoUsuarios, $asunto, $htmlContent, $textContent, $adjuntosCid);
                    header('location:../RegistroExitoso/confirmacionregistro');
                } else {
                    // Si falló, verifiquemos si el correo ya existe en la base de datos
                    $stmtCheck = $conectarsistema->prepare("SELECT id FROM usuarios WHERE correo = ? LIMIT 1");
                    $stmtCheck->bind_param("s", $CorreoUsuarios);
                    $stmtCheck->execute();
                    $resCheck = $stmtCheck->get_result();
                    if ($resCheck && $resCheck->num_rows > 0) {
                        $_SESSION['registro_error'] = "El correo electrónico '{$CorreoUsuarios}' ya se encuentra registrado en nuestra plataforma. Por favor, utiliza otro correo o intenta recuperar tu contraseña.";
                        header('location:../Registrarme/altanuevousuario');
                    } else {
                        header('location:../RegistroFallido/error_registro');
                    }
                    $stmtCheck->close();
                }
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
                }else{
                    // SI USUARIO MODIFICA FOTO DE PERFIL POR DEFECTO ENTONCES
                    $consulta=$Usuarios->CompletarPerfilNuevosUsuarios($conectarsistema,$IdUsuarios,$NombreUsuarios,$ApellidoUsuarios,$UsuarioSinEspacios,$CorreoUsuarios,$FotoPerfil,$Pais,$Ciudad,$Telefono,$Genero,$FechaNacimiento,$Privacidad,$EstadoPerfil);
                    // COPIA ARCHIVO SUBIDO CON NOMBRE FINAL A LA RUTA ESTABLECIDA
                    copy($_FILES['fotoperfil']['tmp_name'],$RutaDestino);
                    // ACTUALIZANDO VARIABLE DE SESION LUEGO DE PETICION DE EDICION
                    $_SESSION['fotos_perfiles'] = $FotoPerfil;
                }// CIERRE if(empty($FotoPerfil))

                if($consulta == "OK") {
                    // Enviar correo de confirmación de perfil completado y bienvenida oficial
                    require_once('mail_helper.php');
                    $logoPath = __DIR__ . '/../vista/images/logo-full.png';
                    $adjuntosCid = [];
                    if (file_exists($logoPath)) {
                        $adjuntosCid['logo_img'] = $logoPath;
                        $logoSrc = 'cid:logo_img';
                    } else {
                        $logoSrc = '';
                    }
                    
                    $asunto = "¡Perfil Completado y Verificado! Bienvenido a Secret Social 🎉";
                    $anio = date('Y');
                    
                    $htmlContent = '
                    <!DOCTYPE html>
                    <html lang="es">
                    <head>
                        <meta charset="UTF-8">
                        <title>¡Perfil Completado!</title>
                        <style>
                            body { font-family: "Helvetica Neue", Helvetica, Arial, sans-serif; background-color: #f4f6f8; margin: 0; padding: 0; -webkit-font-smoothing: antialiased; }
                            .btn-cta:hover { background: linear-gradient(135deg, #b92025, #9e1418) !important; }
                        </style>
                    </head>
                    <body style="margin: 0; padding: 0; background-color: #f4f6f8;">
                        <table border="0" cellpadding="0" cellspacing="0" width="100%" style="table-layout: fixed;">
                            <tr>
                                <td align="center" style="padding: 40px 0 20px 0; background-color: #f4f6f8;">
                                     <table border="0" cellpadding="0" cellspacing="0" width="600" style="background-color: #ffffff; border-radius: 16px; box-shadow: 0 8px 24px rgba(0,0,0,0.06); overflow: hidden; border: 1px solid #eef2f6;">
                                         <!-- HEADER -->
                                         <tr>
                                             <td align="center" style="padding: 35px 40px; background: linear-gradient(135deg, #e53935 0%, #b92025 100%); text-align: center;">
                                                 ' . ($logoSrc ? '<img src="' . $logoSrc . '" alt="Secret Social Logo" style="max-height: 55px; display: block; margin: 0 auto;">' : '<h1 style="color:#ffffff; margin:0; font-size:28px;">Secret Social</h1>') . '
                                             </td>
                                         </tr>
                                         <!-- BODY -->
                                         <tr>
                                             <td style="padding: 40px 40px 30px 40px; color: #334155; line-height: 1.7; font-size: 15px;">
                                                 <h2 style="margin-top: 0; color: #b92025; font-size: 22px; font-weight: 700;">¡Enhorabuena, ' . htmlspecialchars($NombreUsuarios, ENT_QUOTES, 'UTF-8') . '!</h2>
                                                 <p style="margin-bottom: 20px;">Nos complace informarte que tu perfil de usuario ha sido verificado y completado correctamente. Tu nombre de usuario oficial en la red es: <strong>@' . htmlspecialchars($UsuarioSinEspacios, ENT_QUOTES, 'UTF-8') . '</strong>.</p>
                                                 
                                                 <!-- AVISO EXITOSO -->
                                                 <div style="background-color: #f0fdf4; border-left: 4px solid #16a34a; padding: 20px; margin: 25px 0; border-radius: 4px 12px 12px 4px;">
                                                     <h3 style="margin: 0 0 8px 0; color: #16a34a; font-size: 16px; font-weight: bold;">✅ Acceso completo concedido</h3>
                                                     <p style="margin: 0; color: #166534; font-size: 14px; line-height: 1.5;">
                                                         ¡Ya no tienes restricciones! A partir de ahora puedes disfrutar de todas las funcionalidades, interactuar en tiempo real, chatear y personalizar tu perfil a tu gusto.
                                                     </p>
                                                 </div>
                                                 
                                                 <p style="margin-top: 25px; font-weight: bold; color: #1e293b;">¿Qué puedes hacer ahora?</p>
                                                 <ul style="padding-left: 20px; margin-bottom: 25px; line-height: 1.8; color: #475569;">
                                                     <li style="margin-bottom: 6px;">💬 <strong>Mensajería Instantánea:</strong> Chatea de forma privada y en tiempo real.</li>
                                                     <li style="margin-bottom: 6px;">📸 <strong>Publicar:</strong> Sube fotos y estados en tu muro y mira lo que comparten otros.</li>
                                                     <li style="margin-bottom: 6px;">🛍️ <strong>Marketplace:</strong> Explora ofertas de la comunidad o publica tus propios productos.</li>
                                                 </ul>
                                                 
                                                 <!-- BOTON CTA -->
                                                 <div style="text-align: center; margin: 35px 0;">
                                                     <a class="btn-cta" href="' . $base_url . '/IniciarSesion/inicio" style="display: inline-block; background: linear-gradient(135deg, #e53935 0%, #b92025 100%); color: #ffffff !important; text-decoration: none; padding: 14px 35px; font-weight: bold; font-size: 15px; border-radius: 30px; box-shadow: 0 6px 20px rgba(185, 32, 37, 0.25); text-align: center;">Acceder a mi Muro</a>
                                                 </div>
                                                 
                                                 <hr style="border: 0; border-top: 1px solid #f1f5f9; margin: 30px 0;">
                                                 
                                                 <p style="margin-bottom: 0;">¡Que disfrutes de tu estadía en nuestra comunidad!</p>
                                                 <p style="margin-top: 10px; font-weight: bold; color: #1e293b;">El equipo de Secret Social</p>
                                             </td>
                                         </tr>
                                         <!-- FOOTER -->
                                         <tr>
                                             <td align="center" style="padding: 25px 40px; background-color: #f8fafc; border-top: 1px solid #f1f5f9; color: #94a3b8; font-size: 12px; text-align: center; line-height: 1.5;">
                                                 <p style="margin: 0 0 8px 0;">&copy; ' . $anio . ' Secret Social. Todos los derechos reservados.</p>
                                             </td>
                                         </tr>
                                     </table>
                                 </td>
                            </tr>
                        </table>
                    </body>
                    </html>';
                    
                    $textContent = "¡Hola, " . $NombreUsuarios . "!\n\nTu perfil en Secret Social ha sido verificado y completado correctamente.\n\nTu nombre de usuario es: @" . $UsuarioSinEspacios . "\n\nPuedes ingresar y comenzar a compartir contenido aquí:\n" . $base_url . "/IniciarSesion/inicio\n\n¡Que disfrutes de tu estadía!\n\nEl equipo de Secret Social";
                    
                    enviarCorreo($CorreoUsuarios, $asunto, $htmlContent, $textContent, $adjuntosCid);
                }

                // ENVIANDO RESPUESTA DE ACCION A MODELO
                echo json_encode($consulta);
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
                
                if($consulta == "OK") {
                    // Enviar correo de despedida (sentimiento de adiós)
                    require_once('mail_helper.php');
                    $logoPath = __DIR__ . '/../vista/images/logo-full.png';
                    $adjuntosCid = [];
                    if (file_exists($logoPath)) {
                        $adjuntosCid['logo_img'] = $logoPath;
                        $logoSrc = 'cid:logo_img';
                    } else {
                        $logoSrc = '';
                    }
                    
                    $asunto = "Lamentamos mucho verte partir de Secret Social... 💔";
                    $anio = date('Y');
                    
                    $htmlContent = '
                     <!DOCTYPE html>
                     <html lang="es">
                     <head>
                         <meta charset="UTF-8">
                         <title>Lamentamos tu partida</title>
                         <style>
                             body { font-family: "Helvetica Neue", Helvetica, Arial, sans-serif; background-color: #f4f6f8; margin: 0; padding: 0; -webkit-font-smoothing: antialiased; }
                         </style>
                     </head>
                     <body style="margin: 0; padding: 0; background-color: #f4f6f8;">
                         <table border="0" cellpadding="0" cellspacing="0" width="100%" style="table-layout: fixed;">
                             <tr>
                                 <td align="center" style="padding: 40px 0 20px 0; background-color: #f4f6f8;">
                                     <table border="0" cellpadding="0" cellspacing="0" width="600" style="background-color: #ffffff; border-radius: 16px; box-shadow: 0 8px 24px rgba(0,0,0,0.06); overflow: hidden; border: 1px solid #eef2f6;">
                                         <!-- HEADER -->
                                         <tr>
                                             <td align="center" style="padding: 35px 40px; background: linear-gradient(135deg, #475569 0%, #1e293b 100%); text-align: center;">
                                                 ' . ($logoSrc ? '<img src="' . $logoSrc . '" alt="Secret Social Logo" style="max-height: 55px; display: block; margin: 0 auto;">' : '<h1 style="color:#ffffff; margin:0; font-size:28px;">Secret Social</h1>') . '
                                             </td>
                                         </tr>
                                         <!-- BODY -->
                                         <tr>
                                             <td style="padding: 40px 40px 30px 40px; color: #334155; line-height: 1.7; font-size: 15px;">
                                                 <h2 style="margin-top: 0; color: #475569; font-size: 22px; font-weight: 700;">Hola, ' . htmlspecialchars($NombreUsuarios, ENT_QUOTES, 'UTF-8') . '</h2>
                                                 <p style="margin-bottom: 20px;">Te confirmamos que hemos procesado tu solicitud de cancelación de registro en nuestra plataforma. Tus datos de usuario e información personal han sido dados de baja de nuestro sistema de forma definitiva.</p>
                                                 
                                                 <!-- MENSAJE DE ADIOS -->
                                                 <div style="background-color: #f8fafc; border-left: 4px solid #475569; padding: 20px; margin: 25px 0; border-radius: 4px 12px 12px 4px;">
                                                     <h3 style="margin: 0 0 8px 0; color: #334155; font-size: 16px; font-weight: bold;">🌱 Tu feedback nos ayuda a mejorar</h3>
                                                     <p style="margin: 0; color: #475569; font-size: 14px; line-height: 1.5;">
                                                         Lamentamos mucho que Secret Social no haya cumplido tus expectativas en esta ocasión. Tomaremos muy en cuenta tus observaciones sobre: <strong>"' . htmlspecialchars($MotivoUsuarios, ENT_QUOTES, 'UTF-8') . '"</strong> para seguir construyendo una mejor red social.
                                                     </p>
                                                 </div>
                                                 
                                                 <p style="margin-top: 25px;">Queremos recordarte que nuestras puertas siempre estarán abiertas en caso de que decidas regresar en el futuro.</p>
                                                 <p style="margin-top: 10px; font-style: italic; color: #64748b;">"No es un adiós definitivo, sino un hasta luego."</p>
                                                 
                                                 <hr style="border: 0; border-top: 1px solid #f1f5f9; margin: 30px 0;">
                                                 
                                                 <p style="margin-bottom: 0;">Te deseamos el mayor de los éxitos en todo lo que emprendas.</p>
                                                 <p style="margin-top: 10px; font-weight: bold; color: #1e293b;">El equipo de Secret Social</p>
                                             </td>
                                         </tr>
                                         <!-- FOOTER -->
                                         <tr>
                                             <td align="center" style="padding: 25px 40px; background-color: #f8fafc; border-top: 1px solid #f1f5f9; color: #94a3b8; font-size: 12px; text-align: center; line-height: 1.5;">
                                                 <p style="margin: 0 0 8px 0;">&copy; ' . $anio . ' Secret Social. Todos los derechos reservados.</p>
                                             </td>
                                         </tr>
                                     </table>
                                 </td>
                             </tr>
                         </table>
                     </body>
                     </html>';
                     
                    $textContent = "Hola, " . $NombreUsuarios . ".\n\nConfirmamos la cancelación de tu registro en Secret Social y la eliminación definitiva de tus datos.\n\nLamentamos que la plataforma no cumpliera tus expectativas. Si decides regresar en el futuro, las puertas de nuestra comunidad siempre estarán abiertas para ti.\n\nTe deseamos lo mejor.\n\nEl equipo de Secret Social";
                    
                    enviarCorreo($CorreoUsuarios, $asunto, $htmlContent, $textContent, $adjuntosCid);
                }
                
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
            
            // Cargar contraseña actual de la base de datos, ya que no se cambia aquí
            $stmt = $conectarsistema->prepare("SELECT contrasenia FROM usuarios WHERE id = ?");
            $stmt->bind_param("i", $IdUsuarios);
            $stmt->execute();
            $res_pwd = $stmt->get_result();
            $row_pwd = $res_pwd->fetch_assoc();
            $Contrasenia = $row_pwd['contrasenia'];
            $stmt->close();
            
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
                if(empty($FotoPerfil) && empty($FotoPortada)){
                    // SOLO ACTUALIZACION DATOS PERSONALES {SIN ARCHIVOS MULTIMEDIA}
                    $consulta=$Usuarios->EditarPerfilUsuarioSinFotos($conectarsistema,$IdUsuarios,$NombreUsuarios,$ApellidoUsuarios,$UsuarioUnico,$CorreoUsuarios,$Contrasenia,$Pais,$Ciudad,$Telefono,$Genero,$FechaNacimiento,$Privacidad,$EstadoPerfil,$EstadoUsuario);
                }else if(empty($FotoPortada)){// FOTO DE PORTADA VACIO
                    // SOLO ACTUALIZACION FOTO DE PORTADA
                    $consulta=$Usuarios->EditarPerfilUsuarioSinFotoPortada($conectarsistema,$IdUsuarios,$NombreUsuarios,$ApellidoUsuarios,$UsuarioUnico,$CorreoUsuarios,$Contrasenia,$FotoPerfil,$Pais,$Ciudad,$Telefono,$Genero,$FechaNacimiento,$Privacidad,$EstadoPerfil,$EstadoUsuario);
                     // SI FOTO DE PORTADA NO SE ACTUALIZA -> SE ASUME CAMBIO FOTO DE PERFIL
                    // COPIA ARCHIVO SUBIDO CON NOMBRE FINAL A LA RUTA ESTABLECIDA
                    copy($_FILES['fotoperfil']['tmp_name'],$RutaDestino);
                    // CLONACION RUTA FOTO DE PERFIL
                    copy($_FILES['fotoperfil']['tmp_name'],$RutaDestino1);
                    // ACTUALIZANDO VARIABLE DE SESION LUEGO DE PETICION DE EDICION
                    $_SESSION['fotos_perfiles'] = $FotoPerfil;
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
                }
                
                if($consulta == "OK") {
                    // Enviar correo de notificación de actualización de perfil
                    require_once('mail_helper.php');
                    $logoPath = __DIR__ . '/../vista/images/logo.png';
                    $adjuntosCid = [];
                    if (file_exists($logoPath)) {
                        $adjuntosCid['logo'] = $logoPath;
                        $logoSrc = 'cid:logo';
                    } else {
                        $logoSrc = '';
                    }
                    
                    $asunto = "Actualización de tu Perfil - Secret Social";
                    $htmlContent = "
                    <!DOCTYPE html>
                    <html>
                    <head>
                        <meta charset='UTF-8'>
                        <style>
                            body { font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; background-color: #f4f6f8; margin: 0; padding: 0; }
                            .container { max-width: 600px; margin: 20px auto; background-color: #ffffff; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.05); }
                            .header { background: linear-gradient(135deg, #b92025, #e53935); padding: 30px; text-align: center; color: #ffffff; }
                            .header img { height: 50px; margin-bottom: 10px; }
                            .header h1 { margin: 0; font-size: 24px; font-weight: 700; }
                            .content { padding: 40px 30px; line-height: 1.6; color: #333333; }
                            .advice-box { background-color: #f8fafc; border-left: 4px solid #b92025; padding: 20px; margin: 25px 0; border-radius: 0 8px 8px 0; }
                            .advice-box h3 { margin: 0 0 10px 0; color: #b92025; }
                            .footer { background-color: #f8fafc; padding: 20px; text-align: center; font-size: 12px; color: #999999; }
                        </style>
                    </head>
                    <body>
                        <div class='container'>
                            <div class='header'>
                                " . ($logoSrc ? "<img src='{$logoSrc}' alt='Secret Social'>" : "") . "
                                <h1>Perfil Actualizado</h1>
                            </div>
                            <div class='content'>
                                <h2>Hola, {$NombreUsuarios}</h2>
                                <p>Te informamos que tu perfil en <strong>Secret®</strong> ha sido actualizado correctamente.</p>
                                <p>Si realizaste este cambio, no es necesario que hagas nada.</p>
                                <div class='advice-box'>
                                    <h3>🛡️ Consejos de Seguridad:</h3>
                                    <ul>
                                        <li>Revisa periódicamente que tu correo y teléfono de contacto estén actualizados.</li>
                                        <li>Si no fuiste tú quien realizó este cambio, entra a la plataforma y cambia tu contraseña inmediatamente.</li>
                                    </ul>
                                </div>
                                <p>Atentamente,<br><strong>El equipo de seguridad de Secret Social</strong></p>
                            </div>
                            <div class='footer'>
                                <p>&copy; " . date('Y') . " Secret Social. Todos los derechos reservados.</p>
                            </div>
                        </div>
                    </body>
                    </html>";
                    
                    enviarCorreo($CorreoUsuarios, $asunto, $htmlContent, '', $adjuntosCid);
                }
                echo json_encode($consulta);
            }
            $conectarsistema->close(); // CERRANDO CONEXION
        break;
        
        // PETICION CAMBIAR CONTRASEÑA
        case "peticion-cambiarclave":
            $IdUsuarios = $_SESSION['id_usuario']; // ID UNICO DE USUARIO
            $ClaveActual = $_POST['clave_actual'];
            $ClaveNueva = $_POST['clave_nueva'];
            
            // 1. Obtener la contraseña actual guardada en base de datos
            $stmt = $conectarsistema->prepare("SELECT contrasenia, nombres, correo FROM usuarios WHERE id = ?");
            $stmt->bind_param("i", $IdUsuarios);
            $stmt->execute();
            $res = $stmt->get_result();
            if ($res && $res->num_rows > 0) {
                $row = $res->fetch_assoc();
                $ContraseniaGuardada = $row['contrasenia'];
                $NombreUsuarios = $row['nombres'];
                $CorreoUsuario = $row['correo'];
                $stmt->close();
                
                // 2. Verificar que la contraseña actual ingresada coincida
                $cifrado_actual = sha1($ClaveActual);
                $hash_actual = crypt($ClaveActual, $cifrado_actual);
                
                if ($hash_actual === $ContraseniaGuardada) {
                    // 3. Encriptar la nueva contraseña
                    $cifrado_nuevo = sha1($ClaveNueva);
                    $nueva_contrasenia = crypt($ClaveNueva, $cifrado_nuevo);
                    
                    // 4. Actualizar en la base de datos
                    $stmt_update = $conectarsistema->prepare("UPDATE usuarios SET contrasenia = ? WHERE id = ?");
                    $stmt_update->bind_param("si", $nueva_contrasenia, $IdUsuarios);
                    if ($stmt_update->execute()) {
                        $stmt_update->close();
                        
                        // 5. Enviar correo de notificación de seguridad de cambio de contraseña
                        require_once('mail_helper.php');
                        $logoPath = __DIR__ . '/../vista/images/logo.png';
                        $adjuntosCid = [];
                        if (file_exists($logoPath)) {
                            $adjuntosCid['logo'] = $logoPath;
                            $logoSrc = 'cid:logo';
                        } else {
                            $logoSrc = '';
                        }
                        
                        $asunto = "Alerta de Seguridad: Cambio de Contraseña - Secret Social";
                        $htmlContent = "
                        <!DOCTYPE html>
                        <html>
                        <head>
                            <meta charset='UTF-8'>
                            <style>
                                body { font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; background-color: #f4f6f8; margin: 0; padding: 0; }
                                .container { max-width: 600px; margin: 20px auto; background-color: #ffffff; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.05); }
                                .header { background: linear-gradient(135deg, #b92025, #e53935); padding: 30px; text-align: center; color: #ffffff; }
                                .header img { height: 50px; margin-bottom: 10px; }
                                .header h1 { margin: 0; font-size: 24px; font-weight: 700; }
                                .content { padding: 40px 30px; line-height: 1.6; color: #333333; }
                                .advice-box { background-color: #f8fafc; border-left: 4px solid #b92025; padding: 20px; margin: 25px 0; border-radius: 0 8px 8px 0; }
                                .advice-box h3 { margin: 0 0 10px 0; color: #b92025; }
                                .footer { background-color: #f8fafc; padding: 20px; text-align: center; font-size: 12px; color: #999999; }
                            </style>
                        </head>
                        <body>
                            <div class='container'>
                                <div class='header'>
                                    " . ($logoSrc ? "<img src='{$logoSrc}' alt='Secret Social'>" : "") . "
                                    <h1>Alerta de Seguridad</h1>
                                </div>
                                <div class='content'>
                                    <h2>Hola, {$NombreUsuarios}</h2>
                                    <p>Te informamos que la contraseña de tu cuenta de <strong>Secret®</strong> ha sido modificada con éxito.</p>
                                    <p>Si realizaste este cambio, no es necesario que hagas nada.</p>
                                    <div class='advice-box'>
                                        <h3>💡 Consejos de Seguridad:</h3>
                                        <ul>
                                            <li>Usa contraseñas únicas que no compartas con otros sitios.</li>
                                            <li>Si no realizaste este cambio, recupera el control de tu cuenta inmediatamente en la pantalla de inicio usando la opción 'Recuperar contraseña'.</li>
                                        </ul>
                                    </div>
                                    <p>Atentamente,<br><strong>El equipo de seguridad de Secret Social</strong></p>
                                </div>
                                <div class='footer'>
                                    <p>&copy; " . date('Y') . " Secret Social. Todos los derechos reservados.</p>
                                </div>
                            </div>
                        </body>
                        </html>";
                        
                        enviarCorreo($CorreoUsuario, $asunto, $htmlContent, '', $adjuntosCid);
                        
                        echo json_encode("OK");
                    } else {
                        echo json_encode("Error al actualizar la contraseña.");
                    }
                } else {
                    echo json_encode("INCORRECT_CURRENT");
                }
            } else {
                echo json_encode("Usuario no encontrado.");
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
        // BUSCADOR EN TIEMPO REAL - AJAX
        case "peticion-buscador-ajax":
            if (!isset($_SESSION['id_usuario'])) {
                header('HTTP/1.0 403 Forbidden');
                exit;
            }
            $Busqueda = isset($_GET['query']) ? $_GET['query'] : '';
            if (empty($Busqueda)) {
                echo json_encode(['users' => [], 'posts' => []]);
            } else {
                $safeBusqueda = mysqli_real_escape_string($conectarsistema, $Busqueda);
                
                // 1. Buscar usuarios
                $res_usuarios = mysqli_query($conectarsistema, "SELECT id, nombres, apellidos, usuario, fotoperfil FROM usuarios WHERE estado_usuario = 'activo' AND (nombres LIKE '%$safeBusqueda%' OR apellidos LIKE '%$safeBusqueda%' OR usuario LIKE '%$safeBusqueda%') LIMIT 5");
                $usuarios = [];
                if ($res_usuarios) {
                    while ($row = mysqli_fetch_assoc($res_usuarios)) {
                        $usuarios[] = [
                            'id' => $row['id'],
                            'nombres' => $row['nombres'],
                            'apellidos' => $row['apellidos'],
                            'usuario' => $row['usuario'],
                            'fotoperfil' => $row['fotoperfil']
                        ];
                    }
                }
                
                // 2. Buscar publicaciones
                $res_posts = mysqli_query($conectarsistema, "SELECT p.mensaje_publicacion, u.id, u.nombres, u.apellidos, u.usuario, u.fotoperfil FROM publicaciones p JOIN usuarios u ON p.id = u.id WHERE p.mensaje_publicacion LIKE '%$safeBusqueda%' ORDER BY p.fecha_publicacion DESC LIMIT 3");
                $posts = [];
                if ($res_posts) {
                    while ($row = mysqli_fetch_assoc($res_posts)) {
                        $posts[] = [
                            'id' => $row['id'],
                            'nombres' => $row['nombres'],
                            'apellidos' => $row['apellidos'],
                            'usuario' => $row['usuario'],
                            'fotoperfil' => $row['fotoperfil'],
                            'mensaje' => strlen($row['mensaje_publicacion']) > 60 ? substr($row['mensaje_publicacion'], 0, 60) . '...' : $row['mensaje_publicacion']
                        ];
                    }
                }
                
                echo json_encode(['users' => $usuarios, 'posts' => $posts]);
            }
            $conectarsistema->close();
            exit;
        break;
        // BUSCADOR DE USUARIOS -> BUSCADOR UNIVERSAL DE TODA LA PLATAFORMA
        case "resultados-busqueda":
            $IdUsuarios = $_SESSION['id_usuario']; // ID UNICO DE USUARIO REGISTRADO
            $Busqueda = isset($_POST['buscador']) ? $_POST['buscador'] : (isset($_GET['buscador']) ? $_GET['buscador'] : '');
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
                // BUSCADOR SECRET -> PUBLICACIONES
                $consultaPubs=$Usuarios->BuscadorSecretSocialPublicaciones($conectarsistema,$Busqueda);

                // Obtener listas de amigos y solicitudes para personalizar botones
                $my_friends = [];
                $amigos_query = mysqli_query($conectarsistema, "SELECT idsolicitudamigo FROM amigos WHERE id = '$IdUsuarios'");
                if ($amigos_query) {
                    while($row = mysqli_fetch_assoc($amigos_query)) {
                        $my_friends[] = $row['idsolicitudamigo'];
                    }
                }

                $pending_sent = [];
                $sent_query = mysqli_query($conectarsistema, "SELECT idsolicitudamigo FROM solicitudamistad WHERE id = '$IdUsuarios' AND estado = 0");
                if ($sent_query) {
                    while($row = mysqli_fetch_assoc($sent_query)) {
                        $pending_sent[] = $row['idsolicitudamigo'];
                    }
                }

                $pending_received = [];
                $received_query = mysqli_query($conectarsistema, "SELECT id FROM solicitudamistad WHERE idsolicitudamigo = '$IdUsuarios' AND estado = 0");
                if ($received_query) {
                    while($row = mysqli_fetch_assoc($received_query)) {
                        $pending_received[] = $row['id'];
                    }
                }

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