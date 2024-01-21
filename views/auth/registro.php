<!--Se importan los css necesarios-->
<link rel="stylesheet" href="../../build/css/registro.css">
<main>
    <!-- Formulario para el registro -->
    <form method="POST" action="/registro" enctype="multipart/form-data">
        <h3>Registro</h3>

        <?php foreach($errores as $error){ ?>
            <!-- Se imprimen los errores si existen -->
            <div style="color: red;">
                <?php echo $error; ?>
            </div>

        <?php } ?>

        <label for="usuario">Usuario:</label>
        <input type="text" placeholder="Nombre de usuario" id="usuario" name="username" value="<?php echo $usuario->username; ?>">

        <label for="email">Email:</label>
        <input type="email" placeholder="Correo Electrónico" id="email" name="email" value="<?php echo $usuario->email; ?>">

        <label for="password">Contraseña:</label>
        <div class="mostrar">
            <input type="password" placeholder="Password" id="cont1" name="password" value="">
            <!-- Botón para ver u ocultar la contraseña -->
            <button type="button" name="password" onclick="clickBoton('cont1', 'vis1')">
                <p id="vis1">
                    <img src="../../build/img/icons/bloq.svg" alt="">
                </p>
            </button>
        </div>

        <label for="password2">  Repetir constraseña:</label>
        <div class="mostrar">
            <input type="password" placeholder="Password" id="cont2" name="password2" value="">
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
            <option <?php echo $usuario->tipo==1?'selected':'';?> value="1">Comprador</option>
            <option <?php echo $usuario->tipo==2?'selected':'';?> value="2">Vendedor</option>
            <option <?php echo $usuario->tipo==3?'selected':'';?> value="3">Distribuidor</option>
        </select>

        <div class="user_actions">
        <form action="/registro2" method="POST">
                <!--Corregir butón que pasa a ser submit -->
                    <button type="submit">Modificar Datos</button>
                </form>
            <!-- <input type="submit" value="Registrarme" class="registro"> -->
            <!-- Botón para ir al registro -->
            <p>¿Ya tienes cuenta? Entra <a href="/login">aquí</a></p>
        </div>
    </form>
</main>
<!-- Se incluye los archivos de javascript -->
<script src="../../build/js/contraseña.js"></script>
</body>
</html>
