<?php
ob_start(); 
session_start();
require_once "../../backend/config.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = (int)$_POST['id_usuario'];
    $nombre = trim($_POST['nombre_usuario']);
    $email = trim($_POST['email']);
    $es_admin = isset($_POST['es_admin']) ? 1 : 0;
    $pais_id = !empty($_POST['pais_id']) ? (int)$_POST['pais_id'] : null;

    // Validación campos obligatorios
    if ($nombre === "" || $email === "") {
        $_SESSION['mensaje'] = [
            'tipo' => 'error',
            'texto' => "Todos los campos obligatorios deben completarse."
        ];
        header("Location: " . ($_SERVER['HTTP_REFERER'] ?? "../../admin/panel_admin.php"));
        ob_end_flush();
        exit();
    }

    try {
        $pdo = new PDO("mysql:host=$servidor;dbname=$base_de_datos;charset=utf8mb4", $usuario, $contrasena);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $pdo->prepare("SELECT COUNT(*) FROM usuarios WHERE email = ? AND id != ?");
        $stmt->execute([$email, $id]);
        if ($stmt->fetchColumn() > 0) {
            $_SESSION['mensaje'] = [
                'tipo' => 'error',
                'texto' => "El correo ya está registrado por otro usuario."
            ];
        } else {
            $stmt = $pdo->prepare("UPDATE usuarios SET nombre_usuario = ?, email = ?, es_admin = ?, pais_id = ? WHERE id = ?");
            $stmt->execute([$nombre, $email, $es_admin, $pais_id, $id]);
            $_SESSION['mensaje'] = [
                'tipo' => 'exito',
                'texto' => "Usuario actualizado correctamente."
            ];
        }
    } catch (PDOException $e) {
        $_SESSION['mensaje'] = [
            'tipo' => 'error',
            'texto' => "Error al actualizar usuario: " . $e->getMessage()
        ];
    }

    header("Location: " . ($_SERVER['HTTP_REFERER'] ?? "../../admin/panel_admin.php"));
    ob_end_flush(); // Cierra buffer
    exit();
}
