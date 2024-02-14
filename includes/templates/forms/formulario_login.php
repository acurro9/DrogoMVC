
        <!-- Campo de entrada para el nombre de usuario o email -->
        <label for="usuario">Usuario:</label>
        <input type="text" placeholder="Nombre de usuario o Email" id="usuario" name="username">
        <!-- Campo de entrada para la contraseña -->
        <label for="password">Contraseña:</label>
        <div class="mostrar">
            <input type="password" placeholder="Password" id="cont" name="password">
            <!-- Botón para mostrar/ocultar contraseña -->
            <button type="button" name="password" onclick="clickBoton('cont', 'vis')">
             <!-- El estado de visibilidad de la contraseña se indica con un ícono -->
                <p id="vis">
                    <img src="../build/img/icons/bloq.svg" alt="">
                </p>
            </button>
        </div>

        <div class="user_actions">
        <!-- Botón para iniciar sesión -->
        <input type="submit" value="Iniciar Sesión" class="boton_login">
        <!-- Enlace para registrarse si el usuario no tiene cuenta -->
            <p>¿Aún no tienes cuenta? Regístrate <span><a href="registro.php">aquí</a></span></p>
        </div>