<?php
session_start();

// Verificar si el usuario está autenticado
if (!isset($_SESSION['usuario'])) {
    header('Location: index.php');
    exit();
}

// Verificar si se ha pasado un id de la venta
if (!isset($_GET['id'])) {
    header('Location: ventas.php');
    exit();
}

$idVenta = $_GET['id'];  // Obtener el ID de la venta de la URL
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalles Venta - PC Zone</title>
    <link rel="stylesheet" href="Assets/styles.css">
</head>
<body>
    <?php require_once 'Shared/navegador.php'; ?>

    <div id="main-content">
        <h1>Detalles de la Venta Nº<?php echo $idVenta; ?></h1>
        
        <h2>Información de la Venta</h2>
        <table id="infoVentaTable">
            <thead>
                <tr>
                    <th>ID Venta</th>
                    <th>Fecha de Venta</th>
                    <th>Forma de Pago</th>
                    <th>Total Venta</th>
                    <th>Cliente</th>
                    <th>Empleado</th>
                </tr>
            </thead>
            <tbody id="infoVentaBody">
                <!-- La información de la venta se cargará aquí dinámicamente -->
            </tbody>
        </table>

        <h2>Detalles de la Venta</h2>
        <table id="detallesVentaTable">
            <thead id="detallesVentaHeader">
                <tr>
                    <th>Línea Venta</th>
                    <th>Producto</th>
                    <th>Inicio Garantía</th>
                    <th>Fin Garantía</th>
                    <th>Cantidad</th>
                    <th>Precio</th>
                    <th>Proveedor</th>
                </tr>
            </thead>
            <tbody id="detallesVentaBody">
                <!-- Los detalles de la venta se cargarán aquí dinámicamente -->
            </tbody>
        </table>
    </div>

    <script src="Assets/detallesVenta.js"></script>
</body>
</html>