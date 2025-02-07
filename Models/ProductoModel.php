<?php
require_once __DIR__ . '/../Db/Con1Db.php'; // Asegúrate de que la ruta a tu clase de conexión es correcta

class ProductoModel {
    public function obtenerProductos() {
        // Establecer la conexión
        $conn = Conex1::con1();

        // Consulta SQL para obtener los datos de productos
        $sql = "SELECT p.idProducto AS 'ID Producto', 
        p.nombreProducto AS 'Nombre del Producto', 
        p.marca AS 'Marca', 
        p.modelo AS 'Modelo', 
        p.precioCompra AS 'Precio de Compra', 
        p.precioVenta AS 'Precio de Venta', 
        p.stock AS 'Stock', 
        pr.nombre AS 'Proveedor'   
FROM productos p
JOIN proveedores pr ON p.idProveedor = pr.idProveedor;";

        // Ejecutar la consulta
        $resultado = $conn->query($sql);
        $productos = [];

        if ($resultado) {
            $columnas = [];
            while ($fieldinfo = $resultado->fetch_field()) {
                $columnas[] = $fieldinfo->name;
            }

            while ($row = $resultado->fetch_assoc()) {
                $productos[] = $row;
            }

            $conn->close();
            return ['columnas' => $columnas, 'productos' => $productos];
        } else {
            $conn->close();
            return ['columnas' => [], 'productos' => []];
        }
    }

    public function insertarProducto($nombreProducto, $marca, $modelo, $precioCompra, $precioVenta, $stock, $idProveedor) {
        $conn = Conex1::con1();
        $sql = "INSERT INTO productos (nombreProducto, marca, modelo, precioCompra, precioVenta, stock, idProveedor) 
                VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssdiii", $nombreProducto, $marca, $modelo, $precioCompra, $precioVenta, $stock, $idProveedor);
        $resultado = $stmt->execute();

        $stmt->close();
        $conn->close();

        return $resultado;
    }

    public function actualizarProducto($idProducto, $nombreProducto, $marca, $modelo, $precioCompra, $precioVenta, $stock) {
        $conn = Conex1::con1();
        $sql = "UPDATE productos SET nombreProducto = ?, marca = ?, modelo = ?, precioCompra = ?, precioVenta = ?, stock = ? WHERE idProducto = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssdiii", $nombreProducto, $marca, $modelo, $precioCompra, $precioVenta, $stock, $idProducto);
        $resultado = $stmt->execute();

        $stmt->close();
        $conn->close();

        return $resultado;
    }

    public function eliminarProducto($idProducto) {
        $conn = Conex1::con1();
        $sql = "DELETE FROM productos WHERE idProducto = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $idProducto);
        $resultado = $stmt->execute();

        $stmt->close();
        $conn->close();

        return $resultado;
    }

    public function buscarProducto($query) {
        $conn = Conex1::con1();
        $sql = "SELECT idProducto, nombreProducto, marca, modelo, precioCompra, precioVenta, stock, idProveedor 
                FROM productos WHERE nombreProducto LIKE ? OR marca LIKE ? OR modelo LIKE ?";
        $stmt = $conn->prepare($sql);
        $searchTerm = "%" . $query . "%";
        $stmt->bind_param("sss", $searchTerm, $searchTerm, $searchTerm);
        $stmt->execute();
        $resultado = $stmt->get_result();
        $productos = $resultado->fetch_all(MYSQLI_ASSOC);

        $stmt->close();
        $conn->close();

        return $productos;
    }
}
?>
