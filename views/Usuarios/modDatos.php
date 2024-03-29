
<!--Se importan los css necesarios-->
<link rel="stylesheet" href="../build/css/styles.css">
<link rel="stylesheet" href="../build/css/modificar.css">
<?php 
if(isset($_SESSION['errores']) && count($_SESSION['errores']) > 0): ?>
    <div class='errors'>
        <?php foreach($_SESSION['errores'] as $error): ?>
            <p class='error'><?php echo htmlspecialchars($error); ?></p>
        <?php endforeach; ?>
    </div>
    <?php unset($_SESSION['errores']); // Elimina los mensajes de error de la sesión después de mostrarlos
endif; ?>

<main>
    <div class="general">
        <!-- Botones para seleccionar el dato a cambiar -->
        <h2>Cambiar Datos</h2>
        <div class="grid">
        <?php if(isset($datosUsuario) && is_object($datosUsuario)): ?>
            <!-- <div class="grid">
            <div class="grid"> -->
            <a class="boton1 derec" href="/datos?type=username&value=<?php echo htmlspecialchars($datosUsuario->username); ?>">Modificar Nombre de Usuario</a>
            <a class="boton1" href="/datos?type=email&value=<?php echo htmlspecialchars($datosUsuario->email); ?>">Modificar Correo Electrónico</a>
            <a class="boton1 derec" href="/datos?type=password">Modificar Contraseña</a>
            <a class="boton1" href="/datos?type=cartera">Modificar Cartera</a>
            <?php endif; ?>
        </div>
        <a class="boton1" href="/areaPersonal">Volver</a>
    </div>
    </div>
</main>
