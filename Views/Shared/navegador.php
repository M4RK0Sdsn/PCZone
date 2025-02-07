<div class="sidebar">
    <div class="sidebar-header">
        <a href="main.php"><img src="./Source/logo.png" alt=""></img></a> 
    </div>
    <ul class="nav-links">
        <li><a href="main.php"><img src="./Source/SideBar/inicio.png" alt="" class="nav-ico"> INICIO</a></li>
        <li><a href="contactos.php"><img src="./Source/SideBar/contactos.png" alt="" class="nav-ico">CONTACTOS</a></li>
        <li><a href="productos.php"><img src="./Source/SideBar/productos.png" alt="" class="nav-ico">PRODUCTOS</a></li>
        <li><a href="ventas.php"><img src="./Source/SideBar/ventas.png" alt="" class="nav-ico">VENTAS</a></li>
        <li><a href="compras.php"><img src="./Source/SideBar/compras.png" alt="" class="nav-ico">COMPRAS</a></li>
        <li><a href="almacen.php"><img src="./Source/SideBar/almacen.png" alt="" class="nav-ico">ALMACÉN</a></li>
        <li><a href="inventario.php"><img src="./Source/SideBar/inventario.png" alt="" class="nav-ico">INVENTARIO</a></li>
        <li><a href="contabilidad.php"><img src="./Source/SideBar/contabilidad.png" alt="" class="nav-ico">CONTABILIDAD</a></li>
        <li><a href="nominas.php"><img src="./Source/SideBar/nomina.png" alt="" class="nav-ico">NÓMINAS</a></li>
        <li><a href="usuarios.php"><img src="./Source/SideBar/usuarios.png" alt="" class="nav-ico">USUARIOS</a></li>
        <li><a href="produccion.php"><img src="./Source/SideBar/produccion.png" alt="" class="nav-ico">PRODUCCION</a></li>
    </ul>
    <div class="sidebar-footer">
        <button id="ayuda">Ayuda y Soporte</button>
        <!-- Aquí cambiamos el nombre del botón según si el usuario está logueado -->
        <form action="controllers/logout.php" method="post">
            <button id="cerrarSesion" type="submit">
                <?php 
                    if (isset($_SESSION['usuario'])) {
                        echo 'Cerrar sesión';  // Si está logueado, mostrar "Cerrar sesión"
                    } else {
                        echo 'Usuario';  // Si no está logueado, mostrar "Usuario"
                    }
                ?>
            </button>
        </form>
    </div>
</div>
