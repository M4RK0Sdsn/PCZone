<?php
require_once __DIR__ . '/../Db/Con1Db.php'; // Asegúrate de que la ruta a tu clase de conexión es correcta

class VentasModel {
    // Obtener ventas con relación a clientes, empleados y almacenes
    public function obtenerVentas() {
        // Establecer la conexión
        $conn = Conex1::con1();

        // Consulta SQL para obtener los datos de ventas y sus relaciones con clientes, empleados y almacenes
        $sql = "SELECT v.idVenta AS 'ID Venta', 
                        v.fechaVenta AS 'Fecha de Venta', 
                        v.cantidad AS 'Cantidad', 
                        v.formaPago AS 'Forma de Pago', 
                        CONCAT(c.nombre, ' ', c.apellidos) AS 'Cliente',
                        CONCAT(e.nombre, ' ', e.apellidos) AS 'Empleado', 
                        a.nombreAlmacen AS 'Almacén'
                    FROM ventas v
                    INNER JOIN clientes c ON v.idCliente = c.idCliente
                    INNER JOIN empleados e ON v.idEmpleado = e.idEmpleado
                    INNER JOIN almacen a ON v.idAlmacen = a.idAlmacen;";

        // Ejecutar la consulta
        $resultado = $conn->query($sql);

        // Crear un array para almacenar los resultados
        $ventas = [];

        // Obtener los resultados
        if ($resultado->num_rows > 0) {
            // Obtener los nombres de las columnas
            $columnas = [];
            while ($fieldinfo = $resultado->fetch_field()) {
                $columnas[] = $fieldinfo->name;
            }

            // Recuperar todos los resultados
            while ($row = $resultado->fetch_assoc()) {
                $ventas[] = $row;
            }

            // Cerrar la conexión
            $conn->close();

            // Devolver los resultados
            return ['columnas' => $columnas, 'ventas' => $ventas];
        } else {
            // Si no hay resultados, devolver arrays vacíos
            return ['columnas' => [], 'ventas' => []];
        }
    }

    // Insertar una venta
    public function insertarVenta($idCliente, $idEmpleado, $formaPago, $almacen) {
        $conn = Conex1::con1();
    
        // Insertar la venta principal
        $sql = "INSERT INTO ventas (idCliente, idEmpleado, formaPago, idAlmacen, fechaVenta) VALUES (?, ?, ?, ?, NOW())";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iiis", $idCliente, $idEmpleado, $almacen, $formaPago);
    
        if ($stmt->execute()) {
            $idVenta = $stmt->insert_id;  // Obtener el ID de la venta insertada
            $stmt->close();
            return $idVenta;
        }
    
        $stmt->close();
        return false;  // Error al insertar la venta
    }
    
    public function insertarDetalleVenta($idVenta, $idProducto, $cantidad, $precio) {
        $conn = Conex1::con1();
    
        // Insertar en la tabla detallesVenta
        $sql = "INSERT INTO detallesVenta (idVenta, idProducto, cantidad, precio) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iiid", $idVenta, $idProducto, $cantidad, $precio);
        $stmt->execute();
    
        // Actualizar la cantidad del producto en la tabla 'producto'
        $sqlUpdateProducto = "UPDATE productos SET cantidad = cantidad - ? WHERE idProducto = ?";
        $stmtUpdateProducto = $conn->prepare($sqlUpdateProducto);
        $stmtUpdateProducto->bind_param("ii", $cantidad, $idProducto);
        $stmtUpdateProducto->execute();
    
        $stmt->close();
        $stmtUpdateProducto->close();
        $conn->close();
    
        return true;  // Detalle de venta insertado correctamente
    }
    
}
?>
