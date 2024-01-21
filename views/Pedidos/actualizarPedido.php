<?php 
//Para la actualización de los pedidos
    //En caso de no estar logueado y no ser el administrador nos redirige al index.php
    $auth=$_SESSION['login']??false;
    if(!$auth || $_SESSION['tipo']!='Administrador'){
        header('Location: /');
    }

    //Se guarda la id pasada por parametro, si no existe se redirige al area personal del admin 
    $id=$_GET['pedido']??null;
    if(!$id){
        header('Location: /areaPersonalAdmin.php');
    } else{
        //Se crea el array de errores y de hacen las querys necesarias para completar los datos del pedido
        $errores=[];
        $consulta1="SELECT * from usuario where tipo like 'Comprador';";
        $result=mysqli_query($db,$consulta1);
        $consulta2="SELECT * from usuario where tipo like 'Vendedor';";
        $result2=mysqli_query($db,$consulta2);
        $consulta3="SELECT refLocker, direccion from locker;";
        $result3=mysqli_query($db,$consulta3);

        $query="SELECT refCompra, hash_comprador, hash_vendedor, importe, cargoTransporte, cargosAdicionales, fechaRecogida, fechaDeposito, distribuidor, refLocker from compra where refCompra='$id';";
        $resultado=mysqli_query($db,$query);

        // Se guardan los datos de la consulta
        if($fila=mysqli_fetch_row($resultado)){
            $ref=$fila[0];
            $comprador=$fila[1];
            $vendedor=$fila[2];
            $import=$fila[3];
            $cargoT=$fila[4];
            $cargoA=$fila[5];
            $fechaRec=$fila[6];
            $fechaDep=$fila[7];
            $distribuidor=$fila[8];
            $locker=$fila[9];
        }
        //En caso de hacer el POST se guardan los datos del formulario
        if($_SERVER['REQUEST_METHOD']==="POST"){
            $ref=mysqli_real_escape_string($db, $_POST['ref']);
            $comprador=mysqli_real_escape_string($db, $_POST['comp']);
            $vendedor=mysqli_real_escape_string($db, $_POST['vend']);
            $import=mysqli_real_escape_string($db, $_POST['imp']);
            $cargoT=mysqli_real_escape_string($db, $_POST['carT']);
            $cargoA=mysqli_real_escape_string($db, $_POST['carA']);
            $fechaDep=date($_POST['deposito']);
            $fechaRec=date($_POST['registro']);
            $distribuidor=isset($_POST['dist']) ? 1 : 0;
            $locker=mysqli_real_escape_string($db, $_POST['locker']);
            $fecha=date('Y-m-d');

            // Si falta algún dato se crea un error
            if(!$ref){
                $errores[]="Debes añadir una referencia.";
            }
            if(!$comprador){
                $errores[]="Debes añadir un comprador.";
            }
            if(!$vendedor){
                $errores[]="Debes añadir un vendedor.";
            }
            if(!$import){
                $errores[]="Debes añadir un importe.";
            }
            if(!$cargoT){
                $errores[]="Debes añadir un cargo de transporte.";
            }
            if(!$cargoA){
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

            // Si no hay errores se realiza el update
            if(empty($errores)){
                $consulta="UPDATE compra set refCompra='$ref', hash_comprador='$comprador', hash_vendedor='$vendedor', importe=$import, cargoTransporte=$cargoT, cargosAdicionales=$cargoA, fechaDeposito='$fechaDep', fechaRecogida='$fechaRec', refLocker='$locker', distribuidor=$distribuidor where refCompra='$id';";
                $result=mysqli_query( $db, $consulta );
                if($result){
                    //Si se eligió la opción de distribución se añade a la tabla entrega la referencia de la compra y nos redirige a la tabla pedidos
                    if($distribuidor==1){
                        $query2="INSERT into entrega (refCompra) values ('$ref');";
                        $resultado2=mysqli_query($db, $query2);

                        if($resultado2){
                            header("Location: /Pedidos/pedidos.php?res=2");
                        }
                    } else if($distribuidor==0){
                        $query3="DELETE from entrega where refCompra like '$ref';";
                        $resultado3=mysqli_query($db, $query3);

                        if($resultado3){
                            header("Location: /Pedidos/pedidos.php?res=2");
                        }
                    }
                }
            }
        }
    }
?>
<!--Se importan los css necesarios-->
<link rel="stylesheet" href="../build/css/pedidos.css">

<!-- Formulario para la actulización de pedidos -->
<form method="POST" enctype="multipart/form-data" class="formu">
    <?php foreach($errores as $error){?>
        <div>
            <p class="error">
                <?php echo $error;?>    
            </p>
        </div>
    <?php } ?>
    <?php include __DIR__ . '/../../includes/templates/forms/formulario_actPedido.php'; ?>
</form>

