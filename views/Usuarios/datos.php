    <link rel="stylesheet" href="../build/css/modificar.css">


    <form method="POST">
        <?php foreach($errores as $error): ?>
            <div>
                <p class="error"><?= htmlspecialchars($error); ?></p>
            </div>
        <?php endforeach; ?>
        <?php include __DIR__ . '/../../includes/templates/forms/formulario_modDatos.php'; ?>
    </form>

        <a class="boton1" href="/modDatos">Volver</a>
        