<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Iniciar sesión</title>
  <link rel="stylesheet" href="/fronted/Registro_y_inicio_sesion/css/style.css">
  <link rel="stylesheet" href="/fronted/Registro_y_inicio_sesion/css/alerta.css">
</head>

<body>
  <section>
    <div class="login-box">
      <form action="/backend/Registro_y_inicio_sesion/comprobar_cuenta.php" method="post">
        <h2>Iniciar sesión</h2>

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

        <div class="input-box">
          <span class="icon"><ion-icon name="mail"></ion-icon></span>
          <input type="text" id="email" name="email" required>
          <label for="email">Usuario / Gmail</label>
        </div>

        <div class="input-box">
          <span class="icon"><ion-icon name="lock-closed"></ion-icon></span>
          <input type="password" id="password" name="password" required autocomplete="current-password">
          <label for="password">Contraseña</label>
        </div>

        <div class="remember-forgot">
          <label><input type="checkbox" id="remember" name="remember"> Recordar </label>
          <a href="/fronted/Registro_y_inicio_sesion/obtener_codigo.php">¿Has olvidado tu contraseña?</a>
        </div>

        <br>
        <button type="submit">Iniciar sesión</button>

        <div class="register-link">
          <p>¿No tienes cuenta?<a href="/fronted/Registro_y_inicio_sesion/registro.php"> Regístrate</a></p>
        </div>
      </form>
    </div>
  </section>

  <script src="https://unpkg.com/ionicons@5.0.1/dist/ionicons/ionicons.js"></script>
</body>

</html>