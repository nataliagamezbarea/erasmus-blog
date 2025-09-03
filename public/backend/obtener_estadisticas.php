<?php

// Incluir configuración
require_once __DIR__ . "/../backend/config.php";

// Verificar sesión
if (!isset($_SESSION["id_usuario"])) {
    header("Location: ../../fronted/Registro_y_inicio_sesion/inicio_sesion.php");
    exit();
}

$id_usuario = $_SESSION["id_usuario"];

// Conexión a la base de datos
$conexion = new mysqli($servidor, $usuario, $contrasena, $base_de_datos);
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}
$conexion->set_charset("utf8");

// -------------------------
// Obtener datos del usuario
// -------------------------
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
    // Usuario no existe, cerrar sesión
    session_destroy();
    header("Location: ../../fronted/Registro_y_inicio_sesion/inicio_sesion.php");
    exit();
}
$stmt->close();

// -------------------------
// Obtener estadísticas
// -------------------------
function obtenerTotal($conexion, $tabla)
{
    $total = 0;
    $result = $conexion->query("SELECT COUNT(*) AS total FROM $tabla");
    if ($result) {
        $row = $result->fetch_assoc();
        $total = $row["total"];
    }
    return $total;
}

$totalPublicaciones = obtenerTotal($conexion, "publicaciones");
$totalLikes        = obtenerTotal($conexion, "likes");
$totalPaises       = obtenerTotal($conexion, "paises");
$totalUsuarios     = obtenerTotal($conexion, "usuarios");

// Usuario con más publicaciones
$usuarioMasPublicaciones = "";
$result = $conexion->query("
    SELECT u.nombre_usuario, COUNT(p.id) AS total_pub
    FROM usuarios u
    JOIN publicaciones p ON u.id = p.usuario_id
    GROUP BY u.id
    ORDER BY total_pub DESC
    LIMIT 1
");
if ($result && $result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $usuarioMasPublicaciones = $row["nombre_usuario"] . " (" . $row["total_pub"] . " publicaciones)";
}

// Top 5 países con más usuarios
$topPaises = [];
$res = $conexion->query("
    SELECT p.nombre AS pais, COUNT(u.id) AS cantidad
    FROM paises p
    LEFT JOIN usuarios u ON u.pais_id = p.id
    GROUP BY p.id
    ORDER BY cantidad DESC
    LIMIT 5
");
while ($row = $res->fetch_assoc()) {
    $porcentaje = $totalUsuarios > 0 ? round(($row["cantidad"] / $totalUsuarios) * 100) : 0;
    $topPaises[] = [
        "pais" => htmlspecialchars($row["pais"], ENT_QUOTES, "UTF-8"),
        "cantidad" => $row["cantidad"],
        "porcentaje" => $porcentaje
    ];
}

// Últimas 9 publicaciones
$ultimasPublicaciones = [];
$result = $conexion->query("
    SELECT titulo
    FROM publicaciones
    ORDER BY fecha_publicacion DESC, hora_publicacion DESC
    LIMIT 9
");
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $ultimasPublicaciones[] = htmlspecialchars($row["titulo"], ENT_QUOTES, "UTF-8");
    }
}


$seccion = isset($_GET['seccion']) ? $_GET['seccion'] : "inicio";

$seccionesDisponibles = [
    "inicio" => "secciones/dashboard.php",
    "informacion" => "secciones/informacion.php",
    "publicaciones" => "publicaciones/mostrar_publicaciones.php",
    "comentarios" => "secciones/comentarios.php",
    "likes" => "secciones/likes.php",
    "usuarios" => "secciones/usuarios.php",
];

$nombresSecciones = [
    "inicio" => "Inicio",
    "informacion" => "Información",
    "publicaciones" => "Publicaciones",
    "comentarios" => "Comentarios",
    "likes" => "Likes",
    "usuarios" => "Gestionar usuarios",
];

$archivoIncluir = isset($seccionesDisponibles[$seccion]) ? $seccionesDisponibles[$seccion] : "dashboard.php";
$nombreSeccionActual = isset($nombresSecciones[$seccion]) ? $nombresSecciones[$seccion] : "Inicio";

$conexion->close();
