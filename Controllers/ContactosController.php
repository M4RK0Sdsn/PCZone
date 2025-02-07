<?php
require_once __DIR__ . '/../Models/ContactosModel.php'; // Asegúrate de que la ruta sea correcta

class ContactosController {
    public function obtenerDatos($tabla) {
        // Crear una instancia del modelo
        $model = new ContactosModel();

        // Obtener los datos desde el modelo
        $resultado = $model->getDatos($tabla);

        // Verificar si hay datos
        if ($resultado) {
            // Enviar los datos en formato JSON
            echo json_encode($resultado);
        } else {
            // En caso de error, enviar una respuesta vacía o un mensaje de error
            echo json_encode(['columnas' => [], 'datos' => []]);
        }
    }

    public function buscarContacto($tabla, $query) {
        // Crear una instancia del modelo
        $model = new ContactosModel();

        // Obtener los datos desde el modelo
        $resultado = $model->buscarDatos($tabla, $query);

        // Verificar si hay datos
        if ($resultado) {
            // Enviar los datos en formato JSON
            echo json_encode($resultado);
        } else {
            // En caso de error, enviar una respuesta vacía o un mensaje de error
            echo json_encode(['status' => 'error', 'message' => 'No se encontraron resultados']);
        }
    }

    // ... otros métodos ...

    public function añadirEmpleado() {
        // ... código existente ...
    }

    public function añadirCliente() {
        // ... código existente ...
    }

    public function añadirProveedor() {
        // ... código existente ...
    }

    public function editarEmpleado() {
        // ... código existente ...
    }

    public function editarCliente() {
        // ... código existente ...
    }

    public function editarProveedor() {
        // ... código existente ...
    }

    public function borrarContacto() {
        // ... código existente ...
    }
}

// Llamar a la función si la solicitud se hace a este archivo
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        $controller = new ContactosController();
        switch ($_POST['action']) {
            case 'addEmpleado':
                $controller->añadirEmpleado();
                break;
            case 'updateEmpleado':
                $controller->editarEmpleado();
                break;
            case 'delete':
                $controller->borrarContacto();
                break;
            case 'addCliente':
                $controller->añadirCliente();
                break;
            case 'updateCliente':
                $controller->editarCliente();
                break;
            case 'addProveedor':
                $controller->añadirProveedor();
                break;
            case 'updateProveedor':
                $controller->editarProveedor();
                break;
            default:
                echo json_encode(['status' => 'error', 'message' => 'Acción no reconocida']);
                break;
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Acción no proporcionada']);
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $controller = new ContactosController();
    if (isset($_GET['tabla']) && isset($_GET['query'])) {
        $controller->buscarContacto($_GET['tabla'], $_GET['query']);
    } elseif (isset($_GET['tabla'])) {
        $controller->obtenerDatos($_GET['tabla']);
    }
}
?>