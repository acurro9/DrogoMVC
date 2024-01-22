
<link rel="stylesheet" href="../build/css/usuarios.css">
<link rel="stylesheet" href="../build/css/styles.css">
<main>
    <h1 class="abajo">Usuarios</h1>
    <div class="centrado">
        <form class="paginado" method="GET">
            <fieldset>
                <legend style="color: white;">Usrs x pag: </legend>
                <div class="cen">
                    <select name="producto">
                        <option <?= $ppp == 3 ? 'selected' : '' ?> value="3">3</option>
                        <option <?= $ppp == 5 ? 'selected' : '' ?> value="5">5</option>
                        <option <?= $ppp == 10 ? 'selected' : '' ?> value="10">10</option>
                        <option <?= $ppp == 20 ? 'selected' : '' ?> value="20">20</option>
                    </select>
                    <input type="submit" value="Actualizar" class="">
                </div>
            </fieldset>
        </form>
    </div>

    <table class="tabla">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre de Usuario</th>
                <th>Email</th>
                <th>Tipo</th>
                <th>Bloqueado</th>
                <th>Actualizar</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($usuarios as $usuario): ?>
                <tr>
                    <td><?= $usuario->id ?></td>
                    <td><?= $usuario->username ?></td>
                    <td><?= $usuario->email ?></td>
                    <td><?= $usuario->tipo ?></td>
                    <td>    
                        <div class="bloque">
                        <?= $usuario->bloqueado ? 'Sí' : 'No' ?>
                      
                        <!-- Enlace para bloquear/desbloquear usuario -->
                        <a href="/bloquearUsuario?id=<?= $usuario->id; ?>">
                            <img src="../../build/img/icons/edit.svg" alt="<?= $usuario->bloqueado ? 'Desbloquear' : 'Bloquear'; ?>">
                        </a>
                        </div>
                    </td>
                    <td>
                        <?php if ($usuario->tipo != 'Administrador'): ?>
                            <!-- Enlace para actualizar datos del usuario -->
                            <a href="./actualizarUsuario?usuario=<?= $usuario->id; ?>" class="boton-accion">
                                <img src="../../build/img/icons/writer.svg" alt="Actualizar">
                            </a>

                        <?php else: ?>
                            <img src="/../../build/img/icons/ban.svg" alt="No editable">
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <div class="pagComplete">
        <!-- Implementar la paginación -->
        <?php for ($i = 1; $i <= $totalPaginas; $i++): ?>
            <a href="?producto=<?= $ppp ?>&pagina=<?= $i ?>" class="<?= $paginaActual == $i ? 'active' : '' ?>"><?= $i ?></a>
        <?php endfor; ?>
    </div>

    <div class="centro">
        <a href="/areaPersonalAdmin" class="buton grande">Volver</a>
    </div>
</main>

<!-- Se incluye los archivos de javascript -->
<script src="../../build/js/index.js"></script>
