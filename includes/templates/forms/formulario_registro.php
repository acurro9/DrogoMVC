<label for="usuario">Usuario:</label>
    <input type="text" placeholder="Nombre de usuario" id="usuario" name="usuario" value="<?php echo $usuario; ?>">

    <label for="email">Email:</label>
    <input type="email" placeholder="Correo Electrónico" id="email" name="email" value="<?php echo $email; ?>">

    <label for="password">Contraseña:</label>
    <div class="mostrar">
        <input type="password" placeholder="Password" id="cont1" name="password" value="<?php echo $contraseña; ?>">
        <!-- Botón para ver u ocultar la contraseña -->
        <button type="button" name="password" onclick="clickBoton('cont1', 'vis1')">
            <p id="vis1">
                <img src="../build/img/icons/bloq.svg" alt="">
            </p>
        </button>
    </div>

    <label for="password2">  Repetir constraseña:</label>
    <div class="mostrar">
        <input type="password" placeholder="Password" id="cont2" name="password2" value="<?php echo $contraseña2; ?>">
        <!-- Botón para ver u ocultar la contraseña -->
        <button type="button" name="password" onclick="clickBoton('cont2', 'vis2')">
            <p id="vis2">
                <img src="../build/img/icons/bloq.svg" alt="">
            </p>
        </button>
    </div>

    <label for="tipo">Seleccione su perfil: </label>
    <!-- Desplegable para indicar el tipo de usuario (el admin no se puede crear con el formulario, se hace desde la base de datos) -->
    <select name="tipo">
        <option value=""></option>
        <option <?php echo $tipo==1?'selected':'';?> value="1">Comprador</option>
        <option <?php echo $tipo==2?'selected':'';?> value="2">Vendedor</option>
        <option <?php echo $tipo==3?'selected':'';?> value="3">Distribuidor</option>
    </select>

    <div class="user_actions">
        <input type="submit" value="Registrarme" class="registro">
        <!-- Botón para ir al registro -->
        <p>¿Ya tienes cuenta? Entra <a href="login.php">aquí</a></p>
    </div>