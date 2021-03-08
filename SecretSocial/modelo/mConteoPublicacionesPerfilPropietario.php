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

    // CONTADORES EXCLUSIVOS PERFILES PROPIETARIOS
    /*
        -> PERFIL PROPIETARIO: CUANDO UN X USUARIO REGISTRADO REVISA SU PROPIO PERFIL 
        DE USUARIO.
    */
    function NumeroPublicacionesPerfilPropietario($conectarsistema2,$IdUsuarios){
        $resultado=mysqli_query($conectarsistema2,"CALL ContadorPublicacionesPerfilesPropietarios('".$IdUsuarios."');");
		if(mysqli_num_rows($resultado)>0){
			$ImpresionConteo=mysqli_num_rows($resultado);	
			return $ImpresionConteo;
		}else{
            $ImpresionConteo = 0;
            return $ImpresionConteo;
		}
    }
    // CONTADOR DE AMIGOS ACEPTADOS -> PERFILES PROPIETARIOS {PRINCIPAL}
    function NumeroAmigosPerfilPropietario($conectarsistema2,$IdUsuarios){
        $resultado=mysqli_query($conectarsistema2,"CALL ContadorAmigosPerfilPropietario('".$IdUsuarios."');");
		if(mysqli_num_rows($resultado)>0){
			$ImpresionConteo=mysqli_num_rows($resultado);	
			return $ImpresionConteo;
		}else{
            $ImpresionConteo = 0;
            return $ImpresionConteo;
		}
    }
     // CONTADOR DE AMIGOS ACEPTADOS -> PERFILES PROPIETARIOS {SECUNDARIO}
     function NumeroAmigosPerfilPropietarioSecundario($conectarsistema2,$IdUsuarios){
        $resultado=mysqli_query($conectarsistema2,"CALL ContadorAmigosPerfilPropietario('".$IdUsuarios."');");
		if(mysqli_num_rows($resultado)>0){
			$ImpresionConteo=mysqli_num_rows($resultado);	
			return $ImpresionConteo;
		}else{
            $ImpresionConteo = 0;
            return $ImpresionConteo;
		}
    }
    // CONTADOR DE AMIGOS ACEPTADOS -> PERFILES PROPIETARIOS {MENU SECUNDARIO PRINCIPAL}
    function NumeroAmigosPerfilPropietarioSecundarioPrincipal($conectarsistema2,$IdUsuarios){
        $resultado=mysqli_query($conectarsistema2,"CALL ContadorAmigosPerfilPropietario('".$IdUsuarios."');");
		if(mysqli_num_rows($resultado)>0){
			$ImpresionConteo=mysqli_num_rows($resultado);	
			return $ImpresionConteo;
		}else{
            $ImpresionConteo = 0;
            return $ImpresionConteo;
		}
    }
    // CONTADOR DE COMENTARIOS {TODOS LOS USUARIOS -> TODAS LAS PUBLICACIONES REGISTRADAS}
    function NumeroComentariosPublicaciones($conectarsistema2,$IdPublicacion){
        $resultado=mysqli_query($conectarsistema2,"CALL ContadorComentariosPublicaciones('".$IdPublicacion."');");
		if(mysqli_num_rows($resultado)>0){
			$ImpresionConteo=mysqli_num_rows($resultado);	
			return $ImpresionConteo;
		}else{
            $ImpresionConteo = 0;
            return $ImpresionConteo;
		}
    }
    // CONTADOR DE SOLICITUDES DE AMISTAD RECIBIDAS -> TODOS LOS USUARIOS
    function NumeroSolicitudesAmistadRecibidas($conectarsistema2,$IdSolicitudAmigo){
        $resultado=mysqli_query($conectarsistema2,"CALL ContadorSolicitudesAmistad('".$IdSolicitudAmigo."');");
		if(mysqli_num_rows($resultado)>0){
			$ImpresionConteo=mysqli_num_rows($resultado);	
			return $ImpresionConteo;
		}else{
            $ImpresionConteo = 0;
            return $ImpresionConteo;
		}
    }
    // CONTADOR DE SOLICITUDES DE AMISTAD RECIBIDAS -> TODOS LOS USUARIOS
    function NumeroSolicitudesAmistadAceptadas($conectarsistema2,$IdSolicitudAmigo){
        $resultado=mysqli_query($conectarsistema2,"CALL ContadorNotificacionesAmigos('".$IdSolicitudAmigo."');");
		if(mysqli_num_rows($resultado)>0){
			$ImpresionConteo=mysqli_num_rows($resultado);	
			return $ImpresionConteo;
		}else{
            $ImpresionConteo = 0;
            return $ImpresionConteo;
		}
    }
    // CONTADOR DE 'ME GUSTA' REALIZADOS POR LOS USUARIOS EN CADA UNA DE LAS PUBLICACIONES
    function ContadorMeGustaPublicaciones($conectarsistema2,$IdPublicacion){
        $resultado=mysqli_query($conectarsistema2,"CALL ConsultaReaccionesPublicaciones('".$IdPublicacion."');");
        $ObtenerResultado = mysqli_fetch_array($resultado); // SE OBTIENE EL ID QUE COINCIDA CON LA PETICION
         $Contador = $ObtenerResultado['megusta'];
        return $Contador; // DEVUELVE EL NUMERO DE ME GUSTA REALIZADOS POR LOS USUARIOS EN ESA PUBLICACION
    }
    // CONTADOR DE MENSAJES RECIBIBOS {CHAT GENERAL} -> TODOS LOS USUARIOS
    function ContadorMensajesChatGeneral($conectarsistema2){
        $resultado=mysqli_query($conectarsistema2,"CALL ConsultarMensajesRecibidos();");
		if(mysqli_num_rows($resultado)>0){
			$ImpresionConteo=mysqli_num_rows($resultado);	
			return $ImpresionConteo;
		}else{
            $ImpresionConteo = 0;
            return $ImpresionConteo;
		}
    }
    // CONTADOR DE 'ME GUSTA' REALIZADOS POR LOS USUARIOS EN CADA UNA DE LAS PUBLICACIONES
    function HoraUltimaActividadChatGeneral($conectarsistema2){
        $resultado=mysqli_query($conectarsistema2,"CALL ConsultarMensajesRecibidos();");
        $ObtenerResultado = mysqli_fetch_array($resultado); // SE OBTIENE EL ID QUE COINCIDA CON LA PETICION
         $ObtenerFecha = $ObtenerResultado['fechamensaje'];
        return $ObtenerFecha; // DEVUELVE LA FECHA COMPLETA PARA POSTERIORMENTE REALIZAR CONVERSION
    }
    // CONTADOR DE RESULTADOS DE BUSQUEDA -> BUSCADOR SECRET
    function ContadorResultadosBusqueda($conectarsistema2,$Busqueda){
        $resultado=mysqli_query($conectarsistema2,"CALL ConsultarBuscadorSecret('".$Busqueda."');");
		if(mysqli_num_rows($resultado)>0){
			$ImpresionConteo=mysqli_num_rows($resultado);	
			return $ImpresionConteo;
		}else{
            $ImpresionConteo = 0;
            return $ImpresionConteo;
		}
    }
?>