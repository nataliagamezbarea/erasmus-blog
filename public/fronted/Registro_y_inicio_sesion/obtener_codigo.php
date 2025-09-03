<?php session_start(); ?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Recuperar tu cuenta</title>
  <link rel="stylesheet" href="/fronted/Registro_y_inicio_sesion/css/style.css" />
  <link rel="stylesheet" href="/fronted/Registro_y_inicio_sesion/css/alerta.css">

</head>

<body>
  <section>
    <div class="login-box">
      <form
        id="verificationAndNewPasswordForm"
        method="post"
        action="/backend/Registro_y_inicio_sesion/enviar_codigo_recuperacion.php">
        <h2>Recuperar tu cuenta</h2>

        <!-- Mensaje de alerta -->
        <?php if (!empty($datosMensaje['mostrar'])): ?>
          <div class="mensaje-alerta
                        <?= $datosMensaje['tipo'] === 'success' ? 'mensaje-success' : '' ?>
                        <?= $datosMensaje['tipo'] === 'danger' ? 'mensaje-danger' : '' ?>
                        <?= $datosMensaje['tipo'] === 'warning' ? 'mensaje-warning' : '' ?>
                        <?= $datosMensaje['tipo'] === 'info' ? 'mensaje-info' : '' ?>">
            <?= $datosMensaje['texto'] ?>
          </div>
        <?php endif; ?>

        <input
          type="hidden"
          id="nombre_usuario"
          name="nombre_usuario"
          value="nombre_de_usuario" />

        <div class="input-box">
          <span class="icon"><ion-icon name="mail"></ion-icon></span>
          <input type="email" id="gmail" name="gmail" required />
          <label for="gmail">Gmail</label>
        </div>

        <div class="register-link">
          <a href="/fronted/Registro_y_inicio_sesion/inicio_sesion.php" id="enviarVerificacion">¿Te has acordado de la contraseña?</a>
        </div>
        <br />
        <button type="submit">Enviar verificación</button>
      </form>
    </div>
  </section>

  <script src="https://unpkg.com/ionicons@5.0.1/dist/ionicons/ionicons.js"></script>
</body>

</html>