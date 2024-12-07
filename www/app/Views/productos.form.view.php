<?php

declare(strict_types=1);

?>
<div class="card shadow mb-4">
    <form method="post" action="">
        <div
                class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary"><?php echo $titulo; ?></h6>
        </div>
        <!-- Card Body -->
        <div class="card-body">
            <div class="row">
                <div class="col-12 col-sm-6">
                    <div class="form-group">
                        <label for="codigo">Codigo<span class="text-danger">*</span>:</label>
                        <input type="text" class="form-control"
                               name="codigo" id="codigo"
                               value="<?php
                               echo $input['codigo'] ?? ''; ?>"
                               maxlength="50"
                               placeholder="codigo"/>
                        <p class="text-danger small">
                            <?php
                            echo $errors['codigo'] ?? '';
                            ?>
                        </p>
                    </div>
                </div>
                <div class="col-12 col-sm-6">
                    <div class="form-group">
                        <label for="nombre">Nombre<span class="text-danger">*</span>:</label>
                        <input type="text" class="form-control"
                               name="nombre" id="nombre"
                               value="<?php
                               echo $input['nombre'] ?? ''; ?>"
                               placeholder="nombre"/>
                        <p class="text-danger small">
                            <?php
                            echo $errors['nombre'] ?? '';
                            ?>
                        </p>
                    </div>
                </div>
                <div class="col-12 col-sm-12">
                    <div class="form-group">
                        <label for="descipcion">Descripción<span class="text-danger">*</span>:</label>
                        <textarea class="form-control"
                                  name="descripcion" id="descripcion"
                                  placeholder="descripción"><?php echo $input['descripcion'] ?? '';?></textarea>
                        <p class="text-danger small">
                            <?php
                            echo $errors['descripcion'] ?? '';
                            ?>
                        </p>
                    </div>
                </div>
                <div class="col-12 col-sm-6">
                    <div class="form-group">
                        <label for="salarioBruto">Proveedor:</label>
                        <select class="form-control" id="proveedor" name="proveedor">
                            <option value="">-</option>
                            <?php foreach ($proveedores as $proveedor) { ?>
                                <option value="<?php echo $proveedor['cif']; ?>" <?php echo (isset($input['proveedor']) && $input['proveedor'] === $proveedor['cif']) ? 'selected' : '' ?>>
                                    <?php echo ucfirst($proveedor['nombre']); ?>
                                </option>
                            <?php } ?>
                        </select>
                        <p class="text-danger small">
                            <?php
                            echo $errors['proveedor'] ?? '';
                            ?>
                        </p>
                    </div>
                </div>
                <div class="col-12 col-sm-6">
                    <div class="form-group">
                        <label for="coste">Coste<span class="text-danger">*</span>:</label>
                        <input type="text" class="form-control"
                               name="coste" id="coste"
                               value="<?php
                               echo $input['coste'] ?? ''; ?>"
                               maxlength=""
                               placeholder="coste"
                        />
                        <p class="text-danger small">
                            <?php
                            echo $errors['coste'] ?? '';
                            ?>
                        </p>
                    </div>
                </div>
                <div class="col-12 col-lg-6">
                    <div class="form-group">
                        <label for="margen">Margen:</label>
                        <input type="text" class="form-control" name="margen" id="margen" placeholder="margen"
                               value="<?php echo $input['margen'] ?? '' ?>"/>
                        <p class="text-danger small"><?php echo $errors['margen'] ?? ''; ?></p>
                    </div>
                </div>
                <div class="col-12 col-lg-6">
                    <div class="form-group">
                        <label for="stock">Stock:</label>
                        <input type="text" class="form-control" name="stock" id="stock" placeholder="stock"
                               value="<?php echo $input['stock'] ?? '' ?>"/>
                        <p class="text-danger small"><?php echo $errors['stock'] ?? ''; ?></p>
                    </div>
                </div>
                <div class="col-12 col-lg-6">
                    <div class="form-group">
                        <label for="iva">Iva:</label>
                        <input type="text" class="form-control" name="iva" id="iva" placeholder="iva"
                               value="<?php echo $input['iva'] ?? '' ?>"/>
                        <p class="text-danger small"><?php echo $errors['iva'] ?? ''; ?></p>
                    </div>
                </div>
                <div class="col-12 col-lg-6">
                    <div class="form-group">
                        <label for="id_categoria">Categoria:</label>
                        <select name="id_categoria" id="id_categoria" class="form-control">
                            <option value="">-</option>
                            <?php foreach ($categorias as $categoria) {?>
                            <option value="<?php echo $categoria['id_categoria'];?>" <?php echo (isset($input['id_categoria']) && $input['id_categoria'] === $categoria['id_categoria']) ? 'selected' : '' ;?>>
                                <?php echo ucfirst($categoria['nombre_categoria'])?>
                            </option>
                            <?php }?>
                        </select>
                        <p class="text-danger small"><?php echo $errors['id_categoria'] ?? ''; ?></p>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <div class="col-12 text-right">
                <a href="<?php echo $_ENV['host.folder'] . 'productos'; ?>" class="btn btn-danger">Cancelar</a>
                <input type="submit" value="Guardar cambios" class="btn btn-primary ml-2"/>
            </div>
        </div>
    </form>
</div>
