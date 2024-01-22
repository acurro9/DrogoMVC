<!-- Formulario del registro de la cartera -->
<link rel="stylesheet" href="../../build/css/registro.css">
<form method="POST" action="/registro2">
    <h3>Finalizar registro</h3>

    <?php foreach($errores as $error): ?>
        <div style="color: red;">
            <?php echo $error; ?>
        </div>
    <?php endforeach; ?>

    <label for="usuario">Usuario:</label>
    <input type="text" placeholder="Nombre de usuario" id="usuario" name="usuario" value="<?php echo htmlspecialchars($username); ?>">

    <label for="cartera">Cartera:</label>
    <input type="text" placeholder="Hash Cartera" id="cartera" name="cartera">

    <div class="user_actions">
        <input type="submit" value="Registrarme" class="registro">
    </div>
</form>