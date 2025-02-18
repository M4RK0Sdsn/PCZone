<?php
session_start();

// Verificar si el usuario está autenticado
if (!isset($_SESSION['usuario'])) {
    header('Location: index.php');
    exit();
}

// Verificar si se ha pasado un id de la compra
if (!isset($_GET['id'])) {
    header('Location: compras.php');
    exit();
}

$idCompra = $_GET['id'];  // Obtener el ID de la compra de la URL
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalles Compra - PC Zone</title>
    <link rel="stylesheet" href="Assets/styles.css">
</head>
<body>
    <?php require_once 'Shared/navegador.php'; ?>

    <div id="main-content">
        <h1>Detalles de la Compra Nº<?php echo $idCompra; ?></h1>
        
        <h2>Información de la Compra</h2>
        <table id="infoCompraTable">
            <thead>
                <tr>
                    <th>ID Compra</th>
                    <th>Fecha de Compra</th>
                    <th>Forma de Pago</th>
                    <th>Precio Total</th>
                    <th>Empleado</th>
                    <th>Número de Factura</th>
                </tr>
            </thead>
            <tbody id="infoCompraBody">
                <!-- La información de la compra se cargará aquí dinámicamente -->
            </tbody>
        </table>

        <h2>Detalles de la Compra</h2>
        <table id="detallesCompraTable">
            <thead id="detallesCompraHeader">
                <tr>
                    <th>Línea Compra</th>
                    <th>Producto</th>
                    <th>Cantidad</th>
                    <th>Precio</th>
                    <th>Proveedor</th>
                </tr>
            </thead>
            <tbody id="detallesCompraBody">
                <!-- Los detalles de la compra se cargarán aquí dinámicamente -->
            </tbody>
        </table>
    </div>

    <script src="Assets/detallesCompra.js"></script>
</body>
</html>