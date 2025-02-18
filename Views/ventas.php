<?php
session_start();  // Iniciar sesión

// Verificar si el usuario está autenticado
if (!isset($_SESSION['usuario'])) {
    header('Location: index.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ventas - PC Zone</title>
    <link rel="stylesheet" href="Assets/styles.css">
</head>
<body>
    <?php require_once 'Shared/navegador.php'; ?>

    <div id="main-content">
        <h1>Ventas</h1>

        <!-- Campo de búsqueda -->
        <input type="text" class="searchInputCompras" id="searchInputVentas" placeholder="Buscar ventas..." onkeyup="buscarVentas()">

        <table id="ventasTable">
            <thead id="ventasHeader">
                <tr>
                    <!-- Encabezados generados dinámicamente -->
                </tr>
            </thead>
            <tbody id="ventasBody">
                <!-- Datos insertados mediante JavaScript -->
            </tbody>
        </table>

        <button class="Btn" id="btnAbrirFormulario">
            <div class="sign">+</div>
            <div class="text">Añadir Venta</div>
        </button>

        <!-- Formulario emergente para añadir ventas -->
        <div id="formPopupVenta" class="form-popup venta-form" style="display: none;">
            <div class="form-container">
                <span class="closeBtn">&times;</span>
                <form id="ventaForm" method="POST">
                    <div class="form-sidebar">
                        <div class="flex-inputs">
                            <label for="cliente">Cliente:</label>
                            <select id="cliente" name="cliente" required>
                                <option value="">Seleccione un cliente</option>
                            </select>

                            <label for="empleado">Empleado:</label>
                            <select id="empleado" name="empleado" required>
                                <option value="">Seleccione un empleado</option>
                            </select>
                        </div>

                        <div id="productosContainer">
                            <div class="producto-linea">
                                <label for="producto[]">Producto:</label>
                                <select name="producto[]" class="producto" required>
                                    <option value="">Seleccione un producto</option>
                                </select>

                                <label for="proveedor[]">Proveedor:</label>
                                <input type="text" name="proveedor[]" class="proveedor" readonly>

                                <label for="precio[]">Precio:</label>
                                <input type="text" name="precio[]" class="precio" readonly>

                                <label for="cantidad[]">Cantidad:</label>
                                <input type="number" name="cantidad[]" class="cantidad" min="1" required>

                                <span class="subtotal">Subtotal: 0</span>
                                <button type="button" class="remove-line">Borrar fila</button>
                            </div>
                        </div>

                        <label for="formaPago">Forma de Pago:</label>
                        <select id="formaPago" name="formaPago" required>
                            <option value="">Seleccione una opción</option>
                            <option value="Efectivo">Efectivo</option>
                            <option value="Tarjeta">Tarjeta</option>
                        </select>

                        <button type="button" class="addLine" id="addLine">+ Añadir Línea</button>
                        <div id="totalContainer">
                            <span id="total">Total: 0.00</span>
                        </div>
                    </div>

                    <button id="btnAñadir" type="submit" class="save">Guardar Venta</button>
                </form>
            </div>
        </div>
    </div>

    <script src="Assets/ventas.js"></script>
    <script src="Assets/buscadorVentas.js"></script>
</body>
</html>