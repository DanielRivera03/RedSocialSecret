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
}// CIERRE class Eventos{
?>