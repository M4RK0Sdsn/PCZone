<?php
require_once __DIR__ . '/../Models/VentasModel.php'; // Asegúrate de que la ruta al modelo es correcta

class VentasController {
    // Obtener las ventas desde el modelo
    public function obtenerVentas() {
        // Crear una instancia del modelo de ventas
        $ventasModel = new VentasModel();

        // Obtener los datos de ventas desde el modelo
        $ventas = $ventasModel->obtenerVentas();

        // Verificar si los datos existen antes de enviarlos
        if (!empty($ventas['columnas']) && !empty($ventas['ventas'])) {
            echo json_encode([
                'columnas' => $ventas['columnas'],  // Obtener las columnas desde el array correcto
                'datos' => $ventas['ventas']  // Los datos de las ventas
            ]);
        } else {
            // Enviar una respuesta vacía en caso de no encontrar ventas
            echo json_encode([
                'columnas' => [],
                'datos' => []
            ]);
        }
    }

    // Insertar una nueva venta
    public function insertarVenta() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Recoger datos del POST enviados mediante AJAX
            $cliente = $_POST['cliente'];
            $empleado = $_POST['empleado'];
            $almacen = $_POST['almacen'];
            $formaPago = $_POST['formaPago'];
            $productos = $_POST['producto'];
            $cantidades = $_POST['cantidad'];
            $precios = $_POST['precio'];
    
            $ventasModel = new VentasModel();
            $idVenta = $ventasModel->insertarVenta($cliente, $empleado, $formaPago, $almacen);
    
            if ($idVenta) {
                $exito = true;
                foreach ($productos as $index => $idProducto) {
                    $cantidad = $cantidades[$index];
                    $precio = $precios[$index];
    
                    $detalleVentaExito = $ventasModel->insertarDetalleVenta($idVenta, $idProducto, $cantidad, $precio);
                    
                    if (!$detalleVentaExito) {
                        // Si algún producto no tiene suficiente stock, devolver un error
                        $exito = false;
                        break;
                    }
                }
    
                if ($exito) {
                    echo json_encode(['success' => true, 'idVenta' => $idVenta]);
                } else {
                    echo json_encode(['success' => false, 'message' => 'Inventario insuficiente para uno o más productos']);
                }
            } else {
                echo json_encode(['success' => false, 'message' => 'Error al insertar la venta']);
            }
        }
    }
    
}

$controller = new VentasController();

// Manejar las peticiones
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $controller->insertarVenta();
} elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $controller->obtenerVentas();
}
?>
