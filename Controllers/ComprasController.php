<?php
require_once __DIR__ . '/../Models/ComprasModel.php'; // Asegúrate de que la ruta al modelo es correcta

class ComprasController {
    public function obtenerCompras() {
        // Crear una instancia del modelo de compras
        $comprasModel = new ComprasModel();

        // Obtener los datos de compras desde el modelo
        $compras = $comprasModel->obtenerCompras();

        // Verificar si los datos existen antes de enviarlos
        if (!empty($compras['columnas']) && !empty($compras['compras'])) {
            echo json_encode([
                'columnas' => $compras['columnas'],  // Obtener las columnas desde el array correcto
                'datos' => $compras['compras']  // Los datos de las ventas
            ]);
        } else {
            // Enviar una respuesta vacía en caso de no encontrar ventas
            echo json_encode([
                'columnas' => [],
                'datos' => []
            ]);
        }
    }
}

// Llamamos a la función correspondiente si es una petición GET
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $controller = new ComprasController();
    $controller->obtenerCompras();
}
?>
