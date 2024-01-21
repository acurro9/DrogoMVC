<fieldset>
        <legend>Actualizar Locker: </legend>

        <label for="">refLocker: </label>
        <p class="lockerFijo"><?php echo $refLocker; ?> </p>


        <label for="">Dirección: </label>
        <input type="text" name="direccion" value="<?php echo $direccion; ?>">

        <label for="">PassWord: </label>
        <input type="text" name="passwordLocker" value="<?php echo $passwordLocker; ?>">

        <div class="botones">
            <input type="submit" value="Actualizar Lockers" class="registro">
            <a href="/Lockers/lockers.php" class="buton">Volver</a>
        </div>
    </fieldset>