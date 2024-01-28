    <link rel="stylesheet" href="../build/css/modificar.css">


        <?php if ($dataType == 'password'): ?>
        
        
            <form method="POST">
                <h2>Cambiar Contraseña: </h2>
                <input type="hidden" name="dataType" value="password">
                <input type="password" name="newPassword" placeholder="Nueva Contraseña">
                <input type="password" name="confirmPassword" placeholder="Confirmar Nueva Contraseña">
                <input type="submit" value="Cambiar Contraseña">
            </form>
        <?php elseif ($dataType == 'email'): ?>
            <form method="POST">
                <h2>Cambiar Correo Electrónico: </h2>
                <input type="hidden" name="dataType" value="email">
                <input type="email" name="new_value" placeholder="Nuevo Correo Electrónico">
                <input type="submit" value="Cambiar Correo">
            </form>
        <?php elseif ($dataType == 'username'): ?>
            <form method="POST">
                <h2>Cambiar Nombre de Usuario: </h2>
                <input type="hidden" name="dataType" value="username">
                <input type="text" name="new_value" placeholder="Nuevo Nombre de Usuario">
                <input type="submit" value="Cambiar Nombre">
            </form>
        <?php elseif ($dataType == 'cartera'): ?>
            <form method="POST">
                <h2>Cambiar Cartera: </h2>
                <input type="hidden" name="dataType" value="cartera">
                <input type="cartera" name="newCartera" placeholder="Nueva Cartera">
                <input type="cartera" name="confirmCartera" placeholder="Confirmar Nueva Cartera">
                <input type="submit" value="Cambiar Cartera">
            </form>
        <?php endif; ?>

        <a class="boton1" href="/modDatos">Volver</a>
        