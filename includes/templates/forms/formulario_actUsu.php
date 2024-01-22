<fieldset>
        <legend>Actualizar Usuario:</legend>

        <label for="id">ID:</label>
        <input type="text" name="id" value="<?= htmlspecialchars($usuario->id); ?>" readonly>
      
        <label for="nombre">Nombre de usuario:</label>
        <input type="text" name="username" value="<?= htmlspecialchars($usuario->username); ?>">

        <label for="correo">Email:</label>
        <input type="text" name="email" value="<?= htmlspecialchars($usuario->email); ?>">

        <label for="password">Contraseña:</label>
        <input type="password" name="password" value="">

        <label for="tipo">Tipo de usuario:</label>
        <select name="tipo">
            <option value=""></option>
            <option value="1" <?php echo $usuario->tipo == 1 || $usuario->tipo == 'Comprador' ? 'selected' : ''; ?>>Comprador</option>
            <option value="2" <?php echo $usuario->tipo == 2 || $usuario->tipo == 'Vendedor' ? 'selected' : ''; ?>>Vendedor</option>
            <option value="3" <?php echo $usuario->tipo == 3 || $usuario->tipo == 'Distribuidor' ? 'selected' : ''; ?>>Distribuidor</option>
        </select>


        <div class="botones">
            <input type="submit" value="Actualizar Usuario" class="registro">
            <a href="/usuario" class="buton">Volver</a>
        </div>
    </fieldset>