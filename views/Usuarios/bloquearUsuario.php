<!--Se importan los css necesarios-->
<link rel="stylesheet" href="../build/css/styles.css">
<link rel="stylesheet" href="../build/css/bloqUsuario.css">
<?php 
if(isset($_SESSION['errores']) && count($_SESSION['errores']) > 0): ?>
    <div class='errors'>
        <?php foreach($_SESSION['errores'] as $error): ?>
            <p class='error'><?php echo htmlspecialchars($error); ?></p>
        <?php endforeach; ?>
    </div>
    <?php unset($_SESSION['errores']); // Elimina los mensajes de error de la sesión después de mostrarlos
endif; ?>


<div class="bloq">
    <!-- Formulario para la búsqueda del usuario -->
    <form method="POST" class="formu">
    <?php foreach($errores as $error): ?>
        <div>
            <p class="error"><?= htmlspecialchars($error); ?></p>
        </div>
    <?php endforeach; ?>
        <?php include __DIR__ . '/../../includes/templates/forms/formulario_bloqUsu.php'; ?>        
    </form>
</div>

<div class="centro margen">
    <a href="/usuario" class="buton grande">Volver</a>
</div>
<!-- Se incluye los archivos de javascript -->
<script src="../build/js/index.js"></script>
