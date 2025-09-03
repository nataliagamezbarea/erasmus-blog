<?php
require_once __DIR__ . '/../../../backend/config.php';

// --- Usuario logueado ---
$idUsuario = $_SESSION['id_usuario'] ?? null;
$esAdmin   = $_SESSION['es_admin'] ?? 0;

if (!$idUsuario) {
    $_SESSION['mensaje'] = "Debes iniciar sesión.";
    $_SESSION['mensaje_tipo'] = "danger";
    header("Location: mostrar_publicaciones.php");
    exit;
}

// --- Conexión ---
$conexion = new mysqli($servidor, $usuario, $contrasena, $base_de_datos);
$conexion->set_charset("utf8");

// --- Info del usuario y su país ---
$paisUsuarioId = null;
$paisUsuarioNombre = '';
$stmt = $conexion->prepare("
    SELECT u.pais_id, p.nombre AS pais_nombre
    FROM usuarios u
    LEFT JOIN paises p ON u.pais_id = p.id
    WHERE u.id = ?
");
$stmt->bind_param("i", $idUsuario);
$stmt->execute();
$result = $stmt->get_result();
$usuarioDatos = $result->fetch_assoc();
$paisUsuarioId     = $usuarioDatos['pais_id'] ?? null;
$paisUsuarioNombre = $usuarioDatos['pais_nombre'] ?? '';
$stmt->close();

// --- Lista de países solo si es admin ---
$paises = [];
if ($esAdmin) {
    $stmt = $conexion->prepare("SELECT id, nombre FROM paises ORDER BY nombre ASC");
    $stmt->execute();
    $res = $stmt->get_result();
    while ($row = $res->fetch_assoc()) {
        $paises[] = $row;
    }
    $stmt->close();
}

// --- Variables de edición ---
// Si hay $_GET['id'] cargamos la publicación a editar
$publicacion = null;
$idPublicacion = intval($_GET['id'] ?? 0);
if ($idPublicacion > 0) {
    $stmt = $conexion->prepare("SELECT * FROM publicaciones WHERE id = ?");
    $stmt->bind_param("i", $idPublicacion);
    $stmt->execute();
    $publicacion = $stmt->get_result()->fetch_assoc();
    $stmt->close();

    if (!$publicacion) {
        $_SESSION['mensaje'] = "Publicación no encontrada.";
        $_SESSION['mensaje_tipo'] = "danger";
        header("Location: mostrar_publicaciones.php");
        exit;
    }
}

$conexion->close();
