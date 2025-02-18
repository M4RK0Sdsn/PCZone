<?php
require_once __DIR__ . '/../Db/Con1Db.php'; // Asegúrate de que la ruta sea correcta

class ContactosModel {
    public function getDatos($tabla) {
        // Establecer la conexión
        $conn = Conex1::con1();

        // Crear la consulta SQL basada en la tabla especificada
        $sql = "";
        switch ($tabla) {
            case 'empleados':
                $sql = "SELECT idEmpleado AS Id, nombre AS Nombre, apellidos AS Apellidos, salario AS Salario, puesto AS Puesto, departamento AS Departamento, email AS Email, telefono AS Telefono, fechaContratacion AS 'Fecha de Contratación', horasSemana AS 'Horas por Semana', nombreUsuario AS Usuario FROM empleados";
                break;
            case 'clientes':
                $sql = "SELECT idCliente AS Id, nombre AS Nombre, apellidos AS Apellidos, correoElectronico AS Email, telefono AS Teléfono, direccion AS Dirección, anhoNacimiento AS 'Año de Nacimiento' FROM clientes";
                break;
            case 'proveedores':
                $sql = "SELECT idProveedor AS Id, nombre AS Nombre, direccion AS Dirección, correoElectronico AS Email, telefono AS Teléfono FROM proveedores";
                break;
            default:
                return ['columnas' => [], 'datos' => []]; // Retornar vacío si la tabla no es válida
        }
        
        // Ejecutar la consulta
        $resultado = $conn->query($sql);

        // Crear un array para almacenar los datos
        $datos = [];
        
        // Obtener los nombres de las columnas
        $columnas = [];
        if ($resultado->num_rows > 0) {
            while ($fieldinfo = $resultado->fetch_field()) {
                $columnas[] = $fieldinfo->name;
            }
        }
        
        // Recuperar todos los resultados
        while ($row = $resultado->fetch_assoc()) {
            $datos[] = $row;
        }

        // Cerrar la conexión
        $conn->close();
        
        // Devolver los nombres de las columnas y los datos
        return ['columnas' => $columnas, 'datos' => $datos];
    }

    public function insertarEmpleado($nombreEmpleado, $apellidosEmpleado, $salario, $puesto, $departamento, $email, $telefonoEmpleado, $fechaContratacion, $horasSemana, $nombreUsuario, $contraseñaUsuario) {
        // Establecer conexión con la base de datos
        $conn = Conex1::con1();

        $contraseñaHasheada = password_hash($contraseñaUsuario, PASSWORD_DEFAULT);
        // Preparar la consulta SQL para insertar los datos en la tabla empleados
        $sql = "INSERT INTO empleados (nombre, apellidos, salario, puesto, departamento, 
                            email, telefono, fechaContratacion, horasSemana, nombreUsuario, contraseñaUsuario) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
    
        // Asociar los parámetros con la consulta (ten en cuenta el tipo de datos)
        $stmt->bind_param("sssssssssss",  
    $nombreEmpleado,  
    $apellidosEmpleado, 
        $salario,  
        $puesto,  
        $departamento, 
        $email,  
        $telefonoEmpleado, 
        $fechaContratacion,  
        $horasSemana, 
        $nombreUsuario,
        $contraseñaHasheada
    );
        // Ejecutar la consulta
        $resultado = $stmt->execute();
    
        // Cerrar la sentencia y la conexión
        $stmt->close();
        $conn->close();
    
