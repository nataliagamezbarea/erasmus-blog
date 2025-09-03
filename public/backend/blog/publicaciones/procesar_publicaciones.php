<?php
// Iniciar sesión si no está iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../../config.php';

// Usuario logueado y si es admin
$idUsuario = $_SESSION['id_usuario'] ?? null;
$esAdmin = $_SESSION['es_admin'] ?? 0;

// Conexión a la base de datos
$conexion = new mysqli($servidor, $usuario, $contrasena, $base_de_datos);
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}
$conexion->set_charset("utf8");

// Obtener información del usuario
$paisUsuarioId = null;
$paisUsuarioNombre = '';
if ($idUsuario) {
    $stmt = $conexion->prepare("
        SELECT u.pais_id, pa.nombre AS pais_nombre 
        FROM usuarios u
        LEFT JOIN paises pa ON u.pais_id = pa.id
        WHERE u.id = ?
    ");
    $stmt->bind_param("i", $idUsuario);
    $stmt->execute();
    $res = $stmt->get_result();
    if ($row = $res->fetch_assoc()) {
        $paisUsuarioId = $row['pais_id'];
        $paisUsuarioNombre = $row['pais_nombre'];
    }
    $stmt->close();
}

// Obtener lista de países (para admin)
$paises = [];
$stmt = $conexion->prepare("SELECT id, nombre FROM paises ORDER BY nombre ASC");
$stmt->execute();
$res = $stmt->get_result();
while ($row = $res->fetch_assoc()) {
    $paises[] = $row;
}
$stmt->close();

// Obtener publicaciones con likes
$paisSeleccionado = $_GET['pais'] ?? 'Todos';

if ($paisSeleccionado !== 'Todos') {
    $stmt = $conexion->prepare("
        SELECT p.*, u.nombre_usuario, pa.nombre AS pais_nombre,
               (SELECT COUNT(*) FROM likes l WHERE l.publicacion_id = p.id) AS num_likes
        FROM publicaciones p
        JOIN usuarios u ON p.usuario_id = u.id
        LEFT JOIN paises pa ON p.pais_id = pa.id
        WHERE pa.nombre = ?
        ORDER BY p.fecha_publicacion DESC, p.hora_publicacion DESC
    ");
    $stmt->bind_param("s", $paisSeleccionado);
} else {
    $stmt = $conexion->prepare("
        SELECT p.*, u.nombre_usuario, pa.nombre AS pais_nombre,
               (SELECT COUNT(*) FROM likes l WHERE l.publicacion_id = p.id) AS num_likes
        FROM publicaciones p
        JOIN usuarios u ON p.usuario_id = u.id
        LEFT JOIN paises pa ON p.pais_id = pa.id
        ORDER BY p.fecha_publicacion DESC, p.hora_publicacion DESC
    ");
}

$stmt->execute();
$publicaciones = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
$stmt->close();

// Obtener likes del usuario logueado
$likesUsuario = [];
if ($idUsuario) {
    $stmt = $conexion->prepare("SELECT publicacion_id FROM likes WHERE usuario_id = ?");
    $stmt->bind_param("i", $idUsuario);
    $stmt->execute();
    $res = $stmt->get_result();
    while ($row = $res->fetch_assoc()) {
        $likesUsuario[$row['publicacion_id']] = true;
    }
    $stmt->close();
}

$conexion->close();
