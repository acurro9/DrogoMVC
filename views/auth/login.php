<?php foreach($errores as $error): ?>
        <div>
            <p class="error"><?= htmlspecialchars($error); ?></p>
        </div>
    <?php endforeach; ?>

    <!--Se importan los css necesarios-->
    <link rel="stylesheet" href="../build/css/login.css">
    <!-- Formulario para el inicio de sesión -->
    <form method="POST" action="/login" class="login_form">
        <h3>Inicio de sesión</h3>
        <?php include __DIR__ . '/../../includes/templates/forms/formulario_login.php'; ?>
    </form>
    <!-- Se incluye los archivos de javascript -->
    <script src="../build/js/contraseña.js"></script>
</body>
</html>