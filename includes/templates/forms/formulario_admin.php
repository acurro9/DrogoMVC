<!-- Sección de entrada del nombre de usuario o email -->
<label for="usuario">Usuario:</label>
        <input type="text" placeholder="Nombre de usuario o Email" id="usuario" name="usuario">
        <!-- Sección de entrada de contraseña -->
        <label for="password">Contraseña:</label>
        <div class="mostrar">
           <!-- Botón para mostrar/ocultar la contraseña, mejora la usabilidad permitiendo a los usuarios verificar su contraseña antes de enviarla -->    
        <input type="password" placeholder="Password" id="cont" name="password">
            <button type="button" name="password" onclick="clickBoton('cont', 'vis')">
              <!-- Ícono que indica la acción de mostrar/ocultar contraseña, se debe implementar la función `clickBoton` para cambiar la visibilidad de la contraseña -->    
            <p id="vis">
                    <img src="../build/img/icons/bloq.svg" alt="">
                </p>
            </button>
        </div>

        <div class="user_actions">
        <!-- Botón para iniciar sesión -->
            <input type="submit" value="Iniciar Sesión" class="boton_login">
        </div>