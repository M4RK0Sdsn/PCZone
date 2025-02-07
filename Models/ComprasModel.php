<?php
require_once __DIR__ . '/../Db/Con1Db.php'; // Asegúrate de que la ruta a tu clase de conexión es correcta

class ComprasModel {
    public function obtenerCompras() {
        // Establecer la conexión
        $conn = Conex1::con1();

        // Consulta SQL para obtener los datos de compras y sus relaciones con clientes, empleados y almacenes
        $sql = "SELECT c.idCompra AS 'ID Compra',
                        c.fechaCompra AS 'Fecha de Compra',
                        c.cantidad AS 'Cantidad',
                        c.formaPago AS 'Forma de Pago',
                        p.nombre AS 'Proveedor',
                        e.nombre AS 'Empleado',
                        a.nombreAlmacen AS 'Almacén'
                    FROM
                        compras c
                    INNER JOIN proveedores p ON c.idProveedor = p.idProveedor
                    INNER JOIN empleados e ON c.idEmpleado = e.idEmpleado
                    INNER JOIN almacen a ON c.idAlmacen = a.idAlmacen;";

        // Ejecutar la consulta
        $resultado = $conn->query($sql);

        // Crear un array para almacenar los resultados
        $compras = [];

        // Obtener los resultados
        if ($resultado->num_rows > 0) {
            // Obtener los nombres de las columnas
            $columnas = [];
            while ($fieldinfo = $resultado->fetch_field()) {
                $columnas[] = $fieldinfo->name;
            }

            // Recuperar todos los resultados
            while ($row = $resultado->fetch_assoc()) {
                $compras[] = $row;
            }

            // Cerrar la conexión
            $conn->close();

            // Devolver los resultados
            return ['columnas' => $columnas, 'compras' => $compras];
        } else {
            // Si no hay resultados, devolver arrays vacíos
            return ['columnas' => [], 'compras' => []];
        }
    }
}

?>
