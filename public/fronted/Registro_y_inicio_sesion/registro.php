<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Registro</title>
  <link rel="stylesheet" href="/fronted/Registro_y_inicio_sesion/css/style.css">
  <link rel="stylesheet" href="/fronted/Registro_y_inicio_sesion/css/alerta.css">

</head>

<body>
  <section>
    <div class="login-box">
      <form id="registrationForm" method="post" action="../backend/Registro_y_inicio_sesion/registrar.php" onsubmit="return validateForm()">
        <h2>Registro</h2>
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

        <div class="input-box">
          <span class="icon"><ion-icon name="person-add"></ion-icon></span>
          <input type="text" id="user" name="user" required>
          <label for="user">Usuario</label>
        </div>

        <div class="input-box">
          <span class="icon"><ion-icon name="mail"></ion-icon></span>
          <input type="email" id="email" name="email" required>
          <label for="email">Gmail</label>
        </div>

        <div class="input-box">
          <span class="icon"><ion-icon name="lock-closed"></ion-icon></span>
          <input type="password" id="password" name="password" required>
          <label for="password">Contraseña</label>
        </div>

        <button type="submit">Registrarse</button>

        <div class="register-link">
          <p>¿Tienes cuenta?<a href="/fronted/Registro_y_inicio_sesion/inicio_sesion.php"> Inicia sesión</a></p>
        </div>
      </form>
    </div>
  </section>

  <script src="https://unpkg.com/ionicons@5.0.1/dist/ionicons/ionicons.js"></script>
  <script>
    function validateForm() {
      var password = document.getElementById("password").value;
      if (password.length < 8 || !/[A-Z]/.test(password)) {
        alert("La contraseña debe tener al menos 8 caracteres y al menos una letra mayúscula.");
        return false;
      }
      return true;
    }
  </script>
</body>

</html>