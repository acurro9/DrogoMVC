<thead>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Correo</th>
            <th>Teléfono</th>
            <th>Mensaje</th>
            <th>Operaciones</th>
        </tr>
    </thead>
    <tbody>
    <?php while ($fila=mysqli_fetch_assoc($datos)){ ?>
        <tr>
            <td><?php echo $fila['id']; ?></td>
            <td><?php echo $fila['nombre']; ?></td>
            <td><?php echo $fila['email']; ?></td>
            <td><?php echo $fila['telefono']; ?></td>
            <td><?php echo $fila['mensaje']; ?></td>
            <td class="centrar">
                <!-- Formulario para eliminar un mensaje -->
                <form action="<?php $_SERVER[ 'PHP_SELF' ]; ?>" method="post" onsubmit="return confirmEliminado()" class="formEliminado">
                    <input class="bTabla" type="submit" value=" ">
                    <input class="oculto" type="hidden" name="id" value=<?php echo $fila['id'];?>>
                </form>
            </td>
        </tr>
    <?php } ?>
    </tbody>