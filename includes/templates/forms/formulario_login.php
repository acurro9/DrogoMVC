
        <label for="usuario">Usuario:</label>
        <input type="text" placeholder="Nombre de usuario o Email" id="usuario" name="username">

        <label for="password">Contraseña:</label>
        <div class="mostrar">
            <input type="password" placeholder="Password" id="cont" name="password">
            <button type="button" name="password" onclick="clickBoton('cont', 'vis')">
                <p id="vis">
                    <img src="../build/img/icons/bloq.svg" alt="">
                </p>
            </button>
        </div>

        <div class="user_actions">
        <!-- Botón para iniciar sesión -->
        <input type="submit" value="Iniciar Sesión" class="boton_login">
        <!-- Botón para ir al registro -->
            <p>¿Aún no tienes cuenta? Regístrate <span><a href="registro.php">aquí</a></span></p>
        </div>