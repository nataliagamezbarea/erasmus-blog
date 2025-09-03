<?php
// Configuración y conexión a la base de datos
require_once __DIR__ . '/../../config.php';

$conexion = new mysqli($servidor, $usuario, $contrasena, $base_de_datos);
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}
$conexion->set_charset("utf8");

// Obtener países para el dropdown
$paises = [];
$res = $conexion->query("SELECT nombre FROM paises ORDER BY nombre ASC");
if ($res) {
    while ($row = $res->fetch_assoc()) {
        $paises[] = $row['nombre'];
    }
    $res->free();
}

// Cerrar la conexión
$conexion->close();
