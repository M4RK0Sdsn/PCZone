<?php
require_once __DIR__ . '/../Models/ProductoModel.php'; // Asegúrate de que la ruta al modelo es correcta

class ProductoController {
    public function obtenerProductos() {
        $productoModel = new ProductoModel();
        $productos = $productoModel->obtenerProductos();

        if (!empty($productos['columnas']) && !empty($productos['productos'])) {
            echo json_encode([
                'columnas' => $productos['columnas'],
                'datos' => $productos['productos']
            ]);
        } else {
            echo json_encode([
                'columnas' => [],
                'datos' => []
            ]);
        }
    }

    public function añadirProducto() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nombreProducto = $_POST['nombreProducto'];
            $marca = $_POST['marca'];
            $modelo = $_POST['modelo'];
            $precioCompra = $_POST['precioCompra'];
            $precioVenta = $_POST['precioVenta'];
            $stock = $_POST['stock'];
            $idProveedor = $_POST['idProveedor'];

            if (empty($nombreProducto) || empty($marca) || empty($modelo) || empty($precioCompra) || empty($precioVenta) || empty($stock) || empty($idProveedor)) {
                header('Location: ../productos.php');
                exit();
            }

            $productoModel = new ProductoModel();
            $resultado = $productoModel->insertarProducto($nombreProducto, $marca, $modelo, $precioCompra, $precioVenta, $stock, $idProveedor);

            header('Location: ../productos.php' . ($resultado ? '' : '?mensaje=error'));
            exit();
        }
    }

    public function actualizarProducto() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $idProducto = $_POST['idProducto'] ?? null;
            $nombreProducto = $_POST['nombreProducto'] ?? null;
            $marca = $_POST['marca'] ?? null;
            $modelo = $_POST['modelo'] ?? null;
            $precioCompra = $_POST['precioCompra'] ?? null;
            $precioVenta = $_POST['precioVenta'] ?? null;
            $stock = $_POST['stock'] ?? null;

            if (empty($idProducto) || empty($nombreProducto) || empty($marca) || empty($modelo) || empty($precioCompra) || empty($precioVenta) || empty($stock)) {
                echo json_encode(['status' => 'error', 'message' => 'Datos incompletos.']);
                return;
            }

            $productoModel = new ProductoModel();
            $resultado = $productoModel->actualizarProducto($idProducto, $nombreProducto, $marca, $modelo, $precioCompra, $precioVenta, $stock);

            header('Location: ../productos.php' . ($resultado ? '' : '?mensaje=error'));
        }
    }

    public function eliminarProducto() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $idProducto = $_POST['idProducto'];

            if (empty($idProducto)) {
                echo json_encode(['status' => 'error', 'message' => 'ID de producto no proporcionado.']);
                return;
            }

            $productoModel = new ProductoModel();
            $resultado = $productoModel->eliminarProducto($idProducto);

            echo json_encode(['status' => $resultado ? 'success' : 'error', 'message' => $resultado ? 'Producto eliminado' : 'Error al eliminar el producto']);
            exit();
        }
    }

    public function buscarProducto() {
        if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['query'])) {
            $query = $_GET['query'];
            $productoModel = new ProductoModel();
            $productos = $productoModel->buscarProducto($query);
            echo json_encode($productos);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Parámetro de búsqueda no proporcionado']);
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        $controller = new ProductoController();
        switch ($_POST['action']) {
            case 'add':
                $controller->añadirProducto();
                break;
            case 'update':
                $controller->actualizarProducto();
                break;
            case 'delete':
                $controller->eliminarProducto();
                break;
            default:
                echo json_encode(['status' => 'error', 'message' => 'Acción no reconocida']);
                break;
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Acción no proporcionada']);
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $controller = new ProductoController();
    if (isset($_GET['action']) && $_GET['action'] === 'search') {
        $controller->buscarProducto();
    } else {
        $controller->obtenerProductos();
    }
}
?>
