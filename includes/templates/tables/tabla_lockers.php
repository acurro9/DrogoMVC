<thead>
    <tr>
        <th>Referencia del Locker</th>
        <th>Direccion del Locker</th>
        <th>Contraseña del Locker</th>
        <th>Operaciones</th>
    </tr>
</thead>
<tbody>
<?php foreach ($lockers as $locker): ?>
        <tr>
            <td><?=$locker->refLocker ?></td>
            <td><?=$locker->direccion ?></td>
            <td><?=$locker->passwordLocker ?></td>
            <td>
                <div class="bloque">
                    <!-- Formulario para eliminar el locker seleccionado -->
                    <form action="/borrarLocker?id=<?php echo $locker->refLocker; ?>" method="post" onsubmit="return confirmEliminado()" class="formEliminado">
                        <input class="bTabla" type="submit" value=" ">
                        <input class="oculto" type="hidden" name="refLocker" value=<?=$locker->refLocker ?>>
                    </form>
                    <a href="/actualizarLocker?locker=<?=$locker->refLocker ?>" class="bTabla act"><img src="../build/img/icons/writer.svg" alt=""></a>
                </div>
            </td>
        </tr>
    <?php endforeach; ?>
</tbody>