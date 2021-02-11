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
    require('../modelo/mRegistroNuevosUsuarios.php');
    // SI PETICION DE USUARIO NO HA SIDO PROCESADA ENTONCES...
    if(isset($_GET['validarsesion']))
    {
        $peticion_url=$_GET['validarsesion'];  // ENVIO GET DE VALOR ACCION {URL}
    }
    // ASIGNA VALOR POR DEFECTO...
    else
    {
        $peticion_url="inicio";  // CASO CONTRARIO, VALOR POR DEFECTO
    } 
    switch($peticion_url){
        // INICIO DEL SISTEMA {INDEX}
        case "inicio":
            require("../vista/iniciarsesion.php");
        break;
        // VALIDAR USUARIOS -> INICIO DE SESION
        case "validar":
            $cifrado = sha1($_POST['ClaveUsuario']); // RECIBIR CLAVE INGRESADA Y CIFRARLA
            $ClaveUsuarios=crypt($conectarsistema->real_escape_string($_POST['ClaveUsuario']),$cifrado); // COMPARAR CLAVE INGRESADA
            $usuario=$conectando->login($conectarsistema,$conectarsistema->real_escape_string($_POST['CorreoUsuario']),$ClaveUsuarios);
            $login=mysqli_fetch_array($usuario);
            if($login){
                /*
                    IMPORTANTE:
                    -> GUARDADO DE INFORMACION PERSONAL DE CADA USUARIO PARA POSTERIOR
                    UTILIZACION EN COMPLETAR PERFIL DE NUEVOS USUARIOS REGISTRADOS
                */
                // GUARDADO DE DATOS DE USUARIO {SESIONES}
                $_SESSION['id_usuario']=$login['id']; // ID UNICO IDENTIFICADOR DE USUARIO
                $_SESSION['nombre_usuario']=$login['nombres']; // PRIMER NOMBRE DE USUARIOS
                $_SESSION['apellido_usuario']=$login['apellidos']; // PRIMER APELLIDO DE USUARIOS
                $_SESSION['usuario_unico']=$login['usuario']; // NOMBRE DE USUARIO UNICO USUARIOS
                $_SESSION['correo_usuario']=$login['correo']; // CORREO DE USUARIO
                $_SESSION['fotos_perfiles']=$login['fotoperfil']; // FOTO DE PERFIL USUARIOS
                $_SESSION['fotos_portadas']=$login['foto_portada']; // FOTO DE PORTADA GRANDE USUARIOS
                $_SESSION['pais_usuarios']=$login['pais']; // PAIS DE RESIDENDIE DE USUARIOS
                $_SESSION['comprobar_perfil']=$login['completarperfil']; // COMPROBACION DE PERFIL
                #print_r($login);   //-> EFECTOS DE PRUEBAS
                 /* IMPORTANTE:
                 *  SI VALOR ES 1 SIGNIFICA QUE ES UN USUARIO NUEVO Y LO OBLIGA A COMPLETAR SU PERFIL. 
                 * CASO CONTRARIO REDIRECCIONA AL INICIO DE NOTICIAS DE LA APLICACION */
                if($login['completarperfil']==1){
                    header('location:cRegistroNuevosUsuarios.php?nuevoregistro=completarperfil');
                }else if($login['completarperfil']==0){
                    header('location:../Feed/inicio');
                // SI COMPROBACION DE PERFIL FALLA, EVITA EL INGRESO AL SISTEMA
                }else{
                    require("../vista/iniciarsesion.php");
                } // CIERRE CONDICIONALES COMPROBACION DE PERFIL COMPLETADO
            }else{
                header('location:../CredencialesIncorrectas/error');
            } // CIERRE if($login)
        break;
        // CERRAR SESION
        case "cerrarsesion":
            session_unset();
            session_destroy();
            header('location:../index.php');
            $conectarsistema->close(); // CERRANDO CONEXION
        break;
        // REDIRECCION LUEGO DE COMPLETAR PERFIL DE USUARIO
        case "perfilcompletado":
            session_unset();
            session_destroy();
            header('location:../index.php');
            $conectarsistema->close(); // CERRANDO CONEXION
        break;
        // BLOQUEAR ACCIONES NO EXISTENTES
        default:
            $peticion_url=$_GET['noautorizado'];
            header('location:../AccesoDenegado=restringido');
            $conectarsistema->close(); // CERRANDO CONEXION
        break; 
    }
?>