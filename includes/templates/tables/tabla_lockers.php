<thead>
    <tr>
        <th>Referencia del Locker</th>
        <th>Direccion del Locker</th>
        <th>Contraseña del Locker</th>
        <th>Operaciones</th>
    </tr>
</thead>
<tbody>
    <?php while ($fila=mysqli_fetch_assoc($datos)){ ?>
        <tr>
            <td><?php echo $fila['refLocker'] ?></td>
            <td><?php echo $fila['direccion'] ?></td>
            <td><?php echo $fila['passwordLocker'] ?></td>
            <td>
                <div class="bloque">
                    <!-- Formulario para eliminar el locker seleccionado -->
                    <form action="<?php $_SERVER[ 'PHP_SELF' ]; ?>" method="post" onsubmit="return confirmEliminado()" class="formEliminado">
                        <input class="bTabla" type="submit" value=" ">
                        <input class="oculto" type="hidden" name="refLocker" value=<?php echo $fila['refLocker'];?>>
                    </form>
                    <a href="/Lockers/actualizarLockers.php?locker=<?php echo $fila['refLocker'];?>" class="bTabla act"><img src="../build/img/icons/writer.svg" alt=""></a>
                </div>
            </td>
        </tr>
    <?php } ?>
</tbody>