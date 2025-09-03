<link rel="stylesheet" href="../css/styles.css">
<div id="credencialesContainer">
    <h1><i class="fas fa-key icono"></i> Credenciales</h1><br>

    <p>
        <i class="fas fa-user icono"></i>
        <strong>Nombre de Usuario:</strong><br>
        <?php echo htmlspecialchars($nombre_usuario_actual, ENT_QUOTES, 'UTF-8'); ?>
    </p>

    <p>
        <i class="fas fa-envelope icono"></i>
        <strong>Email:</strong><br>
        <?php echo htmlspecialchars($email_usuario_actual, ENT_QUOTES, 'UTF-8'); ?>
    </p>

    <p>
        <i class="fas fa-user-shield icono"></i>
        <strong>Rol:</strong><br>
        <?php echo htmlspecialchars($rol_usuario, ENT_QUOTES, 'UTF-8'); ?>
    </p>
</div>