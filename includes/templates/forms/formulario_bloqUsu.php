            <fieldset>
                <h1><?= $accion == 1 ? 'Bloquear' : 'Desbloquear'; ?> Usuario: </h1>
                <input type="hidden" name="action" value="<?= $accion; ?>">
                <input type="hidden" name="idBloq" value="<?= $usuario->buscarID($usuario->username); ?>" readonly>

                <label for="nameBloq">Nombre de usuario: </label>
                <input type="text" name="nameBloq" value="<?= $usuario->username; ?>" readonly>
        
                <label for="correoBloq">Correo electrónico: </label>
                <input type="email" name="correoBloq" value="<?= $usuario->email; ?>" readonly>
        
                <input type="submit" name="bloquear" value="<?= $accion == 1 ? 'Bloquear' : 'Desbloquear'; ?>">
            </fieldset>
            <?php
            //  endif;
             ?>