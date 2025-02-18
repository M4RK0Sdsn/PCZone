document.addEventListener("DOMContentLoaded", function () {
    cargarVentas();
});

function buscarVentas() {
    let input = document.getElementById("searchInputVentas").value.toLowerCase();
    let filas = document.querySelectorAll("#ventasBody tr");

    filas.forEach(fila => {
        let textoFila = fila.textContent.toLowerCase();
        if (textoFila.includes(input)) {
            fila.style.display = ""; // Mostrar si coincide
        } else {
            fila.style.display = "none"; // Ocultar si no coincide
        }
    });
}

// Función para cargar ventas desde el servidor
function cargarVentas() {
    fetch("Controllers/VentaController.php?action=obtener")
        .then(response => response.json())
        .then(data => {
            let tbody = document.getElementById("ventasBody");
            tbody.innerHTML = ""; // Limpiar antes de agregar nuevas ventas

            data.ventas.forEach(venta => {
                let fila = document.createElement("tr");
                fila.innerHTML = `
                    <td>${venta.idVenta}</td>
                    <td>${venta.fechaVenta}</td>
                    <td>${venta.cantidad}</td>
                    <td>${venta.formaPago}</td>
                    <td>${venta.idCliente}</td>
                    <td>${venta.idEmpleado}</td>
                    <td>${venta.idAlmacen}</td>
                    <td>${venta.totalVenta}</td>
                `;
                tbody.appendChild(fila);
            });
        })
        .catch(error => console.error("Error al cargar ventas:", error));
}