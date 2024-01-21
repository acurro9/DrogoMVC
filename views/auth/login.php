<?php 
//Vista login

    foreach ($errores as $error) {
        // Se imprimen los errores si los hay
    ?>
        <div class="alerta error">
            <?php echo $error; ?>
        </div>
    <?php
    }
?>

    <!--Se importan los css necesarios-->
    <link rel="stylesheet" href="../../build/css/login.css">
    <!-- Formulario para el inicio de sesión -->
    <form method="POST" action="/login">
        <h3>Inicio de sesión</h3>
        <!-- Para evitar elcross-site-scripting!-->        
        <label for="username">Usuario:</label>
        <input type="text" placeholder="Nombre de usuario o Email" id="username" name="username">


        <label for="password">Contraseña:</label>
        <div class="mostrar">
        <input type="password" placeholder="Tu Password" id="password" name="password">
            <button type="button" name="password" onclick="clickBoton('cont', 'vis')">
                <p id="vis">
                    <img src="../../public/build/img/icons/bloq.svg" alt="">
                </p>
            </button>
        </div>

        <div class="user_actions">
        <!-- Botón para iniciar sesión -->
        <input type="submit" value="Iniciar Sesión" class="boton">
        <!-- Botón para ir al registro -->
            <p>¿Aún no tienes cuenta? Regístrate <span><a href="registro">aquí</a></span></p>
        </div>

    </form>
    <!-- Se incluye los archivos de javascript -->
    <script src="./js/contraseña.js"></script>
</body>
</html>