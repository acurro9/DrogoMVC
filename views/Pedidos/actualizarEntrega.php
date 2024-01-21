<?php 
//Para la actualización de distribuciones
    //En caso de no estar logueado y no ser el administrador nos redirige al index.php
    $auth=$_SESSION['login']??false;
    if(!$auth || $_SESSION['tipo']!='Administrador'){
        header('Location: /');
    }

    //Se guarda el id pasado por URL, si no hay redirige a la pagina del area personal del admin
    $id=$_GET['pedido']??null;
    if(!$id){
        header('Location: /areaPersonalAdmin.php');
    } else{
        //Se inicializa errores y se realizan las consultas necesarias
        $errores=[];
        $consulta1="SELECT * from entrega where refCompra like '$id';";
        $result=mysqli_query($db,$consulta1);

        $query="SELECT * from usuario where tipo='Distribuidor';";
        $resultado=mysqli_query($db,$query);

        $query2="SELECT * from locker;";
        $result2=mysqli_query($db, $query2); 
        $result4=mysqli_query($db, $query2); 

        $query3="SELECT * from Compra;";
        $result3=mysqli_query($db, $query3);


        //Se guardan los datos de la entrega
        if($fila=mysqli_fetch_row($result)){
            $ref=$fila[0];
            $distribuidor=$fila[1];
            $refCompra=$fila[2];
            $fechaRec=$fila[3];
            $fechaDep=$fila[4];
            $lockerOg=$fila[5];
            $lockerDep=$fila[6];
        }

        // En caso de hacer el POST
        if($_SERVER['REQUEST_METHOD']==="POST"){
            //Se guardan los datos de los inputs del formulario
            $distribuidor=mysqli_real_escape_string($db, $_POST['comp']);
            $refCompra=mysqli_real_escape_string($db, $_POST['compra']);
            $fechaRec=date($_POST['registro']);
            $fechaDep=date($_POST['deposito']);
            $lockerOg=mysqli_real_escape_string($db, $_POST['lockerOg']);
            $lockerDep=mysqli_real_escape_string($db, $_POST['lockerRec']);
            $fecha=date('Y-m-d');

            //En caso de que falte algún dato se guarda en errores
            if(!$distribuidor){
                $errores[]="Debes añadir una distribuidor.";
            }
            if(!$refCompra){
                $errores[]="Debes añadir un pedido.";
            }
            if(!$fechaRec){
                $errores[]="Debes añadir una fecha de recogida.";
            }
            if(!$fechaDep){
                $errores[]="Debes añadir una fecha de depósito.";
            }
            if(!$lockerOg){
                $errores[]="Debes añadir un locker de origen.";
            }
            if(!$lockerDep){
                $errores[]="Debes añadir un locker de depósito.";
            } 

            if($fecha>$fechaDep){
                $errores[]="La fecha de deposito no puede ser anterior a la fecha actual.";
            }
            if($fecha>=$fechaRec){
                $errores[]="La fecha de recogida no puede ser anterior a la fecha actual.";
            }
            if($fechaDep<$fechaRec){
                $errores[]="La fecha de recogida no puede ser anterior a la fecha de deposito.";
            }

            // En caso de que no haya errores se realiza el update y si es correcto nos redirige a la tabla pedidos
            if(empty($errores)){
                $consulta="UPDATE entrega set hash_distribuidor='$distribuidor', refCompra='$refCompra', fechaRecogida='$fechaRec', fechaDeposito='$fechaDep', lockerOrigen='$lockerOg', lockerDeposito='$lockerDep' where id='$ref';";
                $result=mysqli_query( $db, $consulta );
                if($result){
                    header("Location: /Pedidos/pedidos.php?res=4");
                }
            }
        }
    }
?>
<!--Se importan los css necesarios-->
<link rel="stylesheet" href="../build/css/pedidos.css">

<!-- Formulario para la actualización de las distribuciones -->
<form method="POST" enctype="multipart/form-data" class="formu">
    <?php foreach($errores as $error){?>
        <!-- Se imprimen los errores si los hay -->
        <div>
            <p class="error">
                <?php echo $error;?>    
            </p>
        </div>
    <?php } ?>
    <?php include __DIR__ . '/../../includes/templates/forms/formulario_actEnvio.php'; ?>
</form>
