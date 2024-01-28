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
    <?php foreach ($contactos as $contacto): ?>
        <tr>
            <td><?= $contacto->id;?></td>
            <td><?= $contacto->nombre;?></td>
            <td><?= $contacto->email;?></td>
            <td><?= $contacto->telefono;?></td>
            <td><?= $contacto->mensaje;?></td>

            <td class="centrar">
                <!-- Formulario para eliminar un mensaje -->
                <form action="/borrarContacto?id=<?php echo $contacto->id;?>" method="post" onsubmit="return confirmEliminado()" class="formEliminado">
                    <input class="bTabla" type="submit" value=" ">
                    <input class="oculto" type="hidden" name="id" value=<?php echo $contacto->id;?>>
                </form>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>