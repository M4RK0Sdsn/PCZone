<?php
session_start();  // Iniciar sesión al principio del archivo

// Verificar que el usuario está logueado antes de permitir acceso al contenido
if (isset($_SESSION['usuario'])) {
    $nombreUsuario = $_SESSION['usuario']; // Obtiene el nombre del usuario desde la sesión
} else {
    // Si no está autenticado, puedes redirigirlo al login o mostrar un mensaje
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Almacen - PC Zone</title>
    <link rel="stylesheet" href="Assets/styles.css">
</head>
<body>
    <?php require_once 'Shared/navegador.php'; ?>
    <!-- Contenido específico de Almacenes -->
    <div id="main-content">
        <h1>Almacenes</h1>
        <?php if (isset($_GET['mensaje'])): ?>
            <div class="mensaje">
                <?php if ($_GET['mensaje'] == 'exito'): ?>
                    <p>Almacén añadido con éxito.</p>
                <?php else: ?>
                    <p>Error al añadir el almacén.</p>
                <?php endif; ?>
            </div>
        <?php endif; ?>
        <table id="almacenTable">
            <thead id="almacenHeader">
                <tr>
                    <!-- Los encabezados de las columnas se generarán dinámicamente -->
                </tr>
            </thead>
            <tbody id="almacenBody">
                <!-- Los datos se insertarán aquí mediante JavaScript -->
            </tbody>
        </table>
     <!-- Contenedor del formulario emergente -->
        <button class="Btn" id="openFormBtn">
            <div class="sign">+</div>
            <div class="text">Añadir</div>
        </button>

        <!-- Formulario emergente (inicialmente oculto) -->
        <div id="formPopup" class="form-popup" style="display: none;">
            <div class="form-container">
                <span class="closeBtn">&times;</span>
                <form action="Controllers/AlmacenController.php" method="POST">
                    <label for="nombreAlmacen">Nombre del Almacén:</label>
                    <input type="text" id="nombreAlmacen" name="nombreAlmacen" required>

                    <label for="direccionAlmacen">Dirección del Almacén:</label>
                    <input type="text" id="direccionAlmacen" name="direccionAlmacen" required>

                    <input type="hidden" id="idAlmacen" name="idAlmacen" value="">
                    <input type="hidden" name="action" value="add">

                    <button id="btnAñadirAlmacen" type="submit" class="save">Guardar</button>
                </form>
            </div>
        </div>
        <div id="formularioEdicion" class="form-popup" style="display: none;">
            <h3>Editar Almacén</h3>
            <form id="formEditarAlmacen" class="form-container">
                <label for="eidAlmacen">ID:</label>
                <input type="text" id="eidAlmacen" readonly>
                <br>
                <label for="enombreAlmacen">Nombre:</label>
                <input type="text" id="enombreAlmacen" required>
                <br>
                <label for="edireccionAlmacen">Dirección:</label>
                <input type="text" id="edireccionAlmacen" required>
                <br>
                <input type="hidden" name="action" value="update">
                <button class="closeBtn" onclick="document.getElementById('formularioEdicion').style.display='none'">&times;</button>
            </form>
        </div>
        <div id="mensaje" class="mensaje" style="display: none;"></div>

    <script src="Assets/motor.js"></script>
</body>
</html>
