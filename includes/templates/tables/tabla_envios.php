<thead>
            <tr>
                <th>ID</th>
                <th>refCompra</th>
                <th>Fecha de recogida</th>
                <th>Fecha de depósito</th>
                <th>Locker de depósito</th>
                <th>Locker de origen</th>
                <!-- Esto solo aparece si se es administrador -->
                <?php if($tipo=='Administrador'){?>
                    <th>Distribuidor</th>  
                    <th>Operaciones</th> 
                <?php }?>
            </tr>
        </thead>
        <tbody>
        <?php while ($fila=mysqli_fetch_assoc($datos)){ ?>
            <tr>
                <td><?php echo $fila['id']; ?></td>
                <td><?php echo $fila['refCompra']; ?></td>
                <td><?php echo $fila['fechaRecogida']; ?></td>
                <td><?php echo $fila['fechaDeposito']; ?></td>
                <td><?php echo $fila['lockerOrigen']; ?></td>
                <td><?php echo $fila['lockerDeposito']; ?></td>

                <!-- Esto solo aparece si se es administrador -->
                <?php if($tipo=='Administrador'){ ?>
                    <td><?php echo $fila['hash_distribuidor']; ?></td>
                    <td>
                        <div class="bloque">
                            <!-- Formulario para eliminar el pedido seleccionado -->
                            <form action="<?php $_SERVER[ 'PHP_SELF' ]; ?>" method="post" onsubmit="return confirmEliminado()" class="formEliminado">
                                <input class="bTabla" type="submit" value=" ">
                                <input class="oculto" type="hidden" name="refCompra" value=<?php echo $fila['id'];?>>
                            </form>
                            <a href="/Pedidos/distribuidor.php?pedido=<?php echo $fila['refCompra'];?>" class="bTabla act"><img src="../build/img/icons/writer.svg" alt=""></a>
                </div>
                <?php } ?>
                </td>
            </tr>
        <?php } ?>
        </tbody>