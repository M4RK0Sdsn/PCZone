document.addEventListener("DOMContentLoaded", () =>{
    // Función para cargar los datos según el tipo de tabla (empleados, clientes, proveedores)
    function cargarDatos(tabla) {
        // Realizar la solicitud AJAX para obtener los datos
        fetch('controllers/ContactosController.php?tabla=' + tabla) // Enviar el parámetro 'tabla' en la URL
            .then(response => response.json()) // Esperamos que la respuesta sea JSON
            .then(data => {
                console.log(data); // Ver los datos en la consola
                crearTabla(data.columnas, data.datos); // Crear la tabla con los datos
            })
            .catch(error => console.error('Error al obtener los datos:', error));
    }

    // Función para crear la tabla con los datos de los empleados
    function crearTabla(columnas, datos) {
        const contacto = document.querySelector('input[name="radio"]:checked').value;
        const tablaHead = document.getElementById('contactosHeader');
        const tablaBody = document.getElementById('contactosTable').getElementsByTagName('tbody')[0];
    
        // Limpiar la tabla antes de agregar nuevos datos
        tablaHead.innerHTML = '';
        tablaBody.innerHTML = '';
    
        // Crear los encabezados de la tabla
        columnas.forEach(columna => {
            const th = document.createElement('th');
            th.textContent = columna;
            tablaHead.appendChild(th);
        });
    
        const thAcciones = document.createElement('th');
        thAcciones.textContent = 'Acciones';
        tablaHead.appendChild(thAcciones);
    
        // Iterar sobre los datos y agregarlos a la tabla
        datos.forEach(fila => {
            const tr = document.createElement('tr');
    
            // Asignar el idContacto directamente (eliminar redundancia)
            const idContacto = fila.Id || fila.id || fila.idContacto; // Cambia según el nombre correcto de la propiedad
    
            console.log('ID Asignado:', idContacto);
            tr.dataset.id = idContacto; // Asignar el id dinámicamente según el tipo de contacto
    
            columnas.forEach(columna => {
                const td = document.createElement('td');
                td.textContent = fila[columna];
                tr.appendChild(td);
            });
    
            // Crear columna para botones de acciones
            const tdAcciones = document.createElement('td');
    
            // Botón de editar
            const btnEditar = document.createElement('button');
            btnEditar.classList.add('btnEditar');
            btnEditar.dataset.id = idContacto; // Usar el id correspondiente
            btnEditar.innerHTML = `
            <svg class="edit-svgIcon" viewBox="0 0 512 512">
                <path d="M410.3 231l11.3-11.3-33.9-33.9-62.1-62.1L291.7 89.8l-11.3 11.3-22.6 22.6L58.6 322.9c-10.4 10.4-18 23.3-22.2 37.4L1 480.7c-2.5 8.4-.2 17.5 6.1 23.7s15.3 8.5 23.7 6.1l120.3-35.4c14.1-4.2 27-11.8 37.4-22.2L387.7 253.7 410.3 231zM160 399.4l-9.1 22.7c-4 3.1-8.5 5.4-13.3 6.9L59.4 452l23-78.1c1.4-4.9 3.8-9.4 6.9-13.3l22.7-9.1v32c0 8.8 7.2 16 16 16h32zM362.7 18.7L348.3 33.2 325.7 55.8 314.3 67.1l33.9 33.9 62.1 62.1 33.9 33.9 11.3-11.3 22.6-22.6 14.5-14.5c25-25 25-65.5 0-90.5L453.3 18.7c-25-25-65.5-25-90.5 0zm-47.4 168l-144 144c-6.2 6.2-16.4 6.2-22.6 0s-6.2-16.4 0-22.6l144-144c6.2-6.2 16.4-6.2 22.6 0s6.2 16.4 0 22.6z"></path>
            </svg>
            `;
            tdAcciones.appendChild(btnEditar);

            btnEditar.addEventListener('click', () => {
                const contacto = document.querySelector('input[name="radio"]:checked').value;
                console.log('Tipo de contacto:', contacto); // Verificar el tipo de contacto
                editarContacto(fila, contacto); // Llamar con el objeto fila completo
            });
            
    
            // Botón de borrar
            const btnBorrar = document.createElement('button');
            btnBorrar.classList.add('btnBorrar');
            btnBorrar.dataset.id = idContacto; // Asignar el id correspondiente
            btnBorrar.innerHTML = `
            <svg class="delete-svgIcon" viewBox="0 0 448 512">
                <path d="M135.2 17.7L128 32H32C14.3 32 0 46.3 0 64S14.3 96 32 96H416c17.7 0 32-14.3 32-32s-14.3-32-32-32H320l-7.2-14.3C307.4 6.8 296.3 0 284.2 0H163.8c-12.1 0-23.2 6.8-28.6 17.7zM416 128H32L53.2 467c1.6 25.3 22.6 45 47.9 45H346.9c25.3 0 46.3-19.7 47.9-45L416 128z"></path>
            </svg>
            `;
            tdAcciones.appendChild(btnBorrar);
    
            // Asignar el evento al botón de borrar
            btnBorrar.addEventListener('click', () => {
                console.log('ID del contacto a borrar:', idContacto); // Verificar el ID en la consola
                borrarContacto(idContacto, contacto);
            });
    
            tr.appendChild(tdAcciones);
            tablaBody.appendChild(tr);
        });
    }
    

    // Cargar automáticamente la tabla de empleados al cargar la página
    if (window.location.pathname.includes('contactos.php')) {
        cargarDatos('empleados'); 
    }
    
    // Agregar event listeners a los botones de radio
    document.querySelectorAll('input[name="radio"]').forEach(radio => {
        radio.addEventListener('change', function() {
            cargarDatos(this.value);
        });
    });

    const openFormBtn = document.getElementById('openFormBtn');
    const formPopupEmpleado = document.getElementById('formPopupEmpleado');
    const formPopupCliente = document.getElementById('formPopupCliente');
    const formPopupProveedor = document.getElementById('formPopupProveedor');
    const edicionEmpleado = document.getElementById('edicionEmpleado');

    const closeButtons = document.querySelectorAll('.closeBtn');
    
    openFormBtn.addEventListener('click', function () {
        const selectedRadio = document.querySelector('input[name="radio"]:checked').value;

        // Ocultar todos los formularios
        formPopupEmpleado.style.display = 'none';
        formPopupCliente.style.display = 'none';
        formPopupProveedor.style.display = 'none';

        // Mostrar el formulario correspondiente
        if (selectedRadio === 'empleados') {
            formPopupEmpleado.style.display = 'block';
        } else if (selectedRadio === 'clientes') {
            formPopupCliente.style.display = 'block';
        }else if (selectedRadio === 'proveedores') {
            formPopupProveedor.style.display = 'block';
        }
    });

    // Cerrar los formularios al hacer clic en la 'X'
    closeButtons.forEach(button => {
        button.addEventListener('click', function () {
            formPopupEmpleado.style.display = 'none';
            formPopupCliente.style.display = 'none';
            formPopupProveedor.style.display = 'none';
            formPopupProveedor.style.display = 'none';
            edicionEmpleado.style.display = 'none';
            edicionCliente.style.display = 'none';
            edicionProveedor.style.display = 'none';
        });
    });

    //Funciones para añadir empleados, clientes y proveedores
    function añadirEmpleado() {
        const form = document.querySelector('form'); // Seleccionamos el formulario
        const btnAñadir = document.getElementById('btnAñadirEmpleado'); // Seleccionamos el botón
    
        btnAñadir.addEventListener('click', function(event) {
            event.preventDefault(); // Evita que se recargue la página si el botón está dentro de un formulario
            console.log("Formulario enviado");
            // Capturar los valores del formulario
            const nombreEmpleado = document.getElementById('nombreEmpleado').value;
            const apellidosEmpleado = document.getElementById('apellidosEmpleado').value; 
            const salario = document.getElementById('salario').value;
            const puesto = document.getElementById('puesto').value;
            const departamento = document.getElementById('departamento').value;
            const email = document.getElementById('email').value;
            const telefonoEmpleado = document.getElementById('telefonoEmpleado').value;
            const fechaContratacion = document.getElementById('fechaContratacion').value;
            const horasSemana = document.getElementById('horasSemana').value;
            const nombreUsuario = document.getElementById('nombreUsuario').value;
            const contraseñaUsuario = document.getElementById('contraseñaUsuario').value;
    
            // Crear un objeto FormData para enviar los datos
            const formData = new FormData();
            formData.append('nombreEmpleado', nombreEmpleado);
            formData.append('apellidosEmpleado', apellidosEmpleado);
            formData.append('salario', salario);
            formData.append('puesto', puesto);
            formData.append('departamento', departamento);
            formData.append('email', email);
            formData.append('telefonoEmpleado', telefonoEmpleado);
            formData.append('fechaContratacion', fechaContratacion);
            formData.append('horasSemana', horasSemana);
            formData.append('nombreUsuario', nombreUsuario);
            formData.append('contraseñaUsuario', contraseñaUsuario);
            
    
            // Enviar los datos mediante AJAX
            fetch('Controllers/ContactosController.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    const mensajeDiv = document.getElementById('mensaje'); // Asumiendo que este es el div de mensaje
                    const formPopup = document.getElementById('formPopupEmpleado'); // Asumiendo que este es el formulario emergente
    
                    // Mostrar mensaje de éxito o error según la respuesta del backend
                    if (data.status === 'exito') {
                        mensajeDiv.style.backgroundColor = '#4CAF50'; // Color verde para éxito
                        mensajeDiv.textContent = 'Empleado añadido con éxito.';
                        cargarDatos('empleados'); // Recargar los datos de la tabla
                        
                    } else {
                        mensajeDiv.style.backgroundColor = '#f44336'; // Color rojo para error
                        mensajeDiv.textContent = 'Error al añadir el empleado.';
                    }
                    mensajeDiv.style.display = 'block'; // Mostrar el mensaje
    
                    // Limpiar el formulario
                    form.reset();
    
                    // Cerrar el formulario emergente
                    formPopup.style.display = 'none';
    
                    // Ocultar el mensaje después de 5 segundos
                    setTimeout(() => {
                        mensajeDiv.style.display = 'none';
                    }, 5000);
                })
                .catch(error => {
                    const mensajeDiv = document.getElementById('mensaje'); // Asumiendo que este es el div de mensaje
    
                    // Manejar cualquier error en la petición
                    mensajeDiv.style.backgroundColor = '#f44336'; // Color rojo para error
                    mensajeDiv.textContent = 'Error al procesar la solicitud.';
                    mensajeDiv.style.display = 'block'; // Mostrar el mensaje
                    setTimeout(() => {
                        mensajeDiv.style.display = 'none';
                    }, 5000);
                });
        });
    }
    function añadirCliente() {
        const form = document.querySelector('form'); // Seleccionamos el formulario
        const btnAñadir = document.getElementById('btnAñadirCliente'); // Botón de añadir cliente
    
        btnAñadir.addEventListener('click', function(event) {
            event.preventDefault(); // Evita recargar la página si el botón está dentro del formulario
    
            // Capturar los valores del formulario
            const nombre = document.getElementById('nombreCliente').value;
            const apellidos = document.getElementById('apellidosCliente').value;
            const correoElectronico = document.getElementById('correoElectronico').value;
            const telefono = document.getElementById('telefonoCliente').value;
            const direccion = document.getElementById('direccionCliente').value;
            const anhoNacimiento = document.getElementById('anhoNacimiento').value;
    
            // Crear un objeto FormData para enviar los datos
            const formData = new FormData();
            formData.append('nombre', nombre);
            formData.append('apellidos', apellidos);
            formData.append('correoElectronico', correoElectronico);
            formData.append('telefono', telefono);
            formData.append('direccion', direccion);
            formData.append('anhoNacimiento', anhoNacimiento);
    
            // Enviar los datos mediante AJAX
            fetch('Controllers/ContactosController.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                const mensajeDiv = document.getElementById('mensaje');
                const formPopup = document.getElementById('formPopupCliente');
    
                if (data.status === 'exito') {
                    mensajeDiv.style.backgroundColor = '#4CAF50'; // Verde éxito
                    mensajeDiv.textContent = 'Cliente añadido con éxito.';
                    cargarDatos('clientes'); // Recargar datos de la tabla
                    
                } else {
                    mensajeDiv.style.backgroundColor = '#f44336'; // Rojo error
                    mensajeDiv.textContent = 'Error al añadir el cliente.';
                }
                mensajeDiv.style.display = 'block';
    
                form.reset(); // Limpiar el formulario
                formPopup.style.display = 'none'; // Cerrar el formulario emergente
    
                setTimeout(() => {
                    mensajeDiv.style.display = 'none';
                }, 5000);
            })
            .catch(error => {
                const mensajeDiv = document.getElementById('mensaje');
                mensajeDiv.style.backgroundColor = '#f44336';
                mensajeDiv.textContent = 'Error al procesar la solicitud.';
                mensajeDiv.style.display = 'block';
                setTimeout(() => {
                    mensajeDiv.style.display = 'none';
                }, 5000);
            });
        });
    }
    function añadirProveedor() {
        const form = document.querySelector('form'); // Seleccionamos el formulario
        const btnAñadir = document.getElementById('btnAñadirProveedor'); // Botón de añadir proveedor
    
        btnAñadir.addEventListener('click', function(event) {
            event.preventDefault(); // Evita recargar la página
    
            // Capturar los valores del formulario
            const nombre = document.getElementById('nombreProveedor').value;
            const direccion = document.getElementById('direccionProveedor').value;
            const correoElectronico = document.getElementById('emailProveedor').value;
            const telefono = document.getElementById('telefonoProveedor').value;
    
            // Crear objeto FormData
            const formData = new FormData();
            formData.append('nombre', nombre);
            formData.append('direccion', direccion);
            formData.append('correoElectronico', correoElectronico);
            formData.append('telefono', telefono);
    
            // Enviar los datos mediante fetch (AJAX)
            fetch('Controllers/ContactosController.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                const mensajeDiv = document.getElementById('mensaje');
                const formPopup = document.getElementById('formPopupProveedor');
    
                if (data.status === 'exito') {
                    mensajeDiv.style.backgroundColor = '#4CAF50';
                    mensajeDiv.textContent = 'Proveedor añadido con éxito.';
                    cargarDatos('proveedores');  // Recargar tabla de proveedores
                } else {
                    mensajeDiv.style.backgroundColor = '#f44336';
                    mensajeDiv.textContent = 'Error al añadir el proveedor.';
                }
                mensajeDiv.style.display = 'block';
    
                // Limpiar formulario
                form.reset();
                formPopup.style.display = 'none';
    
                // Ocultar mensaje después de 5 segundos
                setTimeout(() => {
                    mensajeDiv.style.display = 'none';
                }, 5000);
            })
            .catch(error => {
                const mensajeDiv = document.getElementById('mensaje');
                mensajeDiv.style.backgroundColor = '#f44336';
                mensajeDiv.textContent = 'Error al procesar la solicitud.';
                mensajeDiv.style.display = 'block';
                setTimeout(() => {
                    mensajeDiv.style.display = 'none';
                }, 5000);
            });
        });
    }
    function editarContacto(fila, contacto) {
        // Mostrar el formulario de edición adecuado
        console.log("Valor de contacto:", contacto, "Datos del contacto:", fila); // Verificar que 'fila' contiene todos los datos
    
        switch (contacto) {
            case 'empleados':
                console.log('Editando empleado:', fila.idEmpleado);
                editarEmpleado(fila); // Pasar el objeto 'fila' completo
                break;
            case 'proveedores':
                console.log('Editando proveedor:', fila.idContacto); // Usar el ID o nombre correspondiente
                editarProveedor(fila);
                break;
            case 'clientes':
                console.log('Editando cliente:', fila.idContacto); // Usar el ID o nombre correspondiente
                editarCliente(fila);
                break;
            default:
                console.error('Tipo de contacto desconocido:', contacto);
                break;
        }
    }
        
    // Función para editar empleado
    function editarEmpleado(fila) {
        console.log('Editando empleado con ID:', fila.Id);
    
        // Llenar el formulario con los datos del empleado seleccionado
        document.getElementById('eidEmpleado').value = fila['Id'];
        document.getElementById('enombreEmpleado').value = fila['Nombre'];
        document.getElementById('eapellidosEmpleado').value = fila['Apellidos'];
        document.getElementById('esalario').value = fila['Salario'];
        document.getElementById('epuesto').value = fila['Puesto'];
        document.getElementById('edepartamento').value = fila['Departamento'];
        document.getElementById('eemail').value = fila['Email'];
        document.getElementById('etelefonoEmpleado').value = fila['Telefono'];
        document.getElementById('efechaContratacion').value = fila['Fecha de Contratación'];
        document.getElementById('ehorasSemana').value = fila['Horas por Semana'];
        document.getElementById('enombreUsuario').value = fila['Usuario'];
        
    
        // Mostrar el formulario de edición
        document.getElementById('edicionEmpleado').style.display = 'block';
    
        // Asegurar que no se duplique el evento al hacer clic en el botón de guardar
        btnSave.addEventListener('click', () => guardarCambiosEmpleado());
    }
    
    function guardarCambiosEmpleado() {
        const idEmpleado = document.getElementById('eidEmpleado').value;
        const nombreEmpleado = document.getElementById('enombreEmpleado').value;
        const apellidosEmpleado = document.getElementById('eapellidosEmpleado').value;
        const salario = document.getElementById('esalario').value;
        const puesto = document.getElementById('epuesto').value;
        const departamento = document.getElementById('edepartamento').value;
        const email = document.getElementById('eemail').value;
        const telefonoEmpleado = document.getElementById('etelefonoEmpleado').value;
        const fechaContratacion = document.getElementById('efechaContratacion').value;
        const horasSemana = document.getElementById('ehorasSemana').value;
        const nombreUsuario = document.getElementById('enombreUsuario').value;
        const contraseñaUsuario = document.getElementById('econtraseñaUsuario').value;
    
        fetch('../Controllers/ContactosController.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: new URLSearchParams({
                action: 'updateEmpleado',
                idEmpleado: idEmpleado,
                nombre: nombreEmpleado,
                apellidos: apellidosEmpleado,
                salario: salario,
                puesto: puesto,
                departamento: departamento,
                email: email,
                telefono: telefonoEmpleado,
                fechaContratacion: fechaContratacion,
                horasSemana: horasSemana,
                nombreUsuario: nombreUsuario,
                contraseñaUsuario: contraseñaUsuario,
            }),
        })
        .then(response => response.json())
        .then(data => {
            console.log('Respuesta del servidor:', data);
        
            if (data.status === "exito") {
                alert('Empleado actualizado con éxito');
        
                // Ocultar el formulario de edición
                document.getElementById('edicionEmpleado').style.display = 'none';
        
                // Recargar la tabla de empleados
                cargarDatos(); 
            } else {
                alert('Error al actualizar el empleado: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error al enviar los datos:', error);
        });
    }
    
    function editarCliente(fila) {
        console.log('Editando cliente con ID:', fila.Id);
    
        // Llenar el formulario con los datos del cliente seleccionado
        document.getElementById('eidCliente').value = fila['Id'];
        document.getElementById('enombreCliente').value = fila['Nombre'];
        document.getElementById('eapellidosCliente').value = fila['Apellidos'];
        document.getElementById('ecorreoElectronico').value = fila['Email'];
        document.getElementById('etelefonoCliente').value = fila['Teléfono'];
        document.getElementById('edireccion').value = fila['Dirección'];
        document.getElementById('eanhoNacimiento').value = fila['Año de Nacimiento'];
    
        // Mostrar el formulario de edición
        document.getElementById('edicionCliente').style.display = 'block';
    
        // Asegurar que no se duplique el evento al hacer clic en el botón de guardar
        btnSave.addEventListener('click', () => guardarCambiosCliente());
    }
    
    function guardarCambiosCliente() {
        const idCliente = document.getElementById('eidCliente').value;
        const nombreCliente = document.getElementById('enombreCliente').value;
        const apellidosCliente = document.getElementById('eapellidosCliente').value;
        const correoElectronico = document.getElementById('ecorreoElectronico').value;
        const telefonoCliente = document.getElementById('etelefonoCliente').value;
        const direccion = document.getElementById('edireccion').value;
        const anhoNacimiento = document.getElementById('eanhoNacimiento').value;
    
        fetch('../Controllers/ContactosController.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: new URLSearchParams({
                action: 'updateCliente',
                idCliente: idCliente,
                nombre: nombreCliente,
                apellidos: apellidosCliente,
                correoElectronico: correoElectronico,
                telefono: telefonoCliente,
                direccion: direccion,
                anhoNacimiento: anhoNacimiento,
            }),
        })
        .then(response => response.json())
        .then(data => {
            console.log('Respuesta del servidor:', data);
    
            if (data.status === "exito") {
                alert('Cliente actualizado con éxito');
    
                // Ocultar el formulario de edición
                document.getElementById('edicionCliente').style.display = 'none';
    
                // Recargar la tabla de clientes (o actualizar la vista de alguna manera)
                cargarDatosClientes();
            } else {
                alert('Error al actualizar el cliente: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error al enviar los datos:', error);
        });
    }
    
    
    // Función para editar proveedor
    function editarProveedor(fila) {
        console.log('Editando proveedor con ID:', fila.Id);
    
        // Llenar el formulario con los datos del proveedor seleccionado
        document.getElementById('eidProveedor').value = fila['Id'];
        document.getElementById('enombreProveedor').value = fila['Nombre'];
        document.getElementById('edireccionProveedor').value = fila['Dirección'];
        document.getElementById('ecorreoElectronico').value = fila['Email'];
        document.getElementById('etelefonoProveedor').value = fila['Teléfono'];
    
        // Mostrar el formulario de edición
        document.getElementById('edicionProveedor').style.display = 'block';
    
        // Asegurar que no se duplique el evento al hacer clic en el botón de guardar
        document.getElementById('btnEditarProveedor').addEventListener('click', () => guardarCambiosProveedor());
    }
    
    function guardarCambiosProveedor() {
        const idProveedor = document.getElementById('eidProveedor').value;
        const nombreProveedor = document.getElementById('enombreProveedor').value;
        const direccionProveedor = document.getElementById('edireccionProveedor').value;
        const correoElectronico = document.getElementById('ecorreoElectronico').value;
        const telefonoProveedor = document.getElementById('etelefonoProveedor').value;
    
        fetch('../Controllers/ContactosController.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: new URLSearchParams({
                action: 'updateProveedor',
                eidProveedor: idProveedor,
                enombreProveedor: nombreProveedor,
                edireccionProveedor: direccionProveedor,
                ecorreoElectronico: correoElectronico,
                etelefonoProveedor: telefonoProveedor
            }),
        })
        .then(response => response.json())
        .then(data => {
            console.log('Respuesta del servidor:', data);
    
            if (data.status === "exito") {
                alert('Proveedor actualizado con éxito');
    
                // Ocultar el formulario de edición
                document.getElementById('edicionProveedor').style.display = 'none';
    
                // Recargar la tabla de proveedores (o actualizar la vista de alguna manera)
                cargarDatosProveedores();
            } else {
                alert('Error al actualizar el proveedor: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error al enviar los datos:', error);
        });
    }
    
    
    
    
    
    //Funciones para borrar empleados, clientes y proveedores
    function borrarContacto(idContacto, tabla) {
        // Obtener el div de mensajes
        const mensajeDiv = document.getElementById('mensaje');
        
        // Crear un objeto FormData con el id del contacto y la tabla
        const formData = new FormData();
        formData.append('id', idContacto);
        console.log('ID del contacto a borrar:', idContacto);
        formData.append('tabla', tabla);
        console.log('Tabla del contacto a borrar:', tabla);
        formData.append('action', 'delete');
    
        // Enviar los datos mediante AJAX
        fetch('Controllers/ContactosController.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.text())  // Obtener la respuesta como texto
        .then(text => {
            console.log('Respuesta del servidor:', text); // Imprimir la respuesta para verificar qué está devolviendo el servidor
            try {
                const data = JSON.parse(text); // Intentar convertir el texto a JSON
                console.log('Datos recibidos:', data); // Imprimir los datos recibidos para ver su estructura

                if (data.status === 'success') {
                    mensajeDiv.style.backgroundColor = '#4CAF50'; // Verde para éxito
                    mensajeDiv.textContent = 'Contacto eliminado con éxito.';
                    cargarDatos(tabla); // Recargar los datos según el tipo de contacto
                } else {
                    mensajeDiv.style.backgroundColor = '#f44336'; // Rojo para error
                    mensajeDiv.textContent = 'Error al eliminar el contacto.';
                }
                mensajeDiv.style.display = 'block'; // Mostrar el mensaje
            } catch (error) {
                console.error('Error al analizar la respuesta JSON:', error);
                mensajeDiv.style.backgroundColor = '#f44336';
                mensajeDiv.textContent = 'El contacto está relacionado con otra tabla.';
                mensajeDiv.style.display = 'block'; // Mostrar el mensaje
            }

            setTimeout(() => {
                mensajeDiv.style.display = 'none';
            }, 5000);
        })

        .catch(error => {
            console.error('Error al realizar la solicitud:', error);
            mensajeDiv.style.backgroundColor = '#f44336';
            mensajeDiv.textContent = 'Error al procesar la solicitud.';
            mensajeDiv.style.display = 'block'; // Mostrar el mensaje
    
            // Ocultar el mensaje después de 5 segundos
            setTimeout(() => {
                mensajeDiv.style.display = 'none';
            }, 5000);
        });
    }
    

});