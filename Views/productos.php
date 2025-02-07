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
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Productos - PC Zone</title>
    <link rel="stylesheet" href="Assets/styles.css">
</head>
<body>
    <?php require_once 'Shared/navegador.php'; ?>

    <!-- Contenido específico de Productos -->
    <div id="main-content">
        <h1>Productos</h1>

        <?php if (isset($_GET['mensaje'])): ?>
            <div class="mensaje">
                <?php if ($_GET['mensaje'] == 'exito'): ?>
                    <p>Producto añadido con éxito.</p>
                <?php else: ?>
                    <p>Error al añadir el producto.</p>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    <!-- Campo de búsqueda -->
    <input type="text" id="searchInput" placeholder="Buscar productos..." onkeyup="buscarProductos()">
                
        <table id="productoTable">
            <thead id="productoHeader">
                <tr>
                    <!-- Los encabezados de las columnas se generarán dinámicamente -->
                </tr>
            </thead>
            <tbody id="productoBody">
                <!-- Los datos se insertarán aquí mediante JavaScript -->
            </tbody>
        </table>
        <div id="mensaje" class="mensaje" style="display: none;"></div>
        <!-- Contenedor del formulario emergente -->
        <button class="Btn" id="openFormBtn">
            <div class="sign">+</div>
            <div class="text">Añadir</div>
        </button>

        <!-- Formulario emergente (inicialmente oculto) -->
        <div id="formPopup" class="form-popup" style="display: none;">
            <div class="form-container">
                <span class="closeBtn">&times;</span>
                <form action="Controllers/ProductoController.php" method="POST">
                    <label for="nombreProducto">Nombre del Producto:</label>
                    <input type="text" id="nombreProducto" name="nombreProducto" required>

                    <label for="marca">Marca:</label>
                    <input type="text" id="marca" name="marca" required>

                    <label for="modelo">Modelo:</label>
                    <input type="text" id="modelo" name="modelo" required>

                    <label for="precioCompra">Precio de Compra:</label>
                    <input type="number" id="precioCompra" name="precioCompra" step="0.01" required>

                    <label for="precioVenta">Precio de Venta:</label>
                    <input type="number" id="precioVenta" name="precioVenta" step="0.01" required>

                    <label for="stock">Cantidad en Stock:</label>
                    <input type="number" id="stock" name="stock" required>

                    <label for="idProveedor">ID Proveedor:</label>
                    <input type="number" id="idProveedor" name="idProveedor" required>

                    <input type="hidden" id="idProducto" name="idProducto" value="">
                    <input type="hidden" name="action" value="add">

                    <button id="btnAñadirProducto" type="submit" class="save">Guardar</button>
                </form>
            </div>
        </div>


        <!-- Formulario de edición del producto (inicialmente oculto) -->
        <div id="formularioEdicionProducto" class="form-popup" style="display: none;">
            <h3>Editar Producto</h3>
            <form id="formEditarProducto" class="form-container" action="Controllers/ProductoController.php" method="POST">
                <label for="eidProducto">ID Producto:</label>
                <input type="text" id="eidProducto" name="idProducto" readonly>
                <br>
                <label for="enombreProducto">Nombre del Producto:</label>
                <input type="text" id="enombreProducto" name="nombreProducto" required>
                <br>
                <label for="emarcaProducto">Marca:</label>
                <input type="text" id="emarcaProducto" name="marca" required>
                <br>
                <label for="emodeloProducto">Modelo:</label>
                <input type="text" id="emodeloProducto" name="modelo" required>
                <br>
                <label for="eprecioCompraProducto">Precio de Compra:</label>
                <input type="number" id="eprecioCompraProducto" name="precioCompra" required>
                <br>
                <label for="eprecioVentaProducto">Precio de Venta:</label>
                <input type="number" id="eprecioVentaProducto" name="precioVenta" required>
                <br>
                <label for="estockProducto">Cantidad en Stock:</label>
                <input type="number" id="estockProducto" name="stock" required>
                <br>
                <input type="hidden" name="action" value="update">
                <button class="closeBtn" onclick="document.getElementById('formularioEdicionProducto').style.display='none'">&times;</button>
                <button class="save" type="submit">Guardar Cambios</button>
            </form>
        </div>



       
    </div>

    <script src="Assets/motor.js"></script>
    <script src="Assets/buscadorProducto.js"></script>
</body>
</html>
