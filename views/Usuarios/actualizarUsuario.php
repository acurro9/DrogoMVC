<link rel="stylesheet" href="../build/css/usuarios.css">
<!-- Formulario para la actualización de usuarios -->
<?php if (isset($usuario)): ?>
<form action="./actualizarUsuario?usuario=<?= htmlspecialchars($usuario->id); ?>" method="POST" class="formu">
    <!-- Se imprimen los errores si los hay -->
    <?php foreach($errores as $error): ?>
        <div>
            <p class="error"><?= htmlspecialchars($error); ?></p>
        </div>
    <?php endforeach; ?>

    <?php include __DIR__ . '/../../includes/templates/forms/formulario_actUsu.php'; ?>
</form>
<?php endif; ?>
