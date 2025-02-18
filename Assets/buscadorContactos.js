document.addEventListener("DOMContentLoaded", function () {
    // Cargar automáticamente la tabla de empleados al cargar la página
    if (window.location.pathname.includes('contactos.php')) {
        cargarDatos('empleados'); 
    }

    // Agregar event listeners a los botones de radio
    document.querySelectorAll('input[name="radio"]').forEach(radio => {
        radio.addEventListener('change', function() {
            cargarDatos(this.value);
        });
    });

    // Agregar event listener al campo de búsqueda
    document.getElementById('searchInput').addEventListener('keyup', buscarContactos);
});

function buscarContactos() {
    let input = document.getElementById("searchInput").value.toLowerCase();
    let filas = document.querySelectorAll("#contactosBody tr");

    filas.forEach(fila => {
        let textoFila = fila.textContent.toLowerCase();
        if (textoFila.includes(input)) {
            fila.style.display = ""; // Mostrar si coincide
        } else {
            fila.style.display = "none"; // Ocultar si no coincide
        }
    });
}

// Función para cargar contactos desde el servidor
function cargarDatos(tabla) {
    fetch(`Controllers/ContactosController.php?tabla=${tabla}`)
        .then(response => response.json())
        .then(data => {
            let tbody = document.getElementById("contactosBody");
            tbody.innerHTML = ""; // Limpiar antes de agregar nuevos contactos

            data.datos.forEach(contacto => {
                let fila = document.createElement("tr");
                fila.innerHTML = data.columnas.map(columna => `<td>${contacto[columna]}</td>`).join('');
                tbody.appendChild(fila);
            });
        })
        .catch(error => console.error("Error al cargar contactos:", error));
}