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
class Eventos{
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
    // REGISTRO DE NUEVOS EVENTOS SOCIALES -> TODOS LOS USUARIOS 
    public function RegistrarNuevosEventos($conectarsistema,$NombreEvento,$DescripcionEvento,$DireccionEvento,$UsuarioUnico,$Pais,$FechaInicio,$FechaFin,$FotoEvento,$IdUsuarios){
        // LLAMADO DE RUTINA CON PASE DE PARAMETROS
        $resultado=mysqli_query($conectarsistema,"CALL RegistroNuevosEventosSociales('".$NombreEvento."','".$DescripcionEvento."','".$DireccionEvento."','".$UsuarioUnico."','".$Pais."','".$FechaInicio."','".$FechaFin."','".$FotoEvento."','".$IdUsuarios."');");
        if($resultado){
            return "OK";
        }else{
            return "Error: Lo sentimos ha ocurrido un error inesperado. Intenta más tarde...";
        }
    }
    // CONSULTAR EVENTOS REGISTRADOS -> FILTRADOS POR PAIS DE RESIDENCIA USUARIOS
    public function ConsultarEventosRegistrados($conectarsistema25,$Pais){
        $resultado=mysqli_query($conectarsistema25,"CALL ConsultarEventosRegistrados('".$Pais."');");
        return $resultado;
    }
    // FUNCION PARA ELIMINAR DEFINITIVAMENTE EVENTOS SOCIALES REGISTRADOS
    public function EliminarEventosSociales($conectarsistema,$IdEventos){
        $resultado=mysqli_query($conectarsistema,"CALL BorrarEventosSociales('".$IdEventos."');");
        if($resultado){
            return "OK";
        }else{
            return "Error: Lo sentimos ha ocurrido un error inesperado. Intenta más tarde...";
        }
        return $resultado;
    }
    // REGISTRAR O ACTUALIZAR ASISTENCIA A EVENTO
    public function RegistrarAsistenciaEvento($conectarsistema,$IdEvento,$IdUsuario,$Estado){
        $safeIdEvento = mysqli_real_escape_string($conectarsistema, $IdEvento);
        $safeIdUsuario = mysqli_real_escape_string($conectarsistema, $IdUsuario);
        $safeEstado = mysqli_real_escape_string($conectarsistema, $Estado);
        $resultado = mysqli_query($conectarsistema, "INSERT INTO asistencia_eventos (idevento, id_usuario, estado) VALUES ('$safeIdEvento', '$safeIdUsuario', '$safeEstado') ON DUPLICATE KEY UPDATE estado = '$safeEstado'");
        if($resultado){
            return "OK";
        }else{
            return "Error: Lo sentimos ha ocurrido un error inesperado. Intenta más tarde...";
        }
    }

    // OBTENER ASISTENCIA ACTUAL DE UN USUARIO PARA UN EVENTO
    public function ObtenerAsistenciaUsuario($conectarsistema,$IdEvento,$IdUsuario){
        $safeIdEvento = mysqli_real_escape_string($conectarsistema, $IdEvento);
        $safeIdUsuario = mysqli_real_escape_string($conectarsistema, $IdUsuario);
        $resultado = mysqli_query($conectarsistema, "SELECT estado FROM asistencia_eventos WHERE idevento = '$safeIdEvento' AND id_usuario = '$safeIdUsuario' LIMIT 1");
        if($resultado && mysqli_num_rows($resultado) > 0) {
            $row = mysqli_fetch_assoc($resultado);
            return $row['estado'];
        }
        return "";
    }

    // CONTAR RESPUESTAS DE ASISTENCIA A UN EVENTO
    public function ContarAsistenciaEvento($conectarsistema,$IdEvento,$Estado){
        $safeIdEvento = mysqli_real_escape_string($conectarsistema, $IdEvento);
        $safeEstado = mysqli_real_escape_string($conectarsistema, $Estado);
        $resultado = mysqli_query($conectarsistema, "SELECT COUNT(*) as total FROM asistencia_eventos WHERE idevento = '$safeIdEvento' AND estado = '$safeEstado'");
        if($resultado) {
            $row = mysqli_fetch_assoc($resultado);
            return intval($row['total']);
        }
        return 0;
    }
}// CIERRE class Eventos{
?>