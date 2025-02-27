document.addEventListener("DOMContentLoaded", function () {
    cargarCompras();
});

function buscarCompras() {
    let input = document.getElementById("searchInputCompras").value.toLowerCase();
    let filas = document.querySelectorAll("#comprasBody tr");

    filas.forEach(fila => {
        let textoFila = fila.textContent.toLowerCase();
        if (textoFila.includes(input)) {
            fila.style.display = ""; // Mostrar si coincide
        } else {
            fila.style.display = "none"; // Ocultar si no coincide
        }
    });

    // Asignar eventos a los botones de eliminar después de buscar
    asignarEventosEliminar();
}

// Función para cargar compras desde el servidor
function cargarCompras() {
    fetch("Controllers/ComprasController.php?accion=obtener")
        .then(response => response.json())
        .then(data => {
            let tbody = document.getElementById("comprasBody");
            tbody.innerHTML = ""; // Limpiar antes de agregar nuevas compras

            data.datos.forEach(compra => {
                let fila = document.createElement("tr");
                fila.innerHTML = `
                    <td>${compra.ID}</td>
                    <td>${compra['Fecha de Compra']}</td>
                    <td>${compra['Forma de Pago']}</td>
                    <td>${compra['Precio Total']}</td>
                    <td>${compra.Empleado}</td>
                    <td>${compra['Número de Factura']}</td>
                `;
                tbody.appendChild(fila);
            });

            // Asignar eventos a los botones de eliminar después de cargar
            asignarEventosEliminar();
        })
        .catch(error => console.error("Error al cargar compras:", error));
}

// Función para asignar eventos a los botones de eliminar
function asignarEventosEliminar() {
    let botonesEliminar = document.querySelectorAll(".btn-eliminar");
    botonesEliminar.forEach(boton => {
        boton.addEventListener("click", function () {
            let fila = this.closest("tr");
            fila.remove();
        });
    });
}