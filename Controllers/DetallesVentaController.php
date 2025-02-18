<?php
session_start();
require_once __DIR__ . '/../Models/DetallesVentaModel.php';

class DetallesVentaController {

    public function obtenerDetallesVenta() {
        // Verificamos si se ha pasado un idVenta a través de la URL
        if (isset($_GET['id'])) {
            $idVenta = $_GET['id'];

            // Creamos una instancia del modelo
            $detallesVentaModel = new DetallesVentaModel();

            // Obtenemos los detalles de la venta
            $detalles = $detallesVentaModel->obtenerDetallesVenta($idVenta);
            $infoVenta = $detallesVentaModel->obtenerInfoVenta($idVenta);

            // Devolvemos los resultados en formato JSON
            if (!empty($detalles) && !empty($infoVenta)) {
                echo json_encode([
                    'status' => 'exito',
                    'detalles' => $detalles,
                    'infoVenta' => $infoVenta
                ]);
            } else {
                echo json_encode([
                    'status' => 'error',
                    'message' => 'No se encontraron detalles para esta venta.'
                ]);
            }
        } else {
            echo json_encode([
                'status' => 'error',
                'message' => 'Falta el parámetro id de la venta.'
            ]);
        }
    }
}

// Instanciamos el controlador
$controller = new DetallesVentaController();

// Ejecutamos la acción correspondiente
$controller->obtenerDetallesVenta();
?>