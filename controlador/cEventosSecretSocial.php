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
require('../modelo/mModeloEventos.php');
// CREANDO INSTANCIA DE CLASE REFERENCIADA
$EventosSociales=new Eventos();
// SI PETICION DE USUARIO NO HA SIDO PROCESADA ENTONCES...
if(isset($_GET['eventos_sociales']))
{
    $peticion_url=$_GET['eventos_sociales'];  // ENVIO GET DE VALOR ACCION {URL}
}
// ASIGNA VALOR POR DEFECTO...
else
{
    $peticion_url="mostrareventos";  // CASO CONTRARIO, VALOR POR DEFECTO
} 
switch($peticion_url){
    // MOSTRAR LISTADO COMPLETO DE EVENTOS REGISTRADOS POR TODOS LOS USUARIOS
    // -> SE APLICA FILTRO POR PAIS -> SEGUN PAIS DE RESIDENCIA DE CADA USUARIO
    case "mostrareventos":
        $IdUsuarios = $_SESSION['id_usuario']; // ID UNICO DE USUARIO REGISTRADO
        $IdSolicitudAmigo = $_SESSION['id_usuario']; // ID USUARIO UNICO -> QUIEN RECIBE LAS SOLICITUDES
        $Pais = $_SESSION['pais_usuarios']; // PAIS DE RESIDENCIA DE USUARIOS REGISTRADOS
        // CONSULTAR SOLICITUDES DE AMISTAD RECIBIDAS
        $consulta=$EventosSociales->ConsultarSolicitudesAmistad($conectarsistema14,$IdSolicitudAmigo);
        // CONSULTAR NOTIFICACIONES AMIGOS ACEPTADOS -> TODOS LOS USUARIOS
        $consulta1=$EventosSociales->ConsultarNotificacionesAmigos($conectarsistema16,$IdUsuarios);
        // CONSULTAR TODOS LOS EVENTOS REGISTRADOS POR TODOS LOS USUARIOS
        $consulta2=$EventosSociales->ConsultarEventosRegistrados($conectarsistema,$Pais);
        // TODAS LAS CONSULTAS ANIDADAS EN UNA SOLA PAGINA
        require('../vista/listadoeventosregistrados.php');
        $conectarsistema->close(); // CERRANDO CONEXION
        $conectarsistema14->close(); // CIERRE DE CONEXION AUXILIAR 14
        $conectarsistema16->close(); // CIERRE DE CONEXION AUXILIAR 16
    break;
    // REGISTRO DE NUEVOS EVENTOS SOCIALES -> TODOS LOS USUARIOS {FORMULARIO}
    case "registrareventos":
        $IdUsuarios = $_SESSION['id_usuario']; // ID UNICO DE USUARIO REGISTRADO
        $IdSolicitudAmigo = $_SESSION['id_usuario']; // ID USUARIO UNICO -> QUIEN RECIBE LAS SOLICITUDES
        // CONSULTAR SOLICITUDES DE AMISTAD RECIBIDAS
        $consulta=$EventosSociales->ConsultarSolicitudesAmistad($conectarsistema14,$IdSolicitudAmigo);
        // CONSULTAR NOTIFICACIONES AMIGOS ACEPTADOS -> TODOS LOS USUARIOS
        $consulta1=$EventosSociales->ConsultarNotificacionesAmigos($conectarsistema16,$IdUsuarios);
        // TODAS LAS CONSULTAS ANIDADAS EN UNA SOLA PAGINA
        require('../vista/registrareventos.php');
        $conectarsistema->close(); // CERRANDO CONEXION
        $conectarsistema14->close(); // CIERRE DE CONEXION AUXILIAR 14
        $conectarsistema16->close(); // CIERRE DE CONEXION AUXILIAR 16
    break;
    //REGISTRO DE NUEVOS EVENTOS SOCIALES -> TODOS LOS USUARIOS {ENVIO A BASE DE DATOS}
    case "registrar-nuevo-evento":
        // VARIABLES
        $NombreEvento=$_POST['nombre_evento']; // NOMBRE DE EVENTO
        $DescripcionEvento=$_POST['descripcion_evento']; // DESCRIPCION DE EVENTO
        $DireccionEvento=$_POST['direccion_evento']; // DIRECCION COMPLETA DE EVENTO
        $UsuarioUnico=$_SESSION['usuario_unico']; // USUARIO UNICO QUE REGISTRA EVENTO
        // -> IMPORTANTE: AL REGISTRAR EVENTOS, LOS USUARIOS ACEPTAN INCONDICIONALMENTE QUE EL
        // EVENTO QUE REGISTREN UNICAMENTE SERA DISPONIBLE EN SU PAIS DE RESIDENCIA
        $Pais=$_SESSION['pais_usuarios']; // PAIS DE RESIDENCIA DE USUARIO QUE REGISTRA EVENTO
        $FechaInicio=date("Y-m-d H:i:s", strtotime($_POST["diainicio_evento"])); // DIA -> FECHA -> HORA INICIO DE EVENTO
        $FechaFin=date("Y-m-d H:i:s", strtotime($_POST["diafin_evento"])); // DIA -> FECHA -> HORA FINALIZACION DE EVENTO
        $FotoEvento=$_FILES['foto_evento']['name']; // FOTOGRAFIA ALUSIVA AL EVENTO
        $RutaDestino='../vista/images/fotoseventos/'.$FotoEvento; // DESTINO GUARDADO DE FOTOS
        $ExtensionFoto=$_FILES['foto_evento']['type']; // CAPTURA EL TIPO DE FOTO {EXTENSION}
        $IdUsuarios=$_SESSION['id_usuario']; // ID UNICO DE USUARIO QUE REGISTRA EVENTO
        // EVITAR INGRESO VACIO / NULO -> MAL INTENCIONADO
        if(empty($NombreEvento) && empty($DescripcionEvento) && empty($DireccionEvento) && empty($FechaInicio) && empty($FechaFin) && empty($FotoEvento)){
            header('location:../Feed/inicio');
        }else{
            $consulta=$EventosSociales->RegistrarNuevosEventos($conectarsistema,$NombreEvento,$DescripcionEvento,$DireccionEvento,$UsuarioUnico,$Pais,$FechaInicio,$FechaFin,$FotoEvento,$IdUsuarios);
            // COPIA ARCHIVO SUBIDO CON NOMBRE FINAL A LA RUTA ESTABLECIDA
            copy($_FILES['foto_evento']['tmp_name'],$RutaDestino);
            // ENVIANDO RESPUESTA A MODELO
            echo json_encode($consulta);
        }
        $conectarsistema->close(); // CERRANDO CONEXION
    break;
    // ELIMINAR EVENTOS SOCIALES REGISTRADOS
    case "eliminar-eventos":
        $IdEventos=$_GET['ideventosocial']; // ID UNICO DE EVENTO SOCIAL REGISTRADO
        if(empty($IdEventos)){

        }else{
            $consulta=$EventosSociales->EliminarEventosSociales($conectarsistema,$IdEventos);
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