<!--Se importan los css necesarios-->
<link rel="stylesheet" href="../../build/css/registro.css">
<main>
    <!-- Formulario para el registro -->
    <form method="POST" action="/registro" enctype="multipart/form-data">
        <h3>Registro</h3>
        <?php 
        foreach($errores as $error){ ?>
            <!-- Se imprimen los errores si existen -->
            <div style="color: red;">
                <?php echo $error; ?>
            </div>

        <?php 
    } ?>
       

        <?php include __DIR__ . '/../../includes/templates/forms/formulario_registro.php'; ?>
    </form>
</main>
<!-- Se incluye los archivos de javascript -->
<script src="../../build/js/contraseña.js"></script>
</body>
</html>
