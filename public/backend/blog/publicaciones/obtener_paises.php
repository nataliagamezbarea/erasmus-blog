<?php
// Iniciar sesión si no está iniciada aún
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Manejar cierre de sesión
if (isset($_GET['action']) && $_GET['action'] === 'logout') {
    session_destroy();
    // Redirigir al mismo script sin parámetros
    header("Location: " . strtok($_SERVER["REQUEST_URI"], '?'));
    exit;
}

// Configuración y conexión a la base de datos
require_once __DIR__ . '/../../config.php';

$conexion = new mysqli($servidor, $usuario, $contrasena, $base_de_datos);
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}
$conexion->set_charset("utf8");

// Obtener países para el dropdown
$paises = [];
$res = $conexion->query("SELECT nombre FROM paises ORDER BY nombre ASC");
if ($res) {
    while ($row = $res->fetch_assoc()) {
        $paises[] = $row['nombre'];
    }
    $res->free();
}

// Verificar si usuario está logueado y obtener su pais_id
$paisUsuarioId = null;
if (isset($_SESSION['id_usuario']) && !empty($_SESSION['id_usuario'])) {
    $stmt = $conexion->prepare("SELECT pais_id FROM usuarios WHERE id = ?");
    $stmt->bind_param("i", $_SESSION['id_usuario']);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($usuarioDatos = $result->fetch_assoc()) {
        $paisUsuarioId = $usuarioDatos['pais_id'] ?? null;
    }
    $stmt->close();
}

// Cerrar la conexión
$conexion->close();
