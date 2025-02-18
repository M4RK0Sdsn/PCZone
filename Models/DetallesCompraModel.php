<?php
require_once __DIR__ . '/../Db/Con1Db.php';

class DetallesCompraModel {

    // Obtener los detalles de la compra
    public function obtenerDetallesCompra($idCompra) {
        $conn = Conex1::con1();

        // Consulta SQL que obtiene los detalles de la compra, incluyendo el nombre del producto y proveedor
        $sql = "SELECT 
                    dc.idCompra, 
                    dc.lineaCompra, 
                    p.nombreProducto, 
                    dc.cantidad, 
                    dc.precioCompra, 
                    prov.nombre AS proveedor
                FROM detallescompra dc
                INNER JOIN productos p ON dc.idProducto = p.idProducto
                INNER JOIN proveedores prov ON p.idProveedor = prov.idProveedor
                WHERE dc.idCompra = ?";

        // Preparar la sentencia
        $stmt = $conn->prepare($sql);
        
        if (!$stmt) {
            // Si hay un error en la preparación de la consulta, lo capturamos
            throw new Exception('Error en la consulta SQL: ' . $conn->error);
        }

        $stmt->bind_param("i", $idCompra); // Vinculamos el parámetro idCompra

        $stmt->execute();
        $resultado = $stmt->get_result();

        $detallesCompra = [];

        if ($resultado->num_rows > 0) {
            while ($row = $resultado->fetch_assoc()) {
                $detallesCompra[] = $row;  // Guardamos cada fila
            }
        }

        $stmt->close();
        $conn->close();

        return $detallesCompra;
    }

    // Obtener la información adicional de la compra
    public function obtenerInfoCompra($idCompra) {
        $conn = Conex1::con1();

        // Consulta SQL que obtiene la información adicional de la compra
        $sql = "SELECT 
                    c.idCompra, 
                    c.fechaCompra, 
                    c.formaPago, 
                    c.precioTotal, 
                    e.nombre AS empleado, 
                    c.numeroFactura
                FROM compras c
                INNER JOIN empleados e ON c.idEmpleado = e.idEmpleado
                WHERE c.idCompra = ?";

        // Preparar la sentencia
        $stmt = $conn->prepare($sql);
        
        if (!$stmt) {
            // Si hay un error en la preparación de la consulta, lo capturamos
            throw new Exception('Error en la consulta SQL: ' . $conn->error);
        }

        $stmt->bind_param("i", $idCompra); // Vinculamos el parámetro idCompra

        $stmt->execute();
        $resultado = $stmt->get_result();

        $infoCompra = [];

        if ($resultado->num_rows > 0) {
            $infoCompra = $resultado->fetch_assoc();  // Guardamos la fila
        }

        $stmt->close();
        $conn->close();

        return $infoCompra;
    }
}
?>