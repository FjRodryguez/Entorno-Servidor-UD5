<!--Inicio HTML -->
<div class="row">
    <div class="col-12">
        <div class="card shadow mb-4">
            <form method="get" action="/proveedores">
                <input type="hidden" name="order" value="<?php echo $order ?>"/>
                <div
                        class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Filtros</h6>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                    <!--<form action="./?sec=formulario" method="post">                   -->
                    <div class="row">
                        <div class="col-12 col-lg-4">
                            <div class="mb-3">
                                <label for="cif">Cif:</label>
                                <input type="text" class="form-control" name="cif" id="cif"
                                       value="<?php echo $input['cif'] ?? ''; ?>"/>
                            </div>
                        </div>
                        <div class="col-12 col-lg-4">
                            <div class="mb-3">
                                <label for="codigo">Codigo:</label>
                                <input type="text" class="form-control" name="codigo" id="codigo"
                                       value="<?php echo $input['codigo'] ?? ''; ?>"/>
                            </div>
                        </div>
                        <div class="col-12 col-lg-4">
                            <div class="mb-3">
                                <label for="nombre">Nombre:</label>
                                <input type="text" class="form-control" name="nombre" id="nombre"
                                       value="<?php echo $input['nombre'] ?? ''; ?>"/>
                            </div>
                        </div>
                        <div class="col-12 col-lg-4">
                            <div class="mb-3">
                                <label for="pais">Pais:</label>
                                <input type="text" class="form-control" name="pais" id="pais"
                                       value="<?php echo $input['pais'] ?? ''; ?>"/>
                            </div>
                        </div>
                        <div class="col-12 col-lg-4">
                            <div class="mb-3">
                                <label for="email">Email:</label>
                                <input type="text" class="form-control" name="email" id="email"
                                       value="<?php $input['email'] ?? ''; ?>"/>
                            </div>
                        </div>
                        <div class="col-12 col-lg-4">
                            <div class="mb-3">
                                <label for="telefono">Telefono:</label>
                                <input type="text" class="form-control" name="telefono" id="telefono"
                                       value="<?php echo $input['telefono'] ?? ''; ?>"/>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="col-12 text-right">
                        <a href="/proveedores" value="" name="reiniciar" class="btn btn-danger">Reiniciar filtros</a>
                        <input type="submit" value="Aplicar filtros" name="enviar" class="btn btn-primary ml-2"/>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="col-12">
        <div class="card shadow mb-4">
            <div
                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Proveedores</h6>
            </div>
            <!-- Card Body -->
            <div class="card-body" id="card_table">
                <div id="button_container" class="mb-3"></div>
                <!--<form action="./?sec=formulario" method="post">                   -->
                <table id="tabladatos" class="table table-striped">
                    <thead>
                    <tr>
                        <th>
                            <a href="<?php echo $_ENV['host.folder'] . 'proveedores?' . $queryString . 'order=' . (($order == 1) ? '-' : ''); ?>1">Cif</a>
                            <?php if(abs($order) == 1){?> <i class="fas fa-sort-amount-<?php echo $order < 0 ? 'up' : 'down';?>-alt"></i><?php }?>
                        </th>
                        <th>
                            <a href="<?php echo $_ENV['host.folder'] . 'proveedores?' . $queryString . 'order=' . (($order == 2) ? '-' : '') ?>2">Codigo</a>
                            <?php if(abs($order) == 2){?> <i class="fas fa-sort-amount-<?php echo $order < 0 ? 'up' : 'down';?>-alt"></i><?php }?>
                        </th>
                        <th><a href="<?php echo $_ENV['host.folder'] . 'proveedores?' . $queryString . 'order=' . (($order == 3) ? '-' : '') ?>3">Nombre</a>
                            <?php if(abs($order) == 3){?> <i class="fas fa-sort-amount-<?php echo $order < 0 ? 'up' : 'down';?>-alt"></i><?php }?>
                        </th>
                        <th><a href="<?php echo $_ENV['host.folder'] . 'proveedores?' . $queryString . 'order=' . (($order == 4) ? '-' : '') ?>4">Direccion</a>
                            <?php if(abs($order) == 4){?> <i class="fas fa-sort-amount-<?php echo $order < 0 ? 'up' : 'down';?>-alt"></i><?php }?>
                        </th>
                        <th><a href="<?php echo $_ENV['host.folder'] . 'proveedores?' . $queryString . 'order=' . (($order == 5) ? '-' : '') ?>5">Website</a>
                            <?php if(abs($order) == 5){?> <i class="fas fa-sort-amount-<?php echo $order < 0 ? 'up' : 'down';?>-alt"></i><?php }?>
                        </th>
                        <th><a href="<?php echo $_ENV['host.folder'] . 'proveedores?' . $queryString . 'order=' . (($order == 6) ? '-' : '') ?>6">Pais</a>
                            <?php if(abs($order) == 6){?> <i class="fas fa-sort-amount-<?php echo $order < 0 ? 'up' : 'down';?>-alt"></i><?php }?>
                        </th>
                        <th><a href="<?php echo $_ENV['host.folder'] . 'proveedores?' . $queryString . 'order=' . (($order == 7) ? '-' : '') ?>7">Email</a>
                            <?php if(abs($order) == 7){?> <i class="fas fa-sort-amount-<?php echo $order < 0 ? 'up' : 'down';?>-alt"></i><?php }?>
                        </th>
                        <th><a href="<?php echo $_ENV['host.folder'] . 'proveedores?' . $queryString . 'order=' . (($order == 8) ? '-' : '') ?>8">Telefono</a>
                            <?php if(abs($order) == 8){?> <i class="fas fa-sort-amount-<?php echo $order < 0 ? 'up' : 'down';?>-alt"></i><?php }?>
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($proveedores as $proveedor) { ?>
                        <tr>
                            <td><?php echo $proveedor['cif']; ?></td>
                            <td><?php echo $proveedor['codigo']; ?></td>
                            <td><?php echo $proveedor['nombre']; ?></td>
                            <td><?php echo $proveedor['direccion']; ?></td>
                            <td><?php echo $proveedor['website']; ?></td>
                            <td><?php echo $proveedor['pais']; ?></td>
                            <td><?php echo $proveedor['email']; ?></td>
                            <td><?php echo !empty($proveedor['telefono']) ? $proveedor['telefono'] : '-'; ?></td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
            </div>
            <div class="card-footer">
                <nav aria-label="Navegacion por paginas">
                    <ul class="pagination justify-content-center">
                        <li class="page-item">
                            <a class="page-link" href="/proveedores?page=1&order=1" aria-label="First">
                                <span aria-hidden="true">&laquo;</span>
                                <span class="sr-only">First</span>
                            </a>
                        </li>
                        <li class="page-item">
                            <a class="page-link" href="/proveedores?page=2&order=1" aria-label="Previous">
                                <span aria-hidden="true">&lt;</span>
                                <span class="sr-only">Previous</span>
                            </a>
                        </li>

                        <li class="page-item active"><a class="page-link" href="#">3</a></li>
                        <li class="page-item">
                            <a class="page-link" href="/proveedores?page=4&order=1" aria-label="Next">
                                <span aria-hidden="true">&gt;</span>
                                <span class="sr-only">Next</span>
                            </a>
                        </li>
                        <li class="page-item">
                            <a class="page-link" href="/proveedores?page=8&order=1" aria-label="Last">
                                <span aria-hidden="true">&raquo;</span>
                                <span class="sr-only">Last</span>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</div>
<!--Fin HTML -->