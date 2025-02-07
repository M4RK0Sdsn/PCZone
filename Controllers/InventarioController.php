<?php
require_once __DIR__ . '/../Models/InventarioModel.php';

class InventarioController {
    public function obtenerInventario() {
        // Crear una instancia del modelo de inventario
        $inventarioModel = new InventarioModel();

        // Obtener los datos de inventario desde el modelo
        $inventario = $inventarioModel->obtenerInventario();

        // Verificar si los datos existen antes de enviarlos
        if (!empty($inventario['columnas']) && !empty($inventario['inventario'])) {
            echo json_encode([
                'columnas' => $inventario['columnas'],  // Obtener las columnas desde el array correcto
                'datos' => $inventario['inventario']  // Los datos del inventario
            ]);
        } else {
            // Enviar una respuesta vacía en caso de no encontrar inventario
            echo json_encode([
                'columnas' => [],
                'datos' => []
            ]);
        }
    }
}

// Llamamos a la función correspondiente si es una petición GET
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $controller = new InventarioController();
    $controller->obtenerInventario();
}
?>
