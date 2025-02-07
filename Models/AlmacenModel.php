<?php
require_once __DIR__ . '/../Db/Con1Db.php'; // Asegúrate de que la ruta a tu clase de conexión es correcta

class AlmacenModel {
    public function obtenerAlmacen() {
        // Establecer la conexión
        $conn = Conex1::con1();

        // Consulta SQL para obtener los datos de almacen
        $sql = "SELECT idAlmacen AS 'ID Almacén', nombreAlmacen AS 'Nombre del Almacén', direccionAlmacen AS 'Dirección del Almacén'
                FROM almacen;";

        // Ejecutar la consulta
        $resultado = $conn->query($sql);

        // Crear un array para almacenar los resultados
        $almacen = [];

        // Obtener los resultados
        if ($resultado) {
            // Obtener los nombres de las columnas
            $columnas = [];
            while ($fieldinfo = $resultado->fetch_field()) {
                $columnas[] = $fieldinfo->name;
            }

            // Recuperar todos los resultados
            while ($row = $resultado->fetch_assoc()) {
                $almacen[] = $row;
            }

            // Cerrar la conexión
            $conn->close();

            // Devolver los resultados
            return ['columnas' => $columnas, 'almacen' => $almacen];
        } else {
            // Cerrar la conexión en caso de error
            $conn->close();
            // Si no hay resultados, devolver arrays vacíos
            return ['columnas' => [], 'almacen' => []];
        }
    }

    public function insertarAlmacen($nombreAlmacen, $direccionAlmacen) {
        $conn = Conex1::con1();

        $sql = "INSERT INTO almacen (nombreAlmacen, direccionAlmacen) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);

        $stmt->bind_param("ss", $nombreAlmacen, $direccionAlmacen);
        $resultado = $stmt->execute();

        $stmt->close();
        $conn->close();

        return $resultado;  
    }

    public function actualizarAlmacen($idAlmacen, $nombreAlmacen, $direccionAlmacen) {
        $conn = Conex1::con1();
    
        $sql = "UPDATE almacen SET nombreAlmacen = ?, direccionAlmacen = ? WHERE idAlmacen = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssi", $nombreAlmacen, $direccionAlmacen, $idAlmacen);
        $resultado = $stmt->execute();
    
        $stmt->close();
        $conn->close();
    
        return $resultado;
    }
    
    public function eliminarAlmacen($idAlmacen) {
        $conn = Conex1::con1();
    
        $sql = "DELETE FROM almacen WHERE idAlmacen = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $idAlmacen);
        $resultado = $stmt->execute();
    
        $stmt->close();
        $conn->close();
    
        return $resultado;
    }
    
}

?>