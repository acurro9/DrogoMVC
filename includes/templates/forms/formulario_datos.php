<?php
    //En caso de que el dato a cambiar sea la contraseña
    if($dataType=="password"){ ?>
            <h2>Cambiar <?php echo $dataType; ?>: </h2>
            <input type="text" placeholder="Nueva contraseña" name='old_value' value="<?php echo $oldValue; ?>">
            <input type="text" name='new_value' placeholder="Repetir contraseña" class="medio" value="<?php echo $newValue; ?>">
        <!--En caso de que el dato a cambiar sea la cartera-->
    <?php } else if($dataType=="cartera"){?>
            <h2>Cambiar Cartera: </h2>
            <input type="text" placeholder="Nueva cartera" name='old_value'  value="<?php echo $oldValue; ?>">
            <input type="text" name='new_value' placeholder="Repetir cartera" class="medio"  value="<?php echo $newValue; ?>">
            <div class="mostrar">
                <input type="password" placeholder="Password" id="cont1" name="contraseña" value="<?php echo $cont; ?>">

                <button type="button" name="password" onclick="clickBoton('cont1', 'vis1')">
                    <p id="vis1">
                        <img src="./assets/icons/bloq.svg" alt="">
                    </p>
                </button>
            </div>
        <!-- En caso de que el dato no sea la cartera ni la contraseña-->
    <?php } else {?>
        <h2>Cambiar <?php echo $dataType; ?>: </h2>
        <input type="text" value="<?php echo $oldValue; ?>">
        <input type="text" name='new_value' placeholder="Dato Nuevo" class="medio" value="<?php echo $newValue; ?>">
    <?php } ?>