<!--Se importan los css necesarios-->
<link rel="stylesheet" href="../build/css/lockers.css">

<!-- Formulario para la creación de lockers -->
<form method="POST" class="formu" action="/crearLocker">
    <?php foreach($errores as $error): ?>
        <div>
            <p class="error"><?= htmlspecialchars($error); ?></p>
        </div>
    <?php endforeach; ?>
    <?php include __DIR__ . '/../../includes/templates/forms/formulario_crearLocker.php'; ?>
</form>

<div class="centro">
    <a href="/lockers" class="buton grande">Volver</a>
</div>