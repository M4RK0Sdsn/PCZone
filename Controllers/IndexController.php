<?php
require_once __DIR__ . '/../Db/Con1Db.php'; // Asegurar que el archivo existe

class IndexController {

    public function login() {
        session_start(); // Iniciar sesión

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nombreUsuario = trim($_POST['usuarioEmpleado']);  
            $contraseñaIngresada = $_POST['contraseñaEmpleado'];

            if (empty($nombreUsuario) || empty($contraseñaIngresada)) {
                $_SESSION['error'] = 'Todos los campos son obligatorios';
                header('Location: index.php');
                exit();
            }

            $conn = Conex1::con1(); // Obtener conexión a la base de datos

            // Consulta para obtener la contraseña encriptada
            $sql = "SELECT idEmpleado, nombreUsuario, contraseñaUsuario FROM empleados WHERE nombreUsuario = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $nombreUsuario);
            $stmt->execute();
            $resultado = $stmt->get_result();

            if ($resultado->num_rows > 0) {
                $row = $resultado->fetch_assoc();
                $hashAlmacenado = $row['contraseñaUsuario'];

                if (password_verify($contraseñaIngresada, $hashAlmacenado)) {
                    // ✅ Login exitoso
                    $_SESSION['usuario'] = $row['nombreUsuario'];
                    $_SESSION['usuario_id'] = $row['idEmpleado']; 

                    $stmt->close();
                    $conn->close();
                    header('Location: main.php');
                    exit();
                } else {
                    $_SESSION['error'] = 'Contraseña incorrecta';  
                }
            } else {
                $_SESSION['error'] = 'Usuario no encontrado';  
            }

            $stmt->close();
            $conn->close();
            header('Location: index.php');
            exit();
        }
    }

    public function verificarSesion() {
        session_start();
        if (!isset($_SESSION['usuario'])) {
            header('Location: index.php');
            exit();
        }
    }
}
?>
