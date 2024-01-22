<?php foreach($errores as $error): ?>
    <!-- Se imprimen los errores si los hay -->
    <div class="alerta error">
        <?php echo $error; ?>
    </div>
<?php endforeach; ?>

<!--Se importan los css necesarios-->
<link rel="stylesheet" href="../../public/build/css/login.css">
<link rel="stylesheet" href="../../public/build/css/loginAdmin.css">

<!-- Formulario del login del administrador -->
<form method="POST" action="/loginAdmin" enctype="multipart/form-data">
    <h4 class="adminTitle">Área de administrador</h4>    
    <h3>Inicio de sesión</h3>

    <label for="usuario">Usuario:</label>
    <input type="text" placeholder="Nombre de usuario o Email" id="usuario" name="usuario">

    <label for="password">Contraseña:</label>
    <div class="mostrar">
        <input type="password" placeholder="Password" id="cont" name="password">
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
<script src="../../public/build/js/contraseña.js"></script>
<script src="../../public/build/js/index.js"></script>
</body>
</html>