<?php
ob_start();
session_start();

// Incluir configuración
require_once "../../../backend/config.php";

// Verificar sesión
if (!isset($_SESSION["id_usuario"])) {
    header("Location: ../../../fronted/Registro_y_inicio_sesion/inicio_sesion.php");
    exit();
}

$id_usuario = $_SESSION["id_usuario"];

// Conexión a la base de datos
$conexion = new mysqli($servidor, $usuario, $contrasena, $base_de_datos);
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}
$conexion->set_charset("utf8");

// Obtener datos del usuario actual
$stmt = $conexion->prepare("SELECT nombre_usuario, email, es_admin FROM usuarios WHERE id = ?");
$stmt->bind_param("i", $id_usuario);
$stmt->execute();
$result = $stmt->get_result();

$nombre_usuario_actual = "";
$email_usuario_actual = "";
$rol_usuario = "";

if ($result && $result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $nombre_usuario_actual = $row["nombre_usuario"];
    $email_usuario_actual = $row["email"];
    $rol_usuario = $row["es_admin"] == 1 ? "Administrador" : "Usuario";
} else {
    session_destroy();
    header("Location: ../../../fronted/Registro_y_inicio_sesion/inicio_sesion.php");
    exit();
}
$stmt->close();
$conexion->close();

// Determinar sección actual
$seccion = isset($_GET['seccion']) ? $_GET['seccion'] : "inicio";

// Mapear secciones a archivos
$seccionesDisponibles = [
    "inicio" => "secciones/dashboard.php",
    "informacion" => "secciones/informacion.php",
    "publicaciones" => "publicaciones/mostrar_publicaciones.php",
    "comentarios" => "secciones/comentarios.php",
    "likes" => "secciones/likes.php",
    "usuarios" => "secciones/usuarios.php",
];

// Mapear secciones a nombres bonitos
$nombresSecciones = [
    "inicio" => "Inicio",
    "informacion" => "Información",
    "publicaciones" => "Publicaciones",
    "comentarios" => "Comentarios",
    "likes" => "Likes",
    "usuarios" => "Gestionar usuarios",
];

// Verificar si existe la sección
$archivoIncluir = isset($seccionesDisponibles[$seccion]) ? $seccionesDisponibles[$seccion] : "dashboard.php";
$nombreSeccionActual = isset($nombresSecciones[$seccion]) ? $nombresSecciones[$seccion] : "Inicio";
