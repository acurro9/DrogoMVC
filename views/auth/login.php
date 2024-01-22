<?php 
//Vista login

    foreach ($errores as $error) {
        // Se imprimen los errores si los hay
    ?>
        <div class="alerta error">
            <?php echo $error; ?>
        </div>
    <?php
    }
?>

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