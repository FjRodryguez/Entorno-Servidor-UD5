<!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <li class="nav-item">
            <a href="/" class="nav-link <?php echo isset($seccion) && $seccion === '/inicio' ? 'active' : ''; ?>">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Inicio
              </p>
            </a>
          </li> 
            <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item <?php echo (isset($seccion) && in_array($seccion, ['/demo-proveedores'])) ? 'menu-open' : '';?>">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Panel de control
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="/demo-proveedores" class="nav-link <?php echo isset($seccion) && $seccion === '/demo-proveedores' ? 'active' : ''; ?>">
                  <i class="fas fa-laptop-code nav-icon"></i>
                  <p>Demo Proveedores</p>
                </a>
              </li>              
            </ul>
          </li>

            <li class="nav-item <?php echo (isset($seccion) && in_array($seccion, ['/poblacion-pontevedra', '/poblacion-grupos-edad', '/poblacion-pontevedra-2020'])) ? 'menu-open' : '';?>">
                <a href="#" class="nav-link">
                    <i class="nav-icon fas fa-tachometer-alt"></i>
                    <p>
                        CSV
                        <i class="right fas fa-angle-left"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="/poblacion-pontevedra" class="nav-link <?php echo isset($seccion) && $seccion === '/poblacion-pontevedra' ? 'active' : ''; ?>">
                            <i class="fas fa-laptop-code nav-icon"></i>
                            <p>Población Pontevedra</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="/poblacion-grupos-edad" class="nav-link <?php echo isset($seccion) && $seccion === '/poblacion-grupos-edad' ? 'active' : ''; ?>">
                            <i class="fas fa-laptop-code nav-icon"></i>
                            <p>Población grupos de edad</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="/poblacion-pontevedra-2020" class="nav-link <?php echo isset($seccion) && $seccion === '/poblacion-pontevedra-2020' ? 'active' : ''; ?>">
                            <i class="fas fa-laptop-code nav-icon"></i>
                            <p>Población Pontevedra 2020 totales</p>
                        </a>
                    </li>
                </ul>
            </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->