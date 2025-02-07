<?php
session_start();  // Iniciar sesión al principio del archivo

// Verificar que el usuario está logueado antes de permitir acceso al contenido
if (isset($_SESSION['usuario'])) {
    $nombreUsuario = $_SESSION['usuario']; // Obtiene el nombre del usuario desde la sesión
} else {
    // Si no está autenticado, puedes redirigirlo al login o mostrar un mensaje
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Main - PC Zone</title>
    <link rel="stylesheet" href="Assets/styles.css">
</head>
<body>
    <!-- Barra de navegación -->
    <?php require_once 'Shared/navegador.php'; ?>

    <!-- Contenido principal -->
    <div id="main-content">
        <h1>Bienvenido a PC Zone, <?php echo htmlspecialchars($nombreUsuario); ?></h1> <hr>
    
        <div class="noticias">
            <div class="textoNoticia">
                <h1>Aprende a usar la app</h1>
                <p>En este video te mostramos, paso a paso, todo lo que necesitas saber 
                para dominar el uso de nuestra app. Desde las funciones básicas hasta los 
                detalles más avanzados, aprenderás a aprovechar al máximo cada una de sus 
                características para mejorar tu experiencia y obtener los mejores resultados.</p>
            </div>
            <div class="imagenNoticia">
                <img src="./Source/informatico.png" alt="Imagen de informático">
            </div>
        </div>
        
        <div class="ultimasNoticias">
            <h1>¡Últimas noticias</h1><hr>
            <div class="noticias2">
                <div class="textoNoticia2">
                    <h1>PC Zone lanza portátil ecológico EcoPro X</h1>
                    <p>PC Zone ha lanzado su primer portátil ecológico, el EcoPro X, diseñado para combinar alto rendimiento y sostenibilidad. Fabricado con materiales reciclados,
                    el dispositivo ofrece características avanzadas como un procesador de última generación y un sistema de refrigeración eficiente que reduce el consumo energético. 
                    Con este lanzamiento, la empresa busca posicionarse como líder en tecnología ecológica y ha anunciado su compromiso de plantar un árbol por cada unidad vendida.</p>
                </div>
                <div class="imagenNoticia2">
                    <img src="./Source/portatil.png" alt="Imagen de informático">
                </div>
            </div>
            <div class="noticias2">
                <div class="textoNoticia2">
                    <h1>PC Zone se expande a América LatinaX</h1>
                    <p>PC Zone ha anunciado su expansión a América Latina con la apertura de tiendas en México y Chile. 
                    La empresa, especializada en la venta de ordenadores y productos de tecnología, se centrará en ofrecer equipos 
                    gaming de alto rendimiento con su nueva serie Titan G. Esta expansión forma parte de su estrategia para atender 
                    a la creciente demanda tecnológica en la región.</p>
                </div>
                <div class="imagenNoticia2">
                    <img src="./Source/latam.png" alt="Imagen de informático">
                </div>
            </div>
        </div>
    </div>
   
    <script src="Assets/motor.js"></script>
</body>
</html>