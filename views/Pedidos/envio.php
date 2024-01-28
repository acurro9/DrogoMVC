<!--Se importan los css necesarios-->
<link rel="stylesheet" href="../build/css/pedidos.css">
<link rel="stylesheet" href="../build/css/styles.css">

    <h1>Distribuciones</h1>
    
<main>
    
    <table class="tabla">
        <?php include __DIR__ . '/../../includes/templates/tables/tabla_envios.php'; ?>
    </table>
    <!-- Si el usuario no es distribuidor puede volver a la tabla pedidos -->
    <?php if($_SESSION['tipo']!='Distribuidor'){?>
        <div class="centro">
            <a href="/pedidos" class="buton grande">Ver Pedidos</a>
        </div>
    <?php } ?>
</main>
<!-- Se incluye los archivos de javascript -->
<script src="../build/js/index.js"></script>
