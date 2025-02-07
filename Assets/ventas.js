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

        // Limpiar la tabla antes de agregar nuevos datos
        tablaHead.innerHTML = '';
        tablaBody.innerHTML = '';

        // Crear los encabezados de la tabla de ventas
        columnas.forEach(columna => {
            const th = document.createElement('th');
            th.textContent = columna;
            tablaHead.appendChild(th);
        });

        // Iterar sobre los datos y agregarlos a la tabla
        datos.forEach(fila => {
            const tr = document.createElement('tr');
            columnas.forEach(columna => {
                const td = document.createElement('td');
                td.textContent = fila[columna];
                tr.appendChild(td);
            });
            tablaBody.appendChild(tr);
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
                                precioInput.value = selectedProducto['Precio de Venta'] + '€'; // Asumiendo que 'Precio' es un campo en tu base de datos
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
    document.getElementById('btnGuardarVenta').addEventListener('click', () => {
        const cliente = document.getElementById('cliente').value;
        const empleado = document.getElementById('empleado').value;
        const productos = [];
        document.querySelectorAll('.producto-linea').forEach(linea => {
            const producto = linea.querySelector('.producto').value;
            const cantidad = linea.querySelector('.cantidad').value;
            const precio = parseFloat(linea.querySelector('.precio').value);
            const subtotal = parseFloat(linea.querySelector('.subtotal').textContent.replace('Subtotal: ', ''));

            productos.push({ producto, cantidad, precio, subtotal });
        });

        const ventaData = {
            cliente,
            empleado,
            productos,
            total: parseFloat(document.getElementById('total').textContent.replace('Total: ', ''))
        };

        fetch('controllers/VentasController.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(ventaData)
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Venta guardada correctamente');
                location.reload(); // Recargar la página para ver los cambios
            } else {
                alert('Error al guardar la venta');
            }
        })
        .catch(error => console.error('Error al guardar la venta:', error));
    });

    // Cerrar el formulario de venta
    document.querySelector('.closeBtn').addEventListener('click', () => {
        document.getElementById('formPopupVenta').style.display = 'none';
    });
});
