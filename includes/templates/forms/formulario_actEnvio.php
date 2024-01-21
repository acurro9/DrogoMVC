<fieldset>
        <legend>Actualizar Distribuidor:</legend>
        <div class="formulario">
            <div class="part1">        
                <label for="comp">Distribuidor: </label>
                <select name="comp">
                    <!-- Desplegable con los distribuidores -->
                    <option value="" class="black">--Seleccione--</option>
                    <?php while($distribuidor2=mysqli_fetch_assoc($resultado)){?>
                        <option <?php echo $distribuidor==$distribuidor2['id']?'selected':''; ?> value="<?php echo $distribuidor2['id'];?>" class="black">
                            <?php echo $distribuidor2['username'];?>
                        </option>
                    <?php }?>    
                </select>
                
                <label for="lockerOg">Locker de Origen: </label>
                <select name="lockerOg">
                    <!-- Desplegable con los lockers -->
                    <option value="" class="black">--Seleccione--</option>
                    <?php while($lockerOg2=mysqli_fetch_assoc($result2)){ ?>
                        <option <?php echo $lockerOg==$lockerOg2['refLocker']?'selected':''; ?> value="<?php echo $lockerOg2['refLocker'];?>" class="black">
                            <?php echo $lockerOg2['direccion'];?>
                        </option>
                    <?php }?>    
                </select>

                <label for="lockerRec">Locker de Recogida: </label>
                <select name="lockerRec">
                    <!-- Desplegable con los lockers -->
                    <option value="" class="black">--Seleccione--</option>
                    <?php while($lockerRec2=mysqli_fetch_assoc($result4)){ ?>
                        <option <?php echo $lockerDep==$lockerRec2['refLocker']?'selected':''; ?> value="<?php echo $lockerRec2['refLocker'];?>" class="black">
                            <?php echo $lockerRec2['direccion'];?>
                        </option>
                    <?php }?>    
                </select>

            </div>
            <div class="part2">
                <label for="compra">refCompra: </label>
                <select name="compra">
                    <!-- Desplegable con los envios -->
                    <option value="" class="black">--Seleccione--</option>
                    <?php while($compra2=mysqli_fetch_assoc($result3)){ ?>
                        <option <?php echo $refCompra==$compra2['refCompra']?'selected':''; ?> value="<?php echo $compra2['refCompra'];?>" class="black">
                            <?php echo $compra2['refCompra'];?>
                        </option>
                    <?php }?>    
                </select>

                <label for="fecRegistro">Fecha de Recogida: </label>
                <input type="date" name="registro" value="<?php echo $fechaRec; ?>">
        
                <label for="fecDeposito">Fecha de Depósito: </label>
                <input type="date" name="deposito" value="<?php echo $fechaDep; ?>">
        

            </div>
        </div>
        <center>
            <label for="ref">Referencia: </label>
            <p class="lockerFijo"><?php echo $ref; ?> </p>
        </center>

        <!-- Botones para la actualización o volver -->
        <div class="botones">
            <input type="submit" value="Actualizar Distribuidor" class="registro">
            <a href="/Pedidos/pedidos.php" class="buton">Volver</a>
        </div>
    </fieldset>