        // Devolver el resultado de la ejecución
        return $resultado;  
    }
    

    public function insertarCliente($nombre, $apellidos, $correoElectronico, $telefono, $direccion, $anhoNacimiento) {
        $conn = Conex1::con1();
    
        $sql = "INSERT INTO clientes (nombre, apellidos, correoElectronico, telefono, direccion, anhoNacimiento) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
    
        $stmt->bind_param("sssssi", $nombre, $apellidos, $correoElectronico, $telefono, $direccion, $anhoNacimiento); 
        $resultado = $stmt->execute();
    
        $stmt->close();
        $conn->close();
    
        return $resultado;  
    }
    

    public function insertarProveedor($nombre, $direccion, $correoElectronico, $telefono) {
        $conn = Conex1::con1();

        $sql = "INSERT INTO proveedores (nombre, direccion, correoElectronico, telefono) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssss", $nombre, $direccion, $correoElectronico, $telefono);
        
        $resultado = $stmt->execute();

        $stmt->close();
        $conn->close();

        return $resultado;
    }

    public function actualizarEmpleado($eidEmpleado, $enombreEmpleado, $eapellidosEmpleado, $esalarioEmpleado, $epuestoEmpleado, $edepartamentoEmpleado, $eemailEmpleado, $etelefonoEmpleado, $efechaContratacion, $ehorasSemana, $enombreUsuario, $econtrasenaUsuario) {
        // Establecer conexión con la base de datos
        $conn = Conex1::con1();
    
        // Si la nueva contraseña está vacía, mantenemos la actual
        if (!empty($econtrasenaUsuario)) {
            $contraseñaHasheada = password_hash($econtrasenaUsuario, PASSWORD_DEFAULT);
            $sql = "UPDATE empleados SET 
                        nombre = ?, 
                        apellidos = ?, 
                        salario = ?, 
                        puesto = ?, 
                        departamento = ?, 
                        email = ?, 
                        telefono = ?, 
                        fechaContratacion = ?, 
                        horasSemana = ?, 
                        nombreUsuario = ?, 
                        contraseñaUsuario = ? 
                    WHERE idEmpleado = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssssssssssss",  
                $enombreEmpleado,  
                $eapellidosEmpleado, 
                $esalarioEmpleado,  
                $epuestoEmpleado,  
                $edepartamentoEmpleado, 
                $eemailEmpleado,  
                $etelefonoEmpleado, 
                $efechaContratacion,  
                $ehorasSemana, 
                $enombreUsuario,
                $contraseñaHasheada,
                $eidEmpleado
            );
        } else {
            // Si no se cambia la contraseña, actualizamos los otros datos sin modificar la contraseña
            $sql = "UPDATE empleados SET 
                        nombre = ?, 
                        apellidos = ?, 
                        salario = ?, 
                        puesto = ?, 
                        departamento = ?, 
                        email = ?, 
                        telefono = ?, 
                        fechaContratacion = ?, 
                        horasSemana = ?, 
                        nombreUsuario = ? 
                    WHERE idEmpleado = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sssdsissis",  
                $enombreEmpleado,  
                $eapellidosEmpleado, 
                $esalarioEmpleado,  
                $epuestoEmpleado,  
                $edepartamentoEmpleado, 
                $eemailEmpleado,  
                $etelefonoEmpleado, 
                $efechaContratacion,  
                $ehorasSemana, 
                $enombreUsuario,
                $eidEmpleado
            );
        }
    
        // Ejecutar la consulta
        $resultado = $stmt->execute();
    
        // Cerrar la sentencia y la conexión
        $stmt->close();
        $conn->close();
    
        // Devolver el resultado de la ejecución
        return $resultado;  
    }
    
    
    public function actualizarCliente($eidCliente, $enombreCliente, $eapellidosCliente, $ecorreoElectronico, $etelefonoCliente, $edireccion, $eanhoNacimiento) {
        // Establecer conexión con la base de datos
        $conn = Conex1::con1();
    
        // Preparar la consulta SQL para actualizar los datos en la tabla clientes
        $sql = "UPDATE clientes SET 
                    nombre = ?, 
                    apellidos = ?, 
                    correoElectronico = ?, 
                    telefono = ?, 
                    direccion = ?, 
                    anhoNacimiento = ? 
                WHERE idCliente = ?";
        $stmt = $conn->prepare($sql);
    
        // Asociar los parámetros con la consulta (ten en cuenta el tipo de datos)
        $stmt->bind_param(
            "ssssssi",  
            $enombreCliente,  
            $eapellidosCliente, 
            $ecorreoElectronico,  
            $etelefonoCliente,  
            $edireccion, 
            $eanhoNacimiento,
            $eidCliente
        );
    
        // Ejecutar la consulta
        $resultado = $stmt->execute();
    
        // Cerrar la sentencia y la conexión
        $stmt->close();
        $conn->close();
    
        // Devolver el resultado de la ejecución
        return $resultado;  
    }
    
    public function actualizarProveedor($eidProveedor, $enombreProveedor, $edireccionProveedor, $ecorreoElectronico, $etelefonoProveedor) {
        // Establecer conexión con la base de datos
        $conn = Conex1::con1();
    
        // Preparar la consulta SQL para actualizar los datos en la tabla proveedores
        $sql = "UPDATE proveedores SET 
                    nombre = ?, 
                    direccion = ?, 
                    correoElectronico = ?, 
                    telefono = ? 
                WHERE idProveedor = ?";
        $stmt = $conn->prepare($sql);
    
        // Asociar los parámetros con la consulta (ten en cuenta el tipo de datos)
        $stmt->bind_param(
            "ssssi",  
            $enombreProveedor,  
            $edireccionProveedor,  
            $ecorreoElectronico,  
            $etelefonoProveedor,  
            $eidProveedor
        );
    
        // Ejecutar la consulta
        $resultado = $stmt->execute();
    
        // Cerrar la sentencia y la conexión
        $stmt->close();
        $conn->close();
    
        // Devolver el resultado de la ejecución
        return $resultado;  
    }
    
    public function borrarContacto($tabla, $id) {
        $conn = Conex1::con1();
        $sql = "";
    
        // Dependiendo de la tabla, se prepara la consulta SQL
        switch ($tabla) {
            case 'empleados':
                $sql = "DELETE FROM empleados WHERE idEmpleado = ?";
                break;
            case 'clientes':
                $sql = "DELETE FROM clientes WHERE idCliente = ?";
                break;
            case 'proveedores':
                $sql = "DELETE FROM proveedores WHERE idProveedor = ?";
                break;
            default:
                return false; // Si la tabla no es válida, devolver false
        }
    
        // Preparar la consulta
        $stmt = $conn->prepare($sql);
        if ($stmt === false) {
            echo json_encode(['status' => 'error', 'message' => 'Error al preparar la consulta SQL']);
            return false;
        }
    
        // Vincular los parámetros y ejecutar la consulta
        $stmt->bind_param("i", $id);
        $resultado = $stmt->execute();
    
        if ($resultado) {
            $stmt->close();
            $conn->close();
            return true; // La eliminación fue exitosa
        } else {
            // Error al ejecutar la consulta
            echo json_encode(['status' => 'error', 'message' => 'Error al ejecutar la consulta']);
            $stmt->close();
            $conn->close();
            return false; // La eliminación falló
        }
    }
    
}
?>
