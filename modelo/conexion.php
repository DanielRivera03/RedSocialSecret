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
class conexion{
	private $servidor="localhost"; // NOMBRE SERVIDOR
	private $usuario="root"; // USUARIO SERVIDOR
	private $clave=""; // CONTRASEÑA SERVIDOR (SI LO REQUIERE)
	private $base="secretbd"; // NOMBRE DE BASE DE DATOS
	public $establecerconexion; // VARIABLE PUBLICA DE CONEXION*/
	// DATOS DE CONECTIVIDAD BD -> SISTEMA
	public function setServidor($obteniendoservidor)
	{
		$this->servidor=$obteniendoservidor;
	}
	public function getServidor()
	{
		return $this->servidor;
	}

	// CONECTAR SISTEMA Y COMPROBACION DE CONEXION
	public function conectar($bd)
	{
		$miconexion=new mysqli($this->servidor,$this->usuario,$this->clave,$bd); 
		if($miconexion->connect_errno)
		{
			/*echo*/$mensaje="Lo sentimos, ha ocurrido un error de conexion".$miconexion->connect_error;
		}
		else
		{
			/*echo*/ $mensaje="Enhorabuena, conexion exitosa";
			$this->establecerconexion=$miconexion;
		}
		return $mensaje;
	}
	// INICIO DE SESION GENERAL [SIN ROLES DE USUARIOS]
	public function login($conectarsistema,$correo,$contrasenia)
	{
		$resultado=mysqli_query($conectarsistema,"CALL InicioSesion('$correo','$contrasenia');");
		return $resultado;
	}
}// CIERRE CLASE CONEXION

// CONECTAR SISTEMA CON BASE DE DATOS {CONEXION PRINCIPAL TODO EL SISTEMA}
$conectando=new conexion();
$conectando->conectar("secretbd");
$conectarsistema=$conectando->establecerconexion;

/*
	-> CONEXIONES AUXILIARES
		DADO A QUE MYSQL UNICAMENTE PUEDE HACER ¡UNA CONSULTA AL MISMO TIEMPO!
*/
// CONEXION UTILIZADA -> DETALLES PERFIL DE USUARIOS
$conectando=new conexion();
$conectando->conectar("secretbd");
$conectarsistema1=$conectando->establecerconexion;
// CONEXION UTILIZADA -> CONTADOR PUBLICACIONES PERFILES PROPIETARIOS
$conectando=new conexion();
$conectando->conectar("secretbd");
$conectarsistema2=$conectando->establecerconexion;
// CONEXION UTILIZADA -> MOSTRAR FOTOS SUBIDAS PERFILES PROPIETARIOS {MINIATURAS PRINCIPAL}
$conectando=new conexion();
$conectando->conectar("secretbd");
$conectarsistema3=$conectando->establecerconexion;
// CONEXION UTILIZADA -> MOSTRAR FOTOS SUBIDAS PERFILES PROPIETARIOS {SECCION MULTIMEDIA}
$conectando=new conexion();
$conectando->conectar("secretbd");
$conectarsistema4=$conectando->establecerconexion;
// CONEXION UTILIZADA -> MOSTRAR COMENTARIOS PUBLICACIONES {PERFILES PROPIETARIOS}
$conectando=new conexion();
$conectando->conectar("secretbd");
$conectarsistema5=$conectando->establecerconexion;
// CONEXION UTILIZADA -> MOSTRAR AMIGOS CONFIRMADOS {PERFILES PROPIETARIOS}
$conectando=new conexion();
$conectando->conectar("secretbd");
$conectarsistema6=$conectando->establecerconexion;
// CONEXION UTILIZADA -> MOSTRAR CONTADOR AMIGOS CONFIRMADOS {PERFILES PROPIETARIOS}
$conectando=new conexion();
$conectando->conectar("secretbd");
$conectarsistema7=$conectando->establecerconexion;
// CONEXION UTILIZADA -> MOSTRAR CONTADOR AMIGOS CONFIRMADOS SECUNDARIO {PERFILES PROPIETARIOS}
$conectando=new conexion();
$conectando->conectar("secretbd");
$conectarsistema8=$conectando->establecerconexion;
// CONEXION UTILIZADA -> MOSTRAR AMIGOS CONFIRMADOS {PERFILES PROPIETARIOS -> MENU SECUNDARIO PRINCIPAL}
$conectando=new conexion();
$conectando->conectar("secretbd");
$conectarsistema9=$conectando->establecerconexion;
// CONEXION UTILIZADA -> MOSTRAR CONTADOR AMIGOS CONFIRMADOS SECUNDARIO {PERFILES PROPIETARIOS}
$conectando=new conexion();
$conectando->conectar("secretbd");
$conectarsistema10=$conectando->establecerconexion;
// CONEXION UTILIZADA -> CONSULTAR DETALLES USUARIOS SOBRE MI -> TODOS LOS PERFILES REGISTRADOS
$conectando=new conexion();
$conectando->conectar("secretbd");
$conectarsistema11=$conectando->establecerconexion;
// CONEXION UTILIZADA -> CONTADOR DE COMENTARIOS -> TODAS LAS PUBLICACIONES
$conectando=new conexion();
$conectando->conectar("secretbd");
$conectarsistema12=$conectando->establecerconexion;
// CONEXION UTILIZADA -> CONSULTAR SOLICITUDES DE AMISTAD RECIBIDAS -> TODOS LOS USUARIOS
$conectando=new conexion();
$conectando->conectar("secretbd");
$conectarsistema14=$conectando->establecerconexion;
// CONEXION UTILIZADA -> CONTADOR SOLICITUDES DE AMISTAD RECIBIDAS -> TODOS LOS USUARIOS
$conectando=new conexion();
$conectando->conectar("secretbd");
$conectarsistema15=$conectando->establecerconexion;
// CONEXION UTILIZADA -> CONSULTAR NOTIFICACIONES AMIGOS -> TODOS LOS USUARIOS
$conectando=new conexion();
$conectando->conectar("secretbd");
$conectarsistema16=$conectando->establecerconexion;
// CONEXION UTILIZADA -> CONTADOR SOLICITUDES DE AMISTAD ACEPTADAS -> TODOS LOS USUARIOS
$conectando=new conexion();
$conectando->conectar("secretbd");
$conectarsistema17=$conectando->establecerconexion;
// CONEXION UTILIZADA -> VISTA COMPLETA NOTIFICACIONES -> CONSULTA COMPLETA DE SOLICITUDES DE AMISTAD PENDIENTES
$conectando=new conexion();
$conectando->conectar("secretbd");
$conectarsistema20=$conectando->establecerconexion;
// CONEXION UTILIZADA -> CONSULTAR SOLICITUDES DE AMISTAD RECIBIDAS -> TODOS LOS USUARIOS
// CONTROLADOR DE USUARIOS
$conectando=new conexion();
$conectando->conectar("secretbd");
$conectarsistema21=$conectando->establecerconexion;
// CONEXION UTILIZADA -> CONSULTAR NOTIFICACIONES AMIGOS -> TODOS LOS USUARIOS
// CONTROLADOR DE USUARIOS
$conectando=new conexion();
$conectando->conectar("secretbd");
$conectarsistema22=$conectando->establecerconexion;
?>
