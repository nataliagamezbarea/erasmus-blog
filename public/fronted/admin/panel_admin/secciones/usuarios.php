<?php
ob_start(); // Inicia el buffer
require_once __DIR__ . "/../../../../backend/config.php";

try {
    $pdo = new PDO("mysql:host=$servidor;dbname=$base_de_datos;charset=utf8mb4", $usuario, $contrasena);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Traer todos los usuarios
    $stmt = $pdo->query("SELECT u.id, u.nombre_usuario, u.email, u.es_admin, u.pais_id, p.nombre AS pais 
                         FROM usuarios u LEFT JOIN paises p ON u.pais_id = p.id 
                         ORDER BY u.id ASC");
    $usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Traer todos los países
    $stmt = $pdo->query("SELECT id, nombre FROM paises ORDER BY nombre ASC");
    $paises = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error de conexión: " . $e->getMessage());
}

// Mensajes del backend
$mensaje = $_SESSION['mensaje'] ?? null;
unset($_SESSION['mensaje']);
?>

<link href="/fronted/admin/css/usuarios.css" rel="stylesheet" />


<?php if ($mensaje): ?>
    <div class="alert alert-<?= $mensaje['tipo'] === 'exito' ? 'success' : 'danger' ?>">
        <?= htmlspecialchars($mensaje['texto']) ?>
    </div>
<?php endif; ?>

<div class="mb-3 text-end">
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#usuarioModal">Crear Usuario</button>
</div>

<!-- Modal Crear Usuario -->
<div class="modal fade" id="usuarioModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="/backend/admin/crear_usuario.php">
                <div class="modal-header">
                    <h5 class="modal-title">Crear Usuario</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label>Nombre Usuario</label>
                        <input type="text" name="nombre_usuario" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Password</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>País</label>
                        <select name="pais_id" class="form-select">
                            <option value="">-- Seleccione un país --</option>
                            <?php foreach ($paises as $pais): ?>
                                <option value="<?= $pais['id'] ?>"><?= htmlspecialchars($pais['nombre']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-check mb-3">
                        <input type="checkbox" name="es_admin" class="form-check-input" id="es_admin">
                        <label class="form-check-label" for="es_admin">Es administrador</label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Tabla Usuarios -->
<div class="card shadow-sm">
    <h4 class="p-3">Lista de Usuarios</h4>
    <table class="table table-striped align-middle mb-0">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre Usuario</th>
                <th>Email</th>
                <th>País</th>
                <th>Admin</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($usuarios as $usuario): ?>
                <tr>
                    <td><?= $usuario['id'] ?></td>
                    <td><?= htmlspecialchars($usuario['nombre_usuario']) ?></td>
                    <td><?= htmlspecialchars($usuario['email']) ?></td>
                    <td><?= htmlspecialchars($usuario['pais'] ?? '-') ?></td>
                    <td><?= $usuario['es_admin'] ? 'Sí' : 'No' ?></td>
                    <td>
                        <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editarUsuarioModal<?= $usuario['id'] ?>">Editar</button>
                        <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#eliminarUsuarioModal<?= $usuario['id'] ?>">Eliminar</button>
                    </td>
                </tr>

                <!-- Modal Editar Usuario -->
                <div class="modal fade" id="editarUsuarioModal<?= $usuario['id'] ?>" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form method="POST" action="../../../../backend/admin/editar_usuario.php">
                                <div class="modal-header">
                                    <h5 class="modal-title">Editar Usuario</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <input type="hidden" name="id_usuario" value="<?= $usuario['id'] ?>">
                                    <div class="mb-3">
                                        <label>Nombre Usuario</label>
                                        <input type="text" name="nombre_usuario" class="form-control" value="<?= htmlspecialchars($usuario['nombre_usuario']) ?>" required>
                                    </div>
                                    <div class="mb-3">
                                        <label>Email</label>
                                        <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($usuario['email']) ?>" required>
                                    </div>
                                    <div class="mb-3">
                                        <label>País</label>
                                        <select name="pais_id" class="form-select">
                                            <option value="">-- Seleccione un país --</option>
                                            <?php foreach ($paises as $pais): ?>
                                                <option value="<?= $pais['id'] ?>" <?= $pais['id'] == $usuario['pais_id'] ? 'selected' : '' ?>>
                                                    <?= htmlspecialchars($pais['nombre']) ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="form-check mb-3">
                                        <input type="checkbox" name="es_admin" class="form-check-input" id="es_admin_<?= $usuario['id'] ?>" <?= $usuario['es_admin'] ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="es_admin_<?= $usuario['id'] ?>">Es administrador</label>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                    <button type="submit" class="btn btn-primary">Guardar cambios</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Modal Eliminar Usuario -->
                <div class="modal fade" id="eliminarUsuarioModal<?= $usuario['id'] ?>" tabindex="-1">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Confirmar eliminación</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                ¿Eliminar al usuario "<strong><?= htmlspecialchars($usuario['nombre_usuario']) ?></strong>"?
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                <form method="POST" action="../../../../backend/admin/eliminar_usuario.php" class="d-inline">
                                    <input type="hidden" name="id_usuario" value="<?= $usuario['id'] ?>">
                                    <button type="submit" class="btn btn-danger">Eliminar</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

            <?php endforeach; ?>
        </tbody>
    </table>




    <?php
    ob_end_flush(); // Cierra el buffer
