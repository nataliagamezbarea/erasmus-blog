<?php
include '../../../backend/blog/publicaciones/procesar_publicaciones.php';

?>
<link href="/fronted/blog/assets/css/publicaciones.css" rel="stylesheet" />
<div class="container mt-5 pt-5">
    <?php if ($idUsuario): ?>
        <div class="mb-4 text-end">
            <a href="<?= dirname($_SERVER['PHP_SELF']) ?>/crear_publicacion.php" class="btn btn-success">Crear publicación</a>

        </div>
    <?php endif; ?>

    <div class="row">
        <?php if (!empty($publicaciones)): ?>
            <?php foreach ($publicaciones as $pub): ?>
                <div class="col-md-4 mb-4 d-flex">
                    <div class="card flex-fill d-flex flex-column position-relative">

                        <!-- Menú desplegable arriba derecha -->
                        <?php if ($esAdmin || ($idUsuario && $pub['usuario_id'] == $idUsuario)): ?>
                            <div class="dropdown position-absolute top-0 end-0 m-2">
                                <button class="btn btn-sm btn-light border rounded-circle p-1" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-three-dots-vertical" viewBox="0 0 16 16">
                                        <path d="M3 9.5A1.5 1.5 0 1 1 3 6.5a1.5 1.5 0 0 1 0 3zm5 0A1.5 1.5 0 1 1 8 6.5a1.5 1.5 0 0 1 0 3zm5 0A1.5 1.5 0 1 1 13 6.5a1.5 1.5 0 0 1 0 3z" />
                                    </svg>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li><a class="dropdown-item" href="editar_publicacion.php?id=<?= $pub['id'] ?>">Editar</a></li>
                                    <li>
                                        <button type="button" class="dropdown-item text-danger" data-bs-toggle="modal" data-bs-target="#eliminarModal<?= $pub['id'] ?>">Eliminar</button>
                                    </li>
                                </ul>
                            </div>
                        <?php endif; ?>

                        <!-- Imagen de la publicación -->
                        <img class="img-fluid img-thumb" src="<?= htmlspecialchars($pub['ubicacion_imagen'], ENT_QUOTES, 'UTF-8') ?>" alt="<?= htmlspecialchars($pub['titulo'], ENT_QUOTES, 'UTF-8') ?>">

                        <div class="card-body d-flex flex-column flex-grow-1">
                            <!-- Autor, país y fecha/hora -->
                            <div class="d-flex align-items-center mb-2">
                                <img src="https://img.freepik.com/vector-premium/ilustracion-plana-vectorial-escala-grises-icono-perfil-usuario-avatar-persona-imagen-perfil-silueta-genero-neutral-apto-perfiles-redes-sociales-iconos-protectores-pantalla-como-plantillax9xa_719432-2210.jpg?semt=ais_hybrid&w=740&q=80"
                                    alt="Avatar" class="rounded-circle me-2" width="40" height="40">
                                <div>
                                    <strong><?= htmlspecialchars($pub['nombre_usuario'] ?? '', ENT_QUOTES, 'UTF-8') ?></strong>
                                    <small class="text-muted"> | <?= htmlspecialchars($pub['pais_nombre'] ?? ' Sin país', ENT_QUOTES, 'UTF-8') ?></small><br>
                                    <small class="text-muted">
                                        <?= htmlspecialchars($pub['fecha_publicacion'] ?? '', ENT_QUOTES, 'UTF-8') ?>
                                        <?= htmlspecialchars($pub['hora_publicacion'] ?? '', ENT_QUOTES, 'UTF-8') ?>
                                    </small>
                                </div>
                            </div>

                            <!-- Título -->
                            <h5 class="card-title mt-2">
                                <a href="post.php?id=<?= $pub['id'] ?>"><?= htmlspecialchars($pub['titulo'], ENT_QUOTES, 'UTF-8') ?></a>
                            </h5>

                            <!-- Descripción -->
                            <p class="card-text descripcion-card"><?= htmlspecialchars($pub['descripcion'], ENT_QUOTES, 'UTF-8') ?></p>

                            <!-- Like -->
                            <?php if ($idUsuario): ?>
                                <div class="mt-auto d-flex align-items-center">
                                    <form method="POST" action="/backend/blog/publicaciones/dar_like.php" style="display:flex; align-items:center; padding:0; margin:0;">
                                        <input type="hidden" name="publicacion_id" value="<?= $pub['id'] ?>">
                                        <button type="submit" style="border:none; background:none; cursor:pointer; display:flex; align-items:center; padding:0; outline:none;">
                                            <?php if (isset($likesUsuario[$pub['id']])): ?>
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" width="24" height="24">
                                                    <path d="M256 464s-24-20.9-91.5-82.3C106.5 340.7 64 294.7 64 224 64 156.5 118.5 104 186 104c36.7 0 71.1 18.2 92 46.1C299.9 122.2 334.3 104 371 104c67.5 0 122 52.5 122 120 0 70.7-42.5 116.7-100.5 157.7C280 443.1 256 464 256 464z" fill="red" stroke="black" stroke-width="32" />
                                                </svg>
                                            <?php else: ?>
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" width="24" height="24">
                                                    <path d="M256 464s-24-20.9-91.5-82.3C106.5 340.7 64 294.7 64 224 64 156.5 118.5 104 186 104c36.7 0 71.1 18.2 92 46.1C299.9 122.2 334.3 104 371 104c67.5 0 122 52.5 122 120 0 70.7-42.5 116.7-100.5 157.7C280 443.1 256 464 256 464z" fill="none" stroke="black" stroke-width="32" />
                                                </svg>
                                            <?php endif; ?>
                                            <span class="ms-1"><?= $pub['num_likes'] ?></span>
                                        </button>
                                    </form>
                                </div>
                            <?php endif; ?>

                        </div>
                    </div>
                </div>

                <!-- Modal de confirmación de eliminación -->
                <div class="modal fade" id="eliminarModal<?= $pub['id'] ?>" tabindex="-1" aria-labelledby="eliminarModalLabel<?= $pub['id'] ?>" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="eliminarModalLabel<?= $pub['id'] ?>">Confirmar eliminación</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                            </div>
                            <div class="modal-body">
                                ¿Estás seguro de que deseas eliminar la publicación "<strong><?= htmlspecialchars($pub['titulo'], ENT_QUOTES, 'UTF-8') ?></strong>"?
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                <form method="POST" action="/backend/blog/publicaciones/eliminar_publicacion.php" class="d-inline">
                                    <input type="hidden" name="publicacion_id" value="<?= $pub['id'] ?>">
                                    <button type="submit" class="btn btn-danger">Eliminar</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

            <?php endforeach; ?>
        <?php else: ?>
            <p>No hay publicaciones disponibles.</p>
        <?php endif; ?>
    </div>
</div>