


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
        <?php while ($fila=mysqli_fetch_assoc($datos)){ ?>
            <tr>
                <td><?php echo $fila['refCompra']; ?></td>
                <td><?php echo $fila['fechaCompra']; ?></td>
                <td><?php echo $fila['importe']; ?></td>
                <td><?php echo $fila['refLocker']; ?></td>
                <td class="direccion"><?php echo $fila['direccion']; ?></td>
                <!-- En el caso del comprador -->
                <?php if($tipo=='Comprador'){?>
                    <td><?php echo $fila['fechaRecogida'];?></td>   
                <!-- En el caso del vendedor -->
                <?php } else if($tipo=='Vendedor'){?>
                    <td><?php echo $fila['fechaDeposito'];?></td>   
                    <td><?php echo $fila['cargoTransporte'];?></td>   
                    <td><?php echo $fila['cargosAdicionales'];?></td>   
                    <!-- Dependiendo de si hay distribución o no aparece una cosa u otra -->
                    <td>
                        <div class="row">

                            <p><?php echo $fila['distribuidor']==1?'Si':'No';?></p>
                            <?php 
                                if($fila['distribuidor']==1){?>
                                    <a href="/Pedidos/distribuidor.php?pedido=<?php echo $fila['refCompra'];?>" class="act"><img src="../build/img/icons/edit.svg" alt=""></a>
                            <?php } ?>
                        </div>
                    </td> 
                    <!-- En el caso del administrador -->
                <?php } else if($tipo=='Administrador'){ ?>
                    <td><?php echo $fila['fechaRecogida'];?></td>   
                    <td><?php echo $fila['fechaDeposito'];?></td>  
                    <td><?php echo $fila['cargoTransporte'];?></td>   
                    <td><?php echo $fila['cargosAdicionales'];?></td>    
                    <td><?php echo $fila['hash_comprador'];?></td>  
                    <td><?php echo $fila['hash_vendedor'];?></td> 
                    <!-- Dependiendo de si hay distribución o no aparece una cosa u otra -->
                    <td>
                        <div class="row">

                            <p><?php echo $fila['distribuidor']==1?'Si':'No';?></p>
                            <?php 
                                if($fila['distribuidor']==1){?>
                                    <a href="/Pedidos/distribuidor.php?pedido=<?php echo $fila['refCompra'];?>" class="act"><img src="../build/img/icons/edit.svg" alt=""></a>
                            <?php } ?>
                        </div>
                    </td> 
                    <td>
                        <!-- Formulario para eliminar el pedido seleccionado -->
                        <div class="bloque">
                            <form action="<?php $_SERVER[ 'PHP_SELF' ]; ?>" method="post" onsubmit="return confirmEliminado()" class="formEliminado">
                                <input class="bTabla" type="submit" name="borrar" value=" ">
                                <input class="oculto" type="hidden" name="refCompra" value=<?php echo $fila['refCompra'];?>>
                            </form>
                            <a href="/Pedidos/actualizarPedido.php?pedido=<?php echo $fila['refCompra'];?>" class="bTabla act"><img src="../build/img/icons/writer.svg" alt=""></a>
                </div>
                <?php } ?>
                </td>
            </tr>
        <?php } ?>
        </tbody>