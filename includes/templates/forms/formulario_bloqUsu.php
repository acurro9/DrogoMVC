<fieldset>
            <h1>Buscar Usuario: </h1>
    
            <label for="name">Nombre de usuario: </label>
            <input type="text" name="name" placeholder="Username">
    
            <label for="email">Correo electrónico: </label>
            <input type="email" name="correo" placeholder="Email">
    
            <label for="id">Hash de usuario: </label>
            <input type="text" name="id" placeholder="ID">
    
            <input type="submit" name="buscar" value="Buscar">
    
        </fieldset>
    </form>
    <!-- Formulario para bloquear o desbloquear al usuario -->
    <form method="POST" enctype="multipart/form-data" class="formu" onsubmit="return <?php echo $action==1?'confirmBloq()':'confirmDisbloq()'; ?>">
        <fieldset>
            <h1><?php echo $act; ?> Usuario: </h1>
            <label for="name">Nombre de usuario: </label>
            <input type="text" name="nameBloq" placeholder="Username" value="<?php echo $userBloq;?>">
    
            <label for="email">Correo electrónico: </label>
            <input type="email" name="correoBloq" placeholder="Email" value="<?php echo $emailBloq;?>">
    
            <label for="id">Hash de usuario: </label>
            <input type="text" name="idBloq" placeholder="ID" value="<?php echo $idBloq;?>">
    
            <input type="submit" name="bloquear" value="<?php echo $act; ?>">
    
        </fieldset>