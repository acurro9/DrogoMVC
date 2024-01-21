    <!--Se importan los css necesarios-->
    <link rel="stylesheet" href="../build/css/login.css">
    <link rel="stylesheet" href="../build/css/loginAdmin.css">

    <!-- Formulario del login del administrador -->
    <form method="POST" enctype="multipart/form-data">
        <h4 class="adminTitle">Área de administrador</h4>    
        <h3>Inicio de sesión</h3>

        <?php include __DIR__ . '/../../includes/templates/forms/formulario_admin.php'; ?>

    </form>
    <!-- Se incluye los archivos de javascript -->
    <script src="../build/js/contraseña.js"></script>
    <script src="../build/js/index.js"></script>
</body>
</html>