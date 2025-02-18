<?php
session_start();  // Iniciar sesión al principio del archivo
// Verificar que el usuario está logueado antes de permitir acceso al contenido
if (!isset($_SESSION['usuario'])) {
    header('Location: index.php');
    exit();  // Asegúrate de llamar a exit después de la redirección
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contactos - PC Zone</title>
    <link rel="stylesheet" href="Assets/styles.css">
</head>
<body>
    <?php require_once 'Shared/navegador.php'; ?>
    <!-- Contenido específico de Contactos -->
    <div id="main-content">
        <h1>Contactos</h1>
        <!-- Contenedor para la tabla -->
        <div class="radio-inputs">
            <label class="radio">
            <input type="radio" name="radio" value="empleados" checked>
            <span class="name">Empleados</span>
            </label>
            <label class="radio">
                <input type="radio" name="radio" value="clientes">
                <span class="name">Clientes</span>
            </label>
                
            <label class="radio">
                <input type="radio" name="radio" value="proveedores">
                <span class="name">Proveedores</span>
            </label>
        </div>
        <table id="contactosTable">
        <thead>
            <tr id="contactosHeader">
                <!-- Los encabezados se insertarán aquí mediante JavaScript -->
            </tr>
        </thead>
        <tbody>
            <!-- Los datos se insertarán aquí mediante JavaScript -->
        </tbody>
    </table>
    <div id="mensaje" class="mensaje" style="display: none;"></div>
    <button class="Btn" id="openFormBtn">
        <div class="sign">+</div>
        <div class="text">Añadir</div>
    </button>
    <!-- Formulario emergente (inicialmente oculto) EMPLEADOS -->
    <div id="formPopupEmpleado" class="form-popup" style="display: none;">
        <div class="form-container">
            <span class="closeBtn">&times;</span>
            <form action="Controllers/ContactosController.php" method="POST">
                <label for="nombreEmpleado">Nombre:</label>
                <input type="text" id="nombreEmpleado" name="nombreEmpleado" required>

                <label for="apellidosEmpleado">Apellidos:</label>
                <input type="text" id="apellidosEmpleado" name="apellidosEmpleado" required>

                <label for="salario">Salario:</label>
                <input type="text" id="salario" name="salario" required>

                <label for="puesto">Puesto:</label>
                <input type="text" id="puesto" name="puesto" required>

                <label for="departamento">Departamento:</label>
                <input type="text" id="departamento" name="departamento" required>

                <label for="email">Email:</label>
                <input type="text" id="email" name="email" required>

                <label for="telefonoEmpleado">Teléfono:</label>
                <input type="text" id="telefonoEmpleado" name="telefonoEmpleado" required>

                <label for="fechaContratacion">Fecha de Contratación:</label>
                <input type="text" id="fechaContratacion" name="fechaContratacion" required>

                <label for="horasSemana">Horas por Semana:</label>
                <input type="text" id="horasSemana" name="horasSemana" required>

                <label for="nombreUsuario">Nombre de Usuario:</label>
                <input type="text" id="nombreUsuario" name="nombreUsuario" required>

                <label for="contraseñaUsuario">Contraseña de Usuario:</label>
                <input type="password" id="contraseñaUsuario" name="contraseñaUsuario" required>
                
                <input type="hidden" id="idEmpleado" name="idEmpleado" value="">
                <input type="hidden" name="action" value="addEmpleado">

                <button id="btnAñadirEmpleado" type="submit" class="save">Guardar</button>
            </form>
        </div>
    </div>
    <!-- Formulario emergente (inicialmente oculto) CLIENTES -->
    <div id="formPopupCliente" class="form-popup" style="display: none;">
        <div class="form-container">
            <span class="closeBtn">&times;</span>
            <form action="Controllers/ContactosController.php" method="POST">
                <label for="nombre">Nombre:</label>
                <input type="text" id="nombreCliente" name="nombreCliente" required>

                <label for="apellidos">Apellidos:</label>
                <input type="text" id="apellidosCliente" name="apellidosCliente" required>

                <label for="correoElectronico">Email:</label>
                <input type="text" id="correoElectronico" name="correoElectronico" required>

                <label for="telefono">Teléfono:</label>
                <input type="text" id="telefonoCliente" name="telefonoCliente" required>

                <label for="direccion">Dirección:</label>
                <input type="text" id="direccionCliente" name="direccionCliente" required>

                <label for="anhoNacimiento">Año de Nacimiento:</label>
                <input type="text" id="anhoNacimiento" name="anhoNacimiento" required>

                <input type="hidden" id="idCliente" name="idCliente" value="">
                <input type="hidden" name="action" value="addCliente">

                <button id="btnAñadirCliente" type="submit" class="save">Guardar</button>
            </form>
        </div>
    </div>
    <!-- Formulario emergente (inicialmente oculto) Proveedores -->
    <div id="formPopupProveedor" class="form-popup" style="display: none;">
        <div class="form-container">
            <span class="closeBtn">&times;</span>
            <form action="Controllers/ContactosController.php" method="POST">
                <label for="nombreProveedor">Nombre:</label>
                <input type="text" id="nombreProveedor" name="nombreProveedor" required>

                <label for="direcionProveedor">Dirección</label>
                <input type="text" id="direccionProveedor" name="direccionProveedor" required>

                <label for="correoElectronicoProveedor">Email:</label>
                <input type="text" id="correoElectronicoProveedor" name="correoElectronicoProveedor" required>

                <label for="telefonoProveedor">Telefono:</label>
                <input type="text" id="telefonoProveedor" name="telefonoProveedor" required>

                <input type="hidden" id="idProveedor" name="idProveedor" value="">
                <input type="hidden" name="action" value="addProveedor">
                <button id="btnAñadirProveedor" type="submit" class="save">Guardar</button>
            </form>
        </div>
    </div>
    <!-- Mensaje emergente (inicialmente oculto) Editar Empleados-->
    <div id="edicionEmpleado" class="form-popup" style="display: none;">
        <div class="form-container">
            <span class="closeBtn">&times;</span>
            <form id="formEditarEmpleado" action="Controllers/ContactosController.php" method="POST">
                <label for="enombreEmpleado">Nombre:</label>
                <input type="text" id="enombreEmpleado" name="enombreEmpleado" required>

                <label for="eapellidosEmpleado">Apellidos:</label>
                <input type="text" id="eapellidosEmpleado" name="eapellidosEmpleado" required>

                <label for="esalario">Salario:</label>
                <input type="number" id="esalario" name="esalario" required>

                <label for="epuesto">Puesto:</label>
                <input type="text" id="epuesto" name="epuesto" required>

                <label for="edepartamento">Departamento:</label>
                <input type="text" id="edepartamento" name="edepartamento" required>

                <label for="eemail">Email:</label>
                <input type="email" id="eemail" name="eemail" required>

                <label for="etelefonoEmpleado">Teléfono:</label>
                <input type="tel" id="etelefonoEmpleado" name="etelefonoEmpleado" required>

                <label for="efechaContratacion">Fecha de Contratación:</label>
                <input type="date" id="efechaContratacion" name="efechaContratacion" required>

                <label for="ehorasSemana">Horas por Semana:</label>
                <input type="number" id="ehorasSemana" name="ehorasSemana" required>

                <label for="enombreUsuario">Nombre de Usuario:</label>
                <input type="text" id="enombreUsuario" name="enombreUsuario" required>

                <label for="econtraseñaUsuario">Contraseña de Usuario:</label>
                <input type="password" id="econtraseñaUsuario" name="econtraseñaUsuario" required>

                <!-- Campo oculto para enviar el id del empleado -->
                <input type="hidden" id="eidEmpleado" name="eidEmpleado" value="">
                <!-- Acción del formulario -->
                <input type="hidden" name="action" value="updateEmpleado">

                <button id="btnEditarEmpleado" type="submit" class="save">Guardar Cambios</button>
            </form>
        </div>
    </div>
    <!-- Mensaje emergente (inicialmente oculto) Editar Clientes-->
    <div id="edicionCliente" class="form-popup" style="display: none;">
        <div class="form-container">
            <span class="closeBtn">&times;</span>
            <form id="formEditarCliente" action="Controllers/ContactosController.php" method="POST">
                <label for="enombreCliente">Nombre:</label>
                <input type="text" id="enombreCliente" name="enombreCliente" required>

                <label for="eapellidosCliente">Apellidos:</label>
                <input type="text" id="eapellidosCliente" name="eapellidosCliente" required>

                <label for="ecorreoElectronico">Correo Electrónico:</label>
                <input type="email" id="ecorreoElectronico" name="ecorreoElectronico" required>

                <label for="etelefonoCliente">Teléfono:</label>
                <input type="tel" id="etelefonoCliente" name="etelefonoCliente" required>

                <label for="edireccion">Dirección:</label>
                <input type="text" id="edireccion" name="edireccion" required>

                <label for="eanhoNacimiento">Año de Nacimiento:</label>
                <input type="number" id="eanhoNacimiento" name="eanhoNacimiento" required>

                <!-- Campo oculto para enviar el id del cliente -->
                <input type="hidden" id="eidCliente" name="eidCliente" value="">
                <!-- Acción del formulario -->
                <input type="hidden" name="action" value="updateCliente">

                <button id="btnEditarCliente" type="submit" class="save">Guardar Cambios</button>
            </form>
        </div>
    </div>
    <!-- Mensaje emergente (inicialmente oculto) Editar Proveedores-->
    <div id="edicionProveedor" class="form-popup" style="display: none;">
        <div class="form-container">
            <span class="closeBtn">&times;</span>
            <form id="formEditarProveedor" action="Controllers/ContactosController.php" method="POST">
                <label for="enombreProveedor">Nombre:</label>
                <input type="text" id="enombreProveedor" name="enombreProveedor" required>

                <label for="edireccionProveedor">Dirección:</label>
                <input type="text" id="edireccionProveedor" name="edireccionProveedor" required>

                <label for="ecorreoElectronico">Correo Electrónico:</label>
                <input type="email" id="ecorreoElectronico" name="ecorreoElectronico" required>

                <label for="etelefonoProveedor">Teléfono:</label>
                <input type="tel" id="etelefonoProveedor" name="etelefonoProveedor" required>

                <!-- Campo oculto para enviar el id del proveedor -->
                <input type="hidden" id="eidProveedor" name="eidProveedor" value="">
                <!-- Acción del formulario -->
                <input type="hidden" name="action" value="updateProveedor">

                <button id="btnEditarProveedor" type="submit" class="save">Guardar Cambios</button>
            </form>
        </div>
    </div>



    
    
    <script src="Assets/contactos.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            cargarDatos('empleados');

            document.querySelectorAll('input[name="radio"]').forEach(radio => {
                radio.addEventListener('change', function() {
                    cargarDatos(this.value);
                });
            });
        });
    </script>
</body>
</html>
