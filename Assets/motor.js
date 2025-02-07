document.addEventListener("DOMContentLoaded", () => {

    

    /*---------------*/
    //Funcion para cargar compras
    function cargarCompras() {
        fetch('controllers/ComprasController.php') // Asegúrate de que la ruta es correcta
            .then(response => response.json())
            .then(data => {
                console.log(data); // Ver los datos en la consola
                if (data.columnas && data.datos) {
                    crearTablaCompras(data.columnas, data.datos); // Crear la tabla con los datos de ventas
                } else {
                    console.error('No se recibieron datos de compras');
                }
            })
            .catch(error => console.error('Error al obtener los datos de compras:', error));
    }

    // Función para crear la tabla con los datos de las ventas
    function crearTablaCompras(columnas, datos) {
        const tablaHead = document.getElementById('comprasHeader');
        const tablaBody = document.getElementById('comprasTable').getElementsByTagName('tbody')[0];

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

    // Cargar automáticamente la tabla de ventas al cargar la página
    if (window.location.pathname.includes('compras.php')) {
        cargarCompras(); // Solo carga los datos de ventas si estamos en la página de ventas
    }

    // Función para cargar almacenes
    function cargarAlmacen() {
        fetch('controllers/AlmacenController.php') // Asegúrate de que la ruta es correcta
            .then(response => response.json())
            .then(data => {
                console.log(data); // Ver los datos en la consola
                if (data.columnas && data.datos) {
                    crearTablaAlmacen(data.columnas, data.datos); // Crear la tabla con los datos de almacenes
                } else {
                    console.error('No se recibieron datos de almacenes');
                }
            })
            .catch(error => console.error('Error al obtener los datos de almacenes:', error));
    }

    // Función para crear la tabla con los datos de los almacenes
    function crearTablaAlmacen(columnas, datos) {
        const tablaHead = document.getElementById('almacenHeader');
        const tablaBody = document.getElementById('almacenTable').getElementsByTagName('tbody')[0];

        // Limpiar la tabla antes de agregar nuevos datos
        tablaHead.innerHTML = '';
        tablaBody.innerHTML = '';

        // Crear los encabezados de la tabla de almacenes
        columnas.forEach(columna => {
            const th = document.createElement('th');
            th.textContent = columna;
            tablaHead.appendChild(th);
        });

        // Añadir encabezados para botones de editar y borrar
        const thAcciones = document.createElement('th');
        thAcciones.textContent = 'Acciones';
        tablaHead.appendChild(thAcciones);

        // Iterar sobre los datos y agregarlos a la tabla
        datos.forEach(fila => {
            const tr = document.createElement('tr');

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
            btnEditar.dataset.id = fila.idAlmacen; // Asume que "idAlmacen" es el identificador único
            btnEditar.innerHTML = `
            <svg class="edit-svgIcon" viewBox="0 0 512 512">
                <path d="M410.3 231l11.3-11.3-33.9-33.9-62.1-62.1L291.7 89.8l-11.3 11.3-22.6 22.6L58.6 322.9c-10.4 10.4-18 23.3-22.2 37.4L1 480.7c-2.5 8.4-.2 17.5 6.1 23.7s15.3 8.5 23.7 6.1l120.3-35.4c14.1-4.2 27-11.8 37.4-22.2L387.7 253.7 410.3 231zM160 399.4l-9.1 22.7c-4 3.1-8.5 5.4-13.3 6.9L59.4 452l23-78.1c1.4-4.9 3.8-9.4 6.9-13.3l22.7-9.1v32c0 8.8 7.2 16 16 16h32zM362.7 18.7L348.3 33.2 325.7 55.8 314.3 67.1l33.9 33.9 62.1 62.1 33.9 33.9 11.3-11.3 22.6-22.6 14.5-14.5c25-25 25-65.5 0-90.5L453.3 18.7c-25-25-65.5-25-90.5 0zm-47.4 168l-144 144c-6.2 6.2-16.4 6.2-22.6 0s-6.2-16.4 0-22.6l144-144c6.2-6.2 16.4-6.2 22.6 0s6.2 16.4 0 22.6z"></path>
            </svg>
            `;
            btnEditar.addEventListener('click', () => editarAlmacen(fila));
            tdAcciones.appendChild(btnEditar);

            // Botón de borrar
            const btnBorrar = document.createElement('button');
            btnBorrar.classList.add('btnBorrar');
            btnBorrar.dataset.id = fila.idAlmacen;
            btnBorrar.innerHTML = `
            <svg class="delete-svgIcon" viewBox="0 0 448 512">
                <path d="M135.2 17.7L128 32H32C14.3 32 0 46.3 0 64S14.3 96 32 96H416c17.7 0 32-14.3 32-32s-14.3-32-32-32H320l-7.2-14.3C307.4 6.8 296.3 0 284.2 0H163.8c-12.1 0-23.2 6.8-28.6 17.7zM416 128H32L53.2 467c1.6 25.3 22.6 45 47.9 45H346.9c25.3 0 46.3-19.7 47.9-45L416 128z"></path>
            </svg>
            `;
            btnBorrar.addEventListener('click', () => borrarAlmacen(fila['ID Almacén']));
            tdAcciones.appendChild(btnBorrar);

            tr.appendChild(tdAcciones);
            tablaBody.appendChild(tr);
        });
    }

    // Añadir almacen
    function añadirAlmacen() {
        const form = document.querySelector('form'); // Seleccionamos el formulario
        const btnAñadir = document.getElementById('btnAñadirAlmacen'); // Seleccionamos el botón
    
        btnAñadir.addEventListener('click', function(event) {
            event.preventDefault(); // Evita que se recargue la página si el botón está dentro de un formulario
    
            const nombreAlmacen = document.getElementById('nombreAlmacen').value;
            const direccionAlmacen = document.getElementById('direccionAlmacen').value;
    
            // Crear un objeto FormData para enviar los datos
            const formData = new FormData();
            formData.append('nombreAlmacen', nombreAlmacen);
            formData.append('direccionAlmacen', direccionAlmacen);
    
            // Enviar los datos mediante AJAX
            fetch('Controllers/AlmacenController.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    const mensajeDiv = document.getElementById('mensaje'); // Asumiendo que este es el div de mensaje
                    const formPopup = document.getElementById('formPopup'); // Asumiendo que este es el formulario emergente
    
                    // Mostrar mensaje de éxito o error según la respuesta del backend
                    if (data.status === 'exito') {
                        mensajeDiv.style.backgroundColor = '#4CAF50'; // Color verde para éxito
                        mensajeDiv.textContent = 'Almacén añadido con éxito.';
                    } else {
                        mensajeDiv.style.backgroundColor = '#f44336'; // Color rojo para error
                        mensajeDiv.textContent = 'Error al añadir el almacén.';
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

    //Editar almacen
    function editarAlmacen(fila) {
        console.log(fila);
    
        // Llenar el formulario con los datos de la fila seleccionada
        document.getElementById('eidAlmacen').value = fila['ID Almacén'];
        document.getElementById('enombreAlmacen').value = fila['Nombre del Almacén'];
        document.getElementById('edireccionAlmacen').value = fila['Dirección del Almacén'];
    
        // Referencia al contenedor del formulario
        const formulario = document.getElementById('formEditarAlmacen');
        // Crear el botón de guardar
        btnSave = document.createElement('button');
        btnSave.textContent = 'Guardar Cambios';
        btnSave.type = 'button'; // Evita el envío automático del formulario
        btnSave.classList.add('save');
        btnSave.dataset.id = fila['ID Almacén']; // Asume que "ID Almacén" es el identificador único
    
        // Asignar el evento para guardar los cambios
        btnSave.addEventListener('click', () => guardarCambios());
    
        // Añadir el botón al formulario (al final)
        formulario.appendChild(btnSave);
    
        // Mostrar el formulario de edición
        document.getElementById('formularioEdicion').style.display = 'block';
    }
    //Guardar cambios alamacen
    function guardarCambios() {
    const idAlmacen = document.getElementById('eidAlmacen').value;
    const nombreAlmacen = document.getElementById('enombreAlmacen').value;
    const direccionAlmacen = document.getElementById('edireccionAlmacen').value;

    console.log('ID Almacén:', idAlmacen);
    console.log('Nombre Almacén:', nombreAlmacen);
    console.log('Dirección Almacén:', direccionAlmacen);

    fetch('controllers/AlmacenController.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: new URLSearchParams({
            action: 'update',
            idAlmacen: idAlmacen,
            nombreAlmacen: nombreAlmacen,
            direccionAlmacen: direccionAlmacen,
        }),
    })
        .then((response) => response.json())
        .then((data) => {
            if (data.status === 'exito') {
                alert('Almacén actualizado con éxito.');
                document.getElementById('formularioEdicion').style.display = 'none';
                cargarAlmacen(); // Actualiza la tabla
            } else {
                alert('Error al actualizar el almacén.');
            }
        })
        .catch((error) => {
            console.error('Error al actualizar el almacén:', error);
            alert('Ocurrió un error al intentar actualizar el almacén.');
        });
}

    //Borrar almacen
    function borrarAlmacen(idAlmacen) {
        if (confirm("¿Estás seguro de que deseas eliminar este almacén?")) {
            fetch('controllers/AlmacenController.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: new URLSearchParams({
                        action: 'delete',
                        idAlmacen: idAlmacen,
                    }),
                })
                .then((response) => response.json())
                .then((data) => {
                    if (data.status === 'exito') {
                        cargarAlmacen(); // Actualiza la tabla después de eliminar
                        const mensajeDiv = document.getElementById('mensaje');
                        mensajeDiv.textContent = 'Almacén eliminado con éxito.';
                    } else {
                        alert('Error al eliminar el almacén.');
                    }
                })
                .catch((error) => {
                    console.error('Error al eliminar el almacén:', error);
                    alert('Ocurrió un error al intentar eliminar el almacén.');
                });
        }
    }

    // Cargar automáticamente la tabla de almacenes al cargar la página
    if (window.location.pathname.includes('almacen.php')) {
        cargarAlmacen(); // Solo carga los datos de almacenes si estamos en la página de almacenes
    }

    // Función para cargar inventario
    function cargarInventario() {
        fetch('controllers/InventarioController.php') // Asegúrate de que la ruta es correcta
            .then(response => response.json())
            .then(data => {
                console.log(data); // Ver los datos en la consola
                if (data.columnas && data.datos) {
                    crearTablaInventario(data.columnas, data.datos); // Crear la tabla con los datos de inventario
                } else {
                    console.error('No se recibieron datos de inventario');
                }
            })
            .catch(error => console.error('Error al obtener los datos de inventario:', error));
    }

    // Función para crear la tabla con los datos del inventario
    function crearTablaInventario(columnas, datos) {
        const tablaHead = document.getElementById('inventarioHeader');
        const tablaBody = document.getElementById('inventarioTable').getElementsByTagName('tbody')[0];

        // Limpiar la tabla antes de agregar nuevos datos
        tablaHead.innerHTML = '';
        tablaBody.innerHTML = '';

        // Crear los encabezados de la tabla de inventario
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

    // Cargar automáticamente la tabla de inventario al cargar la página
    if (window.location.pathname.includes('inventario.php')) {
        cargarInventario(); // Solo carga los datos de inventario si estamos en la página de inventario
    }


    //Formulario popup para añadir
    const openFormBtn = document.getElementById("openFormBtn"); // Botón para abrir el formulario
    const formPopup = document.getElementById("formPopup"); // Contenedor del formulario emergente
    const closeBtn = document.querySelector(".closeBtn"); // Botón para cerrar el formulario emergente
    const mensajeDiv = document.getElementById("mensaje"); // Div donde se mostrarán los mensajes

    // Mostrar el formulario emergente
    openFormBtn.addEventListener("click", function() {
        formPopup.style.display = "block"; // Muestra el popup
    });

    // Cerrar el formulario emergente
    closeBtn.addEventListener("click", function() {
        formPopup.style.display = "none"; // Oculta el popup
    });

    // Cerrar el formulario si se hace clic fuera del formulario emergente
    window.addEventListener("click", function(event) {
        if (event.target === formPopup) {
            formPopup.style.display = "none"; // Oculta el popup si se hace clic fuera de él
        }
    });

    //Procutos

    // Función para crear la tabla con los datos de Productos
    function cargarProductos() {
        fetch('controllers/ProductoController.php') // Asegúrate de que la ruta es correcta
            .then(response => response.json())
            .then(data => {
                console.log(data); // Ver los datos en la consola
                if (data.columnas && data.datos) {
                    crearTablaProductos(data.columnas, data.datos); // Crear la tabla con los datos de productos
                } else {
                    console.error('No se recibieron datos de productos');
                }
            })
            .catch(error => console.error('Error al obtener los datos de productos:', error));
    }
    
    // Función para crear la tabla con los datos de los productos
    function crearTablaProductos(columnas, datos) {
        const tablaHead = document.getElementById('productoHeader');
        const tablaBody = document.getElementById('productoTable').getElementsByTagName('tbody')[0];
    
        // Limpiar la tabla antes de agregar nuevos datos
        tablaHead.innerHTML = '';
        tablaBody.innerHTML = '';
    
        // Crear los encabezados de la tabla de productos
        columnas.forEach(columna => {
            const th = document.createElement('th');
            th.textContent = columna;
            tablaHead.appendChild(th);
        });
    
        // Añadir encabezados para botones de editar y borrar
        const thAcciones = document.createElement('th');
        thAcciones.textContent = 'Acciones';
        tablaHead.appendChild(thAcciones);
    
        // Iterar sobre los datos y agregarlos a la tabla
        datos.forEach(fila => {
            const tr = document.createElement('tr');
    
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
            btnEditar.dataset.id = fila.idProducto;
            btnEditar.innerHTML = `
            <svg class="edit-svgIcon" viewBox="0 0 512 512">
                <path d="M410.3 231l11.3-11.3-33.9-33.9-62.1-62.1L291.7 89.8l-11.3 11.3-22.6 22.6L58.6 322.9c-10.4 10.4-18 23.3-22.2 37.4L1 480.7c-2.5 8.4-.2 17.5 6.1 23.7s15.3 8.5 23.7 6.1l120.3-35.4c14.1-4.2 27-11.8 37.4-22.2L387.7 253.7 410.3 231zM160 399.4l-9.1 22.7c-4 3.1-8.5 5.4-13.3 6.9L59.4 452l23-78.1c1.4-4.9 3.8-9.4 6.9-13.3l22.7-9.1v32c0 8.8 7.2 16 16 16h32zM362.7 18.7L348.3 33.2 325.7 55.8 314.3 67.1l33.9 33.9 62.1 62.1 33.9 33.9 11.3-11.3 22.6-22.6 14.5-14.5c25-25 25-65.5 0-90.5L453.3 18.7c-25-25-65.5-25-90.5 0zm-47.4 168l-144 144c-6.2 6.2-16.4 6.2-22.6 0s-6.2-16.4 0-22.6l144-144c6.2-6.2 16.4-6.2 22.6 0s6.2 16.4 0 22.6z"></path>
            </svg>
            `;
            btnEditar.addEventListener('click', () => editarProducto(fila));
            tdAcciones.appendChild(btnEditar);
    
            // Botón de borrar
            const btnBorrar = document.createElement('button');
            btnBorrar.classList.add('btnBorrar');
            btnBorrar.dataset.id = fila.idProducto;
            btnBorrar.innerHTML = `
            <svg class="delete-svgIcon" viewBox="0 0 448 512">
                <path d="M135.2 17.7L128 32H32C14.3 32 0 46.3 0 64S14.3 96 32 96H416c17.7 0 32-14.3 32-32s-14.3-32-32-32H320l-7.2-14.3C307.4 6.8 296.3 0 284.2 0H163.8c-12.1 0-23.2 6.8-28.6 17.7zM416 128H32L53.2 467c1.6 25.3 22.6 45 47.9 45H346.9c25.3 0 46.3-19.7 47.9-45L416 128z"></path>
            </svg>
            `;
            btnBorrar.addEventListener('click', () => borrarProducto(fila['idProducto']));
            tdAcciones.appendChild(btnBorrar);
    
            tr.appendChild(tdAcciones);
            tablaBody.appendChild(tr);
        });
    }
        
        // Función para añadir un nuevo producto
    function añadirProducto() {
        const form = document.querySelector('form'); // Seleccionamos el formulario
        const btnAñadir = document.getElementById('btnAñadirProducto'); // Seleccionamos el botón

        btnAñadir.addEventListener('click', function(event) {
            event.preventDefault(); // Evita que se recargue la página si el botón está dentro de un formulario

            const nombreProducto = document.getElementById('nombreProducto').value;
            const descripcionProducto = document.getElementById('descripcionProducto').value;
            const precioProducto = document.getElementById('precioProducto').value;
            const cantidadProducto = document.getElementById('cantidadProducto').value;

            // Crear un objeto FormData para enviar los datos
            const formData = new FormData();
            formData.append('nombreProducto', nombreProducto);
            formData.append('descripcionProducto', descripcionProducto);
            formData.append('precioProducto', precioProducto);
            formData.append('cantidadProducto', cantidadProducto);

            // Enviar los datos mediante AJAX
            fetch('Controllers/ProductoController.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    const mensajeDiv = document.getElementById('mensaje'); // Asumiendo que este es el div de mensaje
                    const formPopup = document.getElementById('formPopup'); // Asumiendo que este es el formulario emergente

                    // Mostrar mensaje de éxito o error según la respuesta del backend
                    if (data.status === 'exito') {
                        mensajeDiv.style.backgroundColor = '#4CAF50'; // Color verde para éxito
                        mensajeDiv.textContent = 'Producto añadido con éxito.';
                    } else {
                        mensajeDiv.style.backgroundColor = '#f44336'; // Color rojo para error
                        mensajeDiv.textContent = 'Error al añadir el producto.';
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

    // Función para editar un producto
    function editarProducto(fila) {
        console.log(fila);
    
        // Llenar el formulario con los datos de la fila seleccionada
        document.getElementById('eidProducto').value = fila['ID Producto'];
        document.getElementById('enombreProducto').value = fila['Nombre del Producto'];
        document.getElementById('emarcaProducto').value = fila['Marca'];
        document.getElementById('emodeloProducto').value = fila['Modelo'];
        document.getElementById('eprecioCompraProducto').value = fila['Precio de Compra'];
        document.getElementById('eprecioVentaProducto').value = fila['Precio de Venta'];
        document.getElementById('estockProducto').value = fila['Stock'];
    
        // Mostrar el formulario de edición
        document.getElementById('formularioEdicionProducto').style.display = 'block';
    }
    

    // Función para guardar los cambios de un producto
    function guardarCambiosProducto() {
    const idProducto = document.getElementById('eidProducto').value;
    const nombreProducto = document.getElementById('enombreProducto').value;
    const marca = document.getElementById('emarcaProducto').value;
    const modelo = document.getElementById('emodeloProducto').value;
    const precioCompra = document.getElementById('eprecioCompraProducto').value;
    const precioVenta = document.getElementById('eprecioVentaProducto').value;
    const stock = document.getElementById('estockProducto').value;

    console.log('ID Producto:', idProducto);
    console.log('Nombre Producto:', nombreProducto);
    console.log('Marca:', marca);
    console.log('Modelo:', modelo);
    console.log('Precio de Compra:', precioCompra);
    console.log('Precio de Venta:', precioVenta);
    console.log('Stock:', stock);

    fetch('controllers/ProductoController.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: new URLSearchParams({
            action: 'update',
            idProducto: idProducto,
            nombreProducto: nombreProducto,
            marca: marca,
            modelo: modelo,
            precioCompra: precioCompra,
            precioVenta: precioVenta,
            stock: stock,
        }),
    })
        .then((response) => response.json())
        .then((data) => {
            if (data.status === 'exito') {
                alert('Producto actualizado con éxito.');
                document.getElementById('formularioEdicionProducto').style.display = 'none';
                cargarProductos(); // Actualiza la tabla de productos
            } else {
                alert('Error al actualizar el producto.');
            }
        })
        .catch((error) => {
            console.error('Error al actualizar el producto:', error);
            alert('Ocurrió un error al intentar actualizar el producto.');
        });
}


    // Función para borrar un producto
    function borrarProducto(idProducto) {
        if (confirm("¿Estás seguro de que deseas eliminar este producto?")) {
            fetch('controllers/ProductoController.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: new URLSearchParams({
                    action: 'delete',
                    idProducto: idProducto,
                }),
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
                mensajeDiv.textContent = 'El producto está relacionado con otra tabla.';
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
    }
    

    // Cargar automáticamente la tabla de productos al cargar la página
    if (window.location.pathname.includes('productos.php')) {
        cargarProductos(); // Solo carga los datos de productos si estamos en la página de productos
    }

});