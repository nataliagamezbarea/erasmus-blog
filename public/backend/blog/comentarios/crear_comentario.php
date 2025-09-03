<?php
include __DIR__ . '/../../config.php';

$conn = new mysqli($servidor, $usuario, $contrasena, $base_de_datos);
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

$id_usuario = isset($_SESSION['id_usuario']) ? intval($_SESSION['id_usuario']) : null;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $id_usuario && !empty($_POST['comentario'])) {
    $comentario = $conn->real_escape_string($_POST['comentario']);
    $sql_insertar = "INSERT INTO comentarios (UsuarioID, TextoComentario) VALUES ($id_usuario, '$comentario')";

    if ($conn->query($sql_insertar)) {
        $_SESSION['mensaje_exito'] = "Comentario publicado correctamente.";
    } else {
        $_SESSION['mensaje_exito'] = "Error al publicar el comentario: " . $conn->error;
    }

    header("Location: ../../fronted/blog/comentarios.php");
    exit;
}
