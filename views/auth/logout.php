<?php
// Para cerrar la sesión
    session_start();
    session_destroy();
    header('Location: /');