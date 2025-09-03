<?php
session_start();
require_once '../../config.php';

// Solo usuarios logueados
if (!isset($_SESSION['id_usuario'])) {
    header('Location: index.php'); // o mostrar un error
    exit;
}

$idUsuario = $_SESSION['id_usuario'];
$publicacionId = $_POST['publicacion_id'] ?? null;

if (!$publicacionId) {
    header('Location: index.php');
    exit;
}

// Conexión a la base de datos
$conexion = new mysqli($servidor, $usuario, $contrasena, $base_de_datos);
if ($conexion->connect_error) die("Error de conexión: " . $conexion->connect_error);
$conexion->set_charset("utf8");

// Comprobar si ya existe like
$stmt = $conexion->prepare("SELECT id FROM likes WHERE usuario_id = ? AND publicacion_id = ?");
$stmt->bind_param("ii", $idUsuario, $publicacionId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // Si ya tiene like, eliminarlo (toggle)
    $stmtDel = $conexion->prepare("DELETE FROM likes WHERE usuario_id = ? AND publicacion_id = ?");
    $stmtDel->bind_param("ii", $idUsuario, $publicacionId);
    $stmtDel->execute();
    $stmtDel->close();
} else {
    // Si no tiene like, insertarlo
    $stmtIns = $conexion->prepare("INSERT INTO likes (usuario_id, publicacion_id) VALUES (?, ?)");
    $stmtIns->bind_param("ii", $idUsuario, $publicacionId);
    $stmtIns->execute();
    $stmtIns->close();
}

$stmt->close();
$conexion->close();

// Volver a la página anterior
$redirect = $_SERVER['HTTP_REFERER'] ?? 'index.php';
header("Location: $redirect");
exit;
?>
