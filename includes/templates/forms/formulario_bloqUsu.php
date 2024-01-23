<!-- <fieldset>
            <h1>Buscar Usuario: </h1>
    
            <label for="name">Nombre de usuario: </label>
            <input type="text" name="name" placeholder="Username">
    
            <label for="email">Correo electrónico: </label>
            <input type="email" name="correo" placeholder="Email">
    
            <label for="id">Hash de usuario: </label>
            <input type="text" name="id" placeholder="ID">
    
            <input type="submit" name="buscar" value="Buscar">
        </fieldset>
    </form> -->

    <!-- Formulario para bloquear o desbloquear al usuario -->
    <!-- Asumiendo que $usuario es el usuario encontrado y $accion es el estado del bloqueo -->
    <?php 
    // if (isset($usuario)): 
    ?>
        <!-- <form action="bloquearUsuario" method="POST" class="formu"> -->
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