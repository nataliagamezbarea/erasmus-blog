<?php
ob_start();
session_start(); // Asegurarse de iniciar sesión

// Archivos separados para crear, editar y eliminar comentarios
include '../../backend/blog/comentarios/crear_comentario.php';
include '../../backend/blog/comentarios/editar_comentario.php';
include '../../backend/blog/comentarios/eliminar_comentario.php';
include '../../backend/blog/comentarios/procesar_comentarios.php';

// Variables de sesión
$id_usuario = isset($_SESSION['id_usuario']) ? intval($_SESSION['id_usuario']) : null;
$es_admin = isset($_SESSION['es_admin']) ? intval($_SESSION['es_admin']) : 0;

?>
<link href="../blog/assets/css/comentarios.css" rel="stylesheet" />



<div class="container mt-5 p-5">
    <h2 class="mb-4">Comentarios</h2>

    <?php include 'components/navbar.php'; ?>

    <?php if (!empty($mensaje_exito)): ?>
        <div class="alert alert-info"><?= htmlspecialchars($mensaje_exito) ?></div>
    <?php endif; ?>

    <?php if (isset($resultado_comentarios) && $resultado_comentarios->num_rows > 0): ?>
        <?php while ($c = $resultado_comentarios->fetch_assoc()): ?>
            <div class="card mb-3 comment-card">
                <div class="card-body">
                    <h5 class="card-title mb-1"><?= htmlspecialchars($c['nombre_usuario']) ?></h5>
                    <p class="card-text"><?= nl2br(htmlspecialchars($c['TextoComentario'])) ?></p>
                    <small class="text-muted"><?= date("d/m/Y H:i", strtotime($c['FechaComentario'])) ?></small>

                    <?php if ($id_usuario == $c['UsuarioID'] || $es_admin): ?>
                        <div class="action-points" data-toggle="collapse" data-target="#menu-<?= $c['IDComentario'] ?>">⋮</div>
                        <div id="menu-<?= $c['IDComentario'] ?>" class="collapse action-menu">
                            <?php if ($id_usuario == $c['UsuarioID']): ?>
                                <a href="#" data-toggle="modal" data-target="#editarModal<?= $c['IDComentario'] ?>">Editar</a>
                            <?php endif; ?>
                            <a href="#" data-toggle="modal" data-target="#eliminarModal<?= $c['IDComentario'] ?>">Eliminar</a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Modal Editar -->
            <?php if ($id_usuario == $c['UsuarioID']): ?>
                <div class="modal fade" id="editarModal<?= $c['IDComentario'] ?>" tabindex="-1" role="dialog">
                    <div class="modal-dialog" role="document">
                        <form method="post">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Editar Comentario</h5>
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>
                                <div class="modal-body">
                                    <input type="hidden" name="id_comentario" value="<?= $c['IDComentario'] ?>">
                                    <div class="form-group">
                                        <textarea name="editar_comentario" class="form-control" required><?= htmlspecialchars($c['TextoComentario']) ?></textarea>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                    <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Modal Eliminar -->
            <?php if ($id_usuario == $c['UsuarioID'] || $es_admin): ?>
                <div class="modal fade" id="eliminarModal<?= $c['IDComentario'] ?>" tabindex="-1" role="dialog">
                    <div class="modal-dialog" role="document">
                        <form method="get">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Eliminar Comentario</h5>
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>
                                <div class="modal-body">
                                    <p>¿Seguro que quieres eliminar este comentario?</p>
                                    <input type="hidden" name="delete" value="<?= $c['IDComentario'] ?>">
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                    <button type="submit" class="btn btn-danger">Eliminar</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            <?php endif; ?>

        <?php endwhile; ?>
    <?php else: ?>
        <p>No hay comentarios aún.</p>
    <?php endif; ?>

    <?php if ($id_usuario): ?>
        <form method="post" class="mt-4">
            <div class="form-group">
                <textarea name="comentario" class="form-control" placeholder="Escribe tu comentario..." required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Comentar</button>
        </form>
    <?php else: ?>
        <div class="alert alert-warning mt-4">
            Debes <a href="../../fronted/Registro_y_inicio_sesion/inicio_sesion.php">iniciar sesión</a> para comentar.
        </div>
    <?php endif; ?>

</div>



<?php
ob_end_flush();
?>