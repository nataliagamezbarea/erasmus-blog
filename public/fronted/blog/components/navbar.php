<?php
ob_start(); // Inicia buffer
require_once __DIR__ . '/../../../backend/blog/procesar_navbar.php';

// Iniciar sesión si no está iniciada
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

// Procesar cierre de sesión
if (isset($_GET['action']) && $_GET['action'] === 'logout') {
  $_SESSION = [];
  session_destroy();
  header("Location: " . strtok($_SERVER["REQUEST_URI"], '?'));
  exit;
}

// Verificar si el usuario está logueado
$usuario_logueado = !empty($_SESSION['id_usuario']);
?>
<nav class="navbar navbar-expand-lg navbar-light bg-white fixed-top shadow-sm">
  <div class="container">
    <a class="navbar-brand fw-bold" href="/fronted/blog/publicaciones/mostrar_publicaciones.php?pais=Todos">Blog Erasmus</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
      aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="/fronted/Inicio/index.php">Inicio</a>
        </li>

        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Países
          </a>
          <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
            <li><a class="dropdown-item" href="../publicaciones/mostrar_publicaciones.php?pais=Todos">Todos</a></li>
            <?php foreach ($paises as $pais): ?>
              <li>
                <a class="dropdown-item" href="../publicaciones/mostrar_publicaciones.php?pais=<?= urlencode($pais) ?>">
                  <?= htmlspecialchars($pais, ENT_QUOTES, 'UTF-8') ?>
                </a>
              </li>
            <?php endforeach; ?>
          </ul>
        </li>

        <li class="nav-item"><a class="nav-link" href="/fronted/blog/comentarios.php">Comentarios</a></li>

        <?php if ($usuario_logueado): ?>
          <?php if (!empty($_SESSION['es_admin']) && $_SESSION['es_admin'] == 1): ?>
            <li class="nav-item">
              <a class="nav-link text-danger fw-bold" href="/fronted/admin/panel_admin/panel_admin.php?seccion=inicio">
                Panel administración
              </a>
            </li>
          <?php endif; ?>
        <?php endif; ?>

        <!-- Botón de login/logout siempre insertado -->
        <?php include __DIR__ . '/../../Registro_y_inicio_sesion/logout.php'; ?>
      </ul>
    </div>
  </div>
</nav>

<!-- Bootstrap CSS y JS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>



<?php ob_end_flush(); ?>