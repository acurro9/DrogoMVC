<fieldset>
        <legend>Actualizar Locker: </legend>

        <label for="">refLocker: </label>
        <p class="lockerFijo"><?php echo $locker->refLocker; ?> </p>


        <label for="">Dirección: </label>
        <input type="text" name="direccion" value="<?php echo $locker->direccion; ?>">

        <label for="">PassWord: </label>
        <input type="text" name="passwordLocker" value="<?php echo $locker->passwordLocker; ?>">

        <div class="botones">
            <input type="submit" value="Actualizar Lockers" class="registro">
            <a href="/lockers" class="buton">Volver</a>
        </div>
    </fieldset>