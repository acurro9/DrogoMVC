        <thead>
            <!-- Encabezados de la tabla con las propiedades del usuario a mostrar -->
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
             <!-- Iteración sobre cada usuario para mostrar sus datos en la tabla -->
            <?php foreach ($usuarios as $usuario): ?>
                <tr>
                    <td><?= $usuario->id ?></td>
                    <td><?= $usuario->username ?></td>
                    <td><?= $usuario->email ?></td>
                    <td><?= $usuario->tipo ?></td>
                    <td>    
                        <div class="bloque">
                        <?= $usuario->bloqueado ? 'Sí' : 'No' ?>
                      
                       <!-- Enlace para bloquear/desbloquear usuario. La acción cambia según el estado actual del usuario -->
                        <a href="/bloquearUsuario?id=<?= $usuario->id; ?>">
                            <img src="../build/img/icons/edit.svg" alt="<?= $usuario->bloqueado ? 'Desbloquear' : 'Bloquear'; ?>">
                        </a>
                        </div>
                    </td>
                    <td>
                        <!-- Condición para permitir la actualización de usuarios que no sean Administradores -->
                        <?php if ($usuario->tipo != 'Administrador'): ?>
                            <!-- Enlace para actualizar datos del usuario -->
                            <a href="./actualizarUsuario?usuario=<?= $usuario->id; ?>" class="boton-accion">
                                <img src="../build/img/icons/writer.svg" alt="Actualizar">
                            </a>

                        <?php else: ?>
                            <img src="../build/img/icons/ban.svg" alt="No editable">
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>