        <thead>
            <tr>
                <th>Referencia Pedido</th>
                <th>Fecha Pedido</th>
                <th>Importe</th>
                <th>Locker del envio</th>
                <th>Dirección</th>
                <!-- En el caso del comprador -->
                <?php if($tipo=='Comprador'){?>
                    <th>Fecha Recogida</th>    
                <!-- En el caso del vendedor -->
                <?php } else if($tipo=='Vendedor'){?>
                    <th>Fecha Deposito</th>
                    <th>Cargo de Transporte</th>
                    <th>Cargos Adicionales</th>
                    <th>Distribuidor</th>
                <!-- En el caso del administrador -->
                <?php } else if($tipo=='Administrador'){ ?>
                    <th>Fecha Recogida</th>
                    <th>Fecha Deposito</th>
                    <th>Cargo de Transporte</th>
                    <th>Cargos Adicionales</th>
                    <th>Comprador</th>
                    <th>Vendedor</th>
                    <th>Distribuidor</th>
                    <th>Operaciones</th>
                <?php } ?>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($pedidos as $pedido): ?>
            <tr>
                <td><?= $pedido->refCompra?></td>
                <td><?= $pedido->fechaCompra?></td>
                <td><?= $pedido->importe?></td>
                <td><?= $pedido->refLocker?></td>
                <td class="direccion"><?= $pedido->direccion?></td>
                <!-- En el caso del comprador -->
                <?php if($tipo=='Comprador'){?>
                    <td><?= $pedido->fechaRecogida?></td>
                <!-- En el caso del vendedor -->
                <?php } else if($tipo=='Vendedor'){?>
                    <td><?= $pedido->fechaDeposito?></td>
                    <td><?= $pedido->cargoTransporte?></td>
                    <td><?= $pedido->cargosAdicionales?></td> 
                    <!-- Dependiendo de si hay distribución o no aparece una cosa u otra -->
                    <td>
                        <div class="row">
                            <p><?= $pedido->distribuidor==1?'Si':'No'?></p>
                            <?php 
                                if($pedido->distribuidor==1){?>
                                    <a href="" class="act"><img src="../build/img/icons/edit.svg" alt=""></a>
                            <?php } ?>
                        </div>
                    </td> 
                    <!-- En el caso del administrador -->
                <?php } else if($tipo=='Administrador'){ ?>
                    <td><?= $pedido->fechaRecogida?></td>
                    <td><?= $pedido->fechaDeposito?></td>
                    <td><?= $pedido->cargoTransporte?></td>
                    <td><?= $pedido->cargosAdicionales?></td>
                    <td><?= $pedido->hash_comprador?></td>
                    <td><?= $pedido->hash_vendedor?></td>
                    <!-- Dependiendo de si hay distribución o no aparece una cosa u otra -->
                    <td>
                        <div class="row">
                            <p><?= $pedido->distribuidor==1?'Si':'No'?></p>
                            <?php 
                                if($pedido->distribuidor==1){?>
                                    <a href="" class="act"><img src="../build/img/icons/edit.svg" alt=""></a>
                            <?php } ?>
                        </div>
                    </td> 
                    <td>
                        <!-- Formulario para eliminar el pedido seleccionado -->
                        <div class="bloque">
                            <form action="<?php $_SERVER[ 'PHP_SELF' ]; ?>" method="post" onsubmit="return confirmEliminado()" class="formEliminado">
                                <input class="bTabla" type="submit" name="borrar" value=" ">
                                <input class="oculto" type="hidden" name="refCompra" value=<?= $pedido->refCompra;?>>
                            </form>
                            <a href="/actualizarPedido.php?id=<?= $pedido->refCompra;?>" class="bTabla act"><img src="../build/img/icons/writer.svg" alt=""></a>
                </div>
                <?php } ?>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>