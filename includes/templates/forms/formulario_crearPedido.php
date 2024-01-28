<fieldset>
        <legend>Crear Pedido:</legend>
        <div class="formulario">
            <div class="part1">
                <label for="comp">Comprador: </label>
                <select name="comp">
                    <option value="" class="black">--Seleccione--</option>
                    <!-- Desplegable con los compradores -->
                    <?php foreach ($usuarios as $usuario) :?>
                        <?php if($usuario->tipo == 'Comprador'){ ?>
                            <option class="black" value="<?= $usuario->id; ?>">
                            <?php echo $usuario->username; ?>
                        </option>
                    <?php } endforeach; ?>    
                </select>
        
                <label for="vend">Vendedor: </label>
                <select name="vend">
                    <option value="" class="black">--Seleccione--</option>
                    <!-- Desplegable con los vendedores -->
                    <?php foreach ($usuarios as $usuario) :?>
                        <?php if($usuario->tipo == 'Vendedor'){ ?>
                            <option class="black" value="<?= $usuario->id; ?>">
                            <?php echo $usuario->username; ?>
                        </option>
                    <?php } endforeach; ?>   
                </select>
                
                <label for="Locker">Locker: </label>
                <select name="locker">
                <option value="" class="black">--Seleccione--</option>
                    <!-- Desplegable con los lockers -->
                    <?php foreach ($lockers as $locker) :?>
                        <option class="black" value="<?= $locker->refLocker; ?>">
                            <?php echo $locker->direccion; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
        
        
                <label for="imp">Importe: </label>
                <input type="number" name="imp">
            </div>
    
            <div class="part2">
                <label for="carT">Cargo de transporte: </label>
                <input type="number" name="carT">
        
                <label for="carA">Cargos adicionales: </label>
                <input type="number" name="carA">
        
                <label for="fecDeposito">Fecha de Depósito: </label>
                <input type="date" name="deposito">
        
                <label for="fecRegistro">Fecha de Recogida: </label>
                <input type="date" name="registro">
        
            </div>
        </div>
        <div class="dist">
            <label for="dist">Distribuidor: </label>
            <input type="checkbox" name="dist">
        </div>
        
        <!-- Botones para crear o volver -->
        <div class="botones">
            <input type="submit" value="Crear Pedido" class="registro">
            <a href="/pedidos" class="buton">Volver</a>
        </div>
    </fieldset>