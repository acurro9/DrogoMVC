<label for="usuario">Usuario:</label>
<input type="text" placeholder="Nombre de usuario" id="usuario" name="usuario" value="<?php echo $user; ?>" readonly="readonly">

<label for="cartera">Cartera:</label>
<input type="text" placeholder="Hash Cartera" id="cartera" name="cartera">

<form action="/registro2" method="POST">
<!--Corregir butón que pasa a ser submit -->
    <button type="submit" class="registro">Registrarme</button>
    
</form>