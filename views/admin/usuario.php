
<link rel="stylesheet" href="../build/css/usuarios.css">
<?php 
    if(isset($_SESSION['mensaje_exito'])): ?>
        <p class='success'><?php echo htmlspecialchars($_SESSION['mensaje_exito']); ?></p>
        <?php unset($_SESSION['mensaje_exito']); // Elimina el mensaje de la sesión después de mostrarlo
    endif; ?>
<main>

    <h1 class="abajo">Usuarios</h1>

    <div class="input-group mb-3">
            <input type="text" id="ajaxAaron" name="ajaxAaron" placeholder="Buscar">
    </div>

    <div class="centrado">
        <form class="paginado" method="GET">
        <?php include __DIR__ . '/../../includes/templates/paginado.php'; ?>
        </form>
    </div>

    <table class="tabla">
            <?php include __DIR__ . '/../../includes/templates/tables/tabla_usuarios.php'; ?>
    </table>

    <div class="pagComplete">
        <!-- Implementar la paginación -->
            <?php for($i=1; $i<=$totalPaginas; $i++){ ?>
                <a href="?producto=<?= $ppp ?>&pagina=<?= $i ?>" class="<?= $paginaActual == $i ? 'active' : '' ?>"><?= $i ?></a>
            <?php } ?>
        </div>
    </div>

    <div class="centro">
        <a href="/areaPersonalAdmin" class="buton grande">Volver</a>
    </div>
</main>

<!-- Se incluye los archivos de javascript -->
<script src="../build/js/index.js"></script>
