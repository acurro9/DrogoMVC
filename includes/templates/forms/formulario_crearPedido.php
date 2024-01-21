<fieldset>
        <legend>Crear Pedido:</legend>
        <div class="formulario">
            <div class="part1">
                <label for="comp">Comprador: </label>
                <select name="comp">
                    <option value="" class="black">--Seleccione--</option>
                    <!-- Desplegable con los compradores -->
                    <?php while($comprador=mysqli_fetch_assoc($result)){?>
                        <option <?php echo $hash_comprador==$comprador['id']?'selected':''; ?> value="<?php echo $comprador['id'];?>" class="black">
                            <?php echo $comprador['username'];?>
                        </option>
                    <?php }?>    
                </select>
        
                <label for="vend">Vendedor: </label>
                <select name="vend">
                    <option value="" class="black">--Seleccione--</option>
                    <!-- Desplegable con los vendedores -->
                    <?php while($vendedor=mysqli_fetch_assoc($result2)){ ?>
                        <option <?php echo $hash_vendedor==$vendedor['id']?'selected':''; ?> value="<?php echo $vendedor['id'];?>" class="black">
                            <?php echo $vendedor['username'];?>
                        </option>
                    <?php }?>    
                </select>
                
                <label for="Locker">Locker: </label>
                <select name="locker">
                    <option value="" class="black">--Seleccione--</option>
                    <!-- Desplegable con los lockers -->
                    <?php while($lockers=mysqli_fetch_assoc($result3)){ ?>
                        <option <?php echo $locker==$lockers['refLocker']?'selected':''; ?> value="<?php echo $lockers['refLocker'];?>" class="black">
                            <?php echo $lockers['direccion'];?>
                        </option>
                    <?php }?>    
                </select>
        
        
                <label for="imp">Importe: </label>
                <input type="number" name="imp" value="<?php echo $importe;?>">
            </div>
    
            <div class="part2">
                <label for="carT">Cargo de transporte: </label>
                <input type="number" name="carT" value="<?php echo $cargoTrans;?>">
        
                <label for="carA">Cargos adicionales: </label>
                <input type="number" name="carA" value="<?php echo $cargoAds;?>">
        
                <label for="fecDeposito">Fecha de Depósito: </label>
                <input type="date" name="deposito" value="<?php echo $fechaDep; ?>">
        
                <label for="fecRegistro">Fecha de Recogida: </label>
                <input type="date" name="registro" value="<?php echo $fechaRec; ?>">
        
            </div>
        </div>
        <div class="dist">
            <label for="dist">Distribuidor: </label>
            <input type="checkbox" name="dist" <?php echo $distribuidor==1?'checked':''; ?>>
        </div>
        
        <!-- Botones para crear o volver -->
        <div class="botones">
            <input type="submit" value="Crear Pedido" class="registro">
            <a href="/Pedidos/pedidos.php" class="buton">Volver</a>
        </div>
    </fieldset>