-- Crear base de datos
CREATE DATABASE PCZone;
USE PCZone;

-- Tabla Empleados
CREATE TABLE empleados (
    idEmpleado INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(50),
    apellidos VARCHAR(50),
    salario DECIMAL(10, 2),
    puesto VARCHAR(50),
    departamento VARCHAR(50),
    email VARCHAR(100),
    telefono VARCHAR(20),
    fechaContratacion DATE,
    horasSemana INT, 
    nombreUsuario VARCHAR(20), 
    contraseñaUsuario VARCHAR(255)
);

-- Tabla Clientes
CREATE TABLE clientes (
    idCliente INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(50),
    apellidos VARCHAR(50),
    correoElectronico VARCHAR(100),
    telefono VARCHAR(20),
    direccion VARCHAR(150),
    anhoNacimiento YEAR
);

-- Tabla Proveedores
CREATE TABLE proveedores (
    idProveedor INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(100),
    direccion VARCHAR(150),
    correoElectronico VARCHAR(100),
    telefono VARCHAR(20)
);

-- Tabla Productos
CREATE TABLE productos (
    idProducto INT PRIMARY KEY AUTO_INCREMENT,
    nombreProducto VARCHAR(100),
    marca VARCHAR(50),
    modelo VARCHAR(50),
    precioCompra DECIMAL(10, 2),
    precioVenta DECIMAL(10, 2),
    stock INT,
    idProveedor INT,
    FOREIGN KEY (idProveedor) REFERENCES proveedores(idProveedor)
);

-- Tabla Almacen
CREATE TABLE almacen (
    idAlmacen INT PRIMARY KEY AUTO_INCREMENT,
    nombreAlmacen VARCHAR(100),
    direccionAlmacen VARCHAR(150)
);

-- Tabla Inventario
CREATE TABLE inventario (
    idInventario INT PRIMARY KEY AUTO_INCREMENT,
    fechaInventario DATE,
    cantidadContada INT,
    idEmpleado INT,
    idProducto INT,
    idAlmacen INT,
    FOREIGN KEY (idEmpleado) REFERENCES empleados(idEmpleado),
    FOREIGN KEY (idProducto) REFERENCES productos(idProducto),
    FOREIGN KEY (idAlmacen) REFERENCES almacen(idAlmacen)
);

-- Tabla Ventas
CREATE TABLE ventas (
    idVenta INT PRIMARY KEY AUTO_INCREMENT,
    fechaVenta DATE,
    cantidad INT,
    formaPago VARCHAR(50),
    idCliente INT,
    idEmpleado INT,
    idAlmacen INT,
    FOREIGN KEY (idCliente) REFERENCES clientes(idCliente),
    FOREIGN KEY (idEmpleado) REFERENCES empleados(idEmpleado),
    FOREIGN KEY (idAlmacen) REFERENCES almacen(idAlmacen)
);

-- Tabla DetallesVenta
CREATE TABLE detallesVenta (
    idVenta INT,
    lineaVenta INT,
    idProducto INT,
    inicioGarantia DATE,
    finGarantia DATE,
    cantidad INT,
    precio DECIMAL(10, 2),
    PRIMARY KEY (idVenta, lineaVenta),
    FOREIGN KEY (idVenta) REFERENCES ventas(idVenta),
    FOREIGN KEY (idProducto) REFERENCES productos(idProducto)
);

-- Tabla Compras
CREATE TABLE compras (
    idCompra INT PRIMARY KEY AUTO_INCREMENT,
    fechaCompra DATE,
    cantidad INT,
    formaPago VARCHAR(50),
    idProveedor INT,
    idEmpleado INT,
    idAlmacen INT,
    FOREIGN KEY (idProveedor) REFERENCES proveedores(idProveedor),
    FOREIGN KEY (idEmpleado) REFERENCES empleados(idEmpleado),
    FOREIGN KEY (idAlmacen) REFERENCES almacen(idAlmacen)
);

-- Tabla DetallesCompra
CREATE TABLE detallesCompra (
    idCompra INT,
    lineaCompra INT,
    idProducto INT,
    cantidad INT,
    precio DECIMAL(10, 2),
    PRIMARY KEY (idCompra, lineaCompra),
    FOREIGN KEY (idCompra) REFERENCES compras(idCompra),
    FOREIGN KEY (idProducto) REFERENCES productos(idProducto)
);

-- Tabla Servicios
CREATE TABLE servicios (
    idServicio INT PRIMARY KEY AUTO_INCREMENT,
    fechaInicio DATE,
    fechaFin DATE,
    descripcion TEXT,
    coste DECIMAL(10, 2),
    tipoServicio VARCHAR(50),
    idEmpleado INT,
    FOREIGN KEY (idEmpleado) REFERENCES empleados(idEmpleado)
);

-- Tabla DetallesServicio
CREATE TABLE detallesServicio (
    idCliente INT,
    idServicio INT,
    PRIMARY KEY (idCliente, idServicio),
    FOREIGN KEY (idCliente) REFERENCES clientes(idCliente),
    FOREIGN KEY (idServicio) REFERENCES servicios(idServicio)
);
