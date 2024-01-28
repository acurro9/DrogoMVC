<label for="usuario">Usuario:</label>
        <input type="text" placeholder="Nombre de usuario" id="usuario" name="username">

        <label for="email">Email:</label>
        <input type="email" placeholder="Correo Electrónico" id="email" name="email">

        <label for="password">Contraseña:</label>
        <div class="mostrar">
            <input type="password" placeholder="Password" id="cont1" name="password">
            <!-- Botón para ver u ocultar la contraseña -->
            <button type="button" name="password" onclick="clickBoton('cont1', 'vis1')">
                <p id="vis1">
                    <img src="../../build/img/icons/bloq.svg" alt="">
                </p>
            </button>
        </div>

        <label for="password2">  Repetir constraseña:</label>
        <div class="mostrar">
            <input type="password" placeholder="Password" id="cont2" name="password2">
            <!-- Botón para ver u ocultar la contraseña -->
            <button type="button" name="password" onclick="clickBoton('cont2', 'vis2')">
                <p id="vis2">
                    <img src="../../build/img/icons/bloq.svg" alt="">
                </p>
            </button>
        </div>

        <label for="tipo">Seleccione su perfil: </label>
        <!-- Desplegable para indicar el tipo de usuario (el admin no se puede crear con el formulario, se hace desde la base de datos) -->
        <select name="tipo">
            <option value=""></option>
            <option value="1">Comprador</option>
            <option value="2">Vendedor</option>
            <option value="3">Distribuidor</option>
        </select>

        <div class="user_actions">
        <form action="/registro" method="POST">
                <!--Corregir butón que pasa a ser submit -->
                    <button type="submit" class="registro">Registrarme</button>
                    
                </form>
            <!-- Botón para ir al login -->
            <p>¿Ya tienes cuenta? Entra <a href="/login">aquí</a></p>
        </div>