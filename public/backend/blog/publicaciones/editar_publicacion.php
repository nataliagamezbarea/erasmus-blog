<?php
require_once __DIR__ . '/../../config.php';  // ✅ con __DIR__

$idUsuario = $_SESSION['id_usuario'] ?? null;
$esAdmin   = $_SESSION['es_admin'] ?? 0;

if (!$idUsuario) {
    $_SESSION['mensaje'] = "Debes iniciar sesión para editar.";
    $_SESSION['mensaje_tipo'] = "danger";
    header("Location: ../../../fronted/blog/publicaciones/mostrar_publicaciones.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idPublicacion = intval($_POST['id_publicacion'] ?? 0);
    $titulo        = trim($_POST['titulo'] ?? '');
    $descripcion   = trim($_POST['descripcion'] ?? '');

    if (empty($idPublicacion) || empty($titulo) || empty($descripcion)) {
        $_SESSION['mensaje'] = "Todos los campos obligatorios deben completarse.";
        $_SESSION['mensaje_tipo'] = "danger";
        header("Location: ../../../fronted/blog/publicaciones/mostrar_publicaciones.php");
        exit;
    }

    // Carpeta absoluta para imágenes
    $carpetaDestino = __DIR__ . '/../../imagenes_erasmus/';
    if (!is_dir($carpetaDestino)) {
        if (!mkdir($carpetaDestino, 0755, true)) {
            $_SESSION['mensaje'] = "No se pudo crear la carpeta de imágenes. Revisa permisos.";
            $_SESSION['mensaje_tipo'] = "danger";
            header("Location: ../../../fronted/blog/publicaciones/mostrar_publicaciones.php");
            exit;
        }
    }

    $ubicacion_imagen = null;
    if (isset($_FILES['ubicacion_imagen']) && $_FILES['ubicacion_imagen']['error'] === UPLOAD_ERR_OK) {
        $nombreArchivo = uniqid() . '_' . basename($_FILES['ubicacion_imagen']['name']);
        $rutaDestino   = $carpetaDestino . $nombreArchivo;

        if (!move_uploaded_file($_FILES['ubicacion_imagen']['tmp_name'], $rutaDestino)) {
            $_SESSION['mensaje'] = "Error al subir la imagen.";
            $_SESSION['mensaje_tipo'] = "danger";
            header("Location: ../../../fronted/blog/publicaciones/mostrar_publicaciones.php");
            exit;
        }

        // Guardamos la ruta relativa que usará el frontend
        $ubicacion_imagen = '/backend/imagenes_erasmus/' . $nombreArchivo;
    }

    // Conexión
    $conexion = new mysqli($servidor, $usuario, $contrasena, $base_de_datos);
    $conexion->set_charset("utf8");
    if ($conexion->connect_error) {
        $_SESSION['mensaje'] = "Error de conexión.";
        $_SESSION['mensaje_tipo'] = "danger";
        header("Location: ../../../fronted/blog/publicaciones/mostrar_publicaciones.php");
        exit;
    }

    // Validar si el usuario puede editar
    if (!$esAdmin) {
        $stmtCheck = $conexion->prepare("SELECT usuario_id FROM publicaciones WHERE id = ?");
        $stmtCheck->bind_param("i", $idPublicacion);
        $stmtCheck->execute();
        $resultado = $stmtCheck->get_result()->fetch_assoc();
        $stmtCheck->close();

        if (!$resultado || $resultado['usuario_id'] != $idUsuario) {
            $_SESSION['mensaje'] = "No tienes permiso para editar esta publicación.";
            $_SESSION['mensaje_tipo'] = "danger";
            header("Location: ../../../fronted/blog/publicaciones/mostrar_publicaciones.php");
            exit;
        }
    }

    // Actualizar
    if ($ubicacion_imagen) {
        $stmt = $conexion->prepare("UPDATE publicaciones SET titulo = ?, descripcion = ?, ubicacion_imagen = ? WHERE id = ?");
        $stmt->bind_param("sssi", $titulo, $descripcion, $ubicacion_imagen, $idPublicacion);
    } else {
        $stmt = $conexion->prepare("UPDATE publicaciones SET titulo = ?, descripcion = ? WHERE id = ?");
        $stmt->bind_param("ssi", $titulo, $descripcion, $idPublicacion);
    }

    if ($stmt->execute()) {
        $_SESSION['mensaje'] = "Publicación editada con éxito.";
        $_SESSION['mensaje_tipo'] = "success";
    } else {
        $_SESSION['mensaje'] = "Error al editar publicación: " . $stmt->error;
        $_SESSION['mensaje_tipo'] = "danger";
    }

    $stmt->close();
    $conexion->close();

    header("Location: ../../../fronted/blog/publicaciones/mostrar_publicaciones.php");
    exit;
}
