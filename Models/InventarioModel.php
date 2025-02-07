<?php
require_once __DIR__ . '/../Db/Con1Db.php'; // Asegúrate de que la ruta a tu clase de conexión es correcta

class InventarioModel {
    public function obtenerInventario() {
        // Establecer la conexión
        $conn = Conex1::con1();

        // Consulta SQL para obtener los datos de inventario y sus relaciones con empleados, productos y almacenes
        $sql = "SELECT 
                inventario.idInventario AS 'ID Inventario',
                inventario.fechaInventario AS 'Fecha Inventario',
                inventario.cantidadContada AS 'Cantidad Contada',
                empleados.nombre AS 'Nombre Empleado',
                productos.nombreProducto AS 'Nombre Producto',
                almacen.nombreAlmacen AS 'Nombre Almacen'
            FROM 
                inventario
            JOIN 
                empleados ON inventario.idEmpleado = empleados.idEmpleado
            JOIN 
                productos ON inventario.idProducto = productos.idProducto
            JOIN 
                almacen ON inventario.idAlmacen = almacen.idAlmacen
            ORDER BY 
                inventario.idInventario ASC;";

        // Ejecutar la consulta
        $resultado = $conn->query($sql);

        // Crear un array para almacenar los resultados
        $inventario = [];

        // Obtener los resultados
        if ($resultado) {
            // Obtener los nombres de las columnas
            $columnas = [];
            while ($fieldinfo = $resultado->fetch_field()) {
                $columnas[] = $fieldinfo->name;
            }

            // Recuperar todos los resultados
            while ($row = $resultado->fetch_assoc()) {
                $inventario[] = $row;
            }

            // Cerrar la conexión
            $conn->close();

            // Devolver los resultados
            return ['columnas' => $columnas, 'inventario' => $inventario];
        } else {
            // Cerrar la conexión en caso de error
            $conn->close();
            // Si no hay resultados, devolver arrays vacíos
            return ['columnas' => [], 'inventario' => []];
        }
    }
}
?>
