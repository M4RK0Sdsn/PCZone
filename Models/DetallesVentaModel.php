<?php
require_once __DIR__ . '/../Db/Con1Db.php';

class DetallesVentaModel {

    // Obtener los detalles de la venta
    public function obtenerDetallesVenta($idVenta) {
        $conn = Conex1::con1();

        // Consulta SQL que obtiene los detalles de la venta, incluyendo el nombre del producto y proveedor
        $sql = "SELECT 
                    dv.idVenta, 
                    dv.lineaVenta, 
                    p.nombreProducto, 
                    dv.inicioGarantia, 
                    dv.finGarantia, 
                    dv.cantidad, 
                    dv.precio, 
                    prov.nombre
                FROM detallesventa dv
                INNER JOIN productos p ON dv.idProducto = p.idProducto
                INNER JOIN proveedores prov ON p.idProveedor = prov.idProveedor
                WHERE dv.idVenta = ?";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $idVenta);
        $stmt->execute();
        $resultado = $stmt->get_result();

        $detallesVenta = [];

        if ($resultado->num_rows > 0) {
            while ($row = $resultado->fetch_assoc()) {
                $detallesVenta[] = $row;  // Guardamos cada fila
            }
        }

        $stmt->close();
        $conn->close();

        return $detallesVenta;
    }

    // Obtener la información adicional de la venta
    public function obtenerInfoVenta($idVenta) {
        $conn = Conex1::con1();

        // Consulta SQL que obtiene la información adicional de la venta
        $sql = "SELECT 
                    v.idVenta, 
                    v.fechaVenta, 
                    v.formaPago, 
                    v.totalVenta, 
                    c.nombre AS cliente, 
                    e.nombre AS empleado
                FROM ventas v
                INNER JOIN clientes c ON v.idCliente = c.idCliente
                INNER JOIN empleados e ON v.idEmpleado = e.idEmpleado
                WHERE v.idVenta = ?";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $idVenta);
        $stmt->execute();
        $resultado = $stmt->get_result();

        $infoVenta = [];

        if ($resultado->num_rows > 0) {
            $infoVenta = $resultado->fetch_assoc();  // Guardamos la fila
        }

        $stmt->close();
        $conn->close();

        return $infoVenta;
    }
}
?>