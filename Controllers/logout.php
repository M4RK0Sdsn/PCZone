<?php
session_start();  // Iniciar sesión

// Destruir todas las variables de sesión
session_unset();

// Destruir la sesión
session_destroy();

// Redirigir al usuario al login
header('Location: ../index.php');
exit();
?>