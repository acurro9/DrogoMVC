<!--Se importan los css necesarios-->
<link rel="stylesheet" href="../../build/css/registro.css">
<main>
    <!-- Formulario para el registro -->
    <form method="POST" action="/registro" enctype="multipart/form-data">
        <h3>Registro</h3>
        <?php foreach($errores as $error): ?>
        <div>
            <p class="error"><?= htmlspecialchars($error); ?></p>
        </div>
    <?php endforeach; ?>
       

        <?php include __DIR__ . '/../../includes/templates/forms/formulario_registro.php'; ?>
    </form>
</main>
<!-- Se incluye los archivos de javascript -->
<script src="../../build/js/contraseña.js"></script>
</body>
</html>
