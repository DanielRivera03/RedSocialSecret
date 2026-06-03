<?php 
/*
--------------------------------------------------------
║            SECRET - RED SOCIAL PHP NATIVO            ║
--------------------------------------------------------           
    AUTOR: DANIEL RIVERA (danielrivera03)
    [Refactorizado para optimización de conexiones]
--------------------------------------------------------
*/ 
class conexion {
    private static $instancia = null;
    private $miconexion;
    
    private $servidor = "localhost";
    private $usuario = "root";
    private $clave = "";
    private $base = "secretbd";
    
    public $establecerconexion; // Para retrocompatibilidad

    private function __construct() {
        $this->miconexion = new mysqli($this->servidor, $this->usuario, $this->clave, $this->base);
        if ($this->miconexion->connect_errno) {
            die("Lo sentimos, ha ocurrido un error de conexion: " . $this->miconexion->connect_error);
        }
        $this->miconexion->set_charset("utf8mb4");
        $this->establecerconexion = $this->miconexion;
    }

    public static function getInstancia() {
        if (self::$instancia == null) {
            self::$instancia = new conexion();
        }
        return self::$instancia;
    }

    public function getConexion() {
        return $this->miconexion;
    }

    // Mantener para compatibilidad hacia atrás por si se llama desde otro lado
    public function conectar($bd) {
        return "Conexion exitosa";
    }

    public function setServidor($obteniendoservidor) {
        $this->servidor = $obteniendoservidor;
    }

    public function getServidor() {
        return $this->servidor;
    }

    // INICIO DE SESION GENERAL
    public function login($conectarsistema, $correo, $contrasenia) {
        $resultado = mysqli_query($conectarsistema, "CALL InicioSesion('$correo','$contrasenia');");
        return $resultado;
    }
}

function crearNuevaConexion() {
    $servidor = "localhost";
    $usuario = "root";
    $clave = "";
    $base = "secretbd";
    $conn = new mysqli($servidor, $usuario, $clave, $base);
    if ($conn->connect_errno) {
        die("Lo sentimos, ha ocurrido un error de conexion: " . $conn->connect_error);
    }
    $conn->set_charset("utf8mb4");
    return $conn;
}

$conectarsistema   = crearNuevaConexion();
$conectarsistema1  = crearNuevaConexion();
$conectarsistema2  = crearNuevaConexion();
$conectarsistema3  = crearNuevaConexion();
$conectarsistema4  = crearNuevaConexion();
$conectarsistema5  = crearNuevaConexion();
$conectarsistema6  = crearNuevaConexion();
$conectarsistema7  = crearNuevaConexion();
$conectarsistema8  = crearNuevaConexion();
$conectarsistema9  = crearNuevaConexion();
$conectarsistema10 = crearNuevaConexion();
$conectarsistema11 = crearNuevaConexion();
$conectarsistema12 = crearNuevaConexion();
$conectarsistema14 = crearNuevaConexion();
$conectarsistema15 = crearNuevaConexion();
$conectarsistema16 = crearNuevaConexion();
$conectarsistema17 = crearNuevaConexion();
$conectarsistema20 = crearNuevaConexion();
$conectarsistema21 = crearNuevaConexion();
$conectarsistema22 = crearNuevaConexion();

// ============================================================
// CONCURRENCIA DE SESIONES: CONFIGURACIÓN Y FIREWALL GLOBAL
// ============================================================

