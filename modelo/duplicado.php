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

    // IMPORTANDO ARCHIVO DE CONEXION
    require("conexion.php");
    /*
        --> CONSULTA DUPLICADOS NOMBRES DE USUARIO UNICOS
    */
    // EVITAR CONSULTAS USUARIOS VACIOS
    if(!empty($_POST["nombre_usuariounico"])) {
        $resultado=mysqli_query($conectarsistema,"CALL ConsultarDisponibilidadUsuario('".$_POST["nombre_usuariounico"] ."');");
        // LEER COINCIDENCIAS DE USUARIOS SEGUN INGRESADO EN CAJA DE TEXTO
        $usuario_encontrado = mysqli_num_rows($resultado); // CONTADOR DE BUSQUEDA
        if($usuario_encontrado>0) { // USUARIO EXISTENTE
            // ESTADO = 1 -> USUARIO SI EXISTE
            $UsuarioNoDisponible = "<span class='nodisponible'><i class='ri-error-warning-fill'></i> Lo sentimos, usuario no disponible. Inténte con otro.</span>";
            echo $UsuarioNoDisponible;
        }else{ // USUARIO NO EXISTENTE
             // ESTADO = 0 -> USUARIO NO EXISTE
            $UsuarioDisponible="<span class='disponible'><i class='ri-checkbox-fill'></i> Enhorabuena, usuario disponible</span>";
            echo $UsuarioDisponible;
        }
    }
?>