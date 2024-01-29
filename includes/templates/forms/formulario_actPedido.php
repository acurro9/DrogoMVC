<fieldset>
        <legend>Actualizar Pedido:</legend>
        <div class="formulario">
            <div class="part1">
                <label for="refCompra">Referencia: </label>
                <input type="text" name="refCompra" value="<?= $pedido->refCompra ?>" readonly>
        
                <label for="comp">Comprador: </label>
                <select name="hash_comprador">
                    <option value="">--Seleccione--</option>
                    <!-- Desplegable con los compradores -->
                    <?php foreach ($usuarios as $usuario) :?>
                        <?php if($usuario->tipo == 'Comprador'){ ?>
                            <option class="black" value="<?= $usuario->id; ?>" <?= $usuario->id==$pedido->hash_comprador?'selected':'';?>>
                            <?php echo $usuario->username; ?>
                        </option>
                    <?php } endforeach; ?>    
                </select>
        
                <!-- Desplegable con los vendedores -->
                <label for="vend">Vendedor: </label>
                <select name="hash_vendedor">
                    <option value="">--Seleccione--</option>
                    <?php foreach ($usuarios as $usuario) :?>
                        <?php if($usuario->tipo == 'Vendedor'){ ?>
                            <option class="black" value="<?= $usuario->id; ?>" <?= $usuario->id==$pedido->hash_vendedor?'selected':'';?>>
                            <?php echo $usuario->username; ?>
                        </option>
                    <?php } endforeach; ?>   
                </select>
                
                <!-- Desplegable con los lockers -->
                <label for="Locker">Locker: </label>
                <select name="refLocker">
                    <option value="">--Seleccione--</option>
                    <?php foreach ($lockers as $locker) :?>
                        <option class="black" value="<?= $locker->refLocker; ?>" <?= $locker->refLocker==$pedido->refLocker?'selected':'';?>>
                            <?php echo $locker->direccion; ?>
                        </option>
                    <?php endforeach; ?>   
                </select>
        
                <label for="importe">Importe: </label>
                <input type="text" name="importe" value="<?= $pedido->importe;?>">
            </div>
            <div class="part2">
                <label for="cargoTransporte">Cargo de transporte: </label>
                <input type="text" name="cargoTransporte" value="<?= $pedido->cargoTransporte;?>">
        
                <label for="cargosAdicionales">Cargos adicionales: </label>
                <input type="text" name="cargosAdicionales" value="<?= $pedido->cargosAdicionales;?>">
        
                <label for="fecDeposito">Fecha de Depósito: </label>
                <input type="date" name="fechaDeposito" value="<?= $pedido->fechaDeposito;?>">
        
                <label for="fecRegistro">Fecha de Recogida: </label>
                <input type="date" name="fechaRecogida" value="<?= $pedido->fechaRecogida;?>">

                <label for="dist">Distribuidor: </label>
                <input type="checkbox" name="distribuidor" <?= $pedido->distribuidor==1?'checked':''; ?>>
            </div>
        </div>

        <!-- Botones para volver o actualizar -->
        <div class="botones">
            <input type="submit" value="Actualizar Pedido" class="registro">
            <a href="/pedidos" class="buton">Volver</a>
        </div>
    </fieldset>