<?php
session_start();
require_once "../../backend/config.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = trim($_POST['nombre_usuario']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $es_admin = isset($_POST['es_admin']) ? 1 : 0;
    $pais_id = !empty($_POST['pais_id']) ? (int)$_POST['pais_id'] : null;

    // Validación de campos obligatorios
    if ($nombre === "" || $email === "" || $password === "") {
        $_SESSION['mensaje'] = [
            'tipo' => 'error',
            'texto' => "Todos los campos obligatorios deben completarse."
        ];
        header("Location: " . ($_SERVER['HTTP_REFERER'] ?? "../../admin/panel_admin.php"));
        exit();
    }

    // Validación de país para usuarios no administradores
    if (!$es_admin && empty($pais_id)) {
        $_SESSION['mensaje'] = [
            'tipo' => 'error',
            'texto' => "Debe seleccionar un país para usuarios no administradores."
        ];
        header("Location: " . ($_SERVER['HTTP_REFERER'] ?? "../../admin/panel_admin.php"));
        exit();
    }

    try {
        $pdo = new PDO("mysql:host=$servidor;dbname=$base_de_datos;charset=utf8mb4", $usuario, $contrasena);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $pdo->prepare("SELECT COUNT(*) FROM usuarios WHERE email = ?");
        $stmt->execute([$email]);

        if ($stmt->fetchColumn() > 0) {
            $_SESSION['mensaje'] = [
                'tipo' => 'error',
                'texto' => "El correo ya está registrado."
            ];
        } else {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("INSERT INTO usuarios (nombre_usuario, email, password, es_admin, pais_id) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([$nombre, $email, $hash, $es_admin, $pais_id]);

            $_SESSION['mensaje'] = [
                'tipo' => 'exito',
                'texto' => "Usuario creado correctamente."
            ];
        }
    } catch (PDOException $e) {
        $_SESSION['mensaje'] = [
            'tipo' => 'error',
            'texto' => "Error al crear usuario: " . $e->getMessage()
        ];
    }

    // Volver a la página desde donde se llamó
    header("Location: " . ($_SERVER['HTTP_REFERER'] ?? "../../admin/panel_admin.php"));
    exit();
}
