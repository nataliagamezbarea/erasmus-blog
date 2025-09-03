<?php
require_once '../config.php';

// Array para pasar mensajes a la vista
$datosMensaje = [
    'mostrar' => false,
    'texto' => '',
    'tipo' => ''
];

// Función para actualizar el mensaje
function mostrarMensaje(&$datosMensaje, $texto, $tipo) {
    $datosMensaje['mostrar'] = true;
    $datosMensaje['texto'] = $texto;
    $datosMensaje['tipo'] = $tipo;
}

// Crear conexión a la base de datos
$conexion = new mysqli($servidor, $usuario, $contrasena, $base_de_datos);

// Revisar conexión
if ($conexion->connect_error) {
    mostrarMensaje($datosMensaje, "Error al conectar con la base de datos: " . $conexion->connect_error, "danger");
} else {
    $correo = trim($_POST['gmail'] ?? '');
    $urlMailhog = "http://localhost:8025";

    if (empty($correo)) {
        mostrarMensaje($datosMensaje, "Por favor, ingresa un correo electrónico.", "info");
    } elseif (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
        mostrarMensaje($datosMensaje, "Correo electrónico no válido.", "info");
    } else {
        $stmt = $conexion->prepare("SELECT * FROM usuarios WHERE email = ?");
        $stmt->bind_param("s", $correo);
        $stmt->execute();
        $resultado = $stmt->get_result();

        if ($resultado->num_rows > 0) {
            // Generar código de verificación
            $codigo = substr(str_shuffle('0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, 6);

            $update = $conexion->prepare("UPDATE usuarios SET codigo_verificacion = ? WHERE email = ?");
            $update->bind_param("ss", $codigo, $correo);
            $update->execute();

            // Preparar correo
            $asunto = "Recuperación de cuenta - Código de verificación";
            $cuerpo = "Hola,\n\nTu código de verificación es: $codigo\n\nGracias.";
            $headers = "From: no-reply@miapp.test\r\n";

            if (mail($correo, $asunto, $cuerpo, $headers)) {
                mostrarMensaje($datosMensaje, "¡Correo enviado con éxito! Puedes revisar el correo en <a href='$urlMailhog' target='_blank' style='color: black; text-decoration: underline;'>MailHog</a>. Además, para insertar el código, accede <a href='/fronted/Registro_y_inicio_sesion/recuperar_contraseña.php' style='color: black; text-decoration: underline;'>aquí</a>.", "success");
            } else {
                mostrarMensaje($datosMensaje, "No fue posible enviar el correo. Por favor, verifica los datos e inténtalo nuevamente.", "danger");
            }

            $update->close();
        } else {
            mostrarMensaje($datosMensaje, "No existe un usuario registrado con ese correo electrónico.", "warning");
        }

        $stmt->close();
    }

    $conexion->close();
}

// Incluir la vista y pasar $datosMensaje
include("../../fronted/Registro_y_inicio_sesion/obtener_codigo.php");
