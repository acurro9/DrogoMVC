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
        <?php while ($fila=mysqli_fetch_assoc($result)){ $hash_usuario=$fila['id'];?>
            <tr>
                <td><?php echo $fila['id']; ?></td>
                <td><?php echo $fila['username']; ?></td>
                <td><?php echo $fila['email']; ?></td>
                <td><?php echo $fila['tipo']; ?></td>
                <td>
                    <div class="bloque">
                        <?php 
                        // Para saber si el usuario está bloqueado o no y manda en la url la información necesaria
                            $query="SELECT username from bloqueado where id like '$hash_usuario';";
                            $resultado=mysqli_query($db, $query);
                            if($resultado->num_rows){
                                $action=2;
                                echo "Sí";
                            } else{
                                $action=1;
                                echo "No";
                            }
                        ?>
                        <a href="/bloquearUsuario.php?id=<?php echo $hash_usuario;?>&action=<?php echo $action;?>" class="bTabla act ult">
                            <!-- <center> -->
                                <img src="../build/img/icons/edit.svg" alt="">
                            <!-- </center> -->
                        </a>
                    </div>
                </td>
                <!-- En caso de que no sea administrador el usuario de la tabla nos permite editar sus datos -->
                <?php if($fila['tipo']!='Administrador'){ ?>
                    <td>
                        <center>
                            <a href="/Usuarios/actualizarUsuario.php?usuario=<?php echo $fila['id'];?>" class="bTabla act"><img src="../build/img/icons/writer.svg" alt=""></a>
                        </center>
                    </td>
                <?php } else {?>
                    <td><img src="../build/img/icons/ban.svg" alt=""></td>
                <?php }?>
            </tr>
        <?php } ?>
        </tbody>