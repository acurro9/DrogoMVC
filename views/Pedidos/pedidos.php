<?php 
//Para la tabla de los pedidos
    // Se guarda la respuesta, el id del usuario, el tipo y se inicializan variables vacias
    $res=$_GET["res"]??null;
    $id=$_SESSION["id"];
    $tipo=$_SESSION["tipo"];
    $tipoUsuario='';
    $errores=[];
    $consulta='';
    $titulo="Mis pedidos";

    //Se realiza la consulta para tener el nº total de pedidos
    $consultaCont="SELECT count(*) as contador FROM compra;";
    $datosCont=mysqli_query($db,$consultaCont);
    $data=mysqli_fetch_assoc($datosCont);
    $cantPropiedades=$data['contador'];
    $cantPropiedades2=$data['contador'];
        /*Se crean las variables para la paginacion
    Por defecto los productos por pagina son 5 y la página es 1, si en la url está presente cambia*/
    $ppp = 5;
    if (isset($_GET["producto"])) {
        $ppp = $_GET["producto"];
    }
    $pagina = 1;
    if (isset($_GET["pagina"])) {
        $pagina = $_GET["pagina"];
    }

    if($cantPropiedades==0){
        $totalPaginas=1;
        $offset=0;
        $limit=10;
        $cant="No hay pedidos.";
    } else{
        //Se coge el total de páginas redondeando hacia arriba
        $totalPaginas=ceil($cantPropiedades/$ppp);
        //Se calculan el limit y el offset
        $offset=($pagina-1)*$ppp;
        $limit= $ppp;
        $cant="";
    }

    //En caso de no estar logueado y ser distribuidor nos redirige al index.php
    $auth=$_SESSION['login']??false;
    if(!$auth || $_SESSION['tipo']=='Distribuidor'){
        header('Location: /');
    }

    // Se cambia el valor de unas variables en función del tipo de usuario
    switch ($_SESSION['tipo']) {
        case 'Comprador':
            $tipoUsuario= 'hash_comprador';
            $consulta="and $tipoUsuario='$id' ";
            break;
        case 'Vendedor':
            $tipoUsuario= 'hash_vendedor';
            $consulta="and $tipoUsuario='$id' ";
            break;
        case 'Administrador':
            $consulta=" ";
            $tipoUsuario="admin";
            $titulo="Pedidos";
    }

    //Si existe tipo de usuario se realiza la conexión para ver los pedidos, si es admin los mira todos, si es comprador o vendedor solo mira los pedidos propios
    if($tipoUsuario){
        $query = "SELECT Compra.refCompra, Compra.fechaCompra, Compra.importe, Compra.fechaRecogida, Compra.fechaDeposito, Compra.cargoTransporte, Compra.cargosAdicionales, Compra.hash_comprador, Compra.hash_vendedor, Compra.distribuidor, Locker.refLocker, Locker.direccion from Compra inner join Locker where Compra.refLocker=Locker.refLocker $consulta order by refCompra limit $limit offset $offset;";
        $datos = mysqli_query($db, $query);
        if(!$datos->num_rows){
            if($tipo!='Administrador'){
                $errores[]="El usuario no tiene pedidos relacionados.";
                $cant='';
            } else{
                $errores[]="";
            }
        }
    }

    // En caso de hacer el POST
    if ($_SERVER['REQUEST_METHOD']==='POST'){
        //En el caso de darle al boton de borrar
        if(isset($_POST['borrar'])){
            //Se guarda la id del pedido y se elimina
            $id=$_POST['refCompra'];
            $consulta="DELETE from compra where refCompra='${id}';";
            $result=mysqli_query($db, $consulta);
            if($result){
                header("Location: /Pedidos/pedidos.php?res=3");
            }
        }
    }
    
?>
<!--Se importan los css necesarios-->
<link rel="stylesheet" href="../build/css/pedidos.css">
<link rel="stylesheet" href="../build/css/styles.css">
<main>
    <h1 class="abajo"><?php echo $titulo;?></h1>
    <div class="centrado">
        <!--Se le pide al usuario el número de pedidos por página-->
        <form class="paginado">
        <?php include __DIR__ . '/../../includes/templates/paginado.php'; ?>
        </form>
    </div>
    
    <table class="tabla">
    <?php
    // Se imprimen los errores
        foreach($errores as $error){ 
    ?>
                    
        <div class="error">
            <?php echo $error;?>
        </div>
                    
    <?php
        }
        // Se imprime el mensaje necesario dependiendo de la respuesta
        if(intval($res)===1){?>
            <p class="success">Pedido creado con exito.</p>
       <?php } if(intval($res)===2){?>
            <p class="success">Pedido modificado con exito.</p>
       <?php } if(intval($res)===3){?>
            <p class="success">Pedido borrado con exito.</p>
       <?php } else if(intval($res)===4){?>
            <p class="success">Distribuidor modificado con exito.</p>
       <?php }
    ?>
    <?php echo '<p class="error">'.$cant.'</p>'?>
    <?php include __DIR__ . '/../../includes/templates/tables/tabla_pedidos.php.php'; ?>
    </table>
    <!--Para moverse entre las páginas-->
        <div class="pagComplete">
            <?php if($cantPropiedades!=0){ if($pagina>1){?>
                
            <a class="pag" href="/Pedidos/pedidos.php?producto=<?php echo $ppp;?>&pagina=<?php echo $pagina-1?>"><</a><?php } ?>
            <?php for($i=0; $i<$totalPaginas; $i++){ ?>
                <a class="pag" href="/Pedidos/pedidos.php?producto=<?php echo $ppp;?>&pagina=<?php echo $i+1;?>" <?php echo $pagina==$i+1?'style="color: #71B100; font-weight: 800;"':'';?>><?php echo $i+1;?></a>
                <?php } 
                if($pagina<$totalPaginas){
                    ?>
            <a class="pag" href="/Pedidos/pedidos.php?producto=<?php echo $ppp;?>&pagina=<?php echo $pagina+1?>">></a>
                    <?php }} ?>
        </div>
        <?php
            if($_SESSION['tipo']=='Administrador'){
        ?>
            <div class="centro">
                <a href="/Pedidos/crearPedido.php" class="buton grande">Crear Pedido</a>
            </div>
        <?php } ?>
</main>
<!-- Se incluye los archivos de javascript -->
<script src="../build/js/index.js"></script>