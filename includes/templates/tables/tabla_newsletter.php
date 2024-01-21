<thead>
    <tr>
        <th>Email</th>
        <th>Borrar</th>
    </tr>
</thead>
<tbody>
<?php while ($fila=mysqli_fetch_assoc($datos)){ ?>
    <tr>
        <td><?php echo $fila['email']; ?></td>
        <td class="centrar">
            <!-- Formulario para borrar un email -->
            <form action="<?php $_SERVER[ 'PHP_SELF' ]; ?>" method="post" onsubmit="return confirmEliminado()" class="formEliminado">
                <input class="bTabla" type="submit" value=" ">
                <input class="oculto" type="hidden" name="id" value=<?php echo $fila['email'];?>>
            </form>
        </td>
    </tr>
<?php } ?>
</tbody>