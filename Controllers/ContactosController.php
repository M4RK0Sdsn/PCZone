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

    public function añadirContacto($tabla, $datos) {
        $model = new ContactosModel();
        $resultado = false;

        switch ($tabla) {
            case 'empleados':
                $resultado = $model->insertarEmpleado(
                    $datos['nombreEmpleado'],
                    $datos['apellidosEmpleado'],
                    $datos['salario'],
                    $datos['puesto'],
                    $datos['departamento'],
                    $datos['email'],
                    $datos['telefonoEmpleado'],
                    $datos['fechaContratacion'],
                    $datos['horasSemana'],
                    $datos['nombreUsuario'],
                    $datos['contraseñaUsuario']
                );
                break;
            case 'clientes':
                $resultado = $model->insertarCliente(
                    $datos['nombreCliente'],
                    $datos['apellidosCliente'],
                    $datos['correoElectronico'],
                    $datos['telefonoCliente'],
                    $datos['direccionCliente'],
                    $datos['anhoNacimiento']
                );
                break;
            case 'proveedores':
                $resultado = $model->insertarProveedor(
                    $datos['nombreProveedor'],
                    $datos['direccionProveedor'],
                    $datos['correoElectronicoProveedor'],
                    $datos['telefonoProveedor']
                );
                break;
        }

        echo json_encode(['status' => $resultado ? 'success' : 'error', 'message' => $resultado ? 'Contacto añadido con éxito' : 'Error al añadir el contacto']);
    }

    public function actualizarContacto($tabla, $id, $datos) {
        $model = new ContactosModel();
        $resultado = false;

        switch ($tabla) {
            case 'empleados':
                $resultado = $model->actualizarEmpleado(
                    $id,
                    $datos['enombreEmpleado'],
                    $datos['eapellidosEmpleado'],
                    $datos['esalario'],
                    $datos['epuesto'],
                    $datos['edepartamento'],
                    $datos['eemail'],
                    $datos['etelefonoEmpleado'],
                    $datos['efechaContratacion'],
                    $datos['ehorasSemana'],
                    $datos['enombreUsuario'],
                    $datos['econtraseñaUsuario']
                );
                break;
            case 'clientes':
                $resultado = $model->actualizarCliente(
                    $id,
                    $datos['enombreCliente'],
                    $datos['eapellidosCliente'],
                    $datos['ecorreoElectronico'],
                    $datos['etelefonoCliente'],
                    $datos['edireccion'],
                    $datos['eanhoNacimiento']
                );
                break;
            case 'proveedores':
                $resultado = $model->actualizarProveedor(
                    $id,
                    $datos['enombreProveedor'],
                    $datos['edireccionProveedor'],
                    $datos['ecorreoElectronico'],
                    $datos['etelefonoProveedor']
                );
                break;
        }

        echo json_encode(['status' => $resultado ? 'success' : 'error', 'message' => $resultado ? 'Contacto actualizado con éxito' : 'Error al actualizar el contacto']);
    }

    public function borrarContacto($tabla, $id) {
        $model = new ContactosModel();
        $resultado = $model->borrarContacto($tabla, $id);

        echo json_encode(['status' => $resultado ? 'success' : 'error', 'message' => $resultado ? 'Contacto eliminado con éxito' : 'Error al eliminar el contacto']);
    }
}

// Manejar las solicitudes
if (isset($_GET['tabla'])) {
    $controller = new ContactosController();
    if (isset($_GET['query'])) {
        $controller->buscarContacto($_GET['tabla'], $_GET['query']);
    } else {
        $controller->obtenerDatos($_GET['tabla']);
    }
} elseif (isset($_POST['action'])) {
    $controller = new ContactosController();
    $action = $_POST['action'];
    $tabla = $_POST['tabla'] ?? null;
    $id = $_POST['id'] ?? null;
    $datos = $_POST;

    switch ($action) {
        case 'addEmpleado':
        case 'addCliente':
        case 'addProveedor':
            $controller->añadirContacto($tabla, $datos);
            break;
        case 'updateEmpleado':
        case 'updateCliente':
        case 'updateProveedor':
            $controller->actualizarContacto($tabla, $id, $datos);
            break;
        case 'delete':
            $controller->borrarContacto($tabla, $id);
            break;
        default:
            echo json_encode(['status' => 'error', 'message' => 'Acción no reconocida']);
            break;
    }
}
?>