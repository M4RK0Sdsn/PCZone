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
    <title>Compras - PC Zone</title>
    <link rel="stylesheet" href="Assets/styles.css">
</head>
<body>
    <?php require_once 'Shared/navegador.php'; ?>
    <!-- Contenido específico de Ventas -->
    <div id="main-content">
        <h1>Compras</h1>
        <table id="comprasTable">
            <thead id="comprasHeader">
                <tr>
                    <!-- Los encabezados de las columnas se generarán dinámicamente -->
                </tr>
            </thead>
            <tbody>
                <!-- Los datos se insertarán aquí mediante JavaScript -->
            </tbody>
        </table>
        <button class="Btn">
        <div class="sign">+</div>
        
        <div class="text">Añadir</div>
    </button>
    </div>
    <script src="Assets/motor.js"></script>
</body>
</html>