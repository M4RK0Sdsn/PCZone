document.addEventListener('DOMContentLoaded', () => {
    const compraId = new URLSearchParams(window.location.search).get('id');

    if (!compraId) {
        alert('ID de compra no encontrado');
        return;
    }

    fetch('controllers/DetallesCompraController.php?id=' + compraId)
        .then(response => response.json())
        .then(data => {
            console.log("Detalles de la compra:", data);
            if (data.status === 'exito') {
                // Crear tabla de detalles de la compra
                crearTablaDetallesCompra(data.detalles);
                // Crear tabla de información de la compra
                crearTablaInfoCompra(data.infoCompra);
            } else {
                alert('No se encontraron detalles para esta compra');
            }
        })
        .catch(error => {
            console.error('Error al obtener los detalles de la compra:', error);
            alert('Error al obtener los detalles de la compra');
        });
});

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

function crearTablaDetallesCompra(detalles) {
    const tablaBody = document.getElementById('detallesCompraBody');
    
    tablaBody.innerHTML = '';  // Limpiar antes de insertar nuevos datos

    detalles.forEach(fila => {
        const tr = document.createElement('tr');
        
        

        const tdLineaCompra = document.createElement('td');
        tdLineaCompra.textContent = fila.lineaCompra;
        tr.appendChild(tdLineaCompra);

        const tdProducto = document.createElement('td');
        tdProducto.textContent = fila.nombreProducto;
        tr.appendChild(tdProducto);

        const tdCantidad = document.createElement('td');
        tdCantidad.textContent = fila.cantidad;
        tr.appendChild(tdCantidad);

        const tdPrecio = document.createElement('td');
        tdPrecio.textContent = fila.precioCompra;
        tr.appendChild(tdPrecio);

        const tdProveedor = document.createElement('td');
        tdProveedor.textContent = fila.proveedor;
        tr.appendChild(tdProveedor);

        tablaBody.appendChild(tr);  // Añadir la fila al cuerpo de la tabla
    });
}

function crearTablaInfoCompra(infoCompra) {
    const tablaBody = document.getElementById('infoCompraBody');
    
    tablaBody.innerHTML = '';  // Limpiar antes de insertar nuevos datos

    const tr = document.createElement('tr');
    
    // Añadir cada campo de infoCompra como columna de la tabla
    const tdIdCompra = document.createElement('td');
    tdIdCompra.textContent = infoCompra.idCompra;
    tr.appendChild(tdIdCompra);

    const tdFechaCompra = document.createElement('td');
    tdFechaCompra.textContent = infoCompra.fechaCompra;
    tr.appendChild(tdFechaCompra);

    const tdFormaPago = document.createElement('td');
    tdFormaPago.textContent = infoCompra.formaPago;
    tr.appendChild(tdFormaPago);

    const tdPrecioTotal = document.createElement('td');
    tdPrecioTotal.textContent = infoCompra.precioTotal;
    tr.appendChild(tdPrecioTotal);

    const tdEmpleado = document.createElement('td');
    tdEmpleado.textContent = infoCompra.empleado;
    tr.appendChild(tdEmpleado);

    const tdNumeroFactura = document.createElement('td');
    tdNumeroFactura.textContent = infoCompra.numeroFactura;
    tr.appendChild(tdNumeroFactura);

    tablaBody.appendChild(tr);  // Añadir la fila al cuerpo de la tabla
}