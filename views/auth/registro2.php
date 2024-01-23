<!-- Formulario del registro de la cartera -->
<?php foreach($errores as $error): ?>
                    <div style="color: red;">
                        <?php echo $error; ?>
                    </div>
                <?php endforeach; ?>
<link rel="stylesheet" href="../build/css/registro.css">
        <main>
            <form method="POST" action="/registro2" class="form_registro2">
                <h3>Finalizar registro</h3>
            
                
            
                <?php include __DIR__ . '/../../includes/templates/forms/formulario_registro2.php'; ?>
            </form>
        </main>
    </body>
</html>