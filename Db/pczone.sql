-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 17-02-2025 a las 08:48:54
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `pczone`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `almacen`
--

CREATE TABLE `almacen` (
  `idAlmacen` int(11) NOT NULL,
  `nombreAlmacen` varchar(100) DEFAULT NULL,
  `direccionAlmacen` varchar(150) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `almacen`
--

INSERT INTO `almacen` (`idAlmacen`, `nombreAlmacen`, `direccionAlmacen`) VALUES
(1, 'Almacén Central', 'Calle Logística 1, Madrid'),
(2, 'Almacén Norte', 'Av. Comercio 25, Bilbao'),
(3, 'Almacén Este', 'Calle Empresarial 14, Valencia'),
(4, 'Almacén Sur', 'Paseo Industrial 9, Sevilla'),
(5, 'Almacén Oeste', 'Plaza Distribución 18, Zaragoza'),
(6, 'Depósito Centro', 'Calle Principal 4, Barcelona'),
(7, 'Depósito Atlántico', 'Av. Marítima 10, Cádiz'),
(8, 'Depósito Mediterráneo', 'Calle Sol 22, Málaga'),
(9, 'Depósito Norte', 'Paseo Montaña 7, Santander'),
(10, 'Almacén Regional', 'Calle Larga 19, Salamanca'),
(20, 'Almacén Regional', 'Calle Corta 19, Salamanca');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--

CREATE TABLE `clientes` (
  `idCliente` int(11) NOT NULL,
  `nombre` varchar(50) DEFAULT NULL,
  `apellidos` varchar(50) DEFAULT NULL,
  `correoElectronico` varchar(100) DEFAULT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `direccion` varchar(150) DEFAULT NULL,
  `anhoNacimiento` year(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `clientes`
--

INSERT INTO `clientes` (`idCliente`, `nombre`, `apellidos`, `correoElectronico`, `telefono`, `direccion`, `anhoNacimiento`) VALUES
(1, 'Alberto', 'García López', 'albertog@gmail.com', '698123456', 'Calle Mayor 10, Madrid', '1985'),
(2, 'Cristina', 'Sánchez Ruiz', 'cristina.sanchez@hotmail.com', '690234567', 'Av. Las Rosas 15, Valencia', '1992'),
(3, 'Jorge', 'Martínez Díaz', 'jorge.martinez@yahoo.es', '671345678', 'Paseo del Prado 20, Sevilla', '1978'),
(4, 'Laura', 'Gómez Fernández', 'laura.gomez@outlook.com', '622456789', 'Calle del Sol 5, Málaga', '1989'),
(5, 'Manuel', 'Pérez Hernández', 'manuel.perez@gmail.com', '699567890', 'Av. Andalucía 12, Granada', '1990'),
(6, 'Raquel', 'Moreno Vega', 'raquel.moreno@hotmail.com', '609678901', 'Calle Luna 25, Cádiz', '1987'),
(7, 'José', 'Navarro Torres', 'jose.navarro@gmail.com', '693789012', 'Av. La Estrella 8, Zaragoza', '1983'),
(8, 'Marina', 'Hidalgo López', 'marina.hidalgo@gmail.com', '612890123', 'Plaza Mayor 4, Salamanca', '1995'),
(9, 'Pablo', 'Castro Ramos', 'pablo.castro@live.com', '635901234', 'Calle Jardines 6, Bilbao', '1988'),
(10, 'Claudia', 'Vázquez Gómez', 'claudia.vazquez@gmail.com', '610123456', 'Calle Arenal 7, Toledo', '1991'),
(11, 'Daniel', 'Arranz Olmos', 'danielarranzolmos@gmail.com', '4788489', 'PASEO REINA CRISTINA, 34', '1998');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `compras`
--

CREATE TABLE `compras` (
  `idCompra` int(11) NOT NULL,
  `fechaCompra` date DEFAULT NULL,
  `cantidad` int(11) DEFAULT NULL,
  `formaPago` varchar(50) DEFAULT NULL,
  `idEmpleado` int(11) DEFAULT NULL,
  `idAlmacen` int(11) DEFAULT NULL,
  `numeroFactura` varchar(50) DEFAULT NULL,
  `precioTotal` decimal(10,2) DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `compras`
--

INSERT INTO `compras` (`idCompra`, `fechaCompra`, `cantidad`, `formaPago`, `idEmpleado`, `idAlmacen`, `numeroFactura`, `precioTotal`) VALUES
(50, '2025-02-16', NULL, 'Efectivo', 6, NULL, '155', 400.00),
(51, '2025-02-16', NULL, 'Tarjeta', 6, NULL, '8888', 100.00);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detallescompra`
--

CREATE TABLE `detallescompra` (
  `idCompra` int(11) NOT NULL,
  `lineaCompra` int(11) NOT NULL,
  `idProducto` int(11) DEFAULT NULL,
  `cantidad` int(11) DEFAULT NULL,
  `precioCompra` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `detallescompra`
--

INSERT INTO `detallescompra` (`idCompra`, `lineaCompra`, `idProducto`, `cantidad`, `precioCompra`) VALUES
(50, 1, 5, 2, 200.00),
(51, 1, 6, 2, 50.00);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detallesservicio`
--

CREATE TABLE `detallesservicio` (
  `idCliente` int(11) NOT NULL,
  `idServicio` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `detallesservicio`
--

INSERT INTO `detallesservicio` (`idCliente`, `idServicio`) VALUES
(1, 1),
(2, 2),
(3, 3),
(4, 4),
(5, 5),
(6, 6),
(7, 7),
(8, 8),
(9, 9),
(10, 10);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detallesventa`
--

CREATE TABLE `detallesventa` (
  `idVenta` int(11) NOT NULL,
  `lineaVenta` int(11) NOT NULL,
  `idProducto` int(11) DEFAULT NULL,
  `inicioGarantia` date DEFAULT NULL,
  `finGarantia` date DEFAULT NULL,
  `cantidad` int(11) DEFAULT NULL,
  `precio` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `detallesventa`
--

INSERT INTO `detallesventa` (`idVenta`, `lineaVenta`, `idProducto`, `inicioGarantia`, `finGarantia`, `cantidad`, `precio`) VALUES
(24, 0, 6, '2025-02-11', '2028-02-11', 2, 75.00),
(25, 0, 2, '2025-02-11', '2028-02-11', 3, 180.00),
(26, 1, 1, '2025-02-11', '2028-02-11', 1, 1200.00),
(26, 2, 10, '2025-02-11', '2028-02-11', 1, 200.00),
(27, 1, 2, '2025-02-11', '2028-02-11', 1, 180.00),
(27, 2, 3, '2025-02-11', '2028-02-11', 1, 120.00),
(28, 1, 1, '2025-02-11', '2028-02-11', 2, 1200.00),
(29, 1, 3, '2025-02-11', '2028-02-11', 2, 120.00),
(32, 1, 2, '2025-02-12', '2028-02-12', 2, 180.00),
(32, 2, 5, '2025-02-12', '2028-02-12', 1, 280.00),
(33, 1, 2, '2025-02-13', '2028-02-13', 2, 180.00),
(33, 2, 6, '2025-02-13', '2028-02-13', 2, 75.00),
(34, 1, 1, '2025-02-13', '2028-02-13', 1, 1200.00),
(35, 1, 3, '2025-02-13', '2028-02-13', 1, 120.00),
(36, 1, 11, '2025-02-13', '2028-02-13', 2, 25.00),
(38, 1, 2, '2025-02-15', '2028-02-15', 1, 180.00),
(39, 1, 3, '2025-02-15', '2028-02-15', 1, 120.00),
(40, 1, 1, '2025-02-15', '2028-02-15', 1, 1200.00);

--
-- Disparadores `detallesventa`
--
DELIMITER $$
CREATE TRIGGER `before_insert_detallesventa` BEFORE INSERT ON `detallesventa` FOR EACH ROW SET NEW.finGarantia = DATE_ADD(NEW.inicioGarantia, INTERVAL 3 YEAR)
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empleados`
--

CREATE TABLE `empleados` (
  `idEmpleado` int(11) NOT NULL,
  `nombre` varchar(50) DEFAULT NULL,
  `apellidos` varchar(50) DEFAULT NULL,
  `salario` decimal(10,2) DEFAULT NULL,
  `puesto` varchar(50) DEFAULT NULL,
  `departamento` varchar(50) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `fechaContratacion` date DEFAULT NULL,
  `horasSemana` int(11) DEFAULT NULL,
  `nombreUsuario` varchar(20) DEFAULT NULL,
  `contraseñaUsuario` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `empleados`
--

INSERT INTO `empleados` (`idEmpleado`, `nombre`, `apellidos`, `salario`, `puesto`, `departamento`, `email`, `telefono`, `fechaContratacion`, `horasSemana`, `nombreUsuario`, `contraseñaUsuario`) VALUES
(1, 'Carlos', 'Pérez García', 2500.00, 'Director Contable', 'Administración', 'carlos.perez@pczone.com', '654321098', '2022-01-15', 40, 'cperez', 'pass1234'),
(2, 'Ana', 'López Martínez', 1800.00, 'Vendedor', 'Ventas', 'ana.lopez@pczone.com', '612345678', '2021-07-10', 35, 'alopez', 'ana5678'),
(3, 'Luis', 'Gómez Sánchez', 2000.00, 'Técnico', 'Soporte Técnico', 'luis.gomez@pczone.com', '678901234', '2020-05-20', 40, 'lgomez', 'luis2020'),
(4, 'María', 'Hernández Ruiz', 2200.00, 'Analista', 'IT', 'maria.hernandez@pczone.com', '679123456', '2019-11-30', 40, 'mhernandez', 'mariaHR'),
(5, 'Javier', 'Morales Díaz', 2400.00, 'Supervisor', 'Logística', 'javier.morales@pczone.com', '621234567', '2023-03-01', 40, 'jmorales', 'javLog23'),
(6, 'Lucía', 'Romero Torres', 1950.00, 'Vendedor', 'Ventas', 'lucia.romero@pczone.com', '691234567', '2020-08-15', 30, 'lromero', 'lucia1950'),
(7, 'Raúl', 'Gil Fernández', 2600.00, 'Gerente', 'Logística', 'raul.gil@pczone.com', '650987654', '2022-12-01', 40, 'rgil', 'raul987'),
(8, 'Elena', 'Vargas Serrano', 2100.00, 'Técnico', 'IT', 'elena.vargas@pczone.com', '699876543', '2018-06-10', 40, 'evargas', 'elena2100'),
(9, 'David', 'Ortiz Blanco', 1750.00, 'Vendedor', 'Ventas', 'david.ortiz@pczone.com', '610345678', '2021-02-18', 20, 'dortiz', 'david75'),
(10, 'Marina', 'Crespo Velasco', 2800.00, 'Contable', 'Administración', 'marina.crespo@pczone.com', '600112233', '2017-10-25', 40, 'icrespo', 'pass1234'),
(18, 'Jose ', 'Pérez', 12555.00, 'Inutil', 'Inutil', 'Inutil@inutil.com', '86748654', '0000-00-00', 25, 'josePe', 'josePe'),
(19, 'Daniel', 'Arranz Olmos', 80000.00, 'CEO', 'Dirección', 'darranzolmos@gmail.com', '672627434', '0000-00-00', 25, 'darranz', '$2y$10$nBBy0dveF/tMO'),
(24, 'Daniel', 'Arranz Olmos', 80000.00, 'CEO', 'Dirección', 'darranzolmos@gmail.com', '4674846489', '0000-00-00', 25, 'admin', '$2y$10$XEr2poMnXvxWT8gBz86aluMNqxRy7wEVFCkro.JFlqJmGc2g6en7m'),
(26, 'Perico', 'Pérez', 156465.00, 'IT', 'Tech', 'pp@pp.com', '4674846489', '2025-02-14', 25, 'Perico', '$2y$10$a35j5KcoqnOLmB4UoFQ.hOG4qnx8Bf03cYYMuW1uJUBIxnIp5AEka');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inventario`
--

CREATE TABLE `inventario` (
  `idInventario` int(11) NOT NULL,
  `fechaInventario` date DEFAULT NULL,
  `cantidadContada` int(11) DEFAULT NULL,
  `idEmpleado` int(11) DEFAULT NULL,
  `idProducto` int(11) DEFAULT NULL,
  `idAlmacen` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `inventario`
--

INSERT INTO `inventario` (`idInventario`, `fechaInventario`, `cantidadContada`, `idEmpleado`, `idProducto`, `idAlmacen`) VALUES
(1, '2024-01-15', 45, 1, 1, 1),
(2, '2024-01-16', 60, 2, 2, 2),
(3, '2024-01-17', 100, 3, 3, 3),
(4, '2024-01-18', 150, 4, 4, 4),
(5, '2024-01-19', 30, 5, 5, 5),
(6, '2024-01-20', 200, 6, 6, 6),
(7, '2024-01-21', 20, 7, 7, 7),
(8, '2024-01-22', 50, 8, 8, 8),
(9, '2024-01-23', 60, 9, 9, 9),
(10, '2024-01-24', 40, 10, 10, 10);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `idProducto` int(11) NOT NULL,
  `nombreProducto` varchar(100) DEFAULT NULL,
  `marca` varchar(50) DEFAULT NULL,
  `modelo` varchar(50) DEFAULT NULL,
  `precioCompra` decimal(10,2) DEFAULT NULL,
  `precioVenta` decimal(10,2) DEFAULT NULL,
  `stock` int(11) DEFAULT NULL,
  `idProveedor` int(11) DEFAULT NULL,
  `idAlmacen` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`idProducto`, `nombreProducto`, `marca`, `modelo`, `precioCompra`, `precioVenta`, `stock`, `idProveedor`, `idAlmacen`) VALUES
(1, 'Portátil Ultra', 'Dell', 'XPS 15', 900.00, 1200.00, 205, 1, NULL),
(2, 'Monitor Curvo', 'Samsung', 'C24F396', 120.00, 180.00, 79, 2, NULL),
(3, 'Teclado Mecánico', 'Logitech', 'G Pro', 80.00, 120.00, 98, 3, NULL),
(4, 'Ratón Gaming', 'Razer', 'DeathAdder V2', 50.00, 75.00, 150, 4, NULL),
(5, 'Auriculares Inalámbricos', 'Sony', 'WH-1000XM4', 200.00, 280.00, 34, 5, NULL),
(6, 'Disco SSD', 'Kingston', 'A2000', 50.00, 75.00, 212, 6, NULL),
(7, 'Tarjeta Gráfica', 'NVIDIA', 'RTX 3060', 400.00, 550.00, 24, 7, NULL),
(8, 'Procesador', 'AMD', 'Ryzen 7 5800X', 300.00, 450.00, 40, 8, NULL),
(9, 'Fuente de Alimentación', 'Corsair', 'RM850x', 100.00, 150.00, 60, 9, NULL),
(10, 'Placa Base', 'MSI', 'B550-A PRO', 130.00, 200.00, 50, 10, NULL),
(11, 'USB C', 'Iphone', 'MC 40', 15.00, 25.00, 28, 2, NULL),
(12, 'USB C', 'Iphone', 'MC 40', 15.00, 25.00, 225, 2, NULL),
(13, 'USB C PRO', 'Iphone', 'MC 40', 15.00, 25.00, 90, 1, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proveedores`
--

CREATE TABLE `proveedores` (
  `idProveedor` int(11) NOT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `direccion` varchar(150) DEFAULT NULL,
  `correoElectronico` varchar(100) DEFAULT NULL,
  `telefono` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `proveedores`
--

INSERT INTO `proveedores` (`idProveedor`, `nombre`, `direccion`, `correoElectronico`, `telefono`) VALUES
(1, 'TechWorld', 'Calle Innovación 12, Barcelona', 'contact@techworld.com', '934567890'),
(2, 'PCGlobal', 'Av. Tecnología 5, Madrid', 'info@pcglobal.com', '910123456'),
(3, 'HardWarePro', 'Paseo Electrónica 18, Valencia', 'sales@hardwarepro.com', '963234567'),
(4, 'SoftVision', 'Calle Software 22, Sevilla', 'support@softvision.com', '954345678'),
(5, 'CompuPlus', 'Av. Computación 9, Málaga', 'service@compuplus.com', '952456789'),
(6, 'NetTech', 'Calle Redes 14, Bilbao', 'info@nettech.com', '944567890'),
(7, 'DataStore', 'Paseo Datos 8, Granada', 'sales@datastore.com', '958678901'),
(8, 'SmartTech', 'Calle Inteligente 3, Zaragoza', 'support@smarttech.com', '976789012'),
(9, 'DigitalWare', 'Plaza Digital 10, Salamanca', 'contact@digitalware.com', '923890123'),
(10, 'ProComponents', 'Calle Componentes 7, Cádiz', 'danielarranzolmos@gmail.com', '956901234');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `servicios`
--

CREATE TABLE `servicios` (
  `idServicio` int(11) NOT NULL,
  `fechaInicio` date DEFAULT NULL,
  `fechaFin` date DEFAULT NULL,
  `descripcion` text DEFAULT NULL,
  `coste` decimal(10,2) DEFAULT NULL,
  `tipoServicio` varchar(50) DEFAULT NULL,
  `idEmpleado` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `servicios`
--

INSERT INTO `servicios` (`idServicio`, `fechaInicio`, `fechaFin`, `descripcion`, `coste`, `tipoServicio`, `idEmpleado`) VALUES
(1, '2024-04-01', '2024-04-07', 'Instalación de sistema operativo', 150.00, 'Instalación', 1),
(2, '2024-04-08', '2024-04-09', 'Configuración de red doméstica', 100.00, 'Configuración', 2),
(3, '2024-04-10', '2024-04-12', 'Reparación de hardware', 200.00, 'Reparación', 3),
(4, '2024-04-13', '2024-04-14', 'Limpieza de equipos', 50.00, 'Mantenimiento', 4),
(5, '2024-04-15', '2024-04-16', 'Actualización de software', 120.00, 'Actualización', 5),
(6, '2024-04-17', '2024-04-18', 'Recuperación de datos', 300.00, 'Recuperación', 6),
(7, '2024-04-19', '2024-04-20', 'Instalación de antivirus', 80.00, 'Seguridad', 7),
(8, '2024-04-21', '2024-04-22', 'Soporte técnico remoto', 60.00, 'Soporte', 8),
(9, '2024-04-23', '2024-04-24', 'Optimización del sistema', 100.00, 'Optimización', 9),
(10, '2024-04-25', '2024-04-26', 'Diagnóstico de problemas', 70.00, 'Diagnóstico', 10);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ventas`
--

CREATE TABLE `ventas` (
  `idVenta` int(11) NOT NULL,
  `fechaVenta` date DEFAULT NULL,
  `cantidad` int(11) DEFAULT NULL,
  `formaPago` varchar(50) DEFAULT NULL,
  `idCliente` int(11) DEFAULT NULL,
  `idEmpleado` int(11) DEFAULT NULL,
  `idAlmacen` int(11) DEFAULT NULL,
  `totalVenta` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `ventas`
--

INSERT INTO `ventas` (`idVenta`, `fechaVenta`, `cantidad`, `formaPago`, `idCliente`, `idEmpleado`, `idAlmacen`, `totalVenta`) VALUES
(24, '2025-02-11', 5, 'Efectivo', 11, 26, 2, 150.00),
(25, '2025-02-11', NULL, 'Tarjeta', 1, 2, NULL, 540.00),
(26, '2025-02-11', NULL, 'Efectivo', 1, 1, NULL, 1400.00),
(27, '2025-02-11', NULL, 'Efectivo', 11, 4, NULL, 300.00),
(28, '2025-02-11', NULL, 'Efectivo', 1, 1, NULL, 2400.00),
(29, '2025-02-11', NULL, 'Efectivo', 1, 3, NULL, 240.00),
(32, '2025-02-12', NULL, 'Efectivo', 1, 2, NULL, 640.00),
(33, '2025-02-13', NULL, 'Efectivo', 2, 2, NULL, 510.00),
(34, '2025-02-13', NULL, 'Efectivo', 3, 2, NULL, 1200.00),
(35, '2025-02-13', NULL, 'Efectivo', 1, 1, NULL, 120.00),
(36, '2025-02-13', NULL, 'Efectivo', 2, 3, NULL, 50.00),
(38, '2025-02-15', NULL, 'Efectivo', 1, 1, NULL, 180.00),
(39, '2025-02-15', NULL, 'Tarjeta', 1, 1, NULL, 120.00),
(40, '2025-02-15', NULL, 'Efectivo', 1, 1, NULL, 1200.00);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `almacen`
--
ALTER TABLE `almacen`
  ADD PRIMARY KEY (`idAlmacen`);

--
-- Indices de la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`idCliente`);

--
-- Indices de la tabla `compras`
--
ALTER TABLE `compras`
  ADD PRIMARY KEY (`idCompra`),
  ADD KEY `idAlmacen` (`idAlmacen`),
  ADD KEY `fk_compras_empleado` (`idEmpleado`);

--
-- Indices de la tabla `detallescompra`
--
ALTER TABLE `detallescompra`
  ADD PRIMARY KEY (`idCompra`,`lineaCompra`),
  ADD KEY `idProducto` (`idProducto`);

--
-- Indices de la tabla `detallesservicio`
--
ALTER TABLE `detallesservicio`
  ADD PRIMARY KEY (`idCliente`,`idServicio`),
  ADD KEY `idServicio` (`idServicio`);

--
-- Indices de la tabla `detallesventa`
--
ALTER TABLE `detallesventa`
  ADD PRIMARY KEY (`idVenta`,`lineaVenta`),
  ADD KEY `idProducto` (`idProducto`);

--
-- Indices de la tabla `empleados`
--
ALTER TABLE `empleados`
  ADD PRIMARY KEY (`idEmpleado`);

--
-- Indices de la tabla `inventario`
--
ALTER TABLE `inventario`
  ADD PRIMARY KEY (`idInventario`),
  ADD KEY `idProducto` (`idProducto`),
  ADD KEY `idAlmacen` (`idAlmacen`),
  ADD KEY `fk_inventario_empleado` (`idEmpleado`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`idProducto`),
  ADD KEY `idProveedor` (`idProveedor`),
  ADD KEY `idAlmacen` (`idAlmacen`);

--
-- Indices de la tabla `proveedores`
--
ALTER TABLE `proveedores`
  ADD PRIMARY KEY (`idProveedor`);

--
-- Indices de la tabla `servicios`
--
ALTER TABLE `servicios`
  ADD PRIMARY KEY (`idServicio`),
  ADD KEY `fk_servicios_empleado` (`idEmpleado`);

--
-- Indices de la tabla `ventas`
--
ALTER TABLE `ventas`
  ADD PRIMARY KEY (`idVenta`),
  ADD KEY `idCliente` (`idCliente`),
  ADD KEY `idAlmacen` (`idAlmacen`),
  ADD KEY `fk_ventas_empleado` (`idEmpleado`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `almacen`
--
ALTER TABLE `almacen`
  MODIFY `idAlmacen` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT de la tabla `clientes`
--
ALTER TABLE `clientes`
  MODIFY `idCliente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `compras`
--
ALTER TABLE `compras`
  MODIFY `idCompra` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;

--
-- AUTO_INCREMENT de la tabla `empleados`
--
ALTER TABLE `empleados`
  MODIFY `idEmpleado` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT de la tabla `inventario`
--
ALTER TABLE `inventario`
  MODIFY `idInventario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `idProducto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `proveedores`
--
ALTER TABLE `proveedores`
  MODIFY `idProveedor` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `servicios`
--
ALTER TABLE `servicios`
  MODIFY `idServicio` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `ventas`
--
ALTER TABLE `ventas`
  MODIFY `idVenta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `compras`
--
ALTER TABLE `compras`
  ADD CONSTRAINT `compras_ibfk_3` FOREIGN KEY (`idAlmacen`) REFERENCES `almacen` (`idAlmacen`),
  ADD CONSTRAINT `fk_compras_empleado` FOREIGN KEY (`idEmpleado`) REFERENCES `empleados` (`idEmpleado`) ON DELETE CASCADE;

--
-- Filtros para la tabla `detallescompra`
--
ALTER TABLE `detallescompra`
  ADD CONSTRAINT `detallescompra_ibfk_1` FOREIGN KEY (`idCompra`) REFERENCES `compras` (`idCompra`),
  ADD CONSTRAINT `detallescompra_ibfk_2` FOREIGN KEY (`idProducto`) REFERENCES `productos` (`idProducto`);

--
-- Filtros para la tabla `detallesservicio`
--
ALTER TABLE `detallesservicio`
  ADD CONSTRAINT `detallesservicio_ibfk_1` FOREIGN KEY (`idCliente`) REFERENCES `clientes` (`idCliente`),
  ADD CONSTRAINT `detallesservicio_ibfk_2` FOREIGN KEY (`idServicio`) REFERENCES `servicios` (`idServicio`);

--
-- Filtros para la tabla `detallesventa`
--
ALTER TABLE `detallesventa`
  ADD CONSTRAINT `detallesventa_ibfk_1` FOREIGN KEY (`idVenta`) REFERENCES `ventas` (`idVenta`),
  ADD CONSTRAINT `detallesventa_ibfk_2` FOREIGN KEY (`idProducto`) REFERENCES `productos` (`idProducto`);

--
-- Filtros para la tabla `inventario`
--
ALTER TABLE `inventario`
  ADD CONSTRAINT `fk_inventario_empleado` FOREIGN KEY (`idEmpleado`) REFERENCES `empleados` (`idEmpleado`) ON DELETE CASCADE,
  ADD CONSTRAINT `inventario_ibfk_2` FOREIGN KEY (`idProducto`) REFERENCES `productos` (`idProducto`),
  ADD CONSTRAINT `inventario_ibfk_3` FOREIGN KEY (`idAlmacen`) REFERENCES `almacen` (`idAlmacen`);

--
-- Filtros para la tabla `productos`
--
ALTER TABLE `productos`
  ADD CONSTRAINT `productos_ibfk_1` FOREIGN KEY (`idProveedor`) REFERENCES `proveedores` (`idProveedor`),
  ADD CONSTRAINT `productos_ibfk_2` FOREIGN KEY (`idAlmacen`) REFERENCES `almacen` (`idAlmacen`);

--
-- Filtros para la tabla `servicios`
--
ALTER TABLE `servicios`
  ADD CONSTRAINT `fk_servicios_empleado` FOREIGN KEY (`idEmpleado`) REFERENCES `empleados` (`idEmpleado`) ON DELETE CASCADE;

--
-- Filtros para la tabla `ventas`
--
ALTER TABLE `ventas`
  ADD CONSTRAINT `fk_ventas_empleado` FOREIGN KEY (`idEmpleado`) REFERENCES `empleados` (`idEmpleado`) ON DELETE CASCADE,
  ADD CONSTRAINT `ventas_ibfk_1` FOREIGN KEY (`idCliente`) REFERENCES `clientes` (`idCliente`),
  ADD CONSTRAINT `ventas_ibfk_3` FOREIGN KEY (`idAlmacen`) REFERENCES `almacen` (`idAlmacen`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
