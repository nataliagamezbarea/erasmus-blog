<?php
ob_start();
session_start();
include '../../../backend/blog/publicaciones/procesar_publicacion.php'; 
?>

<?php include '../components/navbar.php'; ?>

<div class="container mt-5 pt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">

            <!-- Mensaje -->
            <?php if (!empty($_SESSION['mensaje'])): ?>
                <div class="alert alert-<?= $_SESSION['mensaje_tipo'] ?? 'info' ?>">
                    <?= htmlspecialchars($_SESSION['mensaje'], ENT_QUOTES, 'UTF-8') ?>
                </div>
                <?php unset($_SESSION['mensaje'], $_SESSION['mensaje_tipo']); ?>
            <?php endif; ?>

            <form action="/backend/blog/publicaciones/publicar_publicacion.php" method="post" enctype="multipart/form-data">
                <h2 class="mb-3">Publicar</h2>

                <div class="form-group mb-3">
                    <label for="titulo">Título</label>
                    <input type="text" class="form-control" id="titulo" name="titulo" required>
                </div>

                <div class="form-group mb-3">
                    <label for="ubicacion_imagen">Imagen</label>
                    <input type="file" class="form-control" id="ubicacion_imagen" name="ubicacion_imagen" accept="image/*" required>
                </div>

                <div class="form-group mb-3">
                    <label for="descripcion">Descripción</label>
                    <textarea class="form-control" id="descripcion" name="descripcion" rows="4" required></textarea>
                </div>

                <!-- País -->
                <div class="form-group mb-3">
                    <label for="pais">País</label>
                    <?php if (!empty($esAdmin) && $esAdmin): ?>
                        <select class="form-control" id="pais" name="pais_id" required>
                            <option value="">Selecciona un país</option>
                            <?php foreach ($paises as $pais): ?>
                                <option value="<?= $pais['id'] ?>"><?= htmlspecialchars($pais['nombre'], ENT_QUOTES, 'UTF-8') ?></option>
                            <?php endforeach; ?>
                        </select>
                    <?php else: ?>
                        <input type="text" class="form-control" id="pais" value="<?= htmlspecialchars($paisUsuarioNombre, ENT_QUOTES, 'UTF-8') ?>" readonly>
                        <input type="hidden" name="pais_id" value="<?= htmlspecialchars($paisUsuarioId ?? '', ENT_QUOTES, 'UTF-8') ?>">
                    <?php endif; ?>
                </div>

                <button type="submit" class="btn btn-primary">Publicar</button>
            </form>
        </div>
    </div>
</div>

<?php
ob_end_flush();
?>