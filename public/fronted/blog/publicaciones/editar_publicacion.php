<?php
session_start();
require_once __DIR__ . '/../../../backend/config.php';  // ✅ con __DIR__
require_once __DIR__ . '/../../../backend/blog/publicaciones/procesar_publicacion.php';  // ✅ con __DIR__

                        ?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Editar publicación</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">

                <h2 class="mb-3">Editar publicación</h2>

                <?php if (!empty($_SESSION['mensaje'])): ?>
                    <div class="alert alert-<?= $_SESSION['mensaje_tipo'] ?? 'info' ?>">
                        <?= htmlspecialchars($_SESSION['mensaje'], ENT_QUOTES, 'UTF-8') ?>
                    </div>
                    <?php unset($_SESSION['mensaje'], $_SESSION['mensaje_tipo']); ?>
                <?php endif; ?>

                <form action="../../../backend/blog/publicaciones/editar_publicacion.php" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="id_publicacion" value="<?= $publicacion['id'] ?>">

                    <div class="form-group mb-3">
                        <label for="titulo">Título</label>
                        <input type="text" class="form-control" id="titulo" name="titulo"
                            value="<?= htmlspecialchars($publicacion['titulo'], ENT_QUOTES, 'UTF-8') ?>" required>
                    </div>

                    <div class="form-group mb-3">
                        <label for="descripcion">Descripción</label>
                        <textarea class="form-control" id="descripcion" name="descripcion" rows="4" required><?= htmlspecialchars($publicacion['descripcion'], ENT_QUOTES, 'UTF-8') ?></textarea>
                    </div>

                    <div class="form-group mb-3">
                        <label for="ubicacion_imagen">Imagen (opcional)</label>
                        <input type="file" class="form-control" id="ubicacion_imagen" name="ubicacion_imagen" accept="image/*">
                        <?php if (!empty($publicacion['ubicacion_imagen'])): ?>
                            <p class="mt-2">Imagen actual: <br>
                                <img src="<?= htmlspecialchars($publicacion['ubicacion_imagen'], ENT_QUOTES, 'UTF-8') ?>" alt="Imagen actual" style="max-width: 100%;">
                            </p>
                        <?php endif; ?>
                    </div>

                    <button type="submit" class="btn btn-primary">Guardar cambios</button>
                </form>
            </div>
        </div>
    </div>

</body>

</html>