<?php
class Conex1 {
    // Conexión MySQL
    public static function con1() {
        $se = "localhost";
        $us = "marcos";
        $co = "madesani2005";
        $bd = "pczone";  // Base de datos 

        $conn = new mysqli($se, $us, $co, $bd);

        // Comprobar la conexión
        if ($conn->connect_error) {
            die("Conexión fallida: " . $conn->connect_error);
        }

        return $conn; // Retorna la conexión
    }
}
?>
