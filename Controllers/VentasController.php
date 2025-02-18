<?php
require_once __DIR__ . '/../Models/VentasModel.php';

class VentasController {
    // Obtener las ventas desde el modelo
    public function obtenerVentas() {
        $ventasModel = new VentasModel();
        $ventas = $ventasModel->obtenerVentas();

        if (!empty($ventas['columnas']) && !empty($ventas['ventas'])) {
            echo json_encode([
                'columnas' => $ventas['columnas'],
                'datos' => $ventas['ventas']
            ]);
        } else {
            echo json_encode([
                'columnas' => [],
                'datos' => []
            ]);
        }
    }

    // Insertar una nueva venta
    public function añadirVenta() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = json_decode(file_get_contents('php://input'), true); // Obtener los datos de la solicitud

            // Verificar si los datos requeridos están presentes
            if (empty($data['cliente']) || empty($data['empleado']) || empty($data['formaPago']) || empty($data['productos'])) {
                echo json_encode(['status' => 'error', 'message' => 'Faltan datos necesarios']);
                return;
            }

            // Instanciar el modelo de ventas
            $ventasModel = new VentasModel();
            $ventaId = $ventasModel->insertarVenta($data['cliente'], $data['empleado'], $data['formaPago'], $data['totalVenta']);

            if ($ventaId) {
                // Insertar los detalles de la venta
                $resultado = $ventasModel->insertarDetallesVenta($data['productos'], $data['proveedores'], $data['precios'], $data['cantidades'], $ventaId);
                if ($resultado) {
                    echo json_encode(['status' => 'exito', 'message' => 'Venta añadida con éxito']);
                } else {
                    echo json_encode(['status' => 'error', 'message' => 'Error al añadir los detalles de la venta']);
                }
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Error al insertar la venta']);
            }
        }
    }

    //Borrar venta
    public function borrarVenta() {
        if (isset($_GET['id']) && isset($_GET['accion']) && $_GET['accion'] == 'borrar') {
            $idVenta = $_GET['id'];  // Obtener el ID de la venta desde la URL
            $ventasModel = new VentasModel();
            $resultado = $ventasModel->borrarVenta($idVenta);  // Llamar a la función de borrar desde el modelo
    
            if ($resultado) {
                echo json_encode(['status' => 'exito']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'No se pudo borrar la venta.']);
            }
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Falta el parámetro id de la venta o la acción.']);
        }
    }

    public function buscarVenta() {
        if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['query'])) {
            $query = $_GET['query'];
            $ventasModel = new VentasModel();
            $ventas = $ventasModel->buscarVenta($query);
            echo json_encode($ventas);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Parámetro de búsqueda no proporcionado']);
        }
    }
    
    
}

// Verifica si es un POST o GET
$controller = new VentasController();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $controller->añadirVenta();
}  elseif ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['accion']) && $_GET['accion'] == 'borrar') {
    $controller->borrarVenta();
}elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $controller->obtenerVentas();
}
