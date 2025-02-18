<?php
session_start();
require_once __DIR__ . '/../Models/DetallesCompraModel.php';

class DetallesCompraController {

    public function obtenerDetallesCompra() {
        // Verificamos si se ha pasado un idCompra a través de la URL
        if (isset($_GET['id'])) {
            $idCompra = $_GET['id'];

            // Creamos una instancia del modelo
            $detallesCompraModel = new DetallesCompraModel();

            // Obtenemos los detalles de la compra
            $detalles = $detallesCompraModel->obtenerDetallesCompra($idCompra);
            $infoCompra = $detallesCompraModel->obtenerInfoCompra($idCompra);

            // Devolvemos los resultados en formato JSON
            if (!empty($detalles) && !empty($infoCompra)) {
                echo json_encode([
                    'status' => 'exito',
                    'detalles' => $detalles,
                    'infoCompra' => $infoCompra
                ]);
            } else {
                echo json_encode([
                    'status' => 'error',
                    'message' => 'No se encontraron detalles para esta compra.'
                ]);
            }
        } else {
            echo json_encode([
                'status' => 'error',
                'message' => 'Falta el parámetro id de la compra.'
            ]);
        }
    }
}

// Instanciamos el controlador
$controller = new DetallesCompraController();

// Ejecutamos la acción correspondiente
$controller->obtenerDetallesCompra();
?>