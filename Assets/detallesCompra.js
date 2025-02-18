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
                // Ya no necesitamos 'columnas' porque las hemos definido en HTML
                crearTablaDetallesCompra(data.detalles);
            } else {
                alert('No se encontraron detalles para esta compra');
            }
        })
        .catch(error => {
            console.error('Error al obtener los detalles de la compra:', error);
            alert('Error al obtener los detalles de la compra');
        });
});

function crearTablaDetallesCompra(detalles) {
    const tablaBody = document.getElementById('detallesCompraBody');
    
    tablaBody.innerHTML = '';  // Limpiar antes de insertar nuevos datos

    detalles.forEach(fila => {
        const tr = document.createElement('tr');
        
        // Añadir cada campo de fila como columna de la tabla
        const tdIdCompra = document.createElement('td');
        tdIdCompra.textContent = fila.idCompra;
        tr.appendChild(tdIdCompra);

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
