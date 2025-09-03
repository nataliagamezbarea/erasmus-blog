<?php


// Incluir config primero
require_once __DIR__ . '/../config.php';

// Incluir la obtención de países
include __DIR__ . '/publicaciones/obtener_paises.php';

// Verificar si usuario está logueado y obtener su pais_id
$paisUsuarioId = null;

$conexion = new mysqli($servidor, $usuario, $contrasena, $base_de_datos);
if ($conexion->connect_error) die("Error de conexión: " . $conexion->connect_error);
$conexion->set_charset("utf8");

if (!empty($_SESSION['id_usuario'])) {
    $stmt = $conexion->prepare("SELECT pais_id FROM usuarios WHERE id = ?");
    $stmt->bind_param("i", $_SESSION['id_usuario']);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($usuarioDatos = $result->fetch_assoc()) {
        $paisUsuarioId = $usuarioDatos['pais_id'] ?? null;
    }
    $stmt->close();
}

$conexion->close();
