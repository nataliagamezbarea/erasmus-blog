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

if ($conexion->connect_error) {
    mostrarMensaje($datosMensaje, "La conexión ha fallado: " . $conexion->connect_error, "danger");
} else {
    $codigoVerificacion = trim($_POST['codigo_verificacion'] ?? '');
    $correo = trim($_POST['gmail'] ?? '');
    $nuevaContrasena = $_POST['new_password'] ?? '';

    if (empty($codigoVerificacion) || empty($correo) || empty($nuevaContrasena)) {
        mostrarMensaje($datosMensaje, "Por favor, complete todos los campos del formulario.", "danger");
    } else {
        // Verificar código y correo
        $sql = "SELECT * FROM usuarios WHERE codigo_verificacion = ? AND email = ?";
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("ss", $codigoVerificacion, $correo);
        $stmt->execute();
        $resultado = $stmt->get_result();

        if ($resultado->num_rows > 0) {
            // Encriptar nueva contraseña
            $contrasenaHasheada = password_hash($nuevaContrasena, PASSWORD_DEFAULT);

            // Actualizar contraseña y eliminar código de verificación
            $sqlActualizar = "UPDATE usuarios SET password = ?, codigo_verificacion = NULL WHERE codigo_verificacion = ? AND email = ?";
            $stmtActualizar = $conexion->prepare($sqlActualizar);
            $stmtActualizar->bind_param("sss", $contrasenaHasheada, $codigoVerificacion, $correo);

            if ($stmtActualizar->execute()) {
                mostrarMensaje($datosMensaje, 'Contraseña actualizada correctamente. <br><a href="/fronted/Registro_y_inicio_sesion/inicio_sesion.php" style="color: black; text-decoration: underline;">Haz clic aquí para iniciar sesión</a>', "success");
            } else {
                mostrarMensaje($datosMensaje, "Error al actualizar la contraseña: " . $stmtActualizar->error, "danger");
            }

            $stmtActualizar->close();
        } else {
            mostrarMensaje($datosMensaje, "Código de verificación o correo electrónico incorrectos.", "warning");
        }

        $stmt->close();
    }

    $conexion->close();
}

// Incluir la vista y pasar $datosMensaje
include("../../fronted/Registro_y_inicio_sesion/recuperar_contraseña.php");
