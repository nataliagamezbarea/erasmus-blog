<?php
include __DIR__ . '/../../config.php';

$conn = new mysqli($servidor, $usuario, $contrasena, $base_de_datos);
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

$id_usuario = isset($_SESSION['id_usuario']) ? intval($_SESSION['id_usuario']) : null;
$es_admin = isset($_SESSION['es_admin']) ? intval($_SESSION['es_admin']) : 0;

$sql_comentarios = "
    SELECT c.IDComentario, c.TextoComentario, c.FechaComentario, c.UsuarioID, u.nombre_usuario 
    FROM comentarios c 
    JOIN usuarios u ON c.UsuarioID = u.id 
    ORDER BY c.FechaComentario DESC";

$resultado_comentarios = $conn->query($sql_comentarios);

// Mensaje de sesión
$mensaje_exito = '';
if (isset($_SESSION['mensaje_exito'])) {
    $mensaje_exito = $_SESSION['mensaje_exito'];
    unset($_SESSION['mensaje_exito']);
}
