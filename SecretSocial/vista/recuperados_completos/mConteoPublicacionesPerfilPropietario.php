"<?php
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

    // Función auxiliar para vaciar resultados adicionales de Stored Procedures
    function LimpiarConexion($conexion) {
        if ($conexion) {
            while (mysqli_more_results($conexion) && mysqli_next_result($conexion)) {
                $extra = mysqli_use_result($conexion);
                if ($extra instanceof mysqli_result) {
                    mysqli_free_result($extra);
                }
            }
        }
    }

    // CONTADORES EXCLUSIVOS PERFILES PROPIETARIOS
    /*
        -> PERFIL PROPIETARIO: CUANDO UN X USUARIO REGISTRADO REVISA SU PROPIO PERFIL 
        DE USUARIO.
    */
    function NumeroPublicacionesPerfilPropietario($conectarsistema2,$IdUsuarios){
        $resultado=mysqli_query($conectarsistema2,"CALL ContadorPublicacionesPerfilesPropietarios('".$IdUsuarios."');");
        $ImpresionConteo = 0;
\t\tif($resultado && mysqli_num_rows($resultado)>0){
\t\t\t$ImpresionConteo=mysqli_num_rows($resultado);\t
            mysqli_free_result($resultado);
\t\t}
        LimpiarConexion($conectarsistema2);
        return $ImpresionConteo;
    }
    // CONTADOR DE AMIGOS ACEPTADOS -> PERFILES PROPIETARIOS {PRINCIPAL}
    function NumeroAmigosPerfilPropietario($conectarsistema2,$IdUsuarios){
        $resultado=mysqli_query($conectarsistema2,"CALL ContadorAmigosPerfilPropietario('".$IdUsuarios."');");
        $ImpresionConteo = 0;
\t\tif($resultado && mysqli_num_rows($resultado)>0){
\t\t\t$ImpresionConteo=mysqli_num_rows($resultado);\t
            my
<truncated 5949 bytes>