// Asegurarse de que la tabla 'sesiones_activas' exista
$conectarsistema->query("CREATE TABLE IF NOT EXISTS sesiones_activas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL,
    session_id VARCHAR(128) NOT NULL,
    ip_address VARCHAR(45) NOT NULL,
    user_agent VARCHAR(255) NOT NULL,
    ultimo_acceso TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_usuario (usuario_id),
    INDEX idx_session (session_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");

// Asegurarse de que la tabla 'usuarios' tenga las columnas de cierre remoto
$conectarsistema->query("ALTER TABLE usuarios 
    ADD COLUMN IF NOT EXISTS token_cierre_sesion VARCHAR(64) NULL,
    ADD COLUMN IF NOT EXISTS fecha_token_cierre DATETIME NULL
");

// Check and add columns to 'publicaciones'
$check_fondo = $conectarsistema->query("SHOW COLUMNS FROM publicaciones LIKE 'fondo_gradiente'");
if ($check_fondo && $check_fondo->num_rows == 0) {
    $conectarsistema->query("ALTER TABLE publicaciones ADD COLUMN fondo_gradiente VARCHAR(255) NULL");
}
$check_sentimiento = $conectarsistema->query("SHOW COLUMNS FROM publicaciones LIKE 'sentimiento'");
if ($check_sentimiento && $check_sentimiento->num_rows == 0) {
    $conectarsistema->query("ALTER TABLE publicaciones ADD COLUMN sentimiento VARCHAR(100) NULL");
}

// Asegurarse de que la tabla 'historias_epimeras' exista
$conectarsistema->query("CREATE TABLE IF NOT EXISTS historias_epimeras (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL,
    multimedia VARCHAR(255) NOT NULL,
    tipo VARCHAR(20) NOT NULL,
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_usuario_hist (usuario_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");

// Asegurarse de que las tablas de Reels existan
$conectarsistema->query("CREATE TABLE IF NOT EXISTS reels (
    idvideos INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL,
    video VARCHAR(255) NOT NULL,
    titulo_video VARCHAR(255) NOT NULL,
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_usuario_reels (usuario_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");

$conectarsistema->query("CREATE TABLE IF NOT EXISTS reels_likes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL,
    reel_id INT NOT NULL,
    fecha TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    UNIQUE KEY unique_user_reel (usuario_id, reel_id),
    INDEX idx_reel (reel_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");

// Alter publications table to allow up to 1500 chars for multiple photos
$conectarsistema->query("ALTER TABLE publicaciones MODIFY COLUMN foto_publicacion VARCHAR(1500) NOT NULL");

// Recreate RegistrarPublicacionesNuevas stored procedure with VARCHAR(1500)
$conectarsistema->query("DROP PROCEDURE IF EXISTS RegistrarPublicacionesNuevas");
$conectarsistema->query("CREATE PROCEDURE RegistrarPublicacionesNuevas (
    IN _mensaje_publicacion VARCHAR(150),
    IN _foto_publicacion VARCHAR(1500),
    IN _id INT
)
BEGIN
    INSERT INTO publicaciones (mensaje_publicacion, foto_publicacion, id)
    VALUES (_mensaje_publicacion, _foto_publicacion, _id);
END");


// Firewall de sesión única global
$isLoginAction = (isset($_GET['validarsesion']) && (
    $_GET['validarsesion'] === 'validar' || 
    $_GET['validarsesion'] === 'cerrar_sesiones_token' || 
    $_GET['validarsesion'] === 'forzar_login' || 
    $_GET['validarsesion'] === 'cerrarsesion' ||
    $_GET['validarsesion'] === 'check_session'
));

if (!$isLoginAction && session_status() === PHP_SESSION_ACTIVE && isset($_SESSION['id_usuario'])) {
    $userId_sec = (int)$_SESSION['id_usuario'];
    $sessId_sec = $conectarsistema->real_escape_string(session_id());
    
    // Comprobar si el session_id actual del usuario está en sesiones_activas
    $checkSess_sec = $conectarsistema->query("SELECT id FROM sesiones_activas WHERE usuario_id = $userId_sec AND session_id = '$sessId_sec'");
    if (!$checkSess_sec || $checkSess_sec->num_rows == 0) {
        // La sesión no es válida (fue cerrada por otro login)
        session_unset();
        session_destroy();
        
        // Redirigir al inicio de sesión con aviso
        $scriptName = $_SERVER['SCRIPT_NAME'];
        if (strpos($scriptName, '/controlador/') !== false) {
            header('location:../IniciarSesion/inicio?sesion_cerrada=1');
        } else {
            header('location:IniciarSesion/inicio?sesion_cerrada=1');
        }
        exit();
    } else {
        // Actualizar último acceso para mantener la sesión viva
        $conectarsistema->query("UPDATE sesiones_activas SET ultimo_acceso = NOW() WHERE usuario_id = $userId_sec AND session_id = '$sessId_sec'");
    }
}
?>
