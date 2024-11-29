<!--Inicio HTML -->
<div class="row">
    <div class="col-12">
        <div class="card shadow mb-4">
            <form method="get" action="">
                <input type="hidden" name="order" value="1"/>
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
                                <label for="codigo">Código:</label>
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
                        <div class="col-12 col-lg-3">
                            <div class="mb-3">
                                <label for="categoria">Categoría:</label>
                                <select name="categoria[]" id="categoria" class="form-control select2"
                                        data-placeholder="Categoria" multiple>
                                    <?php foreach ($categorias as $categoria) { ?>
                                        <option value="<?php echo $categoria['id_categoria']; ?>" <?php echo (isset($input['categoria']) && in_array($categoria['id_categoria'], $input['categoria'])) ? 'selected' : ''; ?>>
                                            <?php echo ucfirst($categoria['nombre_categoria']); ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-12 col-lg-4">
                            <div class="mb-3">
                                <label for="proveedor">Proveedor:</label>
                                <select name="proveedor" id="proveedor" class="form-control"
                                        data-placeholder="Proveedor">
                                    <option value="<?php ?>">-</option>
                                    <?php foreach ($proveedores as $proveedor) { ?>
                                        <option value="<?php echo $proveedor['cif']; ?>" <?php echo (isset($input['proveedor']) && $proveedor['cif'] === $input['proveedor']) ? 'selected' : ''; ?>>
                                            <?php echo ucfirst($proveedor['nombre']); ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-12 col-lg-4">
                            <div class="mb-3">
                                <label for="stock">Stock:</label>
                                <div class="row">
                                    <div class="col-6">
                                        <input type="text" class="form-control" name="stock_min" id="stock_min"
                                               value="<?php echo $input['stock_min'] ?? ''; ?>"
                                               placeholder="Mí­nimo"/>
                                    </div>
                                    <div class="col-6">
                                        <input type="text" class="form-control" name="stock_max" id="stock_max"
                                               value="<?php echo $input['stock_max'] ?? ''; ?>"
                                               placeholder="Máximo"/>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-lg-4">
                            <div class="mb-3">
                                <label for="pvp">PVP:</label>
                                <div class="row">
                                    <div class="col-6">
                                        <input type="text" class="form-control" name="pvp_min" id="pvp_min"
                                               value="<?php echo $input['pvp_min'] ?? ''; ?>"
                                               placeholder="Mí­nimo"/>
                                    </div>
                                    <div class="col-6">
                                        <input type="text" class="form-control" name="pvp_max" id="pvp_max"
                                               value="<?php echo $input['pvp_max'] ?? ''; ?>"
                                               placeholder="Máximo"/>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="col-12 text-right">
                        <a href="/productos" value="" name="reiniciar" class="btn btn-danger">Reiniciar filtros</a>
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
                <!--<form action="./?sec=formulario" method="post">                   -->
                <table id="tabladatos" class="table table-striped datatable">
                    <thead>
                    <tr>
                        <th><a href="">Código</a></th>
                        <th><a href="">Nombre</a></th>
                        <th><a href="">Categoría</a></th>
                        <th><a href="">Proveedor</a></th>
                        <th><a href="">Stock</a></th>
                        <th><a href="">Coste</a></th>
                        <th><a href="">Margen</a></th>
                        <th><a href="">PVP</a></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($productos as $producto) { ?>
                        <tr class="<?php echo ($producto['stock'] == 0) ? 'table-danger' : ''; ?> <?php echo ($producto['stock'] < 10) ? 'table-warning' : ''; ?>">
                            <td><?php echo $producto['codigo']; ?></td>
                            <td><?php echo $producto['nombre']; ?></td>
                            <td><?php echo !empty($producto['nombre_categoria']) ? $producto['nombre_categoria'] : '-'; ?></td>
                            <td><?php echo $producto['nombre_proveedor']; ?></td>
                            <td><?php echo $producto['stock']; ?></td>
                            <td><?php echo number_format($producto['coste'], 2, ',', '.'); ?></td>
                            <td><?php echo number_format($producto['margen'], 2, ',', '.'); ?></td>
                            <td><?php echo str_replace([',', '.', '_'], ['_', ',', '.'], $producto['pvp']) ?></td>
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