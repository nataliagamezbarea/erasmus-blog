<?php
require_once '../config.php';

// Array para pasar mensajes a la vista
$datosMensaje = [
    'mostrar' => false,
    'texto' => '',
    'tipo' => '',
    'urlRedireccion' => ''
];

// Función para actualizar el mensaje
function mostrarMensaje(&$datosMensaje, $texto, $tipo, $urlRedirigir = '')
{
    $datosMensaje['mostrar'] = true;
    $datosMensaje['texto'] = $texto;
    $datosMensaje['tipo'] = $tipo;
    $datosMensaje['urlRedireccion'] = $urlRedirigir;
}

// Conexión a la base de datos con PDO
try {
    $conexion = new PDO("mysql:host=$servidor;dbname=$base_de_datos;charset=utf8mb4", $usuario, $contrasena);
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error al conectar con la base de datos: " . $e->getMessage());
}

// Procesar formulario de registro
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nombreUsuario = $_POST['user'] ?? '';
    $correo = $_POST['email'] ?? '';
    $contrasena = $_POST['password'] ?? '';

    if (empty($nombreUsuario) || empty($correo) || empty($contrasena)) {
        mostrarMensaje($datosMensaje, "Todos los campos son obligatorios.", "danger", "registro_form.php");
    } else {
        // Verificar si el correo ya existe
        $consulta = $conexion->prepare("SELECT id FROM usuarios WHERE email = ?");
        $consulta->execute([$correo]);

        if ($consulta->rowCount() > 0) {
            mostrarMensaje($datosMensaje, "El correo ya está registrado.", "danger", "registro_form.php");
        } else {
            // Encriptar contraseña y registrar usuario
            $contrasenaEncriptada = password_hash($contrasena, PASSWORD_DEFAULT);
            $insercion = $conexion->prepare("INSERT INTO usuarios (nombre_usuario, email, password) VALUES (?, ?, ?)");
            $exito = $insercion->execute([$nombreUsuario, $correo, $contrasenaEncriptada]);

            if ($exito) {
                mostrarMensaje($datosMensaje, "¡Registro exitoso!", "success", "inicio_sesion.php");
            } else {
                mostrarMensaje($datosMensaje, "Error al registrar el usuario.", "danger", "registro.php");
            }
        }
    }
}

// Incluir la vista y pasar $datosMensaje
include("../../fronted/Registro_y_inicio_sesion/registro.php");
