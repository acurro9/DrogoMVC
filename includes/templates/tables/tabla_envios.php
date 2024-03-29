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
        <?php foreach ($envios as $envio):  ?>
            <tr>
                <td><?= $envio->id; ?></td>
                <td><?= $envio->refCompra; ?></td>
                <td><?= $envio->fechaRecogida; ?></td>
                <td><?= $envio->fechaDeposito; ?></td>
                <td><?= $envio->lockerOrigen; ?></td>
                <td><?= $envio->lockerDeposito; ?></td>

                <!-- Esto solo aparece si se es administrador -->
                <?php if($tipo=='Administrador'){ $cont=0;?>
                    <?php for($x=0; $x<count($user); $x++){ 
                        if($user[$x][0]==$envio->hash_distribuidor){?>
                        <td><?php echo $user[$x][1]; $cont++; ?></td>
                    <?php } } if($cont == 0){ ?> 
                        <td> </td>    
                    <?php } ?>
                    <td>
                        <div class="bloque">
                            <!-- Formulario para eliminar el pedido seleccionado -->
                            <form action="/borrarEnvio?id=<?= $envio->id;?>" method="post" onsubmit="return confirmEliminado()" class="formEliminado">
                                <input class="bTabla" type="submit" value=" ">
                                <input class="oculto" type="hidden" name="refCompra" value=<?= $envio->id;?>>
                            </form>
                            <a href="/actualizarEnvio?id=<?= $envio->refCompra; ?>" class="bTabla act"><img src="../build/img/icons/writer.svg" alt=""></a>
                </div>
                <?php } ?>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>