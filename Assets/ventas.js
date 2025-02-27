document.addEventListener('DOMContentLoaded', () => {
    // Función para abrir el formulario de ventas
    function abrirFormularioVenta() {
        const formPopup = document.getElementById('formPopupVenta');
        formPopup.style.display = 'block';

        // Cargar los datos de clientes, empleados y productos en los selects
        cargarClientes();
        cargarEmpleados();
        cargarProductos();
    }

    // Función para cargar las ventas desde el servidor
    function cargarVentas() {
        fetch('controllers/VentasController.php') // Asegúrate de que la ruta es correcta
            .then(response => response.json())
            .then(data => {
                console.log(data); // Ver los datos en la consola
                if (data.columnas && data.datos) {
                    crearTablaVentas(data.columnas, data.datos); // Crear la tabla con los datos de ventas
                } else {
                    console.error('No se recibieron datos de ventas');
                }
            })
            .catch(error => console.error('Error al obtener los datos de ventas:', error));
    }

    // Función para crear la tabla con los datos de las ventas
    function crearTablaVentas(columnas, datos) {
        const tablaHead = document.getElementById('ventasHeader');
        const tablaBody = document.getElementById('ventasTable').getElementsByTagName('tbody')[0];

        tablaHead.innerHTML = '';
        tablaBody.innerHTML = '';

        // Crear los encabezados de la tabla
        columnas.forEach(columna => {
            const th = document.createElement('th');
            th.textContent = columna;
            tablaHead.appendChild(th);
        });

        // Añadir columna para las acciones (botón de borrar)
        const thAcciones = document.createElement('th');
        thAcciones.textContent = 'Acciones';
        tablaHead.appendChild(thAcciones);

        // Iterar sobre los datos y agregarlos a la tabla
        datos.forEach(fila => {
            const tr = document.createElement('tr');
            tr.classList.add('fila-clicable');  // Añadir la clase 'fila-clicable' para poder hacer clic en la fila

            // Agregar los datos de la venta a las celdas de la fila
            columnas.forEach(columna => {
                const td = document.createElement('td');
                td.textContent = fila[columna];
                tr.appendChild(td);
            });

            // Crear la columna para el botón de borrar
            const tdAcciones = document.createElement('td');
            const btnBorrar = document.createElement('button');
            btnBorrar.classList.add('btnBorrar');
            btnBorrar.dataset.id = fila.ID;  // Usar el idVenta como identificador
            btnBorrar.innerHTML = `
                <svg class="delete-svgIcon" viewBox="0 0 448 512">
                    <path d="M135.2 17.7L128 32H32C14.3 32 0 46.3 0 64S14.3 96 32 96H416c17.7 0 32-14.3 32-32s-14.3-32-32-32H320l-7.2-14.3C307.4 6.8 296.3 0 284.2 0H163.8c-12.1 0-23.2 6.8-28.6 17.7zM416 128H32L53.2 467c1.6 25.3 22.6 45 47.9 45H346.9c25.3 0 46.3-19.7 47.9-45L416 128z"></path>
                </svg>
            `;
            // Añadir el eventListener para el botón de borrar
            btnBorrar.addEventListener('click', (event) => {
                event.stopPropagation(); // Prevenir que el clic en el botón también active el evento de clic de la fila
                borrarVenta(fila.ID);  // Llamar a la función de borrado con el ID de la venta
            });

            tdAcciones.appendChild(btnBorrar);
            tr.appendChild(tdAcciones);
            tablaBody.appendChild(tr);

            // Hacer la fila clicable, redirigiendo a detalles de la venta
            tr.addEventListener('click', () => {
                const ventaId = fila.ID;  // Obtener el ID de la venta
                window.location.href = `detallesVenta.php?id=${ventaId}`;  // Redirigir a detalles de la venta
            });
        });
    }

    // Botón para abrir el formulario
    const btnAbrirFormulario = document.getElementById('btnAbrirFormulario');
    btnAbrirFormulario.addEventListener('click', abrirFormularioVenta);

    // Cargar automáticamente la tabla de ventas al cargar la página
    if (window.location.pathname.includes('ventas.php')) {
        cargarVentas(); // Solo carga los datos de ventas si estamos en la página de ventas
    }

    // Cargar clientes desde el servidor
    function cargarClientes() {
        fetch('controllers/ContactosController.php?tabla=clientes') // Pasamos el parámetro tabla=clientes
            .then(response => response.json())
            .then(data => {
                console.log("Datos recibidos:", data); // Ver los datos en la consola
                const selectClientes = document.getElementById('cliente');
                
                // Limpiar las opciones previas
                selectClientes.innerHTML = '<option value="">Seleccione un cliente</option>';

                // Asegúrate de que estamos accediendo a `data.datos` que contiene el array de clientes
                if (data.datos && data.datos.length > 0) {
                    // Recorrer los datos y agregar las opciones al select
                    data.datos.forEach(cliente => {
                        const option = document.createElement('option');
                        option.value = cliente.Id; // Usamos `Id` como el valor del cliente
                        option.textContent = `${cliente.Nombre} ${cliente.Apellidos || ''}`; // Mostrar nombre y apellidos
                        selectClientes.appendChild(option);
                    });
                } else {
                    console.error('No se recibieron datos de clientes');
                }
            })
            .catch(error => console.error('Error al cargar los clientes:', error));
    }

    // Cargar empleados desde el servidor
    function cargarEmpleados() {
        fetch('controllers/ContactosController.php?tabla=empleados') // Pasamos el parámetro tabla=empleados
            .then(response => response.json())
            .then(data => {
                console.log("Datos de empleados recibidos:", data); // Ver los datos en la consola
                const selectEmpleados = document.getElementById('empleado');
                
                // Limpiar las opciones previas
                selectEmpleados.innerHTML = '<option value="">Seleccione un empleado</option>';

                // Asegúrate de que estamos accediendo a `data.datos` que contiene el array de empleados
                if (data.datos && data.datos.length > 0) {
                    // Recorrer los datos y agregar las opciones al select
                    data.datos.forEach(empleado => {
                        const option = document.createElement('option');
                        option.value = empleado.Id; // Usamos `Id` como el valor del empleado
                        option.textContent = `${empleado.Nombre} ${empleado.Apellidos || ''}`; // Mostrar nombre y apellidos
                        selectEmpleados.appendChild(option);
                    });
                } else {
                    console.error('No se recibieron datos de empleados');
                }
            })
            .catch(error => console.error('Error al cargar los empleados:', error));
    }

    // Cargar productos desde el servidor
    function cargarProductos() {
        fetch('controllers/ProductoController.php') // Asegúrate de que la ruta es correcta
            .then(response => response.json())
            .then(data => {
                console.log("Datos de productos recibidos:", data); // Ver los datos en la consola
        
                // Selecciona todos los select con la clase "producto"
                const selectsProductos = document.querySelectorAll('.producto');
                
                // Verificar si recibimos productos
                if (data.datos && data.datos.length > 0) {
                    // Recorrer cada select con clase "producto"
                    selectsProductos.forEach(selectProducto => {
                        // Limpiar las opciones previas
                        selectProducto.innerHTML = '<option value="">Seleccione un producto</option>';
                        
                        // Recorrer los productos y agregar las opciones al select
                        data.datos.forEach(producto => {
                            const option = document.createElement('option');
                            option.value = producto['ID Producto']; // Asignar el ID del producto como valor
                            option.textContent = `${producto['Nombre del Producto']} (${producto['Marca']} ${producto['Modelo']})`; // Mostrar nombre, marca y modelo
                            selectProducto.appendChild(option);
                        });
    
                        // Agregar un evento al seleccionar un producto
                        selectProducto.addEventListener('change', (event) => {
                            const selectedOption = event.target.options[event.target.selectedIndex];
                            const productoId = selectedOption.value;
                            const selectedProducto = data.datos.find(producto => producto['ID Producto'] == productoId);
    
                            // Rellenar los campos de proveedor y precio
                            const proveedorInput = selectProducto.closest('.producto-linea').querySelector('.proveedor');
                            const precioInput = selectProducto.closest('.producto-linea').querySelector('.precio');
    
                            if (selectedProducto) {
                                proveedorInput.value = selectedProducto['Proveedor']; // Asumiendo que 'Proveedor' es un campo en tu base de datos
                                precioInput.value = selectedProducto['Precio de Venta']; // Asumiendo que 'Precio de Venta' es el campo correcto
                            }
                        });
                    });
                } else {
                    console.error('No se recibieron datos de productos');
                }
            })
            .catch(error => console.error('Error al cargar los productos:', error));
    }

    // Agregar una nueva línea de productos
    document.getElementById('addLine').addEventListener('click', () => {
        const productosContainer = document.getElementById('productosContainer');
        const nuevaLinea = document.createElement('div');
        nuevaLinea.classList.add('producto-linea');

        nuevaLinea.innerHTML = ` 
            <label for="producto[]">Producto:</label>
            <select name="producto[]" class="producto" required>
                <option value="">Seleccione un producto</option>
            </select>

            <label for="proveedor[]">Proveedor:</label>
            <input type="text" name="proveedor[]" class="proveedor" readonly>

            <label for="precio[]">Precio:</label>
            <input type="text" name="precio[]" class="precio" readonly>

            <label for="cantidad[]">Cantidad:</label>
            <input type="number" name="cantidad[]" class="cantidad" min="1" required>

            <span class="subtotal">Subtotal: 0</span>
            <button type="button" class="remove-line">❌</button>
        `;

        productosContainer.appendChild(nuevaLinea);

        // Volver a cargar los productos y asociar el evento de cambio
        cargarProductos();
    });

    // Eliminar una línea de productos
    document.addEventListener('click', event => {
        if (event.target && event.target.classList.contains('remove-line')) {
            const lineaProducto = event.target.closest('.producto-linea');
            lineaProducto.remove();
            actualizarTotal(); // Recalcular el total tras eliminar una línea
        }
    });

    // Escuchar el cambio en la cantidad o precio de los productos
    document.addEventListener('input', event => {
        if (event.target && (event.target.classList.contains('cantidad') || event.target.classList.contains('precio'))) {
            // Obtener la línea de producto
            const lineaProducto = event.target.closest('.producto-linea');
            const cantidad = parseFloat(lineaProducto.querySelector('.cantidad').value) || 0;
            const precio = parseFloat(lineaProducto.querySelector('.precio').value) || 0;

            // Calcular el subtotal
            const subtotal = cantidad * precio;

            // Mostrar el subtotal en la línea correspondiente
            lineaProducto.querySelector('.subtotal').textContent = `Subtotal: ${subtotal.toFixed(2)}`;

            // Actualizar el total global
            actualizarTotal();
        }
    });

    // Función para calcular el total
    function actualizarTotal() {
        let total = 0;

        // Iterar sobre cada línea de producto
        document.querySelectorAll('.producto-linea').forEach(linea => {
            const subtotalText = linea.querySelector('.subtotal').textContent.replace('Subtotal: ', '').trim();
            const subtotal = parseFloat(subtotalText.replace(',', '.')) || 0;  // Asegúrate de eliminar cualquier coma o espacio

            total += subtotal;
        });

        // Mostrar el total en el span con id "total"
        document.getElementById('total').textContent = `Total: ${total.toFixed(2)}`;
    }

    // Enviar el formulario de venta
    document.querySelector('.save').addEventListener('click', function(event) {
        event.preventDefault(); // Evitar que el formulario se envíe de forma tradicional
    
        let cliente = document.getElementById('cliente').value;
        let empleado = document.getElementById('empleado').value;
        let formaPago = document.getElementById('formaPago').value;
        let productos = [];
        let proveedores = [];
        let precios = [];
        let cantidades = [];
        let subtotal = 0;

        // Recorrer las líneas de productos
        document.querySelectorAll('#productosContainer .producto-linea').forEach(function(linea) {
            let producto = linea.querySelector('.producto').value;
            let proveedor = linea.querySelector('.proveedor').value;
            let precio = linea.querySelector('.precio').value;
            let cantidad = linea.querySelector('.cantidad').value;

            if (producto && proveedor && precio && cantidad) {
                productos.push(producto);
                proveedores.push(proveedor);
                precios.push(precio);
                cantidades.push(cantidad);
                subtotal += parseFloat(precio) * parseInt(cantidad);
            }
        });

        // Datos a enviar al controlador
        let data = {
            cliente: cliente,
            empleado: empleado,
            formaPago: formaPago,
            productos: productos,
            proveedores: proveedores,
            precios: precios,
            cantidades: cantidades,
            totalVenta: subtotal // Enviar el total de la venta
        };

        // Enviar los datos al servidor mediante AJAX
        fetch('Controllers/VentasController.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(data)
        })
        .then(response => response.text())  // Cambiar a .text() para obtener el texto crudo
        .then(text => {
            console.log("Respuesta cruda del servidor:", text);  // Ver lo que está devolviendo el servidor
            try {
                const data = JSON.parse(text);  // Intentamos parsear la respuesta a JSON
                console.log("Respuesta del servidor:", data);  // Ver la respuesta en formato JSON
                if (data.status === 'exito') {
                    document.getElementById('ventaForm').reset();
                    window.location.reload();
                } else {
                    alert('Error al añadir la venta: ' + data.message);
                }
            } catch (error) {
                console.error("Error al parsear la respuesta del servidor:", error);
                alert("Error en la respuesta del servidor.");
            }
        })
        .catch(error => {
            console.error('Error al procesar la solicitud:', error);
            alert('Error al procesar la solicitud.');
        });
    });

    // Cerrar el formulario de venta
    document.querySelector('.closeBtn').addEventListener('click', () => {
        document.getElementById('formPopupVenta').style.display = 'none';
    });

    //Borrar venta
    function borrarVenta(idVenta) {
        if (idVenta === undefined || idVenta === null) {
            console.error("ID de la venta no encontrado.");
            alert('No se pudo identificar la venta.');
            return;
        }
        console.log(`controllers/VentasController.php?id=${idVenta}&accion=borrar`);
        // Confirmación de borrado
        if (confirm('¿Estás seguro de que quieres borrar esta venta?')) {
            // Asegúrate de enviar la URL correcta con el id y la acción "borrar"
            fetch(`controllers/VentasController.php?id=${idVenta}&accion=borrar`, {
                method: 'GET',  // Usamos el método GET para pasar los parámetros en la URL
            })
            .then(response => response.json())  // Asumimos que la respuesta será JSON
            .then(data => {
                if (data.status === 'exito') {
                    alert('Venta borrada con éxito.');
                    cargarVentas();  // Recargar la lista de ventas
                } else {
                    alert('Error al borrar la venta: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error al borrar la venta:', error);
                alert('Error al procesar la solicitud.');
            });
        }
    }

});
