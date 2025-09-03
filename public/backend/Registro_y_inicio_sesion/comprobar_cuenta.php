<?php
require_once '../config.php';

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

// Conexión a la base de datos con PDO
try {
    $conexion = new PDO("mysql:host=$servidor;dbname=$base_de_datos;charset=utf8mb4", $usuario, $contrasena);
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error al conectar con la base de datos: " . $e->getMessage());
}

// Procesar el formulario de inicio de sesión
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $correo = $_POST['email'] ?? '';
    $contrasena = $_POST['password'] ?? '';

    if (empty($correo) || empty($contrasena)) {
        mostrarMensaje($datosMensaje, "Todos los campos son obligatorios.", "danger");
    } else {
        $consulta = $conexion->prepare("SELECT id, password, es_admin FROM usuarios WHERE email = ?");
        $consulta->execute([$correo]);

        if ($consulta->rowCount() === 0) {
            mostrarMensaje($datosMensaje, "Usuario o contraseña incorrectos.", "danger");
        } else {
            $usuario = $consulta->fetch(PDO::FETCH_ASSOC);
            if (!password_verify($contrasena, $usuario['password'])) {
                mostrarMensaje($datosMensaje, "Usuario o contraseña incorrectos.", "danger");
            } else {
                // Inicio de sesión exitoso
                session_start();
                $_SESSION['id_usuario'] = $usuario['id'];
                $_SESSION['es_admin'] = $usuario['es_admin']; // Guardamos si es admin

                // Redirigir según tipo de usuario
                if ($usuario['es_admin']) {
                    header("Location: ../../fronted/admin/panel_admin/panel_admin.php?seccion=inicio"); 
                } else {
                    header("Location: ../../fronted/blog/publicaciones/mostrar_publicaciones.php?pais=Todos");
                }
                exit;
            }
        }
    }
}

// Pasar los datos del mensaje a la vista
include("../../fronted/Registro_y_inicio_sesion/inicio_sesion.php");
