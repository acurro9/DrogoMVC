<link rel="stylesheet" href="../../build/css/usuarios.css">
<link rel="stylesheet" href="../../build/css/styles.css">
<!-- Formulario para la actualización de usuarios -->
<?php if (isset($usuario)): ?>
<form action="./actualizarUsuario?usuario=<?= htmlspecialchars($usuario->id); ?>" method="POST" class="formu">
    <!-- Se imprimen los errores si los hay -->
    <?php foreach($errores as $error): ?>
        <div>
            <p class="error"><?= htmlspecialchars($error); ?></p>
        </div>
    <?php endforeach; ?>

    <fieldset>
        <legend>Actualizar Usuario:</legend>

        <label for="id">ID:</label>
        <input type="text" name="id" value="<?= htmlspecialchars($usuario->id); ?>" readonly>
      
        <label for="nombre">Nombre de usuario:</label>
        <input type="text" name="username" value="<?= htmlspecialchars($usuario->username); ?>">

        <label for="correo">Email:</label>
        <input type="text" name="email" value="<?= htmlspecialchars($usuario->email); ?>">

        <label for="password">Contraseña:</label>
        <input type="password" name="password" value="">

        <label for="tipo">Tipo de usuario:</label>
        <select name="tipo">
            <option value=""></option>
            <option value="1" <?= $usuario->tipo == '1' ? 'selected' : ''; ?>>Comprador</option>
            <option value="2" <?= $usuario->tipo == '2' ? 'selected' : ''; ?>>Vendedor</option>
            <option value="3" <?= $usuario->tipo == '3' ? 'selected' : ''; ?>>Distribuidor</option>
        </select>


        <div class="botones">
            <input type="submit" value="Actualizar Usuario" class="registro">
            <a href="/usuario" class="buton">Volver</a>
        </div>
    </fieldset>
</form>
<?php endif; ?>
