<?php
require_once __DIR__ . '/../Db/Con1Db.php';

class VentasModel {
    // Obtener las ventas
    public function obtenerVentas() {
        $conn = Conex1::con1();
        $sql = "SELECT v.idVenta AS 'ID', v.fechaVenta AS 'Fecha', v.totalVenta AS 'Precio total', c.nombre AS 'Cliente', e.nombre AS 'Empleado'
        FROM ventas v
        INNER JOIN clientes c ON v.idCliente = c.idCliente
        INNER JOIN empleados e ON v.idEmpleado = e.idEmpleado;";

        $resultado = $conn->query($sql);
        $ventas = [];

        if ($resultado->num_rows > 0) {
            $columnas = [];
            while ($fieldinfo = $resultado->fetch_field()) {
                $columnas[] = $fieldinfo->name;
            }
            while ($row = $resultado->fetch_assoc()) {
                $ventas[] = $row;
            }
        }
        $conn->close();
        return ['columnas' => $columnas, 'ventas' => $ventas];
    }

    // Insertar venta
    public function insertarVenta($cliente, $empleado, $formaPago, $totalVenta) {
        $conn = Conex1::con1();
        $sql = "INSERT INTO ventas (idCliente, idEmpleado, formaPago, totalVenta, fechaVenta) 
                VALUES (?, ?, ?, ?, CURDATE())";  // Se usa CURDATE() para insertar la fecha actual
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iisi", $cliente, $empleado, $formaPago, $totalVenta);
        $stmt->execute();
        $ventaId = $conn->insert_id; // Obtener el ID de la venta insertada
        $stmt->close();
        $conn->close();
        return $ventaId;
    }
    

    // Insertar detalles de la venta
    public function insertarDetallesVenta($productos, $proveedores, $precios, $cantidades, $ventaId) {
        $conn = Conex1::con1();
        $resultado = true;

        // Inicializamos el valor de `lineaVenta`
        $lineaVenta = 1;

        // Insertar cada producto de la venta
        foreach ($productos as $key => $producto) {
            // Calculamos las fechas en PHP
            $inicioGarantia = date('Y-m-d'); // Fecha actual
            $finGarantia = date('Y-m-d', strtotime('+3 years')); // Fecha 3 años después de la actual

            // Insertamos el detalle de la venta con `lineaVenta` incrementándose por cada producto
            $stmt = $conn->prepare("INSERT INTO detallesventa (idVenta, lineaVenta, idProducto, cantidad, precio, inicioGarantia, finGarantia) 
                                    VALUES (?, ?, ?, ?, ?, ?, ?)");

            // Pasamos los valores para insertar
            $stmt->bind_param("iiidsss", $ventaId, $lineaVenta, $producto, $cantidades[$key], $precios[$key], $inicioGarantia, $finGarantia);
            $resultado &= $stmt->execute(); // Si hay un error en alguna inserción, fallará

            // Actualizamos el stock de productos (restando la cantidad vendida)
            $this->actualizarStockProducto($producto, $cantidades[$key]);

            // Incrementar `lineaVenta` para la próxima iteración
            $lineaVenta++;
        }

        $conn->close();
        return $resultado;
    }

    // Función para actualizar el stock de un producto
    private function actualizarStockProducto($idProducto, $cantidadVendida) {
        $conn = Conex1::con1();
        $sql = "UPDATE productos SET stock = stock - ? WHERE idProducto = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii", $cantidadVendida, $idProducto);
        $stmt->execute();
        $stmt->close();
        $conn->close();
    }

    
    //Borrar venta
    // Función para borrar la venta y restaurar el stock
    public function borrarVenta($idVenta) {
        $conn = Conex1::con1();
        $resultado = true;

        // 1. Obtener los detalles de la venta (productos y cantidades)
        $detalles = $this->obtenerDetallesVenta($idVenta);

        // 2. Restaurar el stock de cada producto
        foreach ($detalles as $detalle) {
            $this->restaurarStockProducto($detalle['idProducto'], $detalle['cantidad']);
        }

        // 3. Borrar los detalles de la venta
        $sqlDetalles = "DELETE FROM detallesventa WHERE idVenta = ?";
        $stmtDetalles = $conn->prepare($sqlDetalles);
        $stmtDetalles->bind_param("i", $idVenta);
        $resultadoDetalles = $stmtDetalles->execute();
        $stmtDetalles->close();

        // 4. Borrar la venta
        $sqlVenta = "DELETE FROM ventas WHERE idVenta = ?";
        $stmtVenta = $conn->prepare($sqlVenta);
        $stmtVenta->bind_param("i", $idVenta);
        $resultadoVenta = $stmtVenta->execute();
        $stmtVenta->close();

        // Cerrar la conexión
        $conn->close();

        // Si todas las operaciones fueron exitosas, devolver true
        return $resultado && $resultadoDetalles && $resultadoVenta;
    }

    

    // Función para obtener los detalles de la venta (productos y cantidades)
    private function obtenerDetallesVenta($idVenta) {
        $conn = Conex1::con1();
        $sql = "SELECT idProducto, cantidad FROM detallesventa WHERE idVenta = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $idVenta);
        $stmt->execute();
        $resultado = $stmt->get_result();

        $detallesVenta = [];
        while ($row = $resultado->fetch_assoc()) {
            $detallesVenta[] = $row;
        }

        $stmt->close();
        $conn->close();

        return $detallesVenta;
    }

    public function buscarVenta($query) {
        $conn = Conex1::con1();
        $sql = "SELECT v.idVenta AS 'ID', v.fechaVenta AS 'Fecha', v.totalVenta AS 'Precio total', c.nombre AS 'Cliente', e.nombre AS 'Empleado'
                FROM ventas v
                INNER JOIN clientes c ON v.idCliente = c.idCliente
                INNER JOIN empleados e ON v.idEmpleado = e.idEmpleado
                WHERE v.idVenta LIKE ? OR c.nombre LIKE ? OR e.nombre LIKE ? OR v.fechaVenta LIKE ? OR v.totalVenta LIKE ?";
    
        $stmt = $conn->prepare($sql);
        $searchTerm = "%" . $query . "%";
        $stmt->bind_param("sssss", $searchTerm, $searchTerm, $searchTerm, $searchTerm, $searchTerm);
        $stmt->execute();
        $resultado = $stmt->get_result();
        $ventas = $resultado->fetch_all(MYSQLI_ASSOC);
    
        $stmt->close();
        $conn->close();
    
        return $ventas;
    }

    // Función para restaurar el stock de un producto
    private function restaurarStockProducto($idProducto, $cantidadVendida) {
        $conn = Conex1::con1();
        $sql = "UPDATE productos SET stock = stock + ? WHERE idProducto = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii", $cantidadVendida, $idProducto);
        $stmt->execute();
        $stmt->close();
        $conn->close();
    }

    
}
