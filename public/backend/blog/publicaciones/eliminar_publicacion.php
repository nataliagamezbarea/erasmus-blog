<?php
session_start();
require '../../config.php'; // Ajusta la ruta

if (!isset($_POST['publicacion_id'])) {
    header("Location: " . ($_SERVER['HTTP_REFERER'] ?? "/"));
    exit;
}

$publicacion_id = intval($_POST['publicacion_id']);

$conexion = new mysqli($servidor, $usuario, $contrasena, $base_de_datos);
if ($conexion->connect_error) {
    header("Location: " . ($_SERVER['HTTP_REFERER'] ?? "/"));
    exit;
}

// Obtener la ruta de la imagen
$stmt = $conexion->prepare("SELECT ubicacion_imagen FROM publicaciones WHERE id = ?");
$stmt->bind_param("i", $publicacion_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    $stmt->close();
    $conexion->close();
    header("Location: " . ($_SERVER['HTTP_REFERER'] ?? "/"));
    exit;
}

$row = $result->fetch_assoc();
$ruta_imagen = $row['ubicacion_imagen'];
if ($ruta_imagen && file_exists($ruta_imagen)) {
    unlink($ruta_imagen);
}
$stmt->close();

// Eliminar la publicación
$stmt = $conexion->prepare("DELETE FROM publicaciones WHERE id = ?");
$stmt->bind_param("i", $publicacion_id);
$stmt->execute();
$stmt->close();
$conexion->close();

// Redirigir de vuelta a la página de origen
header("Location: " . ($_SERVER['HTTP_REFERER'] ?? "/"));
exit;
