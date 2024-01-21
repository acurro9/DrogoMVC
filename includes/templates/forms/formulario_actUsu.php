<fieldset>
        <legend>Actualizar Usuario: </legend>

        <label for="id">ID: </label>
        <input type="text" name="id" value="<?php echo $ref; ?>">

        <label for="">Nombre de usuario: </label>
        <input type="text" name="nombre" value="<?php echo $nombre; ?>">

        <label for="">Email: </label>
        <input type="text" name="correo" value="<?php echo $correo; ?>">

        <label for="">Contraseña: </label>
        <input type="text" name="password" value="<?php echo $cont; ?>">

        <label for="tipo">Tipo de usuario: </label>
        <!-- Desplegable con las opciones de tipo de usuario -->
        <select name="tip">
            <option value=""></option>
            <option <?php echo $tip==1||$tip=='Comprador'?'selected':'';?> value="1">Comprador</option>
            <option <?php echo $tip==2||$tip=='Vendedor'?'selected':'';?> value="2">Vendedor</option>
            <option <?php echo $tip=='Distribuidor'||$tip==3?'selected':'';?> value="3">Distribuidor</option>
    </select>
        <!-- Botones de volver y de actualizar -->
        <div class="botones">
            <input type="submit" value="Actualizar Usuario" class="registro">
            <a href="/Usuarios/usuario.php" class="buton">Volver</a>
        </div>
    </fieldset>