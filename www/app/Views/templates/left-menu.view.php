<!-- Sidebar Menu -->
<nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <li class="nav-item">
            <a href="/"
               class="nav-link <?php echo $_SERVER['REQUEST_URI'] === $_ENV['host.folder'] ? 'active' : ''; ?>">
                <i class="nav-icon fas fa-th"></i>
                <p>
                    Inicio
                </p>
            </a>
        </li>
        <li class="nav-item">
            <a href="/preferencias"
               class="nav-link <?php echo $_SERVER['REQUEST_URI'] === $_ENV['host.folder'] . 'preferencias' ? 'active' : ''; ?>">
                <i class="nav-icon fas fa-book"></i>
                <p>
                    Preferencias
                </p>
            </a>
        </li>
        <!-- Add icons to the links using the .nav-icon class
           with font-awesome or any other icon font library -->
        <?php if(isset($_SESSION['permisos']['demo-proveedores'])){?>
        <li class="nav-item <?php echo (in_array($_SERVER['REQUEST_URI'], [$_ENV['host.folder'] . 'demo-proveedores'])) ? 'menu-open' : ''; ?>">
            <a href="#" class="nav-link">
                <i class="nav-icon fas fa-tachometer-alt"></i>
                <p>
                    Panel de control
                    <i class="right fas fa-angle-left"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="/demo-proveedores"
                       class="nav-link <?php echo $_SERVER['REQUEST_URI'] === $_ENV['host.folder'] . 'demo-proveedores' ? 'active' : ''; ?>">
                        <i class="fas fa-laptop-code nav-icon"></i>
                        <p>Demo Proveedores</p>
                    </a>
                </li>
            </ul>
        </li>
        <?php }?>
        <li class="nav-item <?php echo (in_array($_SERVER['REQUEST_URI'], [$_ENV['host.folder'] . 'poblacion-pontevedra', $_ENV['host.folder'] . 'poblacion-grupos-edad', $_ENV['host.folder'] . 'poblacion-pontevedra-2020'], $_ENV['host.folder'] . 'formulario-poblacion-pontevedra')) ? 'menu-open' : ''; ?>">
            <a href="#" class="nav-link">
                <i class="nav-icon fas fa-file-excel"></i>
                <p>
                    CSV
                    <i class="right fas fa-angle-left"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="<?php echo $_ENV['host.folder']; ?>poblacion-pontevedra"
                       class="nav-link <?php echo $_SERVER['REQUEST_URI'] === $_ENV['host.folder'] . 'poblacion-pontevedra' ? 'active' : ''; ?>">
                        <i class="fas fa-laptop-code nav-icon"></i>
                        <p>Población Pontevedra</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?php echo $_ENV['host.folder']; ?>poblacion-grupos-edad"
                       class="nav-link <?php echo $_SERVER['REQUEST_URI'] === $_ENV['host.folder'] . 'poblacion-grupos-edad' ? 'active' : ''; ?>">
                        <i class="fas fa-laptop-code nav-icon"></i>
                        <p>Población grupos de edad</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?php echo $_ENV['host.folder']; ?>poblacion-pontevedra-2020"
                       class="nav-link <?php echo $_SERVER['REQUEST_URI'] === $_ENV['host.folder'] . 'poblacion-pontevedra-2020' ? 'active' : ''; ?>">
                        <i class="fas fa-laptop-code nav-icon"></i>
                        <p>Población Pontevedra 2020 totales</p>
                    </a>
                </li>
            </ul>
        <li class="nav-item">
            <a href="/usuarios-filtro"
               class="nav-link <?php echo $_SERVER['REQUEST_URI'] === $_ENV['host.folder'] . 'usuarios-filtro' ? 'active' : ''; ?>">
                <i class="nav-icon fas fa-user"></i>
                <p>
                    Usuarios
                </p>
            </a>
        </li>
        <?php if (isset($_SESSION['permisos']['productos'])) { ?>
            <li class="nav-item">
                <a href="/productos"
                   class="nav-link <?php echo $_SERVER['REQUEST_URI'] === $_ENV['host.folder'] . 'productos' ? 'active' : ''; ?>">
                    <i class="nav-icon fas fa-calendar"></i>
                    <p>
                        Productos
                    </p>
                </a>
            </li>
        <?php } ?>
        <?php if (isset($_SESSION['permisos']['categorias'])) { ?>
            <li class="nav-item">
                <a href="/categorias"
                   class="nav-link <?php echo $_SERVER['REQUEST_URI'] === $_ENV['host.folder'] . 'categorias' ? 'active' : ''; ?>">
                    <i class="nav-icon fas fa-bahai"></i>
                    <p>
                        Categorias
                    </p>
                </a>
            </li>
        <?php } ?>
        <?php if (isset($_SESSION['permisos']['proovedores'])) { ?>
            <li class="nav-item">
                <a href="/proveedores"
                   class="nav-link <?php echo $_SERVER['REQUEST_URI'] === $_ENV['host.folder'] . 'proveedores' ? 'active' : ''; ?>">
                    <i class="nav-icon fas fa-shopping-cart"></i>
                    <p>
                        Proveedores
                    </p>
                </a>
            </li>
        <?php } ?>
        <?php if (isset($_SESSION['permisos']['usuarios-sistema'])) { ?>
            <li class="nav-item">
                <a href="/usuarios-sistema"
                   class="nav-link <?php echo $_SERVER['REQUEST_URI'] === $_ENV['host.folder'] . 'usuarios-sistema' ? 'active' : ''; ?>">
                    <i class="nav-icon fas fa-user-circle"></i>
                    <p>
                        Usuarios del sistema
                    </p>
                </a>
            </li>
        <?php } ?>
    </ul>
</nav>
<!-- /.sidebar-menu -->