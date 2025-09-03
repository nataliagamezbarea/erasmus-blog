<?php
// Iniciar sesión
session_start();

// Array para pasar mensajes a la vista
$datosMensaje = [
    'mostrar' => false,
    'texto' => '',
    'tipo' => ''
];

// Función para actualizar el mensaje
function mostrarMensaje(&$datosMensaje, $texto, $tipo)
{
    $datosMensaje['mostrar'] = true;
    $datosMensaje['texto'] = $texto;
    $datosMensaje['tipo'] = $tipo;
}

// Procesar el formulario
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $nombre     = $_POST["fname"] ?? '';
    $apellidos  = $_POST["lname"] ?? '';
    $correo     = $_POST["email"] ?? '';
    $fecha      = $_POST["date"] ?? '';
    $mensaje    = $_POST["message"] ?? '';

    // Validación básica
    if (empty($nombre) || empty($apellidos) || empty($correo) || empty($fecha) || empty($mensaje)) {
        mostrarMensaje($datosMensaje, "Todos los campos son obligatorios.", "danger");
    } elseif (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
        mostrarMensaje($datosMensaje, "Correo electrónico no válido.", "danger");
    } else {
        // Guardar datos en la sesión
        $_SESSION['contacto'] = [
            'nombre' => $nombre,
            'apellidos' => $apellidos,
            'correo' => $correo,
            'fecha' => $fecha,
            'mensaje' => $mensaje
        ];

        // Establecer mensaje de éxito
        $_SESSION['mensaje'] = [
            'texto' => "Tu mensaje ha sido enviado correctamente. Te responderemos pronto.",
            'tipo' => 'success'
        ];

        header("Location: ../../fronted/Inicio/index.php");
        exit;
    }
} else {
    mostrarMensaje($datosMensaje, "No tienes permiso para acceder a esta página.", "warning");
}
