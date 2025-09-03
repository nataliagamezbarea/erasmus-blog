<?php
ob_start(); // Inicio del buffer
session_start();
require_once "../../backend/config.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_usuario = $_POST['id_usuario'] ?? null;

    if (!$id_usuario) {
        $_SESSION['mensaje'] = [
            'tipo' => 'error',
            'texto' => 'ID de usuario no válido.'
        ];
        header("Location: " . ($_SERVER['HTTP_REFERER'] ?? "../../admin/panel_admin.php"));
        exit();
    }

    try {
        $pdo = new PDO("mysql:host=$servidor;dbname=$base_de_datos;charset=utf8mb4", $usuario, $contrasena);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $pdo->prepare("DELETE FROM usuarios WHERE id = ?");
        $stmt->execute([$id_usuario]);

        $_SESSION['mensaje'] = [
            'tipo' => 'exito',
            'texto' => 'Usuario eliminado correctamente.'
        ];
    } catch (PDOException $e) {
        $_SESSION['mensaje'] = [
            'tipo' => 'error',
            'texto' => 'Error al eliminar usuario: ' . $e->getMessage()
        ];
    }

    // Redirigir a la página anterior o al panel de admin si no hay referrer
    header("Location: " . ($_SERVER['HTTP_REFERER'] ?? "../../admin/panel_admin.php"));
    exit();
}

ob_end_flush(); // Fin del buffer
