<fieldset>
        <legend>Actualizar Pedido:</legend>
        <div class="formulario">
            <div class="part1">
                <label for="ref">Referencia: </label>
                <input type="text" name="ref" value="<?php echo $ref;?>">
        
                <label for="comp">Comprador: </label>
                <select name="comp">
                    <option value="">--Seleccione--</option>
                    <!-- Desplegable con los compradores -->
                    <?php while($comprador2=mysqli_fetch_assoc($result)){?>
                        <option <?php echo $comprador==$comprador2['id']?'selected':''; ?> value="<?php echo $comprador2['id'];?>">
                            <?php echo $comprador2['username'];?>
                        </option>
                    <?php }?>    
                </select>
        
                <!-- Desplegable con los vendedores -->
                <label for="vend">Vendedor: </label>
                <select name="vend">
                    <option value="">--Seleccione--</option>
                    <?php while($vendedor2=mysqli_fetch_assoc($result2)){ ?>
                        <option <?php echo $vendedor==$vendedor2['id']?'selected':''; ?> value="<?php echo $vendedor2['id'];?>">
                            <?php echo $vendedor2['username'];?>
                        </option>
                    <?php }?>    
                </select>
                
                <!-- Desplegable con los lockers -->
                <label for="Locker">Locker: </label>
                <select name="locker">
                    <option value="">--Seleccione--</option>
                    <?php while($lockers=mysqli_fetch_assoc($result3)){ ?>
                        <option <?php echo $locker==$lockers['refLocker']?'selected':''; ?> value="<?php echo $lockers['refLocker'];?>">
                            <?php echo $lockers['direccion'];?>
                        </option>
                    <?php }?>    
                </select>
        
                <label for="imp">Importe: </label>
                <input type="text" name="imp" value="<?php echo $import;?>">
            </div>
            <div class="part2">
                <label for="carT">Cargo de transporte: </label>
                <input type="text" name="carT" value="<?php echo $cargoT;?>">
        
                <label for="carA">Cargos adicionales: </label>
                <input type="text" name="carA" value="<?php echo $cargoA;?>">
        
                <label for="fecDeposito">Fecha de Depósito: </label>
                <input type="date" name="deposito" value="<?php echo $fechaDep; ?>">
        
                <label for="fecRegistro">Fecha de Recogida: </label>
                <input type="date" name="registro" value="<?php echo $fechaRec; ?>">

                <label for="dist">Distribuidor: </label>
                <input type="checkbox" name="dist" <?php echo $distribuidor==1?'checked':''; ?>>
            </div>
        </div>

        <!-- Botones para volver o actualizar -->
        <div class="botones">
            <input type="submit" value="Actualizar Pedido" class="registro">
            <a href="/Pedidos/pedidos.php" class="buton">Volver</a>
        </div>
    </fieldset>