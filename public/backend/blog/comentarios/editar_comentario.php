<?php
include __DIR__ . '/../../config.php';

$conn = new mysqli($servidor, $usuario, $contrasena, $base_de_datos);
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

$id_usuario = isset($_SESSION['id_usuario']) ? intval($_SESSION['id_usuario']) : null;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $id_usuario && isset($_POST['id_comentario']) && isset($_POST['editar_comentario'])) {
    $idEdit = intval($_POST['id_comentario']);
    $nuevoTexto = $conn->real_escape_string($_POST['editar_comentario']);

    // Solo permite editar si el usuario es dueño del comentario
    $stmt = $conn->prepare("UPDATE comentarios SET TextoComentario=? WHERE IDComentario=? AND UsuarioID=?");
    $stmt->bind_param("sii", $nuevoTexto, $idEdit, $id_usuario);
    $stmt->execute();
    $stmt->close();

    $_SESSION['mensaje_exito'] = "Comentario editado correctamente.";
    header("Location: ../../fronted/blog/comentarios.php");
    exit;
}
