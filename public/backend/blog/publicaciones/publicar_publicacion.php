<?php
session_start();
require_once '../../config.php';

$idUsuario = $_SESSION['id_usuario'] ?? null;
$esAdmin = $_SESSION['es_admin'] ?? 0;

if (!$idUsuario) {
    $_SESSION['mensaje'] = "Debes iniciar sesión para publicar.";
    $_SESSION['mensaje_tipo'] = "danger";
    header("Location: ../../../fronted/blog/publicaciones/mostrar_publicaciones.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $titulo = trim($_POST['titulo'] ?? '');
    $descripcion = trim($_POST['descripcion'] ?? '');
    $fecha = date('Y-m-d');
    $hora = date('H:i:s');

    if (empty($titulo) || empty($descripcion)) {
        $_SESSION['mensaje'] = "Faltan campos obligatorios.";
        $_SESSION['mensaje_tipo'] = "danger";
        header("Location: ../../../fronted/blog/publicaciones/mostrar_publicaciones.php");
        exit;
    }

    // Carpeta para guardar imágenes (relativa al root del servidor)
    $carpetaDestino = '../../imagenes_erasmus/'; // sin __DIR__

    if (!is_dir($carpetaDestino)) {
        if (!mkdir($carpetaDestino, 0755, true)) {
            $_SESSION['mensaje'] = "No se pudo crear la carpeta para imágenes. Revisa permisos.";
            $_SESSION['mensaje_tipo'] = "danger";
            header("Location: ../../../fronted/blog/publicaciones/mostrar_publicaciones.php");
            exit;
        }
    }

    $ubicacion_imagen = null;
    if (isset($_FILES['ubicacion_imagen']) && $_FILES['ubicacion_imagen']['error'] === UPLOAD_ERR_OK) {
        $nombreArchivo = uniqid() . '_' . basename($_FILES['ubicacion_imagen']['name']);
        $rutaDestino = $carpetaDestino . $nombreArchivo;

        if (!move_uploaded_file($_FILES['ubicacion_imagen']['tmp_name'], $rutaDestino)) {
            $_SESSION['mensaje'] = "Error al subir la imagen. Revisa permisos de la carpeta.";
            $_SESSION['mensaje_tipo'] = "danger";
            header("Location: ../../../fronted/blog/publicaciones/mostrar_publicaciones.php");
            exit;
        }

        // Ruta relativa para el frontend
        $ubicacion_imagen = '/backend/imagenes_erasmus/' . $nombreArchivo;
    }

    // Conexión a la base de datos
    $conexion = new mysqli($servidor, $usuario, $contrasena, $base_de_datos);
    $conexion->set_charset("utf8");
    if ($conexion->connect_error) {
        $_SESSION['mensaje'] = "Error de conexión a la base de datos.";
        $_SESSION['mensaje_tipo'] = "danger";
        header("Location: ../../../fronted/blog/publicaciones/mostrar_publicaciones.php");
        exit;
    }

    // Determinar pais_id
    $pais_id = null;
    if ($esAdmin && isset($_POST['pais_id']) && $_POST['pais_id'] !== '') {
        $pais_id = $_POST['pais_id'];
    } else {
        $stmtPais = $conexion->prepare("SELECT pais_id FROM usuarios WHERE id = ?");
        $stmtPais->bind_param("i", $idUsuario);
        $stmtPais->execute();
        $resultPais = $stmtPais->get_result();
        $usuario = $resultPais->fetch_assoc();
        $pais_id = $usuario['pais_id'] ?? null;
        $stmtPais->close();
    }

    // Insertar publicación
    $stmt = $conexion->prepare("
        INSERT INTO publicaciones 
        (usuario_id, titulo, ubicacion_imagen, descripcion, pais_id, fecha_publicacion, hora_publicacion) 
        VALUES (?, ?, ?, ?, ?, ?, ?)
    ");
    $stmt->bind_param("isssiss", $idUsuario, $titulo, $ubicacion_imagen, $descripcion, $pais_id, $fecha, $hora);

    if ($stmt->execute()) {
        $_SESSION['mensaje'] = "Publicación realizada con éxito.";
        $_SESSION['mensaje_tipo'] = "success";
    } else {
        $_SESSION['mensaje'] = "Error al guardar la publicación: " . $stmt->error;
        $_SESSION['mensaje_tipo'] = "danger";
    }

    $stmt->close();
    $conexion->close();

    header("Location: ../../../fronted/blog/publicaciones/mostrar_publicaciones.php");
    exit;
}
