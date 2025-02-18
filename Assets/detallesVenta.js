document.addEventListener('DOMContentLoaded', () => {
    const ventaId = new URLSearchParams(window.location.search).get('id');

    if (!ventaId) {
        alert('ID de venta no encontrado');
        return;
    }

    fetch('controllers/DetallesVentaController.php?id=' + ventaId)
        .then(response => response.json())
        .then(data => {
            console.log("Detalles de la venta:", data);
            if (data.status === 'exito') {
                // Crear tabla de detalles de la venta
                crearTablaDetallesVenta(data.detalles);
                // Crear tabla de información de la venta
                crearTablaInfoVenta(data.infoVenta);
            } else {
                alert('No se encontraron detalles para esta venta');
            }
        })
        .catch(error => {
            console.error('Error al obtener los detalles de la venta:', error);
            alert('Error al obtener los detalles de la venta');
        });
});

function crearTablaDetallesVenta(detalles) {
    const tablaBody = document.getElementById('detallesVentaBody');
    
    tablaBody.innerHTML = '';  // Limpiar antes de insertar nuevos datos

    detalles.forEach(fila => {
        const tr = document.createElement('tr');
        
       

        const tdLineaVenta = document.createElement('td');
        tdLineaVenta.textContent = fila.lineaVenta;
        tr.appendChild(tdLineaVenta);

        const tdProducto = document.createElement('td');
        tdProducto.textContent = fila.nombreProducto;
        tr.appendChild(tdProducto);

        const tdInicioGarantia = document.createElement('td');
        tdInicioGarantia.textContent = fila.inicioGarantia;
        tr.appendChild(tdInicioGarantia);

        const tdFinGarantia = document.createElement('td');
        tdFinGarantia.textContent = fila.finGarantia;
        tr.appendChild(tdFinGarantia);

        const tdCantidad = document.createElement('td');
        tdCantidad.textContent = fila.cantidad;
        tr.appendChild(tdCantidad);

        const tdPrecio = document.createElement('td');
        tdPrecio.textContent = fila.precio;
        tr.appendChild(tdPrecio);

        const tdProveedor = document.createElement('td');
        tdProveedor.textContent = fila.nombre;
        tr.appendChild(tdProveedor);

        tablaBody.appendChild(tr);  // Añadir la fila al cuerpo de la tabla
    });
}

function crearTablaInfoVenta(infoVenta) {
    const tablaBody = document.getElementById('infoVentaBody');
    
    tablaBody.innerHTML = '';  // Limpiar antes de insertar nuevos datos

    const tr = document.createElement('tr');
    
    // Añadir cada campo de infoVenta como columna de la tabla
    const tdIdVenta = document.createElement('td');
    tdIdVenta.textContent = infoVenta.idVenta;
    tr.appendChild(tdIdVenta);

    const tdFechaVenta = document.createElement('td');
    tdFechaVenta.textContent = infoVenta.fechaVenta;
    tr.appendChild(tdFechaVenta);

    const tdFormaPago = document.createElement('td');
    tdFormaPago.textContent = infoVenta.formaPago;
    tr.appendChild(tdFormaPago);

    const tdTotalVenta = document.createElement('td');
    tdTotalVenta.textContent = infoVenta.totalVenta;
    tr.appendChild(tdTotalVenta);

    const tdCliente = document.createElement('td');
    tdCliente.textContent = infoVenta.cliente;
    tr.appendChild(tdCliente);

    const tdEmpleado = document.createElement('td');
    tdEmpleado.textContent = infoVenta.empleado;
    tr.appendChild(tdEmpleado);

    tablaBody.appendChild(tr);  // Añadir la fila al cuerpo de la tabla
}