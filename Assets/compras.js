document.addEventListener('DOMContentLoaded', () => {
    // Función para abrir el formulario de compras
    function abrirFormularioCompra() {
        const formPopup = document.getElementById('formPopupCompra');
        formPopup.style.display = 'block';

        // Cargar los datos de empleados y productos en los selects
        cargarEmpleados();
        cargarProductos();
    }

    // Función para cargar las compras desde el servidor
    function cargarCompras() {
        fetch('controllers/ComprasController.php') // Asegúrate de que la ruta es correcta
            .then(response => response.json())
            .then(data => {
                console.log(data); // Ver los datos en la consola
                if (data.columnas && data.datos) {
                    crearTablaCompras(data.columnas, data.datos); // Crear la tabla con los datos de compras
                } else {
                    console.error('No se recibieron datos de compras');
                }
            })
            .catch(error => console.error('Error al obtener los datos de compras:', error));
    }

    // Función para crear la tabla con los datos de las compras
    function crearTablaCompras(columnas, datos) {
        const tablaHead = document.getElementById('comprasHeader');
        const tablaBody = document.getElementById('comprasTable').getElementsByTagName('tbody')[0];

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

            // Agregar los datos de la compra a las celdas de la fila
            columnas.forEach(columna => {
                const td = document.createElement('td');
                td.textContent = fila[columna];
                tr.appendChild(td);
            });

            // Crear la columna para el botón de borrar
            const tdAcciones = document.createElement('td');
            const btnBorrar = document.createElement('button');
            btnBorrar.classList.add('btnBorrar');
            btnBorrar.dataset.id = fila.ID;  // Usar el idCompra como identificador
            btnBorrar.innerHTML = `
                <svg class="delete-svgIcon" viewBox="0 0 448 512">
                    <path d="M135.2 17.7L128 32H32C14.3 32 0 46.3 0 64S14.3 96 32 96H416c17.7 0 32-14.3 32-32s-14.3-32-32-32H320l-7.2-14.3C307.4 6.8 296.3 0 284.2 0H163.8c-12.1 0-23.2 6.8-28.6 17.7zM416 128H32L53.2 467c1.6 25.3 22.6 45 47.9 45H346.9c25.3 0 46.3-19.7 47.9-45L416 128z"></path>
                </svg>
            `;
            // Añadir el eventListener para el botón de borrar
            btnBorrar.addEventListener('click', (event) => {
                event.stopPropagation(); // Prevenir que el clic en el botón también active el evento de clic de la fila
                borrarCompra(fila.ID);  // Llamar a la función de borrado con el ID de la compra
            });

            tdAcciones.appendChild(btnBorrar);
            tr.appendChild(tdAcciones);
            tablaBody.appendChild(tr);

            // Hacer la fila clicable, redirigiendo a detalles de la compra
            tr.addEventListener('click', () => {
                const compraId = fila.ID;  // Obtener el ID de la compra
                window.location.href = `detallesCompra.php?id=${compraId}`;  // Redirigir a detalles de la compra
            });
        });
    }

    // Botón para abrir el formulario
    const btnAbrirFormulario = document.getElementById('btnAbrirFormulario');
    btnAbrirFormulario.addEventListener('click', abrirFormularioCompra);

    // Cargar automáticamente la tabla de compras al cargar la página
    if (window.location.pathname.includes('compras.php')) {
        cargarCompras(); // Solo carga los datos de compras si estamos en la página de compras
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
                
                if (data.datos && data.datos.length > 0) {
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

                            const proveedorInput = selectProducto.closest('.producto-linea').querySelector('.proveedor');
                            const precioInput = selectProducto.closest('.producto-linea').querySelector('.precio');

                            if (selectedProducto) {
                                proveedorInput.value = selectedProducto['Proveedor']; // Asumiendo que 'Proveedor' es un campo en tu base de datos
                                precioInput.value = selectedProducto['Precio de Compra']; // Asumimos que 'Precio de Compra' es el campo correcto
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
            <button type="button" class="remove-line">Borrar fila</button>
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

    // Enviar el formulario de compra
    document.querySelector('.save').addEventListener('click', function(event) {
        event.preventDefault(); // Evitar que el formulario se envíe de forma tradicional
    
        let empleado = document.getElementById('empleado').value;
        let formaPago = document.getElementById('formaPago').value;
        let numeroFactura = document.getElementById('numeroFactura').value;  // Asegúrate de obtener el valor de numeroFactura
        let productos = [];
        let precios = [];
        let cantidades = [];
        let subtotal = 0;
    
        // Recorrer las líneas de productos
        document.querySelectorAll('#productosContainer .producto-linea').forEach(function(linea) {
            let producto = linea.querySelector('.producto').value;
            let precio = linea.querySelector('.precio').value;
            let cantidad = linea.querySelector('.cantidad').value;
    
            if (producto && precio && cantidad) {
                productos.push(producto);
                precios.push(precio);
                cantidades.push(cantidad);
                subtotal += parseFloat(precio) * parseInt(cantidad);
            }
        });
    
        // Datos a enviar al controlador
        let data = {
            empleado: empleado,
            formaPago: formaPago,
            numeroFactura: numeroFactura,  // Incluye el número de factura
            productos: productos,
            precios: precios,
            cantidades: cantidades,
            totalCompra: subtotal // Enviar el total de la compra
        };
    
        // Enviar los datos al servidor mediante AJAX
        fetch('Controllers/ComprasController.php', {
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
                    document.getElementById('compraForm').reset();
                    window.location.reload();
                } else {
                    alert('Error al añadir la compra: ' + data.message);
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
    
    function borrarCompra(idCompra) {
        if (idCompra === undefined || idCompra === null) {
            console.error("ID de la compra no encontrado.");
            alert('No se pudo identificar la compra.');
            return;
        }
    
        console.log(`controllers/ComprasController.php?id=${idCompra}&accion=borrar`);
        
        // Confirmación de borrado
        if (confirm('¿Estás seguro de que quieres borrar esta compra?')) {
            // Asegúrate de enviar la URL correcta con el id y la acción "borrar"
            fetch(`controllers/ComprasController.php?id=${idCompra}&accion=borrar`, {
                method: 'GET',
            })
            .then(response => response.text()) // Cambié de response.json() a response.text() para ver la respuesta cruda
            .then(text => {
                console.log("Respuesta cruda del servidor:", text);  // Ver la respuesta cruda
                const data = JSON.parse(text);  // Intentamos parsear la respuesta a JSON
                console.log("Respuesta del servidor:", data);  // Ver la respuesta en formato JSON
                if (data.status === 'exito') {
                    alert('Compra eliminada correctamente');
                    cargarCompras();  // Recargar la lista de compras
                } else {
                    alert('Error al borrar la compra: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error al procesar la solicitud:', error);
                alert('Error al procesar la solicitud.');
            });
            
        }
    }
    

    // Cerrar el formulario de compra
    document.querySelector('.closeBtn').addEventListener('click', () => {
        document.getElementById('formPopupCompra').style.display = 'none';
    });
});
