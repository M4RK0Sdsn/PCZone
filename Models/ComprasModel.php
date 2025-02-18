<?php
require_once __DIR__ . '/../Db/Con1Db.php';

class ComprasModel {
    // Obtener las compras
    public function obtenerCompras() {
        $conn = Conex1::con1();
        $sql = "SELECT c.idCompra AS 'ID', c.fechaCompra AS 'Fecha de Compra', c.formaPago AS 'Forma de Pago', 
                       c.precioTotal AS 'Precio Total', e.nombre AS 'Empleado', c.numeroFactura AS 'Número de Factura'
                FROM compras c
                INNER JOIN empleados e ON c.idEmpleado = e.idEmpleado;";

        $resultado = $conn->query($sql);
        $compras = [];

        if ($resultado->num_rows > 0) {
            $columnas = [];
            while ($fieldinfo = $resultado->fetch_field()) {
                $columnas[] = $fieldinfo->name;
            }
            while ($row = $resultado->fetch_assoc()) {
                $compras[] = $row;
            }
        }
        $conn->close();
        return ['columnas' => $columnas, 'compras' => $compras];
    }

    // Insertar compra
    public function insertarCompra($empleado, $formaPago, $numeroFactura, $totalCompra) {
        $conn = Conex1::con1();
        
        $sql = "INSERT INTO compras (idEmpleado, formaPago, numeroFactura, precioTotal, fechaCompra)
                VALUES (?, ?, ?, ?, CURDATE())";  // CURDATE() para la fecha actual

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("issd", $empleado, $formaPago, $numeroFactura, $totalCompra);  // Asumiendo que `precioTotal` es decimal

        $stmt->execute();
        $compraId = $conn->insert_id;
        $stmt->close();

        $conn->close();

        return $compraId;  // Devolver el ID de la compra insertada
    }

    // Insertar detalles de compra
    public function insertarDetallesCompra($productos, $precios, $cantidades, $compraId) {
        $conn = Conex1::con1();
        $resultado = true;
    
        $lineaCompra = 1;
    
        foreach ($productos as $key => $producto) {
            $stmt = $conn->prepare("INSERT INTO detallescompra (idCompra, lineaCompra, idProducto, precioCompra, cantidad) 
                                    VALUES (?, ?, ?, ?, ?)");
    
            $stmt->bind_param("iiidd", $compraId, $lineaCompra, $producto, $precios[$key], $cantidades[$key]);
            $resultado &= $stmt->execute();
    
            $this->actualizarStockProducto($producto, $cantidades[$key]);
    
            $lineaCompra++;
        }
    
        $conn->close();
        return $resultado;
    }
    
    // Obtener los detalles de la compra
    public function obtenerDetallesCompra($idCompra) {
        $conn = Conex1::con1();

        // Obtener los detalles de la compra, incluyendo el nombre del producto y proveedor
        $sql = "SELECT 
                    dc.idCompra, 
                    dc.lineaCompra, 
                    dc.idProducto,
                    p.nombreProducto, 
                    dc.cantidad, 
                    dc.precioCompra, 
                    prov.nombre AS proveedor
                FROM detallescompra dc
                INNER JOIN productos p ON dc.idProducto = p.idProducto
                INNER JOIN proveedores prov ON p.idProveedor = prov.idProveedor
                WHERE dc.idCompra = ?";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $idCompra);
        $stmt->execute();
        $resultado = $stmt->get_result();

        $detallesCompra = [];

        if ($resultado->num_rows > 0) {
            while ($row = $resultado->fetch_assoc()) {
                $detallesCompra[] = $row;
            }
        }

        $stmt->close();
        $conn->close();

        return $detallesCompra;
    }
    
    public function borrarCompra($idCompra) {
        $conn = Conex1::con1();
        
        // Obtener los detalles de la compra (productos y cantidades)
        $detalles = $this->obtenerDetallesCompra($idCompra);
        if (empty($detalles)) {
            return json_encode(['status' => 'error', 'message' => 'No se encontraron detalles para la compra']);
        }
    
        // Restaurar el stock de cada producto
        foreach ($detalles as $detalle) {
            $this->restaurarStockProducto($detalle['idProducto'], $detalle['cantidad']);
        }
    
        // Eliminar los detalles de la compra
        $sqlDetalles = "DELETE FROM detallescompra WHERE idCompra = ?";
        $stmtDetalles = $conn->prepare($sqlDetalles);
        $stmtDetalles->bind_param("i", $idCompra);
        $resultadoDetalles = $stmtDetalles->execute();
        $stmtDetalles->close();
    
        // Eliminar la compra
        $sqlCompra = "DELETE FROM compras WHERE idCompra = ?";
        $stmtCompra = $conn->prepare($sqlCompra);
        $stmtCompra->bind_param("i", $idCompra);
        $resultadoCompra = $stmtCompra->execute();
        $stmtCompra->close();
    
        $conn->close();
    
        if ($resultadoDetalles && $resultadoCompra) {
            return json_encode(['status' => 'exito', 'message' => 'Compra eliminada correctamente']);
        } else {
            return json_encode(['status' => 'error', 'message' => 'No se pudo eliminar la compra']);
        }
    }

    public function buscarCompra($query) {
        $conn = Conex1::con1();
        $sql = "SELECT c.idCompra AS 'ID', c.fechaCompra AS 'Fecha de Compra', c.formaPago AS 'Forma de Pago', 
                       c.precioTotal AS 'Precio Total', e.nombre AS 'Empleado', c.numeroFactura AS 'Número de Factura'
                FROM compras c
                INNER JOIN empleados e ON c.idEmpleado = e.idEmpleado
                WHERE c.idCompra LIKE ? OR e.nombre LIKE ? OR c.fechaCompra LIKE ? OR c.formaPago LIKE ? OR c.numeroFactura LIKE ? OR c.precioTotal LIKE ?";
    
        $stmt = $conn->prepare($sql);
        $searchTerm = "%" . $query . "%";
        $stmt->bind_param("ssssss", $searchTerm, $searchTerm, $searchTerm, $searchTerm, $searchTerm, $searchTerm);
        $stmt->execute();
        $resultado = $stmt->get_result();
        $compras = $resultado->fetch_all(MYSQLI_ASSOC);
    
        $stmt->close();
        $conn->close();
    
        return $compras;
    }
    
    private function restaurarStockProducto($idProducto, $cantidad) {
        $conn = Conex1::con1();
        // Restamos la cantidad al stock actual del producto
        $sql = "UPDATE productos SET stock = stock - ? WHERE idProducto = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii", $cantidad, $idProducto);
        $stmt->execute();
        $stmt->close();
        $conn->close();
    }
    
    

    private function actualizarStockProducto($idProducto, $cantidadComprada) {
        $conn = Conex1::con1();
        $sql = "UPDATE productos SET stock = stock + ? WHERE idProducto = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii", $cantidadComprada, $idProducto);
        $stmt->execute();
        $stmt->close();
        $conn->close();
    }
}
?>
