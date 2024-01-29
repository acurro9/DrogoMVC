<fieldset>
        <legend>Actualizar Distribuidor:</legend>
        <div class="formulario">
            <div class="part1">        
                <label for="comp">Distribuidor: </label>
                <select name="hash_distribuidor">
                    <!-- Desplegable con los distribuidores -->
                    <option value="" class="black">--Seleccione--</option>
                    <?php foreach ($usuarios as $usuario) :?>
                        <?php if($usuario->tipo == 'Distribuidor'){ ?>
                            <option class="black" value="<?= $usuario->id; ?>" <?= $usuario->id==$envio->hash_distribuidor?'selected':'';?>>
                            <?php echo $usuario->username; ?>
                        </option>
                    <?php } endforeach; ?>   
                </select>
                
                <label for="lockerOg">Locker de Origen: </label>
                <select name="lockerOrigen">
                    <!-- Desplegable con los lockers -->
                    <option value="" class="black">--Seleccione--</option>
                    <?php foreach ($lockers as $locker) :?>
                        <option class="black" value="<?= $locker->refLocker; ?>" <?= $locker->refLocker==$envio->lockerOrigen?'selected':'';?>>
                            <?php echo $locker->direccion; ?>
                        </option>
                    <?php endforeach; ?>   
                </select>

                <label for="lockerRec">Locker de Recogida: </label>
                <select name="lockerDeposito">
                    <!-- Desplegable con los lockers -->
                    <option value="" class="black">--Seleccione--</option>
                    <?php foreach ($lockers as $locker) :?>
                        <option class="black" value="<?= $locker->refLocker; ?>" <?= $locker->refLocker==$envio->lockerDeposito?'selected':'';?>>
                            <?php echo $locker->direccion; ?>
                        </option>
                    <?php endforeach; ?>    
                </select>

            </div>
            <div class="part2">
                <label for="compra">refCompra: </label>
                <select name="refCompra">
                    <!-- Desplegable con los envios -->
                    <option value="" class="black">--Seleccione--</option>
                    <?php foreach ($pedidos as $pedido) :?>
                        <option class="black" value="<?= $pedido->refCompra; ?>" <?= $pedido->refCompra==$envio->refCompra?'selected':'';?>>
                            <?php echo $pedido->refCompra; ?>
                        </option>
                    <?php endforeach; ?>   
                </select>

                <label for="fecRegistro">Fecha de Recogida: </label>
                <input type="date" name="fechaRecogida" value="<?php echo $envio->fechaRecogida; ?>">
        
                <label for="fecDeposito">Fecha de Depósito: </label>
                <input type="date" name="fechaDeposito" value="<?php echo $envio->fechaDeposito; ?>">
        

            </div>
        </div>
        <center>
            <label for="ref">Referencia: </label>
            <p class="lockerFijo"><?= $envio->id; ?> </p>
        </center>

        <!-- Botones para la actualización o volver -->
        <div class="botones">
            <input type="submit" value="Actualizar Distribuidor" class="registro">
            <a href="/pedidos" class="buton">Volver</a>
        </div>
    </fieldset>