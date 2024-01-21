<?php 
//Para la creación de pedidos
    //Importamos las funciones, incluimos el header y creamos la conexión a la base de datos 
    $auth=$_SESSION['login']??false;
    if(!$auth || $_SESSION['tipo']!='Administrador'){
        header('Location: /');
    }

    // Se realizan las consultas necesarias para rellenar los datos
    $consulta1="SELECT * from usuario where tipo like 'Comprador';";
    $result=mysqli_query($db,$consulta1);
    $consulta2="SELECT * from usuario where tipo like 'Vendedor';";
    $result2=mysqli_query($db,$consulta2);
    $consulta3="SELECT refLocker, direccion from locker;";
    $result3=mysqli_query($db,$consulta3);

    //Se inicializan las variables a vacio
    $errores=[];
    $referencia='';
    $hash_comprador='';
    $hash_vendedor='';
    $importe='';
    $cargoTrans='';
    $cargoAds='';
    $locker='';
    $fecDeposito='';
    $fecRecogida='';
    $fechaDep='';
    $fechaRec='';
    $distribuidor='';

    // En caso de hacer el POST
    if($_SERVER['REQUEST_METHOD']==="POST"){
        //Se guardan los datos de los inputs del formulario
        $referencia=md5(uniqid(rand(),true));
        $hash_comprador=mysqli_real_escape_string($db, $_POST["comp"]);
        $hash_vendedor=mysqli_real_escape_string($db, $_POST['vend']);
        $importe=mysqli_real_escape_string($db, $_POST['imp']);
        $cargoTrans=mysqli_real_escape_string($db, $_POST['carT']);
        $cargoAds=mysqli_real_escape_string($db, $_POST['carA']);
        $locker=mysqli_real_escape_string($db, $_POST['locker']);
        $fecha=date('Y-m-d');
        $fechaDep=date($_POST['deposito']);
        $fechaRec=date($_POST['registro']);
        $distribuidor=isset($_POST['dist']) ? 1 : 0;

        //En caso de que falte algún dato se guarda en errores
        if(!$hash_comprador){
            $errores[]="Debes añadir un comprador.";
        }
        if(!$hash_vendedor){
            $errores[]="Debes añadir un vendedor.";
        }
        if(!$importe){
            $errores[]="Debes añadir el importe.";
        }
        if(!$cargoTrans){
            $errores[]="Debes añadir un cargo de transporte.";
        }
        if(!$cargoAds){
            $errores[]="Debes añadir los cargos adicionales.";
        }
        if(!$locker){
            $errores[]="Debes añadir un locker para el envio.";
        } 
        if(!$fechaDep){
            $errores[]="Debes añadir una fecha de deposito.";
        }
        if(!$fechaRec){
            $errores[]="Debes añadir una fecha de recogida.";
        }
        if($fecha>$fechaDep){
            $errores[]="La fecha de deposito no puede ser anterior a la fecha actual.";
        }
        if($fecha>=$fechaRec){
            $errores[]="La fecha de recogida no puede ser anterior a la fecha actual.";
        }
        if($fechaDep>$fechaRec){
            $errores[]="La fecha de recogida no puede ser anterior a la fecha de deposito.";
        }

        // En caso de que no haya errores
        if(empty($errores)){
            //Si se eligió la opción de distribución se añade a la tabla entrega la referencia de la compra y nos redirige a la tabla pedidos
                $query="INSERT into compra (refCompra, hash_comprador, hash_vendedor, fechaCompra, importe, cargoTransporte, cargosAdicionales, fechaDeposito, fechaRecogida, refLocker, distribuidor)
                    values ('$referencia', '$hash_comprador', '$hash_vendedor', '$fecha', $importe, $cargoTrans, $cargoAds, '$fechaDep', '$fechaRec', '$locker', $distribuidor );";
                $resultado=mysqli_query($db, $query);
            if($resultado){
                if($distribuidor==1){
                    $query2="INSERT into entrega (refCompra) values ('$referencia');";
                    $resultado2=mysqli_query($db, $query2);
                    if($resultado2){
                        header("Location: /Pedidos/pedidos.php?res=1");
                    }
                } else{
                    header("Location: /Pedidos/pedidos.php?res=1");
                }
            }
            
        }
    }


?>
<!--Se importan los css necesarios-->
<link rel="stylesheet" href="../build/css/pedidos.css">

<!-- Formulario para la creación de pedidos -->
<form method="POST" enctype="multipart/form-data" class="formu">
    <?php foreach($errores as $error){?>
        <!-- Se imprimen los errores si existen -->
        <div class="error">
            <?php echo $error;?>    
        </div>
    <?php } ?>
    <?php include __DIR__ . '/../../includes/templates/forms/formulario_crearPedido.php'; ?>
</form>