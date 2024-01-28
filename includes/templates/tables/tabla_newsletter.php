<thead>
    <tr>
        <th>Email</th>
        <th>Borrar</th>
    </tr>
</thead>
<tbody>
<?php foreach ($newsletters as $news): ?>
    <tr>
        <td><?= $news->email ?></td>
        <td class="centrar">
            <!-- Formulario para borrar un email -->
            <form action="/borrarNewsletter?id=<?php echo $news->email;?>" method="post" onsubmit="return confirmEliminado()" class="formEliminado">
                <input class="bTabla" type="submit" value=" ">
                <input class="oculto" type="hidden" name="id" value=<?php echo $news->email?>>
            </form>
        </td>
    </tr>
<?php endforeach; ?>
</tbody>