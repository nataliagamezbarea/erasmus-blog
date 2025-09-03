<?php
include __DIR__ . '/../../config.php';

$conn = new mysqli($servidor, $usuario, $contrasena, $base_de_datos);
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

$id_usuario = isset($_SESSION['id_usuario']) ? intval($_SESSION['id_usuario']) : null;
$es_admin = isset($_SESSION['es_admin']) ? intval($_SESSION['es_admin']) : 0;

if (isset($_GET['delete']) && $id_usuario) {
    $idDelete = intval($_GET['delete']);

    if ($es_admin) {
        $stmt = $conn->prepare("DELETE FROM comentarios WHERE IDComentario=?");
        $stmt->bind_param("i", $idDelete);
    } else {
        $stmt = $conn->prepare("DELETE FROM comentarios WHERE IDComentario=? AND UsuarioID=?");
        $stmt->bind_param("ii", $idDelete, $id_usuario);
    }

    $stmt->execute();
    $stmt->close();

    $_SESSION['mensaje_exito'] = "Comentario eliminado correctamente.";
    header("Location: ../../fronted/blog/comentarios.php");
    exit;
}
