<?php
// Suponemos que $datosMensaje viene del backend al incluir este archivo
// $datosMensaje = ['mostrar' => true|false, 'texto' => '', 'tipo' => 'success|danger|warning|info']
?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Recuperar tu cuenta</title>
  <link rel="stylesheet" href="/fronted/Registro_y_inicio_sesion/css/style.css" />
  <link rel="stylesheet" href="/fronted/Registro_y_inicio_sesion/css/alerta.css">

</head>

<body>
  <section>
    <div class="login-box">
      <form id="verificationAndNewPasswordForm" method="post" action="/backend/Registro_y_inicio_sesion/restablecer_contraseña.php">
        <h2>Recuperar tu cuenta</h2>

        <!-- Mensaje de alerta uniforme -->
        <?php if (!empty($datosMensaje['mostrar'])): ?>
          <div class="mensaje-alerta
                    <?= $datosMensaje['tipo'] === 'success' ? 'mensaje-success' : '' ?>
                    <?= $datosMensaje['tipo'] === 'danger' ? 'mensaje-danger' : '' ?>
                    <?= $datosMensaje['tipo'] === 'warning' ? 'mensaje-warning' : '' ?>
                    <?= $datosMensaje['tipo'] === 'info' ? 'mensaje-info' : '' ?>">
            <?= $datosMensaje['texto'] ?>
          </div>
        <?php endif; ?>

        <!-- Código de verificación -->
        <div class="input-box">
          <span class="icon"><ion-icon name="lock-closed"></ion-icon></span>
          <input type="text" id="codigo_verificacion" name="codigo_verificacion" required />
          <label for="codigo_verificacion">Código de verificación</label>
        </div>

        <!-- Gmail -->
        <div class="input-box">
          <span class="icon"><ion-icon name="mail"></ion-icon></span>
          <input type="email" id="gmail" name="gmail" required />
          <label for="gmail">Gmail</label>
        </div>

        <!-- Nueva contraseña -->
        <div class="input-box">
          <span class="icon"><ion-icon name="lock-closed"></ion-icon></span>
          <input type="password" id="new_password" name="new_password" required />
          <label for="new_password">Nueva Contraseña</label>
        </div>

        <button type="submit">Guardar Contraseña</button>
        <a href="/fronted/Registro_y_inicio_sesion/obtener_codigo.php">
          <button type="button">Volver a solicitar código verificación</button>
        </a>
      </form>
    </div>
  </section>

  <script src="https://unpkg.com/ionicons@5.0.1/dist/ionicons/ionicons.js"></script>
</body>

</html>