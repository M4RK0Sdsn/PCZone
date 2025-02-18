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
                // Ya no necesitamos 'columnas' porque las hemos definido en HTML
                crearTablaDetallesVenta(data.detalles);
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
        
        // Añadir cada campo de fila como columna de la tabla
        const tdIdVenta = document.createElement('td');
        tdIdVenta.textContent = fila.idVenta;
        tr.appendChild(tdIdVenta);

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
