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
    <title>Inventario - PC Zone</title>
    <link rel="stylesheet" href="Assets/styles.css">
</head>
<body>
    <?php require_once 'Shared/navegador.php'; ?>
    <!-- Contenido específico de Inventario -->
    <div id="main-content">
        <h1>Inventario</h1>
        <table id="inventarioTable">
            <thead id="inventarioHeader">
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
        <div id="formPopup" class="form-popup" style="display: none;">
            <div class="form-container">
                <span class="closeBtn">&times;</span>
                <form action="Controllers/AlmacenController.php" method="POST">
                    <label for="fechaInventario">Fecha de inventario:</label>
                    <input placeholder="aaaa-mm-dd" type="text" id="fechaInventario" name="fechaInventario" required>

                    <label for="direccionAlmacen">Dirección del Almacén:</label>
                    <input type="text" id="direccionAlmacen" name="direccionAlmacen" required>

                    <input type="hidden" id="idAlmacen" name="idAlmacen" value="">
                    <input type="hidden" name="action" value="add">

                    <button type="submit" class="save">Guardar</button>
                </form>
            </div>
        </div>
        <div id="mensaje" class="mensaje" style="display: none;"></div>
    </div>
    <script src="Assets/motor.js"></script>
</body>
</html>
