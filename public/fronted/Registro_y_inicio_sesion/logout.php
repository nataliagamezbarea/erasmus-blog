<?php include __DIR__ . '/../../backend/Registro_y_inicio_sesion/cerrar_sesion.php'; ?>

<link rel="stylesheet" href="/fronted/Registro_y_inicio_sesion/css/ocultar_fondo_transparente.css">

<?php if ($usuario_logueado): ?>
    <!-- Usuario logueado: mostrar cerrar sesión -->
    <li class="nav-item">
        <a class="nav-link btn d-flex align-items-center logout-btn" href="#" data-bs-toggle="modal" data-bs-target="#logoutModal">
            Cerrar sesión
        </a>
    </li>

    <!-- Modal de confirmación de cierre -->
    <div class="modal fade" id="logoutModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-danger border-2 shadow-lg">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title">Cerrar sesión</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>¿Seguro que quieres cerrar sesión?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <a href="?action=logout" class="btn btn-danger text-white">Cerrar sesión</a>
                </div>
            </div>
        </div>
    </div>

<?php else: ?>
    <!-- Usuario no logueado: mostrar iniciar sesión -->
    <li class="nav-item">
        <a class="nav-link" href="/fronted/Registro_y_inicio_sesion/inicio_sesion.php">Iniciar sesión</a>
    </li>
<?php endif; ?>

