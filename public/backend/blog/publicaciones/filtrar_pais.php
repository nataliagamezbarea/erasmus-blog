<?php
// --- Iniciar sesión si no está iniciada ---
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../../config.php';

// --- Manejo de logout (si viene por GET) ---
if (isset($_GET['action']) && $_GET['action'] === 'logout') {
    session_destroy();
    header("Location: mostrar_publicaciones.php");
    exit;
}

// Usuario logueado
$idUsuario = $_SESSION['id_usuario'] ?? null;
$paisUsuario = null;

// Conexión a la DB
$conexion = new mysqli($servidor, $usuario, $contrasena, $base_de_datos);
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}
$conexion->set_charset("utf8");

// Obtener país del usuario logueado
if ($idUsuario) {
    $stmt = $conexion->prepare("SELECT pais_id FROM usuarios WHERE id = ?");
    $stmt->bind_param("i", $idUsuario);
    $stmt->execute();
    $usuarioDatos = $stmt->get_result()->fetch_assoc();
    $paisUsuario = $usuarioDatos['pais_id'] ?? null;
    $stmt->close();
}

$conexion->close();

// País seleccionado por URL
$paisSeleccionado = $_GET['pais'] ?? null;
if ($paisSeleccionado) {
    $paisSeleccionado = trim(urldecode($paisSeleccionado));
}

// Lista fija de países (para el menú)
$paises = [
    "Dinamarca",
    "Finlandia",
    "Francia",
    "Irlanda",
    "Portugal",
    "Italia",
    "Malta",
    "República Checa",
    "Polonia",
    "Estonia"
];
