<?php
require_once __DIR__ . '/../Models/AlmacenModel.php'; // Asegúrate de que la ruta al modelo es correcta

class AlmacenController {
    public function obtenerAlmacen() {
        // Crear una instancia del modelo de almacén
        $almacenModel = new AlmacenModel();

        // Obtener los datos de almacenes desde el modelo
        $almacen = $almacenModel->obtenerAlmacen();

        // Verificar si los datos existen antes de enviarlos
        if (!empty($almacen['columnas']) && !empty($almacen['almacen'])) {
            echo json_encode([
                'columnas' => $almacen['columnas'],  // Obtener las columnas desde el array correcto
                'datos' => $almacen['almacen']  // Los datos del almacén
            ]);
        } else {
            // Enviar una respuesta vacía en caso de no encontrar almacenes
            echo json_encode([
                'columnas' => [],
                'datos' => []
            ]);
        }
    }

    public function añadirAlmacen() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nombreAlmacen = $_POST['nombreAlmacen'] ?? '';
            $direccionAlmacen = $_POST['direccionAlmacen'] ?? '';

            if (empty($nombreAlmacen) || empty($direccionAlmacen)) {
                header('Location:  ../almacen.php');
                exit();
            }

            // Instanciar el modelo para insertar el almacén
            $almacenModel = new AlmacenModel();
            $resultado = $almacenModel->insertarAlmacen($nombreAlmacen, $direccionAlmacen);

            // Redireccionar con un mensaje dependiendo del resultado
            if ($resultado) {
                header('Location: ../almacen.php');
            } else {
                header('Location: ../almacen.php?mensaje=error');
            }
            exit();
        }
    }

    public function actualizarAlmacen() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $idAlmacen = $_POST['idAlmacen'] ?? null;
            $nombreAlmacen = $_POST['nombreAlmacen'] ?? null;
            $direccionAlmacen = $_POST['direccionAlmacen'] ?? null;
    
            // Verificación de datos
            if (empty($idAlmacen) || empty($nombreAlmacen) || empty($direccionAlmacen)) {
                echo json_encode(['status' => 'error', 'message' => 'Datos incompletos.']);
                return;
            }
    
            $almacenModel = new AlmacenModel();
            $resultado = $almacenModel->actualizarAlmacen($idAlmacen, $nombreAlmacen, $direccionAlmacen);
    
            echo json_encode(['status' => $resultado ? 'exito' : 'error']);
        }
    }

    public function eliminarAlmacen() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $idAlmacen = $_POST['idAlmacen'];
    
            if (empty($idAlmacen)) {
                echo json_encode(['status' => 'error', 'message' => 'ID de almacén no proporcionado.']);
                return;
            }
    
            $almacenModel = new AlmacenModel();
            $resultado = $almacenModel->eliminarAlmacen($idAlmacen);
    
            echo json_encode(['status' => $resultado ? 'exito' : 'error']);
        }
    }
}

// Manejo de solicitudes
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        $controller = new AlmacenController();
        switch ($_POST['action']) {
            case 'add':
                $controller->añadirAlmacen();
                break;
            case 'update':
                $controller->actualizarAlmacen();
                break;
            case 'delete':
                $controller->eliminarAlmacen();
                break;
            default:
                echo json_encode(['status' => 'error', 'message' => 'Acción no reconocida']);
                break;
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Acción no proporcionada']);
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $controller = new AlmacenController();
    $controller->obtenerAlmacen();
}
