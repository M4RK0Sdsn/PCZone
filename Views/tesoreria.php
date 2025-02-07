<?php
session_start();  // Iniciar sesión al principio del archivo

// Verificar que el usuario está logueado antes de permitir acceso al contenido
if (!isset($_SESSION['usuario'])) {
    header('Location: index.php');
    exit();  // Asegúrate de llamar a exit después de la redirección
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contactos - PC Zone</title>
    <link rel="stylesheet" href="Assets/styles.css">
</head>
<body>
    <?php require_once 'Shared/navegador.php'; ?>
    <!-- Contenido específico de Contactos -->
    <div id="main-content">
        <h1>Tesoreria</h1>
        <p>Aquí puedes gestionar toda la información relacionada con tus tesoreria.</p>
    </div>
    <script src="Assets/motor.js"></script>
</body>
