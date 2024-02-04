<link rel="stylesheet" href="../build/css/usuarios.css">
<?php 
if(isset($_SESSION['errores']) && count($_SESSION['errores']) > 0): ?>
    <div class='errors'>
        <?php foreach($_SESSION['errores'] as $error): ?>
            <p class='error'><?php echo htmlspecialchars($error); ?></p>
        <?php endforeach; ?>
    </div>
    <?php unset($_SESSION['errores']); // Elimina los mensajes de error de la sesión después de mostrarlos
endif; ?>

<!-- Formulario para la actualización de usuarios -->
<?php if (isset($usuario)): ?>
<form action="/actualizarUsuario?usuario=<?= htmlspecialchars($usuario->id); ?>" method="POST" class="formu">
    <!-- Se imprimen los errores si los hay -->
    <?php foreach($errores as $error): ?>
        <div>
            <p class="error"><?= htmlspecialchars($error); ?></p>
        </div>
    <?php endforeach; ?>

    <?php include __DIR__ . '/../../includes/templates/forms/formulario_actUsu.php'; ?>
</form>
<?php endif; ?>
