<?php
session_start();
require_once '../../../backend/config.php';
require_once '../../../backend/blog/publicaciones/filtrar_pais.php';
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Publicaciones - <?= htmlspecialchars($paisSeleccionado ?? "Todos", ENT_QUOTES, 'UTF-8') ?></title>
    <link rel="stylesheet" href="/fronted/blog/assets/css/style.css">
</head>

<body>

    <?php include '../components/navbar.php'; ?>

    <?php
    // Componente que muestra publicaciones
    include '../components/publicaciones.php';
    ?>


</body>

</html>