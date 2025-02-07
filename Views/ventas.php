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
        <table id="ventasTable">
            <thead id="ventasHeader">
                <tr>
                    <!-- Encabezados generados dinámicamente -->
                </tr>
            </thead>
            <tbody>
                <!-- Datos insertados mediante JavaScript -->
            </tbody>
        </table>

        <button class="Btn" id="btnAbrirFormulario">
            <div class="sign">+</div>
            <div class="text">Añadir Venta</div>
        </button>

        <!-- Formulario emergente para añadir ventas -->
        <div id="formPopupVenta" class="form-popup" style="display: none;">
            <div class="form-container">
                <span class="closeBtn">&times;</span>
                <form id="ventaForm" method="POST">
                    <label for="cliente">Cliente:</label>
                    <select id="cliente" name="cliente" required>
                        <option value="">Seleccione un cliente</option>
                    </select>

                    <label for="empleado">Empleado:</label>
                    <select id="empleado" name="empleado" required>
                        <option value="">Seleccione un empleado</option>
                    </select>

                    <!-- Contenedor dinámico de productos -->
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
                            <button type="button" class="remove-line">❌</button>
                        </div>
                    </div>

                    <button type="button" id="addLine">+ Añadir Línea</button>
                    <div id="totalContainer">
                        <span id="total">Total: 0.00</span>
                    </div>
                    <button type="submit" class="save">Guardar Venta</button>
                </form>
            </div>
        </div>
    </div>

    <script src="Assets/ventas.js"></script>
</body>
</html>
