<!--Se importan los css necesarios-->
<link rel="stylesheet" href="../build/css/pedidos.css">

<!-- Formulario para la actulización de pedidos -->
<form method="POST" enctype="multipart/form-data" class="formu">
<?php foreach($errores as $error): ?>
        <div>
            <p class="error"><?= htmlspecialchars($error); ?></p>
        </div>
    <?php endforeach; ?>
    <?php include __DIR__ . '/../../includes/templates/forms/formulario_actPedido.php'; ?>
</form>

