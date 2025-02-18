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

    public function añadirEmpleado() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Recoger todos los datos del formulario
            $nombreEmpleado = $_POST['nombreEmpleado'] ?? '';
            $apellidosEmpleado = $_POST['apellidosEmpleado'] ?? '';
            $salario = $_POST['salario'] ?? '';
            $puesto = $_POST['puesto'] ?? '';
            $departamento = $_POST['departamento'] ?? '';
            $email = $_POST['email'] ?? '';
            $telefonoEmpleado = $_POST['telefonoEmpleado'] ?? '';
            $fechaContratacion = $_POST['fechaContratacion'] ?? '';
            $horasSemana = $_POST['horasSemana'] ?? '';
            $nombreUsuario = $_POST['nombreUsuario'] ?? '';
            $contraseñaUsuario = $_POST['contraseñaUsuario'] ?? '';
    
            // Validar que los campos no estén vacíos (excepto el idEmpleado, que no se envía)
            if (empty($nombreEmpleado) || empty($apellidosEmpleado) || empty($salario) || empty($puesto) ||
                empty($departamento) || empty($email) || empty($telefonoEmpleado) || empty($fechaContratacion) ||
                empty($horasSemana) || empty($nombreUsuario) || empty($contraseñaUsuario)) {
                // Redirigir si algún campo está vacío
                header('Location: ../contactos.php');
                exit();
            }
    
            // Instanciar el modelo para insertar el empleado
            $contactoModel = new ContactosModel();
            $resultado = $contactoModel->insertarEmpleado(
                $nombreEmpleado, $apellidosEmpleado, $salario, $puesto, $departamento, $email, 
                $telefonoEmpleado, $fechaContratacion, $horasSemana, $nombreUsuario, $contraseñaUsuario
            );
    
            // Redirigir con mensaje de éxito o error dependiendo del resultado
            if ($resultado) {
                header('Location: ../contactos.php');
            } else {
                header('Location: ../contactos.php?mensaje=error');
            }
            exit();
        }
    }

    public function añadirCliente() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Recoger datos del formulario
            $nombre = $_POST['nombreCliente'] ?? '';
            $apellidos = $_POST['apellidosCliente'] ?? '';
            $correoElectronico = $_POST['correoElectronico'] ?? '';
            $telefono = $_POST['telefonoCliente'] ?? '';
            $direccion = $_POST['direccionCliente'] ?? '';
            $anhoNacimiento = $_POST['anhoNacimiento'] ?? '';
    
            // Validar que los campos no estén vacíos
            if (empty($nombre) || empty($apellidos) || empty($correoElectronico) ||
                empty($telefono) || empty($direccion) || empty($anhoNacimiento)) {
                header('Location: ../contactos.php');
                exit();
            }
    
            // Instanciar el modelo para insertar el cliente
            $contactoModel = new ContactosModel();
            $resultado = $contactoModel->insertarCliente($nombre, $apellidos, $correoElectronico, $telefono, $direccion, $anhoNacimiento);
    
            // Redirigir con mensaje de éxito o error
            if ($resultado) {
                header('Location: ../contactos.php');
            } else {
                header('Location: ../contactos.php?mensaje=error');
            }
            exit();
        }
    }
    
    public function añadirProveedor() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Recoger datos del formulario
            $nombre = $_POST['nombreProveedor'] ?? '';
            $direccion = $_POST['direccionProveedor'] ?? '';
            $correoElectronico = $_POST['correoElectronicoProveedor'] ?? '';
            $telefono = $_POST['telefonoProveedor'] ?? '';

            // Validar que no haya campos vacíos
            if (empty($nombre) || empty($direccion) || empty($correoElectronico) || empty($telefono)) {
                header('Location: ../contactos.php');
                exit();
            }

            // Instanciar el modelo para insertar el proveedor
            $contactoModel = new ContactosModel();
            $resultado = $contactoModel->insertarProveedor($nombre, $direccion, $correoElectronico, $telefono);

            // Redirigir con mensaje de éxito o error
            if ($resultado) {
                header('Location: ../contactos.php?mensaje=exito');
            } else {
                header('Location: ../contactos.php?mensaje=error');
            }
            exit();
        }
    }

    public function editarEmpleado() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            
            // Obtener los datos del formulario
            $idEmpleado = $_POST['eidEmpleado'] ?? null;
            $nombreEmpleado = $_POST['enombreEmpleado'] ?? null;
            $apellidosEmpleado = $_POST['eapellidosEmpleado'] ?? null;
            $salarioEmpleado = $_POST['esalario'] ?? null;
            $puestoEmpleado = $_POST['epuesto'] ?? null;
            $departamentoEmpleado = $_POST['edepartamento'] ?? null;
            $emailEmpleado = $_POST['eemail'] ?? null;
            $telefonoEmpleado = $_POST['etelefonoEmpleado'] ?? null;
            $fechaContratacion = $_POST['efechaContratacion'] ?? null;
            $horasSemana = $_POST['ehorasSemana'] ?? null;
            $nombreUsuario = $_POST['enombreUsuario'] ?? null;
            $contrasenaUsuario = $_POST['econtraseñaUsuario'] ?? null; // Puedes hacer un password_hash si lo prefieres
    
            // Validar que los campos no estén vacíos
            if (empty($nombreEmpleado) || empty($apellidosEmpleado) || empty($salarioEmpleado) || empty($puestoEmpleado) ||
                empty($departamentoEmpleado) || empty($emailEmpleado) || empty($telefonoEmpleado) || empty($fechaContratacion) ||
                empty($horasSemana) || empty($nombreUsuario) || empty($contrasenaUsuario)) {
                echo json_encode(['status' => 'error', 'message' => 'Todos los campos son requeridos']);
                exit();
            }
    
            // Llamar al modelo para actualizar los datos
            $contactosModel = new ContactosModel();
            $resultado = $contactosModel->actualizarEmpleado(
                $idEmpleado, 
                $nombreEmpleado, 
                $apellidosEmpleado, 
                $salarioEmpleado, 
                $puestoEmpleado, 
                $departamentoEmpleado, 
                $emailEmpleado, 
                $telefonoEmpleado, 
                $fechaContratacion, 
                $horasSemana, 
                $nombreUsuario, 
                $contrasenaUsuario
            );
    
            // Modificación del echo json_encode con if-else
            if ($resultado) {
                header('Location: ../contactos.php');
            } else {
                header('Location: ../contactos.php?mensaje=error');
            }
        }
    }
    
    public function editarCliente() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            
            // Obtener los datos del formulario
            $idCliente = $_POST['eidCliente'] ?? null;
            $nombreCliente = $_POST['enombreCliente'] ?? null;
            $apellidosCliente = $_POST['eapellidosCliente'] ?? null;
            $correoElectronico = $_POST['ecorreoElectronico'] ?? null;
            $telefonoCliente = $_POST['etelefonoCliente'] ?? null;
            $direccion = $_POST['edireccion'] ?? null;
            $anhoNacimiento = $_POST['eanhoNacimiento'] ?? null;
    
            // Validar que los campos no estén vacíos
            if (empty($nombreCliente) || empty($apellidosCliente) || empty($correoElectronico) || empty($telefonoCliente) ||
                empty($direccion) || empty($anhoNacimiento)) {
                echo json_encode(['status' => 'error', 'message' => 'Todos los campos son requeridos']);
                exit();
            }
    
            // Llamar al modelo para actualizar los datos
            $contactosModel = new ContactosModel();
            $resultado = $contactosModel->actualizarCliente(
                $idCliente, 
                $nombreCliente, 
                $apellidosCliente, 
                $correoElectronico, 
                $telefonoCliente, 
                $direccion, 
                $anhoNacimiento
            );
    
            // Modificación del echo json_encode con if-else
            if ($resultado) {
                header('Location: ../contactos.php');
            } else {
                header('Location: ../contactos.php?mensaje=error');
            }
        }
    }

    public function editarProveedor() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            
            // Obtener los datos del formulario
            $idProveedor = $_POST['eidProveedor'] ?? null;
            $nombreProveedor = $_POST['enombreProveedor'] ?? null;
            $direccionProveedor = $_POST['edireccionProveedor'] ?? null;
            $correoElectronico = $_POST['ecorreoElectronico'] ?? null;
            $telefonoProveedor = $_POST['etelefonoProveedor'] ?? null;
    
            // Validar que los campos no estén vacíos
            if (empty($nombreProveedor) || empty($direccionProveedor) || empty($correoElectronico) || empty($telefonoProveedor)) {
                echo json_encode(['status' => 'error', 'message' => 'Todos los campos son requeridos']);
                exit();
            }
    
            // Llamar al modelo para actualizar los datos
            $contactosModel = new ContactosModel();
            $resultado = $contactosModel->actualizarProveedor(
                $idProveedor, 
                $nombreProveedor, 
                $direccionProveedor, 
                $correoElectronico, 
                $telefonoProveedor
            );
    
            // Modificación del echo json_encode con if-else
            if ($resultado) {
                header('Location: ../contactos.php');
            } else {
                header('Location: ../contactos.php?mensaje=error');
            }
        }
    }
    
    
    
    
    public function borrarContacto() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Recoger el ID del contacto a borrar
            $id = $_POST['id'] ?? '';
            $tabla = $_POST['tabla'] ?? '';
    
            // Validar que el ID no esté vacío
            if (empty($id) || empty($tabla)) {
                echo json_encode(['status' => 'error', 'message' => 'ID o tabla no proporcionados']);
                exit();
            }
    
            // Instanciar el modelo para borrar el contacto
            $contactoModel = new ContactosModel();
            $resultado = $contactoModel->borrarContacto($tabla, $id);
    
            // Verifica si la eliminación fue exitosa
            if ($resultado) {
                echo json_encode(['status' => 'success', 'message' => 'Contacto eliminado']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Error al eliminar el contacto']);
            }
            exit();
        }
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
}else if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['tabla'])) {
    $controller = new ContactosController();
    $controller->obtenerDatos($_GET['tabla']);
}
?>
