<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../Models/ComprasModel.php';

class ComprasController {
    public function obtenerCompras() {
        $comprasModel = new ComprasModel();
        $compras = $comprasModel->obtenerCompras();

        echo json_encode([
            'columnas' => $compras['columnas'],
            'datos' => $compras['compras']
        ]);
    }

    public function añadirCompra() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = json_decode(file_get_contents('php://input'), true);
    
            // Verificar si los datos requeridos están presentes
            if (empty($data['empleado']) || empty($data['formaPago']) || empty($data['numeroFactura']) || empty($data['productos'])) {
                echo json_encode(['status' => 'error', 'message' => 'Faltan datos necesarios']);
                return;
            }
    
            // Insertar la compra
            $comprasModel = new ComprasModel();
            $compraId = $comprasModel->insertarCompra($data['empleado'], $data['formaPago'], $data['numeroFactura'], $data['totalCompra']);
    
            if ($compraId) {
                // Insertar los detalles de la compra
                $resultado = $comprasModel->insertarDetallesCompra($data['productos'], $data['precios'], $data['cantidades'], $compraId);
                if ($resultado) {
                    echo json_encode(['status' => 'exito', 'message' => 'Compra añadida con éxito']);
                } else {
                    echo json_encode(['status' => 'error', 'message' => 'Error al añadir los detalles de la compra']);
                }
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Error al insertar la compra']);
            }
        }
    }

    public function buscarCompra() {
        if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['query'])) {
            $query = $_GET['query'];
            $comprasModel = new ComprasModel();
            $compras = $comprasModel->buscarCompra($query);
            echo json_encode($compras);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Parámetro de búsqueda no proporcionado']);
        }
    }
    
    public function borrarCompra() {
        if (isset($_GET['id']) && isset($_GET['accion']) && $_GET['accion'] == 'borrar') {
            $idCompra = $_GET['id'];  // Obtener el ID de la compra desde la URL
            $comprasModel = new ComprasModel();
            $resultado = $comprasModel->borrarCompra($idCompra);  // Llamar a la función de borrar desde el modelo
    
            if ($resultado) {
                echo json_encode(['status' => 'exito']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'No se pudo borrar la compra.']);
            }
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Falta el parámetro id de la compra o la acción.']);
        }
    }
    
}



$controller = new ComprasController();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $controller->añadirCompra();
} elseif ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['accion']) && $_GET['accion'] == 'borrar') {
    $controller->borrarCompra();
}elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $controller->obtenerCompras();
}
?>
