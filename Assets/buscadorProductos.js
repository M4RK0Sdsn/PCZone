document.addEventListener("DOMContentLoaded", function () {
});

function buscarProductos() {
    let input = document.getElementById("searchInput").value.toLowerCase();
    let filas = document.querySelectorAll("#productoBody tr");

    filas.forEach(fila => {
        let textoFila = fila.textContent.toLowerCase();
        if (textoFila.includes(input)) {
            fila.style.display = ""; // Mostrar si coincide
        } else {
            fila.style.display = "none"; // Ocultar si no coincide
        }
    });
}

// Función para cargar productos desde el servidor
function cargarProductos() {
    fetch("Controllers/ProductoController.php?action=obtener")
        .then(response => response.json())
        .then(data => {
            let tbody = document.getElementById("productoBody");
            tbody.innerHTML = ""; // Limpiar antes de agregar nuevos productos

            data.productos.forEach(producto => {
                let fila = document.createElement("tr");
                fila.innerHTML = `
                    <td>${producto.idProducto}</td>
                    <td>${producto.nombreProducto}</td>
                    <td>${producto.marca}</td>
                    <td>${producto.modelo}</td>
                    <td>${producto.precioCompra}</td>
                    <td>${producto.precioVenta}</td>
                    <td>${producto.stock}</td>
                    <td>${producto.idProveedor}</td>
                `;
                tbody.appendChild(fila);
            });
        })
        .catch(error => console.error("Error al cargar productos:", error));
}
